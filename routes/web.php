<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('reserve',App\Livewire\ReserveProperty::class, )->name('reserve');
