<?php

namespace App\Http\Controllers;


use App\FailedTranscations;
use Auth;
use Illuminate\Http\Request;
use Rave;
use Illuminate\Support\Str;

class RavePaymentController extends Controller
{
    public function pay(Request $request){

        require_once 'price.php';

        $total = 0;
        
        $total = getcarttotal();
        
       
        $total = sprintf("%.2f",$total * $conversion_rate);

        if (sprintf("%.2f",$request->actualtotal) != $total) {
            notify()->error(__('Payment has been modifed !'),__('Please try again !'));
            return redirect(route('order.review'));

        }

        if(session()->get('currency')['id'] != 'NGN'){
            notify()->warning(__('Currency not supported !'));
            return redirect(route('order.review'));
        }

        Rave::initialize(route('rave.callback'));
    }

    public function callback(Request $request){

        require_once 'price.php';

        $result = json_decode($request->resp, true);

        $txn_id = $result['tx']['txRef'];

        $data = Rave::verifyTransaction($txn_id);

        if ($data->status == 'success') {

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'Rave',session()->get('order_id'),$payment_status);

        }else{

            notify()->error(__('Payment Failed !'));
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'RAVE_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect(route('order.review'));
            
        }

    }
}
