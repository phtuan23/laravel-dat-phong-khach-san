@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý tài khoản</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Trang chính</a></li>
                    <li class="breadcrumb-item active">Danh sách tài khoản</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{route('customer.create')}}" class="btn btn-sm btn-success">Thêm mới khách hàng</a>
                        </h3>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 300px;">
                                <form class="form-inline" id="form-search">
                                    <div class="form-group">
                                        <input type="text" name="search" id="name" class="form-control float-right" placeholder="Tìm kiếm" autocomplete="off">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" id="data">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Tổng đơn đặt</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $cus)
                                <tr>
                                    <td>{{$cus->id}}</td>
                                    <td>{{$cus->name}}</td>
                                    <td>{{$cus->email}}</td>
                                    <td>{{$cus->phone}}</td>
                                    <td>{{$cus->address}}</td>
                                    <td>{{$cus->total_booking($cus->email)}}</td>
                                    <td class="text-right">
                                        <a href="{{route('customer.edit',$cus->id)}}" class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                        <a href="{{route('customer.destroy',$cus->id)}}" class="btn btn-sm btn-danger btn-delete">Xóa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-2 ml-4">
                            {{$customers->appends(request()->all())->links()}}
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
                                    }
                                }
                            });
                        }
                    })
                });
            }

            function search() {
                $(document).on('submit','#form-search',function(e){
                    e.preventDefault();
                    var search = $('input[name="search"]').val();
                    $.ajax({
                        url: "{{route('customer.index')}}" + "?search=" + search,
                        type: "GET",
                        success: function(res) {
                            $("#data").load("{{route('customer.index')}}" + "?search=" + search + " #data>*");
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
                    })
                });
            }
        })
    </script>
    @endsection