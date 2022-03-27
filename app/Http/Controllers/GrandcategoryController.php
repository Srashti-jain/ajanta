<?php
namespace App\Http\Controllers;

use App\Grandcategory;
use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Support\Facades\DB;


class GrandcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('childcategory.view'),403,__('User does not have the right permissions.'));

        $cats = Grandcategory::orderBy('position','ASC')->get();
        return view('admin.grandcategory.index', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('childcategory.create'),403,__('User does not have the right permissions.'));
        $parent = Category::all();
        return view('admin.grandcategory.add', compact('parent'));
    }

    public function import(Request $request){

        abort_if(!auth()->user()->can('category.create'),403,__('User does not have the right permissions.'));

        $validator = Validator::make(
            [
                'file' => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xlsx,xls,csv',
            ]

        );

        if ($validator->fails()) {
            notify()->error(__('Invalid file !'));
            return back();
        }

        $filename = 'childcategories_'.time() . '.' . $request->file->getClientOriginalExtension();

        Storage::disk('local')->put('/excel/'.$filename,file_get_contents($request->file->getRealPath()));

        $childcategories = fastexcel()->import(storage_path().'/app/excel/'.$filename);

        if(count($childcategories)){

            $childcategories->each(function($category){
                

                Grandcategory::create([

                    'parent_id'    => $category['parent_id'],  
                    'subcat_id'     => $category['subcat_id'],  
                    'title'         => $category['title'],
                    'icon'          => $category['icon'],
                    'description'   => clean($category['description']),
                    'status'        => (string) $category['status'],
                    'featured'      => (string) $category['featured'],
                    'image'         => $category['image'],
                    'position'      => (Grandcategory::count() + 1)

               ]);

            });

            try{

                unlink(storage_path().'/excel/'.$filename);

            }catch(\Exception $e){

            }

            notify()->success(__('Childcategories imported successfully !'));

            return back();

        }else{
            notify()->error('File is empty !');
            return back();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        abort_if(!auth()->user()->can('childcategory.create'),403,__('User does not have the right permissions.'));

        $request->validate([

            'parent_id' => 'required|not_in:0', 'title' => 'required|not_in:0',
            'subcat_id' => 'required|not_in:null',

        ], [

            "title.required" => __("Please enter Childcategory name")

        ]);

        $input = $request->all();
        $data = new Grandcategory;

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/grandcategory/';
            $image = time() . $file->getClientOriginalExtension();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 90);

            $input['image'] = $image;

        }

        $input['position'] = (Grandcategory::count()+1);
        $input['description'] = clean($request->description);
        
        $input['status']  = isset($request->status) ? "1" : "0";
        // $input['set_editable']  = $request->set_editable;
        // print_r($request->set_editable);die;
        $data->create($input);
        return redirect()->route('grandcategory.index')
            ->with("added", __("Childcategory has been added"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grandcategory  $grandcategory
     * @return \Illuminate\Http\Response
     */
    public function reposition(Request $request)
    {   

        abort_if(!auth()->user()->can('childcategory.edit'),403,__('User does not have the right permissions.'));

        if($request->ajax()){

            $posts = Grandcategory::all();
            foreach ($posts as $post) {
                foreach ($request->order as $order) {
                    if ($order['id'] == $post->id) {
                        \DB::table('grandcategories')->where('id',$post->id)->update(['position' => $order['position']]);
                    }
                }
            }
            return response()->json('Update Successfully.', 200);

        }
        
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grandcategory  $grandcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        abort_if(!auth()->user()->can('childcategory.edit'),403,__('User does not have the right permissions.'));

        $parent = Category::all();
        $subcat = Subcategory::all();
        $cat = Grandcategory::find($id);
        return view("admin.grandcategory.edit", compact("cat", 'parent', 'subcat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grandcategory  $grandcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   

        abort_if(!auth()->user()->can('childcategory.edit'),403,__('User does not have the right permissions.'));

        $cat = Grandcategory::findOrFail($id);
// print_r($cat);die;
         
        $input = $request->all();
        $input['image'] = $cat['image']; 
        if ($file = $request->file('image')) {

            if ($cat->image != '' && file_exists(public_path() . '/images/grandcategory/' . $cat->image)) {
                unlink(public_path() . '/images/grandcategory/' . $cat->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/grandcategory/';
            $name = time() . $file->getClientOriginalExtension();

            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $name, 90);

            $input['image'] = $name;

        }

        $input['description'] = clean($request->description);
        // print_r($request->set_editable);die;
        $input['status'] =  isset($request->status) ? "1" : "0";
        $input['set_editable']  = $request->set_editable;
    //    print_r($input);die;
        $input['position'] = $request->position;
       if($request->position == '' || $request->position == null){
           $input['position'] = $cat['position'];
       }
        DB::table('grandcategories')->where(['id' => $id])->update([
            'title' => json_encode(array('en'=>$request->title)),
            'image' =>  $input['image'],
            'description' => json_encode(array('en'=>$input['description'])),
            'parent_id' => $request->parent_id,
            'subcat_id' => $request->subcat_id,
            'position' => $input['position'],
            'status' => $input['status'],
            'featured' => $request->featured,
            'created_at' => $cat['created_at'],
            'updated_at' => now(),
            'set_editable' => $input['set_editable']
        ]);
        // $data = $cat->update($input);
        //   print_r($data);die;
        return redirect('admin/grandcategory')->with('updated', __('Childcategory has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grandcategory  $grandcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   

        abort_if(!auth()->user()->can('childcategory.delete'),403,__('User does not have the right permissions.'));

        $getdata = Grandcategory::find($id);

        if ($getdata->image != '' && file_exists(public_path() . '/images/grandcategory/' . $getdata->image)) {
            unlink(public_path() . '/images/grandcategory/' . $getdata->image);
        }

        if (count($getdata->products) > 0)
        {
            return back()
                ->with('warning', __('Childcategory cant be deleted as its linked to products !'));
        }

        $value = $getdata->delete();
        
        if ($value)
        {
            session()->flash("deleted", __("Childcategory has been deleted"));
            return redirect("admin/grandcategory");
        }
    }
}

