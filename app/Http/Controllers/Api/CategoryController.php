<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $service,
    ) {}

    /** Liste des catégories, avec le nombre de produits en ligne par catégorie. */
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->withCount('onlineProducts')
            ->paginate(15);

        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->service->create($request->toData());

        return CategoryResource::make($category)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /** Détail d'une catégorie, avec son nombre de produits en ligne. */
    public function show(Category $category): CategoryResource
    {
        return CategoryResource::make($category->loadCount('onlineProducts'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $category = $this->service->update($category, $request->toData());

        return CategoryResource::make($category->loadCount('onlineProducts'));
    }

    public function destroy(Category $category): Response
    {
        $this->service->delete($category);

        return response()->noContent();
    }
}
