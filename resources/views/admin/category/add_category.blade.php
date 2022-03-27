@extends('admin.layouts.master-soyuz')
@section('title',__('Create a Category'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Category") }}
@endslot

@slot('menu2')
{{ __("Category") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/category')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
            <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach
      </div>
      @endif


      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Add') }} {{ __('Category') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/category')}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Category')}}: <span class="required">*</span>
              </label>

             
                <input placeholder="{{ __('Please enter Category name') }}" type="text" id="first-name" name="title"
                  class="form-control col-md-12" value="{{old('title')}}">

             

            </div>
            <div class="form-group">
              <label class="control-label" for="first-name"> {{__('Description')}} <span class="required"></span>
              </label>
             
                <textarea cols="2" id="editor1" name="description" rows="5">
                      {{old('description')}}
                     </textarea>
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__('Please enter description')}})</small>

              
            </div>

            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Icon')}}:
              </label>
          

                <!--========================================================================-->
                <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="{{ __('Choose icon') }}">
                  <span class="input-group-append">
                    <button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
                </div>
                <!--========================================================================-->



            </div>



            <div class="form-group">
              <label class="control-label" for="first-name"> {{__('Image')}}:
              </label>
              
              <div class="input-group">

                <input required readonly id="image" name="image" type="text"
                    class="form-control">
                <div class="input-group-append">
                    <span data-input="image"
                        class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                </div>
              </div>
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__('Please Choose category image')}})</small>

              </div>
            
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Status')}}: <span class="required">*</span>
              </label>
             <br>
                <label class="switch">
                  <input class="slider tgl tgl-skewed" type="checkbox" id="status" checked="checked">
                  <span class="knob"></span>
                </label>
                <br>
                <input type="hidden" name="status" value="1" id="status3">
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__('Please Choose Status')}})</small>
              </div>
          
            <!-- /.box-body -->

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
@section('custom-script')
  <script>
      $(".midia-toggle").midia({
          base_url: '{{ url('') }}',
          directory_name: 'category'
      });
  </script>
@endsection