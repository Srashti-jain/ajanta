<?php

namespace App\Http\Controllers;

use App\Product;
use App\RealatedProduct;
use App\Related_setting;
use Illuminate\Http\Request;
use Image;

class RealatedProductController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->product_id;
        $input = $request->all();
        $data = RealatedProduct::create($input);
        $data->save();

        return back()->with("added", __("Releted Product Has Been Created !"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealatedProduct  $realatedProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $RealatedProduct = RealatedProduct::findOrFail($id)->first();
        $input = $request->all();
        $RealatedProduct->update($input);
        if ($RealatedProduct) {
            $pro = $RealatedProduct->product_id;
            $daa = new Product;
            $obj = $daa->findorFail($pro);
            $obj->offer_price = $request->offer_price;
            $obj->save();
        }
        return redirect('admin/reletdProduct')->with('updated', __('Related Product has been updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealatedProduct  $realatedProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $RealatedProduct = RealatedProduct::find($id);
        $value = $RealatedProduct->delete();

        if ($value) {
            session()->flash("deleted", __("Related Product Has Been Deleted"));
            return back();
        }

    }

    public function setting_update(Request $request)
    {

        $real = Related_setting::first();
        if (empty($real)) {
            $input = $request->all();

            if ($file = $request->file('image')) {

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/images/brands/';
                $image = time() . $file->getClientOriginalName();
                $optimizeImage->save($optimizePath . $image, 72);

                $input['image'] = $image;

                $data = Related_setting::create($input);

                $data->save();
                return back()->with('added', __('Related Setting has been Created'));
            }
        } else {
            $input = $request->all();

            if ($file = $request->file('image')) {

                if ($real->image != null) {

                    $image_file = @file_get_contents(public_path() . '/images/brands/' . $real->image);

                    if ($image_file) {
                        unlink(public_path() . '/images/brands/' . $real->image);
                    }

                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/images/brands/';
                $name = time() . $file->getClientOriginalName();
                $optimizeImage->save($optimizePath . $name, 72);

                $input['image'] = $name;

            } else {
                $input['image'] = $real->image;
                $real->update($input);
            }

            $real->update($input);

            return redirect('admin/reletdProduct_setting')->with('updated', __('Realated Setting has been updated'));
        }

    }
}
