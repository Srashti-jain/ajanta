<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\AddOn;
use App\Admin;
use App\Branch;
use App\Category;
use App\Subcategory;
use App\Product;
use App\Order;
use App\OrderDetail;
use App\Grandcategory;
use App\SimpleProduct;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\CentralLogics\translate;

class POSController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category_id', 0);
        $categories = Subcategory::active()->get();
        $keyword = $request->keyword;
        $key = explode(' ', $keyword);
        $grand_category = DB::table('grandcategories')->where('status', '1')->get();
        
        $products = DB::table('simple_products')->
        when($request->has('category_id') && $request['category_id'] != 0, function ($query) use ($request) {
            $query->where('subcategory_id', [[['id' => (string)$request['category_id']]]]);
        })
        ->where('status', '1')->get();
        $set_array = [];
        $small_array = [];
        foreach($grand_category as $g_category){
             if($g_category->title != ''){
                  $set_status = 0;
                 foreach($products as $key => $product_data){
                    //  if($cate)
                    // print_r($product_data->price);die;
                    if($product_data->child_id == $g_category->id){
                        $set_array[$g_category->id][$product_data->id] = $product_data;
                        // if($key == 1){
                            $g_category_title = json_decode($g_category->title, true)['en'];
                            // print_r($g_category->title);die;
                            $small_array[$g_category->id]['name'] = $g_category_title;
                            $small_array[$g_category->id]['img'] = $product_data->thumbnail;
                             if($product_data->stock >= 1){
                                $small_array[$g_category->id]['set_status'] = $set_status + 1;
                            }
                        // }
                        $small_array[$g_category->id]['id'] = $g_category->id;
                        $small_array[$g_category->id]['subcategory_id'] = $product_data->subcategory_id;
                        if($product_data->offer_price <= 0){
                            $small_array[$g_category->id]['tot_price'] = @$small_array[$g_category->id]['tot_price'] + $product_data->price;
                        }else{
                            $small_array[$g_category->id]['tot_price'] = @$small_array[$g_category->id]['tot_price'] + $product_data->offer_price;
                        }
                       
                        $small_array[$g_category->id]['tot_tax'] = @$small_array[$g_category->id]['tot_tax'] + $product_data->tax;
                       
                    }
                    
                 }
             }
        }

        // print_r(($request->session()->get('book_remove')));die;
        //   print_r($small_array);die;
        $set_array = $products;
        // $current_branch = Admin::find(auth('admin')->id());
        // $branches = Branch::select('id', 'name')->get();
        return view('admin.pos.index', compact('categories', 'products', 'category', 'keyword','small_array'));
    }

    public function quick_view(Request $request)
    {
        // $product = Product::findOrFail($request->product_id);
        $products = DB::table('simple_products')->
        when($request->has('product_id') && $request['product_id'] != 0, function ($query) use ($request) {
            $query->where('child_id', [[['child_id' => (string)$request['product_id']]]]);
        })
        ->when($request->has('sub_cat') && $request['sub_cat'] != 0, function ($query) use ($request) {
            $query->where('subcategory_id', [[['subcategory_id' => (string)$request['sub_cat']]]]);
        })
        ->where('status', '1')->where('stock','>=', '1')->get();
        $small_array = [];
        foreach($products as $key => $product_data){
                // $g_category_title = json_decode($product_data->title, true)['en'];
                $small_array['name'] = $request['set_name'];
                $small_array['img'] = $product_data->thumbnail;
                $small_array['id'] = $request['product_id'];
                $small_array['subcategory_id'] = $product_data->subcategory_id;
                if($product_data->offer_price <= 0){
                    $small_array['tot_price'] = @$small_array['tot_price'] + $product_data->price;
                }else{
                    $small_array['tot_price'] = @$small_array['tot_price'] + $product_data->offer_price;
                }
               
                $small_array['tot_tax'] = @$small_array['tot_tax'] + $product_data->tax;

         }

         $product = $small_array;
        //  print_r($small_array);die;
        return response()->json([
            'success' => 1,
            'view' => view('admin.pos._quick-view-data', compact('product'))->render(),
        ]);
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;
        $price = 0;
        $addon_price = 0;

        foreach (json_decode($product->choice_options) as $key => $choice) {
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        if ($request['addon_id']) {
            foreach ($request['addon_id'] as $id) {
                $addon_price += $request['addon-price' . $id] * $request['addon-quantity' . $id];
            }
        }

        if ($str != null) {
            $count = count(json_decode($product->variations));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variations)[$i]->type == $str) {
                    $price = json_decode($product->variations)[$i]->price - Helpers::discount_calculate($product, $product->price);
                }
            }
        } else {
            $price = $product->price - Helpers::discount_calculate($product, $product->price);
        }

        return array('price' => ($price * $request->quantity) + $addon_price);
    }

    public function get_customers(Request $request)
    {
        $key = explode(' ', $request['q']);
        $data = DB::table('users')
            ->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%")
                        ->orWhere('phone', 'like', "%{$value}%");
                }
            })
            ->whereNotNull(['f_name', 'l_name', 'phone'])
            ->limit(8)
            ->get([DB::raw('id, CONCAT(f_name, " ", l_name, " (", phone ,")") as text')]);

        $data[] = (object)['id' => false, 'text' => translate('walk_in_customer')];

        return response()->json($data);
    }

    public function update_tax(Request $request)
    {
        if ($request->tax < 0) {
            Toastr::error(translate('Tax_can_not_be_less_than_0_percent'));
            return back();
        } elseif ($request->tax > 100) {
            Toastr::error(translate('Tax_can_not_be_more_than_100_percent'));
            return back();
        }

        $cart = $request->session()->get('cart1', collect([]));
        $cart['tax'] = $request->tax;
        $request->session()->put('cart1', $cart);
        return back();
    }

    public function update_discount(Request $request)
    {
        if ($request->type == 'percent' && $request->discount < 0) {
            Toastr::error(translate('Extra_discount_can_not_be_less_than_0_percent'));
            return back();
        } elseif ($request->type == 'percent' && $request->discount > 100) {
            Toastr::error(translate('Extra_discount_can_not_be_more_than_100_percent'));
            return back();
        }

        $cart = $request->session()->get('cart1', collect([]));
        $cart['extra_discount_type'] = $request->type;
        $cart['extra_discount'] = $request->discount;

        $request->session()->put('cart1', $cart);
        return back();
    }

    public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('cart1', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request) {
            if ($key == $request->key) {
                $object['quantity'] = $request->quantity;
            }
            return $object;
        });
        $request->session()->put('cart1', $cart);
        return response()->json([], 200);
    }

    public function addToCart(Request $request)
    {
        // print_r($request);die;
        $products = DB::table('simple_products')->
        when($request->has('id') && $request['id'] != 0, function ($query) use ($request) {
            $query->where('child_id', [[['child_id' => (string)$request['id']]]]);
        })
        ->when($request->has('subcategory') && $request['subcategory'] != 0, function ($query) use ($request) {
            $query->where('subcategory_id', [[['subcategory_id' => (string)$request['subcategory']]]]);
        })
        ->where('status', '1')->where('stock','>=', '1')->get();

        $set_editable = Grandcategory::find($request['id']);
        // print_r($set_editable->set_editable);die;
        $small_array = [];
        $set_array_list = [];
        $remove_single_from_set = 0;
        if($request->has('single_p_id') && $request['single_p_id'] != 0){
            $remove_single_from_set = $request['single_p_id'];
            
        }
        
        $deleted_array = [];
        $data_id = [];
        foreach($products as $key => $product_data){
            if($remove_single_from_set != 0){
                if ($request->session()->has('cart1')) {
                    if (count($request->session()->get('cart1')) > 0) {
                        foreach ($request->session()->get('cart1') as $key => $cartItem) {
                            if (is_array($cartItem) && $cartItem['id'] == $request['id'] && $cartItem['variant'] == $request['subcategory']) { 
                                $cart = $request->session()->get('cart1', collect([]));
                                $cart->forget($request->session_key);
                                if (!empty($request->session()->get('book_remove.'.$request['id'].'.'.$request['subcategory']))) {
                                        $data_id = $request->session()->get('book_remove.'.$request['id'].'.'.$request['subcategory']);
                                }
                                array_push($data_id,$remove_single_from_set);
                                $request->session()->put('book_remove.'.$request['id'].'.'.$request['subcategory'], $data_id);
                            }
                        }
                    }
                }
                // print_r($request->session()->get('book_remove'));die;
                if(!in_array($product_data->id, $request->session()->get('book_remove')[$request['id']][$request['subcategory']])){
                $set_array_list[$key]['name'] =  json_decode($product_data->product_name, true)['en'];
                $set_array_list[$key]['product_id'] =  $product_data->id;
                $set_array_list[$key]['price'] =  $product_data->price;
                $set_array_list[$key]['offer_price'] =  $product_data->offer_price;
                $set_array_list[$key]['tax'] =  $product_data->tax;
                $set_array_list[$key]['single_product_id'] =  $product_data->id;
                $set_array_list[$key]['set_editable'] = $set_editable->set_editable;
                // $g_category_title = json_decode($product_data->title, true)['en'];
                $small_array['name'] = $request['set_name'];
                $small_array['img'] = $product_data->thumbnail;
                $small_array['id'] = $request['id'];
                $small_array['subcategory_id'] = $request->subcategory_id;
                if($product_data->offer_price <= 0){
                    $small_array['tot_price'] = @$small_array['tot_price'] + $product_data->price;
                }else{
                    $small_array['tot_price'] = @$small_array['tot_price'] + $product_data->offer_price;
                }   
                $small_array['tot_tax'] = @$small_array['tot_tax'] + $product_data->tax;
              }
            }else{
                $set_array_list[$key]['name'] =  json_decode($product_data->product_name, true)['en'];
                $set_array_list[$key]['price'] =  $product_data->price;
                $set_array_list[$key]['offer_price'] =  $product_data->offer_price;
                $set_array_list[$key]['tax'] =  $product_data->tax;
                $set_array_list[$key]['single_product_id'] =  $product_data->id;
                $set_array_list[$key]['set_editable'] = $set_editable->set_editable;
                // $g_category_title = json_decode($product_data->title, true)['en'];
                $small_array['name'] = $request['set_name'];
                $small_array['img'] = $product_data->thumbnail;
                $small_array['id'] = $request['id'];
                $small_array['subcategory_id'] = $request->subcategory_id;
                if($product_data->offer_price <= 0){
                    $small_array['tot_price'] = @$small_array['tot_price'] + $product_data->price;
                }else{
                    $small_array['tot_price'] = @$small_array['tot_price'] + $product_data->offer_price;
                }
                $small_array['tot_tax'] = @$small_array['tot_tax'] + $product_data->tax;
            }
         }
        $product = $small_array;
        
        $data = array();
        
        $data['set_array_list'] = $set_array_list;
        $data['id'] = $product['id'];
        // $data['set_editable'] = 
        $data['subcategory'] = $request['subcategory'];
        $data['tax'] = $small_array['tot_tax'];
        $str = '';
        $variations = [];
        $price = 0;
        $addon_price = 0;
        // $data['variations'] = $variations;
        $data['variant'] = $str = $request['subcategory'];
        if ($request->session()->has('cart1')) {
            if (count($request->session()->get('cart1')) > 0) {
                foreach ($request->session()->get('cart1') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $request['id'] && $cartItem['variant'] == $str) {
                        return response()->json([
                            'data' => 1
                        ]);
                    }
                }

            }
        }
        //Check the string and decreases quantity for the stock
        // if ($str != null) {
        //     $count = count(json_decode($product->variations));
        //     for ($i = 0; $i < $count; $i++) {
        //         if (json_decode($product->variations)[$i]->type == $str) {
        //             $price = json_decode($product->variations)[$i]->price;
        //         }
        //     }
        // } else {
        //     $price = $product['price'];
        // }
        $price = $product['tot_price'];
        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['name'] = $product['name'];
        // $data['discount'] = Helpers::discount_calculate($product, $price);
        $data['image'] = $product['img'];
        $data['add_ons'] = [];
        $data['add_on_qtys'] = [];

        if ($request['addon_id']) {
            foreach ($request['addon_id'] as $id) {
                $addon_price += $request['addon-price' . $id] * $request['addon-quantity' . $id];
                $data['add_on_qtys'][] = $request['addon-quantity' . $id];
            }
            $data['add_ons'] = $request['addon_id'];
        }

        $data['addon_price'] = $addon_price;

        if ($request->session()->has('cart1')) {
            $cart = $request->session()->get('cart1', collect([]));
            $cart->push($data);
        } else {
            $cart = collect([$data]);
            $request->session()->put('cart1', $cart);
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function cart_items()
    {
        return view('admin.pos._cart');
    }

    public function emptyCart(Request $request)
    {
        session()->forget('cart1');
        return response()->json([], 200);
    }

    public function removeFromCart(Request $request)
    {
       
        if ($request->session()->has('cart1')) {
            $cart = $request->session()->get('cart1', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart1', $cart);
            if (!empty($request->session()->get('book_remove')[$request['id']][$request['sub_id']])) {
                $set_delete = $request->session()->get('book_remove.'.$request->id);
                unset($set_delete[$request->sub_id]); // Unset the index you want
                $request->session()->put('book_remove', $set_delete);
            }
        }

        return response()->json([], 200);
    }

    public function store_keys(Request $request)
    {
        session()->put($request['key'], $request['value']);
        return response()->json('',200);
    }

    //order
    public function order_list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];

        $query = Order::pos()->with(['customer', 'branch']);

        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $query = $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('id', 'like', "%{$value}%")
                        ->orWhere('order_status', 'like', "%{$value}%")
                        ->orWhere('transaction_reference', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }

        $orders = $query->latest()->paginate(Helpers::getPagination())->appends($query_param);

        return view('admin-views.pos.order.list', compact('orders','search'));
    }

    public function order_details($id)
    {
        $order = Order::with('details')->where(['id' => $id])->first();
        if (isset($order)) {
            return view('admin-views.pos.order.order-view', compact('order'));
        } else {
            Toastr::info('No more orders!');
            return back();
        }
    }

    public function place_order(Request $request)
    {
        if ($request->session()->has('cart1')) {
            if (count($request->session()->get('cart1')) < 1) {
                Toastr::error(translate('cart_empty_warning'));
                return back();
            }
        } else {
            Toastr::error(translate('cart_empty_warning'));
            return back();
        }

        $cart = $request->session()->get('cart1');
        $total_tax_amount = 0;
        $total_addon_price = 0;
        $product_price = 0;
        $order_details = [];
        $order_qty_total = 0;

        $order_id = 100000 + Order::all()->count() + 1;
        if (Order::find($order_id)) {
            $order_id = Order::orderBy('id', 'DESC')->first()->id + 1;
        }

        $order = new Order();
        $order->id = $order_id;
        $order->order_id = $order_id;
        $order->user_id = session()->get('customer_id')??null;
        $order->coupon = $request->coupon_discount_title == 0 ? null : 'coupon_discount_title';
        $order->payment_receive = 'yes';
        $order->order_status = 'delivered';
        $order->order_type = 'pos';
        $order->payment_method = $request->type;
        $order->handlingcharge = 0; //since pos, no distance, no d. charge
        $order->delivery_address = 'pos';
        $order->created_at = now();
        $order->updated_at = now();
     
        $product_subtotal = 0;
        $parent_ids = [];
        $simple_pro_idss = [];
        foreach ($cart as $c) {
          if (is_array($c)) {
              $discount_on_product = 0;
              $product_subtotal = ($c['price']) * $c['quantity'];
              $discount_on_product += (@$c['discount'] * $c['quantity']);
              $price = $c['price'];
              $parent_ids[$c['name']] = array("class_id" => $c['id'],"school_id" => $c['subcategory'],"quantity" => $c['quantity'],'product_amt' => $product_subtotal,"tax" => $c['tax']);
                foreach ($c['set_array_list'] as $key12 => $set_json){
                    SimpleProduct::where('id',$set_json['single_product_id'])->update(['stock' => DB::raw('stock-1')]);;

                   $simple_pro_idss[$c['id']][$set_json['single_product_id']] = array("class_name" => $c['name'], "id" => $set_json['single_product_id'],"name" => $set_json['name']);
                }   
                 $order_qty_total += $c['quantity'];
                 $total_tax_amount += $c['tax'] * $c['quantity'];
                 $product_price += $product_subtotal - $discount_on_product;
                //  $order_details[] = $or_d;
            }
        }

        $total_price = $product_price + $total_addon_price;
        $extra_discount = 0;
        if (isset($cart['extra_discount'])) {
            $extra_discount = $cart['extra_discount_type'] == 'percent' && $cart['extra_discount'] > 0 ? (($total_price * $cart['extra_discount']) / 100) : $cart['extra_discount'];
            $total_price -= $extra_discount;
        }
        $tax = isset($cart['tax']) ? $cart['tax'] : 0;
        $total_tax_amount = ($tax > 0) ? (($total_price * $tax) / 100) : $total_tax_amount;
        $order->parent_ids = json_encode($parent_ids);
        $order->simple_pro_ids = json_encode($simple_pro_idss);
        $order->qty_total = $order_qty_total;
        $order->status = 1;
        $order->discount = $extra_discount;
        try {
            // $order->extra_discount = $extra_discount??0;
            $order->tax_amount = $total_tax_amount;
            $order->order_total = $total_price + $total_tax_amount + $order->delivery_charge;
            $order->paid_in = $total_price + $total_tax_amount + $order->delivery_charge;

            // $order->coupon_discount_amount = 0.00;
            // $order->branch_id = session()->get('branch_id')??1;
             $order->save();
            // foreach ($order_details as $key => $item) {
            //     $order_details[$key]['order_id'] = $order->id;
            // }
            // print_r($order_details);die;
            // Order::insert($order);

            session()->forget('cart1');
            session(['last_order' => $order->id]);

            session()->forget('customer_id');
            session()->forget('branch_id');

            // Toastr::success(translate('order_placed_successfully'));
            return back();
        } catch (\Exception $e) {
            info($e); 
        }
        // Toastr::warning(translate('failed_to_place_order'));
        return back();
    }

    public function generate_invoice($id)
    {
        $order = Order::where('id', $id)->first();

        return response()->json([
            'success' => 1,
            'view' => view('admin.pos.order.invoice', compact('order'))->render(),
        ]);
    }
}
