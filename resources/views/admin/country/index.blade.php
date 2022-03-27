@extends('admin.layouts.master-soyuz')
@section('title',__('All Countries'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Countries') }}
@endslot

@slot('menu1')
   {{ __('Countries') }}
@endslot

@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
        <a  href=" {{url('admin/country/create')}} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2"></i> {{__("Add Countries")}}
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
                    <h5 class="box-title"> {{__("All Countries")}}</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="country_table" class="table table-hover">
                      <thead>
                        <tr class="table-heading-row">
                          <th>{{ __("ID") }}</th>
                          <th>{{ __("Country Name") }}</th>
                          <th>{{ __("ISO2 Code") }}</th>
                          <th>{{ __('ISO3 Code') }}</th>
                          <th>
                            {{__('Action')}}
                          </th>
                        </tr>
                      </thead>
                  </table>
                  @foreach($countries as $country)
                  <div id="country{{ $country->id }}" class="delete-modal modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
                          <p>
                            {{__('Do you really want to delete this country? This process cannot be undone.')}}
                          </p>
                        </div>
                        <div class="modal-footer">
                             <form method="post" action="{{url('admin/country/'.$country->id)}}" class="pull-right">
                                    {{csrf_field()}}
                                     {{method_field("DELETE")}}
                                      
                             <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
                            <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
             @endforeach
                  </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-script')
<script>
  var url = {!!json_encode( route('country.index') )!!};
</script>
<script src="{{asset('js/country.js')}}"></script>
@endsection 
