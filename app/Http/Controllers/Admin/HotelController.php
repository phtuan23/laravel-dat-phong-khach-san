<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::orderBy('id', 'DESC')->paginate(4);
        if(request()->search){
            $search = request()->search;
            $hotels = Hotel::orderby('id','DESC')->where('name','LIKE',"%$search%")->orWhere('address','LIKE',"%$search%")->paginate(4);
        }
        return view('admin.hotel.index', compact('hotels'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.hotel.create',compact('cities'));
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
            $request->only('name', 'address', 'city_id'),
            [
                'name' => 'required',
                'address' => 'required',
                'city_id' => 'required',
            ],
            [
                'name.required' => 'Vui lòng điền tên danh mục',
                'address.required' => 'Vui lòng điền địa chỉ',
                'city_id.required' => 'Vui lòng chọn thành phố',
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
                'address' => $request->address,
                'city_id' => $request->city_id,
            ];
            if(Hotel::create($data)){
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
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        $cities = City::all();
        return view('admin.hotel.edit',compact('hotel','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        $validator = Validator::make(
            $request->only('name', 'address', 'city_id'),
            [
                'name' => 'required',
                'address' => 'required',
                'city_id' => 'required',
            ],
            [
                'name.required' => 'Vui lòng điền tên danh mục',
                'address.required' => 'Vui lòng điền địa chỉ',
                'city_id.required' => 'Vui lòng chọn thành phố',
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
                'address' => $request->address,
                'city_id' => $request->city_id,
            ];
            if($hotel->update($data)){
                Session::flash('success','Cập nhật thành công.');
                return response([
                    'status' => true
                ]);
            }else{
                return response([
                    'status' => false,
                    'message' => 'Cập nhật không thành công. Vui lòng thử lại',
                    'title' => 'Thêm mới thất bại',
                    'icon' => 'error'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        if($hotel->rooms->count() > 0){
            return response([
                'status' => false,
                'title' => "Thất bại",
                'message' => 'Không thể xóa',
                'icon' => 'error'
            ]);
        }
        if($hotel->delete()){
            return response([
                'status' => true,
                'title' => "Thành công",
                'message' => 'Xóa khách sạn thành công',
                'icon' => 'success'
            ]);
        }
    }
}
