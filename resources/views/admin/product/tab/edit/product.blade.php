<h6>
  {{__('Edit Product Details:')}}
</h6>
<hr>
<form id="demo-form2" method="post" enctype="multipart/form-data" @if(!empty($products))
  action="{{url('admin/products/'.$products->id)}}" @endif data-parsley-validate
  class="form-horizontal form-label-left">
  {{csrf_field()}}
  {{ method_field('PUT') }}
  <div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label class="text-dark">{{ __(' Product Name :') }} <span class="text-danger">*</span></label>
            <input required="" placeholder="{{ __("Please enter product name") }}" type="text" id="first-name" name="name"
        value="{{$products->name ?? ''}}" class="form-control">
        </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
          <label class="text-dark">{{ __('Select Brand: ') }} <span class="text-danger">*</span></label>
          <select required="" name="brand_id" class="form-control select2">
        <option value="">
          {{__("Please Select")}}
        </option>
        @if(!empty($brands_products))
        @foreach($brands_products as $brand)
        <option value="{{$brand->id}}" {{ $brand->id == $products->brand_id ? 'selected="selected"' : '' }}>
          {{$brand->name}} </option>
        @endforeach
        @endif
      </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Category : ') }} <span class="text-danger">*</span></label>
          <select required="" name="category_id" id="category_id" class="form-control select2">
            <option value="">
              {{__("Please Select")}}
            </option>
            @if(!empty($categorys))
            @foreach($categorys as $category)
            <option value="{{$category->id}}" {{ $products->category_id == $category->id ? 'selected="selected"' : '' }}>
              {{$category->title}} </option>
            @endforeach
            @endif
          </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Subcategory : ') }} <span class="text-danger">*</span></label>
          <select required="" name="child" id="upload_id" class="form-control select2">
            <option value="">
              {{__("Please Select")}}
            </option>
            @if(!empty($child))
            @foreach($child as $category)
            <option value="{{$category->id}}" {{ $products->child == $category->id ? 'selected="selected"' : '' }}>
              {{$category->title}}
            </option>
            @endforeach
            @endif
          </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Childcategory : ') }} </label>
          <select name="grand_id" id="grand" class="form-control select2">
            <option value="">
              {{__("Please choose")}}
            </option>
            @if(!empty($child))
              @foreach($products->subcategory->childcategory as $category)
                <option value="{{$category->id}}" {{ $products->grand_id == $category->id ? 'selected="selected"' : '' }}>
                  {{$category->title}}
                </option>
              @endforeach
            @endif
          </select>
      </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>{{ __("Also in :") }}</label>
            <select multiple="multiple" name="other_cats[]" id="other_cats" class="form-control select2">
              @if(!empty($categorys))
                  @foreach($categorys->where('id','!=',$products->category_id) as $category)
                      <option {{ $products->other_cats != '' && in_array($category->id,$products->other_cats) ? "selected" : "" }} value="{{ $category->id }}">{{ $category->title }}</option>
                  @endforeach
              @endif
            </select>

            <small class="text-primary">
                <i class="feather icon-help-circle"></i> {{ __("If in list primary category is also present then it will auto remove from this after create product.") }}
            </small>
        </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Select Store : ') }} </label>
          <select required="" name="store_id" class="form-control select2">
        @foreach($stores as $store)
        <optgroup label="Store Owner • {{ $store->owner }}">
          <option {{ $products->store_id == $store->storeid ? "selected" : "" }} value="{{ $store->storeid }}">
            {{ $store->storename }}</option>
        </optgroup>
        @endforeach

      </select>
          <small class="txt-desc">({{__("Please Choose Store Name")}})</small>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Upload product catlog : ') }} </label>
          <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="catlog" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
            </div>
          </div>
          <small>({{__('Catlog file max size:')}} 1MB ) | {{__("Supported files :")}} pdf,docs,docx,ppt,txt</small>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Select Size chart : ') }} </label>
          <select name="size_chart" class="form-control select2">
              <option value="NULL">{{ __('None') }}</option>
              @foreach ($template_size_chart as $chartoption)
                  <option {{ $products->size_chart == $chartoption->id ? "selected" : "" }} value="{{ $chartoption->id }}">{{ $chartoption->template_name }} ({{ $chartoption->template_code }}) </option>
              @endforeach 
          </select>
      </div>
    </div>

    <div class="col-md-12">
      <div class="form-group">
          <label class="text-dark">{{ __('Key Features :') }} </label>
          <textarea class="form-control" id="editor2" name="key_features">{!! $products->key_features !!}</textarea>
      </div>
    </div>

    <div class="col-md-12">
      <div class="form-group">
          <label class="text-dark">{{ __('Description :') }} </label>
          <textarea id="editor1" name="des" class="form-control">{!! $products->des !!}</textarea>
          <small class="txt-desc">({{__("Please Enter Product Description")}})</small>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
      <label class="text-dark" for="first-name">{{ __('Product Video Preview :') }} </label>
      <input name="video_preview" value="{{ $products->video_preview }}" type="text" class="form-control" placeholder="eg: https://youtube.com/watch?v=">
      <small class="text-muted">
          • {{__("Supported urls are :")}} <b>Youtube,vimeo, only.</b>
      </small>
      </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label class="text-dark" for="first-name">{{ __('Product Video Thumbnail :') }}</label>
      <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="video_thumbnail" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
        </div>
      </div>
      <small class="text-muted">
          • {{__("Max upload size is")}} <b>500KB.</b>
      </small>
    </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Warranty (Duration) : ') }} </label>
          <select class="form-control select2" name="w_d" id="">
            <option>None</option>
            @for($i=1;$i<=12;$i++) <option {{ $products->w_d == $i ? "selected" : "" }} value="{{ $i }}">{{ $i }}</option>
              @endfor
          </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Days/Months/Year :') }} </label>
          <select class="form-control select2" name="w_my" id="">
          <option>{{ __("None") }}</option>
          <option {{ $products->w_my == 'day' ? "selected" : "" }} value="day">{{ __('Day') }}</option>
          <option {{ $products->w_my == 'month' ? "selected" : "" }} value="month">{{ __('Month') }}</option>
          <option {{ $products->w_my == 'year' ? "selected" : "" }} value="year">{{ __('Year') }}</option>
        </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Type :') }} </label>
          <select class="form-control select2" name="w_type" id="">
          <option>{{ __('None') }}</option>
          <option {{ $products->w_type == 'Guarantee' ? "selected" : "" }} value="Guarantee">{{ __('Guarantee') }}</option>
          <option {{ $products->w_type == 'Warranty' ? "selected" : "" }} value="Warranty">{{ __("Warranty") }}</option>
        </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Start Selling From :') }} </label>
          <div class="input-group">                                  
          <input type="text" id="default-date" name="selling_start_at" value="{{ $products->selling_start_at }}" class="datepicker-here form-control" placeholder="dd/mm/yyyy" aria-describedby="basic-addon2"/>
            <div class="input-group-append">
              <span class="input-group-text" id="basic-addon2"><i class="feather icon-calendar"></i></span>
            </div>
          </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Tags :') }} </label>
          <input data-role="tagsinput" value="{{ $products->tags }}" placeholder="{{ __("Please enter tag seprated by Comma(,)") }}" type="text" name="tags"
        class="form-control">
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __('Model :') }}</label>
      <input type="text" id="first-name" name="model" class="form-control" placeholder="{{ __('Please Enter Model Number') }}" value="{{ $products->model }}">
    </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label class="text-dark">{{ __('HSN/SAC :') }}<span class="text-danger">*</span></label>
        <input required placeholder="{{ __("Enter product HSN/SAC code") }}" type="text"
                class="form-control" name="hsn" value="{{ $products->hsn }}">
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label for="first-name" class="text-dark">{{ __('SKU :') }}</label>
      <input type="text" id="first-name" name="sku" value="{{ $products->sku }}" placeholder="{{ __('Please enter SKU') }}"
            class="form-control">
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __('Price Including Tax ?') }}</label><br>
      <label class="switch">
        <input {{ $products->tax_r != '' ? "checked" : "" }} type="checkbox" id="tax_manual"
          class="toggle-input toggle-buttons" name="tax_manual">
        <span class="knob"></span>
      </label>
      </div>
    </div>

    <div class="col-md-4">

      <div class="form-group">
        
        <label class="text-dark">
        {{ __('Price :') }}
        </label>
    
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">{{ $defCurrency->currency->code }}</span>
          </div>
          <input title="{{ __("Price Format must be in this format : 200 or 200.25") }}" required="" type="number" min="0" step="0.01" id="first-name" name="price" value="{{$products->vender_price ?? ''}}" class="form-control">
          
        </div>
      </div>
      <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Do not put comma while entering PRICE') }}</small>
    </div>

    <div class="col-md-4">

      <div class="form-group">
        
        <label class="text-dark">
        {{ __('Offer Price :') }}
        </label>
    
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">{{ $defCurrency->currency->code }}</span>
          </div>
          <input title="Price Format must be in this format : 200 or 200.25" required="" type="number" min="0" step="0.01" id="first-name" name="offer_price" value="{{$products->vender_offer_price ?? 0}}" class="form-control">
          
        </div>
      </div>
      <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Do not put comma while entering Offer price') }}</small>
    </div>


    <div class="col-md-4">
      <div class="form-group">
        
        <label class="text-dark">
        {{ __('Gift Packaging Charge :') }}
        </label>
    
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">{{ $defCurrency->currency->code }}</span>
          </div>
          <input title="{{ __("Gift Packaging price Format must be in this format : 200 or 200.25") }}" pattern="[0-9]+(\.[0-9][0-9]?)?" type="number" step="0.01" min="0" value="{{ $products->gift_pkg_charge ?? old('gift_pkg_charge') }}" name="gift_pkg_charge" class="form-control"/>
          
        </div>
        <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("PUT 0 if you don't want to enable gift packaging for this product.") }}</small>
      </div>
    </div>

    <div class="col-md-6 {{ $products->tax_r != '' ? '' : 'display-none' }}" id="manual_tax" >
      <div class="form-group">
          <label class="text-dark">{{ __('Tax Applied (In %)') }} <span class="text-danger">*</span></label>
          <div class="input-group mb-3">
            <input {{ $products->tax_r != '' ? "required" : "" }} value="{{ $products->tax_r }}" id="tax_r" type="number" min="0" class="form-control" name="tax_r" placeholder="0">
            <div class="input-group-append">
              <span class="input-group-text" id="basic-addon2">%</span>
            </div>
          </div>
      </div>
    </div>

    <div class="col-md-6 {{ $products->tax_r != '' ? '' : 'display-none' }}" id="manual_tax_name">
    <div class="form-group">
      <label class="text-dark">{{ __('Tax Name :') }}<span class="text-danger">*</span></label>
      <input {{ $products->tax_r != '' ? "required" : "" }} type="text" id="tax_name" class="form-control"
        name="tax_name" title="Tax rate must without % sign" placeholder="{{ __("Enter Tax Name") }}"
        value="{{ $products->tax_name }}">
    </div>
    </div>

    <div class="col-md-12">
      <div class="{{ $products->tax_r != '' ? 'display-none' : "" }}" id="tax_class">
        <label class="text-dark">
          {{ __("Tax Classes :") }}
        </label>
        <select {{ $products->tax_r == '' ? "required" : "" }} name="tax" class="form-control">
          <option value="">Please Choose..</option>
          @foreach(App\TaxClass::all() as $tax)
          <option value="{{$tax->id}}"
            @if(!empty($products)){{ $tax->id == $products->tax ? 'selected="selected"' : '' }}@endif>{{$tax->title}}
          </option>
          @endforeach
        </select>
        <small class="txt-desc">({{__("Please Choose Yes Then Start Sale This Product")}})</small>
        <img src="{{(url('images/info.png'))}}" data-toggle="modal" data-target="#taxmodal" class="img-fluid" width="15" ><br>

      </div>
    </div>


    <div class="col-md-4">
      <div class="form-group">
        <label class="text-dark">{{ __("Product tag") }} ({{ app()->getLocale() }}) :
            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{ __("It will show in front end in rounded circle with product thumbnail") }}"></i>
        </label>
        <input type="text" value="{{ $products->sale_tag }}" class="form-control" name="sale_tag" placeholder="Exclusive">
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
        <label class="text-dark">
            {{ __("Product tag text color") }} :
        </label>
        <div class="input-group initial-color">
          <input type="text" class="form-control input-lg" value="{{ $products->sale_tag_text_color  ? $products->sale_tag_text_color : '#000000' }}"  name="sale_tag_text_color"placeholder="#000000"/>
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
        <div class="input-group initial-color">
          <input type="text" class="form-control input-lg" value="{{  $products->sale_tag_color  ? $products->sale_tag_color : '#000000' }}" name="sale_tag_color" placeholder="#000000"/>
          <span class="input-group-append">
          <span class="input-group-text colorpicker-input-addon"><i></i></span>
          </span>
      </div>
    
    </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label class="text-dark">{{ __("Free Shipping :") }}</label><br>
        <label class="switch">
          <input class="slider" type="checkbox" name="free_shipping"  {{ $products->free_shipping == "0" ? '' : "checked" }} />
          <span class="knob"></span>
        </label><br>
        <small class="txt-desc">({{__("If Choose Yes Then Free Shipping Start")}}) </small>
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __(" Featured :") }}</label><br>
      <label class="switch">
        <input class="slider" type="checkbox" name="featured"  @if(!empty($products))
        <?php echo ($products->featured=='1')?'checked':'' ?> @endif />
        <span class="knob"></span>
      </label><br>
      <small class="txt-desc">({{__("If enable than Product will be featured")}})</small>
    </div>
    </div>

    <div class="form-group col-md-4">
        <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} </label><br>
        <label class="switch">
          <input class="slider" type="checkbox" name="status" {{ $products->status == '1' ? 'checked' : '' }}/>
          <span class="knob"></span>
        </label><br>
        <small>{{ __('(Please Choose Status)') }}</small>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __('Cancel Available :') }}</label><br>
      <label class="switch">
          <input class="slider" type="checkbox" name="cancel_avl" {{ $products->cancel_avl == '1' ? 'checked' : '' }}/>
          <span class="knob"></span>
        </label><br>
      <small>{{ __('(Please Choose Cancel Available )') }}</small>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark" for="first-name">{{ __('Cash On Delivery :') }}</label><br>
      <label class="switch">
        <input class="slider" type="checkbox" name="codcheck"  {{ $products->codcheck == '1' ? 'checked' : '' }}/>
        <span class="knob"></span>
      </label><br>
      <small>{{ __('(Please Choose Cash on Delivery Available On This Product or Not)') }}</small>
    </div>
    </div>

    <div class="last_btn col-md-4">
    <div class="form-group">
      <label class="text-dark" for="">{{ __("Return Available :") }}</label>
      <select required="" class="form-control select2" id="choose_policy" name="return_avbls">
        <option value="">{{ __("Please choose an option") }}</option>
        <option {{ $products->return_avbl=='1' ? "selected" : "" }} value="1">{{ __('Return Available') }}</option>
        <option {{ $products->return_avbl=='0' ? "selected" : "" }} value="0">{{ __("Return Not Available") }}</option>
      </select>
      <br>
      <small class="text-desc">({{__("Please choose an option that return will be available for this product or not")}})</small>

    </div>
    </div>

    
    <div id="policy" class="{{ $products->return_avbl == 1 ? '' : 'd-none' }} last_btn col-md-4">
    
      <div class="form-group">
        <label class="text-dark" for="">{{__("Select Return Policy :")}} <span class="text-danger">*</span></label>
        <select name="return_policy" class="choose_policy form-control select2">
          <option value="">{{ __("Please choose an option") }}</option>

          @foreach(App\admin_return_product::where('status','1')->get() as $policy)
          <option @if(!empty($products)) {{ $products->return_policy == $policy->id ? "selected" : "" }} @endif
            value="{{ $policy->id }}">{{ $policy->name }}</option>
          @endforeach
        </select>
      </div>

    </div>

    <div class="col-md-12">
        <div class="form-group">
            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
            {{ __("Update")}}</button>
        </div>
    </div>

  </div>
</form>