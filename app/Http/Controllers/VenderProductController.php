<?php

namespace App\Http\Controllers;

use App\AddProductVariant;
use App\AddSubVariant;
use App\admin_return_product;
use App\Brand;
use App\Cart;
use App\Category;
use App\Commission;
use App\CommissionSetting;
use App\FaqProduct;
use App\Genral;
use App\Grandcategory;
use App\Jobs\CartPriceChange;
use App\Product;
use App\RealatedProduct;
use App\Related_setting;
use App\Shipping;
use App\SimpleProduct;
use App\SizeChart;
use App\Store;
use App\Subcategory;
use App\TaxClass;
use Auth;
use Avatar;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Session;
use View;
use Image;
use Nwidart\Modules\Facades\Module;

class VenderProductController extends Controller
{
    public function __construct()
    {
        $this->moduleenable = Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled();
    }

    public function index(Request $request)
    {
        $products = Product::with(['category' => function ($q) {

            return $q->where('status', '=', '1')->select('id', 'title');

        }, 'subcategory' => function ($q) {

            return $q->where('status', '1')->select('id', 'title');

        }, 'childcat' => function ($q) {

            return $q->where('status', '=', '1')->select('id', 'title');

        }, 'subvariants' => function ($q) {

            return $q->where('def', '=', '1');

        }, 'subvariants.variantimages' => function ($q) {

            return $q->select('var_id', 'main_image');

        }, 'brand' => function ($q) {

            return $q->select('id', 'name');

        }])->with(['vender' =>  function ($q) {

            return $q->select('id', 'name');

        }])->whereHas('vender', function ($query) {

            return $query->where('status', '=', '1')->where('is_verified', '1');

        })->with(['store' =>  function ($q) {

            $q->select('id', 'name');

        }])->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->where('vender_id',auth()->user()->id);

        if($request->ajax()){
            return DataTables::of($products)
            ->addColumn('checkbox', function ($row) {

                $chk = "<div class='inline'>
                            <input type='checkbox' form='bulk_delete_form' class='filled-in material-checkbox-input' name='checked[]'' value='$row->id' id='checkbox$row->id'>
                            <label for='checkbox$row->id' class='material-checkbox'></label>
                            </div>";

                return $chk;
            })
            ->addIndexColumn()
            ->addColumn('image', function ($row) {

                $image = '';

                if (isset($row->subvariants[0]) && $row->subvariants[0]->variantimages) {

                    $image .= "<img width='70px' title='" . str_replace('"', '', $row->name) . "' class='object-fit' src='" . url('variantimages/thumbnails/' . $row->subvariants[0]->variantimages->main_image) . "' alt='" . $row->name . "'>";

                } else {

                    $image = '<img class="object-fit" width="70px" title="Make a variant first !" src="' . Avatar::create($row->name)->toBase64() . '"/>';

                }

                return $image;
            })
            ->addColumn('name', function ($row) {

                $html = '';

                if ($row->name != null) {
                    $html .= '<p><b>' . $row->name . '</b></p>';
                } else {
                    $html .= '<p><b>Product translation not updated in this language </b></p>';
                }

                $html .= '<p><b>Store:</b> ' . $row->store->name ?? __("No Store set") . ' </p>';
                $html .= '<p><b>Brand:</b> ' . $row->brand->name ?? __("No Brand Set") . ' </p>';

                return $html;
            })
            ->addColumn('price', 'admin.product.dtablecolumn.price')
            ->addColumn('catdtl', function ($row) {
                $catdtl = '';

                if ($row->category != null) {
                    $catdtl .= '<p><i class="fa fa-angle-double-right"></i> ' . $row->category->title . '</p>';
                } else {
                    $catdtl .= '<p>'.__('Category not set').'</p>';
                }

                if ($row->subcategory != null) {
                    $catdtl .= '<p class="font-weight600"><i class="fa fa-angle-double-right"></i> ' . $row->subcategory->title . '</p>';
                } else {
                    $catdtl .= "<p>".__('Subcategory not set')."</p>";
                }

                if ($row->childcat != null) {
                    $catdtl .= '<p class="font-weight600"><i class="fa fa-angle-double-right"></i> ' . $row->childcat->title . '</p>';
                } else {
                    $catdtl .= "<p>".__("Child category not set")."</p>";
                }

                return $catdtl;
            })
            ->addColumn('status', 'seller.product.dtablecolumn.status')
            ->addColumn('created_at', 'seller.product.dtablecolumn.history')
            ->addColumn('action', 'seller.product.dtablecolumn.action')
            ->rawColumns(['checkbox', 'image', 'name', 'price', 'catdtl', 'featured', 'status', 'created_at', 'action'])
            ->make(true);
        }

        
        return view("seller.product.index");
    }

    public function additionalPrice(Request $request)
    {
        $product = Product::find($request->productid);
        if ($product) {
            return response()->json(['body' => View::make('admin.product.dtablecolumn.add_price_detail', compact('product'))->render()]);
        } else {
            return response()->json(['msg' => __('No product found !')]);
        }
    }

