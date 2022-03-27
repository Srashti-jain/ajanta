<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SizeChartOption extends Model
{
    protected $fillable = [
        'size_id','option'
    ];

    public function template(){
        return $this->belongsTo(SizeChart::class,'size_id','id');
    }

    public function values(){
        return $this->hasMany(SizeChartValue::class,'option_id');
    }
}
