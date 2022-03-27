@extends("admin.layouts.sellermastersoyuz")
@section('title',__('Add Product Attributes'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Add Product Attributes') }}
@endslot
@slot('menu1')
   {{ __('Add Product Attributes') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ url('seller/products') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{__(':pro \'s Variant',['pro' => $findpro->name])}} </h5>
                
			</div>

				<div class="card-body">

					<div class="row p-2">
						<div class="p-2 bg-success text-white col-md-12">
							<i class="fa fa-info-circle"></i> <i>{{ __('Quick Guide') }}</i>
							<ul>
								<li>{{ __('Common variant not work until you don\'t Link a variant.') }}</li>
								<li> {{__('Before Link a variant click on')}} <b>{{ __('Add Variant Option') }}</b> ({{__('You can add up to')}} <u>2</u> {{__('variant option')}}).</li>
								<li>{{__('After Link Variant option You can create unlimited variant from that options')}}.</li>
								<li>{{__("After Add a default variant you can create unlimited common variants")}}.</li>
							</ul>
						</div>
					</div>
                    
                    <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-plus mr-2"></i> {{ __('Add Common Variant') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-database mr-2"></i> {{ __('Add Variant Option') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab-line" data-toggle="tab" href="#contact-line" role="tab" aria-controls="contact-line" aria-selected="false"><i class="feather icon-trending-up mr-2"></i> {{ __('Link Variant') }}</a>
                        </li>
                        
                    </ul>
                    <div class="tab-content" id="defaultTabContentLine">
                      

                        <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
							<div class="box box-danger">
								<div class="box-header with-border">
									<div class="card-title">
										<div class="row">
											<div class="col-md-9">
												{{__('Add Common Product Variant For')}} <b>{{ $findpro->name }}</b>
											</div>
											<div class="col-md-3">
												<a @if(env('DEMO_LOCK')==0) data-toggle="modal" href="#cmModal" @else disabled
												title="This action is disabled in demo !" @endif
												class="btn btn-primary-rgba float-right">
												<i class="feather icon-plus"></i> {{__("ADD Common Variant")}}
											</a>
											</div>
										</div>
										

									</div>
	
									
								</div>
	
								<div class="box-body">
									<table id="full_detail_table" class="w-100 table table-bordered table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>{{ __('Variant Name') }}</th>
												<th>{{ __('Variant Value') }}</th>
												<th>{{ __('Action') }}</th>
											</tr>
										</thead>
	
										<tbody>
											@foreach($findpro->commonvars as $key=> $commonvariant)
											<tr>
												<td>{{ $key+1 }}</td>
												<td>
													@php
													$nameofattr = App\ProductAttributes::where('id','=',$commonvariant->cm_attr_id)->first()->attr_name;
													@endphp
													@php
													$key = '_';
													@endphp
													@if (strpos($nameofattr, $key) == false)
	
													{{ $nameofattr }}
	
													@else
	
													{{str_replace('_', ' ', $nameofattr)}}
	
													@endif
												</td>
												<td>
	
													@php
													$nameofval = App\ProductValues::where('id','=',$commonvariant->cm_attr_val)->first();
													@endphp
	
													@if($nameofattr == "Color" || $nameofattr == "Colour" || $nameofattr == 'color' || $nameofattr == 'colour')
	
														<div class="inline-flex">
															<div class="color-options">
																<ul>
																	<li title="{{ $nameofval->values }}"
																		class="color varcolor active"><a href="#" title=""><i
																				style="color: {{ $nameofval->unit_value }}"
																				class="fa fa-circle"></i></a>
																		<div class="overlay-image overlay-deactive">
																		</div>
																	</li>
																</ul>
															</div>
														</div>
														<span class="tx-color">{{ $nameofval->values }}</span>
	
													@else
	
	
	
													@if($nameofval->unit_value != null && strcasecmp($nameofval->unit_value,
													$nameofval->values) != 0)
													{{ $nameofval->values }}{{ $nameofval->unit_value }}
													@else
													{{ $nameofval->values }}
													@endif
	
													@endif
	
												</td>
												<td>
													<div class="dropdown">
														<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
														<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
														  
															<a class="dropdown-item" data-toggle="modal" data-target="#editcm{{ $commonvariant->id }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
															<a class="dropdown-item" @if(env('DEMO_LOCK')==0) data-target="#cmdel{{ $commonvariant->id }}"
																@else disabled title="This action is disabled in demo !" @endif data-toggle="modal"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
															
														  </div>
													</div>
													
	
													
												</td>
	
	
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
	
							</div>
                        </div>
						<div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
							<div class="box box-danger">
								<div class="box-header with-border">
									<div class="box-title">
										<div class="row">
											<div class="col-md-10">
												{{__('Add Product Attributes For')}} <b>{{ $findpro->name }}</b>
											</div>
											<div class="col-md-2 ">
												<a data-toggle="modal" href="#optionModal" class=" btn btn-primary-rgba  float-right">
													<i class="feather icon-plus"></i> ADD Option
												</a>
											</div>
										</div>
									
									</div>
	
	
	
								</div>
	
								<div class="box-body mt-2">
									<table id="full_detail_table" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>{{ __('Option Names') }}</th>
												<th>{{ __('Option Value') }} </th>
												<th>{{ __('Action') }}</th>
											</tr>
										</thead>
										<?php $i=0;?>
										<tbody>
											@foreach($getopts as $opt)
											<?php $i++; ?>
											<tr>
												<td>{{ $i }}</td>
												<td>
													<b>
														@php
														$key = '_';
														@endphp
														@if (strpos($opt->getattrname->attr_name, $key) == false)
	
														{{ $opt->getattrname->attr_name }}
	
														@else
	
														{{str_replace('_', ' ', $opt->getattrname->attr_name)}}
	
														@endif
													</b>
												</td>
												<td width="50%">
													<div class="row">
														
													@foreach($opt->attr_value as $value)
	
													@php
													$originalvalue = App\ProductValues::where('id',$value)->get();
													@endphp
													
													@foreach($originalvalue as $value)
													
													@if($value->unit_value !=null && strcasecmp($value->unit_value,
													$value->values) != 0)
	                                                <div class="col-md-3">
														@if($value->proattr->attr_name == "Color" || $value->proattr->attr_name
														== "Colour")
		
														<div class="numberCircle">
																<a href="#" title=""><i
																	style="color: {{ $value->unit_value }}"
																	class="fa fa-circle"></i></a>
																	
														</div>			
														<span class="tx-color">{{ $value->values }}</span>			
														
														
														@else
														
															{{$value->values}}{{ $value->unit_value }}
														
														
													
														@endif
													
		
														@else
														{{$value->values}}
														@endif
													</div>
													@endforeach
												
												
													@endforeach
												
												</div>
	
												</td>
												<td>
													<div class="dropdown">
														<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
														<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
														  
															<a class="dropdown-item"  data-toggle="modal" href="#edit{{ $opt->id }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
															<a class="dropdown-item" @if(env('DEMO_LOCK')==0) data-toggle="modal"
															href="#{{ $opt->id }}var" @else disabled="" @endif><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
															
														  </div>
													</div>
													
	
													
												</td>
	
											
	
	
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
	
						
					</div>
					<div class="tab-pane fade" id="contact-line" role="tabpanel" aria-labelledby="contact-tab-line">
						<div class="box box-danger">
							<div class="box-header with-border">
								<div class="box-title">
									<div class="row">
										<div class="col-md-10">
											{{__('Link variant for')}} <b>{{ $findpro->name }}</b>
										</div>
										<div class="col-md-2">
											<a class="btn  btn-primary-rgba float-right"
									href="{{ route('seller.manage.stock',$findpro->id) }}"><i class="feather icon-plus mr-2"></i> {{__("ADD")}}
								</a>
										</div>
									</div>
									
								</div>

								
							</div>

							<div class="box-body mt-2">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>{{ __('Name') }}</th>
											<th>{{ __('Additional detail') }}</th>
											<th>{{ __('Default') }}</th>
											<th>{{ __('Action') }}</th>
										</tr>
									</thead>

									@foreach($findpro->subvariants as $key=> $sub)
									<tr>

										<td>

											{{$key+1}}
										</td>
										<td>@foreach($sub->main_attr_value as $key=> $originalvalue)
											@if($originalvalue != 0)
											@php
											$getattrname = App\ProductAttributes::where('id',$key)->first();
											@endphp

											@php
											$getattrval = App\ProductValues::where('id',$originalvalue)->first();
											@endphp

											<b>
												@php
												$key = '_';
												@endphp
												@if (strpos($getattrname->attr_name, $key) == false)

												{{ $getattrname->attr_name }}

												@else

												{{str_replace('_', ' ', $getattrname->attr_name)}}

												@endif
											</b> :

											@if(strcasecmp($getattrval->unit_value, $getattrval->values) !=0)

											@if($getattrname->attr_name == "Color" || $getattrname->attr_name ==
											"Colour")


											
												
														<i style="color: {{ $getattrval->unit_value }}"
																	class="border border-primary shadow-sm rounded p-1 fa fa-circle"></i>
																	<span class="tx-color">{{ $getattrval->values }}</span>
															
														</li>
														
													</ul>
											
											
											

											@else
											{{ $getattrval->values }}{{ $getattrval->unit_value }}
											@endif

											@else
											{{ $getattrval->values }}
											@endif

											<br>
											@else
											@php
											$getattrname = App\ProductAttributes::where('id',$key)->first();
											@endphp
											<b>{{ $getattrname->attr_name }}</b> :
											Not Available
											<br>
											@endif
											@endforeach
										</td>

										<td>
											<p><b>{{ __('Price') }}:</b> {{ $sub->price }}</p>
											<p><b>{{ __('Stock') }}:</b> {{ $sub->stock }}</p>
											<p><b>{{ __('Weight') }}:</b> {{ $sub->weight }}{{ $sub->unitname->short_code ?? '' }}</p>
											<p><b>{{ __('Min Order Qty') }}:</b>{{ $sub->min_order_qty }}</p>
											<p><b>{{ __('Max Order Qty') }}:</b>{{ $sub->max_order_qty }}</p>
										</td>
										<td class="v-middle custom-radios">

											<input name="def" class="setdefButton cmn" data-proid="{{ $findpro->id }}"
												id="{{ $sub->id }}" type="radio" {{ $sub->def==1 ? "checked" : "" }}>


											<label for="{{ $sub->id }}">
												
											</label>


										</td>
										<td>
											<div class="dropdown">
												<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
												<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
													
													<a class="dropdown-item"  href="{{ route('seller.edit.var',$sub->id) }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
													<a class="dropdown-item" @if(env('DEMO_LOCK')==0) data-toggle="modal"
													href="#deletevar{{ $sub->id }}" @else
													title="{{ __('This action is disabled in demo !') }}" disabled @endif><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
													
													</div>
											</div>
										</td>
											

									</tr>
									@endforeach
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
@foreach($findpro->commonvars as $key=> $commonvariant)
<!--Edit Modal -->
<div class="modal fade" id="editcm{{ $commonvariant->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Edit {{ $nameofattr }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
			
			</div>

			<div class="modal-body">
				<form action="{{ route('common.update',$commonvariant->id) }}" method="POST">
					@csrf
					<label for="">Edit Options:</label>
					<p></p>
					@foreach($commonvariant->attribute->provalues as $attrval)
					
						@php
						
							$nameofattr = App\ProductAttributes::where('id','=',$commonvariant->cm_attr_id)->first()->attr_name;
							$key = '_';

						@endphp

					@if (strpos($nameofattr, $key) == false)

						@php
							$nameofattr = $nameofattr;
						@endphp

					@else

						@php

						$nameofattr = 	str_replace('_', ' ', $nameofattr);
							
						@endphp
				

					@endif

					@if($nameofattr== 'Color' ||  $nameofattr == 'color' || $nameofattr == 'Colour' || $nameofattr == 'colour')
					<div class="inline-flex">
						
						<label><input {{ $commonvariant->cm_attr_val == $attrval->id ? "checked" : "" }} required class="margin-left-8" type="radio" name="cm_attr_val" value="{{ $attrval->id }}"><div class="inline-flex"><div class="color-options"><ul><li title="{{ $attrval->values }}" class="color varcolor active"><a href="#" title="{{ $attrval->values }}"><i style="color:{{ $attrval->unit_value }}" class="fa fa-circle"></i></a><div class="overlay-image overlay-deactive"></div></li></ul></div></div><span class="tx-color">{{ $attrval->values }}</span></label>

					</div>
					@else

					<label>
						<input {{ $commonvariant->cm_attr_val == $attrval->id ? "checked" : "" }} type="radio"
							name="cm_attr_val" value="{{ $attrval->id }}">
						{{ $attrval->values }}{{ $attrval->unit_value }}
					</label>

					@endif
					@endforeach
					
					<button class="btn btn-primary mt-3" type="submit"><i class="fa fa-check-circle mr-2"></i>{{ __('Update') }}</button>
				</form>
			</div>

		</div>
	</div>
</div>

<!-- Delete Common Variant -->
<div id="cmdel{{ $commonvariant->id }}" class="delete-modal modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="delete-icon"></div>
			</div>
			<div class="modal-body text-center">
				<h4 class="modal-heading">{{ __('Are You Sure ?') }}</h4>
				<p>{{ __('Do you really want to delete this variant? This process cannot be undone') }}.</p>
			</div>
			<div class="modal-footer">
				<form method="post" action="{{route('seller.del.common',$commonvariant->id)}}" class="pull-right">
					{{csrf_field()}}
					{{method_field("DELETE")}}
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">No</button>
					<button type="submit" class="btn btn-danger">Yes</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endforeach

@foreach($getopts as $opt)

<div id="edit{{ $opt->id }}" class="delete-modal modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				
				<div class="modal-title">
					Edit: <b> @php
						$key = '_';
						@endphp
						@if (strpos($opt->getattrname->attr_name, $key) == false)

						{{ $opt->getattrname->attr_name }}

						@else

						{{str_replace('_', ' ', $opt->getattrname->attr_name)}}

						@endif </b>
				</div>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('seller.updt.var2',$opt->id) }}" method="POST">
					{{ csrf_field() }}

					<div class="form-group">
						<label><i>Choosed Option:</i>
							@php
							$key = '_';
							@endphp
							@if (strpos($opt->getattrname->attr_name, $key) == false)

							{{ $opt->getattrname->attr_name }}

							@else

							{{str_replace('_', ' ', $opt->getattrname->attr_name)}}

							@endif
						</label>

						@php
						$pvalues = App\ProductValues::where('atrr_id', $opt->attr_name)->get();
						@endphp
						<br>
						<label><input type="checkbox" class="sel_all"> {{__('Select all') }}</label>
						<br>
						<label for="">{{ __('Choose Value') }}:</label>
						<br>


						@php

						$all_values =
						App\ProductValues::where('atrr_id',$opt->attr_name)->pluck('id','values')->toArray();

						$old_values = $opt->attr_value;
						$diff_values = array_diff($all_values,$old_values);

						@endphp

						@if(isset($old_values) && count($old_values) > 0)
						@foreach($old_values as $old_value)
						<label>
							<input checked type="checkbox" name="attr_value[]" value="{{ $old_value }}">
							@php
							$getvalname = App\ProductValues::where('id',$old_value)->first();
							@endphp
							@if(strcasecmp($getvalname->unit_value, $getvalname->values) !=0)

							@if($opt->getattrname->attr_name == "Color" || $opt->getattrname->attr_name == "Colour")
								<i style="color: {{ $getvalname->unit_value }}" class="fa fa-circle"></i> 
								<span class="tx-color">{{ $getvalname->values }}</span>
							@else
							{{ $getvalname->values }}{{ $getvalname->unit_value }}
							@endif
							@else
							{{ $getvalname->values }}
							@endif
						</label>
						@endforeach
						@endif

						@if(isset($diff_values))
						@foreach($diff_values as $orivalue)
						<label>
							<input type="checkbox" value="{{ $orivalue }}" name="attr_value[]">
							@php
							$getvalname = App\ProductValues::where('id',$orivalue)->first();
							@endphp
							@if(strcasecmp($getvalname->unit_value, $getvalname->values) !=0)

							@if($opt->getattrname->attr_name == "Color" || $opt->getattrname->attr_name == "Colour")
							<i style="color: {{ $getvalname->unit_value }}" class="fa fa-circle"></i> 
							<span class="tx-color">{{ $getvalname->values }}</span>
							@else
							{{ $getvalname->values }}{{ $getvalname->unit_value }}
							@endif
							@else
							{{ $getvalname->values }}
							@endif
						</label>
						@endforeach
						@endif

						<p>

						</p>
					</div>

					<button class="btn btn-md btn-primary" type="submit">
						<i class="fa fa-check-circle mr-2"></i> {{__('Update')}}
					</button>
				</form>


			</div>

		</div>
	</div>
</div>

<div id="{{ $opt->id }}var" class="delete-modal modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="delete-icon"></div>
			</div>
			<div class="modal-body text-center">
				<h4 class="modal-heading">{{ __('Are You Sure ?') }}</h4>
				<p>
					{{__('Do you really want to delete this variant? This process cannot be undone.')}}
				</p>
			</div>
			<div class="modal-footer">
				<form method="post" action="{{route('seller.del.subvar',$opt->id)}}" class="pull-right">
					{{csrf_field()}}
					{{method_field("DELETE")}}
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
					<button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endforeach

<!--Sub variant delete modal-->
@foreach($findpro->subvariants as $key=> $sub)
<div id="deletevar{{ $sub->id }}" class="delete-modal modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="delete-icon"></div>
			</div>
			<div class="modal-body text-center">
				<h4 class="modal-heading">
					{{__('Are You Sure ?')}}
				</h4>
				<p>
					{{__('Do you really want to delete this variant? This process cannot be undone.')}}
				</p>
			</div>
			<div class="modal-footer">
				<form method="post" action="{{ route('seller.del.var',$sub->id) }}" class="pull-right">
					{{csrf_field()}}
					{{method_field("DELETE")}}
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">
						{{__("No")}}
					</button>
					<button type="submit" class="btn btn-danger">
						{{__('Yes')}}
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endforeach
<!--END Sub variant delete modal-->

<!-- Common Variant Modal -->
<div class="modal fade" id="cmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
					{{__('Add Product Common Variant')}}
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				
			</div>
			<div class="modal-body">
				<form action="{{ route('seller.add.common',$findpro->id) }}" method="POST">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="">{{ __('Option Name') }}:</label>

						@php

							$array1 = array();
							$test = collect();
							$array1[] = $findpro->category_id;
							$array2 = collect();

							foreach (App\ProductAttributes::all() as $value) {
								
								$array2 = $value->cats_id;
								$result = array_intersect($array1, $array2);

								if(in_array($findpro->category_id,$value->cats_id)){
									$test->push($value);
								}
							
							}


						@endphp

						<select required="" class="form-control select2" name="attr_name2" id="attr_name2">
							<option value="">
								{{__('Please Choose')}}
							</option>
							@foreach($test as $t)
							<option value="{{ $t->id }}">

								@php
								$key = '_';
								@endphp
								@if (strpos($t->attr_name, $key) == false)

								{{ $t->attr_name }}

								@else

								{{str_replace('_', ' ', $t->attr_name)}}

								@endif

							</option>
							@endforeach
						</select>

					</div>

					<div class="form-group">
						<label for="">{{ __('Option Value') }}:</label>
						<div id="attr_value2">
                                  
						</div>

					</div>

					<button class="btn  btn-primary-rgba" type="submit">
						<i class="fa fa-check-circle mr-2"></i> {{__('Update')}}
					</button>
				</form>


			</div>

		</div>
	</div>
</div>

<!--END-->

<!--Add Link varaint modal-->

<!-- Add Variant Modal -->
<div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
					{{__('Add Product Attributes')}}
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				
			</div>
			<div class="modal-body">
				<form action="{{ route('seller.add.str',$findpro->id) }}" method="POST">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="">{{ __('Option Name') }}:</label>

						@php

						$array1 = array();
						$test = collect();
						$array1[] = $findpro->category_id;
						$array2 = collect();
                        
						foreach (App\ProductAttributes::all() as $value) {
						$array2 = $value->cats_id;
						$result = array_intersect($array1, $array2);
                        
						if(in_array($findpro->category_id,$value->cats_id))
						{
						    $test->push($value);
						}
						}

						@endphp

						<select class="form-control select2" name="attr_name" id="attr_name">
							<option>Please Choose</option>
							@foreach($test as $t)
							<option value="{{ $t->id }}">

								@php
								$key = '_';
								@endphp
								@if (strpos($t->attr_name, $key) == false)

								{{$t->attr_name }}

								@else

								{{str_replace('_', ' ', $t->attr_name)}}

								@endif
							</option>
							@endforeach
						</select>

					</div>

					<div class="form-group">
						<div id="sel_box">

						</div>
						<label for="">{{ __('Option Value') }}:</label>
						 
							<div  id="attr_value">

						
						  </div>
	

					</div>

					<button class="btn btn-primary" type="submit">
						<i class="fa fa-check-circle mr-2"></i> {{__('Update')}}
					</button>
				</form>


			</div>

		</div>
	</div>
</div>
<!--END-->   

@endsection     
               

@section('custom-script')
    <script>var baseUrl = "<?= url('/') ?>";</script>
	<script src="{{ url('js/sellervariant.js') }}"></script>
@endsection
          


