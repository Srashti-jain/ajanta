<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductAttributes;
use App\ProductValues;


class ProductValueController extends Controller
{
    public function get($id)
    {
    	$provalues = ProductValues::where('atrr_id','=',$id)->get();
    	$proattr = ProductAttributes::findorfail($id);
    	return view('admin.provalues.index',compact('proattr','provalues'));
    }

    public function store(Request $request,$id)
    {

    
        $request->validate([
            'value' => 'required|min:1'
        ]);

    	$proattr = ProductAttributes::findorfail($id);
    	$newvalue = new ProductValues;

        $findsameproval = ProductValues::where('values','=',$request->value)->where('atrr_id','=',$id)->first();

        if (isset($findsameproval)) {
            if (strcasecmp($findsameproval->values, $request->value) == 0) {
                return back()->with('warning',__('Value is already there !'));
            }
        }else
        {
            $newvalue->values = $request->value;
            $newvalue->atrr_id = $id;
            $newvalue->unit_value = $request->unit_value;
            $newvalue->save();
        }

    	

    	return back()->with('added',__('Value :value for option :option created succesfully !',[':value' => $request->value, 'option' => $request->attr_name]));
    }

    

    public function update(Request $request,$id,$attr_id)
    {   
      
    	$getval = $request->newval;
        $uval = $request->uval;

            
            $run_q = ProductValues::where('id','=',$id)->update(['values' => $getval, 'unit_value' => $uval]);

            if($run_q)
            {
                
                return "<div class='well custom-well'>".__('Value Changed to :getval $uval succesfully !',['getval' => $getval.' '.$uval])."</div>" ;
            }else {
               
                return "<div class='well custom-well'>".__('Error in updating value !')."</div>" ;
            }

        
    	
    }
}
