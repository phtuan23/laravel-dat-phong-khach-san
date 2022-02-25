<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');   
    }

    public function login()
    {
        return view('admin.login');
    }

    public function sign_in(Request $request)
    {
        $validator = Validator::make($request->only('username','password'), ['username' => 'required','password' => 'required'],['username.required' => 'Vui lòng điền tên đăng nhập.','password.required' => 'Vui lòng điền mật khẩu.']);
        if($validator->fails()){
            $errors = $validator->errors()->all();
            $html = "<ul class='list-group'>";
            foreach($errors as $err){
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            $html .= "</ul>";
            return response([
                'status' => false,
                'title' => 'Đăng nhập thất bại',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        $data = $request->only('username','password');
        $check = Auth::attempt($data);
        if($check){
            $admin = Admin::where('username',$request->username)->orWhere('password',$request->password)->first();
            if($admin){
                $data = [
                    'is_active' => 1
                ];
                $admin->update($data);
            }
            Session::flash('login_success','Chào mừng trở lại.');
            return response()->json([
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác',
                'title' => 'Đăng nhập thất bại',
                'icon' => 'error'
            ]);
        }
    }

    public function sign_out()
    {
        $admin = Auth::user();
        $_admin = Admin::find($admin->id);
        $_admin->update([
            'is_active' => "0"
        ]);
        Auth::logout();
        return redirect()->route('login');
    }
}
