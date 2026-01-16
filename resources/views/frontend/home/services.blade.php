<section class="vs-service__layout1 space position-relative">

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="title-area text-center wow animate__fadeInUp title-anime animation-style5" data-wow-delay="0.25s">
                    <span class="sec-subtitle justify-content-center title-anime__title"> CLEANING SERVICE</span>
                    <h2 class="sec-title title-anime__title">Our Excellent Service</h2>
                </div>
            </div>
        </div>

        <div class="row vs-carousel" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-autoplay="true" data-arrows="true">

            @foreach ($services as $key => $service)
                <div class="col-lg-3 wow animate__fadeInUp" data-wow-delay="0.25s">
                    <div class="vs-service__style1">
                        <div class="vs-service__img">
                            <a href="{{ route('service.details', $service->service_slug) }}">
                                <img src="{{ !empty($service->service_image) ? url('upload/service_image/' . $service->service_image) : url('upload/no_image.jpg') }}" alt="{{ $service->service_title }}">
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

                            <p class="vs-service__text">{{ $service->service_short_description }}</p>

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

    <span class="shape-mockup z-index-n1 d-xl-block d-none" style="right: 0; top: 0px;"><img src="{{ asset('frontend/assets/img/shapes/service-shape-1.png') }}" alt="counter element"></span>
    <span class="shape-mockup z-index-n1 custom-sheap" style="right: 0; bottom: 0px;"><img src="{{ asset('frontend/assets/img/shapes/service-shape-2.png') }}" alt="counter element"></span>
    <span class="shape-mockup z-index-n1 d-xl-block d-none" style="left: 0; bottom: 0px;"><img src="{{ asset('frontend/assets/img/shapes/service-shape-3.png') }}" alt="counter element"></span>

</section>
