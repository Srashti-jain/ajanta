<?php

namespace App\Http\Controllers;

use App\FrontCat;
use App\Widgetsetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WidgetsettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:widget-settings.manage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getSetting()
    {
        $widgets = Widgetsetting::all();
        $NewProCat = FrontCat::first();
        $wp = DB::table('whatsapp_settings')->first();
        return view('admin.widget.settings', compact('widgets', 'NewProCat','wp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Widgetsetting  $widgetsetting
     * @return \Illuminate\Http\Response
     */
    public function show(Widgetsetting $widgetsetting)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Widgetsetting  $widgetsetting
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Widgetsetting  $widgetsetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Widgetsetting::findOrFail($id);
        $input = $request->all();
        $menu->update($input);
        return redirect('admin/widget')->with('updated', __('Widget setting has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Widgetsetting  $widgetsetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Widgetsetting $widgetsetting)
    {
        //
    }
}
