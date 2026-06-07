<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ProductData;
use App\Models\Product;

/** Logique métier des produits. */
class ProductService
{
    public function __construct(
        private readonly ImageStorageService $images,
    ) {}

    public function create(ProductData $data): Product
    {
        return Product::create([
            'name' => $data->name,
            'price' => $data->price,
            'status' => $data->status,
            'category_id' => $data->categoryId,
            'image_path' => $this->images->store($data->image, 'products'),
        ]);
    }

    public function update(Product $product, ProductData $data): Product
    {
        $attributes = [
            'name' => $data->name,
            'price' => $data->price,
            'status' => $data->status,
            'category_id' => $data->categoryId,
        ];

        // Image remplacée seulement si une nouvelle est fournie.
        if ($data->image !== null) {
            $attributes['image_path'] = $this->images->replace(
                $data->image,
                'products',
                $product->image_path,
            );
        }

        $product->update($attributes);

        return $product->refresh();
    }

    public function delete(Product $product): void
    {
        $imagePath = $product->image_path;

        $product->delete();

        $this->images->delete($imagePath);
    }
}
