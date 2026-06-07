<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Product> */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => ucfirst(fake()->words(3, true)),
            'price' => fake()->randomFloat(2, 1, 999),
            'image_path' => 'products/placeholder.jpg',
            'status' => fake()->randomElement(ProductStatus::cases()),
            'category_id' => Category::factory(),
        ];
    }

    public function online(): static
    {
        return $this->state(fn (): array => ['status' => ProductStatus::Online]);
    }
}
