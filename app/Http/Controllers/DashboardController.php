<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;
use App\Models\Agent;
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
        return view('auth.agent.dashboard', compact('agent'));
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
    public function laporanAgent()
    {
        $agent = Auth::user();
        return view('auth.agent.laporan', compact('agent'));
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
