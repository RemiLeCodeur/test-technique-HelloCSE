<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\ProductStatus;
use Illuminate\Http\UploadedFile;

/** Données de création / édition d'un produit, découplées du HTTP. */
final readonly class ProductData
{
    public function __construct(
        public string $name,
        public float $price,
        public ProductStatus $status,
        public int $categoryId,
        public ?UploadedFile $image = null,
    ) {}
}
