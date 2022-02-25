@extends('layout.client')
@section('content')
<!-- Breadcrumb Section Begin -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Chi tiết phòng</h2>
                    <div class="bt-option">
                        <a href="{{route('client.index')}}">Trang chủ</a>
                        <span>Chi tiết</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Room Details Section Begin -->
<section class="room-details-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="room-details-item">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{url('public/upload')}}/{{$room->image}}" alt="First slide">
                            </div>
                            @foreach($images as $img)
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{url('public/upload')}}/{{$img->image}}" alt="Second slide">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="room-details-item">
                    <div class="rd-text">
                        <div class="rd-title">
                            <h3>{{$room->category->name}}</h3>
                            <div class="rdt-right">
                                <div id="rating_room"></div>
                                @if(request()->date_in && request()->date_out)
                                <a href="{{route('booking.add',$room->id)}}?date_in={{date('Y-m-d',strtotime(request()->date_in))}}&date_out={{date('Y-m-d',strtotime(request()->date_out))}}" class="primary-btn btn-booking">Đặt phòng</a>
                                @endif
                            </div>
                        </div>
                        <h2>{{number_format($room->price)}} vnđ<span>/ngày</span></h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="r-o">Diện tích:</td>
                                    <td>{{$room->category->size}} m2</td>
                                </tr>
                                <tr>
                                    <td class="r-o">Tối đa:</td>
                                    <td>{{$room->category->max_people}} người</td>
                                </tr>
                                <tr>
                                    <td class="r-o">Dịch vụ:</td>
                                    <td>{!!$room->category->description!!}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="f-para">{!!$room->description!!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="rd-reviews">
            <h4>Đánh giá</h4>
            <div class="review-item"></div>
            <br>
            <hr>
            <div class="review-add">
                <h4 class="mt-5">Thêm đánh giá</h4>
                <form action="{{route('client.add.review')}}" class="ra-form" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            @if(auth()->guard('cus')->check())
                            <input type="text" name="name" placeholder="Tên khách hàng*" value="{{auth()->guard('cus')->user()->name}}">
                            <input type="hidden" name="room_id" value="{{$room->id}}">
                            @else
                            <input type="text" name="name" placeholder="Tên khách hàng*">
                            <input type="hidden" name="room_id" value="{{$room->id}}">
                            @endif
                        </div>
                        <div class="col-lg-6">
                            @if(auth()->guard('cus')->check())
                            <input type="text" name="email" placeholder="Email khách hàng*" value="{{auth()->guard('cus')->user()->email}}">
                            @else
                            <input type="text" name="email" placeholder="Email khách hàng*">
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <div>
                                <div id="rateYo" class="mb-4"></div>
                                <input type="hidden" name="rating" id="num_rate" value="4.5">
                            </div>
                            <textarea name="review" placeholder="Bình luận*"></textarea>
                            <button class="mb-5" id="btn-submit">Bình luận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
    </div>
    <div class="container">
        <h4 class="mb-5">Gợi ý cho bạn</h4>
        <div class="row">
            @foreach($room_relate as $item)
            <div class="col-md-3">
                <div class="room-item">
                    <img src="{{url('public/upload')}}/{{$item->image}}" height="200px">
                    <div class="ri-text">
                        <h4>{{$item->category->name}}</h4>
                        <h3>{{number_format($item->price)}}<span>/ngày</span></h3>
                        <table>
                    <tbody>
                        <tr>
                            <td class="r-o">Số phòng:</td>
                            <td>{{$item->name}}</td>
                        </tr>
                        <tr>
                            <td class="r-o">Diện tích:</td>
                            <td>{{$item->category->size}} m2</td>
                        </tr>
                        <tr>
                            <td class="r-o">Tối đa:</td>
                            <td>{{$item->category->max_people}} người lớn</td>
                        </tr>
                        <tr>
                            <td class="r-o">Dịch vụ:</td>
                            <td>{!!$item->category->description!!}</td>
                        </tr>
                    </tbody>
                </table>
                        <a href="{{route('client.room.detail',$item->id)}}" class="primary-btn">Chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Room Details Section End -->
@stop()

@section('js')
    <script>
        $(document).ready(function (){
            $("#rateYo").rateYo({
                rating: 4.5,
                spacing: "5px"
            }).on('rateyo.set',function (e,data){
                $("#num_rate").val(data.rating);
            });

            var rating = "{{$rating}}";
            rating = rating > 0 ? rating : 0;
            $("#rating_room").rateYo({
                rating: rating,
                readOnly: true,
                starWidth: "20px"
            });

            add_review();
            get_review();
            get_more_reviews();

            function add_review(){
                $("#btn-submit").on('click',function(e){
                    e.preventDefault();
                    var data = $("form.ra-form").serialize();
                    var url = $("form.ra-form").attr('action');
                    $.ajax({
                        url : url,
                        data : data,
                        type : "POST",
                        success : function(res){
                            if(res.status==false){
                                Swal.fire({
                                    title: res.title,
                                    html: res.message,
                                    icon: res.icon
                                });
                            }
                            if(res.status==true){
                                get_review();
                                $("form.ra-form").trigger('reset');
                                $("#rating_room").rateYo("rating", res.rating);
                            }
                        }
                    });
                });
            }

            function get_review(){
                $.ajax({
                    url : "{{route('client.room.review',$room->id)}}",
                    type : "GET",
                    success : function(res){
                        $(".review-item").html(res);
                    }
                });
            }

            function get_more_reviews(){
                $(document).on('click',".pagination a",function(e){
                    e.preventDefault();
                    var url = $(this).attr("href");
                    $.ajax({
                        url : url,
                        type : "GET",
                        success : function(res){
                            $(".review-item").html(res);
                        }
                    })
                })
            }
        });

    </script>
@endsection
