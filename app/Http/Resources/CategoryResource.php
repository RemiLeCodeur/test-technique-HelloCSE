<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Category;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin Category */
class CategoryResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_url' => Storage::disk(ImageStorageService::DISK)->url($this->image_path),
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],
            // Présent uniquement si la requête a chargé le compteur (withCount).
            'online_products_count' => $this->whenCounted('onlineProducts'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
