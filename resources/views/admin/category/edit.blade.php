@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chỉnh sửa danh mục</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Quản lý danh mục</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('category.update',$category->id)}}" enctype="multipart/form-data" id="formData">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin danh mục</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên danh mục <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên đăng nhập" autocomplete="off" value="{{$category->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Diện tích <span class="text-danger">*</span></label>
                                        <input type="text" name="size" class="form-control" placeholder="Nhập tên đăng nhập" autocomplete="off" value="{{$category->size}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số người tối đa <span class="text-danger">*</span></label>
                                        <input type="text" name="max_people" class="form-control" placeholder="Nhập tên đăng nhập" autocomplete="off" value="{{$category->max_people}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả <span class="text-danger">*</span></label>
                                        <textarea name="description" id="summernote">{{$category->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Cập nhật" style="width:50%">
                    <a href="{{route('category.index')}}" class="btn btn-secondary form-control" style="width:49.5%">Quay lại</a>
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
            height : 120,
        });
        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#formData").serialize();
            $.ajax({
                url: "{{route('category.update',$category->id)}}",
                data: data,
                type: "POST",
                method : "PUT",
                success: function(res) {
                    if (res.status == false) {
                        Swal.fire({
                            title: res.title,
                            html: res.message,
                            icon: res.icon
                        });
                    }
                    if (res.status == true) {
                        window.location.href = "{{route('category.index')}}";
                    }
                }
            });
        });
    })
</script>
@endsection