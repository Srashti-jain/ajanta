@extends('admin.layouts.sellermastersoyuz')
@section('title',__('Returned Orders '))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Returned Orders') }}
@endslot

@slot('menu1')
   {{ __('Returned Orders ') }}
@endslot

@endcomponent

<div class="contentbar">   
             
    <!-- Start row -->
    <div class="row">
    
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Returned Orders')}}</h5>
                </div>
				<div class="card-body">
					
					
				
					<ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-truck mr-2"></i>
								{{__('Return Completed')}} @if($countC>0) <span class="badge badge-success">{{$countC}}</span> @endif</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-truck mr-2"></i>
								{{__('Pending Returns')}} @if($countP>0) <span class="badge badge-danger">{{$countP}}</span>@endif</a>
						</li>
						
					</ul>
					<div class="tab-content" id="defaultTabContentLine">
						<div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
							
							<table id="full_detail_table2" class="table table-striped w-100">
								<thead>
								
									<th>
										#
									</th>
									<th>
										{{__("Order ID")}}
									</th>
									<th>
										{{__('Item')}}
									</th>
									<th>
										{{__('Refunded Amount')}}
									</th>
									<th>
										{{__('Refund Status')}}
									</th>
	
								</thead>
								
								<tbody>
									@foreach($sellerorders as $key=> $order)
										
										@if(isset($order->getorder->order) && $order->status != 'initiated')
										<tr>
											<td>
												{{ $key+1 }}
											</td>
											<td><b>#{{ $inv_cus->order_prefix.$order->getorder->order->order_id }}</b>
													<br>
													<small>
														<a title="View Refund Detail" href="{{  route('seller.order.detail',$order->id)  }}">
															{{__('View Detail')}}
														</a> 
													</small>
											</td>
											<td>
												@if(isset($order->getorder->variant))
													<b>
														{{$order->getorder->variant->products->name}} ({{ variantname($order->getorder->variant) }})
													</b>
												@endif
	
												@if(isset($order->getorder->simple_product))
													<b>
														{{$order->getorder->simple_product->product_name}}
													</b>
												@endif
													
											</td>
											<td>
												<i class="{{ $order->getorder->order->paid_in }}"></i>{{ $order->amount }}
											</td>
											<td>
												<label class="label label-success">
													{{ ucfirst($order->status) }}
												</label>
											</td>
										</tr>
										@endif
											
										
									@endforeach
								</tbody>
	
							</table>
						</div>
						<div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
							<table id="full_detail_table" class="table table-striped w-100">
								<thead>
									<th>
										#
									</th>
									<th>
										{{__('Order TYPE')}}
									</th>
									<th>
										{{__("Order ID")}}
									</th>
									<th>
										{{__("Pending Amount")}}
									</th>
									<th>
										{{__('Requested By')}}
									</th>
									<th>
										{{__('Requested on')}}
									</th>
									
								</thead>
	
								<tbody>
									@foreach($sellerorders as $key=> $order)
										@if(isset($order->getorder->order) && $order->status == 'initiated')
											<tr>
												<td>{{ $key+1 }}</td>
												<td>
													@if($order->getorder->order->payment_method != 'COD')
														<label class="label label-success">
															{{__('PREPAID')}}
														</label>
													@else
														<label class="label label-primary">
															{{__("COD")}}
														</label>
													@endif
												</td>
												<td><b>#{{ $inv_cus->order_prefix.$order->getorder->order->order_id }}</b>
													<br>
													<small>
														<a href="{{ route('seller.return.order.show',$order->id) }}">{{ __("UPDATE ORDER") }}</a>
													</small>
												</td>
												<td>
													<i class="{{ $order->getorder->order->paid_in }}"></i>{{ $order->amount }}
												</td>
												<td>
													{{ $order->user->name }}
												</td>
												<td>
													{{date('d-M-Y | h:i A',strtotime($order->created_at))}}
												</td>
												
											</tr>
										@endif
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
  
  @endsection
  