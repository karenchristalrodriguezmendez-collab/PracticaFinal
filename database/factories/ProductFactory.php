<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'stock' => $this->faker->numberBetween(0, 100),
            'category' => $this->faker->randomElement(['Aceites Esenciales', 'Cuidado Facial', 'Corporal', 'Capilar', 'Tónicos']),
            'ingredients' => $this->faker->words(5, true),
            'is_organic' => $this->faker->boolean(40),
            'image' => null,
        ];
    }
}
