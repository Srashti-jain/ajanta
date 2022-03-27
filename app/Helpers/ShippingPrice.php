<?php

class ShippingPrice
{
    public static function calculateShipping($cart)
    {

        $shipping = 0;


        if ($cart->variant && $cart->product && $cart->product->free_shipping == 0) {

            $free_shipping = App\Shipping::where('id', $cart->product->shipping_id)->first();

            if (!empty($free_shipping)) {

                if ($free_shipping->name == "Shipping Price") {

                    $weight = App\ShippingWeight::first();
                    $pro_weight = $cart->variant->weight;
                    if ($weight->weight_to_0 >= $pro_weight) {
                        if ($weight->per_oq_0 == 'po') {
                            $shipping = $shipping + $weight->weight_price_0;
                        } else {
                            $shipping = $shipping + $weight->weight_price_0 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_1 >= $pro_weight) {
                        if ($weight->per_oq_1 == 'po') {
                            $shipping = $shipping + $weight->weight_price_1;
                        } else {
                            $shipping = $shipping + $weight->weight_price_1 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_2 >= $pro_weight) {
                        if ($weight->per_oq_2 == 'po') {
                            $shipping = $shipping + $weight->weight_price_2;
                        } else {
                            $shipping = $shipping + $weight->weight_price_2 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_3 >= $pro_weight) {
                        if ($weight->per_oq_3 == 'po') {
                            $shipping = $shipping + $weight->weight_price_3;
                        } else {
                            $shipping = $shipping + $weight->weight_price_3 * $cart->qty;
                        }
                    } else {
                        if ($weight->per_oq_4 == 'po') {
                            $shipping = $shipping + $weight->weight_price_4;
                        } else {
                            $shipping = $shipping + $weight->weight_price_4 * $cart->qty;
                        }

                    }

                } else {
                        
                    $shipping = $free_shipping->price;

                }
            }
        }

        return $shipping;
    }
}
