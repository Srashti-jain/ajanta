<?php
namespace App\Http\Controllers;

use App\Commission;
use Illuminate\Http\Request;


class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $commissions = Commission::whereHas('category')->with('category')->get();
        return view("admin.commission.index", compact("commissions"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = \App\Category::all();
        return view("admin.commission.add", compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->validate($request, ['rate' => 'required|integer|not_in:0', 'category_id' => 'required|not_in:0',

        ], ["rate.required" => "Rate field accept only number",

        ]);

        $input = $request->all();
        $data = Commission::create($input);
        $data->save();
        return redirect('admin/commission')
            ->with('updated', __('Commission has been updated'));
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
        $category = \App\Category::all();
        $commission = commission::findOrFail($id);
        return view("admin.commission.edit", compact("commission", "category"));
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
        $data = $this->validate($request, ['rate' => 'required|integer', 'category_id' => 'required',

        ], ["rate.required" => "Rate Fild Accept Only Number",

        ]);

        $tax = Commission::findOrFail($id);
        $input = $request->all();
        $tax->update($input);
        return redirect('admin/commission')->with('updated', 'Commission has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new Commission;
        $obj = $daa->findorFail($id);
        $value = $obj->delete();
        if ($value)
        {
            session()->flash("deleted", "Commission Has Been deleted");
            return redirect("admin/commission");
        }
    }
}

