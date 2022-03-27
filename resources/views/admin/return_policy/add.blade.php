@extends('admin.layouts.master-soyuz')
@section('title',__('Add Return Policy | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Add Policy Settings') }}
@endslot
@slot('menu1')
{{ __("Return Policy") }}
@endslot

@slot('menu2')
{{ __("Add Return Policy") }}
@endslot

@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/return-policy')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
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
          <h5 class="box-title">{{ __('Add Return Policy') }}</h5>
        </div>
        <div class="card-body">
         <!-- main content start -->

         <!-- form start -->
         <form action="{{url('admin/return-policy')}}" class="form" method="POST" novalidate enctype="multipart/form-data">
            {{csrf_field()}}
                        
              <!-- row start -->
              <div class="row">
                
                <!-- Policy Name -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Policy Name :') }} <span class="text-danger">*</span></label>
                        <input placeholder="{{ __("Enter Policy Name") }}" type="text" id="first-name" name="name" class="form-control" value="{{old('name')}}">
                    </div>
                </div>

                <!-- Amount -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Amount :') }} <span class="text-danger">*</span></label>
                        <input placeholder="%" type="text" id="first-name" name="amount" class="form-control" value="{{old('amount')}}">
                        <small>({{__('Please enter amount in Percentage')}})</small>
                    </div>
                </div>

                <!-- Return days -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Return days :') }} <span class="text-danger">*</span></label>
                        <input placeholder="{{ __("Please enter product return days") }}" type="text" id="first-name" name="days" class="form-control">
                    </div>
                </div>

                  <!-- Description -->
                  <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Description') }} <span class="text-danger">*</span></label>
                        <textarea id="editor1" name="des" class="@error('des') is-invalid @enderror" value="{{old('des' ?? '')}}" required="">{{ old('des') }} </textarea>
                        <small class="txt-desc">({{ __("Please rnter return policy description") }})</small>
                    </div>
                </div>

                  <!-- Status -->
                  
                              
                <div class="form-group col-md-6">
                  <label class="control-label" for="first-name">
                    {{__("Return Accept By:")}}
                  </label>
                
                    <select class=" form-control select2" name="return_acp" id="">
                      <option>{{ __('Please choose') }}</option>
                      <option value="auto">
                        {{__('Auto')}}
                      </option>
                      <option value="admin">
                        {{__("Admin")}}
                      </option>
                      <option value="vender">
                        {{__("Vender")}}
                      </option>
                    </select>
                   
                    <small class="txt-desc">({{__("Please Choose an option to select who can accept return")}})</small>
                  
                </div>

                <div class="form-group col-md-6">
                  <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} </label><br>
                  <label class="switch">
                    <input class="slider" type="checkbox" name="status" checked />
                    <span class="knob"></span>
                    
                  </label><br>
                  <small>({{__('Please Choose Status')}})</small>
              </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                        {{ __("Create")}}</button>
                    </div>
                </div>

              </div>
               <!-- row end -->
                                              
          </form>
            <!-- form end -->
        
         <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

