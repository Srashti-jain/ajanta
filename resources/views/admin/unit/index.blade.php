@extends('admin.layouts.master-soyuz')
@section('title',__('All Units |'))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('All Unitss') }}
@endslot
@slot('menu1')
   {{ __('All Units') }}
@endslot


@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
      @can('users.create')
      <a data-target="#addunit" data-toggle="modal" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>
      {{__('Add unit')}}
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
                <h5 class="card-title">{{ __('All Units') }}</h5>
              </div>
              <div class="card-body">
               
                  <div class="table-responsive">
                    <table  id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>
                            {{__("Unit Type")}}
                          </th>
                          <th>
                            {{__("Manage Values")}}
                          </th>
                          <th>
                            {{__("Action")}}
                          </th>
                        </tr>
                      </thead>
          
                      <tbody>
                       
                          @foreach(App\Unit::all() as $key=> $unit)
                           <tr>
                          <td>{{$key+1}}</td>
                          <td>{{ $unit->title }}</td>
                          <td width="60%">
                            
                            <p>
                              @isset($unit->unitvalues)
                                @foreach($unit->unitvalues as $uv)
                                  <b>{{ $uv->unit_values }}</b>: {{ $uv->short_code }},
                                @endforeach
                              @endisset
                            </p>
                            @if($unit->title != 'Color' && $unit->title != 'Colour' && $unit->title != 'colour' && $unit->title != 'color')
                              <a href="{{ route('unit.values',$unit->id) }}">
                                {{__("Manage Values")}}
                              </a>
                            @endif
                          </td>
          
                          <td>
                            <a data-target="#edit{{ $unit->id }}" data-toggle="modal" class="btn btn-sm btn-primary-rgba">
                              <i class="feather icon-edit-2"></i>
                            </a>
          
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
</div>
               
                
                  
                  
              

@foreach(App\Unit::all() as $key=> $unit)
<!-- Modal -->
          <div class="modal fade" id="edit{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">{{__("Edit")}} {{ $unit->title }}</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 
                </div>
                <div class="modal-body">
                     <div class="row">
                       <div class="col-md-12">
                         <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/unit/'.$unit->id)}}" >
                      {{csrf_field()}}
                        {{ method_field('PUT') }}
                      
                        <div class="form-group">
                          <label for="">{{ __("Edit Title:") }}</label>
                          <input type="text" name="title" class="form-control" value="{{ $unit->title }}">
                        </div>

                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                          {{ __("Update")}}</button>
                        

                      </form>  
                       </div>
                     </div>
                </div>
               
              </div>
            </div>
          </div>
      @endforeach
  

  <!-- Modal -->
    <div class="modal fade" id="addunit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">
              {{__("Add Unit")}}
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           
          </div>

          <div class="modal-body">

              <form method="post" enctype="multipart/form-data" action="{{url('admin/unit')}}">
                {{csrf_field()}}

              <div class="form-group">
                
                <label>
                  {{__("Title:")}} <span class="required">*</span>
                </label>
                
                <input type="text" name="title" class="form-control">
              </div>

                <div class="form-group">
                <label for="first-name">
                  {{ __('Status:') }}
                </label>
                <br>
                <label class="switch">
                  <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="status">
                  <span class="knob"></span>
                </label>
              </div>
          
              <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Create")}}</button>
              
      
            </form>

          </div>
          
        </div>
      </div>
    </div>
@endsection     
                    