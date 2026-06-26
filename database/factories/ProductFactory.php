<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'store_id' => Store::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(100, 10000),
            'view_count' => 0,
            'unique_link' => Str::random(8),
            'is_active' => true,
        ];
    }
}