<?php

namespace App\Http\Controllers;

use App\Shipping;
use Illuminate\Http\Request;
use Session;
use View;
use DB;
use App\Product;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:shipping.manage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
       
        $shippings = Shipping::all();
        return view("admin.shipping.index",compact("shippings"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.shipping.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         

        $data = $this->validate($request,[
            "name"=>"required",
            
            
        ]);

        $input = $request->all(); 
        $data = shipping::create($input);
        $data->save();
        return back()->with('category_message', __('Shipping has been updated')); 
    }
    

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        
        $shipping = Shipping::findOrFail($id);

        if($shipping->name == 'Shipping Price')
        {
            return redirect('admin/shipping-price-weight');
        }
        else
        {
            return view("admin.shipping.edit",compact("shipping"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         
        
          $shipping = shipping::findOrFail($id);
          
          $input = $request->all();  

          $input['whole_order'] = $request->whole_order ? 1 : 0;

          $shipping->update($input);

          notify()->success(__('Shipping has been updated'),__('Updated !'));

          return redirect('admin/shipping');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new Shipping;
         $obj = $daa->findorFail($id);
         //print_r($obj); die;
         $value = $obj->delete();
         if($value){
            session()->flash("deleted",__("Shipping Has Been deleted"));
             return redirect("admin/shipping");
         }
    }


    public function shipping(Request $request){
       
         $id = $request['catId'];
        DB::table('shippings')->update(['default_status' => '0']);
       
        $UpdateDetails = Shipping::where('id', '=',  $id)->first();


        $UpdateDetails->default_status = "1";
        $UpdateDetails->save();

        if($id == 1){
           Product::query()->where('free_shipping','=','0')->update(['free_shipping' => '1','shipping_id' => NULL]);
        }else{
            Product::query()->where('free_shipping','=','0')->update(['free_shipping' => '0' ,'shipping_id' => $id]);
        }
        
        Session::flash('success', __('Default shipping method has been changed now.'));
        return View::make('admin.shipping.message');
    }


}