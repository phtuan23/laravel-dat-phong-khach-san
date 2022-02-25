@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý phòng</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Trang chính</a></li>
                    <li class="breadcrumb-item active">Danh sách phòng</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{route('room.create')}}" class="btn btn-sm btn-success">Thêm mới phòng</a>
                        </h3>
                        <div class="card-tools">
                            <form class="form-inline">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Tìm kiếm" autocomplete="off">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" id="data">
                        <table class="table table-hover text-center ">
                            <thead>
                                <tr>
                                    <th>Ảnh phòng</th>
                                    <th>Tên phòng</th>
                                    <th>Giá phòng</th>
                                    <th>Khách sạn</th>
                                    <th>Danh mục phòng</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                <tr>
                                    <td>
                                        <img src="{{url('public/upload')}}/{{$room->image}}" width="60">
                                    </td>
                                    <td>{{$room->name}}</td>
                                    <td>{{number_format($room->price)}} vnđ</td>
                                    <td>{{$room->hotel->name}} <br>{{$room->hotel->city->name}} </td>
                                    <td>{{$room->category->name}}</td>
                                    @if($room->status==0)
                                        <td><span class="badge badge-secondary">Đã đặt</span></td>
                                    @else
                                        <td><span class="badge badge-success">Còn trống</span></td>
                                    @endif
                                    <td class="text-right">
                                        <a href="{{route('room.edit',$room->id)}}" class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                        <a href="{{route('room.destroy',$room->id)}}" class="btn btn-sm btn-danger btn-delete">Xóa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-2 ml-4">
                            {{$rooms->appends(request()->all())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    @endsection

    @section('js')
    <script>
        $(document).ready(function() {
            deleteData();
            search();
            paginate();

            function deleteData() {
                $(document).on('click', '.btn-delete', function(e) {
                    e.preventDefault();
                    var href = $(this).attr('href');
                    Swal.fire({
                        title: 'Bạn có chắc muốn xóa?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'rgb(221, 51, 51)',
                        cancelButtonColor: 'gray',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: href,
                                method: 'DELETE',
                                data : {
                                    _token : "{{csrf_token()}}"  
                                },
                                success: function(res) {
                                    if(res.status==true){
                                        $("#data").load(location.href + " #data>*");
                                        Swal.fire({
                                            title : res.title,
                                            icon : res.icon,
                                            text : res.message
                                        });
                                    }if(res.status==false){
                                        Swal.fire({
                                            title : res.title,
                                            icon : res.icon,
                                            text : res.message
                                        });
                                    }
                                }
                            });
                        }
                    })
                });
            }

            function search() {
                $('input[name="search"]').keyup(function() {
                    var search = $('input[name="search"]').val();
                    $.ajax({
                        url: "{{route('room.index')}}" + "?search=" + search,
                        type: "GET",
                        success: function(res) {
                            $("#data").load("{{route('room.index')}}" + "?search=" + search + " #data>*");
                        }
                    });
                });
            }
            function paginate(){
                $(document).on('click','.pagination a',function(e){
                    e.preventDefault();
                    var href = $(this).attr('href');
                    $.ajax({
                        url : href,
                        type: "GET",
                        success: function(res) {
                            $("#data").load(href + " #data>*");
                        }
                    });
                });
            }
        })
    </script>
    @endsection