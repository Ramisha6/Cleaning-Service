@extends('frontend.dashboard')
@section('frontend_title', 'About Us')
@section('frontend')

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper " data-bg-src="{{ asset('frontend/assets/img/breadcumb/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">About <span>Us</span></h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>about us</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- About Area  -->
    <section class="about-layout1 style3 space-bottom" style="margin-top: 120px">
        <div class="container">
            <div class="row gx-60 g-5 justify-content-center">
                <div class="col-xl-6">
                    <div class="img-box2 wow animate__fadeInUp" data-wow-delay="0.55s">
                        <div class="img1">
                            <a href="about.html"><img src="{{ asset('frontend/assets/img/about/about-img-2-1.jpg') }}" alt="About Image"></a>
                        </div>
                        <span class="shape-mockup d-lg-block d-block h-100" style="right: 0; top: 0px;"><img src="{{ asset('frontend/assets/img/shapes/about-line-shape.png') }}" alt="counter element"></span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-content">
                        <div class="wow animate__fadeInUp" data-wow-delay="0.25s">
                            <div class="title-area title-anime animation-style2">
                                <span class="sec-subtitle left-shape justify-content-center title-anime__title">ABOUT CLEANING</span>
                                <h2 class="sec-title title-anime__title">Our Cleaning <span class="title-highlight">Agency</span> For Your City</h2>
                            </div>
                            <p class="about-text" style="text-align: justify">
                                Smart Clean is a trusted professional cleaning service provider in Bangladesh, dedicated to making homes, offices, and commercial spaces cleaner, healthier, and more comfortable. We believe that a clean environment is essential for a better lifestyle, improved productivity, and peace of mind.
                                <br><br>
                                With a team of trained and experienced cleaning professionals, Smart Clean delivers high-quality cleaning solutions using modern equipment, safe cleaning products, and efficient techniques. From regular home cleaning to deep cleaning, office maintenance, and specialized services, we ensure every corner receives the attention it deserves.
                                <br><br>
                                Customer satisfaction is at the heart of everything we do. We focus on reliability, transparency, and timely service, ensuring our clients receive consistent and dependable cleaning support. Whether you need a one-time service or regular cleaning, Smart Clean is committed to meeting your needs with professionalism and care.
                                <br><br>
                                For detailed information about our services and to schedule a cleaning, please click the “Book a Service” button below and let Smart Clean take care of the rest.
                            </p>
                        </div>
                        <div class="about-inner mb-0 wow animate__fadeInUp" data-wow-delay="0.25s">
                            <a class="vs-btn2" href="{{ route('services') }}">Book service <i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="shape-mockup z-index-n1 d-lg-block d-none" style="left: 52px; top: 0px;"><img src="{{ asset('frontend/assets/img/shapes/about-shape-2-1.png') }}" alt="counter element"></span>
        <span class="shape-mockup" style="right: 0; top: 0px;"><img src="{{ asset('frontend/assets/img/shapes/map-shape-1.png') }}" alt="counter element"></span>
        <span class="shape-mockup z-index-n1" style="right: 120px; bottom: 50px;"><img src="{{ asset('frontend/assets/img/shapes/about-shape-2-2.png') }}" alt="counter element"></span>
    </section>

@endsection
