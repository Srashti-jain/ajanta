<?php
namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{

    public function index()
    {
        abort_if(!auth()->user()->can('category.view'),403,__('User does not have the right permissions.'));
        $category = Category::orderBy('position', 'asc')->get();
        return view("admin.category.index", compact("category"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        abort_if(!auth()->user()->can('category.create'),403,__('User does not have the right permissions.'));
        return view("admin.category.add_category");
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
            notify()->error('Invalid file !');
            return back();
        }

        $filename = 'categories_'.time() . '.' . $request->file->getClientOriginalExtension();

        Storage::disk('local')->put('/excel/'.$filename,file_get_contents($request->file->getRealPath()));

        $categories = fastexcel()->import(storage_path().'/app/excel/'.$filename);

        if(count($categories)){

            $categories->each(function($category){
                

               Category::create([

                    'title'         => $category['title'],
                    'icon'          => $category['icon'],
                    'description'   => clean($category['description']),
                    'status'        => (string) $category['status'],
                    'featured'      => (string) $category['featured'],
                    'image'         => $category['image'],
                    'position'      => (Category::count() + 1)

               ]);

            });

            try{

                unlink(storage_path().'/excel/'.$filename);

            }catch(\Exception $e){

            }

            notify()->success(__('Categories imported successfully'));

            return back();

        }else{
            notify()->error(__('File is empty !'));
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
        abort_if(!auth()->user()->can('category.create'),403,__('User does not have the right permissions.'));

        $request->validate(["title" => "required"], [
            "title.required" => __("Category name is required")
        ]);

        $input = array_filter($request->all());

        $input['description'] = clean($request->description);

        $cat = new Category();

        if ($request->image != null) {

            if(!str_contains($request->image, '.png') && !str_contains($request->image, '.jpg') && !str_contains($request->image, '.jpeg') && !str_contains($request->image, '.webp') && !str_contains($request->image, '.gif')){
                    
                return back()->withInput()->withErrors([
                    'image' => __('Invalid image type for category thumbnail')
                ]);

            }

            $input['image'] = $request->image;

        }

        $input['position'] = (Category::count() + 1);

        $cat->create($input);

        return back()->with("added", __("Category has been added !"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function reposition(Request $request)
    {
        abort_if(!auth()->user()->can('category.edit'),403,__('User does not have the right permissions.'));

        if ($request->ajax()) {

            $posts = Category::all();
            foreach ($posts as $post) {
                foreach ($request->order as $order) {
                    if ($order['id'] == $post->id) {
                        \DB::table('categories')->where('id', $post->id)->update(['position' => $order['position']]);
                    }
                }
            }
            return response()->json('Update Successfully.', 200);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('category.edit'),403,__('User does not have the right permissions.'));

        $cat = Category::findOrFail($id);

        return view("admin.category.edit", compact("cat"));

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

        abort_if(!auth()->user()->can('category.edit'),403,__('User does not have the right permissions.'));

        $request->validate( 
            [
                "title" => "required"
            ],[
                "title.required" => __("Title is required !")
            ]
        );

        $cat = Category::findOrFail($id);

        $category = Category::findOrFail($id);
        $input = array_filter($request->all());

        $input['description'] = clean($request->description);

        if ($request->image) {

            if(!str_contains($request->image, '.png') && !str_contains($request->image, '.jpg') && !str_contains($request->image, '.jpeg') && !str_contains($request->image, '.webp') && !str_contains($request->image, '.gif')){
                    
                return back()->withInput()->withErrors([
                    'image' => __('Invalid image type for category thumbnail')
                ]);

            }

            $input['image'] = $request->image;

        }

        $category->update($input);

        return redirect('admin/category')->with('updated', __('Category has been updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('category.delete'),403,__('User does not have the right permissions.'));

        $category = Category::find($id);

        if (count($category->products) > 0) {
            return back()
                ->with('warning', __('Category can\'t be deleted as its linked to products !'));
        }

        if ($category->image != '' && file_exists(public_path() . '/images/category/' . $category->image)) {
            unlink(public_path() . '/images/category/' . $category->image);
        }

        $value = $category->delete();
        if ($value) {
            session()->flash("deleted", __("Category has been deleted"));
            return redirect("admin/category");
        }
    }

}
