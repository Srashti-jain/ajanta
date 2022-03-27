<?php

namespace App\Http\Controllers;

use App\Affilate;
use App\CurrencyCheckout;
use App\CurrencyList;
use App\CurrencyNew;
use App\Location;
use App\multiCurrency;
use App\OfferPopup;
use App\PWASetting;
use App\User;
use DotenvEditor;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use ZipArchive;

class OtaUpdateController extends Controller
{
    use ThrottlesLogins;

    protected $maxAttempts = 3;
    protected $decayMinutes = 1;

    public function update(Request $request)
    {

        if (config('app.version') == '1.3') {

            $output = Artisan::call('migrate --path=database/migrations/update1_3');

            $op2 = Artisan::call('migrate');

            $listofcurrency = multiCurrency::all();

            $currency = array();

            foreach ($listofcurrency as $cur) {
                array_push($currency, $cur->currency->code);
            }

            Artisan::call('currency:manage add USD');

            if (in_array('USD', $currency)) {

                foreach ($currency as $c) {
                    Artisan::call('currency:manage add ' . $c);
                }

            } else {

                foreach ($currency as $c) {

                    Artisan::call('currency:manage add ' . $c);
                }

            }

            $cur = Artisan::call('currency:update -o');

            if (strstr(env('OPEN_EXCHANGE_RATE_KEY'), '11f0cdf')) {

                $env_keys_save = DotenvEditor::setKeys([
                    'OPEN_EXCHANGE_RATE_KEY' => '',
                ]);

                $env_keys_save->save();

            }

            $new_keys = DotenvEditor::setKeys([

                'NOCAPTCHA_SITEKEY'         => '',
                'NOCAPTCHA_SECRET'          => '',
                'PAYSTACK_PUBLIC_KEY'       => '',
                'PAYSTACK_SECRET_KEY'       => '',
                'PAYSTACK_PAYMENT_URL'      => 'https://api.paystack.co',
                'MERCHANT_EMAIL'            => '',
                'OPEN_EXCHANGE_RATE_KEY'    => '',
                'MESSENGER_CHAT_BUBBLE_URL' => ''

            ]);

            $new_keys->save();
        }

        /** version 1.4 Code */

        if (config('app.version') == '1.4') {

            $this->updateToVersion1_4();

        }

        /** version 1.5 Code */
        $this->updateToVersion1_5();

        /** version 1.6 Code */
        $this->updateToVersion1_6();

        /** version 1.7 Code */
        $this->updateToVersion1_7();

        /** version 1.8 code */

        $this->updateToVersion1_8();

        /** version 1.9 code */

        $this->updateToVersion1_9();

        /** version 2.0 code */

        $this->updateToVersion2_0();

        /** version 2.1 code */

        $this->updateToVersion2_1();

        /** version 2.2 code */

        $this->updateToVersion2_2();

        /** Verion 2.3 code */

        $this->updateToVersion2_3();

        /** Verion 2.4 code */

        $this->updateToVersion2_4();

        /** Verion 2.5 code */

        $this->updateToVersion2_5();

        /** Verion 2.6 code */

        $this->updateToVersion2_6();

        /** Verion 2.7 code */

        $this->updateToVersion2_7();

        /** Verion 2.8 code */

        $this->updateToVersion2_8();

        /** Verion 2.9 code */

        $this->updateToVersion2_9();

        /** Verion 3.0 code */

        $this->updateToVersion3_0();

        /** Verion 3.0 code */

        $this->updateToVersion3_1();

        /** Wrap up */

        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        notify()->success(__('Updated to version :version successfully',['version' => config('app.version')]),__('Version :version',['version' => config('app.version')]));

        return redirect('/');

    }

    public function updateToVersion1_4()
    {

        Artisan::call('migrate --path=database/migrations/update1_4');

        $output = Artisan::output();

        foreach (multiCurrency::all() as $currency) {

            $r = CurrencyList::firstWhere('id', $currency->currency_id);

            $c = CurrencyNew::firstWhere('code', $r->code);

            if ($r && $c) {

                $currency->currency_id = $c->id;
                $currency->save();

            }

        }

        /** Resetting Some Settings */

        Location::truncate();
        CurrencyCheckout::truncate();

        /** Done  */

        /** Some Seeds */

        Artisan::call('db:seed --class=ThemeSettingsTableSeeder');
        Artisan::call('db:seed --class=WhatsappSettingsTableSeeder');

        /** Done */
    }

    public function updateToVersion1_5()
    {
        Artisan::call('migrate --path=database/migrations/update1_5');
        $output = Artisan::output();
    }

    public function updateToVersion1_6()
    {

        try {

            Artisan::call('migrate --path=database/migrations/update1_6');
            // rename(public_path() . '/images/adv', public_path() . '/images/layoutads');

        } catch (\Exception $e) {
            Log::error("OTA 1.6 ERROR:" . $e->getMessage());
        }

    }

