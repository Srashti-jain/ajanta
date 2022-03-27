@extends('admin.layouts.master-soyuz')
@section('title',__('Store Requests | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Store Requests') }}
@endslot
@slot('menu1')
   {{ __('Store Requests') }}
@endslot




@endcomponent

<div class="contentbar">   

  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-9">
                    <h5 class="card-title"> {{__("All Store Requests")}} ({{ $list }})</h5>
                  </div>
                 
                </div>
                 
                  
              </div>
              
              <div class="card-body">
               
                  <div class="table-responsive">
                    <table id="tableStoreList" class="width100 table table-bordered table-striped table-hover">
                      <thead>
                        <th>
                          #
                        </th>
                
                        <th>
                          {{__('Store Details')}}
                        </th>
                
                        <th>
                          {{__("Uploaded Doucments")}}
                          <br>
                          <small>({{ __("For verification") }})</small>
                        </th>
                
                        <th>
                          {{__("Requested at")}}
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
    <!-- End col -->
</div>

@endsection     
                        
@section('custom-script')
<script>
  $(function () {
    "use strict";
    var table = $('#tableStoreList').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('get.store.request') }}",
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          searchable: false,
          orderable : false
        },
        {
          data: 'detail',
          name: 'stores.name'
        },
        {
          data: 'document',
          name: 'stores.document',
        },
        {
          data: 'requested_at',
          name: 'requested_at',
          searchable : false,
          orderable : false
        },
        {
          data: 'action',
          name: 'action',
          searchable : false,
          orderable : false
        }
      ],
      dom: 'lBfrtip',
      buttons: [
        'csv', 'excel', 'pdf', 'print'
      ],
      order: [
        [0, 'DESC']
      ]
    });

  });
</script>
@endsection  
                    
    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


