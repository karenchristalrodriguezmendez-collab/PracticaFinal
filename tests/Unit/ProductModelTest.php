<?php

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

it('hasImage retorna correctamente', function () {
    Storage::fake('public');
    $p = Product::create(['name' => 'T','description' => 'D','price' => 1]);
    expect($p->hasImage())->toBeFalse();
    $path = 'products/test.jpg';
    Storage::disk('public')->put($path, 'x');
    $p->image = $path;
    $p->save();
    expect($p->hasImage())->toBeTrue();
});

it('image_url devuelve URL pública cuando hay imagen', function () {
    Storage::fake('public');
    $path = 'products/p.jpg';
    Storage::disk('public')->put($path, 'x');
    $p = Product::create(['name' => 'T2','description' => 'D','price' => 2,'image' => $path]);
    expect($p->image_url)->not()->toBeNull();
});