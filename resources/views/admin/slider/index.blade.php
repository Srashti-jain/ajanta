@extends('admin.layouts.master-soyuz')
@section('title',__('Slider |'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Sliders') }}
@endslot
@slot('menu2')
{{ __("Sliders") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/slider/create')}}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Slider') }}</a>
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
          <h5 class="box-title">{{ __('Sliders') }}</h5>
        </div>
        <div class="card-body">
         <!-- main content start -->
        <div class="table-responsive">
          <table id="datatable-buttons" class="table table-striped table-bordered">
             <thead>
               <th>{{ __('ID') }}</th>
               <th>{{ __('Slider Content') }}</th>
               <th></th>
               <th>{{ __('Status') }}</th>
               <th>{{ __('Action') }}</th>
             </thead>
             <tbody>
               @foreach($sliders as $key=> $slider)
               <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                @if($image = @file_get_contents(public_path().'/images/slider/'.$slider->image))
                <img src="{{ asset('images/slider/'.$slider->image) }}" width="150px" class="rounded object-fit" >
                @endif
                </td>
                <td>
                    <p><b>Linked To:</b> 
                    @if($slider->link_by =='cat')
                      (Category : <b>{{ $slider->category['title'] ?? 'None' }}</b>)
                    @endif
                    @if($slider->link_by == 'sub') 
                      (Subcategory: <b>{{ $slider->subcategory['title'] ?? 'None' }}</b>)
                    @endif
                    @if($slider->link_by == 'child')
                    ( Child Category: <b>{{ $slider->childcategory->title ?? 'None'}}</b>)
                    @endif
                    @if($slider->link_by == 'pro')
                      (Product: <b>{{ $slider->products['name'] ?? 'None' }}</b>)
                    @endif
                    @if($slider->link_by == 'url')
                      (URL: <b>{{ $slider->url }}</b>)
                    @endif
                    @if($slider->link_by == 'None')
                      <b>None</b>
                    @endif
                  </p>
                    @if(isset($slider->topheading))
                      <p><b>Heading Text:</b> {{ $slider->topheading }}</p>
                    @endif
                    @if(isset($slider->heading))
                      <p><b>Subheading Text:</b> {{ $slider->heading }}</p>
                    @endif
                    @if(isset($slider->buttonname))
                      <p><b>{{ __('Button Text:') }}</b> {{ $slider->buttonname }}</p>
                    @endif
                </td>
                <td>
                  <form action="{{ route('slider.quick.update',$slider->id) }}" method="POST">
                      {{csrf_field()}}
                      <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="{{ __("This cannot be done in demo !") }}" disabled="" @endif class="btn btn-rounded {{ $slider->status == 1 ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                        {{ $slider->status ==1 ? 'Active' : 'Deactive' }}
                      </button>
                  </form>
                </td>
                <td>
                   <div class="dropdown">
                       <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                       <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                          
                           <a class="dropdown-item" href="{{url('admin/slider/'.$slider->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                        
                           <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $slider->id }}" >
                               <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                           </a>
                           
                       </div>
                   </div>

                   <!-- delete Modal start -->
                   <div class="modal fade bd-example-modal-sm" id="delete{{ $slider->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                       <p>{{ __('Do you really want to delete')}} <b>{{$slider->heading}}</b> ? {{ __('This process cannot be undone.')}}</p>
                               </div>
                               <div class="modal-footer">
                                   <form method="post" action="{{url('admin/slider/'.$slider->id)}}" class="pull-right">
                                       {{csrf_field()}}
                                       {{method_field("DELETE")}}
              
                                       <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __("No") }}</button>
                                       <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </div>
                   <!-- delete Model ended -->
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
​


@endsection

<!-- css for image end -->