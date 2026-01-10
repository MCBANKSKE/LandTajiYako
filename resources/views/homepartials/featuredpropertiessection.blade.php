<!-- Featured Properties Section -->
<section id="featured-properties" class="featured-properties section bg-light">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Featured Properties</h2>
                <p class="mb-0">Discover our handpicked selection of premium properties in prime locations across Kenya</p>
            </div>
            <div>
                <a href="{{ route('properties.index', ['is_featured' => true]) }}" class="btn btn-outline-primary">
                    View All Featured <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        @if($featuredProperties->isNotEmpty())
            <div class="featured-grid">
                <!-- Main Featured Property (First one) -->
                @if($mainProperty = $featuredProperties->first())
                    <div class="featured-main" data-aos="zoom-in" data-aos-delay="150">
                        <div class="card border-0 shadow-lg overflow-hidden h-100">
                            <div class="row g-0 h-100">
                                <div class="col-lg-7">
                                    <div class="position-relative h-100">
                                        <!-- Badges -->
                                        <div class="property-badges">
                                            @if($mainProperty->is_featured)
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-star-fill me-1"></i> Featured
                                                </span>
                                            @endif
                                            @if($mainProperty->is_premium)
                                                <span class="badge bg-purple">
                                                    <i class="bi bi-award-fill me-1"></i> Premium
                                                </span>
                                            @endif
                                            @if($mainProperty->is_verified)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-shield-check me-1"></i> Verified
                                                </span>
                                            @endif
                                            @if($mainProperty->is_on_discount)
                                                <span class="badge bg-danger">
                                                    {{ $mainProperty->discount_percentage }}% OFF
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Main Image -->
                                        <a href="{{ route('properties.show', $mainProperty) }}">
                                            <img src="{{ $mainProperty->featured_image_url }}" 
                                                 class="img-fluid h-100 w-100 object-fit-cover" 
                                                 alt="{{ $mainProperty->title }}"
                                                 loading="lazy">
                                        </a>
                                        
                                        <!-- Image Gallery Indicator -->
                                        @if($mainProperty->images->count() > 1)
                                            <div class="gallery-indicator">
                                                <i class="bi bi-images"></i>
                                                <span>{{ $mainProperty->images->count() }} Photos</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="card-body p-4 d-flex flex-column h-100">
                                        <!-- Property Type & Status -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <span class="badge bg-primary">{{ ucfirst($mainProperty->type) }}</span>
                                                <span class="badge bg-{{ $mainProperty->listing_type == 'sale' ? 'success' : 'info' }}">
                                                    {{ $mainProperty->listing_type == 'sale' ? 'For Sale' : 'For Rent' }}
                                                </span>
                                            </div>
                                            <div class="property-actions">
                                                <button class="btn btn-sm btn-outline-secondary favorite-btn" 
                                                        data-property-id="{{ $mainProperty->id }}">
                                                    <i class="bi bi-heart"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary share-btn"
                                                        data-property-url="{{ route('properties.show', $mainProperty) }}">
                                                    <i class="bi bi-share"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Property Title & Location -->
                                        <h3 class="card-title mb-2">
                                            <a href="{{ route('properties.show', $mainProperty) }}" class="text-dark">
                                                {{ $mainProperty->title }}
                                            </a>
                                        </h3>
                                        <div class="property-location mb-3">
                                            <i class="bi bi-geo-alt text-primary me-1"></i>
                                            <span class="text-muted">
                                                {{ $mainProperty->address ?? 'Location not specified' }}
                                                @if($mainProperty->county)
                                                    , {{ $mainProperty->county->county_name }}
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <!-- Property Description -->
                                        <p class="card-text flex-grow-1">
                                            {{ Str::limit(strip_tags($mainProperty->description), 200) }}
                                        </p>
                                        
                                        <!-- Property Specifications -->
                                        <div class="property-specs mb-4">
                                            <div class="row g-3">
                                                @if($mainProperty->bedrooms)
                                                    <div class="col-3">
                                                        <div class="spec-item text-center">
                                                            <div class="spec-icon">
                                                                <i class="bi bi-door-closed"></i>
                                                            </div>
                                                            <div class="spec-value">{{ $mainProperty->bedrooms }}</div>
                                                            <div class="spec-label">Beds</div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($mainProperty->bathrooms)
                                                    <div class="col-3">
                                                        <div class="spec-item text-center">
                                                            <div class="spec-icon">
                                                                <i class="bi bi-droplet"></i>
                                                            </div>
                                                            <div class="spec-value">{{ $mainProperty->bathrooms }}</div>
                                                            <div class="spec-label">Baths</div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($mainProperty->size)
                                                    <div class="col-3">
                                                        <div class="spec-item text-center">
                                                            <div class="spec-icon">
                                                                <i class="bi bi-arrows-angle-expand"></i>
                                                            </div>
                                                            <div class="spec-value">{{ number_format($mainProperty->size) }}</div>
                                                            <div class="spec-label">{{ $mainProperty->size_unit }}</div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($mainProperty->parking_spaces)
                                                    <div class="col-3">
                                                        <div class="spec-item text-center">
                                                            <div class="spec-icon">
                                                                <i class="bi bi-car-front"></i>
                                                            </div>
                                                            <div class="spec-value">{{ $mainProperty->parking_spaces }}</div>
                                                            <div class="spec-label">Parking</div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Price & CTA -->
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="property-price">
                                                    <h4 class="mb-0">{{ $mainProperty->display_price }}</h4>
                                                    @if($mainProperty->is_on_discount)
                                                        <small class="text-muted text-decoration-line-through">
                                                            KES {{ number_format($mainProperty->price, 2) }}
                                                        </small>
                                                    @endif
                                                </div>
                                                <div class="property-meta">
                                                    <small class="text-muted">
                                                        <i class="bi bi-eye me-1"></i> {{ $mainProperty->view_count }} views
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('properties.show', $mainProperty) }}" 
                                                   class="btn btn-primary btn-lg">
                                                    View Property Details
                                                </a>
                                                <a href="{{ route('contact') }}" 
                                                   class="btn btn-outline-primary">
                                                    <i class="bi bi-calendar-check me-1"></i> Schedule Viewing
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Other Featured Properties Grid -->
                <div class="featured-grid-secondary">
                    <div class="row g-4">
                        @foreach($featuredProperties->skip(1)->take(6) as $property)
                            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 200 }}">
                                <div class="property-card h-100">
                                    <!-- Card Image -->
                                    <div class="property-image position-relative">
                                        <a href="{{ route('properties.show', $property) }}">
                                            <img src="{{ $property->featured_image_url }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $property->title }}"
                                                 loading="lazy">
                                        </a>
                                        
                                        <!-- Badges -->
                                        <div class="property-badges">
                                            @if($property->is_featured)
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-star-fill"></i>
                                                </span>
                                            @endif
                                            @if($property->is_premium)
                                                <span class="badge bg-purple">Premium</span>
                                            @endif
                                            @if($property->is_on_discount)
                                                <span class="badge bg-danger">-{{ $property->discount_percentage }}%</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Quick Actions -->
                                        <div class="property-actions">
                                            <button class="btn btn-sm btn-light favorite-btn" 
                                                    data-property-id="{{ $property->id }}">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <!-- Property Type & Status -->
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    {{ ucfirst($property->type) }}
                                                </span>
                                                <span class="badge bg-{{ $property->listing_type == 'sale' ? 'success' : 'info' }} bg-opacity-10 text-{{ $property->listing_type == 'sale' ? 'success' : 'info' }}">
                                                    {{ $property->listing_type == 'sale' ? 'Sale' : 'Rent' }}
                                                </span>
                                            </div>
                                            @if($property->is_verified)
                                                <div class="verified-badge" title="Verified Property">
                                                    <i class="bi bi-shield-check text-success"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Title & Location -->
                                        <h5 class="card-title mb-1">
                                            <a href="{{ route('properties.show', $property) }}" class="text-dark">
                                                {{ Str::limit($property->title, 40) }}
                                            </a>
                                        </h5>
                                        <div class="property-location mb-2">
                                            <i class="bi bi-geo-alt text-muted me-1"></i>
                                            <small class="text-muted">
                                                {{ $property->county->county_name ?? 'Kenya' }}
                                            </small>
                                        </div>
                                        
                                        <!-- Specifications -->
                                        <div class="property-specs mb-3">
                                            <div class="row g-2">
                                                @if($property->bedrooms)
                                                    <div class="col">
                                                        <small class="text-muted">
                                                            <i class="bi bi-door-closed me-1"></i>
                                                            {{ $property->bedrooms }} Bed
                                                        </small>
                                                    </div>
                                                @endif
                                                @if($property->bathrooms)
                                                    <div class="col">
                                                        <small class="text-muted">
                                                            <i class="bi bi-droplet me-1"></i>
                                                            {{ $property->bathrooms }} Bath
                                                        </small>
                                                    </div>
                                                @endif
                                                @if($property->size)
                                                    <div class="col">
                                                        <small class="text-muted">
                                                            <i class="bi bi-arrows-angle-expand me-1"></i>
                                                            {{ number_format($property->size) }} {{ $property->size_unit }}
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Price & CTA -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="property-price">
                                                <h6 class="mb-0">{{ $property->display_price }}</h6>
                                                @if($property->is_on_discount)
                                                    <small class="text-muted text-decoration-line-through">
                                                        KES {{ number_format($property->price, 2) }}
                                                    </small>
                                                @endif
                                            </div>
                                            <a href="{{ route('properties.show', $property) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                Details
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Footer -->
                                    <div class="card-footer bg-transparent border-top">
                                        <div class="row g-2">
                                            <div class="col">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    {{ $property->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <div class="col text-end">
                                                <small class="text-muted">
                                                    <i class="bi bi-eye me-1"></i>
                                                    {{ $property->view_count }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- View More Button -->
            @if($featuredProperties->count() > 7)
                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('properties.index', ['is_featured' => true]) }}" 
                       class="btn btn-primary px-5">
                        View All Featured Properties
                        <span class="badge bg-light text-primary ms-2">{{ $stats['featured'] ?? 0 }}</span>
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="bi bi-house-x display-1 text-muted mb-3"></i>
                    <h3>No Featured Properties</h3>
                    <p class="text-muted mb-4">We're currently updating our featured properties. Please check back soon.</p>
                    <a href="{{ route('properties.index') }}" class="btn btn-primary">
                        Browse All Properties
                    </a>
                </div>
            </div>
        @endif
    </div>
</section><!-- /Featured Properties Section -->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Favorite button functionality
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const propertyId = this.dataset.propertyId;
            
            // Check if user is logged in
            @if(auth()->check())
                // Toggle favorite
                fetch('{{ route("properties.favorite", ":id") }}'.replace(':id', propertyId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const icon = this.querySelector('i');
                        if (data.is_favorite) {
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill');
                            this.classList.add('btn-danger');
                            this.classList.remove('btn-outline-secondary');
                            showToast('Property added to favorites!', 'success');
                        } else {
                            icon.classList.remove('bi-heart-fill');
                            icon.classList.add('bi-heart');
                            this.classList.remove('btn-danger');
                            this.classList.add('btn-outline-secondary');
                            showToast('Property removed from favorites!', 'info');
                        }
                    }
                });
            @else
                // Redirect to login
                window.location.href = '{{ route("login") }}';
            @endif
        });
    });

    // Share button functionality
    document.querySelectorAll('.share-btn').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.dataset.propertyUrl;
            
            // Create share modal or use Web Share API if available
            if (navigator.share) {
                navigator.share({
                    title: 'Check out this property!',
                    text: 'I found this amazing property you might be interested in.',
                    url: url,
                });
            } else {
                // Fallback to copy to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Link copied to clipboard!', 'success');
                });
            }
        });
    });

    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        // Add to container
        const container = document.getElementById('toast-container') || createToastContainer();
        container.appendChild(toast);
        
        // Initialize and show
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove after hide
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '1060';
        document.body.appendChild(container);
        return container;
    }
});
</script>
@endpush