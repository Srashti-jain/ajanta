<?php

namespace App\Http\Controllers;

use App\Subcategory;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        abort_if(!auth()->user()->can('subcategory.view'),403,__('User does not have the right permissions.'));

        $subcategory = Subcategory::orderBy('position','ASC')->get();

        return view('admin.category.subcategory.index',compact("subcategory"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('subcategory.create'),403,__('User does not have the right permissions.'));

        $parent = Category::all();

        return view("admin.category.subcategory.create",compact("parent"));
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

        $filename = 'subcategories_'.time() . '.' . $request->file->getClientOriginalExtension();

        Storage::disk('local')->put('/excel/'.$filename,file_get_contents($request->file->getRealPath()));

        $subcategories = fastexcel()->import(storage_path().'/app/excel/'.$filename);

        if(count($subcategories)){

            $subcategories->each(function($category){
                

               Subcategory::create([

                    'parent_cat'    => $category['parent_cat'],  
                    'title'         => $category['title'],
                    'icon'          => $category['icon'],
                    'description'   => clean($category['description']),
                    'status'        => (string) $category['status'],
                    'featured'      => (string) $category['featured'],
                    'image'         => $category['image'],
                    'position'      => (Subcategory::count() + 1)

               ]);

            });

            try{

                unlink(storage_path().'/excel/'.$filename);

            }catch(\Exception $e){

            }

            notify()->success(__('Subcategories imported successfully !'));

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

        abort_if(!auth()->user()->can('subcategory.create'),403,__('User does not have the right permissions.'));
        
        $request->validate([
            
            "title"=>"required",
            

        ]);

        $data  = new Subcategory;
        $input = array_filter($request->all());

        if(isset($request->status)){
           $input['status'] = "1";
        }else{
            $input['status'] = "0";
        }

        if ($request->image != null) {

            if(!str_contains($request->image, '.png') && !str_contains($request->image, '.jpg') && !str_contains($request->image, '.jpeg') && !str_contains($request->image, '.webp') && !str_contains($request->image, '.gif')){
                    
                return back()->withInput()->withErrors([
                    'image' => __('Invalid image type for subcategory thumbnail')
                ]);

            }

            $input['image'] = $request->image;

        }

         $input['position'] = (Subcategory::count()+1);

         $input['description'] = clean($request->description);

         $data->create($input);
        
        return redirect()->route('subcategory.index')->with("added",__("Subcategory Has Been Added"));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function reposition(Request $request)
    {
        abort_if(!auth()->user()->can('subcategory.edit'),403,__('User does not have the right permissions.'));

        if($request->ajax()){

            $posts = Subcategory::all();
            foreach ($posts as $post) {
                foreach ($request->order as $order) {
                    if ($order['id'] == $post->id) {
                        \DB::table('subcategories')->where('id',$post->id)->update(['position' => $order['position']]);
                    }
                }
            }
            return response()->json('Update Successfully.', 200);

        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('subcategory.edit'),403,__('User does not have the right permissions.'));

        $parent = Category::all();

        $cat = Subcategory::findOrFail($id);
        return view("admin.category.subcategory.edit",compact("cat","parent"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('subcategory.edit'),403,__('User does not have the right permissions.'));

        $subcat = Subcategory::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'parent_cat' => 'required'
        ],[
            'parent_cat.required' => __('Please Select Parent Category')
        ]);

        $subcat->title = $request->title;
        $subcat->parent_cat = $request->parent_cat;
        $subcat->description = clean($request->description);
        $subcat->icon = $request->icon;
            
        if(isset($request->featured)){
            $subcat->featured = 1;
        }else{
            $subcat->featured = 0;
        }

        if(isset($request->status)){
            $subcat->status = 1;
        }else{
            $subcat->status = 0;
        }

        if ($request->image != null) {

            if(!str_contains($request->image, '.png') && !str_contains($request->image, '.jpg') && !str_contains($request->image, '.jpeg') && !str_contains($request->image, '.webp') && !str_contains($request->image, '.gif')){
                    
                return back()->withInput()->withErrors([
                    'image' => __('Invalid image type for subcategory thumbnail')
                ]);

            }

            $input['image'] = $request->image;

        }

        $subcat->save();

        return redirect()->route('subcategory.index')->with("updated",__("Subcategory has been updated !"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('subcategory.delete'),403,__('User does not have the right permissions.'));

        $category = Subcategory::find($id);


        if(count($category->products)>0){
            return back()->with('warning',__('Subcategory can\'t be deleted as its linked to products !'));
        }

        if ($category->image != '' && file_exists(public_path() . '/images/subcategory/' . $category->image)) {
            unlink(public_path() . '/images/subcategory/' . $category->image);
        }

        $value = $category->delete();

        if($value){
            session()->flash("deleted",__("Subcategory has been deleted !"));
            return redirect("admin/subcategory");
        }
    }
}
