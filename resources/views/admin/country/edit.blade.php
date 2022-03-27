@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Country'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Country") }}
@endslot

@slot('menu2')
{{ __("Edit Country") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/country')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">
            {{__("Edit Country")}}
          </h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data"
            action="{{url('admin/country/'.$country->id)}}" data-parsley-validate
            class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Country Name')}} <span class="required">*</span>
              </label>
             
                <input placeholder="{{ __("Please Enter 3 Name Country Code ex. IND") }}" type="text" id="first-name" name="country"
                  value="{{$country->country}}" class="form-control col-md-12">

            
            </div>
            <div class="form-group">
              <button @if(env('DEMO_LOCK')==0) type="reset" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Update") }}</button>
            </div>
            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection