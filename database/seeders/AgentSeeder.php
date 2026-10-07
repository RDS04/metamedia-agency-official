<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AgentLuar;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Admin Account
        Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Administrator PMB',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Seed Sample Agent Internal Accounts (User model)
        $agentsInternal = [
            [
                'name'          => 'Agam (Agent Mahasiswa)',
                'email'         => 'agam@gmail.com',
                'phone'         => '081234567890',
                'status'        => 'mahasiswa',
                'password'      => Hash::make('password123'),
                'kode_referral' => 'REF-AGAM1234',
                'is_active'     => true,
                'email_verified_at' => now(),
            ],
            [
                'name'          => 'Budi Santoso (Agent Dosen/Karyawan)',
                'email'         => 'budi.dosen@gmail.com',
                'phone'         => '081234567891',
                'status'        => 'dosen_karyawan',
                'password'      => Hash::make('password123'),
                'kode_referral' => 'REF-BUDI1234',
                'is_active'     => true,
                'email_verified_at' => now(),
            ],
            [
                'name'          => 'Siti Rahma (Agent Alumni)',
                'email'         => 'siti.alumni@gmail.com',
                'phone'         => '081234567892',
                'status'        => 'alumni',
                'password'      => Hash::make('password123'),
                'kode_referral' => 'REF-SITI1234',
                'is_active'     => true,
                'email_verified_at' => now(),
            ],
            [
                'name'          => 'PT Mitra Edukasi (Agent Mitra)',
                'email'         => 'mitra.edukasi@gmail.com',
                'phone'         => '081234567893',
                'status'        => 'mitra',
                'password'      => Hash::make('password123'),
                'kode_referral' => 'REF-MITRA123',
                'is_active'     => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($agentsInternal as $agentData) {
            User::updateOrCreate(
                ['email' => $agentData['email']],
                $agentData
            );
        }

        // Ambil Agent Internal Agam sebagai referensi
        $agentAgam = User::where('email', 'agam@gmail.com')->first();

        if ($agentAgam) {
            // 3. Seed Sample Agent Luar / Umum Account
            AgentLuar::updateOrCreate(
                ['email' => 'agentumum@gmail.com'],
                [
                    'name'                  => 'Rian Pratama (Agent Umum)',
                    'phone'                 => '085712345678',
                    'password'              => Hash::make('password123'),
                    'kode_referral_dipakai' => $agentAgam->kode_referral,
                    'agent_internal_id'    => $agentAgam->id,
                    'kode_referral'         => 'REF-RIAN5678',
                    'is_active'             => true,
                    'email_verified_at'     => now(),
                ]
            );
        }
    }
}
