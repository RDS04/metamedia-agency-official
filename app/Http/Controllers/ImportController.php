<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaTemplateExport;
use App\Exports\MahasiswaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Show form untuk input mahasiswa
     */
    public function createMahasiswa(Request $request)
    {
        $nextNoPendaftaran = $this->generateNoPendaftaran();

        return view("auth.importMaba.importMaba", compact('nextNoPendaftaran'));
    }

    /**
     * Store mahasiswa dari form input manual
     */
    public function storeMahasiswa(Request $request)
    {
        $programStudi = implode(',', Mahasiswa::PROGRAM_STUDI);
        
        $validated = $request->validate([
            'nik' => 'required|unique:mahasiswas,nik',
            'nama_lengkap' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'program_studi' => 'required|in:' . $programStudi,
            'sistem_kuliah' => 'required|in:Reguler,Mandiri,Mandiri_transfer,RPL',
            'periode' => 'required|string',
        ]);

        $validated['no_pendaftaran'] = $this->generateNoPendaftaran();

        Mahasiswa::create($validated);

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan');
    }

    /**
     * Preview mahasiswa dari Excel sebelum import
     */
    public function previewImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            // Load file dan collect data tanpa save ke DB
            $rows = Excel::toArray(
                new MahasiswaImport,
                $request->file('file')
            );

            // Get first sheet
            $data = $rows[0] ?? [];

            if (empty($data)) {
                return back()->withErrors(['file' => 'File Excel kosong atau tidak valid']);
            }

            $lastNumber = max($this->getLastNoPendaftaranNumber(), $this->getLastNoPendaftaranNumberFromRows($data));
            $data = collect($data)->map(function ($row) use (&$lastNumber) {
                if (empty($row['no_pendaftaran'])) {
                    $lastNumber++;
                    $row['no_pendaftaran'] = $this->formatNoPendaftaran($lastNumber);
                }

                return $row;
            })->all();

            // Simpan ke session untuk diproses
            session(['import_data' => $data]);

            return view('auth.importMaba.previewImport', ['data' => $data]);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['file' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Confirm dan save preview data ke database
     */
    public function confirmImport(Request $request)
    {
        $data = session('import_data');

        if (!$data) {
            return redirect()->route('mahasiswa.create')
                ->withErrors('Session expired, silakan upload file lagi');
        }

        try {
            foreach ($data as $row) {
                // Skip jika row kosong
                if (empty(array_filter($row))) {
                    continue;
                }

                // Validasi
                $validated = [
                    'nik' => $row['nik'] ?? null,
                    'no_pendaftaran' => $row['no_pendaftaran'] ?? null,
                    'nama_lengkap' => $row['nama_lengkap'] ?? null,
                    'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
                    'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                    'program_studi' => $row['program_studi'] ?? null,
                    'sistem_kuliah' => $row['sistem_kuliah'] ?? null,
                    'periode' => $row['periode'] ?? null,
                ];

                if (empty($validated['no_pendaftaran'])) {
                    $validated['no_pendaftaran'] = $this->generateNoPendaftaran();
                }

                // Skip jika required fields kosong
                if (empty($validated['nik']) || empty($validated['nama_lengkap'])) {
                    continue;
                }

                // Check duplikat
                $existing = Mahasiswa::where('nik', $validated['nik'])
                    ->orWhere('no_pendaftaran', $validated['no_pendaftaran'])
                    ->first();

                if (!$existing) {
                    Mahasiswa::create($validated);
                }
            }

            // Clear session
            session()->forget('import_data');

            return redirect()
                ->route('mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil diimport dari Excel');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.create')
                ->withErrors('Terjadi kesalahan saat simpan: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        return Excel::download(
            new MahasiswaTemplateExport,
            'template_mahasiswa.xlsx'
        );
    }

    /**
     * Export data mahasiswa ke Excel
     */
    public function exportMahasiswa()
    {
        return Excel::download(
            new MahasiswaExport,
            'data_mahasiswa_' . date('Y-m-d_H-i-s') . '.xlsx'
        );
    }

    /**
     * Show list mahasiswa
     */
public function indexMahasiswa(Request $request)
{
    $query = Mahasiswa::query();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%')
                ->orWhere('no_pendaftaran', 'like', '%' . $search . '%');
        });
    }

    if ($request->filled('program_studi')) {
        $query->where('program_studi', $request->program_studi);
    }

    if ($request->filled('sistem_kuliah')) {
        $query->where('sistem_kuliah', $request->sistem_kuliah);
    }

    $mahasiswas = $query->latest()->paginate(50)->withQueryString();

    // Statistik Program Studi
    $sistemInformasi = Mahasiswa::where('program_studi', 'Sistem Informasi')->count();

    $informatika = Mahasiswa::where('program_studi', 'Informatika')->count();

    $bisnisDigital = Mahasiswa::where('program_studi', 'Bisnis Digital')->count();

    $dkv = Mahasiswa::where('program_studi', 'Desain Komunikasi Visual')->count();

    $pti = Mahasiswa::where('program_studi', 'Pendidikan Teknologi Informasi')->count();

    $manajemenRitel = Mahasiswa::where('program_studi', 'Manajemen Ritel')->count();

    $totalMahasiswa = Mahasiswa::count();

    return view(
        'auth.importMaba.showData',
        compact(
            'mahasiswas',
            'totalMahasiswa',
            'sistemInformasi',
            'informatika',
            'bisnisDigital',
            'dkv',
            'pti',
            'manajemenRitel'
        )
    );
}

    /**
     * Generate nomor pendaftaran otomatis dengan format PMB001, PMB002, dst.
     */
    private function generateNoPendaftaran()
    {
        return $this->formatNoPendaftaran($this->getLastNoPendaftaranNumber() + 1);
    }

    private function getLastNoPendaftaranNumber()
    {
        return Mahasiswa::where('no_pendaftaran', 'like', 'PMB%')
            ->pluck('no_pendaftaran')
            ->map(function ($number) {
                return $this->extractNoPendaftaranNumber($number);
            })
            ->max() ?? 0;
    }

    private function getLastNoPendaftaranNumberFromRows(array $rows)
    {
        return collect($rows)
            ->map(function ($row) {
                return $this->extractNoPendaftaranNumber($row['no_pendaftaran'] ?? null);
            })
            ->max() ?? 0;
    }

    private function extractNoPendaftaranNumber($number)
    {
        if (preg_match('/^PMB(\d+)$/', (string) $number, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }

    private function formatNoPendaftaran($number)
    {
        return 'PMB' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Edit mahasiswa
     */
    public function editMahasiswa($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('auth.importMaba.editMahasiswa', compact('mahasiswa'));
    }

    /**
     * Update mahasiswa
     */
    public function updateMahasiswa(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $programStudi = implode(',', Mahasiswa::PROGRAM_STUDI);

        $validated = $request->validate([
            'nik' => 'required|unique:mahasiswas,nik,' . $id,
            'no_pendaftaran' => 'required|unique:mahasiswas,no_pendaftaran,' . $id,
            'nama_lengkap' => 'required|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'program_studi' => 'required|in:' . $programStudi,
            'sistem_kuliah' => 'required|in:Reguler,Mandiri,Mandiri_transfer,RPL',
            'periode' => 'required|string',
        ]);

        $mahasiswa->update($validated);

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diubah');
    }

    /**
     * Delete mahasiswa
     */
    public function destroyMahasiswa($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus');
    }
}
