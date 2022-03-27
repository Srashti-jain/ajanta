<?php
namespace App\Http\Controllers;

use App\Faq;
use Illuminate\Http\Request;


class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('faq.view'),403,__('User does not have the right permissions.'));
        $faqs = Faq::all();
        return view("admin.faq.index", compact("faqs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        abort_if(!auth()->user()->can('faq.create'),403,__('User does not have the right permissions.'));
        $faq = Faq::all();
        return view("admin.faq.add", compact("faq"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('faq.create'),403,__('User does not have the right permissions.'));

        $request->validate([
            "ans" => "required",
            "que" => "required"
        ]);

        $input = $request->all();
        $input['status'] = $request->status ? '1' : '0';
        $faq = Faq::create($input);
        $faq->save();

        return back()->with('added', __('Faq has been Create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FAQ  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        abort_if(!auth()->user()->can('faq.edit'),403,__('User does not have the right permissions.'));
        
        $faq = Faq::findOrFail($id);

        return view("admin.faq.edit", compact("faq"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('faq.edit'),403,__('User does not have the right permissions.'));

        $request->validate([
            "ans" => "required",
            "que" => "required"
        ]);

        $faq = Faq::findOrFail($id);

        $input = $request->all();

        $input['status'] = $request->status ? '1' : '0';
        $faq->update($input);

        return redirect('admin/faq')->with('updated', 'Faq has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('faq.delete'),403,__('User does not have the right permissions.'));

        $faq = Faq::findorfail($id);
        $faq->delete();
        session()->flash("deleted", __("Faq has been deleted"));
        return redirect("admin/faq");
        
    }

}

