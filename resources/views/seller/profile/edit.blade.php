@extends('admin.layouts.sellermastersoyuz')
@section('title', __('Edit Profile'))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
{{ __('Edit Profile') }}
@endslot
@slot('menu1')
{{ __('Edit Profile') }}
@endslot



@endcomponent

<div class="contentbar">
 


  <div class="row">
    <div class="col-lg-9">

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
          <h5 class="card-title">{{ __('Edit Profile') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">

              <div class="form-group col-md-6">
                <label for="">{{__("Name")}} : <span class="required">*</span></label>
                <input placeholder="{{ __('Please enter name') }}" type="text" name="name" value="{{auth()->user()->name}}"
                  class="form-control">

              </div>

              <div class="form-group col-md-6">
                <label>{{ __('Buisness Email') }} : <span class="required">*</span></label>
                <input placeholder="{{ __('Please enter email') }}" type="text" name="email" value="{{auth()->user()->email}} "
                  class="form-control">
              </div>

              <div class="form-group col-md-6">
                <label for="">{{__("Phone")}} :</label>
                <input placeholder="{{ __('Please Enter phone no.') }}" type="text" name="phone" value="{{auth()->user()->phone}}"
                  class="form-control">
              </div>

              <div class="form-group col-md-6">
                <label>
                  {{__('Mobile')}} : <span class="required">*</span>
                </label>

                <div class="row no-gutter">
                  <div class="col-md-12">
                    <div class="input-group">

                      <input required pattern="[0-9]+" title="{{ __('Invalid mobile no.') }}" placeholder="1" type="text"
                        name="phonecode" value="{{auth()->user()->phonecode}}" class="col-md-2 form-control">
                      <input required pattern="[0-9]+" title="{{ __('Invalid mobile no.') }}" placeholder="{{ __('Please enter mobile no.') }}"
                        type="text" name="mobile" value="{{auth()->user()->mobile}}" class="col-md-10 form-control">
                    </div>
                  </div>
                </div>
              </div>




              <div class="form-group col-md-4">
                <label>{{__('Country')}} : <span class="required">*</span></label>
                <select data-placeholder="Please select country" class="form-control select2" name="country_id"
                  id="country_id">
                  <option value="">{{ __('Please Choose') }}</option>
                  @foreach($country as $c)

                  <option value="{{$c->id}}" {{ $c->id == auth()->user()->country_id ? 'selected="selected"' : '' }}>
                    {{$c->nicename}}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-md-4">
                <label>{{__('State')}} : <span class="required">*</span></label>
                <select data-placeholder="{{ __('Please select state') }}" required name="state_id" class="form-control select2"
                  id="upload_id">
                  <option value="">{{ __('Please choose') }}</option>
                  @foreach($states as $c)
                  <option value="{{$c->id}}" {{ $c->id == auth()->user()->state_id ? 'selected="selected"' : '' }}>
                    {{$c->name}}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="">{{ __('City') }} :</label>
                <select data-placeholder="{{ __('Please select city') }}" name="city_id" id="city_id" class="form-control select2">
                  <option value="">{{ __('Please select city') }}</option>
                  @foreach($citys as $key=>$c)

                  <option value="{{ $key }}" {{ $key == auth()->user()->city_id ? 'selected' : '' }}>
                    {{$c}}
                  </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-md-8">
                <label for="exampleInputSlug"> {{ __('Choose Profile picture :') }}<sup
                    class="redstar text-danger">*</sup></label><br>
                <div class="input-group mb-3">
                  <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
                      aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">
                      {{__('Choose file')}}
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-12">
                <label class="check">
                  <input type="checkbox" id="check" name="update_password" value="test">
                  <span class="checkmark"></span>
                    {{__('Want To Update password')}}
                </label>
              </div>

              <div class="col-md-12 passwordshow hide">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="">{{__('Password')}} : <span class="required">*</span></label>
                    <div class="input-group">
                      <input name="password" type="password" id="id_password" class="form-control"
                        autocomplete="current-password" placeholder="{{ __('Enter new password') }}">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i id="togglePassword" class="fa fa-eye"></i></span>
                      </div>
                    </div>
                  </div>



                  <div class="form-group col-md-6">
                    <label for="">{{__("Confirm Password")}} : <span class="required">*</span></label>
                    <div class="input-group">
                      <input placeholder="{{ __('Enter password again to confirm') }}" id="id_password1" type="password"
                        name="password_confirmation" class="form-control">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> <i id="togglePassword1" class="fa fa-eye"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="form-group">
              <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
              <button @if(env('DEMO_LOCK')==0) type="submit" @else title="{{ __('This action is disabled in demo !') }}"
                disabled="disabled" @endif class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Update")}}</button>
            </div>

        </div>
        </form>
      </div>
    </div>


    <div class="col-lg-3">
      <div class="card m-b-30">
        <div class="user-slider">
          <div class="user-slider-item">
            <div class="card-body text-center">
              <span>
                @if(Auth::user()->image !="" && file_exists(public_path().'/images/user/'.Auth::user()->image))
                <img id="preview1" src="{{url('images/user/'.Auth::user()->image)}}"
                  class="img-circle rounded mx-auto d-block" alt="User Image">
                @else
                <img id="preview1" class="img-circle rounded mx-auto d-block" title="{{ Auth::user()->name }}"
                  src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" />
                @endif
              </span>
              <h5 class="mt-2">{{ Auth::user()->name }}</h5>
              <p>{{ Auth::user()->store->name }}</p>
              <p> <i class="feather icon-map-pin"></i> @if(auth()->user()->country)
                {{ auth()->user()->city ?  auth()->user()->city->name.', ' : '' }}
                {{ auth()->user()->state ?  auth()->user()->state->name.', ' : '' }}
                {{ auth()->user()->country->nicename }}
                @else
                {{__("Location not updated")}}
                @endif</p>

              <p><span class="badge badge-primary-inverse">
                 SELLER
                </span></p>
            </div>
            <div class="card-footer text-center">
              <div class="row">
                <div class="col-6 border-right">
                  <h5>{{ count(Auth::user()->products) }}</h5>
                  <p class="my-2">{{ __('TOTAL PRODUCTS') }}</p>
                </div>
                <div class="col-6">
                  <h5>{{ Auth::user()->purchaseorder->count() }}</h5>
                  <p class="my-2">{{ __('TOTAL PURCHASE') }}</p>
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
  <script src="{{ url('js/ajaxlocationlist.js') }}"></script>

  <script type="text/javascript">
    $(function () {
      $("#check").on("click", function () {
        $(".passwordshow").toggle(this.checked);
      });
    });
  </script>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#id_password');

    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('fa-eye-slash');
    });
  </script>
  <script>
    const togglePassword1 = document.querySelector('#togglePassword1');
    const password1 = document.querySelector('#id_password1');

    togglePassword1.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
      password1.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('fa-eye-slash');
    });
  </script>
  @endsection