<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>{{ __('Print Order - :printorder',['printorder' => $inv_cus->order_prefix.$order->order_id ]) }}</title>
	<link href="{{ url('admin_new/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}">

	<link href="{{ url('admin_new/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ url('admin_new/assets/css/style.css') }}" rel="stylesheet" type="text/css">
   
</head>
<body class="vertical-layout">
   
    <div class="row">
		<div class="col-md-2 offset-md-10">
		 <a href="{{ url()->previous() }}" class="d-print-none btn btn-primary-rgba mt-2 ml-5"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>   
		</div>
	 
	</div>
     
            <div class="contentbar">    
				    
				@php
						$user = $order->user;

						$address = $order->shippingaddress;

						if($user->country_id !=''){
						$c = App\Allcountry::where('id',$user->country_id)->first()->nicename;
						$s = App\Allstate::where('id',$user->state_id)->first()->name;
						$ci = App\Allcity::where('id',$user->city_id)->first() ? App\Allcity::where('id',$user->city_id)->first()->name : '';
						}

						@endphp      
                
                <div class="row justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-11">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="invoice">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="col-12 col-md-7 col-lg-7">
                                                
                                                <h4>{{ __('Customer Information') }}</h4>
                                                <p><i class="feather icon-user mr-1"></i> {{$user->name}}</p>
                                                <p ><i class="feather icon-mail"></i> {{ $user->email }}</p>
                                                <p ><i class="feather icon-phone mr-1"></i> {{$user->mobile}}</p>
												@if(isset($c))
												<p><i class="fa fa-map-marker mr-1" aria-hidden="true"></i> {{$ci}}, {{ $s }}, {{ $c }}</p>
												@endif
                                            </div>
                                            <div class="col-12 col-md-5 col-lg-5">
                                                <div class="invoice-name">
                                                    <h5 class="text-uppercase mb-3">{{ __('Order Slip') }}</h5>
                                                    
                                                    <p class="mb-1">{{__('Total Qty')}}: {{ $sellerorders->sum('qty') }}</p>
                                                    <p class="mb-0">{{ date('d/m/Y h:i a', strtotime($order->created_at)) }}</p>
													<p class="mb-1">{{ __('Order ID') }}: {{ $inv_cus->order_prefix }}{{ $order->order_id }}</p>
                                                    <p class="mb-0">{{ __("TXN ID") }}: {{ $order->transaction_id }}</p>

                                                    <h4 class="text-success mb-0 mt-3"><i class="{{ $order->paid_in }}"></i>{{ round($total,2) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="invoice-billing">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4 col-lg-4">
                                                <div class="invoice-address">
                                                    <h6 class="mb-3">{{ __('Shipping Address') }}</h6>
                                                    <h6 class="text-muted">{{ $address->name }}</h6>
                                                    <ul class="list-unstyled">
                                                        <li>{{ strip_tags($address->address) }},
															@php
															$user = App\User::findorfail($order->user_id);

															$c = App\Allcountry::where('id',$address->country_id)->first()->nicename;
															$s = App\Allstate::where('id',$address->state_id)->first()->name;
															$ci = App\Allcity::where('id',$address->city_id)->first() ? App\Allcity::where('id',$address->city_id)->first()->name : '';

															@endphp

																{{ $ci }}, {{ $s }}, {{ $ci }}
															</li>
															<li>{{ $address->pin_code }}</li>    
                                                        <li> {{ $address->phone }}</li>  
                                                       
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-4">
                                                <div class="invoice-address">
                                                    <h6 class="mb-3">
														{{__('Billing Address')}}
													</h6>
                                                    <h6 class="text-muted">{{ $order->billing_address['firstname'] }}</h6>
                                                    <ul class="list-unstyled">
                                                        <li>{{ strip_tags($order->billing_address['address']) }}
															@php
									
									
															$c = App\Allcountry::where('id',$order->billing_address['country_id'])->first()->nicename;
															$s = App\Allstate::where('id',$order->billing_address['state'])->first()->name;
															$ci = App\Allcity::where('id',$order->billing_address['city'])->first() ? App\Allcity::where('id',$order->billing_address['city'])->first()->name : '';
									
															@endphp
															{{ $ci }}, {{ $s }}, {{ $ci }}</li>  
                                                        <li>{{ $order->billing_address['pincode'] ?? '' }}</li>  
                                                        <li> {{ $order->billing_address['mobile'] }}</li>  
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
                                                            <p> {{ ucfirst($order->payment_method) }}</p>
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
                                                        <th>
															{{__("Invoice No")}}
														</th>
														<th>
															{{__('Item Info')}}
														</th>
														<th>
															{{__('Qty')}}
														</th>
														<th>
															{{__('Status')}}
														</th>
														<th>
															{{__("Pricing & Tax")}}
														</th>
														
                                                        <th>
															{{__("Total")}}
														</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													@foreach($sellerorders as $invoice)
													<tr>
														<td>
															<i>{{ $inv_cus->prefix }}{{ $invoice->inv_no }}{{ $inv_cus->postfix }}</i>
														</td>
									
														<td width="40%">
															
									
																<div class="row">
																	<div class="col-md-3">
																		@if(isset($invoice->variant))
																			@if($invoice->variant->variantimages)
																				<img width="50px" src="{{url('variantimages/'.$invoice->variant->variantimages['main_image'])}}" alt="">
																			@else
																				<img width="50px" src="{{ Avatar::create($invoice->variant->products->name)->toBase64() }}" alt="">
																			@endif
																		@endif
									
																		@if(isset($invoice->simple_product))
																			<img width="50px" src="{{url('images/simple_products/'.$invoice->simple_product['thumbnail'])}}" alt="">
																		@endif
																	</div>
									
																	<div class="col-md-9">
																		@if(isset($invoice->variant))
																		@php
																			$orivar = $invoice->variant;
																		@endphp
																		<a class="text-dark" target="_blank" 
																			href="{{ App\Helpers\ProductUrl::getUrl($orivar->id) }}"><b>{{substr($orivar->products->name, 0, 25)}}{{strlen($orivar->products->name)>25 ? '...' : ""}}</b>
									
																			<small>{{ variantname($orivar)  }}</small>
																		</a>
																		@endif
									
																		@if($invoice->simple_product)
																		<a class="text-justify" href="{{ route('show.product',['id' => $invoice->simple_product->id, 'slug' => $invoice->simple_product->slug]) }}" target="_blank">
																			<b>{{ $invoice->simple_product->product_name }}</b>
																		</a>
																		@endif
									
																		<br>
																		@if($invoice->variant)
																		<small class="mleft22"><b>Sold By:</b> {{$invoice->variant->products->store->name}}</small>
																		@endif
									
																		@if($invoice->simple_product)
																			<small class=""><b>Sold By:</b> {{$invoice->simple_product->store->name}}</small>
																		@endif
																		<br>
																		<small class="mleft22"><b>Price: </b> <i class="{{ $invoice->order->paid_in }}"></i>
									
																			{{ round(($invoice->price),2) }}
									
																		</small>
									
																		<br>
									
																		<small class="mleft22"><b>Tax:</b> <i
																				class="{{ $invoice->order->paid_in }}"></i>{{ round(($invoice->tax_amount),2) }}
									
																			@if($invoice->variant)
																				@if($invoice->variant->products->tax_r !='')
																				({{ $invoice->variant->products->tax_r.'% '.$invoice->variant->products->tax_name }}
																				)
									
																				@endif
																			@endif
																		</small>
									
																	</div>
									
																</div>
									
									
									
									
									
														</td>
									
														<td>
															{{ $invoice->qty }}
														</td>
									
														<td>
															@if($invoice->status == 'delivered')
															<span >{{ ucfirst($invoice->status) }}</span>
															@elseif($invoice->status == 'processed')
															<span >{{ ucfirst($invoice->status) }}</span>
															@elseif($invoice->status == 'shipped')
															<span >{{ ucfirst($invoice->status) }}</span>
															@elseif($invoice->status == 'return_request')
															<span >
																{{__("Return Request")}}
															</span>
															@elseif($invoice->status == 'returned')
															<span >
																{{__("Returned")}}
															</span>
															@elseif($invoice->status == 'cancel_request')
															<span>Cancelation Request</span>
															@elseif($invoice->status == 'canceled')
															<span >
																{{__("Canceled")}}
															</span>
															@elseif($invoice->status == 'refunded')
															<span >
																{{__("Refunded")}}
															</span>
															@elseif($invoice->status == 'ret_ref')
															<span >
																{{__("Returned & Refunded")}}
															</span>
															@else
															<span >{{ ucfirst($invoice->status) }}</span>
															@endif
														</td>
									
														<td width="40%">
															<p>{{__('Total Price')}} : <i class="{{ $invoice->order->paid_in }}"></i>{{ round(($invoice->price*$invoice->qty),2) }}</p>
									
															
															<p>{{__('Total Tax')}} : <i
																class="{{ $invoice->order->paid_in }}"></i>{{ round(($invoice->tax_amount*$invoice->qty),2) }}
														    </p>
															<p>{{__("Shipping Charges")}} : <i
																class="{{ $invoice->order->paid_in }}"></i>{{ round($invoice->shipping,2) }}
															</p>
									
									
															<small class="help-block">({{ __('Price & TAX Multiplied with Quantity') }})</small>
															<p></p>
									
									
														</td>
									
									
														<td width="20%">
															<i class="{{ $invoice->order->paid_in }}"></i>
									
															{{ round($invoice->qty*($invoice->price+$invoice->tax_amount)+$invoice->shipping,2) }}
									
															<br>
									
															<small>({{ __('Incl. of TAX & Shipping') }})</small>
														</td>
													</tr>
													@endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="invoice-summary-total">
                                        <div class="row">
                                            <div class="col-md-12 order-2 order-lg-1 col-lg-5 col-xl-6">
                                                <div class="order-note">
													
                                                    <h6>{{__('Payment Recieved')}} :
                                                    {{ ucfirst($order->payment_receive)  }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-md-12 order-1 order-lg-2 col-lg-7 col-xl-6">
                                                <div class="order-total table-responsive ">
                                                    <table class="table table-borderless text-right">
                                                        <tbody>
                                                            <tr>
                                                                <td>{{__("Subtotal")}} :</td>
                                                                <td><i class="{{ $invoice->order->paid_in }}"></i>{{ round($total - $hc - $giftcharge,2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('Coupon Discount')}}:</td>
                                                                <td><i class="{{ $invoice->order->paid_in }}"></i>{{ round($order->discount,2) }}</b>
																	({{ $order->coupon }})</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__("Gift Packaging Charge")}}:</td>
                                                                <td>+ <i class="{{ $invoice->order->paid_in }}"></i>{{ round($giftcharge,2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__('Handling Charge')}}:</td>
                                                                <td>+ <i class="{{ $invoice->order->paid_in }}"></i>{{ round($hc,2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="f-w-7 font-18"><h5>{{__("Grand Total")}}:</h5></td>
                                                                <td class="f-w-7 font-18"><h5><i class="{{ $invoice->order->paid_in }}"></i>

																	{{ round($total,2) }}</h5></td>
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
													{{__('Thank you for your Business.')}}
												</p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="invoice-footer-btn">
                                                    <a href="javascript:window.print()" class="d-print-none btn btn-primary-rgba py-1 font-16"><i class="feather icon-printer mr-2"></i>
														{{__('Print')}}
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
