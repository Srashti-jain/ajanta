@extends('admin.layouts.master-soyuz')
@section('title',__('Shipping Settings |'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Shipping') }}
@endslot
@slot('menu2')
{{ __("Shipping") }}
@endslot​
@endcomponent
<div class="contentbar">
  <div class="row">
    
    <div class="col-lg-12">
      <div id="flash-message">

      </div>
      <div class="card m-b-30">
        <div class="card-header">
          <h5 >{{ __('Shipping') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <!-- table to display faq start -->
            <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                <th>{{ __('Default') }}</th>
                <th>{{ __('Shipping Title') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Status') }}</th>
                <th></th>
              </thead>
              <tbody>
                @foreach($shippings as $shipping)
                <tr>
                <td><input {{ $shipping->name == 'Local Pickup' || $shipping->name == 'UPS Shipping' ? "disabled" : ""}} type="radio" class="kk" id="{{$shipping->id}}" {{$shipping->default_status=='1'?'checked':''}} name="radio"></td>
                <td>{{$shipping->name}}</td>
                <td>{{$shipping->price ?? '---'}}</td>
                <td>
                  @if($shipping->login=='1')
                      {{__('Yes')}}
                      @else
                      {{__('No')}}
                    @endif
                  </td><td>
                  <a {{ $shipping->name == 'Free Shipping' || $shipping->name == 'UPS Shipping' ? "disabled" : ""}} href=" {{url('admin/shipping/'.$shipping->id.'/edit')}} " class="btn btn-primary-rgba btn-sm">
                  <i class="feather icon-settings"></i>
                  </a>
                </td>
                
                </tr>
                @endforeach
              </tbody>
            </table>                  
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
         

@endsection
@section('custom-script')
  <script>var url = {!! json_encode( url('admin/shipping_update')) !!};</script>
  <script src="{{ url('js/ship.js') }}"></script>

@endsection
