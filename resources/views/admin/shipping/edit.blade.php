@extends('admin.layouts.master-soyuz')
@section('title','Edit Shipping '.$shipping->name.' | ')
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Shipping') }}
@endslot
​
@slot('menu1')
{{ __("Shipping") }}
@endslot
​
@slot('menu2')
{{ __("Edit Shipping") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/shipping')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
@endslot​
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
          <h5 class="box-title">{{ __('Edit Shipping') }}</h5>
        </div>
        <div class="card-body">
         <!-- main content start -->

         <!-- form start -->
         <form id="demo-form2" method="post" enctype="multipart/form-data"
          action="{{url('admin/shipping/'.$shipping->id)}}" data-parsley-validate
          class="form-horizontal form-label-left">
          {{csrf_field()}}
          {{ method_field('PUT') }}
          <div class="row">
            <div class="form-group col-md-6">
              <label class="control-label" for="first-name">
              {{ __('Shipping Title') }} <span class="text-danger">*</span>
              </label>
              <input disabled="disabled" placeholder="{{ __("Please enter shipping title") }}" type="text" name="name"
                class="form-control" value="{{$shipping->name}}">
            </div>

            

          @if($shipping->id != 1)
          <div class="form-group col-md-6">

            <label class="control-label" for="first-name">
            {{ __('Price') }} <span class="text-danger">*</span>
            </label>
            
              <input placeholder="{{ __("Please enter price") }}" type="text" name="price" class="form-control"
                value="{{$shipping->price}}">
           
          </div>
          @endif

          <div class="form-group col-md-6">
            <label class="control-label" for="first-name">
            {{ __('Status') }} <span class="text-danger">*</span>
            </label><br>
           
              <label class="switch">
                <input class="slider" type="checkbox" name="login" <?php echo ($shipping->login=='1')?'checked':'' ?> />
                <span class="knob"></span>
                <input type="hidden" name="login" value="{{$shipping->login ?? ''}}" id="status3">
              </label>
            <br>
            <small>{{ __('(Please Choose Status)') }} </small>
          </div>

          @if($shipping->id == 3)
            <div class="form-group col-md-6">
              <label class="control-label" for="first-name">
                {{__("Flat price on whole order :")}} <span class="text-danger">*</span>
              </label>
              <label class="switch">
                  <input class="slider" type="checkbox" name="whole_order"  {{ $shipping->whole_order == '1' ? "checked" : "" }} />
                  <span class="knob"></span>
              </label>
              <small>({{__("Please Choose Status")}}) </small>
              
            </div>
          @endif

          
          <div class="form-group col-md-6">
           
              <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle mr-2"></i> {{ __("Update")}}</button>
           
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
