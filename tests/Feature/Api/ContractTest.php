<?php

use App\Models\User;
use App\Models\Product;

it('contrato de /api/status', function () {
    $res = $this->getJson('/api/status');
    $res->assertOk()->assertJsonStructure([
        'success','message','timestamp','version'
    ]);
})->group('contract');

it('contrato de listado de productos', function () {
    Product::create(['name' => 'C1','description' => 'D','price' => 1]);
    $this->actingAs(User::factory()->create(), 'sanctum');
    $res = $this->getJson('/api/products?per_page=2');
    $res->assertOk()->assertJsonStructure([
        'success','data','pagination' => ['current_page','last_page','per_page','total']
    ]);
})->group('contract');

it('contrato de creación de producto', function () {
    $this->actingAs(User::factory()->create(), 'sanctum');
    $res = $this->postJson('/api/products', [
        'name' => 'X','description' => 'D','price' => 12.34,
    ]);
    $res->assertCreated()->assertJsonStructure([
        'success','message','data' => ['product' => ['id','name','description','price','has_image','created_at']]
    ]);
})->group('contract');

it('contrato de auth login', function () {
    $user = User::factory()->create(['email' => 'c@example.com']);
    $res = $this->postJson('/api/auth/login', [
        'email' => 'c@example.com', 'password' => 'password', 'device_name' => 'tests'
    ]);
    $res->assertOk()->assertJsonStructure([
        'success','message','data' => ['token','user' => ['id','name','email']]
    ]);
})->group('contract');