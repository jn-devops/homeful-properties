<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Homeful\Properties\Models\Property;
use App\Actions\UpdatePropertyStatus;
use App\Models\{Callback, Status};

uses(RefreshDatabase::class, WithFaker::class);

test('update property status works', function () {
    $status = Status::create(['code' => $this->faker->word(), 'description' => $this->faker->sentence()]);
    $property = Property::factory()->create(['status' => null]);
    expect($property->status)->toBeNull();
    UpdatePropertyStatus::run($property, $status);
    expect($property->status)->toBe($status->code);
});

test('update property end point', function () {
    $status = Status::create(['code' => $this->faker->word(), 'description' => $this->faker->sentence()]);
    $property = Property::factory()->create(['status' => null]);
    $callback = Callback::factory()->create();
    $transaction_id = $callback->transaction_id;
    expect($property->status)->toBeNull();
    $url = route('update_property_status', ['property_code' => $property->code, 'status' => $status->code, 'transaction_id' => $transaction_id]);
    $response = $this->get($url);
    expect($response->status())->toBe(302);
    $property->refresh();
    expect($property->status)->toBe($status->code);
});