    public function updateToVersion1_7()
    {

        try {

            Artisan::call('migrate --path=database/migrations/update1_7');

            if (file_exists(public_path() . '/manifest.json')) {
                unlink(public_path() . '/manifest.json');
            }

            if (file_exists(public_path() . '/sw.js')) {
                unlink(public_path() . '/sw.js');
            }

            if (Schema::hasTable('offer_popups')) {

                if (OfferPopup::count() < 1) {
                    Artisan::call('db:seed --class=OfferPopupsTableSeeder');
                }

            }

            if (Schema::hasTable('p_w_a_settings')) {

                if (PWASetting::count() < 1) {
                    Artisan::call('db:seed --class=PWASettingsTableSeeder');
                    Artisan::output();
                }

            }

        } catch (\Exception $e) {
            \Log::error("OTA 1.7 ERROR:" . $e->getMessage());
        }

        $pwa_setting = DotenvEditor::setKeys([
            'PWA_ENABLE' => 1,
            'ENABLE_PRELOADER' => 1,
        ]);

        $pwa_setting->save();

    }

    public function updateToVersion1_8()
    {

        try {

            Artisan::call('migrate --path=database/migrations/update1_8');

        } catch (\Exception $e) {
            \Log::error("OTA 1.8 ERROR:" . $e->getMessage());
        }

    }

    public function updateToVersion1_9()
    {

        try {

            Artisan::call('migrate --path=database/migrations/update1_9');

        } catch (\Exception $e) {
            \Log::error("OTA 1.9 ERROR:" . $e->getMessage());
        }

    }

