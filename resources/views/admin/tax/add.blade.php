@extends('admin.layouts.master-soyuz')
@section('title',__('Add new tax rate | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Add new tax rate') }}
@endslot
@slot('menu1')
   {{ __('Tax Rate') }}
@endslot
@slot('menu2')
   {{ __('Add new tax rate') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a  href="{{url('admin/tax')}} " class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">   
  <div class="row">
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-header">
              <h5 class="card-title"> {{__("Add new tax rate")}}</h5>
            </div>
            <div class="card-body">
              <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/tax')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{csrf_field()}}
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>
                      {{__('Tax Name')}} <span  class="required">*</span>
                    </label>
                    <input type="text" name="name" class="form-control">
                  </div>
                   
                  <div class="form-group col-md-6">
                    <label>
                      {{__("Zone")}} <span  class="required">*</span>
                    </label>
                    <select name="zone_id" class="form-control select2" id="country_id">
                      <option value="0">{{ __("Please Choose") }}</option>
                        @foreach(App\zone::all() as $zone)
                        <option value="{{$zone->id}}">
                          {{$zone->title}}
                        </option>
                        @endforeach
                    </select>
                    <small class="txt-desc">({{__("Tax will be applied only to the selected zones.")}})</small>
                  </div>
              
                  <div class="form-group col-md-6">
                    <label >
                      {{__("Rate")}} <span class="required">*</span>
                    </label>
                    <input placeholder="{{ __("Please enter rate") }}" type="text" id="first-name" name="rate" value="{{old('rate')}}" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label >
                      {{__('Type')}} <span  class="required">*</span>
                    </label>
                    <select name="type" class="form-control select2">
                      <option value="p">{{ __('Percentage') }}</option>
                      <option value="f">{{ __('Fix Amount') }}</option>
                    </select>
                    <small class="txt-desc">({{__("Please Choose Tax Type")}})</small>
                  </div>
                  
                
              
              <div class="form-group col-md-6">
                <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                  {{ __("Create")}}</button>
                  
              </form>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection 
