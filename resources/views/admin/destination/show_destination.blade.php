@extends('admin.layouts.master-soyuz')
@section('title',__('All Destination'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Destination') }}
@endslot
@slot('menu1')
   {{ __('Destination') }}
@endslot
@endcomponent
<div class="contentbar"> 
    <div class="row">
        
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title"> {{ __('All Destination')  }}</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="full_detail_table" class="table table-hover">
                      <thead>
                        <tr class="table-heading-row">
                          <th>{{ __('#') }}</th>
                          <th>{{ __('City') }}</th>
                           <th>{{ __('State') }} </th>
                           <th>{{__("Country")}} </th>
                            <th>{{__("Pincode")}} </th>
                           
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1;  ?>
                         
                         @foreach($city as $citys)
                          <tr>
                          <td>{{$citys->id}}</td>
                          <td>{{$citys->name}}</td>
                         
                          <td>{{$citys->state['name']}}</td>
                          <td></td>
                          <td><span id="show-pincode{{ $citys->id }}"></span>
                          <div class="code"><input type="text" id="pincode{{ $citys->id }}" name="pincode" value="{{$citys->pincode}}" disabled>
                         <button id="btnAddProfile{{$citys->id}}" onClick="checkPincode({{$citys->id}})">@if($citys->pincode==''){{'Add'}}@else {{'Edit'}}@endif</button></div></td>
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
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/pincode.js') }}"></script>
@endsection 
