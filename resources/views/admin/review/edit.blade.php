@extends('admin.layouts.master-soyuz')
@section('title',__('Remark Review | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('All Reviews and Ratings') }}
@endslot
@slot('menu1')
{{ __("Review") }}
@endslot
@slot('menu2')
{{ __("Edit Review") }}
@endslot

@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/review')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">
  <div class="row">
    
​
​
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
          <h5>{{ __('Edit Review') }}</h5>
        </div>
        <div class="card-body">
          
      
         <!-- form start -->
         <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/review/'.$review->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                    {{ method_field('PUT') }}
                    
              <!-- row start -->
              <div class="row">
                
                <!-- Title -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Remark') }} <span class="text-danger">*</span></label>
                        <textarea placeholder="{{ __("Please enter remark") }}" type="text" id="first-name" name="remark"cols="30" rows="5" class="form-control">{{$review->remark}}</textarea>
                       
                    </div>
                </div>

                  <!-- Status -->
                  <div class="form-group col-md-12">
                    <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} </label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" checked />
                      <span class="knob"></span>
                    </label>
                </div>
                              
                <!-- create and close button -->
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                        {{ __("Update")}}</button>
                    </div>
                </div>

              </div><!-- row end -->
                                              
          </form>
          <!-- form end -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection