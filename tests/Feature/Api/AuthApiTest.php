<?php

use App\Models\User;

it('registra usuario vía API', function () {
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Armando',
        'email' => 'armando@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
    $response->assertCreated();
    $response->assertJsonStructure(['success','message','data' => ['user' => ['id','name','email'],'token']]);
    $this->assertDatabaseHas('users', ['email' => 'armando@example.com']);
});

it('hace login y obtiene token', function () {
    $user = User::factory()->create(['email' => 'login@example.com']);
    $response = $this->postJson('/api/auth/login', [
        'email' => 'login@example.com',
        'password' => 'password',
        'device_name' => 'tests',
    ]);
    $response->assertOk();
    $response->assertJsonStructure(['success','data' => ['token','user' => ['id','email']]]);
});

it('falla login con credenciales inválidas', function () {
    $user = User::factory()->create(['email' => 'bad@example.com']);
    $response = $this->postJson('/api/auth/login', [
        'email' => 'bad@example.com',
        'password' => 'wrong',
        'device_name' => 'tests',
    ]);
    $response->assertStatus(422);
});

it('obtiene perfil con token de Sanctum', function () {
    $user = User::factory()->create();
    $token = $user->createToken('tests')->plainTextToken;
    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/auth/me');
    $response->assertOk()->assertJsonPath('data.user.id', $user->id);
});

it('cierra sesión (revoca token actual)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('tests')->plainTextToken;
    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/auth/logout');
    $response->assertOk()->assertJsonPath('data.token_revoked', true);
});

it('cierra sesión en todos los dispositivos', function () {
    $user = User::factory()->create();
    $token = $user->createToken('t1')->plainTextToken;
    $user->createToken('t2');
    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/auth/logout-all');
    $response->assertOk();
});

it('lista y revoca tokens', function () {
    $user = User::factory()->create();
    $token = $user->createToken('tests')->plainTextToken;
    $list = $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/auth/tokens');
    $list->assertOk()->assertJsonStructure(['data' => ['tokens']]);
    $tokenId = $list->json('data.tokens.0.id');
    $revoke = $this->withHeader('Authorization', 'Bearer '.$token)
        ->deleteJson('/api/auth/tokens', ['token_id' => $tokenId]);
    $revoke->assertOk();
});