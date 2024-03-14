<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'category_id' => mt_rand(1,10),
            'photo' => 'assets/images/heroimg.jpg',
            'name' => fake()->unique()->words(mt_rand(1,5),true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2),
            'stock' => 0
        ];
    }
}
