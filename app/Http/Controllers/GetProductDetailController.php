<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Homeful\Products\Models\Product;
use Illuminate\Http\Request;

class GetProductDetailController extends Controller
{
    public function __invoke(Request $request, string $product_code): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('sku', $product_code)->firstOrFail();

        return (new ProductResource($product))->response();
    }
}
