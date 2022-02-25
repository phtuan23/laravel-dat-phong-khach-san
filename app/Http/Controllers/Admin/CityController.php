<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::orderBy('id', 'DESC')->paginate(4);
        if(request()->search){
            $search = request()->search;
            $cities = City::orderby('id','DESC')->where('name','LIKE',"%$search%")->paginate(4);
        }
        return view('admin.city.index',compact('cities'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.city.create');
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
            $request->only('name'),
            [
                'name' => 'required|unique:city'
            ],
            [
                'name.required' => 'Vui lòng điền tên thành phố',
                'name.unique' => 'Tên thành phố đã được sử dụng'
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
            $data = [
                'name' => $request->name,
            ];
            if(City::create($data)){
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
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('admin.city.edit',compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $validator = Validator::make(
            $request->only('name'),
            [
                'name' => 'required|unique:city,name,'.$city->id
            ],
            [
                'name.required' => 'Vui lòng điền tên thành phố',
                'name.unique' => 'Tên thành phố đã được sử dụng'
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
            $data = [
                'name' => $request->name
            ];
            if($city->update($data)){
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
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        if($city->hotel()->count() > 0){
            return response([
                'status' => false,
                'title' => "Thất bại",
                'message' => 'Không thể xóa',
                'icon' => 'error'
            ]);
        }
        if($city->delete()){
            return response([
                'status' => true,
                'title' => "Thành công",
                'message' => 'Xóa thành công',
                'icon' => 'success'
            ]);
        }
    }
}
