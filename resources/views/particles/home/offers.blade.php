 <!-- Special Offers Section -->
 <section class="special-offers-section" id="special-offers">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Exclusive Special Offers</h2>
            <p class="text-muted">Premium packages and event experiences tailored for you</p>
        </div>

        <!-- Loading State -->
        <div id="offersLoading" class="text-center" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Loading special offers...</p>
        </div>

        <!-- Offers Grid -->
        <div id="offersGrid" class="row g-4">
            <!-- Offers will be populated via JavaScript -->
        </div>

        <!-- View All Button -->
        <div class="text-center mt-5" id="viewAllButton" style="display: none;">
            <a href="/special-offers" class="btn btn-view-all">View All Offers</a>
        </div>
    </div>
</section>
