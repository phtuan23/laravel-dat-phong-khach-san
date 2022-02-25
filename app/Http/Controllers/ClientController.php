<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\City;
use App\Models\Category;
use App\Models\Room;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Review;
use App\Models\Contact;
use App\Models\CodeSale;
use App\Models\Blog;
use App\Models\ServiceBooking;
use App\Helper\Booking as Bk;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Mail;
use Str;


class ClientController extends Controller
{
    public function index()
    {
        return view('client.index');
    }

    public function room_data(Request $request)
    {
        if ($request->category and $request->date_in and $request->date_out) {
            $category_id = $request->category;
            $date_in = $request->date_in;
            $date_out = $request->date_out;

            $booking_detail = BookingDetail::where('end_date', '>=', date('Y-m-d', strtotime($date_out)))->orWhere('end_date', '>=', date('Y-m-d', strtotime($date_in)))->get();

            $id_booking_detail = [];

            foreach ($booking_detail as $bk_detail) {
                $id_booking_detail[] = $bk_detail->room_id;
            }

            $rooms = Room::where('category_id', $category_id)->whereNotIn('room.id', $id_booking_detail)->paginate(6);
        } else if ($request->category) {
            $rooms = Room::where('category_id', $request->category)->paginate(6);
        } else {
            $rooms = Room::paginate(6);
        }
        return view('client.room.data', compact('rooms'));
    }

    public function room(Request $request)
    {
        $cats = Category::all();
        $cities = City::all();
        return view('client.room.index', compact('cities', 'cats'));
    }

    public function detail(Request $request, Room $room)
    {
        $images = $room->images;
        $rating = Review::where('room_id', $room->id)->avg('rating');
        $room_relate = Room::inRandomOrder()->where('category_id', $room->category_id)->limit(4)->get();
        return view('client.room.detail', compact('room', 'images', 'room_relate', 'rating'));
    }

    public function login()
    {
        $banners = Banner::all();
        return view('client.login', compact('banners'));
    }

    public function register()
    {
        return view('client.register');
    }

    public function contact()
    {
        return view('client.contact');
    }

    public function about()
    {
        return view('client.about');
    }

    public function checkout(Bk $_booking)
    {
        if (count($_booking->bookings) > 0) {
            return view('client.checkout', compact('_booking'));
        }
        return redirect()->route('client.room');
    }

    public function booking(Request $request, Bk $_booking)
    {
        $validator = Validator::make(
            $request->only('name', 'email', 'phone'),
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required'
            ],
            [
                'name.required' => 'Vui lòng điền tên đăng nhập',
                'phone.required' => 'Vui lòng điền số điện thoại',
                'email.required' => 'Vui lòng điền địa chỉ email'
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $html = "<ul class='list-group'>";
            foreach ($errors as $err) {
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            $html .= "</ul>";
            return response([
                'code' => 400,
                'title' => 'Vui lòng điền thông tin',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        if ($validator->passes()) {
            $check_email = Booking::where('customer_email', $request->email)->first();
            $booking = Booking::create([
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'customer_id' => Auth::guard('cus')->check() ? Auth::guard('cus')->user()->id : null
            ]);
            if (!$check_email) {
                $code_sale = CodeSale::create([
                    'name' => $request->email,
                    'code' => Str::random(10),
                    'sale' => 0.1
                ]);
            } else {
                $code_sale = null;
            }
            if ($booking) {
                foreach ($_booking->bookings as $bk) {
                    $start = strtotime($bk['date_in']);
                    $end = strtotime($bk['date_out']);
                    $date = abs($end - $start);
                    $booking_detail = BookingDetail::create([
                        'booking_id' => $booking->id,
                        'room_id' => $bk['id'],
                        'start_date' => $bk['date_in'],
                        'end_date' => $bk['date_out'],
                        'total_day' => floor($date / (60 * 60 * 24)),
                        'total_price' => floor($date / (60 * 60 * 24)) * $bk['price']
                    ]);
                    if ($booking_detail) {
                        foreach ($bk['service'] as $item) {
                            ServiceBooking::create([
                                'booking_id' => $booking_detail->booking_id,
                                'room_id' => $booking_detail->room_id,
                                'service_id' => $item['id']
                            ]);
                        }
                    }
                }
                if ($booking_detail) {
                    Mail::send(
                        'mail.booking',
                        [
                            'booking_order' => $booking,
                            'bookings' => $_booking,
                            'code_sale' => $code_sale
                        ],
                        function ($email) use ($booking, $_booking,$code_sale) {
                            $sale = session('sale')!= null ? session('sale') : null;
                            $mpdf = new \Mpdf\Mpdf(['utf-8']);
                            $mpdf->WriteHTML(view('pdf.booking', compact('booking', '_booking','sale'))->render());
                            $mpdf->output(public_path('pdf/booking.pdf'), 'F');
                            // send mail
                            $email->to($booking->customer_email);
                            $email->from('tuantuan230298@gmail.com');
                            $email->subject('Đặt phòng thành công');
                            $email->attach(public_path('pdf/booking.pdf'));
                        }
                    );
                    Session::flash('success', 'Đặt phòng thành công.');
                    Session::reflash();
                    session(['booking' => []]);
                    session(['sale' => 0]);
                    return response([
                        'code' => 200
                    ]);
                }
            }
        }
    }

    public function amout(Bk $_booking)
    {
        return view('client.checkout.amout', compact('_booking'));
    }

    public function contact_mail(Request $request)
    {
        $validator = Validator::make(
            $request->only('name', 'email'),
            [
                'name' => 'required',
                'email' => 'required'
            ],
            [
                'name.required' => 'Vui lòng nhập tên',
                'email.required' => 'Vui lòng nhập email'
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $html = "<ul class='list-group'>";
            foreach ($errors as $err) {
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            $html .= "</ul>";
            return response([
                'status' => false,
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        if ($validator->passes()) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ];
            $contact = Contact::where('email', $request->email)->first();
            if ($contact) {
                $contact->update($data);
            } else {
                $_contact = Contact::create($data);
                if ($_contact) {
                    Mail::send(
                        'mail.contact',
                        [
                            'contact' => $_contact
                        ],
                        function ($email) use ($_contact) {
                            // send mail
                            $email->to($_contact->email);
                            $email->from('tuantuan230298@gmail.com');
                            $email->subject('Cảm ơn bạn đã quan tâm');
                        }
                    );
                }
            }
            return response([
                'status' => 'success',
                'message' => 'Gửi thành công.',
                'icon' => 'success'
            ]);
        }
    }

    public function blog()
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(4);
        return view('client.blog.blog', compact('blogs'));
    }

    public function blog_detail(Request $request, Blog $blog)
    {
        $newests = Blog::orderBy('id', 'desc')->limit(3)->get();
        return view('client.blog.detail', compact('blog', 'newests'));
    }
}
