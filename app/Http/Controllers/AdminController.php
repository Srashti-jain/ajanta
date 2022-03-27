<?php
namespace App\Http\Controllers;

use App\CanceledOrders;
use App\Category;
use App\Charts\AdminUserChart;
use App\Charts\AdminUserPieChart;
use App\Charts\OrderChart;
use App\Coupan;
use App\DashboardSetting;
use App\Faq;
use App\FullOrderCancelLog;
use App\Genral;
use App\Hotdeal;
use App\Http\Controllers\Api\MainController;
use App\Invoice;
use App\multiCurrency;
use App\Order;
use App\PendingPayout;
use App\Product;
use App\SellerPayout;
use App\SpecialOffer;
use App\Store;
use App\Testimonial;
use App\User;
use App\VisitorChart;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use PDF;
use App\SimpleProduct;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function user_read()
    {
        auth()->user()
            ->unreadNotifications
            ->where('n_type', '=', 'user')
            ->markAsRead();
        return redirect()
            ->back();
    }

    public function order_read()
    {
        auth()
            ->user()
            ->unreadNotifications
            ->where('n_type', '=', 'order_v')
            ->markAsRead();
        return redirect()
            ->back();
    }

    public function ticket_read()
    {
        auth()
            ->user()
            ->unreadNotifications
            ->where('n_type', '=', 'ticket')
            ->markAsRead();
        return redirect()
            ->back();
    }

    public function all_read()
    {
        auth()
            ->user()
            ->unreadNotifications
            ->where('n_type', '!=', 'order_v')
            ->markAsRead();
        return redirect()
            ->back();
    }

    public function index()
    {
        Artisan::call('inspire');

        $quote = Artisan::output();

        $time = date("H");

        date_default_timezone_set(config('app.timezone'));

        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "12") {
            $day = __("Good morning");
        } else
        /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        if ($time >= "12" && $time < "17") {
            $day = __("Good afternoon");
        } else
        /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        if ($time >= "17" && $time < "19") {
            $day  = __("Good evening");
        } else
        /* Finally, show good night if the time is greater than or equal to 1900 hours */
        if ($time >= "19") {
            $day =  __("Good night");
        }

        $lang = Session::get('changed_language');

        $totalproducts = Product::whereHas('category')->whereHas('subvariants')->whereHas('subcategory')->whereHas('brand')->whereHas('store')->whereHas('vender')->count();

        $totalproducts = $totalproducts + SimpleProduct::count();

        $order = Order::with(['user','invoices'])->whereHas('invoices')->whereHas('user')->where('status', '=', '1')->count();

        $usersquery = User::query();

        $user = $usersquery->count();

        $store = Store::count();

        $coupan = Coupan::count();

        $faqs = Faq::count();

        $category = Category::count();

        $cancelorder = CanceledOrders::whereHas('user')->whereHas('order')->whereHas('singleOrder')->count();

        $fcanorder = FullOrderCancelLog::whereHas('user')->whereHas('getorderinfo')->count();

        $totalcancelorder = $fcanorder + $cancelorder;

        $total_testinonials = Testimonial::where('status', '=', '1')->count();


        $total_hotdeals = Hotdeal::whereHas('pro',function($query){
            return $query->where('status','1');
        })->where('status', '=', '1')->count();

        $total_specialoffer = SpecialOffer::whereHas('pro',function($query){
            return $query->where('status','1');
        })->where('status', '=', '1')->count();

        
        $inv_cus = Invoice::first();
        $setting = Genral::first();
        $totalsellers = $usersquery->where('role_id', '=', 'v')->where('status', '=', '1')->count();
        $dashsetting = DashboardSetting::first();

        $get_product_data = new MainController;

        $default_currency = multiCurrency::with('currency')->where('default_currency', '=', 1)->first();

        $products = Product::whereHas('category')
                    ->whereHas('subvariants')
                    ->whereHas('subcategory')
                    ->whereHas('brand')
                    ->whereHas('store')
                    ->whereHas('vender')
                    ->latest()
                    ->take($dashsetting->max_item_pro)
                    ->get()
                    ->map(function($product) use($get_product_data,$default_currency) {

                        $price = $get_product_data->getprice($product, $product->subvariants[0])->getData();

                        $price = $price->offerprice != 0 ? $price->offerprice : $price->mainprice;

                        $content['productname'] = $product->name;
                        $content['detail']      = strip_tags($product->des);
                        $content['producturl']  = $product->getURL($product->subvariants[0]);
                        $content['thumbnail']   = url('variantimages/thumbnails/' . $product->subvariants[0]->variantimages->main_image);
                        $content['price']       = $price;
                        $content['price_in']    = (string) $default_currency->currency->code;

                        return $content;
                        
                    });

        
        $simple_products = SimpleProduct::whereHas('category')
                            ->whereHas('subcategory')
                            ->whereHas('brand')
                            ->whereHas('store')
                            ->whereHas('store.user')
                            ->latest()
                            ->take($dashsetting->max_item_pro)
                            ->get()
                            ->map(function($product) use($default_currency) {

                                $content['productname'] = (string) $product->product_name;
                                $content['detail']      = (string) strip_tags($product->product_detail);
                                $content['producturl']  = route('show.product',['id' => $product->id, 'slug' => $product->slug]);
                                $content['thumbnail']   = url('/images/simple_products/'.$product->thumbnail);
                                $content['price']       = (float) $product->actual_offer_price ? $product->actual_offer_price : $product->actual_selling_price;
                                $content['price_in']    = (string) $default_currency->currency->code;
        
                                return $content;
                                
                            });
        
        if(count($simple_products)){
            
            $products = $products->toBase()->merge($simple_products)->filter()->sortBy('productname');

        }


        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)",
        ];

        /*Creating Userbarchart*/

        $months = [__('January'), __('February'), __('March'), __('April'), __('May'), __('June'), __('July'), __('August'), __('September'), __('October'), __('November'), __('December')];

        $userdata = collect();

        $users = User::select(DB::raw('DATE_FORMAT(created_at, "%M") as month'), DB::raw('count(*) as count'))->where('status','1')
        ->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->get()
        ->map(function($item) use($months,$userdata) {
              
          
            if(in_array($item->month,$months)){
                $userdata->push($item->count);
            }else{
                $userdata->push(0);
            }
            

            return $item;

        });
       

        $userchart = new AdminUserChart;

        $userchart->labels($months);

        $userchart->title(__('Monthly Registered Users in :year',['year' => date('Y')]))->dataset(__('Monthly Registered Users'), 'bar', $userdata)->options([

            'fill' => 'true',
            'shadow' => 'true',
            'borderWidth' => '1',
            
        ])->backgroundColor($fillColors)->color($fillColors);

        /*END*/

        /*Creating order chart*/

        $totalorder = Order::select(DB::raw('DATE_FORMAT(created_at, "%M") as month'), DB::raw('count(*) as count'))
        ->where('status','1')
        ->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("MONTH(created_at)"))
        ->groupBy(DB::raw("YEAR(created_at)"))
        ->get()
        ->map(function($item){
            
            return $item;

        });
       
        $orderchart = new OrderChart;

        $orderchart->labels($totalorder->pluck('month'));

        $orderchart->title(__('Total Orders in :year',['year' => date('Y')]))->label(__('Sales'))->dataset(__('Total Sale'), 'area', $totalorder->pluck('count'))->options([
            'fill' => 'true',
            'fillColor' => 'rgba(77, 150, 218, 0.8)',
            'color' => '#4d96da',
            'shadow' => true,
        ]);

        /*END*/

        /*Creating Piechart of user */

        $piechart = new AdminUserPieChart;

        $roles = Role::pluck('name')->all();

        $piedata = collect();

        foreach($roles as $role){

            $piedata->push([
                'roles' => $role,
                'count' => User::role($role)->count()
            ]);

        }

        $fillColors2 = ['#fc0390','#7158e2','#5de258','#ff3300','#3ae3e0'];

        $piechart->labels($piedata->pluck('roles'));

        $piechart->minimalist(true);

        $piechart->title(__('User Distribution'))->dataset(__('User Distribution'), 'pie', $piedata->pluck('count'))->options([
            'fill' => 'true',
            'shadow' => true,
        ])->color($fillColors2);

        /*End Piechart for user*/

        $pending_payout = 0;

        if ($setting->vendor_enable == 1) {


            $pending_payout = PendingPayout::whereHas('singleorder')->count();
        

        }
        
        $latestorders = Order::whereHas('invoices')->whereHas('user')->with(['user' => function($q){
                return $q->select('id','name');
        }])->latest()->take($dashsetting->max_item_ord)->get();

        $storerequest = Store::with(['user' => function($q){
            return $q->select('id','name as owner','email as useremail');
        }])->whereHas('user',function($q){
            return $q->where('status','1');
        })->where('stores.apply_vender', '=', '0')->select('stores.email as email', 'stores.name as name')->take($dashsetting->max_item_str)->get();

        $registerTodayUsers = User::whereDate('created_at',date('Y-m-d'))->count();


        return view("admin.dashbord.index", compact('time','day','quote','total_hotdeals', 'total_specialoffer', 'total_testinonials', 'totalsellers', 'latestorders', 'products', 'order', 'user', 'store', 'coupan', 'category', 'totalcancelorder', 'faqs', 'inv_cus', 'userchart', 'piechart', 'orderchart', 'storerequest','registerTodayUsers','totalproducts','pending_payout'));
    }

    public function user()
    {
        $users = User::all();

        return view("admin.user.show", compact("users"));
    }

    public function order_print($id)
    {
        $invpre = Invoice::first();
        $order = order::where('id', $id)->first();

        $pdf = PDF::loadView('admin.print.pdfView', compact('order', 'invpre'));

        return $pdf->setPaper('a4', 'landscape')
            ->download('invoice.pdf');
    }

    public function single(Request $request)
    {
        $a = isset($request['id1']) ? $request['id1'] : 'not yet';

        $userUnreadNotification = auth()->user()
            ->unreadNotifications
            ->where('id', $a)->first();

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return response()->json(['status' => 'success']);
        }

    }

    public function visitorData(Request $request)
    {

        if($request->ajax()){
            $data = VisitorChart::select(\DB::raw('SUM(visit_count) as count'), 'country_code')
            ->groupBy('country_code')
            ->get();

            

            $result = array();

            foreach ($data as $key => $value) {
                $result[$value->country_code] = $value->count;
            }

            return response()->json($result);
        }
       

    }

}