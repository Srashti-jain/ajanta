@extends('admin.layouts.sellermastersoyuz')
@section('title', __('Commission Setting'))
@section('body')

@component('seller.components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Commission Setting') }}
@endslot
@slot('menu1')
   {{ __('Account Management') }}
@endslot
@slot('menu2')
   {{ __('Commission Setting') }}
@endslot



@endcomponent

<div class="contentbar">
              
            
  
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Commission Setting  (Applied by admin)') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered">
                 <thead>
                   <tr>
                    <th>{{ __("ID") }}</th>
                    <th> {{__("Category")}} </th>
                    <th> {{__("Rate")}} </th>
                    <th> {{__("Amount Type")}} </th>
                    <th> {{__("Commision Type")}} </th>
                   </tr>
                  
                 </thead>
     
                 <tbody>
                  @foreach($commissions as $key => $commission)
                  @if($commission->type=='flat')
                  <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{$commission->category->title ?? __('All')}}</td>
                  
                   <td>{{$commission->rate ?? ''}}</td>
                  <td> 
                    @if($commission->p_type == 'p')
								      {{__('Percentage')}}
					         @else($commission->p_type == 'f')
                      {{__('Fix Amount')}}
                   
						        @endif
    							</td>
                  <td>
                    @if($commission->type == 'c')
                          {{__('Category')}}
                      @else
                          {{__('Flat For All')}}
                    @endif
                  </td>
                  
                  </tr>
                  @else
                  @foreach(App\Commission::get() as $key => $commission)
                  
                  <tr>
                  <td>{{$key + 1}}</td>
                  <td>{{$commission->category->title ?? ''}}</td>
                  
                  <td>{{$commission->rate ?? ''}}</td>
                  <td> 
                    @if($commission->type == 'p')
                      {{__('Percentage')}}
                   @else
                      {{ __('Fix Amount') }}
                    
                    @endif
                  </td>
                  <td>
                    @if($commission->type == 'flat')
                         {{ __('Flat For All') }}
                      @else
                          {{ __('Category') }}
                    @endif
                  </td>
                  
                  </tr>
                  
                  @endforeach
                  @endif
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
@endsection
