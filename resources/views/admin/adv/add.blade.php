@extends('admin.layouts.master-soyuz')
@section('title',__('Advertisement'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Advertisement') }}
@endslot

@slot('menu1')
{{ __('Advertisement') }}
@endslot

@slot('button')

<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('adv.index') }}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a> </div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <form action="{{ route('select.layout') }}" method="get">
            <button title="Click to continue..." type="submit" class="float-right btn btn-primary-rgba">
              Next <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
            <h5 class="card-title">{{ __('Add Advertisement') }}</h5>
            
        </div>
        <div class="card-body">

          <div class="box-body">


            <div class="BLOCK1">

              <div class="row">

                <div class="col-md-6">

                  <label>
                    <input required="" type="radio" name="layout" value="Three Image Layout">
                  <span class="h3">{{ __("Three Image Layout") }}</span>
                  <br>
                  <small class="left-15 text-info">{{ __("If you choose three image layout you have to upload all three images otherwise choose other layout.") }}</small>
                  </label>

                </div>
                <div class="col-md-6">
                  <img class="img-adv float-right" title="{{ __('Three Image Layout') }}" src="{{ url('images/advLayout3.png') }}"
                    alt="three_image_adv_layout">
                </div>
              </div>

              <hr>

              <div class="row">
                <div class="col-md-6">

                  <label>
                    <input required="" type="radio" name="layout" value="Two non equal image layout">
                  <span class="h3">{{ __("Two Non Equal Image Layout") }}</span>
                  <br>
                  <small class="left-15 text-info">{{ __("If you choose two non equal image layout you have to upload all two images and one is larger than other image otherwise choose other layout.") }}</small>
                  </label>

                </div>
                <div class="col-md-6">
                  <img class="img-adv float-right" title="{{ __("Two Non Equal Image Layout") }}"
                    src="{{ url('images/advLayout2.png') }}" alt="two_non_equal_image_adv_layout">
                </div>
              </div>

              <hr>

              <div class="row">
                <div class="col-md-6">

                  <label>
                    <input required="" type="radio" name="layout" value="Two equal image layout">
                  <span class="h3">{{ __("Two Non Equal Image Layout") }}</span>
                  <br>
                  <small class="left-15 text-info">{{ __("If you choose two equal image layout you have to upload all two images and both images have to be equal othersie choose other layout.") }}</small>
                  </label>

                </div>
                <div class="col-md-6">
                  <img class="img-adv float-right" title="{{ __("Two Equal Image Layout") }}"
                    src="{{ url('images/advLayout1.png') }}" alt="two_equal_image_adv_layout">
                </div>
              </div>

              <hr>

              <div class="row">
                <div class="col-md-6">

                  <label>
                    <input required="" type="radio" name="layout" value="Single image layout">
                  <span class="h3">{{ __("Single image layout") }}</span>
                  <br>
                  <small class="left-15 text-info">{{ __("If you choose one single image layout you have to upload one image in given size.") }}</small>
                  </label>
                  
                </div>
                <div class="col-md-6">
                  <img class="img-adv float-right" title="{{ __("Single image layout") }}" src="{{ url('images/singleImage.png') }}"
                    alt="single_image_adv_layout">
                </div>
              </div>

            </div>

            <hr>

            <div class="form-group mt-2">
              
              <button title="{{ __("Click to continue...") }}" type="submit"
                class="btn btn-md btn-flat btn-primary-rgba pull-right">
                {{__("Next")}} <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>

              </button>
            </div>
            </form>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection