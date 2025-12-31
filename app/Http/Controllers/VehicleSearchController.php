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
}
