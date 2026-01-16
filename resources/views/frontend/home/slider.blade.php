<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="swiper bannerSwiper">
                    <div class="swiper-wrapper">

                        @foreach ($slider as $key => $item)
                            <div class="swiper-slide">
                                <img src="{{ !empty($item->slider_image) ? url('upload/slider_image/' . $item->slider_image) : url('upload/no_image.jpg') }}" alt="Slider Image">
                            </div>
                        @endforeach

                    </div>

                    <!-- Indicators -->
                    <div class="swiper-pagination"></div>

                    <!-- Navigation -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

            </div>
        </div>
    </div>
</section>
