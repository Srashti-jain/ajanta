<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>{{ __('Print Invoice:') }} {{ $inv_cus->prefix.$getInvoice->inv_no.$inv_cus->postfix }}</title>
	<link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{ url('admin/css/style.css') }}">
	<style>
		body {
			background-color: #000
		}

		.padding {
			padding: 2rem !important
		}

		.card {
			margin-bottom: 30px;
			border: none;
			-webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
			-moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
			box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22)
		}

		.card-header {
			background-color: #fff;
			border-bottom: 1px solid #e6e6f2
		}

		h3 {
			font-size: 20px
		}

		h5 {
			font-size: 15px;
			line-height: 26px;
			color: #3d405c;
			margin: 0px 0px 15px 0px;
			font-family: 'Circular Std Medium';
		}

		.text-dark {
			color: #3d405c !important;
		}


		.page_border{
			border: <?php echo $design->border_radius ?? 0 ?>px;
			border-color : <?php echo $design->border_color ?? '#000000' ?>;
			border-style: <?php echo $design->border_style ?? 0 ?>;
		}
		
	</style>
</head>

@php

if(isset($getInvoice->variant)){
	$orivar = App\AddSubVariant::withTrashed()->find($getInvoice->variant_id);
	$store = App\Store::where('id',$orivar->products->store_id)->first();
}

if(isset($getInvoice->simple_product)){
	$store = $getInvoice->simple_product->store;
}

