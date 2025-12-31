# LocalRydes B2B API Integration Guide

Welcome to the LocalRydes B2B API integration guide. This documentation will help you integrate our vehicle search and booking system into your website or application.

## Table of Contents

- [Getting Started](#getting-started)
- [Authentication](#authentication)
- [API Endpoints](#api-endpoints)
- [Integration Examples](#integration-examples)
- [Error Handling](#error-handling)
- [Rate Limits](#rate-limits)
- [Support](#support)

---

## Getting Started

### Base URL

```
Production: https://your-domain.com/api/v2/external
Development: https://lr.local/api/v2/external
```

### Prerequisites

Before you begin, you'll need:
- An active agency account with LocalRydes
- API credentials (API Key)
- Basic knowledge of REST APIs
- HTTPS support on your website

### Quick Start

1. **Obtain API Credentials**: Contact LocalRydes support to get your API key
2. **Test Authentication**: Verify your API key using the validation endpoint
3. **Search Vehicles**: Make your first vehicle search request
4. **Display Results**: Show available vehicles on your website

---

## Authentication

All API requests must include your API key in the request headers.

### API Key Authentication

Include your API key in the `x-api-key` header:

```http
x-api-key: lr_live_YOUR_API_KEY_HERE
```

### Validate Your API Key

**Endpoint:** `GET /auth/validate-key`

**Request:**
```bash
curl --location 'https://your-domain.com/api/v2/external/auth/validate-key' \
--header 'x-api-key: lr_live_YOUR_API_KEY_HERE'
```

**Response:**
```json
{
  "status": "success",
  "statusCode": 200,
  "message": "API key validated successfully",
  "data": {
    "agency_id": 123,
    "company_name": "Your Agency Name",
    "status": "active",
    "api_key_name": "Production Key",
    "commission_rate": 15.00,
    "rate_limit": {
      "per_minute": 60,
      "per_day": 10000,
      "remaining_today": 9850
    },
    "key_info": {
      "created_at": "2025-01-01T00:00:00+00:00",
      "last_used_at": "2025-12-31T10:30:00+00:00",
      "is_active": true
    }
  }
}
```

---

## API Endpoints

### 1. Search Available Vehicles

Search for available vehicles based on trip details.

**Endpoint:** `POST /search-available-vehicles`

**Headers:**
```http
Content-Type: application/json
x-api-key: lr_live_YOUR_API_KEY_HERE
```

**Request Body:**
```json
{
  "trip_booking_type": "transfer",
  "pick_up_location": {
    "id": "ChIJvY9HupHGVTcR7BXrcRP3s9E",
    "google_place_id": "ChIJvY9HupHGVTcR7BXrcRP3s9E",
    "name": "Airport - Dakshinkhan Rd, Dhaka 1229, Bangladesh",
    "lat": "23.8434344",
    "lng": "90.4029252",
    "address": "Airport - Dakshinkhan Rd, Dhaka 1229, Bangladesh",
    "isFavorite": "0",
    "type": "1",
    "note": "",
    "types": []
  },
  "drop_off_location": {
    "id": "ChIJKZ-5WkUX_zkR29gWNCGKmZI",
    "google_place_id": "ChIJKZ-5WkUX_zkR29gWNCGKmZI",
    "name": "55G6+V74, Airport Bypass Rd, Jashore 7400, Bangladesh",
    "lat": "23.1771288",
    "lng": "89.16071740000001",
    "address": "55G6+V74, Airport Bypass Rd, Jashore 7400, Bangladesh",
    "isFavorite": "0",
    "type": "3",
    "note": "",
    "types": []
  },
  "itineraries": [],
  "pickup_date": "2025/11/27",
  "pickup_time": "06:07",
  "passengers": "2",
  "bags": "1",
  "booking_hour": null
}
```

**Request Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `trip_booking_type` | string | Yes | Type of booking: `transfer` or `hourly` |
| `pick_up_location` | object | Yes | Pickup location details |
| `drop_off_location` | object | Conditional | Required for `transfer` type |
| `itineraries` | array | No | Waypoints/stops between pickup and dropoff |
| `pickup_date` | string | Yes | Pickup date (YYYY/MM/DD format) |
| `pickup_time` | string | Yes | Pickup time (HH:MM format) |
| `passengers` | string/int | Yes | Number of passengers (1-50) |
| `bags` | string/int | Yes | Number of bags (0-50) |
| `booking_hour` | int | No | Hours for hourly bookings (2-24) |

**Location Object Structure:**
```json
{
  "id": "unique_id",
  "google_place_id": "Google Place ID",
  "name": "Full address",
  "lat": "latitude",
  "lng": "longitude",
  "address": "Full address",
  "isFavorite": "0",
  "type": "1",
  "note": "",
  "types": []
}
```

**Response:**
```json
{
  "success": true,
  "statusCode": 200,
  "message": "Search request processed successfully",
  "data": {
    "bookingId": "9d4f8a3c-1e2b-4c5d-8f9a-7b6c5d4e3f2a",
    "availableVehicles": [
      {
        "id": 123,
        "vehicle": {
          "id": 123,
          "name": "Mercedes-Benz E-Class",
          "class": "luxury",
          "passenger": 4,
          "bag": 3,
          "images": [
            "https://your-domain.com/storage/vehicles/vehicle-123-1.jpg",
            "https://your-domain.com/storage/vehicles/vehicle-123-2.jpg"
          ],
          "features": ["WiFi", "Climate Control", "Leather Seats"],
          "partner": {
            "company_name": "Premium Transport Ltd",
            "rating": 4.8,
            "city": "Dhaka"
          }
        },
        "sourcePriceCurrency": {
          "iso_code": "BDT",
          "symbol": "৳",
          "name": "Bangladeshi Taka"
        },
        "price": 5500.00,
        "priceBeforeDiscount": 6000.00,
        "partnerDiscountPercentage": 8.33,
        "convertedPrice": 5500.00,
        "convertedPriceBeforeDiscount": 6000.00,
        "isDiscount": 1,
        "customerCanBook": 1
      }
    ],
    "requestedRawData": {}
  }
}
```

**Response Fields:**

| Field | Type | Description |
|-------|------|-------------|
| `bookingId` | string | Unique booking identifier (use for vehicle selection) |
| `availableVehicles` | array | List of available vehicles |
| `vehicle.id` | int | Vehicle ID |
| `vehicle.name` | string | Vehicle name/model |
| `vehicle.class` | string | Vehicle class (economy, luxury, etc.) |
| `vehicle.passenger` | int | Maximum passengers |
| `vehicle.bag` | int | Maximum bags |
| `price` | float | Price in source currency |
| `convertedPrice` | float | Price in your currency |
| `priceBeforeDiscount` | float | Original price before discounts |
| `partnerDiscountPercentage` | float | Total discount percentage |
| `isDiscount` | int | 1 if discount applied, 0 otherwise |
| `customerCanBook` | int | 1 if bookable, 0 otherwise |

### 2. Get API Key Information

Get details about your current API key usage and limits.

**Endpoint:** `GET /partner/api-keys/current`

**Request:**
```bash
curl --location 'https://your-domain.com/api/v2/external/partner/api-keys/current' \
--header 'x-api-key: lr_live_YOUR_API_KEY_HERE'
```

**Response:**
```json
{
  "status": "success",
  "data": {
    "key_id": 1,
    "key_name": "Production API Key",
    "key_preview": "lr_live_ZPKS...3M4K",
    "status": "active",
    "created_at": "2025-01-01T00:00:00+00:00",
    "last_used_at": "2025-12-31T10:30:00+00:00",
    "usage_stats": {
      "total_requests": 15000,
      "requests_today": 150,
      "requests_this_month": 4500
    }
  }
}
```

---

## Integration Examples

### JavaScript/Fetch Example

```javascript
async function searchVehicles(searchParams) {
  const apiKey = 'lr_live_YOUR_API_KEY_HERE';
  const apiUrl = 'https://your-domain.com/api/v2/external/search-available-vehicles';

  const requestData = {
    trip_booking_type: 'transfer',
    pick_up_location: {
      google_place_id: searchParams.pickupPlaceId,
      name: searchParams.pickupAddress,
      lat: searchParams.pickupLat,
      lng: searchParams.pickupLng,
      address: searchParams.pickupAddress
    },
    drop_off_location: {
      google_place_id: searchParams.dropoffPlaceId,
      name: searchParams.dropoffAddress,
      lat: searchParams.dropoffLat,
      lng: searchParams.dropoffLng,
      address: searchParams.dropoffAddress
    },
    itineraries: [],
    pickup_date: searchParams.pickupDate, // Format: "2025/11/27"
    pickup_time: searchParams.pickupTime, // Format: "06:07"
    passengers: searchParams.passengers,
    bags: searchParams.bags,
    booking_hour: null
  };

  try {
    const response = await fetch(apiUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'x-api-key': apiKey
      },
      body: JSON.stringify(requestData)
    });

    const data = await response.json();

    if (data.success) {
      return {
        bookingId: data.data.bookingId,
        vehicles: data.data.availableVehicles
      };
    } else {
      throw new Error(data.message || 'Search failed');
    }
  } catch (error) {
    console.error('Error searching vehicles:', error);
    throw error;
  }
}

// Display vehicles in your UI
function displayVehicles(vehicles) {
  const container = document.getElementById('vehicles-container');

  vehicles.forEach(vehicleData => {
    const vehicle = vehicleData.vehicle;
    const vehicleCard = `
      <div class="vehicle-card">
        <img src="${vehicle.images[0]}" alt="${vehicle.name}">
        <h3>${vehicle.name}</h3>
        <p>Capacity: ${vehicle.passenger} passengers, ${vehicle.bag} bags</p>
        <p>Partner: ${vehicle.partner.company_name}</p>
        <p>Rating: ${vehicle.partner.rating} ⭐</p>
        ${vehicleData.isDiscount ?
          `<p class="original-price">
            ${vehicleData.sourcePriceCurrency.symbol}${vehicleData.priceBeforeDiscount}
          </p>` : ''}
        <p class="price">
          ${vehicleData.sourcePriceCurrency.symbol}${vehicleData.convertedPrice}
        </p>
        ${vehicleData.isDiscount ?
          `<span class="discount-badge">${vehicleData.partnerDiscountPercentage}% OFF</span>` : ''}
        <button onclick="selectVehicle(${vehicle.id})"
                ${vehicleData.customerCanBook ? '' : 'disabled'}>
          ${vehicleData.customerCanBook ? 'Book Now' : 'Not Available'}
        </button>
      </div>
    `;
    container.innerHTML += vehicleCard;
  });
}

// Usage example
const searchParams = {
  pickupPlaceId: 'ChIJvY9HupHGVTcR7BXrcRP3s9E',
  pickupAddress: 'Airport - Dakshinkhan Rd, Dhaka 1229, Bangladesh',
  pickupLat: '23.8434344',
  pickupLng: '90.4029252',
  dropoffPlaceId: 'ChIJKZ-5WkUX_zkR29gWNCGKmZI',
  dropoffAddress: '55G6+V74, Airport Bypass Rd, Jashore 7400, Bangladesh',
  dropoffLat: '23.1771288',
  dropoffLng: '89.16071740000001',
  pickupDate: '2025/11/27',
  pickupTime: '06:07',
  passengers: 2,
  bags: 1
};

searchVehicles(searchParams)
  .then(result => {
    console.log('Booking ID:', result.bookingId);
    displayVehicles(result.vehicles);
  })
  .catch(error => {
    console.error('Search failed:', error);
    alert('Failed to search vehicles. Please try again.');
  });
```

### PHP/cURL Example

```php
<?php

function searchVehicles($searchParams) {
    $apiKey = 'lr_live_YOUR_API_KEY_HERE';
    $apiUrl = 'https://your-domain.com/api/v2/external/search-available-vehicles';

    $requestData = [
        'trip_booking_type' => 'transfer',
        'pick_up_location' => [
            'google_place_id' => $searchParams['pickupPlaceId'],
            'name' => $searchParams['pickupAddress'],
            'lat' => $searchParams['pickupLat'],
            'lng' => $searchParams['pickupLng'],
            'address' => $searchParams['pickupAddress']
        ],
        'drop_off_location' => [
            'google_place_id' => $searchParams['dropoffPlaceId'],
            'name' => $searchParams['dropoffAddress'],
            'lat' => $searchParams['dropoffLat'],
            'lng' => $searchParams['dropoffLng'],
            'address' => $searchParams['dropoffAddress']
        ],
        'itineraries' => [],
        'pickup_date' => $searchParams['pickupDate'],
        'pickup_time' => $searchParams['pickupTime'],
        'passengers' => $searchParams['passengers'],
        'bags' => $searchParams['bags'],
        'booking_hour' => null
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'x-api-key: ' . $apiKey
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if ($data['success']) {
            return $data['data'];
        }
    }

    throw new Exception('Failed to search vehicles');
}

// Usage
try {
    $searchParams = [
        'pickupPlaceId' => 'ChIJvY9HupHGVTcR7BXrcRP3s9E',
        'pickupAddress' => 'Airport - Dakshinkhan Rd, Dhaka 1229, Bangladesh',
        'pickupLat' => '23.8434344',
        'pickupLng' => '90.4029252',
        'dropoffPlaceId' => 'ChIJKZ-5WkUX_zkR29gWNCGKmZI',
        'dropoffAddress' => '55G6+V74, Airport Bypass Rd, Jashore 7400, Bangladesh',
        'dropoffLat' => '23.1771288',
        'dropoffLng' => '89.16071740000001',
        'pickupDate' => '2025/11/27',
        'pickupTime' => '06:07',
        'passengers' => 2,
        'bags' => 1
    ];

    $result = searchVehicles($searchParams);
    $bookingId = $result['bookingId'];
    $vehicles = $result['availableVehicles'];

    // Display vehicles in your template
    foreach ($vehicles as $vehicleData) {
        $vehicle = $vehicleData['vehicle'];
        echo "<div class='vehicle-card'>";
        echo "<h3>{$vehicle['name']}</h3>";
        echo "<p>Price: {$vehicleData['sourcePriceCurrency']['symbol']}{$vehicleData['convertedPrice']}</p>";
        echo "</div>";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Python Example

```python
import requests
import json

def search_vehicles(search_params):
    api_key = 'lr_live_YOUR_API_KEY_HERE'
    api_url = 'https://your-domain.com/api/v2/external/search-available-vehicles'

    headers = {
        'Content-Type': 'application/json',
        'x-api-key': api_key
    }

    request_data = {
        'trip_booking_type': 'transfer',
        'pick_up_location': {
            'google_place_id': search_params['pickupPlaceId'],
            'name': search_params['pickupAddress'],
            'lat': search_params['pickupLat'],
            'lng': search_params['pickupLng'],
            'address': search_params['pickupAddress']
        },
        'drop_off_location': {
            'google_place_id': search_params['dropoffPlaceId'],
            'name': search_params['dropoffAddress'],
            'lat': search_params['dropoffLat'],
            'lng': search_params['dropoffLng'],
            'address': search_params['dropoffAddress']
        },
        'itineraries': [],
        'pickup_date': search_params['pickupDate'],
        'pickup_time': search_params['pickupTime'],
        'passengers': str(search_params['passengers']),
        'bags': str(search_params['bags']),
        'booking_hour': None
    }

    response = requests.post(api_url, headers=headers, json=request_data)

    if response.status_code == 200:
        data = response.json()
        if data.get('success'):
            return data['data']

    raise Exception(f'Failed to search vehicles: {response.text}')

# Usage
search_params = {
    'pickupPlaceId': 'ChIJvY9HupHGVTcR7BXrcRP3s9E',
    'pickupAddress': 'Airport - Dakshinkhan Rd, Dhaka 1229, Bangladesh',
    'pickupLat': '23.8434344',
    'pickupLng': '90.4029252',
    'dropoffPlaceId': 'ChIJKZ-5WkUX_zkR29gWNCGKmZI',
    'dropoffAddress': '55G6+V74, Airport Bypass Rd, Jashore 7400, Bangladesh',
    'dropoffLat': '23.1771288',
    'dropoffLng': '89.16071740000001',
    'pickupDate': '2025/11/27',
    'pickupTime': '06:07',
    'passengers': 2,
    'bags': 1
}

try:
    result = search_vehicles(search_params)
    booking_id = result['bookingId']
    vehicles = result['availableVehicles']

    print(f"Booking ID: {booking_id}")
    print(f"Found {len(vehicles)} vehicles")

    for vehicle_data in vehicles:
        vehicle = vehicle_data['vehicle']
        print(f"{vehicle['name']}: {vehicle_data['sourcePriceCurrency']['symbol']}{vehicle_data['convertedPrice']}")

except Exception as e:
    print(f"Error: {e}")
```

---

## Error Handling

### Error Response Format

All error responses follow this structure:

```json
{
  "success": false,
  "statusCode": 400,
  "message": "Error description",
  "errors": [
    {
      "errorCode": 1001,
      "errorField": "pickup_date",
      "errorMessage": "Pickup date is required"
    }
  ]
}
```

### Common Error Codes

| HTTP Status | Error Code | Description | Solution |
|-------------|-----------|-------------|----------|
| 401 | AUTH_INVALID | Invalid or missing API key | Check your API key |
| 403 | AUTH_EXPIRED | API key expired | Contact support to renew |
| 404 | AGENCY_NOT_FOUND | Agency not found | Verify your account status |
| 422 | VALIDATION_ERROR | Request validation failed | Check request parameters |
| 429 | RATE_LIMIT_EXCEEDED | Too many requests | Wait and retry |
| 500 | SERVER_ERROR | Internal server error | Contact support |

### Validation Errors

Common validation errors and how to fix them:

**Pickup Time Error:**
```json
{
  "success": false,
  "statusCode": 400,
  "message": "Pickup time must be at least 12 hours in advance from the current time."
}
```
**Solution:** Ensure pickup date/time is at least 12 hours in the future.

**Missing Required Fields:**
```json
{
  "success": false,
  "statusCode": 422,
  "message": "Validation errors",
  "errors": [
    {
      "errorCode": 1001,
      "errorField": "trip_booking_type",
      "errorMessage": "Booking type is required"
    }
  ]
}
```
**Solution:** Include all required fields in your request.

---

## Rate Limits

### Default Limits

- **Per Minute:** 60 requests
- **Per Day:** 10,000 requests

### Rate Limit Headers

Monitor your rate limit usage through response headers:

```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1672531200
```

### Handling Rate Limits

When you exceed the rate limit, you'll receive a 429 response:

```json
{
  "success": false,
  "statusCode": 429,
  "message": "Rate limit exceeded. Please try again later.",
  "retry_after": 60
}
```

**Best Practices:**
- Implement exponential backoff for retries
- Cache search results when possible
- Monitor your usage via the API key info endpoint
- Contact support if you need higher limits

---

## Best Practices

### 1. Location Data

Always use Google Places API to get accurate location data:
- Include `google_place_id` for better accuracy
- Provide latitude and longitude coordinates
- Use full address strings

### 2. Date and Time Formatting

- **Date Format:** `YYYY/MM/DD` (e.g., "2025/11/27")
- **Time Format:** `HH:MM` 24-hour format (e.g., "06:07")
- **Timezone:** Use the local timezone of the pickup location
- **Advance Booking:** Minimum 12 hours before pickup time

### 3. Error Handling

```javascript
async function searchWithRetry(params, maxRetries = 3) {
  for (let i = 0; i < maxRetries; i++) {
    try {
      return await searchVehicles(params);
    } catch (error) {
      if (error.statusCode === 429 && i < maxRetries - 1) {
        // Rate limit exceeded, wait and retry
        await new Promise(resolve => setTimeout(resolve, 2000 * (i + 1)));
        continue;
      }
      throw error;
    }
  }
}
```

### 4. Caching

Cache search results to reduce API calls:

```javascript
const cache = new Map();
const CACHE_TTL = 5 * 60 * 1000; // 5 minutes

function getCacheKey(params) {
  return JSON.stringify(params);
}

async function searchVehiclesWithCache(params) {
  const key = getCacheKey(params);
  const cached = cache.get(key);

  if (cached && Date.now() - cached.timestamp < CACHE_TTL) {
    return cached.data;
  }

  const data = await searchVehicles(params);
  cache.set(key, { data, timestamp: Date.now() });

  return data;
}
```

### 5. Security

- **Never expose your API key** in client-side code
- Use server-side proxy to make API calls
- Implement request signing for additional security
- Rotate API keys periodically

### 6. User Experience

- Show loading states during searches
- Display clear error messages to users
- Implement search filters (price range, vehicle type, etc.)
- Allow users to sort results by price, rating, etc.

---

## Testing

### Test Credentials

For testing purposes, use the development environment:

```
Base URL: https://lr.local/api/v2/external
Test API Key: lr_test_YOUR_TEST_KEY_HERE
```

### Test Locations

Use these test locations for development:

**Dhaka Airport:**
```json
{
  "google_place_id": "ChIJvY9HupHGVTcR7BXrcRP3s9E",
  "name": "Hazrat Shahjalal International Airport",
  "lat": "23.8434344",
  "lng": "90.4029252"
}
```

**Dhaka City Center:**
```json
{
  "google_place_id": "ChIJgWr6f4C4VTcRbmFFbAPkDp0",
  "name": "Gulshan, Dhaka",
  "lat": "23.7808",
  "lng": "90.4156"
}
```

---

## Support

### Contact Information

- **Email:** api-support@localrydes.com
- **Documentation:** https://docs.localrydes.com
- **Status Page:** https://status.localrydes.com

### Getting Help

When contacting support, please include:
- Your agency ID
- API key preview (first/last 4 characters)
- Request/response examples
- Error messages
- Timestamp of the issue

### Frequently Asked Questions

**Q: How do I get an API key?**
A: Contact our sales team to set up an agency account. Once approved, you'll receive your API credentials.

**Q: Can I test the API before going live?**
A: Yes, we provide a sandbox environment for testing. Request test credentials from support.

**Q: What currencies are supported?**
A: We support multiple currencies. The pricing is returned in the partner's local currency and can be converted to your preferred currency.

**Q: How are commissions handled?**
A: Commission rates are configured in your agency account. You'll earn commission on each completed booking.

**Q: Can I customize the vehicle display?**
A: Yes, the API returns all necessary vehicle data. You have full control over how to display it on your website.

---

## Changelog

### Version 2.0 (2025-12-31)
- Added B2B API support
- Implemented agency-based authentication
- Added vehicle search with pricing
- Support for transfer and hourly bookings
- Real-time availability checking

---

## Terms of Service

By using the LocalRydes API, you agree to our [Terms of Service](https://localrydes.com/terms) and [Privacy Policy](https://localrydes.com/privacy).

### Key Points:
- Use the API only for legitimate booking purposes
- Do not abuse rate limits
- Protect your API credentials
- Comply with data protection regulations
- Provide accurate customer information

---

**Thank you for choosing LocalRydes!** 🚗

For the latest updates and announcements, follow us on social media or subscribe to our developer newsletter.
