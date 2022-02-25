@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cập nhật ảnh bìa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Quản lý ảnh bìa</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('banner.update',$banner->id)}}" enctype="multipart/form-data" id="formData">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin ảnh bìa</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh banner <span class="text-danger">*</span> </label>
                                <input type="file" name="image" hidden id="image">
                                <input type="button" class="form-control" style="width:30%" value="Chọn banner" id="select_image">
                                <img src="{{url('public/upload')}}/{{$banner->image}}" width="100%" class="mt-4" id="show_img">
                                @error('uploads')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Cập nhật" style="width:50%">
                    <a href="{{route('banner.index')}}" class="btn btn-secondary form-control" style="width:49.5%">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {

        $("#select_image").click(function(){
            $("#image").click()
        });

        $("#image").change(function(){
            var file = $(this)[0].files[0];
            var reader = new FileReader();
                reader.onload = function(ev){
                    $("#show_img").attr("src",ev.target.result);
                }
            reader.readAsDataURL(file);
        });

        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#formData").serialize();
            var formData = new FormData($("#formData")[0]);
            let files = $('#image')[0].files[0];
            if(files){
                formData.append('file',files,files.name);
            }
            $.ajax({
                url: "{{route('banner.update',$banner->id)}}",
                data: formData,
                type: "POST",
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.status == false) {
                        Swal.fire({
                            title: res.title,
                            html: res.message,
                            icon: res.icon
                        });
                    }
                    if (res.status == true) {
                        window.location.href = "{{route('banner.index')}}"
                    }
                }
            });
        });

    })
</script>
@endsection