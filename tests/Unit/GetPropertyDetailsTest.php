<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Homeful\Properties\Data\{ProjectData, PropertyData};
use Homeful\Properties\Models\Property;
use Homeful\Products\Data\ProductData;

uses(RefreshDatabase::class, WithFaker::class);

test('property has data', function () {
    $property = Property::factory()->forProduct()->forProject()->create();
    $data = PropertyData::fromModel($property);
    expect($data)->toBeInstanceOf(PropertyData::class);
    expect($data->product)->toBeInstanceOf(ProductData::class);
    expect($data->project)->toBeInstanceOf(ProjectData::class);
});

test('get property details has end point', function () {
    $property = Property::factory()->forProduct()->forProject()->create();
    $data = PropertyData::fromModel($property);
    $response = $this->get(route('property-details', ['property_code' => $property->code]));
    expect($response->content())->toBeJson();
});
