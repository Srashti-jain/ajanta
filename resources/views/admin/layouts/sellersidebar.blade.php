 <div class="leftbar">
     <!-- Start Sidebar -->
     <div class="sidebar">
         <!-- Start Navigationbar -->
         <div class="navigationbar">



             <div class="vertical-menu-detail">

                 <div class="logobar">
                     <a href="{{url('/')}}" class="logo logo-large">
                         <img src="{{ url('images/genral/'.$genrals_settings->logo) }}" class="img-fluid" alt="logo" />
                     </a>
                 </div>

                 <div class="tab-content" id="v-pills-tabContent">

                     <div class="tab-pane fade active show" id="v-pills-dashboard" role="tabpanel"
                         aria-labelledby="v-pills-dashboard">

                         <ul class="vertical-menu">



                             <li class="{{ Nav::isRoute('seller.dboard') }}">
                                 <a class="nav-link" href="{{route('seller.dboard')}}">
                                     <i class="feather icon-bar-chart-2"></i>
                                     <span>{{ __("seller.Dashboard") }}</span>
                                 </a>
                             </li>
                             <li class="{{ Nav::isRoute('get.profile') }}">
                                 <a class="nav-link" href="{{route('get.profile')}}">
                                     <i class="feather icon-user-plus"></i>
                                     <span>{{ __("seller.Profile") }}</span>
                                 </a>
                             </li>
                             <li class="{{ Nav::isResource('store') }}">
                                 <a class="nav-link" href="{{route('store.index')}} ">
                                     <i class="feather icon-shopping-cart"></i>
                                     <span>{{__("Your Store") }}</span>
                                 </a>
                             </li>

                             <li class="{{ Nav::isResource('manage/sizechart') }} {{ Nav::isRoute("trash.variant.products") }} {{ Nav::isRoute("trash.simple.products") }} {{ Nav::isResource('simple-products') }} {{ Nav::isRoute('seller.get.categories') }} {{ Nav::isRoute('seller.get.subcategories') }} {{ Nav::isRoute('seller.get.childcategories') }} {{ Nav::isRoute('seller.brand.index')  }} {{ Nav::isRoute('seller.pro.vars.all')  }}  {{ Nav::isResource('seller/products') }} {{ Nav::isRoute('seller.import.product') }} {{ Nav::isRoute('seller.add.var') }} {{ Nav::isRoute('seller.manage.stock') }} {{ Nav::isRoute('seller.edit.var') }} {{ Nav::isRoute('seller.pro.vars.all') }} {{ Nav::isRoute('seller.product.attr') }}">
                                 <a href="javaScript:void();">
                                     <i class="feather icon-grid"></i><span>{{ __("Products Management") }}</span><i
                                         class="feather icon-chevron-right"></i>
                                 </a>
                                 <ul class="vertical-submenu">
                                     <li class="{{ Nav::isRoute('seller.brand.index')  }}"><a
                                             href="{{ route('seller.brand.index') }}">{{ __("Brands") }}</a></li>
                                     <li
                                         class="{{ Nav::isRoute('seller.add.var') }} {{ Nav::isRoute('seller.manage.stock') }} {{ Nav::isRoute("trash.variant.products") }} {{ Nav::isRoute('seller.pro.vars.all')  }} {{ Nav::isResource('seller/products') }}">
                                         <a href="{{route('my.products.index')}} "><span>{{ __("Variant Products") }}</span></a>
                                     </li>
                                     <li
                                         class="{{ Nav::isRoute("trash.simple.products") }} {{ Nav::isResource('simple-products') }}">
                                         <a href="{{ route('simple-products.index') }} ">{{__("Simple Products")}}</a>
                                     </li>

                                     <li
                                         class="{{ Nav::isRoute('seller.get.categories') }} {{ Nav::isRoute('seller.get.subcategories') }} {{ Nav::isRoute('seller.get.childcategories') }}">
                                         <a href="javaScript:void();"><span>{{__('Categories')}}
                                             </span><i class="feather icon-chevron-right"></i>
                                         </a>
                                         <ul class="vertical-submenu">
                                             <li class="{{ Nav::isRoute('seller.get.categories') }}"><a
                                                     href="{{route('seller.get.categories')}}">{{__('Categories')}}</a>
                                             </li>
                                             <li class="{{ Nav::isRoute('seller.get.subcategories') }}"><a
                                                     href="{{route('seller.get.subcategories')}}">{{ __("Subcategories") }}</a>
                                             </li>
                                             <li class="{{ Nav::isRoute('seller.get.childcategories') }}"><a
                                                     href="{{route('seller.get.childcategories')}}">{{ __("Childcategories") }}</a>
                                             </li>
                                         </ul>
                                     </li>



                                     <li class="{{ Nav::isRoute('seller.product.attr') }}"><a
                                             href="{{route('seller.product.attr')}} "><span>{{ __("Product Attributes") }}</span></a>
                                     </li>

                                     <li class="{{ Nav::isResource('manage/sizechart') }}">
                                        <a href="{{ route("sizechart.index") }}">{{__("Size chart")}}
                                        </a>
                                    </li>

                                    @if(Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled())
                                     @if(getPlanStatus() == 1 && auth()->user()->activeSubscription->plan->csv_product
                                     == 1)
                                     <li class="{{ Nav::isRoute('seller.import.product') }}">
                                         <a
                                             href="{{route('seller.import.product')}} "><span>{{ __("Import Products") }}</span></a>
                                     </li>
                                     @endif
                                     @else
                                     <li class="{{ Nav::isRoute('seller.import.product') }}">
                                         <a href="{{route('seller.import.product')}} "><span>{{ __("Import Products") }}</span></a>
                                     </li>
                                     @endif
                                 </ul>
                             </li>




                             <li
                                 class="{{ Nav::isResource('order') }} {{ Nav::isRoute('seller.canceled.orders') }} {{ Nav::isRoute('seller.return.order.show') }}">

                                 <a href="javaScript:void();">
                                     <i class="feather icon-truck"
                                         aria-hidden="true"></i><span>{{ __("Order Management") }}</span>
                                     <span class="pull-right-container">
                                         <i class="fa fa-angle-left pull-right"></i>
                                     </span>
                                 </a>
                                 <ul class="vertical-submenu">
                                     <li class="{{ Nav::isResource('order') }}">
                                         <a href="{{url('seller/orders')}} "><span>{{ __("seller.Orders") }}</span> </a>
                                     </li>

                                     <li class="{{ Nav::isRoute('seller.canceled.orders') }}">
                                         <a href="{{ route('seller.canceled.orders') }}">{{__("Cancelled Orders")}}</a>
                                     </li>

                                     <li
                                         class="{{ Nav::isRoute('seller.return.order.show') }} {{ Nav::isRoute('seller.return.index') }}">
                                         <a href="{{ route('seller.return.index') }}">{{ __("Returned Orders") }}</a>
                                     </li>
                                 </ul>
                             </li>

                             <li class="{{ Nav::isRoute('vender.invoice.setting') }}"><a
                                     href="{{ route('vender.invoice.setting') }}"><i class="feather icon-settings"
                                         aria-hidden="true"></i> <span>{{__("Invoice Setting")}} </span></a></li>

                             <li class="{{ Nav::isRoute('seller.shipping.info') }}"><a
                                     href="{{ route('seller.shipping.info') }}"><i class="feather icon-info"
                                         aria-hidden="true"></i> <span>{{ __("Shipping Information") }}</span></a></li>

                            @if(Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled())

                                @include('sellersubscription::seller.menu')
                
                            @endif

                             <li id="ticket" class="{{ Nav::hasSegment(['chats','chat']) }}">
                                <a href="{{ route('admin.chat.list') }}">
                                  <i class="feather icon-message-circle" aria-hidden="true"></i><span>{{ __("My Chats") }}</span></a>
                              </li>

                             <li
                                 class="{{ Nav::isRoute('seller.commission') }} {{ Nav::isRoute('vender.payout.show.complete') }} {{ Nav::isRoute('seller.payout.index') }}">
                                 <a href="javaScript:void();">
                                     <i class="feather icon-aperture"></i> <span>{{__("Account Management") }}</span>
                                     <span class="pull-right-container">
                                         <i class="fa fa-angle-left pull-right"></i>
                                     </span>
                                 </a>
                                 <ul class="vertical-submenu">
                                     <li
                                         class="{{ Nav::isRoute('vender.payout.show.complete') }} {{ Nav::isRoute('seller.payout.index') }}">
                                         <a href="{{route('seller.payout.index')}} ">{{ __("Payouts") }}</a></li>
                                     <li class="{{ Nav::isRoute('seller.commission') }}"><a
                                             href="{{ route('seller.commission') }}">{{ __("Commissions") }}</a></li>
                                 </ul>

                             </li>
                         </ul>
                     </div>



                 </div>

             </div>
         </div>
         <!-- End Navigationbar -->
     </div>
     <!-- End Sidebar -->
 </div>