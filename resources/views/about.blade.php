@extends('layouts.app') 

@section('content')
<!-- Page Title -->
<div class="page-title">
  <div class="heading">
    <div class="container">
      <div class="row d-flex justify-content-center text-center">
        <div class="col-lg-8">
          <h1 class="heading-title">About Us</h1>
          <p class="mb-0">
            Your trusted partner in finding your dream property in Kenya. TAJI YAKO PROPERTIES LTD specializes in connecting buyers with their perfect homes and lucrative investment opportunities across the country.
          </p>
        </div>
      </div>
    </div>
  </div>
  <nav class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li class="current">About</li>
      </ol>
    </div>
  </nav>
</div><!-- End Page Title -->

<!-- About Section -->
<section id="about" class="about section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center mb-5">
      <div class="col-lg-7">
        <div class="intro-content" data-aos="fade-right" data-aos-delay="200">
          <div class="section-badge">
            <i class="bi bi-house-heart"></i>
            <span>Your Trusted Real Estate Partner</span>
          </div>
          <h2>Welcome to TAJI YAKO PROPERTIES LTD</h2>
          <p class="lead-text">With over 15 years of experience in Kenya's real estate market, TAJI YAKO PROPERTIES LTD has helped thousands of clients find their perfect homes and investment properties. Our team of dedicated professionals is committed to providing exceptional service and expert guidance throughout your property journey, from initial search to final transaction.</p>

          <div class="founder-highlight" data-aos="fade-up" data-aos-delay="300">
            <div class="founder-image">
              <img src="{{ asset('assets/img/logo.webp') }}" alt="Founder" class="img-fluid">
            </div>
            <div class="founder-info">
              <blockquote>"At TAJI YAKO PROPERTIES LTD, we believe in building lasting relationships with our clients by providing honest advice, transparent transactions, and exceptional service that goes beyond the sale."</blockquote>
              <div class="founder-details">
                <h5>TAJI YAKO PROPERTIES LTD</h5>
                <span>Your Trusted Real Estate Partner in Kenya</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="visual-section" data-aos="fade-left" data-aos-delay="250">
          <div class="main-image">
            <img src="assets/img/real-estate/property-exterior-7.webp" alt="Luxury Development" class="img-fluid">
            <div class="experience-badge">
              <div class="badge-number">15+</div>
              <div class="badge-text">Years of Excellence</div>
            </div>
          </div>
          <div class="overlay-image">
            <img src="assets/img/real-estate/property-interior-6.webp" alt="Interior Design" class="img-fluid">
          </div>
        </div>
      </div>
    </div>

    <div class="achievements-grid" data-aos="fade-up" data-aos-delay="350">
      <div class="row text-center">
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="achievement-item" data-aos="zoom-in" data-aos-delay="400">
            <div class="achievement-icon">
              <i class="bi bi-key"></i>
            </div>
            <div class="achievement-number">
              <span data-purecounter-start="0" data-purecounter-end="600" data-purecounter-duration="2" class="purecounter"></span>+
            </div>
            <div class="achievement-label">Properties Sold</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="achievement-item" data-aos="zoom-in" data-aos-delay="450">
            <div class="achievement-icon">
              <i class="bi bi-heart-fill"></i>
            </div>
            <div class="achievement-number">
              <span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="2" class="purecounter"></span>+
            </div>
            <div class="achievement-label">Happy Clients</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="achievement-item" data-aos="zoom-in" data-aos-delay="500">
            <div class="achievement-icon">
              <i class="bi bi-geo-alt"></i>
            </div>
            <div class="achievement-number">
              <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="2" class="purecounter"></span>+
            </div>
            <div class="achievement-label">Years Experience</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="achievement-item" data-aos="zoom-in" data-aos-delay="550">
            <div class="achievement-icon">
              <i class="bi bi-award"></i>
            </div>
            <div class="achievement-number">
              <span>2847+</span>
            </div>
            <div class="achievement-label">Properties Listed</div>
          </div>
        </div>
      </div>
    </div><!-- End Achievements Grid -->

    <div class="timeline-section" data-aos="fade-up" data-aos-delay="400">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="section-header text-center mb-5">
            <h3>Our Journey of Excellence</h3>
            <p>From our humble beginnings to becoming one of Kenya's trusted real estate partners, here are the milestones that define our commitment to quality service at TAJI YAKO PROPERTIES LTD.</p>
          </div>

          <div class="timeline">
            <div class="timeline-item" data-aos="fade-right" data-aos-delay="450">
              <div class="timeline-year">2010</div>
              <div class="timeline-content">
                <h4>Company Founded</h4>
                <p>TAJI YAKO PROPERTIES LTD began with a simple mission: to make property ownership accessible and hassle-free for Kenyans. We started as a small agency focusing on residential properties in Nairobi.</p>
              </div>
            </div>
            <div class="timeline-item" data-aos="fade-left" data-aos-delay="500">
              <div class="timeline-year">2015</div>
              <div class="timeline-content">
                <h4>First Major Milestone</h4>
                <p>Celebrated our 100th property sale and expanded our services to include commercial properties and land. Our client base grew to over 100 satisfied customers across Kenya.</p>
              </div>
            </div>
            <div class="timeline-item" data-aos="fade-right" data-aos-delay="550">
              <div class="timeline-year">2020</div>
              <div class="timeline-content">
                <h4>Digital Transformation</h4>
                <p>Launched our comprehensive online platform to serve clients nationwide. Integrated digital property tours, virtual consultations, and online documentation to enhance customer experience.</p>
              </div>
            </div>
            <div class="timeline-item" data-aos="fade-left" data-aos-delay="600">
              <div class="timeline-year">2024</div>
              <div class="timeline-content">
                <h4>Nationwide Recognition</h4>
                <p>Reached 600+ properties sold with 98% client satisfaction. Expanded our network to include over 150 verified agents serving clients across all major counties in Kenya.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Timeline Section -->

    <div class="team-preview" data-aos="fade-up" data-aos-delay="450">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h3>Why Choose TAJI YAKO PROPERTIES LTD</h3>
          <p class="team-description">We are committed to providing exceptional service and finding the perfect property that matches your lifestyle, budget, and investment goals.</p>
          <div class="row text-center mb-5">
            <div class="col-md-4 mb-4">
              <div class="feature-box p-4">
                <i class="bi bi-house-door feature-icon"></i>
                <h5>Diverse Property Portfolio</h5>
                <p>Choose from 2847+ listed properties including land, houses, apartments, and commercial spaces across Kenya.</p>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="feature-box p-4">
                <i class="bi bi-people feature-icon"></i>
                <h5>Expert Guidance</h5>
                <p>Get professional advice from our 150+ verified real estate agents with deep market knowledge and experience.</p>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="feature-box p-4">
                <i class="bi bi-star-fill feature-icon"></i>
                <h5>Proven Track Record</h5>
                <p>98% client satisfaction rate from hundreds of successful transactions completed across Kenya.</p>
              </div>
            </div>
          </div>
          
          <div class="cta-section">
            <a href="{{ route('properties.index') }}" class="btn btn-primary btn-lg">
              <i class="bi bi-search me-2"></i>Explore Our Properties
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg ms-3">
              <i class="bi bi-chat-dots me-2"></i>Contact Our Team
            </a>
          </div>
        </div>
      </div>
    </div><!-- End Team Preview -->

  </div>
</section><!-- /About Section -->
@endsection