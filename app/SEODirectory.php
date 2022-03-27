<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SEODirectory extends Model
{
    protected $fillable = [
        'city','detail','status'
    ];

    public function getRouteKeyName() {

        return 'city';

    }
}
