@extends('admin.layouts.master-soyuz')
@section('title',__('All Pincode list'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Pincode list') }}
@endslot

@slot('menu1')
   {{ __('Pincode list') }}
@endslot


@endcomponent
<div class="contentbar"> 
  <div class="row">
      
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="box-title"> {{  __('All Cities') }}</h5>
              </div>
              <div class="card-body ml-1 mr-1">
                <div class="row">
                  <div class="col-md-12 p-3 mb-2 bg-success text-white rounded">
                      <i class="fa fa-info-circle"></i> {{__("Note:")}}
                      <ul>
                        <li>{{ __('If you enable pincode system you are enabling per destination delivery system which mean for particular cities if you add pincode your product is deliverable only for that city.') }}</li>
                        <li>{{ __("If pincode system is enabled than product is deliverable on selected pincodes only.") }}</li>                        
                      </ul>
                  </div>
              </div>
            
                <span class="margin-top-10 control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                      <label>
                        {{__('Enable Pincode Delivery System:')}}
                      </label>
                </span>
                 <div class="col-md-9 col-sm-9 col-xs-12">
                     <label class="switch">
                    <input  type="checkbox" class="toggle-input toggle-buttons" id="pincodesystem" {{$pincodesystem == 1 ? 'checked' : ''}}>
                    <span class="knob"></span>
                    </label>
                </div>
                
        
                <table id="countryTable" class="{{ $pincodesystem == 1 ? '' : 'display-none' }} table table-striped">
                    <thead>
                        <th>#</th>
                        <th>{{ __("Country Name") }}</th>
                        <th>#</th>
                    </thead>
                </table>
        
              </div>
          
          </div>
      </div>
  </div>
</div>
@endsection

@section('custom-script')
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/pincode.js') }}"></script>

  @if($pincodesystem == 1)
    <script>var search = {!! json_encode( url('pincode-add') ) !!};</script>
    <script src="{{ url('js/pincode2.js') }}"></script>
  @endif
 
@endsection 