    public function updateToVersion2_0()
    {
        try {

            Artisan::call('migrate --path=database/migrations/update2_0');

        } catch (\Exception $e) {
            \Log::error("OTA 2.0 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_1()
    {
        try {

            Artisan::call('migrate --path=database/migrations/update2_1');

        } catch (\Exception $e) {
            \Log::error("OTA 2.1 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_2()
    {
        try {

            if (file_exists(base_path() . '/database/migrations/update2_1/2021_03_22_102151_add_columns.php')) {
                unlink(base_path() . '/database/migrations/update2_1/2021_03_22_102151_add_columns.php');
            }

            Artisan::call('migrate --path=database/migrations/update2_2');

        } catch (\Exception $e) {
            \Log::error("OTA 2.2 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_3()
    {
        try {

            Artisan::call('migrate --path=database/migrations/update2_3');

            if (Affilate::count() < 1) {
                Artisan::call('db:seed --class=AffilatesTableSeeder');
            }

        } catch (\Exception $e) {
            \Log::error("OTA 2.3 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_4()
    {
        try {

            Log::info('OTA 2.4 Update Start');

            Artisan::call('migrate --path=database/migrations/update2_4');

            if (Role::count() < 1) {
                Artisan::call('db:seed --class=RolesTableSeeder');
            }

            if (Permission::count() < 1) {
                Artisan::call('db:seed --class=PermissionsTableSeeder');
            }

            if (DB::table('role_has_permissions')->count() < 1) {
                Artisan::call('db:seed --class=RoleHasPermissionsTableSeeder');
            }

            if (env('ACL_UPGRADE') == 0) {

                $users = User::get();

                $users->each(function ($user) {

                    if ($user->role_id == 'a') {

                        $user->assignRole('Super Admin');

                    }

                    if ($user->role_id == 'v') {

                        $user->assignRole('Seller');

                    }

                    if ($user->role_id == 'u') {

                        $user->assignRole('Customer');

                    }

                    if ($user->status == '0') {

                        $user->assignRole('Blocked');

                    }

                });

                $acl_status = DotenvEditor::setKeys([
                    'ACL_UPGRADE' => '1',
                    'ENABLE_SELLER_SUBS_SYSTEM' => 0,
                ]);

                $acl_status->save();

                Log::info('OTA 2.4 Update Finished.');

            }

        } catch (\Exception $e) {
            \Log::error("OTA 2.4 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_5()
    {
        Log::info('OTA 2.5 Update Start');

        try {

            Artisan::call('migrate --path=database/migrations/update2_5');

            Log::info('OTA 2.5 Update Finished.');

        } catch (\Exception $e) {
            \Log::error("OTA 2.5 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_6()
    {
        Log::info('OTA 2.6 Update Start');

        try {

            Artisan::call('migrate --path=database/migrations/update2_6');

            Log::info('OTA 2.6 Update Finished.');

        } catch (\Exception $e) {
            Log::error("OTA 2.6 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_7()
    {
        Log::info('OTA 2.7 Update Start');

        try {

            Artisan::call('migrate --path=database/migrations/update2_7');

            if (!file_exists(storage_path() . '/app/keys/license.json')) {

                /** License Migration Process */

                $token = @file_get_contents(public_path() . '/intialize.txt');
                $code = @file_get_contents(public_path() . '/code.txt');
                $domain = @file_get_contents(public_path() . '/ddtl.txt');

                if ($token != '' && $code != '') {

                    $lic_json = array(

                        'name' => auth()->user()->name,
                        'code' => $code,
                        'type' => __('envato'),
                        'domain' => $domain,
                        'lic_type' => __('regular'),
                        'token' => $token,

                    );

                }

                $file = json_encode($lic_json,JSON_PRETTY_PRINT);

                $filename = 'license.json';

                Storage::disk('local')->put('/keys/' . $filename, $file);

                /** Delete this token files */

                try {

                    $token ? unlink(public_path() . '/intialize.txt') : '';
                    $code ? unlink(public_path() . '/code.txt') : '';
                    $domain ? unlink(public_path() . '/ddtl.txt') : '';

                } catch (\Exception $e) {
                    Log::error('Failed to migrate license reason : ' . $e->getMessage());
                }
            }

            /** End */

            Log::info('OTA 2.7 Update Finished.');

        } catch (\Exception $e) {
            Log::error("OTA 2.7 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_8(){
        
        try{

            Log::info('OTA 2.8 Update Start');

            Artisan::call('migrate --path=database/migrations/update2_8');

            Log::info('OTA 2.8 Update End');

        }catch(\Exception $e){
            Log::error("OTA 2.8 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion2_9(){
        
        try{

            Log::info('OTA 2.9 Update Start');

            Artisan::call('migrate --path=database/migrations/update2_9');

            Log::info('OTA 2.9 Update End');

        }catch(\Exception $e){
            Log::error("OTA 2.9 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion3_0(){
        
        try{

            Log::info('OTA 3.0 Update Start');

            Artisan::call('migrate --path=database/migrations/update3_0');

            /** Syncing New Permissions */

            Artisan::call('db:seed --class=UpdatePermissions');

            Log::info('OTA 3.0 Update End');

        }catch(\Exception $e){
            Log::error("OTA 3.0 ERROR:" . $e->getMessage());
        }
    }

    public function updateToVersion3_1(){
        
        try{

            Log::info('OTA 3.1 Update Start');

            Artisan::call('migrate --path=database/migrations/update3_1');

            Log::info('OTA 3.1 Update End');

        }catch(\Exception $e){
            Log::error("OTA 3.1 ERROR:" . $e->getMessage());
        }
    }

    public function getotaview()
    {

        return view('ota.update');

    }

    public function prelogin(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password'),

                'is_verified' => 1, 'status' => 1])) {

                if (Auth::user()->role_id != 'a') {
                    Auth::logout();
                    return response()->json(['status' => 'failed', 'msg' => __('No Permission !')]);
                }

                return response()->json(['status' => 'success', __('Authorization successfull').'...']);

            } else {
                return response()->json(['status' => 'failed', 'msg' => __('Invalid email address or wrong password !')]);
            }
        }
    }

    public function checkforupate(Request $request)
    {

        if ($request->ajax()) {

            $version = @file_get_contents(storage_path() . '/app/bugfixer/version.json');

            $version = json_decode($version, true);

            $current_version = $version['version'];

            $current_subversion = $version['subversion'];

            $new_version = str_replace('.', '', $current_subversion) + 1;
            $new_version = implode('.', str_split($new_version));

            $repo = @file_get_contents(config('app.ota_url') . $current_version . '/' . $new_version . '.json');

            if($repo != ''){
                
                $repo = json_decode($repo);
            
                return response()->json([
                    'status' => 'update_avbl',
                    'msg' => __('Update available'),
                    'version' => $repo->subversion,
                    'filename' => $repo->filename,
                ]);

                
            }else{
                
                return response()->json([
                    'status' => 'uptodate',
                    'msg' => __(__('Your application is up to date')),
                ]);
            }

        }

    }

    public function mergeQuickupdate(Request $request)
    {
        
        $file = @file_get_contents(config('app.ota_url') . config('app.version') . '/' . $request->filename);

        if(!$file){
            notify()->error(__('Update file not found !'),'404');
            return back();
        }

        $version = $request->version;

        Storage::disk('local')->put('/bugfixer/' . $request->filename, $file);

        $file = storage_path().'/app/bugfixer/' . $request->filename;

        $zip = new ZipArchive;

        $zipped = $zip->open($file, ZIPARCHIVE::CREATE);

        if ($zipped) {

            $extract = $zip->extractTo(base_path());

            if ($extract) {

                notify()->success(__('Quick hot fix update has been merged successfully !'));

                $version_json = array(

                    'version' => config('app.version'),
                    'subversion' => $version,

                );

                $version_json = json_encode($version_json);

                $filename = 'version.json';

                $zip->close();

                Storage::disk('local')->put('/bugfixer/' . $filename, $version_json);
                
                try{
                    unlink(storage_path().'/app/bugfixer/'.$request->filename);
                }catch(\Exception $e){
                    
                }

                return back();
            }

        }

    }
}