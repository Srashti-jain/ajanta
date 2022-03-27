<?php

namespace App\Http\Controllers;

use App\Maintainence;
use Illuminate\Http\Request;

class MaintainenceController extends Controller
{



    public function post(Request $request)
    {

        if(env('DEMO_LOCK') == 1){
            alert()->error(__('This Action is disabled in demo !'), __('Action Disabled'));
            return back();
        } 
        
        abort_if(!auth()->user()->can('site-settings.maintenance-mode'),403,__('User does not have the right permissions.'));

        $request->validate([
            'allowed_ips' => 'required',
            'message' => 'required|max:5000',
        ]);

        $row_exist = Maintainence::first();

        if ($row_exist) {

            Maintainence::where('id', '=', 1)->update([

                'message' => clean($request->message),
                'allowed_ips' => $request->allowed_ips,
                'status' => isset($request->status) ? 1 : 0,
            ]);

        } else {

            Maintainence::create([

                'message' => clean($request->message),
                'allowed_ips' => $request->allowed_ips,
                'status' => isset($request->status) ? 1 : 0,
            ]);

        }

        return back()->with('added', __('Maintenance settings updated !'));
    }

    public function getview()
    {
        abort_if(!auth()->user()->can('site-settings.maintenance-mode'),403,__('User does not have the right permissions.'));
        
        $data = Maintainence::first();

        return view('admin.maintenance.index', compact('data'));
    }
}
