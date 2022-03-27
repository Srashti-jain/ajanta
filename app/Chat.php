<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['message','conv_id','user_id','type','media'];

    public function conversation(){
        return $this->belongsTo(Conversations::class,'conv_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
