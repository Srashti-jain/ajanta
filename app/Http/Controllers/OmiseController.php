<?php

namespace App\Http\Controllers;


use App\FailedTranscations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class OmiseController extends Controller
{
    public function pay(Request $request)
    {

        if (session()->get('currency')['id'] != 'THB' && session()->get('currency')['id'] != 'JPY') {
            notify()->warning(__('Currency not supported for this payment method !'));
            return redirect(route('order.review'));
        }

        require_once base_path() . '/vendor/omise/omise-php/lib/Omise.php';

        require_once 'price.php';

        $total = 0;

        $total = getcarttotal();
    
        $total = sprintf("%.2f",$total * $conversion_rate);

        $amount = sprintf("%.2f", Crypt::decrypt($request->amount));

        if (round($request->actualtotal, 2) != $total) {
            notify()->error(__('Payment has been modifed !'), __('Please try again !'));
            return redirect(route('order.review'));

        }

        define('OMISE_API_VERSION', env('OMISE_API_VERSION'));
        define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
        define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));

        try {

            $charge = \OmiseCharge::create(array(
                'amount' => $amount * 100,
                'currency' => 'thb',
                'card' => $_POST["omiseToken"],
            ));

        } catch (\Exception $e) {

            notify()->error('Payment Failed !');
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'OMISE_FAILED_' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(route('order.review'));

        }

        if ($charge['status'] == 'successful') {

            $txn_id = $charge['id'];

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'Omise',session()->get('order_id'),$payment_status);

        } else {
            notify()->error('Payment Failed !');
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'OMISE_FAILED_' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(route('order.review'));
        }
    }
}
