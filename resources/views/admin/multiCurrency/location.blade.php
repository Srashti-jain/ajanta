
            <span class="control-label col-md-12" for="first-name">
              <label class="text-dark">
                {{__("Auto Detect:")}}
              </label>
            </span>

             <div class="col-md-12">

             <label class="switch"> 
             
              <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="auto_detect" onchange="autoDetectLocation('auto-detect')" id="auto-detect" {{$auto_geo->auto_detect=="1"?'checked':''}}>
              <span class="knob"></span> 

              </label>
              
              <label for="auto-detect"></label> 
              <div class="geoLocation-add" ><span class="you-are-login">{{__("Currently you are login from")}} </span><img class="country-loding" src="{{ url('images/circle.gif') }}"><span class="location-name"></span> <i class="fa fa-map-marker map-icon" aria-hidden="true"></i></div>

            </div>

          
          <div class="col-md-3 col-sm-3 col-xs-6 select-geo">         
            <label class="text-dark"> {{__("Geo Location:")}} </label> 
          </div>

      <div class="col-md-6 col-sm-6 col-xs-6 select-geo">  
        <select name="geoLocation" class="form-control select2" id="GeoLocationId">
            
             <option value="0">{{ __("Not Available") }}</option>
                      @foreach($all_country as $c)
                         
                        
                         <option value="{{$c->id}}" {{ $c->id == $auto_geo->default_geo_location ? 'selected="selected"' : '' }}>
                            {{$c->nicename}}
                         </option>

                      @endforeach
         </select>
       </div>
        <p></p>

        @if($auto_geo->auto_detect=="1")
          
          <div id="baseCurrencyBox">
            <span class="control-label col-md-3 col-sm-12 col-xs-12 currency-by-country margin-top-10">
              <label class="text-dark">
                {{__("Currency by Country:")}}
              </label>
            </span>
             <div class="col-md-9 col-sm-9 col-xs-12 currency-by-country">
                <label class="switch">
                 <input type="checkbox" name="by-country" onchange="currencybycountry('by-country')" id="by-country" {{$auto_geo->currency_by_country=="1"?'checked':''}}>
                 <span class="knob"></span>
                </label>
                <i class="currency-info">{{ __("Only working with AUTO DETECT feature. Currency will be selected base on country.") }}</i>
              </div>
          </div>

        @else

           <div class="display-none" id="baseCurrencyBox">
            <span class="control-label col-md-3 col-sm-12 col-xs-12 currency-by-country margin-top-10">
              <label class="text-dark">
                {{__("Currency by Country:")}}
              </label>
            </span>
             <div class="col-md-9 col-sm-9 col-xs-12 currency-by-country">
                <label class="switch">
                 <input type="checkbox" name="by-country" onchange="currencybycountry('by-country')" id="by-country" {{$auto_geo->currency_by_country=="1"?'checked':''}}>
                 <span class="knob"></span>
                </label>
                <i class="currency-info">{{ __("Only working with AUTO DETECT feature. Currency will be selected base on country.") }}</i>
              </div>
          </div>

        @endif


            
 
            <!-- Table -->
      <form class="{{ $auto_geo->currency_by_country=="1" ? "" : 'display-none' }}" id="cur_by_country" method="post" action="{{url('admin/location')}}">
               @csrf
          <table class="table">
             
              <thead>
                <tr>
                  <th scope="col">{{ __("Currency") }}</th>
                  <th scope="col">{{ __("Countries") }}</th>
                  <th scope="col">{{ __("Action") }}</th>
                 
                </tr>
              </thead>
              <tbody>

                @if(!empty($check_cur))
                
                
                      @foreach($check_cur as $currency)
                     
                       
                      <tr>
                       
                      <td>
                        
                       ({{$currency->currency->symbol}}){{$currency->currency->code}}
                       <input type="hidden" id="currency_id{{$currency->id}}" name="multi_curr{{$currency->id}}" value="{{$currency->currency->code}}">
                        <input type="hidden" id="multi_currency{{$currency->id}}" name="multi_currency{{$currency->id}}" value="{{$currency->id}}">
                      </td>
                      <td>
                       
                      <div>

                      <select class="form-control select2" id="country_id{{$currency->id}}" name="country{{$currency->id}}[]" multiple="multiple">  
                      @foreach($all_country as $country)
                          
                            <option @if(!empty($currency->currencyLocationSettings)) @foreach(explode(',', $currency->currencyLocationSettings->country_id) as $c) @if($c == $country->id) {{ 'selected' }} @endif @endforeach @endif value="{{$country->id}}">{{$country->nicename}}
                            </option>


                            @endforeach
                      </select>
                         
                    </div>
                      </td>
                      
                       
                       <td>

                       <div class="dropdown">
                            <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">

                              <a onclick="SelectAllCountry2('country_id{{$currency->id}}','btnid{{$currency->id}}')" id="btnid{{$currency->id}}"class="btn btn-light dropdown-item" isSelected="no"> 
                                <span>{{__('Select All')}}  </span><i class="fa fa-check-square-o"></i>
                              </a>

                              <a onclick="RemoveAllCountry2('country_id{{$currency->id}}','btnid{{$currency->id}}')" id="btnid{{$currency->id}}"class="btn btn-light dropdown-item" isSelected="yes"> 
                              <span>{{__("Remove All")}}  </span><i class="fa fa-window-close"></i>
                              </a>
                               
                            </div>
                        </div>
                        
                      
                       
                       </td>
                     </tr>
                              
                     @endforeach
                    @endif
                 <tr>
                  <td colspan="2">
                  <div class="pull-left">
                  <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban mr-2"></i>{{ __("Reset")}}</button>
                    <button class="btn btn-primary-rgba"><i class="fa fa-check-circle mr-2"></i>{{ __("Save") }}</button>
                  </div>
                </td>
                </tr>

                 
                
              </tbody>
              
              

          </table>
</form>
     
<script>var baseUrl = "<?= url('/') ?>";</script>
<script src="{{ url('js/currency.js') }}"></script>

