<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id' => Seller::factory(),
            'category_id' => fake()->numberBetween(1, 6),
            'name' => fake()->word(),
            'photo_path' => fake()->imageUrl(),
            'description' => fake()->realText(),
            'price' => fake()->numberBetween(100, 100000),
            'stock' => fake()->numberBetween(10, 1000),
            'is_show' => 0,
            'created_at' =>fake()->dateTime(),
            'updated_at' =>fake()->dateTime(),
        ];
    }
}
