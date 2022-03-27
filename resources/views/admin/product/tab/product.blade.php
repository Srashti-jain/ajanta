<form method="post" enctype="multipart/form-data" action="{{url('admin/products/')}}" data-parsley-validate class="form-horizontal form-label-left">
@csrf
  <div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label class="text-dark">{{ __('Product Name :') }} <span class="text-danger">*</span></label>
            <input required="" placeholder="{{ __("Please enter product name") }}" type="text" id="first-name" name="name" value="{{ old('name') }}" class="form-control">
        </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
          <label class="text-dark">{{ __('Select Brand: ') }} <span class="text-danger">*</span></label>
          <select placeholder="{{ __("Please select brand") }}" required="" name="brand_id" class="select2 form-control">
            <option value="">
              {{__('Please Select')}}
            </option>
            @if(!empty($brands_products))
              @foreach($brands_products as $brand)
              <option value="{{$brand->id}}" {{ $brand->id == old('brand_id') ? 'selected="selected"' : '' }}>
                {{$brand->name}} </option>
              @endforeach
            @endif
        </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Category : ') }} <span class="text-danger">*</span></label>
              <select data-placeholder="{{ __("Please select category") }}" required="" name="category_id" id="category_id" class="form-control select2">
            <option value="">{{ __("Please Select") }}</option>
            @if(!empty($categorys))
              @foreach($categorys as $category)
                <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected="selected"' : '' }}>
                  {{$category->title}} 
                </option>
              @endforeach
            @endif
          </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Subcategory : ') }} <span class="text-danger">*</span></label>
            <select data-placeholder="{{ __("Please select subcategory") }}" required="" name="child" id="upload_id" class="form-control select2">
             <option value="">{{ __('Please Select') }}</option>
        
            </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Childcategory : ') }} </label>
          <select data-placeholder="{{ __("Please select childcategory") }}" name="grand_id" id="grand" class="form-control select2">
          <option value="">
            {{__('Please choose')}}
          </option>
        
          </select>
      </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>{{ __("Also in :") }}</label>
            <select multiple="multiple" name="other_cats[]" id="other_cats" class="form-control select2">
              @if(!empty($categorys))
                @foreach($categorys as $category)
                    <option {{ old('other_cats') && in_array($category->id,old('other_cats')) ? "selected" : "" }} value="{{ $category->id }}">{{ $category->title }}</option>
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
          <select data-placeholder="{{ __("Please select store") }}" required="" name="store_id" class="form-control select2">
            <option value="">{{ __("Please select store") }}</option>
            @foreach($stores as $store)
              <optgroup label="Store Owner • {{ $store->owner }}">
                <option {{ old('store_id') == $store->storeid ? "selected" : "" }} value="{{ $store->storeid }}">
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
                <input type="file" class="custom-file-input" name="catlog" id="catlog"/>
                <label class="custom-file-label" for="catlog">{{ __("Choose file") }} </label>
            </div>
          </div>
          <small>({{__("Catlog file max size")}}: 1MB ) | {{__("Supported files :")}} pdf,docs,docx,ppt,txt</small>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Select Size chart : ') }} </label>
          <select name="size_chart" class="form-control select2">
              <option value="NULL">{{ __('None') }}</option>
              @foreach ($template_size_chart as $chartoption)
                  <option value="{{ $chartoption->id }}">{{ $chartoption->template_name }} ({{ $chartoption->template_code }}) </option>
              @endforeach 
          </select>
      </div>
    </div>


    <div class="col-md-12">
      <div class="form-group">
          <label class="text-dark">{{ __('Key Features :') }} </label>
          <textarea class="form-control" id="editor2" name="key_features">{!! old('key_features') !!}</textarea>
      </div>
    </div>

    <div class="col-md-12">
      <div class="form-group">
          <label class="text-dark">{{ __('Description :') }} </label>
          <textarea id="editor1" value="{{old('des' ?? '')}}" name="des" class="form-control">{{ old('des' ?? '')}}</textarea>
          <small class="txt-desc">({{__("Please Enter Product Description")}})</small>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
      <label class="text-dark" for="first-name">{{ __('Product Video Preview :') }} </label>
      <input name="video_preview" value="{{ old('video_preview') }}" type="text" class="form-control" placeholder="eg: https://youtube.com/watch?v=">
      <small class="text-muted">
          • {{__("Supported urls are")}} : <b>Youtube,vimeo, only.</b>
      </small>
      </div>
    </div>

    <div class="col-md-6">
    <div class="form-group">
      <label class="text-dark" for="first-name">{{ __('Product Video Thumbnail :') }}</label>
      <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="video_thumbnail" id="video_thumbnail"/>
            <label class="custom-file-label" for="video_thumbnail">{{ __("Choose file") }} </label>
        </div>
      </div>
      <small class="text-muted">
          {{__("• Max upload size is 500KB.")}}
      </small>
    </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Warranty (Duration) : ') }} </label>
          <select class="form-control select2" name="w_d" id="">
            <option>{{ __("None") }}</option>
              @for($i=1;$i<=12;$i++) 
                  <option {{ old('w_d') == $i ? "selected" : "" }} value="{{ $i }}">{{ $i }}</option>
              @endfor
          </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Days/Months/Year :') }} </label>
          <select class="form-control select2" name="w_my" id="">
            <option>{{ __("None") }}</option>
            <option {{ old('w_my') == 'day' ? "selected" : "" }} value="day">{{ __("Day") }}</option>
            <option {{ old('w_my') == 'month' ? "selected" : "" }} value="month">{{ __("Month") }}</option>
            <option {{ old('w_my') == 'year' ? "selected" : "" }} value="year">{{ __("Year") }}</option>
          </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Type :') }} </label>
          <select class="form-control select2" name="w_type" id="">
            <option>None</option>
            <option {{ old('w_type') == 'Guarantee' ? "selected" : "" }} value="Guarantee">
              {{__("Guarantee")}}
            </option>
            <option {{ old('w_type') == 'Warranty' ? "selected" : "" }} value="Warranty">
              {{__("Warranty")}}
            </option>
          </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Start Selling From :') }} </label>
          <div class="input-group">                                  
          <input type="text" id="default-date" name="selling_start_at" value="{{ old('selling_start_at') }}" class="datepicker-here form-control" placeholder="dd/mm/yyyy" aria-describedby="basic-addon2"/>
            <div class="input-group-append">
              <span class="input-group-text" id="basic-addon2"><i class="feather icon-calendar"></i></span>
            </div>
          </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
          <label class="text-dark">{{ __('Tags :') }} </label>
          <input value="{{ old('tags') }}" placeholder="{{ __("Please enter tag seprated by Comma(,)") }}" type="text" name="tags"
        class="form-control">
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __('Model :') }}</label>
      <input type="text" id="first-name" name="model" class="form-control" placeholder="{{ __("Please Enter Model Number") }}" value="{{ old('model') }}">
    </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label class="text-dark">{{ __('HSN/SAC :') }}<span class="text-danger">*</span></label>
        <input required placeholder="{{ __("Enter product HSN/SAC code") }}" type="text" class="form-control" name="hsn" value="{{ old('hsn') }}">
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label for="first-name" class="text-dark">{{ __('SKU :') }}</label>
      <input type="text" id="first-name" name="sku" value="{{ old('sku') }}" placeholder="Please enter SKU" class="form-control">
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __('Price Including Tax ?') }}</label><br>
      <label class="switch">
        <input {{ old('tax_r') ? "checked" : "" }} type="checkbox" id="tax_manual"
          class="toggle-input toggle-buttons" name="tax_manual">
        <span class="knob"></span>
      </label>
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __('Price :') }} <span class="text-danger">*</span>
      </label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">{{ $defCurrency->currency->code }}</span>
        </div>
        <input pattern="[0-9]+(\.[0-9][0-9]?)?" title="{{ __("Price Format must be in this format : 200 or 200.25") }}" required=""
        type="text"  name="price" value="{{ old('price') }}" class="form-control">
      </div>
      <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Do not put comma whilt entering PRICE') }}</small>
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __('Offer Price :') }}
      </label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">{{ $defCurrency->currency->code }}</span>
        </div>
        <input title="{{ __("Offer price Format must be in this format : 200 or 200.25") }}" pattern="[0-9]+(\.[0-9][0-9]?)?"
        type="text" name="offer_price" class="form-control"
        value="{{ old('offer_price') }}">
      </div>
      <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Do not put comma whilt entering OFFER PRICE') }}</small>
    </div>
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
          <input title="{{ __("Gift Packaging price Format must be in this format : 200 or 200.25") }}" pattern="[0-9]+(\.[0-9][0-9]?)?" type="number" step="0.01" min="0" value="{{ old('gift_pkg_charge') ?? 0 }}" name="gift_pkg_charge" class="form-control" value="{{ old('gift_pkg_charge') }}">
          
        </div>
    
      <small class="text-muted"><i class="fa fa-question-circle"></i> 
        {{__("PUT 0 if you don't want to enable gift packaging for this product.")}}
      </small>
      </div>
    </div>

    <div class="col-md-6 {{ old('tax_r') !='' ? '' : 'display-none' }}" id="manual_tax" >
      
      <label class="text-dark">{{ __('Tax Applied (In %)') }}<span class="text-danger">*</span></label>
      <div class="input-group mb-3">
        
        <input id="tax_r" type="number" min="0" placeholder="0" name="tax_r" class="form-control" {{ old('tax_r') ? "required" : "" }} value="{{ old('tax_r') }}">
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon2">%</span>
        </div>
      </div>
    </div>

    <div class="col-md-6 {{ old('tax_r') !='' ? '' : 'display-none' }}" id="manual_tax_name">
      <div class="form-group">
        <label class="text-dark">{{ __('Tax Name :') }}<span class="text-danger">*</span></label>
        <input {{ old('tax_r') ? "required" : "" }} type="text" id="tax_name" class="form-control"
          name="tax_name" title="{{ __("Tax rate must without % sign") }}" placeholder="{{ __("Enter Tax Name") }}"
          value="{{ old('tax_name') }}">
      </div>
    </div>

    <div class="col-md-12">
      <div class="{{ old('tax_r') ? 'display-none' : "" }}" id="tax_class">
        <label class="text-dark">
          Tax Classes:
        </label>
        <select {{ !old('tax_r') ? "required" : "" }} name="tax" id="tax_class_box" class="form-control">
          <option value="">Please Choose..</option>
          @foreach(App\TaxClass::all() as $tax)
          <option value="{{$tax->id}}"
            @if(!empty($products)){{ $tax->id == old('tax') ? 'selected="selected"' : '' }}@endif>{{$tax->title}}
          </option>
          @endforeach
        </select>
        <small class="txt-desc">({{__("Please Choose Yes Then Start Sale This Product.")}})</small>
        <img src="{{(url('images/info.png'))}}" data-toggle="modal" data-target="#taxmodal" class="img-fluid" width="15" ><br>

      </div>
    </div>


    <div class="col-md-4">
      <div class="form-group">
        <label class="text-dark">{{ __("Product tag") }} ({{ app()->getLocale() }}) :
            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{ __("It will show in front end in rounded circle with product thumbnail") }}"></i>
        </label>
        <input type="text" value="{{ old("sale_tag") }}" class="form-control" name="sale_tag" placeholder="Exclusive">
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
        <label class="text-dark">
            {{ __("Product tag text color") }} :
        </label>
        <div class="input-group initial-color">
          <input type="text" class="form-control input-lg" value="#000000"  name="sale_tag_text_color" placeholder="#000000"/>
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
        <div class="input-group initial-color" title="Using input value">
          <input type="text" class="form-control input-lg" value="#000000"  name="sale_tag_color" placeholder="#000000"/>
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
          <input class="slider" type="checkbox" name="free_shipping"  {{ old('free_shipping') ? 'checked' : '' }} />
          <span class="knob"></span>
        </label><br>
        <small class="txt-desc">({{__("If Choose Yes Then Free Shipping Start.")}})</small>
      </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __(" Featured :") }}</label><br>
      <label class="switch">
        <input class="slider" type="checkbox" name="featured"  {{ old('featured') ? 'checked' : "" }} />
        <span class="knob"></span>
      </label><br>
      <small class="txt-desc">({{__("If enable than Product will be featured")}})</small>
    </div>
    </div>

    <div class="form-group col-md-4">
        <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} </label><br>
        <label class="switch">
          <input class="slider" type="checkbox" name="status"  {{ old('status') ? 'checked' : "" }} />
          <span class="knob"></span>
        </label><br>
        <small>{{ __('(Please Choose Status)') }}</small>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark">{{ __('Cancel Available :') }}</label><br>
      <label class="switch">
          <input class="slider" type="checkbox" name="cancel_avl"  {{ old('cancel_avl')  ? 'checked' : "" }} />
          <span class="knob"></span>
        </label><br>
      <small>{{ __('(Please Choose Cancel Available )') }}</small>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-group">
      <label class="text-dark" for="first-name">{{ __('Cash On Delivery :') }}</label><br>
      <label class="switch">
        <input class="slider" type="checkbox" name="codcheck"  {{ old('codcheck') ? 'checked' : "" }} />
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
        <option {{ old('return_avbls') =='1' ? "selected" : "" }} value="1">{{ __("Return Available") }}</option>
        <option {{ old('return_avbls') =='0' ? "selected" : "" }} value="0">{{ __("Return Not Available") }}</option>
      </select>
      <br>
      <small class="text-desc">({{__("Please choose an option that return will be available for this product or not")}})</small>

    </div>
    </div>

    <div id="policy" class="{{ old('return_avbl') == 1 ? 'd-block' : 'd-none' }} form-group col-md-4">
          <label class="text-dark">
              {{ __("Select Return Policy :") }} <span class="text-danger">*</span>
          </label>
          <select data-placeholder="{{ __("Please select return policy") }}" name="return_policy"
              class="form-control choose_policy select2">
              <option value="">{{ __("Please select return policy") }}</option>

              @foreach(App\admin_return_product::where('status','1')->get() as $policy)
              <option {{ old('policy_id') == $policy->id ? "selected" : "" }}
                  value="{{ $policy->id }}">{{ $policy->name }}</option>
              @endforeach
          </select>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
            {{ __("Create")}}</button>
        </div>
    </div>
  </div>
</form>