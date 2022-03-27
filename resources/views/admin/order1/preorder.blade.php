@extends('admin.layouts.master-soyuz')
@section('title',__("All Preorders | "))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Preorders') }}
@endslot
@slot('menu1')
{{ __("Preorders") }}
@endslot

​@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
        <a type="button" class="btn col-4 btn-primary-rgba btn-md z-depth-0" data-toggle="modal" data-target="#bulk_notify">
            <i class="feather icon-arrow-up-circle"></i> {{ __("NOTIFY") }} 
        </a>
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
                    <h5>{{ __('All Preorders') }}</h5>
                </div>
                <div class="card-body">
                    <!-- main content start -->
                    <div class="table-responsive">
                        <!-- table to display faq start -->
                        <table id="all_orders" class="table table-striped table-bordered">
                            <thead>
                                <th>
                                    <div class="inline">
                                        <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                            value="all" id="checkboxAll">
                                        <label for="checkboxAll" class="material-checkbox"></label>
                                    </div>
                                </th>
                                <th></th>
                                <th>{{ __('Invoice ID') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Order Type') }}</th>
                                <th>{{ __('Paid Amount') }}</th>
                                <th>{{ __('Remaning Amount') }}</th>
                                <th>{{ __('Customer Name') }}</th>
                                <th>{{ __('Total Qty') }}</th>
                                <th>{{ __('Total Amount') }}</th>
                                <th>{{ __('Order Date') }}</th>
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


<!--bulk delete modal -->
<div id="bulk_notify" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">
              {{__("Are You Sure ?")}}
          </h4>
          <p>
              {{__("Do you really want to notify to client about these orders? This process cannot be undone.")}}
          </p>
        </div>
        <div class="modal-footer">
         <form id="bulk_form_notify" method="post" action="{{ route('admin.preorders.notify') }}">
            @csrf
            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">
                {{__("No")}}
            </button>
            <button type="submit" class="btn btn-danger">
                {{__("Yes")}}
            </button>
          </form>
        </div>
      </div>
    </div>
</div>


@endsection
@push('script')
<script>
    $(function () {
        "use strict";
        var table = $('#all_orders').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.preorders') }}",
            language: {
                searchPlaceholder: "Search Preorders..."
            },
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'invoice_id',
                    name: 'invoice_downloads.inv_no'
                },
                {
                    data: 'order_id',
                    name: 'orders.order_id'
                },
                {
                    data: 'order_type',
                    name: 'orders.payment_method'
                },
                {
                    data: 'paid_amount',
                    name: 'invoice_downloads.price'
                },
                {
                    data: 'remaining_paid_amount',
                    name: 'invoice_downloads.remaning_amount'
                },
                {
                    data: 'customer_name',
                    name: 'users.name'
                },
                {
                    data: 'total_qty',
                    name: 'invoice_downloads.qty'
                },
                {
                    data: 'total_amount',
                    name: 'total_amount',
                    searchable : false,
                    orderable  : false
                },
                {
                    data: 'order_date',
                    name: 'orders.created_at'
                }
            ],
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            order: [
                [7, 'DESC']
            ]
        });

    });
</script>
@endpush