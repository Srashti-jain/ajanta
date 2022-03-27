@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Product Variant | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Edit Product Variant') }}
@endslot
@slot('menu2')
{{ __("Edit Product Variant") }}
@endslot

@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
        <a href="{{ route('add.var',$vars->products->id) }}" class="btn btn-primary-rgba">
            <i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}
        </a>
    </div>
</div>
@endslot

@endcomponent
<div class="contentbar">
    <div class="row">
       

        <!-- row started -->
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
                @php
                $pro = App\Product::where('id',$vars->pro_id)->first();
                $row = App\AddSubVariant::withTrashed()->where('pro_id',$vars->pro_id)->get();
                @endphp
                <div class="card-header">
                    <h5 class="card-box"> {{__("Edit Product Variant For")}} <b>{{ $vars->products->name }}</b></h5>
                </div>
                
                <!-- card body started -->
                <div class="card-body">
                    <form action="{{ route('updt.var',$vars->id) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <ul class="custom-tab-line nav nav-tabs mb-3" id="defaultTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#facebook" role="tab"
                                    aria-controls="home" aria-selected="true">{{ __('Edit Variant') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#google" role="tab"
                                    aria-controls="profile" aria-selected="false">{{ __('Pricing & Weight') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#twitter" role="tab"
                                    aria-controls="profile" aria-selected="false">{{ __('Manage Stock') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#linkedin" role="tab"
                                    aria-controls="profile" aria-selected="false">{{ __('Edit Images') }}</a>
                            </li>
                        </ul>
                    <div class="tab-content" id="defaultTabContent">


                        <div class="tab-pane fade show active" id="facebook" role="tabpanel" aria-labelledby="home-tab">
                            @foreach($pro->variants as $key => $var)
                            
                            <div class="mt-2 card border shadow-sm">
                                <div class="card-header bg-primary-rgba">
                                    <input child_id="{{$key+3}}" class="hasCheck" type="checkbox" name="main_attr_id[]"
                                        id="{{$key+3}}" value="{{ $var->attr_name }}">
                                    @php
                                    $k = '_';
                                    @endphp
                                    @if (strpos($var->getattrname->attr_name, $k) == false)

                                    {{ $var->getattrname->attr_name }}

                                    @else

                                    {{str_replace('_', ' ', $var->getattrname->attr_name)}}

                                    @endif
                                </div>





                                <div class="card-body">
                                    
                                    

                                    @foreach($var->attr_value as $a => $value)
                                    @php
                                    $nameofvalue = App\ProductValues::where('id','=',$value)->first();
                                    @endphp
                                    <label class="d-inline">

                                        <?php
                                        try
                                            {
                                                $x = $vars->main_attr_value[$var->attr_name];
                                                if($x == $value)
                                                {
                                                    ?>



                                        <input class="a" onload="test('{{ $var->attr_name }}')" checked="checked"
                                            value="{{ $value }}" type="radio"
                                            name="main_attr_value[{{$var->attr_name}}]" id="ch{{$key+3}}">

                                        @push('script')
                                        <script type="text/javascript">
                                            var newId = {{$key}} + 3;
                                            $('#' + newId).prop('checked', true);
                                        </script>
                                        @endpush

                                        @if(strcasecmp($nameofvalue->unit_value, $nameofvalue->values) !=0)

                                        @if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name ==
                                        "Colour")

                                        

                                        <i title="{{ $nameofvalue->values }}"
                                            style="color: {{ $nameofvalue->unit_value }}"
                                            class="border border-primary shadow-sm rounded p-1 fa fa-circle"></i>
                                        <span class="tx-color">{{ $nameofvalue->values }}</span>








                                        @else
                                        {{ $nameofvalue->values }}{{ $nameofvalue->unit_value }}
                                        @endif
                                        @else
                                        {{ $nameofvalue->values }}
                                        @endif


                                    </label>
                                    <?php
                                                    
                                                }
                                                else
                                                {
                                                    ?>

                                    <input class="b" value="{{ $value }}" type="radio"
                                        name="main_attr_value[{{$var->attr_name}}]" id="ch2{{ $key+3 }}{{$a}}">

                                    @if(strcasecmp($nameofvalue->unit_value, $nameofvalue->values) !=0)

                                    @if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name ==
                                    "Colour")

                                   

                                    <i title="{{ $nameofvalue->values }}" style="color: {{ $nameofvalue->unit_value }}"
                                        class="border border-primary shadow-sm rounded p-1 fa fa-circle"></i>

                                    <span class="tx-color">{{ $nameofvalue->values }}</span>
                                    @else
                                    {{ $nameofvalue->values }}{{ $nameofvalue->unit_value }}
                                    @endif
                                    @else
                                    {{ $nameofvalue->values }}
                                    @endif
                                    <?php
                                            }
                                            
                                        }
                                        catch(exception $e) {
                                            ?>

                                    <input class="c" value="{{ $value }}" type="radio"
                                        name="main_attr_value[{{$var->attr_name}}]" id="ch3{{ $key+3 }}{{$a}}">

                                    {{$nameofvalue->values}}{{ $nameofvalue->unit_value }}



                                    </label>
                                    <?php

                                        }

                                    
                                ?>

                                    @endforeach




                                </div>



                            </div>



                            @endforeach

                            <div class="col-md-12 mt-3 form-group">

                                <label>{{__('Set Default:')}} <input {{ $vars->def ==1 ? "checked" : "" }} type="checkbox"
                                        name="def"></label>
                            </div>

                           
                        </div>

                        <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="">
                                            {{__('Edit Additional Price For This Variant :')}}
                                        </label>
                                        <input required placeholder="Enter Price ex 499.99"
                                            type="number" value="{{ $vars->price  }}" step="0.01" class="form-control"
                                            name="price">
                                        <small class="help-block">
                                            {{ __("Please enter Price In Positive or Negative or zero") }}<br></small>
                                        <!-- ------------------------------------ -->
                                        <div class="card bg-success-rgba m-b-30">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-12">
                                                        <h5 class="card-title text-primary mb-1"><i
                                                                class="feather icon-alert-circle"></i> {{ __('Ex. :') }}
                                                        </h5>
                                                        <p class="mb-0 text-primary font-14">{{ __("If you enter +10 and product price is 100 than price will be 110") }}<br> {{__('OR')}} <br>{{__("If you enter -10 and product price is 100 than price will be 90")}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--------------------------------------  -->
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-dark" for="weight">
                                            {{__('Weight:')}}
                                        </label>
                                        <input type="number" step=0.01 name="weight" class="form-control"
                                            value="{{ $vars->weight }}" placeholder="0.00">
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
                                            <option {{ $vars->w_unit == $unitVal->id ? "selected"  :"" }}
                                                value="{{ $unitVal->id }}">{{ ucfirst($unitVal->short_code) }}
                                                ({{ $unitVal->unit_values }})</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <!-- === frontstatic form end ===========-->
                        </div>
                        <!-- === frontstatic end ======== -->

                        <!-- === adminstatic start ======== -->
                        <div class="tab-pane fade" id="twitter" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- === adminstatic form start ======== -->
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-dark" for=""> {{__("Edit Stock:")}} <small><b>[ {{__("Current Stock:")}}
                                                    {{ $vars->stock }}</b>
                                                ]</small></label>
                                        <input data-placement="bottom" id="stock" data-toggle="popover"
                                            data-trigger="focus" data-title="{{ __("Need help?") }}"
                                            data-content="{{ __('It will add stock in existing stock. For example you enter 10 and existing stock is 20 than total stock will be 30.') }}"
                                            type="text" value="" name="stock" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-dark" for="">{{__("Edit Min Order Qty")}}:</label>
                                        <input type="text" value="{{ $vars->min_order_qty }}" name="min_order_qty"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-dark" for="">{{__("Edit Max Order Qty")}}:</label>
                                        <input type="text" value="{{ $vars->max_order_qty }}" name="max_order_qty"
                                            class="form-control">
                                    </div>
                                </div>

                            </div>
                            <!-- === adminstatic form end ===========-->
                        </div>
                        <!-- === adminstatic end ======== -->

                        <!-- === flashmsg start ======== -->
                        <div class="tab-pane fade" id="linkedin" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- === flashmsg form start ======== -->

                            <br>
                            <div class="alert alert-warning">
                                <p><i class="fa fa-info-circle" aria-hidden="true"></i> {{__("Important")}}</p>

                                <ul>
                                    <li>
                                        {{__("Altleast two variant image is required !")}}
                                    </li>
                                    <li>{{__("Default image will be")}} <b><i>Image 1</i></b> {{ __("later you can change default image in edit variant section") }}</li>
                                </ul>
                            </div>

                            <div class="row ml-1">
                                <div class="col-md-3">
                                    <div class="card mt-2 p-3 text-center">
                                        @if($vars->variantimages && $vars->variantimages['image1'])
                                        <img class="object-fit mx-auto" id="preview1" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image1']) }}" alt="">
                                        @else
                                        <img class="object-fit mx-auto" id="preview1" align="center"
                                            width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                                        @endif
                                    
                                        <h6 class="mt-2">Image 1</h6>
                                    <div class="card-footer">
                                        <div class="input-group mb-3">
                                            
                                            <div class="custom-file">
                                              <input name="image1" type="file" id="image1" class="custom-file-input"  aria-describedby="inputGroupFileAddon01">
                                              <label class="custom-file-label" for="inputGroupFile01"></label>
                                            </div>
                                          </div>
                                      
                                        @if($vars->variantimages && $vars->variantimages['image1'] != null)
        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single"
                                                    value="{{ $vars->variantimages['image1'] }}" title="{{  __('Delete this?') }}"
                                                    class="btn btn-sm btn-block btn-danger-rgba btn-ema {{ $vars->variantimages['image1'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>

                                            <div class="col-md-12">
                                                <button disabled="disabled" id="btn-dis1"
                                                    title="{{ __("You cannot delete Default Image") }}"
                                                    class="btn btn-sm btn-block btn-danger-rgba btn-ema {{ $vars->variantimages['image1'] == $vars->variantimages['main_image'] ? "" : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    </div>
                                   
                                    
                                       
                                </div>
                        
                        
                                <div class="col-md-3 ">
                                   <div class="card mt-2 p-3 text-center">
                        
                                        @if($vars->variantimages && $vars->variantimages['image2'])
                                        <img class="mx-auto object-fit" id="preview2" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image2']) }}" alt="">
                                        @else
                                        <img class="mx-auto object-fit" id="preview2" align="center"
                                            width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                                        @endif

                                        <h6 class="mt-2">Image 2</h6>
                                        <div class="card-footer">
                                            <div class="input-group mb-3">
                                                
                                                <div class="custom-file">
                                                <input name="image2" type="file" id="image2" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01"></label>
                                                </div>
                                            </div>
                                        
                                            @if($vars->variantimages && $vars->variantimages['image2'] != null)


                                            <div class="row">
    
                                                <div class="col-md-12">
                                                    <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single2"
                                                        value="{{ $vars->variantimages['image2'] }}" title="{{  __('Delete this?') }}"
                                                        class="btn btn-sm btn-block btn-danger-rgba btn-ema {{ $vars->variantimages['image2'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>
    
                                                <div class="col-md-12">
                                                    <button id="btn-dis2" disabled="disabled"
                                                        title="You cannot delete Default Image"
                                                        class="btn btn-sm btn-block btn-danger-rgba {{ $vars->variantimages['image2'] == $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>
    
                                            </div>
    
                                            @endif
                                        </div>
                                    </div> 
                                </div>
                                
                                
                                <div class="col-md-3 ">
                                    <div class="card mt-2  p-3 text-center">
                                        @if($vars->variantimages && $vars->variantimages['image3'])
                                        <img class="mx-auto object-fit" id="preview3" align="center" width="150" height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image3']) }}" alt="">
                                        @else
                                        
                                        <img id="preview3" align="center" width="150" height="150"
                                            src="{{ url('images/imagechoosebg.png') }}" alt=""
                                            class="mx-auto object-fit">
                                        @endif

                                        <h6 class="mt-2">Image 3</h6>
                                        <div class="card-footer">
                                            <div class="input-group mb-3">
                                                
                                                <div class="custom-file">
                                                <input name="image3" type="file" id="image3" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01"></label>
                                                </div>
                                            </div>
                                        
                                            @if($vars->variantimages && $vars->variantimages['image3'] != null)
                                            <div class="row">
    
                                                <div class="col-md-12">
                                                    <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single3"
                                                        value="{{ $vars->variantimages['image3'] }}" title="{{  __('Delete this?') }}"
                                                        class="btn btn-sm btn-block btn-danger-rgba btn-ema {{ $vars->variantimages['image3'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>
    
                                                <div class="col-md-12">
                                                    <button id="btn-dis3" disabled="disabled"
                                                        title="{{  __('You cannot delete Default Image !') }}"
                                                        class="btn btn-sm btn-block btn-danger-rgba {{ $vars->variantimages['image3'] == $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
    
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                           

                                <div class="col-md-3">
                                    <div class=" card mt-2 mr-3 p-3 text-center">
                                    @if($vars->variantimages && $vars->variantimages['image4'])
                                    <img class="mx-auto object-fit" id="preview4" align="center" width="150"
                                        height="150"
                                        src="{{ url('variantimages/'.$vars->variantimages['image4']) }}" alt="">
                                    @else
                                    <img id="preview4" align="center" width="150" height="150"
                                        src="{{ url('images/imagechoosebg.png') }}" alt=""
                                        class="mx-auto object-fit">
                                    @endif

                                    <h6 class="mt-2">Image 4</h6>
                                    <div class="card-footer">
                                        <div class="input-group mb-3">
                                            
                                            <div class="custom-file">
                                            <input name="image4" type="file" id="image4" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01"></label>
                                            </div>
                                        </div>
                                    
                                        @if($vars->variantimages && $vars->variantimages['image4'] != null)



                                        <div class="row">

                                            <div class="col-md-12">
                                                <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single4"
                                                    value="{{ $vars->variantimages['image4'] }}" title="{{  __('Delete this?') }}"
                                                    class="btn btn-sm btn-block btn-danger-rgba btn-ema {{ $vars->variantimages['image4'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>

                                            <div class="col-md-12">
                                                <button id="btn-dis4" disabled="disabled"
                                                    title="{{ __("You cannot delete Default Image !") }}"
                                                    class="btn btn-sm btn-block btn-danger-rgba {{ $vars->variantimages['image4'] == $vars->variantimages['main_image'] ? "" : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>

                                        </div>
                                        @endif

                                       </div>
                                    </div> 
                                </div>
                                

                                <div class="col-md-3">
                                    <div class="card mt-2 p-3 text-center">
                               


                                            @if($vars->variantimages && $vars->variantimages['image5'])
                                            <img class="mx-auto object-fit" id="preview5" align="center" width="150"
                                                height="150"
                                                src="{{ url('variantimages/'.$vars->variantimages['image5']) }}" alt="">
                                            @else
                                            <img id="preview5" align="center" width="150" height="150"
                                                src="{{ url('images/imagechoosebg.png') }}" alt=""
                                                class="mx-auto object-fit">
                                            @endif


                                            <h6 class="mt-2">Image 5</h6>
                                    <div class="card-footer">
                                        <div class="input-group mb-3">
                                            
                                            <div class="custom-file">
                                            <input name="image5"  type="file" id="image5" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01"></label>
                                            </div>
                                        </div>
                                    
                                        @if($vars->variantimages && $vars->variantimages['image5'] != null)



                                        <div class="row">

                                            <div class="col-md-12">
                                                <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single5"
                                                    value="{{ $vars->variantimages['image5'] }}" title="{{ __("Delete this?") }}"
                                                    class="btn btn-sm btn-block btn-danger-rgba btn-ema {{ $vars->variantimages['image5'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>

                                            <div class="col-md-12">
                                                <button id="btn-dis5" disabled="disabled"
                                                    title="{{ __("You cannot delete Default Image !") }}"
                                                    class="btn btn-sm btn-block btn-danger-rgba {{ $vars->variantimages['image5'] == $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>
                                        </div>





                                        @endif


                                       

                                    </div>
                                 </div>

                                </div>

                                <div class="col-md-3 ">
                                  
                                    <div class="card mt-2  p-3 text-center">
                                        @if($vars->variantimages && $vars->variantimages['image6'])
                                        <img class="mx-auto object-fit" id="preview6" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image6']) }}" alt="">
                                        @else
                                        <img id="preview6" align="center" width="150" height="150"
                                            src="{{ url('images/imagechoosebg.png') }}" alt=""
                                            class="mx-auto object-fit">
                                        @endif

                                        <h6 class="mt-2">Image 6</h6>
                                        <div class="card-footer">
                                            <div class="input-group mb-3">
                                                
                                                <div class="custom-file">
                                                <input name="image6"  type="file" id="image6" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01"></label>
                                                </div>
                                            </div>
                                        
                                            @if($vars->variantimages && $vars->variantimages['image6'] != null)

                                            @if($vars->variantimages['image6'] != $vars->variantimages['image2'])

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single6"
                                                        value="{{ $vars->variantimages['image6'] }}" title="{{  __('Delete this?') }}"
                                                        class="btn btn-sm btn-block btn-danger-rgba btn-ema {{ $vars->variantimages['image6'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>

                                                <div class="col-md-12">
                                                    <button id="btn-dis6" disabled="disabled"
                                                        title="{{  __('You cannot delete Default Image !') }}"
                                                        class="btn btn-sm btn-block btn-danger-rgba {{ $vars->variantimages['image6'] == $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>
                                            </div>



                                            @endif

                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                   
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>{{__("Select Default Image:")}} </label>
                                            <select name="defimage" id="defimage" class="form-control select2">

                                                @if($vars->variantimages && $vars->variantimages['image1'] != null)
                                                <option
                                                    {{ $vars->variantimages['image1'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                    value="{{ $vars->variantimages['image1'] }}">Image 1</option>
                                                @endif

                                                @if($vars->variantimages && $vars->variantimages['image2'] != null)
                                                <option
                                                    {{ $vars->variantimages['image2'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                    value="{{ $vars->variantimages['image2'] }}">Image 2</option>
                                                @endif

                                                @if($vars->variantimages && $vars->variantimages['image3'] != null)
                                                <option
                                                    {{ $vars->variantimages['image3'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                    value="{{ $vars->variantimages['image3'] }}">Image 3</option>
                                                @endif

                                                @if($vars->variantimages && $vars->variantimages['image4'] != null)
                                                <option
                                                    {{ $vars->variantimages['image4'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                    value="{{ $vars->variantimages['image4'] }}">Image 4</option>
                                                @endif

                                                @if($vars->variantimages && $vars->variantimages['image5'] != null)
                                                <option
                                                    {{ $vars->variantimages['image5'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                    value="{{ $vars->variantimages['image5'] }}">Image 5</option>
                                                @endif

                                                @if($vars->variantimages && $vars->variantimages['image6'] != null)
                                                <option
                                                    {{ $vars->variantimages['image6'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                    value="{{ $vars->variantimages['image6'] }}">Image 6</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>



                                </div>

            
            

                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled=""
                            title="{{ __("This action is disabled in demo !") }}" @endif
                            class="pull-right btn btn-md btn-primary-rgba"><i class="feather icon-save"></i>
                            {{__("Update variant")}}
                        </button>
                    </div>


                    </form>
                </div>

            </div>
        </div>
        <!-- === flashmsg form end ===========-->
    </div>
    <!-- === flashmsg end ======== -->

</div>
</div><!-- card body end -->

</div><!-- col end -->
</div>
</div>
</div><!-- row end -->
<br><br>
@endsection
@section('custom-script')
<script>
    var baseUrl = @json(url('/'));
</script>
<script src="{{ url('js/variant.js') }}"></script>
<script>
    var url = @json(url('/setdef/var/image/'.$vars->id));
</script>
<script src="{{url('js/variantimage.js')}}"></script>
@endsection