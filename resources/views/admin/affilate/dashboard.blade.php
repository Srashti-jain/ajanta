@extends('admin.layouts.master-soyuz')
@section('title',__('Affiliate Reports'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Affiliate Reports') }}
@endslot

@slot('menu1')
   {{ __('Affiliate Reports') }}
@endslot


@endcomponent
<div class="contentbar"> 
    <div class="row">
        
        <div class="col-lg-12">

            

            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Affiliate Reports') }}</h5>
                </div>
                <div class="card-body">
                
                    <div class="table-responsive">
                        <table id="report" class="table table-bordered">
                            <thead>
                                <th>
                                    #
                                </th>
                               
                                <th>
                                    {{__('Refered user')}}
                                </th>
                                <th>
                                    {{__('Refered by')}}
                                </th>
                                <th>
                                    {{__('Date')}}
                                </th>
                                <th>
                                    {{__("Amount")}}
                                </th>
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
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
        var table = $('#report').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.affilate.dashboard") }}',
            language: {
                searchPlaceholder: "Search in reports..."
            },
            columns: [
                {data: 'DT_RowIndex', name: 'affilate_histories.id', searchable : false},
                {data : 'refered_user', name : 'fromRefered.name'},
                {data : 'user', name : 'user.name'},
                {data : 'created_at', name : 'affilate_histories.created_at'},
                {data : 'amount', name : 'affilate_histories.amount'},
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // converting to interger to find total
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace("{{ $defaultCurrency->symbol }}", '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                var grandtotal = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    
                        
                    // Update footer by showing the total with the reference of the column index 
                $( api.column( 3).footer() ).html('Total');
                    $( api.column( 4 ).footer() ).html("{{ $defaultCurrency->symbol }}"+'<p>'+grandtotal.toFixed(2)+'</p>');
                },
            dom : 'lBfrtip',
            buttons : [
                'csv','excel','pdf','print'
            ],
            order : [[0,'DESC']]
        });
        
    });

</script>  
@endsection
