<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'DESC')->paginate(4);
        if(request()->search){
            $search = request()->search;
            $customers = Customer::orderby('id','DESC')->where('name','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%")->orWhere('phone','LIKE',"%$search%")->paginate(4);
        }
        return view('admin.customer.index', compact('customers'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.create');
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
            $request->only('name', 'email', 'password', 'phone','cf_password'),
            [
                'name' => 'required',
                'email' => 'required|unique:customer,email|email',
                'password' => 'required|min:6',
                'cf_password' => 'required|same:password',
                'phone' => 'required|regex:/[0-9]{9}/'
            ],
            [
                'name.required' => 'Vui lòng điền tên đăng nhập',
                'phone.required' => 'Vui lòng điền số điện thoại',
                'phone.regex' => 'Số điện thoại không hợp lệ',
                'email.required' => 'Vui lòng điền địa chỉ email',
                'email.unique' => 'Địa chỉ email đã được sử dụng. Vui lòng thử lại',
                'email.email' => 'Email không đúng định dạng. Vui lòng thử lại',
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
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'address' => $request->address
        ];
        if(Customer::create($data)){
            Session::flash('success','Thêm mới thành công');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make(
            $request->only('name','email','phone'),
            [
                'name' => 'required',
                'email' => 'required|email|unique:customer,email,'.$customer->id,
                'phone' => 'required|regex:/[0-9]{9}/'
            ],
            [
                'name.required' => 'Vui lòng điền tên đăng nhập',
                'phone.required' => 'Vui lòng điền số điện thoại',
                'phone.regex' => 'Số điện thoại không hợp lệ',
                'email.required' => 'Vui lòng điền địa chỉ email',
                'email.unique' => 'Địa chỉ email đã được sử dụng. Vui lòng thử lại',
                'email.email' => 'Email không đúng định dạng. Vui lòng thử lại'
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
                'title' => 'Cập nhật không thành công',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address
        ];
        if($customer->update($data)){
            Session::flash('success','Cập nhật thành công');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response([
            'status' => true,
            'title' => "Thành công",
            'message' => 'Xóa tài khoản thành công',
            'icon' => 'success'
        ]);
    }
}
