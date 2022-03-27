@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Tax Rate: :taxname',['taxname' => $tax->name]))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Edit Tax Rate') }}
@endslot
@slot('menu1')
   {{ __('Tax Rate') }}
@endslot
@slot('menu2')
   {{ __('Edit Tax Rate') }}
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
              <h5 class="card-title"> {{__("Edit Tax Rate")}}</h5>
            </div>
            <div class="card-body">
                  <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/tax/'.$tax->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                    {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>
                      {{__("Tax Name")}} <span class="required">*</span>
                    </label>
               
                      <input type="text" name="name" class="form-control " value="{{$tax->name}}">
                    
                      
                  
                  </div>
                  <div class="form-group col-md-6">
                    <label>
                      {{__("Zone")}} <span class="required">*</span>
                    </label>
               
                      <select name="zone_id" class="form-control select2" id="country_id">
                      <option value="0">{{ __("Please Choose") }}</option>
                        @foreach(App\Zone::all() as $zone)
                      <option value="{{$zone->id}}" {{ $zone->id == $tax->zone_id ? 'selected="selected"' : '' }}>
                          {{$zone->title}}
                        </option>
                        @endforeach
                      </select>
                      <small class="txt-desc">({{__("Tax will be applied only to the selected zones.")}})</small>
                    </div>
                  
                  <div class="form-group col-md-6">
                    <label>
                      {{__("Rate")}} <span class="required">*</span>
                    </label>
                 
                      <input placeholder="{{ __('Please enter rate') }}" type="text" id="first-name" name="rate" value="{{$tax->rate}}" class="form-control">
                  
                  </div>
                  
                <div class="form-group col-md-6">
                    <label>
                      {{__("Type")}} <span class="required">*</span>
                    </label>
                    
                 
                      <select name="type" class="form-control select2">
                        <option value="p" <?php echo ($tax->type=='p')?'selected':'' ?>>{{ __("Percentage") }}</option>
                        <option value="f" <?php echo ($tax->type=='f')?'selected':'' ?>>{{ __("Fix Amount") }}</option>
                      </select>
                      <small class="txt-desc">({{__("Please Choose Type")}}) </small>
                    </div>
                 
                  
            <div class="form-group col-md-6">
             
              <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
              <button type="submit" @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="This action is disabled in demo !" @endif class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Update")}}</button>

              </div>
            </form>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection 
