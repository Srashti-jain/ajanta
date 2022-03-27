<?php

namespace App\Http\Controllers;

use App\Address;
use App\Affilate;
use App\Config as AppConfig;
use App\Genral;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderStatus;
use App\Mail\WalletMail;
use App\multiCurrency;
use App\Notifications\SendOrderStatus;
use App\Notifications\SMSNotifcations;
use App\Order;
use App\OrderActivityLog;
use App\OrderWalletLogs;
use App\PendingPayout;
use App\User;
use App\UserWallet;
use App\UserWalletHistory;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mail;
use Nwidart\Modules\Facades\Module;
use Twilosms;

class VenderOrderController extends Controller
{

    public function __construct()
    {

        $this->config = AppConfig::first();

    }

    public function codorderconfirm(Request $request, $id)
    {

        if (Auth::check()) {

            $order = Order::find($id);

            $order->payment_receive = $request->status;

            $order->save();

            if ($order) {
                return response()->json(['showstatus' => 'Updated', 'status' => true]);
            } else {
                return response()->json(['showstatus' => 'Failed', 'status' => false]);
            }

        } else {
            return back()->with('warning', __('Access Denied'));
        }

    }

    public function viewOrder($id)
    {

        $order = Order::with(['orderlogs', 'cancellog', 'refundlogs', 'fullordercancellog', 'shippingaddress', 'invoices', 'user', 'invoices.variant', 'invoices.variant.variantimages', 'invoices.variant.products'])->whereHas('user')->where('order_id', $id)->where('status', '=', '1')->first();

        if (!isset($order)) {
            notify()->error(__('Order not found !'));
            return redirect('/');
        }

        $x = InvoiceDownload::where('order_id', '=', $order->id)->where('vender_id', auth()->id())->get();

        $total = 0;

        $hc = 0;

        $giftcharge = 0;

        foreach ($x as $key => $value) {
            $total += ($value->qty * ($value->price + $value->tax_amount)) + $value->gift_charge + $value->shipping + $value->handlingcharge;
            $hc = $hc + $value->handlingcharge;
            $giftcharge += $value->gift_charge;
        }

        $address = Address::findorfail($order->delivery_address);
        $actvitylogs = OrderActivityLog::where('order_id', $order->id)->orderBy('id', 'desc')->get();
        $inv_cus = Invoice::first();
        return view('seller.order.show', compact('total', 'x', 'order', 'hc', 'address', 'inv_cus', 'actvitylogs', 'giftcharge'));
    }

    public function printOrder($id)
    {
        $order = Order::with(['orderlogs', 'cancellog', 'refundlogs', 'fullordercancellog', 'shippingaddress', 'invoices', 'user', 'invoices.variant', 'invoices.variant.variantimages', 'invoices.variant.products'])->whereHas('user')->find($id);

        $inv_cus = Invoice::first();

        $sellerorders = InvoiceDownload::where('order_id', '=', $order->id)->where('vender_id', auth()->id())->get();

        $total = 0;
        $hc = 0;
        $giftcharge = 0;

        foreach ($sellerorders as $key => $value) {
            $total = $total + ($value->qty * ($value->price + $value->tax_amount)) + $value->gift_charge + $value->shipping + $value->handlingcharge;
            $hc = $hc + $value->handlingcharge;
            $giftcharge += $value->gift_charge;
        }

        return view('seller.order.printorder', compact('total', 'hc', 'inv_cus', 'order', 'sellerorders', 'giftcharge'));
    }

    public function printInvoice($orderID, $id)
    {
        $getInvoice = InvoiceDownload::where('id', $id)->first();
        $inv_cus = Invoice::first();
        $address = Address::findOrFail($getInvoice->order->delivery_address);
        $invSetting = Invoice::where('user_id', $getInvoice->vender_id)->first();

        $design = @file_get_contents(storage_path() . '/app/emart/invoice_design.json');
        $design = json_decode($design);

        if (selected_lang()->rtl_available == 0) {

            return view('seller.order.printinvoice_ltr', compact('invSetting', 'address', 'getInvoice', 'inv_cus', 'design'));

        } else {

            return view('seller.order.printinvoice_rtl', compact('invSetting', 'address', 'getInvoice', 'inv_cus', 'design'));

        }
    }

