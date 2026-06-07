<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CategoryData;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

/** Logique métier des catégories. */
class CategoryService
{
    public function __construct(
        private readonly ImageStorageService $images,
    ) {}

    public function create(CategoryData $data): Category
    {
        return Category::create([
            'name' => $data->name,
            'status' => $data->status,
            'image_path' => $this->images->store($data->image, 'categories'),
        ]);
    }

    public function update(Category $category, CategoryData $data): Category
    {
        $attributes = [
            'name' => $data->name,
            'status' => $data->status,
        ];

        // Image remplacée seulement si une nouvelle est fournie.
        if ($data->image !== null) {
            $attributes['image_path'] = $this->images->replace(
                $data->image,
                'categories',
                $category->image_path,
            );
        }

        $category->update($attributes);

        return $category->refresh();
    }

    public function delete(Category $category): void
    {
        // La cascade SQL supprime les produits mais pas leurs fichiers :
        // on récupère les chemins avant suppression pour nettoyer le stockage.
        $productImagePaths = $category->products()->pluck('image_path');

        DB::transaction(fn () => $category->delete());

        $this->images->delete($category->image_path);

        foreach ($productImagePaths as $path) {
            $this->images->delete($path);
        }
    }
}
