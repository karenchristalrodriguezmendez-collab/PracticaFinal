<?php

use App\Models\User;

it('requiere autenticación para /home', function () {
    $response = $this->get('/home');
    $response->assertRedirect('/login');
});

it('muestra /home para usuario autenticado y aplica cabeceras', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/home');
    $response->assertStatus(200);
    $response->assertHeader('Cache-Control');
    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('X-Frame-Options', 'DENY');
});