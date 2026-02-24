<?php

use App\Models\User;

it('intenta crear producto sin enviar datos y espera éxito (fallo esperado)', function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $response = $this->postJson('/api/products', []);
    // $response->assertStatus(201);
    $response->assertJsonStructure(['success','message','data' => ['product' => ['id','name','description','price']]]);
})->group('api');