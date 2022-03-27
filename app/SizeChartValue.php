<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SizeChartValue extends Model
{
    protected $fillable = ['value','option_id'];

    public function option(){
        return $this->belongsTo(SizeChartOption::class,'option_id','id');
    }
}
