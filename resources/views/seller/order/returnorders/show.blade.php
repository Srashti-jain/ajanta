@extends('admin.layouts.sellermastersoyuz')
@section('title',__('Show Return Order #:order',['order' => $inv_cus->order_prefix.$orderid ]))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])

  @slot('heading')
    {{ __('Return Orders') }}
  @endslot

  @slot('menu2')
    {{ __("Update Return Order") }}
  @endslot

@endcomponent

<div class="contentbar">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<a title="Back" href="{{ url('seller/return/orders') }}" class="float-right btn btn-md btn-primary-rgba">
						<i class="fa fa-arrow-left" aria-hidden="true"></i>
					</a>

					<div class="card-title font-weight-bold text-dark">
						{{__("Invoice No.")}} {{ $inv_cus->prefix }}{{ $rorder->getorder->inv_no }}{{ $inv_cus->postfix }} | Order ID: {{ $inv_cus->order_prefix.$orderid }}
					</div>

					
				</div>

				<div class="card-body">
					<div class="box-body">

						<h4>
							{{__("Refund Order Summary")}}
						</h4>
						<p></p>
						<table class="w-100 table table-striped">
							<thead>
								<th>
									{{__("Item")}}
								</th>
								<th>
									{{__('Qty')}}
								</th>
								<th>
									{{__('Status')}}
								</th>
								<th>
									{{__('Refund Total')}}
								</th>
								<th>
									{{__('REF.No/Transcation ID')}}
								</th>
							</thead>
				
							<tbody>
								<tr>
									<td>
				
										<div class="row">
											<div class="col-md-2">
												@if(isset($rorder->getorder->variant))
													@if($rorder->getorder->variant->variantimages)
														<img width="60px" class="object-fit"
														src="{{url('variantimages/'.$rorder->getorder->variant->variantimages->mainimage)}}" />
													@else
														<img width="60px" class="object-fit"
														src="{{ Avatar::create($rorder->getorder->variant->products->name) }}" />
													@endif
												@endif
				
												@if(isset($rorder->getorder->simple_product))
													<img width="60px" class="object-fit" src="{{url('images/simple_products/'.$rorder->getorder->simple_product->thumbnail)}}" />
												@endif
											</div>
				
											<div class="col-md-10">
												@if(isset($rorder->getorder->variant))
													<b>{{ $rorder->getorder->variant->products->name }}
														{{ variantname($rorder->getorder->variant) }}
													</b>
												@endif
				
												@if(isset($rorder->getorder->simple_product))
													<b>{{  $rorder->getorder->simple_product->product_name }}</b>
												@endif
													<br>
												@if(isset($rorder->getorder->variant))
													<small>
														<b>{{ __('Sold By:') }}</b> {{$rorder->getorder->variant->products->store->name}}
													</small>
												@endif
				
												@if(isset($rorder->getorder->simple_product))
													<small>
														<b>{{ __('Sold By:') }}</b> {{$rorder->getorder->simple_product->store->name}}
													</small>
												@endif
											</div>
										</div>
				
									</td>
									<td>
										{{ $rorder->qty }}
									</td>
									<td>
										<b>{{ ucfirst($rorder->status) }}</b>
									</td>
									<td>
										<b><i class="{{ $rorder->getorder->order->paid_in }}"></i>{{ round($rorder->amount,2) }}</b>
									</td>
									<td>
										<b>{{ $rorder->txn_id }}</b>
									</td>
								</tr>
							</tbody>
						</table>
						<p></p>
						<div class="reason">
							<p class="bg-primary-rgba p-3 text-dark">
								{{__("Reason for Return:")}} <span class="font-weight-bold">{{ $rorder->reason }}</span>
							</p>
						</div>
				
						<p></p>
						<div class="reason">
							<p class="bg-primary-rgba p-3 text-dark">
								{{ __('Refund Method Choosen: ') }}<span class="font-weight-bold">@if($rorder->method_choosen != 'bank')
									{{ ucfirst($rorder->method_choosen) }} ({{ $rorder->getorder->order->payment_method }}) @else
									{{ ucfirst($rorder->method_choosen) }} @endif</span>
								</p>
						</div>
				
						@if($rorder->method_choosen == 'orignal')
						<div class="alert alert-info">
							<i class="fa fa-info-circle"></i>
							{{__('Make Sure your :payment account has sufficient balance before initiate refund !',['payment' => $rorder->getorder->order->payment_method])}}
						</div>
						@endif
						<div class="row no-pad">
							@if($rorder->method_choosen == 'bank')
							<div class="text-center col-md-6">
								<div class="card border">
									<div class="card-header">
										<h4>
											{{__('User\'s Payment Details')}}
										</h4>
									</div>
									<div class="card-body">
										<div class="bankdetail">
				
											<p><b>{{__('A/c Holder name')}}: </b> {{ $rorder->bank->acname }}</p>
											<p><b>{{__('Bank Name')}}: </b> {{ $rorder->bank->acname }}</p>
											<p><b>{{__('A/c No')}}. </b> {{ $rorder->bank->acno }}</p>
											<p><b>{{__('IFSC Code')}}: </b> {{ $rorder->bank->ifsc }}</p>
										</div>
									</div>
				
								</div>
				
							</div>
							@endif
				
							<div class="text-center {{ $rorder->method_choosen !='bank' ? "col-md-12" : "col-md-6" }}">
								<div class="card bg-secondary-rgba">
				
									<div class="card-header bg-warning">
										<h4 class="card-title">
											{{__('Pickup Location')}}
										</h4>
				
									</div>
									<div class="card-body">
				
				
				
										@foreach($rorder->pickup_location as $location)
										@php
											$x = json_decode($location,true);
										@endphp
										<h4><b>{{$x['name']}}</b></h4>
										<p>
											{{ strip_tags($x['address']) }}
										</p>
										<p>{{ $x['ci'] }},{{ $x['s'] }},{{ $x['c'] }},</p>
										<p>{{ $x['pincode'] }}</p>
				
										@endforeach
									</div>
				
								</div>
							</div>
						</div>
						<hr>
						<h4>
							{{__("Update Refund Details")}}
						</h4>
						<form action="{{ route('final.process',$rorder->id) }}" method="POST">
							@csrf
							<div class="row mt-3">
								
								
					
									<div class="col-md-4">
										<div class="form-group">
											<label>{{__('UPDATE AMOUNT')}}:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">
														<i class="{{ $rorder->getorder->order->paid_in }}"></i>
													</span>
												</div>
												<input readonly name="amount" id="txn_amount" type="text" class="form-control"
													value="{{ round($rorder->amount,2) }}" />
												<input type="hidden" value="{{ round($rorder->amount,2) }}" id="actualAmount">
						
											</div>
											<small class="help-block">({{__('Amount will be updated if transcation fee charged')}})</small>
										</div>
									</div>
					
									<div class="col-md-4">
										<div class="form-group">
											<label>{{__('UPDATE Transaction ID')}}:</label>
											<input {{ $rorder->method_choosen == 'bank' ? "" : "readonly" }} type="text" class="form-control"
												value="{{ $rorder->txn_id }}" name="txn_id">
											<small class="help-block">({{__("Use when, when bank transfer method is choosen")}})</small>
										</div>
									</div>
					
									<div class="col-md-4">
										<div class="form-group">
											<label>{{__('UPDATE Transaction Fees')}}:</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">
														<i class="{{ $rorder->getorder->order->paid_in }}"></i>
													</span>
												</div>
												<input {{ $rorder->method_choosen == 'bank' ? "" : "readonly" }} placeholder="0.00" type="text"
													class="form-control" value="" name="txn_fee" id="txn_fee">
											</div>
											<small class="help-block">
												({{_('If chaarged during bank transfer (eg. in NEFT,IMPS,RTGS) enter fee')}}).
											</small>
										</div>
									</div>
					
									<div class="col-md-4">
										<div class="form-group">
											<label>{{__('UPDATE Refund Status')}}:</label>
											<select name="status" class="form-control">
												<option value="refunded">{{__('Refunded') }}</option>
						
											</select>
										</div>
									</div>
					
									<div class="col-md-4">
										<div class="form-group">
											<label>{{__('UPDATE Order Status')}}:</label>
											<select name="order_status" class="form-control">
												<option value="ret_ref">{{ __('Returned & Refunded') }}</option>
												<option value="returned">
													{{__('Returned')}}
												</option>
												<option value="refunded">
													{{__('Refunded')}}
												</option>
											</select>
										</div>
									</div>
									<div class="col-md-12">
										
										<div class="form-group">
											<button title="This action cannot be undone!" type="submit" class="btn btn-md btn-primary">
												<i class="fa fa-check-circle-o" aria-hidden="true"></i> 
												{{__('Initiate Refund')}}
											</button>
										</div>
									</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('custom-script')
<script>
	var baseUrl = "<?= url('/') ?>";
</script>
<script src="{{ url('js/order.js') }}"></script>
@endsection