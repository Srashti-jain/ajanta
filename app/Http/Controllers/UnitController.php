<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use App\UnitValues;


class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('units.view'),403,__('User does not have the right permissions.'));
        $units = Unit::get();
        return view('admin.unit.index',compact('units'));
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('units.create'),403,__('User does not have the right permissions.'));

          $findsameval = Unit::where('title',$request->title)->first();

          if (isset($findsameval)) {
            if(strcasecmp($request->title, $findsameval->title)==0)
              {
                 return back()->with('warning',__('Option Already Added !'));
              }  
          }
            
          

          $input = $request->all();
          if(isset($request->status)){
            $input['status'] = 1;
          }else{
            $input['status'] = 0;
          }
          $unit = Unit::create($input);  
          $unit->save();

          return back()->with('added', __('Unit has been Created !'));
    }

   
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('units.edit'),403,__('User does not have the right permissions.'));

        $unit = Unit::findOrFail($id);
        $input = $request->all();  

        $findsameval = Unit::where('title',$request->title)->first();

        if (isset($findsameval)) {
            if(strcasecmp($findsameval->title, $request->title)==0 && $unit->id != $findsameval->id)
            {
                return back()->with('warning',__('Option Already There !'));
            } 
        }else
        {

          if(isset($request->status)){
            $input['status'] = 1;
          }else{
            $input['status'] = 0;
          }
          
          $unit->update($input);
        }
                


          return redirect('admin/unit')->with('updated', __('Unit has been updated !'));
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('units.delete'),403,__('User does not have the right permissions.'));

        $cat = Unit::find($id);
       

         if($cat->linkedAttributes->count() > 0){
            return back()->with('warning',__("Unit Can't be deleted as it linked to some Product attributes !"));
         }

        $findunitvals = UnitValues::where('unit_id',$id)->get();

        foreach ($findunitvals as $values) {
            $values->delete();
        }

        $cat->delete();
        session()->flash("deleted",__("Unit has been deleted !"));
        return redirect("admin/unit");
         
    }

    public function getValues($id)
    {   
        $unit = Unit::findOrFail($id);
        return view('admin.unit.unitvalues',compact('unit'));
    }

    public function storeValue(Request $request, $id)
    {
    
         $request->validate([
            'unit_values' => 'required',
            'short_code'  => 'required'
        ],[
            'unit_values.required' => __('Value cannot be empty !'),
            'short_code.required'  => __('Short code is require !')
        ]);

       $unitval = new UnitValues;

       
       $findsameval = UnitValues::where('unit_id',$id)->where('unit_values','=',$request->unit_values)->first();

      if (isset($findsameval)) {

          if(strcasecmp($findsameval->unit_values, $request->unit_values)==0){
            return back()->with('warning',__('Option already added !'));
          }
 
      }
      
        
       $unitval->unit_values = $request->unit_values;
       $unitval->short_code = $request->short_code;
       $unitval->unit_id = $id;

       $unitval->save();

       return back()->with('added',__('Value added successfully !'));
    }

    public function editValue(Request $request,$id)
    {
        $request->validate([
            'unit_values' => 'required',
            'short_code'  => 'required'
        ],[
            'unit_values.required' => __('Value cannot be empty !'),
            'short_code.required'  => __('Short code is required !')
        ]);


        $unitval = UnitValues::findOrFail($id);

        $findsameval = UnitValues::where('unit_id',$unitval->unit_id)->where('unit_values','=',$request->unit_values)->first();

        $findshortcode = UnitValues::where('unit_id',$unitval->unit_id)->where('short_code','=',$request->short_code)->first();

    

        if (isset($findsameval)) {
            if(strcasecmp($findsameval->unit_values, $request->unit_values)==0 && $unitval->id != $findsameval->id)
            {   
                return back()->with('warning',__('Option already there !'));
            }

        }

        if(isset($findshortcode))
        {
            
            if(strcasecmp($findshortcode->short_code,$request->short_code)==0 && $unitval->id != $findshortcode->id)
            {   
                return back()->with('warning',__('Short code already there !'));
            }
        }
            
            $unitval->unit_values = $request->unit_values;
            $unitval->short_code  = $request->short_code;
            
            $unitval->save();
        

        

         return back()->with('added',__('Value updated successfully !'));
    }

    public function unitvaldelete($id)
    {
        $unitval = UnitValues::findOrFail($id);

        if($unitval->units->linkedAttributes->count() > 0){
            return back()->with('warning',__("Unit value can't be deleted as it's linked to some product attributes !"));        
        }

        $unitval->delete();

        return back()->with('deleted',__('Value deleted successfully !'));
    }
}
