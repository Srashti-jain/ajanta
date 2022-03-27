@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Abuse'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Abuse") }}
@endslot

@slot('menu2')
{{ __("Abuse") }}
@endslot

@endcomponent

<div class="contentbar">
  <div class="row">
   
    <div class="col-lg-12">
      @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach
      </div>
      @endif
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit') }} {{ __('Abuse') }}</h5>
        </div>
        <div class="card-body">

          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/abuse/')}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
              <div class="row"> 
 
            <div class="form-group col-md-12">
              <label class="control-label" for="first-name">
                {{__('Abuse Words')}} <span class="required">*</span>
              </label>
           
                <input placeholder="Please enter Abuse Word" type="text" id="first-name" data-role="tagsinput"
                  name="name" value=" {{$abuse->name}} " class="form-control">

            </div>
            <div class="form-group col-md-12">
              <label class="control-label" for="first-name">
                Replace Words <span class="required">*</span>
              </label>
              
                <input placeholder="{{ __('Please enter Replace Word') }}" type="text" id="first-name" name="rep"
                  data-role="tagsinput" value=" {{$abuse->rep}} " class="form-control">

           
            </div>

            <div class="form-group col-md-12">
              <label class="control-label " for="first-name">
                {{ __('Status') }}
              </label>
                <br>
              
                <label class="switch">
                  <input <?php echo ($abuse->status=='1')?'checked':'' ?> id="toggle-event3" type="checkbox">
                  <span class="knob"></span>
                  <input type="hidden" name="status" value="{{$abuse->status ?? ''}}" id="status3">

                 
                </label>
              
            </div>
        
            <div class="form-group col-md-12">
              <button @if(env('DEMO_LOCK')==0) type="reset"  @else disabled title="{{ __('This operation is disabled is demo !') }}" @endif  class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
              <button @if(env('DEMO_LOCK')==0)  type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}" @endif  class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                  {{ __('Update') }}</button>
          </div>
          <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection