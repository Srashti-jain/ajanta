<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use Illuminate\Support\Facades\Artisan;
use Session;

class LanguageController extends Controller
{
    public function index()
    {   
        abort_if(!auth()->user()->can('site-settings.language'),403,__('User does not have the right permissions.'));
        $allLang = Language::where('status', '=', 1)->get();
        return view('admin.language.index', compact('allLang'));
    }

   
    public function store(Request $request)
    {

        abort_if(!auth()->user()->can('site-settings.language'),403,__('User does not have the right permissions.'));

        if (isset($request->name))
        {

            try{

                $lang = $ifalready = Language::where('lang_code',$request->lang_code)->first();

            if(isset($ifalready)){

                $ifalready->status = 1;

                if(isset($request->def)){
                    $findlang = Language::where('def', '=', 1)->first();
                    
                    if (isset($findlang))
                    {
                        $findlang->def = 0;
                        $findlang->save();
                    }

                     $ifalready->def = 1;
                     
                     Session::put('changed_language', $ifalready->lang_code);
                }


                $ifalready->rtl_available = isset($request->rtl_available) ? 1 : 0;
                $ifalready->save();


            }else{

                $newlan = new Language;
                $newlan->lang_code = $request->lang_code;
                $newlan->status = 1;
                $newlan->name = $request->name;
                $newlan->rtl_available = isset($request->rtl_available) ? 1 : 0;

                if (isset($newlan))
                {

                    if (isset($request->def))
                    {
                        $newlan->def = 1;
                        $findlang = Language::where('def', '=', 1)->first();
                        if (isset($findlang))
                        {
                            $findlang->def = 0;
                            $findlang->save();
                        }
                        Session::put('changed_language', $newlan->lang_code);
                    }
                    else
                    {
                        $newlan->def = 0;

                    }

                    $lang = $newlan->save();

                } 
            }

           
                if (!is_dir(base_path().'/resources/lang/' . $request->lang_code)){
                    mkdir(base_path().'/resources/lang/' . $request->lang_code);
                    copy(base_path().'/resources/lang/en/staticwords.php', base_path().'/resources/lang/' . $request->lang_code . '/staticwords.php');
                }

            

            notify()->success('Language added !');
            return back();

        }catch(\Exception $e){
                notify()->warning($e->getMessage());
                return back();
        }

        }
        else
        {
            notify()->error(__('Oops ! Something went wrong !'));
            return back();
        }
        notify()->success(__('Language has been added !'));
        return back();

    }

    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('site-settings.language'),403,__('User does not have the right permissions.'));

        $findlang = Language::find($id);
        $input = $request->all();

        if (isset($findlang))
        {

            if (isset($request->def))
            {
                    
               
                    $deflang = Language::where('def', '=', 1)->first();

                    if($deflang->id != $findlang->id){

                        $deflang->def = 0;
                        $deflang->save();
                    
                        $input['def'] = 1;
                        
                    }else{
                        $input['def'] = 1;
                    }
                    
                    $input['rtl_available'] = isset($request->rtl_available) ? 1 : 0;
                    $findlang->update($input);
                
                
                    Session::put('changed_language', $findlang->lang_code);
                

            }
            else
            {

                if($findlang->def == 1){
                    $input['def'] = 1;
                }else{
                    $input['def'] = 0;
                }

                $input['rtl_available'] = isset($request->rtl_available) ? 1 : 0;
                $findlang->update($input);
            }

            notify()->success(__('Language dtails updated !'));
            return back();
        }
        else
        {
            notify()->error(__('Language not found !'));
            return back();
        }

    }

    public function delete($id)
    {

        abort_if(!auth()->user()->can('site-settings.language'),403,__('User does not have the right permissions.'));
        $lang = Language::find($id);

        if (isset($lang))
        {

            if ($lang->def == 1)
            {
                notify()->warning(__('Default language cannot be deleted !'));
                return back();
            }
            else
            {
                $lang->delete();
                notify()->info(__('Language Deleted !'));
                return back();
            }

        }
        else
        {
            notify()->error(__('Language Not found !'));
            return back();
        }
    }

    public function sync_vue_translation(){
        
        Artisan::call('VueTranslation:generate');
        notify()->success(__('Translation synchronize successfully !'),__('Synced'));
        return back();

    }
}

