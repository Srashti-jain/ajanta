@extends('admin.layouts.master-soyuz')
@section('title',__('Create new directory | '))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('SEO Directories') }}
@endslot

@slot('menu1')
{{ __('All Directories') }}
@endslot

@slot('button')

<div class="col-md-6">
  <div class="widgetbar">
    <a href=" {{route('seo-directory.index')}} " class="btn btn-primary-rgba mr-2">
      <i class="feather icon-arrow-left mr-2"></i> {{__("Back")}}
    </a>
  </div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  <div class="row">

    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">
            {{ __('Create new directory') }}
          </h5>
        </div>
        <div class="card-body">
            <form class="form" novalidate action="{{ route('seo-directory.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>{{ __("Enter city name:") }} <span class="text-danger">*</span> </label>
                    <input value="{{ old('city') }}" type="text" class="form-control" required name="city">
                </div>

                <div class="form-group">

                    <label>{{ __("Enter details:") }} <span class="text-danger">*</span> </label>
                    <textarea class="editor form-control" name="detail" rows="10" cols="30">{{ old('detail') }}</textarea>
                    
                </div>

                <div class="form-group">
                    <label>{{ __("Status") }}</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="status"
                          {{ old('status') ? "checked" : "" }}>
                        <span class="knob"></span>
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary-rgba">
                       <i class="feather icon-plus"></i>  {{__("Create")}}
                    </button>
                </div>


            </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection