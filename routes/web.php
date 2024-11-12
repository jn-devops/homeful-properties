<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('reserve',App\Livewire\ReserveProperty::class, )->name('reserve');

Route::get('update_property_status/{property_code}/{status}/{transaction_id}',\App\Http\Controllers\UpdatePropertyStatusController::class )
    ->name('update_property_status');
