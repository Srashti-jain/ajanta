@extends('admin.layouts.master-soyuz')
@section('title',__("Create a new user |"))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Create a new user') }}
@endslot
@slot('menu1')
   {{ __('User') }}
@endslot
@slot('menu2')
   {{ __('Create a new user') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('users.index',['filter' => app('request')->input('type') ]) }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

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
                <h5 class="card-title"> {{__("Create a new user")}}</h5>
              </div>
              <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{url('admin/users/')}}">
                  @csrf
                  <div class="row">
            
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>{{__("Username:")}} <span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ __("Enter username") }}" name="name" value="{{ old('name') }}">
                        
                      </div>
                    </div>
            
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>{{__("Useremail:")}} <span class="required">*</span></label>
                        <input placeholder="{{ __("Please enter email") }}" type="email" name="email" value="{{ old('email') }}" class="form-control">
                      </div>
                    </div>
            
                    <div class="col-md-6">
            
                      <div class="form-group">
                        <label>
                         {{__("Mobile:")}} <span class="required">*</span>
                        </label>
                        
            
                        <div class="row no-gutter">
                          <div class="col-md-12">
                            <div class="input-group">
                              <input required pattern="[0-9]+" title="Invalid mobile no." placeholder="1" type="text"
                              name="phonecode" value="{{old('phonecode')}}" class="col-md-2 form-control">
                              <input required pattern="[0-9]+" title="Invalid mobile no." placeholder="{{ __("Please enter mobile no.") }}" type="text"
                                name="mobile" value="{{old('mobile')}}" class="col-md-10 form-control">
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>
            
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>
                          {{__("Phone:")}}
                        </label>
                        <input pattern="[0-9]+" title="Invalid Phone no." placeholder="{{ __("Please enter phone no.") }}" type="text"
                          name="phone" value="{{old('phone')}}" class="form-control">
                      </div>
                    </div>
            
                    <div class="col-md-4">
                      <div class="form-group">
            
                        <label>
                          {{__("Country:")}}
                        </label>
            
                        <select data-placeholder="{{ __("Please select country") }}" name="country_id" class="form-control select2" id="country_id">
                          
                          <option value="">{{ __("Please Choose") }}</option>
                          @foreach($country as $c)
                                 
                            <option value="{{$c->id}}" >
                              {{$c->nicename}}
                            </option>
            
                          @endforeach
                        </select>
            
                      </div>
                    </div>
            
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>
                          {{__("State:")}}
                        </label>
            
                        <select data-placeholder="Please select state" required name="state_id" class="form-control select2" id="upload_id">
                          <option value="">{{ __("Please choose") }}</option>
                          
                        </select>
            
                      </div>
                    </div>
            
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="first-name">
                          {{__("City:")}}
                        </label>
                        <select data-placeholder="{{ __("Please select city") }}" name="city_id" id="city_id" class="form-control select2">
                          <option value="">{{ __('Please Choose') }}</option>
                          
                        </select>
                      </div>
                    </div>
            
            
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>{{ __("Website:") }}</label>
                        <input placeholder="http://" type="text" id="first-name" name="website" value="{{ old('website') }}"
                          class="form-control">
                      </div>
                    </div>
            
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>
                          {{__("User Role:")}} <span class="required">*</span>
                        </label>
                        <select name="role" data-placeholder="{{ __("Please choose user role") }}" class="form-control select2">
                          
                          @foreach($roles as $role)
                            <option {{ app('request')->input('type') == $role->name ? "selected" : "" }} value="{{ $role->name }}">{{ $role->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
            
                    <div class="col-md-6">
                      <label for="first-name">
                        {{__("Choose Image:")}}
                      </label>
                      <div class="input-group mb-3">
                        <div class="custom-file">
                          <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                          <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                        </div>
                      </div>
                     
                    </div>
            
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>{{ __('Status:') }}</label><br>
                        <label class="switch">
                          <input class="slider" type="checkbox" checked id="toggle-event3" name="status" >
                          <span class="knob"></span>
                        </label>
                        <br>

                        
                        <input type="hidden" name="status" value="1" id="status3">
                      </div>
                    </div>
            
                   
                    <div class="col-md-12 form-group mt-1">
            
                     
                     
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <div class="eyeCy">
                              <label for="password">{{ __("Enter Password:") }}</label>
                              <input minlength="8" id="password" type="password" class="passwordbox form-control" placeholder="{{ __("Enter password min. length 8") }}"
                                name="password" />
                            </div>
                          </div>
            
                        </div>
            
            
                        <div class="col-md-6 mt-1">
            
                          <div class="form-group">
                            <div class="eyeCy">
                              <label for="confirm">{{ __("Confirm Password:") }}</label>
                              <input  id="confirm_password" type="password" class="passwordbox form-control"
                                placeholder="{{ __("Re-enter password for confirmation") }}" name="password_confirmation" />
            
                              <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
            
                            <span class="required">{{$errors->first('password_confirmation')}}</span>
                          </div>
            
            
            
            
                        </div>
            
            
            
                      </div>
                    </div>
                    
            
                  </div>
                  <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                  <button @if(env('DEMO_LOCK')==0) type="submit" @else
                  title="{{ __("This action is disabled in demo !") }}" disabled="disabled" @endif  class="btn btn-primary"><i class="fa fa-check-circle"></i>
                  {{ __("Create")}}</button>

                  
                  
                </form>
              </div>
          </div>
      </div>
    </div>
</div>
@endsection
@section('custom-script')
<script>
  var baseUrl = "<?= url('/') ?>";
</script>
<script src="{{ url("js/ajaxlocationlist.js") }}"></script>
@endsection