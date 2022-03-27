@extends('admin.layouts.sellermastersoyuz')
@section('title', __('Completed Payments'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Completed Payments') }}
@endslot
@slot('menu1')
   {{ __('Completed Payments') }}
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
          <h5 class="card-title">{{ __('Completed Payments') }}</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="form-group col-md-12">
              <div class="box box-default box-body">
                {!! $sellerpayouts->container() !!}
              </div> 
            </div>
          </div>
        </div>
       
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Received Payouts') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
              <table id="completedPayouts" class="table table-striped table-bordered">
                 <thead>
                   <th>
                     #
                   </th>
                   <th>
                     {{__('Transfer TYPE')}}
                   </th>
                   <th>
                     {{__('Order ID')}}
                   </th>
                   <th>
                     {{__("Amount")}}
                   </th>
                   <th>
                     {{__("Seller Details")}}
                   </th>
                   <th>
                     {{__("Paid On")}}
                   </th>
                   <th>
                     {{__("Action")}}
                   </th>
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
</div>

<div class="modal fade" id="trackmodal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              
            <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('Track Payout Status') }}</h5>
              <button type="button" class="float-right close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
          <div id="trackstatus">
          
          </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
              
          </div>
      </div>
  </div>
</div>
			        
@endsection
@section('custom-script')
<script src="{{ url('front/vendor/js/Chart.min.js') }}" charset="utf-8"></script>
{!! $sellerpayouts->script() !!}
<script>
  var url = @json(url('/track/payput/status/'));
  var sellerpayouturl = @json(route('seller.payout.index'));
</script>
<script src="{{ url('js/seller/sellerpayout.js') }}"></script>
@endsection
          
              
              
             