<form action="{{url('seller/products/')}}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="row">

    <div class="form-group col-md-6">
      <label for="first-name">
        {{ __("Product Name") }}: <span class="required">*</span>
      </label>
      <input required="" placeholder="{{ __('Please enter product name') }}" type="text" id="first-name" autofocus="" name="name"
      value="{{ old('name') }}" class="form-control">
    </div>


    <div class="form-group col-md-6">
      <label>
        {{ __('Select Brand') }}: <span class="required">*</span>
      </label>
      <select required="" name="brand_id" class="select2 form-control col-md-7 col-xs-12">
        <option value="">{{ __('Please Select') }}</option>
        @if(!empty($brands_products))
        @foreach($brands_products as $brand)
          <option value="{{$brand->id}}">{{$brand->name}} </option>
        @endforeach
        @endif
      </select>
    </div>



    <div class="form-group last_btn col-md-4">
      <label for="first-name">
        {{ __('Category') }}: <span class="required">*</span>
      </label>

      <select required="" name="category_id" id="category_id" class="form-control select2">
        <option value="">{{ __('Please Select') }}</option>

        @if(!empty($categorys))
        @foreach($categorys as $category)
        <option value="{{$category->id}}"> {{$category->title}} </option>
        @endforeach
        @endif

      </select>
    </div>

    <div class="form-group last_btn col-md-4">

      <label>
        {{ __('Subcategory') }}: <span class="required">*</span>
      </label>

      <select required="" name="child" id="upload_id" class="form-control select2">
        <option value="">{{ __('Please Select') }}</option>
        @if(!empty($child))
        @foreach($child as $category)
        <option value="{{$category->id}}"> {{$category->title}}
        </option>
        @endforeach
        @endif
      </select>
    </div>

    <div class="col-md-12 last_btn">
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

    <div class="form-group last_btn col-md-4">

      <label>
        {{ __('Child Category') }}:
      </label>

      <select name="grand_id" id="grand" class="form-control select2">

        @if(!empty($child))
        @foreach($grand as $category)
          <option value="{{$category->id}}"> {{$category->title}}
          </option>
        @endforeach
        @endif
      </select>

    </div>


    <div class="form-group last_btn col-md-4">
      <label>
        {{ __('Store') }}:
      </label>
      <select required="" name="store_id" class="form-control select2">
        <option value="{{Auth::user()->store->id}}">{{Auth::user()->store->name}}</option>
      </select>
      <small class="txt-desc">({{ __('Please Choose Store Name') }})</small>
    </div>
      




    <div class="form-group  last_btn col-md-4">
      <label>{{ __('Upload product catlog') }}:</label>
      <div class="input-group">
        <div class="custom-file">
          <input type="file" name="catlog" class="custom-file-input" id="catlog" aria-describedby="inputGroupFileAddon01">
          <label class="custom-file-label" for="catlog">{{ __('Choose catlog') }}</label>
        </div>
      </div>
      <small class="txt-desc">({{ __('Catlog file max size') }}: 1MB ) | {{ __('Supported files : pdf,docs,docx,ppt,txt') }}</small>
     
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

    <div class="form-group  col-md-12">
      <label for="first-name"> {{ __('Key Features') }}:
      </label>
      <textarea class="form-control" id="editor2" name="key_features">{{ old('key_features') }}
      </textarea>
    </div>

    <div class="form-group  col-md-12 ">
      <label for="first-name">{{ __('Description') }}:
      </label>
      <textarea id="editor1" name="des">{{ old('des') }}</textarea>
    </div>

    <div class="form-group  col-md-6">
      <label for="first-name">{{__('Product Video Preview')}}: </label>
      <input name="video_preview" value="{{ old('video_preview') }}" type="text" class="form-control" placeholder="eg: https://youtube.com/watch?v=">
      <small class="text-muted">
          • {{__('Supported urls are')}} : <b>Youtube,vimeo, only.</b>
      </small>
    </div>

    <div class="form-group col-md-6">
      <label for="first-name">{{__("Product Video Thumbnail")}}:</label>
      <div class="input-group">
        <div class="custom-file">
          <input type="file"name="video_thumbnail" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
          <label class="custom-file-label" for="inputGroupFile01">
            {{__("Choose video thumbnail")}}
          </label>
        </div>
      </div>
     
      <small class="text-muted">
          • {{__("Max upload size is")}} <b>500KB.</b>
      </small>
    </div>


    <div class="form-group  col-md-4 ">
      <label for="warranty_info">{{__("Warranty")}}:</label>

      <label>({{ __('Duration') }})</label>
      <select class="form-control select2" name="w_d" id="">
        <option>{{__('None') }} </option>
        @for($i=0;$i<=12;$i++) <option value="{{ $i }}">{{ $i }}</option>
          @endfor
      </select>
    </div>

    <div class="form-group  col-md-4">
      <label>{{ __('Days/Months/Year') }}:</label>

      <select class="form-control select2" name="w_my" id="">
        <option>{{ __('None') }}</option>
        <option value="day">{{ __('Day') }}</option>
        <option value="month">{{ __('Month') }}</option>
        <option value="year">{{ __('Year') }}</option>
      </select>
    </div>

    <div class="form-group  col-md-4">
      <label>{{ __("Type")}}:</label>
      <select class="form-control select2" name="w_type" id="">
        <option>{{ __('None') }}</option>
        <option value="Guarantee">{{ __('Guarantee') }}</option>
        <option value="Warranty">{{ __('Warranty') }}</option>
      </select>
    </div>

    <div class="form-group  col-md-6 ">
      <label>
       {{__("Start selling from")}}:
      </label>
    
        <div class="input-group">
            <input type="text" class="timepickerwithdate form-control" placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5" />
            <div class="input-group-append">
                <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
            </div>
        </div>
    
  </div>

     



    <div class="form-group  col-md-6">
      <label>
        {{__('Tags')}}:
      </label>

      <input placeholder="{{ __('Please enter tags seprated by comma') }}" type="text" id="first-name" name="tags"
        data-role="tagsinput" value="{{ old('tags') }}" class="form-control">
    </div>

    <div class="form-group col-md-12">
      <div class="row">
        <div class="col-md-4">
          <label>
            {{__('Model')}}:
          </label>

          <input type="text" id="first-name" name="model" class="form-control" placeholder="{{ __('Please Enter Model Number') }}"
            value="{{ old('model') }}">
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>{{__('HSN/SAC')}} : <span class="required">*</span></label>
            <input required placeholder="{{ __("Enter product HSN/SAC code") }}" type="text"
                class="form-control" name="hsn" value="{{ old('hsn') }}">
          </div>
        </div>

        <div class="col-md-4">
          <label for="first-name">
            {{__('SKU')}}:
          </label>
          <input type="text" id="first-name" name="sku" value="{{ old('sku') }}" placeholder="{{ __("Please enter SKU") }}"
            class="form-control">
        </div>



      </div>
    </div>

    <div class="form-group  col-md-12">
      <label class="switch">

        <input checked type="checkbox" id="tax_manual" class="toggle-input toggle-buttons" name="tax_manual">
        <span class="knob"></span>

      </label>
      <label class="product-tax-include">{{__("Price Including Tax")}} ?</label>

    </div>

    <div class="form-group  col-md-4">

      <label>
        Price: <span class="required">*</span> </label> <br>
        <span class="help-block">({{__("Price you entering is in")}} {{ $genrals_settings->currency_code }})</span>
     

      <input title="{{ __("Offer price Format must be in this format :value",['value' => ': 200 or 200.25' ]) }} " pattern="[0-9]+(\.[0-9][0-9]?)?"
        required="" type="text" id="first-name" name="price" value="{{ old('price') }}"
        placeholder="{{ __('Please enter product price') }}" class="form-control">

      
      <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Don\'t put comma while entering PRICE') }}</small>

    </div>

    <div class="form-group  col-md-4">

      <label>
        {{ __('Offer Price') }}: </label><br>
        <span class="help-block">({{__("Offer Price you entering is in")}} {{ $genrals_settings->currency_code }})</span>
     
      <input title="{{__("Offer price Format must be in this format :value",['value' => ': 200 or 200.25' ])}}" pattern="[0-9]+(\.[0-9][0-9]?)?"
        type="text" id="first-name" name="offer_price" class="form-control"
        placeholder="{{ __('Please enter product offer price') }}" value="{{ old('offer_price') }}">

      
      <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Don\'t put comma whilt entering OFFER PRICE') }}</small>

    </div>

    <div class="form-group  col-md-4">

      <label>
        {{__('Gift Packaging Charge')}}:</label><br>
        <span class="help-block">({{__('Gift Packaging Charge you entering is IN')}} {{ $defCurrency->currency->code }})</span>
      
      <input title="{{__("Gift Packaging price Format must be in this format",['value' => ': 200 or 200.25' ])}} " pattern="[0-9]+(\.[0-9][0-9]?)?"
        type="text" name="gift_pkg_charge" class="form-control"
        value="{{ old('gift_pkg_charge') }}">
     
      <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('PUT 0 if you don\'t want to enable gift packaging for this product.') }}</small>

    </div>

    <div class="col-md-12" id="manual_tax">
