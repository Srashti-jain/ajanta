@extends('admin.layouts.master-soyuz')
@section('title',__('SEO Settings | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Seo Settings') }}
@endslot
​
@slot('menu2')
{{ __("Seo Settings") }}
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
          <h5 class="box-title">{{ __('Seo Settings') }}</h5>
        </div>
        <div class="card-body">
        
         <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{ route('seo.store') }}" data-parsley-validate class="form-horizontal form-label-left">
              @csrf  
            <!-- row start -->
            <div class="row">
              
              <!-- Project Title -->
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="text-dark">{{ __('Project Title') }} <span class="text-danger">*</span></label>
                      <input placeholder="Enter project title (It will also show in title bar)" type="text" id="first-name" name="project_name" value="{{$seo->project_name ?? ''}}" class="form-control">
                  </div>
              </div>

              <!-- Metadata Description -->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="text-dark">{{ __('Metadata Description') }} <span class="text-danger">*</span></label>
                    <input placeholder="{{ __("Enter meta data description") }}" type="text" id="first-name" name="metadata_des" value="{{$seo->metadata_des ?? ''}}" class="form-control">
                </div>
              </div>

              <!-- Metadata Keyword -->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="text-dark">{{ __('Metadata Keyword') }} <span class="text-danger">*</span></label>
                    <input placeholder="{{ __("Enter Metadata Keyword, use comma to seprate it") }}" type="text" id="first-name" name="metadata_key" value="{{$seo->metadata_key ?? ''}}" class="form-control">
                </div>
              </div>

              <!-- Metadata Keyword -->
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="text-dark">{{ __('Google Analytics :') }}</label>
                      <input placeholder="{{ __("Enter Google Analytics Key") }}" type="text" id="first-name" name="google_analysis" value="{{$seo->google_analysis ?? ''}}" class="form-control">
                  </div>
              </div>

                <!-- Facebook Pixel -->
                <div class="col-md-6">
                  <div class="form-group">
                      <label class="text-dark">{{ __('Facebook Pixel :') }}</label>
                      <input placeholder="{{ __('Please enter Facebook Pixel Code Key') }}" type="text" id="first-name" name="FACEBOOK_PIXEL_ID" value="{{ env('FACEBOOK_PIXEL_ID') }}" class="form-control">
                  </div>
              </div>

              <!-- Generate Sitemap -->
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="text-dark">{{ __('Generate Sitemap :') }}</label><br>
                      <a href="{{ url('/sitemap') }}" class="btn btn-md btn-warning-rgba">{{ __('Generate') }}</a>
                      @if(@file_get_contents(public_path().'/sitemap.xml'))
                      {{__("Download")}} <a href="{{ url('/sitemap/download') }}">Sitemap.xml</a>
                      |
                      {{__("View")}} <a href="{{ url('/sitemap.xml') }}">{{ __('Sitemap') }}</a>
                      @endif
                  </div>
              </div>

              <!-- create and close button -->
              <div class="col-md-12">
                  <div class="form-group">
                      <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                      <button @if(env('DEMO_LOCK')==0) type="submit" @else title="This action is disabled in demo !" disabled="disabled" @endif class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i> {{ __("Save Settings") }}</button>
                  </div>
              </div>

            </div><!-- row end -->
                                              
          </form>
          <!-- form end -->
        
         <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

