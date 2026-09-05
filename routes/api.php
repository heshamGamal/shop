<?php

use App\Modules\Catalog\Presentation\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function (): void {
    // Products
    Route::get('/', [ProductController::class, 'index'])
        ->name('products.index');

    Route::post('/', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    Route::put('/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    Route::patch('/{product}', [ProductController::class, 'update'])
        ->name('products.update.patch');

    Route::delete('/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    // Product Variants
    Route::post('/{product}/variants', [ProductController::class, 'storeVariant'])
        ->name('products.variants.store');

    Route::put('/{product}/variants/{variant}', [ProductController::class, 'updateVariant'])
        ->name('products.variants.update');

    Route::patch('/{product}/variants/{variant}', [ProductController::class, 'updateVariant'])
        ->name('products.variants.update.patch');

    Route::delete('/{product}/variants/{variant}', [ProductController::class, 'destroyVariant'])
        ->name('products.variants.destroy');
});
