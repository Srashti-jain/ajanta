<?php

namespace App\Http\Controllers;

use App\Address;
use App\Config;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderStatus;
use App\Notifications\SendOrderStatus;
use App\Notifications\SMSNotifcations;
use App\OrderActivityLog;
use App\PendingPayout;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilosms;

class UpdateOrderController extends Controller
{

    public function __construct()
    {
        $this->config = Config::first();
    }

    public function update(Request $request,$id){

       $inv_cus = Invoice::first();
       $invoice = InvoiceDownload::find($id);

       
       if(!$invoice){
            notify()->error(__('Invoice or linked variant not found !'),'404');
            return redirect(route("order.index"));
       }

       if(in_array($invoice->status,['canceled','delivered','Refund Pending','ret_ref','refunded','return_request'])){
            notify()->warning(__('Item already shipped !'));
            return redirect(route('admin.order.edit',$invoice->order->order_id));
       }

       if(Auth::user()->id == $invoice->vender_id && Auth::user()->role_id == 'v'){
            return view('seller.order.updatestatus',compact('invoice','inv_cus'));
       }else if(Auth::user()->role_id == 'a'){
            return view('admin.order.updatestatus',compact('invoice','inv_cus'));
       }
      

    }

    public function shipproduct(Request $request,$id){

        $invoice = InvoiceDownload::find($id);

       
        if(!$invoice){
             notify()->error(__('Invoice or linked variant not found !'),'404');
             return redirect(route("order.index"));
        }

        if(in_array($invoice->status,['canceled','delivered','Refund Pending','ret_ref','refunded','return_request'])){
            notify()->warning(__('Item already shipped !'));
            return redirect(route('admin.order.edit',$invoice->order->order_id));
       }

       $request->validate([
           'courier_channel' => 'required|string',
           'tracking_link' => 'required|string',
           'exp_delivery_date' => 'required'
       ]);

       if (Auth::user()->id == $invoice->vender_id || Auth::user()->role_id == 'a') {

            $newpendingpay = PendingPayout::where('orderid', '=', $invoice->id)->first();

            if ($newpendingpay) {
                $newpendingpay->delete();
            }

            $invoice->paid_to_seller = 'NO';
            $invoice->status = 'shipped';
            $invoice->save();
            $inv_cus = Invoice::first();
            $status = ucfirst('shipped');
            $invoice->courier_channel = $request->courier_channel;
            $invoice->tracking_link = $request->tracking_link;
            $invoice->exp_delivery_date = $request->exp_delivery_date;
            $invoice->save();

            
            $create_activity = new OrderActivityLog();

            $create_activity->order_id = $invoice->order_id;
            $create_activity->inv_id = $invoice->id;
            $create_activity->user_id = Auth::user()->id;
            $create_activity->variant_id = $invoice->variant_id ?? 0;
            $create_activity->simple_pro_id = $invoice->simple_pro_id ?? 0;
            $create_activity->log = $status;

            $create_activity->save();

            if(isset($invoice->simple_product)){

                $productname = $invoice->simple_product->product_name;
                $var_main = NULL;

            }

            if (isset($invoice->variant)) {
                $productname = $invoice->variant->products->name;
                $var_main = variantname($invoice->variant);
            }

            // Send Mail to User 

            try {
                $e = Address::findOrFail($invoice->order->delivery_address)->email;
                Mail::to($e)->send(new OrderStatus($inv_cus, $invoice, $status));
            } catch (\Exception $e) {
                //Throw exception if you want //
            }

            /*Sending Notification*/
                User::find($invoice->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $invoice->order->order_id));
            /*End*/

            if ($this->config->sms_channel == '1') {

                $orderiddb = $inv_cus->order_prefix . $invoice->order->order_id;

                $smsmsg = 'For Order #' . $orderiddb . ' Item ';

                $smsmsg .= $productname . ' (' . $var_main . ')';

                $smsmsg .= ' has been ' . ucfirst($request->status);

                $smsmsg .= '%0a - ' . config('app.name');

                if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                    try {

                        User::find($invoice->order->user_id)->notify(new SMSNotifcations($smsmsg));

                    } catch (\Exception $e) {

                        Log::error('Error: ' . $e->getMessage());

                    }

                }

                if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                    try {
                        Twilosms::sendMessage($smsmsg, '+' . $invoice->order->user->phonecode . $invoice->order->user->mobile);
                    } catch (\Exception $e) {
                        Log::error('Twillo Error: ' . $e->getMessage());
                    }

                }
            }

       }

       notify()->success(__('Item successfully shipped'),'Success');

        if(Auth::user()->id == $invoice->vender_id && Auth::user()->role_id == 'v'){
            return redirect(route('seller.order.edit',$invoice->order->order_id));
        }else if(Auth::user()->role_id == 'a'){
            return redirect(route('admin.order.edit',$invoice->order->order_id));
        }

      

    }
}
