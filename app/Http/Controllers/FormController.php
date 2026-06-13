<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        return view('form.index');
    }

    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'asal_sekolah' => $request->asal_sekolah,
            'tahun_lulus' => $request->tahun_lulus,
            'program_studi' => $request->program_studi,
            'kelas' => $request->kelas,
        ]);

        // simpan id mahasiswa ke session
        session([
            'mahasiswa_id' => $mahasiswa->id
        ]);

        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        $id = session('mahasiswa_id');

        if (!$id) {
            return redirect()->route('showName');
        }

        $mahasiswa = Mahasiswa::findOrFail($id);

        return view('dashboard', compact('mahasiswa'));
    }

    public function selamat()
    {
        $id = session('mahasiswa_id');

        if (!$id) {
            return redirect()->route('showName');
        }

        $mahasiswa = Mahasiswa::findOrFail($id);

        return view('selamat', compact('mahasiswa'));
    }

    public function show()
    {
        $id = session('mahasiswa_id');

        if (!$id) {
            return redirect()->route('showName');
        }

        $mahasiswa = Mahasiswa::findOrFail($id);

        return view('form.show', compact('mahasiswa'));
    }

    public function edit()
    {
        $id = session('mahasiswa_id');

        if (!$id) {
            return redirect()->route('showName');
        }

        $mahasiswa = Mahasiswa::findOrFail($id);

        return view('form.edit', compact('mahasiswa'));
    }

    public function update(Request $request)
    {
        $id = session('mahasiswa_id');

        if (!$id) {
            return redirect()->route('showName');
        }

        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'asal_sekolah' => $request->asal_sekolah,
            'tahun_lulus' => $request->tahun_lulus,
            'program_studi' => $request->program_studi,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Data berhasil diperbarui');
    }
}