<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded=[];

    function product(){
        return $this->belongsTo(Product::class, "product_id");
    }

    function vendor(){
        return $this->belongsTo(User::class, "vendor_id");
    }

    function user(){
        return $this->belongsTo(User::class, "user_id");
    }
}
