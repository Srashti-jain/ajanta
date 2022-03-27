@extends('admin.layouts.sellermastersoyuz')
@section('title',__('Edit Product - :product',['product' => $product->product_name]))
@section('stylesheet')
<link rel="stylesheet" href="{{ url("/css/lightbox.min.css") }}">
@endsection
@section('body')

@component('seller.components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Edit Product') }}
@endslot
@slot('menu1')
   {{ __('Simple Product') }}
@endslot
@slot('menu1')
   {{ __('Edit Product') }}
@endslot

@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('simple-products.index') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

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
            <h5 class="card-title">{{ __('Edit Product - :product',['product' => $product->product_name]) }}</h5>
          </div>
          <div class="card-body">
            <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-grid mr-2"></i>{{ __("Product Details") }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-layers mr-2"></i>{{ __("Manage Inventory") }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab-line" data-toggle="tab" href="#contact-line" role="tab" aria-controls="contact-line" aria-selected="false"><i class="feather icon-settings mr-2"></i>{{ __("Cashback Settings") }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="spectification-tab-line" data-toggle="tab" href="#spectification-line" role="tab" aria-controls="spectification-line" aria-selected="false"><i class="feather icon-book-open mr-2"></i>{{ __("Product Specifications") }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="image-tab-line" data-toggle="tab" href="#image-line" role="tab" aria-controls="image-line" aria-selected="false"><i class="feather icon-image mr-2"></i>{{ __("360° Image") }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="product-tab-line" data-toggle="tab" href="#product-line" role="tab" aria-controls="product-line" aria-selected="false"><i class="feather icon-plus-circle mr-2"></i>{{ __("Product FAQ's") }}</a>
                </li>
               
            </ul>
            <div class="tab-content" id="defaultTabContentLine">
                <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                    <form action="{{ route("simple-products.update",$product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                        
                                <div class="col-md-9">
                                
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __("Product Name: ") }}<span class="required">*</span></label>
                                                <input placeholder="{{ __("Enter product name") }}" required type="text"
                                                    value="{{ $product->product_name }}" class="form-control"
                                                    name="product_name">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    {{__("Product Brand:")}} <span class="required">*</span>
                                                </label>
                                                <select data-placeholder="{{ __("Please select brand") }}" required="" name="brand_id"
                                                    class="select2 form-control">
                                                    <option value="">{{ __("Please Select") }}</option>
                                                    @if(!empty($brands_all))
                                                        @foreach($brands_all as $brand)
                                                            <option {{$product['brand_id'] == $brand['id'] ? "selected" : "" }}
                                                                value="{{$brand->id}}">
                                                                {{$brand->name}} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    {{__('Product Store:')}} <span class="required">*</span>
                                                </label>
                                                <select data-placeholder="Please select store" required="" name="store_id"
                                                    class="form-control select2">
                
                                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label> {{__('Key Features :')}}
                                                </label>
                                                <textarea class="form-control editor" name="key_features">{!! $product->key_features !!}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{__('Product Description:')}} <span class="required">*</span></label>
                                                <textarea placeholder="{{ __("Enter product details") }}" class="editor"
                                                    name="product_detail" id="product_detail" cols="30"
                                                    rows="10">{{ $product->product_detail }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('Product Category:')}} <span class="required">*</span></label>
                                                <select data-placeholder="{{ __("Please select category") }}"
                                                    name="category_id" id="category_id" class="form-control select2">
                                                    <option value="">{{ __("Please select category") }}</option>
                                                    @foreach($categories as $category)
                                                    <option {{ $product->category_id == $category->id ? "selected" : "" }}
                                                        value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('Product Subategory:')}} <span class="required">*</span></label>
                                                <select data-placeholder="{{ __('Please select subcategory') }}" required=""
                                                    name="subcategory_id" id="upload_id" class="form-control select2">
                                                    <option value="">{{ __('Please Select') }}</option>
                                                    @foreach($product->category->subcategory as $item)
                                                    <option {{ $item->id == $product->subcategory_id ? "selected" : "" }}
                                                        value="{{ $item->id }}">{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    {{__("Childcategory:")}}
                                                </label>
                                                <select data-placeholder="{{ __('Please select childcategory') }}" name="child_id"
                                                    id="grand" class="form-control select2">
                                                    <option value="">{{ __('Please choose') }}</option>
                                                    @foreach($product->subcategory->childcategory as $item)
                                                    <option {{ $item->id == $product->child_id ? "selected" : "" }}
                                                        value="{{ $item->id }}">{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __("Also in :") }}</label>
                                                <select multiple="multiple" name="other_cats[]" id="other_cats" class="form-control select2">
                                                    @foreach($categories->where('id','!=',$product->category_id) as $category)
                                                        <option {{ $product->other_cats != '' && in_array($category->id,$product->other_cats) ? "selected" : "" }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
            
                                                <small class="text-primary">
                                                    <i class="feather icon-help-circle"></i> {{ __("If in list primary category is also present then it will auto remove from this after create product.") }}
                                                </small>
                                            </div>   
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ __('Product Tags:') }}</label>
                                                <input placeholder="{{ __("Enter product tags by comma") }}" type="text"
                                                    class="form-control" name="product_tags"
                                                    value="{{ $product->product_tags }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark">{{ __('Select Size chart : ') }} </label>
                                                <select name="size_chart" class="form-control select2">
                                                    <option value="NULL">{{ __('None') }}</option>
                                                    @foreach ($template_size_chart as $chartoption)
                                                        <option {{ $product->size_chart == $chartoption->id ? "selected" : "" }} value="{{ $chartoption->id }}">{{ $chartoption->template_name }} ({{ $chartoption->template_code }}) </option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                
                                            <div class="form-group">
                                                <label>
                                                    {{ __("Product tag") }} in ({{ app()->getLocale() }}) :
                                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{ __("It will show in front end in rounded circle with product thumbnail") }}"></i>
                                                </label>
                                        
                                                <input type="text" value="{{ $product->sale_tag }}" class="form-control" name="sale_tag" placeholder="Exclusive">
                                            </div>
                                            
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    {{ __("Product tag text color") }} :
                                                </label>
                                                <div class="input-group initial-color" title="Using input value">
                                                    <input type="text" class="form-control input-lg" value="{{ $product->sale_tag_text_color }}" name="sale_tag_text_color" placeholder="#000000"/>
                                                    <span class="input-group-append">
                                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                                    </span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>
                                                    {{ __("Product tag background color") }} :
                                                </label>
                                                <div class="input-group initial-color" title="Using input value">
                                                    <input type="text" class="form-control input-lg" value="{{ $product->sale_tag_color }}" name="sale_tag_color" placeholder="#000000"/>
                                                    <span class="input-group-append">
                                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                                    </span>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ __('Model No:') }}</label>
                                                <input placeholder="{{ __("Enter product modal name or no.") }}" type="text"
                                                    class="form-control" name="model_no" value="{{ $product->model_no }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('HSN/SAC :')}} <span class="required">*</span></label>
                                                <input required placeholder="{{ __("Enter product HSN/SAC code") }}"
                                                    type="text" class="form-control" name="hsin"
                                                    value="{{ $product->hsin }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ __('SKU :') }}</label>
                                                <input placeholder="{{ __("Enter product SKU code") }}" type="text"
                                                    class="form-control" name="sku" value="{{ $product->sku }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('Price:')}} <span class="required">*</span></label>
                                                <input min="0" placeholder="{{ __("Enter product price") }}" required
                                                    type="text" class="form-control" name="actual_selling_price"
                                                    step="0.01" value="{{ $product->actual_selling_price }}">
                                            </div>


                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('Offer Price:')}} </label>
                                                <input min="0" placeholder="{{ __("Enter product offer price") }}"
                                                    type="text" class="form-control" name="actual_offer_price" step="0.01"
                                                    value="{{ $product->actual_offer_price }}">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('Tax:')}} <span class="required">*</span> </label>
                                                <input placeholder="{{ __("Enter product tax in %") }}" required
                                                    type="text" class="form-control" name="tax" step="1"
                                                    value="{{ $product->tax }}">
                                                    <small>({{__("This tax % will add in given price.")}})</small> 
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('Tax name:')}} <span class="required">*</span></label>
                                                <input placeholder="{{ __("Enter product name") }}" required type="text"
                                                    class="form-control" name="tax_name" value="{{ $product->tax_name }}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('Product Thumbnail Image:')}} </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                    </div>
                                                    <div class="custom-file">
                                                    <input name="thumbnail" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="inputGroupFile01"></label>
                                                    </div>
                                                </div>
                                            
                                                <small class="text-muted">
                                                    <i class="fa fa-question-circle"></i>
                                                    {{__("Please select product thumbnail")}}
                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ __('Product Hover Thumbnail Image:') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                    </div>
                                                    <div class="custom-file">
                                                    <input name="hover_thumbnail" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="inputGroupFile01"></label>
                                                    </div>
                                                </div>
                                            
                                                <small class="text-muted">
                                                    <i class="fa fa-question-circle"></i>
                                                    {{__("Please select product hover thumbnail")}}
                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ __('Product Gallery Images:') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                    </div>
                                                    <div class="custom-file">
                                                    <input multiple name="images[]"  type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="inputGroupFile01"></label>
                                                    </div>
                                                </div>
                                            
                                                <small class="text-muted">
                                                    <i class="fa fa-question-circle"></i>
                                                    {{__("Multiple images can be choosen")}}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div
                                            class="{{ $product->product_file !='' ? "" : "display-none" }} product_file col-md-12">
                                            <div class="form-group">
                                                <label>{{ __('Update Downloadable Product File: ') }}<span
                                                        class="text-red">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input name="product_file" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label" for="inputGroupFile01"></label>
                                                    </div>
                                                    </div>
                                        
                                                <small class="text-muted">
                                                    <i class="fa fa-question-circle"></i> {{__("Max file size is 50 MB")}}
                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label>
                                                    {{__('Status :')}}
                                                </label>
                                                <br>
                                                <label class="switch">
                                                    <input type="checkbox" name="status"
                                                        {{ $product->status == '1' ? "checked" : "" }}>
                                                    <span class="knob"></span>
                                                </label>
                                                <br>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Toggle the product status') }}</b>.</small>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ __('Free Shipping :') }}</label>
                                                <br>
                                                <label class="switch">
                                                    <input type="checkbox" name="free_shipping"
                                                        {{ $product->free_shipping == '1' ? "checked" : "" }}>
                                                    <span class="knob"></span>
                                                </label>
                                                <br>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('Toggle to allow free shipping on product')}}.</b></small>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__("Cancel available")}} :</label>
                                                <br>
                                                <label class="switch">
                                                    <input type="checkbox" name="cancel_avbl"
                                                        {{ $product->cancel_avbl == '1' ? "checked" : "" }}>
                                                    <span class="knob"></span>
                                                </label>
                                                <br>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('Toggle to allow product cancellation on order')}}.</b></small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('Cash on delivery available')}} :</label>
                                                <br>
                                                <label class="switch">
                                                    <input type="checkbox" name="cod_avbl"
                                                        {{ $product->cod_avbl == '1' ? "checked" : "" }}>
                                                    <span class="knob"></span>
                                                </label>
                                                <br>
                                                <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('Toggle to allow COD on product')}}.</b></small>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">

                                            <label for="">{{__("Return Available")}} :</label>
                                            <select data-placeholder="Please choose an option" required=""
                                                class="form-control select2" id="choose_policy" name="return_avbl">
                                                <option value="">{{ __('Please choose an option') }}</option>
                                                <option {{ $product['return_avbl'] =='1' ? "selected" : "" }} value="1">
                                                    {{ __('Return Available') }}</option>
                                                <option {{ $product['return_avbl'] =='0' ? "selected" : "" }} value="0">
                                                    {{ __('Return Not Available') }}</option>
                                            </select>
                                            <br>
                                            <small class="text-desc">({{ __('Please choose an option that return will be available for this product or not') }})</small>


                                        </div>

                                        <div id="policy"
                                            class="{{ $product['return_avbl'] == 1 ? '' : 'display-none' }} form-group col-md-4">
                                            <label>
                                                {{__('Select Return Policy')}}: <span class="required">*</span>
                                            </label>
                                            <select data-placeholder="{{ __('Please select return policy') }}" name="policy_id"
                                                class="form-control select2">
                                                <option value="">{{ __('Please select return policy') }}</option>

                                                @foreach(App\admin_return_product::where('status','1')->get()
                                                as $policy)
                                                <option {{ $product['policy_id'] == $policy->id ? "selected" : "" }}
                                                    value="{{ $policy->id }}">{{ $policy->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                        {{ __("Update")}}</button>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="bg-primary-rgba shadow-sm text-center rounded ">
                                        <label class="mt-2">{{ __("Current product thumbnail:") }}</label>
                                        <a href="{{ url('images/simple_products/'.$product->thumbnail) }}"
                                            data-lightbox="image-1" data-title="{{ $product->thumbnail }}">
                                        <img src="{{ url('images/simple_products/'.$product->thumbnail) }}" alt="{{ $product->thumbnail }}" class="img-fluid img-thumbnail mb-2"/>
                                        </a>
                                    </div>
                                    
                                    <div class="bg-primary-rgba shadow-sm text-center mt-md-3 rounded">
                                        <label class="mt-2">{{ __("Current product hover-thumbnail:") }}</label>
                                        <a href="{{ url('images/simple_products/'.$product->hover_thumbnail) }}"
                                            data-lightbox="image-1" data-title="{{ $product->hover_thumbnail }}">
                                            <img src="{{ url('images/simple_products/'.$product->hover_thumbnail) }}"
                                                alt="{{ $product->hover_thumbnail }}" class="img-fluid img-thumbnail mb-2">
                                        </a>
                                    </div>

                                    <div class="bg-primary-rgba shadow-sm text-center mt-md-3 rounded">

                                        <label class="mt-2">{{ __("Product Gallery Images:") }}</label>
                                        <br>
                                        @forelse($product->productGallery as $gallery)
                                        
                                        <a href="{{ url('images/simple_products/gallery/'.$gallery->image) }}"
                                            data-lightbox="image-1" data-title="{{ $gallery->image }}">
                                            <img src="{{ url('images/simple_products/gallery/'.$gallery->image) }}"
                                                alt="{{ $gallery->image }}" class="img-fluid pro-img img-thumbnail mb-2">
                                        </a>
                                        <i data-imageid="{{ $gallery->id }}" class="text-danger fa fa-times stick_close_btn"></i>
                                        @empty
                                        {{__("No images in product gallery.")}}
                                        @endforelse

                                    </div>

                                    <div class="{{ $product->product_file !='' ? "" : "d-none" }} well">

                                        <label>{{ __("Current downloadable Product File:") }}</label>

                                        <p>
                                            <a href="{{ storage_path('digitalproducts/files/'.$product->product_file) }}"><i
                                                    class="fa fa-download"></i> {{ $product->product_file }}</a>
                                        </p>

                                    </div>
                                </div>
                            
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                    <h5>{{ __("Manage Inventory") }}</h5>
               
                    <form action="{{ route("manage.inventory",$product->id) }}" method="POST">
                        @csrf

                       

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __("Stock") }} <span class="text-red">*</span></label>
                                    <input class="form-control price" type="text" min="0" value="{{ $product->stock ?? old('stock') }}" name="stock">
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __("Minimum Order Qty.") }} <span class="text-red">*</span></label>
                                    <input class="form-control price" type="text" min="1" value="{{ $product->min_order_qty ?? old('min_order_qty') }}" name="min_order_qty">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __("Maxium Order Qty.") }}</label>
                                    <input class="form-control price" type="text" min="0" value="{{ $product->max_order_qty ?? old('max_order_qty') }}" name="max_order_qty">
                                </div>
                            </div>
                        </div>

                       

                        <div class="form-group">
                            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                            {{ __("Update")}}</button>
                        </div>
                        
                    </form>
                </div>
                <div class="tab-pane fade" id="contact-line" role="tabpanel" aria-labelledby="contact-tab-line">
                    <h5>{{ __("Cashback Settings") }}</h5>
                   
                    <form action="{{ route("cashback.save",$product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_type" value="simple_product">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('Enable Cashback system :') }}</label>
                                <br>
                                <label class="switch">
                                  <input id="enable" type="checkbox" name="enable"
                                    {{ isset($cashback_settings) && $cashback_settings->enable =='1' ? "checked" : "" }}>
                                  <span class="knob"></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cashback_type">{{ __("Select cashback type:") }} <span class="text-red">*</span> </label>
                                    <select data-placeholder="{{ __("Select cashback type") }}" name="cashback_type" class="form-control select2">
                                        <option value="">{{ __("Select cashback type") }}</option>
                                        <option {{ isset($cashback_settings) && $cashback_settings->cashback_type == 'fix' ? "selected" : "" }} value="fix">{{ __("Fix") }}</option>
                                        <option {{ isset($cashback_settings) && $cashback_settings->cashback_type == 'per' ? "selected" : "" }} value="per">{{ __("Percent") }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="discount_type">{{ __("Discount type:") }} <span class="text-red">*</span> </label>
                                    <select data-placeholder="{{ __("Select discount type") }}" name="discount_type" class="form-control select2">
                                        <option value="">{{ __("Select cashback type") }}</option>
                                        <option {{ isset($cashback_settings) && $cashback_settings->discount_type == 'flat' ? "selected" : "" }} value="flat">{{ __("Flat") }}</option>
                                        <option {{ isset($cashback_settings) && $cashback_settings->discount_type == 'upto' ? "selected" : "" }} value="upto">{{ __("Upto") }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="discount">{{ __("Discount:") }} <span class="text-red">*</span> </label>
                                    <input value="{{ isset($cashback_settings) ? $cashback_settings->discount : 0 }}" step="0.001" type="text" min="0" class="form-control discount2" required name="discount">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}</button>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="tab-pane fade" id="spectification-line" role="tabpanel" aria-labelledby="spectification-tab-line">
                    <h5>{{ __('Edit Product Specification') }}</h5>
                    
                    <a type="button" class="btn btn-danger btn-md z-depth-0" data-toggle="modal"
                        data-target="#bulk_delete"><i class="fa fa-trash"></i> {{ __('Delete Selected') }}</a>
                    <hr>
                    <form action="{{ route('pro.specs.store',$product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" value="yes" name="simple_product">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th>
                                    <div class="inline">
                                        <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                            value="all" />
                                        <label for="checkboxAll" class="material-checkbox"></label>
                                    </div>

                                </th>
                                <th>{{ __('Key') }}</th>
                                <th>{{ __('Value') }}</th>
                                <th>#</th>
                            </thead>

                            <tbody>
                                @if(isset($product->specs))
                                @foreach($product->specs as $spec)
                                <tr>
                                    <td>
                                        <div class="inline">
                                            <input type="checkbox" form="bulk_delete_form"
                                                class="filled-in material-checkbox-input" name="checked[]"
                                                value="{{$spec->id}}" id="checkbox{{$spec->id}}">
                                            <label for="checkbox{{$spec->id}}" class="material-checkbox"></label>
                                        </div>
                                    </td>
                                    <td>{{ $spec->prokeys }}</td>
                                    <td>{{ $spec->provalues }}</td>
                                    <td>

                                        <a data-toggle="modal" title="Edit" data-target="#edit{{ $spec->id }}"
                                            class="btn btn-primary-rgba">
                                            <i class="feather icon-edit-2"></i>
                                        </a>




                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered" id="dynamic_field">

                            <tbody>
                                <tr>
                                    <td>
                                        <input required="" name="prokeys[]" type="text" class="form-control" value=""
                                            placeholder="Product Attribute">
                                    </td>

                                    <td>
                                        <input required="" name="provalues[]" type="text" class="form-control" value=""
                                            placeholder="Attribute Value">
                                    </td>
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-xs btn-success">
                                            <i class="feather icon-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <div class="">
                            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                            {{ __("Create")}}</button>
                        </div>
                    </form>


                    @if(isset($product->specs))
                    @foreach($product->specs as $spec)
                    <div id="edit{{ $spec->id }}" class="delete-modal modal fade" role="dialog">
                        <div class="modal-dialog modal-md">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-title">{{__('Edit')}} : <b>{{ $spec->prokeys }}</b></div>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('pro.specs.update',$spec->id) }}" method="POST">
                                        @csrf
                                        

                                        <div class="form-group">
                                            <label>{{ __('Attribute Key') }}:</label>
                                            <input required="" type="text" name="pro_key" value="{{ $spec->prokeys }}"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Attribute Value') }}:</label>
                                            <input required="" type="text" name="pro_val" value="{{ $spec->provalues }}"
                                                class="form-control">
                                        </div>


                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                            {{ __('Save') }}</button>
                                        <button type="reset" class="btn btn-danger translate-y-3"
                                            data-dismiss="modal">{{ __('Cancel') }}</button>



                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif


                </div>
                <div class="tab-pane fade" id="image-line" role="tabpanel" aria-labelledby="image-tab-line">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route("upload.360",$product->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __("Upload Product 360° Image") }} <span class="text-red">*</span> </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input name="360_image[]" multiple="multiple" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
                                        <label class="custom-file-label" for="inputGroupFile01"></label>
                                        </div>
                                    </div>
                                  

                                    <small class="text-muted">
                                        {{__("You can upload 20 images at a time.")}}
                                    </small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="feather icon-download mr-2"></i> {{__("Upload")}}
                                    </button>
                                </div>
                            </form>

                           @forelse($product->frames as $key => $frame)
                                
                                <div class="bg-primary-rgba shadow-sm rounded p-2">
                                    <div class="row">

                                        <div class="col-md-2">
                                            <a href="{{ url('images/simple_products/360_images/'.$frame->image) }}" data-lightbox="image-1" data-title="{{ $frame->image }}">
                                               <img width="50px" src="{{ url('images/simple_products/360_images/'.$frame->image) }}" alt="{{ $frame->image }}" class=" img-thumbnail"/>
                                            </a>
                                        </div>

                                        <div class="col-md-8 mt-2">
                                            <b>{{$frame->image}}</b>
                                        </div>

                                        <div class="col-md-2  mt-2">
                                           <h3> <i data-imageid="{{ $frame->id }}" class="delete_image_360 text-danger feather icon-trash-2"></i></h3>
                                        </div>

                                    </div>
                                </div>

                           @empty
                           <img src="{{asset('admin_new/assets/images/noimage.jpg')}}" alt="" class="image_store">
                           @endforelse
                        </div>

                        <div class="col-md-6">
                            <label>{{__("Current Image:")}}</label>
                           
                            @if($product->frames()->count())
                                <div id='mySpriteSpin'></div>
                            @else
                                <div class="well">
                                    <h4>
                                        {{__("No preview available...")}}
                                    </h4>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="product-line" role="tabpanel" aria-labelledby="product-tab-line">
                    <div class="mb-2">
                        <a data-toggle="modal" data-target="#addFAQ" class="btn btn-success owtbtn"><i
                                class="feather icon-plus-circle mr-1"></i> {{ __('Add FAQ') }}</a>
                        <br>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Question') }}</th>
                                <th>{{ __('Answer') }}</th>
                                <th>{{  __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($product->faq as $key => $f)

                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$f->simpleproduct->product_name}}</td>
                                <td>{{ $f->question }}</td>
                                <td>{!!$f->answer!!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                            <a class="dropdown-item"  title="Edit FAQ" data-toggle="modal" data-target="#editfaq{{ $f->id }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit Product")}}</a>
                                            <a class="dropdown-item" title="Delete this FAQ?" data-toggle="modal" data-target="#faqdel_{{ $f->id }}"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                          </div>
                                    </div>
                                        
                                    
                                        
                                         
                                           
                                          
                                      
                                </td>
                               
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    @foreach($product->faq as $key => $f)
                    <div id="faqdel_{{ $f->id }}" class="delete-modal modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <div class="delete-icon"></div>
                                </div>
                                <div class="modal-body text-center">
                                    <h4 class="modal-heading">{{ __('Are You Sure ?') }}</h4>
                                    <p>{{ __('Do you really want to delete this faq? This process cannot be undone') }}.</p>
                                </div>
                                <div class="modal-footer">
                                    <form method="post" action="{{url('admin/product_faq/'.$f->id)}}"
                                        class="pull-right">
                                        {{csrf_field()}}
                                        {{method_field("DELETE")}}
                                        <button type="reset" class="btn btn-gray translate-y-3"
                                            data-dismiss="modal">{{ __('No') }}</button>
                                        <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach($product->faq as $key => $f)
                    <!-- EDIT FAQ Modal -->
                    <div class="modal fade" id="editfaq{{ $f->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">{{__('Edit FAQ')}}: {{ $f->question }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                  
                                </div>
                                <div class="modal-body">
                                    <form id="demo-form2" method="post" action="{{route('product_faq.update',$f->id)}}">
                                        {{ method_field("PUT") }}
                                        @csrf
                                        <div class="form-group">
                                            <label for="">{{__('Question')}}: <span class="required">*</span></label>
                                            <input required="" type="text" name="question" value="{{ $f->question }}"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('Answer')}}: <span class="required">*</span></label>
                                            <textarea required="" cols="10" id="answerarea" name="answer" rows="5"
                                                class="form-control editor">{{ $f->answer }}</textarea>
                                            <input type="hidden" readonly name="pro_id" value="{{ $product->id }}">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('Please enter answer for above question !')}} </small>
                                        </div>

                                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                        {{ __("Update")}}</button>


                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Create FAQ Modal -->
                    <div class="modal fade" id="addFAQ" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">{{__('Add new FAQ') }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                  
                                </div>
                                <div class="modal-body">
                                    <form id="demo-form2" method="post" action="{{url('admin/product_faq')}}">
                                        @csrf
                                        <input type="hidden" value="yes" name="simple_product">
                                        <div class="form-group">
                                            <label for="">{{ __('Question') }}: <span class="required">*</span></label>
                                            <input type="text" name="question" value="{{old('question')}}"
                                                class="form-control">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('Please write question !')}}</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{ __('Answer') }}: <span class="required">*</span></label>
                                            <textarea cols="10" id="editor1" name="answer" rows="5"
                                                class="form-control">{{old('answer')}}</textarea>
                                            <input type="hidden" readonly name="pro_id" value="{{ $product->id }}">
                                            <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('Please enter answer for above question !')}} </small>
                                        </div>

                                      
                                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                        {{ __("Create")}}</button>


                                    </form>
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

