@extends('admin.layouts.master-soyuz')
@section('title',__('Create a new commission'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Commission") }}
@endslot

@slot('menu2')
{{ __("Commission") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/commission')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Add') }} {{ __('Commission') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/commission')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
          <div class="form-group">
            <label class="control-label" for="first-name">
              {{__('Category')}} <span class="required">*</span>
            </label>
 
              <select name="category_id" class="form-control select2 col-md-12" id="country_id">
              <option value="0">Please Choose</option>
                @foreach($category as $cat)
               <option value="{{$cat->id}}">
                  {{$cat->title}}
                </option>
                @endforeach
              </select>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Category")}})</small>

            
          </div>
          <div class="form-group">
            <label class="control-label" for="first-name">
              {{__("Rate")}} <span class="required">*</span>
            </label>
            
           
              <input placeholder="Please enter commission rate" type="text" id="first-name" name="rate" value="{{old('rate')}}" class="form-control col-md-12">
              
            
          </div>
          <div class="form-group">
            <label class="control-label" for="first-name">
              {{__("Type")}} <span class="required">*</span>
            </label>
            
            
              <select name="type" class="form-control select2 col-md-12">
                <option value="p">{{ __("Percentage") }}</option>
                <option value="f">{{ __('Fix Amount') }}</option>
              </select>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Commission Type") }})</small>

           
          </div>
           <div class="form-group">
            <label class="control-label" for="first-name">
              {{__("Status")}} <span class="required">*</span>
            </label>
           <br>
              <label class="switch">
                <input class="slider tgl tgl-skewed" type="checkbox" id="status"   checked="checked">
                <span class="knob"></span>
              </label>
              <br>
               <input type="hidden" name="status" value="1" id="status3">
               <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Status")}})</small>

          
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
