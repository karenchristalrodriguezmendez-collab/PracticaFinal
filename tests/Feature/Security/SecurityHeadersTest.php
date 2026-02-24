<?php

use App\Models\User;

it('aplica cabeceras de seguridad en logout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->post('/logout');
    $response->assertHeader('X-Frame-Options', 'DENY');
    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('Referrer-Policy', 'no-referrer');
})->group('security');

it('aplica cabeceras en páginas autenticadas', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/home');
    $response->assertHeader('Cache-Control');
    $response->assertHeader('X-Frame-Options', 'DENY');
    $response->assertHeader('X-Content-Type-Options', 'nosniff');
})->group('security');

it('incluye token CSRF en formularios web', function () {
    $login = $this->get('/login');
    $login->assertSee('name="_token"', false);
    $register = $this->get('/register');
    $register->assertSee('name="_token"', false);
})->group('security');

it('no expone CORS abierto por defecto', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $this->assertFalse($response->headers->has('Access-Control-Allow-Origin'));
})->group('security');