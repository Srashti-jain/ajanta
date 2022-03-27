<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Commission;
use App\CommissionSetting;
use App\CurrencyNew;
use App\Genral;
use App\Http\Controllers\Web\HomeController;
use App\Notifications\SendReviewNotification;
use App\Product360Frame;
use App\ProductGallery;
use App\Seo;
use App\SimpleProduct;
use App\SizeChart;
use App\Store;
use App\Testimonial;
use App\User;
use App\UserReview;
use App\Widgetsetting;
use App\Wishlist;
use Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use Yajra\DataTables\Facades\DataTables;

class SimpleProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        if (DB::connection()->getDatabaseName()) {

            if (Schema::hasTable('seos')) {
                $this->seo = Seo::first();
                $this->setting = Genral::first();
            }
        }
    }

    public function index()
    {

        abort_if(!auth()->user()->can('products.view'), 403, __('User does not have the right permissions.'));

        if (in_array('Seller', auth()->user()->getRoleNames()->toArray())) {

            $products = SimpleProduct::where('store_id', auth()->user()->store->id)
                ->with(['store', 'store.user'])->whereHas('store', function ($q) {
                $q->where('rd', '=', '0')->where('apply_vender', '=', '1')->where('status', '=', '1');
            })->whereHas('store.user', function ($q) {
                $q->where('status', '=', '1');
            })->get();

        } else {
            $products = SimpleProduct::select('*');
        }

        $currency_code = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract', function ($query) {

            return $query->where('default_currency', '1');

        })->first();

        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->thumbnail && file_exists(public_path() . '/images/simple_products/' . $row->thumbnail)) {

                        return "<img width='60px' title='" . str_replace('"', '', $row->product_name) . "' class='object-fit' src='" . url('/images/simple_products/' . $row->thumbnail) . "' alt='" . $row->product_name . "'>";

                    } else {

                        return '<img width="60px" class="object-fit" src="' . Avatar::create($row->product_name)->toBase64() . '"/>';

                    }
                })
                ->addColumn('id', function ($row) {
                    return $row->id;
                })
                ->addColumn('product_name', function ($row) {
                    return $row->product_name;
                })
                ->addColumn('price', function ($row) use ($currency_code) {

                    if (in_array('Seller', auth()->user()->getRoleNames()->toArray())) {
                        return view('seller.simpleproducts.price', compact('currency_code', 'row'));
                    } else {
                        return view('admin.simpleproducts.price', compact('currency_code', 'row'));
                    }

                })
                ->addColumn('status', function ($row) {

                    if ($row->status == '1') {
                        return '<a class="btn btn-sm btn-rounded btn-success-rgba">' . __('Active') . '</a>';
                    } else {
                        return '<a class="btn btn-sm btn-rounded btn-danger-rgba">' . __("Deactive") . '</a>';
                    }

                })
                ->addColumn('action', function ($row) {

                    if (in_array('Seller', auth()->user()->getRoleNames()->toArray())) {
                        return view('seller.simpleproducts.action', compact('row'));
                    } else {
                        return view('admin.simpleproducts.action', compact('row'));
                    }

                })

                ->rawColumns(['image', 'price', 'status', 'action'])
                ->make(true);
        }

        if (in_array('Seller', auth()->user()->getRoleNames()->toArray())) {
            return view('seller.simpleproducts.index');
        } else {
            return view('admin.simpleproducts.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('products.create'), 403, __('User does not have the right permissions.'));
        $categories = Category::where('status', '1')->get();
        $brands_all = Brand::where('status', '1')->get();

        $template_size_chart = SizeChart::whereHas('sizeoptions')
            ->whereHas('sizeoptions.values')
            ->with('sizeoptions')
            ->where('status', '=', '1')
            ->where('user_id', auth()->id())
            ->get();

        if (in_array('Seller', auth()->user()->getRoleNames()->toArray())) {
            $store = auth()->user()->store;
            return view('seller.simpleproducts.create', compact('categories', 'brands_all', 'store', 'template_size_chart'));
        } else {
            $stores = Store::with('user')->whereHas('user')->get();
            return view('admin.simpleproducts.create', compact('categories', 'brands_all', 'stores', 'template_size_chart'));
        }
    }

    public function show($id, $slug)
    {
        require_once 'price.php';

        $product = SimpleProduct::with('productGallery')->where('id', '=', $id)->where('slug', $slug)->where('status', '1')->firstOrfail();

        if (!$product->productGallery()->count()) {
            notify()->error(__('Product is not setup completely !'), __('Missing gallery images !'));
            return redirect()->intended('/');
        }

        $enable_hotdeal = Widgetsetting::where('name', 'hotdeals')->first();

        $sellerSystem = $this->setting->vendor_enable;

        $hotdeals = $deal_data = new HomeController;

        $hotdeals = $deal_data->hotdeals();

        $testimonials = Testimonial::where('status', '1')->get();

        $enable_testimonial_widget = Widgetsetting::where('name', 'testimonial')->first();

        views($product)->record();

        $reviews = $product->reviews()->where('status', '1')->get();

        if (isset($reviews)) {

            $qualityprogress = 0;
            $quality = 0;
            $tq = 0;

            $priceprogress = 0;
            $price = 0;
            $tp = 0;

            $valueprogress = 0;
            $value = 0;
            $vp = 0;

            if (count($product->reviews)) {

                $count = count($product->reviews);

                foreach ($product->reviews as $key => $r) {
                    $quality = $tq + $r->qty * 5;
                }

                $countq = ($count * 1) * 5;
                $ratq = $quality / $countq;
                $qualityprogress = ($ratq * 100) / 5;

                foreach ($product->reviews as $key => $r) {
                    $price = $tp + $r->price * 5;
                }

                $countp = ($count * 1) * 5;
                $ratp = $price / $countp;
                $priceprogress = ($ratp * 100) / 5;

                foreach ($product->reviews as $key => $r) {
                    $value = $vp + $r->value * 5;
                }

                $countv = ($count * 1) * 5;
                $ratv = $value / $countv;
                $valueprogress = ($ratv * 100) / 5;

            }
        }

        $reviewcount = $product->reviews->where('status', "1")->WhereNotNull('review')->count();

        $cashback_settings = $product->cashback_settings;

        return view('front.digitalproduct', compact('cashback_settings', 'product', 'conversion_rate', 'enable_hotdeal', 'testimonials', 'enable_testimonial_widget', 'hotdeals', 'reviewcount', 'qualityprogress', 'priceprogress', 'valueprogress'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('products.create'), 403, __('User does not have the right permissions.'));

        $request->validate([
            'product_name' => 'required|string',
            'brand_id' => 'required',
            'store_id' => 'required',
            'subcategory_id' => 'required',
            'product_detail' => 'required|max:10000',
            'category_id' => 'required',
            'actual_selling_price' => 'numeric|required',
            'tax' => 'required',
            'tax_name' => 'required',
            'hsin' => 'required',
            'type' => 'required',
        ]);

        if ($request->actual_offer_price) {
            $request->validate([
                'actual_offer_price' => 'numeric|max:actual_selling_price',
            ]);
        }

        if ($request->return_avbl == 1) {
            $request->validate([
                'policy_id' => 'required',
            ]);
        }

        $input = array_filter($request->all());

        DB::beginTransaction();

        $product = new SimpleProduct;

        $input['status'] = $request->status ? 1 : 0;

        $input['slug'] = str_slug($request->product_name, '-', app()->getLocale());

        $input['product_detail'] = clean($request->product_detail);

        if (isset($request->other_cats)) {

            $other_categories = $request->other_cats;

            $duplicate_element_index = array_search($request->category_id, $other_categories);

            if ($duplicate_element_index !== false) {
                unset($other_categories[$duplicate_element_index]);
            }

            $other_categories = array_values($other_categories);

            $input['other_cats'] = $other_categories;

        } else {

            $input['other_cats'] = null;

        }

        if ($request->type == 'ex_product') {
            $input['exteral_product_link'] = $request->exteral_product_link;
        }

        if (!is_dir(public_path() . '/images/simple_products')) {
            mkdir(public_path() . '/images/simple_products');

            $text = '<?php echo "<h1>' . __('Access denined !') . '</h1>" ?>';

            @file_put_contents(public_path() . '/images/simple_products/index.php', $text);

        }

        if (!is_dir(public_path() . '/images/simple_products/gallery')) {
            mkdir(public_path() . '/images/simple_products/gallery');

            $text = '<?php echo "<h1>' . __('Access denined !') . '</h1>" ?>';

            @file_put_contents(public_path() . '/images/simple_products/gallery/index.php', $text);

        }

        if (in_array('Seller', auth()->user()->getRoleNames()->toArray())) {

            if ($request->file('thumbnail')) {

                $request->validate([
                    'thumbnail' => 'required|mimes:jpeg,jpg,png,webp,gif,bmp|max:300',
                ]);

                $image = $request->file('thumbnail');
                $input['thumbnail'] = 'thum_dgp_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/simple_products');
                $img = Image::make($image->path());

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . '/' . $input['thumbnail']);

            }

            if ($request->file('hover_thumbnail')) {

                $request->validate([
                    'hover_thumbnail' => 'required|mimes:jpeg,jpg,png,webp,gif,bmp|max:300',
                ]);

                $image = $request->file('hover_thumbnail');
                $input['hover_thumbnail'] = 'hover_thum_dgp_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/simple_products');
                $img = Image::make($image->path());

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . '/' . $input['hover_thumbnail']);

            }

            if ($request->file('product_file')) {

                $request->validate([
                    'product_file' => 'required|max:50000',
                ]);

                $input['product_file'] = time() . 'product_file.' . $request->product_file->getClientOriginalExtension();

                $request->product_file->move(storage_path('digitalproducts/files/'), $input['product_file']);
            }
        } else {

            if ($request->thumbnail != null) {

                if (!str_contains($request->thumbnail, '.png') && !str_contains($request->thumbnail, '.jpg') && !str_contains($request->thumbnail, '.jpeg') && !str_contains($request->thumbnail, '.webp') && !str_contains($request->thumbnail, '.gif')) {

                    return back()->withInput()->withErrors([
                        'thumbnail' => __('Invalid image type for thumbnail'),
                    ]);

                }

            }

            if ($request->hover_thumbnail != null) {
                if (!str_contains($request->hover_thumbnail, '.png') && !str_contains($request->hover_thumbnail, '.jpg') && !str_contains($request->hover_thumbnail, '.jpeg') && !str_contains($request->hover_thumbnail, '.webp') && !str_contains($request->hover_thumbnail, '.gif')) {

                    return back()->withInput()->withErrors([
                        'hover_thumbnail' => __('Invalid image type for hover thumbnail'),
                    ]);

                }
            }

            if ($request->product_file != null) {

                if (!str_contains($request->product_file, '.docx') && str_contains(!$request->product_file, '.pdf') && !str_contains($request->product_file, '.txt') && !str_contains($request->product_file, '.doc')) {

                    return back()->withInput()->withErrors([
                        'product_file' => __('Invalid file type for product file'),
                    ]);

                }

            }

        }

        $input['status'] = $request->status ? 1 : 0;
        $input['free_shipping'] = $request->free_shipping ? 1 : 0;
        $input['featured'] = $request->featured ? 1 : 0;
        $input['cancel_avbl'] = $request->cancel_avbl ? 1 : 0;
        $input['cod_avbl'] = $request->cod_avbl ? 1 : 0;
        $input['child_id'] = $request->child_id ?? null;

        if ($request->return_avbl == 0) {
            $input['policy_id'] = null;
        }

        $commission = CommissionSetting::first();

        if ($commission->type == "flat") {
            if ($commission->p_type == "f") {

                $cit = $commission->rate * $input['tax'] / 100;
                $price = $input['actual_selling_price'] + $commission->rate + $cit;

                if ($request->actual_offer_price) {
                    $offer = $input['actual_offer_price'] + $commission->rate + $cit;
                    $input['offer_price'] = $offer;
                }

                $input['price'] = $price;

                $input['commission_rate'] = $commission->rate + $cit;

            } else {

                $taxrate = $commission->rate;
                $price1 = $request['actual_selling_price'];
                $price2 = $request['actual_offer_price'];
                $tax1 = $price1 * (($taxrate / 100));
                $tax2 = $price2 * (($taxrate / 100));
                $price = $input['actual_selling_price'] + $tax1;

                if ($request->actual_offer_price) {
                    $offer = $input['actual_offer_price'] + $tax2;
                    $input['offer_price'] = $offer;
                }

                $input['price'] = $price;

                if (!empty($tax2)) {
                    $input['commission_rate'] = $tax2;
                } else {
                    $input['commission_rate'] = $tax1;
                }
            }
        } else {

            $comm = Commission::where('category_id', $request->category_id)->first();

            if (isset($comm)) {
                if ($comm->type == 'f') {

                    $cit = $comm->rate * $input['tax'] / 100;
                    $price = $input['actual_selling_price'] + $comm->rate + $cit;

                    if ($request->actual_offer_price) {
                        $offer = $input['actual_offer_price'] + $comm->rate + $cit;
                        $input['offer_price'] = $offer;
                    }

                    $input['price'] = $price;

                    $input['commission_rate'] = $comm->rate + $cit;

                } else {

                    $taxrate = $comm->rate;
                    $price1 = $input['actual_selling_price'];
                    $price2 = $input['actual_offer_price'];
                    $tax1 = $price1 * (($taxrate / 100));
                    $tax2 = $price2 * (($taxrate / 100));
                    $price = $input['actual_selling_price'] + $tax1;

                    if ($request->actual_offer_price) {
                        $offer = $input['actual_offer_price'] + $tax2;
                        $input['offer_price'] = $offer;
                    }

                    $input['price'] = $price;

                    if (!empty($tax2)) {
                        $input['commission_rate'] = $tax2;
                    } else {
                        $input['commission_rate'] = $tax1;
                    }
                }
            }
        }

        if ($request->actual_offer_price != 0 || $request->actual_offer_price) {
            $input['tax_rate'] = sprintf("%.2f", $request->actual_offer_price * $request->tax / 100);
            $input['offer_price'] = sprintf("%2.f", $input['offer_price'] + $input['tax_rate']);

            $taxrate = sprintf("%.2f", $request->actual_selling_price * $request->tax / 100);
            $input['price'] = sprintf("%2.f", $input['price'] + $taxrate);

        } else {
            $input['tax_rate'] = sprintf("%.2f", $request->actual_selling_price * $request->tax / 100);
            $input['price'] = sprintf("%2.f", $input['price'] + $input['tax_rate']);
        }

        $input['actual_offer_price'] = $request->offer_price ?? 0;
        $input['actual_selling_price'] = $request->actual_selling_price;

        $product = $product->create($input);

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $key => $image) {

                $image = $image;
                $filename = 'product_gallery_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/simple_products/gallery/');
                $img = Image::make($image->path());

                $img->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . '/' . $filename);

                $product->productGallery()->create([
                    'product_id' => $product->id,
                    'image' => $filename,
                ]);

            }
        }

        DB::commit();

        notify()->success('Product created !', 'Success');

        return redirect(route('simple-products.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DigitalProduct  $digitalProduct
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('products.edit'), 403, __('User does not have the right permissions.'));

        $product = SimpleProduct::find($id);

        if (!$product) {
            notify()->error('Product not found !');
            return redirect(route('digital-products.index'));
        }

        $categories = Category::where('status', '1')->get();
        $brands_all = Brand::where('status', '1')->get();

        $cashback_settings = $product->cashback_settings;

        $template_size_chart = SizeChart::whereHas('sizeoptions')
            ->whereHas('sizeoptions.values')
            ->with('sizeoptions')
            ->where('status', '=', '1')
            ->where('user_id', auth()->id())
            ->get();

        if (in_array('Seller', auth()->user()->getRoleNames()->toArray())) {

            $store = auth()->user()->store;
            return view('seller.simpleproducts.edit', compact('categories', 'product', 'brands_all', 'store', 'cashback_settings', 'template_size_chart'));

        } else {

            $stores = Store::with('user')->whereHas('user')->get();
            return view('admin.simpleproducts.edit', compact('categories', 'product', 'brands_all', 'stores', 'cashback_settings', 'template_size_chart'));

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DigitalProduct  $digitalProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('products.edit'), 403, __('User does not have the right permissions.'));

        $product = SimpleProduct::find($id);

        if (!$product) {
            notify()->error('Product not found !');
            return redirect(url('manage/simple-products'));
        }

        $request->validate([
            'product_name' => 'required|string',
            'brand_id' => 'required',
            'store_id' => 'required',
            'subcategory_id' => 'required',
            'product_detail' => 'required|max:10000',
            'category_id' => 'required',
            'actual_selling_price' => 'numeric|required',
            'tax' => 'required',
            'tax_name' => 'required',
            'hsin' => 'required',
        ]);

        if ($request->actual_offer_price) {
            $request->validate([
                'actual_offer_price' => 'numeric|max:actual_selling_price',
            ]);
        }

        if ($request->return_avbl == 1) {
            $request->validate([
                'policy_id' => 'required',
            ]);
        }

        DB::beginTransaction();

        $input = array_filter($request->all());

        $input['status'] = $request->status ? 1 : 0;

        $input['slug'] = str_slug($request->product_name, '-', app()->getLocale());

        $input['product_detail'] = clean($request->product_detail);

        if ($request->other_cats) {
            $input['other_cats'] = $request->other_cats;
        } else {
            $input['other_cats'] = null;
        }

        if (!is_dir(public_path() . '/images/simple_products')) {
            mkdir(public_path() . '/images/simple_products');

            $text = '<?php echo "<h1>Access denined !</h1>" ?>';

            @file_put_contents(public_path() . '/images/simple_products/index.php', $text);

        }

        if (in_array('Seller', auth()->user()->getRoleNames()->toArray())) {

            if ($request->file('thumbnail')) {

                $request->validate([
                    'thumbnail' => 'required|mimes:jpeg,jpg,png,webp,gif,bmp|max:300',
                ]);

                $image = $request->file('thumbnail');
                $input['thumbnail'] = 'thum_dgp_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/simple_products');
                $img = Image::make($image->path());

                if ($product->thumbnail != '' && file_exists(public_path() . '/images/simple_products/' . $product->thumbnail)) {
                    unlink(public_path() . '/images/simple_products/' . $product->thumbnail);
                }

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . '/' . $input['thumbnail']);

            }

            if ($request->file('hover_thumbnail')) {

                $request->validate([
                    'hover_thumbnail' => 'required|mimes:jpeg,jpg,png,webp,gif,bmp|max:300',
                ]);

                $image = $request->file('hover_thumbnail');
                $input['hover_thumbnail'] = 'hover_thum_dgp_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/simple_products');
                $img = Image::make($image->path());

                if ($product->hover_thumbnail != '' && file_exists(public_path() . '/images/simple_products/' . $product->hover_thumbnail)) {
                    unlink(public_path() . '/images/simple_products/' . $product->hover_thumbnail);
                }

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . '/' . $input['hover_thumbnail']);

            }

            if ($request->file('product_file')) {

                $request->validate([
                    'product_file' => 'required|max:50000',
                ]);

                if ($product->product_file != '') {
                    try {
                        unlink(storage_path() . '/digitalproducts/files/' . $product->product_file);
                    } catch (\Exception $e) {

                    }
                }

                $input['product_file'] = time() . 'product_file.' . $request->product_file->getClientOriginalExtension();

                $request->product_file->move(storage_path('digitalproducts/files/'), $input['product_file']);
            }
        } else {

            if ($request->thumbnail != null) {

                if (!str_contains($request->thumbnail, '.png') && !str_contains($request->thumbnail, '.jpg') && !str_contains($request->thumbnail, '.jpeg') && !str_contains($request->thumbnail, '.webp') && !str_contains($request->thumbnail, '.gif')) {

                    return back()->withInput()->withErrors([
                        'thumbnail' => 'Invalid image type for thumbnail',
                    ]);

                }

            }

            if ($request->hover_thumbnail != null) {
                if (!str_contains($request->hover_thumbnail, '.png') && !str_contains($request->hover_thumbnail, '.jpg') && !str_contains($request->hover_thumbnail, '.jpeg') && !str_contains($request->hover_thumbnail, '.webp') && !str_contains($request->hover_thumbnail, '.gif')) {

                    return back()->withInput()->withErrors([
                        'hover_thumbnail' => 'Invalid image type for hover thumbnail',
                    ]);

                }
            }

            if ($request->product_file != null) {

                if (!str_contains($request->product_file, '.docx') && str_contains(!$request->product_file, '.pdf') && !str_contains($request->product_file, '.txt') && !str_contains($request->product_file, '.doc')) {

                    return back()->withInput()->withErrors([
                        'product_file' => 'Invalid file type for product file',
                    ]);

                }

            }

        }

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $key => $image) {

                $image = $image;
                $filename = 'product_gallery_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/simple_products/gallery/');
                $img = Image::make($image->path());

                $img->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . '/' . $filename);

                $product->productGallery()->create([
                    'product_id' => $product->id,
                    'image' => $filename,
                ]);

            }
        }

        $input['status'] = $request->status ? 1 : 0;
        $input['free_shipping'] = $request->free_shipping ? 1 : 0;
        $input['featured'] = $request->featured ? 1 : 0;
        $input['cancel_avbl'] = $request->cancel_avbl ? 1 : 0;
        $input['cod_avbl'] = $request->cod_avbl ? 1 : 0;
        $input['child_id'] = $request->child_id ?? null;

        if ($product['return_avbl'] == 0) {
            $input['policy_id'] = null;
        }

        $commission = CommissionSetting::first();

        if ($commission->type == "flat") {
            if ($commission->p_type == "f") {

                $cit = $commission->rate * $input['tax'] / 100;
                $price = $input['actual_selling_price'] + $commission->rate + $cit;

                if ($request->actual_offer_price) {
                    $offer = $input['actual_offer_price'] + $commission->rate + $cit;
                    $input['offer_price'] = $offer;
                }

                $input['price'] = $price;

                $input['commission_rate'] = $commission->rate + $cit;

            } else {

                $taxrate = $commission->rate;
                $price1 = $request['actual_selling_price'];
                $price2 = $request['actual_offer_price'];
                $tax1 = $price1 * (($taxrate / 100));
                $tax2 = $price2 * (($taxrate / 100));
                $price = $input['actual_selling_price'] + $tax1;

                if ($request->actual_offer_price) {
                    $offer = $input['actual_offer_price'] + $tax2;
                    $input['offer_price'] = $offer;
                }

                $input['price'] = $price;

                if (!empty($tax2)) {
                    $input['commission_rate'] = $tax2;
                } else {
                    $input['commission_rate'] = $tax1;
                }
            }
        } else {

            $comm = Commission::where('category_id', $request->category_id)->first();

            if (isset($comm)) {
                if ($comm->type == 'f') {

                    $cit = $comm->rate * $input['tax'] / 100;
                    $price = $input['actual_selling_price'] + $comm->rate + $cit;

                    if ($request->actual_offer_price) {
                        $offer = $input['actual_offer_price'] + $comm->rate + $cit;
                        $input['offer_price'] = $offer;
                    }

                    $input['price'] = $price;

                    $input['commission_rate'] = $comm->rate + $cit;

                } else {

                    $taxrate = $comm->rate;
                    $price1 = $input['actual_selling_price'];
                    $price2 = $input['actual_offer_price'];
                    $tax1 = $price1 * (($taxrate / 100));
                    $tax2 = $price2 * (($taxrate / 100));
                    $price = $input['actual_selling_price'] + $tax1;

                    if ($request->actual_offer_price) {
                        $offer = $input['actual_offer_price'] + $tax2;
                        $input['offer_price'] = $offer;
                    }

                    $input['price'] = $price;

                    if (!empty($tax2)) {
                        $input['commission_rate'] = $tax2;
                    } else {
                        $input['commission_rate'] = $tax1;
                    }
                }
            }
        }

        if ($request->actual_offer_price != 0 && $request->actual_offer_price != '') {

            $input['tax_rate'] = sprintf("%.2f", $request->actual_offer_price * $request->tax / 100);
            $input['offer_price'] = sprintf("%2.f", $input['offer_price'] + $input['tax_rate']);

            $taxrate = sprintf("%.2f", $request->actual_selling_price * $request->tax / 100);
            $input['price'] = sprintf("%2.f", $input['price'] + $taxrate);

        } else {
            $input['tax_rate'] = sprintf("%.2f", $request->actual_selling_price * $request->tax / 100);
            $input['price'] = sprintf("%2.f", $input['price'] + $input['tax_rate']);
            $input['offer_price'] = 0;
        }

        $input['actual_offer_price'] = $request->actual_offer_price ?? 0;
        $input['actual_selling_price'] = $request->actual_selling_price;

        $product->update($input);

        DB::commit();

        notify()->success('Product updated !', $product->product_name);

        return redirect(route('simple-products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DigitalProduct  $digitalProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('products.delete'), 403, __('User does not have the right permissions.'));

        $product = SimpleProduct::find($id);

        if (!$product) {
            notify()->error('Product not found !');
            return redirect(route('simple-products.index'));
        }

        $product->productGallery()->delete();

        $product->delete();

        notify()->success('Product deleted !', 'Success');

        return redirect(route('simple-products.index'));

    }

    public function user_review(Request $request, $id)
    {

        $this->validate($request, [

            "quality" => "required", "Price" => "required", "Value" => "required",

        ]);

        $cusers = UserReview::where('simple_pro_id', $id)->where('user', auth()->id())->first();

        $orders = UserReview::where('simple_pro_id', $id)->first();

        if (isset($cusers)) {
            notify()->error('You Have Already Rated This Product !');
            return back();
        }

        if (!$cusers) {

            $obj = new UserReview();
            $obj->pro_id = 0;
            $obj->simple_pro_id = $id;
            $obj->qty = $request->quality;
            $obj->price = $request->Price;
            $obj->value = $request->Value;
            $obj->user = $request->name;
            $obj->summary = $request->summary;
            $obj->review = $request->review;
            $obj->save();

            $findprovendor = SimpleProduct::find($id);

            if ($request->review != '') {
                if ($findprovendor->store->user['role_id'] != 'a') {
                    $msg = 'A New pending review has been received on ' . $findprovendor->vender->name . ' product';
                } else {
                    $msg = 'A New pending review has been received on your product';
                }
            } else {
                if ($findprovendor->store->user['role_id'] != 'a') {
                    $msg = 'A New pending rating has been received on ' . $findprovendor->vender->name . ' product';
                } else {
                    $msg = 'A New pending rating has been received on your product';
                }
            }

            $admins = User::where('role_id', '=', 'a')->where('status', '=', '1')->get();
            /*Send Notification*/
            Notification::send($admins, new SendReviewNotification($findprovendor->product_name, $msg));

            notify()->success('Rated Successfully !');

            return back();
        } else {
            notify()->error('Thank you for purchase this product but please wait until product is delivered !');
            return back();
        }
    }

    public function manageInventory(Request $request, $id)
    {

        $request->validate([
            'stock' => 'required|numeric',
            'min_order_qty' => 'required|min:1',
        ]);

        $product = SimpleProduct::find($id);

        $product->update($request->all());

        notify()->success('Product inventory updated !', $product->product_name);
        return back();

    }

    public function wishlist(Request $request)
    {

        $product = SimpleProduct::find($request->proid);

        if (!isset($product)) {
            return response()->json([
                'msg' => 'Product not found !',
                'status' => 'fail',
            ]);
        }

        $status = inwishlist($product->id);

        if ($status == false) {

            Wishlist::create([
                'user_id' => auth()->id(),
                'pro_id' => 0,
                'simple_pro_id' => $product->id,
            ]);

            return response()->json([
                'msg' => 'Product added in wishlist !',
                'status' => 'success',
            ]);

        } else {

            $check = Wishlist::where('user_id', auth()->id())->where('simple_pro_id', $product->id)->delete();

            if ($check) {

                return response()->json([
                    'msg' => 'Product removed from wishlist !',
                    'status' => 'success',
                ]);

            } else {

                return response()->json([
                    'msg' => 'Please try again !',
                    'status' => 'fail',
                ]);

            }

        }

    }

    public function deletegalleryImage(Request $request)
    {

        $image = ProductGallery::withTrashed()->find($request->id);

        if ($image) {

            if (file_exists(public_path() . '/images/simple_products/gallery/' . $image->image)) {
                try {
                    unlink(public_path() . '/images/simple_products/gallery/' . $image->image);
                } catch (\Exception $e) {
                    \Log::error('Deleting gallery image');
                }
            }

            $image->forcedelete();

            if ($request->wantsJson()) {
                return response()->json([
                    'msg' => 'Image deleted from gallery !',
                    'status' => 'success',
                ]);
            }

        } else {

            if ($request->wantsJson()) {

                return response()->json([
                    'msg' => 'Image could not be deleted !',
                    'status' => 'fail',
                ]);

            }

        }

    }

    public function upload360(Request $request, $id)
    {

        if (!is_dir(public_path() . '/images/simple_products/360_images')) {
            mkdir(public_path() . '/images/simple_products/360_images');

            $text = '<?php echo "<h1>Access denined !</h1>" ?>';

            @file_put_contents(public_path() . '/images/simple_products/360_images/index.php', $text);

        }

        $request->validate([
            '360_image' => 'required',
            '360_image.*' => 'mimes:png,jpg,jpeg,gif,bmp,webp',
        ]);

        $product = SimpleProduct::findorfail($id);

        ini_set('max_execution_time', -1);

        if ($request->hasFile('360_image')) {

            foreach ($request->file('360_image') as $photo) {

                $image = $photo;
                $filename = 'image_360_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/simple_products/360_images/');
                $img = Image::make($image->path());

                $img->save($destinationPath . '/' . $filename);

                $product->frames()->create([
                    'image' => $filename,
                ]);

            }

        }

        notify()->success('Image uploaded successfully !', 'Success');
        return back();

    }

    public function importImages(Request $request)
    {

        $validator = Validator::make(
            [
                'file' => $request->image,
                'extension' => strtolower($request->image->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xlsx,xls,csv',
            ]

        );

        if ($validator->fails()) {
            return back()->withErrors('Invalid file !');
        }

        $filename = 'simple_product_images_' . time() . '.' . $request->image->getClientOriginalExtension();

        Storage::disk('local')->put('/excel/' . $filename, file_get_contents($request->image->getRealPath()));

        $images = fastexcel()->import(storage_path() . '/app/excel/' . $filename);

        if (count($images)) {

            $images->each(function ($image) {

                ProductGallery::create([

                    'product_id' => $image['product_id'],
                    'image' => $image['image'],

                ]);

            });

            try {

                unlink(storage_path() . '/excel/' . $filename);

            } catch (\Exception $e) {

            }

            notify()->success('Images Imported successfully');

            return back();

        } else {
            return back()->withErrors('File is empty !');
        }

    }

    public function delete360(Request $request)
    {

        $image = Product360Frame::find($request->id);

        if ($image) {

            if (file_exists(public_path() . '/images/simple_products/360_images/' . $image)) {
                try {
                    unlink(storage_path() . '/images/simple_products/360_images/' . $image);
                } catch (\Exception $e) {
                    \Log::error('Deleting 360 deg. image');
                }
            }

            $image->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'msg' => 'Image deleted from frames !',
                    'status' => 'success',
                ]);
            }

        } else {

            if ($request->wantsJson()) {

                return response()->json([
                    'msg' => 'Image could not be deleted !',
                    'status' => 'fail',
                ]);

            }

        }

    }

    public function front360()
    {

        if (request()->ajax()) {

            $product = SimpleProduct::find(request()->id);

            $frames = $product->frames->map(function ($image) {

                $content[] = url('/images/simple_products/360_images/' . $image->image);
                return $content;

            });

            return response()->json($frames, 200);

        }

    }

    public function preorderSettings(Request $request, $id)
    {

        $product = SimpleProduct::findorfail($id);

        $input = $request->all();

        if ($request->pre_order) {

            $input['pre_order'] = 1;
            $request->preorder_type == 'full' ? $input['partial_payment_per'] = null : $input['partial_payment_per'] = $request->partial_payment_per;

        } else {

            $input['pre_order'] = 0;
            $input['preorder_type'] = null;
            $input['partial_payment_per'] = null;
            $input['product_avbl_date'] = null;

        }

        $product->update($input);

        return back()->with('added', __("Preorder configuration has been updated successfully !"));

    }
}
