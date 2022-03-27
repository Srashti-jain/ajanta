<?php

namespace App\Http\Controllers;

use App\Allcity;
use App\Allstate;
use App\City;
use App\Country;
use App\Mail\StoreCreated;
use App\Order;
use App\State;
use App\Store;
use App\User;
use Avatar;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Image;



class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        abort_if(!auth()->user()->can('stores.view'),403,__('User does not have the right permissions.'));

        $stores = Store::leftjoin('allcities', function ($join) {
            $join->on('allcities.id', '=', 'stores.city_id');
        })
            ->leftjoin('allstates', function ($join) {
                $join->on('stores.state_id', '=', 'allstates.id');
            })
            ->leftjoin('allcountry', function ($join) {
                $join->on('allcountry.id', '=', 'stores.country_id');
            })
            ->join('users', 'users.id', '=', 'stores.user_id')
            ->select('stores.*', 'allcities.name as city', 'allstates.name as state', 'allcountry.name as country', 'users.name as username')->get();

        if ($request->ajax()) {
            return DataTables::of($stores)
                ->addIndexColumn()
                ->addColumn('logo', function ($row) {
                    $image = @file_get_contents(public_path().'/images/store/' . $row->store_logo);
                    if ($image) {
                        $logo = '<img style="object-fit:scale-down;" width="70px" height="70px" src="' . url("images/store/" . $row->store_logo) . '"/>';
                    } else {
                        $logo = '<img width="70px" height="70px" src="' . Avatar::create($row->name)->toBase64() . '"/>';
                    }

                    return $logo;

                })
                ->addColumn('info', function ($store) {

                    $html = '<p><b>'.__('Name:').'</b> <span class="font-weight500">' . $store->name . '</span></p>';
                    $html .= '<p><b>'.__('Email').':</b> <span class="font-weight500">' . $store->email . '</span></p>';
                    $html .= '<p><b>'.__('Mobile').':</b> <span class="font-weight500">' . $store->mobile . '</span></p>';
                    $html .= '<p><b>'.__("Address").':</b> <span class="font-weight500">' . $store->address . ' ,' . $store->city . ' ,' . $store->state . ' ,' . $store->country . '</p>';

                    if ($store->verified_store == 1) {
                        $html .= '<p><b>'.__('Verfied Store').': </b> <span class="badge badge-pill badge-success"><i class="fa fa-check-circle"></i> '.__('Verified').'</span></p>';
                    } else {
                        $html .= '<p><b>'.__('Verified Store').' : </b> <span class="badge badge-pill badge-danger">'.__('Not Verified').'</span></p>';
                    }
                   
                    return $html;

                })
                ->editColumn('status', 'admin.store.status')
                ->editColumn('apply', 'admin.store.applybtn')
                ->addColumn('rd', function ($store) {
                    if ($store->rd == '0') {
                        $btn = '<span class="badge badge-pill badge-success">'.__("Not Received").'</span>';
                    } else {
                        $btn = '<span class="badge badge-pill badge-danger">'.__('Received').'</span>';
                    }

                    return $btn;
                })
                ->editColumn('action', 'admin.store.action')
                ->rawColumns(['logo', 'info', 'status', 'apply', 'rd', 'action'])
                ->make(true);

        }

        return view("admin.store.index", compact("stores"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('stores.create'),403,__('User does not have the right permissions.'));
        $countrys = Country::all();
        $states = State::all();
        $citys = City::all();
        $users = User::where('status', '1')->get();
        return view("admin.store.add", compact("states", "countrys", "citys", "users"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        abort_if(!auth()->user()->can('stores.create'),403,__('User does not have the right permissions.'));
        $data = $this->validate($request, [
            "name" => "required",
            "mobile" => "required",
            'address' => "required",
            'country_id' => 'required|not_in:0',
            'state_id' => 'required|not_in:0',
            'city_id' => 'required|not_in:0',
            'store_logo' => 'mimes:jpeg,jpg,webp,png|max:2000',
            "email" => "required|unique:stores,email|email|max:255",

        ], [
            "name.required" => __("Store name is required"),
            "email.required" => __("Business email is required"),
            "mobile.required" => __("Mobile no is required"),

        ]);

        $validateuser = User::find($request->user_id);

        if ($validateuser->store) {
            notify()->error(__('User already have a store !'));
            return back()->withInput();
        }

        $input = $request->all();

        if ($file = $request->file('store_logo')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/';
            $store_logo = time() . $file->getClientOriginalName();
            $optimizeImage->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $store_logo, 90);

            $input['store_logo'] = $store_logo;

        }

        if ($file = $request->file('cover_photo')) {

            if(!is_dir(public_path().'/images/store/cover_photo')){
                mkdir(public_path().'/images/store/cover_photo');
            }   
            
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/cover_photo/';
            $name = 'cover_'.uniqid() .'.'.$file->getClientOriginalExtension();

            $optimizeImage->resize(1500, 440, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $name, 90);
            $input['cover_photo'] = $name;

        }

        $input['status'] = isset($request->status) ? '1' : '0';
        $input['verified_store'] = isset($request->verified_store) ? '1' : '0';
        $input['apply_vender'] = '1';
        $input['uuid']  = Store::generateUUID();

        $store =  Store::create($input);

        $validateuser->role_id = 'v';

        $validateuser->syncRoles('Seller');

        $validateuser->save();

        // Send mail to store owner for store created 

        try{

            if(isset($store->user->email)){
                Mail::to($store->user->email)->send(new StoreCreated($store));
            }

        }catch(\Exception $e){
            \Log::error('Failed to sent email to store owner:'.$e->getMessage());
        }
        notify()->success(__('Store created !'),$store->name);
        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        abort_if(!auth()->user()->can('stores.view'),403,__('User does not have the right permissions.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('stores.edit'),403,__('User does not have the right permissions.'));
        $countrys = Country::all();
        $citys = Allcity::all();
        $users = User::where('role_id', 'v')->orWhere('role_id', 'a')->get();
        $store = Store::find($id);
        $states = Allstate::where('country_id', $store->country_id)->get();
        $citys = Allcity::where('state_id', $store->state_id)->get();

        $getallorder = Order::select('id', 'vender_ids')->get();
        $storeorder = array();
        foreach ($getallorder as $order) {
            if (in_array($store->user->id, $order->vender_ids)) {
                array_push($storeorder, $order);
            }
        }

        $storeordercount = count($storeorder);

        return view("admin.store.edit", compact("store", "countrys", "states", "citys", "users", 'storeordercount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        abort_if(!auth()->user()->can('stores.edit'),403,__('User does not have the right permissions.'));
        $store = Store::find($id);

        

        $this->validate($request, [
            "name" => "required",
            "mobile" => "required",
            'address' => "required",
            'country_id' => 'required|not_in:0',
            'state_id' => 'required|not_in:0',
            'city_id' => 'required|not_in:0',
            'store_logo' => 'mimes:jpeg,jpg,webp,png|max:2000',
            "email" => "required|email|max:255,unique:stores,email,$id",

        ], [
            "name.required" => __("Store name is required"),
            "email.required" => __("Business email is required"),
            "mobile.required" => __("Mobile no is required"),

        ]);

        $store = Store::find($id);

        if(!$store) {
            notify()->error(__('Store Not found !'),'404');
            return back();
        }

        $input = $request->all();

        if ($file = $request->file('store_logo')) {

            if ($store->store_logo != null) {

                if (file_exists(public_path() . '/images/store/' . $store->store_logo)) {
                    unlink(public_path() . '/images/store/' . $store->store_logo);
                }

            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/';
            $name = time() . $file->getClientOriginalName();
            $optimizeImage->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $name, 90);
            $input['store_logo'] = $name;

        }

        if ($file = $request->file('cover_photo')) {

            if(!is_dir(public_path().'/images/store/cover_photo')){
                mkdir(public_path().'/images/store/cover_photo');
            }   

            if ($store->cover_photo != null) {

                if (file_exists(public_path() . '/images/store/cover_photo/' . $store->cover_photo)) {
                    unlink(public_path() . '/images/store/cover_photo/' . $store->cover_photo);
                }

            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/cover_photo/';
            $name = 'cover_'.uniqid() .'.'.$file->getClientOriginalExtension();
            $optimizeImage->resize(1500, 440, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $name, 90);
            $input['cover_photo'] = $name;

        }

        $input['status'] = isset($request->status) ? "1" : "0";
        $input['verified_store'] = isset($request->verified_store) ? '1' : '0';
        $input['apply_vender'] = '1';
        $input['description'] = $request->description;

        if($store->uuid == ''){
            $input['uuid']  = Store::generateUUID();
        }
        
        $input['show_google_reviews'] = $request->show_google_reviews ? 1 : 0;
        $store->update($input);

        notify()->success(__('Store has been updated !'),$store->name);

        return redirect('admin/stores');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('stores.delete'),403,__('User does not have the right permissions.'));

        $store = Store::find($id);

        if ($store) {

            if ($store->logo != '' && file_exists(public_path() . '/images/store/' . $store->store_logo)) {
                unlink(public_path() . '/images/store/' . $store->store_logo);
            }

            if ($store->document != '' && file_exists(public_path() . '/images/store/document' . $store->document)) {
                unlink(public_path() . '/images/store/document' . $store->document);
            }

            $store->user()->update([
                'role_id' => 'u'
            ]);

            $store->user->syncRoles('Customer');

            $store->forcedelete();
            
            notify()->success(__('Store has been updated !'));
            return back();
             
        } else {
            notify()->error(__('Store Not found !'),'404');
            return back();
        }
    }
}
