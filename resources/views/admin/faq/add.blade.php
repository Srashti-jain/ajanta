@extends('admin.layouts.master-soyuz')
@section('title',__('Create New Faq'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Front Settings") }}
@endslot

@slot('menu2')
{{ __("Faq") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

    <a href="{{url('admin/faq')}}" class="btn btn-primary-rgba mr-2"><i
        class="feather icon-arrow-left mr-2"></i>{{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Add Faq') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/faq')}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Question :")}} <span class="required">*</span>
              </label>


              <input placeholder="{{ __('Please enter Question') }}" type="text" id="first-name" name="que" value="{{old('que')}}"
                class="form-control col-md-12">


            </div>

            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Answer')}} <span class="required">*</span>
              </label>


              <textarea rows="5" cols="10" placeholder="{{ __('Please enter answer') }}" type="text" id="first-name" name="ans"
                value="{{old('ans')}}" class="form-control"></textarea>


            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Status')}}
              </label>
              <br>
              <label class="switch">
                <input class="slider tgl tgl-skewed" type="checkbox" id="status" name="status">
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Choose status for your faq")}})</small>
            </div>

            <div class="box-footer">
              <div class="form-group">
                <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                  {{ __("Reset") }}</button>
                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
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