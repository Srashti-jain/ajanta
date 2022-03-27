<?php

namespace App\Http\Controllers;

use App\SEODirectory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SEODirectoryController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | SEODirectoryController
    |--------------------------------------------------------------------------
    |
    | Resource controller of seo directory.
    |
    */

    /** @return Renderable */

    public function index(){

        $dirs = SEODirectory::select('*');

        if(request()->ajax()){
            return DataTables::of($dirs)
              ->addIndexColumn()
              ->addColumn('detail',function($row){
                  return strlen($row->detail) > 50 ? substr($row->detail,0,50)."..." : $row->detail;
              })
              ->addColumn('status',function($row){
                return $row->status == 1 ? "<span class='badge badge-success'>".__('Active')."</span>" : "<span class='badge badge-danger'>".__("Deactive")."</span>";
              })
              ->editColumn('action','admin.seodirectory.action')
              ->rawColumns(['detail', 'status', 'action'])
              ->make(true);
        }
        
        return view('admin.seodirectory.index');

    }

    /** @return Renderable */

    public function create(){
        
        return view('admin.seodirectory.create');

    }

    /** @param $id */
    /** @return Renderable */

    public function show(SEODirectory $seoDirectory){

        abort_if($seoDirectory->status !== 1,404,__('Page is not active'));

        require 'price.php';
        
        return view('admin.seodirectory.show',compact('seoDirectory','conversion_rate'));

    }

    /** @param $id */
    /** @return Renderable */

    public function edit($id){

        $dir = SEODirectory::findorfail($id);

        return view('admin.seodirectory.edit',compact('dir'));

    }

    /** @param $request */
    /** @return Boolean */

    public function store(Request $request){
        
        $request->validate([
            'city'    => 'required',
            'detail' => 'required'
        ]);

        $request['status'] = $request->status ? 1 : 0;
        $request['detail'] = clean($request->detail);

        SEODirectory::create(array_filter($request->all()));

        return back()->with('success',__("Directory has been created !"));

    }

    /** @param $id */
    /** @param $request */
    /** @return Boolean */

    public function update(Request $request,$id){

        $dir = SEODirectory::findorfail($id);

        $request->validate([
            'city'    => 'required',
            'detail' => 'required'
        ]);

        $request['status'] = $request->status ? 1 : 0;
        $request['detail'] = clean($request->detail);

        $dir->update(array_filter($request->all()));

        return back()->with('success',__("Directory has been updated !"));

    }

    /** @param $id */
    /** @return Boolean */

    public function destroy($id){
        
        $dir = SEODirectory::findorfail($id);

        $dir->delete();

        return back()->with('deleted',__("Directory has been deleted !"));

    }
}
