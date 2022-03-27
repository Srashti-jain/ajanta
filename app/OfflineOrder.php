<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfflineOrder extends Model
{
    protected $fillable = ['order_id','shipping_method','shipping_rate','txn_id','payment_method','order_status','subtotal','total_shipping','total_tax','tax_rate','grand_total','customer_name','customer_id','customer_email','customer_phone','customer_shipping_address','customer_billing_address','country_id','state_id','city_id','customer_pincode','additional_note','adjustable_amount','tax_include','invoice_date'];
    
    public function orderItems(){
        return $this->hasMany('App\OfflineOrderItem','order_id');
    }

    public function country(){
        return $this->belongsTo('App\Allcountry','country_id','id');
    }

    public function states(){
        return $this->belongsTo('App\Allstate','state_id','id');
    }

    public function cities(){
        return $this->belongsTo('App\Allcity','city_id','id');
    }
}
