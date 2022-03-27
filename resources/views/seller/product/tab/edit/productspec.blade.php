

<div class="row mb-2">
	<div class="col-md-9">
		<h3>Product Specification</h3>
	</div>
	<div class="col-md-3">
		<a type="button" class="btn btn-danger-rgba float-right" data-toggle="modal" data-target="#bulk_delete"><i class="feather icon-trash-2"></i> Delete Selected</a> 
	</div>
</div>

<form action="{{ route('pro.specs.store',$products->id) }}" method="POST">
				  		@csrf
	<table class="table table-striped table-bordered">
		<thead>
			<th>
                <div class="inline">
                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all"/>
                <label for="checkboxAll" class="material-checkbox"></label>
              </div>
              
              </th>
			<th>Key</th>
			<th>Value</th>
			<th>Action</th>
		</thead>

		<tbody>
			@if(isset($products->specs))
				@foreach($products->specs as $spec)
					<tr>
						<td>
		                    <div class="inline">
		                      <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$spec->id}}" id="checkbox{{$spec->id}}">
		                      <label for="checkbox{{$spec->id}}" class="material-checkbox"></label>
		                    </div>
	                    </td>
						<td>{{ $spec->prokeys }}</td>
						<td>{{ $spec->provalues }}</td>
						<td>
						<div class="dropdown">
							<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
							<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
								<a class="dropdown-item"   data-toggle="modal" title="Edit" data-target="#edit{{ $spec->id }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
								
								
							  </div>
							</div>
						  </td>

					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
  	<table class="table table-striped table-bordered" id="dynamic_field"> 
				  	
	       <tbody>
	       		 <tr> 
		            <td>
		               <input required="" name="prokeys[]" type="text" class="form-control" value="" placeholder="Product Attribute">
		            </td>

		            <td>
		             	<input required="" name="provalues[]" type="text" class="form-control" value="" placeholder="Attribute Value">
		            </td>  
		            <td>
						
						
		            	<button type="button" name="add" id="add" class="btn btn-xs btn-success">
		              	<i class="feather icon-plus"></i>
		            	</button>
		        	</td>  
	        	</tr>  
	       </tbody>
				     
    </table>
   
		<button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
						<button  type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
						{{ __("Update")}}</button>
   
    
</form>

@section('tab-modal-area')
@if(isset($products->specs))
	@foreach($products->specs as $spec)
		<div id="edit{{ $spec->id }}" class="delete-modal modal fade" role="dialog">
	        <div class="modal-dialog modal-md">
	          <!-- Modal content-->
	          <div class="modal-content">
	            <div class="modal-header">
	              <div class="modal-title">Edit : <b>{{ $spec->prokeys }}</b></div>
	            </div>
	            <div class="modal-body">
	              <form action="{{ route('pro.specs.update',$spec->id) }}" method="POST">
	              	  @csrf

	              	  <div class="form-group">
	              	  	<label>Attribute Key:</label>
	              	    <input required="" type="text" name="pro_key" value="{{ $spec->prokeys }}" class="form-control">
	              	  </div>

	              	  <div class="form-group">
	              	  	<label>Attribute Value:</label>
	              	  	<input required="" type="text" name="pro_val" value="{{ $spec->provalues }}" class="form-control">
	              	  </div>
					

						<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle mr-2"></i>Update</button>
						<button type="reset" class="btn btn-danger translate-y-3" data-dismiss="modal"> <i class="feather icon-x-circle mr-2"></i>
							 Cancel</button>
                		
					

	              </form>
	            </div>
	            
	          </div>
	        </div>
	      </div>
	@endforeach
@endif

@endsection



