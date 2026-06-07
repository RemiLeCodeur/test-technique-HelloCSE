<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use App\DTOs\ProductData;
use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            // Image optionnelle à l'édition : si absente, on garde l'existante.
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'status' => ['required', Rule::enum(ProductStatus::class)],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    public function toData(): ProductData
    {
        return new ProductData(
            name: $this->validated('name'),
            price: (float) $this->validated('price'),
            status: $this->enum('status', ProductStatus::class),
            categoryId: (int) $this->validated('category_id'),
            image: $this->file('image'),
        );
    }
}
