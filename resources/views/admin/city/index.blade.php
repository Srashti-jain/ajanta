@extends('admin.layouts.master-soyuz')
@section('title',__('All Cities'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Cities') }}
@endslot

@slot('menu1')
   {{ __('Cities') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
      <button type="button" data-toggle="modal" data-target="#createCity" class="btn btn-primary-rgba mr-2">
        <i class="feather icon-plus mr-2"></i> {{__("Add City")}}
      </button>
       
    </div>                        
</div>
@endslot
@endcomponent
<div class="contentbar"> 
    <div class="row">
        
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title"> {{  __('All Cities') }}</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="citytable" class="table table-hover">
                      <thead>
                        <tr class="table-heading-row">
                          
                          <th>{{ __('ID') }}</th>
                          <th>{{ __('City') }}</th>
                          <th>{{__("State")}} </th>
                          <th>{{ __('Country') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Add new city Modal -->
<div class="modal fade" id="createCity" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">{{ __('Add New State') }}</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('city.store') }}" method="POST">
          @csrf
         
             
                <div class="row">
               
                      
                      <div class="form-group col-md-12">
                        <label>
                          {{__('Select Country:')}} <span class="text-danger">*</span>
                        </label>
                        <select id="country_id" required data-placeholder="{{ __("Select country") }}" class="select2 form-control">
                        
                          @foreach($countries as $country)
                            <option value="">{{ __("Select country") }}</option>
                            <option {{ old('country_id') == $country->id ? "selected" : "" }} value="{{$country->id}}">{{ $country->nicename }}</option>
                          @endforeach

                        </select>
                      </div>
                      
                      <div class="form-group col-md-10">
                        <label class="" for="first-name">
                          {{__('Select State:')}} <span class="text-danger">*</span>
                        </label>
                        <select id="upload_id" required name="state_id" data-placeholder="{{ __("Select state") }}" class="select2 form-control">
                            
                          <option value="">{{ __("Select state") }}</option>
                         
                        </select>
                      </div>

                   
                    <div class="col-md-2">
                    <button data-dismiss="modal" title="Add new state" type="button" data-toggle="modal" data-target="#createState" class="btn btn-md btn-primary">
                      <i class="fa fa-plus"></i>
                    </button>
                  </div>
                
                  
                </div>

          <div class="form-group">
            <label>Enter {{ __('City Name') }}: <span class="text-danger">*</span></label>
            <input value="{{ old('name') }}" required type="text" class="form-control" name="name" placeholder="Enter city name">
          </div>

          <div class="form-group">
            <label>Enter {{ __('City Pin/Zip or postal code:') }} @if($pincodesystem == 1) <span class="text-danger">*</span> @endif</label>
            <input {{ $pincodesystem == 1 ? "required" : "" }} value="{{ old('pincode') }}"  type="text" class="form-control" name="pincode" placeholder="Enter city pin/zip or postal code">
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

<!--Add new state Modal -->
<div class="modal fade" id="createState" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
          {{__('Add New State')}}
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <form action="{{ route('state.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>{{__("Select Country:")}} <span class="text-danger">*</span></label>
            <select required name="country_id" class="form-control select2">
              @foreach(App\Allcountry::orderBy('name','ASC')->get() as $country)
                <option {{ old('value') == $country['id'] ? "selected" : "" }} value="{{ $country['id'] }}">{{ $country['nicename'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>{{__("Enter State Name:")}} <span class="text-danger">*</span></label>
            <input value="{{ old('name') }}" required type="text" class="form-control" name="name" placeholder="Enter state name">
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

        <!-- /page content -->
@endsection
@section('custom-script')
   <script>var url = @json(route('city.index'));</script>
   <script src="{{ url('js/city.js') }}"></script>
   <script>var baseUrl = @json(url('/'));</script>
   <script src="{{ url('js/ajaxlocationlist.js') }}"></script>
@endsection

