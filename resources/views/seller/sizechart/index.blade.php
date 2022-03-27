@extends('admin.layouts.sellermastersoyuz')
@section('title',__("Size chart templates"))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])

    @slot('heading')
        {{ __('Size chart templates') }}
    @endslot
    ​
    @slot('menu2')
        {{ __("Size chart templates") }}
    @endslot

    @slot('button')
        <div class="col-md-6">
            <div class="widgetbar">
                <a href="{{ route('sizechart.create') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Create")}}</a>
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
          <h5 class="box-title">{{ __('Size chart templates') }}</h5>
        </div>
        <div class="card-body">
            <table id="full_detail_table" class="w-100 table table-bordered table-striped">
                <thead>
                    <th>
                        {{__("#")}}
                    </th>
                    <th>
                        {{__("Template name")}}
                    </th>
                    <th>
                        {{__("Template code")}}
                    </th>
                    <th>
                        {{__("Action")}}
                    </th>
                </thead>

                <tbody>
                    @foreach($templates as $key => $temp)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ ucfirst($temp->template_name) }}</td>
                            <td>{{ ucfirst($temp->template_code) }}</td>
                            <td>
                                <div class="dropdown">

                                    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>

                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                    
                                        <a title="Edit" href="{{ route('sizechart.edit',$temp->id) }}" class="dropdown-item"><i class="feather icon-edit mr-2"></i>
                                            {{__('Edit')}}
                                        </a>

                                        <a role="button" title="Delete" data-toggle="modal" data-target="#delete{{ $temp->id }}" class="dropdown-item"><i class="feather icon-trash mr-2"></i>
                                            {{__('Delete')}}
                                        </a>
                                        
                                    </div>
                                </div>
                            </td>

                            <div id="delete{{ $temp->id }}" class="delete-modal modal fade" role="dialog">
                                <div class="modal-dialog modal-sm">
                  
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <div class="delete-icon"></div>
                                    </div>
                                    <div class="modal-body text-center">
                                      <h4 class="modal-heading">{{ __('Are You Sure ?') }}</h4>
                                      <p> {{__('Do you really want to delete this template')}} <b>{{ $temp->template_name }}</b>{{ __('? This process cannot be undone.') }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST" action="{{ route('sizechart.destroy',$temp->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
                                            <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                        </form>
                                    </div>
                                  </div>
                                </div>
                            </div>

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

