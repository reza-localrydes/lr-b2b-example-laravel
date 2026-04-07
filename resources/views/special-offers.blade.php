<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Offers - LocalRydes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Special Offers</h1>
                    <p class="lead text-muted">Discover exclusive deals and premium packages for your next journey</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="filters-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="filters-wrapper">
                        <!-- Search Bar -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search offers by title, location, or category...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select id="categoryFilter" class="form-select">
                                    <option value="">All Categories</option>
                                    <option value="airport">Airport Transfer</option>
                                    <option value="event">Event Package</option>
                                    <option value="tour">City Tour</option>
                                    <option value="wedding">Wedding Package</option>
                                    <option value="hourly">Hourly Service</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status Filters -->
                        <div class="status-filters">
                            <button class="filter-btn active" data-filter="all">
                                <i class="bi bi-grid"></i> All Offers
                            </button>
                            <button class="filter-btn" data-filter="ending-soon">
                                <i class="bi bi-hourglass-split"></i> Ending Soon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Offers Grid Section -->
    <section class="offers-grid-section">
        <div class="container">
            <!-- Loading State -->
            <div id="offersLoading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Loading special offers...</p>
            </div>

            <!-- Error State -->
            <div id="offersError" class="alert alert-danger d-none" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <span id="errorMessage">Failed to load special offers. Please try again later.</span>
            </div>

            <!-- Empty State -->
            <div id="offersEmpty" class="text-center py-5 d-none">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
                <h4 class="mt-3 text-muted">No offers found</h4>
                <p class="text-muted">Try adjusting your search or filters</p>
            </div>

            <!-- Offers Grid -->
            <div id="offersGrid" class="row g-4">
                <!-- Offers will be populated via JavaScript -->
            </div>

            <!-- Load More Indicator -->
            <div id="loadMoreIndicator" class="text-center py-4 d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading more...</span>
                </div>
                <p class="mt-2 text-muted">Loading more offers...</p>
            </div>

            <!-- Results Counter -->
            <div id="resultsCounter" class="text-center mt-4 d-none">
                <p class="text-muted">Showing <strong id="resultsCount">0</strong> of <strong id="totalCount">0</strong> offers</p>
            </div>

            <!-- End Message -->
            <div id="endMessage" class="text-center py-4 d-none">
                <p class="text-muted"><i class="bi bi-check-circle me-2"></i>You've reached the end of all offers</p>
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
        // Pagination state
        let currentPage = 0;
        let limit = 12; // Load 12 offers per page
        let isLoading = false;
        let hasMoreOffers = true;
        let totalOffersLoaded = 0;
        let currentFilters = {};

        // Fetch special offers on page load
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
            setupInfiniteScroll();
            loadOffers(true); // Initial load
        });

        function setupEventListeners() {
            // Search input
            document.getElementById('searchInput').addEventListener('input', debounce(function() {
                resetAndReload();
            }, 500));

            // Category filter
            document.getElementById('categoryFilter').addEventListener('change', function() {
                resetAndReload();
            });

            // Status filter buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    resetAndReload();
                });
            });
        }

        function setupInfiniteScroll() {
            window.addEventListener('scroll', debounce(function() {
                if (isLoading || !hasMoreOffers) return;

                const scrollPosition = window.innerHeight + window.scrollY;
                const pageHeight = document.documentElement.offsetHeight;

                // Load more when user is 300px from bottom
                if (scrollPosition >= pageHeight - 300) {
                    loadOffers(false);
                }
            }, 200));
        }

        function resetAndReload() {
            currentPage = 0;
            totalOffersLoaded = 0;
            hasMoreOffers = true;
            document.getElementById('offersGrid').innerHTML = '';
            document.getElementById('endMessage').classList.add('d-none');
            loadOffers(true);
        }

        async function loadOffers(isFirstLoad = false) {
            if (isLoading || !hasMoreOffers) return;

            isLoading = true;

            // Show appropriate loading state
            if (isFirstLoad) {
                document.getElementById('offersLoading').style.display = 'block';
                document.getElementById('offersError').classList.add('d-none');
                document.getElementById('offersEmpty').classList.add('d-none');
            } else {
                document.getElementById('loadMoreIndicator').classList.remove('d-none');
            }

            try {
                // Build query parameters based on your API structure
                const params = new URLSearchParams({
                    limit: limit,
                    skip: currentPage * limit
                });

                // Add search filter
                const searchTerm = document.getElementById('searchInput').value.trim();
                if (searchTerm) {
                    params.append('search_key', searchTerm);
                }

                // Add category filter (you may need to map category slug to ID)
                const category = document.getElementById('categoryFilter').value;
                if (category) {
                    // If your API uses category_id, you'll need to map the slug to ID
                    // For now, we'll pass it as is - adjust based on your API
                    params.append('category', category);
                }

                const response = await fetch(`/api/special-offers?${params.toString()}`);
                const data = await response.json();

                if (data.success && data.specialOffers) {
                    const offers = data.specialOffers;

                    // Apply client-side status filters
                    const statusFilter = document.querySelector('.filter-btn.active').dataset.filter;
                    const filteredOffers = applyStatusFilter(offers, statusFilter);

                    if (filteredOffers.length === 0 && currentPage === 0) {
                        showEmptyState();
                    } else if (filteredOffers.length < limit) {
                        // Received fewer offers than limit, likely the last page
                        hasMoreOffers = false;
                        appendOffers(filteredOffers);
                        if (totalOffersLoaded > 0) {
                            document.getElementById('endMessage').classList.remove('d-none');
                        }
                    } else {
                        appendOffers(filteredOffers);
                        currentPage++;
                    }

                    updateResultsCounter();
                } else {
                    if (currentPage === 0) {
                        showError('Failed to load special offers');
                    }
                }
            } catch (error) {
                console.error('Error fetching special offers:', error);
                if (currentPage === 0) {
                    showError('An error occurred while loading offers');
                }
            } finally {
                isLoading = false;
                document.getElementById('offersLoading').style.display = 'none';
                document.getElementById('loadMoreIndicator').classList.add('d-none');
            }
        }

        function applyStatusFilter(offers, statusFilter) {
            if (statusFilter === 'ending-soon') {
                return offers.filter(offer => isOfferEndingSoon(offer));
            }
            return offers;
        }

        function appendOffers(offers) {
            const grid = document.getElementById('offersGrid');

            offers.forEach(offer => {
                const cardHtml = createOfferCard(offer);
                grid.insertAdjacentHTML('beforeend', cardHtml);
                totalOffersLoaded++;
            });

            document.getElementById('offersEmpty').classList.add('d-none');
            document.getElementById('resultsCounter').classList.remove('d-none');
        }

        function showEmptyState() {
            document.getElementById('offersGrid').innerHTML = '';
            document.getElementById('offersEmpty').classList.remove('d-none');
            document.getElementById('resultsCounter').classList.add('d-none');
            hasMoreOffers = false;
        }

        function updateResultsCounter() {
            const countElement = document.getElementById('resultsCount');
            countElement.textContent = totalOffersLoaded;
        }

        function isOfferEndingSoon(offer) {
            const now = new Date();
            const endDate = new Date(offer.endDate);
            const daysUntilEnd = (endDate - now) / (1000 * 60 * 60 * 24);
            return daysUntilEnd > 0 && daysUntilEnd <= 7;
        }

        function createOfferCard(offer) {
            const finalPrice = calculateFinalPrice(offer.price, offer.discount, offer.discountType);
            const hasDiscount = offer.discount > 0;
            const isEndingSoon = isOfferEndingSoon(offer);
            const currencySymbol = offer.sourceCurrency?.symbol || '$';

            return `
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="offer-card">
                        ${isEndingSoon ? '<div class="offer-badge badge-ending">Ending Soon</div>' : ''}
                        ${hasDiscount && offer.discountType === 'percentage' ? `<div class="offer-badge badge-discount">${offer.discount}% OFF</div>` : ''}

                        <div class="offer-image">
                            <img src="${offer.thumbnail || '/images/default-offer.jpg'}" alt="${offer.title}">
                        </div>

                        <div class="offer-content">
                            <div class="offer-location">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>${offer.city?.name || 'Multiple Locations'}</span>
                            </div>

                            <h3 class="offer-title">${offer.title}</h3>

                            <div class="offer-meta">
                                ${offer.duration ? `<span><i class="bi bi-clock"></i> ${offer.duration} ${offer.durationUnit || 'hrs'}</span>` : ''}
                                ${offer.maxPassengerLimit ? `<span><i class="bi bi-people"></i> Up to ${offer.maxPassengerLimit}</span>` : ''}
                            </div>

                            <div class="offer-footer">
                                <div class="offer-price">
                                    ${hasDiscount ? `<span class="original-price">${currencySymbol}${offer.price.toLocaleString()}</span>` : ''}
                                    <span class="final-price">${currencySymbol}${finalPrice.toLocaleString()}</span>
                                </div>

                                <a href="/special-offer/${offer.slug}" class="btn-book">
                                    Book Now
                                </a>
                            </div>

                            <div class="offer-dates">
                                <i class="bi bi-calendar-range"></i>
                                ${formatDateRange(offer.startDate, offer.endDate)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
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

        function formatDateRange(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const options = { month: 'short', day: 'numeric' };

            return `${start.toLocaleDateString('en-US', options)} - ${end.toLocaleDateString('en-US', options)}`;
        }

        function truncateText(text, maxLength) {
            if (text.length <= maxLength) return text;
            return text.substring(0, maxLength) + '...';
        }

        function showError(message) {
            const errorDiv = document.getElementById('offersError');
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorDiv.classList.remove('d-none');
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    </script>
</body>
</html>
