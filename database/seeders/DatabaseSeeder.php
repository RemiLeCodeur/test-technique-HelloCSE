<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Peuple la base avec un jeu de données de démonstration.
     */
    public function run(): void
    {
        $this->call([
            CatalogSeeder::class,
        ]);
    }
}
