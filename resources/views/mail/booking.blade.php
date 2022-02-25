<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt phòng thành công</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <style>
        body {
            width: 40%;
            margin: auto;
        }

        .body {
            text-align: center;
        }

        .body img {
            width: 20%;
        }

        .text table {
            margin: auto;
        }

        .text p {
            font-family: 'Dancing Script', cursive;
            font-size: 20px;
        }

        .end p {
            color: gray;
            font-size: 10px;
        }

        .end a {
            color: black;
            text-decoration: none;
        }

        table {
            width: 60%;
            box-sizing: border-box;
            border: 1px solid #ebebeb;
            border-collapse: collapse;
        }

        table tr td,
        tr th {
            text-align: center;
            border: 1px solid #ebebeb;
        }
        #email a{
            color:#dfa974;
            text-decoration: none
        }
    </style>
</head>

<body>
    <div class="body">
        <div class="text">
            <h2>Xin chào <span id="email">{{$booking_order->customer_email}}</span></h2>

            <h4>Dưới đây là thông tin phòng bạn đã đặt</h4>
            <table>
                <thead>
                    <tr style="background-color: #dfa974;">
                        <th style="padding:8px 8px">Số phòng</th>
                        <th style="padding:8px 8px">Ngày đặt</th>
                        <th style="padding:8px 8px">Ngày trả</th>
                        <th style="padding:8px 8px">Dịch vụ</th>
                        <th style="padding:8px 8px">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings->bookings as $item)
                    <?php $total_service = 0 ?>
                    <tr>
                        <td>{{$item['category']}} - {{$item['name']}}</td>
                        <td>{{$item['date_in']}}</td>
                        <td>{{$item['date_out']}}</td>
                        <td style="text-align:left;padding-left: 20px;">
                            @foreach($item['service'] as $srv)
                                <?php $total_service+=$srv['total_price'] ?>
                                <h4>{{$srv['name']}}</h4>
                            @endforeach
                        </td>
                        <td><?=number_format($item['price']*$item['total_day']+$total_service)?>đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h4>Tổng tiền : {{number_format($bookings->total_price)}} vnđ</h4>
            <h4>VAT(10%) : {{number_format(($bookings->total_price)*0.1)}} vnđ</h4>
            @if($bookings->sale != 0)
            <h4>Giảm giá ({{$bookings->sale*100}}%) : {{number_format(($bookings->total_price)*$bookings->sale)}} vnđ</h4>
            @endif
            <h4>Tổng tiền thanh toán: {{number_format(($bookings->total_price) + (($bookings->total_price)*0.1) - ($bookings->total_price)*$bookings->sale)}} vnđ</h4>
            @if($code_sale != null)
            <h5>ĐẶC BIỆT : Ưu đãi cho khách hàng lần đầu sử dụng dịch vụ. <br> Chúng tôi gửi tặng bạn mã giảm giá 10% cho lần đặt phòng kế tiếp. <br><span style="color: #dfa974;">{{$code_sale->code}}</span></h5>
            @endif
            <p>Chúc bạn có một chuyến du lịch vui vẻ !</p>
            <p>Cảm ơn bạn đã đặt phòng và sử dụng dịch vụ của chúng tôi !</p>
        </div>

        <div class="end">
            <a href="{{route('client.index')}}">Truy cập Aptech Hotel</a> |
            <a href="#">Chính sách & Quyền riêng tư</a> |
            <a href="{{route('client.contact')}}">Liên hệ với chúng tôi</a>

            <p>
                Vui lòng không trả lời trực tiếp email này. Email này được gửi từ địa chỉ dành riêng để thông báo và
                không chấp nhận email đến. Nếu bạn có câu hỏi hoặc cần trợ giúp,<a href=""> đặt câu hỏi tại đây.</a>
            </p>
            <p>138 Hoàng Quốc Việt, Bắc Từ Liêm, Hà Nội, Việt Nam</p>
            <p>
                © 2021 InterContinental LLC. Bảo lưu mọi quyền. InterContinental, logo InterContinental, Travellers'
                Choice
                và logo Travellers' Choice là các nhãn hiệu hoặc nhãn hiệu đã đăng ký của InterContinental LLC tại Việt
                Nam
                hoặc các quốc gia khác.
            </p>
        </div>
    </div>
</body>

</html>