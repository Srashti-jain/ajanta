<?php

namespace App\Http\Controllers;

use App\ManualPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManualPaymentGatewayController extends Controller
{
    public function getindex()
    {
        abort_if(!auth()->user()->can('manual-payment.view'), 403, __('User does not have the right permissions.'));
        $methods = ManualPaymentMethod::orderBy('id', 'DESC')->get();
        return view('admin.manualpayment.index', compact('methods'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('manual-payment.create'), 403, __('User does not have the right permissions.'));

        $request->validate([
            'payment_name' => 'required|string|max:50|unique:manual_payment_methods,payment_name',
            'description' => 'required|max:5000',
        ]);

        $newmethod = new ManualPaymentMethod;
        $input = array_filter($request->all());

        if (!is_dir(public_path() . '/images/manual_payment')) {
            mkdir(public_path() . '/images/manual_payment');
        }

        if ($request->thumbnail != null) {

            if (!str_contains($request->thumbnail, '.png') && !str_contains($request->thumbnail, '.jpg') && !str_contains($request->thumbnail, '.jpeg') && !str_contains($request->thumbnail, '.webp') && !str_contains($request->thumbnail, '.gif')) {

                return back()->withInput()->withErrors([
                    'thumbnail' => __('Invalid image type for payment gateway thumbnail'),
                ]);

            }

            $input['thumbnail'] = $request->thumbnail;
        }

        $input['status'] = isset($request->status) ? 1 : 0;

        $newmethod->create($input);

        notify()->success(__('Payment method added !'), $request->payment_name);
        return back();

    }

    public function update(Request $request, $id)
    {

        abort_if(!auth()->user()->can('manual-payment.edit'), 403, __('User does not have the right permissions.'));

        $method = ManualPaymentMethod::find($id);

        if (!$method) {
            notify()->error(__('Payment method not found !'), 404);
            return back();
        }

        $request->validate([
            'payment_name' => 'required|string|max:50|unique:manual_payment_methods,payment_name,' . $method->id,
            'description' => 'required|max:5000',
            'thumbnail' => 'mimes:jpg,jpeg,png,webp,bmp',
        ]);

        $input = array_filter($request->all());

        if ($request->thumbnail != null) {

            if (!str_contains($request->thumbnail, '.png') && !str_contains($request->thumbnail, '.jpg') && !str_contains($request->thumbnail, '.jpeg') && !str_contains($request->thumbnail, '.webp') && !str_contains($request->thumbnail, '.gif')) {

                return back()->withInput()->withErrors([
                    'thumbnail' => __('Invalid image type for payment gateway thumbnail'),
                ]);

            }

            $input['thumbnail'] = $request->thumbnail;
        }

        $input['status'] = isset($request->status) ? 1 : 0;

        $method->update($input);

        notify()->success(__('Payment method updated !'), $request->payment_name);
        return back();

    }

    public function delete($id)
    {
        abort_if(!auth()->user()->can('manual-payment.delete'), 403, __('User does not have the right permissions.'));

        $method = ManualPaymentMethod::find($id);

        if (!$method) {
            notify()->error('Payment method not found !', 404);
            return back();
        }

        if ($method->thumbnail != '' && file_exists(public_path() . '/images/manual_payment/' . $method->thumbnail)) {
            unlink(public_path() . '/images/manual_payment/' . $method->thumbnail);
        }

        notify()->success(__("Payment method deleted"), $method->payment_name);

        $method->delete();

        return back();
    }

    public function checkout(Request $request, $token)
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

        $total = getcarttotal();

        $total = sprintf("%.2f", $total * $conversion_rate);

        if ($request->actualtotal != $total) {
            notify()->error(__('Payment has been modifed !'), __('Please try again !'));
            return redirect(route('order.review'));

        }

        $txn_id = str_random(8);
        $payment_method = ucfirst($request->payvia);

        $payment_status = 'no';

        $checkout = new PlaceOrderController;

        return $checkout->placeorder($txn_id, $payment_method, $orderid = uniqid(), $payment_status, null, $request->purchase_proof);

    }
}
