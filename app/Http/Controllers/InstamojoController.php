<?php
namespace App\Http\Controllers;

use App\FailedTranscations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class InstamojoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function payment($order_id,$amount,$name,$email,$phone,$purpose,$error)
    {   


        if ($phone < 10) {
            notify()->error(__("Invalid Phone no ! "));
            return redirect($error);
        }


        $order_id = $order_id;
        
        session()->put('error_url',$error);

        session()->save();
        
        $api = new \Instamojo\Instamojo(config('services.instamojo.api_key'), config('services.instamojo.auth_token'), config('services.instamojo.url'));

        try
        {

            $response = $api->paymentRequestCreate(array(
                "purpose"       => $purpose,
                "amount"        => $amount,
                "buyer_name"    => $name,
                "send_email"    => true,
                "send_sms"      => true,
                "email"         => $email,
                "phone"         => $phone,
                "redirect_url"  => url('/paidsuccess'),
            ));

            header('Location: ' . $response['longurl']);

            exit();

        } catch (\Exception $e) {

            notify()->error(__(__('Payment Failed !')),$e->getMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = $order_id;
            $failedTranscations->txn_id = 'INSTAMOJO_FAILED_' . str_random(5);
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect($error);

        }

    }

    public function success(Request $request)
    {

        try
        {

            $api = new \Instamojo\Instamojo(config('services.instamojo.api_key'), config('services.instamojo.auth_token'), config('services.instamojo.url'));

            $response = $api->paymentRequestStatus(request('payment_request_id'));

            if (!isset($response['payments'][0]['status'])) {

                notify()->error(__('Payment Failed !'));
                return redirect(session()->get('error_url'));
                

            } else if ($response['payments'][0]['status'] != 'Credit') {

                notify()->error(__('Payment Failed !'));
                return redirect(session()->get('error_url'));

            } else {

               
                $txn_id = $response['payments'][0]['payment_id'];

                $payment_method = 'Instamojo';

                $order_id = session()->get('order_id');

                if(Session::get('payment_type') == 'order')
                {
                    Session::forget('payment_type');
                    Session::forget('error_url');
                    Session::forget('order_id');
                    
                    $payment_status = 'yes';
                    $checkout = new PlaceOrderController;
                    return $checkout->placeorder($txn_id,$payment_method,$order_id,$payment_status);

                }else{
                    
                    Session::forget('payment_type');
                    $preorder = new PreorderController;
                    return $preorder->completePreorder($invoice = session()->get('inv_preorder'),$txn_id);

                }

            }
        } catch (\Exception $e) {

            notify()->error($e->getMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'INSTAMOJO_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();

            return redirect(session()->get('error_url'));
            

        }

    }

    #endoflast

}
