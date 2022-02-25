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
        <form method="post" action="{{route('account.store')}}" enctype="multipart/form-data" id="form-add">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Chọn ảnh đại diện</h3>
                            <input type="file" class="form-control"  id="avatar" name="avatar" hidden>
                            
                        </div>
                        <div class="card-body">
                            <img src="https://png.pngtree.com/png-vector/20190114/ourlarge/pngtree-vector-add-user-icon-png-image_313043.jpg" id="image" width="100%" style="cursor: pointer">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin tài khoản</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" autocomplete="off">
                                <ul class="text-muted mt-1">
                                    <li>Tên đăng nhập ít nhất 6 ký tự và tối đa 20 ký tự</li>
                                    <li>Tên đăng nhập không chứa khoảng trắng</li>
                                    <li>Tên đăng nhập không chứa ký tự đặc biệt</li>
                                </ul>
                                    <small class="text-danger username"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ email <span class="text-danger">*</span></label>
                                <input type="text" name="email" class="form-control" placeholder="Nhập địa chỉ email" autocomplete="off">
                                    <small class="text-danger email"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off">
                                    <small class="text-danger password"></small>
                                <ul class="text-muted mt-1">
                                    <li>Mật khẩu ít nhất 6 ký tự</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="cf_password" class="form-control" placeholder="Xác nhận mật khẩu" autocomplete="off">
                                    <small class="text-danger cf_password"></small>
                            </div>
                        </div>
                    </div>
                    <input type="submit"  class="btn btn-dark form-control btn-submit" value="Thêm mới" style="width:50%">
                    <a href="{{route('account.index')}}"  class="btn btn-secondary form-control" style="width:49.5%">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            
            $("#image").click(function(){
                $("#avatar").click();
            });

            $("#avatar").change(function(){
                var file = $(this)[0].files[0];
                var reader = new FileReader();
                reader.onload = function(e){
                    $("#image").attr("src", e.target.result);
                }
                reader.readAsDataURL(file);
            });

            $(document).on('click','.btn-submit',function(e){
                e.preventDefault();
                var url = $("#form-add").attr("action");
                var data = new FormData($("#form-add")[0]);
                $.ajax({
                    url : url,
                    type : "POST",
                    data : data,
                    processData: false,
                    contentType: false,
                    success : function(res){
                        if(res.status==false){
                            Swal.fire({
                                icon : res.icon,
                                html : res.message,
                                title : res.title
                            });
                        }else{
                            window.location = res.url;
                        }
                    }
                })
            })
        });
    </script>
@endsection