<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('lista productos con paginación y búsqueda', function () {
    Product::create(['name' => 'Alpha','description' => 'A','price' => 10]);
    Product::create(['name' => 'Beta','description' => 'B','price' => 20]);
    $this->actingAs($this->user, 'sanctum');
    $response = $this->getJson('/api/products?search=Alpha&per_page=5');
    $response->assertOk();
    $response->assertJsonStructure(['success','data','pagination']);
});

it('crea producto vía API con y sin imagen', function () {
    $this->actingAs($this->user, 'sanctum');
    $create = $this->postJson('/api/products', [
        'name' => 'API X',
        'description' => 'Desc',
        'price' => 15.50,
    ]);
    $create->assertCreated();
    Storage::fake('public');
    $file = UploadedFile::fake()->image('pic.jpg');
    $createImg = $this->postJson('/api/products', [
        'name' => 'API Y',
        'description' => 'Desc',
        'price' => 99.99,
        'image' => $file,
    ]);
    $createImg->assertCreated();
});

it('muestra, actualiza y elimina producto', function () {
    $this->actingAs($this->user, 'sanctum');
    $product = Product::create(['name' => 'P','description' => 'D','price' => 5]);
    $show = $this->getJson('/api/products/'.$product->id);
    $show->assertOk()->assertJsonPath('data.product.id', $product->id);
    $update = $this->putJson('/api/products/'.$product->id, [
        'name' => 'P2','description' => 'D2','price' => 6.75
    ]);
    $update->assertOk();
    $product->refresh();
    expect($product->name)->toBe('P2');
    $delete = $this->deleteJson('/api/products/'.$product->id);
    $delete->assertOk();
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

it('sube y elimina imagen de producto', function () {
    Storage::fake('public');
    $this->actingAs($this->user, 'sanctum');
    $product = Product::create(['name' => 'PI','description' => 'D','price' => 7]);
    $file = UploadedFile::fake()->image('pic.jpg');
    $upload = $this->postJson('/api/products/'.$product->id.'/upload-image', [
        'image' => $file,
    ]);
    $upload->assertOk();
    $product->refresh();
    expect($product->image)->not()->toBeNull();
    Storage::disk('public')->assertExists($product->image);
    $del = $this->deleteJson('/api/products/'.$product->id.'/image');
    $del->assertOk();
    $product->refresh();
    expect($product->image)->toBeNull();
});

it('devuelve estadísticas', function () {
    $this->actingAs($this->user, 'sanctum');
    Product::create(['name' => 'S1','description' => 'D','price' => 1]);
    Product::create(['name' => 'S2','description' => 'D','price' => 2]);
    $response = $this->getJson('/api/products/statistics');
    $response->assertOk()->assertJsonStructure(['success','data' => ['total_products','average_price']]);
});