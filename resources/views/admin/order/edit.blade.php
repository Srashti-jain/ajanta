@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Order :orderid | ',['orderid' => $inv_cus->order_prefix.$order->order_id]))
@section('body')

@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Order') }}
@endslot
@slot('menu1')
{{ __("Edit Order") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{ url('admin/order') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">
  <div class="row">
    
    <div class="col-lg-12">
		@if ($errors->any())
			<div class="alert alert-danger" role="alert">
			@foreach($errors->all() as $error)
			<p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span></button></p>
			@endforeach
			</div>
		@endif
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit Order') }} {{ $order->order_id }}</h5>
        </div>
        <div class="card-body ml-2">
         <!-- main content start -->

         <!-- form start -->
    <!-- Checking Mnaual payment -->

		@if($order->manual_payment == '1')
			<div class="alert alert-info p-1">
				<i class="fa fa-info-circle"></i> {{__("This order is placed using")}} {{ ucfirst($order->payment_method) }} {{__("method and purchase proof you can view")}} <a href="{{ url('images/purchase_proof/'.$order->purchase_proof) }}"
					data-lightbox="image-1" data-title="{{__("Purchase proof for")}} {{ $order->order_id }}">{{ __("here") }}</a> {{__("and")}} {{__("after verify you can change the order status")}}.
			</div>
		@endif

		<!-- Printing order cancel logs-->

		@if(count($order->cancellog))

			<div class="alert alert-danger">

				@foreach($order->cancellog as $orderlog)
					<p class="font-weight500 font-familycalibri">
						<i class="fa fa-info-circle"></i>
						<b>{{ date('d-m-Y | h:i A',strtotime($orderlog->updated_at)) }} • {{__("For Order")}}
							#{{ $inv_cus->order_prefix.$order->order_id }} • {{ __("Item") }} {{ $orderlog->singleOrder->variant->products->name ?? $orderlog->singleOrder->simple_product->product_name }} @if($orderlog->singleOrder->variant) ({{ variantname($orderlog->singleOrder->variant) }}) @endif {{__("has been cancelled")}}
							{{ $order->payment_method == 'COD' ? "." : ""  }}</b>

						@if($orderlog->method_choosen == 'orignal')

						<b> {{__("and Amount")}} <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
							{{__("is refunded to its orignal source with TXN ID")}} [{{ $orderlog->transaction_id }}].</b>


						@elseif($orderlog->method_choosen == 'bank')

							@if($orderlog->is_refunded == 'completed')
							<b> {{__("and Amount")}} <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
								{{__("is refunded to")}} <b>{{ $orderlog->user->name }}'s</b> {{__("bank ac")}} @if(isset($orderlog->bank->acno))
								XXXX{{ substr($orderlog->bank->acno, -4) }} @endif {{__("with TXN/REF No")}} {{ $orderlog->transaction_id }}
								@if($orderlog->txn_fee !='')<br> {{__("(TXN FEE APPLIED)")}} <i class="{{ $order->paid_in }}"></i>
								{{ $orderlog->txn_fee }} @endif.</b>
							@else
							<b>{{__("Amount")}} <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
								{{__("is pending to")}} <b>{{ $orderlog->user->name }}'s</b> {{__("bank ac")}} @if(isset($orderlog->bank->acno))
								{{__("XXXX") }}{{ substr($orderlog->bank->acno, -4) }} @endif {{__("with TXN/REF. No:")}} {{ $orderlog->transaction_id }}.</b>
							@endif

						@endif
					</p>
				@endforeach

			</div>

		@endif

		<!-- Printing refund logs if any -->

		@if($order->refundlogs()->count() > 0)

			@foreach($order->refundlogs->sortByDesc('id') as $rlogs)

				@php
					
					$orivar2 = App\AddSubVariant::withTrashed()->find($rlogs->getorder->variant_id);
			
				@endphp

				@if($orivar2)

					<div class="alert alert-danger">
						<p><i class="fa fa-info-circle"></i> {{ date('d-m-Y | h:i A',strtotime($rlogs->updated_at)) }} • Item
							<b>{{ $orivar2->products->name }} ({{ variantname($orivar2) }}) </b> has been @if($rlogs->getorder->status == 'return_request')
								{{__("requested for return")}}
							@else
							@if($rlogs->getorder->status == 'ret_ref')
								{{__("Returned and refunded")}}
							@else
								{{ ucfirst($rlogs->getorder->status) }}
							@endif
							@endif

							@if($rlogs->method_choosen == 'orignal')

							{{__("and Amount")}} <i class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->amount }} {{__("is")}} {{ $rlogs->status }} {{__("to its orignal source with TXN ID:")}} <b>{{ $rlogs->txn_id }}</b>.


							@elseif($rlogs->method_choosen == 'bank')
							@if($rlogs->status == 'refunded')
								{{__("and Amount")}} <i class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->amount }}
								{{__("is")}} {{ $rlogs->status }} {{__("to")}} <b>{{ $rlogs->user->name }}</b> {{__("'s bank ac")}} @if(isset($rlogs->bank->acno))
								XXXX{{ substr($rlogs->bank->acno, -4) }} @endif {{__("with TXN ID:")}} <b>{{ $rlogs->txn_id }} @if($rlogs->txn_fee
									!='') <br> ({{__("TXN FEE APPLIED")}}) <b><i
											class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->txn_fee }}</b> @endif</b>.
							@else
								{{__("and Amount")}} <i class="{{ $order->paid_in }}"></i>{{ $rlogs->amount }}
								{{__("is pending to")}} <b>{{ $rlogs->user->name }}</b> {{__("'s bank ac")}} @if(isset($rlogs->bank->acno))
								XXXX{{ substr($rlogs->bank->acno, -4) }} @endif {{__('with TXN ID/REF NO:')}} <b>{{ $rlogs->txn_id }}</b>
							@if($rlogs->txn_fee !='') <br> ({{__("TXN FEE APPLIED")}}) <b><i
									class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->txn_fee }}</b> @endif.
							@endif
							@endif
						</p>
					</div>

				@endif

			@endforeach

		@endif
		
	
				<div class="row">
						<!-- ----------------------- -->
						<div class="col-md-6">
							<div class="card m-b-30 bg-primary-rgba text-muted rounded p-2 mt-2">
								<div class="card-body">
									<p class="card-text"><b>{{__("Order Placed On :")}}</b> {{ date('d/m/Y - h:i a', strtotime($order->created_at)) }}</p>
									<p class="card-text"><b>{{__("Order ID :")}}</b> {{ $inv_cus->order_prefix.$order->order_id }}</p>
									<p class="card-text"><b>{{__("Total qty. :") }}</b> {{ $order->qty_total }}</p>
									<p class="card-text"><b>{{__("Order Total :") }}</b> {{ round($order->order_total,2) }}</p>
								
								</div>
							</div>  
                        </div>
						
						<div class="col-md-6 ">
							<div class="card m-b-30 bg-primary-rgba text-muted rounded p-2 mt-2">
								<div class="card-body">
									<p class="card-text"><b>{{__("Payment method :") }}</b> {{ ucfirst($order->payment_method) }}</p>
									<p class="card-text"><b>{{__("Transcation ID :") }}</b> {{ $order->transaction_id }}</p>
									<p class="card-text"><b>{{__("Payment Received")}}</b>
									</p>

									@if($order->payment_method != 'COD' && $order->payment_method != 'BankTransfer')
									<p>{{ ucfirst($order->payment_receive) }}</p>
									@else
									<select class="form-control selected2" name="pay_confirm" id="pay_confirm">
										<option {{ $order->payment_receive == 'yes' ? "selected" : "" }} value="yes">Yes</option>
										<option {{ $order->payment_receive == 'no' ? "selected" : "" }} value="no">No</option>
									</select>
									@endif
								
								</div>
							</div>  
                    	</div>
						<!-- ----------------------- -->

						<!-- ------ Delivery Address start ----------------- -->
						<div class="col-md-6">
							<div class="card m-b-30 bg-primary-rgba text-muted rounded p-2 mt-2">
							<div class="card-header">
                                <h5 class="card-title">{{ __("Delivery Address") }}</h5>
                            </div>
								<div class="card-body">
								@if($order->shippingaddress)
									<p><b>{{ $order->shippingaddress->name }}</b></p>
									<p><i class="fa fa-envelope-o" aria-hidden="true"></i>
										<a href="mailto:{{ $order->shippingaddress->email }}">
											{{ $order->shippingaddress->email }}
										</a>
									</p>
								@if($order->shippingaddress->phone != '')
									<p><i class="fa fa-phone"></i>
										<a href="tel:{{ $order->shippingaddress->phone }}">{{ $order->shippingaddress->phone }}</a>
									</p>
								@endif
								@if(isset($order->shippingaddress->getCountry))
									<p><i class="fa fa-map-marker" aria-hidden="true"></i> 
										{{$order->shippingaddress->getcity->name ?? ''}}, 
										{{ $order->shippingaddress->getstate->name ?? '' }}, 
										{{ $order->shippingaddress->getCountry->nicename ?? '' }},
										{{ $order->shippingaddress->pin_code }}
									</p>
								@endif
							@endif
								
								</div>
							</div>  
                    	</div>
						<!-- -------- Delivery Address end --------------- -->

						<!-- ------ Billing Address start ----------------- -->
						<div class="col-md-6">
							<div class="card m-b-30 bg-primary-rgba text-muted rounded p-2 mt-2">
							<div class="card-header">
                                <h5 class="card-title">{{ __("Billing Address") }}</h5>
                            </div>
								<div class="card-body">
								<p><b>{{ $order->billing_address['firstname'] }}</b></p>
								<p><i class="fa fa-envelope-o" aria-hidden="true"></i> 
									<a href="mailto:{{ $order->billing_address['email'] }}">
										{{ $order->billing_address['email'] }}
									</a>
								</p>
								@if($order->billing_address['mobile'] != '')
									<p><i class="fa fa-phone"></i>
										<a href="tel:{{ $order->billing_address['mobile'] }}">
											{{ $order->billing_address['mobile'] }}
										</a>
									</p>
								@endif

								@php


									$c = App\Allcountry::where('id',$order->billing_address['country_id'])->first();
									$s = App\Allstate::where('id',$order->billing_address['state'])->first()->name;
									$ci = App\Allcity::where('id',$order->billing_address['city'])->first() ? App\Allcity::where('id',$order->billing_address['city'])->first()->name : '';

								@endphp

								@if($c)
									<p><i class="fa fa-map-marker" aria-hidden="true"></i> 
										{{ $ci ?? ''}}, 
										{{ $s ?? '' }}, 
										{{ $c->nicename ?? '' }},
										@if(isset($order->billing_address['pincode']))
											{{ $order->billing_address['pincode'] }}
										@endif
									</p>
								@endif
								
								</div>
							</div>  
                    	</div>
						<!-- -------- Billing Address end --------------- -->

						
					<div class="col-md-12">
						@foreach($order->invoices as $invoice)
							@if($invoice->local_pick != '' && !in_array($invoice->status,['return_request','refunded','ret_ref','Refund Pending']))
								<div class="alert alert-success">
									@if(isset($invoice->variant))
										@php
											$orivar = $invoice->variant;
										@endphp
									<i class="fa fa-info-circle"></i> {{__("For Item")}} <b>{{ $invoice->variant->products->name }} <small>
											({{ variantname($orivar) }})
						
										</small></b> @endif @if($invoice->simple_products) {{ $invoice->simple_products->product_name }} @endif {{__("Customer has choosen Local Pickup.")}} @if($invoice->status != 'delivered')
										{{__("Estd Delivery date:")}} <span id="estddate{{ $invoice->id }}">
										{{ $invoice->loc_deliv_date == '' ? __("Yet to update") : date('d-m-Y',strtotime($invoice->loc_deliv_date)) }}
						
										@else
										{{__('Item Delivered On:')}} <span id="estddate{{ $invoice->id }}">
											{{ $invoice->loc_deliv_date == '' ? __("Yet to update") : date('d-m-Y',strtotime($invoice->loc_deliv_date)) }}
											@endif
										</span>
								</div>
							@endif

							@if($invoice->local_pick !='' && !in_array($invoice->status,['delivered','return_request','refunded','ret_ref','Refund Pending']))
								
									<div class="row">
										
										<div class="col-md-6">
										<p class="font-weight-bold">{{__('Update Local Pickup Delivery dates:')}} </p>
										
											@if($invoice->variant)
											@php
												$orivar = $invoice->variant;
											@endphp
											<h4 class="text-dark font-weight-bold">{{ $invoice->variant->products->name }} <small>({{ variantname($orivar) }})</small>
											</h4>
											@endif

											@if($invoice->simple_product)
												{{ $invoice->simple_product->product_name }}
											@endif
										</div>
										<div class="col-md-6">
										<form method="POST" action="{{ route('update.local.delivery',$invoice->id) }}">
											@csrf
											<div class="row">
											<div class="col-md-8">
												<div class='input-group date lcpdate'>
													<!-- ---------- -->
													<input type="text" id="default-date" value="{{ date('Y-m-d',strtotime($invoice->loc_deliv_date)) }}" class="form-control" required="" name="del_date" />
													<div class="input-group-append">
														<span class="input-group-text" id="basic-addon2"><i class="feather icon-calendar"></i></span>
													</div>
													
													
												</div>
											</div>
												<div class="col-md-4">
													<button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>{{ __("Save")}}</button>
												</div>
											</div>

										
										</form>
										</div>
									</div>
								
								<br>
							@endif

						@endforeach
					</div>

					<!-- Order Summary -->
                   <div class="col-md-12">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>{{__("Invoice No") }}</th>
								<th>{{__("Item Name") }}</th>
								<th>{{__("Qty") }}</th>
								<th>{{__("Status") }}</th>
								<th>{{__("Pricing & Tax") }}</th>
								<th>{{__("Total") }}</th>
								<th>{{__("Action") }}</th>
						</thead>

						<tbody>
							@foreach($order->invoices as $invoice)
							<tr>
								
								<td>
									<i>{{ $inv_cus->prefix }}{{ $invoice->inv_no }}{{ $inv_cus->postfix }}</i>
								</td>

								<td>
									<div class="row">
										<div class="col-md-4">
											@if(isset($invoice->variant))
												@if($invoice->variant->variantimages)
													<img width="70px" class="object-fit"
													src="{{url('variantimages/'.$invoice->variant->variantimages['main_image'])}}" alt="">
												@else
													<img width="70px" class="object-fit"
													src="{{ Avatar::create($invoice->variant->products->name)->toBase64() }}" alt="">
												@endif
											@endif
		
											@if(isset($invoice->simple_product))
												<img width="60px" class="object-fit" src="{{url('images/simple_products/'.$invoice->simple_product['thumbnail'])}}" alt="">
											@endif
										</div>
		
										<div class="col-md-8">
											@if(isset($invoice->variant))
											
											<a class="text-justify" target="_blank" 
												href="{{ App\Helpers\ProductUrl::getUrl($invoice->variant->id) }}"><b>{{substr($invoice->variant->products->name, 0, 25)}}{{strlen($invoice->variant->products->name)>25 ? '...' : ""}}</b>
		
												<small>
												
													({{ variantname($invoice->variant) }})
		
												</small>
											</a>
											@endif
		
											@if($invoice->simple_product)
											<a class="text-justify" href="{{ route('show.product',['id' => $invoice->simple_product->id, 'slug' => $invoice->simple_product->slug]) }}" target="_blank">
												<b>{{ $invoice->simple_product->product_name }}</b>
											</a>
											@endif
											<br>
											@if($invoice->variant)
											<small><b>{{__('Sold By:') }}</b> {{$invoice->variant->products->store->name}}</small>
											@endif
		
											@if($invoice->simple_product)
												<small><b>{{__('Sold By:') }}</b> {{$invoice->simple_product->store->name}}</small>
											@endif
											<br>
											<small><b>{{ __('Price:') }}</b>
												<i class="{{ $invoice->order->paid_in }}"></i>
		
												{{ round(($invoice->price),2) }}
		
											</small>
											<br>
											<small><b>{{ __("Tax:") }}</b> <i class="{{ $invoice->order->paid_in }}"></i>{{ round($invoice->tax_amount,2) }}</small>
		
										</div>
									</div>
								</td>

								<td>
									{{ $invoice->qty }}
								</td>

								<td>	
									<div id="singleorderstatus{{ $invoice->id }}">
										@if($invoice->status == 'delivered')
										<span class="badge badge-pill badge-success">{{ ucfirst($invoice->status) }}</span>
										@elseif($invoice->status == 'processed')
										<span class="badge badge-pill badge-info">{{ ucfirst($invoice->status) }}</span>
										@elseif($invoice->status == 'shipped')
										<span class="badge badge-pill badge-primary">{{ ucfirst($invoice->status) }}</span>
										@elseif($invoice->status == 'return_request')
										<span class="badge badge-pill badge-warning">
											{{__("Return Requested")}}
										</span>
										@elseif($invoice->status == 'returned')
										<span class="badge badge-pill badge-success">
											{{__("Returned")}}
										</span>
										@elseif($invoice->status == 'cancel_request')
										<span class="badge badge-pill badge-warning">
											{{__("Cancelation Request")}}
										</span>
										@elseif($invoice->status == 'canceled')
										<span class="badge badge-pill badge-danger">
											{{__('Canceled')}}
										</span>
										@elseif($invoice->status == 'refunded')
										<span class="badge badge-pill badge-danger">
											{{__("Refunded")}}
										</span>
										@elseif($invoice->status == 'ret_ref')
										<span class="badge badge-pill badge-success">
											{{__("Return & Refunded")}}
										</span>
										@else
										<span class="badge badge-pill badge-default">{{ ucfirst($invoice->status) }}</span>
										@endif

									</div>

									<br>

										@if($invoice->status == 'Refund Pending' || $invoice->status == 'canceled' || $invoice->status == 'refunded' || $invoice->status == 'returned' || $invoice->status == 'refunded' || $invoice->status == 'ret_ref' || $invoice->status == 'return_request')
										<select disabled="" class="form-control select2">
											<option {{ $invoice->status =="pending" ? "selected" : "" }} value="pending"> {{__('Pending')}}
											</option>
											<option {{ $invoice->status =="processed" ? "selected" : "" }} value="processed"> {{__('Processed')}}
											</option>
											<option {{ $invoice->status =="delivered" ? "selected" : "" }} value="delivered"> {{__("Delivered")}}
											</option>

											<option {{ $invoice->status =="return_request" ? "selected" : "" }} value="return_request">
												{{__('Return Requested')}}
											</option>
											<option {{ $invoice->status =="returned" ? "selected" : "" }} value="returned"> {{__("Returned")}}
											</option>
											<option {{ $invoice->status =="cancel_request" ? "selected" : "" }} value="cancel_request">
												{{__("Canceled Request")}}
												</option>

											<option {{ $invoice->status =="canceled" ? "selected" : "" }} value="canceled"> {{__('Canceled')}}
											</option>

											<option {{ $invoice->status =="refunded" ? "selected" : "" }} value="refunded"> {{__('Refunded')}}
											</option>

											<option {{ $invoice->status =="Refund Pending" ? "selected" : "" }} value="refunded"> {{__("Refund pending")}}
											</option>

											<option {{ $invoice->status =="ret_ref" ? "selected" : "" }} value="refunded">
												{{__("Return & Refunded")}}
											</option>

										</select>
										@else
										<select data-placeholder="{{ __("Change order status") }}" name="status" id="status{{ $invoice->id }}" onchange="changeStatus('{{ $invoice->id }}')" class="select2 form-control">
											<option value="">{{ __("Change order status") }}</option>
											<option {{ $invoice->status =="pending" ? "selected" : "" }} value="pending"> {{ __("Pending") }}
											</option>
											<option {{ $invoice->status =="processed" ? "selected" : "" }} value="processed"> {{__("Processed")}}
											</option>
											<option {{ $invoice->status =="delivered" ? "selected" : "" }} value="delivered"> {{__("Delivered")}}
											</option>

										</select>
										@endif
								</td>

								<td>
									<b>{{ __("Total Price:") }}</b> <i class="{{ $invoice->order->paid_in }}"></i>

									{{ round(($invoice->price*$invoice->qty),2) }}

									<p></p>
									<b>{{ __("Total Tax:") }}</b> <i
										class="{{ $invoice->order->paid_in }}"></i>{{ round(($invoice->tax_amount),2) }}
									<p></p>
									<b>{{ __("Shipping Charges:") }}</b> <i
										class="{{ $invoice->order->paid_in }}"></i>{{ round($invoice->shipping,2) }}
									<p></p>


									<small class="help-block">({{__("Price & TAX Multiplied with Quantity")}})</small>
									<p></p>
								</td>

								<td>
									<i class="{{ $invoice->order->paid_in }}"></i>
			
									{{ round($invoice->qty*($invoice->price+$invoice->tax_amount)+$invoice->shipping,2) }}
			
									<br>
									<small>
										{{__("(Incl. of TAX & Shipping)")}}
									</small>
								</td>

								<td>
								<!-- ------------------------------ -->
								<div class="dropdown">
									<button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
									<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
										
										@if(!in_array($invoice->status,['canceled','delivered','Refund Pending','ret_ref','refunded','return_request']))
											<li role="presentation">
												<a class="dropdown-item" href="{{ route("update.invoice",$invoice->id) }}">
													<i class="fa fa-truck"></i> {{$invoice->status != 'shipped' ? __("Ship") : __("Edit Shipping") }}
												</a>
											</li>
										@endif

										@if(isset($invoice->variant) && $invoice->variant->products->cancel_avl != 0 && !in_array($invoice->status,['shipped','canceled','delivered','Refund Pending','ret_ref','refunded','return_request','shipped']))

										
											<li class="divider"></li>
											<li role="presentation">

												<a role="button" class="dropdown-item" id="canbtn{{ $invoice->id }}" data-toggle="modal"
													data-target="#singleordercancel{{ $invoice->id }}"  title="Cancel this order?">
													<i class="fa fa-ban"></i> {{__("Cancel")}}
												</a>

											</li>


										@endif

									
										@if(isset($invoice->simple_product) && $invoice->simple_product->cancel_avbl != 0 && !in_array($invoice->status,['shipped','canceled','delivered','Refund Pending','ret_ref','refunded','return_request','shipped']))

													<div class="divider"></div>
													<li role="presentation">

														<a role="button" class="dropdown-item" id="canbtn{{ $invoice->id }}" data-toggle="modal"
															data-target="#singleordercancel{{ $invoice->id }}"  title="{{ __("Cancel this order?") }}">
															<i class="fa fa-ban"></i> {{__("Cancel")}}
														</a>

													</li>


										@endif

									</div>
								</div>
								<!-- ------------------------------ -->
		
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</div>

		<div class="col-md-12 ml-2">
			<h4>
				{{__("Order Activity Logs")}}
			</h4>

		    @if(count($order->orderlogs) < 1) <span id="ifnologs"> {{__("No activity logs for this order")}} <br></span>

			@endif

			<small><b>#{{ $inv_cus->order_prefix }}{{ $order->order_id }}</b><br></small>

			<span id="logs">
				@foreach($order->orderlogs->sortByDesc('id') as $logs)
					@if(isset($logs->variant))
					@php
						$findinvoice = App\InvoiceDownload::find($logs->inv_id)->first();
						$orivar = App\AddSubVariant::withTrashed()->withTrashed()->find($logs->variant_id);

						if($order->payment_method !='COD'){

							if(isset($cancellog)){
								$findinvoice2 = App\InvoiceDownload::where('id','=',$cancellog->inv_id)->first();
								$orivar2 = App\AddSubVariant::withTrashed()->withTrashed()->findorfail($findinvoice2->variant_id);
							}
						}
					@endphp
					<small>{{ date('d-m-Y | h:i:a',strtotime($logs->updated_at)) }} • For Order
						<b>{{ $orivar->products->name }} ({{variantname($orivar)}}) </b>
						: @if($logs->user->role_id == 'a')
						<span class="text-danger"><b>{{ $logs->user->name }}</b> ({{__('Admin')}})</span> {{__("changed")}} {{__("status to")}}
						<b>{{ $logs->log }}</b>
						@elseif($logs->user->role_id == 'v')
						<span class="text-primary"><b>{{ $logs->user->name }}</b> ({{__("Vendor")}})</span> {{__("changed")}} {{__("status to")}}
						<b>{{ $logs->log }}</b>
						@else
						<span class="text-success"><b>{{ $logs->user->name }}</b> ({{__("Customer")}})</span> {{__("changed")}} {{__("status to")}}
						<b>{{ $logs->log }}</b>
						@endif

					</small>
					@endif

					@if(isset($logs->simple_product))
						<small>{{ date('d-m-Y | h:i:a',strtotime($logs->updated_at)) }} • For Order Item <b>{{ $logs->simple_product->product_name }}</b> @if($logs->user->role_id == 'a')
							<span class="text-danger"><b>{{ $logs->user->name }}</b> (Admin)</span> {{__("changed status to")}}
							<b>{{ $logs->log }}</b>
							@elseif($logs->user->role_id == 'v')
							<span class="text-primary"><b>{{ $logs->user->name }}</b> (Vendor)</span> {{__("changed status to")}}
							<b>{{ $logs->log }}</b>
							@else
							<span class="text-success"><b>{{ $logs->user->name }}</b> (Customer)</span> {{__("changed status to")}}
							<b>{{ $logs->log }}</b>
							@endif </small>
					@endif

				<p></p>
				@endforeach
			</span>
		</div>
        
         <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>
