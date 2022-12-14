<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded=[];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function state(){
        return $this->belongsTo('App\Models\State','state_id','id');
    }

    public function lga(){
        return $this->belongsTo('App\Models\Lga','lga_id','id');
    }

    public function make(){
        return $this->belongsTo('App\Models\CarMake','make_id','id');
    }

    public function model(){
        return $this->belongsTo('App\Models\CarModel','model_id','id');
    }
}
