@extends('layouts.app')

@section('title', 'Taji Yako Properties - Find Your Dream Property in Kenya')

@push('meta')
    <!-- Primary Meta Tags -->
    <meta name="title" content="Taji Yako Properties - Find Your Dream Property in Kenya">
    <meta name="description" content="Discover prime lands, residential and commercial properties across Kenya with Taji Yako Properties. Your trusted real estate partner for secure and profitable investments.">
    <meta name="keywords" content="real estate Kenya, land for sale in Kenya, houses for sale, apartments for rent, commercial property Kenya, prime land Kenya, real estate investment Kenya">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Taji Yako Properties - Find Your Dream Property in Kenya">
    <meta property="og:description" content="Discover prime lands, residential and commercial properties across Kenya with Taji Yako Properties. Your trusted real estate partner for secure and profitable investments.">
    <meta property="og:image" content="{{ asset('assets/img/favicon.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Taji Yako Properties - Find Your Dream Property in Kenya">
    <meta property="twitter:description" content="Discover prime lands, residential and commercial properties across Kenya with Taji Yako Properties. Your trusted real estate partner for secure and profitable investments.">
    <meta property="twitter:image" content="{{ asset('assets/img/favicon.png') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />
@endpush

@section('content')

<!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1 class="heading-title">Properties</h1>
              <p class="mb-0">
                Find your dream property in Kenya
              </p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="current">Properties</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Properties Section -->
    <section id="properties" class="properties section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">

          <div class="col-lg-8">

            <div class="properties-header mb-4">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="view-toggle d-flex gap-2">
                  <button class="btn btn-outline-secondary btn-sm view-btn active" data-view="grid">
                    <i class="bi bi-grid-3x3-gap"></i> Grid
                  </button>
                  <button class="btn btn-outline-secondary btn-sm view-btn" data-view="list">
                    <i class="bi bi-list"></i> List
                  </button>
                </div>
                <div class="sort-dropdown">
                  <select class="form-select form-select-sm">
                    <option>Sort by: Newest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Most Viewed</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="properties-grid view-grid active" data-aos="fade-up" data-aos-delay="200">
              <div class="row g-4">
                @forelse($properties as $property)
                <div class="col-lg-6 col-md-6">
                  <div class="property-card">
                    <div class="property-image">
                      <img src="{{ $property->featured_image ? asset('storage/' . $property->featured_image) : asset('img/no-image.jpg') }}" 
                           alt="{{ $property->title }}" class="img-fluid">
                      <div class="property-badges">
                        @if($property->is_featured)
                        <span class="badge featured">Featured</span>
                        @endif
                        <span class="badge for-sale">For {{ ucfirst($property->type) }}</span>
                      </div>
                      <div class="property-overlay">
                        <button class="favorite-btn"><i class="bi bi-heart"></i></button>
                        <button class="gallery-btn" data-count="12"><i class="bi bi-images"></i></button>
                      </div>
                    </div>
                    <div class="property-content">
                      <div class="property-price">KES {{ number_format($property->price) }}</div>
                      <h4 class="property-title">{{ $property->title }}</h4>
                      <p class="property-location">
                        <i class="bi bi-geo-alt"></i> 
                        {{ $property->address }}, {{ $property->county->name ?? '' }}
                      </p>
                      <div class="property-features">
                        @if($property->bedrooms)
                        <span><i class="bi bi-house"></i> {{ $property->bedrooms }} Bed</span>
                        @endif
                        @if($property->bathrooms)
                        <span><i class="bi bi-water"></i> {{ $property->bathrooms }} Bath</span>
                        @endif
                        @if($property->size)
                        <span><i class="bi bi-arrows-angle-expand"></i> {{ number_format($property->size) }} {{ $property->size_unit }}</span>
                        @endif
                      </div>
                      <div class="property-agent">
                        <div class="agent-info">
                          <strong>Taji Yako Properties</strong>
                          <div class="agent-contact">
                            <small><i class="bi bi-telephone"></i> +254 720 927 989</small>
                          </div>
                        </div>
                      </div>
                      <a href="{{ route('properties.show', $property) }}" class="btn btn-primary w-100">View Details</a>
                    </div>
                  </div>
                </div><!-- End Property Item -->
                @empty
                <div class="col-12">
                  <div class="alert alert-info text-center">
                    No properties found matching your criteria. Please try different search parameters.
                  </div>
                </div>
                @endforelse
              </div>
            </div>

            <div class="properties-list view-list" data-aos="fade-up" data-aos-delay="200">
              @forelse($properties as $property)
              <div class="property-list-item">
                <div class="row align-items-center">
                  <div class="col-lg-4">
                    <div class="property-image">
                      <img src="{{ $property->featured_image ? asset('storage/' . $property->featured_image) : asset('img/no-image.jpg') }}" 
                           alt="{{ $property->title }}" class="img-fluid">
                      <div class="property-badges">
                        @if($property->is_featured)
                        <span class="badge featured">Featured</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="property-content">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                          <h4 class="property-title mb-1">{{ $property->title }}</h4>
                          <p class="property-location mb-2">
                            <i class="bi bi-geo-alt"></i> 
                            {{ $property->address }}, {{ $property->county->name ?? '' }}
                          </p>
                        </div>
                        <div class="property-price">KES {{ number_format($property->price) }}</div>
                      </div>
                      <div class="property-features mb-3">
                        @if($property->bedrooms)
                        <span><i class="bi bi-house"></i> {{ $property->bedrooms }} Bed</span>
                        @endif
                        @if($property->bathrooms)
                        <span><i class="bi bi-water"></i> {{ $property->bathrooms }} Bath</span>
                        @endif
                        @if($property->size)
                        <span><i class="bi bi-arrows-angle-expand"></i> {{ number_format($property->size) }} {{ $property->size_unit }}</span>
                        @endif
                      </div>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="property-agent">
                          <span>Taji Yako Properties</span>
                        </div>
                        <div class="property-actions">
                          <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-heart"></i></button>
                          <a href="{{ route('properties.show', $property) }}" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- End Property List Item -->
              @empty
              <div class="property-list-item">
                <div class="row">
                  <div class="col-12">
                    <div class="alert alert-info text-center m-0">
                      No properties found matching your criteria. Please try different search parameters.
                    </div>
                  </div>
                </div>
              </div>
              @endforelse
            </div>

            @if($properties->hasPages())
            <nav class="mt-5" data-aos="fade-up" data-aos-delay="300">
              <ul class="pagination justify-content-center">
                {{ $properties->appends(request()->query())->links() }}
              </ul>
            </nav>
            @endif

          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">

            <div class="properties-sidebar">

              <div class="filter-widget">
                <h5 class="filter-title">Filter Properties</h5>
                <form action="{{ route('properties.index') }}" method="GET">
                  @csrf

                  <div class="filter-section">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="location" value="{{ request('location') }}" 
                           placeholder="City, county, or address">
                  </div>

                  <div class="filter-section">
                    <label class="form-label">Property Type</label>
                    <select class="form-select" name="property_type">
                      <option value="">All Types</option>
                      @foreach($propertyTypes as $type)
                        <option value="{{ $type }}" {{ request('property_type') == $type ? 'selected' : '' }}>
                          {{ ucfirst($type) }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="filter-section">
                    <label class="form-label">Price Range (KES)</label>
                    <select class="form-select" name="price_range">
                      <option value="">Any Price</option>
                      <option value="0-200000" {{ request('price_range') == '0-200000' ? 'selected' : '' }}>Under 200K</option>
                      <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>200K - 500K</option>
                      <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>500K - 1M</option>
                      <option value="1000000-5000000" {{ request('price_range') == '1000000-5000000' ? 'selected' : '' }}>1M - 5M</option>
                      <option value="5000000-10000000" {{ request('price_range') == '5000000-10000000' ? 'selected' : '' }}>5M - 10M</option>
                      <option value="10000000+" {{ request('price_range') == '10000000+' ? 'selected' : '' }}>Above 10M</option>
                    </select>
                  </div>

                  <div class="filter-section">
                    <label class="form-label">Bedrooms</label>
                    <div class="bedroom-filter">
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ !request('bedrooms') ? 'active' : '' }}" data-value="">Any</button>
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ request('bedrooms') == '1' ? 'active' : '' }}" data-value="1">1+</button>
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ request('bedrooms') == '2' ? 'active' : '' }}" data-value="2">2+</button>
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ request('bedrooms') == '3' ? 'active' : '' }}" data-value="3">3+</button>
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ request('bedrooms') == '4' ? 'active' : '' }}" data-value="4">4+</button>
                      <input type="hidden" name="bedrooms" id="bedrooms-input" value="{{ request('bedrooms') }}">
                    </div>
                  </div>

                  <div class="filter-section">
                    <label class="form-label">Bathrooms</label>
                    <div class="bathroom-filter">
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ !request('bathrooms') ? 'active' : '' }}" data-value="">Any</button>
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ request('bathrooms') == '1' ? 'active' : '' }}" data-value="1">1+</button>
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ request('bathrooms') == '2' ? 'active' : '' }}" data-value="2">2+</button>
                      <button type="button" class="btn btn-outline-secondary btn-sm filter-btn {{ request('bathrooms') == '3' ? 'active' : '' }}" data-value="3">3+</button>
                      <input type="hidden" name="bathrooms" id="bathrooms-input" value="{{ request('bathrooms') }}">
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                  <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary w-100 mt-2">Reset Filters</a>
                </form>
              </div>

              <div class="featured-properties mt-4">
                <h5>Featured Properties</h5>
                @if($featuredProperties->count() > 0)
                  @foreach($featuredProperties as $featuredProperty)
                  <div class="featured-item mb-3">
                    <div class="row g-3 align-items-center">
                      <div class="col-5">
                        <img src="{{ $featuredProperty->featured_image ? asset('storage/' . $featuredProperty->featured_image) : asset('img/no-image.jpg') }}" 
                             alt="{{ $featuredProperty->title }}" class="img-fluid rounded">
                      </div>
                      <div class="col-7">
                        <h6 class="mb-1">{{ $featuredProperty->title }}</h6>
                        <p class="text-muted small mb-1">{{ $featuredProperty->address }}</p>
                        <strong class="text-primary">KES {{ number_format($featuredProperty->price) }}</strong>
                      </div>
                    </div>
                  </div>
                  @endforeach
                @else
                  <div class="text-center text-muted">
                    <small>No featured properties at the moment</small>
                  </div>
                @endif
              </div>

            </div>

          </div>

        </div>

      </div>

    </section><!-- /Properties Section -->


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter buttons functionality
    const bedroomFilter = document.querySelector('.bedroom-filter');
    const bathroomFilter = document.querySelector('.bathroom-filter');
    
    if (bedroomFilter) {
        const bedroomButtons = bedroomFilter.querySelectorAll('.filter-btn');
        const bedroomInput = document.getElementById('bedrooms-input');
        
        bedroomButtons.forEach(button => {
            button.addEventListener('click', function() {
                bedroomButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                bedroomInput.value = this.dataset.value;
            });
        });
    }
    
    if (bathroomFilter) {
        const bathroomButtons = bathroomFilter.querySelectorAll('.filter-btn');
        const bathroomInput = document.getElementById('bathrooms-input');
        
        bathroomButtons.forEach(button => {
            button.addEventListener('click', function() {
                bathroomButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                bathroomInput.value = this.dataset.value;
            });
        });
    }
    
    // View toggle functionality (grid/list)
    const viewButtons = document.querySelectorAll('.view-btn');
    const viewGrid = document.querySelector('.view-grid');
    const viewList = document.querySelector('.view-list');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            if (this.dataset.view === 'grid') {
                viewGrid.classList.add('active');
                viewList.classList.remove('active');
            } else {
                viewGrid.classList.remove('active');
                viewList.classList.add('active');
            }
        });
    });
});
</script>
@endpush

@endsection