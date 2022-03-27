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



        

          <div>



            <ul class="vertical-menu">



              <li class="{{ Nav::isRoute('admin.main') }}">

                <a href="{{ route('admin.main') }}">

                  <i class="feather icon-airplay" aria-hidden="true"></i> <span>{{ __('Dashboard') }}</span>

                </a>

              </li>



              @canany(['users.view','roles.view'])

                <li class="{{ Nav::isResource('roles') }} {{ Nav::isResource('users') }}">

                  <a href="javaScript:void();">

                    <i class="feather icon-users" aria-hidden="true"></i> <span>{{ __('Users') }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>



                  <ul class="vertical-submenu">



                    @can('users.view')

                    <li class="{{ Nav::isResource('users') }}"><a href="{{ route('users.index') }} ">

                        {{__('All users')}} </a></li>

                    @endcan



                    @can('roles.view')



                    <li class="{{ Nav::isResource('roles') }}"><a href="{{ route('roles.index') }}">

                        {{ __('Roles and Permissions') }}</a></li>

                    @endcan



                  </ul>

                </li>

              @endcan
              <li id="pos" class="{{ Nav::isResource('admin/menu') }}">
                <a href="{{ URL::to('admin/pos');}}">
                  <i class="feather icon-shopping-cart" aria-hidden="true"></i> <span>{{ __('POS') }}</span>

                </a>
              </li>


              @can('menu.view')

                <li id="menum" class="{{ Nav::isResource('admin/menu') }}">

                  <a href="{{ route('menu.index') }}">

                    <i class="feather icon-sliders" aria-hidden="true"></i> <span>{{ __('Menu Management') }}</span>



                  </a>

                </li>

              @endcan





              @if(isset($vendor_system) && $vendor_system == 1)

                @canany(['stores.accept.request','stores.view'])

                  <li class="{{ Nav::isRoute('get.store.request') }} {{ Nav::isResource('stores') }}">

                    <a href="javaScript:void();">

                      <i class="feather icon-database" aria-hidden="true"></i> <span>{{ __('Store') }}</span>

                      <i class="feather icon-chevron-right"></i>

                    </a>



                    <ul class="vertical-submenu">





                      @can('stores.view')

                      <li class="{{ Nav::isResource('stores') }}">

                        <a href="{{url('admin/stores')}} ">

                          {{__('Stores')}}

                        </a>

                      </li>

                      @endcan









                      @if($vendor_system==1)

                      @can('stores.accept.request')

                      <li class="{{ Nav::isRoute('get.store.request') }}">

                        <a href="{{route('get.store.request')}}">

                          {{__('Stores Request')}}

                        </a>

                      </li>

                      @endcan

                      @endif





                    </ul>

                  </li>

                @endcan

              @endif





              @canany(['review.view','brand.view','category.view','subcategory.view','childcategory.view','products.view','products.import','attributes.view','coupans.view','returnpolicy.view','units.view','specialoffer.view'])

                <li class="{{ Nav::isResource('sizechart') }} {{ Nav::isResource('admin/commission_setting') }} {{ Nav::isResource('admin/commission') }} {{ Nav::isRoute('review.index') }} {{ Nav::isRoute('r.ap') }} {{ Nav::isResource('admin/return-policy') }} {{ Nav::isResource('brand') }} {{ Nav::isResource('coupan') }} {{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('grandcategory') }} {{ Nav::isResource('products') }} {{ Nav::isResource('unit') }} {{ Nav::isResource('special') }} {{ Nav::isRoute('attr.index') }} {{ Nav::isRoute('attr.add') }} {{ Nav::isRoute('opt.edit') }} {{ Nav::isRoute('pro.val') }} {{ Nav::isRoute('add.var') }} {{ Nav::isRoute('manage.stock') }} {{ Nav::isRoute('edit.var') }} {{ Nav::isRoute('pro.vars.all') }} {{ Nav::isRoute('import.page') }} {{ Nav::isRoute('requestedbrands.admin') }} ? 'show' : ''">

                  <a href="javaScript:void();">

                    <i class="feather icon-shopping-bag" aria-hidden="true"></i> <span>{{ __('Products Management') }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>

                  <ul class="vertical-submenu">

                    @can('brand.view')

                    <li class="{{ Nav::isResource('brand') }}"><a href="{{url('admin/brand')}} ">{{ __('Brands') }}</a></li>

                    @if($genrals_settings->vendor_enable == 1)

                      <li class="{{ Nav::isRoute('requestedbrands.admin') }}"><a href="{{route('requestedbrands.admin')}} ">{{ __('Requested Brands') }}



                          @php

                          $brands = App\Brand::where('is_requested','=','1')->where('status','0')->orderBy('id','DESC')->count();

                          @endphp



                          @if($brands !=0)

                          <span class="pull-right-container">

                            <small class="label pull-right bg-red">{{ $brands }}</small>

                          </span>

                          @endif



                        </a>

                      </li>

                    @endif

                    @endcan

                    <li class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }}

                    {{ Nav::isResource('grandcategory') }}"">

                      <a href="javaScript:void();">{{__('Categories')}}

                        <i class="feather icon-chevron-right"></i>

                      </a>

                      <ul class="vertical-submenu">

                        @can('category.view')

                        <li

                          class="{{ Nav::isRoute('category.index') }} {{ Nav::isRoute('category.create') }} {{ Nav::isRoute('category.edit') }}">

                          <a href="{{url('admin/category')}}">{{ __('Categories') }}</a></li>

                        @endcan

                        @can('subcategory.view')

                        <li class="{{ Nav::isResource('subcategory') }}"><a href="{{url('admin/subcategory')}}">{{ __('Subcategories') }}</a></li>

                        @endcan

                        @can('childcategory.view')

                        <li class="{{ Nav::isResource('grandcategory') }}"><a href="{{url('admin/grandcategory')}}">{{ __('Childcategories') }}</a></li>

                        @endcan

                      </ul>

                    </li>

                    @can('products.view')

                    <li

                      class="{{ Nav::isRoute('pro.vars.all') }} {{ Nav::isResource('products') }} {{ Nav::isRoute('add.var') }} {{ Nav::isRoute('manage.stock') }} {{ Nav::isRoute('edit.var') }}">

                      <a href="{{url('admin/products')}} ">{{ __('Variant Products') }} </a></li>

                    @endcan

                    @can('products.view')

                      <li class="{{ Nav::isResource('simple-products') }}">

                        <a href="{{ route('simple-products.index') }} ">{{__("Simple Products")}}</a>

                      </li>

                    @endcan

                    @can('products.import')

                    <li class="{{ Nav::isRoute('import.page') }}"><a href="{{ route('import.page') }}">{{ __('Import Products') }}</a></li>

                    @endcan



                    @can('attributes.view')

                    <li

                      class="{{ Nav::isRoute('pro.val') }} {{ Nav::isRoute('opt.edit') }} {{ Nav::isRoute('attr.add') }}{{ Nav::isRoute('attr.index') }}">

                      <a href="{{route('attr.index')}} ">{{ __('Product Attributes') }}</a></li>

                    @endcan

                    @can('coupans.view')

                    <li class="{{ Nav::isResource('coupan') }}"><a href="{{url('admin/coupan')}} ">Coupons</a></li>

                    @endcan

                    @can('returnpolicy.view')

                    <li class="{{ Nav::isResource('admin/return-policy') }}"><a href="{{url('admin/return-policy')}} ">{{ __('Return Policy Settings') }}</a></li>

                    @endcan

                    @can('units.view')

                    <li class="{{ Nav::isResource('unit') }}"><a href="{{url('admin/unit') }}">{{ __('Units') }}</a></li>

                    @endcan

                    @can('specialoffer.view')

                    <li class="{{ Nav::isResource('special') }}"><a href="{{ url('admin/special') }}">{{ __('Special Offers') }}</a></li>

                    @endcan



                    @can('review.view')

                    <li class="{{ Nav::isRoute('review.index') }}"><a href="{{url('admin/review')}}">{{ __('All Reviews') }}</a></li>



                    <li class="{{ Nav::isRoute('r.ap') }}"><a href="{{url('admin/review_approval')}}">{{ __('Reviews For Approval') }}</a></li>

                    @endcan



                    @can('commission.manage')



                    @if($cms->type =='c')

                      <li class="{{ Nav::isResource('admin/commission') }}">

                        <a href="{{url('admin/commission')}}">

                          {{ __("Commissions") }}

                        </a>

                      </li>

                    @endif



                    <li class="{{ Nav::isResource('admin/commission_setting') }}"><a

                        href="{{url('admin/commission_setting')}} ">{{ __('Commission Setting') }}</a>

                    </li>



                    @endcan



                    @can('sizechart.manage')



                    <li class="{{ Nav::isResource('manage/sizechart') }}">

                      <a href="{{ route("sizechart.index") }}">{{__("Size chart")}}

                      </a>

                    </li>



                    @endcan



                  </ul>

                </li>

              @endcan



              @canany(['order.view','invoicesetting.view'])

                <li id="ordersm"

                  class="{{ Nav::isResource('admin/rma') }} {{ Nav::isRoute('admin.preorders') }} {{ Nav::isResource('admin.pending.orders') }} {{ Nav::isRoute('admin.can.order') }} {{ Nav::isRoute('return.order.show') }} {{ Nav::isRoute('return.order.detail') }} {{ Nav::isRoute('return.order.index') }} {{ Nav::isResource('order') }} {{ Nav::isResource('invoice') }}">



                  <a href="javaScript:void();">

                    <i class="feather icon-shopping-cart" aria-hidden="true"></i> <span>{{ __('Orders & Invoices') }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>



                  <ul class="vertical-submenu">



                    <li class="{{ Nav::isResource('order') }}"><a href="{{route('order.index')}} ">{{ __('All Orders') }}</a></li>

                    <li class="{{ Nav::isRoute('admin.preorders') }}"><a href="{{route('admin.preorders')}}"></i>{{__('Pre Orders')}} </a></li>

                    <li class="{{ Nav::isResource('admin.pending.orders') }}"><a href="{{route('admin.pending.orders')}}"></i>{{__('Pending Orders')}} </a></li>

                    <li class="{{ Nav::isRoute('admin.can.order') }}"><a href="{{route('admin.can.order')}}"></i>{{__('Canceled Orders')}} </a></li>



                    <li class="{{ Nav::isRoute('return.order.index') }} {{ Nav::isRoute('return.order.show') }} {{ Nav::isRoute('return.order.detail') }}">

                      <a href="{{route('return.order.index')}} ">{{ __('Returned Orders') }}</a></li>

                    @can('invoicesetting.view')

                    <li class="{{ Nav::isResource('invoice') }}"><a href="{{url('admin/invoice')}}">{{ __('Invoice Setting') }}</a></li>

                    @endcan



                    @can('invoicesetting.view')

                    <li class="{{ Nav::isRoute('get.invoice.design') }}"><a href="{{route('get.invoice.design')}}">{{ __('Invoice Design') }}</a></li>

                    @endcan



                    <li class="{{ Nav::isResource('admin/rma') }}"><a href="{{route('rma.index')}} ">{{ __('Return Reasons') }}</a>

                    </li>

                  </ul>

                </li>

              @endcan



              @canany(['order.view'])

                <li class="{{ Nav::isResource('offline-orders') }} {{ Nav::isRoute('offline.orders.reports') }}">



                  <a href="javaScript:void();">

                    <i class="feather icon-shopping-cart" aria-hidden="true"></i><span>{{ __("Inhouse orders") }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>



                  <ul class="vertical-submenu">



                    <li class="{{ Nav::isResource('offline-orders') }}">

                      <a href="{{route('offline-orders.index')}} ">

                        {{__('All Orders')}}

                      </a>

                    </li>



                    <li class="{{ Nav::isResource('offline-orders') }}">

                      <a href="{{route('offline-orders.create')}}"></i>

                        {{__('Create order')}}

                      </a>

                    </li>



                    <li class="{{ Nav::isRoute('offline.orders.reports') }}">

                      <a href="{{route('offline.orders.reports')}}"></i>

                        {{__('Reports')}}

                      </a>

                    </li>

                    

                  </ul>

                </li>

              @endcan





              @canany(['hotdeals.view','blockadvertisments.view','advertisements.view','testimonials.view','offerpopup.setting','pushnotification.settings'])

                <li class="{{ Nav::isResource('flash-sales') }} {{ Nav::isRoute('admin.push.noti.settings') }} {{ Nav::isRoute('offer.get.settings') }} {{ Nav::isResource('testimonial') }} {{ Nav::isResource('adv') }} {{ Nav::isResource('hotdeal') }} {{ Nav::isResource('detailadvertise') }}">

                  <a href="javaScript:void();">

                    <i class="feather icon-bar-chart-line-" aria-hidden="true"></i><span>{{ __('Marketing Tools') }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>



                  <ul class="vertical-submenu">

                    @can('hotdeals.view')

                    <li><a class="{{ Nav::isResource('admin/hotdeal') }}" href="{{url('admin/hotdeal')}}">{{ __('Hot Deals') }}</a></li>

                    @endcan

                    @can('blockadvertisments.view')

                    <li class="{{ Nav::isResource('admin/detailadvertise') }}"><a href="{{url('admin/detailadvertise')}}">{{ __('Block Advertisments') }}</a></li>

                    @endcan

                    @can('advertisements.view')

                    <li class="{{ Nav::isResource('admin/adv') }}"><a href="{{url('admin/adv')}}">{{ __('Advertisements') }}</a></li>

                    @endcan

                    @can('testimonials.view')

                    <li class="{{ Nav::isResource('admin/testimonial') }}"><a href="{{url('admin/testimonial')}} ">{{ __('Testimonials') }}</a></li>

                    @endcan

                    @can('offerpopup.setting')

                    <li class="{{ Nav::isRoute('offer.get.settings') }}"><a href="{{route('offer.get.settings')}} ">{{ __('Offer PopUp Settings') }}</a></li>

                    @endcan

                    @can('pushnotification.settings')

                    <li class="{{ Nav::isRoute('admin.push.noti.settings') }}"><a

                        href="{{route('admin.push.noti.settings')}}">{{ __('Push Notifications') }}</a></li>

                    @endcan



                    @can('hotdeals.view')

                    <li class="{{ Nav::isResource('flash-sales') }}"><a

                      href="{{route('flash-sales.index')}}">{{ __('Flash sales') }}</a></li>

                    @endcan



                  </ul>



                </li>

              @endcan





              @can('location.manage')

                <li id="location"

                  class="{{ Nav::isRoute('country.list.pincode') }} {{ Nav::isResource('country') }} {{ Nav::isRoute('admin.desti') }} {{ Nav::isRoute('country.index') }} {{ Nav::isRoute('state.index') }} {{ Nav::isRoute('city.index') }}">

                  <a href="javaScript:void();">

                    <i class="feather icon-globe" aria-hidden="true"></i> <span>{{ __('Locations') }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>





                  <ul class="vertical-submenu">

                    <li class="{{ Nav::isResource('country') }}"><a href="{{url('admin/country')}}">{{ __('Countries') }}</a></li>

                    <li class="{{ Nav::isResource('state') }}"><a href="{{url('admin/state')}}">{{ __('States') }}</a></li>

                    <li class="{{ Nav::isResource('city') }}"><a href="{{url('admin/city')}}">{{ __('Cities') }}</a></li>

                    <li class="{{ Nav::isRoute('country.list.pincode') }}{{ Nav::isRoute('admin.desti') }}"><a

                        href="{{url('admin/destination')}}">{{ __('Delivery Locations') }}</a></li>

                  </ul>







                </li>

              @endcan





              @canany(['shipping.manage','taxsystem.manage'])

                <li id="shippingtax" class="{{ Nav::isResource('admin/zone') }} {{ Nav::isResource('shipping') }}

                {{ Nav::isResource('tax') }}">

                  @can('shipping.manage')

                  <a href="javaScript:void();">

                    <i class="feather icon-truck" aria-hidden="true"></i><span>{{ __('Shipping & Taxes') }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>

                  @endcan

                  @can('taxsystem.manage')

                  <ul class="vertical-submenu">

                    <li class="{{ Nav::isResource('tax_class')  }}"><a href="{{url('admin/tax_class')}}">{{  __('Tax Classes') }}</a></li>

                    <li class="{{ Nav::isRoute('tax.index') }}{{ Nav::isRoute('tax.edit') }}{{ Nav::isRoute('tax.create') }}">

                      <a href="{{url('admin/tax')}}">{{ __('Tax Rates') }}</a></li>

                    <li class="{{ Nav::isResource('admin/zone') }}"><a href="{{url('admin/zone')}}">{{ __('Zones') }}</a></li>

                    <li class="{{ Nav::isResource('shipping') }}"><a href="{{url('admin/shipping')}}">{{ __('Shipping') }}</a></li>

                  </ul>

                  @endcan

                </li>

              @endcan





              @if($genrals_settings->vendor_enable == 1)



                @can('sellerpayout.manage')

                

                  <li

                    class="{{ Nav::isRoute('seller.payout.show.complete') }} {{ Nav::isRoute('seller.payouts.index') }} {{ Nav::isRoute('seller.payout.complete') }}">

                    <a href="javaScript:void();">

                      <i class="fa fa-slack" aria-hidden="true"></i><span>{{ __('Seller Payouts') }}</span>

                      <i class="feather icon-chevron-right"></i>

                    </a>

                    <ul class="vertical-submenu">



                      <li class="{{ Nav::isRoute('seller.payouts.index') }}"><a href="{{route('seller.payouts.index')}} ">{{ __('Pending Payouts') }}</a></li>



                      <li class="{{ Nav::isRoute('seller.payout.show.complete') }} {{ Nav::isRoute('seller.payout.complete') }}"><a href="{{ route('seller.payout.complete') }}">

                      {{__('Completed Payouts')}}

                      </a></li>



                    </ul>



                  </li>



                @endcan



              @endif







              @can('currency.manage')

                <li id="mscur" class="{{ Nav::isResource('admin/multiCurrency') }}"><a

                    href="{{url('admin/multiCurrency')}} "><i class="fa fa-money"></i><span>

                      {{__('Currency settings')}}  

                    </span></a>

                </li>

              @endcan





              @if(Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled())



                @include('sellersubscription::admin.menu')



              @endif





              @can('affiliatesystem.manage')

                <li id="slider"

                  class="{{ Nav::isRoute('admin.affilate.settings') }} {{ Nav::isRoute('admin.affilate.dashboard') }}">

                  <a href="javaScript:void();">

                    <i class="feather icon-award"></i><span>

                      {{__("Affiliate Manager")}}

                    </span>

                    <i class="feather icon-chevron-right"></i>



                    <small class="badge badge-success float-right">{{ __('NEW') }}</small>

                    </span>

                  </a>

                  <ul class="vertical-submenu">

                    <li class="{{ Nav::isRoute('admin.affilate.settings') }}">

                      <a href="{{route('admin.affilate.settings')}} ">

                        {{__("Affiliate Settings")}}

                      </a>

                    </li>

                    @if($aff_system->enable_affilate == 1)

                    <li class="{{ Nav::isRoute('admin.affilate.dashboard') }}">

                      <a href="{{route('admin.affilate.dashboard')}} ">

                        <span>{{__("Affiliate Reports")}}</span>

                      </a>

                    </li>

                    @endif

                  </ul>

                </li>

              @endcan



              @canany(['pages.view','blog.view','site-settings.style-settings','site-settings.footer-customize','site-settings.social-handle','pwa.setting.index','color-options.manage','faq.view','widget-settings.manage','payment-gateway.manage','manual-payment.view','sliders.manage'])

                <li

                  class="{{ Nav::isResource('page') }} {{ Nav::isResource('blog') }} {{ Nav::isResource('social') }} {{ Nav::isRoute('footer.index') }} {{ Nav::isRoute('customstyle') }} {{ Nav::isRoute('front.slider') }} {{ Nav::isResource('slider') }} {{ Nav::isRoute('payment.gateway.settings') }} {{ Nav::isRoute('manual.payment.gateway') }} {{ Nav::isRoute('widget.setting') }} {{ Nav::isResource('faq') }} {{ Nav::isRoute('admin.theme.index') }} {{ Nav::isRoute('pwa.setting.index') }}">

                  <a href="javaScript:void();">

                    <i class="feather icon-settings" aria-hidden="true"></i> <span>{{ __("Front Settings") }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>



                  <ul class="vertical-submenu">



                    @can('sliders.manage')

                    <li id="slider" class="treeview {{ Nav::isRoute('front.slider') }} {{ Nav::isResource('slider') }}">

                      <a href="#"><span>Sliders</span>

                        <i class="feather icon-chevron-right"></i>

                      </a>

                      <ul class="vertical-submenu">

                        <li class="{{ Nav::isResource('slider') }}"><a href="{{url('admin/slider')}} ">{{ __('Sliders') }}</a></li>

                        <li class="{{ Nav::isRoute('front.slider') }}">

                          <a href="{{route('front.slider')}} "><span>{{ __('Top Category Slider') }}</span></a>

                        </li>

                      </ul>

                    </li>

                    @endcan



                    @can('pwasettings.manage')

                    <li class="{{ Nav::isRoute('pwa.setting.index') }}"><a title="{{ __('Progressive Web App Setting') }}"

                        href="{{route('pwa.setting.index')}} "><span>{{ __('PWA Settings') }}</span></a>

                    </li>

                    @endcan



                    @can('color-options.manage')

                    <li id="theme-settings" class="{{ Nav::isRoute('admin.theme.index') }}">

                      <a href="{{ route('admin.theme.index') }}"><span>{{ __('Color Options') }}</span>

                      </a>

                    </li>

                    @endcan



                    @can('faq.view')

                    <li id="faqs" class="{{ Nav::isResource('faq') }}"><a href="{{url('admin/faq')}} "><span>{{ __('FAQ\'s') }}</span></a>

                    </li>

                    @endcan



                    @can('widget-settings.manage')



                    <li class="{{ Nav::isRoute('widget.setting') }}">



                      <a href="{{ route('widget.setting') }}"><span>{{ __('Widgets Settings') }}</span></span></a>



                    </li>



                    @endcan



                    @can('payment-gateway.manage')

                    <li class="{{ Nav::isRoute('payment.gateway.settings') }}">



                      <a href="{{ route('payment.gateway.settings') }}"><span>{{ __('Payment Gateway Settings') }}</span></a>



                    </li>

                    @endcan



                    @can('manual-payment.view')

                    <li class="{{ Nav::isRoute('manual.payment.gateway') }}">



                      <a href="{{ route('manual.payment.gateway') }}"><span>{{ __("Offline Payment Gateway") }}</span></a>



                    </li>

                    @endcan



                    @can('site-settings.style-settings')

                    <li class="{{ Nav::isRoute('customstyle') }}">

                      <a href="{{ route('customstyle') }}"><span>{{ __('Custom Style and JS') }}</span></a>

                    </li>

                    @endcan



                    @can('site-settings.footer-customize')

                    <li class="{{ Nav::isRoute('footer.index') }}"><a href="{{url('admin/footer')}} ">{{ __("Footer Customizations") }}</a></li>

                    @endcan



                    @can('site-settings.social-handle')

                    <li class="{{ Nav::isResource('social') }}"><a href="{{url('admin/social')}} ">{{ __('Social Handler Settings') }}</a></li>

                    @endcan



                    @can('blog.view')

                    <li class="{{ Nav::isResource('blog') }}"><a href="{{url('admin/blog')}}">{{ __('Blogs') }}</a></li>

                    @endcan



                    @can('pages.view')

                    <li class="{{ Nav::isResource('page') }}"><a href="{{url('admin/page')}}">{{ __('Pages') }}</a>

                    </li>

                    @endcan



                  </ul>

                </li>

              @endcan





              @canany(['terms-settings.update','others.abuse-word-manage','site-settings.bank-settings','site-settings.dashboard-settings','site-settings.footer-customize','site-settings.genral-settings','site-settings.genral-settings','site-settings.language','site-settings.mail-settings','site-settings.maintenance-mode','site-settings.sms-settings','site-settings.social-handle','site-settings.social-login-settings','site-settings.style-settings'])

              

                <li id="sitesetting" class="{{ Nav::isResource('admin/seo-directory') }} {{ Nav::isRoute('get.user.terms') }} {{ Nav::isRoute('sms.settings') }}

                  {{ Nav::isRoute('get.view.m.mode') }} {{ Nav::isRoute('site.lang') }}

                  {{ Nav::isResource('admin/abuse') }} {{ Nav::isResource('admin/bank_details') }}

                  {{ Nav::isRoute('genral.index') }} {{ Nav::isRoute('mail.getset') }} {{ Nav::isRoute('gen.set') }}

                  {{ Nav::isResource('page') }} {{ Nav::isRoute('seo.index') }} {{ Nav::isRoute('api.setApiView') }}

                  {{ Nav::isRoute('get.paytm.setting') }} {{ Nav::isResource('page') }} {{ Nav::isRoute('admin.dash') }} {{ Nav::isRoute('static.trans')  }}">

                  <a href="javaScript:void();">

                    <i class="feather icon-grid" aria-hidden="true"></i><span>{{ __('Site Settings') }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>

                  <ul class="vertical-submenu">



                    @can('site-settings.genral-settings')

                    <li class="{{ Nav::isRoute('genral.index') }}"><a href="{{url('admin/genral')}}">{{ __('General Settings') }}</a></li>

                    @endcan



                    @can('seo.manage')

                    <li class="{{ Nav::isRoute('seo.index') }}"><a href="{{url('admin/seo')}} ">SEO</a></li>

                    <li class="{{ Nav::isResource('admin/seo-directory') }}"><a href="{{route('seo-directory.index')}} ">{{ __('SEO directory') }}</a></li>

                    @endcan



                    @can('site-settings.language')

                    <li class="{{ Nav::isRoute('static.trans')  }} {{ Nav::isRoute('site.lang') }}"><a

                        href="{{route('site.lang')}}">{{ __('Site Languages') }}</a></li>

                    @endcan



                    @can('site-settings.mail-settings')

                    <li class="{{ Nav::isRoute('mail.getset') }}"><a href="{{url('admin/mail-settings')}}">{{ __('Mail Settings') }}</a></li>

                    @endcan



                    @can('site-settings.social-login-settings')

                    <li class="{{ Nav::isRoute('gen.set') }}"><a href="{{route('gen.set')}}">{{ __('Social Login Settings') }}</a></li>

                    @endcan



                    @can('site-settings.sms-settings')

                    <li class="{{ Nav::isRoute('sms.settings') }}"><a href="{{route('sms.settings')}}">{{ __('SMS Settings') }}</a></li>

                    @endcan



                    @can('site-settings.dashboard-settings')

                    <li class="{{ Nav::isRoute('admin.dash') }}">

                      <a href="{{ route('admin.dash') }}"><span>{{ __('Admin Dashboard Settings') }}</span></a>

                    </li>

                    @endcan



                    @can('site-settings.maintenance-mode')

                    <li class="{{ Nav::isRoute('get.view.m.mode') }}">

                      <a href="{{ route('get.view.m.mode') }}"><span>{{ __("Maintenance Mode") }}</span></a>

                    </li>

                    @endcan



                    @can('terms-settings.update')

                    <li id="sitesetting" class="{{ Nav::isRoute('get.user.terms') }}">

                      <a href="{{ route('get.user.terms') }}"><span>{{ __('Terms Pages') }}</span>

                      </a>

                    </li>

                    @endcan



                    @can('site-settings.bank-settings')

                    <li class="{{ Nav::isResource('admin/bank_details') }}"><a href="{{url('admin/bank_details')}} "></i><span>{{ __('Bank Details') }}</span></a></li>

                    @endcan





                    @can('others.abuse-word-manage')

                    <li class="{{ Nav::isResource('admin/abuse') }}">

                      <a href="{{ url('admin/abuse') }}"><span>{{ __('Abuse Word Settings') }}</span></a>

                    </li>

                    @endcan

                  </ul>

                </li>



              @endcan





              @can('wallet.manage')

                <li class="{{ Nav::isRoute('admin.wallet.settings') }}"><a href="{{ route('admin.wallet.settings') }}"><i class="feather icon-briefcase" aria-hidden="true"></i><span>{{ __('Wallet') }}</span></a></li>

              @endcan



              @can('mediamanager.manage')



                <li class="{{ Nav::isRoute('media.manager') }}"><a href="{{ route('media.manager') }}"><i class="feather icon-image" aria-hidden="true"></i><span>{{ __("Media Manager") }}</span></a></li>

              @endcan



              @can('chat.manage')

                <li id="ticket" class="{{ Nav::hasSegment(['chats','chat']) }}">

                  <a href="{{ route('admin.chat.list') }}">

                    <i class="feather icon-message-circle" aria-hidden="true"></i><span>{{ __("My Chats") }}</span></a>

                </li>

              @endcan



              @can('support-ticket.manage')



                <li id="ticket" class="{{ Nav::isRoute('tickets.admin') }} {{ Nav::isRoute('ticket.show') }}">

                  <a href="{{ route('tickets.admin') }}">

                    <i class="feather icon-volume-1" aria-hidden="true"></i><span>{{ __('Support Tickets') }}</span></a>

                </li>



              @endcan





              @can('reported-products.view')

                <li id="reppro" class="{{ Nav::isRoute('get.rep.pro') }}">

                  <a href="{{ route('get.rep.pro') }}">

                    <i class="feather icon-alert-circle" aria-hidden="true"></i><span>{{ __('Reported Products') }}</span></a>

                </li>

              @endcan



              @can('addon-manager.manage')

                <li class="{{ Nav::isRoute('addonmanger.index') }}"><a

                    href="{{route('addonmanger.index')}} "><i class="feather icon-download"></i><span>{{ __("Add-on Manager") }} <small class="badge badge-success float-right">{{ __('NEW') }}</small></span>

                  </a>

                </li>

              @endcan





              @can('reports.view')

                <li class="{{ Nav::isRoute('device.logs') }} {{ Nav::isRoute('admin.report.mostviewed') }} {{ Nav::isRoute('admin.stock.report') }} {{ Nav::isRoute('admin.sales.report') }}">

                  <a href="javaScript:void();">

                    <i class="fa fa-file-text-o"></i> <span>{{ __("Reports") }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>

                  <ul class="vertical-submenu">



                    <li class="{{ Nav::isRoute('admin.stock.report') }}">

                      <a href="{{ route('admin.stock.report') }}"><span>{{__("Stock report")}}</span>

                      </a>

                    </li>



                    <li class="{{ Nav::isRoute('admin.sales.report') }}">

                      <a href="{{ route('admin.sales.report') }}"><span>{{__("Sales report")}}</span>

                      </a>

                    </li>



                    <li class="{{ Nav::isRoute('admin.report.mostviewed') }}">

                      <a href="{{ route('admin.report.mostviewed') }}"><span>{{__("Most viewed products")}}</span>

                      </a>

                    </li>



                    <li class="{{ Nav::isRoute('device.logs') }}">

                      <a href="{{ route('device.logs') }}"><span>{{__("Login device history")}}</span>

                      </a>

                    </li>



                  </ul>

                </li>

              @endcan



              @canany(['others.importdemo','others.database-backup','others.systemstatus'])

                <li

                  class="{{ Nav::isRoute('others.settings') }} {{ Nav::isRoute('systemstatus') }} {{ Nav::isRoute('admin.import.demo') }} {{ Nav::isRoute('admin.backup.settings') }}">

                  <a href="javaScript:void();">

                    <i class="feather icon-help-circle" aria-hidden="true"></i><span>{{ __('Help & Support') }}</span>

                    <i class="feather icon-chevron-right"></i>

                  </a>

                  <ul class="vertical-submenu">



                    @can('others.importdemo')

                    <li class="{{ Nav::isRoute('admin.import.demo') }}">

                      <a href="{{ url('/admin/import-demo') }}"><span>{{ __('Import Demo') }}</span></a>

                    </li>

                    @endcan



                    @can('others.database-backup')

                    <li id="reppro" class="{{ Nav::isRoute('admin.backup.settings') }}">

                      <a href="{{ route('admin.backup.settings') }}"><span>{{ __('Database Backup') }}</span></a>

                    </li>

                    @endcan



                    @can('others.systemstatus')

                    <li class="{{ Nav::isRoute('systemstatus') }}">

                      <a href="{{ route('systemstatus') }}"><span>{{ __('System Status') }}</span>

                      </a>

                    </li>

                    @endcan



                    @if(auth()->user()->getRoleNames()->contains('Super Admin'))

                    <li class="{{ Nav::isRoute('others.settings') }}">

                      <a href="{{ route('others.settings') }}"><span>{{ __("Remove Public & Force HTTPS") }}</span>

                      </a>

                    </li>

                    @endif



                  </ul>

                </li>

              @endcan



              <li>

                <a href="{{ url('clear-cache') }}">

                  <i class="feather icon-zap"></i><span>{{ __('Clear Cache') }}</span>

                </a>

              </li>



            </ul>

          </div>







      </div>

    </div>

    <!-- End Navigationbar -->

  </div>

  <!-- End Sidebar -->

</div>