@extends('frontend.dashboard')
@section('frontend_title', 'Home')
@section('frontend')

    <!--=============== Slider ===============-->
    @include('frontend.home.slider')

    <!--=============== Services ===============-->
    @include('frontend.home.services')

@endsection
