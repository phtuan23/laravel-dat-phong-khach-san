@if(count($_booking->bookings)>0)
    <div class="row">
        <div class="col-md-9" id="table-booking">
            <table class="table" style="border:1px solid #dee2e6;">
                <tr style="background-color:#dfa974" class="text-center">
                    <th>Phòng</th>
                    <th>Thời gian</th>
                    <th>Dịch vụ</th>
                    <th>
                        <a href="{{route('booking.clear')}}" class="btn btn-sm btn-clear"><i class="fa fa-remove"></i></a>
                    </th>
                </tr>
                @foreach($_booking->bookings as $bk)
                <tbody class="table-bordered">
                    <tr>
                        <td width="300px">
                            <img src="{{url('public/upload')}}/{{$bk['image']}}" width="100%" class="mb-2">
                            <p>Loại phòng : {{$bk['category']}}</p>
                            <p>Số phòng : {{$bk['name']}}</p>
                            <p>Số người : {{$bk['max_people']}} người lớn</p>
                            <p>Diện tích : {{$bk['size']}} m2</p>
                            <p>Mô tả : {!!$bk['description']!!}</p>
                        </td>
                        <td width="200px">
                            Ngày đến : {{date('d-m-Y',strtotime($bk['date_in']))}} <br><br>
                            Ngày rời : {{date('d-m-Y',strtotime($bk['date_out']))}} <br><br>
                            Tổng số ngày : {{$bk['total_day']}} ngày <br>
                        </td>
                        <td>
                            <?php $id_service = []; ?>
                            <h5 class="font-weight-bold mb-1">Dịch vụ đã chọn</h5>
                            <ul class="list-group list-group-flush">
                                @foreach($bk['service'] as $serv)
                                <li class="list-group-item"><i class="fa fa-check-circle mr-2" style="color: #dfa974"></i>{{$serv['name']}} <span><a href="{{route('delete.service',['id_bk' => $bk['id'],'id_service' => $serv['id']])}}" class="text-dark float-right delete_service">x</a></span></li>
                                <?php $id_service[] = $serv['id'] ?>
                                @endforeach
                                <hr>
                            </ul>
                            <form action="{{route('booking.update')}}" class="form_service" id="form-{{$bk['id']}}" method="post">
                            <h5 class="font-weight-bold mb-2">Chọn thêm dịch vụ</h5>
                                @csrf
                                @foreach($services as $srv)
                                    @if(!in_array($srv->id,$id_service))
                                    <div class="form-check">
                                        <label class="form-check-label" style="cursor: pointer">
                                        <input type="hidden" name="id" value="{{$bk['id']}}">
                                        <input type="checkbox" class="form-check-input services" name="service[]" id="{{$bk['id']}}" value="{{$srv->id}}" >{{$srv->name}} (+{{number_format($srv->price)}})</label>
                                    </div>
                                    @endif
                                @endforeach
                            </form>
                            <button class="btn w-100 btn-service mt-3" id="{{$bk['id']}}" style="background-color:#dfa974">Chọn dịch vụ</button>
                        </td>
                        <td class="text-center" width="80px">
                            <a href="{{route('booking.delete',$bk['id'])}}" class="btn btn-dark mb-2 btn-delete">x</a><br>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>  
        </div>
        <div class="col-md-3" id="amount">
            <div style="border:1px solid #dee2e6">
                <div style="background-color:#dfa974" class="p-3 text-center">
                    <h5>Tổng tiền</h5>
                </div>
                <div class="p-2">
                    <h5 style="color:#dfa974">Giá phòng</h5>
                    <ul>
                        @foreach($_booking->bookings as $item)
                            <li style="list-style:none" class="ml-4 mt-2">{{$item['name']}} : {{number_format($item['price'])}} vnđ</li>
                        @endforeach
                    </ul>
                </div>
                <div class="p-2">
                    <h5 style="color:#dfa974">Số Ngày</h5>
                    <ul>
                        <?php $total_service = 0 ?>
                        @foreach($_booking->bookings as $item)
                        <?php foreach($item['service'] as $srv) {$total_service+= $srv['total_price'];}?>
                            <li style="list-style:none" class="ml-4 mt-2">{{$item['name']}} : {{number_format($item['total_day'])}} ngày</li>
                        @endforeach
                    </ul>
                </div>
                @if($total_service > 0)
                <div class="p-2">
                    <h5 style="color:#dfa974">Dịch vụ phòng</h5>
                    <ul>
                        @foreach($_booking->bookings as $item)
                        <?php $total_price = 0 ;
                            foreach($item['service'] as $srv){
                                $total_price+= $srv['total_price'];
                            }
                        ?>
                            @if($total_price > 0)
                            <li style="list-style:none" class="ml-4 mt-2">{{$item['name']}} : {{number_format($total_price)}}/{{$item['total_day']}} ngày</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="p-2">
                    <h5 style="color:#dfa974">Thành tiền</h5>
                    <ul>
                        @foreach($_booking->bookings as $item)
                            <li style="list-style:none" class="ml-4 mt-2">{{$item['name']}} : {{number_format($item['price']*$item['total_day'])}} vnđ</li>
                        @endforeach
                    </ul>
                </div>
                <div class="p-2">
                    <h5 style="color:#dfa974" class="font-weight-bold">Tổng tiền : {{number_format($_booking->total_price)}} vnđ</h5>
                </div>
            </div>
            <br>
            <a href="{{route('client.checkout')}}" class="w-100 btn" style="background-color:#dfa974">Thanh toán</a>
        </div>
    </div>
    @else
    <div class="text-center p-4">
        <h3 style="color:#dfa974" class="mb-3">Đơn đặt phòng đang trống</h3>
        <a href="{{route('client.index')}}" style="color:#dfa974"><i class="fa fa-home"></i> Quay lại trang chủ</a>
    </div>
    @endif