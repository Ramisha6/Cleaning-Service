@extends('frontend.dashboard')
@section('frontend_title', 'Services')
@section('frontend')

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('frontend/assets/img/breadcumb/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Services</h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>Service</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Service Area --}}
    <section class="service-area py-5">

        <div class="container">

            <div class="row my-5">

                @foreach ($services as $key => $service)
                    <div class="col-lg-4 col-md-6 mb-4 wow animate__fadeInUp" data-wow-delay="0.25s">
                        <div class="vs-service__style1 h-100">
                            <div class="vs-service__img">
                                <a href="{{ route('service.details', $service->service_slug) }}">
                                    <img src="{{ !empty($service->service_image) ? url('upload/service_image/' . $service->service_image) : url('upload/no_image.jpg') }}" alt="{{ $service->service_title }}" class="img-fluid">
                                </a>
                            </div>

                            <div class="vs-service__body">
                                <div class="vs-service__header">
                                    <div class="vs-service__content">
                                        <h2 class="vs-service__title h6">
                                            <a href="{{ route('service.details', $service->service_slug) }}">
                                                {{ $service->service_title }}
                                            </a>
                                        </h2>
                                    </div>

                                    <div class="vs-service__price">
                                        ৳{{ $service->service_price }}
                                    </div>
                                </div>

                                <p class="vs-service__text">
                                    {{ $service->service_short_description }}
                                </p>

                                {{-- Book Now button --}}
                                <div class="vs-service__actions">
                                    <a href="{{ route('service.details', $service->service_slug) }}#book" class="btn-book-now">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
        
    </section>

@endsection
