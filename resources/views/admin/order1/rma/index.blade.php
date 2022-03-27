@extends('admin.layouts.master-soyuz')
@section('title',__('All RMA Reasons | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('All RMA Reasons') }}
@endslot
@slot('menu1')
{{ __("All RMA Reasons") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
   
        <a data-target="#createrma" data-toggle="modal" class=" btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>
            {{ __('Add Reason') }}
        </a>
    
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
          <h5 class="box-title">{{ __('All RMA Reasons') }}</h5>
        </div>
        <div class="card-body">
               
          <div class="table-responsive">
            <table  id="datatable-buttons" class="table table-striped table-bordered">
             <thead>
               <tr>
                 <th>{{ __('#') }}</th>
                 <th>{{ __('Reason') }}</th>
                 <th>{{ __('Status') }}</th>
                 <th>{{ __('Action') }}</th>
                </tr>
               </thead>

               <tbody>
                @foreach ($allrma as $key => $item)
                    <tr>
                      <td>{{ ++$key }}</td>
                      <td class="text-dark">{{ $item->reason }}</td>
                      <td>
                        <p class="badge badge-{{ $item->status == 1 ? __("success") : __("danger") }}">
                          {{ $item->status == 1 ? __("Active") : __("Deactive") }}
                        </p>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                          <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">

                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#edit{{ $item->id }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>

                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $item->id }}"><i class="feather icon-trash mr-2"></i>{{ __("Delete") }}</a>
                          
                          </div>
                      </div>
                      </td>
                    </tr>

                    <div id="delete{{ $item->id }}" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
        
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                          </div>
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
                            <p>{{__('Do you really want to delete this reason')}} <b>{{ $item->reason }}</b>{{ __("? This process cannot be undone.") }}</p>
                          </div>
                          <div class="modal-footer">
                          <form method="POST" action="{{ route('rma.destroy',$item->id) }}">
                                @csrf
                                @method('DELETE')
        
                              <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
                              <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
                            </form>
                          </div>
                        </div>
                      </div>
                  </div>

                  <div id="edit{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="my-modal-title">{{ __("Update reason") }}</h5>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('rma.update',$item->id) }}" class="form" method="POST" novalidate>
                                    @csrf
                                    @method("PUT")
                
                                    <x-forms.input :value="$item->reason" :placeholder="__('Enter reason')" :label="__('Enter Reason:')" name="reason" :required="true"/>
                                    <x-forms.toggle :label="__('Status')" name="status" :checked="$item->status == 1 ? true : false"/>
                                    <x-forms.button :text="__('Update')" type="submit" class="btn-md btn-primary-rgba" icon="icon-save"/>
                                
                                </form>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div id="delete{{ $item->id }}" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
        
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                          </div>
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
                            <p>{{__("Do you really want to delete this reason")}} <b>{{ $item->reason }}</b>{{ __("? This process cannot be undone.") }}</p>
                          </div>
                          <div class="modal-footer">
                          <form method="POST" action="{{ route('rma.destroy',$item->id) }}">
                                @csrf
                                @method('DELETE')
        
                              <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
                              <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
                            </form>
                          </div>
                        </div>
                      </div>
                  </div>

                @endforeach
               </tbody>

              </table>                  
                    
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="createrma" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">{{ __("Create reason") }}</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rma.store') }}" class="form" method="POST" novalidate>
                    @csrf

                    <x-forms.input :value="old('reason')" :placeholder="__('Enter reason')" :label="__('Enter Reason:')" name="reason" :required="true"/>
                    <x-forms.toggle :label="__('Status')" name="status" :checked="false"/>
                    <x-forms.button :text="__('Create')" type="submit" class="btn-md btn-primary-rgba" icon="icon-plus"/>
                
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
              
                       