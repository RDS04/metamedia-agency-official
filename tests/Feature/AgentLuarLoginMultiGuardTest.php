<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

test('login agent umum menerima akun user internal dari tabel users', function () {
    Schema::dropIfExists('agent_luars');
    Schema::dropIfExists('admins');
    Schema::dropIfExists('users');

    Schema::create('users', function ($table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });

    Schema::create('admins', function ($table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });

    Schema::create('agent_luars', function ($table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->string('password');
        $table->boolean('is_active')->default(true);
        $table->rememberToken();
        $table->timestamps();
    });

    $user = User::create([
        'name' => 'Internal User',
        'email' => 'internal@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->post(route('agent-luar.login.proses'), [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user, 'web');
});
