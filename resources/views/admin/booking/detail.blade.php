@extends('layout.admin')
@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Chi tiết đơn đặt phòng</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Trang chính</a></li>
                    <li class="breadcrumb-item active">Chi tiết đơn đặt phòng</li>
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
                    <div class="card-body p-0">
                        <div class="row pl-4 pt-3">
                            <a href="{{route('booking.index')}}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Quay lại</a>
                        </div>
                        <div class="row p-4">
                            <div class="col-md-6">
                                <h5>Thông tin khách hàng</h5>
                                <hr>
                                @if($booking->customer_id != null)
                                    <table>
                                        <tr>
                                            <th>Tên khách hàng</th>
                                            <td class="pl-4">{{$booking->customer->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Số điện thoại</th>
                                            <td class="pl-4">{{$booking->customer->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td class="pl-4">{{$booking->customer->email}}</td>
                                        </tr>
                                        <tr>
                                            <th>Địa chỉ</th>
                                            <td class="pl-4">{{$booking->customer->address}}</td>
                                        </tr>
                                    </table>
                                @else
                                    <table>
                                        <tr>
                                            <th>Tên khách hàng</th>
                                            <td class="pl-4">{{$booking->customer_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Số điện thoại</th>
                                            <td class="pl-4">{{$booking->customer_phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td class="pl-4">{{$booking->customer_email}}</td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5>Thông tin đơn đặt phòng</h5>
                                <hr>
                                <table>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <td class="pl-4">{{$booking->id}}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td class="pl-4">{{$booking->created_at->format('d-m-Y')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td id="show_status" class="pl-4">
                                            @if($booking->status==1)
                                            <span class="badge badge-success">Đã đặt phòng</span>
                                            @elseif($booking->status==2)
                                            <span class="badge badge-secondary">Đã trả phòng</span>
                                            @elseif($booking->status==3)
                                            <span class="badge badge-warning">Đã hủy</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($booking->status==1)
                                    <tr id="update_status">
                                        <form action="">
                                            <th class="pt-3">
                                                <div class="form-group">
                                                    <select class="form-control p-0" name="status" style="height:32px" id="status">
                                                    <option value="3" {{$booking->status==3?'selected':''}}>Đã hủy</option>
                                                    <option value="1" {{$booking->status==1?'selected':''}}>Đã đặt phòng</option>
                                                    <option value="2" {{$booking->status==2?'selected':''}}>Đã trả phòng</option>
                                                    </select>
                                                </div>
                                            </th>
                                            <td class="pl-4">
                                                <button class="btn btn-sm btn-success btn-update-status">Cập nhật</button>
                                            </td>
                                        </form>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <hr class="m-auto w-50">
                        <div class="row p-4">
                            <div class="col-md-12 m-auto detail-booking p-5" style="border: 1px solid rgb(221, 216, 216);box-shadow: 5px 5px #d3cece;">
                                <h4 class="text-center">Chi tiết</h4>
                                <br>
                                @foreach($booking->booking_detail as $item)
                                <div class="row mb-4">
                                    <div class="col-md-5">
                                        <img src="{{url('public/upload')}}/{{$item->room->image}}" width="100%">
                                    </div>
                                    <div class="col-md-7 pl-5" id="info_booking">
                                        <table>
                                            <tr>
                                                <th>Số phòng</th>
                                                <td class="pl-4">{{$item->room->name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Loại phòng</th>
                                                <td class="pl-4">{{$item->room->category->name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Giá phòng</th>
                                                <td class="pl-4">{{number_format($item->room->price)}} vnđ</td>
                                            </tr>
                                            <tr>
                                                <th>Tổng tiền phòng</th>
                                                <td class="pl-4">{{number_format($item->total_price)}} vnđ</td>
                                            </tr>
                                            @if($item->services->count() > 0)
                                            <?php $total_service = 0;?>
                                            <tr>
                                                <th>Dịch vụ đã chọn</th>
                                                <td>
                                                    <ul class="mt-2">
                                                    @foreach($item->services as $current_service)
                                                        <li>{{$current_service->service->name}}</li>
                                                    <?php $total_service += $current_service->service->price*$item->total_day;?>
                                                    @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tổng tiền dịch vụ</th>
                                                <td class="pl-4">{{number_format($total_service)}} VNĐ</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                                <hr class="w-50">
                                @endforeach
                            </div>
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
        $(document).ready(function(){
            $(".btn-update-status").click(function(e){
                e.preventDefault();
                var status = $("#status").val();
                $.ajax({
                    url : "{{route('admin.booking.status',$booking->id)}}" + "?status=" + status,
                    type : "GET",
                    success : function(res){
                        if(res.status == true){
                            $("#show_status").load(location.href + " #show_status>*");
                            $("#info_booking").load(location.href + " #info_booking>*");
                            $("#update_status").load(location.href + " #update_status>*");
                        }
                    }
                })
            });
        });
    </script>
@endsection