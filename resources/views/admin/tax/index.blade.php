@extends('admin.layouts.master-soyuz')
@section('title',__('Tax rates | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Tax rates') }}
@endslot
@slot('menu1')
   {{ __('Tax rates') }}
@endslot


@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
     
      <a href=" {{url('admin/tax/create')}} " class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add new tax rate") }}</a>
     
      
    </div>
</div>
@endslot

@endcomponent

<div class="contentbar">   

  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                
                    <h5 class="card-title"> {{__("Tax rates")}}</h5>
                 
                  
                
                 
                  
              </div>
              
              <div class="card-body">
               
                  <div class="table-responsive">
                    <table  id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                          <th>
                            {{__("ID")}}
                          </th>
                          <th>
                            {{__("Tax Name")}}
                          </th>
                          <th>
                            {{__("Zone")}}
                          </th>
                          <th>
                            {{__("Rate")}}
                          </th>
                          <th>
                            {{__("Type")}}
                          </th>
                          <th>
                            {{__("Action")}}
                          </th>
                      </thead>
                      <tbody>
                        @foreach($taxs as $key => $tax)
              
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$tax->name}}</td>
                          <td>
              
                            @php
                            $zonename = App\Zone::where('id','=',$tax->zone_id)->first();
                            @endphp
              
                            {{ $zonename ? $zonename->title : 'No Zone Found !' }}
                          </td>
                          <td>{{$tax->rate}}</td>
                          <td>
                            @if($tax->type == 'p')
                            {{__('Percentage')}}
                            @else($tax->type == 'f')
                            {{__('Fix Amount')}}
                            @endif
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                
                               
                                  <a class="dropdown-item"   href=" {{url('admin/tax/'.$tax->id.'/edit')}} " ><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                               
                            
                                
                                  <a class="dropdown-item" @if(env('DEMO_LOCK') == 0) data-toggle="modal" data-target="#tax_{{$tax->id}}" @else disabled=""
                                    title="{{ __("This action is disabled in demo !") }}" @endif><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                  
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

        
@foreach($taxs as $tax)
<div id="tax_{{ $tax->id }}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
        <p>{{ __("Do you really want to delete this Tax? This process cannot be undone.") }}</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{url('admin/tax/'.$tax->id)}}" class="pull-right">
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
@endsection     
                        
  
                    
    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


