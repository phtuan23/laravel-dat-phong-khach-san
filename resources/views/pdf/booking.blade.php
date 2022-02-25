<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Booking</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        #pdf {
            width: 800px;
            overflow: hidden;
            clear: both;
            border: 1px solid rgb(221, 216, 216);
            padding: 10px;
            box-shadow: 5px 5px #d3cece;
            margin: 0 auto;
            margin-top: 40px
        }

        #title{
            padding:0 20px
        }
        #title .column {
            float: left;
            width: 50%;
        }

        #title .column h2 {
            font-size: 40px;
            padding:5px 0
        }

        /* Clear floats after the columns */
        #title:after {
            content: "";
            display: table;
            clear: both;
        }

        #title .info-order {
            width: 61%;
            float: right;
            padding: 10px 0;
            text-align:right;
        }

        #info {
            clear: both;
            overflow: hidden;
            margin-top: 10px;
            margin-bottom: 30px;
            padding:0 20px;
            line-height:5px
        }

        #info .column {
            float: left;
            width: 50%;
        }

        #info .customer {
            text-align: right;
        }

        #info .shop h5 {
            font-weight: bold;
            font-size: 14px;
            color: rgb(110, 99, 99);
        }

        #info .customer h5 {
            font-weight: bold;
            font-size: 14px;
            color: rgb(110, 99, 99);
        }

        #order-detail .text-order {
            text-align: center;
            font-weight: bold;
        }

        #order-detail .table-order {
            width: 90%;
            margin: 0 auto;
        }

        #order-detail tr {
            text-align: center;
        }

        #order-detail tr.tr-first th {
            padding: 12px 5px;
            background-color: #dfa974;
        }

        #order-detail tr td {
            padding: 10px 0;
        }

        #order-detail tr td {
            border-bottom: 1px dashed gray;
            color: rgb(110, 99, 99);
        }

        #order-detail tr.item:last-child td {
            border-bottom: 1px solid gray;
        }

        #order-detail {
            overflow: hidden;
            clear: both;
            position: relative; 
        }
        #order-detail .total-price{
            border: 1px solid yellow;
        }
        #order-detail .thank{
            text-align: center;
        }
        #total_money{
            float: right;
            padding-right:40px
        }
    </style>
</head>

<body>
    <div id="pdf">
        <div id="title">
            <div class="column">
                <h2 style="color:#dfa974">APTECH HOTEL</h2>
            </div>
            <div class="column">
                <div class="info-order">
                    <h5>Mã đơn đặt : {{$booking->id}}</h5>
                    <h5>Ngày đặt phòng : {{$booking->created_at->format('d-m-Y')}}</h5>
                </div>
            </div>
        </div>
        <div id="info">
            <div class="column">
                <div class="shop">
                    <h5>tuantuan230298@gmail.com</h5>
                    <h5>238 Hoang Quoc Viet</h5>
                    <h5>0989.89.89.89</h5>
                </div>
            </div>
            <div class="column" >
                <div class="customer">
                    <h5>{{$booking->customer_name}}</h5>
                    <h5>{{$booking->customer_phone}}</h5>
                    <h5>{{$booking->customer_email}}</h5>
                </div>
            </div>
        </div>
        <div id="order-detail">
            <p class="text-order">--Chi tiết hóa đơn--</p>
            <table class="table-order">
                <thead>
                    <tr class="tr-first">
                        <th>Phòng</th>
                        <th>Ngày đến</th>
                        <th>Ngày rời</th>
                        <th>Dịch vụ</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bk->bookings as $item)
                    <tr class="item" style="text-align:center">
                        <td style="text-align:center;width:100px">{{$item['name']}}</td>
                        <td style="text-align:center;width:100px">{{$item['date_in']}}</td>
                        <td style="text-align:center;width:100px">{{$item['date_out']}}</td>
                        <td style="text-align:center">
                        <?php $total_service = 0 ?>
                        @foreach($item['service'] as $srv)
                            <h5>{{$srv['name']}}</h5>
                            <?php $total_service+=$srv['total_price'];?>
                        @endforeach
                        </td>
                        <td style="text-align:center;width:100px"><?=number_format($total_service+($item['total_day']*$item['price']));?> đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="total_money" style="text-align:right;">
                <h5>Tổng tiền : {{number_format($bk->total_price)}} đ</h5>
                <h5>Vat : {{number_format($bk->total_price*0.1)}} đ</h5>
                @if($sale!=null)
                <h5>Giảm giá: {{number_format($sale*$bk->total_price)}} đ</h5>
                <h4>Thành tiền : {{number_format($bk->total_price*0.1 + $bk->total_price - $sale*$bk->total_price)}} đ</h4>
                @else
                <h4>Thành tiền : {{number_format($bk->total_price*0.1 + $bk->total_price)}} đ</h4>
                @endif
                
            </div>
            <div class="thank">
                <h5>--Cảm ơn đã sử dụng dịch vụ của chúng tôi--</h5>
            </div>
        </div>
    </div>
</body>

</html>