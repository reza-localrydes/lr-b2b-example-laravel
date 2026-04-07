# Special Offers Implementation Plan
**LocalRydes B2B Laravel Application**

## 📑 Table of Contents
1. [Overview](#overview)
2. [API Integration](#api-integration)
3. [Phase 1: Home Page Section](#phase-1-home-page-section)
4. [Phase 2: Navigation Menu](#phase-2-navigation-menu)
5. [Phase 3: Special Offers Listing Page](#phase-3-special-offers-listing-page)
6. [Phase 4: Special Offer Detail Page](#phase-4-special-offer-detail-page)
7. [Phase 5: Backend Implementation](#phase-5-backend-implementation)
8. [Phase 6: Styling](#phase-6-styling)
9. [Testing Checklist](#testing-checklist)
10. [File Structure](#file-structure)

---

## Overview

### Goal
Create a complete Special Offers feature that allows users to browse and book premium transportation packages, event-based services, and multi-day tours.

### Key Features
- Display 8 featured special offers on home page (2 rows × 4 cards)
- Dedicated listing page with filtering and pagination
- Detailed offer page with booking functionality
- Integration with existing LocalRydes API
- Responsive design matching current site aesthetic

### Reference Examples
- **Image #1**: Special Offers listing page (localrydes.com/special-offers)
- **Image #2**: Special Offer detail page with booking form

---

## API Integration

### Base Configuration
```
Endpoint: https://lr.local/api/v2/external/special-offers
Method: GET
Authentication: x-api-key header
API Key: api_dev_ORyMTjb2I8mPBycdcZi3WYJogciH0LoTWd4bcO30BKFGXTn2rt6WUIwB4mZU
```

### Response Structure
```json
{
  "specialOffers": [
    {
      "id": 146,
      "uuid": "dd59b392-5c34-4d3e-9022-76a94cd0cc1a",
      "title": "Tour package for Austria – Switzerland – France 50-Seater",
      "slug": "tour-package-for-austria-switzerland-france-50-seater",
      "shortDescription": "...",
      "sourceCurrency": { "isoCode": "EUR", "symbol": "€" },
      "price": 12500,
      "discount": 10,
      "discountType": "percentage",
      "startDate": "2026-02-26",
      "endDate": "2026-04-27",
      "city": { "id": 3, "name": "Vienna" },
      "country": "AT",
      "vehicle": { ... },
      "thumbnail": "https://...",
      "images": ["https://...", "..."],
      "maxBookingLimit": 100,
      "maxPassengerLimit": 50,
      "durationUnit": "daily",
      "duration": 9,
      "contents": [
        {
          "title": "Overview",
          "description": "...",
          "icon": "bi-file-earmark-text"
        }
      ],
      "specialOfferCategory": {
        "id": 11,
        "title": "Package",
        "slug": "package"
      }
    }
  ]
}
```

### Key Fields
- **Title**: Offer name
- **Slug**: URL-friendly identifier
- **Price + Discount**: Calculate final price
- **StartDate/EndDate**: Display availability period
- **City + Country**: Location information
- **Vehicle**: Vehicle details (class, capacity)
- **Thumbnail/Images**: Visual assets
- **Contents**: Expandable sections (Overview, Itinerary, Policy, etc.)
- **Category**: Package type (Package, Event Package, Round Trip, etc.)

---

## Phase 1: Home Page Section

### Location
Insert after pricing section, before contact section in `resources/views/welcome.blade.php`

### Design Specifications
```html
<section class="special-offers-section" id="special-offers">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Exclusive Special Offers</h2>
            <p class="text-muted">Premium packages and event experiences</p>
        </div>
        <div class="row g-4">
            <!-- 8 cards in 2 rows (4 per row) -->
        </div>
        <div class="text-center mt-5">
            <a href="/special-offers" class="btn btn-view-all">View All Offers</a>
        </div>
    </div>
</section>
```

### Card Structure
Each card should include:
- **Thumbnail Image**: 100% width, 240px height, object-fit: cover
- **Category Badge**: Positioned top-left (absolute)
- **Date Range Badge**: If applicable (Event Packages)
- **Title**: 2-line max with ellipsis
- **Location**: City + Country flag/icon
- **Price Display**:
  - Original price (strikethrough if discount)
  - Final price (prominent)
  - "From" label
- **Duration**: "X Days" or "X Hours"
- **Vehicle Info**: Icon + capacity
- **CTA Button**: "View Details"

### JavaScript Functionality
```javascript
async function fetchSpecialOffers() {
    const response = await fetch('/api/special-offers-proxy', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
    const data = await response.json();
    renderOfferCards(data.specialOffers.slice(0, 8)); // Show first 8
}
```

---

## Phase 2: Navigation Menu

### Update Navigation Bar
File: `resources/views/welcome.blade.php` (lines 24-40)

Add new menu item:
```html
<li class="nav-item">
    <a class="nav-link" href="#special-offers">Special Offers</a>
</li>
```

Position: Between "Pricing" and "Contact"

### Styling
- Maintain existing nav link styles
- Add hover underline animation
- Active state for current page

---

## Phase 3: Special Offers Listing Page

### Route
```php
// routes/web.php
Route::get('/special-offers', [SpecialOfferController::class, 'index'])->name('special-offers.index');
```

### View: `resources/views/special-offers/index.blade.php`

#### Page Structure
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Same head as welcome.blade.php -->
</head>
<body>
    <!-- Navigation Bar (same as home) -->

    <!-- Hero Section -->
    <section class="special-offers-hero">
        <div class="container">
            <h1>Special Offers</h1>
            <p>Discover exclusive transportation packages and experiences</p>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="filters-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <select id="categoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        <option value="package">Package</option>
                        <option value="event-package">Event Package</option>
                        <option value="round-trip">Round Trip</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="cityFilter" class="form-select">
                        <option value="">All Cities</option>
                        <!-- Populated dynamically -->
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="priceFilter" class="form-select">
                        <option value="">All Prices</option>
                        <option value="0-1000">€0 - €1,000</option>
                        <option value="1000-5000">€1,000 - €5,000</option>
                        <option value="5000+">€5,000+</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search offers...">
                </div>
            </div>
        </div>
    </section>

    <!-- Offers Grid -->
    <section class="offers-grid-section">
        <div class="container">
            <div id="offersGrid" class="row g-4">
                <!-- Cards populated via JavaScript -->
            </div>

            <!-- Pagination -->
            <div class="pagination-container mt-5">
                <!-- Pagination controls -->
            </div>
        </div>
    </section>

    <!-- Footer (same as home) -->
</body>
</html>
```

#### Filtering Logic
```javascript
let allOffers = [];
let filteredOffers = [];

function applyFilters() {
    const category = document.getElementById('categoryFilter').value;
    const city = document.getElementById('cityFilter').value;
    const priceRange = document.getElementById('priceFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();

    filteredOffers = allOffers.filter(offer => {
        // Category filter
        if (category && offer.specialOfferCategory.slug !== category) return false;

        // City filter
        if (city && offer.city.name !== city) return false;

        // Price filter
        const finalPrice = calculateFinalPrice(offer.price, offer.discount, offer.discountType);
        if (priceRange) {
            const [min, max] = priceRange.split('-');
            if (max === undefined) { // "5000+"
                if (finalPrice < parseInt(min)) return false;
            } else {
                if (finalPrice < parseInt(min) || finalPrice > parseInt(max)) return false;
            }
        }

        // Search filter
        if (searchTerm && !offer.title.toLowerCase().includes(searchTerm)) return false;

        return true;
    });

    renderOffers(filteredOffers);
}
```

#### Pagination
- Display 12 offers per page
- Show page numbers (1, 2, 3... Last)
- Previous/Next buttons
- Update URL with page parameter: `/special-offers?page=2`

---

## Phase 4: Special Offer Detail Page

### Route
```php
// routes/web.php
Route::get('/special-offer/{slug}', [SpecialOfferController::class, 'show'])->name('special-offers.show');
```

### View: `resources/views/special-offers/show.blade.php`

#### Page Structure

##### 1. Hero Section with Image Gallery
```html
<section class="offer-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Main Image Carousel -->
                <div class="offer-gallery">
                    <div class="swiper offerSwiper">
                        <div class="swiper-wrapper">
                            <!-- Images from offer.images array -->
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Booking Card (sticky) -->
                <div class="booking-card-sticky">
                    <div class="price-display">
                        <span class="price-label">From</span>
                        <div class="price-main">
                            <span class="currency">€</span>
                            <span class="amount" id="finalPrice">3,219</span>
                        </div>
                        <div class="price-original" id="originalPrice">
                            <del>€3,577</del>
                        </div>
                    </div>

                    <form id="bookingForm" class="mt-4">
                        <div class="mb-3">
                            <label class="form-label">Pickup Date</label>
                            <input type="date" id="pickupDate" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pickup Time</label>
                            <input type="time" id="pickupTime" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Passengers</label>
                            <select id="passengers" class="form-select" required>
                                <!-- Options based on maxPassengerLimit -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea id="notes" class="form-control" rows="3" placeholder="Flight details, special requests..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-book-now w-100">
                            Continue to Book
                        </button>
                    </form>

                    <div class="offer-features mt-3">
                        <div class="feature-item">
                            <i class="bi bi-calendar-check"></i>
                            <span>Instant Confirmation</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-shield-check"></i>
                            <span>Secure Booking</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-headset"></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
```

##### 2. Offer Information Section
```html
<section class="offer-info-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/special-offers">Special Offers</a></li>
                        <li class="breadcrumb-item active">{{ offer.title }}</li>
                    </ol>
                </nav>

                <!-- Title & Meta -->
                <div class="offer-header">
                    <span class="category-badge">{{ category.title }}</span>
                    <h1 class="offer-title">{{ offer.title }}</h1>
                    <div class="offer-meta">
                        <span><i class="bi bi-geo-alt"></i> {{ city.name }}, {{ country }}</span>
                        <span><i class="bi bi-calendar"></i> {{ duration }} Days</span>
                        <span><i class="bi bi-people"></i> Up to {{ maxPassengerLimit }} Passengers</span>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="offer-description">
                    <p>{{ shortDescription }}</p>
                </div>

                <!-- Vehicle Information -->
                <div class="vehicle-info-card">
                    <h3>Vehicle Details</h3>
                    <div class="vehicle-content">
                        <img src="{{ vehicle.thumbnail }}" alt="{{ vehicle.title }}">
                        <div class="vehicle-details">
                            <h4>{{ vehicle.title }}</h4>
                            <p class="vehicle-class">{{ vehicle.vehicleClass.title }}</p>
                            <div class="vehicle-specs">
                                <span><i class="bi bi-person"></i> {{ vehicle.seatingCapacity }} Seats</span>
                                <span><i class="bi bi-bag"></i> {{ vehicle.luggageCapacity }} Bags</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expandable Content Sections -->
                <div class="offer-contents">
                    <!-- Loop through offer.contents array -->
                    <div class="accordion" id="offerAccordion">
                        <div class="accordion-item" v-for="content in contents">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse">
                                    <i class="{{ content.icon }}"></i>
                                    {{ content.title }}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show">
                                <div class="accordion-body" v-html="content.description"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dates & Availability -->
                <div class="availability-card">
                    <h3>Availability</h3>
                    <div class="date-range">
                        <div class="date-item">
                            <label>Start Date</label>
                            <span>{{ formatDate(startDate) }}</span>
                        </div>
                        <div class="date-item">
                            <label>End Date</label>
                            <span>{{ formatDate(endDate) }}</span>
                        </div>
                    </div>
                    <div class="booking-limit">
                        <i class="bi bi-info-circle"></i>
                        Maximum {{ maxBookingLimit }} bookings available
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
```

##### 3. Similar Offers Section
```html
<section class="similar-offers-section">
    <div class="container">
        <h2>Similar Offers</h2>
        <div class="row g-4">
            <!-- Show 4 similar offers based on category or city -->
        </div>
    </div>
</section>
```

#### Booking Form Submission
```javascript
document.getElementById('bookingForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const bookingData = {
        special_offer_id: currentOffer.id,
        pickup_date: document.getElementById('pickupDate').value,
        pickup_time: document.getElementById('pickupTime').value,
        passengers: document.getElementById('passengers').value,
        notes: document.getElementById('notes').value
    };

    // Store in localStorage for booking flow
    localStorage.setItem('specialOfferBooking', JSON.stringify(bookingData));

    // Redirect to booking confirmation page
    window.location.href = `/special-offer-booking/${currentOffer.uuid}`;
});
```

---

## Phase 5: Backend Implementation

### 1. Create Controller

File: `app/Http/Controllers/SpecialOfferController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpecialOfferController extends Controller
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('LOCALRYDES_API_URL') . '/special-offers';
        $this->apiKey = env('LOCALRYDES_API_KEY');
    }

    /**
     * Display special offers listing page
     */
    public function index(Request $request)
    {
        $offers = $this->fetchSpecialOffers();

        // Apply filters if provided
        if ($request->has('category')) {
            $offers = array_filter($offers, function($offer) use ($request) {
                return $offer['specialOfferCategory']['slug'] === $request->input('category');
            });
        }

        return view('special-offers.index', [
            'offers' => $offers,
            'categories' => $this->getCategories($offers),
            'cities' => $this->getCities($offers)
        ]);
    }

    /**
     * Display single special offer detail page
     */
    public function show($slug)
    {
        $offers = $this->fetchSpecialOffers();

        $offer = collect($offers)->firstWhere('slug', $slug);

        if (!$offer) {
            abort(404, 'Special Offer not found');
        }

        // Get similar offers (same category or city)
        $similarOffers = collect($offers)
            ->filter(function($item) use ($offer) {
                return $item['slug'] !== $offer['slug'] &&
                       ($item['specialOfferCategory']['id'] === $offer['specialOfferCategory']['id'] ||
                        $item['city']['id'] === $offer['city']['id']);
            })
            ->take(4);

        return view('special-offers.show', [
            'offer' => $offer,
            'similarOffers' => $similarOffers
        ]);
    }

    /**
     * Fetch special offers from API (with caching)
     */
    private function fetchSpecialOffers()
    {
        return Cache::remember('special_offers', 3600, function () {
            try {
                $response = Http::withHeaders([
                    'x-api-key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ])->get($this->apiUrl);

                if ($response->successful()) {
                    return $response->json()['specialOffers'] ?? [];
                }

                return [];
            } catch (\Exception $e) {
                \Log::error('Failed to fetch special offers: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Extract unique categories from offers
     */
    private function getCategories($offers)
    {
        return collect($offers)
            ->pluck('specialOfferCategory')
            ->unique('id')
            ->values()
            ->toArray();
    }

    /**
     * Extract unique cities from offers
     */
    private function getCities($offers)
    {
        return collect($offers)
            ->pluck('city')
            ->unique('id')
            ->sortBy('name')
            ->values()
            ->toArray();
    }
}
```

### 2. Create API Proxy Endpoint (for AJAX calls)

File: `app/Http/Controllers/Api/SpecialOfferApiController.php`

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpecialOfferApiController extends Controller
{
    public function index()
    {
        $offers = Cache::remember('special_offers', 3600, function () {
            try {
                $response = Http::withHeaders([
                    'x-api-key' => env('LOCALRYDES_API_KEY'),
                    'Content-Type' => 'application/json',
                ])->get(env('LOCALRYDES_API_URL') . '/special-offers');

                if ($response->successful()) {
                    return $response->json()['specialOffers'] ?? [];
                }

                return [];
            } catch (\Exception $e) {
                return [];
            }
        });

        return response()->json([
            'success' => true,
            'specialOffers' => $offers
        ]);
    }
}
```

### 3. Add Routes

File: `routes/web.php`

```php
use App\Http\Controllers\SpecialOfferController;

// Special Offers Routes
Route::get('/special-offers', [SpecialOfferController::class, 'index'])
    ->name('special-offers.index');

Route::get('/special-offer/{slug}', [SpecialOfferController::class, 'show'])
    ->name('special-offers.show');
```

File: `routes/api.php`

```php
use App\Http\Controllers\Api\SpecialOfferApiController;

Route::get('/special-offers-proxy', [SpecialOfferApiController::class, 'index']);
```

### 4. Environment Variables

File: `.env`

```env
LOCALRYDES_API_URL=https://lr.local/api/v2/external
LOCALRYDES_API_KEY=api_dev_ORyMTjb2I8mPBycdcZi3WYJogciH0LoTWd4bcO30BKFGXTn2rt6WUIwB4mZU
```

---

## Phase 6: Styling

### Add to `public/css/style.css`

```css
/* ========================================
   SPECIAL OFFERS SECTION
   ======================================== */

/* Home Page Section */
.special-offers-section {
    padding: 6rem 0;
    background: white;
}

.special-offers-section h2 {
    font-size: 2.8rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.special-offers-section .text-muted {
    font-size: 1.2rem;
}

/* Offer Card */
.offer-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.offer-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.offer-card-image {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.offer-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.offer-card:hover .offer-card-image img {
    transform: scale(1.1);
}

.category-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    z-index: 2;
}

.date-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.offer-card-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.offer-location {
    color: var(--text-light);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.offer-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.offer-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: var(--text-light);
    flex-wrap: wrap;
}

.offer-meta span {
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.offer-meta i {
    color: var(--primary-color);
}

.offer-pricing {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.offer-price {
    display: flex;
    flex-direction: column;
}

.price-label {
    font-size: 0.85rem;
    color: var(--text-light);
}

.price-amount {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--primary-color);
}

.price-original {
    font-size: 0.95rem;
    color: var(--text-light);
    text-decoration: line-through;
}

.btn-view-details {
    padding: 0.6rem 1.5rem;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: transform 0.2s, box-shadow 0.3s;
}

.btn-view-details:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 79, 30, 0.4);
}

.btn-view-all {
    padding: 1rem 3rem;
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    transition: all 0.3s;
}

.btn-view-all:hover {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(255, 79, 30, 0.4);
}

/* ========================================
   LISTING PAGE
   ======================================== */

.special-offers-hero {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    padding: 8rem 0 4rem;
    color: white;
    text-align: center;
}

.special-offers-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.special-offers-hero p {
    font-size: 1.3rem;
    opacity: 0.95;
}

.filters-section {
    padding: 3rem 0 2rem;
    background: var(--light-gray);
    position: sticky;
    top: 80px;
    z-index: 10;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.filters-section .form-select,
.filters-section .form-control {
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    padding: 0.75rem 1rem;
    font-weight: 600;
}

.filters-section .form-select:focus,
.filters-section .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(255, 79, 30, 0.25);
}

.offers-grid-section {
    padding: 4rem 0;
    background: white;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

.pagination {
    display: flex;
    gap: 0.5rem;
}

.page-item {
    list-style: none;
}

.page-link {
    padding: 0.6rem 1rem;
    background: white;
    color: var(--text-dark);
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
}

.page-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    border-color: transparent;
}

/* ========================================
   DETAIL PAGE
   ======================================== */

.offer-hero {
    padding: 120px 0 4rem;
    background: var(--light-gray);
}

.offer-gallery {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.offerSwiper {
    width: 100%;
    height: 500px;
}

.offerSwiper .swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.swiper-button-next,
.swiper-button-prev {
    color: white !important;
    background: rgba(0, 0, 0, 0.5);
    width: 50px !important;
    height: 50px !important;
    border-radius: 50%;
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 20px !important;
}

.swiper-pagination-bullet {
    background: white !important;
    opacity: 0.7;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    background: var(--primary-color) !important;
}

/* Booking Card Sticky */
.booking-card-sticky {
    position: sticky;
    top: 100px;
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.price-display {
    text-align: center;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f0f0f0;
}

.price-label {
    font-size: 0.9rem;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.price-main {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 0.3rem;
    margin: 0.5rem 0;
}

.price-main .currency {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
}

.price-main .amount {
    font-size: 3rem;
    font-weight: 800;
    color: var(--primary-color);
    line-height: 1;
}

.price-original del {
    font-size: 1.2rem;
    color: var(--text-light);
}

.btn-book-now {
    padding: 1rem;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    transition: transform 0.2s, box-shadow 0.3s;
}

.btn-book-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(255, 79, 30, 0.4);
}

.offer-features {
    padding-top: 1rem;
    border-top: 2px solid #f0f0f0;
}

.offer-features .feature-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 0;
    color: var(--text-dark);
    font-size: 0.95rem;
    font-weight: 600;
}

.offer-features .feature-item i {
    color: var(--accent-color);
    font-size: 1.2rem;
}

/* Offer Info Section */
.offer-info-section {
    padding: 4rem 0;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 2rem;
}

.breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: var(--text-light);
}

.offer-header {
    margin-bottom: 2rem;
}

.offer-header .category-badge {
    position: static;
    display: inline-block;
    margin-bottom: 1rem;
}

.offer-header .offer-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.offer-header .offer-meta {
    display: flex;
    gap: 2rem;
    font-size: 1rem;
    color: var(--text-light);
}

.offer-header .offer-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.offer-header .offer-meta i {
    color: var(--primary-color);
    font-size: 1.2rem;
}

.offer-description {
    background: var(--light-gray);
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 3rem;
}

.offer-description p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-dark);
    margin: 0;
}

/* Vehicle Info Card */
.vehicle-info-card {
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 3rem;
}

.vehicle-info-card h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--text-dark);
}

.vehicle-content {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.vehicle-content img {
    width: 200px;
    height: 150px;
    object-fit: cover;
    border-radius: 12px;
}

.vehicle-details h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.vehicle-class {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
}

.vehicle-specs {
    display: flex;
    gap: 1.5rem;
    font-size: 0.95rem;
    color: var(--text-light);
}

.vehicle-specs span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.vehicle-specs i {
    color: var(--primary-color);
}

/* Accordion Sections */
.offer-contents {
    margin-bottom: 3rem;
}

.accordion-item {
    border: 2px solid #e0e0e0;
    border-radius: 15px !important;
    overflow: hidden;
    margin-bottom: 1rem;
}

.accordion-button {
    padding: 1.5rem 2rem;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-dark);
    background: white;
    border: none;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
}

.accordion-button:focus {
    box-shadow: none;
}

.accordion-button i {
    font-size: 1.5rem;
}

.accordion-body {
    padding: 2rem;
    font-size: 1rem;
    line-height: 1.8;
    color: var(--text-dark);
}

/* Availability Card */
.availability-card {
    background: var(--light-gray);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 3rem;
}

.availability-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--text-dark);
}

.date-range {
    display: flex;
    gap: 3rem;
    margin-bottom: 1rem;
}

.date-item {
    display: flex;
    flex-direction: column;
}

.date-item label {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.date-item span {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-dark);
}

.booking-limit {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: rgba(255, 79, 30, 0.1);
    border-radius: 10px;
    color: var(--primary-color);
    font-weight: 600;
}

/* Similar Offers Section */
.similar-offers-section {
    padding: 4rem 0 6rem;
    background: var(--light-gray);
}

.similar-offers-section h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 3rem;
    color: var(--text-dark);
}

/* ========================================
   RESPONSIVE
   ======================================== */

@media (max-width: 768px) {
    .special-offers-hero h1 {
        font-size: 2.5rem;
    }

    .filters-section .row {
        gap: 1rem;
    }

    .offer-header .offer-title {
        font-size: 2rem;
    }

    .offer-header .offer-meta {
        flex-direction: column;
        gap: 0.8rem;
    }

    .vehicle-content {
        flex-direction: column;
    }

    .vehicle-content img {
        width: 100%;
        height: 200px;
    }

    .date-range {
        flex-direction: column;
        gap: 1rem;
    }

    .offerSwiper {
        height: 300px;
    }

    .booking-card-sticky {
        position: static;
        margin-top: 2rem;
    }
}
```

---

## Testing Checklist

### Home Page Section
- [ ] 8 special offers displayed in 2 rows (4 per row)
- [ ] Cards show correct thumbnail images
- [ ] Category badges display correctly
- [ ] Date badges show for event packages
- [ ] Prices calculate discounts correctly
- [ ] "View Details" buttons navigate to detail page
- [ ] "View All Offers" button navigates to listing page
- [ ] Section is responsive on mobile/tablet
- [ ] Hover effects work smoothly

### Listing Page
- [ ] All offers load correctly
- [ ] Category filter works
- [ ] City filter works
- [ ] Price range filter works
- [ ] Search functionality works
- [ ] Pagination displays correct pages
- [ ] Pagination navigation works
- [ ] URL updates with page parameter
- [ ] Filters are clearable
- [ ] "No results" message shows when filtered empty
- [ ] Responsive layout on all devices

### Detail Page
- [ ] Image gallery/carousel works
- [ ] Swiper navigation (prev/next) works
- [ ] Breadcrumb navigation works
- [ ] Offer title and meta display correctly
- [ ] Vehicle information shows correctly
- [ ] All content sections expand/collapse
- [ ] HTML content renders properly in descriptions
- [ ] Booking form validation works
- [ ] Date picker shows available dates
- [ ] Passenger limit enforced
- [ ] Form submission stores data correctly
- [ ] Similar offers section displays related offers
- [ ] Sticky booking card stays in viewport
- [ ] Responsive design on mobile

### API Integration
- [ ] API calls succeed with correct headers
- [ ] Response data structure matches expected format
- [ ] Caching works (subsequent loads are faster)
- [ ] Error handling shows graceful fallback
- [ ] Loading states display during API calls

### Navigation
- [ ] "Special Offers" menu item added
- [ ] Menu item highlights on current page
- [ ] Links navigate correctly

### General
- [ ] SEO meta tags present
- [ ] Images load with proper alt tags
- [ ] Performance optimized (Lighthouse score)
- [ ] No console errors
- [ ] Accessibility standards met (WCAG AA)

---

## File Structure

```
lr-b2b-example-laravel/
├── .claude/
│   └── memory-bank/
│       └── special-offers-implementation-plan.md (THIS FILE)
├── app/
│   └── Http/
│       └── Controllers/
│           ├── SpecialOfferController.php (NEW)
│           └── Api/
│               └── SpecialOfferApiController.php (NEW)
├── public/
│   └── css/
│       └── style.css (UPDATED - add special offers styles)
├── resources/
│   └── views/
│       ├── welcome.blade.php (UPDATED - add home section + nav menu)
│       └── special-offers/
│           ├── index.blade.php (NEW - listing page)
│           └── show.blade.php (NEW - detail page)
├── routes/
│   ├── web.php (UPDATED - add routes)
│   └── api.php (UPDATED - add proxy route)
└── .env (UPDATED - add API credentials)
```

---

## Implementation Order

1. **Environment Setup**
   - Add API credentials to `.env`
   - Test API connection manually

2. **Backend Foundation**
   - Create `SpecialOfferController`
   - Create `SpecialOfferApiController`
   - Add routes to `web.php` and `api.php`
   - Test API proxy endpoint

3. **Home Page Section**
   - Add section HTML to `welcome.blade.php`
   - Add JavaScript for fetching offers
   - Add CSS styles
   - Add navigation menu item
   - Test display and interactions

4. **Listing Page**
   - Create `index.blade.php` view
   - Implement filtering logic
   - Implement pagination
   - Add CSS styles
   - Test filters and pagination

5. **Detail Page**
   - Create `show.blade.php` view
   - Implement image gallery/carousel
   - Implement booking form
   - Add accordion sections
   - Add similar offers section
   - Add CSS styles
   - Test all interactions

6. **Testing & Optimization**
   - Run through testing checklist
   - Optimize performance
   - Fix bugs
   - Mobile testing
   - Browser compatibility testing

---

## Notes

- **Caching**: API responses are cached for 1 hour (3600 seconds) to improve performance
- **Error Handling**: Graceful fallbacks if API fails (show cached data or empty state)
- **Responsive**: All components must work on mobile, tablet, and desktop
- **Accessibility**: Ensure keyboard navigation and screen reader compatibility
- **SEO**: Add proper meta tags on detail pages
- **Performance**: Lazy load images, minify CSS/JS
- **Security**: Sanitize user inputs, validate form data

---

**Last Updated**: 2026-04-07
**Status**: Planning Phase Complete - Ready for Implementation
