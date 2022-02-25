<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Booking;
use App\Models\Room;
use App\Models\Service;
use App\Models\CodeSale;
class BookingController extends Controller
{
    public function index(Booking $_booking)
    {
        $services = Service::all();
        return view('client.booking',compact('_booking','services'));
    }
    public function add(Booking $bk, Room $room,Request $request)
    {
        $date_in = $request->date_in;
        $date_out = $request->date_out;
        $bk->add($room,$date_in,$date_out);
        return redirect()->back()->with('success','Đã thêm vào đơn đặt phòng');
    }

    public function delete(Booking $bk,$id){
        $bk->delete($id);
    }

    public function clear(Booking $bk)
    {
        $bk->clear();
        return response([
            'status' => true
        ]);
    }

    public function update(Booking $bk,Request $request)
    {
        $id = $request->id;
        $_services = [];
        if($request->service){
            $services = $request->service;
            foreach($services as $serv){
                $srv = Service::find($serv);
                $_services[] = $srv;
            }
            $bk->update($id,$_services);
            return response([
                'code' => 200
            ]);
        }
    }

    public function delete_service(Booking $bk,$id_bk,$id_service)
    {
        $bk->delete_service($id_bk,$id_service);
        return response([
            'code' => 200
        ]);
    }

    public function main_booking(Booking $_booking)
    {
        $services = Service::all();
        return view('client.booking.main',compact('services','_booking'));
    }

    public function check_sale(Request $request,Booking $bk)
    {
        if($request->code_sale){
            $code = $request->code_sale;
            $code_sale = CodeSale::where('code',$code)->first();
            if($code_sale){
                $bk->update_sale($code_sale->sale);
                if($code_sale->delete()){
                    return response([
                        'code' => 200
                    ]);
                };
            }else{
                return response([
                    'code' => false,
                    'icon' => 'warning',
                    'message' => 'Mã giảm giá không đúng. Vui lòng thử lại'
                ]);
            }
        }
    }
}
