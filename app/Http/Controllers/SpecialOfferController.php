<?php

namespace App\Http\Controllers;

use App\SpecialOffer;
use Illuminate\Http\Request;
use App\Product;
use App\SimpleProduct;
use DB;


class SpecialOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('specialoffer.view'),403,__('User does not have the right permissions.'));

        $products = SpecialOffer::with('pro','simple_product')->whereHas('pro')->orWhereHas('simple_product')->get();
        return view('admin.special.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('specialoffer.create'),403,__('User does not have the right permissions.'));
        $products = Product::where('status','1')->pluck('name', 'id')->all();
        $simple_products = SimpleProduct::where('status','1')->pluck('product_name', 'id')->all();
        return view("admin.special.add",compact('products','simple_products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('specialoffer.create'),403,__('User does not have the right permissions.'));

        $input = $request->all();

        $special_offer = new SpecialOffer;

        if($request->link_by == 'sp'){
            $input['simple_pro_id'] = $request->simple_pro_id;
            $input['pro_id'] = NULL;
        }else{
            $input['pro_id'] = $request->pro_id;
            $input['simple_pro_id'] = NULL;
        }

        $input['status'] = $request->status ? '1' : '0';

        $special_offer->create($input);
       

        return back()->with("added",__("Special offer has been created !"));

    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */

     public function edit($id)
    {
        abort_if(!auth()->user()->can('specialoffer.edit'),403,__('User does not have the right permissions.'));

        $products = Product::where('status','1')->pluck('name', 'id')->all();
        $simple_products = SimpleProduct::where('status','1')->pluck('product_name', 'id')->all();
        $special_offer = SpecialOffer::find($id);
        return view("admin.special.edit",compact("special_offer","products","simple_products"));
      
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('specialoffer.edit'),403,__('User does not have the right permissions.'));

        $input = $request->all();

        $special_offer = SpecialOffer::findorfail($id);

        if($request->link_by == 'sp'){
            $input['simple_pro_id'] = $request->simple_pro_id;
            $input['pro_id'] = NULL;
        }else{
            $input['pro_id'] = $request->pro_id;
            $input['simple_pro_id'] = NULL;
        }

        $input['status'] = $request->status ? '1' : '0';

        $special_offer->update($input);

        return redirect('admin/special')->with('updated', __('Special offer has been updated !'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SpecialOffer  $specialOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        abort_if(!auth()->user()->can('specialoffer.delete'),403,__('User does not have the right permissions.'));

         $daa = new SpecialOffer;
          $obj = $daa->findorFail($id);
          $value = $obj->delete();
         if($value){
            session()->flash("deleted",__("Special Offer Has Been deleted"));
             return redirect("admin/special");
        }
    }

    public function show_widget()
    {
        $slide = DB::table('special_offer_widget')->first();
        return view('admin.special.widget.index',compact('slide'));
    }

    public function update_widget(Request $request)
    {   
        $slider_wid = DB::table('special_offer_widget')->first();
        if(!empty($slider_wid)){
            $slider = DB::table('special_offer_widget')->update(['slide_count'=>$request->slider]);   
        }
        else{
               DB::table('special_offer_widget')->insert(
                    array(
                            
                            'slide_count'   =>   $request->slider
                    )
                );    
        }
         
            
            return back();
        }

}
