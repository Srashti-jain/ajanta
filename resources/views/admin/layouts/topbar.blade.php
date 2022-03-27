 <!-- Start Topbar Mobile -->
 <div class="topbar-mobile">
     <div class="row align-items-center">
         <div class="col-md-12">
             <div class="mobile-logobar">
                 <a href="{{ url('/') }}" class="mobile-logo">

                     <img src="{{ url('images/genral/'.$genrals_settings->logo) }}" class="img-fluid" alt="logo" />

                 </a>
             </div>
             <div class="mobile-togglebar">
                 <ul class="list-inline mb-0">
                     <li class="list-inline-item">
                         <div class="topbar-toggle-icon">
                             <a class="topbar-toggle-hamburger" href="javascript:void();">
                                 <img src="{{ url('admin_new/assets/images/svg-icon/horizontal.svg') }}"
                                     class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                 <img src="{{ url('admin_new/assets/images/svg-icon/verticle.svg') }}"
                                     class="img-fluid menu-hamburger-vertical" alt="verticle">
                             </a>
                         </div>
                     </li>
                     <li class="list-inline-item">
                         <div class="menubar">
                             <a class="menu-hamburger" href="javascript:void();">
                                 <img src="{{ url('admin_new/assets/images/svg-icon/menu.svg') }}"
                                     class="img-fluid menu-hamburger-collapse" alt="collapse">
                                 <img src="{{ url('admin_new/assets/images/svg-icon/close.svg') }}"
                                     class="img-fluid menu-hamburger-close" alt="close">
                             </a>
                         </div>
                     </li>
                 </ul>
             </div>
         </div>
     </div>
 </div>
 <!-- Start Topbar -->
 <div class="topbar">
     <!-- Start row -->
     <div class="row align-items-center">
         <!-- Start col -->
         <div class="col-md-12 align-self-center">


             {{-- <li class="mt-2 list-inline-item" id="stour">

                 <a role="button" class="cursor-pointer" onclick="starttour()">
                     <i class="feather icon-tv" aria-hidden="true"></i> {{__("Setup Tour")}}
             </a>

             </li> --}}

             <li class="mt-2 list-inline-item">
                 <a title="Visit site" href="{{ url('/') }}" target="_blank">
                     {{__("Visit Site")}} <i class="feather icon-external-link" aria-hidden="true"></i>
                 </a>
             </li>



             <div class="infobar">
                 <ul class="list-inline mb-0">




                     <li class="list-inline-item">
                         <div class="languagebar">
                             <div class="dropdown">

                                 <select class="langdropdown2 form-control" onchange="changeLang()" id="changed_lng">
                                     @foreach(\DB::table('locales')->where('status','=',1)->get() as $lang)
                                     <option {{ Session::get('changed_language') == $lang->lang_code ? "selected" : ""}}
                                         value="{{ $lang->lang_code }}">{{ ucfirst($lang->lang_code) }}</option>
                                     @endforeach
                                 </select>


                             </div>
                         </div>
                     </li>
                     @if(in_array('Super Admin',auth()->user()->getRoleNames()->toArray()))
                     <li class="list-inline-item">
                         <div class="settingbar">
                             <a href="javascript:void(0)" id="infobar-settings-open" class="infobar-icon">
                                 <img src="{{ url("admin_new/assets/images/svg-icon/settings.svg") }}"
                                     class="text-center img-fluid" alt="settings">

                                 <span class="live-icon">
                                     9
                                 </span>
                             </a>

                         </div>
                     </li>
                     @endif

                     <li class="list-inline-item">
                         <div class="settingbar">
                             <a href="javascript:void(0)" id="notification-open" class="infobar-icon">
                                 <img src="{{ url("admin_new/assets/images/svg-icon/notifications.svg") }}"
                                     class="img-fluid" alt="settings">
                                 <span class="live-icon">

                                     <span id="countNoti" class="label label-warning">

                                         {{ auth()->user()->unreadnotifications()->where('n_type','=','order_v')->count() }}

                                     </span>

                                 </span>
                             </a>
                         </div>
                     </li>


                     <li class="list-inline-item">
                         <div class="profilebar">
                             <div class="dropdown">
                                 <a class="dropdown-toggle" href="#" role="button" id="profilelink"
                                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                     @if(Auth::user()->image != '' &&
                                     file_exists(public_path().'/images/user/'.Auth::user()->image))
                                     <img src="{{url('images/user/'.Auth::user()->image)}}" alt="profilephoto"
                                         class="rounded img-fluid">
                                     @else
                                     <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="profilephoto"
                                         class="rounded img-fluid">
                                     @endif

                                     <span class="live-icon">{{ Auth::user()->name }}</span><span
                                         class="feather icon-chevron-down live-icon"></span></a>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                     <div class="dropdown-item">
                                         <div class="profilename">
                                             <h5>{{ Auth::user()->name }}</h5>
                                         </div>
                                     </div>
                                     <div class="userbox">
                                         <ul class="list-unstyled mb-0">
                                             <li class="media dropdown-item">
                                                 @if(auth()->user()->role_id == 'v')
                                                 <a href="{{ route('get.profile') }}" class="profile-icon"><img
                                                         src="{{ url('admin_new/assets/images/svg-icon/crm.svg') }}"
                                                         class="img-fluid" alt="user">{{ __("My Profile") }}
                                                 </a>
                                                 @else

                                                 <a href="{{ url('admin/users/'.Auth::user()->id.'/edit') }}"
                                                     class="profile-icon"><img
                                                         src="{{ url('admin_new/assets/images/svg-icon/crm.svg') }}"
                                                         class="img-fluid" alt="user">{{ __("My Profile") }}
                                                 </a>

                                                 @endif
                                             </li>
                                             @if(auth()->user()->role_id == 'v')
                                             <li class="media dropdown-item">
                                                 <a href="{{ route('store.index') }}" class="profile-icon"><img
                                                         src="{{ url('admin_new/assets/images/svg-icon/ecommerce.svg') }}"
                                                         class="img-fluid" alt="user">{{ __("Your store") }}</a>
                                             </li>
                                             @else
                                             
                                             @if(isset(auth()->user()->store))
                                                <li class="media dropdown-item">
                                                    <a href="{{ url('admin/stores/'.Auth::user()->store->id.'/edit') }}"
                                                        class="profile-icon"><img
                                                            src="{{ url('admin_new/assets/images/svg-icon/ecommerce.svg') }}"
                                                            class="img-fluid" alt="user">{{ __("Your store") }}
                                                    </a>
                                                </li>
                                             @endif

                                             @endif

                                             <li class="media dropdown-item">
                                                 <a href="{{ route('logout') }}" class="profile-icon" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><img
                                                         src="{{ url('admin_new/assets/images/svg-icon/logout.svg') }}"
                                                         class="img-fluid" alt="logout">Logout</a>

                                                 <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                     style="display: none;">
                                                     @csrf
                                                 </form>
                                             </li>
                                         </ul>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </li>
                 </ul>
             </div>
         </div>
         <!-- End col -->
     </div>
     <!-- End row -->
 </div>
 @if(in_array('Super Admin',auth()->user()->getRoleNames()->toArray()))
 <!-- Sidebar quick settings -->
 <div id="infobar-settings-sidebar" class="infobar-settings-sidebar">

     <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
         <h4>{{ __("Settings") }}</h4><a href="javascript:void(0)" id="infobar-settings-close" class="infobar-settings-close"><img
                 src="{{ url('admin_new/assets/images/svg-icon/close.svg') }}" class="img-fluid menu-hamburger-close"
                 alt="close"></a>
     </div>
     <div class="infobar-settings-sidebar-body">
         <div class="h-100 bg-primary-rgba p-3">

             <form action="{{ url('/update-quick-setting') }}" method="POST">
                 @csrf
                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("Enable Multiseller") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input
                             {{ isset($vendor_system) && $vendor_system == 1 ? "checked" : "" }} name="vendor_enable"
                             type="checkbox" class="js-switch-setting-first" /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('If enabled than Multiseller system will be active on your portal.') }}</small>
                     </div>

                 </div>

                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("Enable Preloader") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input {{ env('ENABLE_PRELOADER') =='1' ? "checked" : "" }}
                             name="ENABLE_PRELOADER" type="checkbox" class="js-switch-setting-first" /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Enable or disable preloader by toggling it.') }}</small>
                     </div>

                 </div>

                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("APP DEBUG") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input name="APP_DEBUG" @if(env('DEMO_LOCK') !=1)
                             {{ env('APP_DEBUG') == true ? "checked" : "" }} @endif type="checkbox"
                             class="js-switch-setting-first" /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("Turn it")}} <b>{{ __('ON') }}</b>. {{__("IF you face 500 error")}}.</small>
                     </div>

                 </div>

                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("Disable Right Click?") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input name="right_click" type="checkbox"
                             class="js-switch-setting-first"
                             {{ $genrals_settings->right_click=='1' ? "checked" : "" }} /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("If enabled than Right click will not work on whole project.") }}</small>
                     </div>

                 </div>

                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("Disables Inspect Element?") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input type="checkbox" class="js-switch-setting-first"
                             name="inspect" {{ $genrals_settings->inspect == '1' ? "checked" : "" }} /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> <b>CTRL+U {{__("OR")}} CTRL+SHIFT+I</b> {{__('keys not work on whole project.') }}</small>
                     </div>

                 </div>

                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("Login to display price") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input type="checkbox" class="js-switch-setting-first"
                             name="login" {{ $genrals_settings->login=='1' ? "checked" : "" }} /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('If enabled only logged in users will able to see product prices.') }}</small>
                     </div>

                 </div>

                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("Enable email verification on registration?") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input type="checkbox" class="js-switch-setting-first"
                             name="email_verify_enable"
                             {{ $genrals_settings->email_verify_enable == 1 ? "checked" : "" }} /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('If enabled than email will be sent to user when register.') }}</small>
                     </div>

                 </div>

                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("Enable Cash on delivery?") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input type="checkbox" class="js-switch-setting-first"
                             name="COD_ENABLE" {{ env('COD_ENABLE') == 1 ? "checked" : "" }} /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('If enabled than cash on delivery will enable on payment page.') }}</small>
                     </div>

                 </div>

                 <div class="p-1 row align-items-center pb-2">

                     <div class="col-md-8">
                         <h6 class="mb-0">{{ __("Hide sidebar?") }}</h6>
                     </div>
                     <div class="col-md-4 text-right"><input type="checkbox" class="js-switch-setting-first"
                             name="HIDE_SIDEBAR" {{ env('HIDE_SIDEBAR') =='1' ? "checked" : "" }} /></div>

                     <div class="col-md-12">
                         <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __("By toggling it make the full width front page it.") }}</small>
                     </div>

                 </div>

                 <div class="text-right">
                     <button class="btn btn-md rounded btn-primary-rgba">
                         <i class="feather icon-save"></i> {{__("Save settings")}}
                     </button>
                 </div>
             </form>

         </div>

     </div>
 </div>
 @endif
 <!-- Notification Sidebar -->
 <div id="notification-sidebar" class="infobar-settings-sidebar">
     <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
         <h4>@if(auth()->user()->unreadnotifications->where('n_type','=','order_v')->count())
             {{__("You have")}} {{ auth()->user()->unreadnotifications->where('n_type','=','order_v')->count() }} {{__("New Orders")}} {{__("Notification!")}}
            
             @else
             <span class="text-center">{{ __("No Notifications") }}</span>
             @endif</h4><a href="javascript:void(0)" id="notification-sidebar-close" class="infobar-settings-close"><img
                 src="{{ url('admin_new/assets/images/svg-icon/close.svg') }}" class="img-fluid menu-hamburger-close"
                 alt="close"></a>
     </div>
     <div class="infobar-settings-sidebar-body">
         @if(auth()->user()->unreadnotifications->where('n_type','=','order_v')->count())
         <a class="mr-3 float-right" href="{{ route('mark_read_order') }}">{{ __('Mark all as read') }}</a>
         <div class="clearfix"></div>
         @endif
         <div class="p-3" style="maxheight: 500px;overflow: auto">


             @if(auth()->user()->unreadnotifications->where('n_type','=','order_v')->count())

             @foreach(auth()->user()->unreadNotifications->where('n_type','=','order_v') as $notification)


             <div class="bg-primary-rgba p-3">
                 <a class="font-weight-normal" title="{{ $notification->data['data'] }}"
                     onclick="markread('{{ $notification->id }}')" href="{{ url($notification->url) }}">
                     <img src="{{ url('admin_new/assets/images/ecommerce/product_04.svg') }}" class="img-fluid"
                         width="35" alt="product">
                     #{{ $notification->data['data'] }}
                 </a>
                 <div class="clearfix"></div>
                 <small class="clearfix float-right"><i class="feather icon-calendar"
                         aria-hidden="true"></i>{{ date('jS M y',strtotime($notification->created_at)) }}</small>

             </div>
             <div class="clearfix"></div>



             @endforeach

             @else

             <h4 class="text-center text-primary"><i class="feather icon-bell-off"></i> {{ __("No Notifications") }}
             </h4>

             @endif


         </div>

     </div>
 </div>