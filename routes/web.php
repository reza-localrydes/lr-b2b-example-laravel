<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleSearchController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehicles', function () {
    return view('vehicles');
});

// Vehicle search results page
Route::get('/search/availavael-vehicles/{bookingId}', function ($bookingId) {
    return view('vehicle-results', ['bookingId' => $bookingId]);
});

// Booking details page
Route::get('/booking/details/{bookingId}', function ($bookingId) {
    return view('booking-details', ['bookingId' => $bookingId]);
});

// Booking success page
Route::get('/booking/success/{reservationUuid}', function ($reservationUuid) {
    return view('booking-success', ['reservationUuid' => $reservationUuid]);
});

// API Proxy to avoid CORS issues
Route::post('/api/search-vehicles', [VehicleSearchController::class, 'search']);
Route::post('/api/select-vehicle', [VehicleSearchController::class, 'selectVehicle']);
Route::post('/api/store-reservation', [VehicleSearchController::class, 'storeReservation']);
