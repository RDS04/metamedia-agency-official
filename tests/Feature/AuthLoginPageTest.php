<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

test('halaman login internal menggunakan route login internal', function () {
    $response = $this->get(route('auth.login'));

    $response->assertOk();
    $response->assertSee('action="' . route('login.proses') . '"', false);
    $response->assertSee('href="' . route('auth.register') . '"', false);
    $response->assertDontSee('action="' . route('agent-luar.login.proses') . '"', false);
    $response->assertDontSee('action="' . route('agent-luar.register.store') . '"', false);
});
