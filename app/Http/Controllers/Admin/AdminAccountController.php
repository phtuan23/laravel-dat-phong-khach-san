<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class AdminAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::orderBy('id','DESC')->paginate(4);
        if(request()->search){
            $search = request()->search;
            $admins = Admin::orderBy('id','DESC')->where('username','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%")->paginate(4);
        }
        return view('admin.account.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.account.create');
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
            $request->only('username', 'email', 'avatar', 'password','cf_password'),
            [
               'username' => 'required|unique:admin,username|min:6|max:20|alpha_dash',
                'email' => 'required|unique:admin,email|email',
                'avatar' => 'image',
                'password' => 'required|min:6',
                'cf_password' => 'required|same:password'
            ],
            [
                'username.required' => 'Vui lòng điền tên đăng nhập',
                'username.unique' => 'Tên đăng nhập đã được sử dụng',
                'username.alpha_dash ' => 'Tên đăng nhập không hợp lệ',
                'username.min' => 'Tên đăng nhập tối thiểu 6 ký tự',
                'username.max' => 'Tên đăng nhập tối đa 20 ký tự',
                'email.required' => 'Vui lòng điền địa chỉ email',
                'email.unique' => 'Địa chỉ email đã được sử dụng. Vui lòng thử lại',
                'email.email' => 'Email không đúng định dạng. Vui lòng thử lại',
                'avatar.image' => 'Ảnh đại diện không đúng định dạng (png, jpg). Vui lòng thử lại',
                'password.required' => 'Vui lòng điền mật khẩu',
                'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
                'cf_password.required' => 'Vui lòng xác nhận mật khẩu',
                'cf_password.same' => 'Mật khẩu xác nhận không đúng'
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
        $filename = '';
        if($request->has('avatar')){
            $filename = $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('upload'),$filename);
        }
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => $filename
        ];
        Admin::create($data);
        Session::flash('success','Thêm mới thành công');  
        return response([
            'url' => route('account.index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $account)
    {
        if(Auth::user()->id != $account->id){
            return response([
                'status' => false,
                'icon' => 'warning',
                'message' => 'Không thể cập nhật tài khoản của thành viên khác'
            ]);
        }else{
            return view('admin.account.edit',compact('account'));
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $account)
    {
        $request->validate([
            'username' => 'required|min:6|max:20|alpha_dash|unique:admin,username,'.$account->id,
            'email' => 'required|email|unique:admin,email,'.$account->id,
            'avatar' => 'image',
            'password' => 'required|min:6',
            'cf_password' => 'required|same:password'
        ],[
            'username.required' => 'Vui lòng điền tên đăng nhập',
            'username.unique' => 'Tên đăng nhập đã được sử dụng',
            'username.alpha_dash ' => 'Tên đăng nhập không hợp lệ',
            'username.min' => 'Tên đăng nhập tối thiểu 6 ký tự',
            'username.max' => 'Tên đăng nhập tối đa 20 ký tự',
            'email.required' => 'Vui lòng điền địa chỉ email',
            'email.unique' => 'Địa chỉ email đã được sử dụng. Vui lòng thử lại',
            'email.email' => 'Email không đúng định dạng. Vui lòng thử lại',
            'avatar.image' => 'Ảnh đại diện không đúng định dạng (png, jpg). Vui lòng thử lại',
            'password.required' => 'Vui lòng điền mật khẩu',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'cf_password.required' => 'Vui lòng xác nhận mật khẩu',
            'cf_password.same' => 'Mật khẩu xác nhận không đúng'
        ]);
        $filename = $account->avatar;
        if($request->has('avatar')){
            $filename = $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('upload'),$filename);
        }
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => $filename
        ];
        if($account->update($data)){
            return redirect()->route('account.index')->with('success','Cập nhật thành công');
        }else{
            return redirect()->back()->with('error','Cập nhật thất bại. Vui lòng thử lại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $account)
    {   
        if($account->is_active == 1){
            return response([
                'status' => false,
                'title' => 'Thất bại',
                'message' => 'Không thể xóa tài khoản đang hoạt động',
                'icon' => 'error'
            ]);
        }
        if($account->delete()){
            return response([
                'status' => true,
                'title' => 'Thành công',
                'message' => 'Xóa tài khoản thành công',
                'icon' => 'success'
            ]);
        };
    }
}
