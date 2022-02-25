@extends('layout.client')
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1 style="font-size:48px">Quên mật khẩu?</h1>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                <div class="booking-form">
                    @if(Session::has('success'))
                    <ol class="m-auto">
                            <h4>Đặt lại mật khẩu của bạn</h4>
                            <p>Để đặt lại mật khẩu, vui lòng làm theo các bước sau đây trong 24h</p>
                            <li> Chúng tôi đã gửi một liên kết đến email của bạn</li>
                            <li> Nhấp vào liên kết trong email để đặt lại mật khẩu</li>
                            <li> Sau khi bạn lưu mật khẩu mới của mình, bạn sẽ tự động được đăng nhập.</li>
                            <p>Xin cảm ơn !</p>
                            <a href="{{route('client.index')}}">Trở về trang chủ</a>
                        </ol>
                    @else
                    <h3>Xác nhận email</h3>
                    <form action="#" method="POST" id="data">
                        @csrf
                        <div class="form-group">
                            <label for="">Vui lòng nhập Email của bạn</label>
                            <input type="text" name="email" class="form-control mt-2" placeholder="Nhập địa chỉ email của bạn" autocomplete="off">
                        </div>
                        <button type="submit" id="login">Gửi</button>
                        <br>
                        <a href="{{route('client.login')}}" class="text-dark float-right">Quay lại đăng nhập</a>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- banner -->
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{url('public/client')}}/img/hero/hero-1.jpg"></div>
    </div>
</section>

@stop()
@section('js')
    <script>
        $(document).ready(function(){
            $("#login").click(function(e){
                e.preventDefault();
                var data = $("#data").serialize();
                $.ajax({
                    url : "{{url('forgot-password')}}",
                    data : data,
                    type : "POST",
                    success : function(res){
                        if (res.code == 400) {
                            Swal.fire({
                                html: res.message,
                                icon: res.icon
                            });
                        }
                        if(res.code==444){
                            Swal.fire({
                                title: res.title,
                                html: res.message,
                                icon: res.icon
                            });
                        }
                        if (res.code == 200) {
                            window.location.href = "{{route('client.forgot.password')}}"
                        }
                    }
                });
            })
        });
    </script>
@endsection