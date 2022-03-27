<?php
namespace App\Http\Controllers;

use App\Country;
use App\CurrencyNew;
use App\Genral;
use App\Seo;
use App\Store;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Hash;
use Illuminate\Http\Request;
use Image;
use Session;
use DotenvEditor;

class InstallerController extends Controller
{

    public function verifylicense()
    {
        $getstatus = @file_get_contents(public_path().'/step2.txt');
        $getstatus = Crypt::decrypt($getstatus);

        if ($getstatus == 'complete') {
            return view('install.verifylicense');
        } else {
            return redirect()->route('servercheck');
        }
    }

    public function verify()
    {

        if (env('IS_INSTALLED') == 0) {

            $getstatus = @file_get_contents(public_path().'/step2.txt');
            $getstatus = Crypt::decrypt($getstatus);

            if ($getstatus == 'complete') {
                return view('install.verify');
            } else {
                return redirect()->route('servercheck');
            }

        } else {
            return redirect('/');
        }

    }

    public function eula()
    {

        if (env('IS_INSTALLED') == 0) {
            $getdraft = @file_get_contents(public_path().'/draft.txt');
            if ($getdraft) {
                $getdraft = Crypt::decrypt($getdraft);

                if ($getdraft == 'gotoserverpage') {
                    return redirect()->route('servercheck');
                }

                if ($getdraft == 'gotoverifypage') {
                    return redirect()->route('verifyApp');
                }

                if ($getdraft == 'gotostep1') {
                    return redirect()->route('installApp');
                }

                if ($getdraft == 'gotostep2') {
                    return redirect()->route('get.step2');
                }

                if ($getdraft == 'gotostep3') {
                    return redirect()->route('get.step3');
                }

                if ($getdraft == 'gotostep4') {
                    return redirect()->route('get.step4');
                }

                if ($getdraft == 'gotostep5') {
                    return redirect()->route('get.step5');
                }
            }

            return view('install.eula');
        } else {
            return redirect('/');
        }

    }

    public function storeserver()
    {

        if (env('IS_INSTALLED') == 0) {
            $status = 'complete';
            $status = Crypt::encrypt($status);
            @file_put_contents(public_path().'/step2.txt', $status);

            $draft = 'gotoverifypage';
            $draft = Crypt::encrypt($draft);
            @file_put_contents(public_path().'/draft.txt', $draft);

            return redirect()->route('verifyApp');
        } else {
            return redirect('/');
        }

    }

    public function serverCheck(Request $request)
    {

        if (env('IS_INSTALLED') == 0) {
            $getstatus = @file_get_contents(public_path().'/step1.txt');
            $getstatus = Crypt::decrypt($getstatus);
            if ($getstatus == 'complete') {
                return view('install.servercheck');
            } else {
                return redirect()->route('eulaterm');
            }
        } else {
            return redirect('/');
        }
    }

    public function storeeula(Request $request)
    {

        if (isset($request->eula)) {

            $status = 'complete';
            $status = Crypt::encrypt($status);
            @file_put_contents(public_path().'/step1.txt', $status);

            $draft = 'gotoserverpage';
            $draft = Crypt::encrypt($draft);
            @file_put_contents(public_path().'/draft.txt', $draft);

            return redirect()->route('servercheck');

        } else {
            notify()->error(__('Please Accept Terms and conditions first !'));
            return back();
        }

    }

    public function index()
    {

        if (env('IS_INSTALLED') == 0) {
            $getstatus = @file_get_contents(public_path().'/step3.txt');
            $getstatus = Crypt::decrypt($getstatus);
            if ($getstatus == 'complete') {
                return view('install.index');
            }
        } else {
            return redirect('/');
        }
    }

    public function step1(Request $request)
    {

       
        $app_settings = DotenvEditor::setKeys([

            'APP_NAME'          => strip_tags($request->APP_NAME), 
            'APP_URL'           => $request->APP_URL, 
            'MAIL_FROM_NAME'    => $request->MAIL_FROM_NAME, 
            'MAIL_FROM_ADDRESS' => strip_tags($request->MAIL_FROM_ADDRESS), 
            'MAIL_DRIVER'       => $request->MAIL_DRIVER, 
            'MAIL_HOST'         => $request->MAIL_HOST, 
            'MAIL_PORT'         => $request->MAIL_PORT, 
            'MAIL_USERNAME'     => strip_tags($request->MAIL_USERNAME), 
            'MAIL_PASSWORD'     => strip_tags($request->MAIL_PASSWORD), 
            'MAIL_ENCRYPTION'   => $request->MAIL_ENCRYPTION

        ]);

        $app_settings->save();

        $status = 'complete';
        $status = Crypt::encrypt($status);
        @file_put_contents(public_path().'/step4.txt', $status);

        $draft = 'gotostep2';
        $draft = Crypt::encrypt($draft);
        @file_put_contents(public_path().'/draft.txt', $draft);
        
        return redirect()->route('get.step2');
        

    }

