<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class BookingDetail extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasFactory;
    protected $table = 'booking_detail';
    protected $fillable = ['booking_id','room_id','start_date','end_date','total_day','total_price'];

    public function room()
    {
        return $this->hasOne(Room::class,'id','room_id');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class,'id','booking_id');
    }

    public function services()
    {
        return $this->hasMany(ServiceBooking::class,['booking_id','room_id'],['booking_id','room_id']);
    }
}
