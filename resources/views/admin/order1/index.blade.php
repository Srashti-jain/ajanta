@extends('admin.layouts.master-soyuz')
@section('title',__('All Orders |'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Orders') }}
@endslot
@slot('menu1')
{{ __("Orders") }}
@endslot

​@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a type="button" class="btn btn-danger-rgba btn-md z-depth-0" data-toggle="modal" data-target="#bulk_delete"><i class="fa fa-trash"></i> {{__('Delete Selected')}}</a>
  </div>
</div>
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
          <h5>{{ __('Orders') }}</h5>
        </div>
        <div class="card-body">
         <!-- main content start -->
        <div class="table-responsive">
                        <!-- table to display faq start -->
          <table id="all_orders" class="table table-striped table-bordered">
            <thead>
              <th>
              <div class="inline">
                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                <label for="checkboxAll" class="material-checkbox"></label>
              </div>
              </th>
              <th>{{ __('ID') }}</th>
              <th>{{ __('Order Type') }}</th>
              <th>{{ __('Order Id') }}</th>
              <th>{{ __('Customer Name') }}</th>
              <th>{{ __('Total Qty') }}</th>
              <th>{{ __('Total Amount') }}</th>
              <th>{{ __('Order Date') }}</th>
              <th>{{ __('Action') }}</th>
            </thead>
            <tbody>
            </tbody>
          </table>                  
        </div><!-- table-responsive div end -->
      </div>
      </div>
    </div>
   </div>
</div>
​
            
                       
        

<!--bulk delete modal -->
<div id="bulk_delete" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
              <p>{{ __("Do you really want to delete these orders? This process cannot be undone.") }}</p>
            </div>
            <div class="modal-footer">
             <form id="bulk_delete_form" method="post" action="{{ route('order.bulk.delete') }}">
              @csrf
              {{ method_field('DELETE') }}
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
                <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
              </form>
            </div>
          </div>
        </div>
</div>
@endsection
@section('custom-script')
  <script>
      $(function () {
        "use strict";
        var table = $('#all_orders').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('order.index') }}",
            language: {
              searchPlaceholder: "Search orders..."
            },
            columns: [
                {data: 'checkbox', name: 'checkbox', searchable : false, orderable : false},
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                {data : 'order_type', name : 'orders.payment_method'},
                {data : 'order_id', name : 'orders.order_id'},
                {data : 'customer_dtl', name : 'user.name'},
                {data : 'total_qty', name : 'orders.qty_total'},
                {data : 'total_amount', name : 'orders.order_total'},
                {data : 'order_date', name : 'orders.created_at'},
                {data: 'action', name: 'action', searchable : false, orderable : false}
            ],
            dom : 'lBfrtip',
            buttons : [
              'csv','excel','pdf','print'
            ],
            order : [[7,'DESC']]
        });
        
  });
  </script>
  <script>var baseUrl = "<?= url('/') ?>";</script>
  <script src="{{ url('js/order.js') }}"></script>
@endsection

