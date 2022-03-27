<?php
namespace App\Http\Controllers;


use App\FailedTranscations;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payWithpaypal($order_id,$amount,$name,$email,$phone,$purpose,$error)
    {
        $payout = $amount;

        $payout = round($payout,2);

        session()->put('error_url',$error);
        session()->put('order_id',$order_id);

        session()->save();

        $setcurrency = Session::get('currency')['id'];

        if($setcurrency == 'INR' && env('PAYPAL_MODE') == 'sandbox'){

            notify()->error(__('INR is not supported in paypal sandbox mode try with other currency !'),__('Currency not supported !'));
            return redirect(route('order.review'));

        }

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1')
        /** item name **/
            ->setCurrency($setcurrency)->setQuantity(1)
            ->setPrice($payout);
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array(
            $item_1,
        ));
        $amount = new Amount();
        $amount->setCurrency($setcurrency)->setTotal($payout);
        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($item_list)->setDescription($purpose);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status'))
            ->setCancelUrl(route('order.review'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array(
            $transaction,
        ));

        try
        {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {

                notify()->error('Connection timeout !');
                $failedTranscations = new FailedTranscations;
                $failedTranscations->order_id = $order_id;
                $failedTranscations->txn_id = 'PAYPAL_FAILED_' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();
                return redirect($error);

            } else {

                notify()->error(__('Some error occur, Sorry for inconvenient'));
                $failedTranscations = new FailedTranscations;
                $failedTranscations->order_id = $order_id;
                $failedTranscations->txn_id = 'PAYPAL_FAILED_' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();

                return redirect($error);
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }

        notify()->error(__('Unknown error occurred !'));
        return redirect($error);
    }

    public function getPaymentStatus(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if (empty($request->get('PayerID')) || empty($request->get('token'))) {

            notify()->error('Payment failed !');

            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = session()->get('order_id');
            $failedTranscations->txn_id = 'PAYPAL_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();

            return redirect(session()->get('error_url'));
        }

      

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /**Execute the payment **/
        $response = $payment->execute($execution, $this->_api_context);
        $order_id = session()->get('order_id');

        if ($response->getState() == 'approved') {

            $transactions = $payment->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            $saleId = $sale->getId();
            $payment_status = 'yes';
            

            if(Session::get('payment_type') == 'order')
            {
                Session::forget('payment_type');
                Session::forget('error_url');
                Session::forget('order_id');
                
                $payment_status = 'yes';
                $checkout = new PlaceOrderController;
                return $checkout->placeorder($payment_id,'Paypal',$order_id,$payment_status,$saleId);

            }else{
                
                Session::forget('payment_type');
                $preorder = new PreorderController;
                return $preorder->completePreorder($invoice = session()->get('inv_preorder'),$txn_id = $payment_id);

            }

            
            /*End*/

        } else {
            notify()->error("Payment Failed !");
            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = $order_id;
            $failedTranscations->txn_id = 'PAYPAL_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(session()->get('error_url'));
        }

    }

}
