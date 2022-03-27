@extends('admin.layouts.master-soyuz')
@section('title',__('Inhouse Orders | '))
@component('admin.component.breadcumb',['secondaryactive' => 'active'])

@section('body')

@slot('heading')
{{ __('Inhouse Orders') }}
@endslot

@slot('menu1')
{{ __('Inhouse Orders') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        <a href="{{ route('offline-orders.create') }}" class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2e"></i> {{__("Create new order")}}
        </a>
    </div>
</div>
@endslot
@endcomponent

<div class="contentbar">
    <div class="row">

        <div class="col-lg-12">

            
            {!! $orderchart->container() !!}

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{__('All Offline Orders').' ( '.$ordercount.' )'}}
                    </h3>
                </div>

                <div class="card-body">
                    <table id="offline-orders" class="w-100 table-responsive table table-bordered table-hover">
                        <thead>
                            <th>#</th>
                            <th>{{ __('Order ID') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('TXN. ID') }}</th>
                            <th>{{ __('Payment Method') }}</th>
                            <th>{{ __('Order Status') }}</th>
                            <th>{{ __('Payment Details') }}</th>
                            <th>{{ __('Placed at') }}</th>
                            <th>{{ __('Updated at') }}</th>
                            <th>{{ __('Action') }}</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#offline-orders').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("offline-orders.index") }}',
            language: {
                searchPlaceholder: "Search orders"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'order_id',
                    name: 'offline_orders.order_id'
                },
                {
                    data: 'customer_name',
                    name: 'offline_orders.customer_name'
                },
                {
                    data: 'txn_id',
                    name: 'offline_orders.txn_id'
                },
                {
                    data: 'payment_method',
                    name: 'offline_orders.payment_method'
                },
                {
                    data: 'order_status',
                    name: 'offline_orders.order_status'
                },
                {
                    data: 'grand_total',
                    name: 'offline_orders.grand_total'
                },
                {
                    data: 'created_at',
                    name: 'offline_orders.created_at'
                },
                {
                    data: 'updated_at',
                    name: 'offline_orders.updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                },
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
<script src="{{ url('front/vendor/js/highcharts.js') }}" charset="utf-8"></script>
{!! $orderchart->script() !!}
@endsection