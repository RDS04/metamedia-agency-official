<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'status.required' => 'Status harus dipilih',
            'phone.required' => 'Nomor WhatsApp harus diisi',
            'phone.unique' => 'Nomor WhatsApp sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $otp = (string) random_int(100000, 999999);

        $request->session()->put('pending_registration', [
            'data' => $validated,
            'email' => $validated['email'],
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10)->toDateTimeString(),
            'attempts' => 0,
        ]);

        try {
            $this->sendRegistrationOtp($validated['email'], $otp);
        } catch (Throwable $e) {
            Log::error('Gagal mengirim OTP registrasi.', [
                'email' => $validated['email'],
                'message' => $e->getMessage(),
            ]);

            $request->session()->forget('pending_registration');

            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', $this->mailFailureMessage($e));
        }

        return redirect()
            ->route('auth.register')
            ->with('success', 'Kode OTP sudah dikirim ke email Anda. Silakan masukkan kode untuk menyelesaikan registrasi.');
    }

    public function verifyRegistrationOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP harus diisi',
            'otp.digits' => 'Kode OTP harus 6 digit',
        ]);

        $pending = $request->session()->get('pending_registration');

        if (!$pending) {
            return redirect()
                ->route('auth.register')
                ->with('error', 'Sesi registrasi tidak ditemukan. Silakan daftar ulang.');
        }

        if (now()->greaterThan($pending['expires_at'])) {
            return redirect()
                ->route('auth.register')
                ->with('error', 'Kode OTP sudah kedaluwarsa. Kirim ulang OTP untuk melanjutkan.');
        }

        if (($pending['attempts'] ?? 0) >= 5) {
            $request->session()->forget('pending_registration');

            return redirect()
                ->route('auth.register')
                ->with('error', 'Terlalu banyak percobaan OTP. Silakan daftar ulang.');
        }

        if (!Hash::check($validated['otp'], $pending['otp_hash'])) {
            $pending['attempts'] = ($pending['attempts'] ?? 0) + 1;
            $request->session()->put('pending_registration', $pending);

            return back()->with('error', 'Kode OTP tidak sesuai.');
        }

        $userData = $pending['data'];
        $userData['kode_referral'] = $this->generateUniqueReferralCode();
        $userData['email_verified_at'] = now();

        User::create($userData);
        $request->session()->forget('pending_registration');

        return redirect()
            ->route('auth.login')
            ->with('success', 'Registrasi berhasil. Silakan login menggunakan email dan password.');
    }

    public function resendRegistrationOtp(Request $request)
    {
        $pending = $request->session()->get('pending_registration');

        if (!$pending) {
            return redirect()
                ->route('auth.register')
                ->with('error', 'Sesi registrasi tidak ditemukan. Silakan daftar ulang.');
        }

        $otp = (string) random_int(100000, 999999);
        $pending['otp_hash'] = Hash::make($otp);
        $pending['expires_at'] = now()->addMinutes(10)->toDateTimeString();
        $pending['attempts'] = 0;

        try {
            $this->sendRegistrationOtp($pending['email'], $otp);
        } catch (Throwable $e) {
            Log::error('Gagal mengirim ulang OTP registrasi.', [
                'email' => $pending['email'],
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', $this->mailFailureMessage($e, true));
        }

        $request->session()->put('pending_registration', $pending);

        return back()->with('success', 'Kode OTP baru sudah dikirim ke email Anda.');
    }

    public function changeRegistrationData(Request $request)
    {
        $pending = $request->session()->pull('pending_registration');

        if (!$pending) {
            return redirect()
                ->route('auth.register')
                ->with('error', 'Sesi registrasi tidak ditemukan. Silakan isi data registrasi kembali.');
        }

        return redirect()
            ->route('auth.register')
            ->withInput(collect($pending['data'])->except(['password', 'password_confirmation'])->all())
            ->with('success', 'Silakan perbaiki email atau data registrasi Anda. Password perlu diisi ulang.');
    }

    private function sendRegistrationOtp(string $email, string $otp): void
    {
        $password = (string) config('mail.mailers.smtp.password');

        if (config('mail.default') === 'smtp' && ($password === '' || $password === 'isi_app_password_gmail' || $password === 'app_password_gmail')) {
            throw new \RuntimeException('MAIL_PASSWORD belum diisi dengan Google App Password.');
        }

        Mail::raw(
            "Kode OTP registrasi Agent PMB Metamedia Anda adalah: {$otp}\n\nKode ini berlaku selama 10 menit. Abaikan email ini jika Anda tidak melakukan registrasi.",
            function ($message) use ($email) {
                $message->to($email)
                    ->subject('Kode OTP Registrasi Agent PMB Metamedia');
            }
        );
    }

    private function mailFailureMessage(Throwable $e, bool $resend = false): string
    {
        $prefix = $resend ? 'OTP gagal dikirim ulang.' : 'OTP gagal dikirim.';
        $message = $e->getMessage();

        if (str_contains($message, 'MAIL_PASSWORD belum diisi')) {
            return "{$prefix} MAIL_PASSWORD di .env masih placeholder. Isi dengan Google App Password 16 karakter.";
        }

        if (str_contains($message, 'Username and Password not accepted') || str_contains($message, 'Failed to authenticate')) {
            return "{$prefix} Email atau Google App Password SMTP tidak valid.";
        }

        if (str_contains($message, 'Connection could not be established')) {
            return "{$prefix} Aplikasi tidak bisa terhubung ke SMTP Gmail. Periksa internet, firewall, host, dan port SMTP.";
        }

        return "{$prefix} Periksa konfigurasi SMTP email aplikasi.";
    }

    /**
     * Generate unique referral code
     */
    private function generateUniqueReferralCode()
    {
        do {
            // Format: REF-XXXXXXXX (REF- prefix + 8 random alphanumeric)
            $code = 'REF-' . strtoupper(\Illuminate\Support\Str::random(8));
        } while (User::where('kode_referral', $code)->exists());
        
        return $code;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        $credentials = [
            'email' => $validated['email'],
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
            ->with('error', 'Email atau Password salah');
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
                ->intended(route('dashboard.admin'))
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
