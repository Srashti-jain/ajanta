<?php
namespace App\Http\Controllers;

use App\Abused;
use Illuminate\Http\Request;



class AbusedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['permission:others.abuse-word-manage']);
    }

    public function index()
    {
       
        $abuse = Abused::first();
        return view('admin/abuse/edit', compact('abuse'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $abuse = Abused::first();
        $input = $request->all();
        if (empty($abuse))
        {
            $data = $this->validate($request, ["name" => "required", "rep" => "required",

            ], [

            "name.required" => __("Name field is required"), "rep.required" => __("Replace field is required"),

            ]);
            $data = Abused::create($input);
            $data->save();
            notify()->success(__('Abused Word Setting has Been created !'),__('Done'));
            return back();
        }
        else
        {

            $abuse->update($input);
            notify()->success(__('Abused Word Setting  Has Been Updated'),__('Done'));
            return back();
        }

    }
}

