@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Commision Setting'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Commision Setting") }}
@endslot

@slot('menu2')
{{ __("Edit Commision Setting") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/commission_setting/')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">
            {{__("Edit Commision Setting")}}
          </h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/commission_setting/'.$commission->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
          <div class="form-group" id="dd">
            <label class="control-label" for="first-name">
              {{__('Set Commission')}}
            </label>
            
            
              <select name="type" id="type" class="form-control select2 col-md-12">
                <option value="c" {{ $commission->type == 'c' ? 'selected="selected"' : '' }} >
                  {{__("Category")}}
                </option>
                <option value="flat" {{ $commission->type == 'flat' ? 'selected="selected"' : '' }}>
                  {{__("Flat For All")}}
                </option>
              </select>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Comission Type")}})</small>
            
          </div>
          <div class="form-group" id="p_type" @if($commission->type == 'c') class="display-none" @endif >
            <label class="control-label" for="first-name">
              {{__('Price Type')}}
            </label>
            
              <select name="p_type" class="form-control select2 col-md-12">
                <option value="p" <?php echo ($commission->p_type=='p')?'selected':'' ?>>{{ __("Percentage") }}</option>
                <option value="f" <?php echo ($commission->p_type=='f')?'selected':'' ?>>{{ __("Fix Amount") }}</option>
              </select>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__('Please Choose Price Type')}})</small>
            </div>
        
          <div class="form-group" id="rate" @if($commission->type == 'c') class="display-none" @endif>
            <label class="control-label" for="first-name">
              {{__("Rate")}} <span class="required">*</span>
            </label>
            
            
              <input placeholder="{{ __("Please enter commission rate") }}" type="text" name="rate" value="{{$commission->rate}}" class="form-control select2 col-md-12">
             
            
          </div>
          <div class="form-group">
            <button @if(env('DEMO_LOCK')==0) type="reset"  @else disabled title="{{ __('This operation is disabled is demo !') }}" @endif  class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
            <button @if(env('DEMO_LOCK')==0)  type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}" @endif  class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Update") }}</button>
        </div>
        <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div>
  </div>
  @endsection
{{-- @extends("admin/layouts.master-soyuz")
@section('title','Commision Setting')
@section("body")
      
        <div class="box" >
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Commision Setting</h2>
                    <div class="panel-heading">
                          <a href=" {{url('admin/commission_setting/')}} " class="btn btn-success pull-right owtbtn">< {{ __("Back") }}</a> 
                        </div>   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/commission_setting/'.$commission->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{csrf_field()}}
                        {{ method_field('PUT') }}
                      <div class="form-group" id="dd">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Set Commission
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="type" id="type" class="form-control col-md-7 col-xs-12">
                            <option value="c" {{ $commission->type == 'c' ? 'selected="selected"' : '' }} >Category</option>
                            <option value="flat" {{ $commission->type == 'flat' ? 'selected="selected"' : '' }}>Flat For All</option>
                          </select>
                          <small class="txt-desc">(Please Choose Commission Type )</small>
                        </div>
                      </div>
                      <div class="form-group" id="p_type" @if($commission->type == 'c') class="display-none" @endif >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Price Type
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="p_type" class="form-control col-md-7 col-xs-12">
                            <option value="p" <?php echo ($commission->p_type=='p')?'selected':'' ?>>Percentage</option>
                            <option value="f" <?php echo ($commission->p_type=='f')?'selected':'' ?>>Fix Amount</option>
                          </select>
                          <small class="txt-desc">(Please Choose Price Type) </small>
                        </div>
                      </div>
                      <div class="form-group" id="rate" @if($commission->type == 'c') class="display-none" @endif>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          Rate <span class="required">*</span>
                        </label>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input placeholder="Please enter Commission rate" type="text" name="rate" value="{{$commission->rate}}" class="form-control col-md-7 col-xs-12">
                         
                        </div>
                      </div>
                      <div class="box-footer">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="{{ __("This operation is disabled in Demo !") }}" @endif class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                        
                      </div>
               
@endsection
 --}}
