<?php

namespace App;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class SimpleProduct extends Model implements Viewable
{

    use SoftDeletes;
    use HasTranslations;
    use InteractsWithViews;

    public $translatable = ['product_name', 'product_detail','key_features','sale_tag'];

    protected $fillable = [
        'product_name',
        'slug',
        'product_detail',
        'category_id',
        'product_tags',
        'price',
        'offer_price',
        'tax',
        'tax_rate',
        'thumbnail',
        'hover_thumbnail',
        'product_file',
        'status',
        'store_id',
        'brand_id',
        'type',
        'key_features',
        'subcategory_id',
        'child_id',
        'tax_name',
        'free_shipping',
        'featured',
        'cancel_avbl',
        'cod_avbl',
        'return_avbl',
        'tax_name',
        'model_no',
        'sku',
        'hsin',
        'policy_id',
        'actual_offer_price',
        'actual_selling_price',
        'commission_rate',
        'stock',
        'min_order_qty',
        'max_order_qty',
        'external_product_link',
        '360_image',
        'sale_tag_color',
        'sale_tag_text_color',
        'sale_tag',
        'pre_order',
        'preorder_type',
        'partial_payment_per',
        'product_avbl_date',
        'size_chart',
        'other_cats'
    ];

    protected $casts = [
        'other_cats' => 'array'
    ];

    public function productGallery()
    {
        return $this->hasMany('App\ProductGallery', 'product_id')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory', 'subcategory_id', 'id');
    }

    public function childcat()
    {
        return $this->belongsTo('App\Grandcategory', 'child_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo('App\Store', 'store_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\UserReview', 'simple_pro_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'simple_pro_id');
    }

    public function returnPolicy()
    {
        return $this->belongsTo('App\admin_return_product', 'policy_id','id');
    }

    public function faq()
    {
        return $this->hasMany('App\FaqProduct', 'simple_pro_id');
    }

    public function specs()
    {
        return $this->hasMany('App\ProductSpecifications', 'simple_pro_id');
    }

    public function frames(){
        return $this->hasMany('App\Product360Frame','product_id');
    }

    public function cashback_settings(){
        return $this->hasOne('App\Cashback','simple_product_id','id');
    }

    public function hotdeal(){
        return $this->hasOne('App\Hotdeal','simple_pro_id','id');
    }

    public function special_offer(){
        return $this->hasOne('App\SpecialOffer','simple_pro_id','id');
    }

    public function flashdeal(){
        return $this->hasMany('App\FlashSaleItem','simple_product_id');
    }

    public function sizechart(){
        return $this->belongsTo('App\SizeChart','size_chart','id');
    }

    public function slug(){
        return route('show.product',['id' => $this->id, 'slug' => $this->slug]);
    }

    public function addedInWish(){
        return $this->hasMany(Wishlist::class,'simple_pro_id');
    }

}
