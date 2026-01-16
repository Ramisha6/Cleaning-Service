<footer class="footer-wrapper footer-layout1">
    <div class="widget-area" data-bg-src="{{ asset('frontend/assets/img/bg/footer-bg-1-1.jpg') }}">
        <div class="container">
            <div class="row g-4">

                {{-- Column 1: About --}}
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="footer-widget">
                        <div class="vs-widget-about">
                            <div class="footer-logo mb-3">
                                <a href="{{ route('index') }}">
                                    <img src="{{ asset('frontend/assets/img/logo-white.png') }}" alt="Smart Clean">
                                </a>
                            </div>

                            <p class="footer-text">
                                We care about cleanliness, hygiene, and your comfort.
                                Let us keep your space fresh, safe, and spotless.
                            </p>

                            <div class="contact-box mt-3">
                                <span class="icon">
                                    <img src="{{ asset('frontend/assets/img/icon/call-icon.svg') }}" alt="Call">
                                </span>
                                <div class="contact-content">
                                    <h6 class="contact-title">
                                        <a href="tel:01300586763">01300 586 763</a>
                                    </h6>
                                    <p class="contact-text">Call us anytime</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Quick Links --}}
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="footer-widget widget_categories">
                        <h3 class="widget_title">Quick Links</h3>
                        <ul>
                            <li><a href="{{ route('about.us') }}">About Us</a></li>
                            <li><a href="{{ route('services') }}">Services</a></li>
                            <li><a href="{{ route('events') }}">Events</a></li>
                            <li><a href="{{ route('contact.us') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Column 3: Services --}}
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="footer-widget widget_categories">
                        <h3 class="widget_title">Our Services</h3>
                        <ul>
                            @php
                            $services = \App\Models\CleaningServices::where('service_status', 'active')->take(5)->get();
                            @endphp
                            @foreach ($services as $service)
                                <li><a href="{{ route('service.details', $service->service_slug) }}">{{ $service->service_title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Column 4: Social --}}
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="footer-widget">
                        <h3 class="widget_title">Follow Us</h3>

                        <p class="footer-text mb-3">
                            Stay connected with Smart Clean on social media.
                        </p>

                        <div class="social-style1">
                            <div class="social-icon">
                                <a href="#!"><i class="fab fa-facebook-f"></i></a>
                                <a href="#!"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#!"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="copyright-wrap">
        <div class="container text-center">
            <p class="copyright-text">
                <i class="fal fa-copyright"></i>
                {{ date('Y') }} <a href="{{ route('index') }}">Smart Clean</a>.
                All rights reserved.
            </p>
        </div>
    </div>
</footer>
