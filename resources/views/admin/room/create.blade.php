@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm mới phòng</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Quản lý phòng</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('room.store')}}" enctype="multipart/form-data" id="formData">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin của phòng</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên phòng <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên phòng" autocomplete="off">
                                        @error('name')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ảnh mô tả <span class="text-danger">*</span></label>
                                        <input type="file" name="image_description[]" id="image_description" hidden multiple>
                                        <input type="button" class="form-control" value="Chọn ảnh mô tả" id="select_description">
                                        <div id="img_des"></div>
                                        @error('image_description')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả <span class="text-danger">*</span></label>
                                        <textarea name="description" id="summernote" cols="30" rows="10"></textarea>
                                        @error('description')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá phòng <span class="text-danger">*</span></label>
                                        <input type="text" name="price" class="form-control" placeholder="Nhập giá phòng" autocomplete="off">
                                        @error('price')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ảnh phòng <span class="text-danger">*</span></label>
                                        <input type="file" name="image" id="image" hidden>
                                        <input type="button" class="form-control" value="Chọn ảnh mô tả" id="main_image">
                                        <div id="img"></div>
                                        @error('image')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Danh mục <span class="text-danger">*</span></label>
                                          <select class="form-control" name="category_id">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                          </select>
                                          @error('category_id')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Khách sạn <span class="text-danger">*</span></label>
                                          <select class="form-control" name="hotel_id">
                                            <option value="">Chọn khách sạn</option>
                                            @foreach($hotels as $hotel)
                                                <option value="{{$hotel->id}}">{{$hotel->name}} ({{$hotel->address}})</option>
                                            @endforeach
                                          </select>
                                          @error('hotel_id')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Trạng thái </label>
                                        <select class="form-control" name="status">
                                            <option value="">Chọn trạng thái</option>
                                            <option value="1">Trống</option>
                                            <option value="2">Đã đặt</option>
                                          </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Thêm mới" style="width:50%">
                    <a href="{{route('room.index')}}" class="btn btn-secondary form-control" style="width:49.5%">Quay lại</a>
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

        $("#select_description").click(function() {
            $("#image_description").click();
        })

        $("#main_image").click(function(){
            $("#image").click();
        });

        $("#image_description").change(function(){
            var files = $(this)[0].files;
            var html = $("#img_des")[0];
            for (var i = 0 ; i < files.length ; i++){
                var reader = new FileReader();
                reader.onload = function(ev){
                    $($.parseHTML('<img>')).attr({
                        src : ev.target.result,
                        width: "33%",
                        style : "padding:5px 5px 5px 0"
                    }).appendTo(html);
                }
                reader.readAsDataURL(files[i]);
            }
        });

       

        $("#image").change(function(){
            var file = $(this)[0].files[0];
            var html = $("#img")[0];
            var reader = new FileReader();
            reader.onload = function(ev){
                $($.parseHTML('<img>')).attr({
                    src : ev.target.result,
                    width: "100%",
                    style : "padding:5px 5px 5px 0"
                }).appendTo(html);
            }
            reader.readAsDataURL(file);
        });

        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#formData").serialize();
            var formData = new FormData($("#formData")[0]);
            var image_description = $("#image_description")[0].files;
            var image = $("#image")[0].files[0];
            formData.append('file',image);
            for(i=0;i<image_description.length;i++){
                formData.append('file',image_description[i]);
            }
            $.ajax({
                url: "{{route('room.store')}}",
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
                        window.location.href = "{{route('room.index')}}"
                    }
                }
            });
        });
    })
</script>
@endsection