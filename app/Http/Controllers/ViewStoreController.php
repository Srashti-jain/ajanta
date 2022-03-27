<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\WishlistController;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use ProductRating;

class ViewStoreController extends Controller
{
   

    public function view(Request $request, $uuid,$title){

        require_once 'price.php';

        $store = Store::where('name',$title)
                ->where('uuid','=',$uuid)
                ->orWhereHas('simple_products',function($q){
                    return $q->where('status','=','1');
                })
                ->whereHas('products',function($q){
                    return $q->where('status','=','1');
                })
                ->with(['products','simple_products','products.subvariants'])
                ->first();

        if(!$store){
            notify()->error('Store not found !','404');
            return back();
        }

        if($store->uuid == '' || $uuid == 0){
            notify()->error(__('If you\'re store owner than update store once to get a unique id !'),__('Attention !'));
            return back();
        }


        if($request->sort == 'A-Z'){

            $items  = $store->products->sortBy('name');
            $items2 = $store->simple_products->sortBy('product_name');

        }elseif($request->sort == 'Z-A'){

            $items = $store->products->sortByDesc('name');
            $items2 = $store->simple_products->sortByDesc('product_name');

        }else{

            $items = $store->products->sortBy('name');
            $items2 = $store->simple_products->sortBy('product_name');

        }

        $get_product_data = new MainController;
        $wish             = new WishlistController;

        $items = $items->map(function($q) use($get_product_data,$conversion_rate,$wish) {

            

            if (isset($q->subvariants[0])) {

                $orivar = $q->subvariants[0];

                $variant = $get_product_data->getVariant($orivar);
                $variant = $variant->getData();
                $mainprice = $get_product_data->getprice($q, $orivar);
                $price = $mainprice->getData();
                $rating = $get_product_data->getproductrating($q);

                $content['productid'] = $q->id;
                $content['variantid'] = $orivar->id;
                $content['productname'] = $q->name;
                $content['product_type'] = 'v';
                $content['selling_start_at'] = $q->selling_start_at;

                $content['mainprice']  = price_format($price->mainprice * $conversion_rate);
                $content['details']    = strip_tags($q->des);
                $content['offerprice'] = price_format($price->offerprice * $conversion_rate);
                $content['product_type']  = __('v');
                $content['rating'] = (double) $rating;
                $content['thumbnail'] = url('variantimages/thumbnails/' . $orivar->variantimages->main_image);
                $content['hover_thumbnail'] = url('variantimages/hoverthumbnail/' . $orivar->variantimages->image2);
                $content['is_in_wishlist'] = $wish->isItemInWishlist($orivar);
                $content['stock'] = $orivar->stock;
                $content['featured'] = $q->featured;
                $content['rating'] = ProductRating::getReview($q);
                $content['pricein'] = session()->get('currency')['id'];
                $content['symbol'] = session()->get('currency')['value'];
                $content['position'] = session()->get('currency')['position'];
                $content['cartURL'] = route('add.cart.vue', ['id' => $q->id, 'variantid' => $orivar->id, 'varprice' => $price->mainprice, 'varofferprice' => $price->offerprice, 'qty' => $orivar->min_order_qty]);
                
                $content['producturl'] = $q->getURL($orivar);
                $content['sale_tag'] = $q->sale_tag;
                $content['sale_tag_color'] = $q->sale_tag_color;
                $content['sale_tag_text_color'] = $q->sale_tag_text_color;
                $content['min_order_qty'] = $orivar->min_order_qty;

                return $content;

            }

        });

        $items2 = $items2->map(function($content) use($conversion_rate) {

            $item['productid']           = $content->id;
            $item['productname']         = $content->product_name;

            $item['mainprice']           = price_format($content->price * $conversion_rate);

            $item['offerprice']          = price_format($content->offer_price * $conversion_rate);
            $item['thumbnail']           = url('images/simple_products/' . $content->thumbnail);
            $item['hover_thumbnail']     = url('images/simple_products/' . $content->hover_thumbnail);
            $item['is_in_wishlist']      = inwishlist($content->id) == false ? 0 : 1;
            $item['stock']               = $content->stock;
            $item['featured']            = $content->featured;
            $item['type']                = $content->type;
            $item['product_type']        = __('s');
            $item['details']             = strip_tags($content->product_detail);
            $item['rating']              = 0;
            $item['pre_order']           = $content->pre_order;
            $item['preorder_type']       = $content->preorder_type;
            $item['partial_payment_per'] = $content->partial_payment_per;
            $item['product_avbl_date']   = $content->product_avbl_date;
            $item['pricein']             = session()->get('currency')['id'];
            $item['symbol']              = session()->get('currency')['value'];
            $item['position']            = session()->get('currency')['position'];
            $item['cartURL']             = route('add.cart.vue.simple',['pro_id' => $content->id, 'price' => $content->price, 'offerprice'   => $content->offer_price ?? 0, 'qty' => $content->min_order_qty]);
            $item['pre_order']           = $content->pre_order;
            $item['preorder_type']       = $content->preorder_type;
            $item['partial_payment_per'] = $content->partial_payment_per;
            $item['product_avbl_date']   = $content->product_avbl_date;
            $item['producturl']          = route('show.product',['id' => $content->id, 'slug' => $content->slug]);
            $item['sale_tag']            = $content->sale_tag;
            $item['sale_tag_color']      = $content->sale_tag_color;
            $item['sale_tag_text_color'] = $content->sale_tag_text_color;
            $item['min_order_qty']       = $content->min_order_qty;
            $item['pre_order']           = $content->pre_order;
            $item['product_avbl_date']   = $content->product_avbl_date;
            $item['external_product_link'] = $content->external_product_link;
            return $item;

        });

        $items = $items->toBase()->merge($items2)->filter();

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $itemCollection = collect($items);

        // Define how many items we want to be visible in each page
        $perPage = $request->limit ?? 12;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $products = new LengthAwarePaginator($currentPageItems, count($itemCollection) , $perPage);

        
        // set url path for generted links
        $products->setPath($request->url());

        /** Google Reviews */

        $google_reviews = array();


        if($store->show_google_reviews == 1 && $store->google_place_api_key != '' && $store->google_place_id != ''){

            $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json',[
                'key'     => $store->google_place_api_key,
                'placeid' => $store->google_place_id
            ]);

            if($response->successful()){

               $response = $response->json();
    
               if($response['status'] == 'OK'){

                    $google_reviews = array(
                        'rating'  => $response['result']['rating'],
                        'reviews' => $response['result']['reviews']
                    );

               }
    
            }
        }


        return view('front.viewstore',compact('conversion_rate','store','products','google_reviews'));

    }
}
