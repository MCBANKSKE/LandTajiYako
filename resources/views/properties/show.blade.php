@extends('layouts.app')

@section('title', ($meta['title'] ?? $property->title) . ' | ' . config('app.name'))

@push('meta')
    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ $meta['title'] ?? $property->title }}">
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="real_estate.property">
    <meta property="og:url" content="{{ $meta['url'] }}">
    <meta property="og:title" content="{{ $meta['title'] ?? $property->title }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:image" content="{{ $meta['image'] }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $meta['url'] }}">
    <meta property="twitter:title" content="{{ $meta['title'] ?? $property->title }}">
    <meta property="twitter:description" content="{{ $meta['description'] }}">
    <meta property="twitter:image" content="{{ $meta['image'] }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $meta['url'] }}" />
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateListing",
        "url": "{{ route('properties.show', $property) }}",
        "name": "{{ $property->title }}",
        "description": "{{ strip_tags($property->description) }}",
        "image": "{{ $property->featured_image_url }}",
        @if($property->address)
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $property->address }}",
            "addressLocality": "{{ $property->county->county_name ?? '' }}",
            "addressCountry": "KE"
        },
        @endif
        "offers": {
            "@type": "Offer",
            "price": "{{ $property->price }}",
            "priceCurrency": "KES",
            "availability": "https://schema.org/{{ $property->status === 'available' ? 'InStock' : 'OutOfStock' }}"
        },
        "numberOfRooms": {{ $property->bedrooms ?? 0 }},
        "numberOfBathroomsTotal": {{ $property->bathrooms ?? 0 }},
        "floorSize": {
            "@type": "QuantitativeValue",
            "value": "{{ $property->size }}",
            "unitCode": "{{ $property->size_unit === 'sqft' ? 'FTK' : 'MTK' }}"
        }
    }
    </script>
@endpush

@section('content')

<!-- Page Title -->
<div class="page-title">
    <div class="heading">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-10">
                    <h1 class="heading-title">{{ $property->title }}</h1>
                    <p class="mb-0">
                        <i class="bi bi-geo-alt me-1"></i>
                        {{ $property->address ?? $property->county->county_name ?? 'Location not specified' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <nav class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('properties.index') }}">Properties</a></li>
                <li class="current">{{ Str::limit($property->title, 30) }}</li>
            </ol>
        </div>
    </nav>
</div>

