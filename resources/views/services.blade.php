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
          <h1 class="heading-title">Our Services</h1>
          <p class="mb-0">
            At Taji Yako Properties Ltd, we provide comprehensive real estate solutions to help you buy, sell, rent, and manage properties across Kenya. Our expert team is committed to delivering exceptional service throughout your property journey.
          </p>
        </div>
      </div>
    </div>
  </div>
  <nav class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li class="current">Services</li>
      </ol>
    </div>
  </nav>
</div><!-- End Page Title -->

<!-- Services Section -->
<section class="real-estate-services-3 services section" id="services">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">

      <div class="col-lg-6 col-md-12">
        <div class="service-block" data-aos="fade-right" data-aos-delay="200">
          <div class="service-content">
            <div class="icon">
              <i class="bi bi-house-door"></i>
            </div>
            <h3>Buy Your Dream Home</h3>
            <p>Find your perfect property from our extensive collection of residential and commercial properties across prime locations in Kenya. At Taji Yako Properties Ltd, we guide you through every step of the buying process to ensure a smooth transaction.</p>
            <div class="stats">
              <div class="stat-item">
                <span class="number">600+</span>
                <span class="label">Properties Sold</span>
              </div>
              <div class="stat-item">
                <span class="number">98%</span>
                <span class="label">Client Satisfaction</span>
              </div>
            </div>
            <a href="{{ route('properties.index') }}" class="btn-service">Browse Properties <i class="bi bi-arrow-right"></i></a>
          </div>
          <div class="service-image">
            <img src="assets/img/real-estate/property-exterior-3.webp" alt="Buy Property" class="img-fluid">
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-12">
        <div class="service-block" data-aos="fade-left" data-aos-delay="200">
          <div class="service-content">
            <div class="icon">
              <i class="bi bi-currency-dollar"></i>
            </div>
            <h3>Sell Your Property</h3>
            <p>Maximize your property's value with Taji Yako Properties Ltd's professional sales services. We provide accurate market valuation, strategic marketing, and expert negotiation to achieve the best possible price for your property in the shortest time.</p>
            <div class="stats">
              <div class="stat-item">
                <span class="number">45</span>
                <span class="label">Days Average Sale</span>
              </div>
              <div class="stat-item">
                <span class="number">KES 50M+</span>
                <span class="label">Highest Sale Price</span>
              </div>
            </div>
            <a href="{{ route('contact') }}" class="btn-service">Get Free Valuation <i class="bi bi-arrow-right"></i></a>
          </div>
          <div class="service-image">
            <img src="assets/img/real-estate/property-exterior-7.webp" alt="Sell Property" class="img-fluid">
          </div>
        </div>
      </div>

    </div>

    <div class="row gy-4 mt-4">

      <div class="col-lg-4 col-md-6">
        <div class="service-card" data-aos="zoom-in" data-aos-delay="100">
          <div class="card-icon">
            <i class="bi bi-key"></i>
          </div>
          <h4>Rental Services</h4>
          <p>Comprehensive rental solutions for both landlords and tenants. Taji Yako Properties Ltd makes renting easy with our professional property management and tenant placement services.</p>
          <div class="feature-list">
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>Comprehensive Tenant Screening</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>Strategic Property Marketing</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>Professional Lease Management</span>
            </div>
          </div>
          <a href="{{ route('properties.index') }}?property_type=apartment" class="service-link">Explore Rentals <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-card" data-aos="zoom-in" data-aos-delay="200">
          <div class="card-icon">
            <i class="bi bi-graph-up"></i>
          </div>
          <h4>Investment Consulting</h4>
          <p>Make informed real estate decisions with our expert investment guidance. We help you identify profitable opportunities and build a sustainable property portfolio in Kenya's growing market.</p>
          <div class="feature-list">
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>Detailed Market Analysis</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>Accurate ROI Calculations</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>Personalized Portfolio Planning</span>
            </div>
          </div>
          <a href="{{ route('contact') }}" class="service-link">Start Investing <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-card" data-aos="zoom-in" data-aos-delay="300">
          <div class="card-icon">
            <i class="bi bi-tools"></i>
          </div>
          <h4>Property Management</h4>
          <p>Professional property management services to maintain and maximize the value of your real estate investments. We handle everything from maintenance to tenant relations.</p>
          <div class="feature-list">
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>Proactive Maintenance Coordination</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>Efficient Rent Collection</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-check2"></i>
              <span>24/7 Tenant Support</span>
            </div>
          </div>
          <a href="{{ route('contact') }}" class="service-link">Manage Property <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

    </div>

    <div class="cta-section" data-aos="fade-up" data-aos-delay="400">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h3>Ready to Find Your Perfect Property?</h3>
          <p>Contact Taji Yako Properties Ltd today to discuss your real estate needs with our expert team. Whether you're buying, selling, or investing, we're here to guide you every step of the way.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('contact') }}" class="btn btn-cta">Schedule Free Consultation</a>
        </div>
      </div>
    </div>

  </div>

</section><!-- /Services Section -->

@endsection