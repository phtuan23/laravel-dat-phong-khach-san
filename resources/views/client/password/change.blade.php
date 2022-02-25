@extends('layout.client')
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                <div class="booking-form">
                    <h3>Thay đổi mật khẩu</h3>
                    <form action="#" method="POST" id="data">
                        @csrf
                        <div class="form-group">
                            <label for="">Vui lòng nhập mật khẩu</label>
                            <input type="password" name="password" class="form-control mt-2" placeholder="Nhập địa mật khẩu mới" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Xác nhận mật khẩu</label>
                            <input type="password" name="cf_password" class="form-control mt-2" placeholder="Nhập Lại mật khẩu" autocomplete="off">
                        </div>
                        <button type="submit" id="login">Xác nhận</button>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- banner -->
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{url('public/client')}}/img/hero/hero-2.jpg"></div>
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
                    url : "{{url()->current()}}",
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
                            window.location.href = "{{route('client.login')}}"
                        }
                    }
                });
            })
        });
    </script>
@endsection