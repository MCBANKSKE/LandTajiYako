@php
use App\Models\Property;
$featuredProperties = Property::with('images')
    ->where('is_featured', true)
    ->where('status', 'available')
    ->latest()
    ->take(5)
    ->get();
@endphp

<!-- Why Us Section -->
<section id="why-us" class="why-us section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Why Choose Us</h2>
        <p>Discover the Land Taji Yako difference - Your trusted partner in real estate</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center gy-5">
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
                <div class="image-showcase">
                    @if($featuredProperties->isNotEmpty())
                    <div class="property-carousel swiper init-swiper">
                        <div class="swiper-wrapper">
                            @foreach($featuredProperties as $property)
                                @if($property->images->isNotEmpty())
                                    <div class="swiper-slide">
                                        <div class="main-image-wrapper">
                                            <img src="{{ asset('storage/' . $property->images->first()->path) }}" 
                                                 alt="{{ $property->title }}" 
                                                 class="img-fluid main-image">
                                            <div class="image-overlay">
                                                <a href="{{ route('properties.show', $property->slug) }}" class="overlay-link">
                                                    <div class="overlay-content">
                                                        <i class="bi bi-zoom-in"></i>
                                                        <span>View Property</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <script type="application/json" class="swiper-config">
                            {
                                "slidesPerView": 1,
                                "loop": true,
                                "autoplay": {
                                    "delay": 5000
                                },
                                "pagination": {
                                    "el": ".swiper-pagination",
                                    "clickable": true
                                }
                            }
                        </script>
                    </div>
                    @else
                    <div class="main-image-wrapper">
                        <img src="{{ asset('assets/img/real-estate/property-placeholder.jpg') }}" 
                             alt="Featured Properties" 
                             class="img-fluid main-image">
                    </div>
                    @endif

                    <div class="floating-stats">
                        <div class="stat-badge">
                            <span class="stat-number">10+</span>
                            <span class="stat-text">Years Experience</span>
                        </div>
                        <div class="stat-badge">
                            <span class="stat-number">500+</span>
                            <span class="stat-text">Happy Clients</span>
                        </div>
                    </div>

                    <div class="experience-card">
                        <div class="card-icon">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div class="card-content">
                            <h5>Trusted Experts</h5>
                            <p>Your trusted partner in real estate since 2013</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
                <div class="content-wrapper">
                    <div class="section-badge">
                        <i class="bi bi-star-fill me-2"></i>
                        Why Land Taji Yako
                    </div>

                    <h2>Your Trusted Partner in Real Estate</h2>
                    <p class="lead-text">At Land Taji Yako, we combine local expertise with a passion for helping you find your perfect property. Our dedicated team is committed to making your real estate journey smooth and successful.</p>

                    <div class="benefits-grid">
                        <div class="benefit-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="benefit-icon">
                                <i class="bi bi-house-heart-fill"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Wide Selection</h4>
                                <p>Explore our extensive portfolio of prime properties across Kenya's best locations.</p>
                            </div>
                        </div>

                        <div class="benefit-item" data-aos="fade-up" data-aos-delay="450">
                            <div class="benefit-icon">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Secure Transactions</h4>
                                <p>Enjoy peace of mind with our transparent and legally sound property transactions.</p>
                            </div>
                        </div>

                        <div class="benefit-item" data-aos="fade-up" data-aos-delay="500">
                            <div class="benefit-icon">
                                <i class="bi bi-currency-exchange"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Best Value</h4>
                                <p>Get the best market deals with our expert negotiation and market insights.</p>
                            </div>
                        </div>

                        <div class="benefit-item" data-aos="fade-up" data-aos-delay="550">
                            <div class="benefit-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Dedicated Support</h4>
                                <p>Our team provides personalized assistance throughout your property journey.</p>
                            </div>
                        </div>
                    </div>

                    <div class="achievement-highlights" data-aos="fade-up" data-aos-delay="600">
                        <div class="highlight-item">
                            <span class="highlight-number purecounter" data-purecounter-start="0" data-purecounter-end="98" data-purecounter-duration="2"></span>%
                            <span class="highlight-label">Client Satisfaction</span>
                        </div>
                        <div class="highlight-divider"></div>
                        <div class="highlight-item">
                            <span class="highlight-number purecounter" data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="2"></span>+
                            <span class="highlight-label">Properties Listed</span>
                        </div>
                        <div class="highlight-divider"></div>
                        <div class="highlight-item">
                            <span class="highlight-number">24</span>/7
                            <span class="highlight-label">Support</span>
                        </div>
                    </div>

                    <div class="action-buttons" data-aos="fade-up" data-aos-delay="650">
                        <a href="{{ route('properties.index') }}" class="btn btn-primary">Browse Properties</a>
                        <a href="{{ route('contact') }}" class="btn btn-outline">Get in Touch</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /Why Us Section -->
