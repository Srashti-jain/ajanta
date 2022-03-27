<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Return_Product;

class SellerReturnController extends Controller
{
    public function index(){

    	$inv_cus = Invoice::first();
    	$allorders = Return_Product::whereHas('getorder')->orderBy('id','desc')->get();
    	$sellerorders = collect();
    	$unreadorders = collect();
    	$readedorders = collect();

    	foreach ($allorders as $key => $order) {
    		if(auth()->id() == $order->getorder->vender_id){
    			$sellerorders->push($order);
    		}
    	}

    	foreach ($sellerorders as $key => $order) {
    		if($order->status == 'initiated' && isset($order->getorder->order)){
    			$unreadorders->push($order);
    		}
    	}

    	foreach ($sellerorders as $key => $order) {
    		if($order->status != 'initiated' && isset($order->getorder->order)){
    			$readedorders->push($order);
    		}
    	}
    	
        $countP = count($unreadorders);
    	$countC = count($readedorders);
    	return view('seller.order.returnorders.index',compact('sellerorders','countP','countC','inv_cus'));
    }

    public function show($id){

    	$rorder = Return_Product::with('getorder')->whereHas('getorder')->findorfail($id);
        
        if (isset($rorder)) {

            $inv_cus = Invoice::first();
            $orderid = $rorder->getorder->order->order_id;

            if($rorder->getorder->vender_id != auth()->id()){

                return back()->with('warning',__('You cannot view other seller orders!'));

            }else{

                if($rorder->status != 'initiated'){
                    return back()->with('warning',__('Oops ! Refund already initiated !'));
                }

                return view('seller.order.returnorders.show',compact('rorder','orderid','inv_cus'));
            }

        }else{
            return redirect()->route('seller.return.index')->with('warning',__('Return order not found !'));
        }   
    }

    public function detail($id)
    {
        $order = Return_Product::with('getorder')->whereHas('getorder')->findorfail($id);
       
        if (isset($order)) {

             $inv_cus = Invoice::first();
             $orderid = $order->getorder->order->order_id;
            
            if($order->status != 'initiated'){
               
                 if($order->getorder->vender_id != auth()->id()){
                   
                    return back()->with('warning',__('You cannot view other sellers orders'));
                 }else{
                    return view('seller.order.returnorders.detail',compact('inv_cus','order','orderid'));
                 }
            }else {
                return back()->with('warning',__('Order not refunded yet !'));
            }

        }else {
            return redirect()->route('seller.return.index')->with('warning',__('Order not found !'));
        }

       
    }
}
