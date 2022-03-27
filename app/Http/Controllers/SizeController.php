<?php

namespace App\Http\Controllers;

use App\SizeChart;
use App\SizeChartOption;
use App\SizeChartValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        $templates = SizeChart::where('user_id',auth()->id())->get();

        if( in_array('Seller',auth()->user()->getRoleNames()->toArray()) ){
            return view('seller.sizechart.index', compact('templates'));
        }

        return view('admin.sizechart.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        if( in_array('Seller',auth()->user()->getRoleNames()->toArray()) ){
            return view('seller.sizechart.create');
        }

        return view('admin.sizechart.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        $request->validate([
            'template_name' => 'required',
            'template_code' => 'required|unique:size_charts,template_code',
            'options' => 'required',
        ]);

        DB::beginTransaction();

        $template = new SizeChart;

        $options = explode(',', $request->options);

        $request['user_id'] = auth()->id();

        $request['status'] = $request->status ? 1 : 0;

        $template = $template->create($request->all());

        if (isset($request->options)) {

            foreach ($options as $value) {

                $template->sizeoptions()->create([
                    'option' => $value,
                ]);

            }

        }

        

        DB::commit();

        return redirect(route('sizechart.edit', $template->id));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        $template = SizeChart::findorfail($id);

        if( in_array('Seller',auth()->user()->getRoleNames()->toArray()) ){
            return view('seller.sizechart.edit', compact('template'));
        }

        return view('admin.sizechart.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        $template = SizeChart::with('sizeoptions')->findorfail($id);

        DB::beginTransaction();

        $request->validate([
            'template_name' => 'required',
            'template_code' => 'required|unique:size_charts,template_code,' . $template->id,
            'options' => 'required',
        ]);

        $template->sizeoptions()->each(function ($opt) {
            $opt->values()->delete();
        });

        foreach ($request->values as $key => $value) {

            foreach ($value as $val) {
                SizeChartValue::create([
                    'value' => $val,
                    'option_id' => $key,
                ]);
            }

        }
        
        $request['status'] = $request->status ? 1 : 0;

        $template->update($request->all());

        DB::commit();

        return redirect(route('sizechart.edit', $template->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        $template = SizeChart::findorfail($id);

        $template->sizeoptions->each(function ($value) {
            $value->values()->delete();
        });

        $template->sizeoptions()->delete();
        $template->delete();

        return back()->with('deleted', __('Template has been deleted !'));
    }

    public function addInList(Request $request)
    {

        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        if ($request->ajax()) {

            $exist = SizeChartOption::where('size_id',$request->temp_id)
                    ->where('option', '=', $request->option)
                    ->first();

            if ($exist) {
                $optionid = $exist->id;
                $status = 'fail';
                $message = 'Option already present in template please remove it';
            } else {
                $option = new SizeChartOption;
                $option->option = $request->option;
                $option->size_id = $request->temp_id;
                $option->save();
                $optionid = $option->id;
                $status = 'success';
                $message = 'Option added !';
            }

            $template = SizeChart::with('sizeoptions')->findorfail($request->temp_id);

            return response()->json([
                'optionid' => $optionid,
                'tableview' => View::make('admin.sizechart.tableview', compact('template'))->render(),
                'status' => $status,
                'message' => $message,
            ]);
        }

    }

    public function removefromlist(Request $request)
    {

        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        if ($request->ajax()) {

            $option = SizeChartOption::where(DB::raw("BINARY `option`"), $request->option)
                      ->with('values')
                      ->first();

            if ($option) {

                $option->values()->delete();
                $option->delete();

            }

            $template = SizeChart::with('sizeoptions')->findorfail($request->temp_id);

            return response()->json([
                'tableview' => View::make('admin.sizechart.tableview', compact('template'))->render()
            ]);

        }

    }

    public function viewpreview(Request $request)
    {
        
        abort_if(!auth()->user()->can('sizechart.manage'),403,__('User does not have the right permissions.'));

        if ($request->ajax()) {

            try{

                $template = SizeChart::with('sizeoptions')->find($request->temp_id);

                return response()->json([
                    'status'       => 'success',
                    'tablepreview' => View::make('admin.sizechart.previewtable', compact('template'))->render(),
                ]);

            }catch(\Exception $e){

                return response()->json([
                    'status'  => 'fail',
                    'message' => $e->getMessage()
                ]);

            }

        }
    }
}
