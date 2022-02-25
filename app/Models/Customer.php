<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    protected $table = 'customer';
    protected $fillable = ['avatar','name','email','phone','password','gender','address','token'];

    public function bookings()
    {
        return $this->hasMany(Booking::class,'customer_id','id');
    }

    public function total_booking($customer_email)
    {
        $bookings = Booking::where('customer_email',$customer_email)->get();
        return $bookings->count();
    }
}
