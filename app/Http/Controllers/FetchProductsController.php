<?php

namespace App\Http\Controllers;

use Homeful\Products\Models\Product;
use Illuminate\Http\Request;
use App\Data\FetchData;

class FetchProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $products = Product::all();

        return FetchData::from(compact('products'));
    }
}
