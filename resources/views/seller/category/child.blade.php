@extends('admin.layouts.sellermastersoyuz')
@section('title',__('All Childcategories'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('All Childcategories') }}
@endslot
@slot('menu1')
   {{ __('All Childcategories') }}
@endslot





@endcomponent

<div class="contentbar">   
             
  <!-- Start row -->
  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{__("All Childcategories")}}
				</h5>
              </div>
              
              
			  <div class="card-body">
                  
                 
        
                  
               
                  <div class="table-responsive">
					<table id="subcats" class="table table-bordered table-striped">
						<thead>
							<th>
								#
							</th>
							<th>
								{{__("Thumbnail")}}
							</th>
							<th width="20%">
								{{__("Name")}}
							</th>
							<th width="20%">
								{{__("Subcategory Name")}}
							</th>
							<th width="20%">
								{{ __("Category Name") }}
							</th>
							<th>
								{{ __("Details") }}
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
		      
		      var table = $('#subcats').DataTable({
		          processing: true,
		          serverSide: true,
		          ajax: "{{ route('seller.get.childcategories') }}",
		          columns: [
		              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
		              {data : 'thumbnail', name : 'thumbnail'},
		              {data : 'name', name : 'name'},
		              {data : 'sub', name : 'subcategory.title'},
		              {data : 'main', name : 'category.title'},
		              {data : 'details', name : 'details'}
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
