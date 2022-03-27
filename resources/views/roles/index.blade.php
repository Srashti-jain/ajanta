@extends('admin.layouts.master-soyuz')
@section('title', __('Roles'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Roles') }}
@endslot
@slot('menu1')
   {{ __('Roles') }}
@endslot



@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
     @can('roles.create')
      <a href="{{ route('roles.create') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>  {{ __('Create a new role') }}</a>
      @endcan
      
    </div>
</div>
@endslot

@endcomponent

<div class="contentbar">   

  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
               
                 
                    <h5 class="card-title"> {{__("Roles")}}</h5>
                  
                  
              </div>
              
              <div class="card-body">
               
                  <div class="table-responsive">
                    <table id="roletable" class="table table-borderd responsive " style="width: 100%">

                        <thead>
                            <th>
                                #
                            </th>
                            <th>
                                {{__("Role Name")}}
                            </th>
                            <th>
                                {{__('Action')}}
                            </th>
                        </thead>
                    
                        <tbody>
                    
                        </tbody>
                    
                    
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
</div>

@endsection     
                        
@section('custom-script')
    <script>
       $(document).ready(function () {
        var table = $('#roletable').DataTable({
            lengthChange: false,
            responsive: true,
            serverSide: true,
            autoWidth: true,
            ajax: '{{ route('roles.index') }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'name',
                    name: 'roles.name'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable : false
                }
            ],
            dom: 'lBfrtip',
            buttons: [
                'copy',
                'excel',
                'csv',
                'pdf',
                'print'
            ],
            order: [
                [1, 'ASC']
            ]
        });

    });
    </script>
@endsection    
            