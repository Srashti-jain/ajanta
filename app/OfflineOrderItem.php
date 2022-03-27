<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfflineOrderItem extends Model
{
    protected $table = 'offline_order_items';

    public function parentOrder(){
        return $this->belongsTo('App\OfflineOrder','order_id','id');
    }
}
