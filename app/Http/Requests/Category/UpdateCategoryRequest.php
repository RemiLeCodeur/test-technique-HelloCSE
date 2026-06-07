<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use App\DTOs\CategoryData;
use App\Enums\CategoryStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            // Image optionnelle à l'édition : si absente, on garde l'existante.
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'status' => ['required', Rule::enum(CategoryStatus::class)],
        ];
    }

    public function toData(): CategoryData
    {
        return new CategoryData(
            name: $this->validated('name'),
            status: $this->enum('status', CategoryStatus::class),
            image: $this->file('image'),
        );
    }
}
