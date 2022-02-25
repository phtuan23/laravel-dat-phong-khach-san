<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'room';
    protected $fillable = ['name','price','image','status','description','category_id','hotel_id'];

    public function hotel(){
        return $this->hasOne(Hotel::class,'id','hotel_id');
    }
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function images(){
        return $this->hasMany(ImageRoom::class,'room_id','id');
    }

    public function rate()
    {
        return $this->hasMany(Review::class,'room_id','id');
    }
}
