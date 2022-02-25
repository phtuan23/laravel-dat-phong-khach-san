@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý blog</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Trang chính</a></li>
                    <li class="breadcrumb-item active">Danh sách blog</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <a href="{{route('blog.create')}}" class="btn btn-sm btn-success">Thêm mới blog</a>
                        </div>
                        <div class="card-tools">
                            <form action="" id="form-search">
                                <div class="input-group input-group" style="width: 250px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Tìm kiếm" autocomplete="off" id="name">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" id="data">
                        <table class="table table-hover text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên tiêu đề</th>
                                    <th>Ảnh</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $blog)
                                <tr>
                                    <td>{{$blog->id}}</td>
                                    <td>{{$blog->name}}</td>
                                    <td><img src="{{url('public/upload')}}/{{$blog->image}}" width="200"></td>
                                    <td>
                                        <a href="{{route('blog.edit',$blog->id)}}" class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                        <a href="{{route('blog.destroy',$blog->id)}}" class="btn btn-sm btn-danger btn-delete">Xóa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-2 ml-4">
                            {{$blogs->appends(request()->all())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection

    @section('js')
        <script>
            $(document).ready(function(){
                $(".btn-delete").click(function(e){
                    e.preventDefault();
                    var url = $(this).attr("href");
                    Swal.fire({
                        title: 'Bạn có chắc muốn xóa?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'rgb(221, 51, 51)',
                        cancelButtonColor: 'gray',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                data : {
                                    _token : "{{csrf_token()}}"  
                                },
                                success: function(res) {
                                    $("#data").load(location.href + " #data>*");
                                }
                            });
                        }
                    });
                });

                $(document).on('keyup','#name',function(e){
                    e.preventDefault();
                    var search = $('#name').val();
                    $.ajax({
                        url: "{{route('blog.index')}}" + "?search=" + search,
                        type: "GET",
                        success: function(res) {
                            $("#data").load("{{route('blog.index')}}" + "?search=" + search + " #data>*");
                        }
                    });
                });
            })
        </script>
    @endsection