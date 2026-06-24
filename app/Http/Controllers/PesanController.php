<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // PUBLIC: Simpan kepuasan agent dari halaman informasi
    // ─────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'rating'       => 'required|integer|min:1|max:5',
            'fitur_favorit'=> 'nullable|array',
            'fitur_favorit.*' => 'string|max:100',
            'saran'        => 'nullable|string|max:2000',
            'rekomendasi'  => 'nullable|string|max:100',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'email.required'        => 'Email harus diisi.',
            'email.email'           => 'Format email tidak valid.',
            'rating.required'       => 'Silakan beri penilaian bintang terlebih dahulu.',
            'rating.min'            => 'Rating minimal 1 bintang.',
        ]);

        $validated['tampil'] = true;

        Pesan::create($validated);

        return redirect()
            ->route('informasi')
            ->with('success', 'Terima kasih! Penilaian Anda berhasil dikirim. 🎉');
    }

    // ─────────────────────────────────────────────────────────────
    // ADMIN: Kelola seluruh data kepuasan
    // ─────────────────────────────────────────────────────────────

    /** Daftar semua pesan kepuasan */
    public function index(Request $request)
    {
        $pesans = Pesan::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('rating'), fn ($q) => $q->where('rating', $request->rating))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('auth.admin.pesan.index', compact('pesans'));
    }

    /** Detail satu pesan */
    public function show(Pesan $pesan)
    {
        return view('auth.admin.pesan.show', compact('pesan'));
    }

    /** Toggle tampil / sembunyikan di testimoni publik */
    public function toggleTampil(Pesan $pesan)
    {
        $pesan->update(['tampil' => !$pesan->tampil]);

        $status = $pesan->tampil ? 'ditampilkan' : 'disembunyikan';

        return back()->with('success', "Testimonial berhasil $status.");
    }

    /** Hapus permanen */
    public function destroy(Pesan $pesan)
    {
        $pesan->delete();

        return back()->with('success', 'Data kepuasan berhasil dihapus.');
    }
}
