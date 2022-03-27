@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Product :product | ',['product' => $product->product_name]))
@section('stylesheet')
    <link rel="stylesheet" href="{{ url("/css/lightbox.min.css") }}">
@endsection
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])

    @slot('heading')
        {{ __('Edit Product') }}
    @endslot

    @slot('menu1')
        {{ __("Product") }}
    @endslot

    @slot('menu2')
        {{ __("Edit Product") }}
    @endslot

@slot('button')
    <div class="col-md-6">
        <div class="widgetbar">
            <a href="{{ route('simple-products.index') }}" class="btn btn-primary-rgba">
                <i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}
            </a>
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
                    <h5 class="box-title">{{__("Edit Product")}} {{ $product->product_name }}</h5>
                </div>
                <div class="card-body">


                    <ul class="nav custom-tab-line nav-tabs mb-3" id="defaultTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#productdetails" role="tab"
                                aria-controls="productdetails" aria-selected="true"> <i class="feather icon-edit"></i> {{ __('Product Details') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="manageinventory-tab" data-toggle="tab" href="#manageinventory"
                                role="tab" aria-controls="manageinventory"
                                aria-selected="false"><i class="feather icon-archive"></i> {{ __('Manage Inventory') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cashbacksettings-tab" data-toggle="tab" href="#cashbacksettings"
                                role="tab" aria-controls="cashbacksettings"
                                aria-selected="false"><i class="feather icon-dollar-sign"></i> {{ __('Cashback Settings') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="productspecifications-tab" data-toggle="tab"
                                href="#productspecifications" role="tab" aria-controls="productspecifications"
                                aria-selected="false"><i class="feather icon-align-right"></i> {{ __("Product Specifications") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="image-tab" data-toggle="tab" href="#image" role="tab"
                                aria-controls="image" aria-selected="false"><i class="feather icon-rotate-cw"></i> {{ __("360° Image") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="productfaq-tab" data-toggle="tab" href="#productfaq" role="tab"
                                aria-controls="productfaq" aria-selected="false"><i class="feather icon-help-circle"></i> {{ __("Product FAQ's") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="preorder-tab" data-toggle="tab" href="#preorder" role="tab"
                                aria-controls="preorder" aria-selected="false"><i class="feather icon-arrow-up-right"></i> {{ __("Preorder Configuration") }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="defaultTabContent">
                        <!-- === productdetails start ======== -->
                        <div class="tab-pane fade show active" id="productdetails" role="tabpanel"
                            aria-labelledby="productdetails-tab">
                            <!-- productdetails form start -->

                            <div class="row">
                                <div class="col-md-9">

                                    <!-- <div class="row"> -->
                                    <form action="{{ route("simple-products.update",$product->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        <!-- <div class="col-md-9"> -->
                                        @csrf
                                        @method('PUT')
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-dark">{{__("Product Name:")}} <span
                                                            class="text-danger">*</span></label>
                                                    <input placeholder="{{ __("Enter product name") }}" required
                                                        type="text" value="{{ $product->product_name }}"
                                                        class="form-control" name="product_name">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-dark">
                                                        {{__("Product Brand:")}} <span class="text-danger">*</span>
                                                    </label>
                                                    <select data-placeholder="Please select brand" required=""
                                                        name="brand_id" class="select2 form-control">
                                                        <option value="">Please Select</option>
                                                        @if(!empty($brands_all))
                                                        @foreach($brands_all as $brand)
                                                            <option {{$product['brand_id'] == $brand['id'] ? "selected" : "" }}
                                                                value="{{$brand->id}}">
                                                                {{$brand->name}} 
                                                            </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-dark">
                                                        {{__("Product Store:")}} <span class="text-danger">*</span>
                                                    </label>
                                                    <select data-placeholder="{{__("Please select store")}}" required=""
                                                        name="store_id" class="form-control select2">

                                                        <option value="">
                                                            {{__("Please select store")}}
                                                        </option>

                                                        @foreach($stores as $store)
                                                        <optgroup label="Store Owner • {{ $store->user->name }}">
                                                            <option
                                                                {{$product['store_id'] == $store['id'] ? "selected" : "" }}
                                                                value="{{ $store->id }}">
                                                                {{ $store->name }}</option>
                                                        </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-dark"> {{__("Key Features:")}}
                                                    </label>
                                                    <textarea class="form-control editor" id="editor1"
                                                        name="key_features">{!! $product->key_features !!}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-dark">{{__("Product Description:")}} <span
                                                            class="text-danger">*</span></label>
                                                    <textarea placeholder="{{ __("Enter product details") }}"
                                                        class="editor" name="product_detail" id="editor1" cols="30"
                                                        rows="10">{{ $product->product_detail }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-dark">{{__("Product Category:")}} <span class="text-danger">*</span></label>
                                                    <select data-placeholder="{{ __("Please select category") }}"
                                                        name="category_id" id="category_id"
                                                        class="form-control select2">
                                                        <option value="">{{ __("Please select category") }}</option>
                                                        @foreach($categories as $category)
                                                        <option
                                                            {{ $product->category_id == $category->id ? "selected" : "" }}
                                                            value="{{ $category->id }}">{{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-dark">Product Subcategory: <span
                                                            class="text-danger">*</span></label>

                                                    <select data-placeholder="{{ __('Please select subcategory') }}" required=""
                                                        name="subcategory_id" id="upload_id"
                                                        class="form-control select2">
                                                        <option value="">Please Select</option>
                                                        @foreach($product->category->subcategory as $item)
                                                        <option
                                                            {{ $item->id == $product->subcategory_id ? "selected" : "" }}
                                                            value="{{ $item->id }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-dark">
                                                        Childcategory:
                                                    </label>
                                                    <select data-placeholder="Please select childcategory"
                                                        name="child_id" id="grand" class="form-control select2">
                                                        <option value="">Please choose</option>
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
                                                    <label class="text-dark">Product Tags:</label>
                                                    <input data-role="tagsinput" placeholder="{{ __("Enter product tags by comma") }}"
                                                        type="text" class="form-control" name="product_tags"
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
                                                    <label class="text-dark">
                                                        {{ __("Product tag") }} ({{ app()->getLocale() }}) :

                                                        <i class="fa fa-question-circle" data-toggle="tooltip"
                                                            data-placement="top"
                                                            title="{{ __("It will show in front end in rounded circle with product thumbnail") }}"></i>

                                                    </label>

                                                    <input type="text" value="{{ $product->sale_tag }}"
                                                        class="form-control" name="sale_tag" placeholder="Exclusive">
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-dark">
                                                        {{ __("Product tag text color") }} :
                                                    </label>

                                                    <!-- ------ -->
                                                    <div class="input-group initial-color" title="Using input value">
                                                        <input type="text" class="form-control input-lg"
                                                            value="{{ $product->sale_tag_text_color ? $product->sale_tag_text_color : '#000000' }}"
                                                            name="sale_tag_text_color" placeholder="#000000" />
                                                        <span class="input-group-append">
                                                            <span
                                                                class="input-group-text colorpicker-input-addon"><i></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-dark">
                                                        {{ __("Product tag background color") }} :
                                                    </label>

                                                    <!-- ------ -->
                                                    <div class="input-group initial-color" title="Using input value">
                                                        <input type="text" class="form-control input-lg"
                                                            value="{{ $product->sale_tag_color ? $product->sale_tag_color : '#000000' }}"
                                                            name="sale_tag_color" placeholder="#000000" />
                                                        <span class="input-group-append">
                                                            <span
                                                                class="input-group-text colorpicker-input-addon"><i></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-dark">Model No:</label>
                                                    <input placeholder="{{ __("Enter product modal name or no.") }}"
                                                        type="text" class="form-control" name="model_no"
                                                        value="{{ $product->model_no }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-dark">HSN/SAC : <span
                                                            class="text-danger">*</span></label>
                                                    <input required placeholder="{{ __("Enter product HSN/SAC code") }}"
                                                        type="text" class="form-control" name="hsin"
                                                        value="{{ $product->hsin }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-dark">SKU :</label>
                                                    <input placeholder="{{ __("Enter product SKU code") }}" type="text"
                                                        class="form-control" name="sku" value="{{ $product->sku }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-dark">Price: <span
                                                            class="text-danger">*</span></label>
                                                    <!-- -------------------------------- -->
                                                    <input min="0" required type="number" placeholder="0"
                                                        class="form-control" name="actual_selling_price"
                                                        step="0.01" value="{{ $product->actual_selling_price }}">
                                                </div>


                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-dark">Offer Price: </label>
                                                    <!-- -------------------------------- -->
                                                    <input min="0" required type="number" placeholder="0"
                                                        class="form-control" name="actual_offer_price"
                                                        step="0.01" value="{{ $product->actual_offer_price }}">

                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-dark">Tax: <span class="text-danger">*</span>
                                                    </label>
                                                    <!-- -------------------------------- -->
                                                    <input min="0" required type="number" placeholder="0"
                                                        class="form-control" name="tax" step="0.01"
                                                        value="{{ $product->tax }}">

                                                    <small>({{__("This tax % will add in given price.")}})</small>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-dark">Tax name: <span
                                                            class="text-danger">*</span></label>
                                                    <input placeholder="{{ __("Enter product name") }}" required
                                                        type="text" class="form-control" name="tax_name"
                                                        value="{{ $product->tax_name }}">
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-dark">{{ __("Product Thumbnail Image :") }}<span class="text-danger">*</span></label>
                                                   
                                                    <div class="input-group">

                                                        <input readonly id="thumbnail" name="thumbnail" type="text"
                                                            class="form-control">
                                                        <div class="input-group-append">
                                                            <span data-input="thumbnail"
                                                                class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <small class="text-muted">
                                                        <i class="fa fa-question-circle"></i> {{__("Please select product thumbnail")}}
                                                    </small>
                                                </div>
                                            </div>
                    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-dark">{{ __("Product Hover Thumbnail Image :") }}<span class="text-danger">*</span></label>
                                                     
                                                    <div class="input-group">


                                                        <input readonly id="hover_thumbnail" name="hover_thumbnail" type="text" class="form-control">
                                                        <div class="input-group-append">
                                                            <span data-input="hover_thumbnail"
                                                                class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                                                        </div>
                
                
                
                                                    </div>
                                                    
                                                    <small class="text-muted">
                                                        <i class="fa fa-question-circle"></i>
                                                        {{__("Please select product hover thumbnail")}}
                                                    </small>
                                                </div>
                                            </div>
                    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-dark">{{ __("Other Product Images : ") }}<span class="text-danger">*</span></label>
                                                    
                                                    <div class="input-group mb-3">
                                                        <div class="custom-file">
                                                            <input multiple type="file" class="custom-file-input" name="images[]" id="upload_gallery">
                                                            <label class="custom-file-label" for="upload_gallery">
                                                                {{__("Multiple images can be selected")}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    
                                                    <small class="text-muted">
                                                        <i class="fa fa-question-circle"></i> {{__("Multiple images can be choosen")}}
                                                    </small>
                                                </div>
                                            </div>


                                            <div
                                                class="{{ $product->product_file !='' ? '' : 'display-none' }} product_file col-md-6">
                                                <div class="form-group">
                                                    <label class="text-dark">Update Downloadable Product File: <span
                                                            class="text-danger">*</span></label><br>
                                                    <!-- --------------------- -->
                                                    <div class="input-group">

                                                        <input readonly id="product_file" name="product_file" type="text"
                                                            class="form-control">
                                                        <div class="input-group-append">
                                                            <span data-input="product_file"
                                                                class="bg-primary text-light file-toggle input-group-text">{{ __('Browse') }}</span>
                                                        </div>
                                                    </div>

                                                    <small class="text-muted">
                                                        <i class="fa fa-question-circle"></i>
                                                        {{__("Max file size is 50 MB")}}
                                                    </small>
                                                    <!-- --------------------- -->
                                                </div>
                                            </div>




                                        </div>

                                        <div class="row">



                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label class="text-dark">Status :</label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="status"
                                                            {{ $product->status == '1' ? "checked" : "" }}>
                                                        <span class="knob"></span>
                                                    </label>
                                                    <br>
                                                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                        Toggle the
                                                        product status</b>.</small>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-dark">Free Shipping :</label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="free_shipping"
                                                            {{ $product->free_shipping == '1' ? "checked" : "" }}>
                                                        <span class="knob"></span>
                                                    </label>
                                                    <br>
                                                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                        Toggle to
                                                        allow free
                                                        shipping on product.</b></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-dark">Featured :</label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="featured"
                                                            {{ $product->featured == '1' ? "checked" : "" }}>
                                                        <span class="knob"></span>
                                                    </label>
                                                    <br>
                                                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                        Toggle to
                                                        allow product
                                                        is featured.</b></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-dark">Cancel available :</label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="cancel_avbl"
                                                            {{ $product->cancel_avbl == '1' ? "checked" : "" }}>
                                                        <span class="knob"></span>
                                                    </label>
                                                    <br>
                                                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                        Toggle to
                                                        allow product
                                                        cancellation on order.</b></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-dark">Cash on delivery available :</label>
                                                    <br>
                                                    <label class="switch">
                                                        <input type="checkbox" name="cod_avbl"
                                                            {{ $product->cod_avbl == '1' ? "checked" : "" }}>
                                                        <span class="knob"></span>
                                                    </label>
                                                    <br>
                                                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                        Toggle to
                                                        allow COD on
                                                        product.</b></small>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">

                                                <label class="text-dark" for="">Return Available :</label>
                                                <select data-placeholder="Please choose an option" required=""
                                                    class="form-control select2" id="choose_policy" name="return_avbl">
                                                    <option value="">Please choose an option</option>
                                                    <option {{ $product['return_avbl'] =='1' ? "selected" : "" }}
                                                        value="1">
                                                        Return Available</option>
                                                    <option {{ $product['return_avbl'] =='0' ? "selected" : "" }}
                                                        value="0">
                                                        Return Not Available</option>
                                                </select>
                                                <br>
                                                <small class="text-desc">(Please choose an option that return will be
                                                    available
                                                    for this product or not)</small>


                                            </div>

                                            <div id="policy"
                                                class="{{ $product['return_avbl'] == 1 ? '' : 'display-none' }} form-group col-md-4">
                                                <label class="text-dark">
                                                    Select Return Policy: <span class="text-danger">*</span>
                                                </label>
                                                <select data-placeholder="Please select return policy" name="policy_id"
                                                    class="form-control select2">
                                                    <option value="">Please select return policy</option>

                                                    @foreach(App\admin_return_product::where('status','1')->get()
                                                    as $policy)
                                                    <option {{ $product['policy_id'] == $policy->id ? "selected" : "" }}
                                                        value="{{ $policy->id }}">{{ $policy->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i>
                                                {{ __("Reset")}}</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                {{ __("Update")}}</button>

                                        </div>
                                        <!-- </div> -->
                                    </form>
                                    <!-- </div> -->

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
                                        <i data-imageid="{{ $gallery->id }}" class="text-red fa fa-times stick_close_btn"></i>
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
                            <!-- productdetails form end -->
                        </div>
                        <!-- === productdetails end ======== -->

                        <!-- === manageinventory start ======== -->
                        <div class="tab-pane fade" id="manageinventory" role="tabpanel"
                            aria-labelledby="manageinventory-tab">
                            <!-- === manageinventory form start ======== -->
                            <h6>{{ __("Manage Inventory") }}</h6>
                            <hr>
                            <form action="{{ route("manage.inventory",$product->id) }}" method="POST">
                                @csrf

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __("Stock") }} <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="number" min="0"
                                                value="{{ $product->stock ?? old('stock') }}" name="stock">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __("Minimum Order Qty.") }} <span
                                                    class="text-danger">*</span></label>
                                            <input min="1" type="text" placeholder="0" class="form-control limit"
                                                name="min_order_qty" step="0.01"
                                                value="{{ $product->min_order_qty ?? old('min_order_qty') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __("Maxium Order Qty.") }}</label>
                                            <input min="1" type="text" placeholder="0" class="form-control limit"
                                                name="max_order_qty" step="0.01"
                                                value="{{ $product->max_order_qty ?? old('max_order_qty') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban mr-2"></i>
                                        {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>
                                        {{ __("Update")}}</button>
                                    <!-- <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle mr-2"></i> {{ __("Update") }}</button> -->
                                </div>

                            </form>
                            <!-- === manageinventory form end ===========-->
                        </div>
                        <!-- === manageinventory end ======== -->

                        <!-- === cashbacksettings start ======== -->
                        <div class="tab-pane fade" id="cashbacksettings" role="tabpanel"
                            aria-labelledby="cashbacksettings-tab">
                            <!-- === cashbacksettings form start ======== -->
                            <h6>{{ __("Cashback Settings") }}</h6>
                            <hr>
                            <form action="{{ route("cashback.save",$product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_type" value="simple_product">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark">{{ __('Enable Cashback system :') }}</label>
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
                                            <label class="text-dark"
                                                for="cashback_type">{{ __("Select cashback type:") }} <span
                                                    class="text-danger">*</span> </label>
                                            <select data-placeholder="{{ __("Select cashback type") }}"
                                                name="cashback_type" class="form-control select2">
                                                <option value="">{{ __("Select cashback type") }}</option>
                                                <option
                                                    {{ isset($cashback_settings) && $cashback_settings->cashback_type == 'fix' ? "selected" : "" }}
                                                    value="fix">{{ __("Fix") }}</option>
                                                <option
                                                    {{ isset($cashback_settings) && $cashback_settings->cashback_type == 'per' ? "selected" : "" }}
                                                    value="per">{{ __("Percent") }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark" for="discount_type">{{ __("Discount type:") }}
                                                <span class="text-danger">*</span> </label>
                                            <select data-placeholder="{{ __("Select discount type") }}"
                                                name="discount_type" class="form-control select2">
                                                <option value="">{{ __("Select cashback type") }}</option>
                                                <option
                                                    {{ isset($cashback_settings) && $cashback_settings->discount_type == 'flat' ? "selected" : "" }}
                                                    value="flat">{{ __("Flat") }}</option>
                                                <option
                                                    {{ isset($cashback_settings) && $cashback_settings->discount_type == 'upto' ? "selected" : "" }}
                                                    value="upto">{{ __("Upto") }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark" for="discount">{{ __("Discount:") }} <span
                                                    class="text-danger">*</span> </label>
                                            <input min="0" required type="text" placeholder="0"
                                                class="form-control discount2" name="discount" step="0.01"
                                                value="{{ isset($cashback_settings) ? $cashback_settings->discount : 0 }}">

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban mr-2"></i>
                                            {{ __("Reset")}}</button>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>
                                            {{ __("Update")}}</button>
                                    </div>

                                </div>

                            </form>
                            <!-- === cashbacksettings form end ===========-->
                        </div>
                        <!-- === cashbacksettings end ======== -->

                        <!-- === productspecifications start ======== -->
                        <div class="tab-pane fade" id="productspecifications" role="tabpanel"
                            aria-labelledby="productspecifications-tab">
                            <!-- === productspecifications form start ======== -->

                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card started -->
                                    <div class="card">
                                        <!-- ========= -->
                                        <!-- to show add button start -->
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col-md-7">
                                                    <div class="card-header">
                                                        <h5 class="card-title">{{ __('Edit Product Specification') }}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="widgetbar">
                                                        <button type="button"
                                                            class="float-right btn btn-danger-rgba mr-2"
                                                            data-toggle="modal" data-target="#bulk_delete_spec"><i
                                                                class="feather icon-trash mr-2"></i> Delete
                                                            Selected</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- to show add button end -->
                                        <!-- card body started -->
                                        <div class="card-body">
                                            <form action="{{ route('pro.specs.store',$product->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" value="yes" name="simple_product">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <th>
                                                            <div class="inline">
                                                                <input id="checkboxAll" type="checkbox"
                                                                    class="filled-in" name="checked[]" value="all" />
                                                                <label for="checkboxAll"
                                                                    class="material-checkbox"></label>
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
                                                                                class="filled-in material-checkbox-input"
                                                                                name="checked[]" value="{{$spec->id}}"
                                                                                id="checkbox{{$spec->id}}">
                                                                            <label for="checkbox{{$spec->id}}"
                                                                                class="material-checkbox"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $spec->prokeys }}</td>
                                                                    <td>{{ $spec->provalues }}</td>
                                                                    <td>
                                                                        <a data-toggle="modal" title="Edit"
                                                                            data-target="#edit{{ $spec->id }}"
                                                                            class="btn btn-sm btn-info">
                                                                            <i class="fa fa-pencil"></i>
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
                                                                <input required="" name="prokeys[]" type="text"
                                                                    class="form-control" value=""
                                                                    placeholder="Product Attribute">
                                                            </td>
                                                            <td>
                                                                <input required="" name="provalues[]" type="text"
                                                                    class="form-control" value=""
                                                                    placeholder="Attribute Value">
                                                            </td>
                                                            <td>
                                                                <button type="button" name="add" id="add"
                                                                    class="btn btn-xs btn-success"><i
                                                                        class="fa fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban mr-2"></i>{{ __("Reset")}}</button>
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="fa fa-check-circle mr-2"></i>{{ __("Add")}}</button>
                                                    <!-- <button class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Add</button> -->
                                                </div>
                                            </form>

                                            @if(isset($product->specs))
                                            @foreach($product->specs as $spec)
                                            <div id="edit{{ $spec->id }}" class="delete-modal modal fade" role="dialog">
                                                <div class="modal-dialog modal-md">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="modal-title">Edit : <b>{{ $spec->prokeys }}</b>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('pro.specs.update',$spec->id) }}"
                                                                method="POST">
                                                                @csrf

                                                                <div class="form-group">
                                                                    <label class="text-dark">Attribute Key:</label>
                                                                    <input required="" type="text" name="pro_key"
                                                                        value="{{ $spec->prokeys }}"
                                                                        class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="text-dark">Attribute Value:</label>
                                                                    <input required="" type="text" name="pro_val"
                                                                        value="{{ $spec->provalues }}"
                                                                        class="form-control">
                                                                </div>

                                                                <button type="reset" class="btn btn-danger mr-1"><i
                                                                        class="fa fa-ban mr-2"></i>{{ __("Reset")}}</button>
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="fa fa-check-circle mr-2"></i>{{ __("Update")}}</button>



                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div><!-- row end -->
                            <!-- === productspecifications form end ===========-->
                        </div>
                        <!-- === productspecifications end ======== -->

                        <!-- === image start ======== -->
                        <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="image-tab">
                            <!-- === image form start ======== -->
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{ route("upload.360",$product->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label class="text-dark">{{ __("Upload Product 360° Image") }} <span
                                                    class="text-danger">*</span> </label>
                                            <!-- ------ -->
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                        id="inputGroupFileAddon01">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="360_image[]"
                                                        id="inputGroupFile01" aria-describedby="inputGroupFileAddon01"
                                                        required>
                                                    <label class="custom-file-label" for="inputGroupFile01">Choose
                                                        file</label>
                                                </div>

                                            </div>
                                            <small>{{__("You can upload 20 images at a time.")}}</small>

                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="feather icon-upload mr-2"></i>
                                                {{ __("Upload")}}</button>
                                        </div>
                                    </form>

                                    @forelse($product->frames as $key => $frame)

                                    <div class="well">
                                        <div class="row">

                                            <div class="col-md-2">
                                                <a href="{{ url('images/simple_products/360_images/'.$frame->image) }}"
                                                    data-lightbox="image-1" data-title="{{ $frame->image }}">
                                                    <img width="50px"
                                                        src="{{ url('images/simple_products/360_images/'.$frame->image) }}"
                                                        alt="{{ $frame->image }}" class=" img-thumbnail" />
                                                </a>
                                            </div>

                                            <div class="col-md-8">
                                                <b>{{$frame->image}}</b>
                                            </div>

                                            <div class="col-md-2">
                                                <i data-imageid="{{ $frame->id }}"
                                                    class="delete_image_360 text-red fa fa-trash fa-2x"></i>
                                            </div>

                                        </div>
                                    </div>

                                    @empty
                                    {{__("No frames found !")}}
                                    @endforelse
                                </div>

                                <div class="col-md-6">
                                    <label class="text-dark">{{__("Current Image:")}}</label>

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
                            <!-- === image form end ===========-->
                        </div>
                        <!-- === image end ======== -->

                        <!-- === productfaq start ======== -->
                        <div class="tab-pane fade" id="productfaq" role="tabpanel" aria-labelledby="productfaq-tab">
                            <!-- === productfaq form start ======== -->

                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card started -->
                                    <div class="card">
                                        <!-- ========= -->
                                        <!-- to show add button start -->
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col-md-7">

                                                </div>
                                                <div class="col-md-5">
                                                    <div class="widgetbar">
                                                        <a data-toggle="modal" data-target="#addFAQ"
                                                            class="float-right btn btn-primary-rgba mr-2"><i
                                                                class="feather icon-plus mr-2"></i> Add FAQ</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- to show add button end -->
                                        <!-- card body started -->
                                        <div class="card-body">
                                            <!-- table to display language start -->
                                            <table id="" class="table table-striped table-bordered">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                    <th>Action</th>
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
                                                                <button class="btn btn-round btn-outline-primary"
                                                                    type="button" id="CustomdropdownMenuButton1"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"><i
                                                                        class="feather icon-more-vertical-"></i></button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="CustomdropdownMenuButton1">

                                                                    <a class="dropdown-item btn btn-link"
                                                                        data-toggle="modal"
                                                                        data-target="#editfaq{{ $f->id }}">
                                                                        <i
                                                                            class="feather icon-edit mr-2"></i>{{ __("Edit") }}
                                                                    </a>
                                                                    <a class="dropdown-item btn btn-link"
                                                                        data-toggle="modal"
                                                                        data-target="#delete{{ $f->id }}">
                                                                        <i
                                                                            class="feather icon-delete mr-2"></i>{{ __("Delete") }}
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <!-- edit Modal start -->
                                                            <div class="modal fade" id="editfaq{{ $f->id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleStandardModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleStandardModalLabel">Edit FAQ:
                                                                                {{ $f->question }}</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- form start -->
                                                                            <form
                                                                                action="{{route('product_faq.update',$f->id)}}"
                                                                                class="form" method="POST" novalidate
                                                                                enctype="multipart/form-data">
                                                                                {{ method_field("PUT") }}
                                                                                @csrf

                                                                                <!-- row start -->
                                                                                <div class="row">

                                                                                    <!-- Question -->
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="text-dark">{{ __('Question :') }}
                                                                                                <span
                                                                                                    class="text-danger">*</span></label>
                                                                                            <input required=""
                                                                                                type="text"
                                                                                                name="question"
                                                                                                value="{{ $f->question }}"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Answer -->
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                class="text-dark">{{ __('Answer :') }}
                                                                                                <span
                                                                                                    class="text-danger">*</span></label>
                                                                                            <textarea required=""
                                                                                                cols="10"
                                                                                                id="answerarea"
                                                                                                name="answer" rows="5"
                                                                                                class="form-control editor">{{ $f->answer }}</textarea>
                                                                                            <input type="hidden"
                                                                                                readonly name="pro_id"
                                                                                                value="{{ $product->id }}">
                                                                                            <small class="text-muted"><i
                                                                                                    class="fa fa-question-circle"></i>
                                                                                                Please enter answer for
                                                                                                above question !
                                                                                            </small>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- save button -->
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary"><i
                                                                                                    class="fa fa-check-circle"></i>
                                                                                                {{ __("save")}}</button>
                                                                                            <button type="button"
                                                                                                class="btn btn-danger"
                                                                                                data-dismiss="modal">{{ __('Close') }}</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </div><!-- row end -->

                                                                            </form>
                                                                            <!-- form end -->
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- edit Modal end -->

                                                            <!-- delete Modal start -->
                                                            <div class="modal fade bd-example-modal-sm"
                                                                id="delete{{ $f->id }}" tabindex="-1" role="dialog"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-sm">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <h4 class="modal-heading">Are You Sure ?
                                                                            </h4>
                                                                            <p>Do you really want to delete this faq?
                                                                                This process cannot be undone.</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form method="post"
                                                                                action="{{url('admin/product_faq/'.$f->id)}}"
                                                                                class="pull-right">
                                                                                {{csrf_field()}}
                                                                                {{method_field("DELETE")}}
                                                                                <button type="reset"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">{{ __("No") }}</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">{{ __("YES") }}</button>
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
                                            <!-- table to display language data end -->

                                            <!-- create faq Modal start -->
                                            <div class="modal fade" id="addFAQ" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleStandardModalLabel">
                                                                {{ __('Add new FAQ') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- form start -->
                                                            <form action="{{url('admin/product_faq')}}" class="form"
                                                                method="POST" novalidate enctype="multipart/form-data">
                                                                @csrf

                                                                <!-- row start -->
                                                                <div class="row">

                                                                    <!-- Question -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                class="text-dark">{{ __('Question :') }}
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="question"
                                                                                value="{{old('question')}}"
                                                                                class="form-control">
                                                                            <small class="text-muted"><i
                                                                                    class="fa fa-question-circle"></i>
                                                                                Please write question !</small>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Answer -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                class="text-dark">{{ __('Answer :') }}
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <textarea cols="10" id="detail"
                                                                                name="answer" rows="5"
                                                                                class="editor form-control">{{old('answer')}}</textarea>
                                                                            <input type="hidden" readonly name="pro_id"
                                                                                value="{{ $product->id }}">
                                                                            <small class="text-muted"><i
                                                                                    class="fa fa-question-circle"></i>
                                                                                Please enter answer for above question !
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" value="1" name="simple_product"/>
                                                                    <!-- save button -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">

                                                                            <button type="submit"
                                                                                class="btn btn-primary-rgba"><i
                                                                                    class="feather icon-save"></i>
                                                                                {{ __("Save")}}</button>
                                                                            <button type="button" class="btn btn-danger-rgba"
                                                                                data-dismiss="modal">{{ __('Close') }}</button>
                                                                        </div>
                                                                    </div>

                                                                </div><!-- row end -->

                                                            </form>
                                                            <!-- form end -->
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- create faq Modal end -->

                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div><!-- row end -->
                            <!-- === productfaq form end ===========-->
                        </div>
                        <!-- === productfaq end ======== -->

                        <div class="tab-pane fade" id="preorder" role="tabpanel" aria-labelledby="preorder-tab">

                            <div class="alert alert-primary">
                                <i class="feather icon-info"></i> <b>{{ __("About Preorder") }}</b>
                                <ul>
                                    <li>
                                        {{__("If you set this product as pre-order then this product will display in front with badge call 'Pre-order'.")}}
                                    </li>
                                    <li>{{__("After enabling the pre-order you can set pre-order payment as partial payment or full payment.")}}</li>
                                    <li>
                                        {{__("If you set product payment as partial payment and your product price is $100 and you set 5% partial payment percentage then customer will pay $5 only and rest $95 will pay by him/her once the product is available in stock.")}}
                                    </li>
                                </ul>
                            </div>

                            <form action="{{ route('preorder.settings',$product->id) }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label>{{ __("Available for pre-order ?") }}</label>
                                        <br>
                                        <label class="switch">
                                            <input class="pre_order" id="pre_order" type="checkbox" name="pre_order"
                                            {{ $product->pre_order == '1' ? "checked" : "" }}>
                                            <span class="knob"></span>
                                        </label>
                                    </div>
        
                                    <div style="display: {{$product->pre_order == '1' ? "block" : "none"}};" class="preShow form-group col-6">
                                        <label>{{ __("Select pre-order type:") }} <span class="text-danger">*</span></label>
                                        <select name="preorder_type" id="preorder_type" class="preorder_type form-control select2">
                                            <option {{ $product->preorder_type == "partial" ? "selected" : "" }} value="partial">{{ __("Partial Payment") }}</option>
                                            <option {{ $product->preorder_type == "full" ? "selected" : "" }}  value="full">{{ __("Full Payment") }}</option>
                                        </select>
                                    </div>
        
                                    <div id="partial_payment_per" style="display: {{$product->pre_order == '1' && $product->preorder_type == "partial" ? "block" : "none"}};" class="preShow form-group col-6">
                                        <label>{{ __("Partial payment in %:") }} <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input required placeholder="{{ __("1") }}" type="number" min="1" class="form-control" name="partial_payment_per" value="{{ $product->partial_payment_per }}">
                                            <span class="input-group-text">
                                                <i class="feather icon-percent"></i>
                                            </span>
                                        </div>
                                    </div>
        
                                    <div style="display: {{$product->pre_order == '1' ? "block" : "none"}};" class="preShow form-group col-6">
                                        <label>{{ __("Product available on:") }} <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input required id="default-date" placeholder="{{ now()->addDays(7)->format('Y-m-d') }}" value="{{ date('Y-m-d',strtotime($product->product_avbl_date)) ?? '' }}" type="text" class="form-control" name="product_avbl_date">
                                            <span class="input-group-text">
                                                <i class="feather icon-calendar"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <button class="btn btn-md btn-primary-rgba">
                                           <i class="feather icon-save"></i> {{__("Update")}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>


                    </div>
                </div><!-- card body end -->

            </div>
        </div>
    </div>
</div>
</div>

<!-- Bulk Delete Modal -->
<div id="bulk_delete_spec" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
          <p>Do you really want to delete these products? This process cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <form id="bulk_delete_form" method="post" action="{{ route('pro.specs.delete',$product->id) }}">
            @csrf
            {{ method_field('DELETE') }}
            <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
            <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
          </form>
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
        frames: 35,
        animate: true,
        responsive: false,
        loop: false,
        orientation: 180,
        reverse: false,
        detectSubsampling: true,
        source: [
            @if($product->frames()->count())
            @foreach($product->frames as $frames)
                "{{url('images/simple_products/360_images/'.$frames->image)}}",
            @endforeach
            @endif
        ],
        width: 700, // width in pixels of the window/frame
        height: 600, // height in pixels of the window/frame
    });

    $('.stick_close_btn').on('click', function () {

        var action = confirm('Are your sure ?');

        if (action == true) {
            var imageid = $(this).data('imageid');

            axios.post('{{ url("delete/gallery/image/") }}', {
                id: imageid
            }).then(res => {

                alert(res.data.msg);
                location.reload();

            }).catch(err => {
                alert(err);
                return false;
            });
        } else {

            alert('Delete cancelled !');
            return false;

        }

    });

    $('.delete_image_360').on('click', function () {

        var action = confirm('Are your sure ?');

        if (action == true) {
            var imageid = $(this).data('imageid');

            axios.post('{{ route("delete.360") }}', {
                id: imageid
            }).then(res => {

                alert(res.data.msg);
                location.reload();

            }).catch(err => {
                alert(err);
                return false;
            });
        } else {

            alert('Delete cancelled !');
            return false;

        }

    });

    $('.pre_order').on('change',function(){

        if($(this).is(':checked')){

            $("select[name='preorder_type']").attr('required','required');
            $('input[name="product_avbl_date"]').attr('required','required');
            $('.preShow').show();

        }else{

            $("select[name='preorder_type']").removeAttr('required','required');
            $('input[name="product_avbl_date"]').removeAttr('required','required');
            $('.preShow').hide();

        }

    });

    $('.preorder_type').on('change',function(){
        var val = $(this).val();

        if(val == 'partial'){

            $('input[name="partial_payment_per"]').attr('required','required');
            $('#partial_payment_per').show();


        }else{

            $('input[name="partial_payment_per"]').removeAttr('required','required');
            $('#partial_payment_per').hide();

        }

    });

    $(".midia-toggle").midia({
        base_url: '{{url('')}}',
        directory_name: 'simple_products',
        dropzone : {
            acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
        }
    });

    $(".file-toggle").midia({
        base_url: '{{url('')}}',
        directory_name: 'product_files',
        dropzone : {
            acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
        }
    });
</script>

@endsection