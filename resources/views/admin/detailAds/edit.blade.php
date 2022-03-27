@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Block Detail Page Advertisements'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Block Detail Page Advertisements") }}
@endslot

@slot('menu2')
{{ __("Edit Block Detail Page Advertisements") }}
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
          <h5 class="box-title">{{ __('Edit Block Detail Page Advertisements') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{route('detailadvertise.update',$detail->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group">
              <label>{{ __('Select Position:') }} <span class="required">*</span></label>
              <select required="" name="position" id="position" class="form-control select2">
                <option {{ $detail->position == 'category' ? "selected" : "" }} value="category"> 
                  {{__("On Category Page")}}
                </option>
                <option {{ $detail->position == 'prodetail' ? "selected" : "" }} value="prodetail">
                  {{__('On Product Detail Page')}}
                </option>
              </select>
            </div>

            <div id="linkedPro" class="form-group {{ $detail->position == 'prodetail' ? '' : 'display-none' }}">
              <label>{{ __('Display Product Page:') }} <span class="required">*</span></label>
              <select name="linkedPro" id="" class="select2 form-control">
                @foreach(App\Product::where('status','=','1')->get() as $pro)
                <option {{ $detail->linked_id == $pro->id ? "selected" : "" }} value="{{ $pro->id }}">{{ $pro->name }}
                </option>
                @endforeach
              </select>
              <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('Select a product page where you want to display this ad.') }}</small>
            </div>

            <div id="linkedCat" class="form-group {{ $detail->position == 'category' ? '' : 'display-none' }}">
              <label>{{ __('Display Category Page:') }} <span class="required">*</span></label>
              <select name="linkedCat" id="" class="form-control select2">
                @foreach(App\Category::where('status','=','1')->get() as $cat)
                <option {{ $detail->linked_id == $cat->id ? "selected" : "" }} value="{{ $cat->id }}">{{ $cat->title }}
                </option>
                @endforeach
              </select>
              <small class="text-info"><i class="fa fa-question-circle"></i> {{ __("Select a category page where you want to display this ad.") }}</small>
            </div>

            <div class="form-group">
              <label>{{ __('Link By:') }} <span class="required">*</span></label>
              <select required="" name="linkby" id="linkby" class="form-control select2">
                <option {{ $detail->linkby == 'category' ? "selected" : "" }} value="category">{{ __("By Category Page") }}</option>
                <option {{ $detail->linkby == 'detail' ? "selected" : "" }} value="detail">{{ __('By Product Page') }}</option>
                <option {{ $detail->linkby == 'url' ? "selected" : "" }} value="url">{{ __('By Custom URL') }}</option>
                <option {{ $detail->linkby == 'adsense' ? "selected" : "" }} value="adsense">{{ __('By Google Adsense') }}</option>
              </select>
            </div>



            <div class="{{ $detail->linkby == 'adsense' ? 'display-none' : "" }}" id="customad">

              <div class="form-group">
                <label>{{ __('Choose Image:') }} <span class="required">*</span></label>
                <div class="input-group mb-3">

                  <div class="custom-file">
  
                    <input type="file" name="adimage" class="inputfile inputfile-1" id="inputGroupFile01"
                      aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                  </div>
                </div>
              
              </div>

              <div class="form-group">
                <label>{{ __('Preview') }}: </label>
                <br>
                <img class="pro-img" id="adPreview" src="{{ url('images/detailads/'.$detail->adimage) }}">
              </div>

              <div id="catbox" class="form-group {{ $detail->linkby == 'category' ? '' : 'display-none' }}">
                <label>{{  __('Select Category') }}: <span class="required">*</span></label>
                <select name="cat_id" id="" class="select2 form-control">
                  @foreach(App\Category::where('status','=','1')->get() as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                  @endforeach
                </select>
              </div>

              <div id="probox" class="form-group {{ $detail->linkby == 'detail' ? '' : 'display-none' }}">
                <label>{{ __('Select Product:') }} <span class="required">*</span></label>
                <select name="pro_id" id="" class="select2 form-control">
                  @foreach(App\Product::where('status','=','1')->get() as $pro)
                  <option {{ $detail->pro_id == $pro->id ? "selected" : "" }} value="{{ $pro->id }}">{{ $pro->name }}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>{{ __('Heading Text:') }} </label>
                <input value="{{ $detail->top_heading }}" name="top_heading" placeholder="{{ __('Enter heading text') }}"
                  type="text" class="form-control" id="heading">
              </div>

              <div class="form-group">
                <label>{{__("Heading Text Color")}}: </label>
                <div class="input-group initial-color" title="Using input value">
                  <input type="text" class="form-control input-lg" value="{{ $detail->hcolor ? $detail->hcolor  : '#000000' }}" name="hcolor"
                    placeholder="#000000" />
                  <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                  </span>
                </div>
              </div>

            </div>

            <div class="form-group">
              <label>{{__('Subheading Text')}}: </label>
              <input value="{{ $detail->sheading }}" name="sheading" placeholder="{{ __('Enter subheading text') }}" type="text"
                class="form-control" id="top_heading">
            </div>

            <div class="form-group">
              <label>{{ __('Subheading Text Color') }}: </label>
              <div class="input-group initial-color">
                <input type="text" class="form-control input-lg" value="{{ $detail->scolor ? $detail->scolor  : '#000000' }}" name="scolor"
                  placeholder="#000000" />
                <span class="input-group-append">
                  <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
              </div>

            </div>

            <div class="form-group">
              <label>{{ __('Show Button:') }}</label>
              <br>
              <label class="switch">
                <input {{ $detail->show_btn == 1 ? "checked" : "" }} type="checkbox"
                  class="show_btn toggle-input toggle-buttons" name="show_btn">
                <span class="knob"></span>
              </label>
            </div>

            <div id="urlbox" class="form-group {{ $detail->linkby == 'url' ? "" : 'display-none' }}">
              <label>{{ __('Custom URL:') }} </label>
              <input value="{{ $detail->url }}" placeholder="http://" type="url" class="form-control" id="url"
                name="url">
            </div>

            <div class="{{ $detail->show_btn == 1 ? "" : 'display-none' }}" id="buttongroup">
              <div class="form-group">
                <label>{{ __('Button Text:') }} </label>
                <input value="{{ $detail->btn_text }}" placeholder="{{ __('Enter button text') }}" type="text" class="form-control"
                  id="btn_txt" name="btn_txt">
              </div>

              <div class="form-group">
                <label>{{ __('Button Text Color:') }} </label>
                <div class="input-group initial-color">
                  <input type="text" class="form-control input-lg"  value="{{ $detail->btn_txt_color  ? $detail->btn_txt_color  : '#000000' }}"
                    name="btn_txt_color" placeholder="#000000" />
                  <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                  </span>
                </div>

              </div>

              <div class="form-group">
                <label>{{ __('Button Background Color:') }} </label>
                <div class="input-group initial-color" title="Using input value">
                  <input type="text" class="form-control input-lg" value="{{ $detail->btn_bg_color ? $detail->btn_bg_color  : '#000000' }}"
                    name="btn_bg" placeholder="#000000" />
                  <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                  </span>
                </div>

              </div>


              <div id="adsenseBox" class="form-group {{ $detail->linkby == 'adsense' ? '' : 'display-none' }}">
                <label>{{ __('Google Adsense Code:') }} </label>
                <textarea name="adsensecode" cols="30" rows="5" placeholder="Paste your Adsense code script here"
                  class="form-control">{{ $detail->adsensecode }}</textarea>
              </div>


              <div class="form-group">
                <label>{{ __('Status:') }}</label>
                <br>
                <label class="switch">
                  <input type="checkbox" {{ $detail->status == 1 ? "checked" : "" }}
                    class="quizfp toggle-input toggle-buttons" name="status">
                  <span class="knob"></span>
                </label>
              </div>
              </div>

              <div class="form-group">
                <button @if(env('DEMO_LOCK')==0) type="reset" @else disabled
                  title="{{ __('This operation is disabled is demo !') }}" @endif class="btn btn-danger"><i class="fa fa-ban"></i>
                  {{ __("Reset") }}</button>
                <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                  title="{{ __('This operation is disabled is demo !') }}" @endif class="btn btn-primary"><i
                    class="fa fa-check-circle"></i>
                  {{ __("Update") }}</button>
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