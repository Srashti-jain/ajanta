<?php

namespace App\Http\Controllers;

use App\Allcity;
use App\Allcountry;
use App\Allstate;
use App\CurrencyNew;
use App\Genral;
use Modules\SellerSubscription\Http\Controllers\Subs\PaymentController;
use Modules\SellerSubscription\Models\SellerPlans;
use App\User;
use Avatar;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use Nwidart\Modules\Facades\Module;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->wallet_system = Genral::first()->wallet_enable;
    }

    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('users.view'), 403, __('User does not have the right permissions.'));

        if (!$request->roles) {
            $users = User::where('id', '!=', auth()->id())->with('roles');
        } else {
            if ($request->roles != 'all') {
                $users = User::where('id', '!=', auth()->id())->role($request->roles);
            } else {
                $users = User::where('id', '!=', auth()->id())->with('roles');
            }
        }

        if ($request->ajax()) {
            return DataTables::of($users)

                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image != '' && file_exists(public_path() . '/images/user/' . $row->image)) {

                        $image = "<img title='" . str_replace('"', '', $row->name) . "' class='pro-img' src='" . url('/images/user/' . $row->image) . "' alt='" . $row->name . "'>";

                    } else {

                        $image = '<img class="pro-img" src="' . Avatar::create($row->name)->toBase64() . '"/>';

                    }

                    return $image;
                })
                ->addColumn('role', function ($row) {

                    foreach ($row->getRoleNames() as $role) {
                        return "<p>$role</p>";
                    }

                })
                ->editColumn('loginas', 'admin.user.loginas')
                ->addColumn('created_at', function ($row) {
                    $datetime = date('d-m-Y h:i A', strtotime($row->created_at));
                    return "<p>$datetime</p>";
                })
                ->editColumn('action', 'admin.user.action')
                ->rawColumns(['image', 'role', 'loginas', 'created_at', 'action'])
                ->make(true);
        }

        $roles = Role::get();

        return view("admin.user.show", compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        abort_if(!auth()->user()->can('users.create'), 403, __('User does not have the right permissions.'));

        $roles = Role::get();

        $country = Allcountry::join('countries', 'countries.country', '=', 'allcountry.iso3')->select('allcountry.*')->get();
        return view("admin.user.add_user", compact('country', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        abort_if(!auth()->user()->can('users.create'), 403, __('User does not have the right permissions.'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'image' => 'mimes:jpeg,jpg,png,bmp,gif',
        ]);

        $input = $request->all();

        $u = new User;

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/user/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image);

            $input['image'] = $image;

            $input['password'] = Hash::make($request->password);

        }

        $input['password'] = Hash::make($request->password);

        if ($request->role == 'Seller') {
            $input['role_id'] = 'v';
        } elseif ($request->role == 'Customer') {
            $input['role_id'] = 'c';
        } elseif ($request->role == 'Blocked') {
            $input['role_id'] = 'c';
        } else {
            $input['role_id'] = 'a';
        }

        $user = $u->create($input);

        $user->assignRole($request->role);

        notify()->success(__('User added !'), $request->name);

        return back();
    }

    public function edit($id)
    {
        abort_if(!auth()->user()->can('users.edit'), 403, __('User does not have the right permissions.'));
        $user = User::findOrFail($id);
        $country = Allcountry::join('countries', 'countries.country', '=', 'allcountry.iso3')->select('allcountry.*')->get();
        $states = Allstate::where('country_id', $user->country_id)->get();
        $citys = Allcity::where('state_id', $user->state_id)->get();
        
        $roles = Role::get();

        $plans = NULL;

        if(in_array('Seller', auth()->user()->getRoleNames()->toArray()) && Module::has('SellerSubscription') && Module::find('sellersubscription')->isEnabled()){
            $plans = SellerPlans::where('status', '1')->get();
        }

        return view("admin.user.edit", compact("country", "user", "states", "citys", "plans", "roles"));

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

        abort_if(!auth()->user()->can('users.edit'), 403, __('User does not have the right permissions.'));

        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'image' => 'mimes:jpeg,jpg,png,bmp,gif',
        ]);

        $input = $request->all();

        if (isset($request->is_pass_change)) {

            $this->validate($request, [
                'password' => 'required|between:6,255|confirmed',
                'password_confirmation' => 'required',
            ]);
            
            $newpass = Hash::make($request->password);
            $input['password'] = $newpass;

        } else {
            $input['password'] = $user->password;
        }

        if ($file = $request->file('image')) {

            if ($user->image != '' && file_exists(public_path() . '/images/user/' . $user->image)) {
                unlink(public_path() . '/images/user/' . $user->image);
            }

            $optimizeImage = Image::make($request->file('image'));
            $optimizePath = public_path() . '/images/user/';
            $name = time() . $file->getClientOriginalName();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $name, 72);
            $input['image'] = $name;

        }

        if (isset($request->wallet_status) && isset($user->wallet)) {
            $user->wallet()->update(['status' => '1']);
        } else {
            $user->wallet()->update(['status' => '0']);
        }

        if (Module::has('SellerSubscription') && Module::find('sellersubscription')->isEnabled()) {

            $defaultCurrency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract', function ($query) {

                return $query->where('default_currency', '1');

            })->first();

            if ($request->seller_plan) {

                $plan = SellerPlans::find($request->seller_plan);

                if ($user->activeSubscription) {
                    if ($user->activeSubscription->plan->id != $plan->id) {

                        if ($plan) {

                            $txn_id = str_random(10);

                            $subs = new PaymentController;

                            $payment = $subs->createsubscription($plan, $txn_id, $paidamount = $plan->price, $method = 'By Admin', $user, $currency = $defaultCurrency->code);

                            $input['subs_id'] = $payment->id;

                        }
                    }
                } else {
                    if ($plan) {

                        $txn_id = str_random(10);

                        $subs = new PaymentController;

                        $payment = $subs->createsubscription($plan, $txn_id, $paidamount = $plan->price, $method = 'By Admin', $user, $currency = $defaultCurrency->code);

                        $input['subs_id'] = $payment->id;

                    }
                }

            }

        }

        if ($request->role == 'Seller') {
            $input['role_id'] = 'v';
        } elseif ($request->role == 'Customer') {
            $input['role_id'] = 'c';
        } elseif ($request->role == 'Blocked') {
            $input['role_id'] = 'c';
        } elseif ($request->role == 'Blocked') {
            $input['role_id'] = 'c';
        } else {
            $input['role_id'] = 'a';
        }

        $user->update($input);

        $user->syncRoles($request->role);

        notify()->success(__('details has been updated'), $user->name);

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('users.delete'), 403, __('User does not have the right permissions.'));

        $user = User::find($id);

        if ($user->image != null && file_exists(public_path() . '/images/user/' . $user->image)) {
            unlink(public_path() . '/images/user/' . $user->image);
        }

        if ($this->wallet_system == 1 && isset($user->wallet)) {

            $user->wallet->wallethistory()->delete();
            $user->wallet->delete();

        }

        $user->roles()->detach();

        $value = $user->delete();

        if ($value) {
            notify()->error(__("User has been deleted !"));
            return back();
        }
    }

    public function appliedform(Request $request)
    {

        abort_if(!auth()->user()->can('stores.accept.request'), 403, __('User does not have the right permissions.'));

        $stores = \DB::table('stores')->join('allcities', 'allcities.id', '=', 'stores.city_id')->join('allstates', 'stores.state_id', '=', 'allstates.id')->join('allcountry', 'allcountry.id', '=', 'stores.country_id')->join('users', 'users.id', '=', 'stores.user_id')->select('stores.*', 'allcities.pincode as pincode', 'allcities.name as city', 'allstates.name as state', 'allcountry.name as country', 'users.name as username')->where('stores.apply_vender', '=', '0')->get();

        if ($request->ajax()) {
            return FacadesDataTables::of($stores)->addIndexColumn()
                ->addColumn('detail', function ($row) {
                    $html = '';
                    $html .= "<p><b>".__('Store Name').":</b> $row->name</p>";
                    $html .= "<p><b>".__('Requested By').":</b> $row->username</p>";
                    $html .= "<p><b>".__('Address').":</b> $row->address,</p>";
                    $html .= "<p><b>".__('Store Location')."</b> $row->city, $row->state, $row->country</p>";
                    if ($row->pincode) {
                        $html .= "<p><b>".__("Pincode").":</b> $row->pincode</p>";
                    } else {
                        $html .= "<p><b>".__("Pincode").":</b> - </p>";
                    }

                    return $html;
                })
                ->addColumn('document', function ($row) {
                    return '<a target="__blank" href="' . url('/images/store/document/' . $row->document) . '" title="Download document">'.__("View attachment").'</a>';
                })
                ->addColumn('requested_at', function ($row) {
                    return '<b>' . date("d-M-Y | h:i A", strtotime($row->created_at)) . '</b>';
                })
                ->addColumn('action', 'admin.user.requestaction')
                ->rawColumns(['detail', 'document', 'requested_at', 'action'])
                ->make(true);
        }

        return view("admin.user.appliyed_vender")->withList(count($stores));
    }

    public function choose_country(Request $request)
    {

        $id = $request['catId'];

        $country = Allcountry::findOrFail($id);
        $upload = Allstate::where('country_id', $id)->pluck('name', 'id')->all();

        return response()->json($upload);
    }

    public function choose_city(Request $request)
    {

        $id = $request['catId'];

        $state = Allstate::findOrFail($id);
        $upload = Allcity::where('state_id', $id)->pluck('name', 'id')->all();

        return response()->json($upload);
    }

}
