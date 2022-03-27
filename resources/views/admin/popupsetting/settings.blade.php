@extends('admin.layouts.master-soyuz')
@section('title',__('Offer popup settings |'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Offer popup settings') }}
@endslot
​
@slot('menu2')
{{ __("Offer Popup ") }}
@endslot​
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
          <h5 class="box-title">{{__("Offer Popup Settings")}}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12  p-3 mb-2 bg-success rounded text-white">
                    <i class="fa fa-info-circle"></i> {{__("Note:")}}

                    <ul>
                        <li> 
                            {{__("For translate text in different languages you can switch language from top bar than change the language and update the translations.")}}
                        </li>
                       
                       
                    </ul>
                </div>
                
            </div>
            
         

            <form action="{{ route('offer.update.settings') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-12">
                        <label class="text-dark"> {{__("Enable Offer popup ?")}} </label>
                        <br>
                        <label class="switch">
                            <input {{ isset($settings) && $settings->enable_popup || old('enable_popup') ? "checked" : "" }} id="enable_popup" type="checkbox" name="enable_popup">
                            <span class="knob"></span>
                        </label>
                    </div>

                    <hr>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="text-dark">{{ __("Offer popup image :") }} <span class="text-danger">*</span></label>
                            <!--  -->
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                                </div>
                            </div>
                            <!--  -->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="text-dark">{{__("Heading Text")}} ({{__("in")}} {{ app()->getLocale() }}) : <span class="text-danger">*</span></label>
                            <input value="{{ $settings->heading ?? old('heading') }}" required type="text" class="form-control" name="heading" placeholder="{{ __('Enter heading text') }} in {{ app()->getLocale() }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="text-dark">{{__("Heading Text Color :")}} <span class="text-danger">*</span></label>
                            <div class="input-group initial-color">
                                <input type="text" class="form-control input-lg" value="{{ $settings->heading_color ?? old('heading_color') }}" name="heading_color" placeholder="#000000"/>
                                <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                </span>
                            </div>
                           
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="text-dark">{{__("Subheading Text")}} ({{__("in")}} {{ app()->getLocale() }}) : <span class="text-danger">*</span> </label>
                            <input value="{{ $settings->subheading ?? old('subheading') }}" required type="text" class="form-control" name="subheading" placeholder="Enter subheading text in {{ app()->getLocale() }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="text-dark">{{__('Subheading Text Color:')}} <span class="text-danger">*</span></label>
                            <div class="input-group initial-color">
                                <input type="text" class="form-control input-lg" value="{{ $settings->subheading_color ?? old('subheading_color') }}" name="subheading_color" placeholder="#000000"/>
                                <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                </span>
                            </div>
                            
                         
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="text-dark">{{__("Description Text")}} ({{__("in")}} {{ app()->getLocale() }}) :</label>
                            <input value="{{ $settings->description ?? old('description') }}" type="text" class="form-control" name="description" placeholder="{{__("Enter description text in")}} {{ app()->getLocale() }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="text-dark">{{ __("Description Text Color:") }}</label>
                            <div class="input-group initial-color">
                                <input type="text" class="form-control input-lg" value="{{ $settings->description_text_color ?? old('description_text_color') }}" name="description_text_color" placeholder="#000000"/>
                                <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                </span>
                            </div>
                           
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="text-dark">
                            {{__("Enable Button in popup ?")}}
                        </label>
                        <br>
                        <label class="switch">
                            <input {{ isset($settings) && $settings->enable_button || old('enable_button') ? "checked" : "" }} id="enable_button" type="checkbox" name="enable_button">
                            <span class="knob"></span>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="text-dark">{{__("Button Text")}} ({{__("in")}} {{ app()->getLocale() }}) : </label>
                            <input value="{{ $settings->button_text ?? old('button_text') }}" type="text" class="form-control" name="button_text" placeholder="{{__("Enter button text in")}} {{ app()->getLocale() }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="text-dark">{{__("Button Link")}} ({{__("in")}} {{ app()->getLocale() }}) : </label>
                            <input value="{{ $settings->button_link ?? old('button_link') }}" type="text" class="form-control" name="button_link" placeholder="{{__("Enter button link")}} eg:https://">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-dark">{{ __('Button Text Color:') }}</label>
                            <div class="input-group initial-color" >
                                <input type="text" class="form-control input-lg" value="{{ $settings->button_text_color ?? old('button_text_color') }}" name="button_text_color" placeholder="#000000"/>
                                <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                </span>
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-dark">{{ __('Button Background Color:') }}</label>
                            <div class="input-group initial-color" >
                                <input type="text" class="form-control input-lg" value="{{ $settings->button_color ?? old('button_color') }}" name="button_color"  placeholder="#000000"/>
                                <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                </span>
                            </div>
                          
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-save mr-2"></i>{{ __("Save")}}</button>
                        </div>
                    </div>

                </div>   

            </form>
         <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

