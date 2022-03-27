<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderActivityLog extends Model
{
    public function order()
    {
    	return $this->belongsTo('App\Order','order_id','id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function simple_product(){
    	return $this->belongsTo('App\SimpleProduct','simple_pro_id','id');
    }

    public function variant(){
    	return $this->belongsTo('App\AddSubVariant','variant_id','id');
    }
}
