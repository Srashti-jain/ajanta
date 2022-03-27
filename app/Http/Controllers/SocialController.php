<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Http\Request;



class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['permission:site-settings.social-handle']); 
    }

    public function index()
    {
        $socials = Social::all();
        return view('admin.social.index', compact('socials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.social.add');
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

        $data = Social::create($input);

        $data->save();

        notify()->success(__('Social icon added successfully !'));
        return redirect('admin/social');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Social::find($id);
        return view('admin.social.edit', compact('row'));
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
        $menu = Social::find($id);

        if(!$menu){
            notify()->error(__('Icon not found !'),'404');
            return redirect('admin/social');
        }

        $input = $request->all();

        $menu->update($input);

        notify()->success(__('Social icon updated successfully !'));
        return redirect('admin/social');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Social::find($id);

        if(!$menu){
            notify()->error(__('Icon not found !'),'404');
            return redirect('admin/social');
        }

        $menu->delete();

        notify()->success(__('Social icon deleted successfully !'));
        return redirect('admin/social');
    }
}
