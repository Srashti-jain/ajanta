@extends('admin.layouts.master-soyuz')
@section('title',__('All FAQ'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('All Faq') }}
@endslot

@slot('menu1')
{{ __('Faq') }}
@endslot

@slot('button')

<div class="col-md-6">
  <div class="widgetbar">
    @can('faq.create')
    <a href=" {{url('admin/faq/create')}} " class="btn btn-primary-rgba mr-2">
      <i class="feather icon-plus mr-2"></i> {{__("Add Faq")}}
    </a>
    @endcan
  </div>
</div>
@endslot
@endcomponent
<div class="contentbar">
  <div class="row">

    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title"> {{__("Add Faq")}}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="full_detail_table" class="width100 table table-bordered table-striped">
              <thead>
                <tr class="table-heading-row">
                  <th>{{ __("ID") }}</th>
                  <th>{{ __('Question') }}</th>
                  <th>{{ __('Answer') }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($faqs as $key => $faq)

                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$faq->que}}</td>
                  <td>{{substr(strip_tags($faq->ans), 0, 250)}}{{strlen(strip_tags(
                $faq->ans))>250 ? '...' : ""}}</td>
                  <td>
                    <form action="{{ route('faq.quick.update',$faq->id) }}" method="POST">
                      {{csrf_field()}}
                      <button type="submit"
                        class="btn btn-rounded {{ $faq->status==1 ? "btn-success-rgba" : "btn-danger-rgba" }}">
                        {{ $faq->status ==1 ? __('Active') : __('Deactive') }}
                      </button>
                    </form>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                          class="feather icon-more-vertical-"></i></button>
                      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                        @can('faq.edit')
                        <a class="dropdown-item" href="{{url('admin/faq/'.$faq->id.'/edit')}}"><i
                            class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                        @endcan

                        @can('faq.delete')
                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $faq->id }}">
                          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                        </a>
                        @endcan
                      </div>
                    </div>
                    <div class="modal fade bd-example-modal-sm" id="delete{{$faq->id}}" tabindex="-1" role="dialog"
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
                            <form method="post" action="{{url('admin/faq/'.$faq->id)}}" class="pull-right">
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
</div>

@endsection