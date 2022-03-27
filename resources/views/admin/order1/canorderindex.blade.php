@extends('admin.layouts.master-soyuz')
@section('title',__('Canceled Orders |'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Canceled Orders') }}
@endslot
@slot('menu2')
{{ __("Canceled Orders") }}
@endslot

@endcomponent
​
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
			<h5>{{ __('Canceled Orders') }}</h5>
			</div>
			<div class="card-body">
				<div class="card m-b-30">
					<div class="row">
						
                        <div class="col-md-12 ">
							<div class="p-2 rounded mb-2 bg-success text-white">
                            <i class="fa fa-info-circle"></i> {{ __('Note :') }}
                            <ul>
                                <li>{{ __("COD Orders are only viewable !") }}</li>
                                <li>
									{{__("For Prepaid canceled orders with refund method choosen Bank You can View Details IF refund is complete.")}}
								</li>
                                <li>
									{{__('For Prepaid canceled orders with refund method choosen orignal you can track refund status LIVE from respective Payment gateway & Update TXN/REF ID.')}}
                                </li>
                            </ul>
						   </div>
                        </div>
                    </div>
						
					
					
					
					
						<ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab-line" data-content="{{ __("If order have only 1 item than its count in single canceled orders.") }}"  data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-truck mr-2"></i>
									{{__("Single Canceled Orders")}}  @if($partialcount>0)<span class="badge badge-danger"><span id="pcount">{{ $partialcount }}</span> New @endif</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="profile-tab-line" data-content="{{ __('If order have more than 1 item than its count in Bulk canceled orders.') }}" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-truck mr-2"></i>
									{{__("Bulk Canceled Orders")}} @if($fullcount>0)<span class="badge badge-danger"><span id="fcount">{{ $fullcount }}</span> {{__("New")}} @endif</a>
							</li>
							
						</ul>

						<div class="tab-content" id="defaultTabContentLine">
							<div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
								<table id="full_detail_table" class="w-100 table table-bordered">
									<thead>

										<th>
											#
										</th>

										<th>
											{{__("Order TYPE")}}
										</th>

										<th>
											{{__("ORDER ID")}}
										</th>

										<th>
											{{__('REASON for Cancellation')}}
										</th>

										<th>
											{{__("REFUND METHOD")}}
										</th>

										<th>
											{{__("CUSTOMER")}}
										</th>

										<th>
											{{__("REFUND STATUS")}}
										</th>

									</thead>

									<tbody>
										@foreach($cOrders as $key=> $order)
											<tr>
												<td>{{ $key+1 }}</td>
												<td>

													@if($order->order->payment_method != 'COD')
														<label class="badge badge-success">
															{{__("PREPAID")}}
														</label>
													@else
														<label class="badge badge-primary">
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
															<a onclick="readorder('{{ $order->id }}')"  class="cpointer" data-toggle="modal" data-target="#orderupdate{{ $order->id }}">
																{{__("UPDATE ORDER")}}
															</a>
														@else

															<a role="button" class="cpointer" onclick="readorder('{{ $order->id }}')"  data-toggle="modal" data-target="#orderupdate{{ $order->id }}">
																{{__("UPDATE ORDER")}}
															</a> | <a onclick="trackrefund('{{ $order->id }}')" class="cpointer" role="button">{{ __("TRACK REFUND") }}</a>
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
													{{__("No need for COD Orders")}}
													@endif
												</td>
												<td>
													@php
														$name = App\User::find($order->order->user_id)->name;
													@endphp

													@if(isset($name))
													{{ $name }}
													@else

													{{__("No Name")}}

													@endif
												</td>

												<td>
													@if($order->is_refunded == 'pending')
														<label class="badge badge-danger">{{ ucfirst($order->is_refunded) }}</label>
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
								<table id="full_detail_table2" class="w-100 table table-striped table-bordered">
									<thead>
										<th>
											#
										</th>
										<th>
											{{__("Order TYPE")}}
										</th>
										<th>
											{{__("Order ID")}}
										</th>
										<th>
											{{__("REASON for Cancellation")}}
										</th>
										<th>
											{{__("REFUND METHOD")}}
										</th>
										<th>
											{{__("CUSTOMER")}}
										</th>
										<th>
											{{__("REFUND STATUS")}}
										</th>
									</thead>

									<tbody>
										@foreach($comOrder as $key=> $fcorder)
											<tr>
												<td>{{ $key+1 }}</td>
												<td>

														@if($fcorder->getorderinfo->payment_method != 'COD')
															<label class="label label-success">{{ __("PREPAID") }}</label>
														@else
															<label class="label label-primary">{{ __("COD") }}</label>
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
																<a onclick="readfullorder('{{ $fcorder->id }}')"  class="cpointer" data-toggle="modal" data-target="#fullorderupdate{{ $fcorder->id }}">
																	{{__("UPDATE ORDER")}}
																</a>
															@else
																<a onclick="readfullorder('{{ $fcorder->id }}')" class="cpointer" data-toggle="modal" data-target="#fullorderupdate{{ $fcorder->id }}">{{ __("UPDATE ORDER") }}</a> | <a class="cpointer" onclick="trackrefundFullCOrder('{{ $fcorder->id }}')">{{ __('TRACK REFUND') }}</a>
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
															<label class="badge badge-primary">{{ ucfirst($fcorder->is_refunded) }}</label>
														@else
															<label class="badge badge-success">{{ ucfirst($fcorder->is_refunded) }}</label>
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
        </div>
      </div>
    </div>
  </div>
</div>

				  
							
					
    
                

								
									
									
									
								
									

								
								

                        
                  

<!-- Single Refund Modal -->
@include('admin.order.singleordermodal')
<!--END-->

<!-- FULL Refund Modal -->
@include('admin.order.fullordermodal')
<!--END-->
@endsection
@section('custom-script')
    <script>var baseUrl = "<?= url('/') ?>";</script>
	<script src="{{ url('js/order.js') }}"></script>
@endsection