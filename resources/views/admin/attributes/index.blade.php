@extends('admin.layouts.master-soyuz')
@section('title',__('Manage All Options -'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Manage All Options') }}
@endslot
@slot('menu2')
{{ __("Manage All Options") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  @can('pages.create')
  <a href="{{ route('attr.add') }}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Option') }}</a>
  @endcan
  </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">   
	<div class="col-lg-12">
		<div class="card m-b-30">
			<div class="card-header">
				<h5 class="card-title">{{ __('Manage All Options') }}</h5>
			</div>
			
			<div class="card-body">
			 
				
				<div class="table-responsive">
					<table id="full_detail_table" class="w-100 table table-borderd table-responsive">
						<thead>
							<th>#</th>
							<th>{{ __("Options") }}</th>
							<th>{{ __("Values") }}</th>
							<th>{{ __("In Categories") }}</th>
							
						</thead>
						
						<tbody>
							@foreach($pattr as $k => $pat)
					        
								<tr>
									<td class="text-dark">{{ $k+1 }}</td>
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
											
											</b> <br>
											<a href="{{ route('opt.edit',$pat->id) }}">Edit Option</a>
									
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
										<br>
										<a href="{{ route('pro.val',$pat->id) }}">Manage Values</a>
											
										
										
									</td>
									<td>
										@foreach($pat->cats_id as $cats)
										@php
											$getcatname = App\Category::where('id',$cats)->first();
										@endphp
										   {{ isset($getcatname) ? $getcatname->title : "-" }},
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