@foreach($order->invoices as $o)

	@if(!in_array($o->status,['shipped','canceled','delivered','Refund Pending','ret_ref','refunded','return_request']))
		
		<div data-backdrop="static" data-keyboard="false" class="modal fade" id="singleordercancel{{ $o->id }}" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
							{{__("Cancel Item: ")}}

							@if(isset($o->simple_product))
								{{ $o->simple_product->product_name }}
							@endif

							@if(isset($o->variant))
								{{$o->variant->products->name}}
								({{ variantname($o->variant) }})
							@endif
						</h4>
						<button type="button" class="float-right close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
						
					</div>

					<div class="modal-body">
					
						
						<form action="{{ route('cancel.item', Crypt::encrypt($o->id)) }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="">{{__('Choose Reason')}} <span class="required">*</span></label>
								<select class="form-control" required="" name="comment" id="">
									 <option value="">{{ __('staticwords.PleaseChooseReason') }}</option>
			  
									  @forelse(App\RMA::where('status','=','1')->get() as $rma)
										<option value="{{ $rma->reason }}">{{ $rma->reason }}</option>
									  @empty
										<option value="Other">{{ __('My Reason is not listed here') }}</option>
									  @endforelse
									  
								</select>
							</div>
							@if($order->payment_method !='COD' && $order->payment_method !=' BankTransfer')
							<div class="form-group">

								<label for="">{{ __("Choose Refund Method:") }}</label>
								<label><input onclick="hideBank('{{ $o->id }}')" id="source_check_o{{ $o->id }}" required
										type="radio" value="orignal" name="source" />Orignal Source
									[{{ $o->order->payment_method }}] </label>&nbsp;&nbsp;
								@if($order->user->banks->count()>0)
								<label><input onclick="showBank('{{ $o->id }}')" id="source_check_b{{ $o->id }}" required
										type="radio" value="bank" name="source" />{{__("In Bank")}} </label>
								@else
								<label><input disabled="disabled" type="radio" /> {{__("In Bank")}} <i class="fa fa-question-circle"
										data-toggle="tooltip" data-placement="right"
										title="{{ __("Add a bank account in My Bank Account") }}" aria-hidden="true"></i></label>
								@endif

								<select name="bank_id" id="bank_id_single{{ $o->id }}" class="form-control display-none">
									@foreach($order->user->banks as $bank)
									<option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
									@endforeach
								</select>

							</div>


							@else

							@if($order->user->banks->count()>0)
							<label><input onclick="showBank('{{ $o->id }}')" id="source_check_b{{ $o->id }}" required
									type="radio" value="bank" name="source" />{{_("In Bank")}} </label>
							@else
							<label><input disabled="disabled" type="radio" /> {{__("In Bank")}} <i class="fa fa-question-circle"
									data-toggle="tooltip" data-placement="right" title="Add a bank account in My Bank Account"
									aria-hidden="true"></i></label>
							@endif

							<select name="bank_id" id="bank_id_single{{ $o->id }}" class="display-none form-control">
								@foreach($order->user->banks as $bank)
								<option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
								@endforeach
							</select>


							@endif

							<div class="alert alert-info">
								<h5><i class="fa fa-info-circle"></i> {{ __("Important !") }}</h5>

								<ol class="ol">
									<li>
										{{__('IF Original source is choosen than amount will be reflected to User\'s orignal source in 1-2 days(approx).')}}
									</li>

									<li>
										{{__("IF Bank Method is choosen than make sure User added a bank account else refund will not procced. IF already added than it will take 14 days to reflect amount in users bank account (Working Days*).")}}
									</li>

									<li>
										{{__("Amount will be paid in original currency which used at time of placed order.")}}
									</li>

								</ol>
							</div>
							<button type="submit" class="btn btn-md btn-primary">
								{{__("Procced")}}...
							</button>
							<p></p>
							<p class="bg-danger-rgba p-3 help-block">
								{{__("This action cannot be undone !")}}
							</p>
							<p class="bg-danger-rgba p-3 help-block">
								{{__("It will take time please do not close or refresh window !")}}
							</p>
						</form>

						

					</div>


				</div>
			</div>
		</div>
			
	@endif

@endforeach

@endsection
@section('custom-script')
<script>
	var url 	 = @json(url('/update/orderstatus'));
	var userrole = @json(auth()->user()->role_id);
	var username = @json(auth()->user()->name);
	var orderid  = @json($order->id);
</script>
<script src="{{ url('js/editorder.js') }}"></script>
<script src="{{ url('js/order.js') }}"></script>
@endsection
