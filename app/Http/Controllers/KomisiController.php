<?php

namespace App\Http\Controllers;

use App\Models\Komisi;
use Illuminate\Http\Request;

class KomisiController extends Controller
{
    private const CATEGORIES = [
        'mao' => [
            'view' => 'auth.admin.komisi.mao',
            'title' => 'Komisi Mahasiswa, Orang Tua, Alumni',
            'description' => 'Kelola bonus agent mahasiswa, orang tua, dan alumni.',
        ],
        'dosen_karyawan' => [
            'view' => 'auth.admin.komisi.dosenKaryawan',
            'title' => 'Komisi Dosen dan Karyawan',
            'description' => 'Kelola bonus dosen dan karyawan berdasarkan jumlah mahasiswa.',
        ],
        'mitra' => [
            'view' => 'auth.admin.komisi.mitra',
            'title' => 'Komisi Mitra / Instansi',
            'description' => 'Kelola catatan bonus mitra atau instansi MOU.',
        ],
    ];

    public function mao(Request $request)
    {
        return $this->showCategory($request, 'mao');
    }

    public function dosenKaryawan(Request $request)
    {
        return $this->showCategory($request, 'dosen_karyawan');
    }

    public function mitra(Request $request)
    {
        return $this->showCategory($request, 'mitra');
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['nominal_fleksibel'] = $request->boolean('nominal_fleksibel');
        $validated = $this->normalizeNumbers($validated);

        Komisi::create($validated);

        return redirect()->route($this->routeName($validated['kategori']))
            ->with('success', 'Skema komisi berhasil ditambahkan');
    }

    public function update(Request $request, Komisi $komisi)
    {
        $validated = $this->validatedData($request);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['nominal_fleksibel'] = $request->boolean('nominal_fleksibel');
        $validated = $this->normalizeNumbers($validated);

        $komisi->update($validated);

        return redirect()->route($this->routeName($validated['kategori']))
            ->with('success', 'Skema komisi berhasil diperbarui');
    }

    public function destroy(Komisi $komisi)
    {
        $kategori = $komisi->kategori;
        $komisi->delete();

        return redirect()->route($this->routeName($kategori))
            ->with('success', 'Skema komisi berhasil dihapus');
    }

    private function showCategory(Request $request, string $kategori)
    {
        $meta = self::CATEGORIES[$kategori];
        $komisis = Komisi::where('kategori', $kategori)
            ->latest()
            ->get();

        $editing = $request->filled('edit')
            ? Komisi::where('kategori', $kategori)->find($request->integer('edit'))
            : null;

        $simulasi = null;
        if ($request->filled('komisi_id') && $request->filled('jumlah_mahasiswa')) {
            $selected = Komisi::where('kategori', $kategori)->find($request->integer('komisi_id'));

            if ($selected) {
                $jumlahMahasiswa = $request->integer('jumlah_mahasiswa');
                $hasil = $selected->hitungBonus($jumlahMahasiswa);

                $simulasi = [
                    'komisi' => $selected,
                    'jumlah_mahasiswa' => $jumlahMahasiswa,
                    'total_bonus' => $hasil['total_bonus'],
                    'bonus_ukt' => $hasil['bonus_ukt'],
                ];
            }
        }

        return view($meta['view'], compact('meta', 'kategori', 'komisis', 'editing', 'simulasi'));
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'kategori' => 'required|in:mao,dosen_karyawan,mitra',
            'nama_skema' => 'required|string|max:255',
            'sistem_kuliah' => 'nullable|string|max:255',
            'target_bonus_ukt' => 'nullable|integer|min:1',
            'bonus_pertama' => 'nullable|integer|min:0',
            'bonus_lanjutan' => 'nullable|integer|min:0',
            'bonus_per_mahasiswa' => 'nullable|integer|min:0',
            'ukt_per_semester' => 'nullable|integer|min:0',
            'potongan_ukt_persen' => 'nullable|numeric|min:0|max:100',
            'nominal_fleksibel' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'catatan' => 'nullable|string',
        ]);
    }

    private function routeName(string $kategori): string
    {
        return match ($kategori) {
            'dosen_karyawan' => 'komisi.dosen-karyawan',
            'mitra' => 'komisi.mitra',
            default => 'komisi.mao',
        };
    }

    private function normalizeNumbers(array $data): array
    {
        foreach (['bonus_pertama', 'bonus_lanjutan', 'bonus_per_mahasiswa'] as $field) {
            $data[$field] = (int) ($data[$field] ?? 0);
        }

        foreach (['target_bonus_ukt', 'ukt_per_semester', 'potongan_ukt_persen'] as $field) {
            $value = $data[$field] ?? null;
            $data[$field] = $value === null || $value === ''
                ? null
                : $value;
        }

        return $data;
    }
}
