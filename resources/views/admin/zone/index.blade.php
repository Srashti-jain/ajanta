@extends('admin.layouts.master-soyuz')
@section('title',__('All Zones | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('All Zones') }}
@endslot
@slot('menu1')
   {{ __('All Zones') }}
@endslot


@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
      @can('users.create')
      <a href=" {{url('admin/zone/create')}}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __('Add a new zone') }}</a>
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
               
                    <h5 class="card-title">{{ __('All Zones') }}</h5>
                
                  
                  
              </div>
              
              <div class="card-body">
               
                  <div class="table-responsive">
                    <table  id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>
                            {{__("ID")}}
                          </th>
                          <th>
                            {{__("Name")}}
                          </th>
                          <th>
                            {{__("Country")}}
                          </th>
                          <th>
                            {{__("Zone Name")}}
                          </th>
                          <th>
                            {{__("Code")}}
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
                        
                        @foreach($zones as $key => $zone)
                
                        <tr>
                          <td class="text-dark">{{$key+1}}</td>
                          <td>{{$zone->title}}</td>
                          <td>{{$zone->country->name}}</td>
                          <td class="width30">
                
                            @if(is_array($zone->name))
                
                            @php
                            $state = App\Allstate::whereIn('id',$zone->name)->get();
                            @endphp
                            <?php $zcount =  count($state); $i = 0;?>
                            @foreach($state as $s)
                            <?php $i++;?>
                
                            @if($i<$zcount) {{ $s->name }}, @else {{ $s->name }} @endif @endforeach @endif </td> <td>{{$zone->code}}
                          </td>
                          <td>
                            @if($zone->status=='1')
                            <p class="badge badge-success">{{'Yes'}} </p> 
                            @else
                            <p class="badge badge-danger">{{'No'}} </p> 
                            @endif
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                
                               
                                  <a class="dropdown-item"  href="{{url('admin/zone/'.$zone->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit User")}}</a>
                              
                            
                                  <form method="post" action="{{url('admin/zone/'.$zone->id)}}" >
                                    {{csrf_field()}}
                                    {{method_field("DELETE")}}
                                    <button class="dropdown-item" @if(env('DEMO_LOCK')==0) type="submit" @else disabled=""
                                      title="{{ __("This action is disabled in demo !") }}" @endif class="abc">
                                      <i class="fa fa-trash mr-2"></i> {{__("Delete")}}
                                  </button>
                                  </form>
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
    <!-- End col -->
</div>

@endsection     
                        
  
                    
    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


