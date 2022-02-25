@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm mới banner</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Quản lý banner</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('banner.store')}}" enctype="multipart/form-data" id="formData">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin banner</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh banner <span class="text-danger">*</span> </label>
                                <input type="file" name="uploads[]" multiple hidden id="image">
                                <input type="button" class="form-control" style="width:30%" value="Chọn banner" id="select_image">
                                @error('uploads')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div id="show_image">

                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Thêm mới" style="width:50%">
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
        $(document).ready(function() {
            $('#summernote').summernote({
                height : 120,
            });
        });

        $("#select_image").click(function(){
            $("#image").click()
        });

        $("#image").change(function(){
            var html = $("#show_image")[0];
            var files = $(this)[0].files;
            for(var i = 0; i < files.length; i++){
                var reader = new FileReader();
                reader.onload = function(ev){
                    $($.parseHTML('<img>')).attr({
                        src : ev.target.result,
                        width: "50%",
                        style : "padding:5px 5px 5px 0"
                        }).appendTo(html);
                }
                reader.readAsDataURL(files[i]);
            }
        });

        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#formData").serialize();
            var formData = new FormData($("#formData")[0]);
            let files = $('#image')[0].files;
            for(i=0; i<files.length; i++){
                formData.append('file',files[i],files.name)
            }
            $.ajax({
                url: "{{route('banner.store')}}",
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