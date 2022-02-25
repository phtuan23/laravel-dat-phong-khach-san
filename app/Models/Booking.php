<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = ['customer_name','customer_phone','customer_email','customer_id','status'];

    public function booking_detail()
    {
        return $this->hasMany(BookingDetail::class,'booking_id','id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }
}
