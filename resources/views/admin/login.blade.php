<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(selected_lang()->rtl_available == 1) dir="rtl" @endif>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{  __('Admin Login').' | '.$title }}</title>
    <!-- Fevicon -->
    <link rel="icon" href="{{url('images/genral/'.$fevicon)}}" type="image/gif" sizes="16x16">
    <!-- Start css -->
    <link href="{{ url('admin_new/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('admin_new/assets/css/icons.css') }}" rel="stylesheet" type="text/css">

    @if(selected_lang()->rtl_available == 0)
      <link href="{{ url('admin_new/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    @else
        <link href="{{ url('admin_new/assets/css/style_rtl.css') }}" rel="stylesheet" type="text/css">
    @endif

    @if(env('PWA_ENABLE') == 1)
        @laravelPWA
    @endif
    <!-- End css -->
</head>
<body class="bg-primary-rgba vertical-layout">

    <div class="preloader">
        <div class="spinner"></div> 
    </div>

    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box login-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="shadow-sm bg-white-rgba card">
                                <div class="card-body">

                                    <form id="login-form" action="{{ route('admin.login') }}" method="POST" class="form" novalidate>
                                        @csrf
                                        <div class="form-head">
                                            <a href="{{ url('/') }}" class="logo">
                                                <img class="p-2 bg-primary-rgba" src="{{ url('images/genral/'.$genrals_settings->logo) }}" alt="logo">
                                            </a>
                                        </div>                                        
                                        <h4 class="text-primary my-4">{{ __('Admin Login') }}</h4>
                                        <div class="form-group">
                                            <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="{{ __('Enter email here') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                             @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            @error('g-recaptcha-response')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="{{ __("Enter Password here") }}" required>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-sm-6">
                                                <div class="custom-control custom-checkbox text-left">
                                                  <input {{ old('remember') ? 'checked' : '' }} type="checkbox" class="custom-control-input" id="rememberme" name="remember">
                                                  <label class="custom-control-label font-14" for="rememberme">{{ __('Remember Me') }}</label>
                                                </div>                                
                                            </div>
                                            @if (Route::has('password.request'))
                                                <div class="col-sm-6">
                                                  <div class="forgot-psw"> 
                                                    <a id="forgot-psw" href="{{ route('password.request') }}" class="font-14">{{ __('Forgot Your Password?') }}</a>
                                                  </div>
                                                </div>
                                            @endif
                                        </div> 
                                        
                                        <div>
                                            
                                        </div>

                                        
                                        <button type="submit" class="btn btn-block btn-primary-rgba">{{ __("Log in") }}</button>

                                    </form>

                                    @if(env("DEMO_LOCK") == 1)
                                    <table class="mt-3 table table-bordered">
                                      <tbody>
                                        <tr>
                                          
                                          <td>{{ __("Email") }}</td>
                                          <td>admin@mediacity.co.in</td>
                                          
                                        </tr>

                                        <tr>
                                          <td>{{ __("Password") }}</td>
                                          <td>12345678</td>
                                        </tr>

                                        <tr>
                                          <td align="center" colspan="2">
                                            <button type="button" class="copycred btn btn-sm btn-primary-rgba">
                                                {{__("Copy")}}
                                            </button>
                                          </td>
                                        </tr>
                                      </tbody>
                                  </table>
                                  @endif
                                    
                                  </div>
                            </div>
                        </div>
                        <!-- End Auth Box -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->        
    <script src="{{url('js/jquery.min.js')}}"></script>
    <script src="{{ url('admin_new/assets/js/popper.min.js') }}"></script>

    <script src="{{ url('admin_new/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('admin_new/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ url('admin_new/assets/js/detect.js') }}"></script>
    <script src="{{ url('admin_new/assets/js/jquery.slimscroll.js') }}"></script>
    
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('form');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }

                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();

      

        $(window).on('load',function() {
            $('.preloader').fadeOut('fast');
        });

        $('a').not('.dropdown-toggle').on('click',function() {
            $('.preloader').fadeIn('fast');
        });

        $('#login-form').submit(function(){
            
            $('.preloader').fadeIn('fast');
            
        });

        $(".copycred").on("click",function(){

          $(this).text("Copied !");

          $("input[name=email]").val('admin@mediacity.co.in');
          $("input[name=password]").val('12345678');


        });
    </script>
    <!-- End js -->
</body>
</html>