<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class IndexProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            // Filtre optionnel : ?category_id=1
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
        ];
    }

    /** Identifiant de catégorie à filtrer, ou null. */
    public function categoryId(): ?int
    {
        $value = $this->validated('category_id');

        return $value !== null ? (int) $value : null;
    }
}
