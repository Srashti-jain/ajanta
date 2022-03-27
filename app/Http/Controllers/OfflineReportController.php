<?php

namespace App\Http\Controllers;

use App\multiCurrency;
use App\OfflineOrder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OfflineReportController extends Controller
{
    public function index(Request $request)
    {
        $start_date =  $request->start_date;
        $end_date = $request->end_date;
        
        if($start_date && $end_date){
            $data =  OfflineOrder::whereBetween('invoice_date',[$start_date,$end_date])->withCount('orderItems');
        }else{
            $data =  OfflineOrder::withCount('orderItems');
        }
       

        $currency = multiCurrency::where('default_currency','1')->with('currency')->first();

        if(request()->ajax()){
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('order_date', function ($row) {
                return '<span class="text-dark">'.date('d-m-Y',strtotime($row->invoice_date)).'</span>';
            })
            ->addColumn('order_id', function ($row) {
                return "<span class='text-dark'><b>$row->order_id</b></span>";
            })
            ->addColumn('txn_id', function ($row) {
                return "<span class='text-dark'><b>$row->txn_id</b></span>";
            })
            ->addColumn('customer_detail', function ($row) {
                $data = '<p class="text-dark"><b>' . $row->customer_name . '</b></p>';
                $data .= '<p>' . $row->customer_email . '</p>';
                $data .= '<p>' . $row->customer_shipping_address . '</p>';
                $data .= '<p>' . $row->customer_pincode . '</p>';
                return $data;
            })
            ->addColumn('subtotal', function ($row) use($currency) {
                return $currency->currency->symbol.$row->subtotal;
            })
            ->addColumn('total_tax', function ($row) use($currency) {
                return $currency->currency->symbol.$row->total_tax;
            })
            ->addColumn('total_shipping', function ($row) use($currency) {
                return $currency->currency->symbol.$row->total_shipping;
            })
            ->addColumn('grand_total', function ($row) use($currency) {
                return $currency->currency->symbol.$row->grand_total;
            })
            ->rawColumns(['order_date', 'order_id', 'txn_id', 'customer_detail', 'subtotal', 'total_tax', 'total_shipping','grand_total'])
            ->make(true);
        }

        return view('offlinebilling.reports',compact('currency'));
    }
}
