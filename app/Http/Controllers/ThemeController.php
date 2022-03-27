<?php

namespace App\Http\Controllers;

use App\ThemeSetting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:color-options.manage']);
    }

    public function index(){
        $themesettings = ThemeSetting::first();
        return view('admin.themes.index',compact('themesettings'));
    }

    public function applytheme(Request $request){
        
        $theme = ThemeSetting::first();

        if($theme){

            $theme->key = $request->key;
            $theme->theme_name = $request->key == 'default' ? NULL : $request->theme_pattern_options;
            $theme->save();
            notify()->success(__("Theme changed successfully !"));
            return back();

        }else{
            notify()->error(__("Theme not found !"));
            return back();
        }
    }   
}
