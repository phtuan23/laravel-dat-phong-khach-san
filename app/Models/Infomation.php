<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infomation extends Model
{
    use HasFactory;
    protected $table = 'infomation';
    protected $fillable = ['logo','phone','email'];
}
