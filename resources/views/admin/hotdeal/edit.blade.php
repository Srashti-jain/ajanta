@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Hotdeal | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Hot Deals") }}
@endslot

@slot('menu2')
{{ __("Edit Hotdeal") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

    <a href="{{url('admin/hotdeal')}}" class="btn btn-primary-rgba mr-2"><i
        class="feather icon-arrow-left mr-2"></i>{{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __("Edit Hot Deal") }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data"
            action="{{url('admin/hotdeal/'.$hotdeal->id)}}" data-parsley-validate
            class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="row">
              <div class="form-group col-md-6">
                <label class="control-label" for="first-name">
                  {{__("Created Date")}}
                </label>


                <div class="input-group">
                  <input type="text" class="form-control timepickerwithdate"
                    value="{{ date('Y-m-d h:i a',strtotime($hotdeal->start)) }}" name="start" placeholder="dd/mm/yyyy"
                    aria-describedby="basic-addon5" />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                  </div>
                </div>


              </div>

              <div class="form-group col-md-6">
                <label class="control-label" for="first-name">
                  {{__("Expire Date")}}
                </label>


                <div class="input-group">
                  <input type="text" class="form-control timepickerwithdate"
                    value="{{ date('Y-m-d h:i a',strtotime($hotdeal->end)) }}" name="end" placeholder="dd/mm/yyyy"
                    aria-describedby="basic-addon5" />
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                  </div>

                </div>

              </div>

              <div class="form-group col-md-6">
                <label for="">{{ __("Link by:") }}</label>
                <select required name="link_by" id="link_by" class="select2 form-control">
                  <option {{ $hotdeal->simple_pro_id != '' ? "selected" : "" }} value="sp">
                    {{ __("Link with simple product") }}</option>
                  <option {{ $hotdeal->pro_id != '' ? "selected" : "" }} value="vp">
                    {{ __("Link with variant product") }}</option>
                </select>
              </div>

              <div class="{{ $hotdeal->simple_pro_id == '' ? 'd-none' : 'd-block' }} simpleproduct form-group col-md-6">
                <label class="control-label" for="first-name">
                  {{  __('Select Simple Product') }} <span class="required">*</span>
                </label>

                <select name="simple_pro_id" class="form-control select2 col-md-12">
                  <option value="">{{ __("Please Select Product") }}</option>
                  @foreach($simple_products as $key => $sp)
                  <option {{ $hotdeal->simple_pro_id == $key ? 'selected="selected"' : '' }} value="{{$key}}">{{$sp}}
                  </option>
                  @endforeach
                </select>

              </div>


              <div class="{{ $hotdeal->pro_id == 0 ? 'd-none' : 'd-block' }} variantproduct form-group col-md-6">
                <label class="control-label" for="first-name">
                  {{  __('Select Variant Product') }} <span class="required">*</span>
                </label>

                <select name="pro_id" class="form-control select2">
                  <option value="">{{ __('Please Select Product') }}</option>
                  @foreach($products as $key => $pro)
                    <option value="{{$key}}" {{ $hotdeal->pro_id == $key ? 'selected="selected"' : '' }}>
                      {{$pro}}
                    </option>
                  @endforeach
                </select>

              </div>

              <div class="form-group col-md-6">
                <label class="control-label" for="first-name">
                  {{__("Status")}}
                </label>
                <br>
                <label class="switch">
                  <input class="slider tgl tgl-skewed" type="checkbox" name="status" id="toggle-event33"
                    {{ $hotdeal->status ==1 ? "checked" : "" }}>
                  <span class="knob"></span>

                </label>


                <br>

                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Hotdeal Status")}})</small>

              </div>

              <div class="form-group col-md-12">
                <button @if(env('DEMO_LOCK')==0) type="reset" @else disabled
                  title="{{ __('This operation is disabled is demo !') }}" @endif class="btn btn-danger"><i class="fa fa-ban"></i>
                  {{ __("Reset") }}</button>
                <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                  title="{{ __('This operation is disabled is demo !') }}" @endif class="btn btn-primary"><i
                    class="fa fa-check-circle"></i>
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
@push('script')
<script>
  $('#link_by').on('change', function () {

    if ($(this).val() == 'sp') {


      $('.variantproduct').addClass('d-none').removeClass('d-block');
      $('.simpleproduct').addClass('d-block').removeClass('d-none');

    }

    if ($(this).val() == 'vp') {

      $('.variantproduct').addClass('d-block').removeClass('d-none');
      $('.simpleproduct').addClass('d-none').removeClass('d-block');

    }

  });
</script>
@endpush