<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('muestra listado y formulario de productos', function () {
    $this->get('/products')->assertStatus(200);
    $this->get('/productos')->assertStatus(200);
    $this->get('/productos/agregar')->assertStatus(200);
});

it('crea producto sin imagen', function () {
    $response = $this->post('/products', [
        'name' => 'Producto A',
        'price' => 123.45,
        'description' => 'Desc',
    ]);
    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', [
        'name' => 'Producto A',
        'price' => 123.45,
    ]);
});

it('crea producto con imagen y la almacena', function () {
    Storage::fake('public');
    $file = UploadedFile::fake()->image('foto.jpg', 200, 200);
    $response = $this->post('/products', [
        'name' => 'Producto B',
        'price' => 55.00,
        'description' => 'Desc',
        'image' => $file,
    ]);
    $response->assertRedirect(route('products.index'));
    $product = Product::where('name', 'Producto B')->first();
    expect($product)->not()->toBeNull();
    expect($product->image)->not()->toBeNull();
    Storage::disk('public')->assertExists($product->image);
});

it('edita y elimina producto con imagen', function () {
    Storage::fake('public');
    $file = UploadedFile::fake()->image('foto.jpg');
    $product = Product::create([
        'name' => 'Inicial',
        'price' => 10.00,
        'description' => 'X',
    ]);
    $upload = $this->post('/products', [
        'id' => $product->id,
        'name' => 'Actualizado',
        'price' => 20.00,
        'description' => 'Y',
        'image' => $file,
    ]);
    $upload->assertRedirect(route('products.index'));
    $product->refresh();
    expect($product->name)->toBe('Actualizado');
    if ($product->image) {
        Storage::disk('public')->assertExists($product->image);
    }
    $delete = $this->delete('/products/'.$product->id);
    $delete->assertRedirect(route('products.index'));
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

it('retorna datos para DataTables', function () {
    Product::create(['name' => 'A','description' => 'd','price' => 1]);
    Product::create(['name' => 'B','description' => 'd','price' => 2]);
    $response = $this->get('/products/data?draw=1&start=0&length=10');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'draw', 'recordsTotal', 'recordsFiltered', 'data',
    ]);
});

it('descarga imagen de producto', function () {
    Storage::fake('public');
    $file = UploadedFile::fake()->image('foto.jpg');
    $path = $file->store('products', 'public');
    $p = Product::create(['name' => 'C','price' => 3,'description' => 'z','image' => $path]);
    $response = $this->get('/products/'.$p->id.'/download-image');
    $response->assertStatus(200);
    $response->assertHeader('content-disposition');
});