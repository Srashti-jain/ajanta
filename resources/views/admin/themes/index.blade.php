@extends('admin.layouts.master-soyuz')
@section('title',__('Color Settings | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Color Settings') }}
@endslot
@slot('menu1')
   {{ __('Color Settings') }}
@endslot




@endcomponent

<div class="contentbar">   

    <div class="row">
  
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
				  <h5 class="card-title"> {{__("Color Settings")}}</h5>
			    </div>
                
                <div class="card-body">
					<div class="table-responsive">
                        <form action="{{ route('admin.theme.update') }}" method="POST">
                            @csrf
                            <div class="row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Choose Pattern :') }} </label>
                                <br>
                                <select required class="theme_pattern form-control select2" name="key" id="key">
                                  
                
                                    <option value="default" {{ $themesettings && $themesettings->key == 'default' ? "selected" : "" }}>{{ __("Default Theme") }}</option>
                
                                    <option {{ $themesettings && $themesettings->key == 'pattern1' ? "selected" : "" }} value="pattern1">{{__("Pattern")}} 1</option>
                
                                    <option {{ $themesettings && $themesettings->key == 'pattern2' ? "selected" : "" }} value="pattern2">{{__("Pattern")}} 2</option>
                
                                    <option {{ $themesettings && $themesettings->key == 'pattern3' ? "selected" : "" }} value="pattern3">{{__("Pattern")}} 3</option>
                
                                    <option {{ $themesettings && $themesettings->key == 'pattern4' ? "selected" : "" }} value="pattern4">{{__("Pattern")}} 4</option>
                
                                    <option {{ $themesettings && $themesettings->key == 'pattern5' ? "selected" : "" }} value="pattern5">{{__("Pattern")}} 5</option>
                
                                </select>
                            </div>
                
                            <div style="{{ $themesettings && $themesettings['key'] == 'default' ? "display:none;" : "" }}" class="color_options form-group col-md-6">
                                <label>{{ __('Choose Color Scheme :') }} </label>
                                <br>
                                <select {{ $themesettings && $themesettings['key'] != 'default' ? 'required' : "" }} class="theme_pattern_options form-control select2" name="theme_pattern_options" id="theme_pattern_options">
                
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'yellow_blue' ? "selected" : "" }} value="yellow_blue">Yellow + Blue</option>
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'gold_blue' ? "selected" : "" }} value="gold_blue">Gold + Blue</option>
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'marron_brown' ? "selected" : "" }} value="marron_brown">Marron + Brown</option>
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'greenlight_greendark' ? "selected" : "" }} value="greenlight_greendark">Green Light + Green Dark</option>
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'greendark_greenlight' ? "selected" : "" }} value="greendark_greenlight">Green Dark + Green Light</option>
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'yellow_darkblue' ? "selected" : "" }} value="yellow_darkblue">Yellow + Dark Blue</option>
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'darkpink_darkgrey' ? "selected" : "" }} value="darkpink_darkgrey">Dark Pink + Dark Grey</option>
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'lightgrey_lightgold' ? "selected" : "" }} value="lightgrey_lightgold">Light Grey + Light Gold</option>
                
                                    <option {{ $themesettings && $themesettings->theme_name == 'black_lightblue' ? "selected" : "" }} value="black_lightblue">Black + Light Blue</option>
                                
                                </select>
                            </div>
                            
                        </div>
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                <button  type="submit"class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}</button>
                                
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
        $('.theme_pattern').on('change',function(){

            var pattern = $(this).val();

            if(pattern == 'pattern1'){
                $('.color_options').show();
            }

            if(pattern == 'pattern2'){
                $('.color_options').show();
            }

            if(pattern == 'pattern3'){
                $('.color_options').show();
            }

            if(pattern == 'pattern4'){
                $('.color_options').show();
            }

            if(pattern == 'pattern5'){
                $('.color_options').show();
            }

            if(pattern == 'default'){
                $('.color_options').hide();
               
            }


        });
    </script>
@endsection        
    
                