<!-- Property Details Section -->
<section id="property-details" class="property-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Property Gallery -->
                <div class="property-gallery mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="main-image-container position-relative">
                        <!-- Main Image -->
                        <div class="main-image-wrapper">
                            @if($property->images->isNotEmpty())
                                <img id="main-product-image" 
                                     src="{{ $property->images->first()->url }}" 
                                     alt="{{ $property->title }}" 
                                     class="img-fluid w-100 rounded-3 main-property-image"
                                     loading="eager">
                            @else
                                <img src="{{ asset('assets/img/real-estate/property-placeholder.jpg') }}" 
                                     alt="{{ $property->title }}" 
                                     class="img-fluid w-100 rounded-3 main-property-image"
                                     loading="eager">
                            @endif
                        </div>
                        
                        <!-- Badges -->
                        <div class="property-badges">
                            @if($property->is_featured)
                                <span class="badge bg-warning">
                                    <i class="bi bi-star-fill me-1"></i> Featured
                                </span>
                            @endif
                            @if($property->is_premium)
                                <span class="badge bg-purple">
                                    <i class="bi bi-award-fill me-1"></i> Premium
                                </span>
                            @endif
                            @if($property->is_verified)
                                <span class="badge bg-success">
                                    <i class="bi bi-shield-check me-1"></i> Verified
                                </span>
                            @endif
                            @if($property->is_on_discount)
                                <span class="badge bg-danger">
                                    -{{ $property->discount_percentage }}% OFF
                                </span>
                            @endif
                            @if($property->created_at->diffInDays(now()) < 7)
                                <span class="badge bg-info">New</span>
                            @endif
                        </div>
                        
                        <!-- Navigation Buttons -->
                        @if($property->images->count() > 1)
                            <div class="image-nav-buttons">
                                <button class="image-nav-btn prev-image" type="button">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button class="image-nav-btn next-image" type="button">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                            
                            <!-- Gallery Counter -->
                            <div class="gallery-counter">
                                <span id="current-image">1</span> / <span id="total-images">{{ $property->images->count() }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    @if($property->images->count() > 1)
                        <div class="thumbnail-gallery mt-3">
                            <div class="thumbnail-list">
                                @foreach($property->images as $image)
                                    <div class="thumbnail-item {{ $loop->first ? 'active' : '' }}" 
                                         data-index="{{ $loop->index }}"
                                         data-image="{{ $image->url }}">
                                        <img src="{{ $image->thumbnail_url }}" 
                                             alt="{{ $property->title }} - Image {{ $loop->iteration }}" 
                                             class="img-fluid rounded"
                                             loading="lazy">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Property Details -->
                <div class="property-details-content">
                    <!-- Overview -->
                    <div class="property-overview card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-body">
                            <div class="row">
                                <!-- Basic Info -->
                                <div class="col-lg-8">
                                    <div class="property-header mb-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h2 class="property-title mb-2">{{ $property->title }}</h2>
                                                <div class="property-location d-flex align-items-center mb-3">
                                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                                    <div>
                                                        <div class="fw-semibold">{{ $property->address ?? 'Address not specified' }}</div>
                                                        <div class="text-muted small">
                                                            {{ $property->ward ?? '' }}{{ $property->ward && $property->subCounty ? ', ' : '' }}
                                                            {{ $property->subCounty->constituency_name ?? '' }}{{ $property->subCounty && $property->county ? ', ' : '' }}
                                                            {{ $property->county->county_name ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="property-status">
                                                <span class="badge bg-{{ $property->status_label['color'] ?? 'success' }}">
                                                    {{ $property->status_label['label'] ?? ucfirst($property->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Property Type -->
                                        <div class="property-type mb-3">
                                            <span class="badge bg-primary bg-opacity-10 text-primary me-2">
                                                {{ ucfirst($property->type) }}
                                            </span>
                                            <span class="badge bg-{{ $property->listing_type == 'sale' ? 'success' : 'info' }} bg-opacity-10 text-{{ $property->listing_type == 'sale' ? 'success' : 'info' }}">
                                                For {{ $property->listing_type == 'sale' ? 'Sale' : 'Rent' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Specifications Grid -->
                                    <div class="property-specs-grid mb-4">
                                        <div class="row g-3">
                                            @if($property->bedrooms)
                                                <div class="col-6 col-md-3">
                                                    <div class="spec-item text-center p-3 border rounded">
                                                        <div class="spec-icon text-primary mb-2">
                                                            <i class="bi bi-door-closed fs-4"></i>
                                                        </div>
                                                        <div class="spec-value fw-bold">{{ $property->bedrooms }}</div>
                                                        <div class="spec-label text-muted">Bedrooms</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($property->bathrooms)
                                                <div class="col-6 col-md-3">
                                                    <div class="spec-item text-center p-3 border rounded">
                                                        <div class="spec-icon text-primary mb-2">
                                                            <i class="bi bi-droplet fs-4"></i>
                                                        </div>
                                                        <div class="spec-value fw-bold">{{ $property->bathrooms }}</div>
                                                        <div class="spec-label text-muted">Bathrooms</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($property->size)
                                                <div class="col-6 col-md-3">
                                                    <div class="spec-item text-center p-3 border rounded">
                                                        <div class="spec-icon text-primary mb-2">
                                                            <i class="bi bi-arrows-angle-expand fs-4"></i>
                                                        </div>
                                                        <div class="spec-value fw-bold">{{ number_format($property->size) }}</div>
                                                        <div class="spec-label text-muted">{{ $property->size_unit }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($property->floors)
                                                <div class="col-6 col-md-3">
                                                    <div class="spec-item text-center p-3 border rounded">
                                                        <div class="spec-icon text-primary mb-2">
                                                            <i class="bi bi-building fs-4"></i>
                                                        </div>
                                                        <div class="spec-value fw-bold">{{ $property->floors }}</div>
                                                        <div class="spec-label text-muted">Floors</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($property->parking_spaces)
                                                <div class="col-6 col-md-3">
                                                    <div class="spec-item text-center p-3 border rounded">
                                                        <div class="spec-icon text-primary mb-2">
                                                            <i class="bi bi-car-front fs-4"></i>
                                                        </div>
                                                        <div class="spec-value fw-bold">{{ $property->parking_spaces }}</div>
                                                        <div class="spec-label text-muted">Parking</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($property->year_built)
                                                <div class="col-6 col-md-3">
                                                    <div class="spec-item text-center p-3 border rounded">
                                                        <div class="spec-icon text-primary mb-2">
                                                            <i class="bi bi-calendar-check fs-4"></i>
                                                        </div>
                                                        <div class="spec-value fw-bold">{{ $property->year_built }}</div>
                                                        <div class="spec-label text-muted">Year Built</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Price Section -->
                                <div class="col-lg-4">
                                    <div class="property-price-section text-center">
                                        <div class="price-display mb-3">
                                            @if($property->is_on_discount)
                                                <div class="original-price text-muted text-decoration-line-through mb-1">
                                                    KES {{ number_format($property->price, 2) }}
                                                </div>
                                                <h2 class="discounted-price text-danger mb-2">
                                                    {{ $property->display_price }}
                                                </h2>
                                                <div class="discount-badge bg-danger text-white px-3 py-1 rounded-pill d-inline-block">
                                                    Save {{ $property->discount_percentage }}%
                                                </div>
                                            @else
                                                <h2 class="current-price text-primary mb-3">
                                                    {{ $property->display_price }}
                                                </h2>
                                            @endif
                                        </div>
                                        
                                        <!-- Price Per Unit -->
                                        @if($property->size)
                                            <div class="price-per-unit mb-3">
                                                <div class="text-muted small">Price per {{ $property->size_unit }}</div>
                                                <div class="fw-semibold">
                                                    KES {{ number_format($property->price / $property->size, 2) }}
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Monthly Payment if Installment -->
                                        @if($property->is_installment_available)
                                            <div class="installment-info mb-3">
                                                <div class="text-muted small">Monthly Payment</div>
                                                <div class="fw-bold text-success">
                                                    {{ $property->getMonthlyPayment() ?? 'Available on request' }}
                                                </div>
                                                @if($property->deposit)
                                                    <small class="text-muted">
                                                        Deposit: KES {{ number_format($property->deposit, 2) }}
                                                    </small>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <!-- Property Stats -->
                                        <div class="property-stats mt-3">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <div class="stat-item">
                                                        <div class="stat-value fw-bold">{{ $property->view_count }}</div>
                                                        <div class="stat-label text-muted small">Views</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="stat-item">
                                                        <div class="stat-value fw-bold">{{ $property->contact_count }}</div>
                                                        <div class="stat-label text-muted small">Inquiries</div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="stat-item">
                                                        <div class="stat-label text-muted small">Listed</div>
                                                        <div class="stat-value fw-bold">{{ $property->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="property-description card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-header bg-white border-bottom">
                            <h3 class="mb-0">About This Property</h3>
                        </div>
                        <div class="card-body">
                            <div class="description-content">
                                {!! $property->description ?? 'No description available.' !!}
                            </div>
                            
                            @if($property->additional_info)
                                <div class="additional-info mt-4">
                                    <h5>Additional Information</h5>
                                    {!! $property->additional_info !!}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Amenities & Features -->
                    @if(count($property->amenities ?? []) > 0 || count($property->features ?? []) > 0)
                        <div class="property-features card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="500">
                            <div class="card-header bg-white border-bottom">
                                <h3 class="mb-0">Amenities & Features</h3>
                            </div>
                            <div class="card-body">
                                @if(count($property->amenities ?? []) > 0)
                                    <div class="amenities-section mb-4">
                                        <h5 class="mb-3">Amenities</h5>
                                        <div class="row g-3">
                                            @foreach($property->amenities as $amenity)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="amenity-item d-flex align-items-center">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <span>{{ $amenity }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                @if(count($property->features ?? []) > 0)
                                    <div class="features-section">
                                        <h5 class="mb-3">Special Features</h5>
                                        <div class="row g-3">
                                            @foreach($property->features as $feature)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="feature-item d-flex align-items-center">
                                                        <i class="bi bi-star-fill text-warning me-2"></i>
                                                        <span>{{ $feature }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Map & Location -->
                    @if($property->google_map_link || $property->getLatitude())
                        <div class="property-map card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="600">
                            <div class="card-header bg-white border-bottom">
                                <h3 class="mb-0">Location</h3>
                            </div>
                            <div class="card-body">
                                @if($property->google_map_link)
                                    <div class="map-container mb-4">
                                        <div class="ratio ratio-16x9">
                                            {!! $property->google_map_link !!}
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="location-details">
                                    <h5 class="mb-3">Location Information</h5>
                                    <div class="row g-3">
                                        @if($property->address)
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <div class="detail-label text-muted">Address</div>
                                                    <div class="detail-value">{{ $property->address }}</div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($property->ward)
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <div class="detail-label text-muted">Ward</div>
                                                    <div class="detail-value">{{ $property->ward }}</div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($property->subCounty)
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <div class="detail-label text-muted">Sub-County</div>
                                                    <div class="detail-value">{{ $property->subCounty->constituency_name }}</div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($property->county)
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <div class="detail-label text-muted">County</div>
                                                    <div class="detail-value">{{ $property->county->county_name }}</div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($property->nearest_landmark)
                                            <div class="col-md-12">
                                                <div class="detail-item">
                                                    <div class="detail-label text-muted">Nearest Landmark</div>
                                                    <div class="detail-value">{{ $property->nearest_landmark }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Related Properties -->
                    @if($relatedProperties->isNotEmpty())
                        <div class="related-properties" data-aos="fade-up" data-aos-delay="700">
                            <h3 class="mb-4">Similar Properties</h3>
                            <div class="row g-4">
                                @foreach($relatedProperties as $property)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="property-card card h-100 border-0 shadow-sm">
                                            <div class="property-image position-relative">
                                                <a href="{{ route('properties.show', $property) }}">
                                                    <img src="{{ $property->featured_image_url }}" 
                                                         class="card-img-top" 
                                                         alt="{{ $property->title }}"
                                                         loading="lazy">
                                                </a>
                                                @if($property->is_featured)
                                                    <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                                        <i class="bi bi-star-fill"></i>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="{{ route('properties.show', $property) }}" class="text-dark">
                                                        {{ Str::limit($property->title, 40) }}
                                                    </a>
                                                </h5>
                                                <div class="property-location text-muted small mb-2">
                                                    <i class="bi bi-geo-alt"></i> {{ $property->county->county_name ?? 'Kenya' }}
                                                </div>
                                                <div class="property-specs small text-muted mb-3">
                                                    @if($property->bedrooms)
                                                        <span><i class="bi bi-door-closed"></i> {{ $property->bedrooms }}</span>
                                                    @endif
                                                    @if($property->bathrooms)
                                                        <span class="ms-2"><i class="bi bi-droplet"></i> {{ $property->bathrooms }}</span>
                                                    @endif
                                                    @if($property->size)
                                                        <span class="ms-2"><i class="bi bi-arrows-angle-expand"></i> {{ number_format($property->size) }} {{ $property->size_unit }}</span>
                                                    @endif
                                                </div>
                                                <div class="property-price fw-bold text-primary">
                                                    {{ $property->display_price }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-sidebar">
                    <!-- Contact Form -->
                    <div class="contact-form card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-header bg-white border-bottom">
                            <h4 class="mb-0">Schedule a Viewing</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('properties.schedule-viewing', $property) }}" method="POST" id="propertyContactForm">
                                @csrf
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Your Name *</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" name="phone" class="form-control" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Preferred Date & Time *</label>
                                    <input type="datetime-local" name="preferred_date" class="form-control" required>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" rows="3" 
                                              placeholder="Any specific requirements or questions..."></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-calendar-check me-2"></i> Request Viewing
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Property Actions -->
                    <div class="property-actions card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <!-- Favorite Button -->
                                <button class="btn btn-outline-primary favorite-btn" 
                                        data-property-id="{{ $property->id }}"
                                        id="favoriteButton">
                                    <i class="bi bi-heart"></i>
                                    <span id="favoriteText">Add to Favorites</span>
                                </button>
                                
                                <!-- Share Button -->
                                <button class="btn btn-outline-secondary share-btn" 
                                        data-property-url="{{ route('properties.show', $property) }}"
                                        data-property-title="{{ $property->title }}">
                                    <i class="bi bi-share"></i> Share Property
                                </button>
                                
                                <!-- Print Button -->
                                <button class="btn btn-outline-secondary" onclick="window.print()">
                                    <i class="bi bi-printer"></i> Print Details
                                </button>
                                
                                <!-- Download Brochure -->
                                <a href="{{ route('properties.download-brochure', $property) }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="bi bi-download"></i> Download Brochure
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Share Options -->
                    <div class="share-options card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="500">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Share This Property</h5>
                        </div>
                        <div class="card-body">
                            <div class="share-buttons d-flex justify-content-center gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('properties.show', $property)) }}" 
                                   target="_blank" class="share-btn facebook btn btn-outline-primary">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('properties.show', $property)) }}&text={{ urlencode($property->title) }}" 
                                   target="_blank" class="share-btn twitter btn btn-outline-info">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode('Check out this property: ' . $property->title . ' ' . route('properties.show', $property)) }}" 
                                   target="_blank" class="share-btn whatsapp btn btn-outline-success">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a href="mailto:?subject={{ urlencode('Property: ' . $property->title) }}&body={{ urlencode('Check out this property: ' . route('properties.show', $property)) }}" 
                                   class="share-btn email btn btn-outline-secondary">
                                    <i class="bi bi-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Property Stats -->
                    <div class="property-stats card border-0 shadow-sm" data-aos="fade-up" data-aos-delay="600">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">Property Statistics</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Property ID</span>
                                    <span class="fw-semibold">#{{ $property->id }}</span>
                                </li>
                                <li class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Views</span>
                                    <span class="fw-semibold">{{ $property->view_count }}</span>
                                </li>
                                <li class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Inquiries</span>
                                    <span class="fw-semibold">{{ $property->contact_count }}</span>
                                </li>
                                <li class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Listed On</span>
                                    <span class="fw-semibold">{{ $property->created_at->format('M d, Y') }}</span>
                                </li>
                                @if($property->year_built)
                                    <li class="d-flex justify-content-between py-2">
                                        <span class="text-muted">Year Built</span>
                                        <span class="fw-semibold">{{ $property->year_built }}</span>
                                    </li>
                                @endif
                                @if($property->age_of_property)
                                    <li class="d-flex justify-content-between py-2">
                                        <span class="text-muted">Property Age</span>
                                        <span class="fw-semibold">{{ $property->age_of_property }} years</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.property-gallery .main-image-container {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}
.main-image-wrapper {
    height: 500px;
    overflow: hidden;
}
.main-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.property-badges {
    position: absolute;
    top: 20px;
    left: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    z-index: 10;
}
.image-nav-buttons {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
    z-index: 10;
}
.image-nav-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
    transition: all 0.3s ease;
}
.image-nav-btn:hover {
    background: white;
    color: #0d6efd;
}
.gallery-counter {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    z-index: 10;
}
.thumbnail-list {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding: 5px 0;
}
.thumbnail-item {
    width: 100px;
    height: 80px;
    flex-shrink: 0;
    cursor: pointer;
    border: 2px solid transparent;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}
.thumbnail-item.active {
    border-color: #0d6efd;
}
.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.spec-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 16px;
    transition: all 0.3s ease;
}
.spec-item:hover {
    border-color: #0d6efd;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
}
.spec-icon {
    margin-bottom: 8px;
}
.amenity-item, .feature-item {
    padding: 8px 0;
}
.detail-item {
    margin-bottom: 12px;
}
.detail-label {
    font-size: 0.875rem;
    margin-bottom: 4px;
}
.detail-value {
    font-weight: 500;
}
.sticky-sidebar {
    position: sticky;
    top: 100px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image gallery functionality
    const mainImage = document.getElementById('main-product-image');
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    const currentImageSpan = document.getElementById('current-image');
    const totalImagesSpan = document.getElementById('total-images');
    const prevBtn = document.querySelector('.prev-image');
    const nextBtn = document.querySelector('.next-image');
    
    let currentImageIndex = 0;
    
    if (thumbnails.length > 0 && totalImagesSpan) {
        totalImagesSpan.textContent = thumbnails.length;
    }
    
    // Initialize thumbnails
    thumbnails.forEach(function(thumb, index) {
        thumb.addEventListener('click', function() {
            showImage(index);
        });
    });
    
    // Navigation buttons
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            showImage((currentImageIndex - 1 + thumbnails.length) % thumbnails.length);
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            showImage((currentImageIndex + 1) % thumbnails.length);
        });
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            showImage((currentImageIndex - 1 + thumbnails.length) % thumbnails.length);
        } else if (e.key === 'ArrowRight') {
            showImage((currentImageIndex + 1) % thumbnails.length);
        }
    });
    
    function showImage(index) {
        // Remove active class from all thumbnails
        thumbnails.forEach((thumb) => {
            thumb.classList.remove('active');
        });
        
        // Add active class to clicked thumbnail
        thumbnails[index].classList.add('active');
        
        // Update main image
        const newImageSrc = thumbnails[index].dataset.image;
        mainImage.src = newImageSrc;
        
        // Update current image index
        currentImageIndex = index;
        
        // Update counter
        if (currentImageSpan) {
            currentImageSpan.textContent = index + 1;
        }
        
        // Scroll thumbnail into view
        thumbnails[index].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });
    }
    
    // Favorite button functionality
    const favoriteButton = document.getElementById('favoriteButton');
    const favoriteText = document.getElementById('favoriteText');
    
    if (favoriteButton) {
        favoriteButton.addEventListener('click', async function() {
            const propertyId = this.dataset.propertyId;
            
            try {
                const response = await fetch(`/properties/${propertyId}/favorite`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const icon = this.querySelector('i');
                    if (data.is_favorite) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                        favoriteText.textContent = 'Added to Favorites';
                        this.classList.add('btn-danger');
                        this.classList.remove('btn-outline-primary');
                        showToast('Property added to favorites!', 'success');
                    } else {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                        favoriteText.textContent = 'Add to Favorites';
                        this.classList.remove('btn-danger');
                        this.classList.add('btn-outline-primary');
                        showToast('Property removed from favorites!', 'info');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Please login to favorite properties', 'warning');
            }
        });
    }
    
    // Share button functionality
    const shareButton = document.querySelector('.share-btn');
    
    if (shareButton) {
        shareButton.addEventListener('click', function() {
            const url = this.dataset.propertyUrl;
            const title = this.dataset.propertyTitle;
            
            // Use Web Share API if available
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Check out this amazing property!',
                    url: url,
                });
            } else {
                // Fallback to copy to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Link copied to clipboard!', 'success');
                });
            }
        });
    }
    
    // Contact form submission
    const contactForm = document.getElementById('propertyContactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
        });
    }
    
    // Toast notification function
    function showToast(message, type = 'info') {
        // Create toast container if it doesn't exist
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '1060';
            document.body.appendChild(toastContainer);
        }
        
        // Create toast element
        const toastEl = document.createElement('div');
        toastEl.className = 'toast align-items-center text-bg-' + type + ' border-0';
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        
        toastEl.innerHTML = '<div class="d-flex"><div class="toast-body">' + message + '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
        
        toastContainer.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
        
        // Remove toast after it's hidden
        toastEl.addEventListener('hidden.bs.toast', function() {
            toastEl.remove();
        });
    }
});
</script>
@endpush
@endsection