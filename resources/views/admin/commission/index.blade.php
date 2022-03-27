@extends('admin.layouts.master-soyuz')
@section('title',__('All Commission List'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('All Commission List') }}
@endslot

@slot('menu1')
{{ __('Commission List') }}
@endslot

@slot('button')

<div class="col-md-6">
  <div class="widgetbar">
    <a href=" {{url('admin/commission/create')}} " class="btn btn-primary-rgba mr-2">
      <i class="feather icon-plus mr-2"></i> {{__("Add Commission List")}}
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
          <h5 class="box-title"> {{ __('All Commission List') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="full_detail_table" class="table table-hover">
              <thead>
                <tr>
                  <th>{{ __("ID") }}</th>
                  <th>{{ __('Category') }}</th>
                  <th>{{ __('Rate') }}</th>
                  <th>{{ __("Type") }}</th>
                  <th>{{ __("Status") }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($commissions as $key => $commission)

                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{$commission->category->title}}</td>

                  <td>{{$commission->rate}}</td>
                  <td>
                    @if($commission->type == 'p')
                    {{__('Percentage')}}
                    @else 
                    {{-- $commission->type == 'f' --}}
                    {{__('Fix Amount')}}
                    @endif
                  </td>
                  <td>
                    <form action="{{ route('commission.quick.update',$commission->id) }}" method="POST">
                      {{csrf_field()}}
                      <button type="submit"
                        class="btn btn-rounded  {{ $commission->status==1 ? "btn-success" : "btn-danger" }}">
                        {{ $commission->status ==1 ? __('Active') : __('Deactive') }}
                      </button>
                    </form>
                  </td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                          class="feather icon-more-vertical-"></i></button>
                      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">

                        <a class="dropdown-item" href="{{url('admin/commission/'.$commission->id.'/edit')}}"><i
                            class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>

                        <a class="dropdown-item btn btn-link" data-toggle="modal"
                          data-target="#delete{{ $commission->id }}">
                          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                        </a>

                      </div>
                    </div>
                    <div class="modal fade bd-example-modal-sm" id="delete{{$commission->id}}" tabindex="-1"
                      role="dialog" aria-hidden="true">
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
                            <form method="post" action="{{url('admin/commission/'.$commission->id)}}"
                              class="pull-right">
                              {{csrf_field()}}
                              {{method_field("DELETE")}}
                              <button type="reset" class="btn btn-secondary"
                                data-dismiss="modal">{{ __("No") }}</button>
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
          <!-- /.box-body -->
        </div>
      </div>



    </div>

    @foreach($commissions as $commission)
    <div id="{{ $commission->id }}cm" class="delete-modal modal fade" role="dialog">
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
              {{__("Do you really want to delete this commission? This process cannot be undone.")}}
            </p>
          </div>
          <div class="modal-footer">

            <form method="post" action="{{url('admin/commission/'.$commission->id)}}" class="pull-right">
              {{csrf_field()}}
              {{method_field("DELETE")}}



              <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
              <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endforeach

<!-- /page content -->
@endsection