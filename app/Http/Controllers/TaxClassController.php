<?php

namespace App\Http\Controllers;

use App\TaxClass;
use Illuminate\Http\Request;
use App\Country;
use App\State;
use App\Allstate;



class TaxClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:taxsystem.manage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $taxs = TaxClass::all();
        return view("admin.tax_class.index",compact("taxs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::all();
        return view("admin.tax_class.add",compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      

         $input = $request->all(); 
        $data = TaxClass::create($input);
        $data->save();
        return redirect('admin/tax_class')->with('added', __('Tax Class has been updated')); 
    }

    


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$tax_class = TaxClass::all();
        $country = Country::all();
        $tax = TaxClass::findOrFail($id);
        $states = Allstate::where('country_id',$tax->country_id)->get();

        return view("admin.tax_class.edit",compact("tax","country","states"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
          
            $tax =  TaxClass::where('id',$request->id)->first();
         

            $tax->title         =   $request->title;
            $tax->des           =   $request->des;
            $tax->taxRate_id    =   $request->taxArry;
            $tax->priority      =   $request->priArry;
            $tax->based_on      =   $request->basedArry;
                        
            $tax->save();


          return redirect('admin/tax_class')->with('added', __('Tax Class has been updated'));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new TaxClass;
         $obj = $daa->findorFail($id);
         $value = $obj->delete();
         if($value){
            session()->flash("category_message",__("Tax Class Has Been deleted"));
             return redirect("admin/tax_class");
         }
    }

    public function addRow(Request $request){
        $tax = new TaxClass;

        $tax->title = $request->title;
        $tax->des = $request->des;
        $tax->taxRate_id = $request->taxArry;
        $tax->priority = $request->priArry;
        $tax->based_on = $request->basedArry;
                        
        $tax->save();


         echo 'Success !';

    }
}
