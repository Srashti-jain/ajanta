@extends('admin.layouts.master-soyuz')
@section('title',__("Edit Category | "))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Category") }}
@endslot

@slot('menu2')
{{ __("Edit Category") }}
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
              <span aria-hidden="true">&times;</span></button></p>
          @endforeach
        </div>
      @endif

      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit Category') }}</h5>
        </div>
        <div class="card-body">

          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/category/'.$cat->id)}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Category')}}: <span class="required">*</span>
              </label>

              <input placeholder="{{ __('Please enter category name') }}" type="text" id="first-name" name="title"
                value="{{$cat->title}}" class="form-control col-md-12">


            </div>
            <div class="form-group">
              <label class="control-label" for="first-name"> {{__('Description')}} <span class="required">*</span>
              </label>

              <textarea cols="2" id="editor1" name="description" rows="5">
              {{ucfirst($cat->description)}}
             </textarea>
              <small class="txt-desc">({{ __('Please Enter Description') }})</small>
            </div>

            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Icon')}}:
              </label>

              <div class="input-group">
                <input type="text" class="form-control iconvalue" name="icon" value="{{ $cat->icon }}">
                <span class="input-group-append">
                  <button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                </span>



              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name"> {{__("Image")}}:
              </label>

              <div class="mb-2">
                @if(@file_get_contents('images/category/'.$cat->image))
                <img width="100px" class="img-fluid bg-primary-rgba p-3" src=" {{url('images/category/'.$cat->image)}}">
                @else
                <img title="{{ $cat->title }}" class="pro-img" src="{{ Avatar::create($cat['title'])->toBase64() }}" />
                @endif
              </div>
              
              <div class="input-group">

                <input required readonly id="image" name="image" type="text"
                    class="form-control">
                <div class="input-group-append">
                    <span data-input="image"
                        class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                </div>
              </div>

              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__('Please choose Image')}})</small>


            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Featured:")}}
              </label>
              <br>
              <label class="switch">
                <input class="slider tgl tgl-skewed" type="checkbox" id="toggle-event33"
                  {{$cat->featured ==1 ? "checked" : ""}}>
                <span class="knob"></span>
                <input type="hidden" name="featured" value="{{ $cat->featured }}" id="featured">

              </label>
              <br>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("If enabled than Category will be featured")}})</small>



            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Status')}}:
              </label>
              <br>
              <label class="switch">
                <input class="slider tgl tgl-skewed" type="checkbox" id="toggle-event33"
                  {{$cat->status ==1 ? "checked" : ""}}>
                <span class="knob"></span>
                <input type="hidden" name="status" value="{{ $cat->status }}" id="status3">

              </label>
              <br>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Status")}})</small>


            </div>

            <div class="form-group">
              <button @if(env('DEMO_LOCK')==0) type="reset" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Update") }}</button>
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