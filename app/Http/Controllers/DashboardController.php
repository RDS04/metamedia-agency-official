<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;
use App\Models\Agent;
use App\Models\Komisi;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function informasi()
    {
        return view('informasi');
    }

    public function dashboard(Request $request)
    {
        $agent = Auth::user();
        $totalCamaba = Agent::count();
        $sudahDaftar = 0;
        $registrasiUlang = 0;
        $bonusPerRegistrasi = $this->bonusPerRegistrasi($agent->status ?? null);
        $totalBonus = $registrasiUlang * $bonusPerRegistrasi;
        $camabaTerbaru = Agent::latest()->take(5)->get();

        $chartStart = now()->startOfMonth()->subMonths(5);
        $camabaPerBulan = Agent::where('created_at', '>=', $chartStart)
            ->get()
            ->groupBy(fn ($camaba) => $camaba->created_at->format('Y-m'));

        $chartLabels = [];
        $chartData = [];

        for ($i = 0; $i < 6; $i++) {
            $month = $chartStart->copy()->addMonths($i);
            $chartLabels[] = $month->format('M Y');
            $chartData[] = $camabaPerBulan->get($month->format('Y-m'), collect())->count();
        }

        return view('auth.agent.dashboard', compact(
            'agent',
            'totalCamaba',
            'sudahDaftar',
            'registrasiUlang',
            'bonusPerRegistrasi',
            'totalBonus',
            'camabaTerbaru',
            'chartLabels',
            'chartData'
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

        return view("auth.agent.addAgent.tambahAgent", compact('periodes'));
    }
    public function laporanAgent(Request $request)
    {
        $agent = Auth::user();

        $camabaQuery = Agent::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($query) use ($search) {
                    $query->where('nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('nik', 'like', '%' . $search . '%')
                        ->orWhere('program_studi', 'like', '%' . $search . '%')
                        ->orWhere('sistem_kuliah', 'like', '%' . $search . '%');
                });
            });

        $totalCamaba = (clone $camabaQuery)->count();
        $sudahDaftar = 0;
        $registrasiUlang = 0;
        $bonusPerRegistrasi = $this->bonusPerRegistrasi($agent->status ?? null);
        $totalBonus = $registrasiUlang * $bonusPerRegistrasi;

        $camaba = $camabaQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $progress = [
            'prospek' => [
                'count' => $totalCamaba,
                'percent' => $totalCamaba > 0 ? 100 : 0,
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

        return view('auth.agent.laporan', compact(
            'agent',
            'camaba',
            'totalCamaba',
            'sudahDaftar',
            'registrasiUlang',
            'bonusPerRegistrasi',
            'totalBonus',
            'progress',
            'tingkatDaftar',
            'tingkatRegistrasi',
            'konversiTotal'
        ));
    }

    private function bonusPerRegistrasi(?string $status): int
    {
        $kategori = match ($status) {
            'dosen_karyawan' => 'dosen_karyawan',
            'mitra' => 'mitra',
            default => 'mao',
        };

        $komisi = Komisi::where('kategori', $kategori)
            ->where('is_active', true)
            ->orderByDesc('bonus_per_mahasiswa')
            ->first();

        return (int) ($komisi?->bonus_per_mahasiswa ?: $komisi?->bonus_lanjutan ?: $komisi?->bonus_pertama ?: 0);
    }
    public function listAgent()
    {
        $agents = User::latest()->get();

        return view('auth.admin.dashboard.listAgent', compact('agents'));
    }

    // Simpan agent baru
    public function agenStore(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|unique:camabas,nik',
            'nomor_hp' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'program_studi' => 'required|string',
            'sistem_kuliah' => 'required|string',
            'periode' => 'required|string',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'nomor_hp.required' => 'Nomor HP harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'program_studi.required' => 'Program studi harus dipilih',
            'sistem_kuliah.required' => 'Sistem kuliah harus dipilih',
            'periode.required' => 'Periode harus dipilih',
        ]);

        Agent::create($validated);

        return redirect()->route('agen.Show')
            ->with('success', 'Agent berhasil ditambahkan');
    }

    // Tampilkan data agent
    public function agenShow()
    {
        $agents = Agent::all();
        return view("auth.agent.addAgent.showAgent", ['agents' => $agents]);
    }

    // Tampilkan form edit agent
    public function agenEdit($id)
    {
        $agent = Agent::findOrFail($id);

        if (!$agent) {
            return redirect()->route('agen.Show')
                ->with('error', 'Agent tidak ditemukan');
        }

        $periodes = Periode::orderByDesc('is_active')
            ->orderByDesc('tahun')
            ->orderBy('nama_periode')
            ->get();

        return view("auth.agent.addAgent.editAgent", compact('agent', 'periodes'));
    }

    // Update agent
    public function agenUpdate(Request $request, $id)
    {
        $agent = Agent::find($id);

        if (!$agent) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Agent tidak ditemukan'], 404);
            }
            return redirect()->route('agen.Show')
                ->with('error', 'Agent tidak ditemukan');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|unique:camabas,nik,' . $id,
            'nomor_hp' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'program_studi' => 'required|string',
            'sistem_kuliah' => 'required|string',
            'periode' => 'required|string',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah terdaftar',
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

    // Hapus agent
    public function agenDestroy($id)
    {
        $agent = Agent::find($id);

        if (!$agent) {
            return redirect()->route('agen.Show')
                ->with('error', 'Agent tidak ditemukan');
        }

        $agent->delete();

        return redirect()->route('agen.Show')
            ->with('success', 'Agent berhasil dihapus');
    }

    // Toggle Agent Status
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
