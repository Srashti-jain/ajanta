<?php
namespace App\Http\Controllers;

use App\Invoice;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankTransferController extends Controller
{
    public function payProcess(Request $request)
    {
        require_once 'price.php';

        $validator = Validator::make($request->all(), [
            'purchase_proof' => 'required|mimes:jpg,jpeg,png,webp,bmp',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors());
            $sentfromlastpage = 0;
            return view('front.checkout', compact('sentfromlastpage', 'conversion_rate'));
        }

        $total = 0;

        $total = getcarttotal();
    
       
        $total = sprintf("%.2f",$total * $conversion_rate);


        if (round($request->actualtotal, 2) != round($total, 2)) {

            notify()->error(__('Payment has been modifed !'), __('Please try again !'));
            return redirect(route('order.review'));

        }

        $inv_cus = Invoice::first();

        $txn_id = $inv_cus->cod_prefix . str_random(10) . $inv_cus->cod_postfix;

        $payment_status = 'no';

        $checkout = new PlaceOrderController;

        return $checkout->placeorder($txn_id,'BankTransfer',session()->get('order_id') ?? uniqid(),$payment_status,NULL,$request->purchase_proof);

    }
}
