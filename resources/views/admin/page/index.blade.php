@extends('admin.layouts.master-soyuz')
@section('title',__('All Pages | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Pages') }}
@endslot
@slot('menu1')
{{ __("Pages") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  @can('pages.create')
  <a href="{{url('admin/page/create')}}" class=" btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Page') }}</a>
  @endcan
  </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">
  <div class="row">
   
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Pages') }}</h5>
        </div>
        <div class="card-body">
               
          <div class="table-responsive">
            <table  id="datatable-buttons" class="table table-striped table-bordered">
             <thead>
               <tr>
                 <th>{{ __('ID') }}</th>
                 <th>{{ __('Page Name') }}</th>
                 <th>{{ __('Description') }}</th>
                 <th>{{ __('Slug') }}</th>
                 <th>{{ __('Status') }}</th>
                 <th>{{ __('Action') }}</th>
                </tr>
               </thead>

               <tbody>
                   @foreach($pages as $key => $page)
                  
                       <tr>
                       <td>{{ $key + 1 }}</td>
                       <td>{{$page->name}}</td>
                       <td>{{substr(strip_tags($page->des), 0, 70)}}{{strlen(strip_tags($page->des))>70 ? '...' : ""}}</td>
                       <td>{{$page->slug}}</td>
                       <td>
                           <form action="{{ route('page.quick.update',$page->id) }}" method="POST">
                             {{ csrf_field() }}
                             <button type="Submit" class="btn btn-rounded {{ $page->status ==1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                               @if($page->status ==1)
                               {{ __('Active') }}
                               @else
                               {{ __('Deactive') }}
                               @endif
                             </button>
                           </form>
                       </td>
                      
                       <td>
                           <div class="dropdown">
                               <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                               <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                   @can('pages.edit')
                                   <a class="dropdown-item" href="{{url('admin/page/'.$page->id.'/edit')}} "><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                                   @endcan
                                   @can('pages.delete')
                                   <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $page->id }}" >
                                       <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                   @endcan
                               </div>
                           </div>
​
                           <!-- delete Modal start -->
                           <div class="modal fade bd-example-modal-sm" id="delete{{ $page->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                               <p>{{ __('Do you really want to delete')}} <b>{{$page->name}}</b> ? {{ __('This process cannot be undone.')}}</p>
                                       </div>
                                       <div class="modal-footer">
                                           <form method="post" action="{{url('admin/page/'.$page->id)}}" class="pull-right">
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
  </div>
</div>
@endsection
              
                       