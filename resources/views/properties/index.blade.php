@extends('layouts.app')

@section('content')
<!-- ======= Property Grid ======= -->
<section id="property-grid" class="property-grid">
    <div class="container" data-aos="fade-up">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Properties</li>
            </ol>
        </nav>
        
        <div class="section-header">
            <h2>Properties</h2>
            <p>Find your dream property in Kenya</p>
        </div>

        <div class="row">
            <!-- Sidebar with Filters -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <h4>Refine Search</h4>
                    <form action="{{ route('properties.index') }}" method="GET">
                        @csrf
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ request('location') }}" placeholder="City, county, or address">
                        </div>

                        <div class="mb-3">
                            <label for="property_type" class="form-label">Property Type</label>
                            <select class="form-select" id="property_type" name="property_type">
                                <option value="">All Types</option>
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type }}" {{ request('property_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price_range" class="form-label">Price Range (KES)</label>
                            <select class="form-select" id="price_range" name="price_range">
                                <option value="">Any Price</option>
                                <option value="0-200000" {{ request('price_range') == '0-200000' ? 'selected' : '' }}>Under 200K</option>
                                <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>200K - 500K</option>
                                <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>500K - 1M</option>
                                <option value="1000000-5000000" {{ request('price_range') == '1000000-5000000' ? 'selected' : '' }}>1M - 5M</option>
                                <option value="5000000-10000000" {{ request('price_range') == '5000000-10000000' ? 'selected' : '' }}>5M - 10M</option>
                                <option value="10000000+" {{ request('price_range') == '10000000+' ? 'selected' : '' }}>Above 10M</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bedrooms" class="form-label">Bedrooms</label>
                            <select class="form-select" id="bedrooms" name="bedrooms">
                                <option value="">Any</option>
                                <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                                <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                                <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                                <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                                <option value="5+" {{ request('bedrooms') == '5+' ? 'selected' : '' }}>5+</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bathrooms" class="form-label">Bathrooms</label>
                            <select class="form-select" id="bathrooms" name="bathrooms">
                                <option value="">Any</option>
                                <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                                <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                                <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                                <option value="4+" {{ request('bathrooms') == '4+' ? 'selected' : '' }}>4+</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary w-100 mt-2">Reset Filters</a>
                    </form>
                </div>
            </div>

            <!-- Property Listings -->
            <div class="col-lg-9">
                <div class="row">
                    @forelse($properties as $property)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="property-item">
                                <a href="{{ route('properties.show', $property) }}" class="img">
                                    <img src="{{ $property->featured_image ? asset('storage/' . $property->featured_image) : asset('img/no-image.jpg') }}" 
                                         alt="{{ $property->title }}" class="img-fluid">
                                    @if($property->is_featured)
                                        <div class="featured-badge">Featured</div>
                                    @endif
                                    <div class="property-info">
                                        <span class="price">KES {{ number_format($property->price) }}</span>
                                        <span class="type">{{ ucfirst($property->type) }}</span>
                                    </div>
                                </a>
                                <div class="property-content">
                                    <div class="location">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $property->address }}, {{ $property->county->name ?? '' }}
                                    </div>
                                    <h3>
                                        <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
                                    </h3>
                                    <ul class="property-features">
                                        <li>
                                            <i class="bi bi-house-door"></i>
                                            <span>{{ $property->bedrooms ?? 'N/A' }} Beds</span>
                                        </li>
                                        <li>
                                            <i class="bi bi-droplet"></i>
                                            <span>{{ $property->bathrooms ?? 'N/A' }} Baths</span>
                                        </li>
                                        <li>
                                            <i>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-fullscreen" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344 0a.5.5 0 0 1 .707 0l4.096 4.096V11.5a.5.5 0 1 1 1 0v3.975a.5.5 0 0 1-.5.5H11.5a.5.5 0 0 1 0-1h2.768l-4.096-4.096a.5.5 0 0 1 0-.707zm0-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707zm-4.344 0a.5.5 0 0 1-.707 0L1.025 1.732V4.5a.5.5 0 0 1-1 0V.525a.5.5 0 0 1 .5-.5H4.5a.5.5 0 0 1 0 1H1.732l4.096 4.096a.5.5 0 0 1 0 .707z"/>
                                                </svg>
                                            </i>
                                            <span>{{ number_format($property->size) }} {{ $property->size_unit }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                No properties found matching your criteria. Please try different search parameters.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($properties->hasPages())
                    <div class="pagination-wrapper">
                        {{ $properties->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section><!-- End Property Grid -->
@endsection

@push('styles')
<style>
.property-item {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.property-item:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

.property-item .img {
    position: relative;
    display: block;
    overflow: hidden;
    height: 200px;
}

.property-item .img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.property-item:hover .img img {
    transform: scale(1.05);
}

.featured-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ffc107;
    color: #000;
    padding: 3px 10px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 600;
}

.property-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    padding: 10px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.property-info .price {
    font-weight: 700;
    font-size: 1.1rem;
    color: #fff;
}

.property-info .type {
    background: #ff6b6b;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 600;
}

.property-content {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.property-content .location {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
}

.property-content .location i {
    margin-right: 5px;
}

.property-content h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.property-content h3 a {
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.property-content h3 a:hover {
    color: #3498db;
}

.property-features {
    list-style: none;
    padding: 0;
    margin: 15px 0 0;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.property-features li {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
    color: #6c757d;
}

.property-features i {
    margin-right: 5px;
    color: #3498db;
}

/* Sidebar styles */
.sidebar {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
}

.sidebar h4 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e0e0e0;
    color: #2c3e50;
}

/* Pagination styles */
.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination .page-link {
    color: #3498db;
    border: 1px solid #dee2e6;
    margin: 0 3px;
    border-radius: 4px;
}

.pagination .page-item.active .page-link {
    background-color: #3498db;
    border-color: #3498db;
    color: #fff;
}

.pagination .page-link:hover {
    background-color: #f8f9fa;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .property-item {
        margin-bottom: 30px;
    }
    
    .sidebar {
        margin-bottom: 30px;
    }
}
</style>
@endpush
