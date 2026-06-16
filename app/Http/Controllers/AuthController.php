<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:mahasiswa,alumni,orang_tua,dosen_karyawan,mitra',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'status.required' => 'Status harus dipilih',
            'phone.required' => 'Nomor WhatsApp harus diisi',
            'phone.unique' => 'Nomor WhatsApp sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('auth.login')
            ->with('success', 'Selamat! Anda berhasil mendaftar');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ], [
            'phone.required' => 'Nomor WhatsApp harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $credentials = [
            'phone' => $validated['phone'],
            'password' => $validated['password'],
        ];

        // Support remember me
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali!');
        }

        return back()
            ->withInput()
            ->with('error', 'Nomor WhatsApp atau Password salah');
    }

    public function loginAdmin(Request $request)
    {
        return view('auth.admin.login');
    }

    public function registerAdmin(Request $request)
    {
        return view('auth.admin.register');
    }
    public function adminregisterStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email admin sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('login.admin')
            ->with('success', 'Registrasi berhasil, silakan login.');
    }
    public function adminlogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt($validated, $remember)) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('dashboard.auth'))
                ->with('success', 'Selamat datang, admin!');
        }

        return back()
            ->withInput()
            ->with('error', 'Email atau Password salah');
    }

    public function adminDashboard()
    {
        $agents = User::latest()->get();

        return view('auth.admin.dashboard.dashboard', compact('agents'));
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.admin');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
