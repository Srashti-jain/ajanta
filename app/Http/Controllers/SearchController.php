<?php
namespace App\Http\Controllers;

use App\Commission;
use App\CommissionSetting;
use App\Genral;
use App\Mostsearched;
use App\Product;
use App\SimpleProduct;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function ajaxSearch(Request $request)
    {

        require_once 'price.php';

        $search = $request->search;
        $result = array();
        $imageurl = url('variantimages/thumbnails/');
        $infourl = url('images');

        $sellerSystem = Genral::first();

        $ifwordExist = Mostsearched::where('keyword',$search)->first();

        if(isset($ifwordExist)){
            
            $ifwordExist->count = $ifwordExist->count + 1;

        }else{

            $ifwordExist = new Mostsearched;
            $ifwordExist->keyword = $search;
            $ifwordExist->count = 1;
            
        }

        $ifwordExist->save();

        if ($request->catid == 'all') {

                    $query = Product::where('status','=','1')
                    ->whereHas('vender',function($query) use ($sellerSystem) {
 
                        if($sellerSystem->vendor_enable == 1){
                            $query->where('status','=','1')->where('is_verified','1');
                        }else{
                            $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
                        }
                
                    })
                    ->whereHas('subvariants')
                    ->with('subvariants')
                    ->where('tags->'.app()->getLocale(), 'LIKE', '%' . $search . '%')
                    ->orWhere('name->'.app()->getLocale(), 'LIKE', '%' . $search . '%')
                    ->get();
    
                $query2 = SimpleProduct::whereHas('store.user',function($query) use ($sellerSystem) {
            
                        if($sellerSystem->vendor_enable == 1){
                            $query->where('status','=','1')->where('is_verified','1');
                        }else{
                            $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
                        }
            
                    })
                    ->where('status','=','1')
                    ->where('product_tags', 'LIKE', '%' . $search . '%')
                    ->orWhere('product_name->'.app()->getLocale(), 'LIKE', '%' . $search . '%')
                    ->get();

        } else {
            
                $query = Product::where('status','=','1')
                    ->whereHas('vender',function($query) use ($sellerSystem) {
 
                        if($sellerSystem->vendor_enable == 1){
                            $query->where('status','=','1')->where('is_verified','1');
                        }else{
                            $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
                        }
                
                    })
                    ->with('subvariants')
                    ->whereHas('subvariants')
                    ->where('tags->'.app()->getLocale(), 'LIKE', '%' . $search . '%')
                    ->orwhere('name->'.app()->getLocale(), 'LIKE', '%' . $search . '%')
                    ->where('category_id', '=', $request->catid)
                    ->get();

                $query2 = SimpleProduct::where('status','=','1')
                ->whereHas('store.user',function($query) use ($sellerSystem) {
            
                    if($sellerSystem->vendor_enable == 1){
                        $query->where('status','=','1')->where('is_verified','1');
                    }else{
                        $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
                    }
        
                })
                ->where('category_id', '=', $request->catid)
                ->where('product_tags', 'LIKE', '%' . $search . '%')
                ->orWhere('product_name->'.app()->getLocale(), 'LIKE', '%' . $search . '%')
                ->get();
        }


        if (count($query) < 1 && count($query2) < 1) {
            
            $result[] = ['id' => 1, 'value' => 'No Result found', 'img' => $infourl . '/info.png', 'url' => '#'];

        } else {

            $price_array = array();
            $price_login = Genral::find(1)->login;

            foreach ($query->unique('child') as $searchresult) {

                foreach ($searchresult->subcategory->products as $old) {

                    foreach ($old->subvariants as $orivar) {

                        if ($price_login == 0 || auth()->check()) {

                            $commision_setting = CommissionSetting::first();

                            if ($commision_setting->type == "flat") {

                                $commission_amount = $commision_setting->rate;
                                if ($commision_setting->p_type == 'f') {

                                    if ($old->tax_r != '') {
                                        $cit = $commission_amount * $old->tax_r / 100;
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                                    } else {
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                    }

                                    if ($old->vender_offer_price == 0) {
                                        array_push($price_array, $totalprice);
                                    } else {
                                        array_push($price_array, $totalsaleprice);

                                    }

                                } else {

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0) {
                                        $bprice = round($buyerprice, 2);

                                        array_push($price_array, $bprice);
                                    } else {
                                        $bsprice = round($buyersaleprice, 2);
                                        array_push($price_array, $bsprice);

                                    }

                                }
                            } else {

                                $comm = Commission::where('category_id', $old->category_id)->first();
                                if (isset($comm)) {
                                    if ($comm->type == 'f') {

                                        if ($old->tax_r != '') {
                                            $cit = $comm->rate * $old->tax_r / 100;
                                            $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                        } else {
                                            $price = $old->vender_price + $comm->rate + $orivar->price;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                        }

                                        if ($old->vender_offer_price == 0) {

                                            array_push($price_array, $price);
                                        } else {
                                            array_push($price_array, $offer);
                                        }

                                    } else {

                                        $commission_amount = $comm->rate;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0) {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        } else {
                                            $bsprice = round($buyersaleprice, 2);
                                            array_push($price_array, $bsprice);
                                        }

                                    }
                                } else {
                                    $commission_amount = 0;

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0) {
                                        $bprice = round($buyerprice, 2);
                                        array_push($price_array, $bprice);
                                    } else {
                                        $bsprice = round($buyersaleprice, 2);
                                        array_push($price_array, $bsprice);
                                    }
                                }
                            }

                        }

                    }

                }

            }

            foreach($query2->unique('subcategory') as $searchresult2){

                if($searchresult2->offer_price != 0){
                    array_push($price_array, $searchresult2->offer_price);
                }else{
                    array_push($price_array, $searchresult2->price);
                }
                    
            }

            if ($price_array != null) {
                $firstsub = min($price_array);
                $startp = round($firstsub);
                if ($startp >= $firstsub) {
                    $startp = $startp - 1;
                } else {
                    $startp = $startp;
                }

                $lastsub = max($price_array);
                $endp = round($lastsub);

                if ($endp <= $lastsub) {
                    $endp = $endp + 1;
                } else {
                    $endp = $endp;
                }

            } else {
                $startp = 0.00;
                $endp = 0.00;
            }

            if (isset($firstsub)) {
                if ($firstsub == $lastsub) {
                    $startp = 0.00;
                }
            }

            unset($price_array);

            $price_array = array();
            
            
           
            foreach ($query->unique('child') as $searchresult) {

                if(count($searchresult->subvariants)){

                    $url = url('shop?category=' . $searchresult
                        ->category->id . '&sid=' . $searchresult
                        ->subcategory->id . '&start=' . $startp * $conversion_rate . '&end=' . $endp * $conversion_rate . '&keyword=' . $request->search);

                    $result[] = ['id' => $searchresult->id, 'value' => $request->search . ' in ' . $searchresult
                                ->subcategory->title, 'img' => $imageurl . '/' . $searchresult->subvariants[0]
                                ->variantimages['main_image'], 'url' => $url];
    
                    }
                }
            }

            foreach($query2->unique('subcategory') as $q){

                $url = url('shop?category=' . $q
                        ->category->id . '&sid=' . $q
                        ->subcategory->id . '&start=' . $startp * $conversion_rate . '&end=' . $endp * $conversion_rate . '&keyword=' . $request->search);

                $result[] = ['id' => $q->id, 'value' => $request->search . ' in ' . $q
                ->subcategory->title, 'img' => url('images/simple_products') . '/' . $q->thumbnail, 'url' => $url];
            }

            return response()->json($result);
    }
}
