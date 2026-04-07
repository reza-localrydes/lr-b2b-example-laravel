<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VehicleSearchController extends Controller
{
    public function search(Request $request)
    {
        $apiUrl = env('LOCALRYDES_API_URL');
        $apiKey = env('LOCALRYDES_API_KEY');

        try {
            // For local development, disable SSL verification
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'x-api-key' => $apiKey,
                ])
                ->timeout(30)
                ->post($apiUrl . '/search-available-vehicles', $request->all());

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to connect to API: ' . $e->getMessage()
            ], 500);
        }
    }

    public function selectVehicle(Request $request)
    {
        $apiUrl = env('LOCALRYDES_API_URL');
        $apiKey = env('LOCALRYDES_API_KEY');

        // Validate request
        $validated = $request->validate([
            'booking_id' => 'required|string',
            'vehicle_id' => 'required|string',
        ]);

        try {
            // For local development, disable SSL verification
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'x-api-key' => $apiKey,
                ])
                ->timeout(30)
                ->post($apiUrl . '/booking/select-vehicle', [
                    'booking_id' => $validated['booking_id'],
                    'vehicle_id' => $validated['vehicle_id'],
                ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to select vehicle: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeReservation(Request $request)
    {
        $apiUrl = env('LOCALRYDES_API_URL');
        $apiKey = env('LOCALRYDES_API_KEY');

        // Validate request
        $validated = $request->validate([
            'booking_id' => 'required|string',
            'flight_number' => 'nullable|string',
            'passenger' => 'required|array',
            'passenger.full_name' => 'required|string',
            'passenger.email' => 'nullable|email',
            'passenger.mobile' => 'required|string',
        ]);

        try {
            // For local development, disable SSL verification
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'x-api-key' => $apiKey,
                ])
                ->timeout(30)
                ->post($apiUrl . '/booking/store-reservation', $validated);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store reservation: ' . $e->getMessage()
            ], 500);
        }
    }
}
