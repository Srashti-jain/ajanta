<?php
namespace App\Http\Controllers;

use App\CommissionSetting;
use Illuminate\Http\Request;



class CommissionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['permission:commission.manage']);
    }

    public function index()
    {
        $commission_settings = CommissionSetting::all();
        return view("admin.commission_setting.index", compact("commission_settings"));
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
        $data = CommissionSetting::create($input);
        $data->save();
        return redirect('admin/commission_setting')
            ->with('updated', __('Commission setting has been updated'));
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
        $commission = CommissionSetting::findOrFail($id);
        return view("admin.commission_setting.edit", compact("commission"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $commission_setting = CommissionSetting::findOrFail($id);
        $input = $request->all();
        $commission_setting->update($input);
        return redirect('admin/commission_setting')->with('updated', __('Commission setting has been updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new CommissionSetting;
        $obj = $daa->findorFail($id);
        $value = $obj->delete();
        if ($value)
        {
            session()->flash("deleted", __("Commission setting has been deleted"));
            return redirect("admin/commission_setting");
        }
    }

}

