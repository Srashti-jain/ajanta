<?php

namespace App\Http\Controllers;

use App\AddSubVariant;
use App\Flashsale;
use App\Product;
use App\SimpleProduct;
use Illuminate\Http\Request;
use Image;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    public function index()
    {
        if(request()->ajax()){

            $deals = Flashsale::select('id','title','start_date','end_date','background_image');

            return DataTables::of($deals)
            ->addIndexColumn()
            ->addColumn('background_image', function ($row)
            {
                $image = '<img style="object-fit:scale-down;" width="100px" src="' . url("/images/flashdeals/" . $row->background_image) . '"/>';
                return $image;
            })
            ->editColumn('action', 'admin.flashsale.action')
            ->rawColumns(['background_image', 'action'])
            ->make(true);

        }
        return view('admin.flashsale.index');
    }

    public function create()
    {
        return view('admin.flashsale.create');
    }

    public function edit($id)
    {
        $deal = Flashsale::findorfail($id);
        return view('admin.flashsale.edit',compact('deal'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'background_image' => 'required|mimes:jpg,jpeg,png,gif,webp',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        DB::beginTransaction();

        $newdeal = new Flashsale();

        $input = $request->all();

        if (!is_dir(public_path() . '/images/flashdeals')) {
            mkdir(public_path() . '/images/flashdeals');
        }

        if($request->hasFile('background_image')){

            $image = $request->file('background_image');
            $input['background_image'] = 'flashdeal_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/flashdeals');
            $img = Image::make($image->path());

            $img->save($destinationPath . '/' . $input['background_image']);

        }

        $input['detail'] = clean($request->detail);

        $input['start_date'] = date('Y-m-d H:i:s',strtotime($request->start_date));
        $input['end_date'] = date('Y-m-d H:i:s',strtotime($request->end_date));
        $input['status'] = $request->status ? 1 : 0;
    
        $newdeal = $newdeal->create($input);

        foreach($request->product as $key => $product){

            $newdeal->saleitems()->create([
                'sale_id'           => $newdeal->id,
                'product_id'        => $request->type[$key] == 'variant' ? $request->product_id[$key] : 0,
                'simple_product_id' => $request->type[$key] == 'simple' ? $request->product_id[$key] : 0,
                'discount'          => $request->discount[$key],
                'discount_type'     => $request->discount_type[$key]
            ]);

        }

        DB::commit();

       return redirect()->route('flash-sales.index')->with('added', __('Flashdeal has been created !'));

    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        DB::beginTransaction();

        $newdeal = Flashsale::findorfail($id);

        $input = $request->all();

        if($request->hasFile('background_image')){

            $request->validate([
                'background_image' => 'required|mimes:jpg,jpeg,png,gif,webp'
            ]);

            $image = $request->file('background_image');
            $input['background_image'] = 'flashdeal_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/flashdeals');
            $img = Image::make($image->path());

            if ($newdeal->background_image != '' && file_exists(public_path() . '/images/flashdeals/' . $newdeal->background_image)) {
                unlink(public_path() . '/images/flashdeals/' . $newdeal->background_image);
            }
            
            $img->save($destinationPath . '/' . $input['background_image']);

        }

        $input['detail'] = clean($request->detail);

        $input['start_date'] = date('Y-m-d H:i:s',strtotime($request->start_date));
        $input['end_date'] = date('Y-m-d H:i:s',strtotime($request->end_date));
        $input['status'] = $request->status ? 1 : 0;

        $newdeal->update($input);

        $newdeal->saleitems()->delete();

        foreach($request->product as $key => $product){

            $newdeal->saleitems()->create([
                'sale_id'           => $newdeal->id,
                'product_id'        => $request->type[$key] == 'variant' ? $request->product_id[$key] : 0,
                'simple_product_id' => $request->type[$key] == 'simple' ? $request->product_id[$key] : 0,
                'discount'          => $request->discount[$key],
                'discount_type'     => $request->discount_type[$key]
            ]);

        }

        DB::commit();

        return back()->with('updated', __('Flashdeal has been updated !'));

    }

    public function destroy($id)
    {

        $newdeal = Flashsale::findorfail($id);
        if ($newdeal->background_image != '' && file_exists(public_path() . '/images/flashdeals/' . $newdeal->background_image)) {
            unlink(public_path() . '/images/flashdeals/' . $newdeal->background_image);
        }
        $newdeal->saleitems()->delete();
        $newdeal->delete();
        return back()->with('deleted', __('Flashdeal has been updated !'));

    }

    public function searchproduct(Request $request){
        
        $search = $request->get('term');
        
        $query = AddSubVariant::whereHas('products',function($q) use($search) {
                    return $q->where('name', 'LIKE', '%' . $search . '%')->where('status','1');
                })->with('products')->get();

        $query2 = SimpleProduct::where('product_name', 'LIKE', '%' . $search . '%')
                    ->where('status','1')
                    ->get();

        $query = $query->map(function($q){

                $item['value'] = $q->products->name.'('.variantname($q).')';
                $item['product_type'] = 'variant';
                $item['id'] = $q->id;

                return $item;
        });

        $query2 = $query2->map(function($q){

            $item['value'] = $q->product_name;
            $item['product_type'] = 'simple';
            $item['id'] = $q->id;

            return $item;

        });

        $query = $query->toBase()->merge($query2);

        if(!count($query)){
            $query[] = array('value' => 'No result found', 'product_type' => '0','id' => 0);
        }

        
        return response()->json($query);

    }

    public function list(){

        $deals = Flashsale::withCount('saleitems')->whereHas('saleitems')->where('status','1')->whereDate('end_date','>=',now())->paginate(12);

        require_once('price.php');
        
        return view('front.deals',compact('deals','conversion_rate'));

    }

    public function view($id,$slug){

        $deal = Flashsale::with('saleitems')
                ->whereHas('saleitems')
                ->where('status','1')
                ->whereDate('end_date','>=',now())
                ->where('id',$id)->firstorfail();

        require_once('price.php');
        
        return view('front.viewdeal',compact('deal','conversion_rate'));

    }

    
}
