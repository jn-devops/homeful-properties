<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Homeful\Products\Data\ProductData;
use Homeful\Products\Models\Product;

uses(RefreshDatabase::class, WithFaker::class);

test('property has data', function () {
    $product = Product::factory()->create();
    $data = ProductData::fromModel($product);
    expect($data)->toBeInstanceOf(ProductData::class);
});

test('get product details has end point', function () {
    $product = Product::factory()->create();
    $response = $this->get(route('product-details', ['product_code' => $product->sku]));
    expect($response->content())->toBeJson();
});
