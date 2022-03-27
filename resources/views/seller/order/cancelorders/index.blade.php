@extends("admin.layouts.sellermastersoyuz")
@section('title',__('Cancelled Orders'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Cancelled Orders') }}
@endslot
@slot('menu1')
   {{ __('Orders') }}
@endslot
@slot('menu1')
   {{ __('Cancelled Orders') }}
@endslot



@endcomponent

<div class="contentbar">   
             
    <!-- Start row -->
    <div class="row">
    
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Cancelled Orders')}}</h5>
                </div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12  p-3 mb-2 bg-success text-white rounded">
							<i class="fa fa-info-circle"></i> {{__('Note')}}:

							<ul>
								<li>{{__('COD Orders are only viewable')}} !</li>
								<li>
									{{__("For Prepaid canceled orders with refund method choosen Bank You can View Details IF refund is complete")}}.</li>
								<li>{{__('For Prepaid canceled orders with refund method choosen orignal you can track refund status LIVE from respective Payment gateway & Update TXN/REF ID')}}.
								</li>
							</ul>
						</div>
						
					</div>
					
				
					<ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-truck mr-2"></i>
								{{__('Single Canceled Orders')}} @if($partialcount>0)<span class="badge badge-danger"><span id="pcount">{{ $partialcount }}</span> {{__('New')}} @endif</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-truck mr-2"></i>
								{{__('Bulk Canceled Orders')}} @if($partialcount2>0)<span class="badge badge-danger"><span id="fcount">{{ $partialcount2 }}</span> {{__('New')}} @endif</a>
						</li>
						
					</ul>
					<div class="tab-content" id="defaultTabContentLine">
						<div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
							<table id="full_detail_table"  class="table table-striped w-100">
								<thead>
		
									<th>
										#
									</th>
		
									<th>
										{{__('Order TYPE')}}
									</th>
		
									<th>
										{{__('ORDER ID')}}
									</th>
		
									<th>
										{{__('REASON for Cancellation')}}
									</th>
		
									<th>
										{{__('REFUND METHOD')}}
									</th>
		
									<th>
										{{__("CUSTOMER")}}
									</th>
		
									<th>
										{{__('REFUND STATUS')}}
									</th>
		
								</thead>
		
									<tbody>
										@foreach($sellercanorders as $key => $order)
											<tr>
												<td>{{ $key+1 }}</td>
												<td>
		
													@if($order->order->payment_method != 'COD')
														<label class="label label-success">{{ __('PREPAID') }}</label>
													@else
														<label class="label label-primary">
															{{__('COD')}}
														</label>
													@endif
		
												</td>
												<td>
													@if($order->read_at == NULL)
														<b>#{{ $inv_cus->order_prefix.$order->order->order_id }}</b>
													@else
														#{{ $inv_cus->order_prefix.$order->order->order_id }}
													@endif
													<br>
													<small class="text-center">
														@if($order->method_choosen == 'bank' || $order->order->payment_method == 'COD')
															<a role="button" onclick="readorder('{{ $order->id }}')" title="{{__('View Details')}}" class="cursor-pointer" data-toggle="modal" data-target="#orderupdate{{ $order->id }}">
																{{__('View Details')}}
															</a>
														@else
		
															<a role="button" onclick="readorder('{{ $order->id }}')" title="{{__('View Details')}}" class="cursor-pointer" data-toggle="modal" data-target="#orderupdate{{ $order->id }}">
																{{__('View Details')}}
															</a> | <a onclick="trackrefund('{{ $order->id }}')" class="cursor-pointer" title="{{ __('TRACK REFUND') }}">{{ __('TRACK REFUND') }}</a>
														@endif
													</small>
												</td>
												<td>
													{{ $order->comment }}
												</td>
												<td>
													@if($order->method_choosen == 'bank')
														{{ ucfirst($order->method_choosen) }}
													@elseif($order->method_choosen == 'orignal')
														{{ ucfirst($order->method_choosen) }} ({{ ucfirst($order->order->payment_method) }})
													@else
													No need for COD Orders
													@endif
												</td>
												<td>
													@php
														$name = App\User::find($order->order->user_id)->name;
													@endphp
		
													@if(isset($name))
													{{ $name }}
													@else
		
													{{__('No Name')}}
		
													@endif
												</td>
		
												<td>
													@if($order->is_refunded == 'pending')
														<label class="badge badge-primary">{{ ucfirst($order->is_refunded) }}</label>
													@else
														<label class="badge badge-success">{{ ucfirst($order->is_refunded) }}</label>
													@endif
												</td>
		
												<!--trackmodel-->
		
		
		
											</tr>
										@endforeach
									</tbody>
								</table>
						</div>
						<div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
							<table id="full_detail_table2" class="table table-striped w-100">
								<thead>
									<th>
										#
									</th>
									<th>
										{{__('Order TYPE')}}
									</th>
									<th>
										{{__('Order ID')}}
									</th>
									<th>
										{{__('REASON for Cancellation')}}
									</th>
									<th>
										{{__('REFUND METHOD')}}
									</th>
									<th>
										{{__("CUSTOMER")}}
									</th>
									<th>
										{{__('REFUND STATUS')}}
									</th>
								</thead>
		
								<tbody>
									@foreach($sellerfullcanorders as $key=> $fcorder)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>
		
													@if($fcorder->getorderinfo->payment_method != 'COD')
														<label class="label label-success">
															{{__('PREPAID')}}
														</label>
													@else
														<label class="label label-primary">
															{{__('COD')}}
														</label>
													@endif
											</td>
											<td>
												@if($fcorder->read_at == NULL)
												<b>#{{ $inv_cus->order_prefix.$fcorder->getorderinfo->order_id }}</b>
												@else
													#{{ $inv_cus->order_prefix.$fcorder->getorderinfo->order_id }}
												@endif
												<br>
													<small class="text-center">
														@if($fcorder->method_choosen == 'bank' || $fcorder->getorderinfo->payment_method == 'COD')
															<a onclick="readfullorder('{{ $fcorder->id }}')" title="{{__('View Details')}}" class="cursor-pointer" data-toggle="modal" data-target="#fullorderupdate{{ $fcorder->id }}">{{__('View Details')}}</a>
														@else
															<a onclick="readfullorder('{{ $fcorder->id }}')" title="{{__('View Details')}}" class="cursor-pointer" data-toggle="modal" data-target="#fullorderupdate{{ $fcorder->id }}">{{__('View Details')}}</a> | <a class="cursor-pointer" title="{{__('TRACK REFUND')}}" onclick="trackrefundFullCOrder('{{ $fcorder->id }}')">
																{{__('TRACK REFUND')}}
															</a>
														@endif
													</small>
											</td>
											<td>
												{{ $fcorder->comment }}
											</td>
											<td>
													@if($fcorder->method_choosen == 'bank')
														{{ ucfirst($fcorder->method_choosen) }}
													 @elseif($fcorder->method_choosen == 'orignal')
														{{ ucfirst($fcorder->method_choosen) }} ({{ ucfirst($fcorder->getorderinfo->payment_method) }})
													 @else
													  {{__('No need for COD Orders')}}
													 @endif
											</td>
											<td>
												{{ $fcorder->user->name }}
											</td>
		
											<td>
													@if($fcorder->is_refunded == 'pending')
														<label class="label label-primary">{{ ucfirst($fcorder->is_refunded) }}</label>
													@else
														<label class="label label-success">{{ ucfirst($fcorder->is_refunded) }}</label>
													@endif
											</td>
		
		
											<!-- END Full Order Update Modal -->
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
               
          </div>
      </div>
      <!-- End col -->
  </div>
  
  <!-- Single Refund Modal -->
@include('seller.order.cancelorders.singleordermodal')
<!--END-->

<!-- FULL Refund Modal -->
@include('seller.order.cancelorders.fullordermodal')
<!--END-->
  @endsection

  @section('custom-script')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/order.js') }}"></script>
@endsection
                 
  
               
  
          
              
              
             
              
             
            
                
              
    
                 
                

                
    
            
            
    
             
            
          





                                
 


