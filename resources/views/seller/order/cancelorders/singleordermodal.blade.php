@foreach($sellercanorders as $key=> $order)
<div class="modal fade" id="ordertrack{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				
				<h4 class="modal-title" id="myModalLabel"> {{__('Track REFUND FOR ORDER')}}
					<b>#{{ $inv_cus->order_prefix.$order->order->order_id }}</b> | {{__('TXN ID')}} :
					<b>{{  $order->transaction_id }}</b></h4>

					<button type="button" class="float-right close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div id="refundArea{{ $order->id }}">

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					{{__('Close')}}
				</button>
				<button onclick="trackrefund('{{ $order->id }}')" type="button" class="btn btn-primary"><i
						class="fa fa-refresh" aria-hidden="true"></i> {{ __('REFRESH') }}</button>
			</div>
		</div>
	</div>
</div>

<!-- UPDATE ORDER Modal -->
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="orderupdate{{ $order->id }}" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"> {{__('UPDATE ORDER')}}
					<b>#{{ $inv_cus->order_prefix.$order->order->order_id }}</b></h4>
				<button type="button" class="float-right close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				
			</div>
			<div class="modal-body">
				<h4><b>{{ __('Order Summary') }}</b></h4>
				<hr>
				<div class="bg-primary-rgba p-3 row">
					<div class="col-md-3"><b>{{ __('Customer name') }}</b></div>
					<div class="col-md-3"><b>{{ __('Cancel Order Date') }}</b></div>
					<div class="col-md-3"><b>{{ __('Cancel Order Total') }}</b></div>
					<div class="col-md-3"><b>{{ __('REFUND Transcation ID /REF. ID') }}</b></div>

					@php

						$realamount = round($order->singleorder->qty*$order->singleorder->price+$order->singleorder->tax_amount+$order->singleorder->shipping,2);

					@endphp

					<div class="col-md-3">{{ $user = App\User::find($order->order->user_id)->name }}</div>
					<div class="col-md-3">{{ date('d-m-Y @ h:i A',strtotime($order->created_at)) }}</div>
					<div class="col-md-3">
						<p>{{__("Order Total")}}: <i class="{{ $order->order->paid_in }}"></i>{{ $realamount }}</p>

						@if($order->order->handlingcharge != 0)
						<p>{{__("Handling Charge")}} : <i class="{{ $order->order->paid_in }}"></i>
							{{ $order->singleorder->handlingcharge }}</p>
						@endif
						@if($order->amount != $realamount)
						<p>{{__('Refunded Amount')}} : <i class="{{ $order->order->paid_in }}"></i> {{$order->amount}}</p>
						@endif
					</div>
					<div class="col-md-3"><b>{{ $order->transaction_id }}</b>
					</div>

					<div class="margin-top-15 col-md-3">
						<p><b>{{__("REFUND METHOD")}}:</b></p>

						@if($order->order->payment_method !='COD' && $order->method_choosen != 'bank')
							{{ ucfirst($order->method_choosen) }} ({{ $order->order->payment_method }})
						@elseif($order->method_choosen == 'bank')
							{{ ucfirst($order->method_choosen) }}
						@else
							{{__('No Need for COD Orders')}}
						@endif

					</div>

					<div class="margin-top-15 col-md-6">
						<p><b>{{__('Cancelation Reason')}}:</b></p>
						<blockquote>
							{{ $order->comment }}
						</blockquote>
					</div>

					@if($order->method_choosen == 'bank')
						@php
							$bank = App\Userbank::where('id','=',$order->bank_id)->first();
						@endphp
					<div class="col-md-4">
						@if(isset($bank))
						<label>{{__('Refund')}} {{ ucfirst($order->is_refunded) }} {{__("In")}} {{ $bank->user->name }}'s {{__('Account Following are details')}}:</label>


						<div class="well">

							<p><b>{{__("A/C Holder Name")}}: </b>{{$bank->acname}}</p>
							<p><b>{{__('Bank Name')}}: </b>{{ $bank->bankname }}</p>
							<p><b>{{__('Account No')}}: </b>{{ $bank->acno }}</p>
							<p><b>{{__('IFSC Code')}}: </b>{{ $bank->ifsc }}</p>


						</div>
						@else
						<p>
							{{__('User Deleted bank ac')}}
						</p>
						@endif
					</div>
					@endif



				</div>
				@if($order->order->discount != 0)

					@if($order->order->distype == 'product')

						@if(isset($cpn) && $cpn->pro_id == $order->singleOrder->variant->products->id)
							<div class="callout callout-success">
								{{__("Customer Apply")}} <b>{{ $order->order->coupon }}</b> {{__('on this order')}}.
							</div>
						@endif

					@elseif($order->order->distype == 'category')

						<div class="callout callout-success">
							{{__("Customer Apply")}} <b>{{ $order->order->coupon }}</b> 
							{{__('on this order hence refund amount total is different')}} .
						</div>

					@elseif($order->order->distype == 'cart')
						<div class="callout callout-success">
							{{__("Customer Apply")}} <b>{{ $order->order->coupon }}</b> 
							{{__('on this order  hence refund amount total is different')}}.
						</div>
					@endif

				@endif
				<hr>
				<h4><b>{{ __('Items') }}</b></h4>

				@php
					$inv = $order->singleorder;

					$orivar = $order->singleorder->variant;
					
					if(isset($orivar)){
						$varcount = count($orivar->main_attr_value);
					}

					$i=0;
				@endphp

			
				<div class="row">
					<div class="col-md-1">
						@if($order->singleorder->variant)
							@if($orivar->variantimages)
								<img class="pro-img" src="{{url('variantimages/'.$orivar->variantimages['main_image'])}}"
							/>
							@else 
								<img class="pro-img" src="{{ Avatar::create($orivar->products->name) }}"/>
							@endif
						@endif
		
						@if($order->singleorder->simple_product)
							<img class="pro-img" src="{{url('images/simple_products/'.$order->singleorder->simple_product->thumbnail)}}"/>
						@endif
					</div>

					<div class="col-md-4">
						@if($order->singleorder->variant)
							<a class="text-primary" target="_blank"
								title="Click to view"><b>{{$orivar->products->name}}</b>
		
								<small>
									({{ variantname($order->singleorder->variant) }})
		
								</small>
							</a>
							<br>
							<small class="margin-left-15"><b>Sold By:</b> 
								{{$orivar->products->store->name}}
							</small>
						@endif
		
						@if($order->singleorder->simple_product)
							<a class="color111 margin-top-15" target="_blank"
								title="Click to view">
								<b>{{$order->singleorder->simple_product->product_name}}</b>
							</a>
							<br>
							<small class="margin-left-15"><b>Sold By:</b> {{$order->singleorder->simple_product->store->name}}
							</small>
						@endif
		
						<br>
						<small class="margin-left-15"><b>Qty:</b> {{ $order->singleorder->qty }}
						</small>
					</div>

					<div class="col-md-2">
						@if($order->order->discount != 0)
							@if($order->order->distype == 'product')
							
								@if($order->singleorder->variant)
									@if(isset($cpn) && $cpn->pro_id == $inv->variant->products->id)
										<b><i class="{{ $order->order->paid_in }}"></i>
											{{ round($realamount-$order->order->discount,2) }}</b> &nbsp;
										<strike><i class="{{ $order->order->paid_in }}"></i> {{ $realamount }}</strike>
									@else
										<b><i class="{{ $order->order->paid_in }}"></i> {{ $realamount }}</b>
									@endif
								@endif

								@if($order->singleorder->simple_product)
								
									@if(isset($cpn) && $cpn->simple_pro_id == $order->singleorder->simple_product->id)
										<b><i class="{{ $order->order->paid_in }}"></i>
											{{ round($realamount-$order->order->discount,2) }}</b> &nbsp;
										<strike><i class="{{ $order->order->paid_in }}"></i> {{ $realamount }}</strike>
									@else
										<b><i class="{{ $order->order->paid_in }}"></i> {{ $realamount }}</b>
									@endif

								@endif

							@elseif($order->order->distype == 'cart')

								<b><i class="{{ $order->order->paid_in }}"></i>
									{{ round($realamount-$order->singleOrder->discount,2) }}
								</b>&nbsp;
								<strike><i class="{{ $order->order->paid_in }}"></i> {{ $realamount }}</strike>

							@endif
						@else
						<i class="{{ $order->order->paid_in }}"></i> {{ $realamount }}
						@endif
					</div>

					<div class="col-md-3">
						<label for="">{{__('UPDATE TXN ID/REF. NO')}}:</label>
						<input readonly type="text" name="transaction_id" class="form-control"
							value="{{ $order->transaction_id }}" class="form-control">
						<br>
			
						
			
					</div>
			
					@csrf
					<div class="col-md-2">
			
						<label for="">{{__('REFUND STATUS')}}:</label>
						@if($order->order->payment_method != 'COD')
						<select disabled name="refund_status" id="refund_status{{ $order->id }}" class="form-control"
							onchange="singlerefundstatus('{{ $order->id }}')">
							<option {{ $order->is_refunded == 'completed' ? "selected" : ""}} value="completed">
								Completed</option>
							<option {{ $order->is_refunded == 'pending' ? "selected" : "" }} value="pending">Pending
							</option>
						</select>
						@else
						<select readonly name="refund_status" class="form-control">
			
							<option {{ $order->is_refunded == 'completed' ? "selected" : ""}} value="completed">
								{{__('Completed')}}	
							</option>
			
						</select>
						@endif
			
					</div>

					<div class="col-md-3">
						<label>{{__('Amount')}} :</label>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
							  <span class="input-group-text" id="basic-addon1">
								<i class="{{ $order->order->paid_in }}"></i>
							  </span>
							</div>
							<input placeholder="0.00" type="text" name="amount"
								{{ $order->method_choosen == 'bank' ? "" : "readonly" }} class="form-control"
								value="{{ $order->amount }}" class="form-control">
						</div>
					</div>
			
					<div class="col-md-3">
						<label>
							({{__('ORDER STATUS')}})
						</label>
						@if($order->order->payment_method != 'COD')
			
						<select disabled name="order_status" id="order_status{{ $order->id }}" class="form-control">
							@if($order->singleorder->status == 'Refund Pending')
							<option selected value="Refund Pending">
								{{__("Refund Pending")}}
							</option>
							@elseif($order->singleorder->status == 'refunded' || $order->singleorder->status ==
							'returned')
							<option {{ $order->singleorder->status == 'refunded' ? "selected" : "" }}
								value="refunded">{{ __('Refunded') }}</option>
							<option {{ $order->singleorder->status == 'returned' ? "selected" : "" }}
								value="returned">
								{{__('Returned')}}
							</option>
							@endif
						</select>
			
						@else
			
						<select disabled name="order_status" id="order_status{{ $order->id }}"
							class="order_status form-control">
							<option {{ $order->singleorder->status == 'canceled' ? "selected" : "" }}
								value="canceled">
								{{__('Cancelled')}}
							</option>
							<option {{ $order->singleorder->status == 'returned' ? "selected" : "" }}
								value="returned">
								{{__("Returned")}}
							</option>
						</select>
			
						@endif
			
					</div>

					<div class="col-md-3">
						<label>Transcation Fee:</label>
						<div class="input-group">
							<div class="input-group-prepend">
							  <span class="input-group-text" id="basic-addon1">
								<i class="{{ $order->order->paid_in }}"></i>
							  </span>
							</div>
							<input readonly {{ $order->method_choosen == 'bank' ? "" : "readonly" }} placeholder="0.00"
								type="text" name="txn_fee" class="form-control" value="{{ $order->txn_fee }}"
								class="form-control">
						</div>
			
					</div>

				</div>
				


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					{{__('Close')}}
				</button>
			</div>
		</div>
	</div>
</div>
@endforeach
<!-- END Track-->