    public function editOrder($orderid)
    {
        $order = Order::with(['orderlogs', 'cancellog', 'refundlogs', 'fullordercancellog', 'shippingaddress', 'invoices', 'user', 'invoices.variant', 'invoices.variant.variantimages', 'invoices.variant.products'])->whereHas('user')->where('order_id', $orderid)->first();

        $inv_cus = Invoice::first();
        $address = Address::findOrFail($order->delivery_address);
        $actvitylogs = OrderActivityLog::where('order_id', $order->id)->orderBy('id', 'desc')->get();
        $sellerorders = InvoiceDownload::where('order_id', '=', $order->id)->where('vender_id', Auth::user()->id)->get();
        $total = 0;
        $hc = 0;

        foreach ($sellerorders as $key => $value) {
            $total = $total + $value->qty * ($value->price + $value->tax_amount) + $value->gift_charge + $value->shipping + $value->handlingcharge;
            $hc = $hc + $value->handlingcharge;
        }

        return view('seller.order.edit', compact('sellerorders', 'total', 'order', 'address', 'hc', 'inv_cus', 'actvitylogs'));
    }

    public function delete($id)
    {

        if (Auth::check()) {
            if (Auth::user()->role_id == "v" || Auth::user()->role_id == 'a') {

                $inv = Order::findOrFail($id);
                if (Auth::user()->id == $inv->vender_id || Auth::user()->role_id == 'a') {

                    $order = Order::findOrFail($id);
                    $order->status = 0;
                    $order->save();

                    return back()->with('deleted',__('Order has been deleted'));

                } else {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function updateStatus(Request $request, $id)
    {

        if (Auth::check()) {

            $inv = InvoiceDownload::findOrFail($id);

            if (Auth::user()->id == $inv->vender_id || Auth::user()->role_id == 'a') {

                $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                if ($newpendingpay) {
                    $newpendingpay->delete();
                }

                $inv->paid_to_seller = 'NO';
                $inv->status = $request->status;
                $inv->save();
                $inv_cus = Invoice::first();
                $status = ucfirst($request->status);

                $create_activity = new OrderActivityLog();

                $create_activity->order_id = $inv->order_id;
                $create_activity->inv_id = $inv->id;
                $create_activity->user_id = Auth::user()->id;
                $create_activity->variant_id = $inv->variant_id ?? 0;
                $create_activity->simple_pro_id = $inv->simple_pro_id ?? 0;
                $create_activity->log = $status;

                $create_activity->save();

                $lastlogdate = date('d-m-Y | h:i:a', strtotime($create_activity->updated_at));

                if (isset($inv->variant)) {

                    $productname = $inv->variant->products->name;

                    $var_main = variantname($inv->variant);

                }

                if (isset($inv->simple_product)) {

                    $productname = $inv->simple_product->product_name;
                    $var_main = null;

                }

                /*Sending mail & Notifiation on specific event perform*/

                $order_id = $inv->order->order_id;

                if ($request->status == 'shipped') {

                    /*Send Mail to User*/
                    try {
                        $e = Address::findOrFail($inv->order->delivery_address)->email;
                        Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                    } catch (\Exception $e) {
                        //Throw exception if you want //
                    }
                    /*End*/

                    /*Sending Notification*/
                    User::find($inv->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $order_id));
                    /*End*/

                    if ($this->config->sms_channel == '1') {

                        $orderiddb = $inv_cus->order_prefix . $order_id;

                        $smsmsg = 'For Order ' . $orderiddb . ' item ';

                        $smsmsg .= $productname . ' (' . $var_main . ')';

                        $smsmsg .= ' has been ' . ucfirst($request->status);

                        $smsmsg .= ' - ' . config('app.name');

                        if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                            try {

                                User::find($inv->order->user_id)->notify(new SMSNotifcations($smsmsg));

                            } catch (\Exception $e) {

                                Log::error('Error: ' . $e->getMessage());

                            }

                        }

                        if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                            try {
                                Twilosms::sendMessage($smsmsg, '+' . $inv->order->user->phonecode . $inv->order->user->mobile);
                            } catch (\Exception $e) {
                                Log::error('Twillo Error: ' . $e->getMessage());
                            }

                        }

                        if (Module::has('MimSms') && Module::find('MimSms')->isEnabled() && env('DEFAULT_SMS_CHANNEL') == 'mim') {

                            try {

                                $phone = Address::find($inv->order->delivery_address)->phone;
                                sendMimSMS($smsmsg, $phone);

                            } catch (\Exception $e) {
                                Log::error('MIM SMS Error: ' . $e->getMessage());
                            }

                        }

                    }

                } elseif ($request->status == 'processed') {

                } elseif ($request->status == 'pending') {

                } elseif ($request->status == 'delivered') {

                    $from = $inv->order->paid_in_currency;

                    $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();

                    $defcurrate = currency(1.00, $from = $from, $to = $defCurrency->currency->code, $format = false);

                    //Register a record in pending payout if seller system enable (not for admin)
                    if ($inv->seller->role_id == 'v') {

                        $actualprice = sprintf("%2.f", ($inv->price * $inv->qty) * $defcurrate);
                        $actualtax = sprintf("%2.f", ($inv->tax_amount * $inv->qty) * $defcurrate);
                        $actualshipping = sprintf("%2.f", $inv->shipping * $defcurrate);

                        $actualtotal = $actualprice + $actualtax + $actualshipping;

                        $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();
                        $newpendingpay = new PendingPayout;
                        $newpendingpay->orderid = $inv->id;
                        $newpendingpay->sellerid = $inv->seller->id;
                        $newpendingpay->paidby = Auth::user()->id;
                        $newpendingpay->paid_in = $defCurrency->currency->code;
                        $newpendingpay->subtotal = $actualprice + $inv->gift_charge;
                        $newpendingpay->tax = $actualtax;
                        $newpendingpay->shipping = $actualshipping;
                        $newpendingpay->orderamount = $actualtotal + $inv->gift_charge;

                        $newpendingpay->save();

                    }

                    /**  Affialtion process */

                    $aff_system = Affilate::first();

                    if (isset($aff_system) && $aff_system->enable_affilate == 1 && $aff_system->enable_purchase == 1) {

                        $buyer = $inv->order->user;

                        if ($buyer->purchaseorder()->count() == 1) {

                            if (isset($buyer->onetimereferdata) && $buyer->onetimereferdata->procces == 0) {

                                $buyer->onetimereferdata()->update([
                                    'procces' => '1',
                                ]);

                                $wallet = $buyer->onetimereferdata->fromRefered;

                                $given_amount = $buyer->onetimereferdata->amount;

                                if (isset($wallet->wallet) && $wallet->wallet->status == 1) {

                                    $wallet->wallet()->update([
                                        'balance' => $wallet->wallet->balance + $given_amount,
                                    ]);

                                    $wallet->wallet->wallethistory()->create([
                                        'type' => 'Credit',
                                        'log' => 'Referal bonus for first purchase by ' . $buyer->name,
                                        'amount' => $given_amount,
                                        'txn_id' => str_random(8),
                                        'expire_at' => date("Y-m-d", strtotime(date('Y-m-d') . '+365 days')),
                                    ]);

                                }

                            }

                        }

                    }

                    // Cashback Process

                    // If a product is eligibe for cashback credit cashback into user wallet

                    // Check if wallet system is enable

                    $wallet_system = Genral::first()->wallet_enable;

                    if ($wallet_system == 1) {

                        require 'price.php';

                        /** Cashback for simple products */

                        if (isset($inv->simple_product) && $inv->simple_product->cashback_settings && $inv->cashback == '') {

                            $cb = new CashbackController;

                            $finalAmount = sprintf("%.2f", ($inv->qty * $inv->price) + $inv->tax_amount + $inv->handlingcharge + $inv->shipping + $inv->gift_charge);

                            $finalAmount = sprintf("%.2f", $finalAmount * $defcurrate);

                            $cb = (float) sprintf("%.2f", $cb->apply($inv->simple_product->id, $finalAmount));

                            $inv->cashback = $cb * $conversion_rate;

                            $inv->save();

                            $wallet = UserWallet::where('user_id', $inv->order->user->id)->first();

                            if (!$wallet) {
                                $wallet = new UserWallet();
                                $wallet->balance = 0;
                                $wallet->status = 1;
                                $wallet->user_id = $inv->order->user->id;
                            }

                            if (isset($wallet) && $wallet->status == 1) {

                                $wallet->balance = $wallet->balance + $cb;

                                $wallet->save();

                                $cb_txn_id = 'cashback_' . str_random(8);

                                //adding log in history

                                $walletlog = new UserWalletHistory();
                                $walletlog->wallet_id = $wallet->id;
                                $walletlog->type = 'Credit';
                                $walletlog->log = 'Cashback received on order ' . $inv->order->order_id;
                                $walletlog->amount = sprintf("%.2f", $cb);
                                $walletlog->txn_id = $cb_txn_id;
                                $walletlog->expire_at = now()->addDays(365);
                                $walletlog->save();

                                // Putting order log in admin wallet logs

                                $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

                                $adminwalletlog = new OrderWalletLogs;
                                $adminwalletlog->wallet_txn_id = $cb_txn_id;
                                $adminwalletlog->note = 'Cashback received on order ' . $order_id;
                                $adminwalletlog->type = 'Credit';
                                $adminwalletlog->amount = sprintf("%.2f", $cb);
                                $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance + sprintf("%.2f", $cb) : sprintf("%.2f", $cb);

                                $adminwalletlog->save();

                                try {

                                    $msg1 = __('added successfully to your wallet !');
                                    $txnid = $cb_txn_id;
                                    $amount = sprintf("%.2f", $cb);
                                    $msg2 = 'Updated wallet balance is : ';
                                    $balance = $wallet->balance;

                                    Mail::to($wallet->user->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $defCurrency));

                                } catch (\Exception $e) {

                                }

                            }

                        }

                        /** Cashback for variant products */

                        if (isset($inv->variant) && $inv->variant->products->cashback_settings && $inv->cashback == '') {

                            $cb = new CashbackController;

                            $finalAmount = sprintf("%.2f", ($inv->qty * $inv->price) + $inv->tax_amount + $inv->handlingcharge + $inv->shipping + $inv->gift_charge);

                            $cb = (float) sprintf("%.2f", $cb->apply($inv->variant->products->id, $finalAmount, $type = 'variant_product'));

                            $inv->cashback = $cb;

                            $inv->save();

                            $wallet = UserWallet::where('user_id', $inv->order->user->id)->first();

                            if (!$wallet) {

                                $wallet = new UserWallet();
                                $wallet->balance = 0;
                                $wallet->status = 1;
                                $wallet->user_id = $inv->order->user->id;

                            }

                            if (isset($wallet) && $wallet->status == 1) {

                                $wallet->balance = $wallet->balance + sprintf("%.2f", $cb * $defcurrate);
                                $wallet->save();

                                $cb_txn_id = 'cashback_' . str_random(8);

                                //adding log in history

                                $walletlog = new UserWalletHistory();
                                $walletlog->wallet_id = $wallet->id;
                                $walletlog->type = 'Credit';
                                $walletlog->log = 'Cashback received on order ' . $inv->order->order_id;
                                $walletlog->amount = sprintf("%.2f", $cb);
                                $walletlog->txn_id = $cb_txn_id;
                                $walletlog->expire_at = now()->addDays(365);
                                $walletlog->save();

                                // Putting order log in admin wallet logs

                                $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

                                $adminwalletlog = new OrderWalletLogs;
                                $adminwalletlog->wallet_txn_id = $cb_txn_id;
                                $adminwalletlog->note = 'Cashback received on order ' . $order_id;
                                $adminwalletlog->type = 'Credit';
                                $adminwalletlog->amount = sprintf("%.2f", $cb);
                                $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance + sprintf("%.2f", $cb) : sprintf("%.2f", $cb);

                                $adminwalletlog->save();

                                try {

                                    $msg1 = __('cashback added successfully to your wallet !');
                                    $txnid = $cb_txn_id;
                                    $amount = sprintf("%.2f", $cb);
                                    $msg2 = 'Updated wallet balance is : ';
                                    $balance = $wallet->balance;

                                    Mail::to($wallet->user->email)->send(new WalletMail($msg1, $txnid, $msg2, $balance, $amount, $defCurrency));

                                } catch (\Exception $e) {

                                }

                            }

                        }

                    }

                    //End

                    /*Send Mail to User*/
                    try {
                        $e = Address::findOrFail($inv->order->delivery_address)->email;
                        Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                    } catch (\Exception $e) {
                        //Throw exception if you want //
                    }
                    /*End*/

                    /*Sending Notification*/
                    User::find($inv->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $order_id));
                    /*End*/

                    if ($this->config->sms_channel == '1') {

                        $orderiddb = $inv_cus->order_prefix . $order_id;

                        $smsmsg = 'For Order ' . $orderiddb . ' item ';

                        $smsmsg .= $productname . ' (' . $var_main . ')';

                        $smsmsg .= ' has been ' . ucfirst($request->status);

                        $smsmsg .= ' - ' . config('app.name');

                        if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                            try {

                                User::find($inv->order->user_id)->notify(new SMSNotifcations($smsmsg));

                            } catch (\Exception $e) {

                                \Log::error('Error: ' . $e->getMessage());

                            }

                        }

                        if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                            try {
                                Twilosms::sendMessage($smsmsg, '+' . $inv->order->user->phonecode . $inv->order->user->mobile);
                            } catch (\Exception $e) {
                                \Log::error('Twillo Error: ' . $e->getMessage());
                            }

                        }

                        if (Module::has('MimSms') && Module::find('MimSms')->isEnabled() && env('DEFAULT_SMS_CHANNEL') == 'mim') {

                            try {

                                $phone = Address::find($inv->order->delivery_address)->phone;
                                sendMimSMS($smsmsg, $phone);

                            } catch (\Exception $e) {
                                Log::error('MIM SMS Error: ' . $e->getMessage());
                            }

                        }
                    }

                } elseif ($request->status == 'cancel_request') {

                    $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                    if (isset($newpendingpay)) {
                        $newpendingpay->delete();
                    }

                    /*Send Mail to User*/
                    $status = 'Request for Cancellation';
                    try {
                        $e = Address::findOrFail($inv->order->delivery_address)->email;
                        Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                    } catch (\Swift_TransportException $e) {
                        //Throw exception if you want //
                    }
                    /*End*/

                } elseif ($request->status == 'canceled') {

                    $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                    if (isset($newpendingpay)) {
                        $newpendingpay->delete();
                    }

                    /*Send Mail to User*/
                    try {
                        $e = Address::findOrFail($inv->order->delivery_address)->email;
                        Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                    } catch (\Swift_TransportException $e) {
                        //Throw exception if you want //
                    }
                    /*End*/

                    /*Sending Notification*/
                    User::find($inv->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $order_id));
                    /*End*/

