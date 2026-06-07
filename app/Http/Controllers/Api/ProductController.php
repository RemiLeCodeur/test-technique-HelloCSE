<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\IndexProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service,
    ) {}

    /** Liste des produits, filtrable par catégorie (?category_id=1). */
    public function index(IndexProductRequest $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->with('category')
            ->forCategory($request->categoryId())
            ->paginate(15);

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->create($request->toData());

        return ProductResource::make($product->load('category'))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product->load('category'));
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $product = $this->service->update($product, $request->toData());

        return ProductResource::make($product->load('category'));
    }

    public function destroy(Product $product): Response
    {
        $this->service->delete($product);

        return response()->noContent();
    }
}
