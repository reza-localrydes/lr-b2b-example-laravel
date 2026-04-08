<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleSearchController;
use App\Http\Controllers\Api\SpecialOfferApiController;

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

// Special Offers Pages
Route::get('/special-offers', function () {
    return view('special-offers');
})->name('special.offers');

Route::get('/special-offer/{slug}', function ($slug) {
    return view('special-offer-detail', ['slug' => $slug]);
});

// Special Offer Reservation Success Page
Route::get('/special-offer/reservation/success/{uuid}', function ($uuid) {
    return view('special-offer-success', ['uuid' => $uuid]);
});

// API Proxy to avoid CORS issues
Route::post('/api/search-vehicles', [VehicleSearchController::class, 'search']);
Route::post('/api/select-vehicle', [VehicleSearchController::class, 'selectVehicle']);
Route::post('/api/store-reservation', [VehicleSearchController::class, 'storeReservation']);

// Special Offers API Proxy
Route::get('/api/special-offers', [SpecialOfferApiController::class, 'index']);
Route::get('/api/special-offers/{slug}', [SpecialOfferApiController::class, 'show']);
Route::post('/api/special-offers/add-to-cart', [SpecialOfferApiController::class, 'addToCart']);
Route::get('/api/reservations/{uuid}', [SpecialOfferApiController::class, 'getReservation']);
