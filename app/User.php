<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Nwidart\Modules\Facades\Module;
use SamuelNitsche\AuthLog\AuthLogable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasRoles, AuthLogable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'phonecode', 'mobile', 'city_id', 'country_id', 'state_id', 'phone', 'image', 'website', 'status', 'remember_token', 'apply_vender', 'gender', 'is_verified', 'google2fa_enable', 'google2fa_secret', 'refer_code', 'refered_from', 'subs_id', 'social_id', 'stripe_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function city()
    {
        return $this->belongsTo(Allcity::class, 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Allcountry::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo('App\Allstate', 'state_id', 'id');
    }

    public function ticket()
    {
        return $this->hasMany('App\HelpDesk', 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address', 'user_id');
    }

    public function store()
    {
        return $this->hasOne('App\Store', 'user_id', 'id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Wishlist', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\UserReview', 'user');
    }

    public function banks()
    {
        return $this->hasMany('App\Userbank', 'user_id');
    }

    public function cart()
    {
        return $this->hasMany('App\Cart', 'user_id');
    }

    public function failedtxn()
    {
        return $this->hasMany('App\FailedTranscations', 'user_id');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'vender_id');
    }

    public function purchaseorder()
    {
        return $this->hasMany('App\Order', 'user_id', 'id');
    }

    public function wallet()
    {
        return $this->hasOne('App\UserWallet', 'user_id', 'id');
    }

    public function routeNotificationForMsg91()
    {

        return "{$this->phonecode}{$this->mobile}";
    }

    public function routeNotificationForOneSignal()
    {
        return ['include_external_user_ids' => [$this->id . ""]];
    }

    // public function notifyAuthenticationLogVia()
    // {
    //     return ['mail'];
    // }

    public function wishlistCollection()
    {
        return $this->hasMany('App\User', 'user_id');
    }

    public function billingAddress()
    {
        return $this->hasMany('App\BillingAddress', 'user_id');
    }

    public function getReferals()
    {
        return $this->hasMany('App\AffilateHistory', 'user_id');
    }

    public function onetimereferdata()
    {
        return $this->hasOne('App\AffilateHistory', 'refer_user_id', 'id');
    }

    public static function createReferCode()
    {

        $aff_settings = Affilate::first();

        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');

        shuffle($seed);

        $rand = '';
        foreach (array_rand($seed, $aff_settings->code_limit) as $k) {
            $rand .= $seed[$k];
        }

        $num = str_split('');
        shuffle($num);

        return Str::upper($rand);
    }


    public function sellersubscription()
    {
        if(Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled()){
            return $this->hasMany(\Modules\SellerSubscription\Models\SellerSubscription::class, 'user_id');
        }
    }

    public function activeSubscription()
    {
        if(Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled()){
            return $this->hasOne(\Modules\SellerSubscription\Models\SellerSubscription::class, 'id', 'subs_id');
        }
    }

    public function templates(){
        return $this->hasMany(SizeChart::class,'user_id');
    }

}