<div class="row">
  <div class="col-md-6">
    <label>{{__("Tax Applied (In %)")}} <span class="required">*</span></label>
   
      <input  value="{{ old('tax_r') }}"  type="number" min="0"
      class="form-control" name="tax_r" step="0.01" placeholder="0">
  
     
  </div>
  <div class="col-md-6">
    <label>{{__('Tax Name:')}} <span class="required">*</span></label>
    <input value="{{ old('tax_name') }}" type="text" id="tax_name" class="form-control" name="tax_name"
      placeholder="{{ __('Enter Tax Name') }}">
  </div>
</div>
    
      

    </div>


    <div class="form-group  col-md-12 mt-2">


      <div class="hide" id="tax_class">
        <label>
          {{__("Tax Classes")}}:
        </label>
        <select id="tax_class_box" name="tax" class="form-control select2">
          <option value="">{{ __('Please Choose') }}</option>
          @foreach(App\TaxClass::all() as $tax)
          <option value="{{$tax->id}}">{{$tax->title}}</option>
          @endforeach
        </select>
        <small class="txt-desc">({{__('Please choose tax class')}})</small>
     
        <img src="{{(url('images/info.png'))}}" data-toggle="modal" data-target="#taxmodal" class="height-15"><br>
      </div>


    </div>


    <div class="form-group  col-md-4">
      <label>
          {{ __("Product tag") }} ({{ app()->getLocale() }}) :
          <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{ __("It will show in front end in rounded circle with product thumbnail") }}"></i>
      </label>

      <input type="text" value="{{ old("sale_tag") }}" class="form-control" name="sale_tag" placeholder="Exclusive">
      
    </div>

    <div class="col-md-4">
      <label>
          {{ __("Product tag text color") }} :
      </label>
      <div class="input-group initial-color" title="Using input value">
        <input type="text" class="form-control input-lg" value="#000000" name="sale_tag_text_color" placeholder="#000000"/>
        <span class="input-group-append">
          <span class="input-group-text colorpicker-input-addon"><i></i></span>
        </span>
      </div>

      
     
    </div>
    
    <div class="col-md-4">
      <label>
            {{ __("Product tag background color") }} :
        </label>
        <div  class="input-group initial-color">
          <input type="text" class="form-control input-lg" value="#000000" name="sale_tag_color" placeholder="#000000"/>
          <span class="input-group-append">
            <span class="input-group-text colorpicker-input-addon"><i></i></span>
          </span>
        </div>
        

    </div>


    <div class="col-md-4">


      <label>
        {{__('Free Shipping')}}:
      </label><br>
      <label class="switch">

        <input checked type="checkbox" id="tax_manual" class="toggle-input toggle-buttons" name="free_shipping">
        <span class="knob"></span>

      </label><br>

   

      <small class="txt-desc">({{__('If Enabled Then Free Shipping will enabled for this product')}}) </small>

    </div>

    <div class="col-md-4">
      <label for="first-name">
        {{ __("Status") }}:
      </label>
      <br>
      <label class="switch">

        <input checked type="checkbox" id="toggle-event3" class="toggle-input toggle-buttons" >
        <span class="knob"></span>
        <input @if(!empty($products)) value="{{ $products->status }}" @else value="0" @endif type="hidden" name="status"
        id="status3">
         </label><br>

      
      <small class="txt-desc">({{__('Please Choose Status')}})</small>

    </div>

    <div class="col-md-4">
      <label for="first-name">
       {{__("Cancel available?")}}:
      </label><br>
      <label class="switch">

        <input checked type="checkbox"  id="toggle-event4" class="toggle-input toggle-buttons" >
        <span class="knob"></span>
        
       <input type="hidden" name="cancel_avl" id="status4">
         </label><br>

    

     
      <small class="txt-desc">({{__('Please toggle cancel status if product is cancellable after order')}})</small>
    </div>

    <div class="col-md-4">
      <label for="first-name">
        {{__("Cash On Delivery")}}:
      </label><br>
      <label class="switch">

        <input checked type="checkbox"  id="codcheck" name="codcheck" class="toggle-input toggle-buttons" >
        <span class="knob"></span>
        
       <input type="hidden" name="cancel_avl" id="status4">
         </label><br>


      

      <small class="txt-desc">({{__('Please choose Cash on Delivery available on this product or not')}})</small>
    </div>



    <div class="last_btn col-md-12">

      <div class="row">

        <div class="col-md-4">
          <label for="">{{__('Return Available')}} :</label>
          <select required id="choose_policy" class="form-control select2" name="return_avbls">
            <option value="">{{__('Please choose an option') }}</option>
            <option value="1">{{ __('Return Available') }}</option>
            <option value="0">{{ __('Return Not Available') }}</option>
          </select>
          <br>
          <small class="text-desc">({{__("Please choose an option that return will be available for this product or not")}})</small>


        </div>

        <div id="policy" class="col-md-4 'display-none'">
          <label for="">{{__("Choose Return Policy")}}: </label>
          <select class="form-control select2" id="return_policy" name="return_policy">
            <option value="">{{__('Please choose an option') }}</option>
            @foreach(App\admin_return_product::where('status','1')->get() as $policy)
              <option value="{{ $policy->id }}">{{ $policy->name }}</option>
            @endforeach
          </select>
          <br>
          <small class="text-desc">({{__("Please choose an option that return will be available for this product or not")}})</small>


        </div>


      </div>


    </div>

    <div class="col-md-6 mt-2">
      <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
      <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
      {{ __("Create")}}</button>
    </div>

    <!-- Main row End-->
  </div>

</form>
