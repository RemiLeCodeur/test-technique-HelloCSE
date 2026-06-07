<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\CategoryStatus;
use Illuminate\Http\UploadedFile;

/** Données de création / édition d'une catégorie, découplées du HTTP. */
final readonly class CategoryData
{
    public function __construct(
        public string $name,
        public CategoryStatus $status,
        // Requise à la création, optionnelle à l'édition.
        public ?UploadedFile $image = null,
    ) {}
}
