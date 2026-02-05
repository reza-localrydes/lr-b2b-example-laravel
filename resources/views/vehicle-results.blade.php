<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Available Vehicles - LocalRydes</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-book:hover {
            background: #45a049;
        }

        .btn-book:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .btn-book.loading {
            background: #45a049;
            cursor: wait;
        }

        .btn-book .spinner-inline {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
        }

        .btn-book.loading .spinner-inline {
            display: block;
        }

        .partner-info {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 0.85rem;
            color: #666;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Available Vehicles</h1>
            <p>Choose the perfect vehicle for your journey</p>
            <a href="/">&larr; Back to Search</a>
        </div>

        <!-- Error Message -->
        <div class="error-message" id="errorMessage"></div>

        <!-- Loading Indicator -->
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Loading available vehicles...</p>
        </div>

        <!-- No Results -->
        <div class="no-results" id="noResults">
            <h3>No vehicles found</h3>
            <p>Please try different search criteria.</p>
            <a href="/" style="color: #667eea; text-decoration: underline; margin-top: 20px; display: inline-block;">Back to Search</a>
        </div>

        <!-- Vehicles Container -->
        <div class="vehicles-container" id="vehiclesContainer"></div>
    </div>

    <script>
        // Booking ID from URL
        const bookingId = '{{ $bookingId }}';

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadVehicleResults();
        });

        function loadVehicleResults() {
            const savedData = localStorage.getItem('vehicleSearchResults');

            if (savedData) {
                try {
                    const searchData = JSON.parse(savedData);

                    // Verify bookingId matches
                    if (searchData.bookingId === bookingId) {
                        if (searchData.vehicles && searchData.vehicles.length > 0) {
                            console.log('Loading search results:', searchData.vehicles.length, 'vehicles');
                            displayVehicles(searchData.vehicles, searchData.bookingId);
                        } else {
                            document.getElementById('noResults').classList.add('active');
                        }
                    } else {
                        console.error('Booking ID mismatch');
                        document.getElementById('errorMessage').textContent = 'Invalid booking session. Please search again.';
                        document.getElementById('errorMessage').classList.add('active');
                    }
                } catch (error) {
                    console.error('Error loading results:', error);
                    document.getElementById('errorMessage').textContent = 'Failed to load vehicle results. Please try again.';
                    document.getElementById('errorMessage').classList.add('active');
                }
            } else {
                document.getElementById('noResults').classList.add('active');
            }
        }

        function displayVehicles(vehicles, bookingId) {
            const container = document.getElementById('vehiclesContainer');
            container.innerHTML = '';

            // Sort vehicles by price (ascending - lowest to highest)
            const sortedVehicles = vehicles.sort((a, b) => {
                const priceA = parseFloat(a.convertedPrice) || 0;
                const priceB = parseFloat(b.convertedPrice) || 0;
                return priceA - priceB;
            });

            sortedVehicles.forEach(vehicleData => {
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
                <img src="${vehicle.thumbnail || 'https://via.placeholder.com/400x200?text=Vehicle'}"
                     alt="${vehicle.title}"
                     class="vehicle-image"
                     onerror="this.src='https://via.placeholder.com/400x200?text=Vehicle'">
                <div class="vehicle-details">
                    <h3 class="vehicle-name">${vehicle.title}</h3>
                    <div class="vehicle-class" style="color: #667eea; font-size: 0.9rem; margin-bottom: 10px;">${vehicle.vehicleClass?.title || ''}</div>

                    <div class="vehicle-info">
                        <span>👥 ${vehicle.seatingCapacity} passengers</span>
                        <span>🧳 ${vehicle.luggageCapacity} bags</span>
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

                    ${vehicle.partnerName ? `<div class="partner-info">
                        <div><strong>Partner:</strong> Localrydes</div>
                    </div>` : ''}

                    <button class="btn-book"
                            ${vehicleData.customerCanBook ? '' : 'disabled'}
                            data-vehicle-id="${vehicle.id}"
                            onclick="bookVehicle('${vehicle.id}', event)">
                        <span class="btn-text">${vehicleData.customerCanBook ? 'Book Now' : 'Not Available'}</span>
                        <span class="spinner-inline"></span>
                    </button>
                </div>
            `;

            return card;
        }

        async function bookVehicle(vehicleId, event) {
            if (!vehicleId) {
                alert('Vehicle ID is not available.');
                return;
            }

            const button = event.target.closest('.btn-book');

            // Add loading state
            button.classList.add('loading');
            button.disabled = true;

            try {
                // Get booking ID from localStorage
                const savedData = localStorage.getItem('vehicleSearchResults');
                if (!savedData) {
                    throw new Error('Booking session not found. Please search again.');
                }

                const searchData = JSON.parse(savedData);
                const searchBookingId = searchData.bookingId;

                if (!searchBookingId) {
                    throw new Error('Booking ID not found. Please search again.');
                }

                // Call API to select vehicle
                const response = await fetch('/api/select-vehicle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        booking_id: searchBookingId,
                        vehicle_id: vehicleId.toString()
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Failed to select vehicle');
                }

                if (data.success && data.data) {
                    // Store booking info in localStorage
                    const bookingData = {
                        bookingId: data.data.bookingId,
                        bookingInfo: data.data.bookingInfo,
                        timestamp: new Date().getTime()
                    };
                    localStorage.setItem('selectedVehicleBooking', JSON.stringify(bookingData));

                    // Remove vehicle list from localStorage
                    localStorage.removeItem('vehicleSearchResults');

                    // Redirect to booking details page
                    window.location.href = `/booking/details/${data.data.bookingId}`;
                } else {
                    throw new Error('Invalid response from server');
                }

            } catch (error) {
                console.error('Booking error:', error);
                alert(error.message || 'Failed to book vehicle. Please try again.');

                // Remove loading state
                button.classList.remove('loading');
                button.disabled = false;
            }
        }
    </script>
</body>
</html>
