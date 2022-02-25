@extends('layout.client')
@section('content')
<!-- Breadcrumb Section Begin -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Danh sách phòng</h2>
                    <div class="bt-option">
                        <a href="{{route('client.index')}}">Trang chủ</a>
                        <span>Phòng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Rooms Section Begin -->
<section class="rooms-section spad">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="booking-form" style="padding:0">
                    <h3>Tìm phòng</h3>
                    <form action="#" method="get" id="form_search">
                        <div class="select-option">
                            <label for="category">Danh mục phòng:</label>
                            <select id="category" name="category">
                                <option value="">Danh mục</option>
                                @foreach($cats as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="select-option">
                            <label for="city">Thành phố:</label>
                            <select id="city" name="city">
                                <option value="">Địa điểm</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="check-date">
                            <label for="date-in">Ngày đến:</label>
                            <input type="text" class="date-input" id="date-in" name="date_in" >
                            <i class="icon_calendar"></i>
                        </div>
                        <div class="check-date">
                            <label for="date-out">Ngày rời:</label>
                            <input type="text" class="date-input" id="date-out" name="date_out">
                            <i class="icon_calendar"></i>
                        </div>
                        <h6 id="total_room_search" style="color:#dfa974"></h6>
                        <button type="submit" id="_search">Tìm kiếm</button>
                    </form>
                </div>
                <img src="{{url('public/upload')}}/banner.jpg" width="100%" class="mt-2">
                <img src="{{url('public/upload')}}/banner-room.jpg" width="100%" class="mt-2" height="375">
            </div>
            <div class="col-md-9" id="room_data"></div>
        </div>
    </div>
</section>
@stop()

@section('js')
    <script>
        $(document).ready(function(){
            rooms();
            paginate();
            room_by_cat();
            available_room();
            function rooms(){
                $.ajax({
                    url : "{{route('client.room.data')}}",
                    type : "GET",
                    success : function(res){
                        $("#room_data").html(res);
                    }
                })
            }

            function paginate(){
                $(document).on('click','.pagination a',function(e){
                    e.preventDefault();
                    var href = $(this).attr('href');
                    $.ajax({
                        url : href,
                        type : "GET",
                        success : function(res){
                            $("#room_data").html(res);
                            $("html, body").animate({scrollTop: 300}, 800);
                        }
                    })
                });
            }

            function room_by_cat(){
                $("#category").change(function(){
                    var id = $(this).val();
                    $.ajax({
                        url : "{{route('client.room.data')}}"+"?category="+id,
                        type : "GET",
                        success : function(res){
                            $("#room_data").html(res);
                        }
                    });
                })
            }

            function available_room(){
                $("#_search").click(function(e){
                    e.preventDefault();
                    var data = $("#form_search").serialize();
                    $.ajax({
                        url : "{{route('client.room.data')}}",
                        data : data,
                        type : "GET",
                        success : function(res){
                            $("#room_data").html(res);
                            $(document).ajaxComplete(function(){
                                var text = $(".total_room").text();
                                $("#total_room_search").text(text);
                            });
                        }
                    });
                });
            }
        })
    </script>
@endsection