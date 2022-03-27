@extends('admin.layouts.master-soyuz')
@section('title',__('System Status | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
  @slot('heading')
    {{ __('Help and support') }}
  @endslot

  @slot('menu2')
    {{  __('System Status') }}
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
            <h5 class="card-title">{{ __('System Status') }}</h5>
          </div>
          <div class="card-body">
            @php

            $results = DB::select( DB::raw('SHOW VARIABLES LIKE "%version%"') );

            foreach ($results as $key => $result) {

              if($result->Variable_name == 'version' ){
                $db_info[] = array(
                  'value' => $result->Value
                );
              }

              if($result->Variable_name == 'version_comment'){
                $db_info[] = array(
                  'value' => $result->Value
                );
              }

            }

            $servercheck= array();

            @endphp




            <div id="message"></div>

            <table class="table table-bordered table-striped">


              <tbody>
                <tr>
                  <td>
                    <b>Laravel Version</b>
                  </td>
                  <td>
                    {{ App::version() }} <i class="fa fa-check-circle text-green"></i>
                  </td>
                </tr>
              </tbody>
            </table>


            <table class="table table-bordered table-striped">
              <thead>

                <th colspan="2">
                  MYSQL version info
                </th>
                <th>
                  {{  __('Status') }}
                </th>

              </thead>


              <tbody>
                @foreach($db_info as $key => $info)
                <tr>
                  <td>
                    {{ $key == 0 ? "MYSQL Version" : "Server Type" }}
                  </td>
                  <td>
                    {{ $info['value'] }}
                  </td>
                  <td>
                    @if($key == 0 && $info['value'] < 5.7) @php array_push($servercheck, 0); @endphp <i
                      class="fa fa-times-circle text-danger"></i>
                      @else
                      @php
                      array_push($servercheck, 1);
                      @endphp
                      <i class="fa fa-check-circle text-green"></i>
                      @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>{{ __('php extensions') }}</th>
                  <th>{{ __('Your') }}</th>
                  <th>{{ __('Required') }}</th>
                  <th>{{ __('Status') }}</th>
                </tr>
              </thead>

              <tbody>

                <tr>
                  @php
                    $v = phpversion();
                  @endphp
                  <td>
                    {{ __('php version') }} (<b>{{ $v }}</b>)
                    <br>
                    <small class="text-muted">php version required greater than than 7.2</small>
                  </td>
                  <td>
                    {{ phpversion() }}
                  </td>
                  <td>
                    {{ '7.4+' }}
                  </td>
                  <td>

                    @if($v > 7.2) <i class="text-green fa fa-check-circle"></i>
                    @php
                    array_push($servercheck, 1);
                    @endphp
                    @else
                    @php
                    array_push($servercheck, 0);
                    @endphp
                    <i class="text-danger fa fa-times-circle"></i>
                    <br>
                    <small>
                      Your php version is <b>{{ $v }}</b> which is not supported
                    </small>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('pdo') }}</td>
                  <td>
                    {{ extension_loaded('pdo') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('pdo'))

                    @php
                      array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('BCMath') }}</td>
                  <td>
                    {{ extension_loaded('BCMath') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('BCMath'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('openssl') }}</td>
                  <td>
                    {{ extension_loaded('openssl') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('openssl'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('fileinfo') }}</td>
                  <td>
                    {{ extension_loaded('fileinfo') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('fileinfo'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('json') }}</td>
                  <td>
                    {{ extension_loaded('json') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('json'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('session') }}</td>
                  <td>
                    {{ extension_loaded('session') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>


                    @if (extension_loaded('session'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('gd') }}</td>
                  <td>
                    {{ extension_loaded('gd') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('gd'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>



                <tr>
                  <td>{{ __('allow_url_fopen') }}</td>
                  <td>
                    {{ ini_get('allow_url_fopen') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (ini_get('allow_url_fopen'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>





                <tr>
                  <td>{{ __('xml') }}</td>
                  <td>
                    {{ extension_loaded('xml') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('xml'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('tokenizer') }}</td>
                  <td>
                    {{ extension_loaded('tokenizer') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('tokenizer'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>
                <tr>
                  <td>{{ __('standard') }}</td>
                  <td>
                    {{ extension_loaded('standard') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('standard'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('zip') }}</td>
                  <td>
                    {{ extension_loaded('zip') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('zip'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('mysqli') }}</td>
                  <td>
                    {{ extension_loaded('mysqli') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('mysqli'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('mbstring') }}</td>
                  <td>
                    {{ extension_loaded('mbstring') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('mbstring'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('ctype') }}</td>
                  <td>
                    {{ extension_loaded('ctype') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('ctype'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('exif') }}</td>
                  <td>
                    {{ extension_loaded('exif') ? "Enabled" : "Disabled" }}
                  </td>
                  <td>
                    {{ __('Yes') }}
                  </td>
                  <td>

                    @if (extension_loaded('exif'))

                    @php
                    array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>{{ __('max_execution_time') }} </td>
                  <td>
                    {{ ini_get('max_execution_time') }} {{__("sec.")}}
                  </td>
                  <td>
                    {{__("300 sec.")}}
                  </td>
                  <td>
                    @if (ini_get('max_execution_time') >= 300 || ini_get('max_execution_time') == '-1')
                      @php
                        array_push($servercheck, 1);
                      @endphp
                      <i class="text-green fa fa-check-circle"></i>
                    @else
                      @php
                        array_push($servercheck, 0);
                      @endphp
                      <i class="text-danger fa fa-times-circle"></i>
                    @endif
                  </td>
                </tr>

                <tr>
                  <td>
                      {{ __('memory_limit') }} 
                      
                      @php

                        $memory_limit = ini_get('memory_limit');

                        if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
                            if ($matches[2] == 'M') {
                                $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
                            } else if ($matches[2] == 'K') {
                                $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
                            }
                            else if ($matches[2] == 'G') {
                                $memory_limit = $matches[1] * 1024 * 1024 * 1024; // nnnK -> nnn KB
                            }
                        }
                        
                        $ok = ($memory_limit >= 1024 * 1024 * 1024); // at least 1G?
                        
                      @endphp
                  </td>
                  <td>
                    {{ ini_get('memory_limit') }}
                  </td>
                  <td>
                    {{ __('1G') }}
                  </td>
                  <td>
                      

                    @if ($ok == true || ini_get('memory_limit') == '-1')

                    @php
                      array_push($servercheck, 1);
                    @endphp

                      <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                      array_push($servercheck, 0);
                    @endphp

                      <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>
                      {{ __('upload_max_filesize') }}

                      @php

                        $upload_max_filesize = ini_get('upload_max_filesize');

                        if (preg_match('/^(\d+)(.)$/', $upload_max_filesize, $matches)) {
                            if ($matches[2] == 'M') {
                                $upload_max_filesize = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
                            } else if ($matches[2] == 'K') {
                                $upload_max_filesize = $matches[1] * 1024; // nnnK -> nnn KB
                            }
                            else if ($matches[2] == 'G') {
                                $upload_max_filesize = $matches[1] * 1024 * 1024 * 1024; // nnnK -> nnn KB
                            }
                        }

                        $ok = ($upload_max_filesize >= 1024 * 1024 * 1024); // at least 1G?
                        
                      @endphp

                  </td>
                  <td>
                    {{ ini_get('upload_max_filesize') }}
                  </td>
                  <td>
                    {{ __('1G') }}
                  </td>
                  <td>
                      

                    @if ($ok == true)

                    @php
                      array_push($servercheck, 1);
                    @endphp

                      <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                      array_push($servercheck, 1);
                    @endphp

                      <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td>
                      {{ __('post_max_size') }}

                      @php

                        $post_max_size = ini_get('post_max_size');

                        if (preg_match('/^(\d+)(.)$/', $post_max_size, $matches)) {
                            if ($matches[2] == 'M') {
                                $post_max_size = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
                            } else if ($matches[2] == 'K') {
                                $post_max_size = $matches[1] * 1024; // nnnK -> nnn KB
                            }
                            else if ($matches[2] == 'G') {
                                $post_max_size = $matches[1] * 1024 * 1024 * 1024; // nnnK -> nnn KB
                            }
                        }

                        $ok = ($post_max_size >= 1024 * 1024 * 1024); // at least 1G?
                        
                      @endphp

                  </td>
                  <td>
                    {{ ini_get('post_max_size') }}
                  </td>
                  <td>
                    {{ __('1G') }}
                  </td>
                  <td>
                      

                    @if ($ok == true)

                    @php
                      array_push($servercheck, 1);
                    @endphp

                      <i class="text-green fa fa-check-circle"></i>

                    @else

                    @php
                      array_push($servercheck, 0);
                    @endphp

                      <i class="text-danger fa fa-times-circle"></i>

                    @endif
                  </td>
                </tr>

                <tr>
                  <td><b>{{storage_path()}}</b> {{ __('is writable') }}?</td>
                  @php
                    $path = storage_path();
                  @endphp
                  <td>
                    {{ is_writable($path) ? "Writable" : "Non-Writable" }}
                 </td>
                 <td>
                   {{__("Yes")}}
                 </td>
                  <td>
                   
                    @if(is_writable($path))

                    @php
                    array_push($servercheck, 1);
                    @endphp
                    <i class="text-green fa fa-check-circle"></i>
                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>
                    @endif
                  </td>
                </tr>

                <tr>
                  <td><b>{{base_path('bootstrap/cache')}}</b> {{ __('is writable') }}?</td>
                  @php
                    $path = base_path('bootstrap/cache');
                  @endphp
                  <td>
                     {{ is_writable($path) ? "Writable" : "Non-Writable" }}
                  </td>
                  <td>
                    {{__("Yes")}}
                  </td>
                  <td>
                    
                    @if(is_writable($path))

                    @php
                      array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>
                    @else

                    @php
                    array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>
                    @endif
                  </td>
                </tr>

                <tr>
                  <td><b>{{storage_path('framework/sessions')}}</b> {{ __('is writable') }}?</td>
                  @php
                    $path = storage_path('framework/sessions');
                  @endphp
                   <td>
                    {{ is_writable($path) ? "Writable" : "Non-Writable" }}
                  </td>
                  <td>
                    {{__("Yes")}}
                  </td>
                  <td>
                   
                    @if(is_writable($path))

                    @php
                      array_push($servercheck, 1);
                    @endphp

                    <i class="text-green fa fa-check-circle"></i>
                    @else

                    @php
                      array_push($servercheck, 0);
                    @endphp

                    <i class="text-danger fa fa-times-circle"></i>
                    @endif
                  </td>
                </tr>


              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection
  @section('custom-script')
  <script>
    @if(!in_array(0, $servercheck))
    $("#message").html('<div class="alert bg-success"><p class="text-white"><i class="text-white fa fa-check-circle"></i> {{ __("All good ! No problem detected so far") }}</p></div>');
    @else
    $('#message').html('<div class="alert bg-warning"><p class="text-white"><i class="text-re fa fa-warning"></i> {{ __("Something went wrong ! Please check Status") }}</p></div>');
    @endif
  </script>
  @endsection