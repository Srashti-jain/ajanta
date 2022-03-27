<?php

namespace App\Http\Controllers;

use App\Address;
use App\FailedTranscations;
use App\Invoice;
use Auth;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Crypt;
use Illuminate\Http\Request;
use Validator;

class StripController extends Controller
{

    public function stripayment(Request $request)
    {

        require_once 'price.php';

        $amount = round(Crypt::decrypt($request->amount), 2);

        $expiry = explode('/', $request->expiry);

        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'expiry' => 'required',
            'cvc' => 'required|max:3',
            'amount' => 'required',
        ]);

        $cart_table = Auth::user()->cart;
        $total = 0;

        $total = getcarttotal();

        $total = sprintf("%.2f", $total * $conversion_rate);

        if (round($request->actualtotal, 2) != $total) {

            notify()->error(__('Payment has been modifed !'), __('Please try again !'));
            return redirect(route('order.review'));

        }

        $inv_cus = Invoice::first();

        #Creating order ID
        $order_id = uniqid();

        $input = $request->all();

        if ($validator->passes()) {

            $input = array_except($input, array('_token'));

            $stripe = Stripe::make(env('STRIPE_SECRET'));

            if ($stripe == '' || $stripe == null) {
                notify()->error(__("Stripe key not found !"), __('Error'));
                return redirect(route('order.review'));
            }

            try {

                $month = (int) $expiry[0];
                $year = (int) $expiry[1];

                $address = Address::findorfail(session()->get('address'));

                if (auth()->user()->stripe_id != '') {

                    $customer = $stripe->customers()->create([
                        'email' => auth()->user()->email,
                        'name' => auth()->user()->name,
                        'address' => [
                            'line1' => $address->address,
                            'postal_code' => $address->pin_code,
                            'city' => $address->getcity->name,
                            'state' => $address->getstate->name,
                            'country' => $address->getCountry->iso
                        ],
                    ]);

                    auth()->user()->update([
                        'stripe_id' => $customer['id'],
                    ]);

                }

                //Get payment method id using PaymentMethod API

                $payment_method = $stripe->paymentMethods()->create([
                    'type' => 'card',
                    'card' => [
                        'number' => $request->get('number'),
                        'exp_month' => $month,
                        'exp_year' => $year,
                        'cvc' => $request->get('cvc'),
                    ],
                    'billing_details' => [
                        'address' => [
                            'line1' => __('510 Townsend St'),
                            'postal_code' => 98140,
                            'city' => __('San Francisco'),
                            'state' => __('CA'),
                            'country' => __('US')
                        ],
                        'name' => $request->name,
                        'email' => auth()->user()->email,

                    ],
                ]);


                //Get 3d Secured your created token and payment method id using PaymentIntent API
                if ($payment_method['id']) {

                    
                    $payment = $stripe->paymentIntents()->create([

                        'currency' => session()->get('currency')['id'],
                        'amount' => $amount,
                        'payment_method' => $payment_method['id'],
                        'payment_method_types' => ['card'],
                        'confirm' => true,
                        'description' => "Payment For Order $inv_cus->order_prefix $order_id",
                        'return_url' => url('/stripe/3ds'),
                        'shipping' => [
                            'name' => $address->name,
                            'address' => [
                                'line1' => __('510 Townsend St'),
                                'postal_code' => 98140,
                                'city' => __('San Francisco'),
                                'state' => __('CA'),
                                'country' => __('US')
                            ],
                        ],

                    ]);

                    if ($payment['status'] === 'succeeded') {

                        $order_id = uniqid();

                        $txn_id = $payment['charges']['data'][0]['id'];

                        $payment_status = 'yes';

                        $checkout = new PlaceOrderController;

                        return $checkout->placeorder($txn_id, 'Stripe', $order_id, $payment_status);

                    } elseif ($payment['status'] === 'requires_source_action') {

                        // 3ds secure payment page redirect

                        if (isset($payment['next_action']) && isset($payment['next_action']['redirect_to_url']) && isset($payment['next_action']['redirect_to_url']['url'])) {

                            // Capture the redirect url
                            $redirect = $payment['next_action']['redirect_to_url']['url'];
                            //301 = permanent redirection
                            return redirect($redirect, 301);

                        } else {
                            notify()->error(__('Payment failed'), __('Redirect url not found !'));
                            return redirect(route('order.review'));
                        }

                    } else {

                        $failedTranscations = new FailedTranscations;
                        $failedTranscations->txn_id = 'STRIPE_FAILED_' . str_random(5);
                        $failedTranscations->user_id = auth()->id();
                        $failedTranscations->save();
                        notify()->error('Payment failed');
                        return redirect(route('order.review'));

                    }

                    return view('front.stripe3d', compact('payment'));

                }
            } catch (\Exception $e) {

                notify()->error($e->getMessage());
                $failedTranscations = new FailedTranscations;
                $failedTranscations->txn_id = 'STRIPE_FAILED_' . str_random(5);
                $failedTranscations->user_id = auth()->id();
                $failedTranscations->save();

                return redirect(route('order.review'));
            }
        }
        notify()->error(__("Card details are incomplete !"));
        return redirect(route('order.review'));
    }

    public function complete3ds(Request $request)
    {

        $stripe = Stripe::make(env('STRIPE_SECRET'));

        $result = $stripe->paymentIntents()->find($request->payment_intent);

        if ($result['status'] === 'succeeded') {

            $txn_id = $result['charges']['data'][0]['id'];

            $order_id = uniqid();

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id, 'Stripe', $order_id, $payment_status);

        } else {
            $error = $result['last_payment_error']['message'];
            notify()->error($error);
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = $result['id'];
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();

            return redirect(route('order.review'));

        }

    }

}
