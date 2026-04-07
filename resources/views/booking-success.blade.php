<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Confirmed - LocalRydes</title>
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
            max-width: 900px;
            margin: 0 auto;
        }

        .success-header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: scaleIn 0.5s ease-out;
        }

        .success-icon::after {
            content: '✓';
            font-size: 50px;
            color: white;
            font-weight: bold;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        .success-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .success-header p {
            font-size: 1.1rem;
            opacity: 0.9;
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

        .reservation-id {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }

        .reservation-id-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .reservation-id-value {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
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

        .price-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
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

        .btn-payment {
            width: 100%;
            padding: 18px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-payment:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary {
            width: 100%;
            padding: 15px;
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 15px;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .passenger-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .passenger-info p {
            margin: 5px 0;
            color: #333;
        }

        .passenger-info strong {
            color: #666;
            display: inline-block;
            min-width: 120px;
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
            .success-header h1 {
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
        <div class="success-header">
            <div class="success-icon"></div>
            <h1>Booking Confirmed!</h1>
            <p>Your reservation has been successfully created</p>
        </div>

        <!-- Error Message -->
        <div class="error-message" id="errorMessage"></div>

        <!-- Loading Indicator -->
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Loading reservation details...</p>
        </div>

        <!-- Reservation Details Container -->
        <div id="reservationDetailsContainer"></div>
    </div>

    <script>
        // Reservation UUID from URL
        const reservationUuid = '{{ $reservationUuid }}';
        const localrydesUrl = '{{ env("LOCALRYDES_URL", "https://lr.local") }}';

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadReservationDetails();
        });

        function loadReservationDetails() {
            const savedData = localStorage.getItem('confirmedReservation');

            if (savedData) {
                try {
                    const reservationData = JSON.parse(savedData);

                    // Verify reservationUuid matches
                    if (reservationData.bookingData && reservationData.bookingData.reservation) {
                        const reservation = reservationData.bookingData.reservation;

                        if (reservation.uuid === reservationUuid) {
                            displayReservationDetails(reservation);
                        } else {
                            showError('Invalid reservation session.');
                        }
                    } else {
                        showError('Reservation data is incomplete.');
                    }
                } catch (error) {
                    console.error('Error loading reservation details:', error);
                    showError('Failed to load reservation details.');
                }
            } else {
                showError('No reservation data found. Please start a new booking.');
            }
        }

        function displayReservationDetails(reservation) {
            const container = document.getElementById('reservationDetailsContainer');
            const item = reservation.items && reservation.items[0];

            if (!item) {
                showError('Reservation item not found.');
                return;
            }

            const currency = item.priceDetails.currency.symbol || '€';
            const vehicle = item.vehicle;
            const passenger = reservation.passenger;
            const pickupAddress = item.addresses.find(addr => addr.type === 'pick_up');
            const dropoffAddress = item.addresses.find(addr => addr.type === 'drop_off');

            const paymentUrl = `${localrydesUrl}/reservation-payment-create/${reservation.uuid}?disable_hf=1`;

            container.innerHTML = `
                <div class="booking-card">
                    <div class="reservation-id">
                        <div class="reservation-id-label">Reservation ID</div>
                        <div class="reservation-id-value">${reservation.reservationId}</div>
                    </div>

                    <h2>Trip Information</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Service Type</div>
                            <div class="info-value">${reservation.serviceType.service}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Pickup Date</div>
                            <div class="info-value">${item.pickUpDate}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Pickup Time</div>
                            <div class="info-value">${item.pickUpTime}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Passengers</div>
                            <div class="info-value">${item.numberOfPassengers}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Luggage</div>
                            <div class="info-value">${item.bags} bag(s)</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Distance</div>
                            <div class="info-value">${item.distance}</div>
                        </div>
                        ${item.flightNumber ? `
                        <div class="info-item">
                            <div class="info-label">Flight Number</div>
                            <div class="info-value">${item.flightNumber}</div>
                        </div>
                        ` : ''}
                    </div>

                    <h2>Passenger Information</h2>
                    <div class="passenger-info">
                        <p><strong>Name:</strong> ${passenger.fullName}</p>
                        <p><strong>Email:</strong> ${passenger.email || '--'}</p>
                        <p><strong>Phone:</strong> ${passenger.phoneNo}</p>
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
                            <div style="color: #666; font-size: 0.9rem;">
                                👥 ${vehicle.seatingCapacity} passengers &nbsp;&nbsp; 🧳 ${vehicle.luggageCapacity} bags
                            </div>
                            <div style="margin-top: 5px; color: #666; font-size: 0.85rem;">
                                Partner: ${vehicle.partnerName}
                            </div>
                        </div>
                    </div>

                    <h2>Locations</h2>
                    ${pickupAddress ? `
                    <div class="location-item">
                        <div class="location-type">Pickup Location</div>
                        <div class="location-address">${pickupAddress.fullAddress}</div>
                    </div>
                    ` : ''}
                    ${dropoffAddress ? `
                    <div class="location-item">
                        <div class="location-type">Drop-off Location</div>
                        <div class="location-address">${dropoffAddress.fullAddress}</div>
                    </div>
                    ` : ''}

                    <div class="price-summary">
                        <h3 style="margin-bottom: 15px; font-size: 1.2rem;">Price Summary</h3>
                        <div class="price-row">
                            <span>Net Amount</span>
                            <span>${currency}${parseFloat(item.priceDetails.netAmount || item.priceDetails.grandTotal).toFixed(2)}</span>
                        </div>
                        ${item.priceDetails.discount > 0 ? `
                        <div class="price-row">
                            <span>Discount</span>
                            <span>-${currency}${parseFloat(item.priceDetails.discount).toFixed(2)}</span>
                        </div>
                        ` : ''}
                        ${item.priceDetails.taxAmount > 0 ? `
                        <div class="price-row">
                            <span>Tax (${item.priceDetails.taxPercentage}%)</span>
                            <span>${currency}${parseFloat(item.priceDetails.taxAmount).toFixed(2)}</span>
                        </div>
                        ` : ''}
                        <div class="price-total">
                            <span>Total Amount</span>
                            <span>${currency}${parseFloat(item.priceDetails.grandTotal).toFixed(2)}</span>
                        </div>
                    </div>

                    <a href="${paymentUrl}" class="btn-payment" target="_blank">
                        Proceed to Payment
                    </a>

                    <a href="/" class="btn-secondary">
                        Back to Home
                    </a>
                </div>
            `;
        }

        function showError(message) {
            const errorElement = document.getElementById('errorMessage');
            errorElement.textContent = message;
            errorElement.classList.add('active');
        }
    </script>
</body>
</html>
