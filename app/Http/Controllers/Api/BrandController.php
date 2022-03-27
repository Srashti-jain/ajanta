<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Genral;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\MainController;
use App\Product;
use App\SimpleProduct;
use Illuminate\Support\Facades\Validator;
use DB;
use ProductRating;

class BrandController extends Controller
{
    public function __construct()
    {
        try {

            $this->sellerSystem = Genral::select('vendor_enable')->first();

        } catch (\Exception $e) {

        }
    }

    public function getBrandProducts(Request $request, $brandid)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|string|max:3|min:3',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}

			if($errors->first('currency')){
				return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
			}
	
		}

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $brand = Brand::find($brandid);

       
        if (!$brand) {
            return response(['msg' => 'No brand found with that id !','status' => 'fail']);
        }

        if ($brand->status == 0) {
            return response()->json(['msg' => 'Brand is not active !','status' => 'fail']);
        }


        $brand = array(
            'brandid' => $brand['id'],
            'name' => $brand['name'],
            'image' => $brand['image'] ?? null,
            'image_path' => url('images/brands/'),
            'products' => $this->brandproducts($request,$brand) != null ? $this->brandproducts($request,$brand) : null,
        );

        

        return response()->json($brand);

    }

    public function brandproducts($request,$brand)
    {

        $sellerSystem = $this->sellerSystem;

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request->currency)->getData();

        $brand_products = Product::with('category')->whereHas('brand',function($q) use($brand) {

            return $q->where('brand_id',$brand->id);

        })->whereHas('category',function($q){

            $q->where('status','=','1');

        })->with('subcategory')->wherehas('subcategory',function($q){

            $q->where('status','1');

        })->with('vender')->whereHas('vender',function($query) use ($sellerSystem) {
 
            if($sellerSystem->vendor_enable == 1){
                $query->where('status','=','1')->where('is_verified','1');
            }else{
                $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
            }
    
        })->with('store')->whereHas('store',function($query){
    
            return $query->where('status','=','1');
    
        })->with('subvariants')->whereHas('subvariants',function($query){
    
            $query->where('def','=','1');
    
        })
        ->with('subvariants.variantimages')
        ->whereHas('subvariants.variantimages')
        ->where('status','=','1')
        ->where('featured', '=', '1')
        ->orderBy('id', 'DESC')
        ->take(20)
        ->get();


        $brand_products_vp = $brand_products->map(function($product){

            $orivar = $product->subvariants[0];

            $pricedata = new MainController;

            $mainprice = $pricedata->getprice($product, $orivar);
            $price = $mainprice->getData();

            if ($pricedata->getprice($product, $orivar)->getData()->offerprice != 0) {

                $mp = sprintf("%.2f", $pricedata->getprice($product, $orivar)->getData()->mainprice);
                $op = sprintf("%.2f", $pricedata->getprice($product, $orivar)->getData()->offerprice);

                $getdisprice = $mp - $op;

                $discount = $getdisprice / $mp;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $wishlist = new WishlistController;

            $item['variantid']      = $orivar->id;
            $item['type']           = 'v';
            $item['productid']      = $product->id;
            $item['productname']    = $product->getTranslations('name');
            $item['mainprice']      = (double) sprintf("%.2f", $price->mainprice * $this->rate->exchange_rate);
            $item['offerprice']     = (double) sprintf("%.2f", $price->offerprice * $this->rate->exchange_rate);
            $item['pricein']        = $this->rate->code;
            $item['symbol']         = $this->rate->symbol;
            $item['rating']         = (double) ProductRating::getReview($product);
            $item['reviews']        = (int) $product->reviews()->whereNotNull('review')->count();
            $item['off_in_percent'] = (int) round($offamount);
            $item['thumbnail']      = $orivar->variantimages->main_image;
            $item['thumbnail_path'] = url('variantimages/thumbnails');
            $item['tax_info']       = $product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes");
            $item['is_in_wishlist'] = (boolean) $wishlist->isItemInWishlist($orivar);

            return $item;

        });

        $brand_simple_products = SimpleProduct::whereHas('brand',function($q) use($brand) {

            return $q->where('brand_id',$brand->id);

        })->with('category')->whereHas('category',function($q){

            $q->where('status','=','1');

        })->with('subcategory')->wherehas('subcategory',function($q){

            $q->where('status','1');

        })->with('store')->whereHas('store',function($query){
    
            return $query->where('status','=','1');
    
        })->whereHas('store.user',function($query) use ($sellerSystem) {
    
            if($sellerSystem->vendor_enable == 1){
                $query->where('status','=','1')->where('is_verified','1');
            }else{
                $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
            }

        })
        ->where('status','=','1')
        ->orderBy('id', 'DESC')
        ->take(20)
        ->get();

        $brand_simple_products = $brand_simple_products->map(function($sp){

            if ($sp->offer_price != 0) {

                $getdisprice = $sp->price - $sp->offer_price;

                $discount = $getdisprice / $sp->price;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid']   = $sp->id;
            $item['variantid']   = 0;
            $item['productname'] = $sp->getTranslations('product_name');
            $item['type']      = 's';
            $item['mainprice'] = round($sp->price * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($sp->offer_price * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol']  = $this->rate->symbol;
            $item['rating']  = (double) simple_product_rating($sp->id);
            $item['reviews']  = (int) $sp->reviews()->whereNotNull('review')->count();
            $item['thumbnail'] = $sp->thumbnail;
            $item['thumbnail_path'] = url('images/simple_products/');
            $item['off_in_percent'] = (int) round($offamount);
            $item['tax_info']       = __("Inclusive of all taxes");
            $item['is_in_wishlist'] = inwishlist($sp->id);

            return $item;

        });

        return $brand_simple_products->toBase()->merge($brand_products_vp)->shuffle();

    }

    public function brandprices($request,$brand){

       

        $offamount_array = array();
        $startprice_array_of = array();
        $startprice_array_mrp = array();

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request)->getData();

        if($brand->products()->count() > 0){
            foreach ($brand->products->where('status', '1') as $product) {

        

                if ($product->subvariants()->count() > 0) {
    
                   
                    foreach ($product->subvariants as $orivar) {
                        
                       
                   
                        if ($orivar->def == 1) {
                            
                            $v = new MainController;
    
                            $variant = $v->getVariant($orivar);
    
                            $variant = $variant->getData();

                            if ($v->getprice($product, $orivar)->getData()->offerprice != '0') {

                                $mp = sprintf("%.2f", $v->getprice($product, $orivar)->getData()->mainprice);
                                $op = sprintf("%.2f", $v->getprice($product, $orivar)->getData()->offerprice);
        
                                $getdisprice = $mp - $op;
        
                                $discount = $getdisprice / $mp;
        
                                $offamount = $discount * 100;

                            } else {
                                $offamount = 0;
                            }
                            
    
                            array_push($offamount_array,$offamount);

                            array_push($startprice_array_of,sprintf("%.2f", $v->getprice($product, $orivar)->getData()->offerprice*$this->rate->exchange_rate));
                            
                            array_push($startprice_array_mrp,sprintf("%.2f", $v->getprice($product, $orivar)->getData()->mainprice*$this->rate->exchange_rate));
                            
                            
                        }
    
                    }
    
                }
    
            }
        }

       
        if(array_sum($offamount_array) == 0){

            if(array_sum($startprice_array_of) == 0){

                if(array_sum($startprice_array_mrp) == 0){
                    return null;
                }else{
                    return 'Starting '.$this->rate->symbol.min($startprice_array_mrp);
                }

            }else{
                return 'Starting '.$this->rate->symbol. ' ' .min($startprice_array_of);
            }

        }else{
           
            return 'Up to '.sprintf("%.2f",max($offamount_array)).'% Off';
        }
        
              
        

    }
}
