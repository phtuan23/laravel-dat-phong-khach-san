@extends('layout.client')
@section('content')
<style>
    #over_load{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader.gif") center no-repeat;
    }
    /* Turn off scrollbar when body element has the loading class */
    .container.loading{
        overflow: hidden;   
    }
    /* Make spinner image visible when body element has the loading class */
    .container.loading #overlay{
        display: block;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h4>Thông tin của bạn</h4>
            <div class="card  mt-3 mb-3" style="background-color: #dfa974; border-color:#dfa974">
                <div class="card-body">
                    <form action="{{route('client.checkout.booking')}}" method="post" id="form_checkout">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Họ và tên *</label>
                                    @if(auth()->guard('cus')->check())
                                    <input type="text" name="name" class="form-control" placeholder="Họ và tên khách hàng" autocomplete="off" value="{{auth()->guard('cus')->user()->name}}">
                                    @else
                                    <input type="text" name="name" class="form-control" placeholder="Họ và tên khách hàng" autocomplete="off">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Địa chỉ Email *</label>
                                    @if(auth()->guard('cus')->check())
                                    <input type="text" name="email" class="form-control" placeholder="Họ và tên khách hàng" autocomplete="off" value="{{auth()->guard('cus')->user()->email}}">
                                    @else
                                    <input type="text" name="email" class="form-control" placeholder="Email khách hàng" autocomplete="off">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Số điện thoại *</label>
                                    @if(auth()->guard('cus')->check())
                                    <input type="text" name="phone" class="form-control" placeholder="Họ và tên khách hàng" autocomplete="off" value="{{auth()->guard('cus')->user()->phone}}">
                                    @else
                                    <input type="text" name="phone" class="form-control" placeholder="Số điện thoại khách hàng" autocomplete="off">
                                    @endif
                                    
                                </div>
                                <div class="form-group">
                                    <label for="">Địa chỉ</label>
                                    @if(auth()->guard('cus')->check())
                                    <input type="text" name="address" class="form-control" placeholder="Họ và tên khách hàng" autocomplete="off" value="{{auth()->guard('cus')->user()->address}}">
                                    @else
                                    <input type="text" name="address" class="form-control" placeholder="Địa chỉ khách hàng" autocomplete="off">
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
            <div class="info_booking">
                <div class="card  mb-3">
                    <div class="card-body">
                        <h4 class="card-title">Chi tiết đặt phòng của bạn</h4>
                        @foreach($_booking->bookings as $bk)
                            <h5 style="color:#dfa974" class="font-weight-bold">{{$bk['name']}}</h5>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><b>Ngày đặt phòng</b></h6>
                                    <b>{{$bk['date_in']}}</b>
                                </div>
                                <div class="col-md-6">
                                    <h6><b>Ngày trả phòng</b></h6>
                                    <b>{{$bk['date_out']}}</b>
                                </div>
                            </div>
                            <p>Thời gian lưu trú: <b>{{$bk['total_day']}} ngày</b></p>
                            @if(count($bk['service']) >0)
                            <div>
                                <h6 class="font-weight-bold">Dịch vụ theo phòng</h6>
                                <ul class="ml-4 mt-2">
                                    @foreach($bk['service'] as $item)
                                        <li>{{$item['name']}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" style="padding-top:28px">
            <div id="total_amount">
                <div class="card  mt-3">
                    <div class="card-body check_sale">
                        @if($_booking->sale == 0)
                        <form action="" id="form_sale">
                            <h6><b>Bạn có mã giảm giá không ?</b></h6>
                            <div class="form-group">
                                <label for="">Nhập mã giảm giá của bạn</label>
                                <input type="text" class="form-control" name="code_sale" placeholder="Mã giảm giá">
                                <button class="btn mt-3 w-100" id="code_sale" style="background-color: #dfa974; border-color:#dfa974">Áp dụng</button>
                            </div>
                        </form>
                        @else
                        <div class="text-center"><span class="badge badge-success p-2">Mã giảm giá đã được áp dụng</span></div>
                        @endif
                    </div>
                </div>
                <div class="card " style="margin-top: 38px">
                    <div class="card-body">
                        <h4>Tổng giá tiền</h4>
                        <br>
                        <table>
                            <tr>
                                <th>Tiền phòng : </th>
                                <td>{{number_format($_booking->total_price)}}đ</td>
                            </tr>
                            <tr>
                                <?php $vat =  $_booking->total_price*(10/100)?>
                                <th>10% VAT :</th>
                                <td><?=number_format($vat);?>đ</td>
                            </tr>
                            <tr>
                                <th>Dịch vụ riêng :</th>
                                <td></td>
                            </tr>
                            @if($_booking->sale!=0)
                            <tr>
                                <th>Giảm giá :</th>
                                <td>{{$_booking->sale*100}} %</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Tổng tiền:</th>
                                <td><?=number_format($_booking->total_price+$vat-($_booking->total_price*$_booking->sale))?>đ</td>
                            </tr>
                            <tr>
                                <th>
                                    <p>(Tổng tiền phải thanh toán)</p>
                                </th>
                            </tr>
                        </table>
                    </div>            
                </div>
            </div>
            <br>
            <button class="btn btn-lg btn-primary mb-3 w-100 btn-checkout" style="background-color:#dfa974;border-color:#dfa974">Đặt phòng</button>
        </div>
    </div>
    <div id="over_load"></div>
</div>
@stop()

@section('js')
    <script>
        $(document).ready(function(){
            code_sale();
            $(".btn-checkout").click(function(e){
                e.preventDefault();
                var data = $("#form_checkout").serialize();
                $.ajax({
                    url : "{{route('client.checkout.booking')}}",
                    type : "POST",
                    data : data,
                    success : function(res){
                        if(res.code==400){
                            Swal.fire({
                                title: res.title,
                                html: res.message,
                                icon: res.icon
                            });
                        }
                        if(res.code==200){
                            window.location.href = "{{route('client.index')}}"
                        }
                    }
                });
            });

            function code_sale(){
                $(document).on('click',"#code_sale",function(e){
                    e.preventDefault();
                    var code_sale = $("input[name=code_sale]").val();
                    $.ajax({
                        url : "{{route('client.check.sale')}}" + "?code_sale=" + code_sale,
                        type : "GET",
                        success : function(res){
                            if(res.code==false){
                                Swal.fire({
                                    html: res.message,
                                    icon: res.icon
                                });
                            }
                            if(res.code==200){
                                $("#total_amount").load(location.href + " #total_amount>*");
                            }
                        }
                    });
                })
            }
        })
    </script>
@endsection