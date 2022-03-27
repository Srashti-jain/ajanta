@extends('admin.layouts.master-soyuz')
@section('title',__('Create Attribute -'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Add Options') }}
@endslot
@slot('menu2')
{{ __("Add Options") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('attr.index') }}" class="btn btn-primary-rgba"><i
        class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
@endslot
​
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
          <h5 class="box-title">{{ __('Add Options') }}</h5>
        </div>
        <div class="card-body">
          <!-- main content start -->
          <!-- ------------------- -->
          <div class="card bg-warning-rgba m-b-30">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-12">
                  <p class="mb-0 text-primary font-14"><i class="fa fa-info-circle" aria-hidden="true"></i>
                    {{ __("Once you created option you can't Delete it ! You can only edit it") }}</p>

                </div>

              </div>
            </div>
          </div>
          <!-- ------------------- -->

          <!-- ------------------- -->
          <div class="card bg-info-rgba m-b-30">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-12">
                  <p class="mb-0 text-primary font-14"><i class="fa fa-info-circle" aria-hidden="true"></i>
                    {{__("If you want to create long attribute name with space eg.")}} <b>{{ __("Screen Size") }}</b>
                    {{__("than create it with")}} '<b>_ ({{ __("underscore") }}) </b>' {{__('eg.')}}
                    <b>{{ __("Screen Size") }}</b>{{__('. System will add space on front end.') }}</p>

                </div>

              </div>
            </div>
          </div>
          <!-- ------------------- -->

          <!-- form start -->
          <form method="post" enctype="multipart/form-data" action="{{ route('opt.str') }}" data-parsley-validate
            class="form-horizontal form-label-left">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="text-dark">{{ __('Name :') }}</label>
                  <input required="" type="text" name="attr_name" class="form-control" />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="text-dark">{{ __('Select Type :') }}</label>
                  <select class="form-control select2" name="unit_id">
                    @foreach(App\Unit::all() as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label class="text-dark">{{ __('Choose Category :') }}</label><br>
                  <label>
                    <input type="checkbox" class="selectallbox"> {{__("Select All")}}
                  </label><br>
                  @foreach(App\Category::all() as $cat)

                  <label>
                    <input type="checkbox" name="cats_id[]" value="{{ $cat->id }}">
                    {{ $cat->title }}
                  </label>

                  @endforeach
                </div>
              </div>


              <div class="col-md-12">
                <div class="form-group">
                  <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                    {{ __("Save")}}</button>
                </div>
              </div>
            </div>
          </form>


          <!-- form end -->
          <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom-script')
<script>
  $('.selectallbox').on('click', function () {
    if ($(this).is(':checked')) {
      $('input:checkbox').prop('checked', this.checked);
    } else {
      $('input:checkbox').prop('checked', false);
    }
  });
</script>
@endsection