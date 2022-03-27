@extends('admin.layouts.master-soyuz')
@section('title',__('All Users | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('All Users') }}
@endslot
@slot('menu1')
   {{ __('All Users') }}
@endslot


@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
      @can('users.create')
      <a href="{{ route('users.create',['type' => app('request')->input('filter')]) }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>  {{ __('Create a new user') }}</a>
      @endcan
      
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
                <div class="row">
                  <div class="col-md-9">
                    <h5 class="card-title"> {{__("All users")}}</h5>
                  </div>
                  <div class="col-md-3">
                    <select data-placeholder="Filter by role" name="roles" id="roles" class=" form-control select2">
                      <option value="">{{ __("Filter by role") }}</option>
                      <option value="all">{{ __("All") }}</option>
                      @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                 
                  
              </div>
              
              <div class="card-body">
               
                  <div class="table-responsive">
                    <table id="userstable" class="table table-bordered table-striped">
                      <thead>
                        <th>
                          #
                        </th>
                        <th>
                          {{__("Image")}}
                         </th>
                        <th>
                         {{__("Name")}}
                        </th>
                        <th>
                          {{ __("Email") }}
                         </th>
                         <th>
                          {{ __("Contact NO.") }}
                         </th>
                         <th>
                          {{ __("Role") }}
                         </th>
                         <th>
                          {{ __("Login as user") }}
                         </th>
                         <th>
                          {{ __("Registerd at") }}
                         </th>
                         <th>
                          {{ __("Action") }}
                         </th>
                      </thead>
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
      $(function() {
           var table = $('#userstable').DataTable({
                lengthChange: true,
                responsive: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                url: "{{ route("users.index") }}",
                    data: function (d) {
                        d.roles = $('#roles').val();
                    }
                },
                language: {
                  searchPlaceholder: "Search users"
                },
                columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable : false, searchable : false},
                  {data: 'image', name: 'image', orderable : false, searchable : false},
                  {data : 'name', name : 'users.name'},
                  {data : 'email', name : 'users.email'},
                  {data : 'mobile', name : 'mobile'},
                  {data : 'role', name : 'role'},
                  {data: 'loginas', name: 'loginas', orderable : false, searchable : false},
                  {data : 'created_at', name : 'users.created_at'},
                  {data : 'action', name : 'action',searchable : false}
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print'
                ]
            });

            table.buttons().container().appendTo('#userstable .col-md-3:eq(0)');

            $('#roles').on('change',function(){
                table.draw();
            });
        });
  </script>
@endsection      
                    
    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


