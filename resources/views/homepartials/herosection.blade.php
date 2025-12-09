<!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="hero-content">
          <div class="row align-items-center">

            <div class="col-lg-6 hero-text" data-aos="fade-right" data-aos-delay="200">
              <div class="hero-badge">
                <i class="bi bi-house-heart"></i>
                <span>Your Trusted Property Partner</span>
              </div>
              <h1>Find Your Dream Property in Kenya</h1>
              <p>Your trusted partner in finding the perfect property. We connect buyers with their dream homes and investment opportunities across Kenya's most sought-after locations.</p>

              <div class="search-form" data-aos="fade-up" data-aos-delay="300">
                <form action="{{ route('properties.index') }}" method="GET">
                  @csrf
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="location" name="location" value="{{ request('location') }}" placeholder="Enter location (county, sub-county, or address)">
                        <label for="location">Location</label>
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

            </div><!-- End Hero Text -->

            <div class="col-lg-6 hero-images" data-aos="fade-left" data-aos-delay="400">
              <div class="image-stack">
                <div class="main-image">
                  <img src="assets/img/real-estate/property-exterior-3.webp" alt="Luxury Property" class="img-fluid">
                  <div class="property-tag">
                    <span class="price">$850,000</span>
                    <span class="type">Featured</span>
                  </div>
                </div>

                <div class="secondary-image">
                  <img src="assets/img/real-estate/property-interior-7.webp" alt="Property Interior" class="img-fluid">
                </div>

                <div class="floating-card">
                  <div class="agent-info">
                    <img src="assets/img/real-estate/agent-4.webp" alt="Agent" class="agent-avatar">
                    <div class="agent-details">
                      <h5>Sarah Johnson</h5>
                      <p>Top Real Estate Agent</p>
                      <div class="rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <span>4.9 (127 reviews)</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Hero Images -->

          </div>
        </div>

      </div>

    </section><!-- /Hero Section -->