<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Details - LocalRydes</title>
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
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }

        .booking-card h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        .info-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .info-value {
            font-size: 1.1rem;
            color: #333;
            font-weight: 500;
        }

        .vehicle-info {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .vehicle-thumbnail {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        .vehicle-details {
            flex: 1;
        }

        .vehicle-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .vehicle-class {
            color: #667eea;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .vehicle-capacity {
            color: #666;
            font-size: 0.9rem;
        }

        .price-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .price-summary h3 {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .price-total {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid rgba(255,255,255,0.3);
            font-size: 1.3rem;
            font-weight: 700;
        }

        .location-item {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
        }

        .location-type {
            font-size: 0.85rem;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .location-address {
            font-size: 0.95rem;
            color: #333;
        }

        .btn-continue {
            width: 100%;
            padding: 15px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
        }

        .btn-continue:hover {
            background: #45a049;
        }

        .btn-continue:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 15px;
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

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .vehicle-info {
                flex-direction: column;
            }

            .vehicle-thumbnail {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Details</h1>
            <p>Review your booking information</p>
            <a href="/">&larr; Back to Search</a>
        </div>

        <!-- Error Message -->
        <div class="error-message" id="errorMessage"></div>

        <!-- Loading Indicator -->
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Loading booking details...</p>
        </div>

        <!-- Booking Details Container -->
        <div id="bookingDetailsContainer"></div>
    </div>

    <script>
        // Booking ID from URL
        const bookingId = '{{ $bookingId }}';

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadBookingDetails();
        });

        function loadBookingDetails() {
            const savedData = localStorage.getItem('selectedVehicleBooking');

            if (savedData) {
                try {
                    const bookingData = JSON.parse(savedData);

                    // Verify bookingId matches
                    if (bookingData.bookingId === bookingId) {
                        displayBookingDetails(bookingData.bookingInfo);
                    } else {
                        showError('Invalid booking session. Please search again.');
                    }
                } catch (error) {
                    console.error('Error loading booking details:', error);
                    showError('Failed to load booking details. Please try again.');
                }
            } else {
                showError('No booking data found. Please start a new search.');
            }
        }

        function displayBookingDetails(bookingInfo) {
            const container = document.getElementById('bookingDetailsContainer');

            const currency = bookingInfo.priceInfo.sourceCurrency.symbol || '$';
            const vehicle = bookingInfo.selectedVehicle;
            const price = bookingInfo.priceInfo;

            container.innerHTML = `
                <div class="booking-card">
                    <h2>Trip Information</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Booking ID</div>
                            <div class="info-value">${bookingInfo.uuid}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Trip Type</div>
                            <div class="info-value">${bookingInfo.tripBookingType.charAt(0).toUpperCase() + bookingInfo.tripBookingType.slice(1)}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Pickup Date</div>
                            <div class="info-value">${bookingInfo.pickupDate}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Pickup Time</div>
                            <div class="info-value">${bookingInfo.pickupTime}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Passengers</div>
                            <div class="info-value">${bookingInfo.passengers}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Luggage</div>
                            <div class="info-value">${bookingInfo.bags} bag(s)</div>
                        </div>
                        ${bookingInfo.totalKm ? `
                        <div class="info-item">
                            <div class="info-label">Total Distance</div>
                            <div class="info-value">${bookingInfo.totalKm} km</div>
                        </div>
                        ` : ''}
                    </div>

                    <h2>Selected Vehicle</h2>
                    <div class="vehicle-info">
                        <img src="${vehicle.thumbnail || 'https://via.placeholder.com/150x100?text=Vehicle'}"
                             alt="${vehicle.title}"
                             class="vehicle-thumbnail"
                             onerror="this.src='https://via.placeholder.com/150x100?text=Vehicle'">
                        <div class="vehicle-details">
                            <div class="vehicle-title">${vehicle.title}</div>
                            <div class="vehicle-class">${vehicle.vehicleClass.title}</div>
                            <div class="vehicle-capacity">
                                👥 ${vehicle.seatingCapacity} passengers &nbsp;&nbsp; 🧳 ${vehicle.luggageCapacity} bags
                            </div>
                            <div style="margin-top: 5px; color: #666; font-size: 0.85rem;">
                                Partner: ${vehicle.partnerName}
                            </div>
                        </div>
                    </div>

                    <h2>Locations</h2>
                    ${bookingInfo.locations.map(location => `
                        <div class="location-item">
                            <div class="location-type">${location.title || location.type}</div>
                            <div class="location-address">${location.address || location.name}</div>
                        </div>
                    `).join('')}

                    <div class="price-summary">
                        <h3>Price Summary</h3>
                        <div class="price-row">
                            <span>Base Price</span>
                            <span>${currency}${parseFloat(price.price).toFixed(2)}</span>
                        </div>
                        ${price.discountAmountConverted > 0 ? `
                        <div class="price-row">
                            <span>Discount</span>
                            <span>-${currency}${parseFloat(price.discountAmountConverted).toFixed(2)}</span>
                        </div>
                        ` : ''}
                        <div class="price-total">
                            <span>Total Amount</span>
                            <span>${currency}${parseFloat(price.customerPayable).toFixed(2)}</span>
                        </div>
                    </div>

                    <h2 style="margin-top: 30px;">Passenger Information</h2>
                    <form id="reservationForm" onsubmit="submitReservation(event)">
                        <div class="info-grid">
                            <div class="form-group">
                                <label for="fullName">Full Name <span style="color: #e74c3c;">*</span></label>
                                <input type="text"
                                       id="fullName"
                                       name="full_name"
                                       required
                                       placeholder="Enter passenger full name"
                                       style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 0.95rem;">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       placeholder="Enter email address"
                                       style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 0.95rem;">
                            </div>

                            <div class="form-group">
                                <label for="mobile">Mobile Number <span style="color: #e74c3c;">*</span></label>
                                <input type="tel"
                                       id="mobile"
                                       name="mobile"
                                       required
                                       placeholder="Enter mobile number"
                                       style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 0.95rem;">
                            </div>

                            <div class="form-group">
                                <label for="flightNumber">Flight Number</label>
                                <input type="text"
                                       id="flightNumber"
                                       name="flight_number"
                                       placeholder="Enter flight number (optional)"
                                       style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 0.95rem;">
                            </div>
                        </div>

                        <button type="submit" class="btn-continue" id="confirmBookingBtn">
                            Confirm Booking
                        </button>
                    </form>
                </div>
            `;
        }

        function showError(message) {
            const errorElement = document.getElementById('errorMessage');
            errorElement.textContent = message;
            errorElement.classList.add('active');
        }

        async function submitReservation(event) {
            event.preventDefault();

            const form = event.target;
            const submitBtn = document.getElementById('confirmBookingBtn');
            const errorMessage = document.getElementById('errorMessage');

            // Hide any previous errors
            errorMessage.classList.remove('active');

            // Get form data
            const formData = {
                booking_id: bookingId,
                flight_number: form.flight_number.value.trim() || null,
                passenger: {
                    full_name: form.full_name.value.trim(),
                    email: form.email.value.trim() || null,
                    mobile: form.mobile.value.trim()
                }
            };

            // Validate required fields
            if (!formData.passenger.full_name) {
                alert('Please enter passenger full name');
                return;
            }

            if (!formData.passenger.mobile) {
                alert('Please enter mobile number');
                return;
            }

            // Disable submit button and show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';

            try {
                const response = await fetch('/api/store-reservation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to confirm booking');
                }

                if (data.success && data.data && data.data.reservation) {
                    // Store reservation data in localStorage
                    localStorage.setItem('confirmedReservation', JSON.stringify({
                        bookingData: data.data,
                        timestamp: new Date().getTime()
                    }));

                    // Clear previous booking data
                    localStorage.removeItem('selectedVehicleBooking');

                    // Redirect to success page with reservation UUID
                    const reservationUuid = data.data.reservation.uuid;
                    window.location.href = `/booking/success/${reservationUuid}`;
                } else {
                    throw new Error('Invalid response from server');
                }

            } catch (error) {
                console.error('Reservation error:', error);
                errorMessage.textContent = error.message || 'Failed to confirm booking. Please try again.';
                errorMessage.classList.add('active');

                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Confirm Booking';
            }
        }
    </script>
</body>
</html>
