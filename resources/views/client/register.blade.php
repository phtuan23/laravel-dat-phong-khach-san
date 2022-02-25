@extends('layout.client')
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1>Đăng ký</h1>
                    <p>Đăng ký tài khoản của bạn để khám phá ngay các dịch vụ và các căn phòng nghỉ dưỡng tuyệt vời của chúng tôi !</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="booking-form">
                    <h3>Đăng ký thành viên</h3>
                    <form action="" method="POST" id="data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Họ và tên (*)</label>
                                    <input type="text" name="name" class="form-control" placeholder="Họ và tên" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Số điện thoại (*)</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" placeholder="Địa chỉ" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email (*)</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="">Mật khẩu (*)</label>
                          <input type="password" name="password" class="form-control" placeholder="Mật khẩu" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="">Nhập lại mật khẩu (*)</label>
                          <input type="password" name="cf_password" class="form-control" placeholder=" Xác nhận mật khẩu" autocomplete="off">
                        </div>
                        <button type="submit" id="register">Đăng Ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{url('public/client')}}/img/hero/hero-1.jpg"></div>
    </div>
</section>

@stop()

@section('js')
    <script>
        $(document).ready(function(){
            $("#register").on("click",function(e){
                e.preventDefault();
                var data = $("#data").serialize();
                $.ajax({
                    url : "{{url('register')}}",
                    type : "POST",
                    data : data,
                    success : function(res){
                        if (res.code == 400) {
                            Swal.fire({
                                title: res.title,
                                html: res.message,
                                icon: res.icon
                            });
                        }
                        if (res.code == 200) {
                            window.location.href = "{{route('client.login')}}"
                        }
                    }
                });
            })
        })
    </script>
@endsection