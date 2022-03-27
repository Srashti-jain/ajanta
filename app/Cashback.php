<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashback extends Model
{
    protected $fillable = [
        'product_id','simple_product_id','cashback_type','discount_type','discount','enable'
    ];

    public function simple_product(){
        return $this->belongsTo('App\SimpSimpleProduct','simple_product_id','id');
    }
}
