<div>
    <div class="row mt-3">
        <div class="col-md-6">
            <button class="btn btn-back" style="color:#dfa974"><i class="fa fa-arrow-left float-right"></i> </button>
        </div>
        <div class="col-md-6">
            <h4 style="color:#dfa974" class="float-right">Chi tiết đơn đặt</h4>
        </div>
    </div>
    <hr>
    <div class="row p-2">
        <div class="col-md-8">
            <h5 class="font-weight-bold">Thông tin khách hàng</h5>
            <h6 class="mt-1">{{auth()->guard('cus')->user()->name}}</h6>
            <h6 class="mt-1">{{auth()->guard('cus')->user()->phone}}</h6>
            <h6 class="mt-1">{{auth()->guard('cus')->user()->email}}</h6>
            <h6 class="mt-1">{{auth()->guard('cus')->user()->address}}</h6>
        </div>
        <div class="col-md-4 text-right">
            <h5 class="font-weight-bold">Thông tin đơn đặt</h5>
            <h6 class="mt-1">Mã đơn : {{$booking->id}}</h6>
            <h6 class="mt-1">Ngày đặt : {{$booking->created_at->format('d-m-Y')}}</h6>
        </div>
    </div>
    <hr>
    <div class="row mt-2 ml-2">
        <h5 class="font-weight-bold mb-3">Chi tiết đơn đặt</h5><br>
        @foreach($booking_details as $item)
        <div class="row">
            <div class="col-md-4">
                <img src="{{url('public/upload')}}/{{$item->room->image}}" width="100%">
            </div>
            <div class="col-md-8">
                <h6>Số phòng : {{$item->room->name}}</h6>
                <h6 class="mt-1">Loại phòng : {{$item->room->category->name}}</h6>
                @if(count($item->services) > 0)
                <h6 class="mt-1">Dịch vụ chọn thêm
                    <ul>
                        @foreach($item->services as $srv)
                        <li>{{$srv->name}}</li>
                        @endforeach
                    </ul>
                </h6>
                @endif
                <h6 class="mt-1">Ngày đến : {{$item->start_date}}</h6>
                <h6 class="mt-1">Ngày rời : {{$item->end_date}}</h6>
                <h6 class="mt-1">Tổng tiền : {{number_format($item->total_price)}}/{{$item->total_day}} ngày</h6>
            </div>
        </div>
        @endforeach
    </div>
    <hr>
    <button class="btn btn-back btn-secondary ml-2 mb-3">Quay lại</button>
</div>