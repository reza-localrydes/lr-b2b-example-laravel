<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleSearchController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehicles', function () {
    return view('vehicles');
});

// API Proxy to avoid CORS issues
Route::post('/api/search-vehicles', [VehicleSearchController::class, 'search']);
