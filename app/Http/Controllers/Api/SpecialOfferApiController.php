<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

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

    /**
     * Fetch a single special offer by slug/UUID
     */
    public function show($slug)
    {
        try {
            $lrApiUrl = env('LOCALRYDES_API_URL') . '/special-offers/' . $slug;

            Log::info('Fetching special offer details from API: ' . $lrApiUrl);

            // Disable SSL verification for local development
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'x-api-key' => env('LOCALRYDES_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get($lrApiUrl);

            if ($response->successful()) {
                $responseData = $response->json();

                // The API might return data nested differently for single offer
                $offer = $responseData['data']['specialOffer'] ?? $responseData['data'] ?? null;

                if ($offer) {
                    Log::info('Successfully fetched special offer: ' . ($offer['title'] ?? 'Unknown'));

                    return response()->json([
                        'success' => true,
                        'specialOffer' => $offer
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Special offer not found'
                ], 404);
            }

            Log::error('Special Offer API Error: ' . $response->status() . ' - ' . $response->body());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch special offer'
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Special Offer API Exception: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the special offer'
            ], 500);
        }
    }

    /**
     * Add special offer to cart (create reservation)
     */
    public function addToCart(Request $request)
    {
        try {
            // Validate incoming request
            $validated = $request->validate([
                'special_offer_id' => 'required|integer',
                'pickup_date' => 'required|date',
                'pickup_time' => 'required|string',
                'drop_off_date' => 'required|date',
                'pickup_location' => 'required|string',
                'drop_off_location' => 'required|string',
                'additional_note' => 'nullable|string',
                'customer_name' => 'required|string',
                'customer_email' => 'required|email',
                'customer_phone' => 'required|string',
                'passengers' => 'nullable|integer'
            ]);

            $lrApiUrl = env('LOCALRYDES_API_URL') . '/special-offers/add-to-cart';

            Log::info('Adding special offer to cart via API: ' . $lrApiUrl, $validated);

            // Prepare payload for external API with passenger object
            $payload = [
                'special_offer_id' => $validated['special_offer_id'],
                'pickup_date' => $validated['pickup_date'],
                'pickup_time' => $validated['pickup_time'],
                'drop_off_date' => $validated['drop_off_date'],
                'pickup_location' => $validated['pickup_location'],
                'drop_off_location' => $validated['drop_off_location'],
                'additional_note' => $validated['additional_note'] ?? '',
                'passenger' => [
                    'full_name' => $validated['customer_name'],
                    'email' => $validated['customer_email'],
                    'mobile' => $validated['customer_phone']
                ]
            ];

            Log::info('Sending payload to external API:', $payload);

            // Call external API
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'x-api-key' => env('LOCALRYDES_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post($lrApiUrl, $payload);

            if ($response->successful()) {
                $responseData = $response->json();

                Log::info('Successfully added special offer to cart', $responseData);

                // Extract reservation data
                $reservation = $responseData['data']['reservation'] ?? null;

                if ($reservation) {
                    // Store customer information in session or database if needed
                    session([
                        'last_reservation' => [
                            'uuid' => $reservation['uuid'] ?? null,
                            'customer_name' => $validated['customer_name'],
                            'customer_email' => $validated['customer_email'],
                            'customer_phone' => $validated['customer_phone'],
                            'passengers' => $validated['passengers'] ?? 1,
                        ]
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Special offer added to cart successfully',
                        'reservation' => $reservation
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Request processed',
                    'data' => $responseData
                ]);
            }

            Log::error('Add to Cart API Error: ' . $response->status() . ' - ' . $response->body());

            return response()->json([
                'success' => false,
                'message' => 'Failed to add special offer to cart',
                'error' => $response->json()
            ], $response->status());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Add to Cart Exception: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reservation details by UUID
     */
    public function getReservation($uuid)
    {
        try {
            $lrApiUrl = env('LOCALRYDES_API_URL') . '/external/reservations/' . $uuid;

            Log::info('Fetching reservation details from API: ' . $lrApiUrl);

            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'x-api-key' => env('LOCALRYDES_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get($lrApiUrl);

            if ($response->successful()) {
                $responseData = $response->json();

                return response()->json([
                    'success' => true,
                    'reservation' => $responseData['data'] ?? $responseData
                ]);
            }

            Log::error('Reservation API Error: ' . $response->status() . ' - ' . $response->body());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch reservation details'
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Reservation API Exception: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching reservation'
            ], 500);
        }
    }
}
