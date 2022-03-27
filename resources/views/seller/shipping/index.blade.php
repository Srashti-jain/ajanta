@extends('admin.layouts.sellermastersoyuz')
@section('title', __('Available Shipping Methods'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Available Shipping Methods') }}
@endslot
@slot('menu1')
   {{ __('Available Shipping Methods') }}
@endslot



@endcomponent

<div class="contentbar">                
	<!-- Start row -->
	<div class="row">
		@foreach($shippings as $shipping)
		@if($shipping->name != 'UPS Shipping')
		<div class="mb-2 col-lg-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						
						<div class="col-lg-12">
							<h5>{{ $shipping['name'] }} :-
								@if($shipping['default_status'] == '1')
								<span class="badge badge-primary float-right">
									{{__("Default")}}
								</span>
						@endif</h5>
							
							
							
							<div class="text-center">
								@if($shipping->name != 'Free Shipping' && $shipping->name != 'Shipping Price')
									<h6>
										<p class="text-muted">Price:
										<i class="fa {{ $defCurrency->currency_symbol }}"></i>
										{{ $shipping['price']}}</p>
										
										<p class="text-muted"><i class="feather icon-alert-circle"></i> {{__("Price Can be changed by admin.") }}</p>
										@if($shipping->name == 'Local Pickup')
											<p class="text-muted"><i class="feather icon-alert-circle"></i> {{ __("Localpick up will choosen by user at time of order review.") }}</p>
										@endif
										@if($shipping->name == 'Flat Rate')
											<p class="text-muted"><i class="feather icon-alert-circle"></i> {{ __('Any item shipped with this method means global shipping charge will apply on all products.') }}</p>
										@endif
									</h6>
								@endif

								@if($shipping->name == 'Free Shipping')
									<h6>
										<p class="text-muted">
											{{__("Free Shipping not need any price changes when item is shipped  with this method there is no shipping charge will apply.")}}
										</p>
									</h6>
								@endif

								@if($shipping->name == 'Shipping Price')
									<h6 class="text-muted">
										{{__("Shipping Price mean Shipping price by weight")}}
									</h6>

									<div class="box-footer">
										<a role="button" class="pointer" data-toggle="modal" data-target=".bd-example-modal-lg">
											{{__("View more here shipping price by weight")}}
										</a>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	    @endforeach	
		<!-- End col -->
		<!-- Start col -->
		
		
	</div>
	<!-- End row -->
</div> 

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleLargeModalLabel"> {{__("Shipping Weight Price")}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h5>
					<i class="feather icon-alert-circle"></i> {{ __("Shipping Price is available in two methods and from given weight to given weight eg. 0 kg to 10kg given price is applied") }}</b>.
					<br><br>
					<ul>
						<li>
							{{__("Per Order")}}
						</li>
						<li>
							{{__("Per Quanity")}}
						</li>
					</ul>
					
					<table class="table table-bordered table-striped">
						<thead>
							<th>
								{{__("Weight From")}}
							</th>
							<th>
								{{__("Weight To")}}
							</th>
							<th>
								{{__("Price")}}
							</th>
							<th>
								{{__("Apply On")}}
							</th>
						</thead>
	  
						<tbody>
							<tr>
								<td>
									{{ $sw->weight_from_0 }}
								</td>
								<td>
									{{ $sw->weight_to_0 }}
								</td>
								<td>
									<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_0 }}
								</td>
								<td>
									@if($sw->per_oq_0 == 'po')
									{{__("Per Order")}}
									@else
									{{__("Per Quanity")}}
									@endif
								</td>
	  
	  
							</tr>
	  
							<tr>
								<td>
									{{ $sw->weight_from_1 }}
								</td>
								<td>
									{{ $sw->weight_to_1 }}
								</td>
								<td>
									<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_1 }}
								</td>
								<td>
									@if($sw->per_oq_1 == 'po')
									{{__("Per Order")}}
									@else
									{{__("Per Quanity")}}
									@endif
								</td>
							</tr>
	  
							<tr>
								<td>
									{{ $sw->weight_from_2 }}
								</td>
								<td>
									{{ $sw->weight_to_2 }}
								</td>
								<td>
									<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_2 }}
								</td>
								<td>
									@if($sw->per_oq_2 == 'po')
									{{__("Per Order")}}
									@else
									{{__("Per Quanity")}}
									@endif
								</td>
							</tr>
	  
							<tr>
								<td>
									{{ $sw->weight_from_3 }}
								</td>
								<td>
									{{ $sw->weight_to_3 }}
								</td>
								<td>
									<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_3 }}
								</td>
								<td>
									@if($sw->per_oq_3 == 'po')
									{{__("Per Order")}}
									@else
									{{__("Per Quanity")}}
									@endif
								</td>
							</tr>
	  
							<tr>
								<td>
									{{ $sw->weight_from_4 }}
								</td>
								<td>
									-
								</td>
								<td>
									<i class="fa {{ $defCurrency->currency_symbol }}"></i> {{ $sw->weight_price_4 }}
								</td>
								<td>
									@if($sw->per_oq_4 == 'po')
									{{__("Per Order")}}
									@else
									{{__("Per Quanity")}}
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</h5> 
			  </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
			
			</div>
		</div>
	</div>
</div>

  
@endsection
                 
  
               
  
          
              
              
             
              
             
            
                
              
    
                 
                

                
    
            
            
    
             
            
          





                                
 


