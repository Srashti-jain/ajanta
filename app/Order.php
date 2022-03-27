<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    // public $timestamps = false;

    protected $fillable = [
        'status', 'order_status', 'qty', 'user_id', 'pro_id', 'simple_pro_ids', 'price', 'offer_price', 'pro_name', 'order_status', 'handlingcharge','purchase_proof','manual_payment','transaction_id','tax_amount','order_total'
    ];

    protected $casts = [
        'pro_id' => 'array',
        'billing_address' => 'array',
        'vender_ids' => 'array',
        'main_pro_id' => 'array',
        'simple_pro_ids' => 'array'
    ];


    public function billing()
    {
        return $this->belongsTo('App\BillingAddress', 'billing_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id')->withTrashed();
    }

    public function invoices()
    {
        return $this->hasMany('App\InvoiceDownload', 'order_id')->withTrashed();
    }

    public function orderlogs()
    {
        return $this->hasMany('App\OrderActivityLog', 'order_id');
    }

    public function cancellog()
    {
        return $this->hasMany('App\CanceledOrders', 'order_id');
    }

    public function refundlogs()
    {
        return $this->hasMany('App\Return_Product', 'main_order_id', 'id');
    }

    public function fullordercancellog()
    {
        return $this->hasOne('App\FullOrderCancelLog', 'order_id','id');
    }

    public function shippingaddress(){
        return $this->belongsTo('App\Address','delivery_address','id');
    }

}
