<?php

use App\Http\Controllers\GetPropertyDetailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('property-details/{property_code}', GetPropertyDetailController::class)
    ->name('property-details');
