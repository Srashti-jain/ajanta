@extends('admin.layouts.master-soyuz')
@section('title',__('Shipping Weight | '))

@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

	@slot('heading')
		{{ __('Shipping') }}
	@endslot

	@slot('menu2')
		{{ __("Shipping by weight") }}
	@endslot

	@slot('button')
		<div class="col-md-6">
			<div class="widgetbar">
				
				
				<a href="{{ url()->previous() }}" class="float-right btn btn-primary-rgba mr-2"> <i class="fa fa-arrow-left"></i> {{__("Back")}} </a>
				
				
			</div>
		</div>
	@endslot
​
@endcomponent

<div class="contentbar">
	<div class="row mb-3">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">
						{{__("Shipping Weight")}}
					</div>
				</div>
	
				<div class="card-body">
					<form method="POST" action="{{ route('update.ship.wt') }}">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-3">
								<label>{{ __("Weight From:") }}</label>
								<input type="text" name="weight_from_0" placeholder="0" class="form-control" value="{{ $swt->weight_from_0 }}" />
							</div>
							<div class="col-md-3">
								<label>
									{{__("Weight To:")}}
								</label>
								<input type="text" name="weight_to_0" placeholder="20" class="form-control" value="{{ $swt->weight_to_0 }}" />
							</div>
							<div class="col-md-3">
								<label>
									{{__("Weight Price:")}}
								</label>
								<input type="text" name="weight_price_0" placeholder="10" class="form-control" value="{{ $swt->weight_price_0 }}" />
							</div>
		
							<div class="col-md-3">
								<label>
									{{__("Per Order/Quantity:")}}
								</label>
								<select class="form-control" name="per_oq_0" id="">
									<option {{ $swt->per_oq_0=="po" ? "selected" :"" }} value="po">
										{{__("Per Order")}}
									</option>
									<option {{ $swt->per_oq_0=="pq" ? "selected" :"" }} value="pq">
									{{__('Per Quantity') }}</option>
								</select>
							</div>
						</div>
		
						<div class="last_btn row">
							<div class="col-md-3">
								<label>
									{{__('Weight From:')}}
								</label>
								<input type="text" name="weight_from_1" placeholder="21" class="form-control" value="{{ $swt->weight_from_1 }}" />
							</div>
							<div class="col-md-3">
								<label>
									{{__("Weight To:")}}
								</label>
								<input type="text" name="weight_to_1" placeholder="40" class="form-control" value="{{ $swt->weight_to_1 }}"/>
							</div>
							<div class="col-md-3">
								<label>
									{{__("Weight Price:")}}
								</label>
								<input type="text" name="weight_price_1" placeholder="20" class="form-control" value="{{ $swt->weight_price_1 }}"/>
							</div>
		
							<div class="col-md-3">
								<label>Per Order/Quantity:</label>
								<select class="form-control" name="per_oq_1" id="">
									<option {{ $swt->per_oq_1=="po" ? "selected" :"" }} value="po">{{ __("Per Order") }}</option>
									<option {{ $swt->per_oq_1=="pq" ? "selected" :"" }} value="pq">{{ __("Per Quantity") }}</option>
								</select>
							</div>
						</div>
		
						<div class="last_btn row">
							<div class="col-md-3">
								<label>{{ __("Weight From:") }}</label>
								<input type="text" name="weight_from_2" placeholder="41" class="form-control" value="{{ $swt->weight_from_2 }}"/>
							</div>
							<div class="col-md-3">
								<label>{{ __("Weight To:") }}</label>
								<input type="text" name="weight_to_2" placeholder="60" class="form-control" value="{{ $swt->weight_to_2 }}"/>
							</div>
							<div class="col-md-3">
								<label>{{ __('Weight Price:') }}</label>
								<input type="text" name="weight_price_2" placeholder="30" class="form-control" value="{{ $swt->weight_price_2 }}"/>
							</div>
		
							<div class="col-md-3">
								<label>
									{{__("Per Order/Quantity:")}}
								</label>
								<select class="form-control" name="per_oq_2" id="">
									<option {{ $swt->per_oq_2=="po" ? "selected" :"" }} value="po">{{ __("Per Order") }}</option>
									<option {{ $swt->per_oq_2=="pq" ? "selected" :"" }} value="pq">{{ __("Per Quantity") }}</option>
								</select>
							</div>
						</div>
		
						<div class="last_btn row">
							<div class="col-md-3">
								<label>{{ __('Weight From:') }}</label>
								<input type="text" name="weight_from_3" placeholder="61" class="form-control" value="{{ $swt->weight_from_3 }}" />
							</div>
		
							<div class="col-md-3">
								<label>{{ __("Weight To:") }}</label>
								<input type="text" name="weight_to_3" placeholder="80" class="form-control" value="{{ $swt->weight_to_3 }}"/>
							</div>
		
							<div class="col-md-3">
								<label>{{ __("Weight Price:") }}</label>
								<input type="text" name="weight_price_3" placeholder="40" class="form-control" value="{{ $swt->weight_price_3 }}"/>
							</div>
		
							<div class="col-md-3">
								<label>
									{{__("Per Order/Quantity:")}}
								</label>
								<select class="form-control" name="per_oq_3" id="">
									<option {{ $swt->per_oq_3=="po" ? "selected" :"" }} value="po">
										{{__("Per Order")}}
									</option>
									<option {{ $swt->per_oq_3=="pq" ? "selected" :"" }} value="pq">
										{{__("Per Quantity")}}
									</option>
								</select>
							</div>
						</div>
		
						<div class="last_btn row">
							<div class="col-md-3">
								<label>
									{{__("Limit From Than:")}}
								</label>
								<input type="text" name="weight_from_4" placeholder="61" class="form-control" value="{{ $swt->weight_from_4 }}" />
							</div>
							<div class="col-md-3">
								
							</div>
							<div class="col-md-3">
								<label>
									{{__("Weight Price:")}}
								</label>
								<input type="text" name="weight_price_4" placeholder="40" class="form-control" value="{{ $swt->weight_price_4 }}" />
							</div>
		
							<div class="col-md-3">
								<label>
									{{__("Per Order/Quantity:")}}
								</label>
								<select class="form-control" name="per_oq_4" id="">
									<option {{ $swt->per_oq_4=="po" ? "selected" :"" }} value="po">
										{{__("Per Order")}}
									</option>
									<option {{ $swt->per_oq_4=="pq" ? "selected" :"" }} value="pq">
										{{ __("Per Quantity") }}
									</option>
								</select>
							</div>
						</div>
		
						<div class="card-footer">
								<button type="submit" class="btn btn-primary-rgba btn-md"><i class="fa fa-save"></i> {{ __("Update") }}</button>
								<a class="btn btn-md btn-danger-rgba" href="{{ url('/admin/shipping') }}"><i class="fa fa-times" aria-hidden="true"></i>
								 {{__("Cancel")}}
								</a>
						</div>
					</form>
				</div>
	
			</div>
		</div>
	</div>
</div>


@endsection