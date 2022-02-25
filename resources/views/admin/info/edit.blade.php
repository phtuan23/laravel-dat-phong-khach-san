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
                    <li class="breadcrumb-item active">Cập nhật thông tin</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('infomation.update',$infomation->id)}}" enctype="multipart/form-data" id="formData">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin khách sạn</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Logo <span class="text-danger">*</span></label>
                                        <br>
                                        <img src="{{url('public/upload')}}/{{$infomation->logo}}" width="60%" id="image">
                                        <input type="file" name="upload" hidden>
                                        <input type="button" class="form-control btn-select mt-3" value="Chọn Logo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone" value="{{$infomation->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" value="{{$infomation->email}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Lưu lại" style="width:50%">
                    <a href="{{route('hotel.index')}}" class="btn btn-secondary form-control" style="width:49.5%">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(".btn-select").click(function(){
            $("input[name='upload']").click();
        });

        $("input[name='upload']").change(function(){
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function(e){
                $("#image").attr("src",e.target.result);
            }
            reader.readAsDataURL(file);
        });

        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#formData").serialize();
            var upload = $("input[name='upload']")[0].files[0];
            var formData = new FormData($("#formData")[0]);
            if(upload){
                formData.append(upload,upload.name);
            } 
            $.ajax({
                url: "{{route('infomation.update',$infomation->id)}}",
                data: formData,
                type: "POST",
                contentType: false,
                processData: false,
                success: function(res) {
                    console.log(res)
                    if (res.code == 400) {
                        Swal.fire({
                            title: res.title,
                            html: res.message,
                            icon: res.icon
                        })
                    }
                    if (res.code == 200) {
                        window.location.href = "{{route('infomation.index')}}";
                    }
                }
            });
        });
    })
</script>
@endsection