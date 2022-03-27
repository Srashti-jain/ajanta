<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReportProduct;
use DataTables;

class ReportProductController extends Controller
{
    public function post(Request $request,$id)
    {
    	$input = $request->all();
    	$newreport = new ReportProduct;
      $input['des'] = clean($request->des);

      if($request->simple_product){
        $input['simple_pro_id'] = $id;
      }else{
        $input['pro_id'] = $id;
      }
    	
    	$newreport->create($input);
      notify()->error(__('Product reported successfully !'),__('Reported'));
    	return back();
    }

    public function get(Request $request){

        abort_if(!auth()->user()->can('reported-products.view'),403,__('User does not have the right permissions.'));

         $data = ReportProduct::with(['simpleProduct' => function($q){
         return $q->select('id','product_name');
       },'product' => function($q){
          return $q->select('id','name');
       }])->whereHas('product')->orWhereHas('simpleProduct')->get();

        if($request->ajax()){

            return DataTables::of($data)
               ->addIndexColumn()
               ->editColumn('info',function($row){
                  return "<p><b>Report Title:</b> $row->title </p>
                  <p><b>Contact email:</b> $row->email </p>";
               })
               ->editColumn('product',function($row){
                  if($row->simpleProduct != null){
                    return '<p>Product Name: '.$row->simpleProduct->product_name.'</p>';
                  }else{
                    return '<p>Product Name: '.$row->product->name.'</p>';
                  }
              })
               ->addColumn('rdtl',function($row){
                    return $row->des;
               })
               ->addColumn('rpon',function($row){
                    return $date = date('d-m-Y h:i A',strtotime($row->created_at));
               })
               ->rawColumns(['info','product','rdtl','rpon'])
               ->make(true);

        }

        return view('admin.reportproduct.index');
    }
}
