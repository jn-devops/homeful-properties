<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Homeful\Products\Data\ProductData;
use Homeful\Products\Models\Product;
use App\Data\FetchData;

uses(RefreshDatabase::class, WithFaker::class);

test('fetch products is working', function () {
    $products = Product::factory(2)->create();
    $data = FetchData::from(compact('products'));
    expect($data->products)->toHaveCount(2);
    expect($data->products[0])->toBeInstanceOf(ProductData::class);
});

test('fetch products end point is working', function () {
    $products = Product::factory(2)->create();
    $response = $this->get(route('fetch-products'));
    expect($response->json('products'))->toHaveCount(2);
});

