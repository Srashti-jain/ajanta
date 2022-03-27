@extends(!in_array('Seller',auth()->user()->getRoleNames()->toArray()) ? "admin.layouts.master" : "admin.layouts.sellermastersoyuz")
@section('title',__('Trash'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Trash') }}
@endslot
@slot('menu1')
{{ __("Trash") }}
@endslot

​
@endcomponent
<div class="contentbar">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach
        </div>
        @endif
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                <h5 class="box-title">    {{__("Trashed Products")}}</h5>
                </div>
                <div class="card-body ml-2">
                
                    <div class="table-responsive">
                        <table  id="productTable" class="table table-striped table-bordered">
                            <thead>
                            <th>#</th>
                            <th>
                                {{__("Product Name")}}
                            </th>
                            <th>
                                {{__("Status")}}
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
                        

​
                 

                                      
                   
@endsection

@section('custom-script')
    <script>
        $(function () {

            "use strict";

            var table = $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                stateSave: true,
                ajax: "{{ route('trash.variant.products') }}",
                language: {
                    searchPlaceholder: "Search trashed products..."
                },
                columns: [
                    
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                    {data : 'name', name : 'products.name'},
                    {data : 'status', name : 'products.status',searchable : false},
                    {data : 'action', name : 'action', searchable : false,orderable : false}

                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print'
                ],
                order : [
                    [0,'DESC']
                ]
            });

            });
    </script>
@endsection

