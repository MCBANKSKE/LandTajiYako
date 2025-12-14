@php
use App\Models\Testimonial;
$testimonials = Testimonial::where('is_featured', true)
    ->orderBy('sort_order')
    ->orderBy('created_at', 'desc')
    ->get();
@endphp

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section light-background">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>What Our Clients Say</h2>
        <p>Hear from our satisfied clients about their experience with Land Taji Yako</p>
    </div><!-- End Section Title -->

    @if($testimonials->isNotEmpty())
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="testimonials-slider swiper init-swiper">
            <script type="application/json" class="swiper-config">
                {
                    "slidesPerView": 1,
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "navigation": {
                        "nextEl": ".swiper-button-next",
                        "prevEl": ".swiper-button-prev"
                    }
                }
            </script>

            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="row">
                            <div class="col-lg-8">
                                <h2>{{ $testimonial->content }}</h2>
                                <div class="rating mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="profile d-flex align-items-center">
                                    @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" class="profile-img" alt="{{ $testimonial->name }}">
                                    @else
                                        <div class="profile-img bg-primary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%;">
                                            {{ substr($testimonial->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="profile-info ms-3">
                                        <h3 class="mb-0">{{ $testimonial->name }}</h3>
                                        <span>{{ $testimonial->role }}{{ $testimonial->company ? ' at ' . $testimonial->company : '' }}</span>
                                    </div>
                                </div>
                            </div>
                            @if($testimonial->image)
                            <div class="col-lg-4 d-none d-lg-block">
                                <div class="featured-img-wrapper">
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" class="featured-img" alt="{{ $testimonial->name }}">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div><!-- End Testimonial Item -->
                @endforeach
            </div>

            @if($testimonials->count() > 1)
            <div class="swiper-navigation w-100 d-flex align-items-center justify-content-center">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="container text-center py-5">
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i> No testimonials available at the moment. Check back later!
        </div>
    </div>
    @endif
</section><!-- /Testimonials Section -->
