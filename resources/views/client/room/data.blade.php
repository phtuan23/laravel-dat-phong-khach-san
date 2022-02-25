<div class="row">
    <div class="col-md-6">
        <p class="total_room">Tìm thấy {{$rooms->total()}} phòng theo yêu cầu</p>
    </div>
</div>
<hr>
<div class="row">
    @foreach($rooms as $room)
    <div class="col-md-4">
        <div class="room-item">
            <img src="{{url('public/upload')}}/{{$room->image}}" style="height:200px">
            <div class="ri-text">
                <h4>{{$room->category->name}}</h4>
                
                <h3>{{number_format($room->price)}}<span>/ngày</span></h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="r-o">Số phòng:</td>
                            <td>{{$room->name}}</td>
                        </tr>
                        <tr>
                            <td class="r-o">Diện tích:</td>
                            <td>{{$room->category->size}} m2</td>
                        </tr>
                        <tr>
                            <td class="r-o">Tối đa:</td>
                            <td>{{$room->category->max_people}} người lớn</td>
                        </tr>
                        <tr>
                            <td class="r-o">Dịch vụ:</td>
                            <td>{!!$room->category->description!!}</td>
                        </tr>
                        <tr>
                            <td><span class="float-left" id="rateRoom-{{$room->id}}"></span></td>
                        </tr>
                    </tbody>
                </table>
                @if(request()->date_in and request()->date_out)
                <a href="{{route('client.room.detail',$room->id)}}?date_in={{date('Y-m-d',strtotime(request()->date_in))}}&date_out={{date('Y-m-d',strtotime(request()->date_out))}}" class="primary-btn">Chi tiết</a>
                <a href="{{route('booking.add',$room->id)}}?date_in={{date('Y-m-d',strtotime(request()->date_in))}}&date_out={{date('Y-m-d',strtotime(request()->date_out))}}" class="primary-btn float-right">Đặt phòng</a>
                @else
                <a href="{{route('client.room.detail',$room->id)}}" class="primary-btn">Chi tiết</a>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#rateRoom-"+"{{$room->id}}").rateYo({
                rating: "{{$room->rate()->avg('rating')}}",
                readOnly: true,
                starWidth: "20px"
            });
        })
    </script>
    @endforeach
</div>
<div class="col-md-12">
    <div class="text-center m-auto">
        {{$rooms->appends(request()->all())->links()}}
    </div>
</div>

