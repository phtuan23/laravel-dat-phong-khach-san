@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm mới tài khoản</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Quản lý tài khoản</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>
        <form method="post" action="{{route('customer.store')}}" enctype="multipart/form-data" id="formData">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin khách hàng</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên khách hàng <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên khách hàng" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ email <span class="text-danger">*</span></label>
                                <input type="text" name="email" class="form-control" placeholder="Nhập địa chỉ email" autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ </label>
                                        <input type="text" name="address" class="form-control" placeholder="Nhập số điện thoại" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giới tính </label>
                                        <select class="form-control" name="gender">
                                            <option value="">Chọn giới tính</option>
                                            <option value="1">Nam</option>
                                            <option value="0">Nữ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off">
                                <ul class="text-muted mt-1">
                                    <li>Mật khẩu ít nhất 6 ký tự</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="cf_password" class="form-control" placeholder="Xác nhận mật khẩu" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Thêm mới" style="width:50%">
                    <a href="{{route('customer.index')}}" class="btn btn-secondary form-control" style="width:49.5%">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#formData").serialize();
            $.ajax({
                url: "{{route('customer.store')}}",
                data: data,
                type: "POST",
                success: function(res) {
                    if (res.status == false) {
                        Swal.fire({
                            title: res.title,
                            html: res.message,
                            icon: res.icon
                        })
                    }
                    if (res.status == true) {
                        window.location.href = "{{route('customer.index')}}";
                    }
                }
            });
        });
    })
</script>
@endsection