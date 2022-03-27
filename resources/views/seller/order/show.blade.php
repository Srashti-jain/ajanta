@extends("admin.layouts.sellermastersoyuz")
@section('title',__('View order',['orderid' => $inv_cus->order_prefix.$order->order_id]))
@section('stylesheet')
	<link rel="stylesheet" href="{{ url("/css/lightbox.min.css") }}">
@endsection
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
{{ __('View Order ') }}
@endslot
@slot('menu1')
{{ __('View Order ') }}
@endslot



@endcomponent

<div class="contentbar">
	<div class="row">

		<div class="col-lg-12">
			<div class="card m-b-30">
				<div class="card-header">
					<div class="row">
						<div class="col-md-8">
							<h5 class="card-title">
								{{ __('View order',['orderid' => $inv_cus->order_prefix.$order->order_id]) }}
							</h5>
						</div>
						<div class="col-md-4">
							<a title="Print Order" href="{{ route('seller.print.order',$order->id) }}"
								class="btn btn-primary-rgba pull-right"><i class="fa fa-print"></i> {{ __("Print") }}</a>

							<a title="Edit Order" href="{{ route('seller.order.edit',$order->order_id) }}"
								class="btn btn-success-rgba pull-right mr-2"><i class="fa fa-pencil"></i> 
								{{__("Edit")}}
							</a>
						</div>
					</div>


				</div>
				<div class="card-body">

					<!-- Check if manual payment done -->

					@if($order->manual_payment == '1')
					<div class="alert alert-info p-3">
						<i class="fa fa-info-circle"></i> {{__("This order is placed using")}}
						{{ ucfirst($order->payment_method) }} {{__("method and purchase proof you can view")}} <a
							href="{{ url('images/purchase_proof/'.$order->purchase_proof) }}" data-lightbox="image-1"
							data-title="{{__("Purchase proof for")}} {{ $order->order_id }}"> <b>{{ __("here") }}</b> </a>
						{{__("and")}} {{__("after verify you can change the order status")}}.
					</div>
					@endif

					<!-- Printing Cancellogs of order -->

					@if($order->cancellog->count()>0)
					<div class="alert alert-danger">
						@foreach($order->cancellog->sortByDesc('id') as $cancellog)


						<p><i class="fa fa-info-circle"></i>
							{{ date('d-m-Y | h:i A',strtotime($cancellog->updated_at)) }} • Item
							@if(isset($cancellog->singleOrder->variant))
							<b>{{ $cancellog->singleOrder->variant->products->name }}({{ variantname($cancellog->singleOrder->variant->variant) }})
								@else {{ $cancellog->singleOrder->simple_product->product_name }} </b> @endif {{__('has been canceled')}}

							@if($cancellog->method_choosen == 'orignal')

							{{__('and Amount')}} <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
							{{__('is refunded to its orignal source with TXN ID')}}: <b>{{ $cancellog->transaction_id }}</b>.


							@elseif($cancellog->method_choosen == 'bank')
							@if($cancellog->is_refunded == 'completed')
							{{__('and Amount')}} <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
							{{__("is refunded to")}} <b>{{ $cancellog->user->name }}'s</b> {{__('bank ac')}}
							@if(isset($cancellog->bank->acno))
							XXXX{{ substr($cancellog->bank->acno, -4) }} @endif with TXN ID
							<b>{{ $cancellog->transaction_id }}
								@if($cancellog->txn_fee !='') <br> (TXN FEE APPLIED) <b><i
										class="{{ $order->paid_in }}"></i>{{ $cancellog->txn_fee }}</b> @endif</b>.
							@else
							{{__('and Amount')}} <i class="{{ $order->paid_in }}"></i>{{ $cancellog->amount }}
							{{__('is pending to')}} <b>{{ $cancellog->user->name }}'s</b> {{__('bank ac')}}
							XXXX{{ substr($cancellog->bank->acno, -4) }}
							{{__('with TXN ID/REF NO')}} <b>{{ $cancellog->transaction_id }}</b> @if($cancellog->txn_fee !='')
							<br> ({{__('TXN FEE APPLIED')}}) <b><i class="{{ $order->paid_in }}"></i>{{ $cancellog->txn_fee }}</b> @endif.
							@endif
							@endif
						</p>
						@endforeach
					</div>
					@endif

					<!-- Printing Refund logs of order -->

					@if($order->refundlogs->count()>0)

						@foreach($order->refundlogs->sortByDesc('id') as $rlogs)

							<div class="alert alert-danger">



								<p><i class="fa fa-info-circle"></i> {{ date('d-m-Y | h:i A',strtotime($rlogs->updated_at)) }} •
									{{__('Item')}}
									@if(isset($rlogs->getorder->variant))
									<b>{{ $rlogs->getorder->variant->products->name }}({{ variantname($rlogs->getorder->variant) }})
										@else {{ $rlogs->getorder->simple_product->product_name }} </b> @endif {{__("has been")}}
									@if($rlogs->getorder->status
									== 'return_request')
									{{__('requested for return')}}
									@else
									@if($rlogs->getorder->status == 'ret_ref')
									{{__("Returned and refunded")}}
									@else
									{{ ucfirst($rlogs->getorder->status) }}
									@endif
									@endif

									@if($rlogs->method_choosen == 'orignal')

									{{__('and amount')}} <i class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->amount }}
									is {{ $rlogs->status }} {{ __('to its orignal source with TXN ID') }}: <b>{{ $rlogs->txn_id }}</b>.


									@elseif($rlogs->method_choosen == 'bank')
									@if($rlogs->status == 'refunded')
									{{__('and amount')}} <i class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->amount }}
									is {{ $rlogs->status }} to <b>{{ $rlogs->user->name }}'s</b> bank ac
									@if(isset($rlogs->bank->acno))
									XXXX{{ substr($rlogs->bank->acno, -4) }} @endif with TXN ID: <b>{{ $rlogs->txn_id }}
										@if($rlogs->txn_fee
										!='') <br> ({{ __('TXN FEE APPLIED') }}) <b><i
												class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->txn_fee }}</b>
										@endif</b>.
									@else
									{{__('and amount')}} <i class="{{ $order->paid_in }}"></i>{{ $rlogs->amount }}
									{{__('is pending to')}} <b>{{ $rlogs->user->name }}'s</b> {{__('bank ac')}} @if(isset($rlogs->bank->acno))
									XXXX{{ substr($rlogs->bank->acno, -4) }} @endif {{__('with TXN ID/REF NO')}}:
									<b>{{ $rlogs->txn_id }}</b>
									@if($rlogs->txn_fee !='') <br> ({{ __('TXN FEE APPLIED') }}) <b><i
											class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->txn_fee }}</b> @endif.
									@endif
									@endif</p>
							</div>

						@endforeach

					@endif


					<table class="table table-striped">
						<thead>
							<tr>
								<th>
									{{__('Customer Information')}}
								</th>
								<th>
									{{__('Shipping Address')}}
								</th>
								<th>
									{{__("Billing Address")}}
								</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>

									@php

										$user = $order->user;

										$address = $order->shippingaddress;

									@endphp

									<p><b>{{$user->name}}</b></p>
									<p><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $user->email }}</p>
									@if(isset($user->mobile))
									<p><i class="fa fa-phone"></i> {{$user->mobile}}</p>
									@endif

									<p><i class="fa fa-map-marker" aria-hidden="true"></i>
										{{$user->city ? $user->city->name.',' : ""}}
										{{$user->state ? $user->state->name.',' : ""}}
										{{$user->country ? $user->country->nicename : ""}}
									</p>


								</td>
								<td>
									<p><b>{{ $address->name }}, {{ $address->phone }}</b></p>
									<p class="font-weight600">{{ strip_tags($address->address) }},</p>
									@php

									$user = $order->user;

									$c = App\Allcountry::where('id',$address->country_id)->first()->nicename;
									$s = App\Allstate::where('id',$address->state_id)->first()->name;
									$ci = App\Allcity::where('id',$address->city_id)->first() ?
									App\Allcity::where('id',$address->city_id)->first()->name : '';

									@endphp
									<p class="font-weight600">{{ $ci }}, {{ $s }}, {{ $ci }}</p>
									<p class="font-weight600">{{ $address->pin_code }}</p>
								</td>
								<td>
									<p><b>{{ $order->billing_address['firstname'] }},
											{{ $order->billing_address['mobile'] }}</b>
									</p>
									<p class="font-weight600">{{ strip_tags($order->billing_address['address']) }},</p>
									@php


									$c =
									App\Allcountry::where('id',$order->billing_address['country_id'])->first()->nicename;
									$s = App\Allstate::where('id',$order->billing_address['state'])->first()->name;
									$ci = App\Allcity::where('id',$order->billing_address['city'])->first() ?
									App\Allcity::where('id',$order->billing_address['city'])->first()->name : '';

									@endphp
									<p class="font-weight600">{{ $ci }}, {{ $s }}, {{ $ci }}</p>
									<p class="font-weight600">
										@if(isset($order->billing_address['pincode']))
										{{ $order->billing_address['pincode'] }}
										@endif
									</p>
								</td>
							</tr>
						</tbody>
					</table>

					<table class="table table-striped">
						<thead>
							<th>
								{{__("Order Summary")}}
							</th>
							<th></th>

							<th></th>
						</thead>

						<tbody>
							<tr>
								<td>
									<p><b>{{__("Total Qty")}}:</b> {{ $x->sum('qty') }}</p>
									</p>
									<p><b>{{__('Order Total')}}: <i
												class="{{ $order->paid_in }}"></i>{{ sprintf("%.2f",$total) }}</b>
									</p>
									<p><b>{{__('Payment Recieved')}}:</b> {{ ucfirst($order->payment_receive)  }}</p>
								</td>

								<td>
									<p><b>{{__("Payment Method")}}: </b> {{ ucfirst($order->payment_method) }}
										<p><b>{{ __('Transcation ID') }}:</b> <b><i>{{ $order->transaction_id }}</i></b></p>


								</td>

								<td>
									<p><b>{{ __('Order Date') }}:</b> {{ date('d/m/Y @ h:i a', strtotime($order->created_at)) }}</p>
								</td>
							</tr>
						</tbody>
					</table>

					@foreach($x as $invoice)
					@if($invoice->local_pick != '' && !in_array($invoice->status,['canceled','delivered','Refund
					Pending','ret_ref','refunded','return_request']))
					<div class="alert alert-success">
						@if(isset($invoice->variant))
						@php
						$varcount = count($invoice->variant->main_attr_value);
						@endphp
						<i class="fa fa-info-circle"></i> For Item <b>{{ $invoice->variant->products->name }} <small>
								({{ variantname($invoice->variant) }})

							</small></b> @endif @if($invoice->simple_products)
						{{ $invoice->simple_products->product_name }} @endif {{__("Customer has choosen Local Pickup")}}.
						@if($invoice->status != 'delivered')
						{{__("Estimated Delivery date")}}: <span id="estddate{{ $invoice->id }}">
							{{ $invoice->loc_deliv_date == '' ? __("Yet to update") : date('d-m-Y',strtotime($invoice->loc_deliv_date)) }}

							@else
							{{__("Item Delivered On")}}: <span id="estddate{{ $invoice->id }}">
								{{ $invoice->loc_deliv_date == '' ? __("Yet to update") : date('d-m-Y',strtotime($invoice->loc_deliv_date)) }}
								@endif
							</span>
					</div>
					@endif
					@endforeach

					<table class="table table-striped">
						<thead>
							<th>
								{{__('Order Details')}}
							</th>
						</thead>
					</table>

					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>{{ __('Invoice Nos') }}</th>
								<th>{{ __('Item Name') }}</th>
								<th>{{ __('Qty') }}</th>
								<th>{{ __('Status') }}</th>
								<th>{{ __('Pricing & Tax') }}</th>
								<th>{{ __('Total') }}</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>
							@foreach($x as $invoice)
							<tr>
								<td>
									<i>{{ $inv_cus->prefix }}{{ $invoice->inv_no }}{{ $inv_cus->postfix }}</i>
								</td>

								<td>


									<div class="row">
										<div class="col-md-4">
											@if(isset($invoice->variant))
											@php
												$orivar = $invoice->variant;
											@endphp
											@if($invoice->variant->variantimages)
											<img width="70px" class="object-fit"
												src="{{url('variantimages/'.$orivar->variantimages['main_image'])}}"
												alt="">
											@else
											<img  width="70px" class="object-fit"
												src="{{ Avatar::create($orivar->products->name)->toBase64() }}" alt="">
											@endif
											@endif

											@if(isset($invoice->simple_product))
											<img  width="70px" class="object-fit"
												src="{{url('images/simple_products/'.$invoice->simple_product['thumbnail'])}}"
												alt="">
											@endif
										</div>

										<div class="col-md-8">
											@if(isset($invoice->variant))
											<a class="text-justify mleft22" target="_blank"
												href="{{ App\Helpers\ProductUrl::getUrl($orivar->id) }}"><b>{{substr($orivar->products->name, 0, 25)}}{{strlen($orivar->products->name)>25 ? '...' : ""}}</b>

												<small>
													({{ variantname($orivar) }})

												</small>
											</a>
											@endif

											@if($invoice->simple_product)
											<a class="text-dark"
												href="{{ route('show.product',['id' => $invoice->simple_product->id, 'slug' => $invoice->simple_product->slug]) }}"
												target="_blank">
												<b>{{ $invoice->simple_product->product_name }}</b>
											</a>
											@endif

											<br>
											@if($invoice->variant)
											<small class="mleft22"><b>{{ __('Sold By') }}:</b>
												{{$invoice->variant->products->store->name}}</small>
											@endif

											@if($invoice->simple_product)
											<small class="mleft22"><b>{{ __('Sold By') }}:</b>
												{{$invoice->simple_product->store->name}}</small>
											@endif
											<br>
											<small class="mleft22"><b>Price: </b> <i
													class="{{ $invoice->order->paid_in }}"></i>

												{{ round(($invoice->price),2) }}

											</small>

											<br>

											<small class="mleft22"><b>{{ __("Tax") }}:</b> <i
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
									<span class="label label-success">{{ ucfirst($invoice->status) }}</span>
									@elseif($invoice->status == 'processed')
									<span class="label label-info">{{ ucfirst($invoice->status) }}</span>
									@elseif($invoice->status == 'shipped')
									<span class="label label-primary">{{ ucfirst($invoice->status) }}</span>
									@elseif($invoice->status == 'return_request')
									<span class="label label-warning">{{ __('Return Request') }}</span>
									@elseif($invoice->status == 'returned')
									<span class="label label-success">{{ __('Returned') }}</span>
									@elseif($invoice->status == 'cancel_request')
									<span class="label label-warning">{{ __('Cancelation Request') }}</span>
									@elseif($invoice->status == 'canceled')
									<span class="label label-danger">{{ __('Canceled') }}</span>
									@elseif($invoice->status == 'refunded')
									<span class="label label-primary">{{ __('Refunded') }}</span>
									@elseif($invoice->status == 'ret_ref')
									<span class="label label-success">{{ __('Returned & Refunded') }}</span>
									@else
									<span class="label label-default">{{ ucfirst($invoice->status) }}</span>
									@endif
								</td>

								<td>
									<b>{{ __('Total Price') }}:</b> <i class="{{ $invoice->order->paid_in }}"></i>

									{{ round(($invoice->price*$invoice->qty),2) }}

									<p></p>
									<b>{{__("Total Tax")}}:</b> <i
										class="{{ $invoice->order->paid_in }}"></i>{{ round(($invoice->tax_amount * $invoice->qty),2) }}
									<p></p>
									<b>{{__("Shipping Charges")}}:</b> <i
										class="{{ $invoice->order->paid_in }}"></i>{{ round($invoice->shipping,2) }}
									<p></p>


									<small class="help-block">({{__("Price & TAX Multiplied with Quantity")}})</small>
									<p></p>


								</td>


								<td>
									<i class="{{ $invoice->order->paid_in }}"></i>

									{{ sprintf("%.2f",$invoice->qty*($invoice->price+$invoice->tax_amount)+$invoice->shipping,2) }}

									<br>

									<small>({{__('Incl. of TAX & Shipping')}})</small>
								</td>

								<th>
									<a href="{{ route('seller.print.invoice',['orderid' => $order->order_id, 'id' => $invoice->id]) }}"
										title="{{ __("Print Invoice") }}" href="#" class="btn btn-primary">
										<i class="fa fa-print"></i>
									</a>
								</th>
							</tr>
							@endforeach

							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b>{{ __('Subtotal') }}</b></td>
								<td><b><i class="{{ $invoice->order->paid_in }}"></i>{{ $total - $hc - $giftcharge }}</b>
								</td>
								<td></td>
							</tr>

							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b>{{ __('Coupon Discount') }}</b></td>
								<td><b> - <i
											class="{{ $invoice->order->paid_in }}"></i>{{ round($order->discount,2) }}</b>
									({{ $order->coupon }})</td>
								<td></td>
							</tr>

							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b>{{ __('Gift Packaging Charge') }}</b></td>
								<td><b>+ <i class="{{ $invoice->order->paid_in }}"></i>{{ round($giftcharge,2) }}</b>
								</td>
								<td></td>
							</tr>

							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b>{{ __('Handling Charge') }}</b></td>
								<td><b>+ <i class="{{ $invoice->order->paid_in }}"></i>{{ round($hc,2) }}</b>
								</td>
								<td></td>
							</tr>

							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b>{{ __('Grand Total') }}</b></td>
								<td><b><i class="{{ $invoice->order->paid_in }}"></i>

										{{ round($total,2) }}

									</b></td>
								<td></td>
							</tr>
						</tbody>
					</table>

					<div class="box-body">
						<h4>
							{{__("Order Activity Logs")}}
						</h4>

						@if(count($order->orderlogs) < 1) <span id="ifnologs">No activity logs for this orde</span>

							@endif


							<small><b>#{{ $inv_cus->order_prefix }}{{ $order->order_id }}</b><br></small>

							<span id="logs">


								@foreach($order->orderlogs->sortByDesc('id') as $logs)

								@if(isset($logs->variant))

								@php

								$findinvoice = App\InvoiceDownload::find($logs->inv_id)->first();
								$orivar = App\AddSubVariant::withTrashed()->withTrashed()->find($logs->variant_id);

								if($order->payment_method != 'COD'){

								if(isset($cancellog)){
								$findinvoice2 = App\InvoiceDownload::where('id','=',$cancellog->inv_id)->first();
								$orivar2 =
								App\AddSubVariant::withTrashed()->withTrashed()->findorfail($findinvoice2->variant_id);
								}

								}

								@endphp


								@if($logs->variant->products->vender_id == Auth::user()->id)

								<small>{{ date('d-m-Y | h:i:a',strtotime($logs->updated_at)) }} • For Order
									<b>{{ $orivar->products->name }} ({{variantname($orivar)}}) </b>
									: @if($logs->user->role_id == 'a')
									<span class="text-danger"><b>{{ $logs->user->name }}</b> ({{ __('Admin') }})</span> {{__('changed status to')}}
									<b>{{ $logs->log }}</b>
									@elseif($logs->user->role_id == 'v')
									<span class="text-primary"><b>{{ $logs->user->name }}</b> ({{__('Vendor')}})</span> {{__('changed status to')}}
									<b>{{ $logs->log }}</b>
									@else
									<span class="text-success"><b>{{ $logs->user->name }}</b> ({{__('Customer')}})</span> {{__('changed status to')}}
									<b>{{ $logs->log }}</b>
									@endif

								</small>

								@endif

								@endif

								@if(isset($logs->simple_product) && $logs->simple_product->store->user->id ==
								auth()->id())
								<small>{{ date('d-m-Y | h:i:a',strtotime($logs->updated_at)) }} • {{__("For Order Item")}}
									<b>{{ $logs->simple_product->product_name }}</b> @if($logs->user->role_id == 'a')
									<span class="text-danger"><b>{{ $logs->user->name }}</b> ({{__("Admin")}})</span> {{__('changed status to')}}
									<b>{{ $logs->log }}</b>
									@elseif($logs->user->role_id == 'v')
									<span class="text-primary"><b>{{ $logs->user->name }}</b> ({{__('Vendor')}})</span> {{__('changed status to')}}
									<b>{{ $logs->log }}</b>
									@else
									<span class="text-success"><b>{{ $logs->user->name }}</b> ({{__('Customer')}})</span> {{__('changed status to')}}
									<b>{{ $logs->log }}</b>
									@endif </small>
								@endif

								<p></p>
								@endforeach
							</span>
					</div>



				</div>


			</div>
		</div>
	</div>

@endsection


@section('custom-script')
<script src='{{ url('js/lightbox.min.js') }}' type='text/javascript'></script>
<script>
	var url = @json(url('/update/orderstatus'));
	var userrole = @json(auth()->user()->role_id);
	var username = @json(auth()->user()->name);
	var orderid = @json($order->id);
</script>
<script src="{{ url('js/editorder.js') }}"></script>
<script src="{{ url('js/order.js') }}"></script>
@endsection