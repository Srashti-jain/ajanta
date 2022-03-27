<?php

namespace App\Http\Controllers\Api;

use App\Flashsale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FlashdealController extends Controller
{
    public function getalldeals(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $deals = Flashsale::where('status','=','1')
                ->where('start_date', '<=',  now())
                ->where('end_date', '>=',  now())
                ->get()
                ->transform(function($value){

                    $deal['id'] = $value->id;
                    $deal['title'] = $value->title;
                    $deal['start_date'] = $value->start_date;
                    $deal['total_products']  = $value->saleitems()->count();
                    $deal['end_date']   = $value->end_date;
                    $deal['background_image'] = $value->background_image;
                    $deal['path']  = url('/images/flashdeals');
                    $deal['api_path'] = url('/api/view/deal/'.$value->id);
                    return $deal;

                });

        if(count($deals) < 1){
            return response()->json(['msg' => __("No deals found !"),'status' => 'success']);
        }

        return response()->json(['deals' => $deals,'status' => 'success']);

    }

    public function viewdeal(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|string|min:3|max:3'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }
        
        $deal = Flashsale::where('id',$id)->where('status','=','1')->first();

        if(!$deal){
            return response()->json(['msg' => 'No deal found !','status' => 'fail']);
        }

        if($deal && $deal->end_date < now()){

            return response()->json([
                'msg' => 'Sorry ! Deal you\'re viewing is expired !',
                'status' => 'fail'
            ]);

        }

        $deals = array(
            'title'             => $deal->title,
            'total_products'    => $deal->saleitems()->count(),
            'start_date'        => $deal->start_date,
            'end_date'          => $deal->end_date,
            'background_image'  => $deal->background_image,
            'path'              => url('/images/flashdeals'),
            'products'          => $this->dealproducts($deal)
        );

        return response()->json(['deals' => $deals,'status' => 'success']);

    }

    public function dealproducts($deal){
        
        $dealitems = $deal->saleitems()
                            ->orwhereHas('simple_product')
                            ->wherehas('variant')
                            ->get();

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates(request()->currency)->getData();

        $products = array();

        foreach ($dealitems as $key => $vp) {

            /** Get Variant Products */

                if(isset($vp->variant) && isset($vp->variant->products) && $vp->variant->products->status == '1'){

                    $get_product_data = new MainController;

                    $mainprice         = $get_product_data->getprice($vp->variant->products, $vp->variant);

                    $price             = $mainprice->getData();

                    $sellprice         = $price->offerprice != 0 ? $price->offerprice : $price->mainprice;

                    $discount          = $vp->discount;

                    $discount_type     = $vp->discount_type;

                    $discounted_amount = 0;

                    if($discount_type == 'upto'){

                        $random_no = rand(0,$discount);
                        
                        $discounted_amount = $sellprice * $random_no / 100;

                    }else{

                        $discounted_amount = $sellprice * $discount / 100;

                    }

                    $deal_price = $sellprice - $discounted_amount;

                    $images = $vp->variant->variantimages()->select('image1', 'image2', 'image3', 'image4', 'image5', 'image6')->get()->map(function ($image) {

                        if($image->image1 != null){
                            $item[]['image'] = $image->image1;
                        }
                        
                        if($image->image2 != null){
                            $item[]['image'] = $image->image2;
                        }
                        
                        if($image->image3 != null){
                            $item[]['image'] = $image->image3;
                        }
                        
                        if($image->image4 != null){
                            $item[]['image'] = $image->image4;
                        }

                        if($image->image5 != null){
                            $item[]['image'] = $image->image5;
                        }

                        if($image->image6 != null){
                            $item[]['image'] = $image->image6;
                        }
                        
                        return $item;

                    });

                    $products[] = array(
                        'variantid'     => $vp->variant->id,
                        'type'          => 'v',
                        'productid'     => $vp->variant->products->id,
                        'productname'   => $vp->variant->products->getTranslations('name'),
                        'description'   => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $vp->variant->products->getTranslations('des')),
                        'store'         => $vp->variant->products->store->name,
                        'storelogo'     => url('/images/store/'.$vp->variant->products->store->store_logo),
                        'addedbycount'  => $vp->variant->addedInWish()->count(),
                        'pricein'       => $this->rate->code,
                        'symbol'        => $this->rate->symbol,
                        'price'         => (float) sprintf("%.2f",$price->mainprice * $this->rate->exchange_rate),
                        'offerprice'    => (float) sprintf("%.2f",$deal_price * $this->rate->exchange_rate),
                        'discount'      => $vp->discount_type == 'upto' ? __('Upto :discount% discount',['discount'     => $vp->discount])  : __(':discount% flat discount',['discount' => $vp->discount]),
                        'images'        => $images[0],
                        'image_path'    => url('/variantimages/')
                    );

                }

            /** End */

            /** Get Simpl e Products */
                if(isset($vp->simple_product) && $vp->simple_product->status == '1'){

                    $sellprice = $vp->simple_product->offer_price != 0 ? $vp->simple_product->offer_price : $vp->simple_product->price;

                    $discount = $vp->discount;

                    $discount_type = $vp->discount_type;

                    $discounted_amount = 0;

                    if($discount_type == 'upto'){

                        $random_no = rand(0,$discount);
                        
                        $discounted_amount = $sellprice * $random_no / 100;

                    }else{

                        $discounted_amount = $sellprice * $discount / 100;

                    }

                    $deal_price = $sellprice - $discounted_amount;

                    $products[] = array(

                        'variantid'     => 0,
                        'type'          => 's',
                        'productid'     => $vp->simple_product->id,
                        'productname'   => $vp->simple_product->getTranslations('product_name'),
                        'description'   => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $vp->simple_product->getTranslations('product_detail')),
                        'store'         => $vp->simple_product->store->name,
                        'storelogo'     => url('/images/store/'.$vp->simple_product->store->store_logo),
                        'addedbycount'  => $vp->simple_product->addedInWish()->count(),
                        'pricein'       => $this->rate->code,
                        'symbol'        => $this->rate->symbol,
                        'price'         => (float) sprintf("%.2f",$vp->simple_product->price * $this->rate->exchange_rate),
                        'offerprice'    => (float) sprintf("%.2f",$deal_price * $this->rate->exchange_rate),
                        'discount'      => $vp->discount_type == 'upto' ? __('Upto :discount% discount',['discount' => $vp->discount])  : __(':discount% flat discount',['discount' => $vp->discount]) ,
                        'images'        => $vp->simple_product->productGallery()->select('image')->get(),
                        'image_path'    => url('/images/simple_products/gallery/')
                    );

                }
            /** End */

        }


        return $products;
        
    }
}
