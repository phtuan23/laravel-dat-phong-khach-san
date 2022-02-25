<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('id', 'DESC')->paginate(4);
        return view('admin.banner.index',compact('banners'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
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
            $request->only('uploads'),
            [
                'uploads' => 'required',
                'uploads.*' => 'mimes:jpeg,png,jpg'
            ],
            [
                'uploads.required' => 'Vui lòng chọn ảnh',
                'uploads.*.mimes' => 'Ảnh không đúng định dạng'
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
            $image_banner = [];
            if($request->file('uploads')){
                $uploads = $request->uploads;
                foreach($uploads as $upload){
                    $filename = $upload->getClientOriginalName();
                    $upload->move(public_path('upload'),$filename);
                    $image_banner[] = $filename;
                }
            }
            foreach($image_banner as $item){
                $data = [
                    'image' => $item
                ];
                Banner::create($data);
            }
            Session::flash('success','Thêm mới thành công');
            return response([
                'status' => true
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $validator = Validator::make(
            $request->only('image'),
            [
                'image' => 'image'
            ],
            [
                'image.image' => 'Ảnh không đúng định dạng'
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
            $filename = $banner->image;
            if($request->file('image')){
                $image = $request->image;
                $filename = $image->getClientOriginalName();
                $image->move(public_path('upload'),$filename);
            }
            $data = [
                'image' => $filename
            ];
            if($banner->update($data)){
                Session::flash('success','Cập nhật thành công');
                return response([
                    'status' => true
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        Session::flash('success','Xóa thành công');
        return response([
            'status' => true
        ]);
    }
}
