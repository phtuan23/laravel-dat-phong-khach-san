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
        <form method="post" action="{{route('room.update',$room->id)}}" enctype="multipart/form-data" id="formData">
            @csrf @method('PUT')
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
                                        <label for="exampleInputEmail1">Tên phòng</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên phòng" autocomplete="off" {{old('name')}} value="{{$room->name}}">
                                        @error('name')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ảnh mô tả</label>
                                        <input type="file" name="image_description[]" id="image_description" hidden multiple>
                                        <input type="button" class="form-control" value="Chọn ảnh mô tả" id="select_description">
                                        <div id="img_des" class="mt-3">
                                            @foreach($room->images as $item)
                                                <img src="{{url('public/upload')}}/{{$item->image}}" width="33%">
                                            @endforeach
                                        </div>
                                        <div id="img_des2"></div>
                                        @error('image_description')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả</label>
                                        <textarea name="description" id="summernote" cols="30" rows="10">{!!$room->description!!}</textarea>
                                        @error('description')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá phòng</label>
                                        <input type="text" name="price" class="form-control" placeholder="Nhập giá phòng" autocomplete="off" {{old('price')}} value="{{$room->price}}">
                                        @error('price')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ảnh phòng</label>
                                        <input type="file" name="image" id="image" hidden>
                                        <input type="button" class="form-control" value="Chọn ảnh" id="main_image">
                                        <div id="img">
                                            <img src="{{url('public/upload')}}/{{$room->image}}" width="100%" id="show_img" class="p-2">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Danh mục</label>
                                          <select class="form-control" name="category_id">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{old('category_id')==$category->id?'seletecd' :''}} {{$room->category_id==$category->id?'selected':''}}>{{$category->name}}</option>
                                            @endforeach
                                          </select>
                                          @error('category_id')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Khách sạn</label>
                                          <select class="form-control" name="hotel_id">
                                            <option value="">Chọn khách sạn</option>
                                            @foreach($hotels as $hotel)
                                                <option value="{{$hotel->id}}" {{old('hotel_id')==$hotel->id?'selected':''}} {{$room->hotel_id==$hotel->id?'selected':''}}>{{$hotel->name}} ({{$hotel->address}})</option>
                                            @endforeach
                                          </select>
                                          @error('hotel_id')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Trạng thái </label>
                                        <select class="form-control" name="status">
                                            <option>Chọn trạng thái</option>
                                            <option value="1" {{$room->status==1?'selected':''}}>Trống</option>
                                            <option value="0" {{$room->status==0?'selected':''}}>Đã đặt</option>
                                          </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Cập nhật" style="width:50%">
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
            height : 180,
        });

        $("#select_description").click(function() {
            $("#image_description").click();
        })

        $("#main_image").click(function(){
            $("#image").click();
        });

        $("#image_description").change(function(){
            var files = $(this)[0].files;
            var html = $("#img_des2")[0];
            for (var i = 0 ; i < files.length ; i++){
                var reader = new FileReader();
                reader.onload = function(ev){
                    $($.parseHTML('<img>')).attr({
                        src : ev.target.result,
                        width: "20%",
                        style : "padding:5px 5px 5px 0"
                    }).appendTo(html);
                }
                reader.readAsDataURL(files[i]);
            }
            $("#img_des").hide();
        });

        $("#image").change(function(){
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function(ev){
                $("#show_img").attr('src',ev.target.result);
            }
            reader.readAsDataURL(file);
        });

        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#formData").serialize();
            var formData = new FormData($("#formData")[0]);
            var image_description = $("#image_description")[0].files;
            var image = $("#image")[0].files[0];
            if(image){
                formData.append('file',image);
            }
            if(image_description){
                for(i=0;i<image_description.length;i++){
                    formData.append('file',image_description[i]);
                }
            }
            $.ajax({
                url: "{{route('room.update',$room->id)}}",
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