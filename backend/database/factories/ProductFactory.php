<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => fake()->word(),
            'product_desc' => fake()->paragraph(),
            'product_price' => fake()->numberBetween(1, 1000),
            'product_image' => fake()->imageUrl(640, 400),
        ];
    }
}
