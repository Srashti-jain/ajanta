@extends('admin.layouts.master-soyuz')
@section('title',__('Create a Brand | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Product Management") }}
@endslot

@slot('menu2')
{{ __("Brand") }}
@endslot
@slot('button')

<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{ url('admin/brand') }}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Add') }} {{ __('Brand') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data"
        action="{{url('admin/brand')}}" data-parsley-validate class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div class="form-group">
          <label class="control-label" for="first-name">
            {{__('Brand Name')}}: <span class="required">*</span>
          </label>

            <input placeholder="{{ __('Please enter brand name') }}" type="text" id="first-name" name="name"
              class="form-control col-md-12" value="{{ old('name') }}">

         
        </div>
        <div class="form-group">
          <label class="control-label" for="first-name">
            {{__('Brand Logo')}}: <span class="required">*</span>
          </label>

          <div class="input-group">

            <input required readonly id="image" name="image" type="text"
                class="form-control">
            <div class="input-group-append">
                <span data-input="image"
                    class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
            </div>
          </div>
          
          <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{ __('Please Choose Brand Image') }})</small>

        </div>
        

        <div class="form-group">
          <label class="control-label" for="first-name">
            Select Category: <span class="required">*</span>
          </label>

        
            <select multiple="multiple" class="form-control select2" name="category_id[]">
              @foreach (App\Category::where('status','1')->get(); as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
              @endforeach
            </select>

          
        </div>

        <div class="form-group">
          <label>
            {{__('Status')}}:
          </label><br>
          <label class="switch">
            <input class="slider tgl tgl-skewed" type="checkbox" id="toggle-event33"   checked="checked">
            <span class="knob"></span>
          </label>
          <br>
           <input type="hidden" name="status" value="1" id="status3">
           <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Choose status for your brand")}})</small>
          </div>
          <div class="form-group">
            <label>
             {{__('Show image in footer')}}:
            </label><br>
            <label class="switch">
              <input class="slider tgl tgl-skewed" type="checkbox" id="toggle-event33"   checked="checked">
              <span class="knob"></span>
            </label>
            <br>
             <input type="hidden" name="show_image" value="1" id="status3">
             <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("If You Choose Active Then Image Show In Footer Brand Logo")}})</small>
            </div>
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
          base_url: '{{url('')}}',
          directory_name: 'brand',
          dropzone : {
            acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
          }
      });
  </script>
@endsection