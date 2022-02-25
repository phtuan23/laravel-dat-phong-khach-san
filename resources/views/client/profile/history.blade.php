@if($bookings->count() == 0)
<div class="text-center">
    <h5 style="color:#dfa974" class="mt-5">Lịch sử đơn đặt của bạn đang trống</h5>
</div>
@else
<div>
    <h4 style="color:#dfa974" class="mt-3">Lịch sử đơn đặt</h4>
    <hr>
    <table class="table table-bordered text-center">
        <tr>
            <th>Mã đơn</th>
            <th>Ngày đặt</th>
            <th></th>
        </tr>
        @foreach($bookings as $booking)
        <tr>
            <td>{{$booking->id}}</td>
            <td>{{$booking->created_at->format('d-m-Y')}}</td>
            <td>
                <a href="{{route('client.profile.booking',$booking->id)}}" class="btn btn-danger btn-detail-booking">Chi tiết</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endif
<div class="text-center">
    <h5 style="color:#dfa974">--Hết--</h5>
</div>
<div>
    {{$bookings->links()}}
</div>