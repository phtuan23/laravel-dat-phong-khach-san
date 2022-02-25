<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
class ReviewController extends Controller
{
    public function get_review_by_room($id)
    {
        $reviews = Review::orderBy('id','desc')->where('room_id', $id)->paginate(3);
        return view('client.room.review',compact('reviews'));
    }


    public function add_review(Request $request)
    {
        $validator = Validator::make(
            $request->only('name','email','review'),
            [
                'name' => 'required',
                'email' => 'required',
                'review' => 'required'
            ],
            [
                'name.required' => 'Vui lòng nhập tên',
                'email.required' => 'Vui lòng nhập email',
                'review.required' => 'Vui lòng nhập bình luận của bạn',
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
                'title' => 'Vui lòng nhập thông tin để bình luận',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        if($validator->passes()){
            $data = [
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'review' => $request->review,
                'rating' => $request->rating,
                'room_id' => $request->room_id
            ];
            $review = Review::where('customer_email', $request->email)->where('room_id', $request->room_id)->first();
            if($review){
                $review->update($data);
            }else{
                Review::create($data);
            }
            $rating = Review::where('room_id',$request->room_id)->avg('rating');
            return response([
                'status' => true,
                'rating' => $rating
            ]);
        }
    }
}
