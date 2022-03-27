<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FooterMenu;


class FooterMenuController extends Controller
{
    public function store(Request $request){

		abort_if(!auth()->user()->can('menu.create'),403,__('User does not have the right permissions.'));

    	$request->validate(['title' => 'required']);

    	$footermenu = new FooterMenu;

    	$input = $request->all();

    	if($request->link_by == 'page'){

    		$input['page_id'] = $request->page_id;
    		$input['url'] = NULL;

    	}elseif($request->link_by == 'url'){

    		$input['page_id'] = NULL;
    		$input['url'] = $request->url;
    	}

    	$input['position'] = (FooterMenu::count()+1);

    	$input['status']  = isset($request->status) ? 1 : 0;

    	$footermenu->create($input);

    	return back()->with('added',__(":menu menu has been created !",['menu' => $request->title]));

    }

    public function update(Request $request,$id){

		abort_if(!auth()->user()->can('menu.edit'),403,__('User does not have the right permissions.'));

    	$request->validate(['title' => 'required']);

    	$footermenu = FooterMenu::find($id);

    	if(isset($footermenu)){
    		$input = $request->all();

	    	if($request->link_by == 'page'){

	    		$input['page_id'] = $request->page_id;
	    		$input['url'] = NULL;

	    	}elseif($request->link_by == 'url'){

	    		$input['page_id'] = NULL;
	    		$input['url'] = $request->url;
	    	}

	    	$input['position'] = (FooterMenu::count()+1);

	    	$input['status']  = isset($request->status) ? 1 : 0;

	    	$footermenu->update($input);

	    	return back()->with('added',__(":menu menu has been updated !",['menu' => $request->title]));

	    	}else{
	    		return back()->with(__('404 | Menu not found !'));
	    	}
    }

    public function delete($id){
		abort_if(!auth()->user()->can('menu.delete'),403,__('User does not have the right permissions.'));
    	$footermenu = FooterMenu::find($id);

    	if(isset($footermenu)){
    		$footermenu->delete();
    		return back()->with('success',__('Footer menu has been deleted !'));
    	}else{
    		return back()->with('delete',__('404 | Footer menu not found !'));
    	}
    }
}
