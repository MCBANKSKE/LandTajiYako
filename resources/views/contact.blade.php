@extends('layouts.app')

@section('content')
<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Contact Us</h2>
            <p>Get In Touch With Taji Yako Properties Limited</p>
        </div>

        <div class="row gx-lg-0 gy-4">
            <div class="col-lg-4">
                <div class="info-container">
                    <div class="section-header">
                        <h3>Contact Information</h3>
                        <p>We're here to help and answer any questions you might have.</p>
                    </div>

                    <div class="info-item d-flex">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h4>Location:</h4>
                            <p>Nairobi, Kenya</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h4>Email:</h4>
                            <p>info@tajiyakoproperties.co.ke</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-phone flex-shrink-0"></i>
                        <div>
                            <h4>Call:</h4>
                            <p>+254 700 000000</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-clock flex-shrink-0"></i>
                        <div>
                            <h4>Open Hours:</h4>
                            <p>Monday - Friday: 8:00 AM - 5:00 PM</p>
                            <p>Saturday: 9:00 AM - 2:00 PM</p>
                        </div>
                    </div><!-- End Info Item -->
                </div>
            </div>

            <div class="col-lg-8">
                <form action="{{ route('contact.submit') }}" method="post" class="php-email-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="7" placeholder="Message" required></textarea>
                    </div>
                    <div class="my-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                    </div>
                    <div class="text-center">
                        <button type="submit">Send Message</button>
                    </div>
                </form>
            </div><!-- End Contact Form -->
        </div>
    </div>
</section>
<!-- End Contact Section -->

<!-- ======= Map Section ======= -->
<section id="map" class="map">
    <div class="container-fluid p-0">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.808226439455!2d36.82115931475396!3d-1.2884663359731975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d1b8b2b8b9%3A0x1e1e1e1e1e1e1e1e!2sNairobi%2C%20Kenya!5e0!3m2!1sen!2ske!4v1620000000000!5m2!1sen!2ske" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>
<!-- End Map Section -->

<!-- ======= CTA Section ======= -->
<section id="cta" class="cta">
    <div class="container" data-aos="zoom-in">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h3>Looking for Your Dream Property?</h3>
                <p>Our team is ready to help you find the perfect property that meets your needs and budget.</p>
                <a class="cta-btn" href="{{ route('properties.index') }}">Browse Properties</a>
            </div>
        </div>
    </div>
</section>
<!-- End CTA Section -->

@endsection
