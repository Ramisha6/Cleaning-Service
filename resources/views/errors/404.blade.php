@extends('frontend.dashboard')
@section('frontend_title', 'Error 404')
@section('frontend')

    {{-- Breadcumb --}}
    <div class="breadcumb-wrapper " data-bg-src="{{ asset('frontend/assets/img/breadcumb/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">error <span>404</span></h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>error 404</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Error 404 Section -->
    <div class="error-area space h-100vh d-flex align-items-center justify-content-center" data-bg-src="{{ asset('frontend/assets/img/bg/bg-shep1.png') }}">

        <div class="container">

            <div class="error-area__content text-center">

                <span class="error-area__img wow animate__fadeInUp animation-style2" data-wow-delay="0.25s">
                    <img src="{{ asset('frontend/assets/img/default/error-img.svg') }}" alt="Error image">
                </span>

                <div class="error-area__text wow animate__fadeInUp" data-wow-delay="0.65s"><span>Oops!</span> That page can't befound.</div>

                <a class="vs-btn2 wow animate__bounceInUp" data-wow-delay="0.85s" href="{{ route('index') }}">go back homepage<i class="far fa-long-arrow-right"></i></a>

            </div>

        </div>

    </div>
    <!-- Error 404 Section End -->

@endsection
