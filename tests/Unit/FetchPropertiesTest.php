<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

use Homeful\Properties\Data\{ProjectData, PropertyData};
use Homeful\Properties\Models\Property;
use Homeful\Products\Data\ProductData;
use App\Data\FetchData;

uses(RefreshDatabase::class, WithFaker::class);

test('fetch properties is working', function () {
    $properties = Property::factory(2)->forProduct()->forProject()->create();
    $data = FetchData::from(compact('properties'));
    expect($data->properties)->toHaveCount(2);
    expect($data->properties[0])->toBeInstanceOf(PropertyData::class);
    expect($data->properties[0]->product)->toBeInstanceOf(ProductData::class);
    expect($data->properties[0]->project)->toBeInstanceOf(ProjectData::class);
})->skip();

test('fetch properties end point is working', function () {
    $properties = Property::factory(3)->forProduct()->forProject()->create();
    $response = $this->get(route('fetch-products'));
    expect($response->json())->toHaveCount(2);
})->skip();

