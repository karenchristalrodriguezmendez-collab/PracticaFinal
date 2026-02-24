<?php

use App\Models\User;

dataset('invalidProductPayloads', [
    [['name' => '', 'description' => 'D', 'price' => 10]],
    [['name' => str_repeat('A', 101), 'description' => 'D', 'price' => 10]],
    [['name' => 'X', 'description' => '', 'price' => 10]],
    [['name' => 'X', 'description' => 'D', 'price' => 0]],
    [['name' => 'X', 'description' => 'D', 'price' => -1]],
]);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('rechaza payload inválido en creación', function ($payload) {
    $this->actingAs($this->user, 'sanctum');
    $response = $this->postJson('/api/products', $payload);
    $response->assertStatus(422);
})->with('invalidProductPayloads')->group('security');

it('rechaza payload inválido en actualización', function ($payload) {
    $this->actingAs($this->user, 'sanctum');
    $create = $this->postJson('/api/products', [
        'name' => 'OK', 'description' => 'D', 'price' => 10,
    ])->json('data.product.id');
    $response = $this->putJson('/api/products/'.$create, $payload);
    $response->assertStatus(422);
})->with('invalidProductPayloads')->group('security');