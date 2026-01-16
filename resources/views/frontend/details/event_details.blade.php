@extends('frontend.dashboard')
@section('frontend_title', $event->title)
@section('frontend')

    {{-- Breadcumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('frontend/assets/img/breadcumb/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">event <span>Details</span></h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><a href="{{ route('events') }}">Events</a></li>
                    <li>{{ Str::limit($event->title, 30) }}</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Event Details Area --}}
    <section class="portfolio-Details space">
        <div class="container">

            <div class="portfolio-content">
                <div class="row gx-60 g-5">

                    {{-- Main Content --}}
                    <div class="col-lg-8">

                        {{-- Event Image --}}
                        <div class="portfolio-img wow animate__fadeInUp" data-wow-delay="0.20s">
                            <img src="{{ $event->event_image ? asset('upload/event_image/' . $event->event_image) : asset('frontend/assets/img/gallery/p-d-1.jpg') }}" alt="{{ $event->title }}">
                        </div>

                        <h2 class="portfolio-title h3 mb-10 wow animate__fadeInUp" data-wow-delay="0.25s">
                            {{ $event->title }}
                        </h2>

                        {{-- Meta Info --}}
                        <div class="mb-20 wow animate__fadeInUp" data-wow-delay="0.30s">
                            <span class="me-3">
                                <i class="fa-regular fa-calendar-days"></i>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                            </span>

                            @if (!empty($event->event_time))
                                <span class="me-3">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
                                </span>
                            @endif

                            @if (!empty($event->location))
                                <span class="me-3">
                                    <i class="fa-solid fa-location-dot"></i>
                                    {{ $event->location }}
                                </span>
                            @endif
                        </div>

                        {{-- Long Description (Summernote HTML) --}}
                        <div class="wow animate__fadeInUp" data-wow-delay="0.45s">
                            {!! $event->description !!}
                        </div>

                    </div>

                    {{-- Sidebar --}}
                    <div class="col-lg-4">

                        {{-- Recent Events --}}
                        @if (!empty($recentEvents) && $recentEvents->count() > 0)
                            <div class="widget widget_categories style2 wow animate__fadeInUp" data-wow-delay="0.60s">
                                <h3 class="widget_title">Recent Events</h3>
                                <div class="widget_content">
                                    <ul>
                                        @foreach ($recentEvents as $re)
                                            <li>
                                                <a href="{{ route('event.details', $re->slug) }}">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                    {{ Str::limit($re->title, 35) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- Contact Box (optional) --}}
                        <div class="contact-box2 wow animate__fadeInUp" data-wow-delay="0.75s">
                            <h2 class="portfolio-title">Let’s Contact with us</h2>
                            <span class="icon-btn">
                                <img src="{{ asset('frontend/assets/img/icon/call-icon2.svg') }}" alt="call icon">
                            </span>
                            <div class="contact-content">
                                <h6 class="contact-title">Need help? Talk to expert</h6>
                                <p class="contact-text">
                                    <a href="tel:+880000000000">+880 0000-000000</a>
                                </p>
                            </div>
                            <span class="shape-mockup" style="left: 0; bottom: 0px;">
                                <img src="{{ asset('frontend/assets/img/shapes/contact-sheap1.png') }}" alt="shape">
                            </span>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- Shapes --}}
        <span class="shape-mockup" style="right: 0; top: 0px;">
            <img src="{{ asset('frontend/assets/img/shapes/service-shape-1.png') }}" alt="shape">
        </span>
        <span class="shape-mockup z-index-n1" style="left: 0; bottom: 0px;">
            <img src="{{ asset('frontend/assets/img/shapes/team-shep3.png') }}" alt="shape">
        </span>
    </section>

@endsection
