@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Option - :option | ',['option' => $proattr->attr_name]))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Edit Option') }}
@endslot
@slot('menu2')
{{ __("Edit Option") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{ route('attr.index') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
@endslot
​
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
          <h5 class="box-title">{{ __('Edit Option - :option | ',['option' => $proattr->attr_name]) }}</h5>
        </div>
        <div class="card-body">
        <!-- main content start -->
	

			<!-- form start -->
			<form  method="post" enctype="multipart/form-data" action="{{ route('opt.update',$proattr->id) }}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Name :') }}</label>
                        <input required="" type="text" placeholder="Please Enter name" name="attr_name" class="form-control" value="{{ $proattr->attr_name }}" />
                    </div>
                </div>

				
                <div class="col-md-6">
                  <div class="form-group">
                      <label class="text-dark">{{ __('Update Category :') }}</label><br>
					  	<label>
						<input type="checkbox" class="selectallbox"> {{__("Select All")}}
						</label><br>
						@php

								$all_values = App\Category::pluck('id','title')->toArray();

								$old_values = $proattr->cats_id;

								$diff_values = array_diff($all_values,$old_values);
								
								@endphp

								@if(isset($old_values) && count($old_values) > 0)
					      			@foreach($old_values as $old_value)
										
										

											@php
											  $getcatname = App\Category::where('id',$old_value)->first();
											@endphp

											@if(isset($getcatname))

							      				<label>
												<input checked type="checkbox" name="cats_id[]" value="{{ $old_value }}"> {{$getcatname['title']}}
												</label>

											@endif
					      				
					      			@endforeach
					      		@endif

					      		@if(isset($diff_values))
									@foreach($diff_values as $orivalue)
										@php
									  		$getcatname = App\Category::where('id',$orivalue)->first();
										@endphp 

										@if(isset($getcatname))

											<label>
												<input type="checkbox" value="{{ $orivalue }}" name="cats_id[]"> 
											{{ $getcatname['title'] }}
											</label>

										@endif

									@endforeach
					      		@endif
                  </div>
                </div>
          
        
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                        {{ __("Update")}}</button>
                    </div>
                </div>
              </div>
            </form>




		
			<!-- form end -->
        <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom-script')
<script>
	$('.selectallbox').on('click',function(){
		if($(this).is(':checked')){
			$('input:checkbox').prop('checked', this.checked);
		}else{
			$('input:checkbox').prop('checked', false);
		}
	});
</script>
@endsection
