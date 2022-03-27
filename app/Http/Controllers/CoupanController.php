<?php
namespace App\Http\Controllers;

use App\Coupan;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class CoupanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('coupans.view'),403,__('User does not have the right permissions.'));
        $coupans = Coupan::orderBy('id', 'DESC')->get();
        return view("admin.coupan.index", compact("coupans"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('coupans.create'),403,__('User does not have the right permissions.'));

        $category = Category::all();
        $product = Product::all();

        return view("admin.coupan.add", compact('category', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        abort_if(!auth()->user()->can('coupans.create'),403,__('User does not have the right permissions.'));

        $input = $request->all();
        $newc = new Coupan;

        if ($request->link_by == 'product')
        {
            
            $input['pro_id'] = $request->pro_id;
            $input['minamount'] = NULL;
            $input['cat_id'] = NULL;

        }else if($request->link_by == 'simple_product'){

            $input['pro_id'] = NULL;
            $input['minamount'] = NULL;
            $input['cat_id'] = NULL;
            $input['simple_pro_id'] = $request->simple_pro_id;

        }
        else if($request->link_by == 'category')
        {
            $input['pro_id'] = NULL;
        }else{
            $input['pro_id'] = NULL;
            $input['cat_id'] = NULL;
        }

        if (isset($request->is_login))
        {
            $input['is_login'] = 1;
        }

        $newc->create($input);

        return redirect("admin/coupan")->with("added", __("Coupan has been created !"));
    }

    public function edit($id)
    {
        abort_if(!auth()->user()->can('coupans.edit'),403,__('User does not have the right permissions.'));
        
        $coupan = Coupan::findOrFail($id);
        return view("admin.coupan.edit", compact("coupan"));
    }

    public function update(Request $request, $id)
    {
        
        abort_if(!auth()->user()->can('coupans.edit'),403,__('User does not have the right permissions.'));

        $newc = Coupan::find($id);

        $input = $request->all();

        if ($request->link_by == 'product')
        {
            
            $input['pro_id'] = $request->pro_id;
            $input['minamount'] = NULL;
            $input['cat_id'] = NULL;
        }
        else if($request->link_by == 'simple_product'){

            $input['pro_id'] = NULL;
            $input['minamount'] = NULL;
            $input['cat_id'] = NULL;
            $input['simple_pro_id'] = $request->simple_pro_id;

        }
        else if($request->link_by == 'category')
        {
            $input['pro_id'] = NULL;
            
        }else{
            $input['pro_id'] = NULL;
            $input['cat_id'] = NULL;
        }
        
        if (isset($request->is_login))
        {
            $input['is_login'] = 1;
        }
        else
        {
            $input['is_login'] = 0;
        }

        $newc->update($input);

        notify()->success(__('Coupan has been updated !'),$newc->code);

        return redirect("admin/coupan");
    }

    public function destroy($id)
    {
        abort_if(!auth()->user()->can('coupans.delete'),403,__('User does not have the right permissions.'));

        $newc = Coupan::find($id);
        if (isset($newc))
        {
            $newc->delete();
            return back()
                ->with('deleted', __('Coupon has been deleted'));
        }
        else
        {
            return back()
                ->with('warning', __('404 | Coupon not found !'));
        }
    }
}

