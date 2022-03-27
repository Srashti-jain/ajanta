<?php

namespace App\Http\Controllers;

use App\Product;
use App\SimpleProduct;
use Illuminate\Http\Request;

class CashbackController extends Controller
{
    public function save(Request $request,$id){

        if($request->product_type == 'simple_product'){
            $product = SimpleProduct::findorfail($id);

            $product->cashback_settings()->updateOrCreate([
                'simple_product_id' => $id
            ],[
                'cashback_type' => $request->cashback_type,
                'discount_type' => $request->discount_type,
                'discount'      => $request->discount,
                'enable'        => $request->enable ? 1 : 0
            ]);
        }

        if($request->product_type == 'variant_product'){

            $product = Product::findorfail($id);

            $product->cashback_settings()->updateOrCreate([
                'product_id' => $id
            ],[
                'cashback_type' => $request->cashback_type,
                'discount_type' => $request->discount_type,
                'discount'      => $request->discount,
                'enable'        => $request->enable ? 1 : 0
            ]);
        }


        notify()->success(__('Cashback settings updated !'),__('Success'));
        return back();

    }

    public function apply($id,$amount,$type = 'simple_product'){

        if($type == 'simple_product'){
            $product = SimpleProduct::findorfail($id);
        }else{
            $product = Product::findorfail($id);
        }

        $cashback = $product->cashback_settings;

        if($cashback->cashback_type == 'per'){

            if($cashback->discount_type == 'upto'){

                $random_no = rand(0,$cashback->discount);
                $cb = $amount * $random_no / 100;

            }

            if($cashback->discount_type == 'flat'){

                $cb = $amount * $cashback->discount / 100;

            }

        }

        if($cashback->cashback_type == 'fix'){

            if($cashback->discount_type == 'upto'){
                
                $random_no = rand(0,$cashback->discount);
                $cb = $random_no;

            }

            if($cashback->discount_type == 'flat'){

                $cb = $cashback->discount;

            }

        }

        return $cb;

    }
}
