@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cập nhật thông tin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Cập nhật tài khoản</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('customer.update',$customer->id)}}" enctype="multipart/form-data" id="formData">
            @csrf
            <input type="hidden" name="_method" value="PUT">
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
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên đăng nhập" autocomplete="off" value="{{$customer->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" autocomplete="off" value="{{$customer->phone}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ email <span class="text-danger">*</span></label>
                                <input type="text" name="email" class="form-control" placeholder="Nhập địa chỉ email" autocomplete="off" value="{{$customer->email}}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ </label>
                                        <input type="text" name="address" class="form-control" placeholder="Nhập số điện thoại" autocomplete="off" value="{{$customer->address}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giới tính </label>
                                        <select class="form-control" name="gender">
                                            <option>Chọn giới tính</option>
                                            <option value="1" {{$customer->gender=="1"?'selected':''}}>Nam</option>
                                            <option value="0" {{$customer->gender=="0"?'selected':''}}>Nữ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Cập nhật" style="width:50%">
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
                url: "{{route('customer.update',$customer->id)}}",
                type : "POST",
                data: data,
                success: function(res) {
                    if (res.status == false) {
                        Swal.fire({
                            title: res.title,
                            html: res.message,
                            icon: res.icon
                        })
                    }
                    if (res.status == true) {
                        window.location.href = "{{route('customer.index')}}"
                    }
                }
            });
        });
    })
</script>
@endsection