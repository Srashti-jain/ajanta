@extends('admin.layouts.master-soyuz')
@section('title',__('Seller Payments | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __(' Seller Due Payouts') }}
@endslot
@slot('menu2')
{{ __(" Seller Due Payouts") }}
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
          <h5 class="box-title">{{ __(' Seller Due Payouts') }}</h5>
        </div>
        <div class="card-body">
         <!-- main content start -->
		 <table id="payouttable" class="width100 table table-bordered table-striped">
      		<thead>
      			<th>#</th>
      			<th>
              {{__('Order TYPE')}}
            </th>
      			<th>
              {{__("Order ID")}}
            </th>
      			<th>
              {{__("Order Amount")}}
            </th>
      			<th>
              {{__("Seller Details")}}
            </th>
      			<th>
              {{__("Action")}}
            </th>
      		</thead>

      		<tbody>
      			
      		</tbody>
      	</table>
            <!-- table to display page data end -->                
                   
                    <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('custom-script')
<script>
  var url = @json(route('seller.payouts.index'));
</script>
<script src="{{ url('js/payindex.js') }}"></script>
@endsection

