@extends("admin/layouts.master-soyuz")
@section('title',__('Admin Dashboard | '))
@section("body")


@component('admin.component.breadcumb')

  @slot('heading')
    {{ __('Dashboard') }}
  @endslot

@endcomponent


<div class="contentbar">       
  @can('dashboard.states')         
  <div class="row">
    <div class="col-lg-12 col-xl-12">
      
      <div class="alert alert-success alert-dismissible fade show">
        
        
        <span id="update_text"></span>
  
        <form action="{{ url("/merge-quick-update") }}" method="POST" class="float-right display-none updaterform">
            @csrf
            <input required type="hidden" value="" name="filename">
            <input required type="hidden" value="" name="version">
            <button class="btn btn-sm btn-primary-rgba">
              <i class="feather icon-check-circle"></i> {{__("Update Now")}}
            </button>
        </form>
       
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
  
      </div>

      <div class="row">
        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{$user}}</h4>
                      <p class="font-14 mb-0 ">{{ __('Total Users') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a href="{{route('users.index')}}"> <i class="text-success feather icon-user iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>
     
        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4 >{{$order}}</h4>
                      <p class="font-14 mb-0">{{ __('Total Orders') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a href="{{url('admin/order')}}"> <i class="text-warning feather icon-shopping-cart mr-2 iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{ $totalcancelorder }}</h4>
                      <p class="font-14 mb-0">{{ __('Total Cancelled Orders') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a href="{{url('admin/ord/canceled')}}"> <i class="text-danger feather icon-x-circle iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{ $totalproducts }}</h4>
                      <p class="font-14 mb-0">{{ __('Total Products') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a href="{{url('admin/products')}}"> <i class="text-primary feather icon-truck iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{$store}}</h4>
                      <p class="font-14 mb-0">{{ __('Total Stores') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a href="{{url('admin/stores')}}"> <i class="text-info feather icon-home iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>



        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{$category}}</h4>
                      <p class="font-14 mb-0">{{ __('Total Categories') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a  href="{{url('admin/category')}}"> <i class="text-secondary feather icon-shopping-bag iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{$coupan}}</h4>
                      <p class="font-14 mb-0">{{ __("Total Coupons") }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a href="{{url('admin/coupan')}}"> <i class="text-success feather icon-grid iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{$faqs}}</h4>
                      <p class="font-14 mb-0">{{ __('Total FAQ\'s') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a href="{{url('admin/faq')}}"> <i class="text-warning feather icon-help-circle iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>

        @if($genrals_settings->vendor_enable == 1)
        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{ $pending_payout }}</h4>
                      <p class="font-14 mb-0">{{ __('Pending Payouts') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a href="{{ route('seller.payouts.index') }}"> <i class="text-danger feather icon-credit-card iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-8">
                      <h4>{{ $totalsellers }}</h4>
                      <p class="font-14 mb-0">{{ __('Total sellers (active)') }}</p>
                    </div>
                    <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                      <a  href="{{ route('users.index',['filter' => 'sellers']) }}"> <i class="text-warning feather icon-users iconsize"></i>
                      </a>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>

        @endif

        <div class="col-md-3 ">
          <div class="card m-b-30 shadow-sm">
              <div class="card-body">
                <div class="row">
                  <div class="col-8">
                    <h4>{{ $total_testinonials }}</h4>
                    <p class="font-14 mb-0">{{ __('Total Testimonials (active)') }}</p>
                  </div>
                  <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                    <a href="{{ route('testimonial.index') }}"> <i class="text-primary feather  icon-sliders iconsize"></i>
                    </a>
                    </div>
                    
                </div>
              </div>
          </div>
        </div>


        <div class="col-md-3 ">
          <div class="card m-b-30 shadow-sm">
              <div class="card-body">
                <div class="row">
                  <div class="col-8">
                    <h4>{{ $total_specialoffer }}</h4>
                    <p class="font-14 mb-0">{{ __('Total Special offers (active)') }}</p>
                  </div>
                  <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                    <a  href="{{ route('special.index') }}"> <i class="text-info feather icon-gift iconsize"></i>
                    </a>
                    </div>
                    
                </div>
              </div>
          </div>
        </div>



        <div class="col-md-3 ">
          <div class="card m-b-30 shadow-sm">
              <div class="card-body">
                <div class="row">
                  <div class="col-8">
                    <h4>{{ $total_hotdeals }}</h4>
                    <p class="font-14 mb-0">{{ __('Total Hotdeals (active)') }}</p>
                  </div>
                  <div class="col-4 animate__animated animate__fadeIn animate__delay-2s">
                    <a href="{{ route('hotdeal.index') }}"> <i class="text-secondary feather icon-archive iconsize"></i>
                    </a>
                    </div>
                    
                </div>
              </div>
          </div>
       </div>

    </div>



    <div class="row">
         
      @if($dashsetting->fb_wid ==1 || $dashsetting->tw_wid==1 || $dashsetting->insta_wid==1)
      @php
      $connected = @fsockopen("www.facebook.com", 80);
      @endphp
           @if($dashsetting->fb_wid ==1)
            <div class="col-md-4">
              <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-3 iconsize">
                      
                     <i class="fa fa-facebook-official text-primary"></i>

                    </div>
                    <div class="col-9">
                     <h4>{{ __('Page Likes') }}</h4>
                      @if($dashsetting->fb_page_id != '' || $dashsetting->fb_page_token != '')

                      @if($connected)
                      @php

                        $fb_page = "'".$dashsetting->fb_page_id."'";
                        $access_token = "'".$dashsetting->fb_page_token."'";
                        $url = 'https://graph.facebook.com/v3.2/'.$fb_page.'?fields=fan_count&access_token='.$access_token;
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        $result = curl_exec($curl);

                        curl_close($curl);
                        if($result) { // if valid json object
                          $result = json_decode($result); // decode json object
                          if(isset($result->fan_count)) { 
                            echo '<h4 class="animate__animated animate__fadeIn animate__delay-1s">'.$result->fan_count.'</h4>';
                          }
                        }
                        else{
                          echo __('Page is not a valid FB Page');
                        }
                      @endphp
                      @else
                        <p><b>{{ __('Connection Problem !') }}</b></p>
                      @endif
                      @else
                        <p class="animate__animated animate__fadeIn animate__delay-1s"><b>{{ __('Set up your facebook page key in Admin Dashboard Setting !') }}</b></p>
                      @endif
                      
                     
                    </div>
                   
                  </div>
                </div>
              </div>
            </div>
            @endif

            @if($dashsetting->tw_wid==1)
            <div class="col-md-4">
              <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-3 iconsize">
                      <i class="fa fa-twitter-square text-info"></i>
                     
                    </div>
                    <div class="col-9">
                      <h4>{{ __('Followers') }}</h4>
                      @if($dashsetting->tw_username != '')

                      @if($connected)
                      <?php 
                      
                      $data = @file_get_contents('https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names='.$dashsetting->tw_username); 
                      $parsed =  json_decode($data,true);
                      try{
                        $tw_followers =  $parsed[0]['followers_count'];
                      
                        echo '<h4 class="animate__animated animate__fadeIn animate__delay-1s">'.$tw_followers.'</h4>';
                      }catch(\Exception $e){
                        echo '<span class="info-box-number">'.$e->getCode().''.__('Invalid Username !').'</span>';
                      }
                    ?>
                      @else
                      <p><b>{{ __('Connection Problem !') }}</b></p>
                      @endif
                      @else
                      <p class="animate__animated animate__fadeIn animate__delay-1s"><b>
                        {{__('Set up Twitter username in Admin Dashboard Setting !')}}  
                      </b></p>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            @if($dashsetting->insta_wid==1)
            <div class="col-md-4">
              <div class="card m-b-30 shadow-sm">
                <div class="card-body">
                  <div class="row">
                    <div class="col-3 iconsize">
                      <i class="fa fa-instagram text-danger"></i>
                     
                    </div>
                    <div class="col-9">
                      <h4>{{ __('Followers') }}</h4>
                      @if($dashsetting->inst_username !='')

                      @if($connected)
                      <?php
                        $raw = @file_get_contents("https://www.instagram.com/$dashsetting->inst_username"); //
                        preg_match('/\"edge_followed_by\"\:\s?\{\"count\"\:\s?([0-9]+)/',$raw,$m);
                        
                        
                        try{
                          echo '<h4 class="animate__animated animate__fadeIn animate__delay-1s">'.$m[1].'</h4>';
                        }catch(\Exception $e){
                          echo '<span class="info-box-number">'.$e->getCode().' '.__('Invalid Username !').'</span>';
                        }
                        
                      ?>
                      @else
                      <p><b>{{ __('Connection Problem !') }}</b></p>
                      @endif
                      @else
                      <p class="animate__animated animate__fadeIn animate__delay-1s"><b> {{__("Set up Instagram username in")}} <br>{{ __('Admin Dashboard Setting !') }}</b></p>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
      @endif
                    

          <div class="col-md-12">
            <div class="shadow-sm card">
              {!! $orderchart->container() !!}
            </div>
          </div>


          <div class=" col-md-6 mt-4">
            <div class="shadow-sm card m-b-30">
                <div class="card-header  bg-primary">                                
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h5 class="card-title mb-0 text-white">{{ __('Visitors') }}</h5>
                        </div>
                        <div class="col-3">
                          
                        </div>
                    </div>
                </div>
                <div class="card-body bg-primary">
                  <div id="world-map" style="height: 350px; width: 100%;"></div>
                </div>
            </div>
          </div>
        
          <div class="col-md-6 mt-4">
            <div style="height: 440px; width: 100%;" class="shadow-sm card p-2">
              {!! $userchart->container() !!}
            </div>
          </div>

            @if($dashsetting->lat_ord ==1)
            <div class="col-md-8 m-b-30">
              <div class="shadow-sm h-100 card">
                  <div class="card-header">                                
                      <div class="row align-items-center">
                          <div class="col-9">
                              <h5 class="card-title mb-0">
                                {{__("Latest Orders")}}
                              </h5>
                          </div>
                          <div class="col-3">
                              <div class="dropdown">
                                  <button class="btn btn-link p-0 font-18 float-right" type="button" id="upcomingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="upcomingTask">
                                      @if(count($latestorders))
                                        <a class="dropdown-item font-13" href="{{ url('admin/order') }}">
                                          {{__('View All Orders')}}
                                        </a>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-borderd">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('Order ID') }}</th>
                              <th>{{ __('Customer name') }}</th>
                              <th>{{ __('Total Qty') }}</th>
                              <th>{{ __('Total Price') }}</th>
                              <th>{{ __('Order Date') }}</th>
                            </tr>
                          </thead>
                
                          <tbody>
                            @forelse($latestorders as $key=> $order)
                
                            <tr>
                              <td>{{$key+1}}</td>
                              <td><a title="{{ __('View order') }}"
                                  href="{{ route('show.order',$order->order_id) }}">#{{ $inv_cus->order_prefix.$order->order_id }}</a>
                              </td>
                              <td>{{ $order->user->name }}</td>
                              <td>{{ $order->qty_total }}</td>
                              <td><i class="{{ $order->paid_in }}"></i>{{ $order->order_total }}</td>
                              <td>{{ date('d-M-Y',strtotime($order->created_at)) }}</td>
                
                            </tr>
                            @empty
                              <tr>
                                <td colspan="6">
                                  {{  __("No orders found !") }}
                                </td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
            </div>
            @endif

            <div class="col-md-4 m-b-30">
              <div class="shadow-sm card">
                {!! $piechart->container() !!}
              </div>
            </div>


            @if($genrals_settings->vendor_enable == 1)
            @if($dashsetting->rct_str==1)
            <div class="col-md-12">
              <div class="shadow-sm card m-b-30">
                  <div class="card-header">                                
                      <div class="row align-items-center">
                          <div class="col-9">
                              <h5 class="card-title mb-0">
                                {{__('Recent store requests')}}
                              </h5>
                          </div>
                          <div class="col-3">
                              <div class="dropdown">
                                  <button class="btn btn-link p-0 font-18 float-right" type="button" id="upcomingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="upcomingTask">
                                    @if(count($storerequest))
                                      <a class="dropdown-item font-13" href="{{ url('admin/appliedform') }}">
                                        {{__("View all store requests")}}
                                      </a>
                                    @else
                                      <a class="dropdown-item font-13" href="#">
                                        {{__("No request available")}}
                                      </a>
                                    @endif
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-borderd">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __("Store Name") }}</th>
                              <th>{{ __('Buisness Email') }}</th>
                              <th>{{ __('Request By') }}</th>
                            </tr>
                          </thead>
                
                          <tbody>
                
                            @forelse($storerequest as $key => $store)
                            <tr>
                              <td>{{$key + 1}}</td>
                              <td>{{ $store->name }}</td>
                              <td>{{ $store->email }}</td>
                              <td>{{ $store->owner }}</td>
                            </tr>
                            @empty
                              <tr>
                                <td align="center" colspan="4">
                                  <b>{{ __("No store request yet !") }}</b>
                                </td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
            </div>
            @endif
            @endif

            @if($dashsetting->rct_pro ==1)
            <div class="col-md-8">
              <div class="shadow-sm card m-b-30">
                  <div class="card-header">                                
                      <div class="row align-items-center">
                          <div class="col-9">
                              <h5 class="card-title mb-0">
                                {{__('Recently added products')}}
                              </h5>
                          </div>
                          <div class="col-3">
                              <div class="dropdown">
                                  <button class="btn btn-link p-0 font-18 float-right" type="button" id="upcomingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="upcomingTask">
                                  
                                      <a class="dropdown-item font-13" href="{{ url('admin/products') }}">
                                        {{__('View all products')}}
                                      </a>
                                    
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="card-body">
                   
                        @foreach($products->take($dashsetting->max_item_ord) as $pro)
                        <div class="row mb-2">
                        <div class="text-center col-md-2">
                          @if($pro['thumbnail'] != '')
                            <img class="object-fit" height="50px" src="{{ $pro['thumbnail'] }}" title="{{ $pro['productname'] }}" alt="{{ __("Product image") }}">
                          @endif
                        </div>
                        <div class="col-md-8">
                          <a href="{{ $pro['producturl'] }}" class="product-title"> {{ substr($pro['productname'],0,50)}}
                           </a><br>
                           <span class="product-description">
                            {{ substr($pro['detail'],0,100)}}{{strlen($pro['detail'])>100 ? "..." : "" }}
                          </span>
                        </div>
                        <div class="col-md-2">
                          <span class="badge badge-primary">
                            {{ $pro['price_in'] }} {{ $pro['price'] }}  
                          </span>
                          
                        </div>
                       
                      </div>
                      @endforeach

                      
                   
                  </div>
              </div>
            </div>
            @endif

            @if($dashsetting->rct_cust ==1)
            <div class="col-md-4">
              <div class="shadow-sm card m-b-30">
                  <div class="card-header">                                
                      <div class="row align-items-center">
                          <div class="col-5">
                              <h5 class="card-title mb-0">
                                {{__("Recent Users")}}
                              </h5>
                          </div>
                          <div class="col-7">
                            <div class="row">
                              <div class="col-md-10">
                                <span class="{{ selected_lang()->rtl_available == 0 ? "float-right" : "float-left" }} mt-2 badge badge-success">{{ $registerTodayUsers }} {{ __('members today') }}</span>
                              </div>
                              <div class="col-md-2">
                            
                              <div class="dropdown">
                                
                                  <button class="btn btn-link p-0 font-18 float-right" type="button" id="widgetRevenue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="widgetRevenue">
                                      <a class="dropdown-item font-13"  href="{{ route('users.index',['filter' => 'customer']) }}">{{ __('View all users') }}</a>
                                
                                  </div>
                              </div>
                              </div>
                            </div>
                            
                          </div>
                      </div>
                  </div>                            
                  <div class="user-slider">
                    @foreach($users =
                    App\User::where('role_id','!=','a')->orderBy('id','DESC')->take($dashsetting->max_item_cust)->get() as
                    $user)
                      <div class="user-slider-item">
                          <div class="card-body text-center">
                              <span >
                                @if($user->image !="" && file_exists(public_path().'/images/user/'.$user->image))
                                <img class="mx-auto d-block user_image" src="{{ url('images/user/'.$user->image)  }}" alt="">
                                @else
                                <img class="mx-auto d-block user_image" src="{{ Avatar::create($user->name)->tobase64() }}" alt="">
                                @endif
                              </span>
                              <h5 class="mt-3">{{ $user->name }}</h5>
                              <p>{{ $user->email }}</p>
                              <p><span class="badge badge-primary-inverse">{{ date('Y-m-d',strtotime($user->created_at)) }}</span></p>
                          </div>
                        </div>
                        @endforeach
                     
                                                   
                  </div>                            
              </div>      
          </div>
          @endif

      

    
      </div>
    </div>
  </div>
  @else 
  <div class="alert alert-primary">
    <span class="info-box-icon {{ $time < 19 ? "bg-orange" : "bg-purple" }}">
      @if($time < "19")
        <i class="feather icon-sun"></i>
      @else 
        <i class="feather icon-moon"></i>
      @endif
    </span>
  
    <div class="d-inline info-box-content">
      <span class="font-weight-bold">{{ $day }} ! {{ auth()->user()->name }}</span>
      <span class="info-box-number">
        {{ $quote }}
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  @endcan
</div>
@endsection

@section('custom-script')
<script src="{{ url('front/vendor/js/Chart.min.js') }}" charset="utf-8"></script>
<script src="{{ url('front/vendor/js/highcharts.js') }}" charset="utf-8"></script>
<script>var baseurl = @json(url('/'));</script>
<script src="{{ url('js/updater.js') }}"></script>
<script>
  $(function () {


    $.ajax({
      method: "GET",
      url: '{{ route("get.visitor.data") }}',
      success: function (response) {
        console.log(response);

        $('#world-map').vectorMap({
          map: 'world_mill_en',
          backgroundColor: 'transparent',
          regionStyle: {
            initial: {
              fill: '#e4e4e4',
              'fill-opacity': 1,
              stroke: 'none',
              'stroke-width': 0,
              'stroke-opacity': 1
            }
          },
          series: {
            regions: [{
              values: response,
              scale: ['#f9b9be', '#fbdca2','#6fdca4'],
              normalizeFunction: 'polynomial'
            }]
          },
          onRegionLabelShow: function (e, el, code) {
            if (typeof response[code] != 'undefined') {
              el.html(el.html() + ': ' + response[code] + ' visitors');
            } else {
              el.html(el.html() + ': ' + '0' + ' visitors');
            }

          }
        });

      },
      error: function (err) {
        console.log('Error:' + err);
      }
    });


  });
</script>
{!! $userchart->script() !!}
{!! $piechart->script() !!}
{!! $orderchart->script() !!}
@endsection
