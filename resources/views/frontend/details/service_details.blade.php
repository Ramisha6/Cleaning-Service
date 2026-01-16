@extends('frontend.dashboard')
@section('frontend_title', $service_details->service_title)
@section('frontend')

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('frontend/assets/img/breadcumb/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $service_details->service_title }}</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>Service Details</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Service Details Area -->
    <section class="portfolio-Details space position-relative">
        <div class="container">
            <div class="portfolio-content pt-0">
                <div class="row gx-60 g-5">

                    {{-- Sidebar --}}
                    <div class="col-lg-4">

                        {{-- Booking (same widget style like "All Services") --}}
                        <div class="widget widget_categories style2 wow animate__fadeInUp" data-wow-delay="0.75s">
                            <h3 class="widget_title">Service Overview</h3>
                            <div class="widget_content">
                                <ul class="service-overview-list">
                                    <li>
                                        <a href="javascript:void(0)" class="service-overview-row" aria-disabled="true">
                                            <span class="k">Service</span>
                                            <span class="v">{{ $service_details->service_title }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="service-overview-row" aria-disabled="true">
                                            <span class="k">Price</span>
                                            <span class="v">৳{{ $service_details->service_price }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="service-overview-row" aria-disabled="true">
                                            <span class="k">Duration</span>
                                            <span class="v">{{ $service_details->service_duration ?? 'N/A' }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="widget widget_categories style2 wow animate__fadeInUp" data-wow-delay="0.75s">
                            <h3 class="widget_title">Book Now</h3>

                            <div class="widget_content">
                                <form action="{{ route('service.booking.store') }}" method="POST" id="bookingForm">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $service_details->id }}">

                                    <div class="row gx-3">

                                        @php
                                            $authUser = Auth::user();
                                        @endphp

                                        <div class="col-12 form-group">
                                            <input name="name" type="text" class="form-control" placeholder="Your Name *" value="{{ old('name', $authUser?->name) }}" required>
                                        </div>

                                        <div class="col-12 form-group">
                                            <input name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email', $authUser?->email) }}" {{ $authUser ? 'readonly' : '' }}>
                                            @if ($authUser)
                                                <small class="text-muted">Email is locked from your account.</small>
                                            @endif
                                        </div>

                                        <div class="col-12 form-group">
                                            <input name="phone" type="text" class="form-control" placeholder="Phone *" value="{{ old('phone', $authUser?->phone) }}" required>
                                        </div>


                                        <div class="col-12 form-group">
                                            <input name="date" type="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>

                                        <div class="col-12 form-group">
                                            <textarea name="note" class="form-control" placeholder="Note (optional)" rows="3"></textarea>
                                        </div>

                                        {{-- Payment Method --}}
                                        <div class="col-12 form-group">
                                            <label class="mb-2 d-block">Payment Method</label>

                                            <ul class="payment-list">
                                                <!-- COD Option -->
                                                <li class="payment-li">
                                                    <label class="payment-item" for="pm_cod">
                                                        <input type="radio" id="pm_cod" name="payment_method" value="cod" checked>
                                                        <span class="payment-text">
                                                            <strong>Cash on Delivery</strong>
                                                            <small>Pay after service</small>
                                                        </span>
                                                    </label>
                                                </li>

                                                <!-- bKash Option -->
                                                <li class="payment-li">
                                                    <label class="payment-item" for="pm_bkash">
                                                        <input type="radio" id="pm_bkash" name="payment_method" value="bkash">
                                                        <span class="payment-text">
                                                            <strong>bKash</strong>
                                                            <small>Send Money</small>
                                                        </span>
                                                    </label>
                                                </li>
                                            </ul>

                                            <div id="bkashInfo" class="bkash-info" hidden>
                                                <small>
                                                    Send money to: <strong>01XXXXXXXXX</strong><br>
                                                    Amount: <strong>৳{{ $service_details->service_price }}</strong><br>
                                                    Reference: <strong>{{ $service_details->service_title }}</strong>
                                                </small>
                                            </div>
                                        </div>

                                        {{-- bKash fields --}}
                                        <div id="bkashFields" class="col-12" hidden>
                                            <div class="row gx-3">
                                                <div class="col-12 form-group">
                                                    <input name="bkash_number" type="text" class="form-control" placeholder="bKash Number *">
                                                </div>
                                                <div class="col-12 form-group">
                                                    <input name="transaction_id" type="text" class="form-control" placeholder="bKash Transaction ID *">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 form-group mb-0">
                                            @auth
                                                <button class="vs-btn w-100" type="submit">Confirm Booking</button>
                                            @else
                                                <div class="sidebar-btns">
                                                    <a class="vs-btn sidebar-btn sidebar-btn--solid" href="{{ route('login') }}">
                                                        <span>Login to Book</span>
                                                    </a>
                                                    <a class="vs-btn sidebar-btn sidebar-btn--solid" href="{{ route('register') }}">
                                                        <span>Register</span>
                                                    </a>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                </form>

                                <p class="form-messages mb-0 mt-3"></p>
                            </div>
                        </div>

                        {{-- All Services --}}
                        <div class="widget widget_categories style2 wow animate__fadeInUp" data-wow-delay="0.75s">
                            <h3 class="widget_title">All Services</h3>
                            <div class="widget_content">
                                <ul>
                                    @foreach ($service_list as $service)
                                        <li>
                                            <a href="{{ route('service.details', $service->service_slug) }}">
                                                <i class="fa-solid fa-angles-right"></i>
                                                {{ $service->service_title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Contact Box --}}
                        <div class="contact-box2 wow animate__fadeInUp" data-wow-delay="0.85s">
                            <h2 class="portfolio-title">Let’s Contact with us</h2>
                            <span class="icon-btn">
                                <img src="{{ asset('frontend/assets/img/icon/call-icon2.svg') }}" alt="call icon">
                            </span>
                            <div class="contact-content">
                                <h6 class="contact-title">Need help? Talk to expert</h6>
                                <p class="contact-text"><a href="tel:+9-666-888-679">+9 112 - 8899</a></p>
                            </div>
                            <span class="shape-mockup" style="left: 0; bottom: 0px;">
                                <img src="{{ asset('frontend/assets/img/shapes/contact-sheap1.png') }}" alt="team element">
                            </span>
                        </div>

                    </div>

                    {{-- Service Details --}}
                    <div class="col-lg-8">
                        <div class="portfolio-img mb-40 wow animate__fadeInUp" data-wow-delay="0.20s">
                            <img src="{{ !empty($service_details->service_image) ? url('upload/service_image/' . $service_details->service_image) : url('upload/no_image.jpg') }}" alt="{{ $service_details->service_title }}">
                        </div>

                        <h2 class="portfolio-title h3 mb-20 wow animate__fadeInUp" data-wow-delay="0.25s">
                            {{ $service_details->service_title }}
                        </h2>

                        <div>
                            <p class="portfolio-text mb-20 wow animate__fadeInUp" data-wow-delay="0.35s">
                                {!! $service_details->service_long_description !!}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <span class="shape-mockup" style="right: 0; bottom: 0px;">
            <img src="{{ asset('frontend/assets/img/shapes/contact-sheap2.png') }}" alt="counter element">
        </span>
        <span class="shape-mockup z-index-n1" style="left: 0; bottom: 0px;">
            <img src="{{ asset('frontend/assets/img/shapes/contact-sheap2.png') }}" alt="counter element">
        </span>
    </section>

@endsection
