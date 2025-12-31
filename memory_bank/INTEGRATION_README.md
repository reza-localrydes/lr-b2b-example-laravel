# LocalRydes B2B API Integration Package

This package contains everything you need to integrate LocalRydes vehicle booking into your website.

## 📦 Package Contents

### 1. `INTEGRATION_GUIDE.md`
Complete API documentation including:
- Getting started guide
- Authentication methods
- API endpoint specifications
- Request/response examples
- Code samples (JavaScript, PHP, Python)
- Error handling
- Best practices
- Testing guidelines

### 2. `integration-example.html`
A ready-to-use HTML template featuring:
- Complete vehicle search form
- Real-time API integration
- Beautiful UI with responsive design
- Vehicle display cards
- Loading states and error handling
- Sample implementation code

## 🚀 Quick Start

### Step 1: Get Your API Credentials

Contact LocalRydes support to obtain:
- Agency account
- API key (format: `lr_live_XXXXXXXXXXXX`)

### Step 2: Review the Documentation

Read `INTEGRATION_GUIDE.md` to understand:
- API endpoints
- Request/response formats
- Authentication requirements
- Rate limits and best practices

### Step 3: Test the Example

1. Open `integration-example.html`
2. Replace `YOUR_API_KEY_HERE` with your actual API key
3. Update the `baseUrl` to your environment
4. Open the file in a web browser
5. Test the vehicle search functionality

### Step 4: Customize for Your Website

Use the example as a starting point:
- Modify the UI to match your brand
- Add additional search filters
- Implement booking flow
- Integrate with your backend

## 📚 Documentation Overview

### Authentication

All requests require an API key in the header:
```http
x-api-key: lr_live_YOUR_API_KEY_HERE
```

### Main Endpoint

**Search Available Vehicles**
```
POST /api/v2/external/search-available-vehicles
```

**Required Parameters:**
- `trip_booking_type`: "transfer" or "hourly"
- `pick_up_location`: Location object with coordinates
- `drop_off_location`: Required for transfer type
- `pickup_date`: Date in YYYY/MM/DD format
- `pickup_time`: Time in HH:MM format
- `passengers`: Number of passengers (1-50)
- `bags`: Number of bags (0-50)

### Response Format

```json
{
  "success": true,
  "data": {
    "bookingId": "uuid",
    "availableVehicles": [
      {
        "id": 123,
        "vehicle": { ... },
        "price": 5500.00,
        "convertedPrice": 5500.00,
        ...
      }
    ]
  }
}
```

## 💡 Implementation Tips

### Security
- **Never expose your API key in client-side code in production**
- Use a server-side proxy to make API calls
- Implement request signing for additional security

### Performance
- Cache search results (5 minutes recommended)
- Implement retry logic with exponential backoff
- Monitor your API usage

### User Experience
- Show clear loading states
- Display meaningful error messages
- Implement price sorting/filtering
- Add vehicle comparison features

## 🔧 Customization Examples

### Server-Side Proxy (Recommended)

**Node.js/Express Example:**
```javascript
app.post('/api/search-vehicles', async (req, res) => {
  const response = await fetch('https://your-domain.com/api/v2/external/search-available-vehicles', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'x-api-key': process.env.LOCALRYDES_API_KEY
    },
    body: JSON.stringify(req.body)
  });

  const data = await response.json();
  res.json(data);
});
```

**PHP Example:**
```php
<?php
// proxy.php
$apiKey = getenv('LOCALRYDES_API_KEY');
$requestData = json_decode(file_get_contents('php://input'), true);

$ch = curl_init('https://your-domain.com/api/v2/external/search-available-vehicles');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'x-api-key: ' . $apiKey
]);

$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $response;
```

### Adding Google Places Autocomplete

1. Get a Google Maps API key
2. Add the script to your HTML:
```html
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY&libraries=places"></script>
```

3. Initialize autocomplete:
```javascript
const autocomplete = new google.maps.places.Autocomplete(inputElement);
autocomplete.addListener('place_changed', function() {
  const place = autocomplete.getPlace();
  // Extract lat, lng, place_id
});
```

## 📊 Rate Limits

- **Per Minute:** 60 requests
- **Per Day:** 10,000 requests

Monitor your usage:
```javascript
GET /api/v2/external/partner/api-keys/current
```

## 🐛 Troubleshooting

### Common Issues

**"Invalid API key" error:**
- Verify your API key is correct
- Check that the header name is `x-api-key`
- Ensure your account is active

**"Pickup time must be at least 12 hours in advance":**
- Check your date/time formatting
- Ensure pickup is at least 12 hours from now
- Verify timezone is correct

**"CORS error" in browser:**
- API calls should be made server-side
- Use a backend proxy to avoid CORS issues
- Contact support for CORS configuration

**No vehicles returned:**
- Check if locations are within service area
- Verify date/time is valid
- Try increasing passenger/bag capacity

## 📞 Support

### Getting Help

**Email:** api-support@localrydes.com
**Documentation:** https://docs.localrydes.com
**Status:** https://status.localrydes.com

### Before Contacting Support

Please have ready:
- Your agency ID
- API key preview (first/last 4 characters)
- Request/response examples
- Error messages with timestamps

## 🔄 Next Steps

After integrating vehicle search:

1. **Implement Booking Flow**
   - Vehicle selection
   - Passenger information
   - Payment processing
   - Booking confirmation

2. **Add Advanced Features**
   - Price filters and sorting
   - Vehicle comparison
   - Favorite locations
   - Booking history

3. **Optimize Performance**
   - Implement caching
   - Add loading states
   - Handle edge cases
   - Monitor analytics

4. **Test Thoroughly**
   - Test with various locations
   - Check different passenger counts
   - Verify pricing calculations
   - Test error scenarios

## 📄 License & Terms

By using the LocalRydes API, you agree to our:
- [Terms of Service](https://localrydes.com/terms)
- [Privacy Policy](https://localrydes.com/privacy)
- [API Usage Policy](https://docs.localrydes.com/api-policy)

## 🎉 Success Stories

Join hundreds of partners successfully using our API:
- Travel agencies
- Hotel concierge services
- Corporate travel platforms
- Tourism websites

---

**Happy integrating! 🚗**

For the latest updates, follow our [Developer Blog](https://blog.localrydes.com/developers).
