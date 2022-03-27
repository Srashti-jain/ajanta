@extends('admin.layouts.master-soyuz')
@section('title',__("Create a Block Detail Page Advertisements | "))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Block Detail Page Advertisements") }}
@endslot

@slot('menu2')
{{ __("Block") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{ route('detailadvertise.index') }}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Add') }} {{ __('Block Detail Page Advertisements') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{route('detailadvertise.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
  
            <div class="form-group">
              <label>{{ __('Select Position:') }} <span class="required">*</span></label>
              <select required="" name="position" id="position" class="form-control select2">
                  <option value="category">On Category Page</option>
                  <option value="prodetail">On Product Detail Page</option>
              </select>
            </div>
  
             <div id="linkedPro" class="display-none form-group">
            <label>{{ __('Display Product Page:') }} <span class="required">*</span></label>
            <select name="linkedPro" id="" class="form-control select2">
                @foreach(App\Product::where('status','=','1')->get() as $pro)
                  <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                @endforeach
            </select>
            <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('Select a product page where you want to display this ad.') }}</small>
          </div>
  
          <div id="linkedCat" class="form-group">
            <label>{{ __('Display Category Page:') }} <span class="required">*</span></label>
            <select name="linkedCat" id="" class="form-control select2">
                @foreach(App\Category::where('status','=','1')->get() as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                @endforeach
            </select>
            <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('Select a category page where you want to display this ad.') }}</small>
          </div>
  
            <div class="form-group">
              <label>{{ __('Link By:') }} <span class="required">*</span></label>
              <select required="" name="linkby" id="linkby" class="form-control select2">
                  <option value="category">{{ __('By Category Page') }}</option>
                  <option value="detail">{{ __('By Product Page') }}</option>
                  <option value="url">{{ __("By Custom URL") }}</option> 
                  <option value="adsense">{{ __("By Google Adsense") }}</option>
              </select>
            </div>
  <div id="customad">
  
              <div class="form-group">
                <label>{{ __('Choose Image:') }} <span class="required">*</span></label>
                <div class="input-group mb-3">

                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                  </div>
  
  
                  <div class="custom-file">
  
                    <input type="file" name="adimage" class="inputfile inputfile-1" id="inputGroupFile01"
                      aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                  </div>
                </div>
              </div>
  
              <div id="catbox" class="form-group">
                <label>{{  __('Select Category') }}: <span class="required">*</span></label>
                <select name="cat_id" id="" class="select2 form-control">
                    @foreach(App\Category::where('status','=','1')->get() as $cat)
                      <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                    @endforeach
                </select>
              </div>
  
              <div id="probox" class="display-none form-group">
                <label>{{ __('Select Product:') }} <span class="required">*</span></label>
                <select name="pro_id" id="" class="select2 form-control">
                    @foreach(App\Product::where('status','=','1')->get() as $pro)
                      <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                    @endforeach
                </select>
                <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Select a product page so when user click on ad he/she will redirect to this product page')}} </small>
              </div>
  
              <div class="form-group">
                <label>{{ __('Heading Text:') }} </label>
                <input value="{{ old('top_heading') }}" name="top_heading" placeholder="{{ __('Enter heading text') }}" type="text" class="form-control" id="top_heading">
              </div>
  
              <div class="form-group">
                 <label>{{__('Heading Text Color:')}} </label>
                 <div class="input-group initial-color" title="Using input value">
                  <input type="text" class="form-control input-lg" value="#000000" name="hcolor" placeholder="#000000"/>
                  <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                  </span>
                </div>
                
              </div>
  
              <div class="form-group">
                <label>{{__("Subheading Text:")}} </label>
                <input value="{{ old('sheading') }}" name="sheading" placeholder="{{ __('Enter subheading text') }}" type="text" class="form-control" id="top_heading">
              </div>
  
              <div class="form-group">
                 <label>{{__("Subheading Text Color:")}} </label>
                 <div class="input-group initial-color">
                  <input type="text" class="form-control input-lg" value="#000000" name="scolor" placeholder="#000000"/>
                  <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                  </span>
                </div>
                
              </div>
  
              <div id="urlbox" class="display-none form-group">
                <label>{{ __('Custom URL:') }} </label>
                <input value="{{ old('url') }}" placeholder="http://" type="text" class="form-control" id="url" name="url">
              </div>
  
              <div class="form-group">
                <label>{{ __('Show Button:') }}</label>
                <br>
                <label class="switch">
                  <input type="checkbox" class="show_btn toggle-input toggle-buttons" name="show_btn" >
                  <span class="knob"></span>
                </label>
              </div>
  
              <div class="display-none" id="buttongroup">
                <div class="form-group">
                  <label>{{ __('Button Text:') }} </label>
                  <input value="{{ old('btn_txt') }}" placeholder="Enter button text" type="text" class="form-control" id="btn_txt" name="btn_txt">
                </div>
  
               <div class="form-group">
                   <label>{{ __('Button Text Color:') }} </label>
               
                   <div class="input-group initial-color">
                    <input type="text" class="form-control input-lg" value="#000000" name="btn_txt_color" placeholder="#000000"/>
                    <span class="input-group-append">
                      <span class="input-group-text colorpicker-input-addon"><i></i></span>
                    </span>
                  </div>
                </div>
               
  
                <div class="form-group">
                   <label>{{ __('Button Background Color:') }} </label>
                 
                   <div class="input-group initial-color" title="Using input value">
                    <input type="text" class="form-control input-lg" value="#000000" name="btn_bg" placeholder="#000000"/>
                    <span class="input-group-append">
                      <span class="input-group-text colorpicker-input-addon"><i></i></span>
                    </span>
                  </div>
                </div>
  
              </div>
           
  
            <div id="adsenseBox" class="display-none form-group">
              <label>{{ __('Google Adsense Code:') }} </label>
              <textarea name="adsensecode" cols="30" rows="5" placeholder="{{ __('Paste your Adsense code script here') }}" class="form-control">{{ old('adsensecode') }}</textarea> 
            </div>
  
          <div class="form-group">
            <label>{{ __('Status:') }}</label>
            <br>
            <label class="switch">
              <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="status" checked>
              <span class="knob"></span>
            </label>
         </div>
  
         
      
  
      <div class="form-group">
        <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
          {{ __("Reset") }}</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
          {{ __("Create") }}</button>
      </div>

      <div class="clear-both"></div>
      </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection        
@section('custom-script')
  <script src="{{ url('js/detailads.js') }}"></script>
@endsection
