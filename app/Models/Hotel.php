<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotel';
    protected $fillable = ['name','address','city_id'];

    public function city()
    {
        return $this->hasOne(City::class,'id','city_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class,'hotel_id','id');
    }
}
