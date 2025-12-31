<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalRydes - Book Your Ride</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            width: 100%;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        .booking-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .booking-card h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
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

        .btn-search {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.3s;
            margin-top: 10px;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-search:active {
            transform: translateY(0);
        }

        .footer {
            text-align: center;
            color: white;
            margin-top: 30px;
            opacity: 0.9;
        }

        .footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .header p {
                font-size: 1rem;
            }

            .booking-card {
                padding: 25px;
            }

            .booking-card h2 {
                font-size: 1.5rem;
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
            <h1>Book Your Ride</h1>
            <p>Find the perfect vehicle for your journey</p>
        </div>

        <div class="booking-card">
            <h2>Search Available Vehicles</h2>
            <form action="/vehicles" method="GET">
                <div class="form-group">
                    <label for="pickupLocation">Pickup Location</label>
                    <input type="text" id="pickupLocation" name="pickup" placeholder="Enter pickup address" required>
                </div>

                <div class="form-group">
                    <label for="dropoffLocation">Drop-off Location</label>
                    <input type="text" id="dropoffLocation" name="dropoff" placeholder="Enter drop-off address" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="pickupDate">Pickup Date</label>
                        <input type="date" id="pickupDate" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="pickupTime">Pickup Time</label>
                        <input type="time" id="pickupTime" name="time" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="passengers">Passengers</label>
                        <select id="passengers" name="passengers" required>
                            <option value="1">1 Passenger</option>
                            <option value="2" selected>2 Passengers</option>
                            <option value="3">3 Passengers</option>
                            <option value="4">4 Passengers</option>
                            <option value="5">5 Passengers</option>
                            <option value="6">6+ Passengers</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bags">Luggage</label>
                        <select id="bags" name="bags" required>
                            <option value="0">No Luggage</option>
                            <option value="1" selected>1 Bag</option>
                            <option value="2">2 Bags</option>
                            <option value="3">3 Bags</option>
                            <option value="4">4+ Bags</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-search">Search Vehicles</button>
            </form>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} LocalRydes. All rights reserved.</p>
            <p>
                <a href="#">About</a> |
                <a href="#">Contact</a> |
                <a href="#">Terms</a> |
                <a href="#">Privacy</a>
            </p>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_PLACE_API_KEY') }}&libraries=places"></script>
    <script>
        // Set default date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.getElementById('pickupDate').value = tomorrow.toISOString().split('T')[0];
        document.getElementById('pickupDate').min = new Date().toISOString().split('T')[0];

        // Set default time to 10:00
        document.getElementById('pickupTime').value = '10:00';

        // Initialize Google Places Autocomplete
        function initAutocomplete() {
            const pickupInput = document.getElementById('pickupLocation');
            const dropoffInput = document.getElementById('dropoffLocation');

            if (typeof google !== 'undefined' && google.maps) {
                const pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput);
                const dropoffAutocomplete = new google.maps.places.Autocomplete(dropoffInput);

                // Optional: Add listener for place selection
                pickupAutocomplete.addListener('place_changed', function() {
                    const place = pickupAutocomplete.getPlace();
                    console.log('Pickup location selected:', place);
                });

                dropoffAutocomplete.addListener('place_changed', function() {
                    const place = dropoffAutocomplete.getPlace();
                    console.log('Dropoff location selected:', place);
                });
            } else {
                console.error('Google Maps API not loaded');
            }
        }

        // Initialize autocomplete when page loads
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initAutocomplete, 100);
            });
        } else {
            setTimeout(initAutocomplete, 100);
        }
    </script>
</body>
</html>
