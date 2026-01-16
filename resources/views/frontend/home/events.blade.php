{{-- Event Area --}}
<section class="vs-blog__layout1 space" data-bg-src="{{ asset('frontend/assets/img/bg/blog-bg1.png') }}" style="padding-top: 0;">

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="title-area text-center wow animate__fadeInUp title-anime animation-style5" data-wow-delay="0.25s">
                    <span class="sec-subtitle justify-content-center title-anime__title">OUR Events</span>
                    <h2 class="sec-title title-anime__title">Updated Events</h2>
                </div>
            </div>
        </div>

        @if ($events->count() > 0)
            <div class="row align-items-center vs-carousel" data-slide-show="3" data-ml-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-autoplay="true" data-arrows="true">

                @foreach ($events as $key => $event)
                    <div class="col-xl-4 wow animate__fadeInUp" data-wow-delay="{{ 0.25 + $key * 0.2 }}s">
                        <div class="vs-blog__style1">
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

                                            @if (!empty($event->location))
                                                <span class="blog-date">
                                                    <i class="fa-solid fa-location-dot" style="margin-right: 5px;margin-top: 4px;"></i>
                                                    {{ $event->location }}
                                                </span>
                                            @endif
                                        </div>

                                        <h2 class="blog-title">
                                            <a href="{{ route('event.details', $event->slug) }}">
                                                {{ $event->title }}
                                            </a>
                                        </h2>

                                        @if (!empty($event->short_description))
                                            <p class="mb-2">
                                                {{ Str::limit(strip_tags($event->short_description), 80) }}
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
