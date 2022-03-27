@extends('admin.layouts.master-soyuz')
@section('title',__('Create Add new country'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Country") }}
@endslot

@slot('menu2')
{{ __("Country") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

    <a href="{{url('admin/country')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i>
      {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Add') }} {{ __('Country') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/country')}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Country")}} <span class="required">*</span>
              </label>


              <input pattern="[A-Za-z]{3}" placeholder="{{ __("Please enter 3 name country code ex. IND") }}"
                type="text" id="first-name" name="country" value="{{ old('country') }}" class="form-control col-md-12">


            </div>
            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                {{ __("Reset") }}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Create") }}</button>
            </div>

            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection