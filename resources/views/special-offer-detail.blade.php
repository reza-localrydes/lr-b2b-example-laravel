<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Special Offer - LocalRydes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Detail Page Specific Styles */
        .offer-hero {
            position: relative;
            height: 500px;
            background-size: cover;
            background-position: center;
            background-color: #f0f0f0;
        }

        .offer-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
        }

        .offer-hero-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            align-items: flex-end;
            padding-bottom: 3rem;
        }

        .offer-hero-content h1 {
            color: white;
            font-size: 3rem;
            font-weight: 800;
            text-shadow: 0 4px 20px rgba(0,0,0,0.5);
            margin-bottom: 1rem;
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
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 10px;
        }

        .offer-hero-meta-item i {
            font-size: 1.3rem;
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
            position: sticky;
            top: 100px;
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

        .validity-badge {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .expired-badge {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
            transition: gap 0.3s;
        }

        .back-link:hover {
            gap: 0.8rem;
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

    <!-- Offer Hero Section -->
    <div class="offer-hero" id="offerHero">
        <div class="container h-100">
            <div class="offer-hero-content">
                <div>
                    <a href="/special-offers" class="back-link">
                        <i class="bi bi-arrow-left"></i> Back to All Offers
                    </a>
                    <h1 id="offerTitle">Loading...</h1>
                    <div class="offer-hero-meta" id="offerMeta">
                        <!-- Meta info will be populated via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <!-- Description Card -->
                    <div class="offer-detail-card">
                        <h2>About This Offer</h2>
                        <div id="offerDescription" class="text-muted"></div>
                    </div>

                    <!-- Features Card -->
                    <div class="offer-detail-card">
                        <h2>What's Included</h2>
                        <div class="feature-list" id="featuresList">
                            <!-- Features will be populated via JavaScript -->
                        </div>
                    </div>

                    <!-- Terms Card -->
                    <div class="offer-detail-card">
                        <h2>Terms & Conditions</h2>
                        <div id="offerTerms" class="text-muted">
                            <!-- Terms will be populated via JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Booking Sidebar -->
                <div class="col-lg-4">
                    <div class="booking-card">
                        <div id="validityBadge" class="validity-badge">
                            <!-- Validity info will be populated via JavaScript -->
                        </div>

                        <div class="booking-price" id="bookingPrice">
                            <!-- Price will be populated via JavaScript -->
                        </div>

                        <form id="bookingForm" class="booking-form">
                            <div class="mb-3">
                                <label for="bookingDate" class="form-label">
                                    <i class="bi bi-calendar3"></i> Select Date
                                </label>
                                <input type="date" class="form-control" id="bookingDate" required>
                            </div>

                            <div class="mb-3">
                                <label for="bookingTime" class="form-label">
                                    <i class="bi bi-clock"></i> Select Time
                                </label>
                                <input type="time" class="form-control" id="bookingTime" required>
                            </div>

                            <div class="mb-3">
                                <label for="passengers" class="form-label">
                                    <i class="bi bi-people"></i> Number of Passengers
                                </label>
                                <select class="form-select" id="passengers" required>
                                    <option value="1">1 Passenger</option>
                                    <option value="2" selected>2 Passengers</option>
                                    <option value="3">3 Passengers</option>
                                    <option value="4">4 Passengers</option>
                                    <option value="5">5 Passengers</option>
                                    <option value="6">6+ Passengers</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="customerName" class="form-label">
                                    <i class="bi bi-person"></i> Full Name
                                </label>
                                <input type="text" class="form-control" id="customerName" placeholder="Enter your name" required>
                            </div>

                            <div class="mb-3">
                                <label for="customerEmail" class="form-label">
                                    <i class="bi bi-envelope"></i> Email Address
                                </label>
                                <input type="email" class="form-control" id="customerEmail" placeholder="your@email.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="customerPhone" class="form-label">
                                    <i class="bi bi-telephone"></i> Phone Number
                                </label>
                                <input type="tel" class="form-control" id="customerPhone" placeholder="+1 (555) 123-4567" required>
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
    <script>
        const offerSlug = '{{ $slug }}';
        let currentOffer = null;

        // Fetch offer details on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchOfferDetails();
            setupBookingForm();
        });

        async function fetchOfferDetails() {
            try {
                // Fetch all offers and find the one matching the slug
                const response = await fetch('/api/special-offers');
                const data = await response.json();

                if (data.success && data.specialOffers) {
                    currentOffer = data.specialOffers.find(offer => offer.slug === offerSlug);

                    if (currentOffer) {
                        renderOfferDetails(currentOffer);
                    } else {
                        showError();
                    }
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

            // Set hero background
            if (offer.thumbnail) {
                document.getElementById('offerHero').style.backgroundImage = `url(${offer.thumbnail})`;
            }

            // Set hero content
            document.getElementById('offerTitle').textContent = offer.title;

            // Set hero meta
            const meta = document.getElementById('offerMeta');
            meta.innerHTML = `
                <div class="offer-hero-meta-item">
                    <i class="bi ${getCategoryIcon(offer.categorySlug)}"></i>
                    <span>${offer.category || 'Special Offer'}</span>
                </div>
                ${offer.discountPercentage ? `
                <div class="offer-hero-meta-item">
                    <i class="bi bi-tag"></i>
                    <span>${offer.discountPercentage}% Off</span>
                </div>
                ` : ''}
            `;

            // Set description
            document.getElementById('offerDescription').innerHTML = offer.description || 'No description available.';

            // Set features
            if (offer.features && offer.features.length > 0) {
                const featuresList = document.getElementById('featuresList');
                featuresList.innerHTML = offer.features.map(feature => `
                    <div class="feature-list-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <div class="feature-list-item-content">
                            <h4>${feature}</h4>
                        </div>
                    </div>
                `).join('');
            }

            // Set terms
            if (offer.termsAndConditions) {
                document.getElementById('offerTerms').innerHTML = offer.termsAndConditions;
            } else {
                document.getElementById('offerTerms').innerHTML = `
                    <ul class="text-muted">
                        <li>Offer valid from ${formatDate(offer.startDate)} to ${formatDate(offer.endDate)}</li>
                        <li>Booking must be made in advance</li>
                        <li>Subject to availability</li>
                        <li>Cancellation policy applies</li>
                        <li>Cannot be combined with other offers</li>
                    </ul>
                `;
            }

            // Set validity badge
            const validityBadge = document.getElementById('validityBadge');
            const isActive = isOfferActive(offer);
            const daysRemaining = getDaysRemaining(offer.endDate);

            if (isActive) {
                if (daysRemaining <= 7) {
                    validityBadge.innerHTML = `<i class="bi bi-hourglass-split me-2"></i>Ending in ${daysRemaining} day${daysRemaining > 1 ? 's' : ''}!`;
                } else {
                    validityBadge.innerHTML = `<i class="bi bi-clock-history me-2"></i>Valid until ${formatDate(offer.endDate)}`;
                }
            } else {
                validityBadge.classList.add('expired-badge');
                validityBadge.innerHTML = `<i class="bi bi-x-circle me-2"></i>This offer has expired`;
                document.getElementById('bookNowBtn').disabled = true;
                document.getElementById('bookNowBtn').innerHTML = '<i class="bi bi-x-circle me-2"></i>Offer Expired';
            }

            // Set pricing
            const originalPrice = offer.priceDetails?.originalPrice || 0;
            const discount = offer.discountPercentage || 0;
            const finalPrice = calculateFinalPrice(originalPrice, discount);

            const bookingPrice = document.getElementById('bookingPrice');
            bookingPrice.innerHTML = `
                <div class="price-label">Price per booking</div>
                ${discount > 0 ? `<div class="price-original">$${originalPrice}</div>` : ''}
                <div class="price-final">$${finalPrice}</div>
                ${discount > 0 ? `<div class="price-discount">Save ${discount}%</div>` : ''}
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

        function setupBookingForm() {
            document.getElementById('bookingForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!currentOffer) {
                    alert('Offer details not loaded. Please refresh the page.');
                    return;
                }

                const bookingData = {
                    offerSlug: currentOffer.slug,
                    offerTitle: currentOffer.title,
                    date: document.getElementById('bookingDate').value,
                    time: document.getElementById('bookingTime').value,
                    passengers: document.getElementById('passengers').value,
                    customerName: document.getElementById('customerName').value,
                    customerEmail: document.getElementById('customerEmail').value,
                    customerPhone: document.getElementById('customerPhone').value,
                    originalPrice: currentOffer.priceDetails?.originalPrice || 0,
                    discount: currentOffer.discountPercentage || 0,
                    finalPrice: calculateFinalPrice(
                        currentOffer.priceDetails?.originalPrice || 0,
                        currentOffer.discountPercentage || 0
                    )
                };

                console.log('Booking Data:', bookingData);

                // TODO: Send booking data to backend
                alert('Booking functionality will be implemented soon!\n\nYour booking details:\n' +
                    `Offer: ${bookingData.offerTitle}\n` +
                    `Date: ${bookingData.date} at ${bookingData.time}\n` +
                    `Passengers: ${bookingData.passengers}\n` +
                    `Price: $${bookingData.finalPrice}`
                );
            });
        }

        function isOfferActive(offer) {
            const now = new Date();
            const startDate = new Date(offer.startDate);
            const endDate = new Date(offer.endDate);
            return now >= startDate && now <= endDate;
        }

        function getDaysRemaining(endDate) {
            const now = new Date();
            const end = new Date(endDate);
            const diffTime = end - now;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }

        function calculateFinalPrice(originalPrice, discountPercentage) {
            if (!originalPrice) return 0;
            const discount = (originalPrice * discountPercentage) / 100;
            return (originalPrice - discount).toFixed(2);
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
