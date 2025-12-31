<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cleaning and pool service template | Vecuro | Home 3</title>
    <meta name="author" content="Vecuro">
    <meta name="description" content="Cleaning and pool Home 3 template">
    <meta name="keywords" content="Cleaning and pool Home 3 template">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="{{ asset('frontend/assets/img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('frontend/assets/img/favicon.ico') }}" type="image/x-icon">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@400;700&amp;family=Poppins:wght@400;500;600;700;800&amp;family=Rubik:ital,wght@0,300..900;1,300..900&amp;display=swap"
        rel="stylesheet">

    {{-- All CSS File --}}
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.min.css') }}">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
    <!-- animate js -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

</head>

<body>


    {{-- Preloader --}}
    <!-- <div class="preloader">
        <button class="vs-btn preloaderCls">Cancel Preloader </button>
        <div class="preloader-inner">
            <img src="{{ asset('frontend/assets/img/logo.svg') }}" alt="logo">
            <span class="loader"></span>
        </div>
    </div> -->


    {{-- Mobile Menu --}}
    @include('frontend.layout.mobile_menu')


    {{-- Popup Search Box --}}
    <div class="popup-search-box d-none d-lg-block  ">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" class="border-theme" placeholder="What are you looking for">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>


    {{-- Header Area --}}
    @include('frontend.layout.header')


    {{-- Start Main Content --}}

    <!-- Slider Area -->
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('frontend/assets/img/banner/banner_3.jpg') }}" class="d-block w-100"
                                    alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('frontend/assets/img/banner/banner_2.jpg') }}" class="d-block w-100"
                                    alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('frontend/assets/img/banner/banner_1.jpg') }}" class="d-block w-100"
                                    alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Slider Area End -->

    
    <!-- Service Area  -->
    <section class="vs-service__layout1 space position-relative">
        <div class="container custome-space-bottom">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="title-area text-center wow animate__fadeInUp title-anime animation-style5"
                        data-wow-delay="0.25s">
                        <span class="sec-subtitle justify-content-center title-anime__title"> CLEANING SERVICE</span>
                        <h2 class="sec-title title-anime__title">Our Excellent Service</h2>
                    </div>
                </div>
            </div>
            <div class="row vs-carousel" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3"
                data-md-slide-show="2" data-autoplay="true" data-arrows="true">
                <div class="col-lg-3 wow animate__fadeInUp" data-wow-delay="0.25s">
                    <div class="vs-service__style1">
                        <div class="vs-service__img">
                            <a href="">
                                <img src="{{ asset('frontend/assets/img/service/service-img-1-1.jpg') }}"
                                    alt="Serevice Image">
                            </a>
                        </div>
                        <div class="vs-service__body">
                            <div class="vs-service__header">
                                <div class="vs-service__content">
                                    <p class="vs-service__subtitle">cleaning 01</p>
                                    <h2 class="vs-service__title h6"><a href="">home service</a></h2>
                                </div>
                                <div class="vs-service__icon">
                                    <img src="{{ asset('frontend/assets/img/icon/service-icon-1-1.svg') }}"
                                        alt="Service Icon">
                                </div>
                            </div>
                            <p class="vs-service__text">aweep & mopsd vacuum floor House Cleaners.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 wow animate__fadeInUp" data-wow-delay="0.45s">
                    <div class="vs-service__style1">
                        <div class="vs-service__img">
                            <a href="">
                                <img src="{{ asset('frontend/assets/img/service/service-img-1-2.jpg') }}"
                                    alt="Serevice Image">
                            </a>
                        </div>
                        <div class="vs-service__body">
                            <div class="vs-service__header">
                                <div class="vs-service__content">
                                    <p class="vs-service__subtitle">cleaning 01</p>
                                    <h2 class="vs-service__title h6"><a href="">Kitchen Clean</a></h2>
                                </div>
                                <div class="vs-service__icon">
                                    <img src="{{ asset('frontend/assets/img/icon/service-icon-1-2.svg') }}"
                                        alt="Service Icon">
                                </div>
                            </div>
                            <p class="vs-service__text">aweep & mopsd vacuum floor House Cleaners.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 wow animate__fadeInUp" data-wow-delay="0.65s">
                    <div class="vs-service__style1">
                        <div class="vs-service__img">
                            <a href="">
                                <img src="{{ asset('frontend/assets/img/service/service-img-1-3.jpg') }}"
                                    alt="Serevice Image">
                            </a>
                        </div>
                        <div class="vs-service__body">
                            <div class="vs-service__header">
                                <div class="vs-service__content">
                                    <p class="vs-service__subtitle">cleaning 01</p>
                                    <h2 class="vs-service__title h6"><a href="">Purification</a></h2>
                                </div>
                                <div class="vs-service__icon">
                                    <img src="{{ asset('frontend/assets/img/icon/service-icon-1-3.svg') }}"
                                        alt="Service Icon">
                                </div>
                            </div>
                            <p class="vs-service__text">aweep & mopsd vacuum floor House Cleaners.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 wow animate__fadeInUp" data-wow-delay="0.85s">
                    <div class="vs-service__style1">
                        <div class="vs-service__img">
                            <a href="">
                                <img src="{{ asset('frontend/assets/img/service/service-img-1-4.jpg') }}"
                                    alt="Serevice Image">
                            </a>
                        </div>
                        <div class="vs-service__body">
                            <div class="vs-service__header">
                                <div class="vs-service__content">
                                    <p class="vs-service__subtitle">cleaning 01</p>
                                    <h2 class="vs-service__title h6"><a href="">Bed & Mattres</a></h2>
                                </div>
                                <div class="vs-service__icon">
                                    <img src="{{ asset('frontend/assets/img/icon/service-icon-1-4.svg') }}"
                                        alt="Service Icon">
                                </div>
                            </div>
                            <p class="vs-service__text">aweep & mopsd vacuum floor House Cleaners.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 wow animate__fadeInUp" data-wow-delay="0.95s">
                    <div class="vs-service__style1">
                        <div class="vs-service__img">
                            <a href="">
                                <img src="{{ asset('frontend/assets/img/service/service-img-1-5.jpg') }}"
                                    alt="Serevice Image">
                            </a>
                        </div>
                        <div class="vs-service__body">
                            <div class="vs-service__header">
                                <div class="vs-service__content">
                                    <p class="vs-service__subtitle">cleaning 01</p>
                                    <h2 class="vs-service__title h6"><a href="">House Clean</a></h2>
                                </div>
                                <div class="vs-service__icon">
                                    <img src="{{ asset('frontend/assets/img/icon/service-icon-1-4.svg') }}"
                                        alt="Service Icon">
                                </div>
                            </div>
                            <p class="vs-service__text">aweep & mopsd vacuum floor House Cleaners.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="shape-mockup z-index-n1 d-xl-block d-none" style="right: 0; top: 0px;"><img
                src="{{ asset('frontend/assets/img/shapes/service-shape-1.png') }}" alt="counter element"></span>
        <span class="shape-mockup z-index-n1 custom-sheap" style="right: 0; bottom: 0px;"><img
                src="{{ asset('frontend/assets/img/shapes/service-shape-2.png') }}" alt="counter element"></span>
        <span class="shape-mockup z-index-n1 d-xl-block d-none" style="left: 0; bottom: 0px;"><img
                src="{{ asset('frontend/assets/img/shapes/service-shape-3.png') }}" alt="counter element"></span>
    </section>
    <!-- Service Area End  -->


    {{-- Footer Area --}}
    @include('frontend.layout.footer')
    <!-- Scroll To Top -->
    <button class="back-to-top" id="backToTop" aria-label="Back to Top">
        <span class="progress-circle">
            <svg viewBox="0 0 100 100">
                <circle class="bg" cx="50" cy="50" r="40"></circle>
                <circle class="progress" cx="50" cy="50" r="40"></circle>
            </svg>
            <span class="progress-percentage" id="progressPercentage">0%</span>
        </span>
    </button>


    {{-- All Js File --}}
    <!-- Jquery -->
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <!-- Slick Slider -->
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- imagesloaded -->
    <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- Gsap -->
    <script src="{{ asset('frontend/assets/js/gsap.min.js') }}"></script>
    <!-- ScrollTrigger -->
    <script src="{{ asset('frontend/assets/js/ScrollTrigger.min.js') }}"></script>
    <!-- Gsap ScrollTo Plugin -->
    <script src="{{ asset('frontend/assets/js/gsap-scroll-to-plugin.js') }}"></script>
    <!-- Split Text -->
    <script src="{{ asset('frontend/assets/js/SplitText.js') }}"></script>
    <!-- lenis -->
    <script src="{{ asset('frontend/assets/js/lenis.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
    <!-- Main Js File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

</body>

</html>
