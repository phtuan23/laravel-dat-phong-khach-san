<table class="table table-hover text-center">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên thành phố</th>
            <th>Tổng số khách sạn</th>
            <th>Ngày tạo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($cities as $city)
        <tr>
            <td>{{$city->id}}</td>
            <td>{{$city->name}}</td>
            <td>{{$city->hotel()->count()}}</td>
            <td>{{$city->created_at->format('d-m-Y')}}</td>
            <td class="text-right">
                <a href="{{route('city.edit',$city->id)}}" class="btn btn-sm btn-warning">Chỉnh sửa</a>
                <a href="{{route('city.destroy',$city->id)}}" class="btn btn-sm btn-danger btn-delete">Xóa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="clearfix mt-2 ml-4">
    {{$cities->appends(request()->all())->links()}}
</div>