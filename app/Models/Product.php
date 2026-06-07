<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $image_path
 * @property ProductStatus $status
 * @property int $category_id
 */
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image_path',
        'status',
        'category_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'status' => ProductStatus::class,
        ];
    }

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Filtre optionnel par catégorie (endpoint de liste).
     *
     * @param  Builder<Product>  $query
     * @return Builder<Product>
     */
    public function scopeForCategory(Builder $query, ?int $categoryId): Builder
    {
        return $query->when(
            $categoryId !== null,
            fn (Builder $q): Builder => $q->where('category_id', $categoryId),
        );
    }
}
