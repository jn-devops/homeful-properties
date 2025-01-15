<?php

use App\Http\Controllers\{GetNextPropertyDetailController, GetProductDetailController, GetPropertyDetailController};
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('property-details/{property_code}', GetPropertyDetailController::class)
    ->name('property-details');

Route::get('product-details/{product_code}', GetProductDetailController::class)
    ->name('product-details');

Route::get('next-property-details/{product_code}', GetNextPropertyDetailController::class)
    ->name('next-property-details');

