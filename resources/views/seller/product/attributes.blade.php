@extends('admin.layouts.sellermastersoyuz')
@section('title',__('Available Product Attributes'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Available Product Attributes') }}
@endslot
@slot('menu1')
   {{ __('Available Product Attributes') }}
@endslot




@endcomponent

<div class="contentbar">   
	<div class="col-lg-12">
		<div class="card m-b-30">
			<div class="card-header">
				<h5 class="card-title">{{ __('Available Product Attributes')}}</h5>
			</div>
			
			<div class="card-body">
			 
				
				<div class="table-responsive">
					<table id="full_detail_table" class="width100 table table-borderd table-responsive">
						<thead>
							<th>#</th>
							<th>
								{{__('Options')}}
							</th>
							<th>
								{{__('Values')}}
							</th>
							<th>
								{{__('In Categories')}}
							</th>
							
						</thead>
						<?php $i=0;?>
						<tbody>
							@foreach($pattr as $pat)
							<?php $i++;?>
								<tr>
									<td class="text-dark">{{ $i }}</td>
									<td>
										<b>
		
											@php
												  $k = '_'; 
											@endphp
		
											@if (strpos($pat->attr_name, $k) == false)
											
											  {{ $pat->attr_name }}
											   
											@else
											  
											  {{str_replace('_', ' ',$pat->attr_name)}}
											  
											@endif
											
											</b>
									</td>
									<td width="60%">
										<div class="row">
											@foreach($pat->provalues->all() as $t)
											<div class="col-md-3 mb-2">
												@if(strcasecmp($t->unit_value, $t->values) !=0)
												@if($pat->attr_name == "Color" || $pat->attr_name == "Colour")
												
												<div class="numberCircle">
													<a href="#" title=""><i style="color: {{ $t->unit_value }}" class="fa fa-circle"></i></a><br>
												
												</div>
												<span class="tx-color">{{ $t->values }}</span>	
													
													
												@else
													{{ $t->values }}{{ $t->unit_value }},
												@endif
												@else
			
													{{ $t->values }},
													
												@endif
											</div>
											@endforeach
										</div>
										
											
										
										
									</td>
									<td>
										@foreach($pat->cats_id as $cats)
										 
											@php
												$getcatname = App\Category::where('id',$cats)->first();
											@endphp

											@if(isset($getcatname))
												{{$getcatname->title}} {{!$loop->last ? "," : ''}}
											@endif

										@endforeach
									</td>
									
		
									
								</tr>
							@endforeach
						</tbody>
					</table>
			  </div>
		  </div>
	  </div>
  </div>
  <!-- End col -->
</div>

@endsection  