</div>
        
@endsection
@section('custom-script')
<script src='{{ url('js/lightbox.min.js') }}' type='text/javascript'></script>
<script src='//unpkg.com/spritespin@x.x.x/release/spritespin.js' type='text/javascript'></script>
<script src="//unpkg.com/axios/dist/axios.min.js"></script>
<script>

            $("#mySpriteSpin").spritespin({
            // path to the source images.
                frames : 35,
                animate : true,
                responsive : false,
                loop : false,
                orientation : 180,
                reverse : false,
                detectSubsampling : true,
                source: [
                    @if($product->frames()->count())
                        @foreach($product->frames as $frames)
                            "{{url('images/simple_products/360_images/'.$frames->image)}}",  
                        @endforeach
                    @endif  
                ],
                width   : 700,  // width in pixels of the window/frame
                height  : 600,  // height in pixels of the window/frame
            });

        $('.stick_close_btn').on('click',function(){

            var action =  confirm('Are your sure ?');

            if(action == true){
                var imageid = $(this).data('imageid');

                axios.post('{{ url("delete/gallery/image/") }}',{
                    id : imageid
                }).then(res => {

                    alert(res.data.msg);
                    location.reload();

                }).catch(err => {
                    alert(err);
                    return false;
                });
            }else{

                alert('Delete cancelled !');
                return false;

            }

        });

        $('.delete_image_360').on('click',function(){

                var action =  confirm('Are your sure ?');

                if(action == true){
                    var imageid = $(this).data('imageid');

                    axios.post('{{ route("delete.360") }}',{
                        id : imageid
                    }).then(res => {

                        alert(res.data.msg);
                        location.reload();

                    }).catch(err => {
                        alert(err);
                        return false;
                    });
                }else{

                    alert('Delete cancelled !');
                    return false;

                }

            });
    </script>
@endsection