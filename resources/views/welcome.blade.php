<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LocalRydes - Premium Transportation Services</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#home">LocalRydes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('special.offers') }}">Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">FAQ</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-nav-cta" href="#home">Book Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @include('partials.home.hero')
    @include('partials.home.offers')



    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Get In Touch</h2>
                <p class="text-muted">We're here to help you 24/7</p>
            </div>
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">📍</div>
                    <div class="contact-details">
                        <h3>Visit Us</h3>
                        <p>123 Transportation Avenue<br>New York, NY 10001<br>United States</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <div class="contact-details">
                        <h3>Call Us</h3>
                        <p>+1 (555) 123-4567<br>Available 24/7</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">✉️</div>
                    <div class="contact-details">
                        <h3>Email Us</h3>
                        <p>info@localrydes.com<br>support@localrydes.com</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">⏰</div>
                    <div class="contact-details">
                        <h3>Business Hours</h3>
                        <p>24/7 Customer Support<br>Office: Mon-Fri, 9AM-6PM</p>
                    </div>
                </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact-form">
                        <h3>Send us a message</h3>
                        <form id="contactForm">
                            <div class="mb-3">
                                <label for="contactName" class="form-label">Your Name</label>
                                <input type="text" id="contactName" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactEmail" class="form-label">Email Address</label>
                                <input type="email" id="contactEmail" class="form-control" placeholder="john@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactPhone" class="form-label">Phone Number</label>
                                <input type="tel" id="contactPhone" class="form-control" placeholder="+1 (555) 123-4567">
                            </div>
                            <div class="mb-3">
                                <label for="contactMessage" class="form-label">Message</label>
                                <textarea id="contactMessage" class="form-control" rows="5" placeholder="How can we help you?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-submit">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Frequently Asked Questions</h2>
                <p class="text-muted">Find answers to common questions about our services</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
            <div class="faq-item">
                <button class="faq-question">
                    <span>How do I book a ride?</span>
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Simply fill out the booking form above with your pickup location, destination, date, and time. Select the number of passengers and luggage, then click "Search Available Vehicles" to see your options. Choose your preferred vehicle and complete the booking process.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>What payment methods do you accept?</span>
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        We accept all major credit cards (Visa, MasterCard, American Express), debit cards, and digital payment methods. All payments are processed securely through our encrypted payment gateway.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Can I cancel or modify my booking?</span>
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Yes, you can cancel or modify your booking up to 24 hours before the scheduled pickup time without any charges. Cancellations made within 24 hours may incur a cancellation fee. Contact our support team for assistance with modifications.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Are your drivers licensed and insured?</span>
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Absolutely! All our drivers are professionally licensed, background-checked, and fully insured. They undergo rigorous training to ensure your safety and comfort throughout your journey.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Do you offer airport transfers?</span>
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Yes, we specialize in airport transfers! Our drivers monitor flight schedules and will adjust pickup times accordingly if your flight is delayed. We also provide meet-and-greet service at the airport terminal.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>What if I have extra luggage?</span>
                    <span class="faq-icon">▼</span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        No problem! When booking, make sure to select the correct number of bags. If you have oversized luggage or special items, please contact us in advance so we can arrange a suitable vehicle with adequate storage space.
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                <h3>LocalRydes</h3>
                <p style="color: rgba(255,255,255,0.7); margin-top: 1rem; line-height: 1.6;">
                    Your trusted partner for premium transportation services. Experience comfort, reliability, and professionalism with every ride.
                </p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="#">Airport Transfers</a></li>
                        <li><a href="#">Corporate Travel</a></li>
                        <li><a href="#">Hourly Rentals</a></li>
                        <li><a href="#">Special Events</a></li>
                        <li><a href="#">City Tours</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h3>Contact</h3>
                    <ul>
                        <li>📍 123 Transportation Ave</li>
                        <li>📞 +1 (555) 123-4567</li>
                        <li>✉️ info@localrydes.com</li>
                        <li>⏰ Available 24/7</li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom">
                        <p>&copy; 2026 LocalRydes. All rights reserved. | Privacy Policy | Terms of Service</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Loading Indicator -->
    <div class="loading" id="loading">
        <div class="loading-content">
            <div class="spinner"></div>
            <p>Searching for available vehicles...</p>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACE_API_KEY') }}&libraries=places"></script>
    <script>
        // Configuration
        const API_CONFIG = {
            baseUrl: '{{ env("LOCALRYDES_API_URL", "https://lr.local/api/v2/external") }}',
            apiKey: '{{ env("LOCALRYDES_API_KEY", "lr_live_ZPKSM337Z5LxcSnvCorBivXA2NZzm5LHxXKIMmHK3M4Kb8x9nXrOA8GKjgRU") }}'
        };

        let currentServiceType = 'transfer';
        let itineraryCount = 0;
        let autocompletes = {};
        let locationData = {
            pickup: null,
            dropoff: null,
            itineraries: []
        };

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeNavbar();
            initializeDateDefaults();
            initializeServiceTypeSwitcher();
            initializeGoogleAutocomplete();
            initializeItineraryButtons();
            initializeFormSubmission();
            initializeFAQ();
            initializeContactForm();
            fetchSpecialOffers();
        });

        // Navbar scroll effect
        function initializeNavbar() {
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }

        function initializeDateDefaults() {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            document.getElementById('pickupDate').value = tomorrow.toISOString().split('T')[0];
            document.getElementById('pickupDate').min = new Date().toISOString().split('T')[0];
            document.getElementById('pickupTime').value = '10:00';
        }

        function initializeServiceTypeSwitcher() {
            document.querySelectorAll('.service-type-card').forEach(card => {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.service-type-card').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    currentServiceType = this.dataset.service;
                    updateFormFields();
                });
            });
        }

        function updateFormFields() {
            const dropoffContainer = document.querySelector('.dropoff-container');
            const dropoffInput = document.getElementById('dropoffLocation');
            const dropoffRequired = document.querySelector('.dropoff-required');
            const hoursContainer = document.querySelector('.hours-container');
            const hoursInput = document.getElementById('hours');

            if (currentServiceType === 'transfer') {
                dropoffContainer.style.display = 'block';
                dropoffInput.required = true;
                if (dropoffRequired) dropoffRequired.style.display = 'inline';
                hoursContainer.style.display = 'none';
                hoursInput.required = false;
            } else {
                dropoffContainer.style.display = 'block';
                dropoffInput.required = false;
                if (dropoffRequired) dropoffRequired.style.display = 'none';
                hoursContainer.style.display = 'block';
                hoursInput.required = true;
            }
        }

        function initializeGoogleAutocomplete() {
            const inputs = document.querySelectorAll('.search-location');
            inputs.forEach(input => {
                const autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener('place_changed', function() {
                    handlePlaceSelect(autocomplete, input.id);
                });
                autocompletes[input.id] = autocomplete;
            });
        }

        function handlePlaceSelect(autocomplete, inputId) {
            const place = autocomplete.getPlace();

            if (!place || !place.geometry) {
                alert('Please select a location from the dropdown');
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
            } else if (inputId === 'dropoffLocation') {
                locationData.dropoff = locationObject;
            } else {
                const match = inputId.match(/itinerary_(\d+)/);
                if (match) {
                    locationObject.type = "2";
                    locationData.itineraries[parseInt(match[1])] = locationObject;
                }
            }

            console.log('Location selected:', locationObject);
        }

        function initializeItineraryButtons() {
            document.getElementById('addItinerary').addEventListener('click', addItineraryStop);
        }

        function addItineraryStop() {
            itineraryCount++;
            const itineraryHtml = `
                <div class="itinerary-item" data-index="${itineraryCount}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong style="color: var(--primary-color);">Stop #${itineraryCount}</strong>
                        <button type="button" class="btn btn-remove btn-sm" onclick="removeItinerary(${itineraryCount})">
                            Remove
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stop Location</label>
                        <input type="text"
                               id="itinerary_${itineraryCount}"
                               class="form-control search-location"
                               placeholder="Enter stop address"
                               autocomplete="off">
                    </div>
                </div>
            `;

            document.getElementById('itinerariesContainer').insertAdjacentHTML('beforeend', itineraryHtml);

            const newInput = document.getElementById(`itinerary_${itineraryCount}`);
            const autocomplete = new google.maps.places.Autocomplete(newInput);
            autocomplete.addListener('place_changed', function() {
                handlePlaceSelect(autocomplete, `itinerary_${itineraryCount}`);
            });
            autocompletes[`itinerary_${itineraryCount}`] = autocomplete;
        }

        function removeItinerary(index) {
            const item = document.querySelector(`.itinerary-item[data-index="${index}"]`);
            if (item) {
                item.remove();
                delete locationData.itineraries[index];
                delete autocompletes[`itinerary_${index}`];
            }
        }

        function initializeFormSubmission() {
            document.getElementById('searchForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                await searchVehicles();
            });
        }

        async function searchVehicles() {
            const searchBtn = document.getElementById('searchBtn');
            const loading = document.getElementById('loading');
            const errorMessage = document.getElementById('errorMessage');

            if (!locationData.pickup) {
                alert('Please select a pickup location from the dropdown');
                return;
            }

            if (currentServiceType === 'transfer' && !locationData.dropoff) {
                alert('Please select a drop-off location from the dropdown');
                return;
            }

            loading.classList.add('active');
            errorMessage.classList.remove('active');
            searchBtn.disabled = true;

            try {
                const requestData = buildSearchRequest();
                console.log('Search request:', requestData);

                const response = await fetch('/api/search-vehicles', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(requestData)
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Search failed');
                }

                const vehiclesArray = data.data.availableVehicles ? Object.values(data.data.availableVehicles) : [];

                if (data.success && vehiclesArray.length > 0) {
                    const searchData = {
                        vehicles: vehiclesArray,
                        bookingId: data.data.bookingId,
                        timestamp: new Date().getTime()
                    };
                    localStorage.setItem('vehicleSearchResults', JSON.stringify(searchData));
                    window.location.href = `/search/availavael-vehicles/${data.data.bookingId}`;
                } else {
                    alert('No vehicles found. Please try different search criteria.');
                }

            } catch (error) {
                console.error('Search error:', error);
                errorMessage.textContent = error.message || 'Failed to search vehicles. Please try again.';
                errorMessage.classList.add('active');
            } finally {
                loading.classList.remove('active');
                searchBtn.disabled = false;
            }
        }

        function buildSearchRequest() {
            const pickupDate = document.getElementById('pickupDate').value.replace(/-/g, '/');
            const pickupTime = document.getElementById('pickupTime').value;
            const passengers = document.getElementById('passengers').value;
            const bags = document.getElementById('bags').value;

            const requestData = {
                trip_booking_type: currentServiceType === 'transfer' ? 'transfer' : 'hourly',
                pick_up_location: locationData.pickup,
                pickup_date: pickupDate,
                pickup_time: pickupTime,
                passengers: passengers,
                bags: bags,
                itineraries: locationData.itineraries.filter(item => item !== null && item !== undefined)
            };

            if (currentServiceType === 'transfer' && locationData.dropoff) {
                requestData.drop_off_location = locationData.dropoff;
            } else if (currentServiceType === 'hourly') {
                const hours = document.getElementById('hours').value;
                requestData.booking_hour = hours;
                if (locationData.dropoff) {
                    requestData.drop_off_location = locationData.dropoff;
                }
            }

            return requestData;
        }

        // FAQ functionality
        function initializeFAQ() {
            document.querySelectorAll('.faq-question').forEach(button => {
                button.addEventListener('click', function() {
                    const faqItem = this.parentElement;
                    const isActive = faqItem.classList.contains('active');

                    document.querySelectorAll('.faq-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    if (!isActive) {
                        faqItem.classList.add('active');
                    }
                });
            });
        }

        // Contact form
        function initializeContactForm() {
            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Thank you for your message! We will get back to you shortly.');
                this.reset();
            });
        }

        // Special Offers Functions
        async function fetchSpecialOffers() {
            const offersGrid = document.getElementById('offersGrid');
            const offersLoading = document.getElementById('offersLoading');
            const viewAllButton = document.getElementById('viewAllButton');

            offersLoading.style.display = 'block';

            try {
                const response = await fetch('/api/special-offers', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch special offers');
                }

                const data = await response.json();

                if (data.success && data.specialOffers && data.specialOffers.length > 0) {
                    const offers = data.specialOffers.slice(0, 8); // Show only first 8 offers
                    renderSpecialOffers(offers);
                    viewAllButton.style.display = 'block';
                } else {
                    offersGrid.innerHTML = '<div class="col-12 text-center"><p class="text-muted">No special offers available at the moment.</p></div>';
                }
            } catch (error) {
                console.error('Error fetching special offers:', error);
                offersGrid.innerHTML = '<div class="col-12 text-center"><p class="text-danger">Failed to load special offers. Please try again later.</p></div>';
            } finally {
                offersLoading.style.display = 'none';
            }
        }

        function renderSpecialOffers(offers) {
            const offersGrid = document.getElementById('offersGrid');
            offersGrid.innerHTML = '';

            offers.forEach(offer => {
                const card = createOfferCard(offer);
                offersGrid.appendChild(card);
            });
        }

        function createOfferCard(offer) {
            const col = document.createElement('div');
            col.className = 'col-lg-3 col-md-6';

            const finalPrice = calculateFinalPrice(offer.price, offer.discount, offer.discountType);
            const hasDiscount = offer.discount > 0;

            col.innerHTML = `
                <div class="offer-card">
                    <a href="/special-offer/${offer.slug}" class="offer-card-link">
                        <div class="offer-card-image">
                            <img src="${offer.thumbnail}" alt="${offer.title}" loading="lazy">

                            ${offer.startDate && offer.endDate ? `
                                <span class="date-badge">
                                    <i class="bi bi-calendar"></i> ${formatDateRange(offer.startDate, offer.endDate)}
                                </span>
                            ` : ''}
                        </div>
                    </a>
                    <div class="offer-card-content">
                        <div class="offer-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>${offer.city.name}, ${offer.country}</span>
                        </div>
                        <a href="/special-offer/${offer.slug}" class="offer-title-link">
                            <h3 class="offer-title">${offer.title}</h3>
                        </a>
                        <div class="offer-meta">
                            <span><i class="bi bi-clock"></i> ${offer.duration} ${offer.durationUnit}</span>
                            <span><i class="bi bi-people"></i> Up to ${offer.maxPassengerLimit}</span>
                        </div>
                        <div class="offer-pricing">
                            <div class="offer-price">
                                <span class="price-label">From</span>
                                <div class="price-amount">${offer.sourceCurrency.symbol}${finalPrice.toLocaleString()}</div>
                                ${hasDiscount ? `<div class="price-original">${offer.sourceCurrency.symbol}${offer.price.toLocaleString()}</div>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;

            return col;
        }

        function calculateFinalPrice(price, discount, discountType) {
            if (!discount || discount === 0) return price;

            if (discountType === 'percentage') {
                return price - (price * discount / 100);
            } else if (discountType === 'fixed') {
                return price - discount;
            }

            return price;
        }

        function formatDateRange(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            const startMonth = start.toLocaleDateString('en-US', { month: 'short' });
            const endMonth = end.toLocaleDateString('en-US', { month: 'short' });
            const startDay = start.getDate();
            const endDay = end.getDate();

            if (startMonth === endMonth) {
                return `${startMonth} ${startDay}-${endDay}`;
            } else {
                return `${startMonth} ${startDay} - ${endMonth} ${endDay}`;
            }
        }
    </script>
</body>
</html>
