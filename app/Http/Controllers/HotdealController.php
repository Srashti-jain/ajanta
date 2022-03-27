<?php
namespace App\Http\Controllers;

use App\Hotdeal;
use App\Product;
use App\SimpleProduct;
use Illuminate\Http\Request;

class HotdealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('hotdeals.view'), 403, __('User does not have the right permissions.'));
        $products = Hotdeal::with('pro','simple_product')->whereHas('simple_product')->orwhereHas('pro')->get();
        return view('admin.hotdeal.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('hotdeals.create'), 403, __('User does not have the right permissions.'));
        $products = Product::where('status','1')->pluck('name', 'id')->all();
        $simple_products = SimpleProduct::where('status','1')->pluck('product_name', 'id')->all();
        return view("admin.hotdeal.add", compact('products', 'simple_products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('hotdeals.create'), 403, __('User does not have the right permissions.'));

        $input = $request->all();
        $input['start'] = date('Y-m-d H:i:s', strtotime($request->start));
        $input['end'] = date('Y-m-d H:i:s', strtotime($request->end));

        if($request->link_by == 'sp'){
            $input['simple_pro_id'] = $request->simple_pro_id;
            $input['pro_id'] = NULL;
        }else{
            $input['pro_id'] = $request->pro_id;
            $input['simple_pro_id'] = NULL;
        }

        $input['status'] = $request->status ? '1' : '0';

        Hotdeal::create($input);

        return redirect('admin/hotdeal')->with("added", __("Deal has been created"));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hotdeal  $hotdeal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        abort_if(!auth()->user()->can('hotdeals.edit'), 403, __('User does not have the right permissions.'));
        $products = Product::where('status','1')->pluck('name', 'id')->all();
        $simple_products = SimpleProduct::where('status','1')->pluck('product_name', 'id')->all();
        $hotdeal = Hotdeal::find($id);
        return view("admin.hotdeal.edit", compact("products", "hotdeal","simple_products"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hotdeal  $hotdeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        abort_if(!auth()->user()->can('hotdeals.edit'), 403, __('User does not have the right permissions.'));

        $hotdeal = Hotdeal::find($id);

        $input = $request->all();
        $input['start'] = date('Y-m-d H:i:s', strtotime($request->start));
        $input['end'] = date('Y-m-d H:i:s', strtotime($request->end));

        if($request->link_by == 'sp'){
            $input['simple_pro_id'] = $request->simple_pro_id;
            $input['pro_id'] = NULL;
        }else{
            $input['pro_id'] = $request->pro_id;
            $input['simple_pro_id'] = NULL;
        }

        $input['status'] = $request->status ? '1' : '0';

        $hotdeal->update($input);

        return redirect('admin/hotdeal')
            ->with('updated', __('Hotdeal has been updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hotdeal  $hotdeal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('hotdeals.delete'), 403, __('User does not have the right permissions.'));

        $product = Hotdeal::find($id);
        $value = $product->delete();
        if ($value) {
            $pro = $product->pro_id;
            $daa = new Product;
            $obj = $daa->findorFail($pro);
            $obj->offer_price = '';
            $obj->save();
            session()
                ->flash("deleted", __("Deal has been deleted !"));
            return redirect("admin/hotdeal");
        }
    }
}