                    if ($this->config->sms_channel == '1') {

                        $orderiddb = $inv_cus->order_prefix . $order_id;

                        $smsmsg = 'For Order ' . $orderiddb . ' item ';

                        $smsmsg .= $productname . ' (' . $var_main . ')';

                        $smsmsg .= ' has been ' . ucfirst($request->status);

                        $smsmsg .= ' - ' . config('app.name');

                        if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                            try {

                                User::find($inv->order->user_id)->notify(new SMSNotifcations($smsmsg));

                            } catch (\Exception $e) {

                                Log::error('Error: ' . $e->getMessage());

                            }

                        }

                        if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                            try {
                                Twilosms::sendMessage($smsmsg, '+' . $inv->order->user->phonecode . $inv->order->user->mobile);
                            } catch (\Exception $e) {
                                Log::error('Twillo Error: ' . $e->getMessage());
                            }

                        }

                        if (Module::has('MimSms') && Module::find('MimSms')->isEnabled() && env('DEFAULT_SMS_CHANNEL') == 'mim') {

                            try {

                                $phone = Address::find($inv->order->delivery_address)->phone;
                                sendMimSMS($smsmsg, $phone);

                            } catch (\Exception $e) {
                                Log::error('MIM SMS Error: ' . $e->getMessage());
                            }

                        }
                    }

                } elseif ($request->status == 'return_request') {

                    $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                    if (isset($newpendingpay)) {
                        $newpendingpay->delete();
                    }

                    /*Send Mail to User*/
                    $status = 'Request for return';

                    try {
                        $e = Address::findOrFail($inv->order->delivery_address)->email;
                        Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                    } catch (\Swift_TransportException $e) {
                        //Throw exception if you want //
                    }

                    /*End*/

                } elseif ($request->status == 'returned') {

                    $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                    if (isset($newpendingpay)) {
                        $newpendingpay->delete();
                    }

                    /*Send Mail to User*/
                    try {
                        $e = Address::findOrFail($inv->order->delivery_address)->email;
                        Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                    } catch (\Swift_TransportException $e) {
                        //Throw exception if you want //
                    }
                    /*End*/

                    /*Sending Notification*/
                    User::find($inv->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $order_id));
                    /*End*/

                    if ($this->config->sms_channel == '1') {

                        $orderiddb = $inv_cus->order_prefix . $order_id;

                        $smsmsg = 'For Order ' . $orderiddb . ' item ';

                        $smsmsg .= $productname . ' (' . $var_main . ')';

                        $smsmsg .= ' has been ' . ucfirst($request->status);

                        $smsmsg .= ' - ' . config('app.name');

                        if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                            try {

                                User::find($inv->order->user_id)->notify(new SMSNotifcations($smsmsg));

                            } catch (\Exception $e) {

                                \Log::error('Error: ' . $e->getMessage());

                            }

                        }

                        if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                            try {
                                Twilosms::sendMessage($smsmsg, '+' . $inv->order->user->phonecode . $inv->order->user->mobile);
                            } catch (\Exception $e) {
                                \Log::error('Twillo Error: ' . $e->getMessage());
                            }

                        }

                        if (Module::has('MimSms') && Module::find('MimSms')->isEnabled() && env('DEFAULT_SMS_CHANNEL') == 'mim') {

                            try {

                                $phone = Address::find($inv->order->delivery_address)->phone;
                                sendMimSMS($smsmsg, $phone);

                            } catch (\Exception $e) {
                                Log::error('MIM SMS Error: ' . $e->getMessage());
                            }

                        }
                    }

                }

                /*end*/
                return response()->json(['variant' => $var_main, 'proname' => $productname, 'lastlogdate' => $lastlogdate, 'dstatus' => $status, 'id' => $inv->id, 'status' => $request->status, 'invno' => $inv_cus->prefix . $inv->inv_no . $inv_cus->postfix]);

            } else {
                return abort(404);
            }

        } else {
            return abort(404);
        }

    }
}
