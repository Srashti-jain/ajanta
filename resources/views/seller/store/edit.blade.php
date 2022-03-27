@extends("admin.layouts.sellermastersoyuz")
@section('title',__('Edit Store - :store',['store' => $store->name]))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
{{ __('Edit Store') }}
@endslot
@slot('menu1')
{{ __('Edit Store') }}
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
          <h5 class="card-title"> {{__("Edit Store Details")}}</h5>
        </div>
        <div class="card-body">


          <div class="row">
            <div class="col-md-8">


              <form action="{{ route('store.update',$store->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")

                <div class="row">
                  <div class="col-md-6 form-group">

                    <label> {{__('Store ID:')}} </br>

                      <small class="text-muted">
                        <i class="fa fa-question-circle"></i>
                        {{ __('If you did not see store id hit update button to get it.') }}
                      </small></label>
                    <input disabled type="text" name="name" class="form-control" value="{{$store->uuid ?? 'NOT SET'}}">

                  </div>


                  <div class="col-md-6 form-group">

                    <label>{{__('Store Name:')}} <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{$store->name ?? ''}}">

                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>{{__('Store Email:')}} <span class="required">*</span></label>
                      <input type="text" name="email" class="form-control" value="{{$store->email ?? ''}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">{{ __('Phone:') }}</label>
                      <input type="text" placeholder="{{ __('Enter phone no.') }}" name="phone" class="form-control"
                        value="{{$store->phone ?? ''}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">{{ __('Mobile:') }}</label>
                      <input type="text" placeholder="{{ __('Enter mobile no.') }}" name="mobile" class="form-control"
                        value="{{$store->mobile ?? ''}}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">{{ __('VAT/GSTIN No:') }}</label>
                      <input type="text" placeholder="{{ __("Enter VAT or GSTIN no. of your store") }}" name="vat_no"
                        class="form-control" value="{{$store->vat_no ?? ''}}">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-3">
                        <label for="">{{__("Store Address:")}} <span class="required">*</span></label>
                        <textarea class="form-control" name="address" placeholder="{{ __('Enter store address') }}"
                          cols="10" rows="2">{{ $store->address }}</textarea>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="">{{__("Country:")}} <span class="required">*</span></label>
                          <select data-placeholder="{{ __('Please select country') }}" name="country_id" id="country_id"
                            class="form-control select2">
                            <option value="0">{{ __('Please Choose') }}</option>
                            @foreach($countries as $c)

                            <option value="{{$c->id}}" {{ $c->id == $store->country_id ? 'selected="selected"' : '' }}>
                              {{$c->nicename}}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="">State: <span class="required">*</span></label>
                          <select data-placeholder="{{ __('Please select state') }}" required name="state_id"
                            id="upload_id" class="form-control select2">
                            <option value="0">{{ __('Please choose') }}</option>
                            @foreach($states as $c)
                            <option value="{{$c->id}}" {{ $c->id == $store->state_id ? 'selected="selected"' : '' }}>
                              {{$c->name}}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label for=""> {{__("City:")}} </label>
                          <select data-placeholder="Please select city" name="city_id" id="city_id"
                            class="form-control select2">
                            <option value="">{{ __('Please Choose') }}</option>
                            @foreach($city as $c)
                            <option value="{{$c->id}}" {{ $c->id == $store->city_id ? 'selected="selected"' : '' }}>
                              {{$c->name}}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      @if($pincodesystem == 1)
                      <div class="col-md-3">
                        <label for="">{{__('Pincode:')}} <span class="required">*</span></label>
                        <input type="text" value="{{ $store->pin_code }}" name="pin_code"
                          placeholder="{{ __('Enter pincode') }}" class="form-control">
                      </div>
                      @endif
                    </div>
                  </div>


                  <div class="col-md-6 mt-md-2">

                    <div class="form-group">

                      <label for="">{{ __('Choose Store Logo:') }}</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                        </div>
                        <div class="custom-file">
                          <input type="file" name="store_logo" class="custom-file-input" id="inputGroupFile01"
                            aria-describedby="inputGroupFileAddon01">
                          <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose store logo") }}</label>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-6 mt-md-2">
                    <div class="form-group">
                      @if($store->status == 1)
                      <img src="{{asset('admin_new/assets/images/active.png')}}" alt="" class="active_icon">
                      @else
                      <img src="{{asset('admin_new/assets/images/deactive.jpg')}}" alt="" class="active_icon">
                      @endif
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="alert alert-success">
                      <ul>
                        <li>
                          {{__("In order to get google place api key Google Maps platform account is required you can know more about")}}
                          <a target="__blank" class="alert-link"
                            href="https://mapsplatform.google.com/">{{ __("here") }}</a></li>
                        <li>
                          {{__("To find your place id use this ")}} <a target="__blank"
                            href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder"
                            class="alert-link">{{ __('tool') }}</a>
                        </li>

                        <li>
                          {{__("To get Place API Key head over to ")}} <a target="__blank" class="alert-link"
                            href="https://developers.google.com/maps/documentation/places/web-service/overview">{{ __("here") }}</a>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                      <label>{{ __("Show Google reviews & ratings on store page?") }}</label>
                      <br>
                      <label class="switch">
                        <input {{ $store->show_google_reviews == 1 ? "checked" : "" }} id="show_google_reviews"
                          class="show_google_reviews" type="checkbox" name="show_google_reviews">
                        <span class="knob"></span>
                      </label>
                    </div>
                  </div>

                  <div class="col-4 placeid" style="display:{{ $store->show_google_reviews == 1 ? "block" : "none" }}">
                    <div class="form-group">
                      <label>{{ __("Google Place ID") }} <span class="text-danger">*</span></label>
                      <input {{ $store->show_google_reviews == 1 ? "required" : "" }}
                        value="{{ $store->google_place_id ?? '' }}" name="google_place_id" type="text"
                        class="pkey form-control" placeholder="{{ __("Enter your google place id key") }}">
                    </div>
                  </div>

                  <div class="col-4 placeapi" style="display:{{ $store->show_google_reviews == 1 ? "block" : "none" }}">

                    <div class="form-group">
                      <label>{{ __("Google Place API Key") }} <span class="text-danger">*</span> </label>
                      <input {{ $store->show_google_reviews == 1 ? "required" : "" }}
                        value="{{ $store->google_place_api_key ?? '' }}" name="google_place_api_key" type="text"
                        class="pkey form-control" placeholder="{{ __("Enter your google place api key") }}">
                    </div>

                  </div>


                  <div class="col-md-12 form-group">
                    <button @if(env('DEMO_LOCK')==0) type="submit" @else title="This action is disabled in demo !"
                      disabled="disabled" @endif class="btn btn-md btn-primary"><i class="fa fa-check-circle"></i>
                      {{__('Update')}} </button>
              </form>
              <button data-toggle="modal" data-target="#deletestore" type="button" class="btn btn-md btn-danger">
                <i class="fa fa-trash-o"></i> {{__("Request for delete")}}
              </button>
              <div id="deletestore" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">{{ __('Are You Sure ?') }}</h4>
                      <p>
                        {{__('Do you really want to delete your store? This process cannot be undone. By clicking YES your all products,payouts, orders records will be deleted !')}}
                      </p>
                    </div>
                    <div class="modal-footer">
                      <form method="post" action="{{ route('req.for.delete.store',$store->id) }}" class="pull-right">
                        {{csrf_field()}}
                        {{method_field("DELETE")}}

                        <button type="reset" class="btn btn-gray translate-y-3"
                          data-dismiss="modal">{{ __('No') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-md-4">
          <div class="row">
            <div class="card m-b-30 bg-primary-rgba shadow-sm mr-3 ">
              <div class="card-body py-5 ">
                <div class="row">
                  <div class="col-lg-3 text-center">
                    @php
                    $image = @file_get_contents(public_path().'/images/store/'.$store->store_logo);
                    @endphp
                    <img title="{{ $store->name }}"
                      src="{{ $image ? url('images/store/'.$store->store_logo) : Avatar::create($store->name)->toBase64() }}"
                      alt="Store logo" class="img-fluid mb-3" alt="user">

                  </div>
                  <div class="col-lg-9">
                    <div class="row">
                      <h4>{{ $store->name }}</h4>
                    </div>

                    <div class="row">
                      <p>
                        <i class="feather icon-map-pin mr-2"></i>{{ $store->city['name'] }},
                        {{ $store->state['name'] }}, {{ $store->country['nicename'] }}</p>
                    </div>



                    @php
                    $allorders = App\Order::all();

                    $sellerorder = collect();

                    foreach ($allorders as $key => $order) {

                    if(in_array(Auth::user()->id, $order->vender_ids)){
                    $sellerorder->push($order);
                    }

                    }
                    @endphp

                    <div class="table-responsive">
                      <table class="table table-borderless mb-0">
                        <tbody>
                          <tr>
                            <th scope="row" class="p-1 text-muted"><i class="feather icon-check-square"></i>
                              {{ __('Created On') }}</th>
                            <td class="p-1">{{ date('d-M-Y',strtotime($store->created_at)) }}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="p-1 text-muted"><i class="feather icon-user-plus"></i>
                              {{ __('Owner') }}</th>
                            <td class="p-1">{{ $store->user->name }}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="p-1 text-muted"><i class="feather icon-truck"></i>
                              {{ __('Total Orders') }}</th>
                            <td class="p-1">{{ count($sellerorder) }}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="p-1 text-muted"><i class="feather icon-shopping-cart"></i>
                              {{ __('Total Products') }}</th>
                            <td class="p-1">{{ $store->products->count() }}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="p-1 text-muted"><i class="feather icon-check"></i>
                              {{ __('Verified') }}</th>
                            <td class="p-1"><i
                                class="{{ $store->verified_store == '1' ? "feather icon-user-check" : "No" }}"></i>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row ml-md-5">
            @if($store->verified_store == 1)
            <img src="{{asset('admin_new/assets/images/verified.jpg')}}" alt="" class="">
            @else
            <img src="{{asset('admin_new/assets/images/unverified.jpg')}}" alt="" class="">
            @endif
          </div>

        </div>
      </div>
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
  $(".show_google_reviews").on('change', function () {
    if ($(this).is(":checked")) {

      $('.placeid,.placeapi').show();

      $('.pkey').each(function (index, value) {
        $(this).attr('required', 'required');
      });

    } else {
      $('.placeid,.placeapi').hide();

      $('.pkey').each(function (index, value) {
        $(this).removeAttr('required', 'required');
      });

    }
  });
</script>
<script src="{{ url('js/ajaxlocationlist.js') }}"></script>
@endsection