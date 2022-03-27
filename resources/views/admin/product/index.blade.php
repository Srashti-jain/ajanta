@extends('admin.layouts.master-soyuz')
@section('title',__('All Products |'))
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
     
      <a title="Import products" href="{{ route('import.page') }}" class="float-right btn btn-success-rgba mr-2"> <i class="feather icon-download mr-1"></i>{{__("Import Products")}} </a>
      <a href="{{ url('admin/products/create') }}" class="float-right btn btn-primary-rgba mr-2"> <i class="feather icon-plus mr-2"></i> {{__("Add Product")}} </a>
      <a href="{{ route('trash.variant.products') }}" class="btn btn-md btn-danger-rgba mr-2"> <i class="fa fa-trash"></i> {{ __("Trash") }}</a>
      
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
            <span aria-hidden="true">&times;</span></button></p>
        @endforeach
      </div>
      @endif
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('All Products') }}</h5>
          <!-- ---------------------- -->
            <form id="bulk_delete_form" method="POST" action="{{ route('pro.bulk.delete') }}" class="pull-left form-inline">
              @csrf
              <div class="form-group">
                <select required name="action" id="action" class="form-control">
                  <option value="">{{ __("Please select action") }}</option>
                  <option value="deleted">{{ __("Delete selected") }}</option>
                  <option value="deactivated">{{ __("Deactive selected") }}</option>
                  <option value="activated">{{ __("Active selected") }}</option>
                </select>
              </div>
              <button type="submit" class="ml-2 btn btn-md btn-primary-rgba">
                {{__('Apply')}}
              </button>
            </form>
           

        </div>
        <div class="card-body ml-2">
         <!-- main content start -->
         <div class="table-responsive">
            <table id="productTable" class="w-100 table table-bordered table-hover">
              <thead>
                <th>
                  <div class="inline">
                    <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all"/>
                    <label for="checkboxAll" class="material-checkbox"></label>
                  </div>
                
                </th>
                <th>
                  {{ __('S.NO') }}
                </th>
                <th>
                  {{ __('Image') }}
                </th>
                <th>
                {{ __('Product Detail') }}
                </th>
                <th>
                  {{ __('Price') }} ({{ $defCurrency->currency->code }})
                </th>
                <th>
                  {{ __('Categories & More') }}
                </th>
                <th>
                  {{ __('Featured') }}
                </th>
                <th>
                  {{ __('Status') }}
                </th>
                <th>
                  {{ __('Add / Update on') }}
                </th>
                <th>
                  {{ __('Actions') }}
                </th>
              </thead>
            </table>
           </div>
                    <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>


<div id="bulk_delete" class="delete-modal modal fade" role="dialog">
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
              {{__("Do you really want to delete selected products? This process cannot be undone.")}}
            </p>
          </div>
          <div class="modal-footer">
           <form id="bulk_delete_form" method="post" action="{{ route('pro.bulk.delete') }}">
              @csrf
              @method('DELETE')
              <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
              <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('custom-script')
<script>
  $(function () {

      "use strict";

      var table = $('#productTable').DataTable({
          processing: true,
          serverSide: true,
          searching: true,
          stateSave: true,
          ajax: "{{ route('products.index') }}",
          language: {
                searchPlaceholder: "Search Products..."
          },
          columns: [
              
              {data : 'checkbox', name : 'checkbox', searchable : false,orderable : false},
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
              {data : 'image', name : 'image',searchable : false, orderable : false},
              {data : 'name', name : 'products.name'},
              {data : 'price', name : 'price'},
              {data : 'catdtl', name : 'category.title'},
              {data : 'featured', name : 'products.featured',searchable : false},
              {data : 'status', name : 'products.status',searchable : false},
              {data : 'created_at', name : 'products.created_at'},
              {data : 'action', name : 'action', searchable : false,orderable : false}
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print'
          ],
          order : [
            [8,'DESC']
          ]
      });
      
  });

  

   $('#productTable').on('click', '.ptl', function (e) { 
        var id = $(this).data('proid');
        
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type : 'POST',
          data : { productid : $(this).data('proid') },
          datatype : 'html',
          url  : '{{ route('add.price.product') }}',
          success : function(response){
              $('#priceDetail'+id).modal('show');
              $('#pricecontent'+id).html('');
              $('#pricecontent'+id).html(response.body);
          }
      });

    });
    
</script>
@endsection