@endphp
<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
	
	
	<div class="card page_border">
		
		<div class="card-header p-4">
			
			<div class="d-print-none row">
				<div class="col-md-6">
					
				</div>
				<div class="col-md-6">
					
					<button title="{{ __("Print Invoice") }}" onclick="printit()" class="float-right btn btn-md btn-secondary">
						<i class="fa fa-print"></i>
					</button>

					<a title="{{ __("Go back") }}" href="{{ url()->previous() }}" class="mr-2 float-right btn btn-md btn-secondary">
						<i class="fa fa-arrow-left"></i>
					</a>
				</div>
				
			</div>
			<hr class="d-print-none">

			<div class="mt-4 float-right">
				
				<h3 class="mb-0">{{__("Tax Invoice")}} #{{ $inv_cus->prefix.$getInvoice->inv_no.$inv_cus->postfix }}</h3>
				<hr>
				{{__("Date:")}} <b>{{ date($design->date_format,strtotime($getInvoice->created_at)) }}</b>
				<br>
				{{__("Transcation ID:")}} <b>{{ $getInvoice->order->transaction_id }} </b>
				
				
			</div>

			<a class="pt-2 d-inline-block" href="{{ url('/') }}" data-abc="true">
			@if(isset($design) && $design->show_logo == 1)
				<img width="50px" src="{{url('images/genral/'.$fevicon)}}">
			@endif
				{{ $title }}
			</a>
			<br> <br>
			{{__("Order ID:")}} <b>#{{ $inv_cus->order_prefix.$getInvoice->order->order_id }}</b>
			<br>
			{{__("Payment method:")}} <b>{{$getInvoice->order->payment_method}}</b>

			
		</div>
		<div class="card-body">
			<div class="row mb-4">
				<div class="col-sm-4">
					<h5 class="mb-3">{{ __("Sold By:") }}</h5>
					<h3 class="text-dark mb-1">{{ $store->name }}</h3>
					<div>{{ $store->address }}</div>
					@php

						$c = App\Allcountry::where('id',$store->country_id)->first()->nicename;
						$s = App\Allstate::where('id',$store->state_id)->first()->name;
						$ci = App\Allcity::where('id',$store->city_id)->first() ? App\Allcity::where('id',$store->city_id)->first()->name : '';

					@endphp
					<div>{{ $ci }},{{ $s }},{{ $c }}, {{ $store->pin_code }}</div>
					<div>Email: {{ $store->email }}</div>
					<div>Phone: {{ $store->mobile }}</div>
					@if(isset($design) && $design->show_vat == 1)
						<div>GSTIN: <b>{{ $store->vat_no }}</b> </div>
					@endif
				</div>
				<div class="col-sm-4 ">
					<h5 class="mb-3">{{ __("Shipping Address:") }}</h5>
					<h3 class="text-dark mb-1">{{$address->name}}</h3>
					<div>{{ strip_tags($address->address) }}</div>
					<div>
						{{ $address->getcity ? $address->getcity->name.',' : '' }}
						{{ $address->getstate ? $address->getstate->name.',' : '' }}
						{{ $address->getCountry ? $address->getCountry->nicename.',' : '' }}
						{{ $address->pin_code ? $address->pin_code : "" }}
					</div>
					<div>Email: {{$address->email}}</div>
					<div>Phone: {{ $address->phone }}</div>
				</div>
				<div class="col-sm-4 ">
					<h5 class="mb-3">{{ __("Billing Address:") }}</h5>
					<h3 class="text-dark mb-1">{{ $getInvoice->order->billing_address['firstname'] }}</h3>
					<div>{{ strip_tags($getInvoice->order->billing_address['address']) }}</div>

					@php


					$bcountry = App\Allcountry::where('id',$getInvoice->order->billing_address['country_id'])->first()->nicename;
					$bstate = App\Allstate::where('id',$getInvoice->order->billing_address['state'])->first() ?
					App\Allstate::where('id',$getInvoice->order->billing_address['state'])->first()->name :
					'';
					$bcity = App\Allcity::where('id',$getInvoice->order->billing_address['city'])->first() ?
					App\Allcity::where('id',$getInvoice->order->billing_address['city'])->first()->name :
					'';

					@endphp

					<div>{{ $bcity }}, {{ $bstate }}, {{ $bcountry }}, {{ $getInvoice->order->billing_address['pincode'] ?? '' }}</div>
					<div>Email: {{ $getInvoice->order->billing_address['email'] }}</div>
					<div>Phone: {{ $getInvoice->order->billing_address['mobile'] }}</div>
				</div>
			</div>
			<div class="table-responsive-sm">
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="center">#</th>
							<th>{{ __('Item') }}</th>
							<th>{{ __('Qty') }}</th>
							<th>{{ __('Pricing & Shipping') }}</th>
							<th>{{ __('TAX') }}</th>
							<th>{{ __('Total') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1.</td>
							<td>
									@if($getInvoice->variant)
										<b>{{$orivar->products->name}} <small>({{variantname($orivar)}})</small>
										<br>
										<small><b>{{ __("HSN/SAC : ") }}</b> {{ $getInvoice->variant->products->hsn }}</small>
										
										<br>
										<small><b>{{ __('Sold By:') }}</b> {{$orivar->products->store->name}}</small>
									@endif

									@if($getInvoice->simple_product)
										<b>{{$getInvoice->simple_product->product_name}} 
										
										<br>
										<small><b>{{ __("HSN/SAC : ") }}</b> {{ $getInvoice->simple_product->hsin }}</small>
										<br>
										<small><b>{{ __('Sold By:') }}</b> {{$getInvoice->simple_product->store->name}}</small>
									@endif

									<br>
									<small class="tax"><b>{{ __('Price:') }}</b> <i
											class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->price , 2, '.', '')}}
									</small>
									
									<br>
									<small class="tax"><b>{{ __('Tax:') }}</b> <i
											class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->tax_amount, 2, '.', '')}}
									</small>
							</td>
							<td valign="middle">
								{{ $getInvoice->qty }}
							</td>
							<td>
								<p><b>{{ __('Price:') }}</b> <i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->qty*$getInvoice->price,2) }}</p>

								<p class="ship"><b>{{ __('Shipping:') }}</b> <i
										class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->shipping,2) }}
								</p></b>
								<small class="help-block">({{ __('Price Multiplied with Qty.') }})</small>
							</td>
							<td>

								@if($getInvoice->igst != NULL)
								<p><i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->igst) }} {{ __("(IGST)") }} </p>
								@endif
								@if($getInvoice->sgst != NULL)
								<p><i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->sgst) }} ({{ __("SGST") }})</p>
								@endif
								@if($getInvoice->cgst != NULL)
								<p><i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->cgst) }} ({{ __("CGST") }})</p>
								@endif
								<p><b>Total:</b> <i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->tax_amount * $getInvoice->qty,2) }}
								</p>
								@if(isset($getInvoice->variant) && $getInvoice->variant->products->tax_r !='' && $getInvoice->igst != NULL && $getInvoice->cgst !=
								NULL && $getInvoice->sgst != NULL)

								<p>({{ $orivar->products->tax_name }})</p>

								@endif

								@if(isset($getInvoice->simple_product) && $getInvoice->simple_product->tax !='' && $getInvoice->igst != NULL && $getInvoice->cgst !=
								NULL && $getInvoice->sgst != NULL)

								<p>({{ $getInvoice->simple_product->tax_name }})</p>

								@endif


								<small class="help-block">(Tax Multiplied with Qty.)</small>
							</td>
							<td>
								<i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->qty*($getInvoice->price+$getInvoice->tax_amount)+$getInvoice->shipping,2) }}
								<br>
								<small class="help-block">({{ __('Incl. of Tax & Shipping') }})</small>
							</td>
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-lg-4 col-sm-5">
					{{ __('Terms:') }} </b>{!! $inv_cus->terms !!}

					

				<table class="table">
					<tr>
						@if(!empty($invSetting->seal))
						<td>
							{{ __('Seal:') }}
							<br>
							<img width="50px" src="{{ url('images/seal/'.$invSetting->seal) }}" alt="">
						</td>
						@endif
						@if(!empty($invSetting->sign))
						<td>
							{{ __('Sign:') }} <br>
							<img width="50px" src="{{ url('images/sign/'.$invSetting->sign) }}" alt="">
						</td>
						@endif
						@if(isset($design) && $design->show_qr == 1)
						<td>
							@php

								$data = array(
									'Sold By'      => $store->name,
									'Invoice No.'  => $inv_cus->order_prefix.$getInvoice->order->order_id,
									'Invoice Date' => date('d M,Y',strtotime($getInvoice->created_at)),
									'Amount' 	   => $getInvoice->order->discount == 0 ? $getInvoice->order->paid_in_currency.' '.price_format($getInvoice->qty*($getInvoice->price+$getInvoice->tax_amount)+$getInvoice->handlingcharge+$getInvoice->shipping+$getInvoice->gift_charge,2) : $getInvoice->order->paid_in_currency.' '.price_format($getInvoice->qty*($getInvoice->price+$getInvoice->tax_amount)-$getInvoice->discount+$getInvoice->handlingcharge+$getInvoice->shipping+$getInvoice->gift_charge,2),
									'Invoice link' => url()->current(),
								);

								$data = json_encode($data,true);
							@endphp	

							<span title="{{ __("Invoice QR") }}">
								{!! QrCode::color(21, 126, 210)->errorCorrection('H')->generate($data) !!}
							</span>
						</td>
						@endif
					</tr>
				</table>

				</div>
				<div class="col-lg-4 col-sm-5 ml-auto">
					<table class="table table-clear">
						<tbody>
							@if( $getInvoice->order->discount !=0)
							<tr>
								<td class="left">
									<strong class="text-dark">
										{{ __('Coupon Discount') }}
									</strong>
								</td>
								<td class="right">
									@if($getInvoice->order->discount !=0)

									- <i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->discount,2) }}

									@endif
								</td>
							</tr>	
							@endif
							<tr>
								<td class="left">
									<strong class="text-dark">
										{{ __('Gift Pkg. Charges') }}
									</strong>
								</td>
								<td class="right">
									+ <i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->gift_charge) }}
								</td>
							</tr>

							<tr>
								<td class="left">
									<strong class="text-dark">
										{{ __('Handling Charges') }}
									</strong>
								</td>
								<td class="right">
									+ <i class="{{ $getInvoice->order->paid_in }}"></i> {{ price_format($getInvoice->handlingcharge) }}
								</td>
							</tr>
							<tr>
								<td class="left">
									<strong class="text-dark">
										{{ __('Total') }}
									</strong>
								</td>
								<td class="right">
									@if( $getInvoice->order->discount == 0)
										<i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->qty*($getInvoice->price+$getInvoice->tax_amount)+$getInvoice->handlingcharge+$getInvoice->shipping+$getInvoice->gift_charge,2) }}
									@else
										<i class="{{ $getInvoice->order->paid_in }}"></i>{{ price_format($getInvoice->qty*($getInvoice->price+$getInvoice->tax_amount)-$getInvoice->discount+$getInvoice->handlingcharge+$getInvoice->shipping+$getInvoice->gift_charge,2) }}
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="card-footer bg-white">
			<p class="mb-0">
				{{ $genrals_settings->project_name }}, {{ $genrals_settings->address }}
			</p>
		</div>
	</div>
</div>

<script>
	function printit(){
		@if($design->print_mode == 'landscape')
		var css = '@page { size: landscape; }',
			head = document.head || document.getElementsByTagName('head')[0],
			style = document.createElement('style');

		style.type = 'text/css';
		style.media = 'print';

		if (style.styleSheet){
		style.styleSheet.cssText = css;
		} else {
		style.appendChild(document.createTextNode(css));
		}

		head.appendChild(style);

		@endif
		
		window.print();

	}
</script>
</html>