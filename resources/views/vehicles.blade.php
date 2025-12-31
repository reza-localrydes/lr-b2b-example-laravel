<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Vehicles - LocalRydes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .header a {
            color: white;
            text-decoration: none;
            opacity: 0.9;
            margin-top: 10px;
            display: inline-block;
        }

        .header a:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .booking-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }

        .booking-card h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: #333;
        }

        /* Service Type Selector */
        .service-type-selector {
            margin-bottom: 30px;
        }

        .service-type-label {
            font-weight: 600;
            color: #555;
            font-size: 1rem;
            margin-bottom: 15px;
            display: block;
        }

        .service-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .service-type-card {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .service-type-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .service-type-card.active {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .service-type-card .icon {
            font-size: 2rem;
            color: #667eea;
            flex-shrink: 0;
        }

        .service-type-card.active .icon {
            color: #fff;
        }

        .service-type-card .service-text .title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .service-type-card .service-text .description {
            font-size: 0.85rem;
            color: #666;
        }

        .service-type-card.active .service-text .description {
            color: rgba(255,255,255,0.9);
        }

        /* Form Styles */
        .form-section {
            margin-bottom: 25px;
        }

        .form-section-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .required {
            color: #e74c3c;
        }

        /* Itinerary Stops */
        .itinerary-item {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            position: relative;
        }

        .itinerary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .itinerary-header strong {
            color: #667eea;
            font-size: 1rem;
        }

        .btn-remove {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .btn-remove:hover {
            background: #c0392b;
        }

        .btn-add-itinerary {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }

        .btn-add-itinerary:hover {
            text-decoration: underline;
        }

        /* Buttons */
        .btn-search {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.3s;
            margin-top: 20px;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-search:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Loading and Results */
        .loading {
            display: none;
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            display: none;
            background: #fee;
            color: #c33;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }

        .error-message.active {
            display: block;
        }

        .vehicles-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .vehicle-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .vehicle-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .vehicle-details {
            padding: 20px;
        }

        .vehicle-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .vehicle-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            color: #666;
            font-size: 0.9rem;
        }

        .vehicle-features {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 15px 0;
        }

        .feature-badge {
            background: #f0f0f0;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            color: #666;
        }

        .price-container {
            margin: 15px 0;
        }

        .original-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
        }

        .current-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
        }

        .discount-badge {
            background: #4CAF50;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            display: inline-block;
            margin-left: 10px;
        }

        .btn-book {
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-book:hover {
            background: #45a049;
        }

        .btn-book:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .partner-info {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 0.85rem;
            color: #666;
        }

        .rating {
            color: #ffa500;
        }

        .no-results {
            display: none;
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
        }

        .no-results.active {
            display: block;
        }

        .no-results h3 {
            color: #666;
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .booking-card {
                padding: 25px;
            }

            .service-types {
                grid-template-columns: 1fr;
            }
        }

        .pac-container {
            z-index: 10000 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Search Available Vehicles</h1>
            <p>Find the perfect vehicle for your journey</p>
            <a href="/">&larr; Back to Home</a>
        </div>

        <div class="booking-card">
            <h2>Book Your Ride</h2>

            <form id="searchForm">
                <!-- Service Type Selection -->
                <div class="service-type-selector">
                    <label class="service-type-label">Select Your Service Type</label>
                    <div class="service-types">
                        <div class="service-type-card active" data-service="transfer">
                            <div class="icon">=—</div>
                            <div class="service-text">
                                <div class="title">Transfer Service</div>
                                <div class="description">Point-to-point transportation</div>
                            </div>
                        </div>
                        <div class="service-type-card" data-service="hourly">
                            <div class="icon">ð</div>
                            <div class="service-text">
                                <div class="title">Hourly Service</div>
                                <div class="description">Book by the hour with a driver</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Fields -->
                <div class="form-section">
                    <div class="form-section-title">Trip Details</div>

                    <div class="form-group">
                        <label for="pickupLocation">Pickup Location <span class="required">*</span></label>
                        <input type="text"
                               id="pickupLocation"
                               class="search-location"
                               placeholder="Enter pickup address"
                               autocomplete="off"
                               required>
                    </div>

                    <!-- Itinerary Stops Container -->
                    <div id="itinerariesContainer"></div>
                    <a href="javascript:void(0)" class="btn-add-itinerary" id="addItinerary">
                        + Add Stop
                    </a>

                    <div class="form-group dropoff-container">
                        <label for="dropoffLocation">Drop-off Location <span class="required dropoff-required">*</span></label>
                        <input type="text"
                               id="dropoffLocation"
                               class="search-location"
                               placeholder="Enter drop-off address"
                               autocomplete="off">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="pickupDate">Pickup Date <span class="required">*</span></label>
                            <input type="date" id="pickupDate" required>
                        </div>

                        <div class="form-group">
                            <label for="pickupTime">Pickup Time <span class="required">*</span></label>
                            <input type="time" id="pickupTime" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="passengers">Passengers <span class="required">*</span></label>
                            <select id="passengers" required>
                                <option value="1">1 Passenger</option>
                                <option value="2" selected>2 Passengers</option>
                                <option value="3">3 Passengers</option>
                                <option value="4">4 Passengers</option>
                                <option value="5">5 Passengers</option>
                                <option value="6">6+ Passengers</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="bags">Luggage <span class="required">*</span></label>
                            <select id="bags" required>
                                <option value="0">No Luggage</option>
                                <option value="1" selected>1 Bag</option>
                                <option value="2">2 Bags</option>
                                <option value="3">3 Bags</option>
                                <option value="4">4+ Bags</option>
                            </select>
                        </div>

                        <div class="form-group hours-container" style="display: none;">
                            <label for="hours">Number of Hours <span class="required">*</span></label>
                            <select id="hours">
                                <option value="">Select hours</option>
                                <option value="4">4 Hours</option>
                                <option value="5">5 Hours</option>
                                <option value="6">6 Hours</option>
                                <option value="7">7 Hours</option>
                                <option value="8">8 Hours</option>
                                <option value="9">9 Hours</option>
                                <option value="10">10 Hours</option>
                                <option value="11">11 Hours</option>
                                <option value="12">12 Hours</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-search" id="searchBtn">
                    Search Available Vehicles
                </button>
            </form>
        </div>

        <!-- Error Message -->
        <div class="error-message" id="errorMessage"></div>

        <!-- Loading Indicator -->
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Searching for available vehicles...</p>
        </div>

        <!-- No Results -->
        <div class="no-results" id="noResults">
            <h3>No vehicles found</h3>
            <p>Please try different search criteria.</p>
        </div>

        <!-- Vehicles Container -->
        <div class="vehicles-container" id="vehiclesContainer"></div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACE_API_KEY') }}&libraries=places"></script>
    <script>
        // Configuration
        const API_CONFIG = {
            baseUrl: '{{ env("LOCALRYDES_API_URL", "https://api.localrydes.com/api/v2/external") }}',
            apiKey: '{{ env("LOCALRYDES_API_KEY", "YOUR_API_KEY_HERE") }}'
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
            initializeDateDefaults();
            initializeServiceTypeSwitcher();
            initializeGoogleAutocomplete();
            initializeItineraryButtons();
            initializeFormSubmission();
        });

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
                // Transfer: dropoff required, no hours
                dropoffContainer.style.display = 'block';
                dropoffInput.required = true;
                if (dropoffRequired) dropoffRequired.style.display = 'inline';
                hoursContainer.style.display = 'none';
                hoursInput.required = false;
            } else {
                // Hourly: dropoff optional, hours required
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
                // Handle itinerary
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
                    <div class="itinerary-header">
                        <strong>Stop #${itineraryCount}</strong>
                        <button type="button" class="btn-remove" onclick="removeItinerary(${itineraryCount})">
                            Remove
                        </button>
                    </div>
                    <div class="form-group">
                        <label>Stop Location</label>
                        <input type="text"
                               id="itinerary_${itineraryCount}"
                               class="search-location"
                               placeholder="Enter stop address"
                               autocomplete="off">
                    </div>
                </div>
            `;

            document.getElementById('itinerariesContainer').insertAdjacentHTML('beforeend', itineraryHtml);

            // Reinitialize autocomplete for new input
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
            const vehiclesContainer = document.getElementById('vehiclesContainer');
            const noResults = document.getElementById('noResults');

            // Validation
            if (!locationData.pickup) {
                alert('Please select a pickup location from the dropdown');
                return;
            }

            if (currentServiceType === 'transfer' && !locationData.dropoff) {
                alert('Please select a drop-off location from the dropdown');
                return;
            }

            // Show loading
            loading.classList.add('active');
            errorMessage.classList.remove('active');
            noResults.classList.remove('active');
            vehiclesContainer.innerHTML = '';
            searchBtn.disabled = true;

            try {
                const requestData = buildSearchRequest();
                console.log('Search request:', requestData);

                const response = await fetch(`${API_CONFIG.baseUrl}/search-available-vehicles`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'x-api-key': API_CONFIG.apiKey
                    },
                    body: JSON.stringify(requestData)
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Search failed');
                }

                if (data.success && data.data.availableVehicles && data.data.availableVehicles.length > 0) {
                    displayVehicles(data.data.availableVehicles, data.data.bookingId);
                } else {
                    noResults.classList.add('active');
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

        function displayVehicles(vehicles, bookingId) {
            const container = document.getElementById('vehiclesContainer');
            container.innerHTML = '';

            vehicles.forEach(vehicleData => {
                const card = createVehicleCard(vehicleData, bookingId);
                container.appendChild(card);
            });
        }

        function createVehicleCard(vehicleData, bookingId) {
            const vehicle = vehicleData.vehicle;
            const card = document.createElement('div');
            card.className = 'vehicle-card';

            const hasDiscount = vehicleData.isDiscount === 1;
            const currency = vehicleData.sourcePriceCurrency?.symbol || '$';

            card.innerHTML = `
                <img src="${vehicle.images && vehicle.images[0] ? vehicle.images[0] : 'https://via.placeholder.com/400x200?text=Vehicle'}"
                     alt="${vehicle.name}"
                     class="vehicle-image"
                     onerror="this.src='https://via.placeholder.com/400x200?text=Vehicle'">
                <div class="vehicle-details">
                    <h3 class="vehicle-name">${vehicle.name}</h3>

                    <div class="vehicle-info">
                        <span>=d ${vehicle.passenger} passengers</span>
                        <span>>ó ${vehicle.bag} bags</span>
                    </div>

                    <div class="vehicle-features">
                        ${vehicle.features ? vehicle.features.map(f => `<span class="feature-badge">${f}</span>`).join('') : ''}
                    </div>

                    <div class="price-container">
                        ${hasDiscount ? `<div class="original-price">${currency}${parseFloat(vehicleData.priceBeforeDiscount).toFixed(2)}</div>` : ''}
                        <div class="current-price">
                            ${currency}${parseFloat(vehicleData.convertedPrice).toFixed(2)}
                            ${hasDiscount ? `<span class="discount-badge">${parseFloat(vehicleData.partnerDiscountPercentage).toFixed(0)}% OFF</span>` : ''}
                        </div>
                    </div>

                    <div class="partner-info">
                        <div><strong>Partner:</strong> ${vehicle.partner?.company_name || 'LocalRydes'}</div>
                        <div class="rating">P ${vehicle.partner?.rating || '5.0'} / 5.0</div>
                    </div>

                    <button class="btn-book"
                            ${vehicleData.customerCanBook ? '' : 'disabled'}
                            onclick="bookVehicle(${vehicle.id}, '${bookingId}')">
                        ${vehicleData.customerCanBook ? 'Book Now' : 'Not Available'}
                    </button>
                </div>
            `;

            return card;
        }

        function bookVehicle(vehicleId, bookingId) {
            alert(`Booking vehicle ${vehicleId} with booking ID: ${bookingId}\n\nThis would redirect to your booking confirmation page.`);
            // In production: window.location.href = `/booking/confirm?vehicleId=${vehicleId}&bookingId=${bookingId}`;
        }
    </script>
</body>
</html>
