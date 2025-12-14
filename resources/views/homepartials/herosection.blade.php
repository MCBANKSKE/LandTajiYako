<!-- Hero Section -->
<section id="hero" class="hero section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="hero-content">
      <div class="row align-items-center">

        <!-- Left Column: Text & Search -->
        <div class="col-lg-6 hero-text" data-aos="fade-right" data-aos-delay="200">
          <div class="hero-badge">
            <i class="bi bi-house-heart"></i>
            <span>Your Trusted Property Partner</span>
          </div>
          
          <h1>Find Your Dream Property in Kenya</h1>
          <p>Your trusted partner in finding the perfect property. We connect buyers with their dream homes and investment opportunities across Kenya's most sought-after locations.</p>

          <!-- Search Form -->
          <div class="search-form" data-aos="fade-up" data-aos-delay="300">
            <form action="{{ route('properties.index') }}" method="GET">
              @csrf
              <div class="row g-3">
                <div class="col-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="location" name="location" value="{{ request('location') }}">
                    <label for="location">Location (county, sub-county, or address)</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="property-type" name="property_type">
                      <option value="">Any Type</option>
                      <option value="land" {{ request('property_type') == 'land' ? 'selected' : '' }}>Land</option>
                      <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                      <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                      <option value="commercial" {{ request('property_type') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                      <option value="industrial" {{ request('property_type') == 'industrial' ? 'selected' : '' }}>Industrial</option>
                    </select>
                    <label for="property-type">Property Type</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="price-range" name="price_range">
                      <option value="">Any Price Range</option>
                      <option value="0-200000" {{ request('price_range') == '0-200000' ? 'selected' : '' }}>Under KES 200K</option>
                      <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>KES 200K - 500K</option>
                      <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>KES 500K - 1M</option>
                      <option value="1000000-5000000" {{ request('price_range') == '1000000-5000000' ? 'selected' : '' }}>KES 1M - 5M</option>
                      <option value="5000000-10000000" {{ request('price_range') == '5000000-10000000' ? 'selected' : '' }}>KES 5M - 10M</option>
                      <option value="10000000+" {{ request('price_range') == '10000000+' ? 'selected' : '' }}>Above KES 10M</option>
                    </select>
                    <label for="price-range">Price Range</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="bedrooms" name="bedrooms">
                      <option value="">Any Bedrooms</option>
                      <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1 Bedroom</option>
                      <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2 Bedrooms</option>
                      <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3 Bedrooms</option>
                      <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4 Bedrooms</option>
                      <option value="5+" {{ request('bedrooms') == '5+' ? 'selected' : '' }}>5+ Bedrooms</option>
                    </select>
                    <label for="bedrooms">Bedrooms</label>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" id="bathrooms" name="bathrooms">
                      <option value="">Any Bathrooms</option>
                      <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1 Bathroom</option>
                      <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2 Bathrooms</option>
                      <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3 Bathrooms</option>
                      <option value="4+" {{ request('bathrooms') == '4+' ? 'selected' : '' }}>4+ Bathrooms</option>
                    </select>
                    <label for="bathrooms">Bathrooms</label>
                  </div>
                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-search w-100">
                    <i class="bi bi-search"></i>
                    Search Properties
                  </button>
                </div>
              </div>
            </form>
          </div>

          <!-- Stats -->
          <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
            <div class="row">
              <div class="col-4">
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="2847" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                  <p>Properties Listed</p>
                </div>
              </div>
              <div class="col-4">
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="156" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                  <p>Verified Agents</p>
                </div>
              </div>
              <div class="col-4">
                <div class="stat-item">
                  <h3><span data-purecounter-start="0" data-purecounter-end="98" data-purecounter-duration="1" class="purecounter"></span>%</h3>
                  <p>Client Satisfaction</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column: Carousel -->
        <div class="col-lg-6 hero-images" data-aos="fade-left" data-aos-delay="400">
          <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              @foreach($featuredProperties as $key => $property)
                <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
              @endforeach
            </div>
            
            <div class="carousel-inner">
              @foreach($featuredProperties as $key => $property)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                  <div class="image-stack">
                    <div class="main-image">
                      @if($property->featured_image)
                        <img src="{{ asset('storage/' . $property->featured_image) }}" alt="{{ $property->title }}" class="img-fluid">
                      @else
                        <img src="{{ asset('assets/img/real-estate/property-placeholder.jpg') }}" alt="{{ $property->title }}" class="img-fluid">
                      @endif
                      <div class="property-tag">
                        <span class="price">{{ $property->display_price }}</span>
                        @if($property->is_featured)
                          <span class="type">Featured</span>
                        @endif
                        @if($property->is_on_discount)
                          <span class="discount">{{ $property->discount_percentage }}% OFF</span>
                        @endif
                      </div>
                    </div>

                    @if($property->images->count() > 1)
                      <div class="secondary-image">
                        <img src="{{ asset('storage/' . $property->images[1]->path) }}" alt="{{ $property->images[1]->alt_text ?? 'Property Image' }}" class="img-fluid">
                      </div>
                    @endif

                    <div class="floating-card">
                      <div class="agent-info">
                        <div class="agent-avatar">
                          <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="agent-details">
                          <h5>{{ $property->user->name ?? 'Land Taji Yako' }}</h5>
                          <p>Real Estate Agent</p>
                          <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                              <i class="bi bi-star-fill {{ $i <= ($property->rating ?? 5) ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                            <span>{{ $property->reviews_count ?? 0 }} reviews</span>
                          </div>
                          <a href="{{ route('properties.show', $property) }}" class="btn-view-property">
                            View Property <i class="bi bi-arrow-right"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>