<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "category";
    protected $fillable = ['name','size','max_people','description'];

    public function rooms()
    {
        return $this->hasMany(Room::class,'category_id','id');
    }
}
