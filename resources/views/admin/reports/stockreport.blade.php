@extends('admin.layouts.master-soyuz')
@section('title',__('Stock reports all products'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Stock Reports') }}
@endslot
@slot('menu1')
{{ __("Reports") }}
@endslot
@slot('menu2')
{{ __("Stock Reports") }}
@endslot
@endcomponent
<div class="contentbar">
   
    <div class="row">
       
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">
                        {{__("Stock Report")}}
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-shopping-bag mr-2"></i>{{ __("Variant Products") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-shopping-bag mr-2"></i>{{ __("Simple Products") }}</a>
                        </li>
                      
                    </ul>
                    <div class="tab-content" id="defaultTabContentLine">
                        <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                            <table  id="stock_report_vp" class="w-100 table table-striped table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>{{ __("Product name") }}</th>
                                    <th>{{ __("Variant detail") }}</th>
                                    <th>{{ __('Store name') }}</th>
                                    <th>
                                        {{__("Stock")}}
                                    </th>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                            <table  id="stock_report_sp" class="w-100 table table-striped table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>{{ __("Product name") }}</th>
                                    <th>
                                        {{__("Store name")}}
                                    </th>
                                    <th>
                                        {{__("Stock")}}
                                    </th>
                                </thead>
                            </table>
                        </div>
                       
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
            var table = $('#stock_report_vp').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.stock.report") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'products.name'},
                    {data : 'variant', name : 'variant'},
                    {data : 'store_name', name : 'products.store.name'},
                    {data : 'stock', name : 'add_sub_variants.stock'}
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print'
                ],
                order : [[0,'DESC']]
            });
            
        });

        $(function () {
            "use strict";
            var table = $('#stock_report_sp').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.stock.report.sp") }}',
                language: {
                    searchPlaceholder: "Search in reports..."
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'product_name', name : 'simple_products.product_name'},
                    {data : 'store_name', name : 'store.name'},
                    {data : 'stock', name : 'simple_products.stock'}
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print'
                ],
                order : [[0,'DESC']]
            });
            
        });
    </script>
@endsection