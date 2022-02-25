@extends('layout.client')
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1>Đăng nhập</h1>
                    <p>Đăng nhập tài khoản của bạn để khám phá ngay các dịch vụ và các căn phòng nghỉ dưỡng tuyệt vời của chúng tôi !</p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                <div class="booking-form">
                    <h3>Đăng nhập</h3>
                    <form action="#" method="POST" id="data">
                        @csrf
                        <div class="form-group">
                            <label for="">Nhập Email của bạn</label>
                            <input type="text" name="email" class="form-control" placeholder="Email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Nhập mật khẩu của bạn</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                        </div>
                        <div class="form-check mb-2">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="remember">
                                Lưu mật khẩu
                            </label>
                        </div>
                        <span>Bạn chưa có tài khoản ?<a href="{{route('client.register')}}" class="ml-2" style="color: #dfa974">Đăng ký tại đây !</a></span>

                        <div class="mt-3 text-center">
                            <a href="{{route('client.forgot.password')}}" style="color: #dfa974">Quên mật khẩu?</a>
                        </div>

                        <button type="submit" id="login">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- banner -->
    <div class="hero-slider owl-carousel">
        @foreach($banners as $item)
            <div class="hs-item set-bg" data-setbg="{{url('public/upload')}}/{{$item->image}}"></div>
        @endforeach
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
                    url : "{{url('login')}}",
                    data : data,
                    type : "POST",
                    success : function(res){
                        if (res.code == 400) {
                            Swal.fire({
                                title: res.title,
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
                            window.location.href = "{{route('client.index')}}"
                        }
                    }
                });
            })
        });
    </script>
@endsection