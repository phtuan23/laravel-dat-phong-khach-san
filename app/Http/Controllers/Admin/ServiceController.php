<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::orderBy('id', 'DESC')->paginate(4);
        if(request()->search){
            $search = request()->search;
            $services = Service::orderby('id','DESC')->where('name','LIKE',"%$search%")->paginate(4);
        }
        return view('admin.service.index', compact('services'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->only('image', 'name', 'price'),
            [
                'name' => 'required|unique:service',
                'image' => 'required|image',
                'price' => 'required|numeric|min:1'
            ],
            [
                'name.required' => 'Vui lòng điền tên dịch vụ',
                'name.unique' => 'Tên dịch vụ đã được sử dụng',
                'image.required' => 'Vui lòng chọn ảnh dịch vụ',
                'image.image' => 'Ảnh không hợp lệ',
                'price.required' => 'Vui lòng điền giá dịch vụ',
                'price.numeric' => 'Giá dịch vụ phải là số',
                'price.min' => 'Giá dịch vụ không hợp lệ'
            ]
        );
        if($validator->fails()){
            $errors = $validator->errors()->all();
            $html = "<ul class='list-group'>";
            foreach($errors as $err){
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            $html .= "</ul>";
            return response([
                'status' => false,
                'title' => 'Thêm mới thất bại',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        if($validator->passes()){
            $filename= '';
            if($request->file('image')){
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $image->move(public_path('upload'),$filename);
            }
            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'image' => $filename
            ];
            if(Service::create($data)){
                Session::flash('success','Thêm mới thành công.');
                return response([
                    'status' => true
                ]);
            }else{
                return response([
                    'status' => false,
                    'message' => 'Thêm mới không thành công. Vui lòng thử lại',
                    'title' => 'Thêm mới thất bại',
                    'icon' => 'error'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('admin.service.edit',compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make(
            $request->only('image', 'name', 'price'),
            [
                'name' => 'required|unique:service,name,'.$service->id,
                'image' => 'image',
                'price' => 'required|numeric|min:1'
            ],
            [
                'name.required' => 'Vui lòng điền tên dịch vụ',
                'name.unique' => 'Tên dịch vụ đã được sử dụng',
                'image.image' => 'Ảnh không hợp lệ',
                'price.required' => 'Vui lòng điền giá dịch vụ',
                'price.numeric' => 'Giá dịch vụ phải là số',
                'price.min' => 'Giá dịch vụ không hợp lệ'
            ]
        );
        if($validator->fails()){
            $errors = $validator->errors()->all();
            $html = "<ul class='list-group'>";
            foreach($errors as $err){
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            $html .= "</ul>";
            return response([
                'status' => false,
                'title' => 'Thêm mới thất bại',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        if($validator->passes()){
            $filename= $service->image;
            if($request->file('image')){
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $image->move(public_path('upload'),$filename);
            }
            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'image' => $filename
            ];
            if($service->update($data)){
                Session::flash('success','Cập nhật thành công.');
                return response([
                    'status' => true
                ]);
            }else{
                return response([
                    'status' => false,
                    'message' => 'Cập nhật không thành công. Vui lòng thử lại',
                    'title' => 'Cập nhật thất bại',
                    'icon' => 'error'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if($service->service_booking()->count() > 0){
            return response([
                'status' => 300,
                'title' => "Thất bại",
                'message' => 'Không thể xóa dữ liệu dịch vụ hiện tại',
                'icon' => 'error'
            ]);
        }
        if($service->delete()){
            return response([
                'status' => true,
                'title' => "Thành công",
                'message' => 'Xóa dịch vụ thành công',
                'icon' => 'success'
            ]);
        }
    }
}
