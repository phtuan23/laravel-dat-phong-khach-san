@extends('layout.client')
@section('content')
<style>
    .act {
        border-bottom: 1px solid #dfa974
    }
</style>
<div class="container p-5">
    <h4 style="color:#dfa974">Thông tin tài khoản</h4>
    <div class="mb-5 mt-5">
        <div class="row">
            <div class="col-md-4" style="border: 1px solid rgb(221, 216, 216);box-shadow: 5px 5px #d3cece;">
                <div class="mb-3">
                    <div class="row p-3">
                        <div class="col-md-6 text-center" id="info_main">
                            <img src="{{url('public/upload')}}/{{auth()->guard('cus')->user()->avatar}}" width="100%" style="cursor: pointer;" id="image">
                            <form action="" enctype="multipart/form-data" method="post" id="form_data">
                            @csrf
                                <input type="file" name="avatar" id="avatar" hidden>
                                <button class="btn btn-sm btn-success w-100 mt-2" id="submit_image">Lưu</button>
                            </form>
                        </div>
                        <div class="col-md-6" id="infomation">
                            <h5 class="mb-3">{{$customer->name}}</h5>
                            @if($customer->gender==1)
                            <h5 class="mb-3"><i class="fa fa-mars mr-2"></i> Nam</h5>
                            @else($customer->gender==0)
                            <h5><i class="fa fa-venus mr-2"></i> Nữ</h5>
                            @endif
                            <h5>{{$customer->address}}</h5>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <ul>
                        <li class="list-group-item" style="border-color:#fff"><i class="fa fa-history mr-2" ></i> <a href="{{route('client.profile.history')}}" class="text-dark btn-history">Lịch sử đơn hàng</a></li>
                        <li class="list-group-item" style="border-color:#fff"><i class="fa fa-edit mr-2" ></i> <a href="{{route('client.profile.update')}}" class="text-dark btn-update">Cập nhật thông tin</a></li>
                        <li class="list-group-item" style="border-color:#fff" ><i class="fa fa-edit mr-2"></i> <a href="{{route('client.profile.change.password')}}" class="text-dark btn-change-password">Đổi mật khẩu</a></li>
                        <li class="list-group-item" style="border-color:#fff" ><i class="fa fa-sign-out mr-2"></i> <a href="{{route('client.logout')}}" class="text-dark">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-7 ml-5" style="border: 1px solid rgb(221, 216, 216);box-shadow: 5px 5px #d3cece;" id="main_content"></div>
        </div>
    </div>
</div>
@stop()
@section('js')
    <script>
        $(document).ready(function() {
            history_booking();
            update_form();
            update_info();
            change_password();
            submit_change_password();
            detail_booking();
            $(".btn-history").click(function(e){
                e.preventDefault();
                history_booking();
            });
            $("#submit_image").hide();

            $("#image").click(function() {
                $("#avatar").click();
            });

            $(document).on('click','.btn-secondary',function(){
                history_booking();
            });

            $("#avatar").change(function(){
                var file = $(this)[0].files[0];
                if(file){
                    $("#submit_image").show();
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $("#image").attr('src',e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            $("#submit_image").click(function(e){
                e.preventDefault();
                var formData = new FormData($("#form_data")[0]);
                $.ajax({
                    url : "{{route('client.profile.upload')}}",
                    data : formData,
                    type : "POST",
                    contentType: false,
                    processData: false,
                    success : function(res){
                        if(res.status=='success'){
                            $("#submit_image").hide();
                        }
                    }
                });
            });

            $(document).on('click','.btn-back',function(){
                history_booking();
            });

            function history_booking(){
                $.ajax({
                    url : "{{route('client.profile.history')}}",
                    type : "GET",
                    success : function(res){
                        $("#main_content").html(res);
                    }
                });
            }

            function update_form(){
                $(".btn-update").click(function(e){
                    e.preventDefault();
                    $.ajax({
                        url : "{{route('client.profile.update')}}",
                        type : "GET",
                        success : function(res){
                            $("#main_content").html(res);
                        }
                    });
                })
            }

            function update_info(){
                $(document).on('click','.btn-submit',function(e){
                    e.preventDefault();
                    var data = $("#form_info").serialize();
                    $.ajax({
                        url : "{{route('client.profile.update')}}",
                        type : "POST",
                        data : data,
                        success : function(res){
                            if(res.status=='false'){
                                Swal.fire({
                                    html: res.message,
                                    icon: res.icon
                                });
                            }
                            if(res.status=='success'){
                                window.location.reload();
                            }
                        }
                    });
                });
            }

            function change_password(){
                $(".btn-change-password").click(function(e){
                    e.preventDefault();
                    var url = $(this).attr("href");
                    $.ajax({
                        url : url,
                        type : "GET",
                        success : function(res){
                            $("#main_content").html(res);
                        }
                    });
                })
            }

            function submit_change_password(){
                $(document).on('click','.js-btn-submit',function(e){
                    e.preventDefault();
                    var data = $("#form_password").serialize();
                    $.ajax({
                        url : "{{route('client.profile.change.password')}}",
                        type: "POST",
                        data : data,
                        success: function(res){
                            if(res.status=='false'){
                                Swal.fire({
                                    html: res.message,
                                    icon: res.icon
                                });
                            }
                            if(res.status=='success'){
                                history_booking();
                                Swal.fire({
                                    html: res.message,
                                    icon: res.icon
                                });
                            }
                        }
                    });
                });
            }

            function detail_booking(){
                $(document).on('click','.btn-detail-booking',function(e){
                    e.preventDefault();
                    var url = $(this).attr('href');
                    $.ajax({
                        url : url,
                        type : 'GET',
                        success : function(res){
                            $("#main_content").html(res);
                        }
                    });
                })
            }


        });
    </script>
@endsection