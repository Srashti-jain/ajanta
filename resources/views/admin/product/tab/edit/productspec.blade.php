<h5>
	{{__("Edit Product Specification")}}
</h5>
<hr>
<a type="button" class=" btn btn-danger-rgba" data-toggle="modal" data-target="#bulk_delete"><i class="fa fa-trash"></i> {{ __("Delete Selected") }}</a>
<hr>
<form action="{{ route('pro.specs.store',$products->id) }}" method="POST">
	@csrf
	<table class="table table-striped table-bordered">
		<thead>
			<th>
				<div class="inline">
					<input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" />
					<label for="checkboxAll" class="material-checkbox"></label>
				</div>

			</th>
			<th>{{ __("Key") }}</th>
			<th>{{ __("Value") }}</th>
			<th>#</th>
		</thead>

		<tbody>
			@if(isset($products->specs))
			@foreach($products->specs as $spec)
			<tr>
				<td>
					<div class="inline">
						<input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input"
							name="checked[]" value="{{$spec->id}}" id="checkbox{{$spec->id}}">
						<label for="checkbox{{$spec->id}}" class="material-checkbox"></label>
					</div>
				</td>
				<td>{{ $spec->prokeys }}</td>
				<td>{{ $spec->provalues }}</td>
				<td>
					<a data-toggle="modal" title="Edit" data-target="#edit{{ $spec->id }}" class="btn btn-sm btn-info">
						<i class="fa fa-pencil"></i>
					</a>

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
					<input required="" name="prokeys[]" type="text" class="form-control" value=""
						placeholder="Product Attribute">
				</td>

				<td>
					<input required="" name="provalues[]" type="text" class="form-control" value=""
						placeholder="Attribute Value">
				</td>
				<td>
					<button type="button" name="add" id="add" class="btn btn-xs btn-success">
						<i class="fa fa-plus"></i>
					</button>
				</td>
			</tr>
		</tbody>

	</table>

	<button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
	<button class="btn btn-primary btn-md"><i class="fa fa-check-circle"></i> {{ __("Add") }}</button>

</form>

@section('tab-modal-area')

@if(isset($products->specs))
@foreach($products->specs as $spec)

<!-- ------------------------- -->
<div class="modal fade" id="edit{{ $spec->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleStandardModalLabel">{{__('Edit :')}} <b>{{ $spec->prokeys }}</b></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('pro.specs.update',$spec->id) }}" method="POST">
					@csrf

					<div class="form-group">
						<label>{{ __("Attribute Key:") }}</label>
						<input required="" type="text" name="pro_key" value="{{ $spec->prokeys }}" class="form-control">
					</div>

					<div class="form-group">
						<label>{{ __('Attribute Value:') }}</label>
						<input required="" type="text" name="pro_val" value="{{ $spec->provalues }}"
							class="form-control">
					</div>
					<button type="submit" class="btn btn-primary"><i
							class="fa fa-check-circle"></i>{{ __("Save") }}</button>
					<button type="reset" class="btn btn-danger translate-y-3"
						data-dismiss="modal">{{ __("Cancel") }}</button>

				</form>
			</div>

		</div>
	</div>
</div>
<!-- ------------------------- -->

<div id="1edit{{ $spec->id }}" class="delete-modal modal fade" role="dialog">
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
						<label>{{ __('Attribute Key:') }}</label>
						<input required="" type="text" name="pro_key" value="{{ $spec->prokeys }}" class="form-control">
					</div>

					<div class="form-group">
						<label>
							{{__("Attribute Value:")}}
						</label>
						<input required="" type="text" name="pro_val" value="{{ $spec->provalues }}"
							class="form-control">
					</div>


					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
						{{__('Save')}}
					</button>
					<button type="reset" class="btn btn-danger translate-y-3" data-dismiss="modal">
						{{__("Cancel")}}
					</button>



				</form>
			</div>

		</div>
	</div>
</div>
@endforeach
@endif

@endsection