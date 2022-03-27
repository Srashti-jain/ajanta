<?php

namespace App\Http\Controllers;

use App\Address;
use App\Charts\OfflineOrdersChart;
use App\Country;
use App\Invoice;
use App\multiCurrency;
use App\OfflineOrder;
use App\OfflineOrderItem;
use App\Product;
use App\ProductAttributes;
use App\ProductValues;
use App\Store;
use App\User;
use PDF;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class OfflineOrderController extends Controller
{

    public function __construct()
    {
        $this->invoice = Invoice::first();
        $this->currency = multiCurrency::where('default_currency','=',1)->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = OfflineOrder::select('*');

        /*Creating order chart*/

        $totalorder = OfflineOrder::select(DB::raw('DATE_FORMAT(created_at, "%M") as month'), DB::raw('count(*) as count'))
        ->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->get()
        ->map(function($item){
            
            return $item;

        });

       

      $orderchart = new OfflineOrdersChart;

      $orderchart->labels($totalorder->pluck('month'));

      $orderchart->title(__('Total Orders in :year',['year' => date('Y')]))->label(__('Sales'))->dataset(__("Month"), 'area', $totalorder->pluck('count'))->options([
          'fill' => 'true',
          'borderColor' => '#51C1C0',
          'shadow' => true
      ]);

        if ($request->ajax()) {
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('order_id', function ($row) {
                    return '<span class="badge badge-success">#<b>'.$row->order_id.'</b></span>';
                })
                ->addColumn('customer_name', function ($row) {
                    $data = "<p class='text-dark'><b>$row->customer_name</b></p>";
                    $data .= '<p class="border border-bottom"></p>';
                    $data .= "<small class='text-dark'>$row->customer_email</small>";
                    $data .= '<p class="border border-bottom"></p>';
                    $data .= "<small class='text-dark'>$row->customer_phone</small>";
                    return $data;
                })
                ->addColumn('txn_id', function ($row) {
                     return '<span class="badge badge-secondary">'.$row->txn_id.'</span>';
                })
                ->addColumn('payment_method', function ($row) {
                    return '<span class="badge badge-primary">'.$row->payment_method.'</span>';
                })
                ->addColumn('order_status', function ($row) {
                    return '<span class="badge badge-info">'.ucfirst(str_replace('_',' ',$row->order_status)).'</span>';
                })
                ->addColumn('grand_total', function ($row) {
                    $total = '';

                    $total .= '<small class="text-dark"><b>Gross Total:</b> ' .$row->subtotal. '<i class="'.$this->currency->currency_symbol.'"></i></small>';
                    $total .= '<p class="border border-bottom"></p>';
                    $total .= '<small class="text-dark"><b>Total Tax:</b> ' .$row->total_tax. '<i class="'.$this->currency->currency_symbol.'"></i></small>';
                    $total .= '<p class="border border-bottom"></p>';
                    $total .= '<small class="text-dark"><b>Total Shipping:</b> ' .$row->total_shipping. '<i class="'.$this->currency->currency_symbol.'"></i></small>';
                    $total .= '<p class="border border-bottom"></p>';
                    $total .= '<small class="text-dark"><b>Grand Total:</b> ' .$row->grand_total. '<i class="'.$this->currency->currency_symbol.'"></i></small>';

                    return $total;
                })
                ->addColumn('created_at', function ($row) {
                    $date =  '<small><b>Date: </b>'.date('d-m-Y', strtotime($row->created_at)).'</small>';
                    $date .= '<p class="border border-bottom"></p>';
                    $date .=  '<small><b>Time: </b>'.date('h:i a', strtotime($row->created_at)).'</small>';
                    return $date;
                })
                ->addColumn('updated_at', function ($row) {
                    $date =  '<small><b>'.__('Date: ').'</b>'.date('d-m-Y', strtotime($row->updated_at)).'</small>';
                    $date .= '<p class="border border-bottom"></p>';
                    $date .=  '<small><b>'.__("Time: ").'</b>'.date('h:i a', strtotime($row->updated_at)).'</small>';
                    return $date;
                })
                ->editColumn('action', 'offlinebilling.action')
                ->rawColumns(['order_id', 'customer_name', 'payment_method', 'txn_id', 'order_status', 'grand_total', 'created_at', 'updated_at','action'])
                ->make(true);
        }

        return view('offlinebilling.index')->with(['ordercount' => $orders->count(), 'orderchart' => $orderchart]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::all();
        return view('offlinebilling.create', compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $customer = User::find($request->customer_id);

            if (isset($customer)) {

                $address = Address::where('address', '=', $request->customer_shipping_address)->where('user_id', '=', $customer->id)->first();

                if (!isset($address)) {

                    $address = $this->address($customer, $request);

                }

            } else {

                $customer = User::create([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'password' => Hash::make('1234567890'),
                    'mobile' => $request->customer_phone,
                    'role_id' => 'u',
                    'status' => '1',
                    'is_verified' => '0',
                ]);

                $address = $this->address($customer, $request);

            }

            $validator = Validator::make($request->all(), [
                'order_id' => 'unique:offline_orders,order_id',
                'txn_id' => 'unique:offline_orders,txn_id'
            ]);

            if ($validator->fails()) {

                $errors = $validator->errors();

                $orderid = $request->order_id ? $request->order_id : $this->invoice->order_prefix.uniqid();

                if($errors->first('txn_id')){

                    return back()->withErrors([
                        'txn_id' => $errors->first('txn_id')
                    ]);
                   
                }
            }

            $orderid = $request->order_id ? $request->order_id : $this->invoice->order_prefix.uniqid();

            if($request->txn_same_as_orderid){
                $txnid = $orderid;
            }else{
                $txnid = $request->txn_id;
            }

            $order = new OfflineOrder;

            $input = $request->all();

            if(isset($request->DEFAULT_INVOICE_DATE)){

                $path = new GenralController;

                $path->changeEnv([
                    'DEFAULT_INVOICE_DATE' => date('Y-m-d',strtotime($request->invoice_date))
                ]);

            }

            $input['order_id'] = $orderid;

            $input['customer_id'] = $customer->id;

            $input['tax_include'] = isset($request->tax_include) ? 1 : 0;

            $input['invoice_date'] = date('Y-m-d',strtotime($request->invoice_date));

            $input['txn_id'] = $txnid;

            $order = $order->create($input);

            if (isset($request->product_name)) {

                foreach ($request->product_name as $key => $product) {

                    $orderitem = new OfflineOrderItem;

                    $orderitem->order_id = $order->id;
                    $orderitem->product_name = $request->product_name[$key];
                    $orderitem->product_price = $request->product_price[$key];
                    $orderitem->product_qty = $request->product_qty[$key];
                    $orderitem->product_total = $request->product_total[$key];
                    $orderitem->origin = $request->origin[$key];
                    
                    $orderitem->save();
                }

            } else {
                return back()->withErrors(__('Please create at least one product'))->withInput();
            }

            notify()->success(__('Order created successfully !'), "$order->order_id");

            return redirect(route('offline-orders.index'));

        } catch (\Exception $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    protected function address($customer, $request)
    {
        return Address::create([
            'name' => $request->customer_name,
            'email' => $request->customer_email,
            'phone' => $request->customer_phone,
            'user_id' => $customer->id,
            'address' => $request->customer_shipping_address,
            'pin_code' => $request->customer_pincode,
            'defaddress' => $request->mark_as_default ? 1 : 0,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $order = OfflineOrder::where('id',$id)->where('order_id',$request->orderid)->first();
        $store = Store::first();
        if(!$order || $request->order_id){
            
            notify()->error(__('Order not found !'));
            return redirect(route('offline-orders.index'));
        }

        return view('offlinebilling.show', compact('order','store'));
    }

    public function print(Request $request,$id)
    {
        $order = OfflineOrder::where('id',$id)->where('order_id',$request->orderid)->first();
        $store = Store::first();
        if(!$order || $request->order_id){
            
            notify()->error(__('Order not found !'));
            return redirect(route('offline-orders.index'));
        }

        return view('offlinebilling.print', compact('order','store'));
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $order = OfflineOrder::where('id',$id)->where('order_id',$request->orderid)->first();

        if(!$order || $request->order_id){
            
            notify()->error(__('Order not found !'));
            return redirect(route('offline-orders.index'));
        }

        $country = Country::all();
        return view('offlinebilling.edit', compact('country','order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        try {

            $order = OfflineOrder::find($id);

            $validator = Validator::make($request->all(), [
                'order_id' => 'unique:offline_orders,order_id,'.$order->id,
                'txn_id' => 'unique:offline_orders,txn_id,'.$order->id
            ]);
    
            if ($validator->fails()) {
    
                $errors = $validator->errors();

                if($errors->first('order_id')){
    
                    return back()->withErrors([
                        'order_id' => __('Order ID has already been taken !')
                    ]);
                   
                }
    
                if($errors->first('txn_id')){
    
                    return back()->withErrors([
                        'txn_id' => $errors->first('txn_id')
                    ]);
                   
                }
            }
    
            
            if(isset($order)){

                $customer = User::find($request->customer_id);

            if (isset($customer)) {
                $address = Address::where('address', '=', $request->customer_shipping_address)->where('user_id', '=', $customer->id)->first();

                if (!isset($address)) {

                    $address = $this->address($customer, $request);

                }
            } else {

                $customer = User::create([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'password' => Hash::make('1234567890'),
                    'mobile' => $request->customer_phone,
                    'role_id' => 'u',
                    'status' => '1',
                    'is_verified' => '0',
                ]);

                $address = $this->address($customer, $request);

            }

            $input = $request->all();

            $input['order_id'] = isset($request->order_id) ? $request->order_id : $order->order_id;
            $input['customer_id'] = $customer->id;
            $input['tax_include'] = isset($request->tax_include) ? 1 : 0;
            $input['invoice_date'] = date('Y-m-d',strtotime($request->invoice_date));

            if(isset($request->DEFAULT_INVOICE_DATE)){

                $path = new GenralController;

                $path->changeEnv([
                    'DEFAULT_INVOICE_DATE' => date('Y-m-d',strtotime($request->invoice_date))
                ]);

            }

            if($request->txn_same_as_orderid){
                $txnid = $input['order_id'];
            }else{
                $txnid = $request->txn_id;
            }

            $input['txn_id'] = $txnid;
            
            $order->update($input);

            $order->orderItems()->delete();
            

            if (isset($request->product_name)) {

                foreach ($request->product_name as $key => $product) {

                    $orderitem = new OfflineOrderItem;

                    $orderitem->order_id = $order->id;
                    $orderitem->product_name = $request->product_name[$key];
                    $orderitem->product_price = $request->product_price[$key];
                    $orderitem->product_qty = $request->product_qty[$key];
                    $orderitem->product_total = $request->product_total[$key];
                    $orderitem->origin = $request->origin[$key];
                    $orderitem->save();
                }

            } else {
                return back()->withErrors(__('Please create at least one product'))->withInput();
            }

                notify()->success(__('Order updated successfully !'), "$order->order_id");

                return redirect(route('offline-orders.index'));
            }else{
                notify()->error(__('Order not found !'));
                return redirect(route('offline-orders.index'));
            }

        } catch (\Exception $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = OfflineOrder::find($id);

        if(!isset($order)){
            notify()->error(__('Order not found !'));
            return redirect(route('offline-orders.index'));
        }

        $order->orderItems()->delete();
        $order->delete();

        notify()->success(__('Order has been deleted !'));
        return redirect(route('offline-orders.index'));
    }

    public function customerSearch(Request $request)
    {

        $search = $request->get('term');
        $result = array();
        $query = User::where('name', 'LIKE', '%' . $search . '%')->get();

        foreach ($query as $q) {

            $address = $q->addresses->where('defaddress', '1')->first();

            $result[] = [
                'id' => $q->id,
                'value' => $q->name,
                'email' => $q->email,
                'phoneno' => $q->mobile,
                'address' => isset($address) ? $address->address : null,
                'pincode' => isset($address) ? $address->pin_code : null,
                'country' => isset($address) ? $address->country_id : null,
                'state' => isset($address) ? $address->state_id : null,
                'city' => isset($address) ? $address->city_id : null,
            ];

           
        }

        return response()->json($result);
    }

    public function productsearch(Request $request){

        $search = $request->get('term');
        $result = array();
        $query = Product::where('name', 'LIKE', '%' . $search . '%')->with('subvariants')->get();

        foreach ($query as $key => $q) {

            foreach ($q->subvariants as $orivar) {

                $variant = $this->getVariant($orivar)->getData();

                $result[] = [
                    'id' => $q->id,
                    'value' => $q->name.' ('.$variant->value.')'
                ];
            }
            
            
        }

        return response()->json($result);

    }

    protected function getVariant($orivar)
    {
        $varcount = count($orivar->main_attr_value);
        $i = 0;
        $othervariantName = null;

        foreach ($orivar->main_attr_value as $key => $orivars) {

            $i++;

            
            $getvarvalue = ProductValues::where('id', $orivars)->first();

            if ($i < $varcount) {
                if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {
                    if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                        $othervariantName = $getvarvalue->values . ',';

                    } else {
                        $othervariantName = $getvarvalue->values . $getvarvalue->unit_value . ',';
                    }
                } else {
                    $othervariantName = $getvarvalue->values;
                }

            } else {

                if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {

                    if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                        $othervariantName = $getvarvalue->values;

                    } else {
                        $othervariantName = $getvarvalue->values . $getvarvalue->unit_value;
                    }

                } else {
                    $othervariantName = $getvarvalue->values;
                }

            }

        }

        return response()->json(['value' => $othervariantName]);
    }
}
