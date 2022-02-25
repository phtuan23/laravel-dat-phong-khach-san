<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ServiceBooking extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasFactory;
    protected $table = 'service_booking';
    protected $fillable = ['service_id','booking_id','room_id'];

    public function service()
    {
        return $this->hasOne(Service::class,'id','service_id');
    }

}
