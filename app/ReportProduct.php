<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportProduct extends Model
{
    protected $fillable = [
    	'pro_id','title','email','des','simple_pro_id'
    ];

    public function product(){
        return $this->belongsTo('App\Product','pro_id','id');
    }

    public function simpleProduct(){
        return $this->belongsTo('App\SimpleProduct','simple_pro_id','id');
    }
}
