<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1>Premium Transportation at Your Fingertips</h1>
                    <p>Experience luxury and comfort with our professional chauffeur services. Available 24/7 for all your transportation needs.</p>

                    <div class="row g-3 mt-3">
                        <div class="col-6">
                            <div class="feature-item">
                                <div class="feature-icon">⚡</div>
                                <div class="feature-text">Instant Booking</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item">
                                <div class="feature-icon">🚗</div>
                                <div class="feature-text">Premium Vehicles</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item">
                                <div class="feature-icon">👨‍✈️</div>
                                <div class="feature-text">Professional Drivers</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="feature-item">
                                <div class="feature-icon">💳</div>
                                <div class="feature-text">Transparent Pricing</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="search-card">
                    <!-- Error Message -->
                    <div class="error-message" id="errorMessage"></div>

                    <form id="searchForm">
                        <!-- Service Type Selection -->
                        <div class="mb-3">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="service-type-card active" data-service="transfer">
                                        <div class="icon">🚖</div>
                                        <div class="title">Transfer</div>
                                        <div class="description">Point-to-point</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="service-type-card" data-service="hourly">
                                        <div class="icon">⏱️</div>
                                        <div class="title">Hourly</div>
                                        <div class="description">Book by hour</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Fields -->
                        <div class="mb-3">
                            <label for="pickupLocation" class="form-label">Pickup Location <span class="text-danger">*</span></label>
                            <input type="text" id="pickupLocation" class="form-control search-location" placeholder="Enter pickup address" autocomplete="off" required>
                        </div>

                        <!-- Itinerary Stops Container -->
                        <div id="itinerariesContainer"></div>
                        <a href="javascript:void(0)" class="btn-add-itinerary d-inline-block mb-3" id="addItinerary">+ Add Stop</a>

                        <div class="mb-3 dropoff-container">
                            <label for="dropoffLocation" class="form-label">Drop-off Location <span class="text-danger dropoff-required">*</span></label>
                            <input type="text" id="dropoffLocation" class="form-control search-location" placeholder="Enter drop-off address" autocomplete="off">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="pickupDate" class="form-label">Pickup Date <span class="text-danger">*</span></label>
                                <input type="date" id="pickupDate" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="pickupTime" class="form-label">Pickup Time <span class="text-danger">*</span></label>
                                <input type="time" id="pickupTime" class="form-control" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="passengers" class="form-label">Passengers <span class="text-danger">*</span></label>
                                <select id="passengers" class="form-select" required>
                                    <option value="1">1 Passenger</option>
                                    <option value="2" selected>2 Passengers</option>
                                    <option value="3">3 Passengers</option>
                                    <option value="4">4 Passengers</option>
                                    <option value="5">5 Passengers</option>
                                    <option value="6">6+ Passengers</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="bags" class="form-label">Luggage <span class="text-danger">*</span></label>
                                <select id="bags" class="form-select" required>
                                    <option value="0">No Luggage</option>
                                    <option value="1" selected>1 Bag</option>
                                    <option value="2">2 Bags</option>
                                    <option value="3">3 Bags</option>
                                    <option value="4">4+ Bags</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 hours-container" style="display: none;">
                            <label for="hours" class="form-label">Number of Hours <span class="text-danger">*</span></label>
                            <select id="hours" class="form-select">
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

                        <button type="submit" class="btn-search" id="searchBtn">
                            Search Available Vehicles
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
