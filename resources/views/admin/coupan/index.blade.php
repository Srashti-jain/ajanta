@extends('admin.layouts.master-soyuz')
@section('title',__('All Coupans'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Coupans') }}
@endslot

@slot('menu1')
   {{ __('Coupans') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        <a  href=" {{ route('coupan.create') }} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2"></i> {{__("Add Coupans")}}
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
                    <h5 class="box-title"> {{ __('All Coupans') }}</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="full_detail_table" class="table table-bordered table-striped">
                      <thead>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('CODE') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Max Usage') }}</th>
                        <th>{{ __('Detail') }}</th>
                        <th>{{ __('Action') }}</th>
                      </thead>
                      <tbody>
                        @foreach($coupans as $key=> $cpn)
                        <tr>
                          <td>{{ $key+1 }}</td>
                          <td>{{ $cpn->code }}</td>
                          <td>@if($cpn->distype == 'fix') <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i> @endif
                            {{ $cpn->amount }}@if($cpn->distype == 'per')% @endif </td>
                          <td>{{ $cpn->maxusage }}</td>
                          <td>
                            <p>{{__("Linked to")}} : <b>{{ ucfirst($cpn->link_by) }}</b></p>
                            <p>{{  __('Expiry Date') }}: <b>{{ date('d-M-Y',strtotime($cpn->expirydate)) }}</b></p>
                            <p>{{__('Discount Type')}}: <b>{{ $cpn->distype == 'per' ? __("Percentage") : __("Fixed Amount") }}</b></p>
                          </td>
                          <td>
                            <div class="dropdown">
                                <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                  @can('coupans.edit')
                                    <a class="dropdown-item" href="{{ route('coupan.edit',$cpn->id) }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                                    @endcan
                
                                    @can('coupans.delete')
                                    <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cpn->id }}" >
                                      <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                  </a>
                                    @endcan
                                </div>
                            </div>
                            @can('coupans.delete')
                            <div class="modal fade bd-example-modal-sm" id="delete{{$cpn->id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                          <form method="post" action="{{route('coupan.destroy',$cpn->id)}}" class="pull-right">
                                              {{csrf_field()}}
                                              {{method_field("DELETE")}}
                                              <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                                              <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          @endcan 
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
