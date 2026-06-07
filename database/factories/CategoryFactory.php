<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CategoryStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Category> */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => ucfirst(fake()->unique()->words(2, true)),
            'image_path' => 'categories/placeholder.jpg',
            'status' => fake()->randomElement(CategoryStatus::cases()),
        ];
    }

    public function online(): static
    {
        return $this->state(fn (): array => ['status' => CategoryStatus::Online]);
    }
}
