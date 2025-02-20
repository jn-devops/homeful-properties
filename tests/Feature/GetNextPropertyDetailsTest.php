<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Homeful\Properties\Data\{ProjectData, PropertyData};
use Homeful\Properties\Models\Property;
use Homeful\Products\Data\ProductData;

uses(RefreshDatabase::class, WithFaker::class);

test('get next property details has end point', function () {
    $property = Property::factory()->forProduct()->forProject()->create();
    $response = $this->get(route('next-property-details', ['product_code' => $property->sku]));
    expect($response->content())->toBeJson();
});
