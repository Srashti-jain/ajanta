<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversations extends Model
{

    protected $fillable = ['conv_id','receiver_id','sender_id'];

    public function chat(){

        return $this->hasMany(Chat::class,'conv_id');

    }

    public function sender(){
        return $this->belongsTo(User::class,'sender_id','id');
    }

    public function reciever(){
        return $this->belongsTo(User::class,'receiver_id','id');
    }

}
