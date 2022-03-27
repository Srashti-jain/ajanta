<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product360Frame extends Model
{

    protected $fillable = [
        'image','product_id'
    ];

    public function product(){
        return $this->belongsTo(SimpleProduct::class,'product_id','id');
    }
}
