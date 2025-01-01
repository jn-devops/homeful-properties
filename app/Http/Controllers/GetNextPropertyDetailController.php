<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Actions\GetNextProperty;
use Illuminate\Http\Request;

class GetNextPropertyDetailController extends Controller
{
    public function __invoke(Request $request, string $product_code): \Illuminate\Http\JsonResponse
    {
        $property = app(GetNextProperty::class)->run($product_code);

        return (new PropertyResource($property))->response();
    }
}
