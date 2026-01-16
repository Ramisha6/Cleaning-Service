@extends('frontend.dashboard')
@section('frontend_title', 'Events')
@section('frontend')

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('frontend/assets/img/breadcumb/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">our <span>events</span></h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>our events</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Event Area --}}
    <section class="vs-blog__layout1 space" data-bg-src="{{ asset('frontend/assets/img/bg/blog-bg1.png') }}">
        <div class="container">

            @if ($events->count() > 0)
                <div class="row">

                    @foreach ($events as $key => $event)
                        <div class="col-lg-4 col-md-6 mb-4 wow animate__fadeInUp" data-wow-delay="{{ 0.15 + $key * 0.1 }}s">

                            <div class="vs-blog__style1 h-100">
                                <div class="row gx-4 align-items-center">

                                    <div class="col-xl-auto">
                                        <div class="blog-img">
                                            <a href="{{ route('event.details', $event->slug) }}">
                                                <img src="{{ $event->event_image ? asset('upload/event_image/' . $event->event_image) : asset('frontend/assets/img/blog/blog-s-3-1.jpg') }}" alt="{{ $event->title }}">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="blog-content">

                                            <div class="blog-inner-author">
                                                <span class="blog-date">
                                                    <i class="fa-regular fa-calendar-days" style="margin-right: 5px;margin-top: 4px;"></i>
                                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                                </span>

                                                @if ($event->location)
                                                    <span class="blog-date">
                                                        <i class="fa-solid fa-location-dot" style="margin-right: 5px;margin-top: 4px;"></i>
                                                        {{ $event->location }}
                                                    </span>
                                                @endif
                                            </div>

                                            <h2 class="blog-title">
                                                <a href="{{ route('event.details', $event->slug) }}">
                                                    {{ Str::limit($event->title, 45) }}
                                                </a>
                                            </h2>

                                            @if ($event->short_description)
                                                <p class="mb-2">
                                                    {{ Str::limit(strip_tags($event->short_description), 90) }}
                                                </p>
                                            @endif

                                            <div class="blog-btn">
                                                <a class="link-btn" href="{{ route('event.details', $event->slug) }}">
                                                    <span class="icon"><i class="fa-solid fa-arrow-right"></i></span>
                                                    Read More
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                <div class="text-center">
                    <h4>No events found</h4>
                    <p>Please check back later.</p>
                </div>
            @endif

        </div>
    </section>

@endsection
