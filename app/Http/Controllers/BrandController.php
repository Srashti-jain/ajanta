<?php
namespace App\Http\Controllers;

use App\Brand;
use Image;
use Illuminate\Http\Request;
use DataTables;
use Avatar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        abort_if(!auth()->user()->can('brand.view'),403,__('User does not have the right permissions.'));

        $brands = Brand::select('brands.id', 'brands.name', 'brands.image', 'brands.status');

        if ($request->ajax())
        {
            return DataTables::of($brands)->addIndexColumn()->addColumn('image', function ($row)
            {
                $photo = @file_get_contents('images/brands/'.$row->image);

                if($photo){
                    $image = '<img style="object-fit:scale-down;" width="100px" height="70px" src="' . url("images/brands/" . $row->image) . '"/>';
                }else{
                    $image = '<img width="70px" height="70px" src="' . Avatar::create($row->name)->toBase64() . '"/>';
                }
                
                return $image;
            })->editColumn('status', 'admin.brand.status')
                ->editColumn('action', 'admin.brand.action')
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.brand.index', compact('brands'));

    }

    public function requestedbrands()
    {
        abort_if(!auth()->user()->can('brand.view'),403,__('User does not have the right permissions.'));
        $brands = Brand::where('is_requested', '=', '1')->where('status', '0')
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.brand.requestedbrand', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('brand.create'),403,__('User does not have the right permissions.'));
        return view("admin.brand.add");
    }

    public function importbrands(Request $request){
        abort_if(!auth()->user()->can('brand.create'),403,__('User does not have the right permissions.'));

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

        $filename = 'brands_'.time() . '.' . $request->file->getClientOriginalExtension();

        Storage::disk('local')->put('/excel/'.$filename,file_get_contents($request->file->getRealPath()));

        $brands = fastexcel()->import(storage_path().'/app/excel/'.$filename);

        if(count($brands)){

            $brands->each(function($brand){
                

               Brand::create([
                   
                    'name'          => $brand['name'],
                    'status'        => (string) $brand['status'],
                    'category_id'   => explode(',',$brand['category_id']),
                    'show_image'    => $brand['show_image'],
                    'image'         => $brand['image']

               ]);

            });

            Storage::delete('/excel/'.$filename);

            notify()->success(__('Brands imported successfully'));

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

        abort_if(!auth()->user()->can('brand.create'),403,__('User does not have the right permissions.'));

        $this->validate($request, 
            [
                "name" => "required|unique:brands,name"
            ],
            [
                "name.required" => __("Brand name is required"),
            ]
        );

        $input = array_filter($request->all());

        if ($request->image != null)
        {
            if(!str_contains($request->image, '.png') && !str_contains($request->image, '.jpg') && !str_contains($request->image, '.jpeg') && !str_contains($request->image, '.webp') && !str_contains($request->image, '.gif')){
                    
                return back()->withInput()->withErrors([
                    'image' => _('Invalid image type for brand logo')
                ]);

            }

            $input['image'] = $request->image;
        }

        if(isset($request->status)){
            $input['status'] = '1';
        }else{
            $input['status'] = '0';
        }

        if(isset($request->show_image)){
            $input['show_image'] = '1';
        }else{
            $input['show_image'] = '0';
        }

        $data = Brand::create($input);

        return back()
            ->with("added", __("Brand Has Been Created !"));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('brand.edit'),403,__('User does not have the right permissions.'));
        $brand = Brand::findOrFail($id);
        return view("admin.brand.edit", compact("brand"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        abort_if(!auth()->user()->can('brand.edit'),403,__('User does not have the right permissions.'));

        $data = $this->validate($request, [

        "name" => "required|unique:brands,name,$id",

        ], [

        "name.required" => __("Brand name is required"),

        ]);

        $brand = Brand::findOrFail($id);

        $input = array_filter($request->all());

        if ($request->image != null)
        {
            if(!str_contains($request->image, '.png') && !str_contains($request->image, '.jpg') && !str_contains($request->image, '.jpeg') && !str_contains($request->image, '.webp') && !str_contains($request->image, '.gif')){
                    
                return back()->withInput()->withErrors([
                    'image' => __('Invalid image type for brand logo')
                ]);

            }
            
            $input['image'] = $request->image;
        }

        if(isset($request->status)){
            $input['status'] = '1';
        }else{
            $input['status'] = '0';
        }

        if(isset($request->show_image)){
            $input['show_image'] = '1';
        }else{
            $input['show_image'] = '0';
        }

        $brand->update($input);

        return redirect('admin/brand')->with('updated', __('Brand has been updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        abort_if(!auth()->user()->can('brand.delete'),403,__('User does not have the right permissions.'));

        $obj = Brand::findorFail($id);

        if ($obj
            ->products
            ->count() < 1)
        {
            if ($obj->image != null)
            {
                $image_file = @file_get_contents(public_path() . '/images/brand/' . $obj->image);

                if ($image_file)
                {
                    unlink(public_path() . '/images/brand/' . $obj->image);
                }
            }
            $value = $obj->delete();
            if ($value)
            {
                session()->flash("deleted", "Brand Has Been deleted");
                return redirect("admin/brand");
            }
        }
        else
        {
            return back()
                ->with('warning', __('Brand cannot be deleted as its linked to some products !'));
        }

    }

}

