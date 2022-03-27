<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{

    protected $fillable = [
        'sale_id','product_id','simple_product_id','discount','discount_type'
    ];

    public function sale(){
        return $this->belongsTo(Flashsale::class,'sale_id','id');
    }

    public function variant(){
        return $this->belongsTo(AddSubVariant::class,'product_id','id');
    }

    public function simple_product(){
        return $this->belongsTo(SimpleProduct::class,'simple_product_id','id');
    }

}
