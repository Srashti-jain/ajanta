<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;



class CustomStyleController extends Controller
{
    public function addStyle()
    {

        abort_if(!auth()->user()->can('site-settings.style-settings'),403,__('User does not have the right permissions.'));

        $css = @file_get_contents(public_path().'/css/custom-style.css');
        $js  = @file_get_contents(public_path().'/js/custom-js.js');
        
        return view('admin.customstyle.add',compact('css','js'));
    }

    public function storeCSS(Request $request)
    {
        abort_if(!auth()->user()->can('site-settings.style-settings'),403,__('User does not have the right permissions.'));

        $this->validate($request, array(
            'css' => 'required'
        ));

        $css = $request->css;
        
        file_put_contents(public_path()."/css/custom-style.css", $css . PHP_EOL);
        

        return redirect()->route('customstyle')
            ->with('added', __('Added Custom CSS !'));

    }

    public function storeJS(Request $request)
    {
        abort_if(!auth()->user()->can('site-settings.style-settings'),403,__('User does not have the right permissions.'));

        $this->validate($request, array(
            'js' => 'required'
        ));

        $js = $request->js;
        file_put_contents(public_path()."/js/custom-js.js", $js . PHP_EOL );
        return redirect()->route('customstyle')
            ->with('added', __('Added Javascript !'));
    }

}

