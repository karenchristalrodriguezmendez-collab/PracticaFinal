<?php

it('registro de usuario sin datos requeridos retorna JSON con 422', function () {
    $response = $this->postJson('/api/auth/register', []);
    $response->assertStatus(422);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJsonStructure(['success','message','errors']);
})->group('api');

it('creación de producto sin datos requeridos retorna JSON con 422', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $response = $this->postJson('/api/products', []);
    $response->assertStatus(422);
    $response->assertHeader('Content-Type', 'application/json');
    $response->assertJsonStructure(['success','message','errors']);
})->group('api');