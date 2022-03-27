@extends('admin.layouts.sellermastersoyuz')
@section('title',__('Edit product - :product',['product' => $products->name]))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Edit Product ') }}
@endslot
@slot('menu1')
   {{ __('Products') }}
@endslot
@slot('menu1')
   {{ __('Edit Product ') }}
@endslot

@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ url('/seller/products/') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

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
          <h5 class="card-title">
            {{__('Edit product - :product',['product' => $products->name])}}
          </h5>
        </div>
        <div class="card-body">
          <div class="col-md-12 col-lg-12 col-xl-12">
            
              
            
                   
                    <div class="row">
                        <div class="col-md-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"> {{ __('Product Details') }}</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"> {{ __('Product Specifications') }}</a>
                                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{ __('FAQ\'s') }}</a>
                                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"> {{ __('Related Products') }}</a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                  @include('seller/product/tab.edit.product')
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                  @include('seller.product.tab.edit.productspec')
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                  @include('seller/product/tab.edit.faq')
                                </div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                  @include('seller/product/tab.edit.show_related')
                                </div>
                            </div>
                        </div>
                    </div> 
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                
            


          <div class="modal fade" id="taxmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalCenterTitle">
                  {{__('Product Tax Information(PTI)')}}
                </h4>
                
              </div>
        
              <div class="modal-body">
                <div id="accordion">
                  @foreach(App\TaxClass::all() as $protax)
                  <div class="card">
                    <div class="card-header" id="headingThree">
                      <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#tbl{{$protax->id}}"
                          aria-expanded="false" aria-controls="{{$protax->title}}">
                          {{$protax->title}}
                        </button>
                      </h5>
                    </div>
                    <div id="tbl{{$protax->id}}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                      <div class="card-body">
                        <table class="table table-bordered table-striped">
                          <tr>
                            <th>{{__('Tax Name')}}
                              <img src="{{(url('images/info.png'))}}" class="height-15" data-toggle="popover"
                                data-content="{{ __('You Want to Choose Tax Class Then Apply same Tax Class And Tax Rate.') }}">
                            </th>
                            <th>
                              {{__('Tax Rate')}}
                            </th>
                            <th>
                              {{__('Priority')}}
                              <img src="{{(url('images/info.png'))}}" class="height-15" data-toggle="popover" data-content="{{ __('1 Priority Is Higher Priority And All Numeric Number Is Lowest Priority, Priority Are Accept Is Numeric Number.') }}">
                            </th>
                            <th>{{ __('Based On') }} <img src="{{(url('images/info.png'))}}" class="height-15" data-toggle="popover"
                                data-content="{{ __('You Want To Choose Billing address Then Billing Address And Zone Address Are Same Then Tax Will Be Applied, And You Will Be Choose Store Address then Store Addrss And User Billing Address Is Same Then Tax Will Be Apply.') }}">
                            </th>
                            <th>{{ __('Zone Details') }}<img src="{{(url('images/info.png'))}}" class="height-15" data-toggle="popover"
                                data-content="{{ __('You Want To Choose Billing address Then Billing Address And Zone Address Are Same Then Tax Will Be Applied,And You Will Be Choose Store Address then Store Addrss And User Billing Address Is Same Then Tax Will Be Apply.') }}">
                            </th>
                          </tr>
                          @if(isset($protax->priority))
        
                          @foreach($protax->priority as $k=> $taxRate)
        
                          @if(isset($protax->taxRate_id[$taxRate]))
                          <?php  $taxs = App\Tax::where('id',$protax->taxRate_id[$taxRate])->first();?>
                         
                          @isset($taxs)
                              <tr>
                                <td>
                                  
                                  {{$taxs->name}}
                                </td>
                                <td>@if($taxs->type=='f'){{$taxs->rate}}{{'%'}}@else{{$taxs->rate}}@endif</td>
                                <td>{{$taxRate}}</td>
                                <td>{{$protax->based_on[$taxRate]}}</td>
                                <td>
                                  <?php $zone = App\Zone::where('id',$taxs->zone_id)->first();?>
                                  @if(!empty($zone))
                                  {{$zone->state_id=='0'?'All Zone':$zone->title}}
                                  @endif
                                </td>
                              </tr>
                          @endisset
        
                          @endif
        
                          @endforeach
        
                          @endif
                        </table>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
        
            </div>
          </div>
        </div>
        <!-- Nav tabs -->
        
        <!-- Modal -->
        <div data-backdrop="static" data-keyboard='false' class="modal fade" id="relProModal" tabindex="-1" role="dialog"
          aria-labelledby="myModalLabel">
          <div class="modal-dialog model-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('Add Related Product for')}} <b>{{ $products->name }}</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
              
              </div>
              <div class="modal-body">
        
                <form action="{{ route('rel.store',$products->id) }}" method="POST">
                  @csrf
                  <label>{{__('Choose Products:')}} <span class="required">*</span></label>
                  <select class="js-example-basic-single" multiple="multiple" name="related_pro[]">
                    @foreach($products->subcategory->products as $pro)
                    @if($products->id != $pro->id)
                    <option @if(isset($products->relproduct->related_pro)) @foreach($products->relproduct->related_pro as $c)
                      {{$c == $pro->id ? 'selected' : ''}}
                      @endforeach @endif value="{{ $pro->id }}">{{ $pro->name }}</option>
                    @endif
                    @endforeach
                  </select>
        
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="feather icon-x-circle mr-1"></i> Close</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle mr-1"></i>
            {{ __("Save changes")}}</button>
               
                </form>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Bulk Delete Modal -->
        <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="delete-icon"></div>
              </div>
              <div class="modal-body text-center">
                <h4 class="modal-heading">
                  {{__('Are You Sure ?')}}
                </h4>
                <p>
                  {{__('Do you really want to delete these products? This process cannot be undone.')}}
                </p>
              </div>
              <div class="modal-footer">
                <form id="bulk_delete_form" method="post" action="{{ route('pro.specs.delete',$products->id) }}">
                  @csrf
                  {{ method_field('DELETE') }}
                  <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">
                    {{__('No')}}
                  </button>
                  <button type="submit" class="btn btn-danger">
                    {{__('Yes')}}
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>



                
                        
@yield('tab-modal-area')

@endsection                  
