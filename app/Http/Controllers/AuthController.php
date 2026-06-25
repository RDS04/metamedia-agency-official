<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Agent;
use App\Models\Komisi;
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
            "Halo,\n\n" .
            "Terima kasih telah melakukan pendaftaran Agent PMB Metamedia.\n\n" .
            "Kode OTP verifikasi Anda adalah:\n\n" .
            "OTP: {$otp}\n\n" .
            "Kode OTP ini berlaku selama 10 menit dan hanya dapat digunakan satu kali.\n\n" .
            "Pendaftaran Agent PMB:\n" .
            "https://musiindahlogistik.co.id/agent/\n\n" .
            "Pendaftaran Mahasiswa Metamedia:\n" .
            "https://spmb.metamedia.ac.id/\n\n" .
            "Jika Anda tidak merasa melakukan pendaftaran ini, silakan abaikan email ini.\n\n" .
            "Salam,\nTim PMB Metamedia",
            function ($message) use ($email) {
                $message->to($email)
                    ->subject('🔐 Kode OTP Verifikasi Agent PMB Metamedia');
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

        return "{$prefix} OTP Gagal Di Kirim Coba Lagi .";
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

        // Coba login sebagai Admin terlebih dahulu
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('dashboard.admin'))
                ->with('success', 'Selamat datang kembali, Admin!');
        }

        // Coba login sebagai User biasa
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
            ->route('auth.login')
            ->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function adminDashboard()
    {
        // 1. Metric Cards: Total Camaba counts across all prodis
        $totalProspek = Agent::where('status', 'Prospek')->count();
        $totalSudahDaftar = Agent::where('status', 'Sudah Daftar')->count();
        $totalRegistrasiUlang = Agent::where('status', 'Registrasi Ulang')->count();
        $totalCamaba = Agent::count();

        // 2. Calculate Bonus Berjalan across all agents
        $totalBonusBerjalan = 0;

        $komisiMao = Komisi::where('kategori', 'mao')->where('is_active', true)->first();
        $komisiDosen = Komisi::where('kategori', 'dosen_karyawan')->where('is_active', true)->first();
        $komisiMitra = Komisi::where('kategori', 'mitra')->where('is_active', true)->first();

        // Count of Registrasi Ulang grouped by agent_id
        $agentCounts = Agent::where('status', 'Registrasi Ulang')
            ->select('agent_id')
            ->selectRaw('count(*) as total')
            ->groupBy('agent_id')
            ->pluck('total', 'agent_id')
            ->all();

        $users = User::all();
        foreach ($users as $user) {
            $status = $user->status;
            $komisi = match ($status) {
                'dosen_karyawan' => $komisiDosen,
                'mitra' => $komisiMitra,
                default => $komisiMao,
            };

            if (!$komisi || $komisi->nominal_fleksibel) {
                continue;
            }

            $regCount = $agentCounts[$user->id] ?? 0;
            $bonusSummary = $komisi->hitungBonus($regCount);
            $totalBonusBerjalan += (int) ($bonusSummary['total_bonus'] ?? 0);
        }

        // 3. Agent statistics (Total, Active, Top 3 Agents)
        $totalAgent = User::count();
        $activeAgent = User::where('is_active', true)->count();

        // Top agents by registered Camaba count
        $topAgents = User::withCount([
            'camabas' => function ($q) {
                $q->where('status', 'Registrasi Ulang');
            }
        ])
            ->orderByDesc('camabas_count')
            ->take(3)
            ->get();

        // 4. Latest Camabas with their agents
        $camabaTerbaru = Agent::with('agent')->latest()->take(5)->get();

        // 5. Chart data for the last 6 months
        $chartStart = now()->startOfMonth()->subMonths(5);
        $camabaPerBulan = Agent::where('created_at', '>=', $chartStart)
            ->get()
            ->groupBy(fn($camaba) => $camaba->created_at->format('Y-m'));

        $chartLabels = [];
        $chartData = [];

        for ($i = 0; $i < 6; $i++) {
            $month = $chartStart->copy()->addMonths($i);
            $chartLabels[] = match ((int) $month->format('n')) {
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
            } . ' ' . $month->format('Y');
            $chartData[] = $camabaPerBulan->get($month->format('Y-m'), collect())->count();
        }

        return view('auth.admin.dashboard.dashboard', compact(
            'totalProspek',
            'totalSudahDaftar',
            'totalRegistrasiUlang',
            'totalCamaba',
            'totalBonusBerjalan',
            'totalAgent',
            'activeAgent',
            'topAgents',
            'camabaTerbaru',
            'chartLabels',
            'chartData'
        ));
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        $isAdmin = Admin::where('email', $validated['email'])->exists();
        $isUser = User::where('email', $validated['email'])->exists();

        if (!$isAdmin && !$isUser) {
            return back()->with('error', 'Email tidak terdaftar.')->withInput();
        }

        $otp = (string) random_int(100000, 999999);

        $request->session()->put('pending_password_reset', [
            'email' => $validated['email'],
            'role' => $isAdmin ? 'admin' : 'user',
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10)->toDateTimeString(),
            'attempts' => 0,
        ]);

        try {
            $this->sendPasswordResetOtp($validated['email'], $otp);
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim OTP reset password.', [
                'email' => $validated['email'],
                'message' => $e->getMessage(),
            ]);

            $request->session()->forget('pending_password_reset');

            return back()->with('error', $this->mailFailureMessage($e));
        }

        return back()->with('success', 'Kode OTP reset password telah dikirim ke email Anda. Silakan verifikasi untuk melanjutkan.');
    }

    private function sendPasswordResetOtp(string $email, string $otp): void
    {
        $password = (string) config('mail.mailers.smtp.password');

        if (config('mail.default') === 'smtp' && ($password === '' || $password === 'isi_app_password_gmail' || $password === 'app_password_gmail')) {
            throw new \RuntimeException('MAIL_PASSWORD belum diisi dengan Google App Password.');
        }

        Mail::raw(
            "Kode OTP Reset Password Anda adalah: {$otp}\n\nKode ini berlaku selama 10 menit. Abaikan email ini jika Anda tidak meminta reset password.",
            function ($message) use ($email) {
                $message->to($email)
                    ->subject('Kode OTP Reset Password');
            }
        );
    }

    public function verifyResetOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP harus diisi',
            'otp.digits' => 'Kode OTP harus 6 digit',
        ]);

        $pending = $request->session()->get('pending_password_reset');

        if (!$pending) {
            return redirect()
                ->route('password.request')
                ->with('error', 'Sesi reset password tidak ditemukan. Silakan masukkan email kembali.');
        }

        if (now()->greaterThan($pending['expires_at'])) {
            return redirect()
                ->route('password.request')
                ->with('error', 'Kode OTP sudah kedaluwarsa. Silakan masukkan email kembali.');
        }

        if (($pending['attempts'] ?? 0) >= 5) {
            $request->session()->forget('pending_password_reset');

            return redirect()
                ->route('password.request')
                ->with('error', 'Terlalu banyak percobaan OTP. Silakan mulai kembali.');
        }

        if (!Hash::check($validated['otp'], $pending['otp_hash'])) {
            $pending['attempts'] = ($pending['attempts'] ?? 0) + 1;
            $request->session()->put('pending_password_reset', $pending);

            return back()->with('error', 'Kode OTP tidak sesuai.');
        }

        $request->session()->put('password_reset_otp_verified', true);

        return back()->with('success', 'Kode OTP berhasil diverifikasi. Silakan masukkan password baru Anda.');
    }

    public function resendResetOtp(Request $request)
    {
        $pending = $request->session()->get('pending_password_reset');

        if (!$pending) {
            return redirect()
                ->route('password.request')
                ->with('error', 'Sesi reset password tidak ditemukan.');
        }

        $otp = (string) random_int(100000, 999999);
        $pending['otp_hash'] = Hash::make($otp);
        $pending['expires_at'] = now()->addMinutes(10)->toDateTimeString();
        $pending['attempts'] = 0;

        try {
            $this->sendPasswordResetOtp($pending['email'], $otp);
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim ulang OTP reset password.', [
                'email' => $pending['email'],
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', $this->mailFailureMessage($e, true));
        }

        $request->session()->put('pending_password_reset', $pending);

        return back()->with('success', 'Kode OTP baru sudah dikirim ke email Anda.');
    }

    public function cancelReset(Request $request)
    {
        $request->session()->forget(['pending_password_reset', 'password_reset_otp_verified']);
        return redirect()->route('password.request');
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if (!$request->session()->get('password_reset_otp_verified')) {
            return redirect()
                ->route('password.request')
                ->with('error', 'Akses tidak sah.');
        }

        $pending = $request->session()->get('pending_password_reset');

        if (!$pending) {
            return redirect()
                ->route('password.request')
                ->with('error', 'Sesi reset password tidak ditemukan.');
        }

        $hashedPassword = Hash::make($validated['password']);

        if ($pending['role'] === 'admin') {
            Admin::where('email', $pending['email'])->update(['password' => $hashedPassword]);
        } else {
            User::where('email', $pending['email'])->update(['password' => $hashedPassword]);
        }

        $request->session()->forget(['pending_password_reset', 'password_reset_otp_verified']);

        return redirect()
            ->route('auth.login')
            ->with('success', 'Password berhasil diubah. Silakan login menggunakan password baru.');
    }
}
