@extends('admin.layouts.master-soyuz')
@section('title',__("Manage :unittitle Values | ",['unittitle' => $unit->title]))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Manage  Values') }}
@endslot
@slot('menu1')
   {{ __('Units') }}
@endslot
@slot('menu2')
   {{ __('Manage Values') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a  href="{{ route('unit.index') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">   

  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                <h5 class="card-title">{{__("Option values for :")}} <b>{{ $unit->title }}</b></h5>
              </div>
              <div class="card-body">
               
				<div class="row">
					<div class="col-md-4">
						<h5>{{__("Add New Value for")}} <b>{{ $unit->title }}</b></h5>
	
						<form method="POST" action="{{ route('store.val.unit',$unit->id) }} ">
							{{ csrf_field() }}
	
							<div class="form-group">
								<label for="">
									{{__("Value :")}}
								</label>
								<input required="" type="text" name="unit_values" class="form-control">
							</div>
	
							<div class="form-group">
								<label>{{__('Short Code:')}} </label>
								<input type="text" required class="form-control" name="short_code">
							</div>
	
							
							<button type="submit" class="btn btn-primary"><i class="feather icon-plus-circle"></i>
							  {{ __("Add")}}</button>
							<button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>  
							
						</a>
							
						</form>
					</div>
	
					<div class="col-md-8">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>
										{{__("Value")}}
									</th>
									<th>
										{{__("Short Code")}}
									</th>
									<th>
										{{__("Action")}}
									</th>
								</tr>
							</thead>
	
							<tbody>
								@foreach($unit->unitvalues as $a => $unitval)
								<tr>
									<td>
										{{ $a+1 }}
									</td>
	
									<td>
										{{ $unitval->unit_values }}
									</td>
	
									<td>
										{{ $unitval->short_code }}
									</td>
	
									<td>
										<div class="dropdown">
											<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
											<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
											  
											 
												<a class="dropdown-item"   data-target="#edit_{{ $unitval->id }}" data-toggle="modal"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
											 
											
												<a class="dropdown-item" @if(env('DEMO_LOCK') == 0) data-target="#del_{{ $unitval->id }}" data-toggle="modal" @else title="{{ __("This action is disabled in demo !") }}" disabled @endif><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
											
											  </div>
										  </div>
										  
									</td>
									
				
					  <!--END-->
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
	
					
				</div>
            </div>
          </div>
      </div>
      <!-- End col -->
  </div>
</div>
               
@foreach($unit->unitvalues as $a => $unitval)
<!-- Edit Modal -->
		<div class="modal fade" id="edit_{{ $unitval->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"> {{__("Edit")}} {{ $unitval->unit_values }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			
			  </div>
			  <div class="modal-body">
				 <form action="{{ route('edit.val.unit',$unitval->id) }}" method="POST">
					 {{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="form-group">
						<label for="">
							{{__("Title :")}}
						</label>
						<input type="text" value="{{ $unitval->unit_values }}" class="form-control" name="unit_values">
					</div>

					<div class="form-group">
						<label> {{__("Short Code:")}} </label>
						<input type="text" value="{{ $unitval->short_code }}" class="form-control" name="short_code">
					</div>

					<button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
					<button type="submit" @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" title="{{ __("This action is disabled in demo !") }}"  @endif class="btn btn-primary"><i class="fa fa-check-circle"></i>
					  {{ __("Update")}}</button>

					

				 </form>
			  </div>
			 
			</div>
		  </div>
		</div>

		 <!--Modal for Delete-->
		<div id="del_{{ $unitval->id }}" class="delete-modal modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <div class="delete-icon"></div>
				</div>
				<div class="modal-body text-center">
				  <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
				  <p>
					  {{__("Do you really want to delete this? This process cannot be undone.")}}
				  </p>
				</div>
				<div class="modal-footer">
				  <form method="POST" action="{{ route('del.unit.val',$unitval->id) }}">
					  {{ csrf_field() }}
					  {{ method_field('DELETE') }}
					  
					<button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
					<button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
				  </form>
				</div>
			  </div>
			</div>
	  </div>
@endforeach               
                  
                  
              


@endsection     
                    