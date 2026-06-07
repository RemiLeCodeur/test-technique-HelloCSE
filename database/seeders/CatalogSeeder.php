<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CategoryStatus;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

/** Catalogue de démo : catégories en ligne avec des produits de statuts variés. */
class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()
            ->online()
            ->count(5)
            ->has(Product::factory()->count(8))
            ->create();

        Category::factory()->state(['status' => CategoryStatus::Disabled])->create();
        Category::factory()->state(['status' => CategoryStatus::Archived])->create();
    }
}
