@extends('admin.layouts.master-soyuz')
@section('title',__('All Products | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('All Products') }}
@endslot
@slot('menu2')
{{ __("All Products") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
      
        @can('products.import')
            <a data-toggle="modal" data-target="#importproductimages" class="float-right btn btn-info-rgba mr-2">
                <i class="feather icon-image"></i> {{__("Bulk Upload Images") }}
            </a>
        @endcan
        @can('products.import')
            <a class="float-right btn btn-success-rgba mr-2" href="{{ route('import.page') }}">
                <i class="feather icon-file-text"></i> {{__("Import Products") }}
            </a>
        @endcan
        @can('products.create')
            <a href="{{ route('simple-products.create') }}" class="float-right btn btn-primary-rgba mr-2">
                <i class="feather icon-plus mr-2"></i>{{__("Add new") }}
            </a>
        @endcan
        @can('products.delete')
            <a href="{{ route('trash.simple.products') }}" class="float-right btn btn-danger-rgba mr-2">
                <i class="feather icon-trash-2"></i> {{__("Trash") }}
            </a>
        @endcan
  </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">
  <div class="row">
   
    <div class="col-lg-12">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          @foreach($errors->all() as $error)
          <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true" style="color:red;">&times;</span></button></p>
          @endforeach
        </div>
        @endif
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Product') }}</h5>
        </div>
        <div class="card-body">
         <!-- main content start -->
        <table id="d_products" class="w-100 table table-bordered table-hover">
            <thead>
                <th>{{ __("S.No") }}</th>
                <th>{{ __('Image') }}</th>
                <th>{{ __("ID") }}</th>
                <th>{{ __('Product Name') }}</th>
                <th>{{ __("Pricing") }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
            </thead>
        </table>                
         <!-- main content end -->
        </div>
      </div>
    </div>
  </div>

  <!-- =============================== -->

<!-- ----------- -->
<div class="modal fade" id="importproductimages" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__("Bulk Import Simple Product Images")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- main content start -->
                <a href="{{ url('files/SimpleProductImages.xlsx') }}" class="btn btn-md btn-success"> {{ __('Download Example xls/csv File') }}</a>
						<hr>
						<form action="{{ route('simple.product.import.images') }}" method="POST" enctype="multipart/form-data">	
                            @csrf
						
							<div class="row">
								<div class="form-group col-md-12">
									<label for="file">{{__("Choose your xls/csv File")}} :</label>
                                    <!-- ------------ -->
                                    <div class="input-group mb-3">
                                       
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
                                            <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                                        </div>
                                        @if ($errors->has('file'))
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                        @endif
                                        <p></p>
                                    </div>
                                    <!-- ------------- -->
									<button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> {{ __('Import') }}</button>
								</div>
								
							</div>
			
						</form>

                        <div class="box box-danger">
							<div class="box-header with-border">
								<div class="box-title">{{ __('Instructions') }}</div>
							</div>
					
							<div class="box-body">
								<p><b>{{ __('Follow the instructions carefully before importing the file.') }}</b></p>
								<p>{{ __('The columns of the file should be in the following order.') }}</p>
					
								<table class="table table-striped">
									<thead>
										<tr>
											<th>{{ __('Column No') }}</th>
											<th>{{ __('Column Name') }}</th>
                                            <th>{{ __('Required') }}</th>
											<th>{{ __('Description') }}</th>
										</tr>
									</thead>
					
									<tbody>
										<tr>
											<td>1</td>
											<td><b>product_id</b></td>
                                            <td><b>{{ __('Yes') }}</b></td>
											<td>Enter product id here</td>	
										</tr>

										<tr>
											<td>2</td>
											<td> <b>image</b> </td>
											<td><b>{{ __('Yes') }}</b></td>
                                            <td>Name your image eg: example.jpg <b>(Images can be uploaded using Media Manager / Simple Products Gallery Tab. )</b> .</td>
										</tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                <!-- main content end -->
            </div>
            
        </div>
    </div>
</div>
<!-- ----------- -->

  <!-- =============================== -->
</div>
@endsection
@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#d_products').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: '{{ route("simple-products.index") }}',
            language: {
                searchPlaceholder: "Search Products..."
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'image',
                    name: 'image',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'id',
                    name: 'simple_products.id'
                },
                {
                    data: 'product_name',
                    name: 'simple_products.product_name'
                },
                {
                    data: 'price',
                    name: 'simple_products.actual_selling_price'
                },
                {
                    data: 'status',
                    name: 'simple_products.status'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable : false
                },
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

