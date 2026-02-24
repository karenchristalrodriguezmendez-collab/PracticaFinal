<?php

use App\Models\User;

it('exige rol admin para listar productos', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $res = $this->getJson('/api/products');
    $res->assertStatus(403);
    $res->assertHeader('Content-Type', 'application/json');
    $res->assertJsonStructure(['success','message','error']);
})->group('security');

it('exige rol admin para crear productos', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $res = $this->postJson('/api/products', [
        'name' => 'X', 'description' => 'D', 'price' => 1
    ]);
    $res->assertStatus(403);
    $res->assertHeader('Content-Type', 'application/json');
    $res->assertJsonStructure(['success','message','error']);
})->group('security');