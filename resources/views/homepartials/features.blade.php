<!-- Featured Services Section -->
<section id="featured-services" class="featured-services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Our Services</h2>
        <p>Comprehensive real estate solutions tailored to meet your property needs in Kenya</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4 justify-content-center">

            <!-- Land Sales -->
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="service-card">
                    <div class="service-header">
                        <div class="service-icon">
                            <i class="bi bi-tree"></i>
                        </div>
                        <div class="service-number">01</div>
                    </div>
                    <div class="service-content">
                        <h3><a href="{{ route('properties.index', ['property_type' => 'land']) }}">Land Sales</a></h3>
                        <p>Discover prime land parcels across Kenya's most promising locations for investment and development</p>
                        <ul class="service-features">
                            <li><i class="bi bi-check2"></i> Title Deed Verification</li>
                            <li><i class="bi bi-check2"></i> Site Visits & Surveys</li>
                            <li><i class="bi bi-check2"></i> Flexible Payment Plans</li>
                        </ul>
                    </div>
                    <div class="service-action">
                        <a href="{{ route('properties.index', ['property_type' => 'land']) }}" class="service-btn">
                            <span>Browse Land</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div><!-- End Service Item -->

            <!-- Property Sales -->
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="service-card featured">
                    <div class="service-header">
                        <div class="service-icon">
                            <i class="bi bi-house"></i>
                        </div>
                        <div class="service-number">02</div>
                    </div>
                    <div class="service-content">
                        <h3><a href="{{ route('properties.index', ['property_type' => 'residential']) }}">Property Sales</a></h3>
                        <p>Find your dream home from our exclusive collection of residential and commercial properties</p>
                        <ul class="service-features">
                            <li><i class="bi bi-check2"></i> Verified Listings</li>
                            <li><i class="bi bi-check2"></i> Virtual & Physical Tours</li>
                            <li><i class="bi bi-check2"></i> Mortgage Facilitation</li>
                        </ul>
                    </div>
                    <div class="service-action">
                        <a href="{{ route('properties.index', ['property_type' => 'residential']) }}" class="service-btn">
                            <span>View Properties</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div><!-- End Service Item -->

            <!-- Property Management -->
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="service-card">
                    <div class="service-header">
                        <div class="service-icon">
                            <i class="bi bi-building-gear"></i>
                        </div>
                        <div class="service-number">03</div>
                    </div>
                    <div class="service-content">
                        <h3><a href="{{ route('services') }}">Property Management</a></h3>
                        <p>Professional property management services to maximize your real estate investment returns</p>
                        <ul class="service-features">
                            <li><i class="bi bi-check2"></i> Tenant & Lease Management</li>
                            <li><i class="bi bi-check2"></i> Maintenance Coordination</li>
                            <li><i class="bi bi-check2"></i> Financial Reporting</li>
                        </ul>
                    </div>
                    <div class="service-action">
                        <a href="{{ route('contact') }}" class="service-btn">
                            <span>Get Started</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div><!-- End Service Item -->

            <!-- Legal & Consultancy -->
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="500">
                <div class="service-card">
                    <div class="service-header">
                        <div class="service-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="service-number">04</div>
                    </div>
                    <div class="service-content">
                        <h3><a href="{{ route('services') }}">Legal & Consultancy</a></h3>
                        <p>Expert legal guidance and consultancy services for all your real estate transactions</p>
                        <ul class="service-features">
                            <li><i class="bi bi-check2"></i> Title Deed Processing</li>
                            <li><i class="bi bi-check2"></i> Contract Review</li>
                            <li><i class="bi bi-check2"></i> Property Transfer</li>
                        </ul>
                    </div>
                    <div class="service-action">
                        <a href="{{ route('contact') }}" class="service-btn">
                            <span>Consult Us</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div><!-- End Service Item -->

        </div>

        <div class="text-center" data-aos="fade-up" data-aos-delay="600">
            <a href="{{ route('services') }}" class="btn-all-services">
                <span>Explore All Our Services</span>
                <i class="bi bi-arrow-up-right"></i>
            </a>
        </div>
    </div>
</section><!-- /Featured Services Section -->
