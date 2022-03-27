@extends("admin.layouts.sellermastersoyuz")
@section('title',__("Edit Product Variant"))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Edit Product Variant ') }}
@endslot
@slot('menu1')
   {{ __('Edit Product Variant ') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a  href="{{ route('seller.add.var',$vars->products->id) }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot

@endcomponent

<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title"> {{__('Edit Product Variant For')}} <b>{{ $vars->products->name }}</b></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.updt.var',$vars->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-edit mr-2"></i>{{ __('Edit Variant') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-database mr-2"></i>
                            {{ __('Edit Pricing & Weight') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab-line" data-toggle="tab" href="#contact-line" role="tab" aria-controls="contact-line" aria-selected="false"><i class="feather icon-trending-up mr-2"></i>
                            {{ __('Manage Stock') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="image-tab-line" data-toggle="tab" href="#image-line" role="tab" aria-controls="image-line" aria-selected="false"><i class="feather icon-image mr-2"></i>{{ __('Edit Images') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="defaultTabContentLine">
                        @php
                        $pro = App\Product::where('id',$vars->pro_id)->first();
                        $row = App\AddSubVariant::withTrashed()->where('pro_id',$vars->pro_id)->get();
                        @endphp


                        <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                            @foreach($pro->variants as $key => $var)
                            <br>
    
    
                            <div class="card border border">
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
                                            value="{{ $value }}" type="radio" name="main_attr_value[{{$var->attr_name}}]"
                                            id="ch{{$key+3}}">
    
                                        @push('script')
                                            <script>
                                                var newId = @json($key + 3);
                                                $('#' + newId).prop('checked', true);
                                            </script>
                                        @endpush
    
                                        @if(strcasecmp($nameofvalue->unit_value, $nameofvalue->values) !=0)
    
                                        @if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name ==
                                        "Colour")
    
                                       
                                        <i title="{{ $nameofvalue->values }}" style="color: {{ $nameofvalue->unit_value }}" class="border border-primary shadow-sm rounded p-1 fa fa-circle"></i>
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
    
                                    @if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name == "Colour")
                                        
                                    <i title="{{ $nameofvalue->values }}" style="color: {{ $nameofvalue->unit_value }}" class="border border-primary shadow-sm rounded p-1 fa fa-circle"></i>
                                    
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
                                            catch(\Exception $e) {
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
     
                                <label>{{__('Set Default')}}: <input {{ $vars->def ==1 ? "checked" : "" }} type="checkbox" name="def"></label>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                            
                                <div >
                                    <label for="">{{ __('Edit Additional Price For This Variant') }}:</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input required placeholder="Enter Price ex 499.99" value="{{ $vars->price }}" step=0.01 type="text" class="form-control editprice"  name="price" >
                                        </div>
                                    </div>
                                    <small >{{ __('Please enter Price In Positive or Negative') }}
                                    </small>
                                   
                                    <div class="row">
                                        <div class="col-md-7">
                                            <p class="p-3 mb-2 bg-primary-rgba text-primary mt-2">
                                                <b> {{__('Ex.')}} </b>
                                                {{__('If for this product price is 100 and you enter +10 than price will be 110')}}
                                                <br> {{__("OR")}} <br>
                                                {{__('If for this product price is 100 and you enter -10 than price will be 90')}}
                                            </p>
                                        </div>
                                    </div>
                                       
                                   
                                   
                                </div>
                                <div>
                                    <label for="weight">{{ __('Weight') }}:</label>
                                    <div class="row">
                                       
                                        <div class="col-md-4">
                                            
                                            <input type="text" step=0.01 name="weight" class="form-control editprice"
                                            value="{{ $vars->weight }}" placeholder="0.00" >
                                        </div>
                                        <div class="col-md-4">
                                            <select name="w_unit" class="select2 form-control">
                                                <option value="">
                                                    {{__('Please Choose')}}
                                                </option>
                                                @php
                                                $unit = App\Unit::find(1);
                                                @endphp
                                                @if(isset($unit))
                                                @foreach($unit->unitvalues as $unitVal)
                                                <option {{ $vars->w_unit == $unitVal->id ? "selected"  :"" }}
                                                    value="{{ $unitVal->id }}">{{ $unitVal->short_code ? ucfirst($unitVal->short_code) : '' }}
                                                    ({{ $unitVal->unit_values }})</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                        <div class="tab-pane fade" id="contact-line" role="tabpanel" aria-labelledby="contact-tab-line">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{__("Edit Stock")}}: <small><b>[ {{__("Current Stock")}}: {{ $vars->stock }}</b>
                                                ]</small></label>
                                        <input data-placement="bottom" id="stock" data-toggle="popover" data-trigger="focus"
                                            data-title="Need help?"
                                            data-content="
                                            {{__("It will add stock in existing stock. For example you enter 10 and existing stock is 20 than total stock will be 30.") }}"
                                            type="text" value="" name="stock" class="form-control">
        
                                    </div>
                                </div>
        
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{ __('Edit Min Order Qty') }}:</label>
                                        <input type="text" value="{{ $vars->min_order_qty }}" name="min_order_qty"
                                            class="form-control">
                                    </div>
                                </div>
        
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{__("Edit Max Order Qty")}}:</label>
                                        <input type="text" value="{{ $vars->max_order_qty }}" name="max_order_qty"
                                            class="form-control">
                                    </div>
                                </div>
        
                             </div>
                        </div>
                        <div class="tab-pane fade bg-primary-rgba shadow-sm" id="image-line" role="tabpanel" aria-labelledby="image-tab-line">
                            <div class="row ml-1">
                                <div class="col-md-3">
                                    <div class="card mt-2 p-3 text-center">
                                        @if($vars->variantimages && $vars->variantimages['image1'])
                                        <img class="mx-auto d-block" id="preview1"  align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image1']) }}" alt="">
                                        @else
                                        <img class="mx-auto d-block" id="preview1" align="center"
                                            width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                                        @endif
                                    
                                        <h6 class="mt-2">{{ __("Image 1") }}</h6>
                                    <div class="card-footer">
                                        <div class="input-group mb-3">
                                            
                                            <div class="custom-file">
                                              <input name="image1"  type="file" name="chooseFile" id="image1"class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                              <label class="custom-file-label" for="inputGroupFile01"></label>
                                            </div>
                                          </div>
                                      
                                        @if($vars->variantimages && $vars->variantimages['image1'] != null)
        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single"
                                                    value="{{ $vars->variantimages['image1'] }}" title="{{ __("Delete this?") }}"
                                                    class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image1'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>

                                            <div class="col-md-12">
                                                <button disabled="disabled" id="btn-dis1"
                                                    title="{{ __('You cannot delete Default Image') }}"
                                                    class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image1'] == $vars->variantimages['main_image'] ? "" : 'd-none' }}"
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
                                        <img class="mx-auto d-block" id="preview2" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image2']) }}" alt="">
                                        @else
                                        <img class="mx-auto d-block" id="preview2" align="center"
                                            width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                                        @endif

                                        <h6 class="mt-2">{{ __('Image 2') }}</h6>
                                        <div class="card-footer">
                                            <div class="input-group mb-3">
                                                
                                                <div class="custom-file">
                                                <input name="image2"  type="file" name="chooseFile" id="image2"class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01"></label>
                                                </div>
                                            </div>
                                        
                                            @if($vars->variantimages && $vars->variantimages['image2'] != null)


                                            <div class="row">
    
                                                <div class="col-md-12">
                                                    <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single2"
                                                        value="{{ $vars->variantimages['image2'] }}" title="Delete this?"
                                                        class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image2'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>
    
                                                <div class="col-md-12">
                                                    <button id="btn-dis2" disabled="disabled"
                                                        title="You cannot delete Default Image"
                                                        class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image2'] == $vars->variantimages['main_image'] ? '' : 'd-none' }}"
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
                                        <img class="mx-auto d-block" id="preview3" align="center" width="150" height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image3']) }}" alt="">
                                        @else
                                        
                                        <img id="preview3" align="center" width="150" height="150"
                                            src="{{ url('images/imagechoosebg.png') }}" alt=""
                                            class="mx-auto d-block">
                                        @endif

                                        <h6 class="mt-2">{{ __('Image 3') }}</h6>
                                        <div class="card-footer">
                                            <div class="input-group mb-3">
                                                
                                                <div class="custom-file">
                                                <input name="image3"  type="file" name="chooseFile" id="image3"class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01"></label>
                                                </div>
                                            </div>
                                        
                                            @if($vars->variantimages && $vars->variantimages['image3'] != null)
                                            <div class="row">
    
                                                <div class="col-md-12">
                                                    <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single3"
                                                        value="{{ $vars->variantimages['image3'] }}" title="{{ __('Delete this?') }}"
                                                        class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image3'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>
    
                                                <div class="col-md-12">
                                                    <button id="btn-dis3" disabled="disabled"
                                                        title="{{ __('You cannot delete Default Image !') }}"
                                                        class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image3'] == $vars->variantimages['main_image'] ? '' : 'd-none' }}"
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
                                    <img class="mx-auto d-block" id="preview4" align="center" width="150"
                                        height="150"
                                        src="{{ url('variantimages/'.$vars->variantimages['image4']) }}" alt="">
                                    @else
                                    <img id="preview4" align="center" width="150" height="150"
                                        src="{{ url('images/imagechoosebg.png') }}" alt=""
                                        class="mx-auto d-block">
                                    @endif

                                    <h6 class="mt-2">{{ __('Image 4') }}</h6>
                                    <div class="card-footer">
                                        <div class="input-group mb-3">
                                            
                                            <div class="custom-file">
                                            <input name="image4"  type="file" name="chooseFile" id="image4"class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01"></label>
                                            </div>
                                        </div>
                                    
                                        @if($vars->variantimages && $vars->variantimages['image4'] != null)



                                        <div class="row">

                                            <div class="col-md-12">
                                                <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single4"
                                                    value="{{ $vars->variantimages['image4'] }}" title="{{  __('Delete this?')}}"
                                                    class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image4'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>

                                            <div class="col-md-12">
                                                <button id="btn-dis4" disabled="disabled"
                                                    title="{{ __('You cannot delete Default Image !') }}"
                                                    class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image4'] == $vars->variantimages['main_image'] ? "" : 'd-none' }}"
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
                                            <img class="mx-auto d-block" id="preview5" align="center" width="150"
                                                height="150"
                                                src="{{ url('variantimages/'.$vars->variantimages['image5']) }}" alt="">
                                            @else
                                            <img id="preview5" align="center" width="150" height="150"
                                                src="{{ url('images/imagechoosebg.png') }}" alt=""
                                                class="mx-auto d-block">
                                            @endif


                                            <h6 class="mt-2">
                                                {{ __('Image 5') }}
                                            </h6>
                                    <div class="card-footer">
                                        <div class="input-group mb-3">
                                            
                                            <div class="custom-file">
                                            <input name="image5"  type="file" name="chooseFile" id="image5"class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01"></label>
                                            </div>
                                        </div>
                                    
                                        @if($vars->variantimages && $vars->variantimages['image5'] != null)



                                        <div class="row">

                                            <div class="col-md-12">
                                                <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single5"
                                                    value="{{ $vars->variantimages['image5'] }}" title="Delete this?"
                                                    class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image5'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                    type="button">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </div>

                                            <div class="col-md-12">
                                                <button id="btn-dis5" disabled="disabled"
                                                    title="{{ __('You cannot delete Default Image !') }}"
                                                    class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image5'] == $vars->variantimages['main_image'] ? '' : 'd-none' }}"
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
                                        <img class="mx-auto d-block" id="preview6" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image6']) }}" alt="">
                                        @else
                                        <img id="preview6" align="center" width="150" height="150"
                                            src="{{ url('images/imagechoosebg.png') }}" alt=""
                                            class="mx-auto d-block">
                                        @endif

                                        <h6 class="mt-2">
                                            {{__('Image 6')}}
                                        </h6>
                                        <div class="card-footer">
                                            <div class="input-group mb-3">
                                                
                                                <div class="custom-file">
                                                <input name="image6"  type="file" name="chooseFile" id="image6"class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01"></label>
                                                </div>
                                            </div>
                                        
                                            @if($vars->variantimages && $vars->variantimages['image6'] != null)

                                            @if($vars->variantimages['image6'] != $vars->variantimages['image2'])

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single6"
                                                        value="{{ $vars->variantimages['image6'] }}" title="{{ __('Delete this?') }}"
                                                        class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image6'] != $vars->variantimages['main_image'] ? '' : 'd-none' }}"
                                                        type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>

                                                <div class="col-md-12">
                                                    <button id="btn-dis6" disabled="disabled"
                                                        title="{{ __('You cannot delete Default Image ') }}!"
                                                        class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image6'] == $vars->variantimages['main_image'] ? '' : 'd-none' }}"
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
                                            <label>{{ __('Select Default Image') }}: </label>
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
                    <div class=" form-group mt-3">
                        
                        <button @if(env('DEMO_LOCK')==0) type="submit" onclick="formty()" @else disabled="disabled"
                            title="{{ __('This action is disabled in demo !') }}" @endif class="float-right btn btn-primary-rgba">
                            <i class="feather icon-save"></i> {{__('Update Variant')}}
                        </button>
    
                        
                    </div>
    
                   </form>
                </div>
            </div>
        </div>
    </div>
   </div>
</div>

@endsection     
                                          
    
@section('custom-script')
<script>
    var baseUrl = @json(url('/'));
</script>
<script src="{{ url('js/sellervariant.js') }}"></script>
<script>
    var url =  @json(url('/setdef/var/image/'.$vars->id));
</script>
<script src="{{url('js/variantimage.js')}}"></script>
@endsection




                                    




                                    

                                      
                                       



                                



  
  
  
  
  
                                        




                                        




                                        

                                           
                                        




                                        




                                    


                                    
                                    
                               

                                        
                                        
                                               



                                 
                                

                                
    
    
    
    
    
    
                                       
    
    
                                            
    
    
                                       
    
                                       
                                       
                                            
                                            
                                            
                                            
            
            
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     

    
    
                                            
                                            
                                            
    
    
    
    
    
    
                        
      
                    
    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


