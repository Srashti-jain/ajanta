<?php

namespace App\Http\Controllers;

use App\RMA;
use Illuminate\Http\Request;

class RMAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allrma = RMA::orderBy('id','DESC')->get();
        return view('admin.order.rma.index',compact('allrma'));
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
            'reason' => 'required|unique:r_m_a_s,reason'
        ]);

        $input = array_filter($request->all());

        $input['status'] = $request->status ? 1 : 0;

        RMA::create($input);

        return back()->with('added',__("Reason has been added !"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RMA $rma)
    {
        $request->validate([
            'reason' => 'unique:r_m_a_s,reason,'.$rma->id
        ]);

        $input = array_filter($request->all());

        $input['status'] = $request->status ? 1 : 0;

        $rma->update($input);

        return back()->with('added',__("Reason has been updated !"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RMA $rma)
    {
        $rma->delete();
        return back()->with('deleted',__("Reason has been deleted !"));
    }
}
