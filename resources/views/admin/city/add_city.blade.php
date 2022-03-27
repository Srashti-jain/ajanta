@extends('admin.layouts.master-soyuz')
@section('title',__('Create a city'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("City") }}
@endslot

@slot('menu2')
{{ __("City") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/city')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Add') }} {{ __('City') }}</h5>
        </div>
        <div class="card-body">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ __('Add State') }}</h4>
      </div>
      <div class="modal-body">

      </div>
      <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/state')}}"
        data-parsley-validate class="form-horizontal form-label-left">

        {{csrf_field()}}
        <div class="form-group">
          <label class="control-label col-md-12" for="first-name">
            {{__("State")}} <span class="required">*</span>
          </label>

          <div class="col-md-12">
            <input type="text" id="first-name" name="state" class="form-control col-md-12">
            <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Enter State..")}})</small>
          </div>

        </div>

        <div class="form-group">
          <label class="control-label col-md-12" for="first-name">
            {{__("Country")}}
          </label>
          <div class="col-md-12">
            <select name="country_id" class="form-control col-md-12">
              @foreach($countrys as $country)
              <option value="{{$country->id}}">{{$country->country}}</option>
              @endforeach
            </select>
            <small class="text-info"> <i class="text-dark feather icon-help`-circle"></i>({{__("Please choose country")}})</small>
          </div>
        </div>
        <div class="form-group">
          <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
            {{ __("Reset") }}</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
            {{ __("Create") }}</button>
        </div>

        <div class="clear-both"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
        </div>
    </div>

  </div>
</div>
@endsection