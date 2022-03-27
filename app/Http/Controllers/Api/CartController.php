<?php

namespace App\Http\Controllers\Api;

use App\AddSubVariant;
use App\Cart;
use App\Coupan;
use App\Genral;
use App\Http\Controllers\Controller;
use App\ProductAttributes;
use App\ProductValues;
use App\Shipping;
use App\ShippingWeight;
use App\SimpleProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ShippingPrice;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'currency' => 'required|string|min:3|max:3',
            'variantid' => 'sometimes|numeric',
            'simple_pro_id' => 'sometimes|numeric',
            'quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('variantid')) {
                return response()->json(['msg' => $errors->first('variantid'), 'status' => 'fail']);
            }

            if ($errors->first('simple_pro_id')) {
                return response()->json(['msg' => $errors->first('simple_pro_id'), 'status' => 'fail']);
            }

            if ($errors->first('quantity')) {
                return response()->json(['msg' => $errors->first('quantity'), 'status' => 'fail']);
            }

        }

        if ($request->simple_pro_id) {
            return $this->addItemInSimpleProduct();
        }

        $item = Cart::where('variant_id', '=', $request->variantid)
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        $rates = new CurrencyController;

        $rate = $rates->fetchRates($request->currency)->getData();

        $variant = AddSubVariant::find($request->variantid);

        if ($request->variantid && !$variant) {
            return response()->json(['msg' => 'Variant not found !', 'status' => 'fail']);
        }

        if ($request->variantid && $variant->stock < 1) {
            return response()->json(['msg' => 'Sorry ! Item is out of stock currently !', 'status' => 'fail']);
        }

        if ($request->variantid && $request->quantity < $variant->min_order_qty) {
            return response()->json(['msg' => 'For this product you need to add atleast ' . $variant->min_order_qty . ' quantity', 'status' => 'fail']);
        }

        if ($request->variantid && $request->quantity > $variant->max_order_qty) {
            return response()->json(['msg' => 'For this product you can add maximum ' . $variant->max_order_qty . ' quantity', 'status' => 'fail']);
        }

        if ($request->variantid && $request->quantity > $variant->stock) {
            return response()->json(['msg' => 'Product stock limit reached !', 'status' => 'fail']);
        }

        $price = new ProductController;

        $price = $price->getprice($variant->products, $variant)->getData();

        if (isset($item)) {

            $newqty = (int) $item->qty + $request->quantity;
            $item->qty = $newqty;
            $item->price_total = (float) $price->mainprice * $newqty;
            $item->semi_total = (float) $price->offerprice * $newqty;

            $item->shipping = $this->getShipping($newqty, $variant);

            $item->updated_at = now();

            $item->save();

            return response()->json(['msg' => 'Product quantity updated !', 'status' => 'success']);

        } else {

            $cart = new Cart;
            $cart->qty = $request->quantity;
            $cart->user_id = Auth::user()->id;
            $cart->pro_id = $variant->products->id;
            $cart->variant_id = $request->variantid;
            $cart->ori_price = (float) $price->mainprice;
            $cart->ori_offer_price = (float) $price->offerprice;

            $cart->price_total = (float) $price->mainprice * $request->quantity;
            $cart->semi_total = (float) $price->offerprice * $request->quantity;

            $cart->vender_id = $variant->products->vender->id;
            $cart->shipping = $this->getShipping($request->quantity, $variant);
            $cart->created_at = now();
            $cart->updated_at = now();

            $cart->save();

            return response()->json(['msg' => 'Item added to cart successfully !', 'status' => 'success']);

        }

    }

    public function addItemInSimpleProduct()
    {

        $item = Cart::where('simple_pro_id', '=', request()->simple_pro_id)
            ->where('user_id', '=', Auth::user()->id)
            ->first();

        $rates = new CurrencyController;

        $rate = $rates->fetchRates(request()->currency)->getData();

        $product = SimpleProduct::find(request()->simple_pro_id);

        if (!$product) {
            return response()->json(['msg' => 'Product not found !', 'status' => 'fail']);
        }

        if ($product->status != 1) {
            return response()->json(['msg' => 'Product not active !', 'status' => 'fail']);
        }

        if ($product->stock < 1) {
            return response()->json(['msg' => 'Sorry ! Item is out of stock currently !', 'status' => 'fail']);
        }

        if (request()->quantity < $product->min_order_qty) {
            return response()->json(['msg' => 'For this product you need to add atleast ' . $product->min_order_qty . ' quantity', 'status' => 'fail']);
        }

        if (request()->quantity > $product->max_order_qty) {
            return response()->json(['msg' => 'For this product you can add maximum ' . $product->max_order_qty . ' quantity', 'status' => 'fail']);
        }

        if (request()->quantity > $product->stock) {
            return response()->json(['msg' => 'Product stock limit reached !', 'status' => 'fail']);
        }

        if (isset($item)) {

            $newqty = (int) $item->qty + request()->quantity;
            $item->qty = $newqty;
            $item->price_total = (float) $item->ori_price * $newqty;
            $item->semi_total = (float) $item->ori_offer_price * $newqty;

            $item->shipping = shippingprice($item);

            $item->updated_at = now();

            $item->save();

            return response()->json(['msg' => 'Product quantity updated !', 'status' => 'success']);

        } else {

            $cart = new Cart;
            $cart->qty = request()->quantity;
            $cart->user_id = Auth::user()->id;
            $cart->pro_id = null;
            $cart->variant_id = null;

            $cart->simple_pro_id = $product->id;

            $cart->ori_price = (float) $product->price;
            $cart->ori_offer_price = (float) $product->offer_price;

            $cart->price_total = (float) $product->price * request()->quantity;
            $cart->semi_total = (float) $product->offer_price * request()->quantity;

            $cart->vender_id = $product->store->user->id;

            $cart->created_at = now();
            $cart->updated_at = now();

            $cart->save();

            /** Update the shipping once item added in cart */

            $cart->update([
                'shipping' => shippingprice($cart),
            ]);

            return response()->json([

                'msg' => 'Item added to cart successfully !',
                'status' => 'success',

            ]);

        }

    }

    public function getShipping($qty, $variant)
    {
        $shipping = 0;

        if ($variant->products->free_shipping == 0) {

            $free_shipping = Shipping::where('id', $variant->products->shipping_id)->first();

            if (!empty($free_shipping)) {

                if ($free_shipping->name == "Shipping Price") {

                    $weight = ShippingWeight::first();

                    $pro_weight = $variant->weight;

                    if ($weight->weight_to_0 >= $pro_weight) {

                        if ($weight->per_oq_0 == 'po') {
                            $shipping = $shipping + $weight->weight_price_0;
                        } else {
                            $shipping = $shipping + $weight->weight_price_0 * $qty;
                        }

                    } elseif ($weight->weight_to_1 >= $pro_weight) {

                        if ($weight->per_oq_1 == 'po') {
                            $shipping = $shipping + $weight->weight_price_1;
                        } else {
                            $shipping = $shipping + $weight->weight_price_1 * $qty;
                        }

                    } elseif ($weight->weight_to_2 >= $pro_weight) {

                        if ($weight->per_oq_2 == 'po') {
                            $shipping = $shipping + $weight->weight_price_2;
                        } else {
                            $shipping = $shipping + $weight->weight_price_2 * $qty;
                        }

                    } elseif ($weight->weight_to_3 >= $pro_weight) {

                        if ($weight->per_oq_3 == 'po') {
                            $shipping = $shipping + $weight->weight_price_3;
                        } else {
                            $shipping = $shipping + $weight->weight_price_3 * $qty;
                        }

                    } else {

                        if ($weight->per_oq_4 == 'po') {
                            $shipping = $shipping + $weight->weight_price_4;
                        } else {
                            $shipping = $shipping + $weight->weight_price_4 * $qty;
                        }

                    }

                } else {

                    $shipping = $shipping + $free_shipping->price;

                }
            }

        }

        return $shipping;
    }

    public function yourCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'currency' => 'required|string|min:3|max:3',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }
        }

        $rates = new CurrencyController;

        $rate = $rates->fetchRates($request->currency)->getData();

        $cart_free_shipping = Genral::first()->cart_amount;

        if (count($this->cartproducts($request->currency))) {

            if ($cart_free_shipping != 0 || $cart_free_shipping != '') {

                if ($this->cartTotal()->getData()->subtotal * $rate->exchange_rate >= $cart_free_shipping * $rate->exchange_rate) {

                    $shipping = 0;

                } else {
                    $shipping = (double) sprintf("%.2f", $this->cartTotal()->getData()->shipping * $rate->exchange_rate);
                }

            }

            $cart = array(
                'products' => $this->cartproducts($request->currency),
                'subtotal' => (double) sprintf("%.2f", $this->cartTotal()->getData()->subtotal * $rate->exchange_rate),
                'shipping' => $shipping,
                'coupan_discount' => (float) sprintf("%.2f", $this->getTotalDiscount() * $rate->exchange_rate),
                'grand_total' => (double) sprintf("%.2f", $this->cartTotal()->getData()->grandTotal * $rate->exchange_rate),
                'currency' => $rate->code,
                'symbol' => $rate->symbol,
                'appliedCoupan' => $this->appliedCoupan($rate) != null ? $this->appliedCoupan($rate)->getData() : null,
                'offers' => $this->getOffers($rate),
            );

            return response()->json($cart);

        } else {

            return response()->json(['msg' => 'Your cart is empty !', 'status' => 'success']);

        }

    }

    public function cartproducts($currency)
    {

        $rates = new CurrencyController;

        $rate = $rates->fetchRates($currency)->getData();

        $products = array();

        foreach (Auth::user()->cart as $cart) {

            if (isset($cart->variant) && isset($cart->variant->products) && $cart->variant->products->status == 1) {

                $productData = new ProductController;

                $rating = $productData->getproductrating($cart->product);

                $reviews = $productData->getProductReviews($cart->product);

                if ($productData->getprice($cart->product, $cart->variant)->getData()->offerprice != 0) {

                    $mp = sprintf("%.2f", $productData->getprice($cart->product, $cart->variant)->getData()->mainprice * $rate->exchange_rate);
                    $op = sprintf("%.2f", $productData->getprice($cart->product, $cart->variant)->getData()->offerprice * $rate->exchange_rate);

                    $getdisprice = $mp - $op;

                    $discount = $getdisprice / $mp;

                    $offamount = $discount * 100;

                } else {

                    $offamount = 0;

                }

                $products[] = array(
                    'cartid' => $cart->id,
                    'productid' => $cart->product->id,
                    'variantid' => $cart->variant_id,
                    'type' => 'v',
                    'off_in_percent' => (int) round($offamount),
                    'productname' => $cart->product->name,
                    'orignalprice' => (float) sprintf("%.2f", $cart->price_total * $rate->exchange_rate) / $cart->qty,
                    'orignalofferprice' => (float) sprintf("%.2f", $cart->semi_total * $rate->exchange_rate) / $cart->qty,
                    'mainprice' => (float) sprintf("%.2f", $cart->price_total * $rate->exchange_rate),
                    'offerprice' => (float) sprintf("%.2f", $cart->semi_total * $rate->exchange_rate),
                    'qty' => $cart->qty,
                    'rating' => $rating,
                    'review' => count($reviews),
                    'thumbnail_path' => url('variantimages/thumbnails'),
                    'thumbnail' => $cart->variant->variantimages->main_image,
                    'tax_info' => $cart->product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                    'soldby' => $cart->product->store->name,
                    'variant' => $this->variantDetail($cart->variant),
                    'minorderqty' => (int) $cart->variant->min_order_qty,
                    'maxorderqty' => (int) $cart->variant->max_order_qty,
                );

            }

            if (isset($cart->simple_product) && $cart->simple_product->status == 1) {

                if ($cart->simple_product->offer_price != 0) {

                    $mp = $cart->simple_product->price;
                    $op = $cart->simple_product->offer_price;

                    $getdisprice = $mp - $op;

                    $discount = $getdisprice / $mp;

                    $offamount = $discount * 100;

                } else {

                    $offamount = 0;

                }

                $products[] = array(
                    'cartid' => $cart->id,
                    'productid' => $cart->simple_product->id,
                    'variantid' => 0,
                    'type' => 's',
                    'off_in_percent' => (int) round($offamount),
                    'productname' => $cart->simple_product->product_name,
                    'orignalprice' => (float) sprintf("%.2f", $cart->price_total * $rate->exchange_rate) / $cart->qty,
                    'orignalofferprice' => (float) sprintf("%.2f", $cart->semi_total * $rate->exchange_rate) / $cart->qty,
                    'mainprice' => (float) sprintf("%.2f", $cart->price_total * $rate->exchange_rate),
                    'offerprice' => (float) sprintf("%.2f", $cart->semi_total * $rate->exchange_rate),
                    'qty' => $cart->qty,
                    'rating' => simple_product_rating($cart->simple_product->id),
                    'review' => $cart->simple_product->reviews()->where('review', '!=', '')->count(),
                    'thumbnail_path' => url('/images/simple_products/'),
                    'thumbnail' => $cart->simple_product->thumbnail,
                    'tax_info' => __("Inclusive of all taxes"),
                    'soldby' => $cart->simple_product->store->name,
                    'variant' => null,
                    'minorderqty' => (int) $cart->simple_product->min_order_qty,
                    'maxorderqty' => (int) $cart->simple_product->max_order_qty,
                );

            }

        }

        return $products;

    }

    public function cartTotal()
    {

        $totalshipping = $this->calculateShipping();

        $subtotal = 0;

        $rates = new CurrencyController;

        $rate = $rates->fetchRates(request()->currency)->getData();

        foreach (Auth::user()->cart as $cart) {

            if ($cart->semi_total != 0) {

                $subtotal = $subtotal + $cart->semi_total;

            } else {

                $subtotal = $subtotal + $cart->price_total;

            }

        }

        $genrals_settings = Genral::first();

        if ($genrals_settings->cart_amount != 0 || $genrals_settings->cart_amount != '') {

            if ($subtotal * $rate->exchange_rate >= $genrals_settings->cart_amount * $rate->exchange_rate) {

                $totalshipping = 0;

            }

        }

        $grandtotal = ($totalshipping + $subtotal) - $this->getTotalDiscount();

        return response()->json([

            'subtotal' => sprintf("%.2f", $subtotal),
            'grandTotal' => sprintf("%.2f", $grandtotal),
            'shipping' => $totalshipping,

        ]);

    }

    public function calculateShipping()
    {

        $shipping = 0;

        foreach (Auth::user()->cart as $cart) {
            if ($cart->variant && $cart->variant->products && $cart->variant->products->status == 1) {
                $shipping += ShippingPrice::calculateShipping($cart);
            }

            if ($cart->simple_product && $cart->simple_product->status == 1) {
                $shipping += shippingprice($cart);
            }
        }

        return $shipping;

    }

    public function variantDetail($variant)
    {

        $varcount = count($variant->main_attr_value);
        $var_main = '';
        $i = 0;
        $othervariantName = null;

        $variants = null;

        foreach ($variant->main_attr_value as $key => $orivars) {

            $i++;

            $loopgetattrname = ProductAttributes::where('id', $key)->first();
            $getvarvalue = ProductValues::where('id', $orivars)->first();

            $result[] = array(
                'attr_id' => $loopgetattrname['id'],
                'attrribute' => $loopgetattrname['attr_name'],
            );

            $variants[] = array(
                'var_name' => variantname($variant),
                'attr_name' => $loopgetattrname['attr_name'],
                'type' => $loopgetattrname['attr_name'] == 'color' || $loopgetattrname['attr_name'] == 'Color' || $loopgetattrname['attr_name'] == 'colour' || $loopgetattrname['attr_name'] == 'Colour' ? 'c' : 's',
            );

        }

        return $variants;

    }

    public function increaseQuantity(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cartid' => 'required|numeric',
            'currency' => 'required|string|max:3|min:3',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('cartid')) {
                return response()->json(['msg' => $errors->first('cartid'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('quantity')) {
                return response()->json(['msg' => $errors->first('quantity'), 'status' => 'fail']);
            }
        }

        $cartrow = Cart::find($request->cartid);

        if (!$cartrow) {
            return response()->json(['msg' => 'Cart item not found !', 'status' => 'fail']);
        }

        if (isset($cartrow->variant) && isset($cartrow->variant->products) && $cartrow->variant->products->status == 1) {

            $variant = AddSubVariant::find($cartrow->variant_id);

            if (!$variant) {
                return response()->json(['msg' => 'Variant not found !', 'status' => 'fail']);
            }

            if ($variant->stock < 1) {
                return response()->json(['msg' => 'Sorry ! Item is out of stock currently !', 'status' => 'fail']);
            }

            if ($cartrow->qty > $variant->max_order_qty) {
                return response()->json(['msg' => 'Product max qty limit reached !', 'status' => 'fail']);
            }

            if ($request->qty > $variant->stock) {
                return response()->json(['msg' => 'Product stock limit reached !', 'status' => 'fail']);
            }

            if ($request->quantity < $variant->min_order_qty) {
                return response()->json(['msg' => 'For this product you need to add atleast ' . $variant->min_order_qty . ' quantity', 'status' => 'fail']);
            }

            if ($variant->max_order_qty != '') {
                if ($request->quantity > $variant->max_order_qty) {
                    return response()->json(['msg' => 'For this product you can add maximum ' . $variant->max_order_qty . ' quantity', 'status' => 'fail']);
                }
            }

            $price = new ProductController;

            $price = $price->getprice($variant->products, $variant)->getData();

            $cartrow->qty = $request->quantity;

            $cartrow->price_total = (float) $price->mainprice * $request->quantity;
            $cartrow->semi_total = (float) $price->offerprice * $request->quantity;

            $cartrow->shipping = $this->getShipping($request->quantity, $variant);

            $cartrow->updated_at = now();

            $cartrow->save();
        }

        if (isset($cartrow->simple_product) && $cartrow->simple_product->status == 1) {

            if ($cartrow->simple_product->stock < 1) {

                return response()->json([
                    'msg' => 'Sorry ! Item is out of stock currently !',
                    'status' => 'fail',
                ]);

            }

            if ($cartrow->qty > $cartrow->simple_product->max_order_qty) {
                return response()->json(['msg' => 'Product max qty limit reached !', 'status' => 'fail']);
            }

            if ($request->qty > $cartrow->simple_product->stock) {

                return response()->json([
                    'msg' => 'Product stock limit reached !',
                    'status' => 'fail',
                ]);

            }

            if ($request->quantity < $cartrow->simple_product->min_order_qty) {

                return response()->json([
                    'msg' => 'For this product you need to add atleast ' . $cartrow->simple_product->min_order_qty . ' quantity',
                    'status' => 'fail',
                ]);

            }

            if ($cartrow->simple_product->max_order_qty != '') {

                if ($request->quantity > $cartrow->simple_product->max_order_qty) {

                    return response()->json([
                        'msg' => 'For this product you can add maximum ' . $cartrow->simple_product->max_order_qty . ' quantity',
                        'status' => 'fail',
                    ]);

                }

            }

            $cartrow->qty = $request->quantity;

            $cartrow->price_total = (float) $cartrow->ori_price * $cartrow->qty;
            $cartrow->semi_total = (float) $cartrow->ori_offer_price * $cartrow->qty;

            $cartrow->shipping = shippingprice($cartrow);

            $cartrow->updated_at = now();

            $cartrow->save();

        }

        return response()->json($this->yourCart(request())->getData(), 200);
    }

    public function cartItemRemove(Request $request)
    {

        if (Auth::check()) {

            if (!$request->cartid) {
                return response()->json(['msg' => 'Cart id is required', 'status' => 'fail']);
            }

            $row = Cart::find($request->cartid);

            if (!$row) {
                return response()->json(['msg' => 'Cart item not found !', 'status' => 'fail']);
            }

            $row->delete();

            return response()->json(['msg' => 'Item is removed from your cart !', 'status' => 'success']);

        }

    }

    public function clearCart()
    {

        if (Auth::check()) {

            auth()->user()->cart()->delete();

            return response()->json(['msg' => 'Cart is now empty !', 'status' => 'success']);

        } else {
            return response()->json(['msg' => 'Log in to continue...', 'status' => 'success']);
        }

    }

    public function getTotalDiscount()
    {

        $totaldiscount = 0;

        foreach (Auth::user()->cart as $cart) {

            if ($cart->semi_total != 0) {

                $totaldiscount = $totaldiscount + $cart->disamount;

            } else {

                $totaldiscount = $totaldiscount + $cart->disamount;

            }

        }

        return sprintf("%.2f", $totaldiscount);
    }

    public function getOffers($rate)
    {

        $content = array();

        foreach (auth()->user()->cart as $cart) {

            if (isset($cart->variant) && isset($cart->variant->products) && $cart->variant->products->status == 1) {

                $coupans = Coupan::where('link_by', 'cart')
                    ->whereDate('expirydate', '>=', Carbon::now())
                    ->get();

                if ($cart->variant && $cart->variant->products && $cart->variant->products->status == 1) {

                    $productcoupans = Coupan::where('pro_id', $cart->product->id)
                        ->whereDate('expirydate', '>=', Carbon::now())
                        ->get();

                }

                $productcategorycoupans = Coupan::where('cat_id', $cart->product->category_id)
                    ->get();

                $content = array();

                foreach ($coupans as $c) {

                    if ($c->maxusage != 0) {

                        if ($c->pro_id != null) {

                            $linkedto = array(
                                'id' => $c->product->id,
                                'name' => $c->product->getTranslations('name'),
                                'appliedon' => $c->link_by,
                            );

                        } elseif ($c->cat_id != null) {

                            $linkedto = array(

                                'id' => $c->cate->id,
                                'name' => $c->cate->getTranslations('title'),
                                'appliedon' => $c->link_by,
                            );

                        } else {
                            $linkedto = null;
                        }

                        $content[] = array(
                            'coupanid' => $c->id,
                            'code' => $c->code,
                            'discount' => $c->distype == 'fix' ? (float) sprintf("%.2f", $c->amount * $rate->exchange_rate) : (int) $c->amount,
                            'discount_type' => $c->distype,
                            'minamount' => (float) sprintf("%.2f", $c->minamount * $rate->exchange_rate),
                            'is_login' => $c->is_login,
                            'description' => $c->description,
                            'linked_to' => $linkedto,
                            'offertext' => $this->findOfferText($c, $rate)->getData()->offerText != '' ? $this->findOfferText($c, $rate)->getData()->offerText : null,
                            'validationtext' => $this->findOfferText($c, $rate)->getData()->validationText != null ? $this->findOfferText($c, $rate)->getData()->validationText : null,
                        );

                    }
                }

                foreach ($productcoupans as $c1) {

                    if ($c1->pro_id != null) {

                        $linkedto = array(
                            'id' => $c1->product->id,
                            'name' => $c1->product->getTranslations('name'),
                            'appliedon' => $c1->link_by,
                        );

                    } elseif ($c1->cat_id != null) {

                        $linkedto = array(

                            'id' => $c1->cate->id,
                            'name' => $c1->cate->getTranslations('title'),
                            'appliedon' => $c1->link_by,
                        );

                    } else {
                        $linkedto = null;
                    }

                    $content[] = array(
                        'coupanid' => $c1->id,
                        'code' => $c1->code,
                        'discount' => $c1->distype == 'fix' ? (float) sprintf("%.2f", $c1->amount * $rate->exchange_rate) : (int) $c1->amount,
                        'discount_type' => $c1->distype,
                        'minamount' => (float) sprintf("%.2f", $c1->minamount * $rate->exchange_rate),
                        'is_login' => $c1->is_login,
                        'description' => $c1->description,
                        'linked_to' => $linkedto,
                        'offertext' => $this->findOfferText($c1, $rate)->getData()->offerText != '' ? $this->findOfferText($c1, $rate)->getData()->offerText : null,
                        'validationtext' => $this->findOfferText($c1, $rate)->getData()->validationText != null ? $this->findOfferText($c1, $rate)->getData()->validationText : null,
                    );

                }

                foreach ($productcategorycoupans as $c2) {

                    if ($c2->pro_id != null) {

                        $linkedto = array(
                            'id' => $c2->product->id,
                            'name' => $c2->product->getTranslations('name'),
                            'appliedon' => $c2->link_by,
                        );

                    } elseif ($c2->cat_id != null) {

                        $linkedto = array(

                            'id' => $c2->cate->id,
                            'name' => $c2->cate->getTranslations('title'),
                            'appliedon' => $c2->link_by,
                        );

                    } else {
                        $linkedto = null;
                    }

                    $content[] = array(
                        'coupanid' => $c2->id,
                        'code' => $c2->code,
                        'discount' => $c2->distype == 'fix' ? (float) sprintf("%.2f", $c2->amount * $rate->exchange_rate) : (int) $c2->amount,
                        'discount_type' => $c2->distype,
                        'minamount' => (float) sprintf("%.2f", $c2->minamount * $rate->exchange_rate),
                        'is_login' => $c2->is_login,
                        'description' => $c2->description,
                        'linked_to' => $linkedto,
                        'offertext' => $this->findOfferText($c2, $rate)->getData()->offerText != '' ? $this->findOfferText($c2, $rate)->getData()->offerText : null,
                        'validationtext' => $this->findOfferText($c2, $rate)->getData()->validationText != null ? $this->findOfferText($c2, $rate)->getData()->validationText : null,
                    );

                }
            }

            if (isset($cart->simple_product) && $cart->simple_product->status == 1) {

                $simple_products_coupans = Coupan::where('simple_pro_id', $cart->simple_product->id)
                    ->whereDate('expirydate', '>=', Carbon::now())
                    ->get();

                if (isset($simple_products_coupans)) {

                    foreach ($simple_products_coupans as $sc1) {

                        if ($sc1->simple_product != null) {

                            $linkedto = array(
                                'id' => $sc1->simple_product->id,
                                'name' => $sc1->simple_product->getTranslations('product_name'),
                                'appliedon' => $sc1->link_by,
                            );

                        } elseif ($sc1->cat_id != null) {

                            $linkedto = array(

                                'id' => $sc1->cate->id,
                                'name' => $sc1->cate->getTranslations('title'),
                                'appliedon' => $sc1->link_by,
                            );

                        } else {
                            $linkedto = null;
                        }

                        $content[] = array(
                            'coupanid' => $sc1->id,
                            'code' => $sc1->code,
                            'discount' => $sc1->distype == 'fix' ? (float) sprintf("%.2f", $sc1->amount * $rate->exchange_rate) : (int) $sc1->amount,
                            'discount_type' => $sc1->distype,
                            'minamount' => (float) sprintf("%.2f", $sc1->minamount * $rate->exchange_rate),
                            'is_login' => $sc1->is_login,
                            'description' => $sc1->description,
                            'linked_to' => $linkedto,
                            'offertext' => $this->findOfferText($sc1, $rate)->getData()->offerText != '' ? $this->findOfferText($sc1, $rate)->getData()->offerText : null,
                            'validationtext' => $this->findOfferText($sc1, $rate)->getData()->validationText != null ? $this->findOfferText($sc1, $rate)->getData()->validationText : null,
                        );

                    }
                }

                $simpleproductcategorycoupans = Coupan::where('cat_id', $cart->simple_product->category_id)
                    ->get();

                foreach ($simpleproductcategorycoupans as $sc2) {

                    if ($sc2->simple_pro_id != null) {

                        $linkedto = array(
                            'id' => $sc2->simple_product->id,
                            'name' => $sc2->simple_product->getTranslations('product_name'),
                            'appliedon' => $sc2->link_by,
                        );

                    } elseif ($sc2->cat_id != null) {

                        $linkedto = array(

                            'id' => $sc2->cate->id,
                            'name' => $sc2->cate->getTranslations('title'),
                            'appliedon' => $sc2->link_by,
                        );

                    } else {
                        $linkedto = null;
                    }

                    $content[] = array(
                        'coupanid' => $sc2->id,
                        'code' => $sc2->code,
                        'discount' => $sc2->distype == 'fix' ? (float) sprintf("%.2f", $sc2->amount * $rate->exchange_rate) : (int) $sc2->amount,
                        'discount_type' => $sc2->distype,
                        'minamount' => (float) sprintf("%.2f", $sc2->minamount * $rate->exchange_rate),
                        'is_login' => $sc2->is_login,
                        'description' => $sc2->description,
                        'linked_to' => $linkedto,
                        'offertext' => $this->findOfferText($sc2, $rate)->getData()->offerText != '' ? $this->findOfferText($sc2, $rate)->getData()->offerText : null,
                        'validationtext' => $this->findOfferText($sc2, $rate)->getData()->validationText != null ? $this->findOfferText($sc2, $rate)->getData()->validationText : null,
                    );

                }

            }

        }

        return $content = array_unique($content, SORT_REGULAR);

    }

    public function findOfferText($c, $rate)
    {

        $offerText = array();

        $validationText = array();

        if ($c->distype == 'fix') {

            $offerText[]['text'] = 'Get flat ' . $rate->symbol . sprintf("%.2f", $c->amount * $rate->exchange_rate) . ' off';

        }

        if ($c->distype == 'per') {
            $offerText[]['text'] = 'Get ' . $c->amount . '% off';
        }

        if ($c->minamount != null) {
            $validationText[]['text'] = 'Valid on orders above ' . $rate->symbol . sprintf("%.2f", $c->minamount * $rate->exchange_rate);
        }

        if ($c->is_login == 1) {

            $validationText[]['text'] = 'Offer applicable for registered users only.';
        }

        return response()->json([
            'c' => $c,
            'offerText' => $offerText,
            'validationText' => $validationText,
        ]);

    }

    public function appliedCoupan($rate)
    {

        $cpn = Cart::getCoupanDetail();

        if ($cpn) {

            if ($cpn->pro_id != null) {

                $linkedto = array(
                    'id' => $cpn->product->id,
                    'name' => $cpn->product->getTranslations('name'),
                    'appliedon' => $cpn->link_by,
                );

            } elseif ($cpn->cat_id != null) {

                $linkedto = array(

                    'id' => $cpn->cate->id,
                    'name' => $cpn->cate->getTranslations('title'),
                    'appliedon' => $cpn->link_by,
                );

            } else {
                $linkedto = null;
            }

            $offerText = array();

            $validationText = array();

            if ($cpn->distype == 'fix') {

                $offerText[]['text'] = 'Get flat ' . $rate->symbol . sprintf("%.2f", $cpn->amount * $rate->exchange_rate) . ' off';

            }

            if ($cpn->distype == 'per') {
                $offerText[]['text'] = 'Get ' . $cpn->amount . '% off';
            }

            if ($cpn->minamount != null) {
                $validationText[]['text'] = 'Valid on orders above ' . $rate->symbol . sprintf("%.2f", $cpn->minamount * $rate->exchange_rate);
            }

            if ($cpn->is_login == 1) {

                $validationText[]['text'] = 'Offer applicable for registered users only.';
            }

            return response()->json([
                'coupanid' => $cpn->id,
                'code' => $cpn->code,
                'discount' => $cpn->distype == 'fix' ? (float) sprintf("%.2f", $cpn->amount * $rate->exchange_rate) : (int) $cpn->amount,
                'discount_type' => $cpn->distype,
                'minamount' => (float) sprintf("%.2f", $cpn->minamount * $rate->exchange_rate),
                'is_login' => $cpn->is_login,
                'description' => $cpn->description,
                'linked_to' => $linkedto,
                'offertext' => $offerText,
                'validationText' => $validationText,
            ]);
        }
    }

    public function guestCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'currency' => 'required|string|min:3|max:3',
            'cart' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('cart')) {
                return response()->json(['msg' => $errors->first('cart'), 'status' => 'fail']);
            }
        }

        $rates = new CurrencyController;

        $rate = $rates->fetchRates($request->currency)->getData();

        if ($request->cart) {

            $cart = array(

                'products'      => $this->guestcartproducts($request),
                'subtotal'      => (double) sprintf("%.2f", $this->guestcartTotal()->getData()->subtotal * $rate->exchange_rate),
                'shipping'      => (double) sprintf("%.2f", $this->guestcartTotal()->getData()->shipping * $rate->exchange_rate),
                'grand_total'   => (double) sprintf("%.2f", $this->guestcartTotal()->getData()->grandTotal * $rate->exchange_rate),
                'currency'      => $rate->code,
                'symbol'        => $rate->symbol

            );

            return response()->json($cart);

        } else {

            return response()->json([
                'msg'       => 'Your cart is empty !', 
                'status'    => 'success'
            ]);

        }
    }

    public function guestcartproducts()
    {

        $rates = new CurrencyController;

        $rate = $rates->fetchRates(request()->currency)->getData();

        $products = array();

        

        foreach (request()->cart as $cart) {
            

            $qty = $cart['quantity'];

            if (isset($cart['variantid'])) {

                $variantid = $cart['variantid'];
                

                $productData = new ProductController;

                $variant = AddSubVariant::find($variantid);

                if (isset($variant)) {

                    $rating = $productData->getproductrating($variant->products);

                    $reviews = $productData->getProductReviews($variant->products);

                    if ($productData->getprice($variant->products, $variant)->getData()->offerprice != 0) {

                        $mp = sprintf("%.2f", $productData->getprice($variant->products, $variant)->getData()->mainprice * $rate->exchange_rate);
                        $op = sprintf("%.2f", $productData->getprice($variant->products, $variant)->getData()->offerprice * $rate->exchange_rate);

                        $getdisprice = $mp - $op;

                        $discount = $getdisprice / $mp;

                        $offamount = $discount * 100;

                    } else {

                        $offamount = 0;

                    }

                    $products[] = array(
                        'productid' => $variant->products->id,
                        'variantid' => $variantid,
                        'off_in_percent' => (int) round($offamount),
                        'productname' => $variant->products->name,
                        'orignalprice' => (float) sprintf("%.2f", $productData->getprice($variant->products, $variant)->getData()->mainprice * $rate->exchange_rate) / $qty,
                        'orignalofferprice' => (float) sprintf("%.2f", $productData->getprice($variant->products, $variant)->getData()->offerprice * $rate->exchange_rate) / $qty,
                        'mainprice' => (float) sprintf("%.2f", $productData->getprice($variant->products, $variant)->getData()->mainprice * $rate->exchange_rate) * $qty,
                        'offerprice' => (float) sprintf("%.2f", $productData->getprice($variant->products, $variant)->getData()->offerprice * $rate->exchange_rate) * $qty,
                        'qty' => $qty,
                        'rating' => $rating,
                        'review' => count($reviews),
                        'thumbnail_path' => url('variantimages/thumbnails'),
                        'thumbnail' => $variant->variantimages->main_image,
                        'tax_info' => $variant->products->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                        'soldby' => $variant->products->store->name,
                        'variant' => $this->variantDetail($variant),
                        'minorderqty' => (int) $variant->min_order_qty,
                        'maxorderqty' => (int) $variant->max_order_qty,
                    );
                }
            }

            if(isset($cart['simple_pro_id'])){

                $sp = SimpleProduct::find($cart['simple_pro_id']);

                if ($sp->offer_price != 0) {

                    $mp = $sp->price;
                    $op = $sp->offer_price;

                    $getdisprice = $mp - $op;

                    $discount = $getdisprice / $mp;

                    $offamount = $discount * 100;

                } else {

                    $offamount = 0;

                }

                $products[] = array(
                    'productid'         => $sp->id,
                    'variantid'         => 0,
                    'type'              => 's',
                    'off_in_percent'    => (int) round($offamount),
                    'productname'       => $sp->product_name,
                    'orignalprice'      => (float) sprintf("%.2f", $sp->price * $rate->exchange_rate),
                    'orignalofferprice' => (float) sprintf("%.2f", $sp->offer_price * $rate->exchange_rate),
                    'mainprice'         => (float) sprintf("%.2f", ($sp->price * $rate->exchange_rate) * $qty),
                    'offerprice'        => (float) sprintf("%.2f", ($sp->offer_price  * $rate->exchange_rate) * $qty),
                    'qty'               => $qty,
                    'rating'            => simple_product_rating($sp->id),
                    'review'            => $sp->reviews()->where('review', '!=', '')->count(),
                    'thumbnail_path'    => url('/images/simple_products/'),
                    'thumbnail'         => $sp->thumbnail,
                    'tax_info'          => __("Inclusive of all taxes"),
                    'soldby'            => $sp->store->name,
                    'variant'           => null,
                    'minorderqty'       => (int) $sp->min_order_qty,
                    'maxorderqty'       => (int) $sp->max_order_qty,
                );


            }

        }

        return $products;

    }

    public function guestCartStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'currency' => 'required|string|min:3|max:3',
            'cart'   => 'required'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('cart')) {
                return response()->json(['msg' => $errors->first('cart'), 'status' => 'fail']);
            }
        }

        if ($request->cart) {

            foreach ($request->cart as $cart) {

                if (isset($cart['variantid'])) {
                    $variantid = $cart['variantid'];
                    $qty = $cart['quantity'];

                    $item = Cart::where('variant_id', '=', $variantid)->where('user_id', '=', Auth::user()->id)->first();

                    $variant = AddSubVariant::find($variantid);

                    $price = new ProductController;

                    $price = $price->getprice($variant->products, $variant)->getData();

                    if (isset($item)) {

                        $newqty = (int) $item->qty + $qty;
                        $item->qty = $newqty;
                        $item->price_total = (float) $price->mainprice * $newqty;
                        $item->semi_total = (float) $price->offerprice * $newqty;

                        $item->shipping = $this->getShipping($newqty, $variant);

                        $item->updated_at = now();

                        $item->save();

                        return response()->json([

                            'msg' => 'Items quantity updated in cart successfully !', 
                            'status' => 'success'

                        ]);

                    } else {

                        $cart = new Cart;
                        $cart->qty = $qty;
                        $cart->user_id = Auth::user()->id;
                        $cart->pro_id = $variant->products->id;
                        $cart->variant_id = $variantid;

                        $cart->ori_price = (float) $price->mainprice;
                        $cart->ori_offer_price = (float) $price->offerprice;

                        $cart->price_total = (float) $price->mainprice * $qty;
                        $cart->semi_total = (float) $price->offerprice * $qty;

                        $cart->vender_id = $variant->products->vender->id;
                        $cart->shipping = $this->getShipping($qty, $variant);
                        $cart->created_at = now();
                        $cart->updated_at = now();

                        $cart->save();

                    }
                }

                if (isset($cart['simple_pro_id'])) {
                    
                    $pro_id = $cart['simple_pro_id'];
                    
                    $qty  = $cart['quantity'];

                    $item = Cart::where('simple_pro_id', '=', $pro_id)
                                ->where('user_id', '=', Auth::user()->id)
                                ->first();

                    $product = SimpleProduct::find($pro_id);

                    if(!isset($product)){

                        return response()->json([

                            'msg'       => 'Product not found!', 
                            'status'    => 'success'

                        ]);

                    }

                    if (isset($item)) {

                        $newqty                 = (int) $item->qty + $qty;
                        $item->qty              = $newqty;
                        $item->price_total      = (float) $product->price * $newqty;
                        $item->semi_total       = (float) $product->offer_price * $newqty;

                        $item->updated_at = now();

                        $item->save();

                        $item->update([
                            'shipping' => shippingprice($item)
                        ]);

                        return response()->json([

                            'msg' => 'Items quantity updated in cart successfully !', 
                            'status' => 'success'

                        ]);

                    } else {

                        $cart = new Cart;
                        $cart->qty              = $qty;
                        $cart->user_id          = Auth::user()->id;
                        $cart->pro_id           = NULL;
                        $cart->variant_id       = NULL;

                        $cart->simple_pro_id    = $product->id;

                        $cart->ori_price        = (float) $product->price;
                        $cart->ori_offer_price  = (float) $product->offer_price;

                        $cart->price_total      = (float) $product->price * $qty;
                        $cart->semi_total       = (float) $product->offer_price * $qty;

                        $cart->vender_id        = $product->store->id;
                        $cart->created_at       = now();
                        $cart->updated_at       = now();

                        $cart->save();

                        $cart->update([
                            'shipping' => shippingprice($cart)
                        ]);

                    }

                }

            }

            return response()->json(['msg' => 'Items added to cart successfully !', 'status' => 'success']);

        } else {

            return response()->json(['msg' => 'Empty data cannot be stored !', 'status' => 'fail']);

        }

    }

    public function guestcartTotal()
    {

       
        $totalshipping = +$this->guestCartCalculateShipping();

        $subtotal = 0;

        $subtotal = 0;

        foreach (request()->cart as $cart) {

            if (isset($cart['variantid'])) {

                $variantid = $cart['variantid'];
                $qty = $cart['quantity'];

                $productData = new ProductController;

                $variant = AddSubVariant::find($variantid);

                if (isset($variant)) {

                    if ($variant->products->offer_price != 0) {

                        $subtotal = $subtotal + (float) sprintf("%.2f", $productData->getprice($variant->products, $variant)->getData()->offerprice * $qty);

                    } else {

                        $subtotal = $subtotal + (float) sprintf("%.2f", $productData->getprice($variant->products, $variant)->getData()->mainprice * $qty);

                    }

                }
            }

        }

        $grandtotal = ($totalshipping + $subtotal);

        return response()->json([

            'subtotal'      => sprintf("%.2f", $subtotal),
            'grandTotal'    => sprintf("%.2f", $grandtotal),
            'shipping'      => $totalshipping,

        ]);

    }

    public function guestCartCalculateShipping()
    {
        $shipping = 0;

        foreach (request()->cart as $cart) {

            if (isset($cart['variantid'])) {

                $variantid  = $cart['variantid'];
                $qty        = $cart['quantity'];

                $variant = AddSubVariant::find($variantid);

                if (isset($variant) && isset($variant->products)) {

                    if ($variant->products->free_shipping == '0') {

                        $free_shipping = Shipping::where('default_status', '=', '1')->first();

                        if (!empty($free_shipping)) {

                            if ($free_shipping->name == "Shipping Price") {

                                $weight = ShippingWeight::first();
                                $pro_weight = $variant->weight;

                                if ($weight->weight_to_0 >= $pro_weight) {

                                    if ($weight->per_oq_0 == 'po') {

                                        $shipping += $weight->weight_price_0;

                                    } else {

                                        $shipping += $weight->weight_price_0 * $qty;

                                    }

                                } elseif ($weight->weight_to_1 >= $pro_weight) {

                                    if ($weight->per_oq_1 == 'po') {

                                        $shipping += $weight->weight_price_1;

                                    } else {

                                        $shipping += $weight->weight_price_1 * $qty;

                                    }

                                } elseif ($weight->weight_to_2 >= $pro_weight) {

                                    if ($weight->per_oq_2 == 'po') {

                                        $shipping += $weight->weight_price_2;

                                    } else {

                                        $shipping += $weight->weight_price_2 * $qty;

                                    }

                                } elseif ($weight->weight_to_3 >= $pro_weight) {

                                    if ($weight->per_oq_3 == 'po') {

                                        $shipping += $weight->weight_price_3;

                                    } else {

                                        $shipping += $weight->weight_price_3 * $qty;

                                    }

                                } else {

                                    if ($weight->per_oq_4 == 'po') {

                                        $shipping += $weight->weight_price_4;

                                    } else {

                                        $shipping += $weight->weight_price_4 * $qty;

                                    }

                                }

                            } else {

                                $shipping += $free_shipping->price;

                            }
                        }
                    }

                }
            }

            if (isset($cart['simple_pro_id'])) {

                $sp = SimpleProduct::find($cart['simple_pro_id']);

                if (isset($sp)) {

                    if ($sp->free_shipping == '0') {
        
                        $free_shipping = Shipping::where('default_status', '=', '1')->first();
        
                        if (isset($free_shipping)) {
        
                            if ($free_shipping->name == "Shipping Price") {
        
                                $weight = ShippingWeight::first();

                                $pro_weight = $sp->weight;

                                if ($weight->weight_to_0 >= $pro_weight) {
                                    if ($weight->per_oq_0 == 'po') {
                                        $shipping += $weight->weight_price_0;
                                    } else {
                                        $shipping += $weight->weight_price_0 * $cart['quantity'];
                                    }
                                    
                                } elseif ($weight->weight_to_1 >= $pro_weight) {
                                    if ($weight->per_oq_1 == 'po') {
                                        $shipping += $weight->weight_price_1;
                                    } else {
                                        $shipping += $weight->weight_price_1 * $cart['quantity'];
                                    }
                                } elseif ($weight->weight_to_2 >= $pro_weight) {
                                    if ($weight->per_oq_2 == 'po') {
                                        $shipping += $weight->weight_price_2;
                                    } else {
                                        $shipping += $weight->weight_price_2 * $cart['quantity'];
                                    }
                                } elseif ($weight->weight_to_3 >= $pro_weight) {
                                    if ($weight->per_oq_3 == 'po') {
                                        $shipping += $weight->weight_price_3;
                                    } else {
                                        $shipping += $weight->weight_price_3 * $cart['quantity'];
                                    }
                                } else {
                                    if ($weight->per_oq_4 == 'po') {
                                        $shipping += $weight->weight_price_4;
                                    } else {
                                        $shipping += $weight->weight_price_4 * $cart['quantity'];
                                    }
        
                                }
        
                            } else {
        
                                $shipping += $free_shipping->price;
        
                            }
                        }
                    }

                }
                
            }

        }

        return $shipping;
    }

}
