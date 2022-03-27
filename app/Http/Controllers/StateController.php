<?php

namespace App\Http\Controllers;

use App\Allstate;
use App\State;
use App\Country;
use Illuminate\Http\Request;
use DB;
use DataTables;


class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

           $data = Allstate::join('allcountry','allstates.country_id' ,'=', 'allcountry.id' )->select('allstates.name as statename','allcountry.name as cname');

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->statename;
                 })
                ->addColumn('cname', function($row){
                    return $row->cname;
                 })
                ->rawColumns(['name','cname'])
                ->make(true);
        }
         
        
        return view("admin.state.index");
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countrys = Country::all();
        return view("admin.state.add_state",compact("countrys"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:allstates,name',
            'country_id' => 'required'
        ],[
            'name.required' => __('State name is required'),
            'name.unique' => __('State already exist !'),
            'country_id.required' => __('Please select country')
        ]);

        $newState = new Allstate;
        $input =  $request->all();
        $newState->create($input);
        return back()->with('added',__('State added !'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $state = State::findOrFail($id);
         $countrys = Country::all();
        return view("admin.state.edit",compact("state","countrys"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
           
            $data = $this->validate($request,[
            "state"=>"required",
            
        ],[

            "state.required"=> __("State name is required"),
            
          ]);

            $daa = new State;
            $obj = $daa->findorFail($id);
            
              $obj->country_id = $request->country_id;
              $obj->state = $request->state;

                $value=$obj->save();
                if($value){
                    session()->flash("updated",__("State has been updated"));
                    return redirect("admin/state/".$id."/edit");
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $state = State::find($id);
        $value = $state->delete();
        if($value){
            session()->flash("deleted",__("State has been deleted"));
            return redirect("admin/state");
         }
    }
}
