@extends('layout.client')
@section('content')
<!-- Hero Section Begin -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1>Khách sạn Aptech</h1>
                    <p>Dưới đây là các trang web đặt phòng khách sạn tốt nhất, bao gồm các đề xuất cho quốc tế
                        du lịch và tìm phòng khách sạn giá rẻ.</p>
                    <a href="#" class="primary-btn">Khám phá ngay</a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{url('public/client')}}/img/hero/hero-1.jpg"></div>
        <div class="hs-item set-bg" data-setbg="{{url('public/client')}}/img/hero/hero-2.jpg"></div>
        <div class="hs-item set-bg" data-setbg="{{url('public/client')}}/img/hero/hero-3.jpg"></div>
    </div>
</section>
<!-- Hero Section End -->

<!-- About Us Section Begin -->
<section class="aboutus-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-text">
                    <div class="section-title">
                        <span>Về chúng tôi</span>
                        <h2>Khách sạn Aptech</h2>
                    </div>
                    <p class="f-para">Chúng tôi đam mê
                        du lịch. Mỗi ngày, chúng tôi truyền cảm hứng và tiếp cận hàng triệu khách du lịch trên 90 trang web địa phương trong 41
                        ngôn ngữ.</p>
                    <p class="s-para">Vì vậy, khi nói đến việc đặt khách sạn hoàn hảo, cho thuê kỳ nghỉ, khu nghỉ dưỡng,
                        căn hộ, nhà khách hoặc nhà trên cây, chúng tôi đã hỗ trợ bạn.</p>
                    <a href="#" class="primary-btn about-btn">Xem thêm</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-pic">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="{{url('public/client')}}/img/about/about-1.jpg" alt="">
                        </div>
                        <div class="col-sm-6">
                            <img src="{{url('public/client')}}/img/about/about-2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Section End -->

<!-- Services Section End -->
<section class="services-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Chúng ta làm gì?</span>
                    <h2>Khám phá các dịch vụ của chúng tôi</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-036-parking"></i>
                    <h4>Kế hoạch đi du lịch</h4>
                    <p>Cung cấp nhiều chuyến du lịch quanh thế giới.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-033-dinner"></i>
                    <h4>Dịch vụ ăn uống</h4>
                    <p>Cung cấp nhiều dịch vụ ăn uống. Tổ chức các sự kiện lớn.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-026-bed"></i>
                    <h4>Trông trẻ</h4>
                    <p>Cung cấp dịch vụ trông trẻ.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-024-towel"></i>
                    <h4>Giặt ủi</h4>
                    <p>Cung cấp dịch vụ vệ sinh và giặt là.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-044-clock-1"></i>
                    <h4>Thuê tài xế</h4>
                    <p>Cung cấp dịch vụ thuê lái xe riêng.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-012-cocktail"></i>
                    <h4>Quầy Bar và Đồ uống</h4>
                    <p>Khu vực quầy bar và ăn uống cao cấp.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Tin túc mới</span>
                    <h2>Sư kiện của chúng tôi</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="blog-item set-bg" data-setbg="{{url('public/client')}}/img/blog/blog-1.jpg">
                    <div class="bi-text">
                        <span class="b-tag">Du lịch</span>
                        <h4><a href="#">Tremblant In Canada</a></h4>
                        <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-item set-bg" data-setbg="{{url('public/client')}}/img/blog/blog-2.jpg">
                    <div class="bi-text">
                        <span class="b-tag">Cắm trại</span>
                        <h4><a href="#">Choosing A Static Caravan</a></h4>
                        <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-item set-bg" data-setbg="{{url('public/client')}}/img/blog/blog-3.jpg">
                    <div class="bi-text">
                        <span class="b-tag">Sự kiện</span>
                        <h4><a href="#">Copper Canyon</a></h4>
                        <div class="b-time"><i class="icon_clock_alt"></i> 21th April, 2019</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="blog-item small-size set-bg" data-setbg="{{url('public/client')}}/img/blog/blog-wide.jpg">
                    <div class="bi-text">
                        <span class="b-tag">Sự kiện</span>
                        <h4><a href="#">Trip To Iqaluit In Nunavut A Canadian Arctic City</a></h4>
                        <div class="b-time"><i class="icon_clock_alt"></i> 08th April, 2019</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-item small-size set-bg" data-setbg="{{url('public/client')}}/img/blog/blog-10.jpg">
                    <div class="bi-text">
                        <span class="b-tag">Du lịch</span>
                        <h4><a href="#">Traveling To Barcelona</a></h4>
                        <div class="b-time"><i class="icon_clock_alt"></i> 12th April, 2019</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop()