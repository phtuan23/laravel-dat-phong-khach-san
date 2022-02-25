<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeSale extends Model
{
    use HasFactory;
    protected $table = 'code_sale';
    protected $fillable = ['name','code','sale'];
}
