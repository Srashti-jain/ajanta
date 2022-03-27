@extends('admin.layouts.master-soyuz')
@section('title',__('Offline Payment Gateway'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Front Setting') }}
@endslot

@slot('menu1')
   {{ __('Offline Payment Gateway') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        
@can('manual-payment.create')

        <a data-target="#addPaymentModal" data-toggle="modal" class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2"></i> {{__("Add New")}}
        </a>
        @endcan
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
                    <h5 class="box-title">
                        {{__("All Offline Payment Gateway")}}
                    </h5>
                </div>
                <div class="card-body">
                
                    <div class="table-responsive">
                        <table style="width:100%" id="full_detail_table" class="table table-bordered">
                            <thead>
                                <th>
                                    #
                                </th>
                                <th>
                                    {{__("Payment Gateway Name")}}
                                </th>
                                <th>
                                    {{__('Action')}}
                                </th>
                            </thead>
                            <tbody>
                                @foreach($methods as $key=> $m)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{  ucfirst($m->payment_name) }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1"
                                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                              @can('childcategory.edit')
                                              <a class="dropdown-item" data-toggle="modal" data-target="#editPaymentmethod{{ $m->id }}"><i
                                                  class="feather icon-edit mr-2"></i>{{  __('Edit') }}</a>
                                              @endcan
                      
                                              @can('childcategory.delete')
                                              <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $m->id }}">
                                                <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                              </a>
                                              @endcan
                                            </div>
                                          </div>
                                        
                                       
                                    </td>
                                </tr>
                        
                                <!-- Edit Payment Method Modal -->
                                @can('manual-payment.edit')
                                <div data-backdrop="false" id="editPaymentmethod{{ $m->id }}" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="editPaymentModal-title" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPaymentModal-title">Edit Payment method: {{ $m->payment_name }}

                                                <button class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </h5>
                        
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('manual.payment.gateway.update',$m->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                        
                                                    @csrf
                        
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{__("Payment method name:")}} <span class="text-danger">*</span>
                                                        </label>
                                                        <input required type="text" value="{{ $m['payment_name'] }}" name="payment_name"
                                                            class="form-control" />
                                                    </div>
                        
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{__("Payment Instructions:")}} <span class="text-danger">*</span>
                                                        </label>
                        
                                                        <textarea name="description" id="" cols="30" rows="5"
                                                            class="form-control editor">{!! $m['description'] !!}</textarea>
                        
                                                    </div>
                        
                                                    <div class="form-group">
                                                        <label for="">
                                                            {{__("Image :")}}
                                                        </label>
                                                        <div class="input-group">

                                                            <input required readonly id="thumbnail{{ $m['id'] }}" name="thumbnail" type="text"
                                                                class="form-control">
                                                            <div class="input-group-append">
                                                                <span data-input="thumbnail{{ $m['id'] }}"
                                                                    class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <br>
                                                        <label class="switch">
                                                            <input id="status" type="checkbox" name="status"
                                                                {{ $m['status'] == 1 ? "checked" : "" }}>
                                                            <span class="knob"></span>
                                                        </label>
                                                    </div>
                        
                                                    <div class="form-group">
                                                        <button @if(env('DEMO_LOCK')==0) type="reset"  @else disabled title="{{ __('This operation is disabled is demo !') }}" @endif  class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
                                                        <button @if(env('DEMO_LOCK')==0)  type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}" @endif  class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                                            {{ __("Update") }}</button>
                                                    </div>
                        
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endcan
                                @can('manual-payment.delete')
                                <!-- Delete Payment -->
                                <div class="modal fade bd-example-modal-sm" id="delete{{$m->id}}" tabindex="-1" role="dialog"
                                    aria-hidden="true">
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
                                          <form method="post" action="{{ route('manual.payment.gateway.update',$m->id) }}}}" class="pull-right">
                                            {{csrf_field()}}
                                            {{method_field("DELETE")}}
                                            <button type="reset" class="btn btn-danger-rgba" data-dismiss="modal">{{ __("No") }}</button>
                                            <button type="submit" class="btn btn-primary-rgba">{{ __("YES") }}</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                @endcan
                                <!-- END -->
                        
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@can('manual-payment.create')
    <div data-backdrop="false" id="addPaymentModal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="addPaymentModal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModal-title">Add new payment method</h5>

                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form action="{{ route('manual.payment.gateway.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="form-group">
                            <label for="">
                                {{__('Payment method name:')}} <span class="text-danger">*</span>
                            </label>
                            <input required type="text" value="{{ old('payment_name') }}" name="payment_name"
                                class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="">
                                {{__('Payment Instructions :')}} <span class="text-danger">*</span>
                            </label>

                            <textarea name="description" id="" cols="30" rows="5"
                                class="form-control editor">{!! old('description') !!}</textarea>

                        </div>

                        <div class="form-group">
                            <label for="">
                                {{__("Image :")}}
                            </label>
                            <div class="input-group">

                                <input required readonly id="thumbnail" name="thumbnail" type="text"
                                    class="form-control">
                                <div class="input-group-append">
                                    <span data-input="thumbnail"
                                        class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                {{__('Status :')}}
                            </label>
                            <br>
                            <label class="switch">
                                <input id="status" type="checkbox" name="status" {{ old('status') ? "checked" : "" }} checked>
                                <span class="knob"></span>
                            </label>
                        </div>

                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                              {{ __("Reset") }}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                              {{ __("Create") }}</button>
                          </div>
              
                          <div class="clear-both"></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endcan
@endsection
@section('custom-script')
  <script>
      $(".midia-toggle").midia({
          base_url: '{{url('')}}',
          directory_name: 'manual_payment'
      });
  </script>
@endsection