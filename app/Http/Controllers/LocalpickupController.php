<?php
namespace App\Http\Controllers;

use App\Cart;
use App\Genral;
use App\InvoiceDownload;
use App\Notifications\LocalPickUpNotification;
use App\ProductAttributes;
use App\ProductValues;
use App\Shipping;
use App\ShippingWeight;
use App\User;
use Auth;
use Illuminate\Http\Request;

class LocalpickupController extends Controller
{
    public function apply(Request $request)
    {
        require_once 'price.php';

        if (Auth::check()) {

            $cartid = $request->cartid;
            $grandtotal = 0;
            $totalshipping = 0;

            $cartrow = Cart::where('id', '=', $cartid)->where('user_id', Auth::user()
                    ->id)
                    ->first();

            $getrate = Shipping::where('name', '=', 'Local Pickup')->first()->price;

            if (isset($cartrow)) {

                if($cartrow->product &&  $cartrow->variant){

                    if (!empty($cartrow->product->shipping_id)) {

                        /*Update cart row*/
                        $cartrow->shipping = $getrate;
                        $cartrow->ship_type = 'localpickup';
                        $cartrow->save();
                        /*End*/
    
                    } else {
    
                        /*Update cart row*/
                        $getrate = 0;
                        $cartrow->shipping = '0';
                        $cartrow->ship_type = 'localpickup';
                        $cartrow->save();
                        /*End*/
                    }

                    if ($cartrow->semi_total != 0) {

                        if ($cartrow->product->tax_r != '') {
                            $totalprice = $cartrow->semi_total + $getrate;
                        } else {
                            $totalprice = $cartrow->semi_total + $cartrow->tax_amount + $getrate;
                        }
    
                    } else {
    
                        if ($cartrow->product->tax_r != '') {
                            $totalprice = $cartrow->price_total + $getrate;
                        } else {
                            $totalprice = $cartrow->price_total + $cartrow->tax_amount + $getrate;
                        }
    
                    }

                }

                if($cartrow->simple_product){

                    if ($cartrow->simple_product->free_shipping == 0) {

                        /*Update cart row*/
                        $cartrow->shipping = $getrate;
                        $cartrow->ship_type = 'localpickup';
                        $cartrow->save();
                        /*End*/
    
                    } else {
    
                        /*Update cart row*/
                        $getrate = 0;
                        $cartrow->shipping = '0';
                        $cartrow->ship_type = 'localpickup';
                        $cartrow->save();
                        /*End*/
                    }

                    if ($cartrow->semi_total != 0) {

                        if ($cartrow->simple_product->tax != '0') {
                            $totalprice = ($cartrow->semi_total) + $getrate;
                        }
    
                    } else {
    
                        if ($cartrow->simple_product->tax != '0') {
                           $totalprice = ($cartrow->price_total) + $getrate;
                        }
    
                    }

                }

                

                foreach (auth()->user()->cart as $value) {

                    $totalshipping += $value->shipping;

                    if ($value->semi_total != 0) {
                        
                        if($value->product && $value->variant){

                            if ($value->product->tax_r != '') {
                                $grandtotal = $grandtotal + $value->shipping + $value->semi_total;
                            } else {
                                $grandtotal = $grandtotal + $value->shipping + $value->tax_amount + $value->semi_total;
                            }

                        }

                        if($value->simple_product){

                            $grandtotal = $grandtotal + $value->shipping + $value->semi_total;
                           
                        }

                    } else {
                        
                        if($value->product && $value->variant){

                            if ($value->product->tax_r != '') {
                                $grandtotal = $grandtotal + $value->shipping + $value->price_total;
                            } else {
                                $grandtotal = $grandtotal + $value->shipping + $value->tax_amount + $value->price_total;
                            }

                        }

                        if($value->simple_product){

                           
                           $grandtotal = $grandtotal + $value->shipping + $value->price_total;
                            

                        }

                    }

                }

                $genrals_settings = Genral::first();
                $handlingcharge = 0;

                // Calulate handling charge
                if ($genrals_settings->chargeterm == 'fo') {
                    // on full order handling charge
                    $handlingcharge = $genrals_settings->handlingcharge;
                } elseif ($genrals_settings->chargeterm == 'pi') {
                    // Per item handling charge
                    $totalcartitem = count($cart);
                    $handlingcharge = $genrals_settings->handlingcharge * $totalcartitem;
                }

                $grandtotal = $grandtotal + $handlingcharge;

                return response()->json(['pershipping' => round($getrate * $conversion_rate, 2), 'totalprice' => round(($totalprice * $conversion_rate), 2), 'totalshipping' => round(($totalshipping * $conversion_rate), 2), 'grandtotal' => round(($grandtotal * $conversion_rate), 2)]);

            } else {
                return response()->json('error');
            }

        } else {
            return response()->json('error');
        }
    }

