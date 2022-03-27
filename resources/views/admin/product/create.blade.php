@extends('admin.layouts.master-soyuz')
@section('title',__('Add New Product |'))
@section('body')
​
@component('admin.component.breadcumb',['thirdactive' => 'active'])
​
@slot('heading')
  {{ __('Add New Product') }}
@endslot
@slot('menu1')
  {{ __("Product") }}
@endslot
@slot('menu2')
  {{ __("Add New Product") }}
@endslot
​
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{ route('products.index') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">
  <div class="row">
   
​
​
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
          <h5>{{ __('Add Product') }}</h5>
        </div>
        <div class="card-body">
            @include('admin.product.tab.product')
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="taxmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">
          {{__('Product Tax Information(PTI)')}}
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
       
      </div>
      <div class="modal-body">
        <div id="accordion">
          @foreach(App\TaxClass::all() as $protax)
          <div class="card">
            <div class="card-header" id="headingThree">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#tbl{{$protax->id}}"
                  aria-expanded="false" aria-controls="{{$protax->title}}">
                  {{$protax->title}}
                </button>
              </h5>
            </div>
            <div id="tbl{{$protax->id}}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <tr>
                    <th>{{__("Tax Name")}}
                      <img src="{{(url('images/info.png'))}}" class="height-15" data-toggle="popover"
                        data-content="{{ __('You Want to Choose Tax Class Then Apply same Tax Class And Tax Rate.') }}">
                    </th>
                    <th>
                      {{__("Tax Rate")}}
                    </th>
                    <th>
                      {{__('Priority')}}
                      <img src="{{(url('images/info.png'))}}" class="height-15" data-toggle="popover" data-content="{{ __('1 Priority Is Higher Priority And All Numeric Number Is Lowest Priority, Priority Are Accept Is Numeric Number.') }}">
                    </th>
                    <th>{{__('Based On')}} <img src="{{(url('images/info.png'))}}" class="height-15" data-toggle="popover"
                        data-content="{{ __('You Want To Choose Billing address Then Billing Address And Zone Address Are Same Then Tax Will Be Applied, And You Will Be Choose Store Address then Store Addrss And User Billing Address Is Same Then Tax Will Be Apply') }}">
                    </th>
                    <th>{{ __("Zone Details") }}<img src="{{(url('images/info.png'))}}" class="height-15" data-toggle="popover"
                        data-content="{{ __('You Want To Choose Billing address Then Billing Address And Zone Address Are Same Then Tax Will Be Applied, And You Will Be Choose Store Address then Store Addrss And User Billing Address Is Same Then Tax Will Be Apply.') }}">
                    </th>
                  </tr>
                  @if(isset($protax->priority))
                  @foreach($protax->priority as $k => $taxRate)
                  @if(isset($protax->taxRate_id[$taxRate]))
                  @php $taxs = App\Tax::where('id',$protax->taxRate_id[$taxRate])->first(); @endphp
                  @if(isset($taxs))
                  <tr>
                    <td>
                      {{$taxs->name}}
                    </td>
                    <td>@if($taxs->type=='f'){{$taxs->rate}}{{'%'}}@else{{$taxs->rate}}@endif</td>
                    <td>{{$taxRate}}</td>
                    <td>{{$protax->based_on[$taxRate]}}</td>
                    <td>
                      <?php $zone = App\Zone::where('id',$taxs->zone_id)->first();?>
                      @if(!empty($zone))
                      {{$zone->state_id=='0'?'All Zone':$zone->title}}
                      @endif
                    </td>
                  </tr>
                  @endif
                  @endif
                  @endforeach
                  @endif
                </table>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Nav tabs -->
  @endsection