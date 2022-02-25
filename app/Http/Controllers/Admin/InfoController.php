<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infomation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Infomation::first()->toArray();
        return view('admin.info.index',compact('info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Infomation  $infomation
     * @return \Illuminate\Http\Response
     */
    public function show(Infomation $infomation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Infomation  $infomation
     * @return \Illuminate\Http\Response
     */
    public function edit(Infomation $infomation)
    {
        return view('admin.info.edit', compact('infomation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Infomation  $infomation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Infomation $infomation)
    {
        $validator = Validator::make(
            $request->only('phone', 'email'),
            [
                'email' => 'required|unique:customer,email|email',
                'phone' => 'required|regex:/[0-9]{9}/'
            ],
            [
                'phone.required' => 'Vui lòng điền số điện thoại',
                'phone.regex' => 'Số điện thoại không hợp lệ',
                'email.required' => 'Vui lòng điền địa chỉ email',
                'email.unique' => 'Địa chỉ email đã được sử dụng. Vui lòng thử lại',
                'email.email' => 'Email không đúng định dạng. Vui lòng thử lại',
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
                'code' => 400,
                'title' => 'Thêm mới thất bại',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        if($validator->passes()) {
            $image = $infomation->logo;
            if($request->upload){
                $image = $request->upload->getClientOriginalName();
                $request->upload->move(public_path('upload'),$image);
            }
            $data = [
                'phone' => $request->phone,
                'email' => $request->email,
                'logo' => $image,
            ];
            if($infomation->update($data)){
                Session::flash('success','Cập nhật thành công.');
                return response([
                    'code' => 200
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Infomation  $infomation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Infomation $infomation)
    {
        //
    }
}
