<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\City;
use App\Models\BookingDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Mail;
use Str;
use App\Rules\CheckPassword;
class CustomerController extends Controller
{
    public function submit_register(Request $request)
    {
        $validator = Validator::make(
            $request->only('name', 'email', 'password', 'phone','cf_password'),
            [
                'name' => 'required',
                'email' => 'required|unique:customer,email|email',
                'password' => 'required|min:6',
                'cf_password' => 'required|same:password',
                'phone' => 'required|regex:/[0-9]{10}/'
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
                'code' => 400,
                'title' => 'Đăng ký không thành công',
                'icon' => 'error',
                'message' => $html
            ]);
        }
        if($validator->passes()) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'gender' => $request->gender,
                'address' => $request->address
            ];
            if(Customer::create($data)){
                Session::flash('success','Đăng ký thành viên thành công');
                Session::reflash();
                return response([
                    'code' => 200
                ]);
            }
        }
    }

    public function submit_login(Request $request)
    {
        $validator = Validator::make(
            $request->only('email', 'password'),
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Vui lòng điền email',
                'email.email' => 'Email không đúng định dạng. Vui lòng thử lại',
                'password.required' => 'Vui lòng điền mật khẩu'
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
                'title' => 'Đăng nhập không thành công',
                'icon' => 'error',
                'message' => $html
            ]);
        }
        if($validator->passes()) {
            $customer = $request->only('email','password');
            $remember = $request->remember;
            $check = Auth::guard('cus')->attempt($customer,$remember);
            if($check){
                Session::flash('login_success',"Xin chào".Auth::guard('cus')->user()->email);
                Session::reflash();
                return response([
                    'code' => 200
                ]);
            }else{
                return response([
                    'code' => 444,
                    'title' => 'Đăng nhập thất bại',
                    'icon' => 'error',
                    'message' => "Vui lòng kiểm tra tài khoản hoặc mật khẩu"
                ]);
            }
        }
    }

    public function logout()
    {
        Auth::guard('cus')->logout();
        return redirect()->route('client.index');
    }

    public function forgot_password()
    {
        return view('client.password.forgot');
    }

    public function confirm_email(Request $request)
    {
        $validator = Validator::make(
            $request->only('email', 'password'),
            [
                'email' => 'required|email'
            ],
            [
                'email.required' => 'Vui lòng điền email',
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
                'code' => 400,
                'icon' => 'error',
                'message' => $html
            ]);
        }
        if($validator->passes()){
            $email = $request->email;
            $customer = Customer::where('email',$email)->first();
            if($customer){
                $token = Str::random(35);
                $customer->update(['token' => $token]);
                Mail::send('mail.forgot-password',compact('customer','token'),function($mail) use($email){
                    $mail->to($email);
                    $mail->from('tuantuan230298@gmail.com');
                    $mail->subject('Confirmation Required');
                });
                Session::flash('success','Vui lòng kiểm tra email của bạn');
                Session::reflash();
                return response([
                    'code' => 200,
                ]);
            }else{
                return response([
                    'code' => 444,
                    'icon' => 'warning',
                    'message' => "Không tìm thấy email. Vui lòng thử lại."
                ]);
            }
        }
    }

    public function confirm_request(Request $request,$email,$token)
    {
        $customer = Customer::where('email',$email)->orWhere('token',$token)->first();
        if($customer){
            return view('client.password.change');
        }else{
            return view('client.password.forgot')->with('error','Không tìm thấy tài khoản');
        }
    }

    public function change_password(Request $request,$email,$token)
    {
        $validator = Validator::make(
            $request->only('cf_password', 'password'),
            [
                'password' => 'required|min:6',
                'cf_password' => 'required|same:password',
            ],
            [
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
                'code' => 400,
                'icon' => 'error',
                'message' => $html
            ]);
        }
        if($validator->passes()) {
            $password = $request->password;
            $customer = Customer::where('email',$email)->orWhere('token',$token)->first();
            if($customer){
                if($customer->update(['password' => bcrypt($password) , 'token' => NULL])){
                    Session::flash('success','Bạn đã đổi mật khẩu thành công.');
                    Session::reflash();
                    return response([
                        'code' => 200
                    ]);
                }
            }
        }
    }

    public function profile()
    {
        $customer = Auth::guard('cus')->user();
        return view('client.profile.index',compact('customer'));
    }

    public function upload(Request $request)
    {
        $customer = Auth::guard('cus')->user();
        if($request->has('avatar')){
            $filename = $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('upload'),$filename);
            $customer->update(['avatar' => $filename]);
            return response([
                'status' => 'success'
            ]);
        }
    }

    public function form_update(Request $request)
    {
        $customer = Auth::guard('cus')->user();
        return view('client.profile.update',compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = Auth::guard('cus')->user();
        $validator = Validator::make(
            $request->only('phone'),
            [
                'phone' => 'required|regex:/[0-9]{10}/'
            ],
            [
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.regex' => 'Số điện thoại không đúng định dạng. Vui lòng thử lại'
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
                'status' => 'false',
                'icon' => 'error',
                'message' => $html
            ]);
        }
        $data = [
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender
        ];
        if($customer->update($data)){
            Session::flash('success','Cập nhật thông tin thành công.');
            Session::reflash();
            return response([
                'status' => 'success'
            ]);
        }
    }

    public function history(Request $request)
    {
        $customer = Auth::guard('cus')->user();
        $bookings = Booking::where('customer_id', $customer->id)->paginate(4);
        return view('client.profile.history',compact('bookings'));
    }

    public function form_change_password(Request $request)
    {
        return view('client.profile.password');
    }

    public function submit_change_password(Request $request)
    {
        $customer = Auth::guard('cus')->user();
        $validator = Validator::make(
            $request->only('old_password','new_password','confirm_password'),
            [
                'old_password' => ['required',new CheckPassword],
                'new_password' => 'required|alpha_dash|min:6',
                'confirm_password' => 'required|same:new_password'
            ],
            [
                'old_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
                'new_password.required' => 'Vui lòng nhập mật khẩu mới',
                'new_password.alpha_dash' => 'Mật khẩu không chứa khoảng trắng',
                'confirm_password.required' => 'Vui lòng xác nhận mật khẩu mới',
                'confirm_password.same' => 'Mật khẩu xác nhận không đúng. Vui lòng thử lại'
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
                'status' => 'false',
                'icon' => 'error',
                'message' => $html
            ]);
        }
        if($validator->passes()){
            $password = bcrypt($request->new_password);
            if($customer->update(['password' => $password])){
                return response([
                    'status' => 'success',
                    'icon' => 'success',
                    'message' => "Đổi mật khẩu thành công"
                ]);
            }
        }
    }

    public function detail_booking(Request $request,$id)
    {
        $booking_details = BookingDetail::where('booking_id',$id)->get();
        $booking = Booking::where('id',$id)->first();
        return view('client.profile.detail',compact('booking_details','booking'));
    }
}
