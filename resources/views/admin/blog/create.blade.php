@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm mới blog</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Quản lý blog</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('blog.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin blog</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nội dung <span class="text-danger">*</span></label>
                                        <textarea name="content" id="summernote" cols="30" rows="10">{{old('content')}}</textarea>
                                        @error('content')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên tiêu đề <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tiêu đề" autocomplete="off" {{old('name')}}>
                                        @error('name')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ảnh tiêu đề <span class="text-danger">*</span></label>
                                        <input type="file" name="image" id="image" hidden>
                                        <input type="button" class="form-control" value="Chọn ảnh" id="main_image">
                                        <div >
                                            <img src="" width="100%" id="img" class="mt-3">
                                        </div>
                                        @error('image')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Thêm mới" style="width:50%">
                    <a href="{{route('blog.index')}}" class="btn btn-secondary form-control" style="width:49.5%">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height : 370.438,
        });

        $("#main_image").click(function(){
            $("#image").click();
        });


        $("#image").change(function(){
            var file = $(this)[0].files[0];
            var html = $("#img")[0];
            var reader = new FileReader();
            reader.onload = function(ev){
                $("#img").attr("src",ev.target.result);
            }
            reader.readAsDataURL(file);
        });
    })
</script>
@endsection