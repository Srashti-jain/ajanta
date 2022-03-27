<?php
namespace App\Http\Controllers;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\FailedTranscations;
use Session;
use Illuminate\Support\Str;

class PaytmController extends Controller
{
    public function payProcess($order_id,$amount,$name,$email,$phone,$purpose,$error)
    {
        
        $orderID = $order_id;
        $payment = PaytmWallet::with('receive');

        session()->put('error_url',$error);

        session()->save();

        $payment->prepare([
            'order'         => $orderID,
            'user'          => auth()->id(),
            'mobile_number' => $phone,
            'email'         => $email,
            'amount'        => $amount,
            'callback_url'  => url('/paidviapaytmsuccess'),
        ]);

        return $payment->receive();
    }

    public function paymentCallback()
    {

        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();

        $order_id = session()->get('order_id');
        
        if ($transaction->isSuccessful()) {
            
            $txn_id = $response['TXNID'];

            $payment_status = 'yes';

            if(Session::get('payment_type') == 'order')
            {
                Session::forget('payment_type');
                Session::forget('error_url');
                Session::forget('order_id');
                
                $payment_status = 'yes';
                $checkout = new PlaceOrderController;
                return $checkout->placeorder($txn_id,'Paytm',$order_id,$payment_status);

            }else{
                
                Session::forget('payment_type');
                $preorder = new PreorderController;
                return $preorder->completePreorder($invoice = session()->get('inv_preorder'),$txn_id);

            }
           

        } elseif ($transaction->isFailed()) {

            notify()->error($transaction->getResponseMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'PAYTM_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect(session()->get('order_url'));

        } elseif ($transaction->isOpen()) {
            //Transaction Open/Processing

        } else {

            notify()->error($transaction->getResponseMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'PAYTM_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect(session()->get('order_url'));
        }

    }
}
