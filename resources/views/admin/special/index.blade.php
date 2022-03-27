@extends('admin.layouts.master-soyuz')
@section('title',__('All Special Offers'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('All Special Offers') }}
@endslot
@slot('menu1')
{{ __("Special Offers") }}
@endslot​
​@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/special/create')}}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Special Offer') }}</a>
 
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
        <h5 class="box-title">{{ __('Special Offers') }}</h5>
      </div>
      <div class="card-body">
         <!-- main content start -->
        <div class="table-responsive">
                        <!-- table to display faq start -->
          <table id="datatable-buttons" class="table table-striped table-bordered">
            <thead>
              <th>{{ __('Id') }}</th>
              <th>{{ __('Product Name') }}</th>
              <th>{{ __('Status') }}</th>
              <th>{{ __('Action') }}</th>
            </thead>
            <tbody>
               
                @foreach($products as $key => $product)
                
                  <tr>
                    <td>{{++$key}}</td>
                    <td>{{ isset($product->pro) ? $product->pro->name : $product->simple_product->product_name }}</td>
                    <td>
                      <form action="{{ route('spo.status.quick.update',$product->id) }}" method="Post">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-rounded {{ $product->status == 1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                          {{ $product->status ==1 ? "Active" : "Deactive" }}
                        </button>
                      </form>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                
                                <a class="dropdown-item" href="{{url('admin/special/'.$product->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                               
                                <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $product->id }}" >
                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                               
                            </div>
                        </div>
                        <div class="modal fade bd-example-modal-sm" id="delete{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                            <h4>{{ __('Are You Sure ?')}}</h4>
                                            <p>{{ __('Do you really want to delete')}} <b></b> ? {{ __('This process cannot be undone.')}}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post" action="{{url('admin/special/'.$product->id)}}" class="pull-right">
                                            {{csrf_field()}}
                                            {{method_field("DELETE")}}
                                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
  
@endsection