    public function getstep2()
    {

        if (env('IS_INSTALLED') == 0) {
            $getstatus = @file_get_contents(public_path().'/step4.txt');
            $getstatus = Crypt::decrypt($getstatus);

            if ($getstatus == 'complete') {
                return view('install.step2');
            } else {
                return redirect()
                    ->route('installApp');
            }
        } else {
            return redirect('/');
        }

    }

    public function step2(Request $request)
    {

        
        $db_details = DotenvEditor::setKeys([
            'DB_HOST'       => strip_tags($request->DB_HOST), 
            'DB_PORT'       => strip_tags($request->DB_PORT), 
            'DB_DATABASE'   => strip_tags($request->DB_DATABASE), 
            'DB_USERNAME'   => strip_tags($request->DB_USERNAME), 
            'DB_PASSWORD'   => strip_tags($request->DB_PASSWORD)
        ]);

        $db_details->save();
        
        $status = 'complete';
        $status = Crypt::encrypt($status);
        @file_put_contents(public_path().'/step5.txt', $status);

        $draft = 'gotostep3';
        $draft = Crypt::encrypt($draft);
        @file_put_contents(public_path().'/draft.txt', $draft);

        return redirect()->route('get.step3');

    }

    public function getstep3()
    {

        try
        {
            \DB::connection()
                ->getPdo();

            if (env('IS_INSTALLED') == 0) {

                if (!\Schema::hasTable('genrals')) {

                    Artisan::call('migrate');
                    Artisan::call('migrate --path=database/migrations/update1_3');
                    Artisan::call('migrate --path=database/migrations/update1_4');
                    Artisan::call('migrate --path=database/migrations/update1_5');
                    Artisan::call('migrate --path=database/migrations/update1_6');
                    Artisan::call('migrate --path=database/migrations/update1_7');
                    Artisan::call('migrate --path=database/migrations/update1_9');
                    Artisan::call('migrate --path=database/migrations/update2_0');
                    Artisan::call('migrate --path=database/migrations/update2_1');
                    Artisan::call('migrate --path=database/migrations/update2_2');
                    Artisan::call('migrate --path=database/migrations/update2_3');
                    Artisan::call('migrate --path=database/migrations/update2_4');
                    Artisan::call('migrate --path=database/migrations/update2_5');
                    Artisan::call('migrate --path=database/migrations/update2_6');
                    Artisan::call('migrate --path=database/migrations/update2_7');
                    Artisan::call('migrate --path=database/migrations/update2_8');
                    Artisan::call('migrate --path=database/migrations/update2_9');
                    Artisan::call('migrate --path=database/migrations/update3_0');
                    Artisan::call('migrate --path=database/migrations/update3_1');
                    Artisan::call('db:seed');

                }

                $getstatus = @file_get_contents(public_path().'/step5.txt');
                $getstatus = Crypt::decrypt($getstatus);

                if ($getstatus == 'complete') {
                    return view('install.step3');
                }

            } else {
                return redirect('/');
            }

        } catch (\Exception $e) {

            Artisan::call('db:wipe');

            notify()->error($e->getMessage(),$e->getCode());
            return redirect()->route('get.step2');

        }

    }

    public function storeStep3(Request $request)
    {

        $request->validate([
            'project_name' => 'required|string|max:255',
            'country' => 'required',
            'currency' => 'required|string|max:3|min:3'
        ]);

        Session::put('changed_language', 'en');

        // Store seo details
        $seo = Seo::first();

        $seo->project_name = $request->project_name;

        $seo->save();

        // store country
        $cn = Country::first();

        if (!isset($cn)) {
            $cntry = new Country;
            $cntry->country = $request->country;
            $cntry->save();
        } else {

            $cn->country = $request->country;
            $cn->save();
        }

       
        Artisan::call('currency:manage add ' . $request->currency);
        
        Artisan::call('currency:update -o');

        $currency = CurrencyNew::where('code',$request->currency)->first();

        $currency->currencyextract()->updateOrCreate([
            'id' => 1
        ],[
            'currency_id' => $currency->id,
            'add_amount' => 0.00,
            'currency_symbol' => $currency->code == 'USD' ? 'fa fa-dollar' : $request->currency_symbol,
            'default_currency' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'position' => 'l'
        ]);
        
        //Store genral settings
        $newGenral = Genral::first();
        $newGenral->project_name = $request->project_name;
        $newGenral->email = $request->email;
        $newGenral->currency_code = $request->code;

        $open_ex_key = DotenvEditor::setKeys([
            'OPEN_EXCHANGE_RATE_KEY' => ''
        ]);

        $open_ex_key->save();

        if ($file = $request->file('logo')) {
            if ($$newGenral->logo != null && file_exists(public_path() . '/images/genral/' . $newGenral->logo)) {
                unlink(public_path().'/images/genral/' . $newGenral->logo);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/genral/';
            $image = 'logo.' . $image->getClientOriginalExtension();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image);

            $newGenral->logo = $image;

        }

        if ($file = $request->file('favicon')) {

            if ($newGenral->fevicon != null && file_exists(public_path() . '/images/genral/' . $newGenral->fevicon)) {
                unlink(public_path().'/images/genral/' . $newGenral->fevicon);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/genral/';
            $image = 'fevicon.' . $image->getClientOriginalExtension();
            $optimizeImage->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 72);

            $newGenral->fevicon = $image;

        }

        $newGenral->save();

        $status = 'complete';
        $status = Crypt::encrypt($status);
        @file_put_contents(public_path().'/step6.txt', $status);

        $draft = 'gotostep4';
        $draft = Crypt::encrypt($draft);
        @file_put_contents(public_path().'/draft.txt', $draft);

        return redirect()->route('get.step4');

    }

