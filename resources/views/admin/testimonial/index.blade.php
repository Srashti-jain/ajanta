@extends('admin.layouts.master-soyuz')
@section('title',__('Testimonials'))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Testimonials') }}
@endslot
@slot('menu1')
   {{ __('Testimonials') }}
@endslot


@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
     
      <a href=" {{url('admin/testimonial/create')}}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __('Add Testimonial ') }}</a>
     
      
    </div>
</div>
@endslot

@endcomponent

<div class="contentbar">   

  <div class="row">
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-header">
              <h5 class="card-title"> {{__("Testimonal")}}</h5>
            </div>
            <div class="card-body">
             
                <div class="table-responsive">
                  <table  id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr class="table-heading-row">
                        <th>
                          {{__("ID")}}
                        </th>
                        <th>
                          {{__("Name")}}
                        </th>
                        <th>
                          {{__("Feedback")}}
                        </th>
                        <th>
                          {{__("Designation")}}
                        </th>
                        <th>
                          {{__("Image")}}
                        </th>
                        <th>
                          {{__("Rating")}}
                        </th>
                        <th>
                          {{__("Status")}}
                        </th>
                        <th>
                          {{__("Action")}}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1;?>
                      @foreach($clients as $clint)
            
                      <tr>
                        <td>{{$i++}}</td>
                        <td width="10%">{{$clint->name}}</td>
                        <td>{{strip_tags($clint->des)}}</td>
                        <td>{{$clint->post}}</td>
                        <td><img src="{{url('images/testimonial/'.$clint->image)}}" class="testimonal_image"></td>
                        <td >{{$clint->rating}}</td>
                        <td>
                          @can('testimonials.edit')
                          <form action="{{ route('clint.quick.update',$clint->id) }}" method="POST">
                            {{csrf_field()}}
                            <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled="disabled"
                              title="{{ __("This operation is disabled in demo") }}" @endif
                              class="btn btn-rounded {{ $clint->status==1 ? "btn-success-rgba" : "btn-danger-rgba" }}">
                              {{ $clint->status ==1 ? 'Active' : 'Deactive' }}
                            </button>
                          </form>
                          @endcan
                        </td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                              
                              @can('testimonials.edit')
                                <a class="dropdown-item"  href="{{url('admin/testimonial/'.$clint->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit User")}}</a>
                              @endcan
                          
                              @can('testimonials.delete')
                                <a class="dropdown-item"  @if(env('DEMO_LOCK')==0) data-toggle="modal" data-target="#cli_{{$clint->id}}" @else
                                  disabled="disabled" title="{{ __("This operation is disabled in demo") }}" @endif ><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                @endcan
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
  
     
                
                 
                  
                
                 
                  
              

        
@can('testimonials.delete')
@foreach($clients as $clint)
<div id="cli_{{$clint->id}}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
        <p>Do you really want to delete this testimonial? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">

        <form method="post" action="{{url('admin/testimonial/'.$clint->id)}}" class="pull-right">
          {{csrf_field()}}
          {{method_field("DELETE")}}

          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
          <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endcan
@endsection     