    public function allvariants($id)
    {
        $pro = Product::find($id);

        if (!$pro) {
            notify()->error(__('Product not found !'), '404');
            return back();
        }

        return view('seller.product.allvar', compact('pro'));
    }

    public function importPage()
    {
        if($this->moduleenable == 1){

            if(getPlanStatus() == 1 && auth()->user()->activeSubscription->plan->csv_product != 1){

                notify()->error(__('This feature is not available in your current subscription !'),__('Sorry !'));
                return redirect(route('my.products.index'));

            }
            
            return view('seller.product.import');

        }else{
            return view('seller.product.import');
        }
       
    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), ['action' => 'required', 'checked' => 'required']);

        if ($validator->fails()) {


            $errors = $validator->errors();
            
            if($errors->first('action')){
                notify()->error('Please select action from action list !');
            }
            
            if($errors->first('checked')){
                notify()->error('Atleast one item is required to be checked !');
            }

            return back();
            
        }

        $products = Product::whereIn('id',$request->checked)->get();

        if($request->action == 'deleted'){
            $products->each(function($product){
                $product->subvariants()->delete();
                $product->delete();
            });
        }

        if($request->action == 'deactivated'){
            $products->each(function($product){
                $product->status = '0';
                $product->save();
            });
        }

        if($request->action == 'activated'){
            
            $products->each(function($product){
                $product->status = '1';
                $product->save();
            });
        }


        notify()->success(__('Selected products has been :action'),['action' => $request->action]);
        return back();
    }

    public function storeImportProducts(Request $request)
    {

        if($this->moduleenable == 1){

            if(auth()->user()->activeSubscription && auth()->user()->activeSubscription->plan && auth()->user()->activeSubscription->plan->csv_product != 1){
                notify()->error(__('This feature is not available in your current subscription !'),__('Sorry !'));
                return back();
            }

        }       

        Validator::make(
            [
                'file' => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xlsx,xls,csv',
            ]

        );

        if (!$request->has('file')) {
            notify()->warning('Please choose a file !');
            return back();
        }

        $fileName = time() . '.' . $request->file->getClientOriginalExtension();

        if (!is_dir(public_path() . '/excel')) {
            mkdir(public_path() . '/excel');
        }

        $request->file->move(public_path('excel'), $fileName);

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', -1);

        $productfile = (new FastExcel)->import(public_path() . '/excel/' . $fileName);
        $lang = Session::get('changed_language');

        
       
        if(Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled() && auth()->user()->activeSubscription->plan->csv_product == 1){

            $plancount = auth()->user()->activeSubscription->plan->product_create;

            $hisitemsleft = $plancount - (auth()->user()->products()->count() + auth()->user()->store->simple_products->count());

            if(count($productfile) > $hisitemsleft){

                $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                if ($file) {
                    unlink(public_path() . '/excel/' . $fileName);
                }

                notify()->error(__('Excel contains more products then your current products upload limit !','Sorry !'));
                return back();

            }

            
        }

        if($request->type == '1'){
            return $this->simpleimportproducts($productfile,$fileName);
        }

        if (count($productfile) > 0) {

            foreach ($productfile as $key => $line) {

                $rowno = $key;
                $sellPrice = 0;
                $sellofferPrice = 0;
                $commissionRate = 0;

                $catname = $line['category_name'];

                $catid = Category::whereRaw("JSON_EXTRACT(title, '$.$lang') = '$catname'")->first();

                if (!$catid) {
                    $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                    if ($file) {
                        unlink(public_path() . '/excel/' . $fileName);
                    }

                    notify()->error(__('Invalid Category name at Row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                    return back();
                    break;
                }

                $subcatname = $line['subcategory_name'];
                $subcatid = Subcategory::whereRaw("JSON_EXTRACT(title, '$.$lang') = '$subcatname'")->first();

                if (!$subcatid) {
                    $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                    if ($file) {
                        unlink(public_path() . '/excel/' . $fileName);
                    }

                    notify()->error(__('Invalid Subategory name at Row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                    return back();
                    break;
                }

                $brandnid = Brand::where('name', $line['brand_name'])->first();

                if (!$brandnid) {

                    $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                    if ($file) {
                        unlink(public_path() . '/excel/' . $fileName);
                    }

                    notify()->error(__('Invalid Brand name at Row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                    return back();

                    break;
                }

                $store = Store::where('name', $line['store_name'])->first();

                if (!$store) {
                    $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                    if ($file) {
                        unlink(public_path() . '/excel/' . $fileName);
                    }

                    notify()->error(__('Invalid Store name at Row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                    return back();
                    break;
                }

                if ($line['return_available'] != '0') {

                    $p = admin_return_product::where('name', $line['return_policy'])->first();

                    if (!isset($p)) {
                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        notify()->error(__('Invalid return policy name at Row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                        return back();
                        break;
                    }

                    $policy = $p->id;
                } else {
                    $policy = 0;
                }

                if ($line['tax'] != '0') {

                    $tc = TaxClass::where('title', $line['tax'])->first();

                    if (!isset($tc)) {
                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        notify()->error(__('Invalid Taxclass name at Row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                        return back();
                        break;
                    }

                    $taxClass = $tc->id;

                } else {

                    $taxClass = 0;

                }

                if ($line['free_shipping'] != '1') {

                    $freeShipping = 1;
                    $ship = Shipping::where('default_status', '1')->first();

                    if (!isset($ship)) {
                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        notify()->error(__('Invalid Shipping name at Row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                        return back();
                        break;
                    }

                    $shippingID = $ship->id;

                } else {

                    $freeShipping = 0;
                    $shippingID = null;

                }

                if ($line['childcategory'] != '') {
                    $childcatname = $line['childcategory'];
                    $c = Grandcategory::whereRaw("JSON_EXTRACT(title, '$.$lang') = '$childcatname'")->first();

                    if (!isset($c)) {
                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        notify()->error(__('Invalid Childcategory name at row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                        return back();
                        break;
                    }

                    $childid = $c->id;
                } else {
                    $childid = '0';
                }

                /*Commission Price*/
                $commission = CommissionSetting::first();
               
                if ($commission->type == "flat") {
                    if ($commission->p_type == "f") {

                        if ($line['tax_rate'] != '') {

                            $cit = $commission->rate * $line['tax_rate'] / 100;
                            $price = $line['price'] + $commission->rate + $cit;
                            $offer = $line['offer_price'] + $commission->rate + $cit;

                        } else {
                            $price = $line['price'] + $commission->rate;
                            $offer = $line['offer_price'] + $commission->rate;
                        }

                        $sellPrice = $price;
                        $sellofferPrice = $offer;
                        $commissionRate = $commission->rate;

                    } else {

                        $taxrate = $commission->rate;
                        $price1 = $line['price'];
                        $price2 = $line['offer_price'];
                        $tax1 = ($price1 * (($taxrate / 100)));
                        $tax2 = ($price2 * (($taxrate / 100)));
                        $sellPrice = $price1 + $tax1;
                        $sellofferPrice = $price2 + $tax2;

                        if (!empty($tax2)) {
                            $commissionRate = $tax2;
                        } else {
                            $commissionRate = $tax1;
                        }
                    }
                } else {

                    $comm = Commission::where('category_id', $catid)
                        ->first();
                    if (isset($comm)) {
                        if ($comm->type == 'f') {

                            if ($line['tax_rate'] != '') {

                                $cit = $comm->rate * $line['tax_rate'] / 100;
                                $price = $line['price'] + $comm->rate + $cit;
                                $offer = $line['offer_price'] + $comm->rate + $cit;

                            } else {

                                $price = $line['price'] + $comm->rate;
                                $offer = $line['offer_price'] + $comm->rate;

                            }

                            $sellPrice = $price;
                            $sellofferPrice = $offer;
                            $commissionRate = $comm->rate;

                        } else {
                            $taxrate = $comm->rate;
                            $price1 = $line['price'];
                            $price2 = $line['offer_price'];
                            $tax1 = ($price1 * (($taxrate / 100)));
                            $tax2 = ($price2 * (($taxrate / 100)));
                            $price = $line['price'] + $tax1;
                            $offer = $line['offer_price'] + $tax2;
                            $sellPrice = $price;
                            $sellofferPrice = $offer;

                            if (!empty($tax2)) {
                                $commissionRate = $tax2;
                            } else {
                                $commissionRate = $tax1;
                            }
                        }
                    } else {
                        $commissionRate = 0;
                        $sellPrice = $line['price'] + $commissionRate;

                        if ($line['offer_price'] != '' && $line['offer_price'] != '0') {
                            $sellofferPrice = $line['offer_price'] + $commissionRate;
                        } else {
                            $sellofferPrice = 0;
                        }
                    }
                }

                
                /**/

                //convert for enum value
                if ($line['featured'] == 0) {
                    $featured = '0';
                } else {
                    $featured = '1';
                }

                if ($line['status'] == 0) {
                    $pstatus = '0';
                } else {
                    $pstatus = '1';
                }
                /**/

                $product = Product::create([

                    'category_id' => $catid->id,
                    'child' => $subcatid->id,
                    'grand_id' => $childid,
                    'store_id' => $store['id'],
                    'vender_id' => $store->user['id'],
                    'brand_id' => $brandnid->id,
                    'name' => $line['product_name'],
                    'des' => clean($line['product_description']),
                    'tags' => $line['tags'],
                    'model' => $line['model_no'],
                    'sku' => $line['sku'],
                    'price_in' => $line['price_in'],
                    'price' => $sellPrice,
                    'offer_price' => $sellofferPrice,
                    'featured' => $featured,
                    'status' => $pstatus,
                    'vender_price' => $line['price'],
                    'vender_offer_price' => $line['offer_price'],
                    'tax' => $taxClass,
                    'codcheck' => $line['cash_on_delivery'],
                    'free_shipping' => $freeShipping,
                    'selling_start_at' => $line['selling_start_at'],
                    'return_avbl' => $line['return_available'],
                    'cancel_avl' => $line['cancel_available'],
                    'w_d' => $line['warranty_in_days'],
                    'w_my' => $line['warranty_in_monthsyears'],
                    'w_type' => $line['warranty_type'],
                    'commission_rate' => $commissionRate,
                    'shipping_id' => $shippingID,
                    'return_policy' => $policy,
                    'tax_r' => $line['tax_rate'],
                    'tax_name' => $line['tax_name'],
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),

                ]);

                $relsetting = new Related_setting;
                $relsetting->pro_id = $product->id;
                $relsetting->status = '0';
                $relsetting->save();

            }

            notify()->success(__('Products Imported Successfully !'), __(':count Imported !',['count' => $productfile->count() - 1]));

            $file = @file_get_contents(public_path() . '/excel/' . $fileName);

            if ($file) {
                unlink(public_path() . '/excel/' . $fileName);
            }

            return back();

        } else {

            notify()->error(__('Your excel file is empty !'));
            $file = @file_get_contents(public_path() . '/excel/' . $fileName);

            if ($file) {
                unlink(public_path() . '/excel/' . $fileName);
            }

            return back();
        }

    }

    public function simpleimportproducts($productfile,$fileName){

        if (count($productfile) > 0) {

            $lang = app()->getLocale();

            foreach ($productfile as $key => $product) {

                $catid = Category::where('title->'.$lang,$product['category_id'])->first();

                if (!isset($catid)) {
                    $catid = new Category;
                    $catid->title = $product['category_id'];
                    $catid->status = '1';
                    $catid->featured = '0';
                    $catid->position = (Category::count() + 1);
                    $catid->save();
                }

                $subcatname = $product['subcategory_id'];
                $subcatid = Subcategory::whereRaw("JSON_EXTRACT(title, '$.$lang') = '$subcatname'")->first();

                if (!isset($subcatid)) {

                    $subcatid = new Subcategory;
                    $subcatid->title = $subcatname;
                    $subcatid->status = '1';
                    $subcatid->position = (Subcategory::count() + 1);
                    $subcatid->featured = '0';
                    $subcatid->parent_cat = $catid->id;
                    $subcatid->save();
                }

                $brandnid = Brand::where('name', $product['brand_id'])->first();

                if (!isset($brandnid)) {

                    $brandnid = new Brand;
                    $brandnid->name = $product['brand_id'];
                    $brandnid->status = '1';
                    $brandnid->show_image = '1';
                    $brandnid->is_requested = '0';
                    $brandnid->save();

                }

                if ($product['child_id'] != '') {

                    $childcatname = $product['child_id'];
                    $c = Grandcategory::whereRaw("JSON_EXTRACT(title, '$.$lang') = '$childcatname'")->first();

                    if (!isset($c)) {

                        $child = new Grandcategory;
                        $child->title = $product['child_id'];
                        $child->status = '1';
                        $child->position = (Grandcategory::count() + 1);
                        $child->featured = '0';
                        $child->parent_id = $catid->id;
                        $child->subcat_id = $subcatid->id;
                        $child->save();

                        $childid = $child->id;

                    } else {
                        $childid = $c->id;
                    }

                }

                $store = Store::where('name', $product['store_id'])->first();

                if (!$store) {
                    $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                    if ($file) {
                        unlink(public_path() . '/excel/' . $fileName);
                    }

                    notify()->error(__('Invalid Store name at row no :row ! Please create it and than try to import this file again !',['row' => $key]));

                    return back();
                    break;
                }

                if ($product['return_avbl'] == '1') {

                     $p = admin_return_product::find($product['return_policy']);
                    
                    if (!$p) {
                        $file = @file_get_contents(public_path() . '/excel/' . $fileName);

                        if ($file) {
                            unlink(public_path() . '/excel/' . $fileName);
                        }

                        $rowno = $key + 1;

                        notify()->error(__('Invalid return policy name at row no :row ! Please create it and than try to import this file again !',['row' => $rowno]));

                        return back();
                        break;
                    }

                    $policy = $p->id;
                }

                $commission = CommissionSetting::first();

                if ($commission->type == "flat") {
                    if ($commission->p_type == "f") {

                        $cit = $commission->rate * $product['tax_rate'] / 100;
                        $price = $product['actual_selling_price'] + $commission->rate + $cit;
                        $offer = $product['actual_offer_price'] + $commission->rate + $cit;

                       
                        $price = $price;
                        $offer_price = $offer;

                        $commission_rate = $commission->rate + $cit;

                    } else {

                        $taxrate = $commission->rate;
                        $price1 = $product['actual_selling_price'];
                        $price2 = $product['actual_offer_price'];
                        $tax1   = $price1 * ($taxrate / 100);
                        $tax2   = $price2 * ($taxrate / 100);
                        $price  = $product['actual_selling_price'] + $tax1;
                        $offer  = $product['actual_offer_price'] + $tax2;

                       
                        $price = $price;
                        $offer_price = $offer;

                        if (!empty($tax2)) {
                            $commission_rate = $tax2;
                        } else {
                            $commission_rate = $tax1;
                        }
                    }
                } else {

                    $comm = Commission::where('category_id', $catid)->first();

                    if (isset($comm)) {
                        if ($comm->type == 'f') {

                            $cit = $comm->rate * $product['tax_rate'] / 100;
                            $price = $product['actual_selling_price'] + $comm->rate + $cit;
                            $offer = $product['actual_offer_price'] + $comm->rate + $cit;

                            $price = $price;
                            $offer_price = $offer;
                            $commission_rate = $comm->rate + $cit;

                        } else {

                            $taxrate = $comm->rate;
                            $price1 = $product['actual_selling_price'];
                            $price2 = $product['actual_offer_price'];
                            $tax1 = $price1 * ($taxrate / 100);
                            $tax2 = $price2 * ($taxrate / 100);
                            $price = $product['actual_selling_price'] + $tax1;
                            $offer = $product['actual_offer_price'] + $tax2;

                        
                            $price = $price;
                            $offer_price = $offer;

                            if (!empty($tax2)) {
                                $commission_rate = $tax2;
                            } else {
                                $commission_rate = $tax1;
                            }
                        }
                    }
                }

                if($product['actual_offer_price'] != 0 || $product['actual_offer_price']){

                    $tax_rate = sprintf("%.2f",$product['actual_offer_price'] * $product['tax_rate'] / 100);
                    $offer_price = sprintf("%2.f",$offer_price + $tax_rate);
        
                    $taxrate = sprintf("%.2f",$product['actual_selling_price'] * $product['tax_rate'] / 100);
                    $price = sprintf("%2.f",$price + $taxrate);
        
                }else{
                    $tax_rate = sprintf("%.2f",$product['actual_selling_price'] * $product['tax_rate'] / 100);
                    $price = sprintf("%2.f",$price + $tax_rate);
                    $offer_price = 0;
                }

                $simple_product = SimpleProduct::create([
                    'product_name'    => $product['product_name'],
                    'product_detail'  => $product['product_detail'],
                    'slug'            => str_slug($product['product_name'], '-', app()->getLocale()),
                    'category_id'     => $catid->id,
                    'subcategory_id'  => $subcatid->id,
                    'child_id'        => $childid ?? NULL,
                    'product_tags'    => $product['product_tags'],
                    'tax'             => $tax_rate,
                    'tax_rate'        => $product['tax_rate'],
                    'tax_name'        => $product['tax_name'],
                    'thumbnail'       => $product['thumbnail'],
                    'hover_thumbnail' => $product['hover_thumbnail'],
                    'status'          => $product['status'],
                    'store_id'        => $store->id,
                    'brand_id'        => $brandnid->id,
                    'type'            => $product['type'],
                    'key_features'    => clean($product['key_features']),
                    'product_detail'  => clean($product['product_detail']),
                    'free_shipping'   => $product['free_shipping'],
                    'featured'        => $product['featured'],
                    'cancel_avbl'     => $product['cancel_avbl'],
                    'cod_avbl'        => $product['cod_avbl'],
                    'return_avbl'     => $product['return_avbl'],
                    'policy_id'       => $policy ?? NULL,
                    'model_no'        => $product['model_no'],
                    'sku'             => $product['sku'],
                    'hsin'            => $product['hsin'],
                    'actual_offer_price' => $product['actual_offer_price'] ?? 0,
                    'actual_selling_price' => $product['actual_selling_price'],
                    'price'           => $price,
                    'offer_price'     => $offer_price ?? 0,
                    'commission_rate' => $commission_rate ?? 0,
                    'stock'           => $product['stock'] ?? 1,
                    'min_order_qty'   => $product['min_order_qty'] ?? 1,
                    'max_order_qty'   => $product['max_order_qty'] ?? 1,
                    'external_product_link' => $product['type'] == 'ex_product' ? $product['external_product_link'] : NULL
                ]);

            }

            notify()->success(__('Product import successfully !'),__('Imported'));
            $file = @file_get_contents(public_path() . '/excel/' . $fileName);

            if ($file) {
                unlink(public_path() . '/excel/' . $fileName);
            }

            return back();

        }else{
            notify()->warning(__('Your excel file is empty !'));
            $file = @file_get_contents(public_path() . '/excel/' . $fileName);

            if ($file) {
                unlink(public_path() . '/excel/' . $fileName);
            }
            return back();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if (Auth::check()) {
            $auth_name = Auth::user()->name;
            $vender_id = Auth::user()->id;
        }

        if (!Auth::user()->store) {
            notify()->warning(__('Sorry your store is not found or deactive !'));
            return back();
        }

        if(config('sellersubscription.enable') == 1 && Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled()){

            if((auth()->user()->products()->count() + auth()->user()->store->simple_products->count()) == auth()->user()->activeSubscription->plan->product_create){
               notify()->error('Product upload limit reached !','Upgrade your plan');
               return redirect(route('my.products.index'));
            }

        }

        $categorys = Category::where('status','1')->get(['id','title']);
        $brands_products = Brand::where('status', '=', '1')->get();
        $template_size_chart = SizeChart::whereHas('sizeoptions')
                                ->whereHas('sizeoptions.values')
                                ->with('sizeoptions')
                                ->where('status','=','1')
                                ->where('user_id',auth()->id())
                                ->get();

        return view('seller.product.create', compact('auth_name', 'brands_products', 'categorys', 'vender_id','template_size_chart'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        if(config('sellersubscription.enable') == 1 && Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled()){

           
            if((auth()->user()->products()->count() + auth()->user()->store->simple_products->count() ) == auth()->user()->activeSubscription->plan->product_create){
               notify()->error(__('Product upload limit reached !'),__('Upgrade your plan'));
               return redirect(route('my.products.index'));
            }

        }

        $data = $this->validate($request, ["name" => "required", "price" => "required", 'brand_id' => 'required|not_in:0', 'category_id' => 'required|not_in:0', 'child' => 'required|not_in:0',

        ], [

            "name.required" => __("Product Name is needed"), 
            "price.required" => __("Price is needed"), 
            "brand_id.required" => __("Please Choose Brand"),

        ]);

        $input = $request->all();
        $currency_code = Genral::first()->currency_code;

        if (isset($request->codcheck)) {
            $input['codcheck'] = "1";
        } else {
            $input['codcheck'] = "0";
        }

        if (isset($request->featured)) {
            $input['featured'] = "1";
        } else {
            $input['featured'] = "0";
        }

        if (isset($request->tax_manual)) {

            $request->validate(['tax_r' => 'required|numeric', 'tax_name' => 'string|required|min:1']);

            $input['tax'] = 0;

        } else {

            $input['tax_r'] = null;
            $input['tax_name'] = null;

        }

        if (isset($request->free_shipping)) {

            $input['free_shipping'] = "1";
        } else {

            $sid = Shipping::where('default_status', "1")->first();
            $input['shipping_id'] = $sid->id;
            $input['free_shipping'] = "0";
        }

        $input['price_in'] = $currency_code;

        if ($request->vender_price == '') {
            $input['vender_price'] = $request->price;
            $input['vender_offer_price'] = $request->offer_price;
        }

        if (!is_dir(public_path() . '/images/videothumbnails')) {
            mkdir(public_path() . '/images/videothumbnails');
        }

        if(isset($request->other_cats)){

            $other_categories = $request->other_cats;
 
            $duplicate_element_index = array_search($request->category_id,$other_categories);
            
            if($duplicate_element_index !== false){
                unset($other_categories[$duplicate_element_index]);
            }
            
            $other_categories = array_values($other_categories);
 
            $input['other_cats'] = $other_categories;
 
         }else{
 
             $input['other_cats'] = NULL;
 
         }

        if ($request->video_thumbnail) {

            $request->validate([
                'video_thumbnail' => 'mimes:jpeg,jpg,png,webp,gif|max:512',
            ]);

            $image = $request->file('video_thumbnail');
            $input['video_thumbnail'] = 'video_thumbnail_' . uniqid() . '.webp';
            $destinationPath = public_path('/images/videothumbnails');
            $img = Image::make($image->path());

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->insert(public_path('images/play-icon.png'), 'center', 10, 10);

            $img->save($destinationPath . '/' . $input['video_thumbnail']);

        }

        if ($request->catlog) {

            $validator = Validator::make(
                [
                    'file' => $request->catlog,
                    'extension' => strtolower($request->catlog->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required|max:1024',
                    'extension' => 'required|in:pdf,doc,docx,ppt,txt',
                ]

            );

            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file for product catlog !'));
            }

            if (!is_dir(public_path() . '/productcatlog')) {
                mkdir(public_path() . '/productcatlog');
            }

            $input['catlog'] = time() . '_catlog.' . $request->catlog->getClientOriginalExtension();

            $request->catlog->move(public_path('productcatlog'), $input['catlog']);

        }

        $commission = CommissionSetting::first();
    
        if ($commission->type == "flat") {
            if ($commission->p_type == "f") {

                $price = $input['price'] + $commission->rate;
                $offer = $input['offer_price'] + $commission->rate;
                $input['price'] = $price;
                $input['offer_price'] = $offer;
                $input['commission_rate'] = $commission->rate;

            } else {

                $taxrate = $commission->rate;
                $price1 = $input['price'];
                $price2 = $input['offer_price'];
                $tax1 = $price1 * ($taxrate / 100);
                $tax2 = $price2 * ($taxrate / 100);
                $price = $input['price'] + $tax1;
                $offer = $input['offer_price'] + $tax2;
                $input['price'] = $price;
                $input['offer_price'] = $offer;
                if (!empty($tax2)) {
                    $input['commission_rate'] = $tax2;
                } else {
                    $input['commission_rate'] = $tax1;
                }
            }
        } else {

            $comm = Commission::where('category_id', $request->category_id)
                ->first();
            if (isset($comm)) {
                if ($comm->type == 'f') {

                    $price = $input['price'] + $comm->rate;
                    $offer = $input['offer_price'] + $comm->rate;
                    $input['price'] = $price;
                    $input['offer_price'] = $offer;
                    $input['commission_rate'] = $comm->rate;

                } else {
                    $taxrate = $comm->rate;
                    $price1 = $input['price'];
                    $price2 = $input['offer_price'];
                    $tax1 = $price1 * ($taxrate / 100);
                    $tax2 = $price2 * ($taxrate / 100);
                    $price = $input['price'] + $tax1;
                    $offer = $input['offer_price'] + $tax2;
                    $input['price'] = $price;
                    $input['offer_price'] = $offer;

                    if (!empty($tax2)) {
                        $input['commission_rate'] = $tax2;
                    } else {
                        $input['commission_rate'] = $tax1;
                    }
                }
            }
        }

        

        if ($request->return_avbls == "1") {

            $request->validate(['return_avbls' => 'required', 'return_policy' => 'required'], ['return_policy.required' => __('Please choose return policy')]);

            if ($request->return_policy === "Please choose an option") {
                return back()
                    ->with('warning', __('Please choose a return policy !'));
            }

        }

        if ($request->return_avbls == "1") {

            $input['return_avbl'] = "1";
            $input['return_policy'] = $request->return_policy;
        } else {

            $input['return_avbl'] = 0;
            $input['return_policy'] = 0;
        }

        $input['video_preview'] = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $request->video_preview);

        $input['vender_id'] = auth()->id();
        $input['grand_id'] = isset($request->grand_id) ? $request->grand_id : 0;
        $input['w_d'] = $request->w_d;
        $input['w_my'] = $request->w_my;
        $input['w_type'] = $request->w_type;
        $input['gift_pkg_charge'] = $request->gift_pkg_charge ?? 0;
        $data = Product::create($input);

        $data->save();

        $relsetting = new Related_setting;
        $relsetting->pro_id = $data->id;
        $relsetting->status = '0';
        $relsetting->save();

        notify()->success(__('Product created !  create at-least one variant to complete the product'));

        return redirect()->route('seller.add.var', $data->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Vender $vender)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
       
        $products = Product::find($id);
        $categorys = Category::where('status','1')->get(['id','title']);
        $brands_products = Brand::where('status', '=', '1')->get();
        $store = Store::where('user_id', Auth::user()->id)
            ->where('status', "1")
            ->first();

        if (!$store) {
            notify()->error(__('Sorry your store is not found or deactive !'));
            return back();
        }

        $faqs = FaqProduct::where('pro_id', $id)->get();
        $cat_id = Product::where('id', $id)->first();
        $child = Subcategory::where('parent_cat', $cat_id->category_id)->get();
        $realateds = RealatedProduct::get();
        $rel_setting = $products->relsetting;
        //$child_id = Subcategory::where('parent_cat',$cat_id->category_id)->first();
        $grand = Grandcategory::where('status','1')->where('subcat_id', $cat_id->child)
            ->get();
        
        $template_size_chart = SizeChart::whereHas('sizeoptions')
        ->whereHas('sizeoptions.values')
        ->with('sizeoptions')
        ->where('status','=','1')
        ->where('user_id',auth()->id())
        ->get();

        return view("seller.product.edit_tab", compact("rel_setting", "products", "categorys", "store", "brands_products", "faqs", "child", "grand", "realateds","template_size_chart"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product = Product::find($id);

        if (!$product) {
            notify()->error('No Product found !', '404');
            return back();
        }

        $currency_code = Genral::first()->currency_code;

        $this->validate($request, ["name" => "required", "price" => "required|numeric", "brand_id.required" => "Please Choose Brand",

        ], [

            "name.required" => "Product Name is needed", "price.required" => "Price is needed",

        ]);

        $input = $request->all();

        if (isset($request->codcheck)) {
            $input['codcheck'] = "1";
        } else {
            $input['codcheck'] = "0";
        }

        if (isset($request->featured)) {
            $input['featured'] = "1";
        } else {
            $input['featured'] = "0";
        }

        if (isset($request->tax_manual)) {

            $request->validate(['tax_r' => 'required|numeric', 'tax_name' => 'string|required|min:1']);

            $input['tax'] = 0;

        } else {

            $input['tax_r'] = null;
            $input['tax_name'] = null;
            $input['tax'] = $request->tax;
        }

        $input['vender_price'] = $request->price;
        $input['vender_offer_price'] = $request->offer_price;

        $commission = CommissionSetting::first();
      
        if ($commission->type == "flat") {
            if ($commission->p_type == "f") {

                if (!isset($request->tax_r)) {

                    $price = $input['price'] + $commission->rate;
                    $offer = $input['offer_price'] + $commission->rate;

                    $input['price'] = $price;
                    $input['offer_price'] = $offer;
                    $input['commission_rate'] = $commission->rate;

                } else {

                    $cit = $commission->rate * $input['tax_r'] / 100;
                    $price = $input['price'] + $commission->rate + $cit;
                    $offer = $input['offer_price'] + $commission->rate + $cit;

                    $input['price'] = $price;
                    $input['offer_price'] = $offer;
                    $input['commission_rate'] = $commission->rate + $cit;
                }

            } else {

                $taxrate = $commission->rate;
                $price1 = $input['price'];
                $price2 = $input['offer_price'];
                $tax1 = $price1 * ($taxrate / 100);
                $tax2 = $price2 * ($taxrate / 100);
                $price = $input['price'] + $tax1;
                $offer = $input['offer_price'] + $tax2;
                $input['price'] = $price;
                $input['offer_price'] = $offer;
                if (!empty($tax2)) {
                    $input['commission_rate'] = $tax2;
                } else {
                    $input['commission_rate'] = $tax1;
                }
            }
        } else {

            $comm = Commission::where('category_id', $request->category_id)
                ->first();
            if (isset($comm)) {
                if ($comm->type == 'f') {

                    if (!isset($request->tax_manual)) {

                        $price = $input['price'] + $comm->rate;
                        $offer = $input['offer_price'] + $comm->rate;
                        $input['price'] = $price;
                        $input['offer_price'] = $offer;
                        $input['commission_rate'] = $comm->rate;

                    } else {

                        $cit = $commission->rate * $input['tax_r'] / 100;
                        $price = $input['price'] + $comm->rate + $cit;

                        if ($request->offer_price) {
                            $offer = $input['offer_price'] + $comm->rate + $cit;
                            $input['offer_price'] = $offer;
                        } else {
                            $input['offer_price'] = null;
                        }

                        $input['price'] = $price;

                        $input['commission_rate'] = $comm->rate + $cit;
                    }

                } else {

                    $taxrate = $comm->rate;
                    $price1 = $input['price'];
                    $price2 = $input['offer_price'];
                    $tax1 = $price1 * ($taxrate / 100);
                    $tax2 = $price2 * ($taxrate / 100);
                    $price = $input['price'] + $tax1;
                    $offer = $input['offer_price'] + $tax2;
                    $input['price'] = $price;
                    $input['offer_price'] = $offer;

                    if (!empty($tax2)) {
                        $input['commission_rate'] = $tax2;
                    } else {
                        $input['commission_rate'] = $tax1;
                    }
                }
            }
        }

        

        if ($request->return_avbls == "1") {

            $request->validate(['return_avbls' => 'required', 'return_policy' => 'required'], ['return_policy.required' => __('Please choose return policy')]);

            if ($request->return_policy === "Please choose an option") {
                return back()->withErrors(__('Please choose a return policy !'))->withInput();
            }

        }

        if ($request->return_avbls == "1") {

            $input['return_avbl'] = "1";
            $input['return_policy'] = $request->return_policy;
        } else {

            $input['return_avbl'] = 0;
            $input['return_policy'] = 0;
        }

        if (isset($request->free_shipping)) {

            $input['free_shipping'] = "1";
            $input['shipping_id'] = null;

        } else {

            $sid = Shipping::where('default_status', "1")->first();
            $input['shipping_id'] = $sid->id;
            $input['free_shipping'] = '0';
        }

        if (!is_dir(public_path() . '/images/videothumbnails')) {
            mkdir(public_path() . '/images/videothumbnails');
        }

        if ($request->video_thumbnail) {

            $request->validate([
                'video_thumbnail' => 'mimes:jpeg,jpg,png,webp,gif|max:512',
            ]);

            $image = $request->file('video_thumbnail');
            $input['video_thumbnail'] = 'video_thumbnail_' . uniqid() . '.webp';
            $destinationPath = public_path('/images/videothumbnails');
            $img = Image::make($image->path());

            if ($product->video_thumbnail != '' && file_exists(public_path() . '/images/videothumbnails/' . $product->video_thumbnail)) {
                unlink(public_path() . '/images/videothumbnails/' . $product->video_thumbnail);
            }

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->insert(public_path('images/play-icon.png'), 'center', 10, 10);

            $img->save($destinationPath . '/' . $input['video_thumbnail']);

        }

        if ($request->catlog) {

            $validator = Validator::make(
                [
                    'file' => $request->catlog,
                    'extension' => strtolower($request->catlog->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required|max:1024',
                    'extension' => 'required|in:pdf,doc,docx,ppt,txt',
                ]

            );

            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file for product catlog !'));
            }

            if (!is_dir(public_path() . '/productcatlog')) {
                mkdir(public_path() . '/productcatlog');
            }

            if ($product->catlog != '' && file_exists(public_path() . '/productcatlog/' . $product->catlog)) {
                unlink(public_path() . '/productcatlog/' . $product->catlog);
            }

            $input['catlog'] = time() . '_catlog.' . $request->catlog->getClientOriginalExtension();

            $request->catlog->move(public_path('productcatlog'), $input['catlog']);

        }

        $input['video_preview'] = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "https://youtube.com/embed/$1", $request->video_preview);

        $input['price_in'] = $currency_code;
        $input['w_d'] = $request->w_d;
        $input['w_my'] = $request->w_my;
        $input['w_type'] = $request->w_type;
        $input['key_features'] = clean($request->key_features);
        $input['des'] = clean($request->des);
        $input['grand_id'] = isset($request->grand_id) ? $request->grand_id : 0;
        $input['gift_pkg_charge'] = $request->gift_pkg_charge ?? 0;
        $product->update($input);

        /** Fire a job to handle cart price change if product price change */

        $cart = Cart::with('product')->whereHas('product')->with('variant')->whereHas('variant')->where('pro_id',$product->id)->get();


        CartPriceChange::dispatch($cart);

        notify()->success(__('Product has been updated !'), $product->name);
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $pro = Product::find($id);

        if (!$pro) {
            notify()->error(__('404 | Product not found !'));
            return back();
        }

      
        $pro->subvariants()->delete();
        

        $pro->delete();

        notify()->error(__('Product has been deleted !'));
        return back();

    }

}
