<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SpecialOfferApiController extends Controller
{
    /**
     * Fetch special offers from external API with pagination
     */
    public function index()
    {
        try {
            $lrApiUrl = env('LOCALRYDES_API_URL') . '/special-offers';

            // Build query parameters for pagination and filters
            $queryParams = [];

            // Pagination parameters
            if (request()->has('limit')) {
                $queryParams['limit'] = request()->input('limit', 20);
            }

            if (request()->has('skip')) {
                $queryParams['skip'] = request()->input('skip', 0);
            }

            // Filter parameters
            if (request()->has('search_key')) {
                $queryParams['search_key'] = request()->input('search_key');
            }

            if (request()->has('city_id')) {
                $queryParams['city_id'] = request()->input('city_id');
            }

            if (request()->has('vehicle_id')) {
                $queryParams['vehicle_id'] = request()->input('vehicle_id');
            }

            if (request()->has('partner_id')) {
                $queryParams['partner_id'] = request()->input('partner_id');
            }

            if (request()->has('category')) {
                $queryParams['category'] = request()->input('category');
            }

            Log::info('Fetching special offers from API: ' . $lrApiUrl, $queryParams);

            // Disable SSL verification for local development
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'x-api-key' => env('LOCALRYDES_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get($lrApiUrl, $queryParams);

            if ($response->successful()) {
                $responseData = $response->json();

                // The API returns data nested in: data.specialOffers
                $offers = $responseData['data']['specialOffers'] ?? [];

                Log::info('Successfully fetched ' . count($offers) . ' special offers');

                return response()->json([
                    'success' => true,
                    'specialOffers' => $offers,
                    'pagination' => [
                        'limit' => $queryParams['limit'] ?? 20,
                        'skip' => $queryParams['skip'] ?? 0,
                        'count' => count($offers)
                    ]
                ]);
            }

            Log::error('Special Offers API Error: ' . $response->status() . ' - ' . $response->body());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch special offers',
                'specialOffers' => []
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Special Offers API Exception: ' . $e->getMessage());
            throw $e;
        }
    }
}
