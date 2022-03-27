<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class VerifyPaymentController extends Controller
{
    public function paymentReVerify(Request $request)
    {

        require_once 'price.php';

        if ($request->ajax()) {

            $ordertotal = sprintf("%.2f",$request->carttotal);

            $total = getcarttotal();
        
            $total = sprintf("%.2f",$total * $conversion_rate);

            if ($ordertotal == $total) {
                return response()->json([200, __('Total matched')]);
            } else {
                \Session::put('re-verify', 'yes');
                return response()->json([401, __('Total not matched')]);
            }
        }
    }

}
