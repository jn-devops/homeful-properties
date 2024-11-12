<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use App\Models\Callback;

uses(RefreshDatabase::class, WithFaker::class);

test('callback has attributes', function () {
    $callback = Callback::factory()->create();
    expect($callback->transaction_id)->toBeString();
    expect($callback->url)->toBeString();
});