    public function reset(Request $request)
    {
        require_once 'price.php';

        if (Auth::check()) {
            $grandtotal = 0;
            $totalshipping = 0;
            $cartid = $request->cartid;

            $row = Cart::where('id', '=', $cartid)->where('user_id', auth()->id())
                    ->first();

            if (isset($row)) {

                if($row->product && $row->variant){

                    /*reset data*/
                    $free_shipping = Shipping::where('id', $row
                            ->product
                            ->shipping_id)
                            ->first();

                    if (!empty($free_shipping)) {
                        if ($free_shipping->name == "Shipping Price") {
                            $weight = ShippingWeight::first();
                            $pro_weight = $row
                                ->variant->weight;
                            if ($weight->weight_to_0 >= $pro_weight) {

                                if ($weight->per_oq_0 == 'po') {
                                    $per_shipping = $weight->weight_price_0;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                } else {
                                    $per_shipping = $weight->weight_price_0 * $row->qty;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                }
                            } elseif ($weight->weight_to_1 >= $pro_weight) {

                                if ($weight->per_oq_1 == 'po') {
                                    $per_shipping = $weight->weight_price_1;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                } else {
                                    $per_shipping = $weight->weight_price_1 * $row->qty;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                }
                            } elseif ($weight->weight_to_2 >= $pro_weight) {

                                if ($weight->per_oq_2 == 'po') {
                                    $per_shipping = $weight->weight_price_2;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                } else {

                                    $per_shipping = $weight->weight_price_2 * $row->qty;
                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                }
                            } elseif ($weight->weight_to_3 >= $pro_weight) {

                                if ($weight->per_oq_3 == 'po') {
                                    $per_shipping = $weight->weight_price_3;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                } else {
                                    $per_shipping = $weight->weight_price_3 * $row->qty;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                }
                            } else {

                                if ($weight->per_oq_4 == 'po') {
                                    $per_shipping = $weight->weight_price_4;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));
                                } else {

                                    $per_shipping = $weight->weight_price_4 * $row->qty;

                                    Cart::where('id', $row->id)
                                        ->update(array(
                                            'shipping' => $per_shipping,
                                            'ship_type' => null,
                                        ));

                                }

                            }

                        } else {
                            $per_shipping = $free_shipping->price;

                            Cart::where('id', $row->id)
                                ->update(array(
                                    'shipping' => $per_shipping,
                                    'ship_type' => null,
                                ));

                        }
                    } else {
                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => '0',
                                'ship_type' => null,
                            ));

                        $per_shipping = 0;
                    }

                }

                if($row->simple_product){
                    if($row->simple_product->free_shipping == 0){

                        Cart::where('id', $row->id)
                                ->update(array(
                                    'shipping' => shippingprice($row),
                                    'ship_type' => null,
                                ));
    
                            $per_shipping = shippingprice($row);
    
                    }else{

                        Cart::where('id', $row->id)
                                ->update(array(
                                    'shipping' => '0',
                                    'ship_type' => null,
                                ));
    
                            $per_shipping = 0;

                    }
                }

               

                if ($row->semi_total != 0) {

                    if($row->product && $row->variant){
                        if ($row->product->tax_r != '') {
                            $totalprice = $row->semi_total + $per_shipping;
                        } else {
                            $totalprice = $row->semi_total + $row->tax_amount + $per_shipping;
                        }
                    }

                    if($row->simple_product){
                        
                        $totalprice = ($row->semi_total) + $per_shipping;
                    }

                } else {

                    if($row->product && $row->variant){

                        if ($row->product->tax_r != '') {
                            $totalprice = $row->price_total + $per_shipping;
                        } else {
                            $totalprice = $row->price_total + $row->tax_amount + $per_shipping;
                        }

                    }

                    
                    if($row->simple_product){
                        $totalprice = ($row->semi_total) + $per_shipping;
                    }

                }

                foreach (auth()->user()->cart as $value) {
                    $totalshipping = $totalshipping + $value->shipping;

                    if ($value->semi_total != 0) {
                        
                        if($value->product){
                            if ($value->product->tax_r != '') {
                                $grandtotal = $grandtotal + $value->shipping + $value->semi_total;
                            } else {
                                $grandtotal = $grandtotal + $value->shipping + $value->tax_amount + $value->semi_total;
                            }
                        }

                        if($value->simple_product){

                            
                            $grandtotal = $grandtotal + $value->shipping + $value->semi_total;
                           

                        }

                    } else {
                        
                        if($value->product){
                            if ($value->product->tax_r != '') {
                                $grandtotal = $grandtotal + $value->shipping + $value->price_total;
                            } else {
                                $grandtotal = $grandtotal + $value->shipping + $value->tax_amount + $value->price_total;
                            }
                        }
                        if($value->simple_product){

                           
                            $grandtotal = $grandtotal + $value->shipping + $value->price_total;
                            

                        }

                    }

                }

                $genrals_settings = Genral::first();
                $handlingcharge = 0;

                // Calulate handling charge
                if ($genrals_settings->chargeterm == 'fo') {
                    // on full order handling charge
                    $handlingcharge = $genrals_settings->handlingcharge;
                } elseif ($genrals_settings->chargeterm == 'pi') {
                    // Per item handling charge
                    $totalcartitem = count($cart);
                    $handlingcharge = $genrals_settings->handlingcharge * $totalcartitem;
                }

                $grandtotal = $grandtotal + $handlingcharge;

                return response()->json(['pershipping' => round($per_shipping * $conversion_rate, 2), 'totalprice' => round(($totalprice * $conversion_rate), 2), 'totalshipping' => round(($totalshipping * $conversion_rate), 2), 'grandtotal' => round(($grandtotal * $conversion_rate), 2)]);

            } else {
                return response()->json('error');
            }
        } else {
            return response()
                ->json('error');
        }
    }

    public function updateDelivery(Request $request, $id)
    {

        $result = InvoiceDownload::findorfail($id);
        $result->loc_deliv_date = $request->del_date;
        $result->save();

        /*Send Notification to user*/
        if($result->variant){
            $productname = $result->variant->products->name;
            $var_main = variantname($result->variant);
        }else{
            $productname = $result->simple_product->product_name;
        }
        
        $order_id = $result->order->order_id;
      
        /*Fire Notification*/

        User::find($result
                ->order
                ->user_id)
                ->notify(new LocalPickUpNotification($productname, $var_main = NULL, $order_id));

        /*End*/

        return back()->with('updated', __('Local pickup delivery date updated for this order !'));

    }

}
