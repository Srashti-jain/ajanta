<?php

namespace App\Http\Controllers;

use App\Allcity;
use App\Allcountry;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = DB::table('allcities')->join('allstates', 'allstates.id', '=', 'allcities.state_id')
            ->join('allcountry', 'allstates.country_id', '=', 'allcountry.id')
            ->select('allcities.name as c', 'allstates.name as statename', 'allcountry.nicename as cname');

        if ($request->ajax()) {

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('cityname', function ($row) {
                    return $row->c;
                })
                ->addColumn('statename', function ($row) {
                    return $row->statename;
                })
                ->addColumn('country', function ($row) {
                    return $row->cname;
                })
                ->rawColumns(['cityname', 'statename', 'country'])
                ->make(true);
        }

        $countries = Allcountry::join('countries', 'countries.country', '=', 'allcountry.iso3')
            ->select('allcountry.*')->get();

        return view("admin.city.index", compact('countries'));
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

            'name' => 'required|unique:allcities,name',
            'state_id' => 'required',
        ], [
            'name.required'     => __('Please enter city name !'),
            'name.unique'       => __('City already exists !'),
            'state_id.required' => __('Please select state !'),
        ]);

        $input = $request->all();

        $newcity = new Allcity;
        $newcity->create($input);
        notify()->success(__('City added'), $request->name);

        return back();

    }
}
