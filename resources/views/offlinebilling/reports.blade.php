@extends('admin.layouts.master-soyuz')
@section('title',__('Inhouse Order Reports | '))
@section('stylesheet')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('body')

@component('admin.component.breadcumb',['secondaryactive' => 'active'])

@section('body')

    @slot('heading')
        {{ __('Offline Billing') }}
    @endslot

    @slot('menu1')
        {{ __('Reports') }}
    @endslot

@slot('button')

    <div class="col-md-6">
        <div class="widgetbar">
            <a href="{{ route('offline-orders.index') }}" class="btn btn-primary-rgba">
                <i class="feather icon-arrow-left mr-2"></i> {{__("Back")}}
            </a>
        </div>
    </div>
@endslot
@endcomponent

    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{__('Offline Order Reports') }}
                        </h3>
                        <hr>
                        <div class="float-right form-group">
                            <label>{{ __("Sort by time period") }}</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                    <i class="fa fa-calendar"></i> <span class="text-range">Filter by date</span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <div class="card-body">
                        <table id="reports" class="w-100 table table-bordered table-hover">
                            <thead>
                                <th>#</th>
                                <th>{{ __('Invoice Date') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('TXN. ID') }}</th>
                                <th>{{ __('Customer details') }}</th>
                                <th>{{ __('Subtotal') }}</th>
                                <th>{{ __('Total tax') }}</th>
                                <th>{{ __('Total shipping') }}</th>
                                <th>{{ __('Grand total') }}</th>
                            </thead>
                            <tbody>
                
                            </tbody>
                            <tfoot align="right">
                                <tr>
                                    <th>
                                        <th></th>
                                        <th></th>
                
                                        <th></th>
                                        <th></th>
                
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom-script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(function () {
        "use strict";
            var st_date;
            var et_date;
            var table = $('#reports').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ route("offline.orders.reports") }}",
                data: function (d) {
                    d.start_date = st_date;
                    d.end_date = et_date;
                }
            },
            language: {
                searchPlaceholder: "Search in reports"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false,
                },
                {
                    data: 'order_date',
                    name: 'offline_orders.invoice_date'
                },
                {
                    data: 'order_id',
                    name: 'offline_orders.order_id'
                },
                {
                    data: 'txn_id',
                    name: 'offline_orders.txn_id'
                },
                {
                    data: 'customer_detail',
                    name: 'offline_orders.customer_name'
                },
                {
                    data: 'subtotal',
                    name: 'offline_orders.subtotal'
                },
                {
                    data: 'total_tax',
                    name: 'offline_orders.total_tax'
                },
                {
                    data: 'total_shipping',
                    name: 'offline_orders.total_shipping'
                },
                {
                    data: 'grand_total',
                    name: 'offline_orders.grand_total'
                },
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    // converting to interger to find total
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\₹,\$]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
        
                    // computing column Total of the complete result 
                    var subtotal = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        
                var totaltax = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        
                    var shipping = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        
                var grandtotal = api
                        .column( 8 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    
                        
                    // Update footer by showing the total with the reference of the column index 
                $( api.column( 4).footer() ).html('Total');
                    $( api.column( 5 ).footer() ).html("{{ $currency->currency->symbol }}"+subtotal.toFixed(2));
                    $( api.column( 6 ).footer() ).html("{{ $currency->currency->symbol }}"+totaltax.toFixed(2));
                    $( api.column( 7 ).footer() ).html("{{ $currency->currency->symbol }}"+shipping.toFixed(2));
                    $( api.column( 8 ).footer() ).html("{{ $currency->currency->symbol }}"+grandtotal.toFixed(2));
                },
            dom: 'lBfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            order: [
                [1, 'DESC']
            ]
        });

        $('#daterange-btn').daterangepicker({
                locale: { format: 'DD/MM/YYYY' },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {

                st_date = start.format('YYYY-MM-DD HH:mm:ss');
                et_date = end.format('YYYY-MM-DD HH:mm:ss');

                table.draw();

                $('.text-range').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                
            }
        );


    });
</script>
@endsection