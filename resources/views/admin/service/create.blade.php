@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm mới Dịch vụ</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Quản lý dịch vụ</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('service.store')}}" enctype="multipart/form-data" id="formData">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin dịch vụ</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-10 m-auto">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image">Ảnh <span class="text-danger">*</span> </label>
                                        <input type="file" name="image" hidden id="image">
                                        <img src="https://image.freepik.com/free-vector/hotel-services-set-icons_24877-52755.jpg" width="88%" style="cursor: pointer;" id="select_image">
                                        @error('image')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên dịch vụ <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Nhập tên dịch vụ">
                                        @error('name')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá dịch vụ <span class="text-danger">*</span> </label>
                                        <input type="text" name="price" class="form-control" autocomplete="off" placeholder="Nhập giá dịch vụ">
                                        @error('price')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Thêm mới" style="width:50%">
                                    <a href="{{route('service.index')}}" class="btn btn-secondary form-control" style="width:49%">Quay lại</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $('#summernote').summernote({
                height : 120,
            });
        });

        $("#select_image").click(function(){
            $("#image").click()
        });

        $("#image").change(function(){
            var file = $(this)[0].files[0];
            console.log(file);
            var reader = new FileReader();
            reader.onload = function(ev){
                $("#select_image").attr("src",ev.target.result);
            }
            reader.readAsDataURL(file);
        });

        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = new FormData($("#formData")[0]);
            $.ajax({
                url: "{{route('service.store')}}",
                data: data,
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
                        window.location.href = "{{route('service.index')}}"
                    }
                }
            });
        });
    })
</script>
@endsection