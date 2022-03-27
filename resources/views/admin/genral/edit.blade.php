@extends('admin.layouts.master-soyuz')
@section('title',__('General Settings | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Front Settings") }}
@endslot

@slot('menu2')
{{ __("General Settings") }}
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

      @if(session()->has('support_ping'))
        <div class="alert alert-danger alert-dismissible fade show">
          <i class="feather icon-alert-circle"></i> {!! session()->get('support_ping') !!}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <div class="card m-b-30">
        <div class="card-header">
          <a href="{{ url()->previous() }}" class="float-right btn btn-md btn-primary-rgba"><i
              class="feather icon-arrow-left"></i> {{ __("Back") }}</a>
          <h4 class="card-title">{{ __("General Settings") }}</h4>

        </div>
        <div class="card-body ml-2">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/genral/')}}"
            data-parsley-validate>
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>
                    {{__("Project Name")}}: <span class="required">*</span>
                  </label>

                  <input placeholder="{{ __('Please enter Project name') }}" type="text" id="a1" name="APP_NAME"
                    value="{{ env('APP_NAME') }}" class="form-control currency-icon-picker ">
                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('Project name is basically your Project Title')}}.</small>
                </div>
              </div>

              <div class="col-md-6">

                <div class="form-group">
                  <label>{{__('Default Email')}}:</label>
                  <input placeholder="{{ __('Please Enter Email (info@example.com)') }}" type="text" id="first-name" name="email"
                    value="{{$row->email ?? ''}}" class="form-control">
                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Default email will be used by yourcustomer for contacting you.') }}</small>
                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">
                  <label>{{ __('APP URL:') }}</label>
                  <input placeholder="http://" type="text" id="first-name" name="APP_URL" value="{{ env("APP_URL") }}"
                    class="form-control">
                  <small class="text-muted"><i class="fa fa-warning"></i> {{ __('Try changing domain will cause serious error.') }}</small>
                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">
                  <label>{{ __('Mobile') }}:</label>

                  <input placeholder="{{ __('Please enter mobile no.') }}" type="text" id="first-name" name="mobile"
                    value="{{$row->mobile ?? ''}}" class="form-control">

                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Please enter valid mobile no (it will also show in your site footer).') }}</small>
                </div>

              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>{{ __('Copyright Text') }}:</label>

                  <input placeholder="{{ __('Please enter copyright text') }}" type="text" id="first-name" name="copyright"
                    value="{{$row->copyright ?? ''}}" class="form-control">

                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Copyright text will be shown in your site footer don\'t put YEAR on text.') }}</small>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>
                    {{__('Default Currency')}}:
                  </label>

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                        <i class="fa {{ $defCurrency->currency_symbol }}"></i>
                      </span>
                    </div>
                    <input value="{{ $defCurrency->currency->code }}" readonly name="currency_code" type="text"
                      class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Default currency can be customized in Multiple Currency setting.') }}</small>
                </div>
              </div>





              <div class="col-md-6">

                <div class="row">
                  <div class="col-md-9">
                    <label>{{__("Logo")}}:</label>
                    <div class="input-group mb-3">

                      
                        <input readonly id="chooselogo" name="logo" type="text" class="form-control">
                        <div class="input-group-append">
                          <span data-input="chooselogo" class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                        </div>
                      

                      
                    </div>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("Please choose a site logo")}} ({{__("supported format:")}} <b>PNG, JPG, JPEG, GIF, WEBP</b>).</small>
                  </div>

                  <div class="col-custom col-md-3">
                    @if(!empty($row))
                    <div class="bg-primary-rgba p-3">

                      <img title="Current Logo" src=" {{url('images/genral/'.$row->logo)}}" class="img-fluid">

                    </div>
                    @endif
                  </div>
                </div>


              </div>

              <div class="col-md-6">

                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label>{{__("Favicon")}}:</label>
                      <div class="input-group mb-3">

                        <input readonly id="choosefevicon" name="fevicon" type="text" class="form-control">
                        <div class="input-group-append">
                          <span data-input="choosefevicon" class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                        </div>

                        
                      </div>
                      <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("Please choose a site favicon")}} ({{__('supported format:')}} <b>PNG, JPG, JPEG, ICO</b>).</small>
                    </div>
                  </div>

                  <div class="col-custom col-md-4">
                    @if(!empty($row))
                    <div class="bg-primary-rgba p-3">
                      <center><img title="Current Favicon" src=" {{url('images/genral/'.$row->fevicon)}}"
                          class="pro-img"></center>
                    </div>
                    @endif
                  </div>
                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">
                  <label>{{__('Address')}}:</label>

                  <textarea rows="3" cols="10" value="{{old('address' ?? '')}}" name="address"
                    class="form-control">{{$row->address ?? ''}}</textarea>
                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Please enter address (it will also show in your site footer).') }}</small>
                </div>

              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" for="first-name">
                    {{__('Cart Amount')}}: <span class="required">*</span>
                  </label>

                  <input type="text" name="cart_amount" value="{{$row->cart_amount ?? ''}}" onkeyup="sync()"
                    class="form-control">
                  <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("Enter cart amount eg. 500 so if user cart amount is greater or equal to this amount than shipping will be free")}} ({{__('Put')}} <b>0</b> {{__("for disable it")}}).</small>
                </div>
              </div>

              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <label for="handlingcharge">{{__('Handling Charges')}}:</label>


                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                          <i class="fa {{ $defCurrency->currency_symbol }}"></i>
                        </span>
                      </div>
                      <input step="0.1" placeholder="0.00" type="number" value="{{ $row->handlingcharge }}"
                        name="handlingcharge" class="form-control" aria-describedby="basic-addon1">
                    </div>

                  </div>

                  <div class="col-md-6">
                    <label for="chargeterm">{{__('Charging term')}}: </label>
                    <select class="select2 form-control" name="chargeterm" id="">
                      <option {{ $row->chargeterm == 'pi' ? "selected" : "" }} value="pi">Per Item</option>
                      <option {{ $row->chargeterm == 'fo' ? "selected" : "" }} value="fo">on full order</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">

                <div class="row">
                  <br>
                  <div class="col-md-10">
                    <div class="form-group">
                      <label>{{__('Preloader')}}:</label>
                      <div class="input-group mb-3">


                        <div class="custom-file">

                          <input type="file" name="preloader" class="inputfile inputfile-1" id="choosepreloader"
                            aria-describedby="inputGroupFileAddon01">
                          <label class="custom-file-label" for="choosepreloader">
                            {{__("Choose preloader")}}
                          </label>
                        </div>
                      </div>
                      <small class="text-muted"><i class="fa fa-question-circle"></i>
                        {{__("Change your front end preloader")}}
                        here.</small>
                    </div>
                  </div>

                  <div class="col-custom col-md-3">
                    @if(file_exists(public_path().'/images/preloader/preloader.png'))
                    <div class="bg-primary-rgba p-3">
                      <img title="Current preloader" src=" {{url('images/preloader/preloader.png')}}" class="img-fluid">


                    </div>
                    @endif
                  </div>
                </div>
              </div>

              <div class="col-md-6 form-group">
                <br>
                @php $timestamp = time(); @endphp
                <label>{{__('Select Timezone:')}} <span class="text-danger">*</span> </label>
                <select name="TIMEZONE" id="TIMEZONE" class="form-control select2">



                  @foreach (timezone_identifiers_list() as $zone)

                  @php
                  date_default_timezone_set($zone);
                  $zones['offset'] = date('P', $timestamp);
                  $zones['diff_from_gtm'] = 'UTC/GMT '.date('P', $timestamp);
                  @endphp

                  <option {{ env('TIMEZONE') == $zone ? "selected" : "" }} value="{{ $zone }}">
                    {{ $zones['diff_from_gtm'].' '.$zone }}</option>

                  @endforeach
                </select>

              </div>



            </div>


            <div class="shadow-sm bg-primary-rgba p-3 rounded mt-4">
              <h4><i class="feather icon-zap" aria-hidden="true"></i> {{ __('Miscellaneous Settings') }}</h4>

              <div class="mt-3 row">



                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{ __('Disable Right Click:') }}</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="right_click" {{ $row->right_click=='1' ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('If enabled than Right click will not work on  whole project')}} (<b>{{ __('Recommended') }}</b>).</small>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{ __('Disable Inspect Elements:') }}</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="inspect" {{ $row->inspect=='1' ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("If enabled than Inspect element like")}}
                      <b>CTRL+U {{__("OR")}} CTRL+SHIFT+I</b> {{__('keys not work on whole project')}} (<b>{{ __("Recommended") }}</b>).</small>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{ __('Login Display Price') }}:</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="login" {{ $row->login=='1' ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('If enabled than Prices of products
                      and deals only visible to Logged In users.') }}</small>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{__('Guest Login')}}:</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="guest_login" {{ $row->guest_login=='1' ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('If enabled than Guest checkout will
                      be active on your portal.') }}</small>
                  </div>
                </div>



              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{__('APP Debug')}}:</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="APP_DEBUG" @if(env('DEMO_LOCK') !=1)
                        {{ env('APP_DEBUG') == true ? "checked" : "" }} @endif>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("Turn it")}} <b>{{ __('OFF') }}</b>. {{__("ONLY FOR Development purpose")}} (<b>{{ __('Recommanded') }}</b>).</small>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{__("Enable Multiseller system On Portal")}}:</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="vendor_enable" {{ $row->vendor_enable== 1 ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("If enabled than Multiseller system will be active on your portal.") }}</small>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{__("Enable email verification on user registration")}}:</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="email_verify_enable"
                        {{ $row->email_verify_enable == 1 ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('If enabled than email verification when user register he/she need to verify his/her email to access the site.') }}</small>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>{{ __('Enable Cash on delivery on checkout page') }}:</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="COD_ENABLE" {{ env('COD_ENABLE') == 1 ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{__('If enabled than cash on delivery will enable on payment page')}}.</small>
                  </div>
                </div>

                <div class="col-md-3">

                  <div class="form-group">
                    <label>{{__("Enable Preloader")}}:</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="ENABLE_PRELOADER"
                        {{ env('ENABLE_PRELOADER') =='1' ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Enable or disable preloader by toggling it.') }}</small>
                  </div>
                </div>

                <div class="col-md-3">

                  <div class="form-group">
                    <label>{{__("Hide Sidebar")}} :</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="HIDE_SIDEBAR" {{ env('HIDE_SIDEBAR') =='1' ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('By toggling it make the full width front page.') }}</small>
                  </div>
                </div>

                <div class="col-md-3">

                  <div class="form-group">
                    <label>
                      {{__("Enable Price with comma notation :")}}
                    </label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="PRICE_DISPLAY_FORMAT"
                        {{ env('PRICE_DISPLAY_FORMAT') == 'comma' || old('PRICE_DISPLAY_FORMAT') ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("By toggling it price will display on front end with comma eg : 1000.12 will show")}} <b>1 000,50</b>.</small>
                  </div>
                </div>

                <div class="col-md-3">

                  <div class="form-group">
                    <label>{{__("Show image instead of color dots")}} :</label>
                    <br>
                    <label class="switch">
                      <input type="checkbox" name="SHOW_IMAGE_INSTEAD_COLOR"
                        {{ env('SHOW_IMAGE_INSTEAD_COLOR') == true || old('SHOW_IMAGE_INSTEAD_COLOR') ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("By toggling it on variant product on color selection variant image will display instead of color dot")}}.</small>
                  </div>
                </div>

              </div>
            </div>
            <p class="border-default border-bottom"></p>
            <div class="shadow-sm bg-primary-rgba p-3 rounded">
              <a target="__blank" title="Get your keys from here" class=" pull-right text-info"
                href="https://www.google.com/recaptcha/admin/create"><i class="fa fa-key"></i> {{ __('Get Your reCAPTCHA v2 Keys From Here') }}</a>
              <h4><i class="feather icon-settings" aria-hidden="true"></i> {{ __('reCaptcha v2 Settings') }}</h4>
              <small class="text-muted"><i class="fa fa-warning"></i> {{ __('reCaptcha will not work on ') }}<b>localhost (eg. on
                  xammp,wammp,laragon)</b>. {{__("Read more about")}} <a target="__blank"
                  href="https://developers.google.com/recaptcha/docs/faq#localhost_support">{{ __('here') }}</a></small>
              <hr>
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group eyeCy">
                    <label>
                      {{__('NOCAPTCHA_SECRET')}}:
                    </label>
                    <input value="{{ env('NOCAPTCHA_SECRET') }}" id="NOCAPTCHA_SECRET" name="NOCAPTCHA_SECRET"
                      type="password" class="form-control" placeholder="{{ __('Enter NOCAPTCHA SECRET key') }}">
                      <span toggle="#NOCAPTCHA_SECRET" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group eyeCy">
                    <label>
                      {{__("NOCAPTCHA_SITEKEY")}}
                    </label>
                    <input id="NOCAPTCHA_SITEKEY" value="{{ env('NOCAPTCHA_SITEKEY') }}" name="NOCAPTCHA_SITEKEY"
                      type="password" class="form-control" placeholder="{{ __('Enter NOCAPTCHA SITEKEY key') }}">
                      <span toggle="#NOCAPTCHA_SITEKEY" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{__("Enable reCaptcha on Registration")}} :</label>
                    <br>
                    <label class="switch">
                      <input id="captcha_enable" type="checkbox" name="captcha_enable"
                        {{ $row->captcha_enable=='1' ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>



            <div class="bg-primary-rgba p-3 mt-2 rounded shadow-sm">
              <a target="__blank" title="Get your keys from here" class=" pull-right text-info"
                href="https://mailchimp.com/"><i class="fa fa-key"></i> {{ __("Get your mailchimp keys from here") }}</a>
              <h4><i class="feather icon-wifi"></i> {{__("MailChimp Newsletter Settings") }}</h4>
              <hr>
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group eyeCy">
                    <label>
                      {{__("MAILCHIMP APIKEY")}}
                    </label>
                    <input value="{{ env('MAILCHIMP_APIKEY') }}" id="MAILCHIMP_APIKEY" name="MAILCHIMP_APIKEY"
                      type="password" class="form-control" placeholder="{{ __('Enter MAILCHIMP API KEY') }}">
                      <span toggle="#MAILCHIMP_APIKEY" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group eyeCy">
                    <label>
                      {{__("MAILCHIMP LIST ID")}}
                    </label>
                    <input id="MAILCHIMP_LIST_ID" value="{{ env('MAILCHIMP_LIST_ID') }}" name="MAILCHIMP_LIST_ID"
                      type="password" class="form-control" placeholder="{{ __("Enter MAILCHIMP LIST ID") }}">
                      <span toggle="#MAILCHIMP_LIST_ID" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-primary-rgba p-3 mt-2 rounded shadow-sm">
              <a target="__blank" title="Get your keys from here" class=" pull-right text-info"
                href="https://tagmanager.google.com/#/home/"><i class="fa fa-key"></i> {{ __("Get your GTM keys from here") }}</a>
              <h4><i class="fa fa-google"></i> {{__("Google Tag Manager Settings") }}</h4>
              <hr>
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group eyeCy">
                    <label>
                      {{__("GOOGLE TAG MANAGER ID")}}
                    </label>
                    <input value="{{ env('GOOGLE_TAG_MANAGER_ID') }}" id="GOOGLE_TAG_MANAGER_ID"
                      name="GOOGLE_TAG_MANAGER_ID" type="text" class="form-control"
                      placeholder="{{ __('Enter GOOGLE TAG MANAGER ID here') }}">
                      <span toggle="#GOOGLE_TAG_MANAGER_ID" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{__("Enable Google Tag Manager")}} :</label>
                    <br>
                    <label class="switch">
                      <input id="GOOGLE_TAG_MANAGER_ENABLED" type="checkbox" name="GOOGLE_TAG_MANAGER_ENABLED"
                        {{ env('GOOGLE_TAG_MANAGER_ENABLED') =='1' ? "checked" : "" }}>
                      <span class="knob"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-primary-rgba p-3 mt-2 rounded shadow-sm">
              <a target="__blank" title="{{ __("Get your keys from here") }}" class=" pull-right text-info"
                href="https://pusher.com"><i class="fa fa-key"></i> {{ __('Get your pusher keys from here') }}</a>
              <h4><i class="fa fa-comments-o"></i> {{__("Pusher Settings") }}</h4>
              <hr>
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                    <label>
                      {{__("PUSHER APP ID")}}
                    </label>
                    <input value="{{ env('PUSHER_APP_ID') }}" id="PUSHER APP ID"
                      name="PUSHER_APP_ID" type="text" class="form-control"
                      placeholder="{{ __('Enter PUSHER APP ID') }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group eyeCy">
                    <label>
                      {{__("PUSHER APP KEY")}}
                    </label>
                    <input value="{{ env('PUSHER_APP_KEY') }}" id="PUSHER APP KEY"
                      name="PUSHER_APP_KEY" type="password" class="form-control"
                      placeholder="{{ __('Enter PUSHER APP KEY') }}">
                      <span toggle="#APP" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group eyeCy">
                    <label>
                      {{__("PUSHER APP SECRET")}}
                    </label>
                    <input value="{{ env('PUSHER_APP_SECRET') }}" id="PUSHER_APP_SECRET"
                      name="PUSHER_APP_SECRET" type="password" class="form-control"
                      placeholder="{{ __('Enter PUSHER APP SECRET') }}">
                      <span toggle="#PUSHER_APP_SECRET" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>
                      {{__("PUSHER_APP_CLUSTER")}}
                    </label>
                    <input value="{{ env('PUSHER_APP_CLUSTER') }}" id="PUSHER_APP_CLUSTER"
                      name="PUSHER_APP_CLUSTER" type="text" class="form-control"
                      placeholder="Enter PUSHER APP CLUSTER">
                  </div>
                </div>

              </div>
            </div>


            <div class="form-group mt-2">
              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn col-3 btn-success-rgba"><i class="fa fa-save"></i>
                Save</button>
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
<script>
  $('#captcha_enable').on('change', function () {
    if ($('#captcha_enable').is(':checked')) {
      $('#NOCAPTCHA_SECRET').attr('required', 'required');
      $('#NOCAPTCHA_SITEKEY').attr('required', 'required');
    } else {
      $('#NOCAPTCHA_SECRET').removeAttr('required');
      $('#NOCAPTCHA_SITEKEY').removeAttr('required');
    }
  });

  $('#GOOGLE_TAG_MANAGER_ENABLED').on('change', function () {
    if ($('#GOOGLE_TAG_MANAGER_ENABLED').is(':checked')) {
      $('#GOOGLE_TAG_MANAGER_ID').attr('required', 'required');
    } else {
      $('#GOOGLE_TAG_MANAGER_ID').removeAttr('required');
    }
  });

  $("input[name='ENABLE_SELLER_SUBS_SYSTEM']").on('change', function () {


    if ($("input[name='ENABLE_SELLER_SUBS_SYSTEM']").is(':checked')) {

      $('.purbox').removeClass('display-none');

      $("input[name='purchase_code']").attr('required', 'required');

    } else {


      $('.purbox').addClass('display-none');

      $("input[name='purchase_code']").removeAttr('required');

    }

  });

  $(".midia-toggle").midia({
		base_url: '{{url('')}}',
    directory_name : 'logo',
    dropzone : {
      acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
    }
	});
</script>
@endsection