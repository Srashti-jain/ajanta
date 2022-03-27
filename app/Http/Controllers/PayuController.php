<?php
namespace App\Http\Controllers;

use App\Address;
use App\FailedTranscations;
use App\Invoice;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tzsk\Payu\Concerns\Attributes;
use Tzsk\Payu\Concerns\Customer;
use Tzsk\Payu\Concerns\Transaction;
use Tzsk\Payu\Facades\Payu;
use Illuminate\Support\Str;

class PayuController extends Controller
{

    public function refund()
    {

        $ch = curl_init();
        $postUrl = 'https://test.payumoney.com/treasury/merchant/refundPayment?merchantKey=kOFGXHRT&paymentId=249863078&refundAmount=224';

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authorization: 6+m8xqo3Kmhr+FNF3QkGn+rzLxCn2LI3idnZuumgiVY=',
        ));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);

        $result = json_decode($output, true);

        return $result;

    }

    public function payment($order_id,$amount,$name,$email,$phone,$purpose,$error)
    {
      
        if (Session::get('currency')['id'] != 'INR') {
            notify()->error('Currency is in ' . strtoupper(Session::get('currency')['id']) . ' and payumoney only support INR currency.');
            return redirect($error);
        }

        $txnid = uniqid();
        Session::put('gen_txn', $txnid);

        session()->put('error_url',$error);

        session()->save();

        $customer = Customer::make()
        ->firstName($name)
        ->email($email)
        ->phone($phone);

        $attributes = Attributes::make()
        ->udf1("Payment For Order $order_id");

        $transaction = Transaction::make()
        ->charge($amount)
        ->for($purpose)
        ->with($attributes)
        ->to($customer);
        
        return Payu::initiate($transaction)->redirect(url('payment/status'));

    }

    public function status()
    {

        $payment = Payu::capture();  

        if ($payment->successful()) {

            $txn_id = $payment->response('payuMoneyId');

            $payment_status = 'yes';

            $order_id = session()->get('order_id');

            if(Session::get('payment_type') == 'order')
            {
                Session::forget('payment_type');
                Session::forget('error_url');
                Session::forget('order_id');
                
                $payment_status = 'yes';
                $checkout = new PlaceOrderController;
                return $checkout->placeorder($txn_id,'PayU',session()->get('order_id'),$payment_status);

            }else{
                
                Session::forget('payment_type');
                $preorder = new PreorderController;
                return $preorder->completePreorder($invoice = session()->get('inv_preorder'),$txn_id);

            }

        } else {

            notify()->error(__("Payment not done due to some payumoney server issue !"));
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'PAYU_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(session()->get('order_url'));

        }

    }
}
