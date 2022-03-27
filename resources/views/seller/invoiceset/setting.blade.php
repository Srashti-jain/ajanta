@extends('admin.layouts.sellermastersoyuz')
@section('title',__("Seller Invoice Setting"))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Seller Invoice Setting') }}
@endslot
@slot('menu1')
   {{ __('Seller Invoice Setting') }}
@endslot



@endcomponent
@php
	$setting = App\Invoice::where('user_id',Auth::user()->id)->first();
@endphp
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
          <h5 class="card-title">{{ __('Seller Invoice Setting') }}</h5>
        </div>
        <div class="card-body">
		<form action="{{ route('vender.invoice.sop') }}" method="POST" enctype="multipart/form-data">
		@csrf
          <div class="row">
				<div class="form-group col-md-6">
					<label for="seal">{{__('Seal/Stamp (Image)')}}
						<br> <small class="text-muted">{{ __('Stamp/Seal will show at bottom right of your invoice') }}</small></label>
					<div class="input-group mb-3">
						<div class="custom-file">
						  <input type="file" name="seal" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
						  <label class="custom-file-label" for="inputGroupFile01">
							  {{__("Choose file")}}
						  </label>
						</div>
					  </div>
				</div>
				
			
				<div class="form-group col-md-6">
					<label for="sign">{{__("Signature")}}<br>
						
				<small class="text-muted">
						{{__("Signature will show at bottom left of your invoice")}}	
					</small></label>

					<div class="input-group mb-3">
						<div class="custom-file">
						  <input type="file" name="sign" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
						  <label class="custom-file-label" for="inputGroupFile01">
							  {{__('Choose file')}}
						  </label>
						</div>
					  </div>
				</div>
            </div>

			<div class="form-group">
                <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
				<button @if(env('DEMO_LOCK') == 0) type="submit" @else title="{{ __('This action is disable in demo !') }}" disabled="disabled" @endif class="btn btn-primary"><i class="fa fa-check-circle"></i> {{ __('Update') }}</button>
               
              </div>
            <div class="row">

				<div class="col-md-6">
					
					@if(isset($setting))
						<img width="100px" title="{{ __('Your Stamp/Seal') }}" src="{{ url('images/seal/'.$setting->seal) }}" alt="">
					@else
					<img src="{{asset('admin_new/assets/images/noimage.jpg')}}" alt="" class="image_store">
					@endif
					
				</div>

				<div class="col-md-6">
					
					@if(isset($setting))
						<img width="100px" title="Your Sign" src="{{ url('images/sign/'.$setting->sign) }}" alt="">
					@else
					<img src="{{asset('admin_new/assets/images/noimage.jpg')}}" alt="" class="image_store">
					@endif
				</div>
            </div>
            </form>
		  </div>
	    </div>
	</div>
  </div>
</div>
        
@endsection
          