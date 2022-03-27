<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id','image'
    ];

    public function product(){
        return $this->belongsTo('App\DigitalProduct','product_id','id')->withTrashed();
    }
}
