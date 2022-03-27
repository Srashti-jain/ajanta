@extends('admin.layouts.master-soyuz')
@section('title',__('All Requested Brands'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
	{{ __('All Requested Brands') }}
@endslot

@slot('menu1')
	{{ __('Requested Brands') }}
@endslot

@endcomponent
<div class="contentbar">
	<div class="row">

		<div class="col-lg-12">
			<div class="card m-b-30">
				<div class="card-header">
					<h5 class="box-title"> {{ __('All Requested Brands') }}</h5>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">

							<thead>
								<th>#</th>
								<th>{{ __('Brand Logo') }}</th>
								<th>{{ __('Brand Name') }}</th>
								<th>{{ __('Brand Proof') }}</th>
								<th>{{ __('Action') }}</th>
							</thead>

							<tbody>
								@foreach($brands as $key=> $brand)
								<tr>
									<td>
										{{ $key+1 }}
									</td>

									<td>
										@if($brand->image !='')
										<img width="100px" align="left" class="img-fluid"
											src='{{ url("images/brands/".$brand->image) }}' />

										@else
										<img title="{{ __('Make a variant first !') }}" 
											src="{{ Avatar::create($brand->name)->toBase64() }}" />
										@endif
									</td>

									<td>
										{{ $brand->name }}
									</td>

									<td>
										@if($brand->brand_proof !='')
										{{ url('brandproof/'.$brand->brand_proof) }}
										@else
										-
										@endif
									</td>

									<td>
										<form action="{{ route('brand.quick.update',$brand->id) }}" method="POST">
											{{csrf_field()}}
											<span type="submit"
												class="btn btn-sm btn-rounded  {{ $brand->status==1 ? "btn-success-rgba" : "btn-danger-rgba" }}">
												{{ $brand->status == 1 ? __('Active') : __('Deactive') }}
											</span>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection