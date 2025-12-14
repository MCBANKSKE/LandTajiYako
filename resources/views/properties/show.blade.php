@extends('layouts.app')

@section('content')
<!-- Page Title -->
<div class="page-title">
  <div class="heading">
    <div class="container">
      <div class="row d-flex justify-content-center text-center">
        <div class="col-lg-8">
          <h1 class="heading-title">{{ $property->title }}</h1>
          
        </div>
      </div>
    </div>
  </div>
  <nav class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('properties.index') }}">Properties</a></li>
        <li class="current">{{ $property->title }}</li>
      </ol>
    </div>
  </nav>
</div>

<!-- Property Details Section -->
<section id="property-details" class="property-details section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      <div class="col-lg-8">
        <!-- Property Gallery -->
        <div class="property-gallery" data-aos="fade-up" data-aos-delay="200">
          @if($property->images->isNotEmpty())
            <div class="main-image-container image-zoom-container">
              <img id="main-product-image" 
                   src="{{ asset('storage/' . $property->images->first()->path) }}" 
                   alt="{{ $property->title }}" 
                   class="img-fluid main-property-image"
                   data-zoom="{{ asset('storage/' . $property->images->first()->path) }}">
              <div class="image-nav-buttons">
                <button class="image-nav-btn prev-image" type="button">
                  <i class="bi bi-chevron-left"></i>
                </button>
                <button class="image-nav-btn next-image" type="button">
                  <i class="bi bi-chevron-right"></i>
                </button>
              </div>
            </div>
            <div class="thumbnail-gallery thumbnail-list">
              @foreach($property->images as $image)
                <div class="thumbnail-item {{ $loop->first ? 'active' : '' }}" 
                     data-image="{{ asset('storage/' . $image->path) }}">
                  <img src="{{ asset('storage/' . $image->path) }}" 
                       alt="{{ $property->title }} - Image {{ $loop->iteration }}" 
                       class="img-fluid">
                </div>
              @endforeach
            </div>
          @else
            <div class="main-image-container">
              <img src="{{ asset('assets/img/real-estate/property-placeholder.jpg') }}" 
                   alt="No images available" 
                   class="img-fluid main-property-image">
            </div>
          @endif
        </div>

        <!-- Property Description -->
        <div class="property-description" data-aos="fade-up" data-aos-delay="300">
          <h3>About This Property</h3>
          {!! $property->description ?? 'No description available.' !!}
          
          @if($property->additional_info)
            {!! $property->additional_info !!}
          @endif
        </div>

        <!-- Amenities -->
        <div class="property-amenities" data-aos="fade-up" data-aos-delay="400">
          <h3>Amenities & Features</h3>
          <div class="row">
            <div class="col-md-6">
              <h4>Property Details</h4>
              <ul class="features-list">
                <li><i class="bi bi-check-circle"></i> {{ $property->bedrooms ?? 'N/A' }} Bedrooms</li>
                <li><i class="bi bi-check-circle"></i> {{ $property->bathrooms ?? 'N/A' }} Bathrooms</li>
                @if($property->floors)
                  <li><i class="bi bi-check-circle"></i> {{ $property->floors }} Floors</li>
                @endif
                @if($property->size)
                  <li><i class="bi bi-check-circle"></i> {{ number_format($property->size) }} {{ $property->size_unit ?? 'sq ft' }}</li>
                @endif
              </ul>
            </div>
            <div class="col-md-6">
           <!--   <h4>Features</h4>
              <ul class="features-list">
                @if($property->features && is_array($property->features))
                  @foreach(array_slice($property->features, 0, 5) as $feature)
                    <li><i class="bi bi-check-circle"></i> {{ $feature }}</li>
                  @endforeach
                @else
                  <li>No additional features listed</li>
                @endif
              </ul> -->
            </div>
          </div>
        </div>

        <!-- Map Section -->
        @if($property->google_map_link)
        <div class="property-map" data-aos="fade-up" data-aos-delay="500">
          <h3>Location</h3>
          <div class="map-container">
            {!! $property->google_map_link !!}
          </div>
          <div class="location-details">
            <h4>Location Information</h4>
            <p>
              {{ $property->address }}<br>
              {{ $property->ward }}, {{ $property->subCounty->name ?? '' }}<br>
              {{ $property->county->county_name ?? '' }}
            </p>
            @if($property->nearest_landmark)
              <p><strong>Nearest Landmark:</strong> {{ $property->nearest_landmark }}</p>
            @endif
          </div>
        </div>
        @endif
      </div>

      <div class="col-lg-4">
        <!-- Property Overview -->
        <div class="property-overview sticky-top" data-aos="fade-up" data-aos-delay="200">
          <div class="price-tag">
            @if($property->is_on_discount)
              <span class="original-price">KSH {{ number_format($property->price) }}</span>
              <span class="discounted-price">KSH {{ number_format($property->discounted_price) }}</span>
              <span class="discount-badge">Save {{ $property->discount_percentage }}%</span>
            @else
              KSH {{ number_format($property->price) }}
            @endif
          </div>
          
          <div class="property-status">
            {{ ucfirst($property->status) }}
            @if($property->is_featured)
              <span class="featured-badge">Featured</span>
            @endif
          </div>

          <div class="property-address">
            <h4>{{ $property->title }}</h4>
            <p>
              {{ $property->address }}<br>
              {{ $property->ward }}, {{ $property->county->county_name ?? '' }}
            </p>
          </div>

          <div class="property-stats">
            <div class="stat-item">
              <i class="bi bi-house"></i>
              <div>
                <span class="value">{{ $property->bedrooms ?? 'N/A' }}</span>
                <span class="label">Bedrooms</span>
              </div>
            </div>
            <div class="stat-item">
              <i class="bi bi-droplet"></i>
              <div>
                <span class="value">{{ $property->bathrooms ?? 'N/A' }}</span>
                <span class="label">Bathrooms</span>
              </div>
            </div>
            @if($property->size)
            <div class="stat-item">
              <i class="bi bi-rulers"></i>
              <div>
                <span class="value">{{ number_format($property->size) }}</span>
                <span class="label">{{ $property->size_unit ?? 'Sq Ft' }}</span>
              </div>
            </div>
            @endif
            @if($property->floors)
            <div class="stat-item">
              <i class="bi bi-building"></i>
              <div>
                <span class="value">{{ $property->floors }}</span>
                <span class="label">Floors</span>
              </div>
            </div>
            @endif
          </div>

          <!-- Contact Form -->
          <div class="contact-form mt-4">
            <h4>Schedule a Viewing</h4>
            <form action="{{ route('contact.submit') }}" method="POST" class="php-email-form">
              @csrf
              <input type="hidden" name="property_id" value="{{ $property->id }}">
              <input type="hidden" name="subject" value="Viewing Request for {{ $property->title }}">
              
              <div class="form-group mb-3">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
              </div>
              <div class="form-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
              </div>
              <div class="form-group mb-3">
                <input type="tel" name="phone" class="form-control" placeholder="Your Phone" required>
              </div>
              <div class="form-group mb-3">
                <input type="datetime-local" name="preferred_date" class="form-control" required>
              </div>
              <div class="form-group mb-3">
                <textarea class="form-control" name="message" rows="3" placeholder="Your Message"></textarea>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Request Viewing</button>
              </div>
            </form>
          </div>

          <!-- Share Buttons -->
          <div class="social-share mt-4">
            <h5>Share This Property</h5>
            <div class="share-buttons">
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                 target="_blank" class="share-btn facebook">
                <i class="bi bi-facebook"></i>
              </a>
              <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($property->title) }}" 
                 target="_blank" class="share-btn twitter">
                <i class="bi bi-twitter"></i>
              </a>
              <a href="https://wa.me/?text={{ urlencode('Check out this property: ' . $property->title . ' ' . url()->current()) }}" 
                 target="_blank" class="share-btn whatsapp">
                <i class="bi bi-whatsapp"></i>
              </a>
              <a href="mailto:?subject={{ urlencode('Property: ' . $property->title) }}&body={{ urlencode('Check out this property: ' . url()->current()) }}" 
                 class="share-btn email">
                <i class="bi bi-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
/* Add your custom styles here */
.price-tag {
  font-size: 1.8rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 0.5rem;
}
.original-price {
  text-decoration: line-through;
  color: #7f8c8d;
  margin-right: 10px;
  font-size: 1.2rem;
}
.discounted-price {
  color: #e74c3c;
  font-weight: bold;
}
.discount-badge {
  background: #e74c3c;
  color: white;
  font-size: 0.8rem;
  padding: 2px 8px;
  border-radius: 10px;
  margin-left: 10px;
  position: relative;
  top: -5px;
}
.property-status {
  color: #27ae60;
  font-weight: 600;
  margin-bottom: 1rem;
}
.featured-badge {
  background: #f39c12;
  color: white;
  font-size: 0.7rem;
  padding: 2px 8px;
  border-radius: 10px;
  margin-left: 10px;
}
.property-address {
  margin-bottom: 1.5rem;
}
.property-address h4 {
  margin-bottom: 0.5rem;
  color: #2c3e50;
}
.property-stats {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  margin-bottom: 1.5rem;
}
.stat-item {
  display: flex;
  align-items: center;
  padding: 0.75rem;
  background: #f8f9fa;
  border-radius: 8px;
}
.stat-item i {
  font-size: 1.5rem;
  color: #3498db;
  margin-right: 0.75rem;
}
.stat-item .value {
  display: block;
  font-weight: 700;
  color: #2c3e50;
}
.stat-item .label {
  font-size: 0.8rem;
  color: #7f8c8d;
}
.contact-form {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
}
.share-buttons {
  display: flex;
  gap: 0.5rem;
}
.share-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  color: white;
  text-decoration: none;
  transition: all 0.3s ease;
}
.share-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.facebook { background: #3b5998; }
.twitter { background: #1da1f2; }
.whatsapp { background: #25d366; }
.email { background: #7f8c8d; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Image gallery functionality
  const mainImage = document.getElementById('main-product-image');
  const thumbnails = document.querySelectorAll('.thumbnail-item');
  
  if (thumbnails.length > 0) {
    thumbnails.forEach(thumb => {
      thumb.addEventListener('click', function() {
        // Remove active class from all thumbnails
        thumbnails.forEach(t => t.classList.remove('active'));
        
        // Add active class to clicked thumbnail
        this.classList.add('active');
        
        // Update main image
        const newImageSrc = this.getAttribute('data-image');
        mainImage.src = newImageSrc;
        mainImage.setAttribute('data-zoom', newImageSrc);
      });
    });
  }

  // Image navigation
  const prevBtn = document.querySelector('.prev-image');
  const nextBtn = document.querySelector('.next-image');

  if (prevBtn && nextBtn) {
    prevBtn.addEventListener('click', () => navigateImages(-1));
    nextBtn.addEventListener('click', () => navigateImages(1));
  }

  function navigateImages(direction) {
    const activeThumb = document.querySelector('.thumbnail-item.active');
    const thumbnails = Array.from(document.querySelectorAll('.thumbnail-item'));
    const currentIndex = thumbnails.indexOf(activeThumb);
    const newIndex = (currentIndex + direction + thumbnails.length) % thumbnails.length;
    
    thumbnails[newIndex].click();
  }

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      navigateImages(-1);
    } else if (e.key === 'ArrowRight') {
      navigateImages(1);
    }
  });
});
</script>
@endpush
@endsection