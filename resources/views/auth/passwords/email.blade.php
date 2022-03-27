@extends("front.layout.master")
@section('title',__("Forget Password ?"))
@section('body')
@php
    require_once(base_path().'/app/Http/Controllers/price.php');
@endphp
  <div class="body-content">
    <div class="container-fluid">
        <div class="sign-in-page">
            <div class="row justify-content-center">
              <div id="aniBox" class="col-md-6 sign-in">
                
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Module::has('MimSms') && Module::find('MimSms')->isEnabled() && env('MIM_SMS_OTP_ENABLE') == 1 && env('DEFAULT_SMS_CHANNEL') == 'mim')
                        @include('mimsms::auth.forgetpassword')
                    @elseif(Module::has('Exabytes') && Module::find('Exabytes')->isEnabled() && env('DEFAULT_SMS_CHANNEL') == 'exabytes')
                        @include('exabytes::auth.forgetpassword')
                    @else
                      <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group has-feedback">
                          <label for="email">{{ __('staticwords.Enteremailtocontinue') }}</label>
                          <input required="" value="{{ old('email') }}" type="email" name="email" class="form-control" placeholder="{{ __('staticwords.Email') }}">
                          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                          @if ($errors->has('email'))
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                          @endif
                        </div>
                        
                        <div class="row">
                          <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                {{ __('staticwords.SendPasswordResetLink') }}
                            </button>
                          </div>
                        </div>
                      
                      </form>
                    @endif
              </div>
            </div>
        </div>
    </div>
  </div>
@endsection