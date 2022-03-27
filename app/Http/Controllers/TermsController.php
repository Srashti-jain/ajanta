<?php

namespace App\Http\Controllers;

use App\TermsSettings;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:terms-settings.update']);
        $this->setting = TermsSettings::all();
        
    }

    public function userterms(){

        $userTerm = $this->setting->firstWhere('key','user-register-term');
        $sellerTerm = $this->setting->firstWhere('key','seller-register-term');
        return view('admin.terms.term',compact('userTerm','sellerTerm'));

    }

    public function postuserterms(Request $request,$key){
        
        $term = $this->setting->firstWhere('key',$key);

        if($term){

            $request->validate([
                'title' => 'required',
                'description' => 'required'
            ]);

            $term->title = $request->title;
            $term->description = clean($request->description);

            $term->save();

            session()->flash('added',__('Terms has been updated !'));

            return back();


        }else{
            session()->flash('warning',__('404 | Not found !'));
            return redirect(route('admin.main'));
        }
    }
}
