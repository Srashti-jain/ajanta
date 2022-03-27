<?php

namespace App\Http\Controllers;

use App\AddSubVariant;
use App\Order;
use App\Product;
use App\SimpleProduct;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function stockreport(Request $request)
    {

        abort_if(!auth()->user()->can('reports.view'),403,__('User does not have the right permissions.'));

        $products = AddSubVariant::with(['variantimages', 'products', 'products.store', 'products.vender'])
                    ->whereHas('products.store', function ($q) {
                        return $q->where('status', '=', '1');
                    })->whereHas('products.vender', function ($q) {
                        return $q->where('status', '=', '1');
                    });

        if ($request->ajax()) {

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<b>' . $row->products->name . '</b>';
                })
                ->addColumn('variant', function($row){
                    return variantname($row);
                })
                ->addColumn('store_name', function ($row) {
                    return '<b>' . $row->products->store->name . '</b>';
                })
                ->addColumn('stock', function ($row) {
                    if ($row->stock < 5) {
                        return "<span class='text-red'><b>$row->stock</b></span>";
                    } else {
                        return "<span class='text-green'><b>$row->stock</b></span>";
                    }
                })
                ->rawColumns(['product_name', 'variant', 'store_name', 'stock'])
                ->make(true);

        }

        return view('admin.reports.stockreport');
    }

    public function salesreport(Request $request)
    {   

        abort_if(!auth()->user()->can('reports.view'),403,__('User does not have the right permissions.'));

        $orders = Order::with(['invoices'])->whereHas('invoices')->where('status','1');

        if ($request->ajax()) {
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return '<b>' . date('d-m-Y',strtotime($row->created_at)) . '</b>';
                })
                ->addColumn('order_id', function ($row) {
                    return '<b>' . $row->order_id . '</b>';
                })
                ->addColumn('subtotal', function ($row) {
                    return sprintf('%.2f',$row->order_total - $row->tax_amount - $row->shipping);
                })
                ->addColumn('handlingcharge', function ($row) {
                    return $row->handlingcharge;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->order_total + $row->handlingcharge + $row->gift_charge;
                })
                ->rawColumns(['date','order_id', 'variant', 'store_name', 'sales'])
                ->make(true);
        }

        return view('admin.reports.salesreport');
    }

    public function stockreportsp(){

        abort_if(!auth()->user()->can('reports.view'),403,__('User does not have the right permissions.'));

        $products = SimpleProduct::with(['store'])->whereHas('store',function($q){
                $q->where('status','1');
        });

        if(request()->ajax()){

            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<b>' . $row->product_name . '</b>';
                })
                ->addColumn('store_name', function ($row) {
                    return '<b>' . $row->store->name . '</b>';
                })
                ->addColumn('stock', function ($row) {
                    if ($row->stock < 5) {
                        return "<span class='text-red'><b>$row->stock</b></span>";
                    } else {
                        return "<span class='text-green'><b>$row->stock</b></span>";
                    }
                })
                ->rawColumns(['product_name', 'variant', 'store_name', 'stock'])
                ->make(true);

        }

    }

    public function mostviewproducts(Request $request){

        abort_if(!auth()->user()->can('reports.view'),403,__('User does not have the right permissions.'));

        $data = Product::orderByUniqueViews();

        $data2 = SimpleProduct::orderByUniqueViews();
        
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<b>' . $row->name . '</b>';
                })
                ->addColumn('views', function ($row) {
                    
                    return "<b>$row->unique_views_count</b>";
                    
                })
                ->rawColumns(['product_name', 'views'])
                ->make(true);
        }

        return view('admin.reports.viewreport');

    }

    public function mostviewsimpleproducts(){

        $data = SimpleProduct::orderByUniqueViews();
        
        if (request()->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('product_name', function ($row) {
                    return '<b>' . $row->product_name . '</b>';
                })
                ->addColumn('views', function ($row) {
                    
                    return "<b>$row->unique_views_count</b>";
                    
                })
                ->rawColumns(['product_name', 'views'])
                ->make(true);
        }

    }
}
