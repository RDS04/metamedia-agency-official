<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentLuar;
use App\Models\Komisi;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AgentLuarDashboardController extends Controller
{
    private const SISTEM_KULIAH_OPTIONS = [
        'Reguler',
        'Mandiri',
        'Mandiri_Transfer',
        'RPL',
    ];

    private const CAMABA_STATUSES = [
        'Prospek'         => 'bg-amber-50 text-amber-700',
        'Dihubungi'       => 'bg-cyan-50 text-cyan-700',
        'Sudah Daftar'    => 'bg-blue-50 text-blue-700',
        'Registrasi'      => 'bg-violet-50 text-violet-700',
        'Registrasi Ulang'=> 'bg-emerald-50 text-emerald-700',
        'Batal'           => 'bg-red-50 text-red-700',
    ];

    /**
     * Dashboard utama Agent Umum
     */
    public function dashboard()
    {
        /** @var AgentLuar $agentLuar */
        $agentLuar = Auth::guard('agent_luar')->user();

        $camabaQuery = Agent::where('agent_luar_id', $agentLuar->id);

        $totalCamaba     = (clone $camabaQuery)->count();
        $prospek         = (clone $camabaQuery)->where('status', 'Prospek')->count();
        $sudahDaftar     = (clone $camabaQuery)->where('status', 'Sudah Daftar')->count();
        $registrasiUlang = (clone $camabaQuery)->where('status', 'Registrasi Ulang')->count();

        // Hitung bonus berdasarkan status agent luar (MAO sebagai default)
        $komisiAktif  = $this->komisiAktif($agentLuar->status ?? null);
        $totalBonus   = 0;
        if ($komisiAktif && !$komisiAktif->nominal_fleksibel) {
            $bonusSummary = $komisiAktif->hitungBonus($registrasiUlang);
            $totalBonus   = (int) ($bonusSummary['total_bonus'] ?? 0);
        }

        $camabaTerbaru = (clone $camabaQuery)->latest()->take(5)->get();

        // Chart 6 bulan terakhir
        $chartStart = now()->startOfMonth()->subMonths(5);
        $camabaPerBulan = (clone $camabaQuery)
            ->where('created_at', '>=', $chartStart)
            ->get()
            ->groupBy(fn ($c) => $c->created_at->format('Y-m'));

        $chartLabels = [];
        $chartData   = [];
        for ($i = 0; $i < 6; $i++) {
            $month         = $chartStart->copy()->addMonths($i);
            $chartLabels[] = $month->format('M Y');
            $chartData[]   = $camabaPerBulan->get($month->format('Y-m'), collect())->count();
        }

        $statusOptions = self::CAMABA_STATUSES;

        // Status monitoring
        $statusMonitor = [
            ['label' => 'Prospek',          'count' => $prospek,         'bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'bar' => 'bg-amber-400',   'icon' => 'ti-user-search'],
            ['label' => 'Dihubungi',        'count' => (clone $camabaQuery)->where('status', 'Dihubungi')->count(), 'bg' => 'bg-cyan-50', 'text' => 'text-cyan-700', 'bar' => 'bg-cyan-400', 'icon' => 'ti-phone-call'],
            ['label' => 'Sudah Daftar',     'count' => $sudahDaftar,     'bg' => 'bg-blue-50',    'text' => 'text-blue-700',    'bar' => 'bg-blue-500',    'icon' => 'ti-clipboard-check'],
            ['label' => 'Registrasi',       'count' => (clone $camabaQuery)->where('status', 'Registrasi')->count(), 'bg' => 'bg-violet-50', 'text' => 'text-violet-700', 'bar' => 'bg-violet-500', 'icon' => 'ti-school'],
            ['label' => 'Registrasi Ulang', 'count' => $registrasiUlang, 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'bar' => 'bg-emerald-500', 'icon' => 'ti-circle-check'],
            ['label' => 'Batal',            'count' => (clone $camabaQuery)->where('status', 'Batal')->count(), 'bg' => 'bg-red-50', 'text' => 'text-red-600', 'bar' => 'bg-red-400', 'icon' => 'ti-user-x'],
        ];

        return view('auth.agentLuar.dashboard', compact(
            'agentLuar',
            'totalCamaba',
            'prospek',
            'sudahDaftar',
            'registrasiUlang',
            'totalBonus',
            'camabaTerbaru',
            'chartLabels',
            'chartData',
            'statusOptions',
            'statusMonitor'
        ));
    }

    /**
     * Daftar semua camaba milik Agent Umum (dengan filter & pagination)
     */
    public function camabaIndex(Request $request)
    {
        /** @var AgentLuar $agentLuar */
        $agentLuar = Auth::guard('agent_luar')->user();

        $camabaQuery = Agent::where('agent_luar_id', $agentLuar->id)
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->input('search');
                $q->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('program_studi', 'like', "%{$search}%")
                        ->orWhere('sistem_kuliah', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->input('status'));
            });

        $totalCamaba     = Agent::where('agent_luar_id', $agentLuar->id)->count();
        $prospek         = Agent::where('agent_luar_id', $agentLuar->id)->where('status', 'Prospek')->count();
        $sudahDaftar     = Agent::where('agent_luar_id', $agentLuar->id)->where('status', 'Sudah Daftar')->count();
        $registrasiUlang = Agent::where('agent_luar_id', $agentLuar->id)->where('status', 'Registrasi Ulang')->count();

        $camabas = $camabaQuery->latest()->paginate(10)->withQueryString();

        $statusOptions = self::CAMABA_STATUSES;

        return view('auth.agentLuar.camaba.index', compact(
            'agentLuar',
            'camabas',
            'totalCamaba',
            'prospek',
            'sudahDaftar',
            'registrasiUlang',
            'statusOptions'
        ));
    }

    /**
     * Form tambah camaba baru
     */
    public function tambahCamaba()
    {
        $periodes = Periode::orderByDesc('is_active')
            ->orderByDesc('tahun')
            ->orderBy('nama_periode')
            ->get();

        $agentLuar = Auth::guard('agent_luar')->user();

        return view('auth.agentLuar.camaba.create', compact('periodes', 'agentLuar'));
    }

    /**
     * Simpan camaba baru
     */
    public function camabaSimpan(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => 'required|string|unique:camabas,nik',
            'nomor_hp'      => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'program_studi' => 'required|string',
            'sistem_kuliah' => ['required', Rule::in(self::SISTEM_KULIAH_OPTIONS)],
            'periode'       => 'required|string',
        ], [
            'nama_lengkap.required'  => 'Nama lengkap harus diisi',
            'nik.required'           => 'NIK/NIM harus diisi',
            'nik.unique'             => 'NIK/NIM sudah terdaftar',
            'nomor_hp.required'      => 'Nomor HP harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'program_studi.required' => 'Program studi harus dipilih',
            'sistem_kuliah.required' => 'Sistem kuliah harus dipilih',
            'periode.required'       => 'Periode harus dipilih',
        ]);

        $agentLuar = Auth::guard('agent_luar')->user();

        $validated['agent_luar_id'] = $agentLuar->id;
        $validated['agent_id']      = $agentLuar->agent_internal_id; // Tetap link ke agent internal
        $validated['status']        = 'Prospek';

        Agent::create($validated);

        return redirect()->route('agent-luar.camaba.index')
            ->with('success', 'Calon mahasiswa berhasil ditambahkan!');
    }

    /**
     * Detail camaba
     */
    public function camabaDetail($id)
    {
        $agentLuar = Auth::guard('agent_luar')->user();
        $camaba    = Agent::where('agent_luar_id', $agentLuar->id)->findOrFail($id);
        $statusOptions = self::CAMABA_STATUSES;

        return view('auth.agentLuar.camaba.detail', compact('camaba', 'statusOptions', 'agentLuar'));
    }

    /**
     * Form edit camaba
     */
    public function camabaEdit($id)
    {
        $agentLuar = Auth::guard('agent_luar')->user();
        $camaba    = Agent::where('agent_luar_id', $agentLuar->id)->findOrFail($id);

        if ($camaba->status === 'Registrasi Ulang') {
            return redirect()->route('agent-luar.camaba.index')
                ->with('error', 'Calon mahasiswa yang sudah Registrasi Ulang tidak bisa diedit.');
        }

        $periodes = Periode::orderByDesc('is_active')
            ->orderByDesc('tahun')
            ->orderBy('nama_periode')
            ->get();

        return view('auth.agentLuar.camaba.edit', compact('camaba', 'periodes', 'agentLuar'));
    }

    /**
     * Update camaba
     */
    public function camabaUpdate(Request $request, $id)
    {
        $agentLuar = Auth::guard('agent_luar')->user();
        $camaba    = Agent::where('agent_luar_id', $agentLuar->id)->findOrFail($id);

        if ($camaba->status === 'Registrasi Ulang') {
            return redirect()->route('agent-luar.camaba.index')
                ->with('error', 'Calon mahasiswa yang sudah Registrasi Ulang tidak bisa diedit.');
        }

        $validated = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => 'required|string|unique:camabas,nik,' . $id,
            'nomor_hp'      => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'program_studi' => 'required|string',
            'sistem_kuliah' => ['required', Rule::in(self::SISTEM_KULIAH_OPTIONS)],
            'periode'       => 'required|string',
        ], [
            'nama_lengkap.required'  => 'Nama lengkap harus diisi',
            'nik.required'           => 'NIK/NIM harus diisi',
            'nik.unique'             => 'NIK/NIM sudah terdaftar',
            'nomor_hp.required'      => 'Nomor HP harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'program_studi.required' => 'Program studi harus dipilih',
            'sistem_kuliah.required' => 'Sistem kuliah harus dipilih',
            'periode.required'       => 'Periode harus dipilih',
        ]);

        $camaba->update($validated);

        return redirect()->route('agent-luar.camaba.index')
            ->with('success', 'Data calon mahasiswa berhasil diperbarui!');
    }

    /**
     * Hapus camaba
     */
    public function camabaDestroy($id)
    {
        $agentLuar = Auth::guard('agent_luar')->user();
        $camaba    = Agent::where('agent_luar_id', $agentLuar->id)->findOrFail($id);

        if ($camaba->status === 'Registrasi Ulang') {
            return redirect()->route('agent-luar.camaba.index')
                ->with('error', 'Calon mahasiswa yang sudah Registrasi Ulang tidak bisa dihapus.');
        }

        $camaba->delete();

        return redirect()->route('agent-luar.camaba.index')
            ->with('success', 'Calon mahasiswa berhasil dihapus.');
    }

    /**
     * Helper: ambil komisi aktif berdasarkan status
     */
    private function komisiAktif(?string $status): ?Komisi
    {
        $kategori = match ($status) {
            'dosen_karyawan' => 'dosen_karyawan',
            'mitra'          => 'mitra',
            default          => 'mao',
        };

        return Komisi::where('kategori', $kategori)
            ->where('is_active', true)
            ->orderBy('nominal_fleksibel')
            ->orderByDesc('bonus_per_mahasiswa')
            ->first();
    }
}
