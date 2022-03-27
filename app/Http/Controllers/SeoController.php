<?php

namespace App\Http\Controllers;

use App\Seo;
use Illuminate\Http\Request;
use DotenvEditor;


class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['permission:seo.manage']);
    }

    public function index()
    {
        $seo = Seo::first();

        return view("admin.Seo.edit", compact("seo"));
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
            "metadata_des" => "required",
            "metadata_key" => "required",
        ],[
            "metadata_des.required" => __("Metadata description is required"),
            "metadata_key.required" => __("Metadata key is required"),
        ]);

        $env_keys_save = DotenvEditor::setKeys([
            'FACEBOOK_PIXEL_ID' => $request->FACEBOOK_PIXEL_ID,
        ]);

        $env_keys_save->save();

       
        Seo::updateOrCreate([
            'id' => 1
        ],[
            'google_analysis' => $request->google_analysis,
            'metadata_des' => $request->metadata_des,
            'metadata_key' => $request->metadata_key,
            'project_name' => $request->project_name
        ]);

        
        notify()->success(__('Seo settings has been updated !'));
        return back();

        
    }


}
