@extends('admin.layouts.master-soyuz')
@section('title',__('Create new product | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Add Product') }}
@endslot
@slot('menu1')
{{ __("Product") }}
@endslot
@slot('menu2')
{{ __("Add Product") }}
@endslot
@slot('button')
<div class="col-md-6">
    <div class="widgetbar">
        <a href="{{ route('simple-products.index') }}" class="btn btn-primary-rgba"><i
                class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
    </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">
    <div class="row">

        <div class="col-lg-12">
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)
                <p>
                    {{ $error}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </p>
                @endforeach
            </div>
            @endif
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Create New Product') }}</h5>
                </div>
                <div class="card-body ml-2">
                    <!-- main content start -->
                    <form action="{{ route("simple-products.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Product Type : ") }}<span
                                            class="text-danger">*</span></label>
                                    <select required data-placeholder="{{ __("Please select product type") }}"
                                        name="type" id="product_type" class="select2 product_type form-control">
                                        <option value="">{{ __("Please select product type") }}</option>
                                        <option {{ old('type') == 'simple_product' ? "selected" : "" }}
                                            value="simple_product">{{ __("Simple Product") }}</option>
                                        <option {{ old('type') == 'd_product' ? "selected" : "" }} value="d_product">
                                            {{ __("Digital Product") }}</option>
                                        <option {{ old('type') == 'ex_product' ? "selected" : "" }} value="ex_product">
                                            {{ __("External Product") }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Product Name : ") }}<span
                                            class="text-danger">*</span></label>
                                    <input placeholder="{{ __("Enter product name") }}" required type="text"
                                        value="{{ old('product_name') }}" class="form-control" name="product_name">
                                </div>
                            </div>

                            <div class="ex_pro_link display-none col-md-12">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Product Link : ") }}<span
                                            class="text-danger">*</span></label>
                                    <input placeholder="{{ __("Enter product link: https:// ") }}" type="text"
                                        value="{{ old('external_product_link') }}" class="form-control"
                                        name="external_product_link">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">
                                        {{ __("Product Brand :") }} <span class="text-danger">*</span>
                                    </label>
                                    <select data-placeholder="{{ __("Please Select") }}" required="" name="brand_id"
                                        class="select2 form-control">
                                        <option value="">{{ __("Please Select") }}</option>
                                        @if(!empty($brands_all))
                                        @foreach($brands_all as $brand)
                                        <option value="{{$brand->id}}"
                                            {{ $brand->id == old('brand_id') ? 'selected="selected"' : '' }}>
                                            {{$brand->name}} </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">
                                        Product Store : <span class="text-danger">*</span>
                                    </label>
                                    <select data-placeholder="{{ __("Please select store") }}" required="" name="store_id"
                                        class="form-control select2">

                                        <option value="">{{ __("Please select store") }}</option>

                                        @foreach($stores as $store)
                                        <optgroup label="Store Owner • {{ $store->user->name }}">
                                            <option {{ old('store_id') == $store->id ? "selected" : "" }}
                                                value="{{ $store->id }}">
                                                {{ $store->name }}</option>
                                        </optgroup>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="text-dark">{{ __("Key Features :") }}
                            </label>
                            <textarea id="editor1" class="form-control"
                                name="key_features">{!! old('key_features') !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="text-dark">{{ __("Product Description : ") }}<span
                                    class="text-danger">*</span></label>
                            <textarea placeholder="{{ __("Enter product details") }}" class="editor"
                                name="product_detail" id="editor1" cols="30"
                                rows="10">{{ old('product_detail') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Product Category :") }}<span
                                            class="text-danger">*</span></label>
                                    <select data-placeholder="{{ __("Please select category") }}" name="category_id"
                                        id="category_id" class="form-control select2">
                                        <option value="">{{ __("Please select category") }}</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Product Subategory :") }}<span
                                            class="text-danger">*</span></label>

                                    <select data-placeholder="Please select subcategory" required=""
                                        name="subcategory_id" id="upload_id" class="form-control select2">
                                        <option value="">{{ __("Please Select") }}</option>

                                    </select>
                                </div>


                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">
                                        {{ __("Childcategory :") }}
                                    </label>
                                    <select data-placeholder="Please select childcategory" name="child_id" id="grand"
                                        class="form-control select2">
                                        <option value="">{{ __("Please Select") }}</option>

                                    </select>
                                </div>


                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __("Also in :") }}</label>
                                    <select multiple="multiple" name="other_cats[]" id="other_cats" class="form-control select2">
                                        @foreach($categories as $category)
                                            <option  {{ old('other_cats') != '' && in_array($category->id,old('other_cats')) ? "selected" : "" }} value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>

                                    <small class="text-primary">
                                        <i class="feather icon-help-circle"></i> {{ __("If in list primary category is also present then it will auto remove from this after create product.") }}
                                    </small>
                                </div>

                                
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Product Tags :") }}</label>
                                    <input data-role="tagsinput" placeholder="{{ __("Enter product tags by comma") }}" type="text"
                                        class="form-control" name="product_tags" value="{{ old('product_tags') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">{{ __('Select Size chart : ') }} </label>
                                    <select name="size_chart" class="form-control select2">
                                        <option value="NULL">{{ __('None') }}</option>
                                        @foreach ($template_size_chart as $chartoption)
                                            <option {{ old('size_chart') == $chartoption->id ? "selected" : "" }} value="{{ $chartoption->id }}">{{ $chartoption->template_name }} ({{ $chartoption->template_code }}) </option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label class="text-dark">
                                        {{ __("Product tag") }} in ({{ app()->getLocale() }}) :
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top"
                                            title="{{ __("It will show in front end in rounded circle with product thumbnail") }}"></i>
                                    </label>

                                    <input type="text" value="{{ old("sale_tag") }}" class="form-control"
                                        name="sale_tag" placeholder="{{ __("Exclusive") }}">
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">
                                        {{ __("Product tag text color") }} :
                                    </label>
                                    <!-- ------------ -->
                                    <div class="input-group initial-color">
                                        <input type="text" class="form-control input-lg" value="#000000"
                                            name="sale_tag_text_color" placeholder="#000000" />
                                        <span class="input-group-append">
                                            <span class="input-group-text colorpicker-input-addon"><i></i></span>
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
                                        <input type="text" class="form-control input-lg" value="#000000"
                                            name="sale_tag_color" placeholder="#000000" />
                                        <span class="input-group-append">
                                            <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Model No :") }}</label>
                                    <input placeholder="{{ __("Enter product modal name or no.") }}" type="text"
                                        class="form-control" name="model_no" value="{{ old('model_no') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("HSN/SAC : ") }}<span
                                            class="text-danger">*</span></label>
                                    <input required placeholder="{{ __('Enter product HSN/SAC code') }}" type="text"
                                        class="form-control" name="hsin" value="{{ old('hsin') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("SKU :") }}</label>
                                    <input placeholder="{{ __("Enter product SKU code") }}" type="text"
                                        class="form-control" name="sku" value="{{ old('sku') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Price :") }}<span
                                            class="text-danger">*</span></label>
                                    <input min="0" required type="text" placeholder="0" class="form-control"
                                        name="actual_selling_price" step="0.01"
                                        value="{{ old('actual_selling_price') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Offer Price :") }}</label>
                                    <input min="0" type="text" placeholder="0" class="form-control"
                                        name="actual_offer_price" step="0.01" value="{{ old('actual_offer_price') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Tax :") }}<span class="text-danger">*</span>
                                    </label>
                                    <input min="0" required type="text" placeholder="0"
                                        class="form-control simpleproduct" name="tax" step="0.01"
                                        value="{{ old('tax') }}">
                                    <small>({{__("This tax % will add in given price.")}})</small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Tax name : ") }}<span
                                            class="text-danger">*</span></label>
                                    <input placeholder="{{ __("Enter product name") }}" required type="text"
                                        class="form-control" name="tax_name" value="{{ old('tax_name') }}">
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Product Thumbnail Image :") }}<span
                                            class="text-danger">*</span></label>



                                    <div class="input-group">

                                        <input required readonly id="thumbnail" name="thumbnail" type="text"
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Product Hover Thumbnail Image :") }}<span
                                            class="text-danger">*</span></label>

                                    <div class="input-group">


                                        <input required readonly id="hover_thumbnail" name="hover_thumbnail" type="text"
                                            class="form-control">
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Other Product Images : ") }}<span
                                            class="text-danger">*</span></label>

                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input multiple type="file" class="custom-file-input" name="images[]"
                                                id="upload_gallery" required>
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
                        </div>

                        <div class="row">
                            <div class="product_file display-none col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Downloadable Product File :") }} <span class="text-danger">*</span></label><br>

                                    <div class="input-group">

                                        <input readonly id="product_file" name="product_file" type="text"
                                            class="form-control">
                                        <div class="input-group-append">
                                            <span data-input="product_file"
                                                class="bg-primary text-light file-toggle input-group-text">{{ __('Browse') }}</span>
                                        </div>
                                    </div>

                                    <small class="text-muted">
                                        <i class="fa fa-question-circle"></i> {{__("Max file size is 50 MB")}}
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-3">

                                <div class="form-group">
                                    <label class="text-dark">{{ __("Status :") }}</label>
                                    <br>
                                    <label class="switch">
                                        <input type="checkbox" name="status"
                                            {{ old('status') == '1' ? "checked" : "" }}>
                                        <span class="knob"></span>
                                    </label>
                                    <br>
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("Toggle the product status") }}</b></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Free Shipping :") }}</label>
                                    <br>
                                    <label class="switch">
                                        <input type="checkbox" name="free_shipping"
                                            {{ old('free_shipping') == '1' ? "checked" : "" }}>
                                        <span class="knob"></span>
                                    </label>
                                    <br>
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("Toggle to allow free shipping on product.") }}</b></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Featured :") }}</label>
                                    <br>
                                    <label class="switch">
                                        <input type="checkbox" name="featured"
                                            {{ old('featured') == '1' ? "checked" : "" }}>
                                        <span class="knob"></span>
                                    </label>
                                    <br>
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("Toggle to allow product is featured.") }}</b></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Cancel available :") }}</label>
                                    <br>
                                    <label class="switch">
                                        <input type="checkbox" name="cancel_avbl"
                                            {{ old('cancel_avbl') == '1' ? "checked" : "" }}>
                                        <span class="knob"></span>
                                    </label>
                                    <br>
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("Toggle to allow product cancellation on order.") }}</b></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark">{{ __("Cash on delivery available :") }}</label>
                                    <br>
                                    <label class="switch">
                                        <input type="checkbox" name="cod_avbl"
                                            {{ old('cod_avbl') == '1' ? "checked" : "" }}>
                                        <span class="knob"></span>
                                    </label>
                                    <br>
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("Toggle to allow COD on product.") }}</b></small>
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label class="text-dark" for="">{{ __("Return Available :") }}</label>
                                <select data-placeholder="{{ __("Please choose an option") }}" required=""
                                    class="form-control select2" id="choose_policy" name="return_avbl">
                                    <option value="">
                                        {{__("Please choose an option")}}
                                    </option>
                                    <option {{ old('return_avbl') =='1' ? "selected" : "" }} value="1">
                                        {{__("Return Available")}}
                                    </option>
                                    <option {{ old('return_avbl') =='0' ? "selected" : "" }} value="0">
                                        {{__("Return Not Available")}}
                                    </option>
                                </select>
                                <br>
                                <small
                                    class="text-desc">{{ __("(Please choose an option that return will be available for this product or not)") }}
                                </small>
                            </div>

                            <div id="policy"
                                class="{{ old('return_avbl') == 1 ? '' : 'display-none' }} form-group col-md-4">
                                <label class="text-dark">
                                    {{ __("Select Return Policy :") }} <span class="text-danger">*</span>
                                </label>
                                <select data-placeholder="{{ __("Please select return policy") }}" name="policy_id"
                                    class="form-control select2">
                                    <option value="">
                                        {{__("Please select return policy")}}
                                    </option>

                                    @foreach(App\admin_return_product::where('status','1')->get() as $policy)
                                    <option {{ old('policy_id') == $policy->id ? "selected" : "" }}
                                        value="{{ $policy->id }}">{{ $policy->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                </div>

                <div class="col-md-offset-1 col-md-10 form-group">
                    <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                        {{ __("Create")}}</button>
                </div>


                </form>
                <!-- main content end -->
            </div>
        </div>
    </div>
</div>



</div>
@endsection
@section('custom-script')
<script>
    $('.product_type').on('change', function () {

        var type = $(this).val();

        if (type == 'd_product') {

            $('.ex_pro_link').addClass('display-none');
            $('.product_file').removeClass('display-none');
            $("input[product_file]").attr('required', 'required');
            $("input[external_product_link]").removeAttr('required', 'required');


        } else if (type == 'ex_product') {

            $('.ex_pro_link').removeClass('display-none');
            $('.product_file').addClass('display-none');
            $("input[product_file]").removeAttr('required', 'required');
            $("input[external_product_link]").attr('required', 'required');

        } else {

            $('.ex_pro_link').addClass('display-none');
            $('.product_file').addClass('display-none');
            $("input[product_file]").removeAttr('required', 'required');
            $("input[external_product_link]").removeAttr('required', 'required');
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