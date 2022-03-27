<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{__("Payout for Order Item")}} #{{ $inv_cus->prefix.$payout->singleorder->inv_no.$inv_cus->postfix }} | eMart</title>
	<link href="{{ url('admin_new/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}">

	<link href="{{ url('admin_new/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('admin_new/assets/css/style.css') }}" rel="stylesheet" type="text/css">
   
</head>
<body class="vertical-layout">
    
    
     
            <div class="contentbar">
                <div class="row ml-0 mb-2">
                    <div class="col-md-12 ml-5">
                        <a href="{{ route('seller.payout.show.complete',$payout->id) }}"  class="d-print-none btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                    </div>
                 
                </div>             
			   
                
                <div class="row justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-11">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="invoice">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="col-12 col-md-7 col-lg-7">
                                                <div class="invoice-logo">
                                                  <a href="{{url('/')}}" class="logo logo-large">
                                                    <img src="{{ url('images/genral/'.$genrals_settings->logo) }}" class="img-fluid" alt="logo" />
                                                 </a>
                                                </div>
                                                <h4>{{ $title }}</h4>
                                                <p>{{ $seoset['metadata_des'] }}</p>
                                            
                                                <p class="mb-0">{{ $genrals_settings['address'] }}</p>
                                            </div>
                                            <div class="col-12 col-md-5 col-lg-5">
                                                
                                                
                                           
                                           
                                                <div class="invoice-name">
                                                    <h5 class="text-uppercase mb-3">
                                                        {{__("Invoice")}}
                                                    </h5>
                                                    
                                                    <p class="mb-1">{{__("Invoice No. :")}} #{{ $inv_cus->prefix.$payout->singleorder->inv_no.$inv_cus->postfix }}</p>
                                                    <p class="mb-0">{{__("Payout ID :")}}  {{ $payout->payoutid}}</p>
                                                    <p class="mb-0">{{__("Transcation ID :")}} {{ $txnid }}</p>
                                                    @if($payout->paidvia == 'Paypal')
                                                    <p class="mb-1">{{__("Paypal Batch ID :")}} {{ $payout->txn_id }}</p>
                                                    <p class="mb-1">{{__("Payment Status :")}} {{ $status}}</p>
                                                                              @endif
                                                   

                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="invoice-billing">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4 col-lg-4">
                                                <div class="invoice-address">
                                                    <h6 class="mb-3">
                                                        {{__("From")}}
                                                    </h6>
                                                    <h6 class="text-muted">{{ $genrals_settings->project_name }}</h6>
                                                    <ul class="list-unstyled">
                                                        <li>{{ $genrals_settings->address }}</li>
													    <li>{{ $genrals_settings->mobile }}</li>    
                                                        <li> {{ $genrals_settings->email }}</li>  
                                                       
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-4">
                                                <div class="invoice-address">
                                                    <h6 class="mb-3">
                                                        {{__("To")}}
                                                    </h6>
                                                    <h6 class="text-muted">{{ $payout->vender->name }}</h6>
                                                    <ul class="list-unstyled">
                                                        <li> {{ $payout->vender->store->address }}
                                                            {{ $payout->vender->store->city['name'] }}, {{ $payout->vender->store->state['name'] }}, {{ $payout->vender->store->country['nicename'] }}</li>  
                                                        <li>{{ $payout->vender->store->mobile }}</li>  
                                                        <li> {{ $payout->vender->store->paypal_email }}</li>  
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <div class="invoice-address">
                                                    <div class="card">
                                                        <div class="card-body bg-info-rgba text-center">
                                                            <h6>
                                                                {{__("Payment Method")}}
                                                            </h6>
                                                            <p></p>
                                                            <p>@if($payout->paidvia == 'Paypal')
                                                                <img src="{{ url('images/paypal.png') }}" alt="Paypal">
                                                              @endif
                                                              @if($payout->paidvia == 'Bank')
                                                              <img width="50px" src="{{ url('images/bankt.png') }}" alt="bank_transfer" title="Bank Transfer">
                                                              @endif</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="invoice-summary">
                                        <div class="table-responsive ">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>
                                                            {{__('Image')}}
                                                        </th>
                                                        <th>
                                                            {{__("Product")}}
                                                        </th>
                                                        <th>
                                                            {{__("HSN")}}
                                                        </th>
                                                        <th>
                                                            {{__("Qty")}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        @if($payout->singleorder->variant)
                                                        <td>
                                                          <img height="50px" src="{{url('variantimages/thumbnails/'.$payout->singleorder->variant->variantimages['main_image'])}}" alt=""/>
                                                        </td>
                                                        <td>{{ $payout->singleorder->variant->products->name }}  
                                                          
                                                          <small>({{ variantname($payout->singleorder->variant) }})</small></td>
                                                        <td>{{ $payout->singleorder->variant->products->hsn }}</td>
                                                      @endif
                                                      @if($payout->singleorder->simple_product)
                                                        <td>
                                                          <img height="50px" src="{{url('images/simple_products/'.$payout->singleorder->simple_product->thumbnail)}}"/>
                                                        </td>
                                                        <td>
                                                          {{ $payout->singleorder->simple_product->product_name }}  
                                                        </td>
                                                        <td>{{ $payout->singleorder->simple_product->hsin }}</td>
                                                      @endif
                                                        <td>{{ $payout->singleorder->qty }}</td>
                                                        
                                                      </tr>
                                                    </tbody>
                                                     
                                            </table>
                                        </div>
                                    </div>
                                    <div class="invoice-summary-total">
                                        <div class="row">
                                            <div class="col-md-12 order-2 order-lg-1 col-lg-5 col-xl-6">
                                                <div class="order-note">
													
                                                     <h4 class="text-success mb-0 mt-3">{{__("Payment Method:")}} {{ $payout->paidvia == 'Bank' ? "Bank Transfer [$payout->txn_type]" : $payout->paidvia }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-12 order-1 order-lg-2 col-lg-7 col-xl-6">
                                                <div class="order-total table-responsive ">
                                                    <table class="table table-borderless text-right">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    {{__("Subtotal:")}}
                                                                </td>
                                                                <td><i class="{{ $defCurrency->currency_symbol }}"></i> @if($payout->paidvia == 'Bank') {{  sprintf("%.2f", $payout->orderamount+$payout->txn_fee) }} @else {{  sprintf("%.2f", $payout->orderamount) }} @endif</td>
                                                            </tr>
                                                            @if($payout->txn_fee !='')
                                                            @if($payout->paidvia =='Paypal')
                                                            <tr>

                                                                <td>
                                                                    {{__("Transcation Charge:")}}
                                                                </td>
                                                                <td><i class="{{ $defCurrency->currency_symbol }}"></i> {{ $payout->txn_fee }} <i title="Already paid by admin not included in this total" class="fa fa-info-circle d-print-none"></i></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    {{__("Transcation Charge:")}}
                                                                </td>
                                                                <td><i class="{{ $defCurrency->currency_symbol }}"></i> {{ $payout->txn_fee }} <i title="Already paid by admin not included in this total" class="fa fa-info-circle d-print-none"></i></td>
                                                            </tr>
                                                            @endif
                                                            @endif
                                              
                                                            
                                                            <tr>
                                                                <td class="f-w-7 font-18"><h5>Total:</h5></td>
                                                                <td class="f-w-7 font-18">
                                                                    <h5><i class="{{ $defCurrency->currency_symbol }}"></i> @if($payout->paidvia == 'Bank') {{  sprintf("%.2f", $payout->orderamount+$payout->txn_fee-$payout->txn_fee) }} @else {{  sprintf("%.2f", $payout->orderamount) }} @endif</h5>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="invoice-footer">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <p class="mb-0">
                                                    {{__("Thank you for your Business.")}}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="invoice-footer-btn">
                                                    <a href="javascript:window.print()" class="d-print-none btn btn-primary-rgba py-1 font-16"><i class="feather icon-printer mr-2"></i>
                                                        {{__("Print")}}
                                                    </a>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
       
    
</body>
</html>
   
	
	



	
	



	