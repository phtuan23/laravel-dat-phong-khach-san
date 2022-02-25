@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm mới khách sạn</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                    <li class="breadcrumb-item active">Quản lý khách sạn</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content pb-5">
    <div class="container-fluid">
        <form method="post" action="{{route('hotel.store')}}" enctype="multipart/form-data" id="formData">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin khách sạn</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên khách sạn <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên khách sạn" autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ khách sạn <span class="text-danger">*</span></label>
                                        <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ khác sạn" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Thành phố <span class="text-danger">*</span></label>
                                        <div class="form-group">
                                          <select class="form-control" name="city_id">
                                            <option value="">Chọn thành phố</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-dark form-control btn-submit" value="Thêm mới" style="width:50%">
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
        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var data = $("#formData").serialize();
            $.ajax({
                url: "{{route('hotel.store')}}",
                data: data,
                type: "POST",
                success: function(res) {
                    if (res.status == false) {
                        Swal.fire({
                            title: res.title,
                            html: res.message,
                            icon: res.icon
                        });
                    }else{
                        window.location.href = "{{route('hotel.index')}}"
                    }
                }
            });
        });
    })
</script>
@endsection