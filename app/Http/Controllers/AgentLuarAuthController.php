<?php

namespace App\Http\Controllers;

use App\Models\AgentLuar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Str;

class AgentLuarAuthController extends Controller
{
    /**
     * Tampilkan form registrasi Agent Umum
     */
    public function register()
    {
        return view('auth.agentLuar.register');
    }

    /**
     * Proses registrasi Agent Umum
     */
    public function registerStore(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'phone'                 => 'required|string|unique:agent_luars,phone',
            'email'                 => 'required|email|unique:agent_luars,email',
            'password'              => 'required|string|min:6|confirmed',
            'kode_referral_dipakai' => 'required|string',
        ], [
            'name.required'                  => 'Nama harus diisi',
            'phone.required'                 => 'Nomor WhatsApp harus diisi',
            'phone.unique'                   => 'Nomor WhatsApp sudah terdaftar',
            'email.required'                 => 'Email harus diisi',
            'email.email'                    => 'Format email tidak valid',
            'email.unique'                   => 'Email sudah terdaftar',
            'password.required'              => 'Password harus diisi',
            'password.min'                   => 'Password minimal 6 karakter',
            'password.confirmed'             => 'Konfirmasi password tidak sesuai',
            'kode_referral_dipakai.required' => 'Kode referral harus diisi',
        ]);

        // Validasi kode referral — harus cocok dengan kode_referral yang ada di tabel users
        $agentInternal = User::where('kode_referral', $validated['kode_referral_dipakai'])->first();

        if (!$agentInternal) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Kode referral tidak valid. Pastikan kode yang Anda masukkan benar.');
        }

        // Buat Agent Umum
        $kodeReferralBaru = $this->generateUniqueReferralCode();

        AgentLuar::create([
            'name'                  => $validated['name'],
            'phone'                 => $validated['phone'],
            'email'                 => $validated['email'],
            'password'              => Hash::make($validated['password']),
            'kode_referral_dipakai' => $validated['kode_referral_dipakai'],
            'agent_internal_id'     => $agentInternal->id,
            'kode_referral'         => $kodeReferralBaru,
            'is_active'             => true,
            'email_verified_at'     => now(),
        ]);

        return redirect()
            ->route('agent-luar.login')
            ->with('success', 'Registrasi berhasil! Selamat bergabung sebagai Agent Umum. Silakan login.');
    }

    /**
     * Tampilkan form login Agent Umum
     */
    public function login()
    {
        return view('auth.agentLuar.login');
    }

    /**
     * Proses login Agent Umum
     */
    public function loginProcess(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email harus diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        $remember = $request->has('remember');

        $guards = [
            'agent_luar' => route('agent-luar.dashboard'),
            'web' => route('dashboard'),
            'admin' => route('dashboard.admin'),
        ];

        foreach ($guards as $guard => $redirectRoute) {
            if (Auth::guard($guard)->attempt([
                'email'    => $validated['email'],
                'password' => $validated['password'],
            ], $remember)) {
                $request->session()->regenerate();

                if ($guard === 'agent_luar') {
                    $agentLuar = Auth::guard('agent_luar')->user();
                    if (!$agentLuar->is_active) {
                        Auth::guard('agent_luar')->logout();
                        return back()
                            ->withInput()
                            ->with('error', 'Akun Anda tidak aktif. Hubungi Agent Internal Anda untuk mengaktifkan akun.');
                    }

                    return redirect()
                        ->intended($redirectRoute)
                        ->with('success', 'Selamat datang kembali, ' . $agentLuar->name . '!');
                }

                $user = Auth::guard($guard)->user();
                $displayName = $user->name ?? $user->email;

                return redirect()
                    ->intended($redirectRoute)
                    ->with('success', 'Selamat datang kembali, ' . $displayName . '!');
            }
        }

        return back()
            ->withInput()
            ->with('error', 'Email atau Password salah');
    }

    /**
     * Logout Agent Umum
     */
    public function logout(Request $request)
    {
        Auth::guard('agent_luar')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('agent-luar.login');
    }

    /**
     * Generate kode referral unik untuk Agent Umum
     */
    private function generateUniqueReferralCode(): string
    {
        do {
            $code = 'AGU-' . strtoupper(Str::random(8));
        } while (AgentLuar::where('kode_referral', $code)->exists());

        return $code;
    }
}
