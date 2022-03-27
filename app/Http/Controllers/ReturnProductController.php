<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddSubVariant;
use App\admin_return_product;
use App\CanceledOrders;
use App\Config;
use App\CurrencyList;
use App\Genral;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderStatus;
use App\multiCurrency;
use App\Notifications\AdminOrderNotification;
use App\Notifications\SellerNotification;
use App\Notifications\SendOrderStatus;
use App\Notifications\SMSNotifcations;
use App\OrderActivityLog;
use App\OrderWalletLogs;
use App\Return_Product;
use App\SimpleProduct;
use App\User;
use App\UserWalletHistory;
use Auth;
use Braintree;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mail;
use Nwidart\Modules\Facades\Module;
use PayPal\Api\Amount;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PaytmWallet;
use Razorpay\Api\Api;
use Session;
use Twilosms;


class ReturnProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $_api_context;

    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
        $this->defaultCurrency = multiCurrency::where('default_currency', '=', 1)->first();
        $this->wallet_system = Genral::first()->wallet_enable;
    }

    public function index()
    {
        abort_if(!auth()->user()->can('returnpolicy.view'),403,__('User does not have the right permissions.'));
        $pro_return = admin_return_product::get();
        return view('admin.return_policy.index', compact('pro_return'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('returnpolicy.create'),403,__('User does not have the right permissions.'));
        return view('admin.return_policy.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        abort_if(!auth()->user()->can('returnpolicy.create'),403,__('User does not have the right permissions.'));

        $this->validate($request, [
            'des' => 'required|string|',
            'days' => 'required',
            'amount' => 'required',
        ]);

        $input = $request->all();

        $input['created_by'] = Auth::user()->id;

        $data = admin_return_product::create($input);

        $data->save();

        return redirect('admin/return-policy')->with("added", __("Return Policy Has Been Created !"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Return_Product  $return_Product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Return_Product  $return_Product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('returnpolicy.edit'),403,__('User does not have the right permissions.'));

        $policy = admin_return_product::findOrFail($id);
        return view("admin.return_policy.edit", compact("policy"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Return_Product  $return_Product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('returnpolicy.edit'),403,__('User does not have the right permissions.'));

        $brand = admin_return_product::findOrFail($id);
        $input = $request->all();
        $brand->update($input);

        return redirect('admin/return-policy')->with('updated', __('Return Policy has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Return_Product  $return_Product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('returnpolicy.delete'),403,__('User does not have the right permissions.'));

        $daa = new admin_return_product;
        $obj = $daa->findorFail($id);

        $value = $obj->delete();
        if ($value) {
            session()->flash("deleted", __("Return Policy Has Been deleted"));
            return redirect("admin/return-policy");
        }
    }

    public function update_return_product(Request $request, $id)
    {

        $status = $request->payment_status;
        if ($status == '') {
            $status = 0;
        }

        $sub = new Return_Product;
        $obj = $sub->find($id);
        $obj->payment_status = $status;
        $obj->created_at = date('Y-m-d H:i:s');
        $obj->updated_at = date('Y-m-d H:i:s');
        $obj->save();

        return redirect('admin/return_products_show')->with('updated', __('Return Product is update.'));
    }

    public function cancel_product(Request $request, $id)
    {

        $did = Crypt::decrypt($id);
        $status = 0; 

        if (!isset($request->source)) {
            notify()->error(__('Please add bank account first !'));
            return back();
        }

        if (Auth::check()) {

            $findorder = InvoiceDownload::find($did);

            if ($findorder->discount != 0) {

                $finalAmount = sprintf("%.2f", (($findorder->qty * $findorder->price) + $findorder->tax_amount + $findorder->handlingcharge + $findorder->gift_charge + $findorder->shipping) - $findorder->discount);

            } else {

                $finalAmount = sprintf("%.2f", ($findorder->qty * $findorder->price) + $findorder->tax_amount + $findorder->handlingcharge + $findorder->shipping + $findorder->gift_charge);

            }


            $finalAmount = round($finalAmount, 2);

            if (!empty($findorder)) {

                if (auth()->id() == $findorder->order->user_id || auth()->user()->role_id == 'a' || $findorder->vender_id == auth()->id()) {

                    //Cancel Order Here
                    if ($findorder->order->payment_method == 'COD') {

                        $cancelorderlog = new CanceledOrders();

                        $cancelorderlog->order_id = $findorder->order->id;
                        $cancelorderlog->inv_id = $findorder->id;
                        $cancelorderlog->user_id = $findorder->order->user_id;
                        $cancelorderlog->comment = $request->comment;
                        $cancelorderlog->method_choosen = $request->source;
                        $cancelorderlog->amount = $finalAmount;
                        $cancelorderlog->is_refunded = 'completed';
                        $cancelorderlog->transaction_id = 'CODCAN' . str_random(10);
                        $cancelorderlog->bank_id = $request->bank_id;
                        $cancelorderlog->txn_fee = null;
                        $cancelorderlog->save();

                        $status = 1;
                    }

                    if ($findorder->order->payment_method == 'BankTransfer' || $request->source == 'bank') {
                       
                       
                            $cancelorderlog = new CanceledOrders();

                            $cancelorderlog->order_id = $findorder->order->id;
                            $cancelorderlog->inv_id = $findorder->id;
                            $cancelorderlog->user_id = $findorder->order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $finalAmount;
                            $cancelorderlog->bank_id = $request->bank_id;
                            $cancelorderlog->is_refunded = 'pending';
                            $cancelorderlog->transaction_id = 'TXNBNK' . str_random(10);
                            $cancelorderlog->txn_fee = null;
                            $cancelorderlog->save();

                            $status = 1;
                        
                    } elseif ($request->source == 'orignal') {


                        if ($findorder->order->payment_method == 'Wallet') {

                            if ($this->wallet_system != 1) {
                                notify()->info(__('Wallet System is deactive currently ! please contact site master regrading this issue !'));
                                return back();
                            }

                            if (isset($findorder->order->user->wallet) && $findorder->order->user->wallet->status == 1) {

                                $cancelorderlog = new CanceledOrders();

                                $cancelorderlog->order_id = $findorder->order->id;
                                $cancelorderlog->inv_id = $findorder->id;
                                $cancelorderlog->user_id = $findorder->order->user_id;
                                $cancelorderlog->comment = $request->comment;
                                $cancelorderlog->method_choosen = $request->source;
                                $cancelorderlog->amount = $finalAmount;
                                $cancelorderlog->is_refunded = 'completed';
                                $cancelorderlog->transaction_id = 'WALLET' . str_random(10);
                                $cancelorderlog->txn_fee = null;
                                $cancelorderlog->save();

                                $status = 1;
                                $refunded_wallet_amount = sprintf("%.2f", currency($finalAmount, $from = $findorder->order->paid_in_currency, $to = $this->defaultCurrency->currency->code, $format = false));

                                /** Put Money back in users wallet */
                                $findorder->order->user->wallet()->update([
                                    'balance' => $findorder->order->user->wallet->balance + $refunded_wallet_amount,
                                ]);

                                $inv_cus = Invoice::first();
                                $invoiceno = $inv_cus->prefix . $findorder->inv_no . $inv_cus->postfix;

                                /** Adding Customer Wallet Log in History */

                                $walletlog = new UserWalletHistory;
                                $walletlog->wallet_id = $findorder->order->user->wallet->id;
                                $walletlog->type = 'Credit';
                                $walletlog->log = 'Refund Payment for Invoice #' . $invoiceno;
                                $walletlog->amount = $refunded_wallet_amount;
                                $walletlog->txn_id = $cancelorderlog->transaction_id;
                                $walletlog->save();
                                /** END */

                                /** Make a log entry in Admin Order Wallet logs */

                                $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

                                $adminwalletlog = new OrderWalletLogs;
                                $adminwalletlog->wallet_txn_id = $cancelorderlog->transaction_id;
                                $adminwalletlog->note = 'Refund Payment for Invoice #' . $invoiceno;
                                $adminwalletlog->type = 'Debit';
                                $adminwalletlog->amount = $refunded_wallet_amount;
                                $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance - $refunded_wallet_amount : $refunded_wallet_amount;
                                $adminwalletlog->save();
                                /** END */

                            } else {
                                notify()->warning(__("Refund can't be proccesed as your wallet is deactive or not found !"));
                                return back();
                            }

                        } elseif ($findorder->order->payment_method == 'PayPal') {

                            $fCurrency = multiCurrency::where('currency_symbol', '=', $findorder->order->paid_in)->first();

                            $setCurrency = CurrencyList::findOrFail($fCurrency->currency_id)->code;

                            $amt = new Amount();
                            $amt->setTotal($finalAmount)
                                ->setCurrency($setCurrency);
                            $saleId = $findorder->order->sale_id;
                            $refund = new Refund();
                            $refund->setAmount($amt);
                            $sale = new Sale();
                            $sale->setId($saleId);

                            try {

                                $refundedSale = $sale->refund($refund, $this->_api_context);

                                $cancelorderlog = new CanceledOrders();

                                $cancelorderlog->order_id = $findorder->order->id;
                                $cancelorderlog->inv_id = $findorder->id;
                                $cancelorderlog->user_id = $findorder->order->user_id;
                                $cancelorderlog->comment = $request->comment;
                                $cancelorderlog->method_choosen = $request->source;
                                $cancelorderlog->amount = $refundedSale->total_refunded_amount['value'];
                                $cancelorderlog->is_refunded = $refundedSale->state;
                                $cancelorderlog->transaction_id = $refundedSale->id;
                                $cancelorderlog->txn_fee = $refundedSale->refund_from_transaction_fee['value'];
                                $cancelorderlog->save();

                                $status = 1;

                            } catch (\Exception $ex) {

                                notify()->error($ex->getMessage());
                                return back();

                            }
                        } elseif ($findorder->order->payment_method == 'Stripe') {
                            $stripe = new Stripe();
                            $stripe = Stripe::make(env('STRIPE_SECRET'));

                            $charge_id = $findorder->order->transaction_id;
                            $amount = $finalAmount;

                            try {

                                $refund = $stripe->refunds()->create($charge_id, $amount, [

                                    'metadata' => [

                                        'reason' => $request->comment,

                                    ],

                                ]);

                                $cancelorderlog = new CanceledOrders();

                                $cancelorderlog->order_id = $findorder->order->id;
                                $cancelorderlog->inv_id = $findorder->id;
                                $cancelorderlog->user_id = $findorder->order->user_id;
                                $cancelorderlog->comment = $request->comment;
                                $cancelorderlog->method_choosen = $request->source;
                                $cancelorderlog->amount = $finalAmount;
                                $cancelorderlog->is_refunded = 'completed';
                                $cancelorderlog->transaction_id = $refund['id'];
                                $cancelorderlog->txn_fee = null;
                                $cancelorderlog->save();

                                $status = 1;

                            } catch (\Exception $e) {
                                $error = $e->getMessage();
                                Session::flash('warning', $error);
                                notify()->error($error);
                                return back();
                            }

                        } elseif ($findorder->order->payment_method == 'Instamojo') {

                        
                           
                            try {

                                $ch = curl_init();
                                $api_key = env('IM_API_KEY');
                                $auth_token = env('IM_AUTH_TOKEN');
                                curl_setopt($ch, CURLOPT_URL, env('IM_REFUND_URL'));
                                curl_setopt($ch, CURLOPT_HEADER, false);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER,

                                    array("X-Api-Key:$api_key",
                                        "X-Auth-Token:$auth_token"));

                                $payload = array(

                                    'transaction_id' => 'RFD_IM_' . str_random(10),
                                    'payment_id' => $findorder->order->transaction_id,
                                    'type' => 'QFL',
                                    'refund_amount' => $finalAmount,
                                    'body' => $request->comment,

                                );

                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
                                $response = curl_exec($ch);
                                curl_close($ch);

                                $result = json_decode($response, true);

                                if (isset($result['refund'])) {

                                    $cancelorderlog = new CanceledOrders();

                                    $cancelorderlog->order_id = $findorder->order->id;
                                    $cancelorderlog->inv_id = $findorder->id;
                                    $cancelorderlog->user_id = $findorder->order->user_id;
                                    $cancelorderlog->comment = $request->comment;
                                    $cancelorderlog->method_choosen = $request->source;
                                    $cancelorderlog->amount = $result['refund']['refund_amount'];
                                    $cancelorderlog->is_refunded = 'completed';
                                    $cancelorderlog->transaction_id = $result['refund']['id'];
                                    $cancelorderlog->txn_fee = null;
                                    $cancelorderlog->save();

                                    $status = 1;

                                } else {
                                    notify()->error($result['message']);
                                    return back();
                                }

                            } catch (\Exception $e) {
                               
                                $error = $e->getMessage();
                                Session::flash('warning', $error);
                                notify()->error($error);
                                return back();
                            }

                        } elseif ($findorder->order->payment_method == 'PayU') {
                            Session::flash('warning', __('Error In PAYU SIDE Will added soon when PAYU solve it, use bank transfer method till that'));
                            notify()->error(__('Error In PAYU SIDE Will added soon when PAYU solve it use bank transfer method till that'));
                            return back();

                        } elseif ($findorder->order->payment_method == 'Razorpay') {
                            //get API Configuration
                            $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));
                            $payment = $api->payment->fetch($findorder->order->transaction_id);

                            try {
                                $refund = $payment->refund(array('amount' => $finalAmount * 100));

                                $cancelorderlog = new CanceledOrders();

                                $cancelorderlog->order_id = $findorder->order->id;
                                $cancelorderlog->inv_id = $findorder->id;
                                $cancelorderlog->user_id = $findorder->order->user_id;
                                $cancelorderlog->comment = $request->comment;
                                $cancelorderlog->method_choosen = $request->source;
                                $cancelorderlog->amount = $refund->amount / 100;
                                $cancelorderlog->is_refunded = 'completed';
                                $cancelorderlog->transaction_id = $refund->id;
                                $cancelorderlog->txn_fee = null;
                                $cancelorderlog->save();

                                $status = 1;

                            } catch (\Exception $e) {
                                $error = $e->getMessage();
                                Session::flash('warning', $error);
                                notify()->error($error);
                                return back();
                            }
                        } elseif ($findorder->order->payment_method == 'Paytm') {

                         

                            $refund = PaytmWallet::with('refund');

                            $refund->prepare([
                                'order' => $findorder->order['order_id'],
                                'reference' => 'refund-order-' . $findorder->order['order_id'],
                                'amount' => $finalAmount,
                                'transaction' => $findorder->order->transaction_id,
                            ]);

                            $refund->initiate();
                            $response = $refund->response();

                            if ($refund->isSuccessful()) {

                                $cancelorderlog = new CanceledOrders();

                                $cancelorderlog->order_id = $findorder->order->id;
                                $cancelorderlog->inv_id = $findorder->id;
                                $cancelorderlog->user_id = $findorder->order->user_id;
                                $cancelorderlog->comment = $request->comment;
                                $cancelorderlog->method_choosen = $request->source;
                                $cancelorderlog->amount = $response['REFUNDAMOUNT'];
                                $cancelorderlog->is_refunded = 'completed';
                                $cancelorderlog->transaction_id = $response['REFUNDID'];
                                $cancelorderlog->txn_fee = null;
                                $cancelorderlog->save();
                                $status = 1;

                            } else if ($refund->isFailed()) {

                                if ($response['STATUS'] == 'TXN_FAILURE') {

                                    $status = 0;
                                    notify()->error($response['RESPMSG']);
                                    Session::flash('warning', $response['RESPMSG']);
                                    return back();

                                }

                            } else if ($refund->isOpen()) {
                                #nocode
                            } else if ($refund->isPending()) {
                                #nocode
                            }

                        } elseif ($findorder->order->payment_method == 'Braintree') {
                            $gateway = $this->brainConfig();
                            $result = $gateway->transaction()->refund($findorder->order->transaction_id, $finalAmount);
                            if ($result->success == true) {

                                $cancelorderlog = new CanceledOrders();

                                $cancelorderlog->order_id = $findorder->order->id;
                                $cancelorderlog->inv_id = $findorder->id;
                                $cancelorderlog->user_id = $findorder->order->user_id;
                                $cancelorderlog->comment = $request->comment;
                                $cancelorderlog->method_choosen = $request->source;
                                $cancelorderlog->amount = $result->transaction->amount;
                                $cancelorderlog->is_refunded = 'completed';
                                $cancelorderlog->transaction_id = $result->transaction->id;
                                $cancelorderlog->txn_fee = null;
                                $cancelorderlog->save();

                                $status = 1;

                            } else {
                                $status = 0;
                                notify()->error($result->message);
                                Session::flash('warning', $result->message);
                                return back();
                            }
                        } elseif ($findorder->order->payment_method == 'Paystack') {

                            $url = "https://api.paystack.co/refund";

                            $fields = [
                                'amount' => $finalAmount,
                                'transaction' => $findorder->order->transaction_id,
                                'customer_note' => $request->comment,
                            ];

                            $fields_string = http_build_query($fields);
                            //open connection
                            $ch = curl_init();
                            $secret = env('PAYSTACK_SECRET_KEY');
                            //set the url, number of POST vars, POST data
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                "Authorization: Bearer $secret",
                                "Cache-Control: no-cache",
                            ));

                            //So that curl_exec returns the contents of the cURL; rather than echoing it
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            //execute post
                            $result = curl_exec($ch);
                            $result = json_decode($result, true);

                            if ($result['status'] == false) {
                                $status = 0;
                                Session::flash('warning', $result['message']);
                                notify()->error($result['message']);
                                return back();
                            } else {
                                $cancelorderlog = new CanceledOrders();

                                $cancelorderlog->order_id = $findorder->order->id;
                                $cancelorderlog->inv_id = $findorder->id;
                                $cancelorderlog->user_id = $findorder->order->user_id;
                                $cancelorderlog->comment = $request->comment;
                                $cancelorderlog->method_choosen = $request->source;
                                $cancelorderlog->amount = $result['data']['transaction']['amount'] / 100;
                                $cancelorderlog->is_refunded = 'completed';
                                $cancelorderlog->transaction_id = $result['data']['transaction']['id'];
                                $cancelorderlog->txn_fee = null;
                                $cancelorderlog->save();

                                $status = 1;
                            }

                        } else {
                            notify()->info(__('For Selected Payment Method Instant Refund is not available !'));
                            return back();
                        }

                    }

                    if ($status == 1) {

                        if ($findorder->order->payment_method != 'COD' && $request->source != 'bank') {

                            InvoiceDownload::where('id', '=', $did)->update(['status' => 'refunded']);

                        }

                        if ($request->source == 'bank') {

                            InvoiceDownload::where('id', '=', $did)->update(['status' => 'Refund Pending']);
                        }

                        if ($findorder->order->payment_method == 'COD') {
                            InvoiceDownload::where('id', '=', $did)->update(['status' => 'canceled']);
                        }

                        if(isset($findorder->variant)){
                            $orivar = AddSubVariant::findorfail($findorder->variant_id);

                           
                            /*Adding Stock Back*/
                            $stock = $orivar->stock + $findorder->qty;

                            /*Updating Stock*/
                            $orivar->stock = $stock;
                            $orivar->save();

                            /*Returned*/

                            $productname = $orivar->products->name;

                            $var_main = variantname($orivar);

                        }

                        if(isset($findorder->simple_product)){

                            $p = SimpleProduct::findorfail($findorder->simple_pro_id);

                            /*Adding Stock Back*/
                            $stock = $p->stock + $findorder->qty;

                            /*Updating Stock*/
                            $p->stock = $stock;
                            $p->save();

                            /*Returned*/

                            $productname = $p->product_name;

                            $var_main = NULL;


                        }

                        $get_admins = User::where('role_id', '=', 'a')->get();
                        $status = ucfirst('cancelled');

                        $create_activity = new OrderActivityLog();

                        $create_activity->order_id = $findorder->order->id;
                        $create_activity->inv_id = $findorder->id;
                        $create_activity->user_id = auth()->id();
                        $create_activity->variant_id = $findorder->variant_id ?? 0;
                        $create_activity->simple_pro_id = $findorder->simple_pro_id ?? NULL;
                        $create_activity->log = $status;

                        $create_activity->save();
                        $inv_cus = Invoice::first();

                        /*Send Mail to User*/
                        $e = Address::findOrFail($findorder->order->delivery_address)->email;

                        if (isset($e)) {
                            try {
                                Mail::to($e)->send(new OrderStatus($inv_cus, $findorder, $status));
                            } catch (\Exception $e) {

                            }
                        }
                        /*End*/

                        /*Sending Notification to user*/
                        User::find($findorder->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $findorder->order->order_id));
                        /*End*/

                        /*Sending notification to all admin*/
                        \Notification::send($get_admins, new AdminOrderNotification($inv_cus, $productname, $var_main, $status, $findorder->order->order_id));
                        /*End*/

                        $config = Config::first();

                        if($config->sms_channel == '1'){

                            $smsmsg = 'For Order #' . $inv_cus->order_prefix . $findorder->order->order_id . ' following item ';

                            $smsmsg .= $productname . ' (' . $var_main . ')';

                            $smsmsg .= ' has been ' . $status; // specify order status

                            $smsmsg .= ' and amount ';

                            $smsmsg .= $findorder->order->paid_in_currency; // specify curreny code

                            $smsmsg .= $finalAmount; // specify amount

                            $smsmsg .= ' (IF Paid) is processed for refund to your choosen source ' . ucfirst($request->source) . ' account'; // specify source

                            $smsmsg .= ' - ' . config('app.name');

    
                            if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $config->msg91_enable == '1'){
    
                                try{
                                    
                                    User::find($findorder->order->user_id)->notify(new SMSNotifcations($smsmsg));
            
                                }catch(\Exception $e){
            
                                    \Log::error('Error: '.$e->getMessage());
            
                                }
    
                            }
        
                            if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
    
                                try{
                                    Twilosms::sendMessage($smsmsg, '+'.$findorder->order->user->phonecode.$findorder->order->user->mobile);
                                }catch(\Exception $e){
                                    \Log::error('Twillo Error: '.$e->getMessage());
                                }
    
                            }

                            if (Module::has('MimSms') && Module::find('MimSms')->isEnabled() && env('DEFAULT_SMS_CHANNEL') == 'mim') {

                                try{
                            
                                    sendMimSMS($smsmsg,$findorder->order->user->phonecode.$findorder->order->user->mobile);
                            
                                }catch(\Exception $e){
                                    Log::error('MIM SMS Error: ' . $e->getMessage());
                                }
                            
                            }

                        }

                        /*Sending Notification to vender*/
                        $vender_system = Genral::first()->vendor_enable;
                        if ($vender_system == 1) {
                            $o = $findorder->order->order_id;
                            $msg = "For order $inv_cus->order_prefix $o Item $productname ($var_main) has been $status";
                            $url = route('seller.canceled.orders');
                            $v = User::find($findorder->vender_id);
                            if ($v->role_id == 'v') {
                                $v->notify(new SellerNotification($url, $msg));
                            }
                        }
                        /*END*/
                    }

                    if ($findorder->order->payment_method == 'COD') {
                        Session::flash('updated', __('Following Item has been cancelled successfully !')); //for admin
                        notify()->success(__('Following Item has been cancelled successfully !'));
                        return back();

                    }
                    Session::flash('added', __('Following Item has been cancelled successfully !'));
                    notify()->success(__('Following Item has been cancelled successfully !'));
                    return back();

                } else {
                    Session::flash('deleted', '404 No order found regarding your query ! !');
                    notify()->error('404 No order found regarding your query !');
                    return back();
                }

            } else {
                Session::flash('warning', __('Unauthorized Action !'));
                notify()->error(__('Unauthorized Action !'));
                return back();
            }

        }

    }

    /* Config function to get the braintree config data to process all the apis on braintree gateway */
    public function brainConfig()
    {

        return $gateway = new Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

    }

}