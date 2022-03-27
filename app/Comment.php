<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'name','email','comment','approved','pro_id','simple_pro_id'
    ];

    public function products(){
    	return $this->belongsTo('App\Product','pro_id','id');
    }
}
