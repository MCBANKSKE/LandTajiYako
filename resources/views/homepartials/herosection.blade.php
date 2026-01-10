<!-- Hero Section -->
<section id="hero" class="hero section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="hero-content">
            <div class="row align-items-center gy-5">

                <!-- Left Column: Text & Search -->
                <div class="col-lg-6 hero-text" data-aos="fade-right" data-aos-delay="200">
                    <div class="hero-badge">
                        <i class="bi bi-house-heart"></i>
                        <span>Your Trusted Property Partner</span>
                    </div>
                    
                    <h1>Find Your Dream Property in Kenya</h1>
                    <p>Discover prime lands, luxury homes, and commercial properties across Kenya's most sought-after locations. Your trusted partner for secure and profitable real estate investments.</p>

                    <!-- Stats -->
                    <div class="hero-stats mb-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="row g-4">
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3><span data-purecounter-start="0" data-purecounter-end="{{ $stats['total_properties'] ?? 2847 }}" class="purecounter"></span>+</h3>
                                    <p>Properties Listed</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3><span data-purecounter-start="0" data-purecounter-end="{{ $stats['verified_properties'] ?? 156 }}" class="purecounter"></span>+</h3>
                                    <p>Verified Properties</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3><span data-purecounter-start="0" data-purecounter-end="98" class="purecounter"></span>%</h3>
                                    <p>Client Satisfaction</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <div class="search-form" data-aos="fade-up" data-aos-delay="400">
                        <form action="{{ route('properties.index') }}" method="GET" id="hero-search-form">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="location" name="location" 
                                               value="{{ request('location') }}" 
                                               placeholder="Enter location, county, or landmark"
                                               data-autocomplete-url="{{ route('api.locations.autocomplete') }}">
                                        <label for="location"><i class="bi bi-geo-alt me-2"></i> Where are you looking?</label>
                                        <div class="autocomplete-results d-none"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="property_type" name="property_type">
                                            <option value="">Any Type</option>
                                            <option value="land" {{ request('property_type') == 'land' ? 'selected' : '' }}>Land</option>
                                            <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                                            <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                            <option value="commercial" {{ request('property_type') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                                            <option value="industrial" {{ request('property_type') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                                            <option value="farm" {{ request('property_type') == 'farm' ? 'selected' : '' }}>Farm</option>
                                        </select>
                                        <label for="property_type">Property Type</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="listing_type" name="listing_type">
                                            <option value="">For Sale or Rent</option>
                                            <option value="sale" {{ request('listing_type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                                            <option value="rent" {{ request('listing_type') == 'rent' ? 'selected' : '' }}>For Rent</option>
                                            <option value="lease" {{ request('listing_type') == 'lease' ? 'selected' : '' }}>For Lease</option>
                                        </select>
                                        <label for="listing_type">Listing Type</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select class="form-select" id="bedrooms" name="bedrooms">
                                                    <option value="">Any Bedrooms</option>
                                                    <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                                                    <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                                                    <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                                                    <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                                                    <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>5+</option>
                                                </select>
                                                <label for="bedrooms">Beds</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select class="form-select" id="bathrooms" name="bathrooms">
                                                    <option value="">Any Bathrooms</option>
                                                    <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                                                    <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                                                    <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                                                    <option value="4" {{ request('bathrooms') == '4' ? 'selected' : '' }}>4+</option>
                                                </select>
                                                <label for="bathrooms">Baths</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <select class="form-select" id="price_range" name="price_range">
                                                    <option value="">Any Price</option>
                                                    <option value="0-200000" {{ request('price_range') == '0-200000' ? 'selected' : '' }}>Under 200K</option>
                                                    <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>200K - 500K</option>
                                                    <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>500K - 1M</option>
                                                    <option value="1000000-5000000" {{ request('price_range') == '1000000-5000000' ? 'selected' : '' }}>1M - 5M</option>
                                                    <option value="5000000-10000000" {{ request('price_range') == '5000000-10000000' ? 'selected' : '' }}>5M - 10M</option>
                                                    <option value="10000000+" {{ request('price_range') == '10000000+' ? 'selected' : '' }}>Above 10M</option>
                                                    <option value="custom">Custom Range</option>
                                                </select>
                                                <label for="price_range">Price</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Custom Price Range (hidden by default) -->
                                <div class="col-12 custom-price-range" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="min_price" name="min_price" 
                                                       value="{{ request('min_price') }}" 
                                                       placeholder="Min Price" step="1000">
                                                <label for="min_price">Minimum Price (KES)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="max_price" name="max_price" 
                                                       value="{{ request('max_price') }}" 
                                                       placeholder="Max Price" step="1000">
                                                <label for="max_price">Maximum Price (KES)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-search me-2"></i>
                                            Search Properties
                                            <span class="badge bg-light text-primary ms-2">{{ $stats['total_properties'] ?? 0 }}</span>
                                        </button>
                                        <a href="{{ route('properties.index') }}" class="btn btn-outline-primary">
                                            <i class="bi bi-grid-3x3-gap me-2"></i>
                                            View All Properties
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- Right Column: Carousel -->
                <div class="col-lg-6 hero-images" data-aos="fade-left" data-aos-delay="500">
                    <div class="position-relative">
                        <!-- Premium Properties Badge -->
                        @if($premiumProperties->isNotEmpty())
                            <div class="premium-badge mb-3">
                                <i class="bi bi-stars"></i>
                                <span>Premium Properties</span>
                            </div>
                        @endif

                        <!-- Main Carousel -->
                        <div id="propertyCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($featuredProperties as $key => $property)
                                    <button type="button" data-bs-target="#propertyCarousel" 
                                            data-bs-slide-to="{{ $key }}" 
                                            class="{{ $key === 0 ? 'active' : '' }}" 
                                            aria-label="Slide {{ $key + 1 }}"></button>
                                @endforeach
                            </div>
                            
                            <div class="carousel-inner">
                                @foreach($featuredProperties as $key => $property)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <div class="image-stack">
                                            <!-- Main Image -->
                                            <div class="main-image">
                                                <img src="{{ $property->featured_image_url }}" 
                                                     alt="{{ $property->title }}" 
                                                     class="img-fluid rounded-3"
                                                     loading="{{ $key === 0 ? 'eager' : 'lazy' }}">
                                                <div class="image-overlay">
                                                    <div class="property-tags">
                                                        <span class="price-tag">
                                                            {{ $property->display_price }}
                                                        </span>
                                                        @if($property->is_featured)
                                                            <span class="featured-tag">
                                                                <i class="bi bi-star-fill me-1"></i> Featured
                                                            </span>
                                                        @endif
                                                        @if($property->is_premium)
                                                            <span class="premium-tag">
                                                                <i class="bi bi-award-fill me-1"></i> Premium
                                                            </span>
                                                        @endif
                                                        @if($property->is_verified)
                                                            <span class="verified-tag">
                                                                <i class="bi bi-shield-check me-1"></i> Verified
                                                            </span>
                                                        @endif
                                                        @if($property->is_on_discount)
                                                            <span class="discount-tag">
                                                                {{ $property->discount_percentage }}% OFF
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Secondary Images (if available) -->
                                            @if($property->images->count() > 1)
                                                <div class="secondary-images">
                                                    @foreach($property->images->take(2) as $image)
                                                        <div class="secondary-image">
                                                            <img src="{{ $image->thumbnail_url }}" 
                                                                 alt="{{ $image->alt_text ?? 'Property Image' }}" 
                                                                 class="img-fluid rounded-2"
                                                                 loading="lazy">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Floating Card -->
                                            <div class="floating-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="avatar me-3">
                                                            <i class="bi bi-person-circle fs-2"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">{{ $property->user->name ?? 'Land Taji Yako' }}</h6>
                                                            <div class="small text-muted">Certified Agent</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="property-info">
                                                        <h5 class="property-title mb-2">{{ Str::limit($property->title, 40) }}</h5>
                                                        <div class="property-location mb-2">
                                                            <i class="bi bi-geo-alt me-1"></i>
                                                            {{ $property->county->county_name ?? '' }}{{ $property->subCounty ? ', ' . $property->subCounty->constituency_name : '' }}
                                                        </div>
                                                        
                                                        <div class="property-specs mb-3">
                                                            @if($property->bedrooms)
                                                                <span class="spec-item">
                                                                    <i class="bi bi-door-closed me-1"></i>
                                                                    {{ $property->bedrooms }} {{ $property->bedrooms == 1 ? 'Bed' : 'Beds' }}
                                                                </span>
                                                            @endif
                                                            @if($property->bathrooms)
                                                                <span class="spec-item">
                                                                    <i class="bi bi-droplet me-1"></i>
                                                                    {{ $property->bathrooms }} {{ $property->bathrooms == 1 ? 'Bath' : 'Baths' }}
                                                                </span>
                                                            @endif
                                                            @if($property->size)
                                                                <span class="spec-item">
                                                                    <i class="bi bi-arrows-angle-expand me-1"></i>
                                                                    {{ $property->formatted_size }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="property-status">
                                                                <span class="badge bg-{{ $property->listing_type == 'sale' ? 'success' : 'info' }}">
                                                                    {{ $property->listing_type == 'sale' ? 'For Sale' : 'For Rent' }}
                                                                </span>
                                                            </div>
                                                            <a href="{{ route('properties.show', $property) }}" 
                                                               class="btn btn-sm btn-primary">
                                                                View Details <i class="bi bi-arrow-right ms-1"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Carousel Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                        <!-- Quick Links -->
                        <div class="quick-links mt-4">
                            <div class="row g-2">
                                <div class="col-4">
                                    <a href="{{ route('properties.index', ['listing_type' => 'sale']) }}" 
                                       class="quick-link-item">
                                        <i class="bi bi-house-door"></i>
                                        <span>Buy</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('properties.index', ['listing_type' => 'rent']) }}" 
                                       class="quick-link-item">
                                        <i class="bi bi-house-check"></i>
                                        <span>Rent</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('properties.index', ['is_verified' => true]) }}" 
                                       class="quick-link-item">
                                        <i class="bi bi-shield-check"></i>
                                        <span>Verified</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Custom price range toggle
    const priceRangeSelect = document.getElementById('price_range');
    const customPriceRange = document.querySelector('.custom-price-range');
    
    if (priceRangeSelect && customPriceRange) {
        priceRangeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customPriceRange.style.display = 'block';
            } else {
                customPriceRange.style.display = 'none';
            }
        });
        
        // Initialize on page load
        if (priceRangeSelect.value === 'custom') {
            customPriceRange.style.display = 'block';
        }
    }
    
    // Location autocomplete
    const locationInput = document.getElementById('location');
    const autocompleteResults = document.querySelector('.autocomplete-results');
    
    if (locationInput && autocompleteResults) {
        let timeout = null;
        
        locationInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                autocompleteResults.classList.add('d-none');
                return;
            }
            
            timeout = setTimeout(() => {
                fetch(`${locationInput.dataset.autocompleteUrl}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            autocompleteResults.innerHTML = data.map(item => `
                                <div class="autocomplete-item" data-value="${item.value}">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    ${item.label}
                                </div>
                            `).join('');
                            autocompleteResults.classList.remove('d-none');
                        } else {
                            autocompleteResults.classList.add('d-none');
                        }
                    })
                    .catch(() => {
                        autocompleteResults.classList.add('d-none');
                    });
            }, 300);
        });
        
        // Handle click on autocomplete item
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('autocomplete-item')) {
                locationInput.value = e.target.dataset.value;
                autocompleteResults.classList.add('d-none');
            }
        });
        
        // Close autocomplete when clicking outside
        document.addEventListener('click', function(e) {
            if (!locationInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
                autocompleteResults.classList.add('d-none');
            }
        });
    }
});
</script>
@endpush