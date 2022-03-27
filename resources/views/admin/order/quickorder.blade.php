<div class="card">

	<div class="card-header with-border">
		<span class="pull-right">
			<button onclick="collapseorder('{{ $order['id'] }}')" type="button" class="close" id="closebtn{{ $order['id'] }}" aria-label="Close">
                  <span aria-hidden="true">×</span>
            </button>
		</span>
		# <b>{{ $inv_cus['order_prefix'].$order['order_id'] }}</b>
		<br>
		<span>
			{{ date('d-M-Y | h:i A',strtotime($order['created_at'])) }}
		</span> 


	</div>

	<div class="card-body with-border">
		<p><b>{{ __("Order from") }}</b></p>
		<p>{{ $order->user->name }}</p>
		<p><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $order->user->email }}</p>
		@if($order->user->mobile)
			<p><i class="fa fa-phone" aria-hidden="true"></i> {{ $order->user->mobile }} </p>
		@endif
		@if(isset($order->user->country->nicename))
		<p>
			<i class="fa fa-map-marker" aria-hidden="true"></i> {{ $order->user['city']['name'] }}, {{ $order->user['state']['name'] }}, {{ $order->user['country']['nicename'] }}
		</p>
		@endif
	

	
		@foreach($order->invoices->where('status','pending') as $suborder)
			<div class="row">
				<div class="col-md-2">
					@if($suborder->variant)
						@if($suborder->variant->variantimages)
							<img width="50px" src="{{ url('/variantimages/'.$suborder->variant->variantimages['main_image']) }}" alt="" class="m-t-2 img-responsive" title="{{ $suborder->variant->products['name'] }}" alt="Product Image" />
						@else
							<img width="50px" src="{{ Avatar::create($suborder->variant->products['name'])->toBase64() }}" alt="" class="m-t-2 img-responsive" title="{{ $suborder->variant->products['name'] }}" alt="Product Image" />
						@endif
					@endif

					@if($suborder->simple_product)

						<img width="50px" src="{{ url('images/simple_products/'.$suborder->simple_product->thumbnail) }}" alt="" class="m-t-2 img-responsive" title="{{ $suborder->simple_product['product_name'] }}" alt="Product Image" />

					@endif
				</div>
				<div class="col-md-5">
					
					@if(isset($suborder->variant))
						{{ $suborder->variant->products['name'] }} <b>(x {{ $suborder['qty'] }})</b>
					@endif

					@if(isset($suborder->simple_product))
						{{ $suborder->simple_product['product_name'] }} <b>(x {{ $suborder['qty'] }})</b>
					@endif
				</div>
				<div class="col-md-5">
					<i class="{{ $order['paid_in'] }}"></i> {{ $suborder->price + $suborder->tax_amount + $suborder->shipping }}
					<br>
					<small>({{__("Incl. of Tax & Shipping")}}).</small>
				</div>
			</div>
			
		@endforeach
	


		
		<div class="row">

			<div class="col-md-4">
				<span><b>{{__("Subtotal")}}: </b></span>
			<br>
		
				@if($order->discount != 0)
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order['order_total'] + $order['discount']) }}
				@else
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order['order_total'])  }}
				@endif
			</div>

			@if($order->discount != 0)
				<div class="col-md-4">
					<b>{{__('Coupon discount:')}} </b><br>
				
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order['discount']) }}
				</div>
				@endif

				@if($order->gift_charge != 0)
					<div class=" col-md-4">
						<b>{{__("Gift Pkg. charges")}}: </b>
					<br>
						+ <i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order->gift_charge) }}
					</div>
				@endif
				
				@if($order->handlingcharge != 0)
					<div class="col-md-4">
						<b>{{__("Handling charges")}}: </b>
				<br>
						+ <i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order->handlingcharge) }}
					</div>
				@endif

			<div class=" col-md-4">
				<b>Total: </b>
			<br>
				@if($order->discount != 0)
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order->order_total + $order->handlingcharge) }}
				@else
					<i class="{{ $order['paid_in'] }}"></i> {{ sprintf("%.2f",$order->order_total + $order->handlingcharge) }}
				@endif
			
			</div>
		</div>

				

		<div class="row mt-md-2">
			<div class="col-md-4">
				<p><b>{{__("Paid by")}}:</b></p>
				<p>{{ $order->payment_method }}</p>
			
			
			</div>

			<div class="col-md-4">
				<p><b>{{ __("Payment received") }}</b></p>
				<p>
					{{__("Yes")}}
				</p>
			
			</div>

		</div>
	</div>
	

</div>