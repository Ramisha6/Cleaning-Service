@extends('frontend.dashboard')
@section('frontend_title', 'About Us')
@section('frontend')

    <!--********************************
       Start Main Content
     ******************************** -->

    <!--==============================
            Breadcumb
            ============================== -->
    <div class="breadcumb-wrapper " data-bg-src="{{asset('frontend/assets/img/breadcumb/breadcumb-bg.png')}}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">About <span>Us</span></h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="index.html">Home</a></li>
                    <li>about us</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- About Area  -->
    <section class="about-layout1 space">
        <div class="container custome-space-bottom">
            <div class="row gx-60 g-5 justify-content-center align-items-center">
                <div class="col-xl-6">
                    <div class="img-box1 wow animate__fadeInUp" data-wow-delay="0.55s">
                        <div class="img-icon">
                            <img src="assets/img/icon/about-icon1.svg" alt="icon">
                            <span class="icon-shep">
                                <img src="assets/img/shapes/about-icon-shape1.png" alt="shape" class="spin">
                            </span>
                        </div>
                        <div class="img1">
                            <a href="about.html"><img src="assets/img/about/about-img-1-1.jpg" alt="About Image"></a>
                        </div>
                        <div class="img2">
                            <a href="about.html"><img src="assets/img/about/about-img-1-2.jpg" alt="About Image"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-content">
                        <div class="wow animate__fadeInUp" data-wow-delay="0.25s">
                            <div class="title-area title-anime animation-style2">
                                <span class="sec-subtitle left-shape justify-content-center title-anime__title">ABOUT
                                    CLEANING</span>
                                <h2 class="sec-title title-anime__title">Our Cleaning <span
                                        class="title-highlight">Agency</span> For Your City</h2>
                            </div>
                            <p class="about-text">
                                When you work Angeles House Cleaners Referal Agency cleaning breathe easy because your home
                                will soon
                            </p>
                        </div>
                        <div class="about-box1 wow animate__fadeInUp" data-wow-delay="0.25s">
                            <div class="about-item">
                                <span class="item-icon">
                                    <img src="assets/img/icon/about-icon2.svg" alt="icon">
                                </span>
                                <h2 class="item-title h6">House Cleaning</h2>
                                <p class="item-text">leaning machine your Ultrasonic parts cleaning dioxide</p>
                            </div>
                            <div class="about-item">
                                <span class="item-icon">
                                    <img src="assets/img/icon/about-icon3.svg" alt="icon">
                                </span>
                                <h2 class="item-title h6">Living Room Cleaning</h2>
                                <p class="item-text">leaning machine your Ultrasonic parts cleaning dioxide</p>
                            </div>
                        </div>
                        <div class="about-inner wow animate__fadeInUp" data-wow-delay="0.25s">
                            <a class="vs-btn2" href="about.html">Book service <i class="far fa-long-arrow-right"></i></a>
                            <div class="author-box">
                                <img src="assets/img/about/author-img.jpg" alt="author image">
                                <div class="author-content">
                                    <h2 class="title h5">D.markwin</h2>
                                    <p class="desi">Co-founder</p>
                                </div>
                            </div>
                        </div>
                        <div class="about-notice wow animate__fadeInUp" data-wow-delay="0.30s">
                            <span class="notice-icon"><img src="assets/img/icon/about-icon4.svg" alt="icon"></span>
                            <p class="notice-text">Give Your Home A Deep Clean for aesthetic.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="shape-mockup z-index-n1 d-lg-block d-none" style="left: 52px; top: 0px;"><img
                src="assets/img/shapes/about-shape-1-1.png" alt="counter element"></span>
        <span class="shape-mockup z-index-n1" style="right: 0; top: 0px;"><img src="assets/img/shapes/about-shape-1-2.png"
                alt="counter element"></span>
    </section>
    <!-- About Area End -->
    <!-- Client Area  -->
    <section class="vs-client__layout1 space-bottom" data-bg-src="assets/img/bg/client-bg1.jpg">
        <div class="container">
            <div class="video-style1 background-image" data-bg-src="assets/img/bg/video-bg1.png">
                <div class="row justify-content-center">
                    <div class="video-area text-center">
                        <a href="https://www.youtube.com/watch?v=moYayPRgaY0" class="play-btn popup-video">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                    <div class="col-xl-6">
                        <div class="title-area text-center wow animate__fadeInUp title-anime animation-style2"
                            data-wow-delay="0.3s"
                            style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                            <h2 class="sec-title title-anime__title">Most Trusted service</h2>
                            <a class="vs-btn2" href="about.html">Book service <i class="far fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row g-5">
                <div class="col-xl-5 position-relative wow animate__fadeInUp">
                    <div class="title-area title-anime animation-style5">
                        <span class="sec-subtitle left-shape justify-content-center title-anime__title">ABOUT
                            CLEANING</span>
                        <h2 class="sec-title text-white title-anime__title">Excellent <span
                                class="title-highlight">Service</span> cleaning</h2>
                    </div>
                    <div class="vs-client__inner">
                        <div class="author-img">
                            <img src="assets/img/cleaning/cleaning-tumb-1.png" alt="cleaning tumb">
                        </div>
                        <div class="vs-client__content">
                            <span class="vs-client__subtitle">57+</span>
                            <p class="vs-client__text">Members</p>
                        </div>
                    </div>
                    <span class="shape-mockup vs-slider-shape-1  d-xl-block d-none" style="right: 35px; top: -35px;"><img
                            src="assets/img/shapes/cleaning-shapes-1.png" alt="counter element"></span>
                </div>
                <div class="col-xl-7">
                    <div class="row gx-3 gy-3">
                        <div class="col-xl-4 col-6 col-md-4 wow animate__fadeInUp" data-wow-delay="0.25s">
                            <div class="vs-client__brand">
                                <img src="assets/img/brand/brand-1.png" alt="Brand Images">
                            </div>
                        </div>
                        <div class="col-xl-4 col-6 col-md-4 wow animate__fadeInUp" data-wow-delay="0.35s">
                            <div class="vs-client__brand">
                                <img src="assets/img/brand/brand-2.png" alt="Brand Images">
                            </div>
                        </div>
                        <div class="col-xl-4 col-6 col-md-4 wow animate__fadeInUp" data-wow-delay="0.45s">
                            <div class="vs-client__brand">
                                <img src="assets/img/brand/brand-3.png" alt="Brand Images">
                            </div>
                        </div>
                        <div class="col-xl-4 col-6 col-md-4 wow animate__fadeInUp" data-wow-delay="0.65s">
                            <div class="vs-client__brand">
                                <img src="assets/img/brand/brand-4.png" alt="Brand Images">
                            </div>
                        </div>
                        <div class="col-xl-4 col-6 col-md-4 wow animate__fadeInUp" data-wow-delay="0.75s">
                            <div class="vs-client__brand">
                                <img src="assets/img/brand/brand-5.png" alt="Brand Images">
                            </div>
                        </div>
                        <div class="col-xl-4 col-6 col-md-4 wow animate__fadeInUp" data-wow-delay="0.85s">
                            <div class="vs-client__brand">
                                <img src="assets/img/brand/brand-1.png" alt="Brand Images">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="common-line shape-mockup d-none d-xxl-block" style="top: -7px;">
            <img src="assets/img/shapes/line-shep.png" alt="shapes">
        </div>
    </section>
    <!-- Client Area End -->
    <!-- Team Area  -->
    <section class="vs-team__layout1 bg-linear space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="title-area text-center wow animate__fadeInUp title-anime animation-style5"
                        data-wow-delay="0.25s">
                        <span class="sec-subtitle justify-content-center title-anime__title">MEET OUR TEAM</span>
                        <h2 class="sec-title title-anime__title">We have a expert team</h2>
                    </div>
                </div>
            </div>
            <div class="row vs-carousel" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3"
                data-md-slide-show="2" data-sm-slide-show="2" data-autoplay="true" data-arrows="true">
                <div class="col-xl-3 wow animate__fadeInUp" data-wow-delay="0.25s">
                    <div class="vs-team__style1">
                        <div class="vs-team__img">
                            <a href="team.html">
                                <img src="assets/img/team/team-img-1-1.png" alt="Team Image">
                            </a>
                            <div class="vs-team__social--media">
                                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                <a href="javascript:void(0)"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="vs-team__content">
                            <h2 class="vs-team__title"><a href="team.html">erica hanson</a></h2>
                            <p class="vs-team__subtitle">Supervisor</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow animate__fadeInUp" data-wow-delay="0.35s">
                    <div class="vs-team__style1">
                        <div class="vs-team__img">
                            <a href="team.html">
                                <img src="assets/img/team/team-img-1-2.png" alt="Team Image">
                            </a>
                            <div class="vs-team__social--media">
                                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                <a href="javascript:void(0)"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="vs-team__content">
                            <h2 class="vs-team__title"><a href="team.html">Alexandra Dario</a></h2>
                            <p class="vs-team__subtitle">founder, CEO</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow animate__fadeInUp" data-wow-delay="0.45s">
                    <div class="vs-team__style1">
                        <div class="vs-team__img">
                            <a href="team.html">
                                <img src="assets/img/team/team-img-1-3.png" alt="Team Image">
                            </a>
                            <div class="vs-team__social--media">
                                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                <a href="javascript:void(0)"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="vs-team__content">
                            <h2 class="vs-team__title"><a href="team.html">emely jonson</a></h2>
                            <p class="vs-team__subtitle">office cleaner</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow animate__fadeInUp" data-wow-delay="0.55s">
                    <div class="vs-team__style1">
                        <div class="vs-team__img">
                            <a href="team.html">
                                <img src="assets/img/team/team-img-1-4.png" alt="Team Image">
                            </a>
                            <div class="vs-team__social--media">
                                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                <a href="javascript:void(0)"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="vs-team__content">
                            <h2 class="vs-team__title"><a href="team.html">Tonoy Rahomon</a></h2>
                            <p class="vs-team__subtitle">Supervisor</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 wow animate__fadeInUp" data-wow-delay="0.65s">
                    <div class="vs-team__style1">
                        <div class="vs-team__img">
                            <a href="team.html">
                                <img src="assets/img/team/team-img-1-5.png" alt="Team Image">
                            </a>
                            <div class="vs-team__social--media">
                                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                <a href="javascript:void(0)"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="vs-team__content">
                            <h2 class="vs-team__title"><a href="team.html">Rivan islam</a></h2>
                            <p class="vs-team__subtitle">Supervisor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span class="shape-mockup" style="right: 0; top: 0px;"><img src="assets/img/shapes/service-shape-1.png"
                alt="team element"></span>
        <span class="shape-mockup z-index-n1" style="left: 0; bottom: 0px;"><img src="assets/img/shapes/team-shep1.png"
                alt="team element"></span>
    </section>
    <!-- Team Area End -->

    <!--********************************
       End Main Content
     ******************************** -->

@endsection
