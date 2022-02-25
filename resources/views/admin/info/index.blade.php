@extends('layout.admin')

@section('main')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý thông tin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Trang chính</a></li>
                    <li class="breadcrumb-item active">Thông tin khách sạn</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <form action=""></form>
                                    @csrf
                                    <input type="text" name="search" class="form-control float-right" placeholder="Tìm kiếm" autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0" id="data">
                        <table class="table table-hover text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Logo</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="40">{{$info['id']}}</td>
                                    <td >
                                        <img src="{{url('public/upload')}}/{{$info['logo']}}" width="100">
                                    </td>
                                    <td >{{$info['phone']}}</td>
                                    <td >{{$info['email']}}</td>
                                    <td >
                                        <a href="{{route('infomation.edit',$info['id'])}}" class="btn btn-sm btn-success">Cập nhật</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    @endsection