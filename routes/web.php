<?php

use App\Http\Controllers\ModemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('modem/search', [ModemController::class, 'search'])->name('modem.search');
Route::resource('/modem', ModemController::class);
