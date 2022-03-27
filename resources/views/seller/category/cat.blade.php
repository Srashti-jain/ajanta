@extends('admin.layouts.sellermastersoyuz')
@section('title',__('All Categories'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])

	@slot('heading')
		{{ __('All Categories') }}
	@endslot
	@slot('menu1')
		{{ __('All Categories') }}
	@endslot

@endcomponent

<div class="contentbar">   
             
  <!-- Start row -->
  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{__("All Categories")}}
				</h5>
              </div>
              
              
			  <div class="card-body">
                  
                 
        
                  
               
                  <div class="table-responsive">
					<table id="allcats" class="table table-bordered table-striped">
						<thead>
							<th>
								#
							</th>
							<th width="15%">
								{{__("Thumbnail")}}
							</th>
							<th width="50%">
								{{__("Name")}}
							</th>
							
							<th>
								{{__("Details")}}
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
		      
		      var table = $('#allcats').DataTable({
		          processing: true,
		          serverSide: true,
		          ajax: "{{ route('seller.get.categories') }}",
		          columns: [
		              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
		              {data : 'thumbnail', name : 'thumbnail'},
		              {data : 'name', name : 'name'},
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
