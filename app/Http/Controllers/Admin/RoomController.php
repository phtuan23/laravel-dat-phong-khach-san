<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Category;
use App\Models\ImageRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::orderBy('id', 'DESC')->paginate(6);
        if(request()->search){
            $search = request()->search;
            $rooms = Room::join('hotel','hotel.id','=','room.hotel_id')->join('category','category.id','=','room.category_id')
            ->orderby('room.id','DESC')->where('room.name','LIKE',"%$search%")
            ->orWhere('hotel.name','LIKE',"%$search%")
            ->orWhere('category.name','LIKE',"%$search%")
            ->select('room.id','room.name','room.price','room.hotel_id','room.category_id','room.image')
            ->paginate(6);
        }
        return view('admin.room.index',compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hotels = Hotel::all();
        $categories = Category::all();
        return view('admin.room.create',compact('hotels', 'categories'));
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
            $request->only('name', 'price', 'image','image_description','description','category_id','hotel_id'),
            [
                'name' => 'required',
                'price' => 'required|numeric|min:1',
                'image' => 'required|mimes:jpeg,jpg,png',
                'image_description' => 'required',
                'image_description.*' => 'mimes:jpeg,png,jpg',
                'description' => 'required',
                'category_id' => 'required',
                'hotel_id' => 'required'
            ],
            [
                'name.required' => 'Vui lòng nhập tên phòng',
                'price.required' => 'Vui lòng nhập giá phòng',
                'price.numeric' => 'Giá phòng phải là số',
                'price.min' => 'Giá phòng phải là số dương',
                'image.required' => 'Vui lòng chọn ảnh',
                'image.mimes' => 'Ảnh không đúng định dạng',
                'description.required' => 'Vui lòng nhập mô tả phòng',
                'image_description.required' => 'Vui lòng chọn ảnh mô tả',
                'image_description.image' => 'Ảnh mô tả không hợp lệ',
                'image_description.*.mimes' => 'Ảnh mô tả không hợp lệ',
                'category_id.required' => 'Vui lòng chọn danh mục phòng',
                'hotel_id.required' => 'Vui lòng chọn địa chỉ khách sạn'
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

        if($validator->passes()) {
            if($request->has('image')){
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $image->move(public_path('upload'),$filename);
                $data = [
                    'name' => $request->name,
                    'price' => $request->price,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'hotel_id' => $request->hotel_id,
                    'image' => $filename
                ];
                if($room = Room::create($data)){
                    if($request->has('image_description')){
                        $images = $request->image_description;
                        foreach($images as $img){
                            $img_desciption = $img->getClientOriginalName();
                            $img->move(public_path('upload'),$img_desciption);
                            $data_img = [
                                'room_id' => $room->id,
                                'image' => $img_desciption
                            ];
                            ImageRoom::create($data_img);
                        }
                    }
                    Session::flash('success','Thêm mới thành công.');
                    return response([
                        'status' => true
                    ]);
                }
            }
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return view('admin.room.detail',compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $hotels = Hotel::all();
        $categories = Category::all();
        return view('admin.room.edit',compact('room','hotels','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $validator = Validator::make(
            $request->only('name', 'price', 'image','image_description','description','category_id','hotel_id'),
            [
                'name' => 'required',
                'price' => 'required|numeric|min:1',
                'image' => 'mimes:jpeg,jpg,png',
                'image_description.*' => 'mimes:jpeg,jpg,png',
                'description' => 'required',
                'category_id' => 'required',
                'hotel_id' => 'required'
            ],
            [
                'name.required' => 'Vui lòng nhập tên phòng',
                'price.required' => 'Vui lòng nhập giá phòng',
                'price.numeric' => 'Giá phòng phải là số',
                'price.min' => 'Giá phòng phải là số dương',
                'image.mimes' => 'Ảnh không đúng định dạng',
                'description.required' => 'Vui lòng nhập mô tả phòng',
                'image_description.*.mimes' => 'Ảnh mô tả không hợp lệ',
                'category_id.required' => 'Vui lòng chọn danh mục phòng',
                'hotel_id.required' => 'Vui lòng chọn địa chỉ khách sạn'
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
            $filename = $room->image;
            if($request->has('image')){
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $image->move(public_path('upload'),$filename);
            }
            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'hotel_id' => $request->hotel_id,
                'image' => $filename,
                'status' => $request->status
            ];
            if($request->has('image_description')){
                ImageRoom::where('room_id',$room->id)->delete();
                $images = $request->image_description;
                foreach($images as $img){
                    $img_desciption = $img->getClientOriginalName();
                    $img->move(public_path('upload'),$img_desciption);
                    $data_img = [
                        'room_id' => $room->id,
                        'image' => $img_desciption
                    ];
                    ImageRoom::create($data_img);
                }
            }
            if($room->update($data)){
                Session::flash('success','Cập nhật thành công.');
                return response([
                    'status' => true
                ]);
            }
            
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        ImageRoom::where('room_id',$room->id)->delete();
        if($room->delete()){
            return response([
                'status' => true,
                'title' => "Thành công",
                'message' => 'Xóa phòng thành công',
                'icon' => 'success'
            ]);
        }else{
            return response([
                'status' => false,
                'title' => "Thất bại",
                'message' => 'Xóa không thành công',
                'icon' => 'error'
            ]);
        }
    }
}
