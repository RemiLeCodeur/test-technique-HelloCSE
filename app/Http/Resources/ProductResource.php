<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin Product */
class ProductResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // Stocké en decimal (exact) ; exposé en nombre pour le client.
            'price' => (float) $this->price,
            'image_url' => Storage::disk(ImageStorageService::DISK)->url($this->image_path),
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],
            'category_id' => $this->category_id,
            // Catégorie imbriquée seulement si elle a été chargée (with('category')).
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
