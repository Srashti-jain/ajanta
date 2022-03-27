@extends('admin.layouts.master-soyuz')
@section('title',__('Edit zone | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Edit zone') }}
@endslot
@slot('menu1')
   {{ __('Edit zone') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href=" {{url('admin/zone')}} " class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent
<div class="contentbar">   

  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                <h5 class="card-title"> {{__("Edit zone")}}</h5>
              </div>
              <div class="card-body">
                <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/zone/'.$zone->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                  {{csrf_field()}}
                  {{ method_field('PUT') }}
                   <div class="row">
                     <div class="form-group col-md-6">
                       <label>
                         {{__("Zone Name:")}} <span class="required">*</span>
                       </label>
                     
                       <input required value="{{ $zone->title }}" placeholder="{{ __("Ex. North Zone") }}" type="text" class="form-control" name="title">
                     </div>
                      


  
  
                      <div class="form-group col-md-6">
                          <label>
                            {{__("Country")}} <span class="required">*</span>
                          </label>
                        
                            <select name="country_id" class="form-control select2" id="country_id">
                            <option value="0">{{ __("Please Choose") }}</option>
                              @foreach($country as $c)
                              <?php
                                $iso3 = $c->country;
  
                                $country_name = DB::table('allcountry')->
                                where('iso3',$iso3)->first();
                               ?>
                              <option value="{{$country_name->id}}" {{ $country_name->id == $zone->country_id ? 'selected="selected"' : '' }} >
                                {{$country_name->nicename}}
                              </option>
                             @endforeach
                            </select>
                         
                        </div>
  
                     
                        
                          <div class="form-group col-md-12">
                            <label>
                              {{__("Select Zone:")}} <span class="required">*</span>
                            </label>
                            <select multiple="multiple" class="js-example-basic-single width100" name="name[]" id="upload_id">
                                 @foreach ($states as $item)
                                
                                 @if($zone->name != '')
                                     <option @foreach($zone->name as $c)
                                           {{$c == $item->id ? 'selected' : ''}}
                                           @endforeach
                                           value="{{ $item->id }}">{{ $item->name }}</option>
                                  @else
                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endif
                                 @endforeach
                             </select>
                             <a   onclick="SelectAllCountry2()" id="btn_sel" class="hide btn btn-success mt-2 " isSelected="no"> 
                              <span> {{__("Select All")}}  </span><i class="feather icon-check-square"></i>
                             </a>
    
                             <a onclick="RemoveAllCountry2()" id="btn_rem"class="hide btn btn-danger mt-2" isSelected="yes"> 
                              <span> {{__("Remove All")}}  </span><i class="feather icon-trash-2"></i>
                             </a>
                          </div>
                          
                          
                            
  
  
                        <div class="form-group col-md-6">
                          <label>
                            {{__("Code:")}} <span class="required">*</span>
                          </label>
                          <input type="text" id="first-name" name="code" value="{{$zone->code}}" class="form-control">
                          <p class="txt-desc">{{ __('Please Enter code') }}</p>
                        
                      </div>
                          
                         
                        <div class="form-group col-md-6">
                          <label>
                            {{__("Status")}}
                          </label>
                            <br>
                          <label class="switch">
                            <input class="slider tgl tgl-skewed" type="checkbox" id="toggle-event33"   <?php echo ($zone->status=='1')?'checked':'' ?>>
                            <span class="knob"></span>
                          </label>

                         
                          <br>
                           <input type="hidden" name="status" value="{{$zone->status}}" id="status3">
                           <p class="mt-2"> {{__("Please Choose Status")}} </p>
                         
                        </div>
                
                  <div class="from-group col-md-6">
                    <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                    <button   class="btn btn-primary" @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" title="{{ __("This action is disabled in demo !") }}" @endif><i class="fa fa-check-circle"></i>
                    {{ __("Create")}}</button>
                  </div>
                  
              </form>
              </div>
          </div>
      </div>
    </div>
</div>
@endsection
@section('custom-script')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/zone.js') }}"></script> 
@endsection      
                  
                  
                 
                  
              


    
   
  
      