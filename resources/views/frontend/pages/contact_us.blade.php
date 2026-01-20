@extends('frontend.dashboard')
@section('frontend_title', 'Contact Us')
@section('frontend')

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('frontend/assets/img/breadcumb/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">contact <span>us</span></h1>
            </div>
            <div class="breadcumb-menu-wrap">
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>contact us</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Contact Area --}}
    <section class="contact-layout1 space">
        <div class="container">
            <div class="row g-5 gx-60">

                <div class="col-xl-5">
                    <div class="contact-style1">

                        <div class="title-area text-left wow animate__fadeInUp animation-style2" data-wow-delay="0.25s">
                            <span class="sec-subtitle left-shape justify-content-center title-anime__title">CONTACT US</span>
                            <h2 class="sec-title title-anime__title">Get in touch with us</h2>
                        </div>

                        <div class="contact-inner wow animate__fadeInUp" data-wow-delay="0.35s">
                            <div class="contact-address">
                                <span>Address:</span>
                                <a class="address">Dhaka, Bangladesh</a>
                            </div>
                            <div class="contact-box">
                                <span class="contact-icon">
                                    <i class="fa-light fa-phone-volume"></i>
                                </span>
                                <div class="contact-content">
                                    <h6 class="contact-title">Customer Service :</h6>
                                    <p class="contact-text">+880 1300 586763</p>
                                </div>
                            </div>
                            <div class="contact-box">
                                <span class="contact-icon">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                                <div class="contact-content">
                                    <h6 class="contact-title">careers :</h6>
                                    <p class="contact-text">exemple@info.com</p>
                                </div>
                            </div>
                        </div>

                        <div class="social-style2 wow animate__fadeInUp" data-wow-delay="0.45s">
                            <span class="social-title">Follow Us :</span>
                            <div class="social-icon">
                                <a href="#!"><i class="fab fa-facebook-f"></i></a>
                                <a href="#!"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#!"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xl-7">
                    <div class="form-style2 wow animate__fadeInUp" data-wow-delay="0.55s">
                        <div class="vs-comment-form">
                            <div id="respond">

                                {{-- ✅ success message --}}
                                @if (session('message'))
                                    <div class="alert alert-success mb-3">
                                        {{ session('message') }}
                                    </div>
                                @endif

                                {{-- ✅ show all errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('contact.store') }}" method="POST">
                                    @csrf

                                    <div class="row gx-3">

                                        <div class="col-md-12 form-group">
                                            <input name="name" type="text" class="form-control" placeholder="Your Name *" value="{{ old('name') }}" required>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <input name="phone" type="text" class="form-control" placeholder="Your Phone *" value="{{ old('phone') }}" required>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <input name="email" type="email" class="form-control" placeholder="Your Email *" value="{{ old('email') }}" required>
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <input name="subject" type="text" class="form-control" placeholder="Your Subject *" value="{{ old('subject') }}" required>
                                        </div>

                                        <div class="col-12 form-group mt-1 mb-30">
                                            <textarea name="message" class="form-control" placeholder="your message ..." required>{{ old('message') }}</textarea>
                                        </div>

                                        <div class="col-12 form-group mb-0">
                                            <button class="vs-btn" type="submit">Send message</button>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
