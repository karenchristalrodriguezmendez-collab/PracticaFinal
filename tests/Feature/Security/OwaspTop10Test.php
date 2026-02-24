<?php

use App\Models\User;

it('requiere autenticación en API productos', function () {
    $res = $this->getJson('/api/products');
    $res->assertStatus(401);
    $res->assertHeader('Content-Type', 'application/json');
})->group('owasp');

it('aplica HSTS en contexto https', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $res = $this->withServerVariables(['HTTPS' => 'on'])->get('/home');
    $res->assertHeader('Strict-Transport-Security');
})->group('owasp');

it('resiste inyección en búsqueda de productos', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $q = "' OR 1=1 --";
    $res = $this->getJson('/api/products?search='.$q);
    $res->assertOk();
    $res->assertHeader('Content-Type', 'application/json');
})->group('owasp');

it('no permite CORS abierto', function () {
    $res = $this->get('/');
    $this->assertFalse($res->headers->has('Access-Control-Allow-Origin'));
})->group('owasp');

it('aplica rate limiting en status', function () {
    $fails = 0;
    for ($i = 0; $i < 120; $i++) {
        $r = $this->getJson('/api/status');
        if ($r->getStatusCode() === 429) {
            $fails++;
            break;
        }
    }
    expect($fails)->toBeGreaterThan(0);
})->group('owasp');

it('requiere rol admin para acceder a API productos', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $res = $this->getJson('/api/products');
    $res->assertStatus(403);
})->group('owasp');