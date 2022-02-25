@extends('layout.client')
@section('content')
<!-- Breadcrumb Section Begin -->
<div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Về chúng tôi</h2>
                        <div class="bt-option">
                            <a href="./index.html">Trang chủ</a>
                            <span>Về chúng tôi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- About Us Page Section Begin -->
    <section class="aboutus-page-section spad">
        <div class="container">
            <div class="about-page-text">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ap-title">
                            <h2>Chào mừng đến với Aptech Hotel.</h2>
                            <p>Được xây dựng vào năm 2000, khách sạn này nằm ở trung tâm của
                                thành phố, dễ dàng tiếp cận các điểm du lịch của thành phố. Nó cung cấp một cách trang nhã
                                phòng được trang trí.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-1">
                        <ul class="ap-services">
                            <li><i class="icon_check"></i> Giảm giá 20%.</li>
                            <li><i class="icon_check"></i> Bữa sáng hàng ngày miễn phí</li>
                            <li><i class="icon_check"></i> Giặt là mỗi ngày</li>
                            <li><i class="icon_check"></i> Miễn phí wifi.</li>
                            <li><i class="icon_check"></i> Giảm 20% đồ ăn uống</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="about-page-services">
                <div class="row">
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="{{url('public/client')}}/img/about/about-p1.jpg">
                            <div class="api-text">
                                <h3>Dịch vụ nhà ăn riêng</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="{{url('public/client')}}/img/about/about-p2.jpg">
                            <div class="api-text">
                                <h3>Du lịch và cắm trại</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="{{url('public/client')}}/img/about/about-p3.jpg">
                            <div class="api-text">
                                <h3>Sự kiện và tiệc</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Page Section End -->

    <!-- Video Section Begin -->
    <section class="video-section set-bg" data-setbg="{{url('public/client')}}/img/video-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <h2>Khám phá Khách sạn & Dịch vụ của Chúng tôi.</h2>
                        <p>Đó là Mùa Bão Nhưng Chúng Tôi Đang Đến Đảo Hilton Head</p>
                        <a href="https://www.youtube.com/watch?v=EzKkl64rRbM" class="play-btn video-popup"><img
                                src="{{url('public/client')}}/img/play.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Video Section End -->

    <!-- Gallery Section Begin -->
    <section class="gallery-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Our Gallery</span>
                        <h2>Discover Our Work</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="gallery-item set-bg" data-setbg="{{url('public/client')}}/img/gallery/gallery-1.jpg">
                        <div class="gi-text">
                            <h3>Phòng đôi</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="{{url('public/client')}}/img/gallery/gallery-3.jpg">
                                <div class="gi-text">
                                    <h3>Phòng đơn</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="{{url('public/client')}}/img/gallery/gallery-4.jpg">
                                <div class="gi-text">
                                    <h3>Phòng gia đình</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="gallery-item large-item set-bg" data-setbg="{{url('public/client')}}/img/gallery/gallery-2.jpg">
                        <div class="gi-text">
                            <h3>Nhiều tiện nghi đang chờ bạn.</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gallery Section End -->

@stop()