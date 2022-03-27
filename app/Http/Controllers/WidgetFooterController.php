<?php

namespace App\Http\Controllers;

use App\widget_footer;
use Illuminate\Http\Request;

class WidgetFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socials = widget_footer::all();
        return view('admin.widgetfooter.index',compact('socials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.widgetfooter.add');
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
        
            $data = widget_footer::create($input);
        
            $data->save();

            return back()->with("added",__("Widget footer has been created !"));
        
        
         
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Social $social)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $row = widget_footer::find($id);
        return view('admin.widgetfooter.edit',compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = widget_footer::findOrFail($id);
          $input = $request->all();
         
             $menu->update($input);

             return redirect('admin/widget_footer')->with("updated",__("Widget footer has been updated !"));
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = widget_footer::findOrFail($id);
          
        $menu->delete();

        return redirect('admin/widget_footer')->with("deleted",__("Widget footer has been deleted !"));
    }
}