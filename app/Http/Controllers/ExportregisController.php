<?php

namespace App\Http\Controllers;

use App\Exports\AgentTemplateExport;
use App\Imports\AgentImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ExportregisController extends Controller
{
    /**
     * Tampilkan halaman upload Excel registrasi agent.
     */
    public function index()
    {
        return view('auth.admin.dashboard.exportRegister');
    }

    /**
     * Preview data dari Excel sebelum dikonfirmasi.
     */
    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file.required' => 'File Excel harus diupload.',
            'file.mimes' => 'Format file harus .xlsx, .xls, atau .csv.',
            'file.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        try {
            $rows = Excel::toArray(new AgentImport(), $request->file('file'));
            $data = $rows[0] ?? [];

            if (empty($data)) {
                return back()->withErrors(['file' => 'File Excel kosong atau tidak valid.']);
            }

            // Normalisasi header & filter baris kosong
            $preview = collect($data)
                ->filter(fn($row) => !empty(array_filter(array_values($row))))
                ->map(function ($row) {
                    // Normalize keys to lowercase, strip spaces
                    $normalized = [];
                    foreach ($row as $key => $val) {
                        $normalized[strtolower(trim($key))] = $val;
                    }
                    return $normalized;
                })
                ->values()
                ->toArray();

            if (empty($preview)) {
                return back()->withErrors(['file' => 'Data di Excel tidak ditemukan atau semua baris kosong.']);
            }

            // Validasi baris — tandai mana yang valid / invalid
            $validStatuses = ['mahasiswa', 'alumni', 'orang_tua', 'dosen_karyawan', 'mitra'];

            $preview = array_map(function ($row) use ($validStatuses) {
                $errors = [];

                if (empty($row['name']))
                    $errors[] = 'Nama wajib diisi';
                if (empty($row['email'])) {
                    $errors[] = 'Email wajib diisi';
                } elseif (!filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Format email tidak valid';
                } elseif (User::where('email', $row['email'])->exists()) {
                    $errors[] = 'Email sudah terdaftar';
                }
                if (empty($row['phone'])) {
                    $errors[] = 'No. HP wajib diisi';
                } elseif (User::where('phone', $row['phone'])->exists()) {
                    $errors[] = 'No. HP sudah terdaftar';
                }
                if (empty($row['status'])) {
                    $errors[] = 'Status wajib diisi';
                } elseif (!in_array(strtolower(trim($row['status'])), $validStatuses)) {
                    $errors[] = 'Status tidak valid (gunakan: mahasiswa/alumni/orang_tua/dosen_karyawan/mitra)';
                }
                if (empty($row['password']))
                    $errors[] = 'Password wajib diisi';

                $row['_errors'] = $errors;
                $row['_valid'] = empty($errors);
                return $row;
            }, $preview);

            // Simpan ke session
            session(['export_register_data' => $preview]);

            return view('auth.admin.dashboard.exportRegister', [
                'preview' => $preview,
                'totalRows' => count($preview),
                'validRows' => count(array_filter($preview, fn($r) => $r['_valid'])),
                'invalidRows' => count(array_filter($preview, fn($r) => !$r['_valid'])),
            ]);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['file' => 'Gagal membaca file: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function confirm(Request $request)
    {
        $data = session('export_register_data');

        if (!$data) {
            return redirect()->route('exportregister.index')
                ->with('error', 'Sesi telah berakhir, silakan upload ulang file Excel.');
        }

        $berhasil = 0;
        $gagal = 0;

        foreach ($data as $row) {
            if (!$row['_valid']) {
                $gagal++;
                continue;
            }

            try {
                User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'status' => strtolower(trim($row['status'])),
                    'password' => Hash::make($row['password']),
                    'kode_referral' => $this->generateUniqueReferralCode(),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
                $berhasil++;
            } catch (\Exception $e) {
                $gagal++;
            }
        }

        session()->forget('export_register_data');

        $message = "{$berhasil} agent berhasil didaftarkan.";
        if ($gagal > 0) {
            $message .= " {$gagal} baris gagal atau dilewati.";
        }

        return redirect()->route('exportregister.index')
            ->with('success', $message);
    }

    /**
     * Download template Excel kosong untuk diisi.
     */
    public function downloadTemplate()
    {
        return Excel::download(
            new AgentTemplateExport(),
            'template_registrasi_agent.xlsx'
        );
    }

    /**
     * Generate unique referral code.
     */
    private function generateUniqueReferralCode(): string
    {
        do {
            $code = 'REF-' . strtoupper(Str::random(8));
        } while (User::where('kode_referral', $code)->exists());

        return $code;
    }

    /**
     * Daftarkan agent baru secara manual.
     */
    public function storeManual(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'status' => 'required|in:mahasiswa,alumni,orang_tua,dosen_karyawan,mitra',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor WhatsApp harus diisi',
            'phone.unique' => 'Nomor WhatsApp sudah terdaftar',
            'status.required' => 'Status harus dipilih',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'status' => $validated['status'],
                'password' => Hash::make($validated['password']),
                'kode_referral' => $this->generateUniqueReferralCode(),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            return redirect()
                ->route('exportregister.index')
                ->with('success', 'Agent baru berhasil didaftarkan secara manual.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Gagal mendaftarkan agent secara manual: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
