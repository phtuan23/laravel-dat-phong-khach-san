@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý đơn đặt phòng</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Trang chính</a></li>
                    <li class="breadcrumb-item active">Danh sách đơn đặt phòng</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="data">
                    <div class="card-header">
                        <div class="card-title">
                            <a href="{{route('booking.index')}}" class="btn btn-sm btn-primary btn-status">Tất cả</a>
                            <a href="{{route('booking.index')}}?status=1" class="btn btn-sm btn-success btn-status">Đã đặt phòng</a>
                            <a href="{{route('booking.index')}}?status=2" class="btn btn-sm btn-secondary btn-status">Đã trả phòng</a>
                            <a href="{{route('booking.index')}}?status=3" class="btn btn-sm btn-warning btn-status">Đã hủy</a>
                        </div>
                        <div class="card-tools">
                            <form action="" id="form-search">
                                <div class="input-group input-group" style="width: 250px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Tìm kiếm" autocomplete="off" id="name">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if($bookings->count() == 0)
                    <h5 class="text-center mt-3 mb-3">Không có dữ liệu</h5>
                    @else
                    <div class="card-body table-responsive p-0" id="data">
                        <table class="table table-hover text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach($bookings as $booking)
                                <tr>
                                    <td width="40">{{$booking->id}}</td>
                                    <td >{{$booking->customer_name}}</td>
                                    <td >{{$booking->customer_phone}}</td>
                                    <td >{{$booking->customer_email}}</td>
                                    <td>
                                    @if($booking->status==1)
                                    <span class="badge badge-success">Đã đặt phòng</span>
                                    @elseif($booking->status==2)
                                    <span class="badge badge-secondary">Đã trả phòng</span>
                                    @elseif($booking->status==3)
                                    <span class="badge badge-warning">Đã hủy</span>
                                    @endif
                                    </td>
                                    <td>
                                        <a href="{{route('booking.show',$booking->id)}}" class="btn btn-sm btn-success">Chi tiết</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-2 ml-4">
                            {{$bookings->appends(request()->all())->links()}}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection

    @section('js')
        <script>
            $(document).ready(function(){
                $(document).on('click','.btn-status',function(e){
                    e.preventDefault();
                    var href = $(this).attr('href');
                    $.ajax({
                        url : href,
                        type : 'GET',
                        success : function(res){
                            $("#data").load(href + " #data>*");
                        }
                    });
                });

                $(document).on('click','.pagination a',function(e){
                    e.preventDefault();
                    var href = $(this).attr('href');
                    $.ajax({
                        url : href,
                        type : 'GET',
                        success : function(res){
                            $("#data").load(href + " #data>*");
                        }
                    });
                });

                $(document).on('submit','#form-search',function(e){
                    e.preventDefault();
                    var search = $("#name").val();
                    $.ajax({
                        url : window.location.href + "?search=" + search, 
                        type : 'GET',
                        success : function(res){
                            $("#data").load(window.location.href + "?search=" + search + " #data>*");
                        }
                    });
                })
            })
        </script>
    @endsection
    