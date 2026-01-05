<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('frontend_title') | Cleaning Services</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@400;700&amp;family=Poppins:wght@400;500;600;700;800&amp;family=Rubik:ital,wght@0,300..900;1,300..900&amp;display=swap" rel="stylesheet">

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
    @yield('frontend')


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
