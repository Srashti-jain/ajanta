<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Http\Request;
use Image;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('testimonials.view'), 403, __('User does not have the right permissions.'));
        $clients = Testimonial::all();
        return view('admin.testimonial.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('testimonials.create'), 403, __('User does not have the right permissions.'));
        return view('admin.testimonial.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('testimonials.create'), 403, __('User does not have the right permissions.'));
        $this->validate($request, [

            'name' => 'required',
            'rating' => 'required',
            'post' => 'required',
            'image' => 'required',
            'rating' => 'required|not_in:0',

        ], [

            "name.required" => __("Please enter name"),

        ]);

        $input = $request->all();

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/testimonial/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image, 72);

            $input['image'] = $image;

        }

        $input['des'] = clean($request->des);

        $data = Testimonial::create($input);
        return back()->with("added", __("Testimonial has been added"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('testimonials.edit'), 403, __('User does not have the right permissions.'));
        $client = Testimonial::find($id);
        return view("admin.testimonial.edit", compact("client"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('testimonials.edit'), 403, __('User does not have the right permissions.'));

        $testimonial = Testimonial::findOrFail($id);

        $input = $request->all();

        if ($file = $request->file('image')) {

            if ($testimonial->image != null) {

                $image_file = @file_get_contents(public_path() . '/images/testimonial/' . $testimonial->image);

                if ($image_file) {
                    unlink(public_path() . '/images/testimonial/' . $testimonial->image);
                }

            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/testimonial/';
            $name = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $name, 72);

            $input['image'] = $name;

        } else {
            $input['image'] = $testimonial->image;
        }

        $input['des'] = clean($request->des);

        $testimonial->update($input);

        return redirect('admin/testimonial')->with('updated', __('Testimonial has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('testimonials.delete'), 403, __('User does not have the right permissions.'));

        $testimonial = Testimonial::find($id);
        if ($testimonial->image != null) {

            $image_file = @file_get_contents(public_path() . '/images/testimonial/' . $testimonial->image);

            if ($image_file) {

                unlink(public_path() . '/images/testimonial/' . $testimonial->image);
            }
        }
        $value = $testimonial->delete();
        if ($value) {
            session()->flash("deleted", __("Testimonial has been deleted"));
            return redirect("admin/testimonial");
        }
    }
}
