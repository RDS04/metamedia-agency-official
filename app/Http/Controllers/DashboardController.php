<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;
use App\Models\Agent;
use App\Models\AgentLuar;
use App\Models\Komisi;
use App\Models\Periode;
use App\Models\Pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private const SISTEM_KULIAH_OPTIONS = [
        'Reguler',
        'Mandiri',
        'Mandiri_Transfer',
        'RPL',
    ];

    private const CAMABA_STATUSES = [
        'Prospek' => 'bg-amber-50 text-amber-700',
        'Dihubungi' => 'bg-cyan-50 text-cyan-700',
        'Sudah Daftar' => 'bg-blue-50 text-blue-700',
        'Registrasi' => 'bg-violet-50 text-violet-700',
        'Registrasi Ulang' => 'bg-emerald-50 text-emerald-700',
        'Batal' => 'bg-red-50 text-red-700',
    ];

    public function informasi()
    {
        $testimoni = Pesan::tampil()
            ->latest()
            ->take(6)
            ->get();

        return view('informasi', compact('testimoni'));
    }

    public function dashboard(Request $request)
    {
        $agent = Auth::user();
        $camabaQuery = Agent::where('agent_id', $agent->id);

        $totalCamaba = (clone $camabaQuery)->count();
        $prospek = (clone $camabaQuery)->where('status', 'Prospek')->count();
        $sudahDaftar = (clone $camabaQuery)->where('status', 'Sudah Daftar')->count();
        $registrasiUlang = (clone $camabaQuery)->where('status', 'Registrasi Ulang')->count();
        $komisiAktif = $this->komisiAktif($agent->status ?? null);
        $bonusSummary = $komisiAktif?->hitungBonus($registrasiUlang) ?? $this->emptyBonusSummary();
        $bonusSummary['bonus_ukt'] = $komisiAktif?->memenuhiTargetBonusUkt($totalCamaba) ?? false;
        $bonusPerRegistrasi = $this->bonusPerRegistrasi($komisiAktif);
        $totalBonus = (int) ($bonusSummary['total_bonus'] ?? 0);
        $camabaTerbaru = (clone $camabaQuery)->latest()->take(5)->get();

        $chartStart = now()->startOfMonth()->subMonths(5);
        $camabaPerBulan = (clone $camabaQuery)
            ->where('created_at', '>=', $chartStart)
            ->get()
            ->groupBy(fn ($camaba) => $camaba->created_at->format('Y-m'));

        $chartLabels = [];
        $chartData = [];

        for ($i = 0; $i < 6; $i++) {
            $month = $chartStart->copy()->addMonths($i);
            $chartLabels[] = $month->format('M Y');
            $chartData[] = $camabaPerBulan->get($month->format('Y-m'), collect())->count();
        }

        $statusOptions = self::CAMABA_STATUSES;

        // Status monitoring breakdown
        $statusMonitor = [
            [
                'label' => 'Prospek',
                'count' => (clone $camabaQuery)->where('status', 'Prospek')->count(),
                'bg'    => 'bg-amber-50',
                'text'  => 'text-amber-700',
                'bar'   => 'bg-amber-400',
                'icon'  => 'ti-user-search',
            ],
            [
                'label' => 'Dihubungi',
                'count' => (clone $camabaQuery)->where('status', 'Dihubungi')->count(),
                'bg'    => 'bg-cyan-50',
                'text'  => 'text-cyan-700',
                'bar'   => 'bg-cyan-400',
                'icon'  => 'ti-phone-call',
            ],
            [
                'label' => 'Sudah Daftar',
                'count' => $sudahDaftar,
                'bg'    => 'bg-blue-50',
                'text'  => 'text-blue-700',
                'bar'   => 'bg-blue-500',
                'icon'  => 'ti-clipboard-check',
            ],
            [
                'label' => 'Registrasi',
                'count' => (clone $camabaQuery)->where('status', 'Registrasi')->count(),
                'bg'    => 'bg-violet-50',
                'text'  => 'text-violet-700',
                'bar'   => 'bg-violet-500',
                'icon'  => 'ti-school',
            ],
            [
                'label' => 'Registrasi Ulang',
                'count' => $registrasiUlang,
                'bg'    => 'bg-emerald-50',
                'text'  => 'text-emerald-700',
                'bar'   => 'bg-emerald-500',
                'icon'  => 'ti-circle-check',
            ],
            [
                'label' => 'Batal',
                'count' => (clone $camabaQuery)->where('status', 'Batal')->count(),
                'bg'    => 'bg-red-50',
                'text'  => 'text-red-600',
                'bar'   => 'bg-red-400',
                'icon'  => 'ti-user-x',
            ],
        ];

        return view('auth.agent.dashboard', compact(
            'agent',
            'totalCamaba',
            'prospek',
            'sudahDaftar',
            'registrasiUlang',
            'bonusPerRegistrasi',
            'totalBonus',
            'camabaTerbaru',
            'chartLabels',
            'chartData',
            'statusOptions',
            'statusMonitor'
        ));
    }

    public function app()
    {
        return view("auth.layout.app");
    }

    public function header()
    {
        $status = StatusHelper::formatStatus(Auth::user()->status ?? 'User');
        return view('dashboard', compact('status'));
    }
    public function priode()
    {
        $periodes = Periode::latest()->get();

        return view('auth.admin.dashboard.priode', compact('periodes'));
    }

    public function periodeStore(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:2000|max:2100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['is_active']) {
            Periode::query()->update(['is_active' => false]);
        }

        Periode::create($validated);

        return redirect()->route('priode')
            ->with('success', 'Periode berhasil ditambahkan');
    }

    public function periodeEdit(Periode $periode)
    {
        $periodes = Periode::latest()->get();

        return view('auth.admin.dashboard.priode', compact('periodes', 'periode'));
    }

    public function periodeUpdate(Request $request, Periode $periode)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:2000|max:2100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['is_active']) {
            Periode::whereKeyNot($periode->id)->update(['is_active' => false]);
        }

        $periode->update($validated);

        return redirect()->route('priode')
            ->with('success', 'Periode berhasil diperbarui');
    }

    public function periodeDestroy(Periode $periode)
    {
        $periode->delete();

        return redirect()->route('priode')
            ->with('success', 'Periode berhasil dihapus');
    }

    public function sidebar()
    {
        return view("auth.layout.sidebar");
    }

    public function footer()
    {
        return view("auth.layout.footer");
    }

    // Tampilkan form tambah agent
    public function tambahAgent()
    {
        $periodes = Periode::orderByDesc('is_active')
            ->orderByDesc('tahun')
            ->orderBy('nama_periode')
            ->get();

        $agent = Auth::user();
        $totalCamaba = Agent::where('agent_id', $agent->id)->count();
        $registrasiUlang = Agent::where('agent_id', $agent->id)
            ->where('status', 'Registrasi Ulang')
            ->count();
        $komisiAktif = $this->komisiAktif($agent->status ?? null);
        $targetBonusUkt = $komisiAktif?->target_bonus_ukt;
        $isMitra = ($komisiAktif->kategori ?? null) === 'mitra';
        $targetProgressCount = $isMitra ? $registrasiUlang : $totalCamaba;
        $potonganUktTercapai = $isMitra
            ? $targetBonusUkt !== null && $targetProgressCount >= $targetBonusUkt
            : ($komisiAktif?->memenuhiTargetBonusUkt($totalCamaba) ?? false);
        $sisaTargetUkt = $targetBonusUkt !== null ? max(0, $targetBonusUkt - $targetProgressCount) : null;
        $akanTercapaiSetelahSimpan = $targetBonusUkt !== null
            && $komisiAktif
            && !$isMitra
            && !$potonganUktTercapai
            && $komisiAktif->memenuhiTargetBonusUkt($totalCamaba + 1);

        return view("auth.agent.addAgent.tambahAgent", compact(
            'periodes',
            'komisiAktif',
            'totalCamaba',
            'registrasiUlang',
            'isMitra',
            'targetProgressCount',
            'targetBonusUkt',
            'potonganUktTercapai',
            'sisaTargetUkt',
            'akanTercapaiSetelahSimpan'
        ));
    }
    public function laporanAgent(Request $request)
    {
        $agent = Auth::user();

        $camabaQuery = Agent::where('agent_id', $agent->id)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($query) use ($search) {
                    $query->where('nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('nik', 'like', '%' . $search . '%')
                        ->orWhere('program_studi', 'like', '%' . $search . '%')
                        ->orWhere('sistem_kuliah', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            });

        $totalCamaba = (clone $camabaQuery)->count();
        $prospek = (clone $camabaQuery)->where('status', 'Prospek')->count();
        $sudahDaftar = (clone $camabaQuery)->where('status', 'Sudah Daftar')->count();
        $registrasiUlang = (clone $camabaQuery)->where('status', 'Registrasi Ulang')->count();
        $komisiAktif = $this->komisiAktif($agent->status ?? null);
        $bonusSummary = $komisiAktif?->hitungBonus($registrasiUlang) ?? $this->emptyBonusSummary();
        $bonusSummary['bonus_ukt'] = $komisiAktif?->memenuhiTargetBonusUkt($totalCamaba) ?? false;
        $bonusPerRegistrasi = $this->bonusPerRegistrasi($komisiAktif);
        $totalBonus = (int) ($bonusSummary['total_bonus'] ?? 0);
        $bonusPerCamaba = $this->bonusPerCamaba($agent->id, $komisiAktif);

        $camaba = $camabaQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $progress = [
            'prospek' => [
                'count' => $prospek,
                'percent' => $totalCamaba > 0 ? round(($prospek / $totalCamaba) * 100) : 0,
            ],
            'sudah_daftar' => [
                'count' => $sudahDaftar,
                'percent' => $totalCamaba > 0 ? round(($sudahDaftar / $totalCamaba) * 100) : 0,
            ],
            'registrasi_ulang' => [
                'count' => $registrasiUlang,
                'percent' => $totalCamaba > 0 ? round(($registrasiUlang / $totalCamaba) * 100) : 0,
            ],
        ];

        $tingkatDaftar = $totalCamaba > 0 ? round(($sudahDaftar / $totalCamaba) * 100, 1) : 0;
        $tingkatRegistrasi = $sudahDaftar > 0 ? round(($registrasiUlang / $sudahDaftar) * 100, 1) : 0;
        $konversiTotal = $totalCamaba > 0 ? round(($registrasiUlang / $totalCamaba) * 100, 1) : 0;
        $statusOptions = self::CAMABA_STATUSES;

        return view('auth.agent.laporan', compact(
            'agent',
            'camaba',
            'totalCamaba',
            'prospek',
            'sudahDaftar',
            'registrasiUlang',
            'bonusPerRegistrasi',
            'totalBonus',
            'bonusSummary',
            'bonusPerCamaba',
            'komisiAktif',
            'progress',
            'tingkatDaftar',
            'tingkatRegistrasi',
            'konversiTotal',
            'statusOptions'
        ));
    }

    public function dataCamaba(Request $request)
    {
        $camabas = Agent::with('agent')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($query) use ($search) {
                    $query->where('nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('nik', 'like', '%' . $search . '%')
                        ->orWhere('nomor_hp', 'like', '%' . $search . '%')
                        ->orWhere('program_studi', 'like', '%' . $search . '%')
                        ->orWhere('sistem_kuliah', 'like', '%' . $search . '%')
                        ->orWhereHas('agent', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->when($request->filled('agent_id'), function ($query) use ($request) {
                $query->where('agent_id', $request->input('agent_id'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statusOptions = self::CAMABA_STATUSES;
        $agentOptions = User::orderBy('name')
            ->get(['id', 'name', 'status']);

        return view('auth.admin.dashboard.dataCamaba', compact('camabas', 'statusOptions', 'agentOptions'));
    }

    public function updateCamabaStatus(Request $request, Agent $camaba)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(self::CAMABA_STATUSES)),
        ]);

        $camaba->update($validated);

        return back()
            ->with('success', 'Status camaba berhasil diperbarui');
    }

    private function komisiAktif(?string $status): ?Komisi
    {
        $kategori = match ($status) {
            'dosen_karyawan' => 'dosen_karyawan',
            'mitra' => 'mitra',
            default => 'mao',
        };

        return Komisi::where('kategori', $kategori)
            ->where('is_active', true)
            ->orderBy('nominal_fleksibel')
            ->orderByDesc('bonus_per_mahasiswa')
            ->first();
    }

    private function bonusPerRegistrasi(?Komisi $komisi): int
    {
        if (!$komisi || $komisi->nominal_fleksibel) {
            return 0;
        }

        return (int) ($komisi->bonus_per_mahasiswa ?: $komisi->bonus_lanjutan ?: $komisi->bonus_pertama ?: 0);
    }

    private function bonusPerCamaba(int $agentId, ?Komisi $komisi): array
    {
        if (!$komisi) {
            return [];
        }

        $registrasiUlang = Agent::where('agent_id', $agentId)
            ->where('status', 'Registrasi Ulang')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get(['id'])
            ->values();

        if ($komisi->kategori === 'mitra' && !$komisi->nominal_fleksibel) {
            $targetMitra = (int) ($komisi->target_bonus_ukt ?: 10);
            $totalRegistrasi = $registrasiUlang->count();

            return $registrasiUlang
                ->mapWithKeys(function ($camaba, int $index) use ($komisi, $targetMitra, $totalRegistrasi) {
                    $urutan = $index + 1;

                    if ($totalRegistrasi >= $targetMitra) {
                        $bonus = $urutan < $targetMitra
                            ? 0
                            : ($urutan === $targetMitra ? (int) $komisi->bonus_pertama : (int) $komisi->bonus_per_mahasiswa);
                    } else {
                        $bonus = (int) $komisi->bonus_per_mahasiswa;
                    }

                    return [$camaba->id => $bonus];
                })
                ->all();
        }

        return $registrasiUlang
            ->mapWithKeys(fn ($camaba, int $index) => [
                $camaba->id => $komisi->bonusUntukUrutan($index + 1),
            ])
            ->all();
    }

    private function emptyBonusSummary(): array
    {
        return [
            'total_bonus' => 0,
            'bonus_ukt' => false,
            'bonus_pertama_total' => 0,
            'bonus_lanjutan_total' => 0,
            'bonus_per_mahasiswa_total' => 0,
            'jumlah_bonus_pertama' => 0,
            'jumlah_bonus_lanjutan' => 0,
            'jumlah_bonus_per_mahasiswa' => 0,
        ];
    }
    public function listAgent(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('kode_referral', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('active')) {
            $query->where('is_active', $request->input('active'));
        }

        $agents = $query
            ->with(['camabas' => function ($q) {
                $q->latest();
            }])
            ->withCount('camabas')
            ->latest()
            ->paginate(10);

        return view('auth.admin.dashboard.listAgent', compact('agents'));
    }

    public function listMahasiswaAgent(User $user)
    {
        $agent = $user;

        $mahasiswa = Agent::where('agent_id', $agent->id)
            ->latest()
            ->get();

        return view('auth.admin.dashboard.listMahasiswaAgent', compact('agent', 'mahasiswa'));
    }

    // Simpan agent / mahasiswa baru
    public function agenStore(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|unique:camabas,nik',
            'nomor_hp' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'program_studi' => 'required|string',
            'sistem_kuliah' => ['required', Rule::in(self::SISTEM_KULIAH_OPTIONS)],
            'periode' => 'required|string',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK/NIM harus diisi',
            'nik.unique' => 'NIK/NIM sudah terdaftar',
            'nomor_hp.required' => 'Nomor HP harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'program_studi.required' => 'Program studi harus dipilih',
            'sistem_kuliah.required' => 'Sistem kuliah harus dipilih',
            'periode.required' => 'Periode harus dipilih',
        ]);

        $validated['agent_id'] = Auth::id();
        $validated['status'] = 'Prospek';

        Agent::create($validated);

        return redirect()->route('agen.ShowMahasiswa')
            ->with('success', 'Data calon mahasiswa berhasil ditambahkan!');
    }

    public function agenShow()
    {
        // Ambil Agent Umum yang mendaftar menggunakan kode referral Agent Internal ini
        $kodeReferral = Auth::user()->kode_referral;
        $agentUmumList = AgentLuar::with('camabas')
            ->where('kode_referral_dipakai', $kodeReferral)
            ->latest()
            ->get();
        $agentUmumCount = $agentUmumList->count();

        return view('auth.agent.addAgent.showAgent', compact('agentUmumList', 'agentUmumCount', 'kodeReferral'));
    }

    public function agenShowMahasiswa()
    {
        $agentId = Auth::id();
        $kodeReferral = Auth::user()->kode_referral;
        $agentLuarIds = AgentLuar::where('kode_referral_dipakai', $kodeReferral)
            ->pluck('id');

        $mahasiswa = Agent::where(function ($query) use ($agentId, $agentLuarIds) {
                $query->where('agent_id', $agentId)
                      ->orWhereIn('agent_luar_id', $agentLuarIds);
            })
            ->with(['agent', 'agentLuar'])
            ->latest()
            ->get();

        $mahasiswaCount = $mahasiswa->count();

        return view('auth.agent.addAgent.showMahasiswa', compact('mahasiswa', 'mahasiswaCount', 'kodeReferral'));
    }

    public function agenDetail($id)
    {
        $agentId = Auth::id();
        $kodeReferral = Auth::user()->kode_referral;
        $agentLuarIds = AgentLuar::where('kode_referral_dipakai', $kodeReferral)->pluck('id');

        $agent = Agent::where(function ($query) use ($agentId, $agentLuarIds) {
                $query->where('agent_id', $agentId)
                      ->orWhereIn('agent_luar_id', $agentLuarIds);
            })
            ->with('agentLuar')
            ->findOrFail($id);

        $statusOptions = self::CAMABA_STATUSES;

        return view("auth.agent.addAgent.detailAgent", compact('agent', 'statusOptions'));
    }

    public function agenEdit($id)
    {
        $agent = Agent::where('agent_id', Auth::id())->findOrFail($id);

        if ($agent->status === 'Registrasi Ulang') {
            return redirect()->route('agen.Show')
                ->with('error', 'Calon mahasiswa yang sudah Registrasi Ulang tidak bisa diedit.');
        }

        $periodes = Periode::orderByDesc('is_active')
            ->orderByDesc('tahun')
            ->orderBy('nama_periode')
            ->get();

        return view("auth.agent.addAgent.editAgent", compact('agent', 'periodes'));
    }

    public function agenUpdate(Request $request, $id)
    {
        $agent = Agent::where('agent_id', Auth::id())->find($id);

        if (!$agent) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Agent tidak ditemukan'], 404);
            }
            return redirect()->route('agen.Show')
                ->with('error', 'Agent tidak ditemukan');
        }

        if ($agent->status === 'Registrasi Ulang') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Calon mahasiswa yang sudah Registrasi Ulang tidak bisa diedit.'], 403);
            }

            return redirect()->route('agen.Show')
                ->with('error', 'Calon mahasiswa yang sudah Registrasi Ulang tidak bisa diedit.');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|unique:camabas,nik,' . $id,
            'nomor_hp' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'program_studi' => 'required|string',
            'sistem_kuliah' => ['required', Rule::in(self::SISTEM_KULIAH_OPTIONS)],
            'periode' => 'required|string',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK/NIM harus diisi',
            'nik.unique' => 'NIK/NIM sudah terdaftar',
            'nomor_hp.required' => 'Nomor HP harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'program_studi.required' => 'Program studi harus dipilih',
            'sistem_kuliah.required' => 'Sistem kuliah harus dipilih',
            'periode.required' => 'Periode harus dipilih',
        ]);

        $agent->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Agent berhasil diperbarui', 'agent' => $agent]);
        }

        return redirect()->route('agen.Show')
            ->with('success', 'Agent berhasil diperbarui');
    }

    public function agenDestroy($id)
    {
        $agent = Agent::where('agent_id', Auth::id())->find($id);

        if (!$agent) {
            return redirect()->route('agen.Show')
                ->with('error', 'Agent tidak ditemukan');
        }

        if ($agent->status === 'Registrasi Ulang') {
            return redirect()->route('agen.Show')
                ->with('error', 'Calon mahasiswa yang sudah Registrasi Ulang tidak bisa dihapus.');
        }

        $agent->delete();

        return redirect()->route('agen.Show')
            ->with('success', 'Agent berhasil dihapus');
    }
    
    public function toggleAgent($id)
    {
        $agent = User::find($id);

        if (!$agent) {
            return redirect()->route('listAgent')
                ->with('error', 'Agent tidak ditemukan');
        }

        $agent->is_active = !$agent->is_active;
        $agent->save();

        $status = $agent->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('listAgent')
            ->with('success', 'Agent berhasil ' . $status);
    }
}
