@extends('admin.layouts.master-soyuz')
@section('title',__('Completed Payments'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Completed Payouts') }}
@endslot
@slot('menu2')
{{ __("Completed Payouts") }}
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
          <h5 class="box-title">{{ __('Completed Payouts') }}</h5>
        </div>
        <div class="card-body">
         <!-- main content start -->
            <table id="completedPayouts" class="width100 table table-striped table-bordered">
              <thead>
                <th>
                  #
                </th>
                <th>
                  {{__("Transfer TYPE")}}
                </th>
                <th>
                  {{__("Order ID")}}
                </th>
                <th>
                  {{__("Amount")}}
                </th>
                <th>
                  {{__('Seller Details')}}
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

 <!-- Modal -->
 <div class="modal fade" id="trackmodal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
              <h5 class="modal-title" id="exampleStandardModalLabel">
                {{__("Track Payout Status")}}
              </h5>
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
<script>
  var trackurl = {!! json_encode( url('/track/payput/status/') ) !!};
  var payouturl = {!! json_encode( route('seller.payout.complete') ) !!};
</script>
<script src="{{url('js/paymentscript.js')}}"></script>
@endsection

