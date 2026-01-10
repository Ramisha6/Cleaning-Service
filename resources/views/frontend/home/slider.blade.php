<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="swiper bannerSwiper">
                    <div class="swiper-wrapper">

                        @php
                            $banners = [
                                'frontend/assets/img/banner/banner_3.jpg',
                                'frontend/assets/img/banner/banner_2.jpg',
                                'frontend/assets/img/banner/banner_1.jpg',
                            ];
                        @endphp

                        @foreach($banners as $banner)
                            <div class="swiper-slide">
                                <img src="{{ asset($banner) }}" class="d-block w-100" alt="Banner">
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
