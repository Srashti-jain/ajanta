<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Adv;
use App\Allcity;
use App\Allstate;
use App\AppSection;
use App\Blog;
use App\Brand;
use App\Category;
use App\CategorySlider;
use App\Commission;
use App\CommissionSetting;
use App\Country;
use App\Faq;
use App\Flashsale;
use App\FooterMenu;
use App\FrontCat;
use App\Genral;
use App\Grandcategory;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Controller;
use App\Language;
use App\Menu;
use App\Page;
use App\Product;
use App\ProductAttributes;
use App\ProductValues;
use App\SimpleProduct;
use App\Slider;
use App\SpecialOffer;
use App\Subcategory;
use App\TermsSettings;
use App\Testimonial;
use App\UserReview;
use App\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use ProductRating;

class MainController extends Controller
{

    public function __construct()
    {
        try {

            $this->sellerSystem = Genral::select('vendor_enable')->first();

        } catch (\Exception $e) {

        }
    }

    public function homepage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request->currency)->getData();

        $item = array();

        $content = array();

        /** List app settings */
        $response = $this->appSettings();

        $response = $response->getData();

        $appheader = array(
            'sort' => 8,
            'name' => 'appheader',
            'logopath' => $response->logopath,
            'logo' => $response->logo,
            'current_lang' => app()->getLocale(),
            'current_time' => now()->format('Y-m-d h:i:s'),
        );
        /** End */

        /** Sidebar Categories */
        $response = $this->sidebarcategories($content);

        $categories = array(
            'sort' => 7,
            'name' => 'categories',
            'layout' => 'vertical',
            'enable' => true,
            'path' => url('/images/category/'),
            'items' => $response,
        );
        /** End */

        /** Specialoffers products */
        $response = $this->specialoffer($content);
        /** End */

        $specialoffers = array(
            'sort' => 6,
            'layout' => 'vertical',
            'name' => 'specialoffers',
            'enable' => true,
            'path' => url('/variantimages/thumbnails/'),
            'items' => $response,
        );

        /** Getting Sliders */

        $response = $this->slider($content);

        /** End */

        $sliders = array(
            'sort' => 5,
            'name' => 'slider',
            'layout' => 'vertical',
            'autoslide' => true,
            'enable' => true,
            'path' => url('images/slider'),
            'items' => $response,
        );

        /** Top categories */

        $response = $this->topcategories($content);

        $topcategories = array(
            'sort' => 4,
            'name' => 'topcategories',
            'layout' => 'vertical',
            'enable' => true,
            'path' => url('/images/category/'),
            'items' => $response,
        );

        /** Recent Products with Categories */

        $response = $this->recentProducts($content);

        $recentProducts = array(
            'sort' => 3,
            'name' => 'newProducts',
            'layout' => 'vertical',
            'enable' => true,
            'path' => url('variantimages/thumbnails/'),
            'items' => $response,
        );

        // /** Getting Blogs */

        $blogs = array(
            'sort' => 2,
            'name' => 'blogs',
            'layout' => 'vertical',
            'enable' => true,
            'path' => url('/images/blog/'),
            'items' => $this->gettingBlogs($content = array()),
        );



        $flashdeals = array(

            'status' => Flashsale::count() ? true : false,
            
            'deals' => Flashsale::where('status','=','1')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->inRandomOrder()
                ->get()
                ->transform(function($value){
                
                    $deal['title'] = $value->title;
                    $deal['id'] = $value->id;
                    $deal['start_time'] = $value->start_date;
                    $deal['end_time'] = $value->end_date;
                    $deal['background_image'] = $value->background_image;
                    $deal['api_url'] = url('/api/view/deal/'.$value->id);
                    
                    return $deal;

                }),

            'path'   => url('/images/flashdeals')

        );

        // Final Response //

        $homepage = [
            'appheaders' => $appheader,
            'categories' => $categories,
            'specialoffers' => $specialoffers,
            'flashdeals' => $flashdeals,
            'sliders' => $sliders,
            'TwoEqualAdvertise' => $this->advertise('abovenewproduct', 'Two equal image layout') != null ? $this->advertise('abovenewproduct', 'Two equal image layout') : null,
            'hotdeals' => $this->hotdeals($request, $content),
            'featuredProducts' => $this->featuredProducts($content),
            'ThreeEqualAdvertise' => $this->advertise('afterfeaturedproduct', 'Three Image Layout') != null ? $this->advertise('afterfeaturedproduct', 'Three Image Layout') : null,
            'topCatgories' => $topcategories,
            'SingleAdvertise' => $this->advertise('abovelatestblog', 'Single Image Layout') != null ? $this->advertise('abovelatestblog', 'Single Image Layout') : null,
            'brands' => $this->brandSlider($request),
            'TwoNonEqualAdvertise' => $this->advertise('abovenewproduct', 'Two non equal image layout') != null ? $this->advertise('abovenewproduct', 'Two non equal image layout') : null,
            'blogs' => $blogs,
            'newProducts' => $this->tabbedProducts(),
        ];


        // Table fetch of keys

        $section = AppSection::orderBy('sort','ASC')->get();

        $homepage_sections = array(); // the second array

        // a variable to count the number of iterations

        foreach ($section as $key => $value) {

            
            $key_exist = array_key_exists($value->name,$homepage);

            if($key_exist == true){
                $homepage_sections[$value->name] = $homepage[$value->name];
            }
            
        }

        return response()->json($homepage_sections, 200);

    }

    public function sidebarcategories($content)
    {

        $categories = Category::orderBy('position', 'ASC')->select('title as title', 'id', 'image', 'icon')->get();

        foreach ($categories as $key => $cat) {
            $content[] = array(
                'id' => $cat->id,
                'title' => $cat->getTranslations('title'),
                'icon' => $cat->icon,
                'image' => $cat->image,
                'url' => url('/api/category/' . $cat->id),
            );
        }

        return $content;
    }

    public function brandSlider($request)
    {

        $content = array();

        $brands = Brand::where('status', '=', '1')->where('show_image', '=', 1)->get();

        $saleT = new BrandController;

        foreach ($brands as $brand) {
            $content[] = array(
                'id' => $brand['id'],
                'name' => $brand['name'],
                'image' => $brand['image'] ?? null,
                'image_path' => url('images/brands/'),
                'url' => url('/brands/' . $brand['id'] . '/products'),
                'sale_text' => $brand->products->count() > 0 ? $saleT->brandprices($request->currency, $brand) : null,
            );
        }


        return $content;

    }

    public function advertise($position, $type)
    {

        $content = array();

        $adv = Adv::where('position', $position)->where('layout', $type)->get();

        foreach ($adv as $ad) {

            if ($type == 'Three Image Layout') {

                $linkby = '';

                if ($ad->cat_id1 != '') {
                    $linkby = url('api/category/' . $ad->cat_id1);
                } elseif ($ad->pro_id1 != '') {

                    if (isset($ad->product)) {
                        $linkby = url('api/details/' . $ad->pro_id1 . '/' . $ad->product->subvariants->where('def', 1)->first()->id ?? '' . '/');
                    } else {
                        $linkby = null;
                    }

                    return $linkby;

                } elseif ($ad->url1 != '') {
                    $linkby = $ad->url1;
                }

                $linkby2 = '';

                if ($ad->cat_id2 != '') {
                    $linkby2 = url('api/category/' . $ad->cat_id2);
                } elseif ($ad->pro_id2 != '') {
                    if (isset($ad->product)) {
                        $linkby2 = url('api/details/' . $ad->pro_id2 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                    }
                } elseif ($ad->url2 != '') {
                    $linkby2 = $ad->url2;
                }

                $linkby3 = '';

                if ($ad->cat_id3 != '') {
                    $linkby3 = url('api/category/' . $ad->cat_id3);
                } elseif ($ad->pro_id3 != '') {
                    $linkby3 = url('api/details/' . $ad->pro_id3 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url3 != '') {
                    $linkby3 = $ad->url3;
                }

                $content[] = array(
                    'adimagepath' => url('images/layoutads'),
                    'image1' => $ad->image1,
                    'image2' => $ad->image2,
                    'image3' => $ad->image3,
                    'image1linkby' => $linkby,
                    'image2linkby' => $linkby2,
                    'image3linkby' => $linkby3,
                );

            }

            if ($type == 'Two non equal image layout') {

                $linkby = '';

                if ($ad->cat_id1 != '') {
                    $linkby = url('api/category/' . $ad->cat_id1);
                } elseif ($ad->pro_id1 != '') {
                    $linkby = url('api/details/' . $ad->pro_id1 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url1 != '') {
                    $linkby = $ad->url1;
                }

                $linkby2 = '';

                if ($ad->cat_id2 != '') {
                    $linkby2 = url('api/category/' . $ad->cat_id2);
                } elseif ($ad->pro_id2 != '') {
                    $linkby2 = url('api/details/' . $ad->pro_id2 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url2 != '') {
                    $linkby2 = $ad->url2;
                }

                $content[] = array(
                    'adimagepath' => url('images/layoutads'),
                    'image1' => $ad->image1,
                    'image2' => $ad->image2,
                    'image1linkby' => $linkby,
                    'image2linkby' => $linkby2,
                );

            }

            if ($type == 'Two equal image layout') {

                $linkby = '';

                if ($ad->cat_id1 != '') {
                    $linkby = url('api/category/' . $ad->cat_id1);
                } elseif ($ad->pro_id1 != '') {
                    if (isset($ad->product)) {
                        $linkby = url('api/details/' . $ad->pro_id1 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                    } else {
                        $linkby = null;
                    }
                } elseif ($ad->url1 != '') {
                    $linkby = $ad->url1;
                }

                $linkby2 = '';

                if ($ad->cat_id2 != '') {
                    $linkby2 = url('api/category/' . $ad->cat_id2);
                } elseif ($ad->pro_id2 != '') {
                    if (isset($ad->product)) {
                        $linkby2 = url('api/details/' . $ad->pro_id2 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                    }
                } elseif ($ad->url2 != '') {
                    $linkby2 = $ad->url2;
                }

                $content[] = array(
                    'adimagepath' => url('images/layoutads'),
                    'image1' => $ad->image1,
                    'image2' => $ad->image2,
                    'image1linkby' => $linkby,
                    'image2linkby' => $linkby2,
                );

            }

            if ($type == 'Single image layout') {

                $linkby = '';

                if ($ad->cat_id1 != '') {
                    $linkby = url('api/category/' . $ad->cat_id1);
                } elseif ($ad->pro_id1 != '') {
                    $linkby = url('api/details/' . $ad->pro_id1 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url1 != '') {
                    $linkby = $ad->url1;
                }

                $content[] = array(
                    'adimagepath' => url('images/layoutads'),
                    'image1' => $ad->image1,
                    'image1linkby' => $linkby,
                );

            }

        }

        return $content;

    }

    public function appSettings()
    {

        $settings = Genral::first();

        if (isset($settings)) {
            return response()->json(['logo' => $settings->logo, 'logopath' => url('/images/genral/')]);
        }
    }

    public function slider($content)
    {

        $sliders = Slider::where('status', '=', '1')->get();

        foreach ($sliders as $key => $slider) {

            $type = '';

            if ($slider->link_by == 'cat') {

                $type = 'category';

            } elseif ($slider->link_by == 'sub') {
                $type = 'subcategory';
            } elseif ($slider->link_by == 'url') {
                $type = 'subcategory';
            } else {
                $type = 'None';
            }

            $id = '';

            if ($slider->link_by == 'cat') {

                $id = $slider->category_id;

            } elseif ($slider->link_by == 'sub') {
                $id = $slider->child;
            } elseif ($slider->link_by == 'url') {
                $id = $slider->url;
            }

            $content[] = array(

                'image' => $slider->image,
                'linkedTo' => $type,
                'linked_id' => $id,
                'topheading' => $slider->getTranslations('topheading'),
                'headingtextcolor' => $slider->headingtextcolor,
                'heading' => $slider->getTranslations('heading'),
                'subheadingcolor' => $slider->subheadingcolor,
                'buttonname' => $slider->getTranslations('buttonname'),
                'btntextcolor' => $slider->btntextcolor,
                'btnbgcolor' => $slider->btnbgcolor,
                'moredescription' => $slider->moredesc != null ? $slider->moredesc : 'Not found',
                'descriptionTextColor' => $slider->moredesccolor,
                'status' => $slider->status,
            );

        }

        return $content;
    }

    public function tabbedProducts()
    {

        $tabbed = array();

        $frontcat = FrontCat::first();

        if (isset($frontcat) && $frontcat->name != '' && $frontcat->status == '1') {
            $tabbed[] = array(
                'tabid' => '0',
                'tabname' => array(
                    'en' => __("ALL"),
                ),
                'products' => $this->recentProducts() != null ? $this->recentProducts() : 'No Products found',
            );

            foreach (explode(',', $frontcat->name) as $name) {

                $category = Category::find($name);

                if (isset($category)) {

                    $tabbed[] = array(
                        'tabid' => $category->id,
                        'tabname' => $category->getTranslations('title'),
                    );

                }
            }

        }

        return $tabbed;
    }

    public function recentProducts()
    {

        $sellerSystem = $this->sellerSystem;

        $topcatproducts = Product::with('category')->whereHas('category', function ($q) {

            $q->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('vender')->whereHas('vender', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->with('subvariants')->whereHas('subvariants', function ($query) {

            $query->where('def', '=', '1');

        })
            ->with('subvariants.variantimages')
            ->whereHas('subvariants.variantimages')
            ->where('status', '=', '1')
            ->orderBy('id', 'DESC')
            ->take(20)
            ->get();

        $review = new ProductController;

        $wishlist = new WishlistController;

        $topcatproducts = $topcatproducts->map(function ($q) use ($review, $wishlist) {

            $orivar = $q->subvariants[0];
            $mainprice = $this->getprice($q, $orivar);
            $price = $mainprice->getData();

            if ($this->getprice($q, $orivar)->getData()->offerprice != 0) {

                $mp = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->mainprice);
                $op = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->offerprice);

                $getdisprice = $mp - $op;

                $discount = $getdisprice / $mp;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid'] = $q->id;
            $item['variantid'] = $orivar->id;
            $item['productname'] = $q->getTranslations('name');
            $item['description'] = array_map(function ($v) {
                return trim(strip_tags($v));
            }, $q->getTranslations('des'));
            $item['type'] = 'v';
            $item['mainprice'] = round($price->mainprice * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($price->offerprice * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['rating'] = (double) get_product_rating($q->id);
            $item['review'] = (int) $review->getProductReviews($q)->count();
            $item['thumbnail'] = $orivar->variantimages->main_image ?? '';
            $item['thumbnail_path'] = url('/variantimages/thumbnails');
            $item['off_in_percent'] = (int) round($offamount);
            $item['tax_info'] = $q->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes");
            $item['tag_text'] = $q->sale_tag;
            $item['tag_text_color'] = $q->sale_tag_text_color;
            $item['tag_bg_color'] = $q->sale_tag_color;
            $item['is_in_wishlist'] = $wishlist->isItemInWishlist($orivar);

            return $item;

        });

        $top_simple_products = SimpleProduct::with('category')->whereHas('category', function ($q) {

            $q->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->whereHas('store.user', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })
            ->where('status', '=', '1')
            ->orderBy('id', 'DESC')
            ->take(20)
            ->get();

        $top_simple_products = $top_simple_products->map(function ($sp) {

            if ($sp->offer_price != 0) {

                $getdisprice = $sp->price - $sp->offer_price;

                $discount = $getdisprice / $sp->price;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid'] = $sp->id;
            $item['variantid'] = 0;
            $item['type'] = 's';
            $item['productname'] = $sp->getTranslations('product_name');
            $item['description'] = array_map(function ($v) {
                return trim(strip_tags($v));
            }, $sp->getTranslations('product_detail'));
            $item['type'] = 's';
            $item['mainprice'] = round($sp->price * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($sp->offer_price * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['rating'] = (double) simple_product_rating($sp->id);
            $item['review'] = (int) $sp->reviews()->whereNotNull('review')->count();
            $item['thumbnail'] = $sp->thumbnail;
            $item['thumbnail_path'] = url('images/simple_products/');
            $item['off_in_percent'] = (int) round($offamount);
            $item['tax_info'] = __("Inclusive of all taxes");
            $item['tag_text'] = $sp->sale_tag;
            $item['tag_text_color'] = $sp->sale_tag_text_color;
            $item['tag_bg_color'] = $sp->sale_tag_color;
            $item['is_in_wishlist'] = inwishlist($sp->id);

            return $item;

        });

        return $topcatproducts->toBase()->merge($top_simple_products)->shuffle();
    }

    public function categoryproducts($catid)
    {

        $validator = Validator::make(request()->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3',
        ]);

        $sellerSystem = $this->sellerSystem;

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', request()->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        if (!$catid) {
            return response()->json(['msg' => 'Category id is required', 'status' => 'fail']);
        }

        $category = Category::find($catid);

        if (isset($category)) {

            $rates = new CurrencyController;

            $this->rate = $rates->fetchRates(request()->currency)->getData();

            $categoryproducts_vp = Product::with('category')->whereHas('category', function ($q) use ($category) {

                $q->where('status', '=', '1')->where('id', $category->id);

            })->with('subcategory')->wherehas('subcategory', function ($q) {

                $q->where('status', '1');

            })->with('vender')->whereHas('vender', function ($query) use ($sellerSystem) {

                if ($sellerSystem->vendor_enable == 1) {
                    $query->where('status', '=', '1')->where('is_verified', '1');
                } else {
                    $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
                }

            })->with('store')->whereHas('store', function ($query) {

                return $query->where('status', '=', '1');

            })->with('subvariants')->whereHas('subvariants', function ($query) {

                $query->where('def', '=', '1');

            })
                ->with(['subvariants.variantimages'])
                ->whereHas('subvariants.variantimages')
                ->where('status', '=', '1')
                ->orderBy('id', 'DESC')
                ->take(20)
                ->get();

            $review = new ProductController;

            $wishlist = new WishlistController;

            $categoryproducts_vp = $categoryproducts_vp->map(function ($q) use ($review, $wishlist) {

                $orivar = $q->subvariants[0];
                $mainprice = $this->getprice($q, $orivar);
                $price = $mainprice->getData();

                if ($this->getprice($q, $orivar)->getData()->offerprice != 0) {

                    $mp = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->mainprice);
                    $op = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->offerprice);

                    $getdisprice = $mp - $op;

                    $discount = $getdisprice / $mp;

                    $offamount = $discount * 100;
                } else {
                    $offamount = 0;
                }

                $item['productid'] = $q->id;
                $item['variantid'] = $orivar->id;
                $item['productname'] = $q->getTranslations('name');
                $item['description'] = array_map(function ($v) {
                    return trim(strip_tags($v));
                }, $q->getTranslations('des'));
                $item['type'] = 'v';
                $item['mainprice'] = round($price->mainprice * $this->rate->exchange_rate, 2);
                $item['offerprice'] = round($price->offerprice * $this->rate->exchange_rate, 2);
                $item['pricein'] = $this->rate->code;
                $item['symbol'] = $this->rate->symbol;
                $item['rating'] = (double) get_product_rating($q->id);
                $item['review'] = (int) $review->getProductReviews($q)->count();
                $item['thumbnail'] = $orivar->variantimages->main_image ?? '';
                $item['thumbnail_path'] = url('/variantimages/thumbnails');
                $item['off_in_percent'] = (int) round($offamount);
                $item['tax_info'] = $q->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes");
                $item['tag_text'] = $q->sale_tag;
                $item['tag_text_color'] = $q->sale_tag_text_color;
                $item['tag_bg_color'] = $q->sale_tag_color;
                $item['is_in_wishlist'] = $wishlist->isItemInWishlist($orivar);

                return $item;

            });

            $categoryproducts_sp = SimpleProduct::with('category')->whereHas('category', function ($q) use ($category) {

                $q->where('id', $category->id)->where('status', '=', '1');

            })->with('subcategory')->wherehas('subcategory', function ($q) {

                $q->where('status', '1');

            })->with('store')->whereHas('store', function ($query) {

                return $query->where('status', '=', '1');

            })->whereHas('store.user', function ($query) use ($sellerSystem) {

                if ($sellerSystem->vendor_enable == 1) {
                    $query->where('status', '=', '1')->where('is_verified', '1');
                } else {
                    $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
                }

            })->where('status', '=', '1')->orderBy('id', 'DESC')->take(20)->get();

            $categoryproducts_sp = $categoryproducts_sp->map(function ($sp) {

                if ($sp->offer_price != 0) {

                    $getdisprice = $sp->price - $sp->offer_price;

                    $discount = $getdisprice / $sp->price;

                    $offamount = $discount * 100;
                } else {
                    $offamount = 0;
                }

                $item['productid'] = $sp->id;
                $item['variantid'] = 0;
                $item['type'] = 's';
                $item['productname'] = $sp->getTranslations('product_name');
                $item['description'] = array_map(function ($v) {
                    return trim(strip_tags($v));
                }, $sp->getTranslations('product_detail'));
                $item['type'] = 's';
                $item['mainprice'] = round($sp->price * $this->rate->exchange_rate, 2);
                $item['offerprice'] = round($sp->offer_price * $this->rate->exchange_rate, 2);
                $item['pricein'] = $this->rate->code;
                $item['symbol'] = $this->rate->symbol;
                $item['rating'] = (double) simple_product_rating($sp->id);
                $item['review'] = (int) $sp->reviews()->whereNotNull('review')->count();
                $item['thumbnail'] = $sp->thumbnail;
                $item['thumbnail_path'] = url('images/simple_products/');
                $item['off_in_percent'] = (int) round($offamount);
                $item['tax_info'] = __("Inclusive of all taxes");
                $item['tag_text'] = $sp->sale_tag;
                $item['tag_text_color'] = $sp->sale_tag_text_color;
                $item['tag_bg_color'] = $sp->sale_tag_color;
                $item['is_in_wishlist'] = inwishlist($sp->id);

                return $item;

            });

            return $categoryproducts_vp->toBase()->merge($categoryproducts_sp)->shuffle();
        } else {
            return response()->json([
                'No products found !',
            ]);
        }

    }

    public function topcategories($content)
    {

        $topcats = CategorySlider::first();

        if ($topcats && $topcats->category_ids != '') {

            foreach ($topcats->category_ids as $categoryid) {

                $category = Category::where('id', $categoryid)->where('status', '1')->first();

                if ($category) {

                    $content[] = array(
                        'id' => $category->id,
                        'name' => $category->getTranslations('title'),
                        'description' => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $category->getTranslations('description')),
                        'image' => $category->image,
                        'icon' => $category->icon,
                        'url' => url('/api/category/' . $category->id),
                    );

                }

            }

        }

        return $content;

    }

    public function categories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $categories = Category::orderBy('position', 'ASC')->get();
        return response()->json(['categories' => $categories]);
    }

    public function gettingBlogs($content)
    {

        $blogs = Blog::where('status', '1')->get();

        foreach ($blogs as $blog) {

            $content[] = array(
                'title' => $blog->getTranslations('heading'),
                'des' => array_map(function ($v) {
                    return trim(strip_tags($v));
                }, $blog->getTranslations('des')),
                'author' => $blog->getTranslations('user'),
                'image' => $blog->image,
                'created_on' => date('M jS, Y', strtotime($blog->created_at)),
                'url' => url('/api/blog/post/' . $blog->slug),
            );

        }

        return $content;
    }

    public function featuredProducts($content)
    {
        $sellerSystem = $this->sellerSystem;

        $featured_variant_products = Product::with('category')->whereHas('category', function ($q) {

            $q->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('vender')->whereHas('vender', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->with('subvariants')->whereHas('subvariants', function ($query) {

            $query->where('def', '=', '1');

        })->with('subvariants.variantimages')->whereHas('subvariants.variantimages')
            ->where('status', '=', '1')
            ->where('featured', '=', '1')
            ->orderBy('id', 'DESC')
            ->take(20)
            ->get();

        $featured_variant_products = $featured_variant_products->map(function ($product) {

            $orivar = $product->subvariants[0];

            $variant = $this->getVariant($orivar);

            $variant = $variant->getData();

            $mainprice = $this->getprice($product, $orivar);

            $price = $mainprice->getData();

            $rating = $this->getproductrating($product);

            $mp = sprintf("%.2f", $this->getprice($product, $orivar)->getData()->mainprice);

            $op = sprintf("%.2f", $this->getprice($product, $orivar)->getData()->offerprice);

            $getdisprice = $mp - $op;

            $discount = $getdisprice / $mp;

            $offamount = $discount * 100;

            $wishlist = new WishlistController;

            $item['productid'] = $product->id;
            $item['variantid'] = $orivar->id;
            $item['productname'] = $product->getTranslations('name');
            $item['description'] = array_map(function ($v) {
                return trim(strip_tags($v));
            }, $product->getTranslations('des'));
            $item['type'] = 'v';
            $item['tax_info'] = $product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes");
            $item['mainprice'] = (float) sprintf("%.2f", $price->mainprice * $this->rate->exchange_rate);
            $item['offerprice'] = (float) sprintf("%.2f", $price->offerprice * $this->rate->exchange_rate);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['off_percent'] = (int) round($offamount);
            $item['rating'] = (double) $rating;
            $item['thumbnail'] = $orivar->variantimages->main_image;
            $item['thumbnail_path'] = url('variantimages/thumbnails');
            $item['is_in_wishlist'] = $wishlist->isItemInWishlist($orivar);

            return $item;

        });

        $featured_simple_products = SimpleProduct::with('category')->whereHas('category', function ($q) {

            $q->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->whereHas('store.user', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })
        ->where('status', '=', '1')
        ->where('featured', '=', '1')
        ->orderBy('id', 'DESC')
        ->take(20)
        ->get();

        $featured_simple_products = $featured_simple_products->map(function ($sp) {

            $offamount = 0;

            if ($sp->offer_price != 0) {
                $getdisprice = $sp->price - $sp->offer_price;

                $discount = $getdisprice / $sp->price;

                $offamount = $discount * 100;
            }

            $item['productid'] = $sp->id;
            $item['variantid'] = 0;
            $item['type'] = 's';
            $item['productname'] = $sp->getTranslations('product_name');
            $item['description'] = array_map(function ($v) {
                return trim(strip_tags($v));
            }, $sp->getTranslations('product_detail'));
            $item['tax_info'] = $sp->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes");
            $item['mainprice']   = (float) sprintf("%.2f", $sp->price * $this->rate->exchange_rate);
            $item['offerprice']  = (float) sprintf("%.2f", $sp->offer_price * $this->rate->exchange_rate);
            $item['pricein']     = $this->rate->code;
            $item['symbol']      = $this->rate->symbol;
            $item['off_percent'] = (int) round($offamount);
            $item['rating'] = (double) simple_product_rating($sp->id);
            $item['thumbnail_path'] = url('/images/simple_products/');
            $item['thumbnail'] = $sp->thumbnail;
            $item['is_in_wishlist'] = inwishlist($sp->id);

            return $item;

        });

        return $featured_simple_products->toBase()->merge($featured_variant_products)->shuffle();

    }

    public function testimonials($content)
    {

        $testimonials = Testimonial::orderBy('id', 'DESC')->where('status', '1')->get();

        foreach ($testimonials as $value) {

            $content[] = array(
                'name' => $value->getTranslations('name'),
                'des' => $value->getTranslations('des'),
                'designation' => $value->post,
                'rating' => $value->rating,
                'profilepicture' => $value->image,
            );

        }

        return $content;
    }

    public function subcategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $categories = Subcategory::orderBy('position', 'ASC')->get();
        return response()->json(['categories' => $categories], 200);
    }

    public function childcategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required', 'status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $categories = Grandcategory::orderBy('position', 'ASC')->get();
        return response()->json(['categories' => $categories], 200);
    }

    public function getcategoryproduct(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $sellerSystem = $this->sellerSystem;

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request->currency)->getData();

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['msg' => 'Category not found !', 'status' => 'fail']);
        }

        if ($category->status != 1) {
            return response()->json(['msg' => 'Category is not active !', 'status' => 'fail']);
        }

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates(request()->currency)->getData();

        $categoryproducts_vp = Product::with('category')->whereHas('category', function ($q) use ($category) {

            $q->where('status', '=', '1')->where('id', $category->id);

        })->with('subcategory')->wherehas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('vender')->whereHas('vender', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->with('subvariants')->whereHas('subvariants', function ($query) {

            $query->where('def', '=', '1');

        })
        ->with(['subvariants.variantimages'])
        ->whereHas('subvariants.variantimages')
        ->where('status', '=', '1')
        ->orderBy('id', 'DESC')
        ->get();

        $review = new ProductController;

        $wishlist = new WishlistController;

        $categoryproducts_vp = $categoryproducts_vp->map(function ($q) use ($review, $wishlist) {

            $orivar = $q->subvariants[0];
            $mainprice = $this->getprice($q, $orivar);
            $price = $mainprice->getData();

            if ($this->getprice($q, $orivar)->getData()->offerprice != 0) {

                $mp = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->mainprice);
                $op = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->offerprice);

                $getdisprice = $mp - $op;

                $discount = $getdisprice / $mp;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid'] = $q->id;
            $item['variantid'] = $orivar->id;
            $item['productname'] = $q->getTranslations('name');
            $item['variantname'] = variantname($orivar);
            $item['type'] = 'v';
            $item['mainprice'] = round($price->mainprice * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($price->offerprice * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['rating'] = (double) get_product_rating($q->id);
            $item['review'] = (int) $review->getProductReviews($q)->count();
            $item['images'] = $orivar->variantimages->main_image ?? '';
            $item['thumbpath'] = url('/variantimages/thumbnails');
            $item['off_in_percent'] = (int) round($offamount);
            $item['is_in_wishlist'] = (boolean) $wishlist->isItemInWishlist($orivar);
            $item['detail_page_url'] = url('/api/details/' . $q->id . '/' . $orivar->id . '');

            return $item;

        });

        $categoryproducts_sp = SimpleProduct::with('category')->whereHas('category', function ($q) use ($category) {

            $q->where('id', $category->id)->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->whereHas('store.user', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })
        ->where('status', '=', '1')
        ->orderBy('id', 'DESC')
        ->get();

        $categoryproducts_sp = $categoryproducts_sp->map(function ($sp) {

            if ($sp->offer_price != 0) {

                $getdisprice = $sp->price - $sp->offer_price;

                $discount = $getdisprice / $sp->price;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid'] = $sp->id;
            $item['variantid'] = 0;
            $item['type'] = 's';
            $item['variantname'] = NULL;
            $item['productname'] = $sp->getTranslations('product_name');
            $item['mainprice'] = round($sp->price * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($sp->offer_price * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['rating'] = (double) simple_product_rating($sp->id);
            $item['review'] = (int) $sp->reviews()->whereNotNull('review')->count();
            $item['images'] = $sp->thumbnail;
            $item['thumbpath'] = url('images/simple_products/');
            $item['off_in_percent'] = (int) round($offamount);
            $item['is_in_wishlist'] = inwishlist($sp->id);

            return $item;

        });

        $result = $categoryproducts_sp->toBase()->merge($categoryproducts_vp)->shuffle();

        if (empty($result)) {
            $result[] = 'No Products Found in this category !';
        }

        $category_dtl = array(
            'id' => $category->id,
            'name' => $category->getTranslations('title'),
            'desciption' => array_map(function ($v) {
                return trim(strip_tags($v));
            }, $category->getTranslations('description')),
            'icon' => $category->icon,
            'image' => $category->image,
            'imagepath' => url('images/grandcategory/'),
        );

        $finalresponse = [

            'category' => $category_dtl,
            'products' => $result,

        ];

        return response()->json($finalresponse);

    }

    public function getsubcategoryproduct(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $sellerSystem = $this->sellerSystem;

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request->currency)->getData();

        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return response()->json(['msg' => 'Category not found !', 'status' => 'fail']);
        }

        if ($subcategory->status != 1) {
            return response()->json(['msg' => 'Category is not active !', 'status' => 'fail']);
        }

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates(request()->currency)->getData();

        $categoryproducts_vp = Product::with('category')->whereHas('category', function ($q) use ($subcategory) {

            $q->where('status', '=', '1')->where('id', $subcategory->category->id);

        })->with('subcategory')->wherehas('subcategory', function ($q) use($subcategory) {

            $q->where('status', '1')->where('id',$subcategory->id);

        })->with('vender')->whereHas('vender', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->with('subvariants')->whereHas('subvariants', function ($query) {

            $query->where('def', '=', '1');

        })
        ->with(['subvariants.variantimages'])
        ->whereHas('subvariants.variantimages')
        ->where('status', '=', '1')
        ->orderBy('id', 'DESC')
        ->get();

        $review = new ProductController;

        $wishlist = new WishlistController;

        $categoryproducts_vp = $categoryproducts_vp->map(function ($q) use ($review, $wishlist) {

            $orivar = $q->subvariants[0];
            $mainprice = $this->getprice($q, $orivar);
            $price = $mainprice->getData();

            if ($this->getprice($q, $orivar)->getData()->offerprice != 0) {

                $mp = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->mainprice);
                $op = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->offerprice);

                $getdisprice = $mp - $op;

                $discount = $getdisprice / $mp;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid'] = $q->id;
            $item['variantid'] = $orivar->id;
            $item['productname'] = $q->getTranslations('name');
            $item['variantname'] = variantname($orivar);
            $item['type'] = 'v';
            $item['mainprice'] = round($price->mainprice * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($price->offerprice * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['rating'] = (double) get_product_rating($q->id);
            $item['review'] = (int) $review->getProductReviews($q)->count();
            $item['images'] = $orivar->variantimages->main_image ?? '';
            $item['thumbpath'] = url('/variantimages/thumbnails');
            $item['off_in_percent'] = (int) round($offamount);
            $item['is_in_wishlist'] = (boolean) $wishlist->isItemInWishlist($orivar);
            $item['detail_page_url'] = url('/api/details/' . $q->id . '/' . $orivar->id . '');

            return $item;

        });

        $categoryproducts_sp = SimpleProduct::with('category')->whereHas('category', function ($q) use ($subcategory) {

            $q->where('id', $subcategory->category->id)->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) use($subcategory) {

            $q->where('status', '1')->where('id',$subcategory->id);

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->whereHas('store.user', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })
        ->where('status', '=', '1')
        ->orderBy('id', 'DESC')
        ->get();

        $categoryproducts_sp = $categoryproducts_sp->map(function ($sp) {

            if ($sp->offer_price != 0) {

                $getdisprice = $sp->price - $sp->offer_price;

                $discount = $getdisprice / $sp->price;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid'] = $sp->id;
            $item['variantid'] = 0;
            $item['type'] = 's';
            $item['variantname'] = NULL;
            $item['productname'] = $sp->getTranslations('product_name');
            $item['mainprice'] = round($sp->price * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($sp->offer_price * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['rating'] = (double) simple_product_rating($sp->id);
            $item['review'] = (int) $sp->reviews()->whereNotNull('review')->count();
            $item['images'] = $sp->thumbnail;
            $item['thumbpath'] = url('images/simple_products/');
            $item['off_in_percent'] = (int) round($offamount);
            $item['is_in_wishlist'] = inwishlist($sp->id);

            return $item;

        });

        $result = $categoryproducts_sp->toBase()->merge($categoryproducts_vp)->shuffle();

        if (empty($result)) {
            $result[] = 'No Products Found in this category !';
        }

        $subcategory_dtl = array(
            'id' => $subcategory->id,
            'name' => $subcategory->getTranslations('title'),
            'desciption' => array_map(function ($v) {
                return trim(strip_tags($v));
            }, $subcategory->getTranslations('description')),
            'icon' => $subcategory->icon,
            'image' => $subcategory->image,
            'imagepath' => url('images/grandcategory/'),
        );

        $finalresponse = [

            'category' => $subcategory_dtl,
            'products' => $result,

        ];

        return response()->json($finalresponse);

    }

    public function getchildcategoryproduct(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request->currency)->getData();

        $childcat = Grandcategory::find($id);

        $sellerSystem = $this->sellerSystem;

        if (!$childcat) {
            return response()->json(['msg' => 'Childcategory not found !', 'status' => 'fail']);
        }

        if ($childcat->status != 1) {
            return response()->json(['msg' => 'Childcategory is not active !', 'status' => 'fail']);
        }

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates(request()->currency)->getData();

        $categoryproducts_vp = Product::with('category')->whereHas('category', function ($q) use ($childcat) {

            $q->where('status', '=', '1')->where('id', $childcat->subcategory->category->id);

        })->with('subcategory')->wherehas('subcategory', function ($q) use($childcat) {

            $q->where('status', '1')->where('id',$childcat->subcategory->id);

        })->with('childcat')->wherehas('childcat', function ($q) use($childcat) {

            $q->where('status', '1')->where('id',$childcat->id);

        })->with('vender')->whereHas('vender', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->with('subvariants')->whereHas('subvariants', function ($query) {

            $query->where('def', '=', '1');

        })
        ->with(['subvariants.variantimages'])
        ->whereHas('subvariants.variantimages')
        ->where('status', '=', '1')
        ->orderBy('id', 'DESC')
        ->get();

        $review = new ProductController;

        $wishlist = new WishlistController;

        $categoryproducts_vp = $categoryproducts_vp->map(function ($q) use ($review, $wishlist) {

            $orivar = $q->subvariants[0];
            $mainprice = $this->getprice($q, $orivar);
            $price = $mainprice->getData();

            if ($this->getprice($q, $orivar)->getData()->offerprice != 0) {

                $mp = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->mainprice);
                $op = sprintf("%.2f", $this->getprice($q, $orivar)->getData()->offerprice);

                $getdisprice = $mp - $op;

                $discount = $getdisprice / $mp;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid'] = $q->id;
            $item['variantid'] = $orivar->id;
            $item['productname'] = $q->getTranslations('name');
            $item['variantname'] = variantname($orivar);
            $item['type'] = 'v';
            $item['mainprice'] = round($price->mainprice * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($price->offerprice * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['rating'] = (double) get_product_rating($q->id);
            $item['review'] = (int) $review->getProductReviews($q)->count();
            $item['images'] = $orivar->variantimages->main_image ?? '';
            $item['thumbpath'] = url('/variantimages/thumbnails');
            $item['off_in_percent'] = (int) round($offamount);
            $item['is_in_wishlist'] = (boolean) $wishlist->isItemInWishlist($orivar);
            $item['detail_page_url'] = url('/api/details/' . $q->id . '/' . $orivar->id . '');

            return $item;

        });

        $categoryproducts_sp = SimpleProduct::with('category')->whereHas('category', function ($q) use ($childcat) {

            $q->where('id', $childcat->subcategory->category->id)->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) use($childcat) {

            $q->where('status', '1')->where('id',$childcat->subcategory->id);

        })->with('childcat')->wherehas('childcat', function ($q) use($childcat) {

            $q->where('status', '1')->where('id',$childcat->id);

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->whereHas('store.user', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })
        ->where('status', '=', '1')
        ->orderBy('id', 'DESC')
        ->get();

        $categoryproducts_sp = $categoryproducts_sp->map(function ($sp) {

            if ($sp->offer_price != 0) {

                $getdisprice = $sp->price - $sp->offer_price;

                $discount = $getdisprice / $sp->price;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $item['productid'] = $sp->id;
            $item['variantid'] = 0;
            $item['type'] = 's';
            $item['variantname'] = NULL;
            $item['productname'] = $sp->getTranslations('product_name');
            $item['mainprice'] = round($sp->price * $this->rate->exchange_rate, 2);
            $item['offerprice'] = round($sp->offer_price * $this->rate->exchange_rate, 2);
            $item['pricein'] = $this->rate->code;
            $item['symbol'] = $this->rate->symbol;
            $item['rating'] = (double) simple_product_rating($sp->id);
            $item['review'] = (int) $sp->reviews()->whereNotNull('review')->count();
            $item['images'] = $sp->thumbnail;
            $item['thumbpath'] = url('images/simple_products/');
            $item['off_in_percent'] = (int) round($offamount);
            $item['is_in_wishlist'] = inwishlist($sp->id);

            return $item;

        });

        $result = $categoryproducts_sp->toBase()->merge($categoryproducts_vp)->shuffle();

        if (empty($result)) {
            $result[] = 'No Products Found in this category !';
        }

        $subcategory_dtl = array(
            'id' => $childcat->id,
            'name' => $childcat->getTranslations('title'),
            'desciption' => array_map(function ($v) {
                return trim(strip_tags($v));
            }, $childcat->getTranslations('description')),
            'icon' => $childcat->icon,
            'image' => $childcat->image,
            'imagepath' => url('images/grandcategory/'),
        );

        $finalresponse = [

            'category' => $subcategory_dtl,
            'products' => $result,

        ];

        return response()->json($finalresponse);
    }

    public function hotdeals(Request $request, $content)
    {
        $sellerSystem = $this->sellerSystem;

        if (!isset($this->rate)) {
            $rates = new CurrencyController;
            $this->rate = $rates->fetchRates($request->currency)->getData();
        }

        $variant_product_hotdeals = Product::with('hotdeal')
            ->whereHas('hotdeal', function ($query) {

                return $query->where('status', '1')->whereDate('end', '>=', now());

            })
            ->with('category')->whereHas('category', function ($q) {

            $q->where('status', '=', '1');

        })
            ->with('subcategory')->whereHas('subcategory', function ($q) {

            $q->where('status', '1');

        })
            ->with('vender')->whereHas('vender', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })
            ->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })
            ->with('subvariants')->whereHas('subvariants', function ($query) {

            $query->where('def', '=', '1');

        })
            ->with('subvariants.variantimages')
            ->whereHas('subvariants.variantimages')
            ->where('status', '=', '1')
            ->orderBy('id', 'DESC')
            ->get();

        if ($variant_product_hotdeals) {

            $get_product_data = new MainController;

            $variant_product_hotdeals = $variant_product_hotdeals->map(function ($q) use ($get_product_data) {

                $orivar = $q->subvariants[0];

                if (isset($orivar)) {

                    $variant = $get_product_data->getVariant($orivar);
                    $variant = $variant->getData();
                    $mainprice = $get_product_data->getprice($q, $orivar);
                    $price = $mainprice->getData();

                    $mp = sprintf("%.2f", $get_product_data->getprice($q, $orivar)->getData()->mainprice);

                    $op = sprintf("%.2f", $get_product_data->getprice($q, $orivar)->getData()->offerprice);

                    $offamount = 0;

                    if ($op != 0) {

                        $getdisprice = $mp - $op;

                        $discount = $getdisprice / $mp;

                        $offamount = $discount * 100;
                    }

                    $content['start_date'] = $q->hotdeal->start;
                    $content['end_date'] = $q->hotdeal->end;
                    $content['productid'] = $q->id;
                    $content['type'] = 'v';
                    $content['variantid'] = $orivar->id;
                    $content['productname'] = $q->getTranslations('name');
                    $content['tax_info'] = $q->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes");
                    $content['selling_start_at'] = $q->selling_start_at;
                    $content['mainprice'] = ($price->mainprice * $this->rate->exchange_rate);
                    $content['offerprice'] = ($price->offerprice * $this->rate->exchange_rate);
                    $content['pricein'] = $this->rate->code;
                    $content['symbol'] = $this->rate->symbol;
                    $content['off_percent'] = (int) round($offamount);
                    $content['thumbnail_path'] = url('/variantimages');
                    $content['thumbnail'] = $orivar->variantimages->main_image;
                    $content['rating'] = ProductRating::getReview($q);
                    $content['hotdeal_bg_path'] = url('images/hotdeal_backgrounds/');
                    $content['hotdeal_bg'] = 'default.jpg';
                    $content['otherimagepath'] = url('variantimages/');
                    $content['otherimages'] = $orivar->variantimages()->select('image1', 'image2', 'image3', 'image4', 'image5', 'image6')->get()->map(function ($image) {

                        $item[]['image'] = $image->image1;
                        $item[]['image'] = $image->image2;
                        $item[]['image'] = $image->image3;
                        $item[]['image'] = $image->image4;
                        $item[]['image'] = $image->image5;
                        $item[]['image'] = $image->image6;

                        return $item;
                    });

                    $content['otherimages'] = $content['otherimages'][0];

                    return $content;

                }

            });

            $variant_product_hotdeals = $variant_product_hotdeals->filter();
        }

        $simple_products_hotdeals = SimpleProduct::with('hotdeal')
            ->whereHas('hotdeal', function ($q) {

                return $q->where('pre_order', '=', '0')
                    ->where('status', '1')
                    ->whereDate('end', '>=', now());

            })->with('category')->whereHas('category', function ($q) {

            $q->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->whereHas('store.user', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {

                $query->where('status', '=', '1')
                    ->where('is_verified', '1');

            } else {

                $query->where('status', '=', '1')
                    ->where('role_id', '=', 'a')
                    ->where('is_verified', '1');

            }

        })
            ->where('status', '=', '1')
            ->get();

        if ($simple_products_hotdeals) {

            $simple_products_hotdeals = $simple_products_hotdeals->map(function ($sp) {

                if ($sp->offerprice != 0) {
                    $getdisprice = $sp->mainprice - $sp->offerprice;

                    $discount = $getdisprice / $sp->mainprice;

                    $offamount = $discount * 100;
                }

                $item['start_date'] = $sp->hotdeal->start;
                $item['end_date'] = $sp->hotdeal->end;
                $item['productid'] = $sp->id;
                $item['variantid'] = 0;
                $item['productname'] = $sp->getTranslations('product_name');
                $item['mainprice'] = $sp->price * $this->rate->exchange_rate;
                $item['offerprice'] = $sp->offer_price * $this->rate->exchange_rate;
                $item['tax_info'] = __("Inclusive of all taxes");
                $item['thumbnail_path'] = url('images/simple_products/');
                $item['thumbnail'] = $sp->thumbnail;
                $item['otherimagepath'] = url('/images/simple_products/gallery');
                $item['otherimages'] = $sp->productGallery()->get(['image']);
                $item['pricein'] = $this->rate->code;
                $item['symbol'] = $this->rate->symbol;
                $item['type'] = 's';
                $item['rating'] = simple_product_rating($sp->id);

                $item['off_percent'] = (int) round($offamount ?? 0);
                $item['hotdeal_bg_path'] = url('images/hotdeal_backgrounds/');
                $item['hotdeal_bg'] = 'default.jpg';

                return $item;

            });
        }

        return $simple_products_hotdeals->toBase()->merge($variant_product_hotdeals);
    }

    public function specialoffer($content)
    {

        $sellerSystem = $this->sellerSystem;

        $vp_specialoffers = Product::with('specialoffer')->whereHas('specialoffer', function ($query) {

            return $query->where('status', '1');

        })->with('category')->whereHas('category', function ($q) {

            $q->where('status', '=', '1');

        })->with('subcategory')->whereHas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('vender')->whereHas('vender', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->with('subvariants')->whereHas('subvariants', function ($query) {

            $query->where('def', '=', '1');

        })
            ->with('subvariants.variantimages')
            ->whereHas('subvariants.variantimages')
            ->where('status', '=', '1')
            ->orderBy('id', 'DESC')
            ->get();

        $vp_specialoffers = $vp_specialoffers->map(function ($sp) {

            $orivar = $sp->subvariants[0];
            $mainprice = $this->getprice($sp, $orivar);
            $price = $mainprice->getData();

            if ($this->getprice($sp, $orivar)->getData()->offerprice != 0) {

                $mp = sprintf("%.2f", $this->getprice($sp, $orivar)->getData()->mainprice);
                $op = sprintf("%.2f", $this->getprice($sp, $orivar)->getData()->offerprice);

                $getdisprice = $mp - $op;

                $discount = $getdisprice / $mp;

                $offamount = $discount * 100;
            } else {
                $offamount = 0;
            }

            $content['productname'] = $sp->getTranslations('name');
            $content['productid'] = $sp->id;
            $content['variantid'] = $orivar->id;
            $content['type'] = 'v';
            $content['mainprice'] = (double) sprintf("%.2f", $price->mainprice * $this->rate->exchange_rate);
            $content['offerprice'] = (double) sprintf("%.2f", $price->offerprice * $this->rate->exchange_rate);
            $content['pricein'] = $this->rate->code;
            $content['symbol'] = $this->rate->symbol;
            $content['rating'] = (double) ProductRating::getReview($sp);
            $content['thumbnail'] = $orivar->variantimages->main_image;
            $content['thumb_path'] = url('/variantimages/thumbnails/');
            $content['off_in_percent'] = (int) round($offamount);

            return $content;

        });

        $sp_specialoffers = SimpleProduct::with('special_offer')
            ->whereHas('special_offer', function ($q) {
                return $q->where('status', '1');
            })
            ->with('category')->whereHas('category', function ($q) {

            $q->where('status', '=', '1');

        })->with('subcategory')->wherehas('subcategory', function ($q) {

            $q->where('status', '1');

        })->with('store')->whereHas('store', function ($query) {

            return $query->where('status', '=', '1');

        })->whereHas('store.user', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })
            ->where('status', '=', '1')
            ->get();

        if ($sp_specialoffers) {

            $sp_specialoffers = $sp_specialoffers->map(function ($sp) {

                if ($sp->offer_price != 0) {

                    $mp = $sp->price;
                    $op = $sp->offer_price;

                    $getdisprice = $mp - $op;

                    $discount = $getdisprice / $mp;

                    $offamount = $discount * 100;
                } else {
                    $offamount = 0;
                }

                $item['productname'] = $sp->getTranslations('product_name');
                $item['productid'] = $sp->id;
                $item['type'] = 's';
                $item['mainprice'] = (double) sprintf("%.2f", $sp->price * $this->rate->exchange_rate);
                $item['offerprice'] = (double) sprintf("%.2f", $sp->offer_price * $this->rate->exchange_rate);
                $item['pricein'] = $this->rate->code;
                $item['symbol'] = $this->rate->symbol;
                $item['rating'] = (double) simple_product_rating($sp->id);
                $item['thumbnail'] = $sp->thumbnail;
                $item['thumb_path'] = url('images/simple_products/');
                $item['off_in_percent'] = round($offamount);

                return $item;

            });
        }

        return $sp_specialoffers->merge($vp_specialoffers)->shuffle();
    }

    public function brands(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required', 'status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $brand = Brand::where('status', '=', '1')->where('show_image', '=', 1)->get();
        return response()->json($brand);
    }

    public function page(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required', 'status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $page = Page::where('slug', '=', $slug)->where('status','=','1')->first();

        if(!$page){
            return response()->json(['msg' => __("Page not found !"),'status' => 'fail']);
        }

        return response()->json($page);

    }

    public function menus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required', 'status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $topmenu = Menu::orderBy('position', 'ASC')->get();

        return response()->json($topmenu);
    }

    public function footermenus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required', 'status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $footermenus = FooterMenu::get();

        return response()->json($footermenus = FooterMenu::get());
    }

    public function userprofile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required', 'status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !", 'status' => 'fail']);
        } else {
            $user = Auth::user();
            return response()->json($user);
        }

    }

    public function mywallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|string|max:3'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !", 'status' => 'fail']);
        }

        $wallet = UserWallet::firstWhere('user_id', '=', Auth::user()->id);

       
        $wallethistory = $wallet->wallethistory;

        return response()->json(['wallet' => $wallet, 'wallethistory' => $wallethistory]);
    }

    public function getuseraddress(Request $request)
    {

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !", 'status' => 'fail'], 401);
        }

        $address = array();

        foreach (Auth::user()->addresses->sortByDesc('id') as $key => $ad) {

            $address[] = array(
                'id' => $ad->id,
                'name' => $ad->name,
                'email' => $ad->email,
                'address' => strip_tags($ad->address),
                'type' => $ad->type,
                'phone' => $ad->phone,
                'pin_code' => $ad->pin_code,
                'country' => array(
                    'id' => (int) $ad->country_id,
                    'name' => $ad->getCountry ? $ad->getCountry->nicename : null,
                ),
                'state' => array(
                    'id' => (int) $ad->state_id,
                    'name' => $ad->getstate ? $ad->getstate->name : null,
                ),
                'city' => array(
                    'id' => (int) $ad->city_id,
                    'name' => $ad->getcity ? $ad->getcity->name : null,
                ),
                'defaddress' => $ad->defaddress,
            );
        }

        return response()->json(['address' => $address, 'status' => 'success']);
    }

    public function getuserbanks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !", 'status' => 'fail']);
        }

        $userbanklist = Auth::user()->banks;

        return response()->json(['banks' => $userbanklist],200);
    }

    public function faqs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $faqs = Faq::all();

        return response()->json(['faqs' => $faqs]);
    }

    public function listallblog(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $blogs = Blog::orderBy('id', 'DESC')->get();
        return response()->json($blogs);
    }

    public function blogdetail(Request $request, $slug)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $blog = Blog::firstWhere('slug', '=', $slug);

        if (!isset($blog)) {
            return response()->json(['msg' => '404 Blog post not found !', 'status' => 'fail']);
        }

        return response()->json($blog);
    }

    public function myNotifications(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !", 'status' => 'fail']);
        }

        $notifications = auth()->user()
                         ->unreadNotifications
                         ->where('n_type', '!=', 'order_v')
                         ->transform(function($value){

                            $item['data'] = $value->data;
                            $item['created_at'] = $value->created_at;
                            return $item;

                         });
                         
        $notifications = $notifications->values();

        $notificationsCount = auth()->user()->unreadNotifications
                              ->where('n_type', '!=', 'order_v')
                              ->count();

        return response()->json(['notifications' => $notifications, 'count' => $notificationsCount]);
    }

    public function getprice($pro, $orivar)
    {

        $convert_price = 0.00;
        $show_price = 0.00;

        $commision_setting = CommissionSetting::first();

        if ($commision_setting->type == "flat") {

            $commission_amount = $commision_setting->rate;

            if ($commision_setting->p_type == 'f') {

                if ($pro->tax_r != '') {

                    $cit = $commission_amount * $pro->tax_r / 100;
                    $totalprice = $pro->vender_price + $orivar->price + $commission_amount + $cit;
                    $totalsaleprice = $pro->vender_offer_price + $cit + $orivar->price +
                        $commission_amount;

                    if ($pro->vender_offer_price == null) {
                        $show_price = $totalprice;
                    } else {
                        $totalsaleprice;
                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                        $show_price = $totalprice;
                    }

                } else {
                    $totalprice = $pro->vender_price + $orivar->price + $commission_amount;
                    $totalsaleprice = $pro->vender_offer_price + $orivar->price + $commission_amount;

                    if ($pro->vender_offer_price == null) {
                        $show_price = $totalprice;
                    } else {
                        $totalsaleprice;
                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                        $show_price = $totalprice;
                    }

                }

            } else {

                $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                if ($pro->vender_offer_price == null) {
                    $show_price = round($buyerprice, 2);
                } else {
                    round($buyersaleprice, 2);

                    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                    $show_price = $buyerprice;
                }

            }
        } else {

            $comm = Commission::where('category_id', $pro->category_id)->first();
            if (isset($comm)) {
                if ($comm->type == 'f') {

                    if ($pro->tax_r != '') {

                        $cit = $comm->rate * $pro['tax_r'] / 100;

                        $price = $pro->vender_price + $comm->rate + $orivar->price + $cit;

                        if ($pro->vender_offer_price != null) {
                            $offer = $pro->vender_offer_price + $comm->rate + $orivar->price + $cit;
                        } else {
                            $offer = $pro->vender_offer_price;
                        }

                        if ($pro->vender_offer_price == null) {
                            $show_price = $price;
                        } else {

                            $convert_price = $offer;
                            $show_price = $price;
                        }

                    } else {

                        $price = $pro->vender_price + $comm->rate + $orivar->price;

                        if ($pro->vender_offer_price != null) {
                            $offer = $pro->vender_offer_price + $comm->rate + $orivar->price;
                        } else {
                            $offer = $pro->vender_offer_price;
                        }

                        if ($pro->vender_offer_price == 0 || $pro->vender_offer_price == null) {
                            $show_price = $price;
                        } else {

                            $convert_price = $offer;
                            $show_price = $price;
                        }

                    }

                } else {

                    $commission_amount = $comm->rate;

                    $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                    $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                    $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                    $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                    if ($pro->vender_offer_price == null) {
                        $show_price = round($buyerprice, 2);
                    } else {
                        $convert_price = round($buyersaleprice, 2);

                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                        $show_price = round($buyerprice, 2);
                    }

                }
            } else {
                $commission_amount = 0;

                $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                if ($pro->vender_offer_price == null) {
                    $show_price = round($buyerprice, 2);
                } else {
                    $convert_price = round($buyersaleprice, 2);

                    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                    $show_price = round($buyerprice, 2);
                }
            }
        }

        return response()->json(['mainprice' => sprintf("%.2f", $show_price), 'offerprice' => sprintf("%.2f", $convert_price)]);

    }

    public function getproductrating($pro)
    {

        $reviews = UserReview::where('pro_id', $pro->id)->where('status', '1')->get();

        if (!empty($reviews[0])) {

            $review_t = 0;
            $price_t = 0;
            $value_t = 0;
            $sub_total = 0;
            $count = UserReview::where('pro_id', $pro->id)->count();

            foreach ($reviews as $review) {
                $review_t = $review->price * 5;
                $price_t = $review->price * 5;
                $value_t = $review->value * 5;
                $sub_total = $sub_total + $review_t + $price_t + $value_t;
            }

            $count = ($count * 3) * 5;
            $rat = $sub_total / $count;
            $ratings_var = ($rat * 100) / 5;

            $overallrating = ($ratings_var / 2) / 10;

            return sprintf('%.2f', $overallrating);

        } else {
            return $overallrating = 0;
        }
    }

    public function getVariant($orivar)
    {
        $varcount = count($orivar->main_attr_value);
        $i = 0;
        $othervariantName = null;

        foreach ($orivar->main_attr_value as $key => $orivars) {

            $i++;

            $loopgetattrname = ProductAttributes::where('id', $key)->first()->attr_name;
            $getvarvalue = ProductValues::where('id', $orivars)->first();

            if ($i < $varcount) {
                if (isset($getvarvalue) && strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {
                    if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                        $othervariantName = $getvarvalue->values . ',';

                    } else {
                        $othervariantName = $getvarvalue->values . $getvarvalue->unit_value . ',';
                    }
                } else {
                    $othervariantName = $getvarvalue->values ?? '';
                }

            } else {

                if (isset($getvarvalue) && strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {

                    if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                        $othervariantName = $getvarvalue->values;

                    } else {
                        $othervariantName = $getvarvalue->values . $getvarvalue->unit_value;
                    }

                } else {
                    $othervariantName = $getvarvalue->values ?? '';
                }

            }

        }

        return response()->json(['value' => $othervariantName, 'attrName' => $loopgetattrname]);
    }

    public function createaddress(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|numeric',
            'pincode' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'defaddress' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('name')) {
                return response()->json(['msg' => $errors->first('name'), 'status' => 'fail']);
            }

            if ($errors->first('email')) {
                return response()->json(['msg' => $errors->first('email'), 'status' => 'fail']);
            }

            if ($errors->first('address')) {
                return response()->json(['msg' => $errors->first('address'), 'status' => 'fail']);
            }

            if ($errors->first('phone')) {
                return response()->json(['msg' => $errors->first('phone'), 'status' => 'fail']);
            }

            if ($errors->first('pincode')) {
                return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }

            if ($errors->first('country_id')) {
                return response()->json(['msg' => $errors->first('country_id'), 'status' => 'fail']);
            }

            if ($errors->first('state_id')) {
                return response()->json(['msg' => $errors->first('state_id'), 'status' => 'fail']);
            }

            if ($errors->first('city_id')) {
                return response()->json(['msg' => $errors->first('city_id'), 'status' => 'fail']);
            }

            if ($errors->first('defaddress')) {
                return response()->json(['msg' => $errors->first('defaddress'), 'status' => 'fail']);
            }
        }

        if ($request->defaddress == 1) {
            //Remove any previous default address
            Address::where('user_id', Auth::user()->id)
                ->where('defaddress', '=', 1)
                ->update(['defaddress' => 0]);
        }

        $createdaddress = Auth::user()->addresses()->create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type ?? null,
            'pin_code' => $request->pincode,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'defaddress' => $request->defaddress,
            'user_id' => Auth::user()->id,
        ]);

        $address = array(
            'id' => $createdaddress->id,
            'name' => $createdaddress->name,
            'email' => $createdaddress->email,
            'address' => $createdaddress->address,
            'type' => $createdaddress->type,
            'phone' => $createdaddress->phone,
            'pin_code' => $createdaddress->pin_code,
            'country' => array(
                'id' => (int) $createdaddress->country_id,
                'name' => $createdaddress->getCountry ? $createdaddress->getCountry->nicename : null,
            ),
            'state' => array(
                'id' => (int) $createdaddress->state_id,
                'name' => $createdaddress->getstate ? $createdaddress->getstate->name : null,
            ),
            'city' => array(
                'id' => (int) $createdaddress->city_id,
                'name' => $createdaddress->getcity ? $createdaddress->getcity->name : null,
            ),
            'defaddress' => $createdaddress->defaddress,
        );

        return response()->json(['msg' => 'Address created successfully', 'address' => $address, 'status' => 'success']);

    }

    public function listbillingaddress()
    {

        $address = array();

        foreach (Auth::user()->billingAddress->sortByDesc('id') as $key => $ad) {

            $address[] = array(
                'id' => $ad->id,
                'name' => $ad->firstname,
                'email' => $ad->email,
                'address' => strip_tags($ad->address),
                'mobile' => (int) $ad->mobile,
                'pincode' => (int) $ad->pincode,
                'type' => $ad->type,
                'country' => array(
                    'id' => (int) $ad->country_id,
                    'name' => $ad->countiess ? $ad->countiess->nicename : null,
                ),
                'state' => array(
                    'id' => (int) $ad->state,
                    'name' => $ad->states ? $ad->states->name : null,
                ),
                'city' => array(
                    'id' => (int) $ad->city,
                    'name' => $ad->cities ? $ad->cities->name : null,
                ),
            );
        }

        return response()->json(['billingaddress' => $address, 'status' => 'success']);
    }

    public function createbillingaddress(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|numeric',
            'pincode' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('name')) {
                return response()->json(['msg' => $errors->first('name'), 'status' => 'fail']);
            }

            if ($errors->first('email')) {
                return response()->json(['msg' => $errors->first('email'), 'status' => 'fail']);
            }

            if ($errors->first('address')) {
                return response()->json(['msg' => $errors->first('address'), 'status' => 'fail']);
            }

            if ($errors->first('phone')) {
                return response()->json(['msg' => $errors->first('phone'), 'status' => 'fail']);
            }

            if ($errors->first('pincode')) {
                return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }

            if ($errors->first('country_id')) {
                return response()->json(['msg' => $errors->first('country_id'), 'status' => 'fail']);
            }

            if ($errors->first('state_id')) {
                return response()->json(['msg' => $errors->first('state_id'), 'status' => 'fail']);
            }

            if ($errors->first('city_id')) {
                return response()->json(['msg' => $errors->first('city_id'), 'status' => 'fail']);
            }

            if ($errors->first('defaddress')) {
                return response()->json(['msg' => $errors->first('defaddress'), 'status' => 'fail']);
            }
        }

        $createdaddress = Auth::user()->billingAddress()->create([
            'firstname' => $request->name,
            'email' => $request->email,
            'type' => $request->type ?? null,
            'address' => $request->address,
            'mobile' => $request->phone,
            'pincode' => $request->pincode,
            'country_id' => $request->country_id,
            'state' => $request->state_id,
            'city' => $request->city_id,
            'user_id' => Auth::user()->id,
        ]);

        $address = array(
            'id' => $createdaddress->id,
            'name' => $createdaddress->firstname,
            'email' => $createdaddress->email,
            'address' => $createdaddress->address,
            'type' => $createdaddress->type,
            'phone' => $createdaddress->mobile,
            'pincode' => $createdaddress->pincode,
            'country' => array(
                'id' => (int) $createdaddress->country_id,
                'name' => $createdaddress->countiess ? $createdaddress->countiess->nicename : null,
            ),
            'state' => array(
                'id' => (int) $createdaddress->state,
                'name' => $createdaddress->states ? $createdaddress->states->name : null,
            ),
            'city' => array(
                'id' => (int) $createdaddress->city,
                'name' => $createdaddress->cities ? $createdaddress->cities->name : null,
            ),
        );

        return response()->json(['msg' => 'Billing address created successfully', 'billingaddress' => $address, 'status' => 'success']);

    }

    public function listofcountries(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $data = Country::join('allcountry', 'allcountry.iso3', '=', 'countries.country')->select('allcountry.id as id', 'allcountry.nicename as name')->get();

        return response()->json([
            'countries' => $data,
            'status' => 'success',
        ]);

    }

    public function listofstates(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $data = Allstate::where('country_id', '=', $id)->get();

        return response()->json(['states' => $data, 'success' => 'success']);

    }

    public function listofcities(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $data = Allcity::where('state_id', '=', $id)->get();

        return response()->json(['cities' => $data, 'status' => 'success']);

    }

    public function searchcity(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('name')) {
                return response()->json(['msg' => $errors->first('name'), 'status' => 'fail']);
            }
        }

        $result = Allcity::where('name', 'LIKE', '%' . $request->name . '%')
            ->get();

        $finalResult = array();

        foreach ($result as $key => $value) {
            $finalResult[] = array(
                'cityid' => $value->id,
                'cityname' => $value->name,
                'pincode' => $value->pincode,
                'stateid' => $value->state ? $value->state->id : null,
                'statename' => $value->state ? $value->state->name : null,
                'countryid' => $value->state->country ? $value->state->country->id : null,
                'countryname' => $value->state->country ? $value->state->country->nicename : null,
            );
        }

        if (count($finalResult) < 1) {
            return response()->json(
                [
                    'msg' => 'No result found !',
                    'status' => 'fail',
                ]
            );
        }

        return response()->json($finalResult);

    }

    public function fetchPinCodeAddressForGuest(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'pincode' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('pincode')) {
                return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }
        }

        if (strlen($request->pincode) > 12) {

            return response()->json(['msg' => 'Invalid Pincode', 'status' => 'fail']);

        }

        $term = $request->pincode;

        $result = array();

        $queries2 = Allcity::where('pincode', 'LIKE', '%' . $term . '%')->get();

        foreach ($queries2 as $value) {

            $result[] = [
                'cityid' => $value->id,
                'cityname' => $value->name,
                'pincode' => $value->pincode,
                'stateid' => $value->state ? $value->state->id : null,
                'statename' => $value->state ? $value->state->name : null,
                'countryid' => $value->state->country ? $value->state->country->id : null,
                'countryname' => $value->state->country ? $value->state->country->nicename : null,
            ];

        }

        if (count($result) < 1) {
            return response()->json(
                [
                    'msg' => 'No result found !',
                    'status' => 'fail',
                ]
            );
        }

        return response()->json($result);

    }

    public function fetchPinCodeAddressForAuthUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pincode' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if ($errors->first('pincode')) {
                return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }
        }

        if (strlen($request->pincode) > 12) {

            return response()->json(['msg' => 'Invalid Pincode', 'status' => 'fail']);

        }

        $term = $request->pincode;

        $result = array();

        if (Auth::check()) {
            $queries = Address::where('user_id', Auth::user()
                    ->id)->where('pin_code', 'LIKE', '%' . $term . '%')->get();
        }

        $queries2 = Allcity::where('pincode', 'LIKE', '%' . $term . '%')->get();

        if (Auth::check()) {
            foreach ($queries as $value) {

                $address = strlen($value->address) > 100 ? substr($value->address, 0, 100) . "..." : $value->address;

                $result[] = [
                    'address' => $address,
                    'cityid' => $value->getcity->id,
                    'cityname' => $value->getcity->name,
                    'pincode' => $value->pin_code,
                    'stateid' => $value->getstate ? $value->getstate->id : null,
                    'statename' => $value->getstate ? $value->getstate->name : null,
                    'countryid' => $value->getstate->getCountry ? $value->getstate->getCountry->country->id : null,
                    'countryname' => $value->getstate->getCountry ? $value->getstate->getCountry->country->nicename : null,
                ];

            }
        }

        foreach ($queries2 as $value) {

            $result[] = [
                'cityid' => $value->id,
                'cityname' => $value->name,
                'pincode' => $value->pincode,
                'stateid' => $value->state ? $value->state->id : null,
                'statename' => $value->state ? $value->state->name : null,
                'countryid' => $value->state->country ? $value->state->country->id : null,
                'countryname' => $value->state->country ? $value->state->country->nicename : null,
            ];

        }

        if (count($result) < 1) {
            return response()->json(
                [
                    'msg' => 'No result found !',
                    'status' => 'fail',
                ]
            );
        }

        return response()->json($result);
    }

    public function listLanguages(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('secret')) {
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $languages = Language::orderBy('def','desc')->get();

        return response()->json(['languages' => $languages,'status' => 'success']);

    }

    public function myReviews(){

        $reviews = UserReview::where('status','1')->where('user',auth()->id())->get();

        $reviews = $reviews->transform(function($value){

            $user_count = count([$value]);
            $user_sub_total = 0;
            $user_review_t = $value->price * 5;
            $user_price_t = $value->price * 5;
            $user_value_t = $value->value * 5;
            $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;

            $user_count   = ($user_count * 3) * 5;
            $rat1         = $user_sub_total / $user_count;
            


            if(isset($value->pro)){

                $item['product_name'] = $value->pro->getTranslations('name');
                $item['review']       = $value->review;
                $item['rating']       = $rat1;

                return $item;

            }

            if(isset($value->simple_product)){

                $item['product_name'] = $value->simple_product->getTranslations('product_name');
                $item['review']       = $value->review;
                $item['rating']       = $rat1;

                return $item;

            }

        });

        return response()->json(['reviews' => $reviews,'status' => 'success'],200);

    }

    public function getTermPages($provider){

        if(!$provider){
            return response()->json(['msg' => 'Provider must be specified eg: tos, privacy']);
        }

        if($provider == 'tos'){

            $result = Page::where('slug','=','terms-condition')
                      ->orWhere('slug','=','tos')
                      ->orWhere('slug','=','termscondition')
                      ->orWhere('slug','=','termsconditions')
                      ->orWhere('slug','=','terms-conditions')
                      ->first();

            return response()->json($result);
        }

        if($provider == 'privacy'){

            $result = Page::where('slug','=','privacypolicy')
                      ->orWhere('slug','=','privacy-policy')
                      ->orWhere('slug','=','privacy')
                      ->first();

            return response()->json($result);

        }

        if($provider == 'user_term'){

            $result = TermsSettings::where('key','=','user-register-term')
                      ->first();

            return response()->json($result);

        }

        if($provider == 'seller_term'){

            $result = TermsSettings::where('key','=','seller-register-term')
                      ->first();

            return response()->json($result);

        }

        if($provider == 'about_us'){

            $result = Page::where('slug','=','about-us')
                      ->orWhere('slug','=','aboutus')
                      ->orWhere('slug','=','about')
                      ->orWhere('slug','=','about_us')
                      ->first();

            return response()->json($result);

        }

    }

}
