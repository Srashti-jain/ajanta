@extends('admin.layouts.master-soyuz')
@section('title',__('All Blog Post'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Blog Post') }}
@endslot

@slot('menu1')
   {{ __('Blog') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        <a  href=" {{url('admin/blog/create')}} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2"></i> {{__("Add Blog")}}
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
                    <h5 class="box-title"> {{ __("All Blog Post") }}</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                  <thead>
                        <tr>
                          <th>{{ __("ID") }}</th>
                          <th>{{ __("Heading") }}</th>
                          <th>{{ __("Description") }}</th>
                          <th>{{ __("User") }}</th>
                          <th>{{ __('Image') }}</th>
                          <th>{{ __("Created at") }}</th>
                          <th>{{ __("Status") }}</th>
                          <th>{{ __("Action") }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1;?>
                        @foreach($blogs as $key=> $slider)
                        <tr>
                          <td>{{$i++}}</td>
                          <td>{{$slider->heading}}</td>
                          <td>{{substr(strip_tags($slider->des), 0, 50)}}{{strlen(strip_tags(
                                $slider->des))>50 ? '...' : ""}}</td>
                          <td>{{$slider->user}}</td>
                          <td> <img class="pro-img" src="{{url('images/blog/'.$slider->image)}}"></td>
                
                          <td>{{$slider->created_at}}</td>
                          <td>
                            @can('blog.edit')
                            <form action="{{ route('blog.quick.update',$slider->id) }}" method="POST">
                              {{csrf_field()}}
                              <span @if(env('DEMO_LOCK')==0) type="submit" @else disabled title="{{ __("This operation is disabled in Demo !") }}"
                                @endif class="btn btn-rounded  {{ $slider->status==1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                                {{ $slider->status ==1 ? __('Active') : __('Deactive') }}
                            </span>
                            </form>
                            @endcan
                          </td>
                          <td>
                            <div class="dropdown">
                                <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                  @can('blog.edit')
                                    <a class="dropdown-item" href="{{url('admin/blog/'.$slider->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                                    @endcan
                
                                    @can('blog.delete')
                                    <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $slider->id }}" >
                                      <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                  </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="modal fade bd-example-modal-sm" id="delete{{$slider->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("Delete") }}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                              <h4>{{ __('Are You Sure ?')}}</h4>
                                              <p>{{ __('Do you really want to delete')}}? {{ __('This process cannot be undone.')}}</p>
                                      </div>
                                      <div class="modal-footer">
                                          <form method="post" action="{{url('admin/blog/'.$slider->id)}}" class="pull-right">
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
