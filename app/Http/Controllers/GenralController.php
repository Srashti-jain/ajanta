<?php
namespace App\Http\Controllers;

use App\Genral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class GenralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('site-settings.genral-settings'), 403, __('User does not have the right permissions.'));

        $row = Genral::first();

        $env_files = ['APP_NAME' => env('APP_NAME')];

        return view("admin.genral.edit", compact("row", "env_files"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        abort_if(!auth()->user()->can('site-settings.genral-settings'), 403, __('User does not have the right permissions.'));

        $input = array_filter($request->all());

        $active = @file_get_contents(public_path() . '/config.txt');

        if (!$active) {
            $putS = 1;
            file_put_contents(public_path() . '/config.txt', $putS);
        }

        $d = \Request::getHost();

        $domain = str_replace("www.", "", $d);

		return $this->verifiedupdate($input,$request);

    }

    public function verifiedupdate($input, $request)
    {

        abort_if(!auth()->user()->can('site-settings.genral-settings'), 403, __('User does not have the right permissions.'));

        $cat = Genral::first();

        $env_keys_save = DotenvEditor::setKeys([
            'APP_NAME' => $request->APP_NAME,
            'APP_URL' => $request->APP_URL,
            'NOCAPTCHA_SECRET' => $request->NOCAPTCHA_SECRET,
            'NOCAPTCHA_SITEKEY' => $request->NOCAPTCHA_SITEKEY,
            'OPEN_EXCHANGE_RATE_KEY' => $request->OPEN_EXCHANGE_RATE_KEY,
            'APP_DEBUG' => isset($request->APP_DEBUG) ? "true" : "false",
            'COD_ENABLE' => isset($request->COD_ENABLE) ? "1" : "0",
            'ENABLE_PRELOADER' => isset($request->ENABLE_PRELOADER) ? "1" : "0",
            'TIMEZONE' => $request->TIMEZONE,
            'MAILCHIMP_APIKEY' => $request->MAILCHIMP_APIKEY,
            'MAILCHIMP_LIST_ID' => $request->MAILCHIMP_LIST_ID,
            'HIDE_SIDEBAR' => $request->HIDE_SIDEBAR ? 1 : 0,
            'GOOGLE_TAG_MANAGER_ENABLED' => $request->GOOGLE_TAG_MANAGER_ENABLED ? "true" : "false",
            'GOOGLE_TAG_MANAGER_ID' => $request->GOOGLE_TAG_MANAGER_ID,
            'PRICE_DISPLAY_FORMAT' => $request->PRICE_DISPLAY_FORMAT ? 'comma' : 'decimal',
            'SHOW_IMAGE_INSTEAD_COLOR' => $request->SHOW_IMAGE_INSTEAD_COLOR ? 'true' : 'false',
            'PUSHER_APP_ID' => $request->PUSHER_APP_ID,
            'PUSHER_APP_KEY' => $request->PUSHER_APP_KEY,
            'PUSHER_APP_SECRET' => $request->PUSHER_APP_SECRET,
            'PUSHER_APP_CLUSTER' => $request->PUSHER_APP_CLUSTER
        ]);

        $env_keys_save->save();

       
        if ($request->logo != null) {

            
            if(strstr($request->logo, '.png') || strstr($request->logo, '.jpg') || strstr($request->logo, '.jpeg') || strstr($request->logo, '.webp') || strstr($request->logo, '.gif')){

                $input['logo'] = $request->logo;

            }else{
                return back()->withInput()->withErrors([
                    __('Invalid image type')
                ]);
            }

        }

        if ($request->fevicon != null) {


            if(strstr($request->fevicon, '.png') || strstr($request->fevicon, '.jpg') || strstr($request->fevicon, '.jpeg') || strstr($request->fevicon, '.webp') || strstr($request->fevicon, '.ico')){

                $input['fevicon'] = $request->fevicon;

            }else{
                return back()->withInput()->withErrors([
                    __('Invalid image type')
                ]);
            }
 
        }

        if (isset($request->right_click)) {
            $input['right_click'] = '1';
        } else {
            $input['right_click'] = '0';
        }

        if (isset($request->captcha_enable)) {
            $input['captcha_enable'] = '1';
        } else {
            $input['captcha_enable'] = '0';
        }

        if (isset($request->inspect)) {
            $input['inspect'] = '1';
        } else {
            $input['inspect'] = '0';
        }

        if (isset($request->login)) {
            $input['login'] = '1';
        } else {
            $input['login'] = '0';
        }

        if (isset($request->guest_login)) {
            $input['guest_login'] = '1';
        } else {
            $input['guest_login'] = '0';
        }

        if (isset($request->vendor_enable)) {
            $input['vendor_enable'] = 1;
        } else {
            $input['vendor_enable'] = 0;
        }

        if (isset($request->email_verify_enable)) {
            $input['email_verify_enable'] = 1;
        } else {
            $input['email_verify_enable'] = 0;
        }

        if ($request->file('preloader')) {
            $dir = 'images/preloader';
            $leave_files = array('index.php');

            foreach (glob("$dir/*") as $file2) {
                if (!in_array(basename($file2), $leave_files)) {
                    unlink($file2);
                }
            }

            $image = $request->file('preloader');
            $img = Image::make($image->path());
            $preloader = 'preloader.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/preloader');
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($destinationPath . '/' . $preloader);
        }

        $input['cart_amount'] = $request->cart_amount ?? 0;

        $cat->update($input);

        notify()->success(__("Genral Setting Has Been Updated !"));
        return back();

    }

   
    public function quicksettings(Request $request){

        abort_if(!auth()->user()->can('site-settings.genral-settings'), 403, __('User does not have the right permissions.'));

        $env = DotenvEditor::setkeys([

            'ENABLE_PRELOADER'  => $request->ENABLE_PRELOADER ? 1 : 0,
            'APP_DEBUG'         => $request->APP_DEBUG ? "true" : "false",
            'COD_ENABLE'        => $request->COD_ENABLE ? 1 : 0,
            'HIDE_SIDEBAR'      => $request->HIDE_SIDEBAR ? 1 : 0,

        ]);

        $env->save();

        $settings = Genral::first();

        $settings->vendor_enable                  = $request->vendor_enable ? '1' : '0';
        $settings->right_click                    = $request->right_click ? '1' : '0';
        $settings->inspect                        = $request->inspect ? '1' : '0';
        $settings->login                          =  $request->login ? '1' : '0';
        $settings->email_verify_enable            =  $request->email_verify_enable ? '1' : '0';
        
        $settings->save();

        notify()->success(__('Settings updated !'));

        return back();

    }

}
