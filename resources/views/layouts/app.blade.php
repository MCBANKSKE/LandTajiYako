<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Taji Yako Properties'))</title>

    <!-- Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Connecting you with perfect homes, commercial spaces, and prime land.')">
    <meta name="keywords" content="real estate, properties, land for sale, homes, commercial property">
    <meta name="author" content="Taji Yako Properties Ltd">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og:title', 'Taji Yako Properties - Your Trusted Real Estate Partner')">
    <meta property="og:description" content="@yield('og:description', 'Find land, homes and commercial properties with trusted agents.')">
    <meta property="og:image" content="@yield('og:image', asset('images/logo.png'))">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@300;400;600;700&family=Raleway:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/drift-zoom/drift-basic.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="index-page">

    <!-- ======================= HEADER ======================= -->
     <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/logo.webp') }}" alt="Logo">
                <h1 class="sitename">{{ config('app.name', 'Taji Yako Properties') }}</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('properties.index') }}">Properties</a></li>
                    <li><a href="{{ route('services') }}">Services</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <!-- ======================= MAIN CONTENT ======================= -->
    <main class="flex-grow">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- ======================= FOOTER ======================= -->
    
     <!-- Footer -->

  <footer id="footer" class="footer position-relative">

    <div class="container">
      <div class="row gy-5">

        <div class="col-lg-4">
          <div class="footer-content">
            <a href="/" class="logo d-flex align-items-center mb-4">
              <span class="sitename">{{config('app.name', 'Taji Yako Properties')}}</span>
            </a>
            <p class="mb-4" style="color: #6c757d;">Your trusted partner in finding the perfect property. We connect buyers with their dream homes and investment opportunities.</p>
              
            <div class="newsletter-form">
              <h5>Stay Updated</h5>
              <form action="forms/newsletter.php" method="post" class="php-email-form">
                <div class="input-group">
                  <input type="email" name="email" class="form-control" placeholder="Enter your email" required="">
                  <button type="submit" class="btn-subscribe">
                    <i class="bi bi-send"></i>
                  </button>
                </div>
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Thank you for subscribing!</div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-6">
          <div class="footer-links">
            <h4>Useful Links</h4>
            <ul>
               <li class="mb-2"><a href="/" class="text-decoration-none" style="color: #6c757d;">Home</a></li>
                    <li class="mb-2"><a href="#about" class="text-decoration-none" style="color: #6c757d;">About Us</a></li>
                    <li class="mb-2"><a href="/properties" class="text-decoration-none" style="color: #6c757d;">Properties</a></li>
                    <li class="mb-2"><a href="#services" class="text-decoration-none" style="color: #6c757d;">Services</a></li>
                    <li class="mb-2"><a href="#contact" class="text-decoration-none" style="color: #6c757d;">Contact</a></li>
                </ul>
          </div>
        </div>

        <div class="col-lg-2 col-6">
          <div class="footer-links">
           <h4>Our Services</h4>
            <ul>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Property Sales</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Property Management</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Land Acquisition</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Real Estate Investment</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Property Valuation</a></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="footer-contact">
            <h4>Get in Touch</h4>
            <div class="contact-item">
              <div class="contact-icon">
                <i class="bi bi-geo-alt"></i>
              </div>
              <div class="contact-info">
                <p>Building 100<br>Kirinde Shell Petrol Station<br>Karen</p>
              </div>
            </div>

            <div class="contact-item">
              <div class="contact-icon">
                <i class="bi bi-telephone"></i>
              </div>
              <div class="contact-info">
                <p>+254 720 927 989</p>
              </div>
            </div>

            <div class="contact-item">
              <div class="contact-icon">
                <i class="bi bi-envelope"></i>
              </div>
              <div class="contact-info">
                <p>tajirealtors@gmail.com</p>
              </div>
            </div>

            <div class="social-links">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-twitter-x"></i></a>
              <a href="#"><i class="bi bi-linkedin"></i></a>
              <a href="#"><i class="bi bi-youtube"></i></a>
              
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="copyright">
              <p>&copy; {{ date('Y') }} <span>Copyright</span> <strong class="px-1 sitename">{{config('app.name')}}</strong> <span>All Rights Reserved</span></p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="footer-bottom-links">
              <a href="#">Privacy Policy</a>
              <a href="#">Terms of Service</a>
              <a href="#">Cookie Policy</a>
            </div>
            <div class="credits">
              Designed by <a href="https://mcbanske.co.ke/">Mark Clinton</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </footer>
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/drift-zoom/Drift.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js')}}"></script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
