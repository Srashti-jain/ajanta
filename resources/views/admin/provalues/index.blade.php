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
  <a href="{{ route('attr.index') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
@endslot
@endcomponent
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
          <h5 class="box-title">{{__("Option values for :")}} <b>{{ $proattr->attr_name }}</b></h5>
        </div>
        <div class="card-body">
      
		<div class="card bg-warning m-b-30">
			<div class="card-body">
			<div class="row align-items-center">
				<div class="col-12">
				<p class="mb-0 text-white font-14"><i class="fa fa-info-circle" aria-hidden="true"></i>
					{{__('Once you created value option you can\'t Delete it ! You can only edit it')}}
				</p>
				
				</div>
				
			</div>
			</div>
		</div>


		<!-- form start -->
		<h5>{{__("Add New Option Value for")}} <b>{{ $proattr->attr_name }}</b></h5>
		<form method="post" enctype="multipart/form-data" action="{{ route('pro.val.store',$proattr->id) }}" data-parsley-validate class="form-horizontal form-label-left">
		{{ csrf_field() }}
              <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Value :') }} </label>
                        <input required="" type="text" name="value" class="form-control">
                    </div>
                </div>

				<div class="col-md-6">
					<label class="text-dark">{{ __('Choose color value :') }} </label>
						
						@if($proattr->attr_name == "Color" || $proattr->attr_name == "Colour")
						<div class="input-group initial-color">
								<input type="text" class="form-control input-lg" value="#000000"  name="unit_value" placeholder="#000000"/>
								<span class="input-group-append">
									<span class="input-group-text colorpicker-input-addon"><i></i></span>
									</span>
				            </div>
						@else
						<div class="form-group">
							@php
								$getunitvals = App\UnitValues::where('unit_id','=',$proattr->unit_id)->get();
							@endphp
							<select name="unit_value" id="" class="form-control">

								@isset($getunitvals)
									@foreach($getunitvals as $unitval)
										<option value="{{ $unitval->short_code }}">{{ $unitval->unit_values }} {{ "(".$unitval->short_code.")" }}</option>
									@endforeach
								@endisset
								
							</select>
						</div>
						@endif
					</div>
        
					<div class="col-md-12">
						<div class="form-group">
							<button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
							{{ __("Create")}}</button>
						</div>
					</div>
				
              </div>
            </form>
		<!-- form end -->

		<!-- table start -->
		<table class="table table-bordered table-striped">
						<thead>
							<th>#</th>
							<th>
								{{__("Value")}}
							</th>
							<th>
								{{__("Action")}}
							</th>
						</thead>

						<tbody>
							<?php $i=0;?>
							@foreach($provalues as $proval)
							<?php $i++; ?>
								<tr>
									<td>{{$i}}</td>
									<td>
									<div class="row">
							       <div class="col-md-12">
							        <div class="row">
										@if(strcasecmp($proval->unit_value, $proval->values) !=0)

										@if($proattr->attr_name == "Color" || $proattr->attr_name == "Colour")
										
										<div class="inline-flex margin-left-minus-15">
											<div class="color-options">
												<ul>
													<li
														class="color varcolor active"><a href="#" title=""><i
																style="color: {{ $proval->unit_value }}"
																class="fa fa-circle"></i></a>
														<div class="overlay-image overlay-deactive">
														</div>
													</li>
												</ul>
											</div>
										</div>

										<span class="tx-color">{{ $proval->values }}</span>

										
									
										@else
										{{ $proval->values }}{{ $proval->unit_value }}
										@endif

										@else
										{{ $proval->values }}
										@endif
										</div>
								</div>
								</div>
									</td>
									<td>
									<div class="dropdown">
                                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                            
                                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#edit{{ $proval->id }}" >
                                                <i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                                           
                                        </div>
                                    </div>
										
										<!-- =======edit modal start================ -->
										<div class="modal fade" id="edit{{ $proval->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleStandardModalLabel">Edit Value: <b>{{ $proval->values }}</b></h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<!-- main content start -->
														<div class="display-none" id="result{{ $proval->id }}">
            		
														</div>

														<div class="form-group">

															<label class="text-dark" for="">Edit Value:</label>
															<input id="getValue{{ $proval->id }}" type="text" placeholder="Enter value" class="form-control" name="values" value="{{ $proval->values }}">
															
														</div>

														@php
															$getunit = App\Unit::where('id','=',$proval->proattr->unit_id)->first();
														@endphp
														
														<div class="form-group">
															<label class="text-dark" for="">Edit Color value :</label>
																@if($proval->proattr->attr_name == "Color" || $proval->proattr->attr_name == "Colour")
																	
																<div class="input-group initial-color" title="Using input value">
																	<input type="text"  id="unit_val{{ $proval->id }}"  class="form-control input-lg" value="{{ $proval->unit_value ? $proval->unit_value : '#000000' }}"  name="unit_value" placeholder="#000000"/>
																	<span class="input-group-append">
																		<span class="input-group-text colorpicker-input-addon"><i></i></span>
																		</span>
																</div>
																	
																@else
															
															<select name="unit_value" id="unit_val{{ $proval->id }}" class="form-control">
																@isset($getunit->unitvalues)
																	@foreach ($getunit->unitvalues as $uval)
																		<option {{ $proval->unit_value == $uval->short_code ? "selected" : "" }} value="{{ $uval->short_code }}">{{ $uval->unit_values }}</option>
																	@endforeach
																@endisset
															</select>

															@endif
														</div>
														<!-- main content end -->
													</div>
													<div class="modal-footer">
														<button type="reset" class="btn btn-danger translate-y-3" data-dismiss="modal">{{ __('Close') }}</button>
                										<button @if(env('DEMO_LOCK') == 0) onclick="submit('{{ $proval->id }}','{{ $proattr->id }}')" type="submit" @else title="This action is disabled in demo !" disabled="disabled"  @endif id="update" class="btn btn-primary"><i class="fa fa-check-circle"></i> {{ __("Update") }}</button>
													</div>
												</div>
											</div>
										</div>
										<!-- ===== edit modal end ============= -->
											
									</td>

									
								</tr>
							@endforeach
						</tbody>
					</table>
		<!-- table end -->

        <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('custom-script')
<script>
	var url = {!!json_encode( url('admin/product/manage/values/update/') )!!};
</script>
<script src="{{ url('js/provalue.js') }}"></script>
@endsection

