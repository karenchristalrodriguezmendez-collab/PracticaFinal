<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Tónico Facial',
                'description' => 'Hecho de agua mineral y hierbas medicinales.',
                'price' => 1.06,
                'stock' => 50,
                'category' => 'Cremas naturales',
                'ingredients' => 'Agua mineral, hierbas medicinales',
                'is_organic' => true,
                'image' => 'products/tonico.jpg'
            ],
            [
                'name' => 'Crema Hidratante',
                'description' => 'Crema de arroz hidratante con antioxidantes.',
                'price' => 35.00,
                'stock' => 100,
                'category' => 'Cremas naturales',
                'ingredients' => 'Arroz, antioxidantes',
                'is_organic' => true,
                'image' => 'products/crema.jpg'
            ],
            [
                'name' => 'Labial Hidratante',
                'description' => 'Bálsamo hidratante para labios irritados.',
                'price' => 35.00,
                'stock' => 45,
                'category' => 'Bálsamos labiales',
                'ingredients' => 'Aceite de coco, manteca de cacao',
                'is_organic' => false,
                'image' => 'products/labial.jpg'
            ],
            [
                'name' => 'Jabón de Lavanda',
                'description' => 'Jabón artesanal con flores de lavanda.',
                'price' => 12.50,
                'stock' => 30,
                'category' => 'Jabones artesanales',
                'ingredients' => 'Lavanda, aceites vegetales',
                'is_organic' => true,
                'image' => 'products/jabon.jpg'
            ],
            [
                'name' => 'Mascarilla de Arcilla',
                'description' => 'Mascarilla en polvo para limpieza profunda.',
                'price' => 15.00,
                'stock' => 20,
                'category' => 'Mascarillas en polvo',
                'ingredients' => 'Arcilla verde, aceites esenciales',
                'is_organic' => true,
                'image' => 'products/mascarilla.jpg'
            ],
            [
                'name' => 'Cepillo de Bambú',
                'description' => 'Cepillo dental de bambú biodegradable.',
                'price' => 4.50,
                'stock' => 150,
                'category' => 'Accesorios y empaques eco',
                'ingredients' => 'Bambú, nylon biodegradable',
                'is_organic' => true,
                'image' => 'products/cepillo.jpg'
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
