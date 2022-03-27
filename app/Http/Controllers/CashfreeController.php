<?php

namespace App\Http\Controllers;

use App\Address;
use App\FailedTranscations;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CashfreeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->apiEndpoint = env('CASHFREE_END_POINT');
    }

    public function pay($order_id,$amount,$name,$email,$phone,$purpose,$error)
    {
       
        if (session()->get('currency')['id'] != 'INR') {
            notify()->error(__('Cashfree Only Support INR Payment !'));
            return redirect(route('order.review'));
        }

        $c = strlen($phone);

        session()->put('error_url',$error);

        session()->save();

        if ($c < 10) {

            $sentfromlastpage = 0;
            notify()->error("Invalid Phone no. ");
            return redirect($error);
        }

        $opUrl = $this->apiEndpoint . "/api/v1/order/create";

        session()->put('order_id',str_replace('_pre','',$order_id));
        session()->put('error_url',$error);
        session()->save();

        $cf_request = array();
        $cf_request["appId"]         = env('CASHFREE_APP_ID');
        $cf_request["secretKey"]     = env('CASHFREE_SECRET_KEY');
        $cf_request["orderId"]       = $order_id;
        $cf_request["orderAmount"]   = $amount;
        $cf_request["orderNote"]     = $purpose;
        $cf_request["customerPhone"] = $phone;
        $cf_request["customerName"]  = $name;
        $cf_request["customerEmail"] = $email;
        $cf_request["returnUrl"]     = url('payviacashfree/success');

        $timeout = 20;

        $request_string = "";

        foreach ($cf_request as $key => $value) {
            $request_string .= $key . '=' . rawurlencode($value) . '&';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$opUrl?");
        curl_setopt($ch, CURLOPT_POST, count($cf_request));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $curl_result = curl_exec($ch);
        curl_close($ch);

        $jsonResponse = json_decode($curl_result);

        if ($jsonResponse->{'status'} == "OK") {
            $paymentLink = $jsonResponse->{"paymentLink"};
            return redirect($paymentLink);
        } else {
            
            notify()->error($jsonResponse->{'reason'});
            return redirect($error);
        }
    }

    public function success(Request $request)
    {

        if ($request->txStatus == 'CANCELLED') {
            Session::put('from-pay-page', 'yes');
            Session::put('page-reloaded', 'yes');
            notify()->warning($request->txMsg);
            return redirect(session()->get('error_url'));
        }

        $response = Http::timeout(30)->withHeaders(["cache-control: no-cache"])->asForm()->post($this->apiEndpoint . '/api/v1/order/info/status', [
            'appId' => env('CASHFREE_APP_ID'),
            'secretKey' => env('CASHFREE_SECRET_KEY'),
            'orderId' => $request->orderId,
        ]);

        if ($response->successful()) {

            $result = $response->json();

            if ($result['orderStatus'] == 'PAID') {

                
                $txn_id = $result['referenceId'];

                $payment_status = 'yes';

                $order_id = session()->get('order_id');

                if(Session::get('payment_type') == 'order')
                {
                    Session::forget('payment_type');
                    Session::forget('error_url');
                    Session::forget('order_id');
                    
                    $payment_status = 'yes';
                    $checkout = new PlaceOrderController;
                    return $checkout->placeorder($txn_id,$payment_method = 'Cashfree',$order_id,$payment_status);

                }else{
                    
                    Session::forget('payment_type');
                    $preorder = new PreorderController;
                    return $preorder->completePreorder($invoice = session()->get('inv_preorder'),$txn_id);

                }

                
            } else {
                notify()->error('Payment Failed !');
                $failedTranscations = new FailedTranscations();
                $failedTranscations->txn_id = 'CASHFREE_FAILED_' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();
                return redirect(session()->get('error_url'));
            }

        } else {
            notify()->error('Payment Failed !');
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'CASHFREE_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(session()->get('error_url'));
        }

    }
}
