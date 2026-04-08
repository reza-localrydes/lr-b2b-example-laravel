<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title id="pageTitle">Special Offer - LocalRydes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Detail Page Specific Styles */
        .offer-hero-simple {
            padding: 140px 0 40px;
            background: linear-gradient(135deg, #FF4F1E 0%, #ff6b3d 100%);
        }

        .offer-hero-simple h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .offer-hero-meta {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .offer-hero-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 10px;
        }

        .offer-hero-meta-item i {
            font-size: 1.2rem;
        }

        /* Offer Details Section */
        .offer-details-section {
            padding: 3rem 0;
            background: #f8f9fa;
        }

        .offer-info-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .offer-detail-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .offer-info-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .offer-info-meta {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .info-meta-item i {
            color: var(--primary-color);
            font-size: 1.2rem;
            width: 24px;
        }

        .offer-short-description {
            font-size: 1rem;
            line-height: 1.8;
            color: var(--text-light);
        }

        .gallery-container {
            display: flex;
            gap: 1rem;
        }

        .gallery-main {
            flex: 1;
        }

        .gallery-main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .gallery-thumbnails {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            width: 160px;
        }

        .gallery-thumb {
            position: relative;
            height: 95px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s;
        }

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-thumb:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .gallery-thumb.active {
            border-color: var(--primary-color);
        }

        .gallery-thumb-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Content Description Styling */
        .content-description {
            line-height: 1.8;
        }

        .content-description h1,
        .content-description h2,
        .content-description h3,
        .content-description h4,
        .content-description h5 {
            color: var(--text-dark);
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .content-description h5 {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .content-description ul {
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .content-description li {
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }

        .content-description strong {
            color: var(--text-dark);
            font-weight: 600;
        }

        .content-description p {
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        .detail-section {
            padding: 4rem 0;
        }

        .offer-detail-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .offer-detail-card h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }

        .feature-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .feature-list-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .feature-list-item i {
            color: var(--accent-color);
            font-size: 1.5rem;
            flex-shrink: 0;
            margin-top: 0.2rem;
        }

        .feature-list-item-content h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: var(--text-dark);
        }

        .feature-list-item-content p {
            font-size: 0.95rem;
            color: var(--text-light);
            margin: 0;
        }

        .booking-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            border: 2px solid var(--primary-color);
        }

        .booking-price {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .booking-price .price-label {
            font-size: 1rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }

        .booking-price .price-original {
            font-size: 1.5rem;
            color: var(--text-light);
            text-decoration: line-through;
            margin-bottom: 0.5rem;
        }

        .booking-price .price-final {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-color);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .booking-price .price-discount {
            display: inline-block;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .booking-form .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .btn-book-now {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 700;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-book-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 79, 30, 0.5);
        }

        .terms-text {
            font-size: 0.85rem;
            color: var(--text-light);
            text-align: center;
            margin-top: 1rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: gap 0.3s;
            opacity: 0.9;
        }

        .back-link:hover {
            gap: 0.8rem;
            opacity: 1;
            color: white;
        }

        @media (max-width: 768px) {
            .offer-hero-simple h1 {
                font-size: 1.8rem;
            }

            .offer-detail-title {
                font-size: 1.5rem;
            }

            .gallery-container {
                flex-direction: column;
            }

            .gallery-thumbnails {
                flex-direction: row;
                width: 100%;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }

            .gallery-thumb {
                min-width: 100px;
                width: 100px;
                height: 75px;
            }

            .gallery-main-image {
                height: 280px;
            }

            .offer-info-card {
                padding: 1.5rem;
            }

            .offer-info-meta {
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <span class="brand-text">LocalRydes</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#vehicles">Vehicles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/special-offers">Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Offer Hero Section with Image Gallery -->
    <div class="offer-hero-simple">
        <div class="container">
            <a href="/special-offers" class="back-link">
                <i class="bi bi-arrow-left"></i> Back to All Offers
            </a>
            <h1 id="offerTitle">Loading...</h1>
            <div class="offer-hero-meta" id="offerMeta">
                <!-- Meta info will be populated via JavaScript -->
            </div>
        </div>
    </div>

    <!-- Offer Details Section -->
    <section class="offer-details-section d-none" id="offerDetailsSection">
        <div class="container">
            <div class="row g-4">
                <!-- Left Side: Image Gallery -->
                <div class="col-lg-7">
                    <div class="gallery-container">
                        <!-- Main Image -->
                        <div class="gallery-main">
                            <img id="mainGalleryImage" class="gallery-main-image" src="" alt="Main offer image">
                        </div>

                        <!-- Thumbnail Images -->
                        <div class="gallery-thumbnails" id="galleryThumbnails">
                            <!-- Thumbnails will be populated via JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Right Side: Basic Info -->
                <div class="col-lg-5">
                    <div class="offer-info-card">
                        <h1 class="offer-detail-title" id="offerDetailTitle">Loading...</h1>

                        <div class="offer-info-badge">Package</div>

                        <div class="offer-info-meta">
                            <div class="info-meta-item" id="durationInfo">
                                <i class="bi bi-clock"></i>
                                <span>Loading...</span>
                            </div>
                            <div class="info-meta-item" id="passengersInfo">
                                <i class="bi bi-people"></i>
                                <span>Loading...</span>
                            </div>
                            <div class="info-meta-item" id="vehicleInfo">
                                <i class="bi bi-car-front"></i>
                                <span>Loading...</span>
                            </div>
                        </div>

                        <div class="offer-short-description" id="offerShortDescription">
                            <!-- Short description will be populated via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loading State -->
    <div id="loadingState" class="text-center py-5">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-muted">Loading offer details...</p>
    </div>

    <!-- Error State -->
    <div id="errorState" class="container py-5 d-none">
        <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Offer not found</strong> - The special offer you're looking for doesn't exist or has been removed.
            <a href="/special-offers" class="alert-link ms-3">View all offers</a>
        </div>
    </div>

    <!-- Detail Content -->
    <section class="detail-section d-none" id="detailContent">
        <div class="container">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Content Sections (dynamically generated from contents array) -->
                    <div id="contentSections">
                        <!-- Content sections will be populated via JavaScript -->
                    </div>
                </div>

                <!-- Booking Sidebar -->
                <div class="col-lg-4">
                    <div class="booking-card">
                        <div class="booking-price" id="bookingPrice">
                            <!-- Price will be populated via JavaScript -->
                        </div>

                        <form id="bookingForm" class="booking-form">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="bookingDate" class="form-label">
                                        <i class="bi bi-calendar3"></i> Select Date
                                    </label>
                                    <input type="date" class="form-control" id="bookingDate" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="bookingTime" class="form-label">
                                        <i class="bi bi-clock"></i> Time
                                    </label>
                                    <input type="time" class="form-control" id="bookingTime" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="pickupLocation" class="form-label">
                                        <i class="bi bi-geo-alt"></i> Pickup Location
                                    </label>
                                    <input type="text" class="form-control" id="pickupLocation" placeholder="Enter pickup location" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="dropOffLocation" class="form-label">
                                        <i class="bi bi-geo-alt-fill"></i> Drop-off Location
                                    </label>
                                    <input type="text" class="form-control" id="dropOffLocation" placeholder="Enter drop-off location" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="customerName" class="form-label">
                                        <i class="bi bi-person"></i> Full Name
                                    </label>
                                    <input type="text" class="form-control" id="customerName" placeholder="Enter your name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="customerEmail" class="form-label">
                                        <i class="bi bi-envelope"></i> Email Address
                                    </label>
                                    <input type="email" class="form-control" id="customerEmail" placeholder="your@email.com" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="customerPhone" class="form-label">
                                        <i class="bi bi-telephone"></i> Phone Number
                                    </label>
                                    <input type="tel" class="form-control" id="customerPhone" placeholder="+1 (555) 123-4567" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="additionalNote" class="form-label">
                                        <i class="bi bi-chat-left-text"></i> Additional Notes (Optional)
                                    </label>
                                    <textarea class="form-control" id="additionalNote" rows="3" placeholder="Any special requests or preferences..."></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn-book-now" id="bookNowBtn">
                                <i class="bi bi-check-circle me-2"></i> Book This Offer
                            </button>

                            <p class="terms-text">
                                By booking, you agree to our <a href="#" class="text-primary">Terms & Conditions</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>LocalRydes</h5>
                    <p class="text-muted">Premium transportation services for discerning travelers.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">&copy; 2024 LocalRydes. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACE_API_KEY') }}&libraries=places"></script>
    <script>
        const offerSlug = '{{ $slug }}';
        let currentOffer = null;
        let pickupAutocomplete, dropOffAutocomplete;
        let locationData = {
            pickup: null,
            dropoff: null
        };

        // Fetch offer details on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchOfferDetails();
            setupBookingForm();
            initializeGooglePlaces();
        });

        async function fetchOfferDetails() {
            try {
                // Fetch specific offer by slug
                const response = await fetch(`/api/special-offers/${offerSlug}`);
                const data = await response.json();

                if (data.success && data.specialOffer) {
                    currentOffer = data.specialOffer;
                    renderOfferDetails(currentOffer);
                } else {
                    showError();
                }
            } catch (error) {
                console.error('Error fetching offer details:', error);
                showError();
            } finally {
                document.getElementById('loadingState').style.display = 'none';
            }
        }

        function renderOfferDetails(offer) {
            // Update page title
            document.title = `${offer.title} - LocalRydes`;
            document.getElementById('pageTitle').textContent = `${offer.title} - LocalRydes`;

            // Set hero content
            document.getElementById('offerTitle').textContent = offer.title;

            // Render image gallery
            if (offer.images && offer.images.length > 0) {
                renderImageGallery(offer.images, offer);
            } else if (offer.thumbnail) {
                renderImageGallery([offer.thumbnail], offer);
            }

            // Set hero meta
            const meta = document.getElementById('offerMeta');
            const hasDiscount = offer.discount && offer.discount > 0;
            meta.innerHTML = `
                <div class="offer-hero-meta-item">
                    <i class="bi ${getCategoryIcon(offer.categorySlug)}"></i>
                    <span>${offer.category || 'Special Offer'}</span>
                </div>
                ${hasDiscount && offer.discountType === 'percentage' ? `
                <div class="offer-hero-meta-item">
                    <i class="bi bi-tag"></i>
                    <span>${offer.discount}% Off</span>
                </div>
                ` : ''}
            `;

            // Render content sections
            if (offer.contents && offer.contents.length > 0) {
                renderContentSections(offer.contents);
            } else {
                // Fallback if no contents
                const contentSections = document.getElementById('contentSections');
                contentSections.innerHTML = `
                    <div class="offer-detail-card">
                        <h2>About This Offer</h2>
                        <div class="text-muted">${offer.description || 'No description available.'}</div>
                    </div>
                `;
            }

            // Set pricing
            const originalPrice = offer.price || 0;
            const discount = offer.discount || 0;
            const discountType = offer.discountType || 'percentage';
            const currencySymbol = offer.sourceCurrency?.symbol || '$';
            const finalPrice = calculateFinalPrice(originalPrice, discount, discountType);

            const bookingPrice = document.getElementById('bookingPrice');
            const savingsText = discountType === 'percentage' ? `Save ${discount}%` : `Save ${currencySymbol}${discount}`;
            bookingPrice.innerHTML = `
                ${discount > 0 ? `<div class="price-original">${currencySymbol}${originalPrice.toLocaleString()}</div>` : ''}
                <div class="price-final">${currencySymbol}${finalPrice.toLocaleString()}</div>
                ${discount > 0 ? `<div class="price-discount">${savingsText}</div>` : ''}
            `;

            // Set date constraints
            const dateInput = document.getElementById('bookingDate');
            const today = new Date().toISOString().split('T')[0];
            const endDate = new Date(offer.endDate).toISOString().split('T')[0];
            dateInput.min = today;
            dateInput.max = endDate;

            // Show content
            document.getElementById('detailContent').classList.remove('d-none');
        }

        function initializeGooglePlaces() {
            // Initialize autocomplete for pickup location
            const pickupInput = document.getElementById('pickupLocation');
            pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, {
                types: ['establishment', 'geocode']
            });

            // Add event listener for pickup location
            pickupAutocomplete.addListener('place_changed', function() {
                handlePlaceSelect(pickupAutocomplete, 'pickupLocation');
            });

            // Initialize autocomplete for drop-off location
            const dropOffInput = document.getElementById('dropOffLocation');
            dropOffAutocomplete = new google.maps.places.Autocomplete(dropOffInput, {
                types: ['establishment', 'geocode']
            });

            // Add event listener for drop-off location
            dropOffAutocomplete.addListener('place_changed', function() {
                handlePlaceSelect(dropOffAutocomplete, 'dropOffLocation');
            });
        }

        function handlePlaceSelect(autocomplete, inputId) {
            const place = autocomplete.getPlace();

            if (!place || !place.geometry) {
                console.warn('Please select a location from the dropdown');
                return;
            }

            const locationObject = {
                id: place.place_id,
                google_place_id: place.place_id,
                name: document.getElementById(inputId).value,
                lat: place.geometry.location.lat().toString(),
                lng: place.geometry.location.lng().toString(),
                address: place.formatted_address,
                isFavorite: "0",
                type: inputId === 'pickupLocation' ? "1" : "3",
                note: "",
                types: place.types || []
            };

            if (inputId === 'pickupLocation') {
                locationData.pickup = locationObject;
                console.log('Pickup location selected:', locationObject);
            } else if (inputId === 'dropOffLocation') {
                locationData.dropoff = locationObject;
                console.log('Drop-off location selected:', locationObject);
            }
        }

        function setupBookingForm() {
            const bookingForm = document.getElementById('bookingForm');
            const bookNowBtn = document.getElementById('bookNowBtn');

            bookingForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!currentOffer) {
                    alert('Offer details not loaded. Please refresh the page.');
                    return;
                }

                // Validate location selections
                if (!locationData.pickup) {
                    alert('Please select a pickup location from the dropdown');
                    return;
                }

                if (!locationData.dropoff) {
                    alert('Please select a drop-off location from the dropdown');
                    return;
                }

                // Disable submit button and show loading state
                bookNowBtn.disabled = true;
                bookNowBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

                try {
                    // Calculate drop-off date (same as pickup date for now, can be modified based on offer duration)
                    const pickupDate = document.getElementById('bookingDate').value;
                    const dropOffDate = pickupDate; // You can calculate this based on offer.duration if needed

                    // Prepare API payload - send individual customer fields
                    // Controller will create passenger object for external API
                    const apiPayload = {
                        special_offer_id: currentOffer.id,
                        pickup_date: pickupDate,
                        pickup_time: document.getElementById('bookingTime').value,
                        drop_off_date: dropOffDate,
                        pickup_location: locationData.pickup.name || locationData.pickup.address,
                        drop_off_location: locationData.dropoff.name || locationData.dropoff.address,
                        additional_note: document.getElementById('additionalNote').value || '',
                        customer_name: document.getElementById('customerName').value,
                        customer_email: document.getElementById('customerEmail').value,
                        customer_phone: document.getElementById('customerPhone').value
                    };

                    console.log('Sending booking request:', apiPayload);

                    // Call add-to-cart API
                    const response = await fetch('/api/special-offers/add-to-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(apiPayload)
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Failed to confirm booking');
                    }

                    if (result.success && result.reservation) {
                        console.log('Booking successful:', result);

                        // Store reservation data in localStorage for success page
                        // Success page expects: reservationData.bookingData.reservation
                        localStorage.setItem('confirmedReservation', JSON.stringify({
                            bookingData: {
                                reservation: result.reservation
                            },
                            offer: currentOffer,
                            formData: apiPayload,
                            timestamp: new Date().getTime()
                        }));

                        // Clear previous booking data if any
                        localStorage.removeItem('selectedVehicleBooking');

                        // Redirect to success page with reservation UUID
                        const reservationUuid = result.reservation.uuid;
                        window.location.href = `/booking/success/${reservationUuid}`;
                    } else {
                        throw new Error('Invalid response from server');
                    }
                } catch (error) {
                    console.error('Booking error:', error);
                    alert('An error occurred while processing your booking. Please try again.\n\n' + error.message);

                    // Re-enable button
                    bookNowBtn.disabled = false;
                    bookNowBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Book This Offer';
                }
            });
        }

        function getDaysRemaining(endDate) {
            const now = new Date();
            const end = new Date(endDate);
            const diffTime = end - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }

        function renderImageGallery(images, offer) {
            const mainImage = document.getElementById('mainGalleryImage');
            const thumbnailsContainer = document.getElementById('galleryThumbnails');
            const offerDetailsSection = document.getElementById('offerDetailsSection');

            if (!images || images.length === 0) return;

            // Set first image as main
            mainImage.src = images[0];

            // Show max 4 thumbnails, with "+X" indicator on last if more images
            const maxThumbs = 4;
            const displayThumbs = images.slice(0, maxThumbs);
            const remainingCount = images.length > maxThumbs ? images.length - maxThumbs : 0;

            thumbnailsContainer.innerHTML = displayThumbs.map((img, index) => {
                const isLast = index === maxThumbs - 1;
                const showOverlay = isLast && remainingCount > 0;

                return `
                    <div class="gallery-thumb ${index === 0 ? 'active' : ''}" data-index="${index}">
                        <img src="${img}" alt="Thumbnail ${index + 1}">
                        ${showOverlay ? `<div class="gallery-thumb-overlay">+${remainingCount}</div>` : ''}
                    </div>
                `;
            }).join('');

            // Populate right side info
            document.getElementById('offerDetailTitle').textContent = offer.title;

            // Duration info
            const durationInfo = document.getElementById('durationInfo');
            if (offer.duration && offer.durationUnit) {
                durationInfo.innerHTML = `
                    <i class="bi bi-clock"></i>
                    <span>${offer.duration} ${offer.durationUnit}</span>
                `;
            } else {
                durationInfo.style.display = 'none';
            }

            // Passengers info
            const passengersInfo = document.getElementById('passengersInfo');
            if (offer.maxPassengerLimit) {
                passengersInfo.innerHTML = `
                    <i class="bi bi-people"></i>
                    <span>${offer.maxPassengerLimit} Person${offer.maxPassengerLimit > 1 ? 's' : ''}</span>
                `;
            } else {
                passengersInfo.style.display = 'none';
            }

            // Vehicle info
            const vehicleInfo = document.getElementById('vehicleInfo');
            if (offer.partner?.name) {
                vehicleInfo.innerHTML = `
                    <i class="bi bi-car-front"></i>
                    <span>${offer.partner.name}</span>
                `;
            } else {
                vehicleInfo.style.display = 'none';
            }

            // Short description
            const shortDescElement = document.getElementById('offerShortDescription');
            if (offer.shortDescription) {
                shortDescElement.textContent = offer.shortDescription;
            } else {
                shortDescElement.style.display = 'none';
            }

            // Show section
            offerDetailsSection.classList.remove('d-none');

            // Add click handlers for thumbnails
            document.querySelectorAll('.gallery-thumb').forEach((thumb) => {
                thumb.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);

                    // Update main image
                    mainImage.src = images[index];

                    // Update active state
                    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }

        function renderContentSections(contents) {
            const contentSections = document.getElementById('contentSections');

            contentSections.innerHTML = contents.map(content => {
                // Skip if description is "--" or empty
                if (!content.description || content.description === '--' || content.description.trim() === '') {
                    return '';
                }

                return `
                    <div class="offer-detail-card">
                        <h2>
                            ${content.icon ? `<i class="${content.icon} me-2"></i>` : ''}
                            ${content.title}
                        </h2>
                        <div class="content-description">
                            ${content.description}
                        </div>
                    </div>
                `;
            }).filter(html => html !== '').join('');
        }

        function calculateFinalPrice(price, discount, discountType) {
            if (!price) return 0;
            if (!discount || discount === 0) return price;

            if (discountType === 'percentage') {
                return price - (price * discount / 100);
            } else if (discountType === 'fixed') {
                return price - discount;
            }

            return price;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        }

        function getCategoryIcon(categorySlug) {
            const icons = {
                'airport': 'bi-airplane',
                'event': 'bi-calendar-event',
                'tour': 'bi-compass',
                'wedding': 'bi-heart',
                'hourly': 'bi-clock-history'
            };
            return icons[categorySlug] || 'bi-star';
        }

        function showError() {
            document.getElementById('errorState').classList.remove('d-none');
        }
    </script>
</body>
</html>
