@extends('admin.layouts.master-soyuz')
@section('title',__("Edit Store |"))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Edit Store') }}
@endslot

@slot('menu1')
   {{ __('Store') }}
@endslot
@slot('menu2')
   {{ __('Edit Store') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href=" {{url('admin/stores')}} " class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

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
          <h5 class="box-title">{{ __('Edit Store') }}</h5>
        </div>
        <div class="card-body">
         <!-- main content start -->

         <!-- form start -->
         <form action="{{url('admin/stores/'.$store->id)}}" class="form" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            {{ method_field('PUT') }}
                       
                    <div class="row">

                    <div class="col-md-4">
                    <div class="form-group">
                      <label class="text-dark">
                        {{ __('Store ID') }}:
                      </label>
                      <input class="form-control" type="text" readonly value="{{ $store->uuid ?? "Not set" }}">
                      <small class="text-muted">
                        <i class="fa fa-question-circle"></i> {{ __('If you did not see store id hit update button to get it.') }}
                      </small>
                    </div>
                    </div>

                    <!-- storeOwner -->
                    <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Store Owner') }} : <span class="text-danger">*</span></label>
                                <select class="select2 form-control" name="user_id" required>
                                  <option value="">{{ __("Please Choose Store Owner") }}</option>
                                  @foreach($users as $user)
                                    <optgroup label="{{ $user->email }}">
                                    <option {{ $store->user_id == $user->id ? "selected" : "" }}  value="{{$user->id}}"> {{$user->name}}</option>
                                    </optgroup>
                                  @endforeach
                                </select>
                                <small>
                                <i class="fa fa-question-circle"></i> {{ __('Choose Store Owner') }}
                                </small>
                          </div>
                      </div>
                      
                      <!-- Store name -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Store Name :') }} <span class="text-danger">*</span></label>
                              <input type="text" value="{{ $store->name }}" autofocus="" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Enter Page Name') }}" name="name" required="">
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('Enter Store Name') }}
                              </small>
                          </div>
                      </div>

                      <!-- email -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Business Email :') }} <span class="text-danger">*</span></label>
                              <input type="text" value="{{ $store->email }}" autofocus="" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Please enter buisness email') }}" name="email" required="">
                              <small>
                                <i class="fa fa-question-circle"></i> {{ __('Please enter buisness email') }}
                              </small>
                          </div>
                      </div>

                      <!-- VAT/GSTIN No: -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('VAT/GSTIN No :') }} </label>
                              <input type="text" value="{{ $store->vat_no }}" autofocus="" class="form-control @error('vat_no') is-invalid @enderror" placeholder="{{ __('Please enter your GSTIN/VAT No.') }}" name="vat_no">
                              <small>
                                <i class="fa fa-question-circle"></i> {{ __('Please enter valid GSTIN/VAT No.') }}
                              </small>
                          </div>
                      </div>

                      <!-- Phone -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Phone :') }} </label>
                              <input pattern="[0-9]+" title="{{ __("Invalid phone no.") }}" placeholder="{{ __('Please enter Phoneno.') }}" type="text" id="first-name" name="phone" value="{{ $store->phone }}" class="form-control">
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('Please enter Phoneno.') }}
                              </small>
                          </div>
                      </div>

                      <!-- Mobile -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Mobile :') }} <span class="text-danger">*</span></label>
                              <input pattern="[0-9]+" title="Invalid mobile no." placeholder="Please enter mobile no." type="text" id="first-name" name="mobile" class="form-control" value="{{ $store->mobile }}">
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('Please select Mobile no.') }}
                              </small>
                          </div>
                      </div>

                        <!-- Country -->
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Country') }} : <span class="text-danger">*</span></label>
                              <select data-placeholder="{{ __('Please select country') }}" name="country_id" id="country_id" class="form-control select2 col-md-7 col-xs-12">
                                <option value="0">{{ __("Please Choose") }}</option>
                                @foreach($countrys as $country)
                                <?php
                                              $iso3 = $country->country;
                
                                              $country_name = DB::table('allcountry')->
                                              where('iso3',$iso3)->first();
                
                                               ?>
                                <option {{ $store->country_id == $country_name->id ? 'selected' : "" }} value="{{$country_name->id}} ">{{ $country_name->nicename }}</option>
                                @endforeach
                              </select>
              
                              <small>
                                <i class="fa fa-question-circle"></i> {{ __('Please select country') }}
                              </small>
                          </div>
                      </div>

                      <!-- state -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('State') }} : <span class="text-danger">*</span></label>
                              <select data-placeholder="{{ __('Please select state') }}" required name="state_id" id="upload_id" class="select2 form-control">
  
                                <option value="">{{ __("Please Choose") }}</option>
                                @foreach($store->country->states as $state)
                                  <option {{ $store->state_id != 0 && $store->state_id == $state->id ? "selected" : "" }} value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                              </select>
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('Please select state') }}
                              </small>
                          </div>
                      </div>

                      <!-- city -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('City') }} : <span class="text-danger">*</span></label>
                              <select data-placeholder="{{ __('Please select city') }}" required name="city_id" id="city_id" class="select2 form-control">
                                <option value="">{{ __("Please Choose") }}</option>
                                @if(isset($store->state->city))
                                    @foreach($store->state->city as $city)
                                      <option {{ $store->city_id != 0 && $store->city_id == $city->id ? "selected" : ""  }} value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                @endif
                              </select>
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('Please select city') }}
                              </small>
                          </div>
                      </div>

                      <!-- pincode -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Pincode') }} :</label>
                              <input pattern="[0-9]+" title="{{ __("Invalid pincode/zipcode") }}" placeholder="{{ __('Please enter pincode') }}" type="text" id="first-name" name="pin_code" class="form-control" value="{{ $store['pin_code'] }}">
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('Please enter pincode') }}
                              </small>
                          </div>
                      </div>

                      <!-- choosePayout -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Please select prerfed payout:') }} :</label>
                              <select class="select2 form-control" name="preferd" id="preferd" required>
                                <option value="">{{ __('admin.preferPayout') }}</option>
                                <option {{ $store['preferd'] == 'paypal' ? 'selected' : "" }} value="paypal">{{ __('Paypal') }}</option>
                                <option {{ $store['preferd'] == 'paytm' ? 'selected' : "" }} value="paytm">{{ __('Paytm') }}</option>
                                <option {{ $store['preferd'] == 'bank' ? 'selected' : "" }} value="bank">{{ __('Bank Transfer') }}</option>
                              </select>
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('Please select prerfed payout') }}
                              </small>
                          </div>
                      </div>

                        <!-- paypalemail -->
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="text-dark">{{__('Paypal Email')}} :</label>
                                <input value="{{ $store['paypal_email'] }}" type="text" class="form-control" class="form-control" name="paypal_email" placeholder="eg:seller@paypal.com">
                                <small class="text-muted">
                                  <i class="fa fa-question-circle"></i> {{ __('Please enter paypal email') }}
                                </small>
                          </div>
                      </div>

                      <!-- paypalemail -->
                      <div class="col-md-4">
                      <div class="form-group">
                            <label class="text-dark"> {{__("Paytm Mobile No.")}} : ({{ __('admin.IndiaApplicable') }})</label>
                            <input value="{{ $store['paytem_mobile'] }}" type="text" class="form-control" class="form-control" name="paytem_mobile" placeholder="eg:7894561230">
                            <small class="text-muted">
                              <i class="fa fa-question-circle"></i> {{ __('Please enter mobile no.') }}
                            </small>
                      </div>
                      </div>

                      <!-- AccountNumber -->
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="text-dark">{{ __('Account No.') }}</label>
                        <input class="form-control" pattern="[0-9]+" title="{{ __("Invalid account no.") }}" type="text"  name="account"
                          value="{{ $store['account'] }}" placeholder="{{ __('Please Enter Account Number') }}"> <span
                          class="required">{{$errors->first('account')}}</span>
                      </div>
                      </div>

                      <!-- AccountName -->
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="text-dark">{{ __('Account Name') }} :</label>
                        <input class="form-control" type="text" name="account_name" value="{{ $store['account_name'] }}"
                          placeholder="{{ __('Please Enter Account Name') }}"> <span
                          class="required">{{$errors->first('bank_name')}}</span>
                      </div>
                      </div>

                      <!-- BankName -->
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="text-dark"> {{ __('BankName') }} :</label>
                        <input class="form-control"  type="text" name="bank_name" value="{{ $store['bank_name'] }}"
                          placeholder="{{ __('Please Enter Bank Name') }}"> <span
                          class="required">{{$errors->first('bank_name')}}</span>
                      </div>
                      </div>

                      <!-- IFSC Code -->
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="text-dark"> {{ __('IFSC Code') }} :</label>
                        <input class="form-control"  type="text" name="ifsc" value="{{ $store['ifsc'] }}"
                          placeholder="{{ __('Please Enter IFSC Code') }}"> <span
                          class="required">{{$errors->first('ifsc')}}</span>
                      </div>
                      </div>

                      <!-- BranchAddress -->
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="text-dark">{{ __('Branch Address') }} : </label>
                        <input class="form-control"  type="text" id="first-name" name="branch" placeholder="{{ __("Please Enter Branch Address") }}"
                          value="{{ $store['branch'] }}">
                        <span class="required">{{$errors->first('branch')}}</span>
                      </div>
                      </div>

                      <!-- Logo -->
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="text-dark">
                          {{ __('Logo') }} :
                        </label>
                        <div class="input-group mb-3">
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" name="store_logo" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                          </div>
                        </div>
                        <small class="text-muted">
                          <i class="fa fa-question-circle"></i> {{ __('Select Store Logo') }}
                        </small>
                      </div>
                      </div>

                        <!-- Store cover photo -->
                        <div class="col-md-4">
                        <div class="form-group">
                        <label class="text-dark">
                          {{ __('Store cover photo :') }}
                        </label>
                        <div class="input-group mb-3">
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" name="cover_photo" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                          </div>
                        </div>
                        <small>
                          <i class="fa fa-question-circle"></i>  
                            • {{__("It will display on your store page.")}}
                            • {{__("Recommnaded size is :")}} <b>1500 x 440 px</b>
                            • {{__("Allow format is")}} <b>jpg,jpeg,png,gif</b>     
                        </small>
                      </div>
                      </div>

                        <!-- Store Address -->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Store Address :') }} <span class="text-danger">*</span></label>
                              <textarea class="form-control" required name="address" id="address" cols="30" rows="5">{!! $store->address !!}</textarea>
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('Please enter address') }}
                              </small>
                          </div>
                      </div>

                        <!-- Store description -->
                        <div class="col-md-6">
                          <div class="form-group">
                              <label class="text-dark">{{ __('Store description :') }} <span class="text-danger">*</span></label>
                              <textarea class="form-control" required name="description" id="description" cols="30" rows="5">{{ $store->description }}</textarea>
                              <small class="text-muted">
                                <i class="fa fa-question-circle"></i> {{ __('It will display on your store page.') }}
                              </small>
                          </div>
                      </div>

                      

                        <!-- Status -->
                        <div class="col-md-6">
                        <div class="form-group">
                          <label class="text-dark">{{ __('Status') }} </label><br>
                          <label class="switch">
                            <input class="slider" type="checkbox" name="status" {{ $store['status'] == '1' ? "checked" : "" }} />
                            <span class="knob"></span>
                          </label>
                          <br>
                          <small>{{ __('Toggle the store status') }}</small>
                      </div>
                      </div>

                      <!-- Verified Store -->
                      <div class="col-md-6">
                      <div class="form-group">
                        <label class="text-dark">{{ __('Verified Store :') }}</label><br>
                        <label class="switch">
                          <input {{ $store['verified_store'] == '1' ? "checked" : "" }} type="checkbox" name="verified_store">
                          <span class="knob"></span>
                        </label>
                        <br>
                        <small>{{ __('(On The Product detail page if store is verified than it will add') }} <i class="fa fa-check-circle text-green"></i> {{ __('Symbol next to the store name.)') }}</small>
                      </div>
                      </div>

                      <div class="col-12">
                        <div class="alert alert-success">
                            <ul>
                              <li>{{__("In order to get google place api key Google Maps platform account is required you can know more about")}} <a target="__blank" class="alert-link" href="https://mapsplatform.google.com/">{{ __("here") }}</a></li>
                              <li>
                                {{__("To find your place id use this ")}} <a target="__blank" href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder" class="alert-link">{{ __('tool') }}</a>
                              </li>

                              <li>
                                {{__("To get Place API Key head over to ")}} <a target="__blank" class="alert-link" href="https://developers.google.com/maps/documentation/places/web-service/overview">{{ __("here") }}</a>
                              </li>
                            </ul>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group">
                            <label>{{ __("Show Google reviews & ratings on store page?") }}</label>
                            <br>
                            <label class="switch">
                              <input {{ $store->show_google_reviews == 1 ? "checked" : "" }} id="show_google_reviews" class="show_google_reviews" type="checkbox" name="show_google_reviews"
                                >
                              <span class="knob"></span>
                            </label>
                        </div>
                      </div>

                      <div class="col-4 placeid" style="display:{{ $store->show_google_reviews == 1 ? "block" : "none" }}">
                        <div class="form-group">
                            <label>{{ __("Google Place ID") }} <span class="text-danger">*</span></label>
                            <input {{ $store->show_google_reviews == 1 ? "required=required" : "" }} value="{{ $store->google_place_id ?? '' }}" name="google_place_id" type="text" class="pkey form-control" placeholder="{{ __("Enter your google place id key") }}">
                        </div>
                      </div>

                      <div class="col-4 placeapi" style="display:{{ $store->show_google_reviews == 1 ? "block" : "none" }}">

                        <div class="form-group">
                            <label>{{ __("Google Place API Key") }} <span class="text-danger">*</span> </label>
                            <input {{ $store->show_google_reviews == 1 ? "required=required" : "" }} value="{{ $store->google_place_api_key ?? '' }}" name="google_place_api_key" type="text" class="pkey form-control" placeholder="{{ __("Enter your google place api key") }}">
                        </div>

                      </div>
                                    
                      <!-- create and close button -->
                      <div class="col-md-12">
                          <div class="form-group">
                              <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                              {{ __("Update")}}</button>
                          </div>
                      </div>

                    </div><!-- row end -->
                                              
                  </form>
                  <!-- form end -->

         <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@section('custom-script')
<script>
  var baseUrl = @json(url('/'));
</script>
<script>
  $(".show_google_reviews").on('change',function(){
    if($(this).is(":checked")){

        $('.placeid,.placeapi').show();

        $('.pkey').each(function(index,value){
          $(this).attr('required','required');
        });

    }else{
      $('.placeid,.placeapi').hide();

      $('.pkey').each(function(index,value){
          $(this).removeAttr('required','required');
      });

    }
  });
</script>
<script src="{{ url('js/ajaxlocationlist.js') }}"></script>
@endsection