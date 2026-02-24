<?php

use App\Models\User;

it('muestra la página de inicio', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

it('muestra el formulario de login', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

it('muestra el formulario de registro', function () {
    $response = $this->get('/register');
    $response->assertStatus(200);
});

it('permite cerrar sesión y aplica cabeceras de seguridad', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->post('/logout');
    $response->assertRedirect('/');
    $response->assertHeader('Clear-Site-Data');
    $response->assertHeader('Cache-Control');
    $response->assertHeader('X-Logout-Method', 'POST');
});