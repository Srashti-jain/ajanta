@extends('admin.layouts.master-soyuz')
@section('title',__('All Hotdeals | '))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Hotdeals') }}
@endslot

@slot('menu1')
   {{ __('Hotdeals') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        <a  href=" {{url('admin/hotdeal/create')}} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2"></i> {{__("Add Hotdeals")}}
        </a>
    </div>                        
</div>
@endslot
@endcomponent
<div class="contentbar"> 
    <div class="row">
        
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title"> {{ __('All Hotdeals') }}</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="full_detail_table" class="width100 table table-bordered table-striped">
                      <thead>
                        <tr class="table-heading-row">
              
                          <th>{{ __('ID') }}</th>
                          <th>{{ __('Product Name') }}</th>
                          <th>{{ __('Status') }}</th>
                          <th>{{ __("Action") }}</th>
                        </tr>
                      </thead>
                      <tbody>
                       
              
                        @foreach($products as $key => $product)
                        
                        <tr>
                          <td>{{ $key+1 }}</td>
                          <td>{{ isset($product->pro) ? $product->pro->name : $product->simple_product->product_name }}</td>
                        
                          <td>
              
                            @can('hotdeals.edit')
                            <form action="{{ route('hot.quick.update',$product->id) }}" method="POST">
                              @csrf
                              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                title="{{ __("This operation is disabled in Demo !") }}" @endif
                                class="btn btn-rounded {{ $product->status==1 ? "btn-success-rgba" : "btn-danger-rgba" }}">
                                {{ $product->status ==1 ? __('Active') : __('Deactive') }}
                              </button>
                            </form>
                          @endcan
              
              
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                @can('hotdeals.edit')
                                  <a class="dropdown-item" href="{{url('admin/hotdeal/'.$product->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                                  @endcan
                                  @can('hotdeals.delete')
                                  <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $product->id }}" >
                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                </a>
                                  @endcan
                              </div>
                          </div>
                          <div class="modal fade bd-example-modal-sm" id="delete{{$product->id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                            <p>{{ __('Do you really want to delete')}}? {{ __('This process cannot be undone.')}}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post" action="{{url('admin/hotdeal/'.$product->id)}}" class="pull-right">
                                            @csrf
                                            {{method_field("DELETE")}}
                                            <button type="reset" class="btn btn-secondary-rgba" data-dismiss="modal">{{ __("No") }}</button>
                                            <button type="submit" class="btn btn-primary-rgba">{{ __("YES") }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                          
                          </td>
              
                        </tr>
                        @endforeach
              
                    </table>
                    </tbody>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
             
