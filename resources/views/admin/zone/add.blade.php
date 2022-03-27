@extends('admin.layouts.master-soyuz')
@section('title',__('Add a new zone | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Add a new zone') }}
@endslot
@slot('menu1')
   {{ __('Add a new zone') }}
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
                <h5 class="card-title"> {{__("Add a new zone")}}</h5>
              </div>
              <div class="card-body">
                <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/zone')}}" data-parsley-validate class="form-horizontal form-label-left">
                  {{csrf_field()}}
                  <div class="row">
                        <div class="form-group col-md-6">
                          <label>
                            {{__("Zone Name:")}} <span class="required">*</span>
                          </label>
                          <input required placeholder="{{ __("Ex. North Zone") }}" value="" type="text" class="form-control" name="title">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>
                              {{__("Country")}}: <span class="required">*</span>
                            </label>
                            <select name="country_id" class="form-control select2 " id="country_id">
                            <option value="0">Please Choose</option>
                              @foreach($country as $c)
                              <?php
                                $iso3 = $c->country;
  
                                $country_name = DB::table('allcountry')->
                                where('iso3',$iso3)->first();
  
                                 ?>
                              <option value="{{$country_name->id}}">
                                {{$country_name->nicename}}
                              </option>
                              @endforeach
                            </select>
                        </div>
                           
                        
  
  
                          
  
                        <div class="form-group col-md-6">
                          <label>
                            {{__("Select Zone:")}} <span class="required">*</span>
                          </label>
                          <select name="name[]" multiple="multiple" class="js-example-basic-single" id="upload_id" >
                          </select>
                          <p class="mt-2">({{__("Select States for Zone")}})</p>
                       
                         <a   onclick="SelectAllCountry2()" id="btn_sel" class="hide btn btn-success " isSelected="no"> 
                          <span>{{__("Select All")}}  </span><i class="feather icon-check-square"></i>
                         </a>

                         <a onclick="RemoveAllCountry2()" id="btn_rem"class="hide btn btn-danger" isSelected="yes"> 
                          <span>{{__("Remove All")}}  </span><i class="feather icon-trash-2"></i>
                         </a>

                        </div>
                          
                        
                               
                                 
                               
                        <div class="form-group col-md-6">
                          <label>
                            {{__("Code")}}: <span class="required">*</span>
                          </label>
                          
                        
                            <input type="text" id="first-name" name="code" class="form-control">
                            <p class="txt-desc">{{ __("Please Enter code") }}</p>
                         
                        </div>
                        <div class="form-group col-md-6">
                          <label>
                            {{ __('Status:') }}
                          </label><br>

                          <label class="switch">
                            <input class="slider tgl tgl-skewed" type="checkbox" id="toggle-event33"   checked="checked">
                            <span class="knob"></span>
                          </label>
                          <br>
                         
                         
                           
                           <input type="hidden" name="status" value="1" id="status3">
                           <p class="txt-desc">
                             {{__("Please Choose Status")}}
                           </p>
                          
                        </div>
                <!-- /.box-body -->
                  <div class="form-group col-md-12">
                  
                    <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                    <button   class="btn btn-primary"><i class="fa fa-check-circle"></i>
                    {{ __("Create")}}</button>
                
              </form>
              </div>
          </div>
      </div>
    </div>
</div>
@endsection
@section('custom-script')
  <script>var baseUrl = @json(url('/'));</script>
  <script src="{{ url('js/zone.js') }}"></script> 
@endsection  
                  
                  
                  
                 
                  
              


    
   
  
      