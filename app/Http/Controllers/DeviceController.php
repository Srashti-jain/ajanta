<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    public function index(){
        
        $users = DB::table('users')
              ->join('auth_log','users.id','=','auth_log.authenticatable_id')
              ->select('users.name as username','users.email as useremail','auth_log.*');

        if(request()->ajax()){
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('username',function($row){

                $html = '<b> <span class="text-dark">'.__('Name:').'</span> </b>'.$row->username;
                $html .= '<br>';
                $html .= '<b> <span class="text-dark">'.__('Email').':</span> </b>'.$row->useremail;
                return $html;

            })
            ->addColumn('ip_address',function($row){
                return $row->ip_address;
            })
            ->addColumn('platform',function($row){
                return $row->platform;
            })
            ->addColumn('browser',function($row){
                return $row->browser;
            })
            ->addColumn('login_at',function($row){
                return $row->login_at ? date('d-m-Y | h:i A',strtotime($row->login_at)) : '-' ;
            })
            ->addColumn('logout_at',function($row){
                return $row->logout_at ? date('d-m-Y | h:i A',strtotime($row->logout_at)) : '-' ;
            })
            ->rawColumns(['username','ip_address','platform','browser','login_at','logout_at'])
            ->make(true);
        }

        return view('admin.reports.history');
    }
}
