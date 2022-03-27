<?php
namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('pages.view'),403,__('User does not have the right permissions.'));
        $pages = Page::all();
        return view("admin.page.index", compact("pages"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        abort_if(!auth()->user()->can('pages.create'),403,__('User does not have the right permissions.'));
        return view("admin.page.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('pages.create'),403,__('User does not have the right permissions.'));

            $data = $this->validate($request, ["name" => "required", "slug" => "required",

        ]);

        $input = $request->all();
        $input['des'] = clean($request->des);
        $input['status'] = $request->status ? '1' : '0';
        $page = Page::create($input);
        $page->save();

        return back()
            ->with('updated', __('Page has been created !'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        abort_if(!auth()->user()->can('pages.edit'),403,__('User does not have the right permissions.'));

        $page = Page::findOrFail($id);

        return view("admin.page.edit", compact("page"));

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
        abort_if(!auth()->user()->can('pages.edit'),403,__('User does not have the right permissions.'));

            $data = $this->validate($request, ["name" => "required", "slug" => "required",

        ]);
        
        $page = Page::findOrFail($id);
        $input = $request->all();
        $input['des'] = clean($request->des);
        $input['status'] = $request->status ? '1' : '0';
        $page->update($input);

        return redirect('admin/page')->with('updated', __('Page has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('pages.delete'),403,__('User does not have the right permissions.'));
        $cat = Page::find($id);
        $value = $cat->delete();
        if ($value)
        {
            session()->flash("deleted", __("Page Has Been Deleted"));
            return redirect("admin/page");
        }
    }

}

