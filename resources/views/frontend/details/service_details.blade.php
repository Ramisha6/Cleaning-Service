@extends('frontend.dashboard')
@section('frontend_title', $service_details->service_title)
@section('frontend')

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper " data-bg-src="{{ asset('frontend/assets/img/breadcumb/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $service_details->service_title }} </span></h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>Service Details</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- portfolio Area  -->
    <section class="portfolio-Details space position-relative">

        <div class="container">

            <div class="portfolio-content pt-0">

                <div class="row gx-60 g-5">

                    <div class="col-lg-4">

                        <div class="widget widget_categories style2 wow animate__fadeInUp wow-animated" data-wow-delay="0.75s">
                            <h3 class="widget_title">all services</h3>
                            <div class="widget_content">
                                <ul>
                                    @foreach ($service_list as $service)
                                        <li>
                                            <a href="{{ route('service.details', $service->service_slug) }}"><i class="fa-solid fa-angles-right"></i>{{ $service->service_title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="contact-box2 wow animate__fadeInUp wow-animated" data-wow-delay="0.85s">
                            <h2 class="portfolio-title">Let’s Contact with us</h2>
                            <span class="icon-btn">
                                <img src="{{ asset('frontend/assets/img/icon/call-icon2.svg') }}" alt="call icon">
                            </span>
                            <div class="contact-content">
                                <h6 class="contact-title">Need help? Talk to expert</h6>
                                <p class="contact-text"><a href="tel:+9-666-888-679">+9 112 - 8899</a></p>
                            </div>
                            <span class="shape-mockup" style="left: 0; bottom: 0px;"><img src="{{ asset('frontend/assets/img/shapes/contact-sheap1.png') }}" alt="team element"></span>
                        </div>

                    </div>

                    <div class="col-lg-8">

                        <div class="portfolio-img mb-40 wow animate__fadeInUp" data-wow-delay="0.20s">
                            <img src="{{ !empty($service_details->service_image) ? url('upload/service_image/' . $service_details->service_image) : url('upload/no_image.jpg') }}" alt="{{ $service->service_title }}">
                        </div>

                        <h2 class="portfolio-title h3 mb-20 wow animate__fadeInUp" data-wow-delay="0.25s">{{ $service->service_title }}</h2>

                        <div>
                            <p class="portfolio-text mb-20 wow animate__fadeInUp" data-wow-delay="0.35s">
                                {!! $service_details->service_long_description !!}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <span class="shape-mockup" style="right: 0; bottom: 0px;"><img src="{{ asset('frontend/assets/img/shapes/contact-sheap2.png') }}" alt="counter element"></span>
        <span class="shape-mockup z-index-n1" style="left: 0; bottom: 0px;"><img src="{{ asset('frontend/assets/img/shapes/contact-sheap2.png') }}" alt="counter element"></span>

    </section>

@endsection
