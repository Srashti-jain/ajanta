<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SizeChart extends Model
{
    protected $fillable = ['template_name','template_code','user_id','status'];
    
    public function sizeoptions(){
        return $this->hasMany(SizeChartOption::class,'size_id');
    }

    public function creator(){
        return $this->hasMany(User::class,'user_id','id');
    }
}
