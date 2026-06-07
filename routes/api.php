<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// apiResource génère les 5 routes REST (index, store, show, update, destroy)
// préfixées par /api (configuré dans bootstrap/app.php).
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
