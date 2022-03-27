@extends('admin.layouts.master-soyuz')
@section('title',__('Add Testimonial | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Add Testimonial ') }}
@endslot
@slot('menu1')
   {{ __('Testimonial ') }}
@endslot
@slot('menu2')
   {{ __('Add Testimonial ') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href=" {{url('admin/testimonial')}}"  class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent
<div class="contentbar">   

  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                <h5 class="card-title"> {{__("Add Testimonial")}}</h5>
              </div>
              <div class="card-body">
                <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/testimonial')}}" data-parsley-validate class="form-horizontal form-label-left">
                  {{csrf_field()}}
                  <div class="row">
                <div class="form-group col-md-6">
                  <label>
                    {{__("Name:")}} <span class="required">*</span>
                  </label>
                  <input placeholder="{{ __("Enter Name") }}" type="text" id="first-name" name="name" value="{{old('name')}}" class="form-control">
                </div>
                  
                <div class="form-group col-md-6">
                  <label>
                    {{__("Rating:")}} <span class="required">*</span>
                  </label>
                  
                 
                    <select name="rating" class="form-control select2">
                      <option value="0">{{ __("Please Choose") }}</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                    <small class="txt-desc">({{__('Please Choose Rating') }})</small>
                  
                </div>
                 
                    
                  
                <div class="form-group col-md-6">
                  <label>
                    {{__("Designation:")}} <span class="required">*</span>
                  </label>
                  <input placeholder="{{ __('Enter Designation') }}" type="text" id="first-name" name="post" value="{{old('post')}}" class="form-control">
                </div>
                  
                 
                <div class="form-group col-md-6">
                  <label>{{__("Image:")}} <span class="required">*</span>
                  </label>
                  <div class="input-group mb-2">
                    
                    <div class="custom-file">
                      <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                    </div>
                  </div>
                  
                  <small class="txt-desc">({{__("Please Choose Client Image")}})</small>
                </div>

                <div class="form-group col-md-12">
                 <label>{{__("Description:")}} <span class="required"></span>
                 </label>
                
                  <textarea cols="2" id="editor1" name="des" rows="5" >
                   {{old('des')}}
                  </textarea>
                  <small class="txt-desc">({{__("Please Enter Description")}})</small>
                 </div>
                  
                 <div class="form-group col-md-6">
                    <label>
                      {{ __('Status:') }}
                    </label>
                    <br>
                    <label class="switch">
                      <input class="slider tgl tgl-skewed" type="checkbox" checked id="toggle-event3" name="status" >
                      <span class="knob"></span>
                    </label>
                    <br>
                    <input type="hidden" name="status" value="0" id="status3">
                      <small class="txt-desc">({{__("Please Choose Status")}}) </small>
                  </div>

                 
                  
                 
                  
                 
                <div class="form-group col-md-12">
                  <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                    {{ __("Create")}}</button>
                </div>
              </form>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
                  
                

                  
        

              
                  
                  