@extends('admin.layouts.master-soyuz')
@section('title',__('Add Product Variant | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Add Product Variant') }}
@endslot
@slot('menu2')
{{ __("Add Product Variant") }}
@endslot

@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{ route('add.var',$findpro->id) }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
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
              <h5 class="card-box">{{__("Add Product Variant For")}} <b>{{ $findpro->name }}</b></h5>
          </div> 
         
          <form enctype="multipart/form-data" action="{{ route('manage.stock.post',$findpro->id) }}" method="POST">
            {{ csrf_field() }}
            <div class="card-body">
              <ul class="nav custom-tab-line nav-tabs mb-3" id="defaultTab" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#facebook" role="tab" aria-controls="home" aria-selected="true">{{ __('Add Variant') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="profile" aria-selected="false">{{ __('Pricing & Weight') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#twitter" role="tab" aria-controls="profile" aria-selected="false">{{ __('Inventory') }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#linkedin" role="tab" aria-controls="profile" aria-selected="false">{{ __('Variant Images') }}</a>
                      </li>
              </ul>
              <div class="tab-content" id="defaultTabContent">

                 
                  <div class="tab-pane fade show active" id="facebook" role="tabpanel" aria-labelledby="home-tab">
                    <div class="box box-info">
                      <div class="box-header with-border">
                        <div class="card-title">
                          <h5>
                            {{__("Add Stock")}}
                          </h5>
                        </div>
                      </div>
              
                      <div class="card-body">
                        
                        <div class="row">
                          <div class="col-md-2">
                            <label>
                              {{__('Product Attributes:')}}
                            </label>
                          </div>
              
                        
                          <div class="col-md-10">
                            @foreach($findpro->variants as $key=> $var)
              
                          <div class="mt-2 card border shadow-sm">
                            <div class="card-header bg-primary-rgba">
                              <label>
                                <input required class="categories" type="checkbox" name="main_attr_id[]" id="categories_{{ $var->attr_name }}" child_id="{{$key}}" value="{{ $var->attr_name }}">
                                
                                        @php
                                            $key = '_'; 
                                        @endphp
                                        @if (strpos($var->getattrname->attr_name, $key) == false)
                                        
                                          {{ $var->getattrname->attr_name }}
                                           
                                        @else
                                          
                                          {{str_replace('_', ' ', $var->getattrname->attr_name)}}
                                          
                                        @endif
                            </label>
                            </div>
              
                          <div class="card-body">

                      
                            
                            @foreach($var->attr_value as $a => $value)
                            @php
                              $nameofvalue = App\ProductValues::where('id','=',$value)->first();
                            @endphp
                              <label>
                                <input required class="a a_{{ $var->attr_name }}" parents_id="{{ $var->attr_name }}" value="{{ $value }}" type="radio" name="main_attr_value[{{$var->attr_name}}]" id="{{ $key }}">
                
                                  @if(strcasecmp($nameofvalue->unit_value, $nameofvalue->values) != 0)
                
                                    @if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name == "Colour")
                                          
                                          <div class="numberCircle">
                                            <li class="dotremove" title="{{ $nameofvalue->values }}"><a href="#" title=""><i style="color: {{ $nameofvalue->unit_value }}" class="fa fa-circle"></i></a>
                                          </div>
                                          <span class="mr-3">{{ $nameofvalue->values }}</span>
                                               
                                        
                                    @else
                                    {{ $nameofvalue->values }}{{ $nameofvalue->unit_value }}
                                    @endif
                                  @else
                                    {{ $nameofvalue->values }}
                                  @endif
                
                              
                              </label>
                              @endforeach
                            </div>
                          </div>
                          @endforeach


                            <div>
                              <label class="mt-3">
                                {{__("Set default variant :")}} 
                                <input type="checkbox" name="def">
                              </label>
                            </div>
                           
                          </div>
                           
                        </div>
                        
              
                        
                      </div>
                    </div>   
                  </div>
                  
                  <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="profile-tab">
                      <!-- === frontstatic form start ======== -->

                      <div class="row">

                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="text-dark" for="">
                                    {{__("Additional Price For This Variant :")}}
                                  </label>
                                  <input required value="{{ old('price') }}" placeholder="{{ __("Enter Price ex 499.99") }}" type="number" step=0.01 class="form-control" name="price">
                                  <small class="help-block">{{ __("Please enter Price In Positive or Negative or zero") }}<br></small>
                                  <!-- ------------------------------------ -->
                                  <div class="card bg-success-rgba m-b-30">
                                    <div class="card-body">
                                      <div class="row align-items-center">
                                        <div class="col-12">
                                          <h5 class="card-title text-primary mb-1"><i class="feather icon-alert-circle"></i> {{ __('Ex. :') }}</h5>
                                          <p class="mb-0 text-primary font-14"><b>Ex. </b>{{ __("If you enter +10 and product price is 100 than price will be 110") }}<br> {{__('OR')}} <br>{{ __('If you enter -10 and product price is 100 than price will be 90') }}</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!--------------------------------------  -->
                                </div>
                          </div>

                          <div class="col-md-3">
                          <div class="form-group">
                              <label class="text-dark" for="weight">Weight:</label>
                              <input type="number" step=0.01 name="weight" class="form-control" value="0.00" placeholder="0.00">
                          </div>
                          </div>

                          <div class="col-md-3">
                          <div class="form-group">
                              <label class="text-dark" for="weight"></label>
                              <select name="w_unit" class="select2 form-control">
                                <option value="">{{ __("Please Choose") }}</option>
                                @php
                                  $unit = App\Unit::find(1);
                                @endphp
                                @if(isset($unit))
                                  @foreach($unit->unitvalues as $unitVal)
                                      <option value="{{ $unitVal->id }}">{{ ucfirst($unitVal->short_code) }} ({{ $unitVal->unit_values }})</option>
                                  @endforeach
                                @endif
                              </select>
                          </div>
                          </div>

                      </div>

                      <!-- === frontstatic form end ===========-->
                  </div>
                  
                  <div class="tab-pane fade" id="twitter" role="tabpanel" aria-labelledby="profile-tab">
                      <!-- === adminstatic form start ======== -->
                      <br>
                      <div class="row">
                          <div class="col-md-4">
                          <div class="form-group">
                            <label class="text-dark" for="">
                              {{__("Add Stock:")}}
                            </label>
                            <input required min="1" type="number" class="form-control" name="stock" placeholder="Enter stock" value="{{ old('stock') }}" >
                          </div>
                          </div>

                          <div class="col-md-4">
                          <div class="form-group">
                            <label class="text-dark" for="">
                              {{__("Min Qty:")}}
                            </label>
                            <input required value="{{ old('min_order_qty')  }}" min="1" type="number" class="form-control" name="min_order_qty" placeholder="{{ __("Enter Min Qty For order") }}">
                          </div>
                          </div>

                          <div class="col-md-4">
                          <div class="form-group">
                            <label class="text-dark" for="">
                              {{__("Max Qty:")}}
                            </label>
                            <input value="{{ old('max_order_qty') }}" min="1" type="number" class="form-control" name="max_order_qty" placeholder="{{ __('Enter Max Qty For order') }}">
                          </div>
                          </div>

                        </div>
                      <!-- === adminstatic form end ===========-->
                  </div>
                 
                  <div class="tab-pane fade" id="linkedin" role="tabpanel" aria-labelledby="profile-tab">
                      <!-- === flashmsg form start ======== -->
                     
                      <br>
                        <div class="alert alert-info">
                            <p><i class="fa fa-info-circle" aria-hidden="true"></i> {{ __("Important") }}</p>

                            <ul>
                                <li>
                                  {{__("Altleast two variant image is required !")}}
                                </li>
                                <li>{{__('Default image will be')}} <b><i>Image 1</i></b> {{ __("later you can change default image in edit variant section") }}</li>
                            </ul>
                        </div>	

                        <div class="row">

                          <div class="col-md-4 text-center">
                            <div class="card">
                              <label class="padding-one">Image 1</label>
                              <div class="card-body">
                                <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                                  height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                              </div>
                              <div class="card-footer">
                                <div class="input-group mb-3">
                                  <div class="custom-file">
                                    <input type="file" name="image1" required=""
                                      class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
        
        
        
        
                          <div class="col-md-4 text-center">
                            <div class="card">
                              <label class="padding-one">Image 2</label>
                              <div class="card-body">
                                <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                                  height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                              </div>
        
                              <div class="card-footer">
                                <div class="input-group mb-3">
                                  <div class="custom-file">
                                    <input type="file" name="image2" required=""
                                      class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                                  </div>
                                </div>
                              </div>
        
                            </div>
                          </div>
                          <div class="col-md-4 text-center">
                            <div class="card">
                              <label class="padding-one">Image 3</label>
                              <div class="card-body">
                                <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                                  height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                              </div>
        
                              <div class="card-footer">
                                <div class="input-group mb-3">
                                  <div class="custom-file">
                                    <input type="file" name="image3"
                                      class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                                  </div>
                                </div>
                              </div>
        
                            </div>
                          </div>
                          <div class="col-md-4 text-center">
                            <div class="card">
                              <label class="padding-one">Image 4</label>
                              <div class="card-body">
                                <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                                  height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                              </div>
        
                              <div class="card-footer">
                                <div class="input-group mb-3">
                                  <div class="custom-file">
                                    <input type="file" name="image4"
                                      class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                                  </div>
                                </div>
        
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4 text-center">
                            <div class="card">
                              <label class="padding-one">Image 5</label>
                              <div class="card-body">
                                <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                                  height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                              </div>
        
                              <div class="card-footer">
                                <div class="input-group mb-3">
                                  <div class="custom-file">
                                    <input type="file" name="image5"
                                      class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                                  </div>
                                </div>
        
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4 text-center">
                            <div class="card">
                              <label class="padding-one">Image 6</label>
                              <div class="card-body">
                                <img class="test1 margin-bottom-10 bg-secondary-rgba" id="preview1" align="center" width="150"
                                  height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                              </div>
        
                              <div class="card-footer">
                                <div class="input-group mb-3">
                                  <div class="custom-file">
                                    <input type="file" name="image6"
                                      class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                                  </div>
                                </div>
        
                              </div>
                            </div>
                          </div>
        
        
        
        
        
                        </div>
                    </div>

                  </div>

                  <div class="col-md-12 mb-2">
                    <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="{{ __("This action is disabled in demo !") }}" @endif class="pull-right btn btn-md btn-primary-rgba mb-2"><i class="feather icon-plus mr-2"></i> {{ __('Add Variant') }}</button>
                  </div>
    
              </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>
               

       
   
@endsection
@section('custom-script')
	<script src="{{ url('js/subvar.js') }}"></script>
@endsection