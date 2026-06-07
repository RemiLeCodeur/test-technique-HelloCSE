<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CategoryStatus;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $image_path
 * @property CategoryStatus $status
 */
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'image_path',
        'status',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'status' => CategoryStatus::class,
        ];
    }

    /** @return HasMany<Product, $this> */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Produits en ligne — permet withCount('onlineProducts').
     *
     * @return HasMany<Product, $this>
     */
    public function onlineProducts(): HasMany
    {
        return $this->products()->where('status', ProductStatus::Online);
    }
}
