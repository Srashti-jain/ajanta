<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotdeal extends Model
{
     protected $fillable = [
        'pro_id','start','end','status','simple_pro_id'
    ];

     public function pro()
     {
     	return $this->belongsTo('App\Product','pro_id');  
     }

     public function simple_product()
     {
     	return $this->belongsTo('App\SimpleProduct','simple_pro_id');  
     }

}
