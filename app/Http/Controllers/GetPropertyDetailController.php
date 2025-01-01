<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use Homeful\Properties\Models\Property;
use Illuminate\Http\Request;

class GetPropertyDetailController extends Controller
{
    public function __invoke(Request $request, string $property_code): \Illuminate\Http\JsonResponse
    {
        $property = Property::where('code', $property_code)->firstOrFail();

        return (new PropertyResource($property))->response();
    }
}
