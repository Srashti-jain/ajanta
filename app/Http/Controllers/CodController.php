<?php
namespace App\Http\Controllers;

use App\Cod;
use App\Invoice;
use Auth;
use Illuminate\Http\Request;

class CodController extends Controller
{

    //For payment using cod

    public function payviacod(Request $request)
    {

        require_once 'price.php';

        $cart_table = Auth::user()->cart;
        $total = 0;

       

        $total = getcarttotal();
        
       
        $total = sprintf("%.2f",$total * $conversion_rate);

        if (round($request->actualtotal, 2) != $total) {

            notify()->error(__('Payment has been modifed !'), __('Please try again !'));
            return redirect(route('order.review'));

        }

        $inv_cus = Invoice::first();

        $txn_id = $inv_cus->cod_prefix . str_random(10) . $inv_cus->cod_postfix;

        $payment_status = 'no';

        $checkout = new PlaceOrderController;

        return $checkout->placeorder($txn_id, 'COD', session()->get('order_id'), $payment_status);

    }
    #end

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cod  $cod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $cat = Cod::where('order_id', $id)->first();
        if (empty($cat)) {
            $data = Cod::create($input);

            $data->save();
            return redirect('admin/cod')
                ->with("updated", __("COD Setting Has Been Updated"));
        } else {
            $cat->update($input);
            return redirect('admin/cod')->with("updated", __("COD Setting Has Been Updated"));
        }
    }

    public function editupdateOn(Request $request, $id)
    {
        $input = $request->all();
        $cat = Cod::where('order_id', $id)->first();
        if (empty($cat)) {
            $data = Cod::create($input);

            $data->save();
            return redirect('vender/cod')
                ->with("updated", __("COD Setting Has Been Updated"));
        } else {
            $cat->update($input);
            return redirect('vender/cod')->with("updated", __("COD Setting Has Been Updated"));
        }
    }
}
