<?php

namespace App\Http\Controllers;

use App\Shipping;
use DB;
use Illuminate\Http\Request;
use Session;
use View;

class VenderShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $data = $this->validate($request, [
            "name" => "required",

        ], [

            "name.required" => __("Shipping field is required"),

        ]);

        $input = $request->all();
        $data = shipping::create($input);
        $data->save();
        return back()->with('updated', __('Shipping has been updated'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $this->validate($request, [
            "name" => "required",

        ], [

            "name.required" => __("Shipping field is required"),

        ]);

        $shipping = shipping::findOrFail($id);
        $input = $request->all();
        $shipping->update($input);

        return redirect('vender/shipping')->with('updated', __('Shipping has been updated'));

    }

    public function shipping(Request $request)
    {

        $id = $request['catId'];
        $user = $request['user'];
        DB::table('shippings')->update(['default_status' => '0']);

        $UpdateDetails = shipping::where('id', '=', $id)->first();
        $UpdateDetails->default_status = "1";
        $UpdateDetails->save();
        if ($UpdateDetails) {

            DB::table('products')->where('vender_id', '=', $user)->update(['shipping_id' => $id]);
        }

        Session::flash('success', __('Default shipping method has been changed now.'));
        return View::make('admin.shipping.message');

    }

}
