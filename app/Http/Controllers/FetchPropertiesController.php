<?php

namespace App\Http\Controllers;

use Homeful\Properties\Models\Property;
use Illuminate\Http\Request;
use App\Data\FetchData;

class FetchPropertiesController extends Controller
{
    public function __invoke(Request $request): FetchData
    {
        $properties  = Property::all();

        return FetchData::from(compact('properties'));
    }
}
