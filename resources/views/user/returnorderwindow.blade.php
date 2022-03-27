@extends('front.layout.master')
@section('title',"Return Product |")
@section('body')
	<div class="container-fluid">
		<div class="bg-white">
			 <div class="user_header"><h6 class="user_m">
			 	{{ __('staticwords.ReturnProduct') }} @if(isset($findvar))
				 <a>
					 <b>{{$findvar->products->name}}</b>
					 <small>({{ variantname($findvar) }})</small>
				 </a>
			 @else 

				 <a>
					 <b>{{$order->simple_product->product_name}}</b>
				 </a>

			 @endif @if(isset($findvar)) ({{ variantname($findvar) }} @endif
        	</h6>
        	</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<h5 class="margin-15">{{ __('Order') }} #{{ $inv_cus->order_prefix.$order->order->order_id }}
					</h5>
				</div>
				<div class="col-md-4">
					<h5 class="margin-15">{{ __('TXN ID:') }} {{ $order->order->transaction_id }}
					</h5>
				</div>
				<div class="col-md-4"></div>
			</div>
        	
        	
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<th>
						{{ __('staticwords.Item') }}
					</th>

					<th>
						{{ __('staticwords.qty') }}
					</th>

					<th>
						{{ __('staticwords.Price') }}
					</th>

					<th>{{ __('staticwords.TotalGiftCharge') }}</th>

					<th>{{ __('staticwords.HandlingCharge') }}</th>

					<th>
						{{ __('staticwords.Total') }}
					</th>

					<th>
						{{ __('staticwords.Deliveredat') }}
					</th>
				</thead>

				<tbody>
					<tr>
						<td>
							<div class="row">
							<div class="col-2">
								@if(isset($findvar))
								<img class="img-fluid" height="50px" src="{{url('variantimages/thumbnails/'.$findvar->variantimages['main_image'])}}" alt=""/>
								@else

								<img class="img-fluid" height="50px" src="{{url('images/simple_products/'.$order->simple_product->thumbnail)}}" alt=""/>

								@endif
							</div>
							<div class="col-10">
								@if(isset($findvar))
									<a>
										<b>{{$findvar->products->name}}</b>
										<small>({{ variantname($findvar) }})</small>
									</a>
								@else 

									<a>
										<b>{{$order->simple_product->product_name}}</b>
									</a>

								@endif
			                <br>
								@if(isset($findvar))
									<small><b>{{ __('staticwords.SoldBy') }}:</b> {{$findvar->products->store->name}}</small>
								@else 
									<small><b>{{ __('staticwords.SoldBy') }}:</b> {{$order->simple_product->store->name}}</small>	
								@endif
			                <br>
			               
							</div>
						 </div>
						</td>
						<td>
							{{$order->qty}}
						</td>

						<td><b><i class="{{ $order->order->paid_in }}"></i>
							
								
						 		@if($order->order->discount !=0)
									
									{{ price_format($order->qty*$order->price+$order->tax_amount+$order->shipping-$order->discount) }}
								
                                @else
                                    {{ price_format($order->qty*$order->price+$order->tax_amount+$order->shipping) }}
                                @endif 
						</b><br>
                          <small>({{ __('Incl. of Tax & Shipping') }})</small>
                        </td>
						<td>
							<b><i class="{{ $order->order->paid_in }}"></i> {{ $order->gift_charge }}</b>
						</td>
						<td>
							<b><i class="{{ $order->order->paid_in }}"></i> @infloat($order->handlingcharge) </b>
						</td>
						<td>
							<b><i class="{{ $order->order->paid_in }}"></i> 

								@if($order->order->discount !=0)
									
									{{ price_format(($order->qty*$order->price)+$order->tax_amount+$order->handlingcharge+$order->shipping-$order->discount+$order->gift_charge) }}
								
                                @else
                                    {{ price_format(($order->qty*$order->price)+$order->tax_amount+$order->handlingcharge+$order->shipping+$order->gift_charge) }}
                                @endif 
                            </b>
						</td>
                        <td>
						@php
							$days = $findvar->products->returnPolicy->days ?? $order->simple_product->returnPolicy->days;
                     		$endOn = date("d-M-Y", strtotime("$order->updated_at +$days days"));
						@endphp
                        	<span class="font-weight600">{{ date('d-M-Y @ h:i A',strtotime($order->updated_at)) }}</span>
							<br>
                        	<small class="font-weight600">({{ __('staticwords.ReturnPolicyEndsOn') }} {{ $endOn }})</small>
                        	
                        </td>



					</tr>
				</tbody>
			</table>
			</div>

			@php
				
				if($order->discount == 0){
					$paidAmount = round(($order->qty*$order->price)+$order->tax_amount+$order->handlingcharge+$order->shipping+$order->gift_charge,2);
				}else{
					$paidAmount = round((($order->qty*$order->price)+$order->tax_amount+$order->handlingcharge+$order->shipping)-$order->discount+$order->gift_charge,2);
				}

				if(isset($findvar)){
					$per = $paidAmount*$findvar->products->returnPolicy->amount/100;
				}else{
					$per = $paidAmount*$order->simple_product->returnPolicy->amount/100;
				}
				
				

				$paidAmount = $paidAmount-$per;

				if($order->cashback != ''){
					$paidAmount = $paidAmount - $order->cashback;
				}

			@endphp
			
			<div class="margin-15">

				@php
					$orderId = Crypt::encrypt($order->id);
				@endphp
				<!--return form-->
				<form action="{{ route('return.process',$orderId) }}" method="POST">
					@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						

								<label class="font-weight-bold">{{ __('staticwords.ChooseReasonforReturningtheProduct') }}: <span class="required">*</span></label>

								<select class="row col-12 form-control margin-left-0" required="" name="reason_return" id="">
									<option value="">{{ __('staticwords.PleaseChooseReason') }}</option>
									
									  @forelse(App\RMA::where('status','=','1')->get() as $rma)
										<option value="{{ $rma->reason }}">{{ $rma->reason }}</option>
									  @empty
										<option value="Other">{{ __('My Reason is not listed here') }}</option>
									  @endforelse
									  
								</select>
							
						
						</div>
						
						<div class="form-group">
							<label class="font-weight-bold">{{ __('staticwords.RefundedAmount') }}:</label>
							<input required type="text" class="form-control" readonly value="{{price_format($paidAmount) }}">

							<input type="hidden" value="{{ Crypt::encrypt(round($paidAmount,2)) }}" name="rf_am">
						</div>

					</div>
					<div class="col-md-6">
						<p></p>
						<br>
						
						<div class="alert alert-info">
							<h6><i class="fa fa-info-circle"></i> {{ __('staticwords.AdditionalNote') }}:</h6>
							<p>
								- {{ __('staticwords.AsPerProductReturnPolicy') }} {{ $findvar->products->returnPolicy->amount ?? $order->simple_product->returnPolicy->amount }}% {{ __('staticwords.refundorderamount') }}. 

								{{ __('staticwords.RefundedAmountwillbe') }}: <b><i class="{{ $order->order->paid_in }}"></i>{{ price_format($paidAmount) }}</b>
							</p>
							@if($order->cashback != '')
							<p>
								- {{ __("Cashback amount of ") }} <b><i class="{{ $order->order->paid_in }}"></i>@infloat($order->cashback)</b> {{ __("dedcuted from final refund amount ") }}
								<b><i class="{{ $order->order->paid_in }}"></i> {{ price_format($paidAmount + $order->cashback)}}</b>
							</p>
							@endif

						</div>
					</div>
				</div>
					
					<hr>

					<div class="row">
						<div class="col-md-6">
							<label class="h6 font-weight-bold">{{ __('staticwords.PickupLocation') }}:</label>

							@php
								 $address = App\Address::find($order->order->delivery_address);
								 $c = App\Allcountry::where('id',$address->country_id)->first()->nicename;
		                         $s = App\Allstate::where('id',$address->state_id)->first()->name;
		                         $ci = App\Allcity::where('id',$address->city_id)->first()->name;

		                         $addressA = array();

		                         $addressA = [

		                         	'name' => $address->name,
		                         	'address' => strip_tags($address->address),
		                         	'ci' 	=> $ci,
		                         	's' => $s,
		                         	'c' => $ci,
		                         	'pincode' => $address->pin_code

		                         ];

		                       


							@endphp

							<div class="form-group">

								<div class="card">
									<div class="card-body">
									
									<div class="custom-control custom-checkbox">
									  <input checked type="checkbox" name="pickupaddress[]" value="{{ json_encode($addressA,TRUE)}}" class="custom-control-input" id="customCheck1">
									  <label class="h6 custom-control-label" for="customCheck1">
									  	{{$address->name}}


									  	<p class="p-2 font-weight600">
										
										{{ strip_tags($address->address) }}<br>{{ $ci }},{{ $s }},{{ $c }} <br> {{ $address->pin_code }}
										</p>
									  </label>
									</div>
									
								</div>
								</div>
							</div>

						
					</div>

					<div class="col-md-6">
							<label class="h6 font-weight-bold">{{ __('staticwords.RefundMethod') }}:</label>
							@if($order->order->payment_method !='COD')
							<div class="form-group">
								

								<div class="custom-control custom-radio">
								  <input required="" type="radio" id="customRadio1" value="orignal" name="source" class="custom-control-input">
								  <label class="font-weight-bold custom-control-label" for="customRadio1">{{ __('staticwords.OrignalSource') }} ({{$order->order->payment_method}})</label>
								</div>
							</div>
							@endif
							<div class="form-group">
								

								<div class="custom-control custom-radio">
								  <input required name="source" value="bank" type="radio" id="customRadio2" name="customRadio" class="font-weight-bold custom-control-input">
								  <label class="custom-control-label font-weight-bold" for="customRadio2">{{ __('staticwords.Bank') }}</label>
								</div>
							</div>
							
							<div id="bank_box" class="form-group display-none">
								<label class="font-weight-bold">{{ __('staticwords.Chooseabank') }}: <span class="required">*</span></label>
								<select name="bank_id" id="bank_id" class="form-control">
									@foreach(Auth::user()->banks as $bank)
										<option value="{{ $bank->id }}">{{ $bank->bankname }} ( {{ $bank->acno }} )
										</option>
									@endforeach
								</select>
							</div>
					</div>


					</div>
					<hr>
					<button type="submit" class="btn btn-primary">{{ __('staticwords.Procced') }}...</button>
					<br><br>
				</form>
				
			<!--end-->
			</div>
			

		</div>
	</div>
@endsection
@section('script')
	<script src="{{ url('js/returnorder.js') }}"></script>
@endsection