    public function getstep4()
    {

        if (env('IS_INSTALLED') == 0) {
            $getstatus = @file_get_contents(public_path().'/step6.txt');
            $getstatus = Crypt::decrypt($getstatus);

            if ($getstatus == 'complete') {
                return view('install.step4');
            }

        } else {
            return redirect('/');
        }

    }

    public function storeStep4(Request $request)
    {

        $useralready = User::first();

        if (isset($useralready)) {

            User::query()->truncate();

        }

        $request->validate(['name' => 'required|string|max:255', 'email' => 'required|string|email|max:255|unique:users', 'password' => 'required|string|min:8|confirmed', 'password_confirmation' => 'required', 'profile_photo' => 'mimes:jpg,jpeg,png,bmp', 'country' => 'required', 'state_id' => 'required', 'city_id' => 'required']);

        $dir = 'images/user';
        $leave_files = array('index.php');

        foreach (glob("$dir/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                unlink($file);
            }
        }

        $user = new User;

        $user->name = strip_tags($request->name);
        $user->email = strip_tags($request->email);
        $user->role_id = 'a';
        $user->password = Hash::make(strip_tags($request->password));
        $user->country_id = $request->country;
        $user->state_id = $request->state_id;
        $user->city_id = $request->city_id;

        if ($file = $request->file('profile_photo')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/user/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image);

            $user->image = $image;

        }

        $user->save();

        $user->assignRole('Super Admin');

        $status = 'complete';
        $status = Crypt::encrypt($status);
        @file_put_contents(public_path().'/step7.txt', $status);

        $draft = 'gotostep5';
        $draft = Crypt::encrypt($draft);
        @file_put_contents(public_path().'/draft.txt', $draft);

        return redirect()->route('get.step5');

    }

    public function getstep5()
    {

        if (env('IS_INSTALLED') == 0) {
            $getstatus = @file_get_contents(public_path().'/step6.txt');
            $getstatus = Crypt::decrypt($getstatus);

            if ($getstatus == 'complete') {
                return view('install.step5');
            }
        } else {
            return redirect('/');
        }

    }

    public function storeStep5(Request $request)
    {

        $store = Store::first();

        if (isset($store)) {
            Store::query()->truncate();
        }

        $request->validate(['storelogo' => 'mimes:jpg,jpeg,png,bmp']);

        $dir = 'images/store';
        $leave_files = array('index.php');

        foreach (glob("$dir/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $newStore = new Store;
        $newStore->name = $request->store_name;
        $newStore->mobile = $request->mobile;
        $newStore->email = $request->email;
        $newStore->address = $request->address;
        $newStore->user_id = User::first()->id;
        $newStore->pin_code = $request->pincode;
        $newStore->country_id = $request->country_id;
        $newStore->state_id = $request->state_id;
        $newStore->city_id = $request->city_id;
        $newStore->pin_code = $request->pincode;
        $newStore->status = '1';
        $newStore->verified_store = '1';
        $newStore->apply_vender = '1';
        $newStore->uuid = Store::generateUUID();
        
        if ($file = $request->file('storelogo')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/store/';
            $image = time() . $file->getClientOriginalName();

            $optimizeImage->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $image);

            $newStore->store_logo = $image;

        }

        $newStore->save();

        $apistatus = $this->update_status('1');

        if ($apistatus == 1) {

            $install_done = DotenvEditor::setKeys([
                'IS_INSTALLED' => '1',
                'APP_DEBUG' => 'false'
            ]);

            $install_done->save();

            Artisan::call('cache:clear');
            Artisan::call('view:clear');

        } else {

            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            notify()->error(__('Oops Please try again !'));
            return redirect()->route('get.step5')->withInput();

        }

        Session::flush();

        $remove_step_files = array('step1.txt', 'step2.txt', 'step3.txt', 'step4.txt', 'step5.txt', 'step6.txt', 'step7.txt', 'draft.txt');

        foreach ($remove_step_files as $key => $file) {

            unlink(public_path(). '/' . $file);

        }

        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        return redirect('/');

    }

    public function update_status($status)
    {
		return 1;
    }

    

}
