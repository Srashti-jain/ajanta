@extends("front.layout.master")
@section('title', "$product->product_name | ")
@section('meta_tags')
  <link rel="canonical" href="{{ url()->full() }}" />
  <meta name="robots" content="all">
  <meta property="og:title" content="{{ $product->product_name }}" />
  <meta name="keywords" content="{{ $product->tags ?? ''}}">
  <meta property="og:description"
    content="{{substr(strip_tags($product->product_detail), 0, 100)}}{{strlen(strip_tags( $product->product_detail))>100 ? '...' : ""}}" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url()->full() }}" />
  <meta property="og:image" content="{{ url('images/simple_products/'.$product->thumbnail) }}" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:description"
    content="{{substr(strip_tags($product->product_detail), 0, 100)}}{{strlen(strip_tags( $product->product_detail))>100 ? '...' : ""}}" />
  <meta name="twitter:site" content="{{ url()->full() }}" />
@endsection
@section('stylesheet')
  <!-- Drift Zoom CSS -->
  <link rel="stylesheet" href="{{ url('css/vendor/drift-basic.min.css') }}">
  <!-- Lightbox CSS -->
  <link rel="stylesheet" href="{{ url('css/lightbox.min.css') }}">
@endsection
@section("body")
<nav class="navbar navbar-dark display-none navbarBlue stickCartNav fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">

      <a class="navbar-brand" href="{{ url()->full() }}">
        <img src="{{ url('images/simple_products/'.$product->thumbnail) }}" width="30" height="30"
          class="d-inline-block"/>
        {{$product->product_name}}
      </a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    
    <div id="navbarSupportedContent">
      @if($product->pre_order == 1 && $product->product_avbl_date > date('Y-m-d h:i:s'))

        @if($product->preorder_type == 'partial')
          @php 
            $price   = $product->offer_price != 0 ? $product->offer_price : $product->price;
            $d_price = ($price * $product->partial_payment_per / 100);
          @endphp
        @endif

      @endif

      
      <form action="{{ $product->type == 'ex_product' ? $product->external_product_link : route('add.cart.simple',['pro_id' => $product->id, 'price' => $product->price, 'offerprice' => (isset($d_price)) ? $d_price : (($product->offer_price != 0 || $product->offer_price != '') ? $product->offer_price : 0)]) }}" method="{{$product->type == 'ex_product' ? 'GET' : 'POST'}}">

        @csrf

        <ul class="nav navbar-nav navbar-right">
        
            <li class="nav-item">
              <div class="quant-input">
                <input name="qty" type="number" value="{{ $product->min_order_qty }}" max="{{ $product->max_order_qty ?? "" }}" class="qty-section">
              </div>
            </li>

            <li class="nav-item active">
              <div id="cartForm">
                <div id="cartForm">

                  @if($product->pre_order == 1 && $product->product_avbl_date > date('Y-m-d h:i:s'))
                    <button type="submit" class="btn btn-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{ $product->type != 'ex_product' ? __("PRE-ORDER NOW") : 'Buy Now' }} <span class="sr-only">(current)</span></button>
                  @elseif($product->stock != 0)
                    <button type="submit" class="btn btn-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{$product->type != 'ex_product' ? __("staticwords.AddtoCart") : 'Buy Now' }} <span class="sr-only">(current)</span></button>
                  @else 
                    <button type="button" class="btn btn btn-cart-oos"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{ $product->type != 'ex_product' ? __("staticwords.Outofstock") : 'Buy Now' }} <span class="sr-only">(current)</span></button>
                  @endif
  
                </div>
              </div>
            </li>

          

          <li class="nav-item">
            <div class="favorite-button header-nav-smallscreen">

              <span class="favorite-button-box">

              </span>

            </div>
          </li>

          <li class="nav-item">
            <div class="favorite-button header-nav-smallscreen">
              <span class="favorite-button-one">
                <a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="{{ __('Add to Compare') }}"
                  href="{{ route('compare.product',$product->id) }}">
                  <i class="fa fa-signal"></i>
                </a>
              </span>
            </div>
          </li>

        </ul>

      </form>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="breadcrumb">
  <div class="container-fluid">
    <div class="breadcrumb-inner">
      <ul class="list-inline list-unstyled">
        <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
        <li><a href="{{ $product->category->getUrl() }}">{{ $product->category->title }}</a></li>
        <li><a href="{{ $product->subcategory->getUrl() }}">{{ $product->subcategory->title }}</a></li>
        @if(!empty($product->childcat->title))
        <li class='active'>
          <a href="{{ $product->childcat->getURL() }}">
            {{ $product->childcat->title }}
          </a>
        </li>
        @endif
      </ul>
    </div><!-- /.breadcrumb-inner -->
  </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-xs outer-top-xs-one detail-page-block">
  <div class='container-fluid'>
    <div class='row no-gutters single-product'>
      <div class='mb-5 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2 sidebar left-sidebar'>
        <div class="side-content">
          <div class="sidebar-module-container">

            @php
            $isad =
            App\DetailAds::where('position','=','prodetail')->where('linked_id',$product->id)->where('status','=','1')->first();
            @endphp
            @if(isset($isad))
            <div class="home-banner outer-top-n outer-bottom-xs">
              @if($isad->adsensecode != '')
              @php
              html_entity_decode($isad->adsensecode);
              @endphp
              @else
              @if($isad->show_btn == '1')
              <h3 class="buy-heading" style="color:{{ $isad->hcolor }}">{{ $isad->top_heading }}</h3>
              <h5 class="buy-sub-heading" style="color:{{ $isad->scolor }}">{{ $isad->sheading }}</h5>
              <center><a href="
                   @if($isad->linkby == 'category')
                      @php
                        App\Helpers\CategoryUrl::getURL($isad->cat_id);
                      @endphp
                   @elseif($isad->linkby == 'detail')
                      @php

                          if(isset($isad->pro_id->subvariants)){
                            App\Helpers\ProductUrl::getUrl($isad->pro_id->subvariants->first()->id);
                          }
                          
                      @endphp
                   @elseif($isad->linkby == 'url')
                    {{ $isad->url }}
                   @endif" style="color:{{ $isad->btn_txt_color }};background: {{ $isad->btn_bg_color }}"
                  class="btn buy-button">{{ $isad->btn_text }}</a></center>
              <img src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise" class="img-fluid">
              @elseif($isad->show_btn == 0 && $isad->top_heading != '')
              <a href="
                  @if($isad->linkby == 'category')
                      @php
                        App\Helpers\CategoryUrl::getURL($isad->cat_id);
                      @endphp
                  @elseif($isad->linkby == 'detail')
                        @php

                          if(isset($isad->pro_id->subvariants)){
                            App\Helpers\ProductUrl::getUrl($isad->pro_id->subvariants->first()->id);
                          }
                        
                        @endphp
                  @elseif($isad->linkby == 'url')
                    {{ $isad->url }}
                  @endif
                  ">
                <h3 class="buy-heading" style="color:{{ $isad->hcolor }}">{{ $isad->top_heading }}</h3>
                <h5 class="buy-sub-heading" style="color:{{ $isad->scolor }}">{{ $isad->sheading }}</h5>
                <img class="img-fluid" src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise">
              </a>
              @else
              <a href="
                  @if($isad->linkby == 'category')
                    @php
                       App\Helpers\CategoryUrl::getURL($isad->cat_id);
                    @endphp
                  @elseif($isad->linkby == 'detail')
                      @php

                        if(isset($isad->pro_id->subvariants)){
                          App\Helpers\ProductUrl::getUrl($isad->pro_id->subvariants->first()->id);
                        }
                        
                      @endphp
                  @elseif($isad->linkby == 'url')
                    {{ $isad->url }}
                  @endif
                  ">
                <img class="img-fluid" src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise">
              </a>
              @endif
              @endif
            </div>
            @endif
            <!-- ============================================== Testimonials: END ============================================== -->
            @if(count($hotdeals) && isset($enable_hotdeal) && $enable_hotdeal->shop == "1")

            <div class="mb-2 d-md-none d-sm-none d-lg-block sidebar-widget sidebar-widget-one hot-deals hot-deals-one outer-bottom-xs">
              <h3 class="section-title">{{ __('staticwords.Hotdeals') }}</h3>
              <div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-ss">

                @foreach($hotdeals as $deal)

                
                
                  <div class="item hot-deals-item">
                      <div class="products">
                        <div class="hot-deal-wrapper">
                          <div class="image">
                            <a href="{{ $deal['producturl'] }}" title="{{ $deal['productname'][session()->get('changed_language')] ?? $deal['productname'][config('translatable.fallback_locale')] }}">
                              
                              
                              <img class="owl-lazy"
                                data-src="{{ $deal['thumbnail'] }}"
                                alt="{{ $deal['productname'][session()->get('changed_language')] ?? $deal['productname'][config('translatable.fallback_locale')] }}">

                              <img class="owl-lazy hover-image"
                                src="{{ $deal['hover_thumbnail'] }}"
                                alt="{{ $deal['productname'][session()->get('changed_language')] ?? $deal['productname'][config('translatable.fallback_locale')] }}" />

                            </a>
                          </div>

                          @if($deal['offerprice'] != '0' || $deal['offerprice'] != '0,00')
                          
                          <div class="sale-offer-tag"><span><?php echo round($deal['off_percent']) . "%"; ?><br>
                              {{ __('off') }}</span>
                          </div>

                          @endif

                          <div class="countdown">
                            <div class="timing-wrapper" data-startat="{{ $deal['start_date'] }}"
                              data-countdown="{{ $deal['end_date'] }}">
                            </div>
                          </div>
                        </div>
                        <!-- /.hot-deal-wrapper -->

                        <div class="product-info text-left m-t-20">
                          <h3 class="name"><b><a href="{{ $deal['producturl'] }}"
                                title="{{ $deal['productname'][session()->get('changed_language')] ?? $deal['productname'][config('translatable.fallback_locale')] }}">
                                {{ $deal['productname'][session()->get('changed_language')] ?? $deal['productname'][config('translatable.fallback_locale')] }}</a></b></h3>
                         
                          @if($deal['rating'] != '0')
                          <div class="">
                            <div class="star-ratings-sprite"><span style="width:<?php echo $deal['rating']; ?>%"
                                class="star-ratings-sprite-rating"></span></div>
                          </div>

                          @else
                          <div class="text-center">
                            {{ __('No Rating') }}
                          </div>
                          @endif

                          <div class="product-price"> <span class="price">

                              @if($price_login == 0 || Auth::check())

                               
                             
                                @if($deal['offerprice'] != '0' || $deal['offerprice'] != '0,00')
                                <span class="price"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{ $deal['mainprice'] }}</span>
                                @else

                                <span class="price"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{ $deal['offerprice'] }}</span>

                                <span class="price-before-discount">
                                    <i class="{{session()->get('currency')['value']}}"></i>{{ $deal['mainprice'] }}
                                </span>


                                @endif

                              @endif
                          </div>

                          <!-- /.product-price -->

                        </div>
                        <!-- /.product-info -->

                        <div class="cart clearfix animate-effect">
                          <div class="action">
                            <ul class="list-unstyled">

                              @php

                                $in_session = 0;

                                if(!empty(Session::has('cart'))){
                                  foreach (Session::get('cart') as $scart) {
                                    if($deal['product_type'] == 'variant' && $deal['variantid'] == $scart['variantid']){
                                      $in_session = 1;
                                    }
                                  }
                                }

                              @endphp

                              @if($deal['start_date'] != '' || $deal['end_date'] <= date("Y-m-d h:i:s"))

                                @if($deal['in_cart'] == 0 && $deal['stock'] > 0)

                                  @if($price_login != 1)
                                  <form method="POST" action="{{ $deal['product_type'] == 'variant' ? route('add.cart', ['id' => $deal['productid'], 'variantid' => $deal['variantid'], 'varprice' => $deal['unformat_mainprice'], 'varofferprice' => $deal['unformat_offerprice'], 'qty' => $deal['min_order_qty']]) : route('add.cart.simple',['pro_id' => $deal['productid'], 'price' => $deal['unformat_mainprice'], 'offerprice' => $deal['unformat_offerprice'], 'qty' => $deal['min_order_qty']]) }}">
                                    @csrf
                                    <li class="add-cart-button btn-group">

                                      <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> 
                                          <i class="fa fa-shopping-cart"></i> 
                                      </button>

                                      <button class="btn btn-primary cart-btn" type="submit">
                                        {{__("Add to cart")}}
                                      </button>
                                    </li>
                                  </form>
                                  @endif

                                @else

                                  @if($deal['stock'] > 0)
                                    <li class="add-cart-button btn-group">

                                      <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i
                                          class="fa fa-check"></i> </button>
                                      <button onclick="window.location='{{ url('/cart') }}'"
                                        class="btn btn-primary cart-btn" type="button">Deal in Cart</button>

                                    </li>
                                  @endif

                                  @if($deal['stock'] == 0)

                                    <h5 class="required" align="center">
                                      {{ __('staticwords.Outofstock') }}
                                    </h5>

                                  @endif

                                @endif

                                @else
                                  <h5>
                                    {{ __('staticwords.ComingSoon') }}
                                  </h5>
                                @endif

                            </ul>
                          </div>
                          <!-- /.action -->
                        </div>



                      </div>
                  </div>
                @endforeach


              </div>
              <!-- /.sidebar-widget -->
            </div>

            @endif

          </div>

        </div>
      </div><!-- /.sidebar -->
      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12  col-xl-10 rht-col main-content'>

        <div class="detail-block">
          <!-- ====================== data sticky: start ============= -->
          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4 gallery-holder left-sidebar">
              <div class="product-item-holder size-big single-product-gallery small-gallery">

                <div class="data-sticky">

                  <div id="single-product-gallery-item">


                    @isset($product->productGallery)
                    <center>
                      <a class="lightboxmain" href="{{ url('images/simple_products/gallery/'.$product->productGallery[0]['image']) }}" data-lightbox="image-1" data-title="{{ $product->product_name }}">
                        
                        <img alt="miniproductimage"
                        src="{{ url('images/simple_products/gallery/'.$product->productGallery[0]['image']) }}" class="thumb_pro_img img img-fluid zoom-img drift-demo-trigger"
                        data-zoom="{{ url('images/simple_products/gallery/'.$product->productGallery[0]['image']) }}"/>

                      </a>
                    </center>
                    @endisset


                  </div>

                  <!-- /.single-product-gallery-item -->

                  <div class="mt-5 galleryContainer">
                    <div id="productgalleryItems"
                      class="owl-carousel product-galley-custom-em custom-carousel owl-theme">
                      @isset($product->productGallery)
                      @foreach($product->productGallery as $gallery)
                      <div class='provarbox'>

                          
                          <img onclick="changeImage2('{{ url('images/simple_products/gallery/'.$gallery->image) }}')"
                          alt='productimage' class="box-image"
                          src="{{ url('images/simple_products/gallery/'.$gallery->image) }}">
                         

                      </div>
                      @endforeach
                      @endisset
                    </div>
                  </div>

                  @if($product->stock == 0)
                    <div class="notifymeblock">
                      <form action="#" method="post">
                        @csrf
                        <button type="button" data-target="#notifyMe" data-toggle="modal"
                          class="text-white m-1 p-2 btn btn-md btn-block btn-primary">{{ __("NOTIFY ME") }}</button>
                      </form>
                    </div>
                  @endif
                </div>


                <!-- ======================= data sticky: END ========================== -->

              </div><!-- /.single-product-gallery -->



            </div><!-- /.gallery-holder -->

            <div class='col-sm-12 col-md-12 col-lg-12 col-xl-8 product-info-block main-content'>

              <div id="details-container"></div>

              <div class="product-info product-x">
                <div class="stock-container info-container">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="pull-left">
                        <div class="stock-box">
                          <span class="label">{{ __('staticwords.Availability') }} : 
                            @if($product->pre_order == 1 && $product->product_avbl_date > date('Y-m-d h:i:s'))
                              <span class="text-primary">
                                {{ __("Available for pre-order") }}
                              </span>
                            @else
                              <span class="{{ $product->stock == 0 ? "text-danger" : "text-green"}}">
                                {{ $product->stock == 0 ? __("Out of Stock") : __("In Stock") }}
                              </span>
                            @endif
                          </span>
                        </div>
                      </div>
                      <div class="pull-left">
                        <div class="stock-box">
                          <span class="text-success stockval value">

                          </span>
                        </div>
                      </div>
                      <br><br>
                      <h1 class="name">{{$product->product_name}} </h1>
                      <span class="productVars name-type"></span>
                      <div class="seller-info">{{ __('staticwords.by') }} <a
                          href="{{ route('store.view',['uuid' => $product->store->uuid ?? 0, 'title' => $product->store->name]) }}"
                          class="lnk">
                          {{ $product->store->name }} @if($product->store->verified_store) <i title="Verified"
                            class="text-green fa fa-check-circle"></i> @endif
                        </a>
                      </div>
                      <p></p>

                      <?php

                        $review_t = 0;
                        
                        $price_t = 0;

                        $value_t = 0;

                        $sub_total = 0;

                        $count = count($product->reviews);

                        $onlyrev = array();

                        foreach ($product->reviews->where('status','1') as $review) {
                            $review_t = $review->qty * 5;
                            $price_t = $review->price * 5;
                            $value_t = $review->value * 5;
                            $sub_total = $sub_total + $review_t + $price_t + $value_t;
                        }

                        $count = ($count * 3) * 5;

                        if ($count != "" && $count != 0) {
                          $rat = $sub_total / $count;

                          $ratings_var = ($rat * 100) / 5;

                          $overallrating = ($ratings_var / 2) / 10;
                        }

                        ?>

                      @php
                      $count = 0;
                      @endphp



                      @if(isset($overallrating) && $overallrating != 0)

                      @if(isset($ratings_var))
                      <div class="pull-left">
                        <div class="star-ratings-sprite">
                          <span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                        </div>
                      </div>
                      @endif

                      <div class="pull-left">
                        <div class="reviews-rating">
                          {{ round($overallrating,1)}} <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                      </div>

                      <div class="margin-left25">
                        <div class="reviews">
                          <a href="{{ route('allreviews',['id' => $product->id, 'type' => 's']) }}"
                            class="lnk">&nbsp;&nbsp;{{  $count =  count($product->reviews->where('status','1')) }}
                            {{ __('ratings and') }}
                            {{ $reviewcount }} {{ __('reviews') }}</a>
                        </div>
                      </div>

                      <p></p>
                      @else
                      <div class="pull-left">

                        <i class="color147ED2 fa fa-star-half-o" aria-hidden="true"></i>
                        {{ __('staticwords.ratetext') }}
                      </div>
                      <br>
                      <p></p>
                      @endif


                      <p><i class="color147ED2 fa fa-handshake-o" aria-hidden="true"></i> Trust of <b>
                          {{$product->brand->name}}</b>
                        @if($image = @file_get_contents('images/brands/'.$product->brand->image))
                        <img alt="brandlogo" class="pro-brand"
                          src="{{ url('/images/brands/'.$product->brand->image) }}">
                        @else
                        <img alt="brandlogo" class="pro-brand"
                          src="{{ Avatar::create($product->brand->name)->toBase64() }}">
                        @endif
                      </p>

                      @if($product->selling_start_at <= date("Y-m-d H:i:s")) @else <h3>{{ __('ComingSoon') }}</h3>

                      @endif

                    </div>
                    @if($product->stock != 0)
                    <div class="col-md-4 col-xs-12 col-sm-12">
                      <div id="qbc" class="quantity-block">
                        <div class="quantity-top">{{ __("To buy, Select") }}</div>
                        <div class="quantity-heading">{{ __("Quantity") }}</div>
                        <div class="qty-parent-cont">
                          <div class="quantity-container info-container">
                            <div>
                             
                              <div class="qty-count">
                                @if($product->pre_order == 1 && $product->product_avbl_date > date('Y-m-d h:i:s'))

                                  @if($product->preorder_type == 'partial')
                                    @php 
                                      $price   = $product->offer_price != 0 ? $product->offer_price : $product->price;
                                      $d_price = ($price * $product->partial_payment_per / 100);
                                    @endphp
                                  @endif

                                  <form action="{{ route('add.cart.simple',['pro_id' => $product->id, 'price' => $product->price, 'offerprice' => $d_price ?? $product->offer_price]) }}" method="POST">
                                    @csrf
                                    <div>
                                      <div class="cart-quantity">
                                        <div class="quant-input">
                                          <input type="number" value="1" name="qty" min="1" max="1" class="qty-section">
                                        </div>
                                      </div>
                                      <div class="add-btn">
                                        @if($product->type == 'ex_product')
                                          <a href="{{ $product->external_product_link }}" role="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{__("Buy Now")}} <span class="sr-only">(current)</span>
                                          </a>
                                        @else 
                                        <button type="submit" class="btn btn-primary">
                                          {{__("Pre-order now")}}
                                        </button>
                                        @endif
                                      </div>
                                    </div>
                                  </form>

                                @else

                                  <form action="{{ route('add.cart.simple',['pro_id' => $product->id, 'price' => $product->price, 'offerprice' => (isset($d_price)) ? $d_price : (($product->offer_price != 0 || $product->offer_price != '') ? $product->offer_price : 0)]) }}" method="POST">
                                    @csrf
                                    <div>
                                      <div class="cart-quantity">
                                        <div class="quant-input">
                                          <input type="number" value="1" name="qty" min="{{ $product->min_order_qty }}"
                                            max="{{ $product->max_order_qty != '' ? $product->max_order_qty : ''}}" maxorders="null" class="qty-section">
                                        </div>
                                      </div>
                                      <div class="add-btn">
                                        @if($product->type == 'ex_product')
                                          <a href="{{ $product->external_product_link }}" role="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{__("Buy Now")}} <span class="sr-only">(current)</span>
                                          </a>
                                        @else 
                                        <button type="submit" class="btn btn-primary">
                                          {{__("Add to Cart")}}
                                        </button>
                                        @endif
                                      </div>
                                    </div>
                                  </form>
                               
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif

                  </div><!-- /.row -->
                </div><!-- /.stock-container -->



                <div class="rating-reviews">


                  <div class="price-container info-container">
                    <div class="row">


                      <div class="col-sm-6 col-xs-12 col-md-8">
                        <div class="price-box price-box-border">
                          @if($product->pre_order == 1 && $product->product_avbl_date > date('Y-m-d h:i:s'))

                            <span class="price price-main dtl-price-main">
                              <i class="{{ session()->get('currency')['value'] }}"></i>
                              {{ $product->offer_price != 0 || $product->offer_price != '' ? price_format($product->offer_price * $conversion_rate) :  price_format($product->price * $conversion_rate)  }}
                            </span>

                            @if($product->offer_price != 0)
                              <span class="margin-top-15 font-size-20 price-strike price-strike-main dtl-price-strike-main">
                                <i class="{{ session()->get('currency')['value'] }}"></i> {{ price_format($product->price * $conversion_rate) }}
                              </span>
                            @endif

                            @if($product->preorder_type == 'partial')
                              
                              @php
                                  echo '<p class="text-primary"> (Pay '.$product->partial_payment_per.'% of product price now and rest amount pay when product is available).</p>';
                                  $price   = $product->offer_price != 0 ? $product->offer_price : $product->price;
                                  $d_price = ($price * $product->partial_payment_per / 100);
                                  $d_price = price_format($d_price * $conversion_rate);
                                  $print_price = '<i class="'.session()->get('currency')['value'].'"></i>';
                                  echo "<h4 class='text-info'>Pre order payable amount ";
                                  echo '<span class="">'.$print_price.$d_price.'</span></h4>';
                                  
                              @endphp

                           
                            @endif

                          @else

                          <span class="price price-main dtl-price-main">
                            <i class="{{ session()->get('currency')['value'] }}"></i>
                            {{ $product->offer_price != 0 || $product->offer_price != '' ? price_format($product->offer_price * $conversion_rate) :  price_format($product->price * $conversion_rate)  }}
                          </span>

                          @if($product->offer_price != 0)
                            <span class="margin-top-15 font-size-20 price-strike price-strike-main dtl-price-strike-main">
                              <i class="{{ session()->get('currency')['value'] }}"></i> {{ price_format($product->price * $conversion_rate) }}
                            </span>
                          @endif
                          
                          &nbsp;<i data-toggle="tooltip" data-placement="left"
                            title="{{ $product->tax == '' ? __('Taxes Not Included') : __('Taxes Included') }}"
                            class="color111 fa fa-info-circle"></i>

                            @if($product->offer_price != 0)
                            @php
                              
                              $getdisprice = ($product->price*$conversion_rate) - ($product->offer_price * $conversion_rate);
                              $gotdis = $getdisprice/($product->price * $conversion_rate);
                              $offamount = round($gotdis*100);

                            @endphp
                          
                           <span class="text-success font-size-18">
                            &nbsp;{{ $offamount }}% {{__("off")}}
                           </span>

                          @endif
                            

                          @endif

                         

                          
                        </div>

                        @if(isset($cashback_settings) && $cashback_settings->enable == 1)
                          <span class="shadow-sm rounded mb-2 p-1 border border-success text-green">
                            {{ __("Buy now and earn cashback in your wallet") }} {{ $cashback_settings->discount_type }}  @if($cashback_settings->cashback_type == 'fix') <i class="{{ session()->get('currency')['value'] }}"></i><b>{{ sprintf("%.2f", $cashback_settings->discount * $conversion_rate) }}</b> @else <b>{{ $cashback_settings->discount.'%' }}</b> @endif 
                          </span>
                        @endif

                          
                      </div>

                      <!-- close-->
                      <div class="mt-2 col-sm-6 col-xs-12 col-md-4">
                        <div class="favorite-button header-nav-screen">

                          <a class="btn btn-primary" data-toggle="modal" data-placement="right" title="Share"
                            data-target="#sharemodal">

                            <i class="text-white fa fa-share-alt" aria-hidden="true"></i>

                          </a>

                          <div class="modal fade" id="sharemodal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">

                                <div class="share-content modal-body">
                                  @php
                                  echo Share::Page(url()->full(),null,[],'<div class="row">', '</div>')
                                  ->facebook()
                                  ->twitter()
                                  ->telegram()
                                  ->whatsapp();
                                  @endphp
                                </div>

                              </div>
                            </div>
                          </div>
                          @if($product->type != 'ex_product')

                            <a class="{{ inwishlist($product->id) == true ? "bg-primary" : "" }} add_in_wish_simple btn btn-primary" data-proid="{{ $product->id }}" data-status="{{ inwishlist($product->id) }}" data-toggle="tooltip" data-placement="right"
                              title="  {{ inwishlist($product->id) == false ? __("staticwords.AddToWishList") :  __("staticwords.RemoveFromWishlist") }}" href="javascript:void(0)">
                              <i class="fa fa-heart"></i>
                            </a>

                          @php
                          $m=0;
                          @endphp

                          @if(!empty(Session::get('comparison')))

                          @foreach(Session::get('comparison') as $p)

                          @if($p['proid'] == $product->id)
                          @php
                          $m = 1;
                          break;
                          @endphp
                          @else
                          @php
                          $m = 0;
                          @endphp
                          @endif

                          @endforeach

                          @endif

                          @if($m == 0)
                          <a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add to Compare"
                            href="{{ route('compare.product',$product->id) }}">
                            <i class="fa fa-signal"></i>
                          </a>
                          @else
                          <a class="abg btn btn-primary" data-toggle="tooltip" data-placement="right"
                            title="Remove From Compare List" href="{{ route('remove.compare.product',$product->id) }}">
                            <i class="fa fa-signal"></i>
                          </a>
                          @endif

                          @if($product->catlog != '' && file_exists(public_path().'/productcatlog/'.$product->catlog))
                          <a class="abg btn btn-primary" data-toggle="tooltip" data-placement="right"
                            title="Download catlog"
                            href="{{ URL::temporarySignedRoute('download.catlog', now()->addMinutes(2), ['catlog' => $product->catlog]) }}">
                            <i class="fa fa-download"></i>
                          </a>
                          @endif

                          @endif

                        </div>
                      </div>

                    </div>


                  </div><!-- /.price-container -->

                  <div class="dc row">
                    @if($pincodesystem == 1)
                    <div class="col-lg-7 col-sm-6 col-xs-6 description-container">
                      <p></p>
                      <div class="delivery-location  description-heading">

                        <img alt="shoppingbag"
                          src="{{url('/images/shopping-bag.png')}}">{{ __('staticwords.deliverytext') }}


                      </div>


                      <form id="myForm" method="post">
                        {{csrf_field()}}
                        <div class="form-group">

                          <div class="input-group mb-3">
                            <input placeholder="{{ __('Enter Pincode') }}" required class="pincode-input form-control"
                              onchange="SubmitFormData()" type="text" id="deliveryPinCode" value="">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">
                                <i id="marker-map" class="fa fa-map-marker"></i>
                              </span>
                            </div>
                          </div>

                          <span id="pincodeResponce"></span>
                        </div>
                      </form>

                    </div>
                    @endif

                    <div class="col-sm-6 col-xs-6 d-block d-sm-none">
                      <b>{{ __('staticwords.Share') }}</b> : <div class="share-content"></div>
                    </div>
                    <div class="{{ $pincodesystem == 1 ? "col-md-5" : "col-md-8" }} description-container ">
                      <p></p>
                      <div class="description-heading">{{ __('staticwords.otherservices') }}</div>
                      <div class="price-container info-container">
                        <div class="delivery-detail text-center">
                          <div class="row">
                            @if($product->cod_avbl == 1)
                            <div class="col-lg-3 col-4">
                              <div class="image">
                                <img src="{{url('/images/icon-cod.png')}}" class="img-fluid" alt="img">
                              </div>
                              <div class="detail text-center">{{ __('staticwords.podtext') }}</div>
                            </div>
                            @endif
                            @if($product->return_avbl == 1)
                            <div class="col-lg-3 col-4">
                              <div data-toggle="modal" data-target="#returnmodal" class="image">
                                <img src="{{url('/images/icon-returns.png')}}" class="img-fluid" alt="img">
                              </div>
                              <div class="detail">{{ $product->returnPolicy->days }} {{ __('staticwords.returndays') }}
                              </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="returnmodal" tabindex="-1" role="dialog"
                              aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                    <h5 class="modal-title" id="myModalLabel">{{ $product->returnPolicy->name }}</h5>
                                  </div>
                                  <div class="modal-body">
                                    {!! $product->returnPolicy->des !!}
                                  </div>

                                </div>
                              </div>
                            </div>
                            @else
                            <div class="col-lg-3 col-4">
                              <div data-toggle="modal" data-target="#returnmodal" class="image">
                                <img src="{{url('/images/icon-returns.png')}}" class="img-fluid" alt="img">
                              </div>
                              <div class="detail">{{ __('staticwords.noreturn') }}</div>
                            </div>
                            @endif
                            @if($product->free_shipping == 1) 
                            <div class="col-lg-4 col-4">
                              <div class="image">
                                <img src="{{url('/images/icon-delivered.png')}}" class="img-fluid" alt="img">
                              </div>
                              <div class="detail">{{config('app.name')}} {{ __('staticwords.freedelivery') }}</div>
                            </div>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                  </div>


                  <!-- ============================ small-screen start ========================================= -->
                  <hr>
                  <!-- ============================ small-screen end ========================================= -->
                  
                  <div class="row">
                    @if(isset($product->key_features))
                    
                      <div class="col-md-6 description-container">
                        <div class="description-heading">{{ __('staticwords.Highlight') }}</div>
                        <div class="description-list">
                          {!! $product->key_features !!}
                        </div>
                        <div class="report-text"><a href="#reportproduct" data-toggle="modal" title="">
                            <img alt="commenticon"
                              src="{{url('/images/comment.png')}}">{{ __('staticwords.rprotext') }}.</a></div>
                      </div><!-- /.description-container -->

                      @if(isset($product->sizechart) && $product->size_chart != '' && $product->sizechart->status == 1)
                        <div class="col-md-6">
                          <h6 class="ml-3 float-right">
                            <a class="text-primary" data-toggle="modal" data-target="#previewModal" role="button">
                              <i class="fa fa-bar-chart"></i> {{__("View size chart")}}
                            </a>
                          </h6>
                        </div>
                      @endif

                    @endif
                  </div>

                </div><!-- /.product-info -->
              </div><!-- /.col-sm-7 -->

            </div><!-- /.row -->
          </div>
        </div>
        <!-- ============================================== full-screen tab start ============================================== -->
        <!-- ==============================================    ============================================== -->

        <div class="mt-2 product-feature">
          <div class="fast-delivery-block-block">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="fast-delivery-block">
                  <i class="fa fa-truck"></i>
                  <div class="delivery-heading">{{ __('staticwords.FastDelivery') }}</div>
                  <p>{{ __('staticwords.fastdtext') }}.</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="fast-delivery-block">
                  <i class="fa fa-cubes" aria-hidden="true"></i>
                  <div class="delivery-heading">{{ __('staticwords.QualityAssurance') }}</div>
                  <p>{{ __('staticwords.With') }} {{ config('app.name') }} {{ __('staticwords.qtext') }}.</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="fast-delivery-block">
                  <i class="fa fa-money"></i>
                  <div class="delivery-heading">{{ __('staticwords.PurchaseProtection') }}</div>
                  <p>{{ __('staticwords.PayementGatewaytext') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>



        <div id="product-tabs" class="mt-2 product-tabs display-none-block">

          <div class="row">
            <div class="col-lg-3 col-12">
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#prodesc" role="tab"
                  aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-list"></i>
                  {{ __('staticwords.Description') }}</a>

                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#prospec" role="tab"
                  aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-bars"></i>
                  {{ __('staticwords.prospecs') }}</a>

                @if($product->frames()->count())
                  <a class="nav-link" id="v-tab-pro-360" data-toggle="pill" href="#v-tab-pro-360-tour" role="tab"
                  aria-controls="v-tab-pro-360-tour" aria-selected="false"><i class="fa fa-repeat"></i>
                    {{ __('Product 360° Tour') }}
                  </a>
                @endif

                @if($product->type != 'ex_product')
                  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-tab-pro-reviews" role="tab"
                  aria-controls="v-tab-pro-reviews" aria-selected="false"><i class="fa fa-star"></i>
                  {{ __('staticwords.reviewratetext') }}</a>
                @endif

                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pro-comments" role="tab"
                  aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-comment"></i>
                  {{ count($product->comments) }} {{ __('staticwords.Comments') }}</a>

                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pro-faqs" role="tab"
                  aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-question-circle"></i>
                  {{ __('staticwords.faqs') }}</a>



              </div>
            </div>
            <div class="col-lg-9">
              <div class="tab-content" id="v-pills-tabContent">

                <div class="tab-pane fade show active" id="prodesc" role="tabpanel" aria-labelledby="v-pills-home-tab">

                  @if($product->product_detail != '')
                  {!! $product->product_detail !!}
                  @else
                  <h4>{{ __('No Description') }}</h4>
                  @endif
                  <hr>
                  <p><b>{{ __('Tags') }}:</b>
                    @php
                    $x = explode(',', $product->product_tags);
                    @endphp
                    @foreach($x as $tag)
                    <span class="badge badge-secondary"><i class="fa fa-tags"></i> {{ $tag }}</span>
                    @endforeach
                  </p>

                </div>

                <div class="tab-pane fade" id="prospec" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                  @if(count($product->specs)>0)

                  <div class="row">
                    @foreach($product->specs as $spec)

                    <div class="col-md-3 keycol">
                      <b>{{ $spec->prokeys }}</b>
                    </div>

                    <div class="col-md-9 keyval">
                      {{ $spec->provalues }}
                    </div>

                    @endforeach
                  </div>
                  @else
                  <h4>
                    {{ __('No Specifications') }}
                  </h4>
                  @endif

                </div>

                @if($product->frames()->count())
                  <div class="tab-pane fade" id="v-tab-pro-360-tour" role="tabpanel" aria-labelledby="v-tab-pro-360-tour">
                      <h5>
                        {{__("Move your mouse left or right to rotate the image")}}
                      </h5>

                      <div style="margin-left: -80px" id="produdct360tour">

                      </div>
                  </div>
                @endif

                @if($product->type != 'ex_product')
                  <div class="tab-pane fade" id="v-tab-pro-reviews" role="tabpanel"
                    aria-labelledby="v-pills-messages-tab">

                    @auth

                    @php
                      $purchased = App\Order::whereJsonContains('simple_pro_ids',$product->id)->where('user_id',Auth::user()->id)->first();

                      $findproinorder = 0;
                      $alreadyrated = $product->reviews->where('user',Auth::user()->id)->first();
                    @endphp

                   

                    @if($purchased)
                    @if(isset($alreadyrated))


                    <h5>
                      {{ __('Your Review') }}
                    </h5>
                    <hr>
                    <div class="row">

                      <div class="col-md-2">
                        @if($alreadyrated->users->image !='')
                        <img src="{{ url('/images/user/'.$alreadyrated->users->image) }}" alt=""
                          class="img-fluid rounded-circle">
                        @else
                        <img class="img-fluid rounded-circle"
                          src="{{ Avatar::create($alreadyrated->users->name)->toBase64() }}">
                        @endif
                      </div>

                      <div class="col-md-8">
                        <p>
                          <b><i>{{ $alreadyrated->users->name }}</i></b>
                          <small class="pull-right rating-date">On
                            {{ date('jS M Y',strtotime($alreadyrated->created_at)) }}
                            @if($alreadyrated->status == 1)
                            <span class="badge badge-success font-weight-bold"><i class="fa fa-check"
                                aria-hidden="true"></i> {{ __('Approved') }}</span>
                            @else
                            <span class="badge badge-success font-weight-bold"><i class="fa fa-info-circle"
                                aria-hidden="true"></i> {{ __('Pending') }}</span>
                            @endif
                          </small>
                          <br>

                          <?php
      
                                    $user_count = count([$alreadyrated]);
                                    $user_sub_total = 0;
                                    $user_review_t = $alreadyrated->price * 5;
                                    $user_price_t = $alreadyrated->price * 5;
                                    $user_value_t = $alreadyrated->value * 5;
                                    $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
      
                                    $user_count = ($user_count * 3) * 5;
                                    $rat1 = $user_sub_total / $user_count;
                                    $ratings_var1 = ($rat1 * 100) / 5;
      
                                    ?>
                          <div class="pull-left">
                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                class="star-ratings-sprite-rating"></span>
                            </div>
                          </div>
                          <br>
                          <span class="font-weight500">{{ $alreadyrated->review }}</span>
                        </p>
                      </div>

                    </div>

                    <hr>
                    <a title="{{ __("View all reviews") }}" class="font-weight-bold pull-right"
                      href="{{ route('allreviews',['id' => $product->id, 'type' => 's']) }}">{{ __('staticwords.vall') }}</a>
                    <h5 class="title">{{ __('staticwords.recReviews') }}</h5>

                    <hr>

                    <div class="row">

                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="overall-rating-main-block">
                          <div class="overall-rating-block text-center">
                            @php
                            if(!isset($overallrating)){
                            $overallrating = 0;
                            }
                            @endphp
                            <h1>{{ round($overallrating,1) }}</h1>
                            <div class="overall-rating-title">{{ __('staticwords.OverallRating') }}</div>
                            <div class="rating">
                              @php
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $sub_total = 0;
                              $reviews2 = App\UserReview::where('simple_pro_id', $product->id)->where('status',
                              '1')->get();
                              @endphp 
                              @if(!empty($reviews2[0]))
                              
                              @php

                                $count = App\UserReview::where('status', '1')->where('simple_pro_id',
                                $product->id)->count();

                                foreach ($reviews2 as $review) {
                                  $review_t = $review->price * 5;
                                  $price_t = $review->price * 5;
                                  $value_t = $review->value * 5;
                                  $sub_total = $sub_total + $review_t + $price_t + $value_t;
                                }

                                $count = ($count * 3) * 5;
                                $rat = $sub_total / $count;
                                $ratings_var2 = ($rat * 100) / 5;

                              @endphp


                              <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>


                              @else
                              <div class="text-center">
                                {{ __('No Rating') }}
                              </div>
                              @endif
                            </div>
                            <div class="total-review">{{$count =  count($product->reviews->where('status','1'))}}
                              {{ __('Ratings &') }}
                              {{$reviewcount}} {{ __('reviews') }}</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                              <label>{{ __('staticwords.Quality') }}</label>
                              <div class="stat-1 stat-bar">
                                <span class="stat-bar-rating" role="stat-bar"
                                  style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Price') }}</label>
                              <div class="stat-2 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar"
                                  style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Value') }}</label>
                              <div class="stat-3 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar"
                                  style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                              </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                          <div class="overall-rating-block satisfied-customer-block text-center">
                            <h3>100%</h3>
                            <div class="overall-rating-title">{{ __('staticwords.SatisfiedCustomer') }}</div>
                            <p>{{ __('staticwords.customerText') }}.</p>
                          </div>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-9">
                        <!-- All reviews will show here-->
                        @foreach($product->reviews->take(5) as $review)

                        @if($review->status == "1")
                        <div class="row">

                          <div class="col-md-2">
                            @if($review->users->image !='')
                            <img src="{{ url('/images/user/'.$review->users->image) }}" alt=""
                              class=" rounded-circle img-fluid">
                            @else
                            <img class="rounded-circle img-fluid"
                              src="{{ Avatar::create($review->users->name)->toBase64() }}">
                            @endif
                          </div>



                          <div class="col-md-10">
                            <p>
                              <b><i>{{ $review->users->name }}</i></b>
                              <?php
      
                                            $user_count = count([$review]);
                                            $user_sub_total = 0;
                                            $user_review_t = $review->price * 5;
                                            $user_price_t = $review->price * 5;
                                            $user_value_t = $review->value * 5;
                                            $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
      
                                            $user_count = ($user_count * 3) * 5;
                                            $rat1 = $user_sub_total / $user_count;
                                            $ratings_var1 = ($rat1 * 100) / 5;
      
                                            ?>
                              <div class="pull-left">
                                <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                    class="star-ratings-sprite-rating"></span>
                                </div>
                              </div>

                              <small class="pull-right rating-date">{{ __('On') }}
                                {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                              <br>
                              <span class="font-weight500">{{ $review->review }}</span>
                            </p>
                          </div>

                        </div>
                        <hr>
                        @endif

                        @endforeach


                        <!--end-->
                      </div>
                    </div>


                    @else
                    <h5>{{ __('staticwords.ratereviewPurchase') }}</h5>
                    <hr>
                    @php
                    if(!isset($overallrating)){
                    $overallrating = 0;
                    }
                    @endphp
                    <div class="row">
                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="overall-rating-main-block">
                          <div class="overall-rating-block text-center">
                            <h1>{{ round($overallrating,1) }}</h1>
                            <div class="overall-rating-title">{{ __('staticwords.OverallRating') }}</div>
                            <div class="rating">
                              @php
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $sub_total = 0;
                              $reviews2 = App\UserReview::where('simple_pro_id', $product->id)->where('status',
                              '1')->get();
                              @endphp @if(!empty($reviews2[0]))
                              @php
                              $count = App\UserReview::where('status', '1')->where('simple_pro_id',
                              $product->id)->count();
                              foreach ($reviews2 as $review) {
                              $review_t = $review->price * 5;
                              $price_t = $review->price * 5;
                              $value_t = $review->value * 5;
                              $sub_total = $sub_total + $review_t + $price_t + $value_t;
                              }
                              $count = ($count * 3) * 5;
                              $rat = $sub_total / $count;
                              $ratings_var2 = ($rat * 100) / 5;
                              @endphp


                              <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>


                              @else
                              <div class="text-center">
                                {{ __('No Rating') }}
                              </div>
                              @endif
                            </div>
                            <div class="total-review">{{$count =  count($product->reviews)}} Ratings & {{$reviewcount}}
                              reviews</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                              <label>{{ __('staticwords.Quality') }}</label>
                              <div class="stat-1 stat-bar">
                                <span class="stat-bar-rating" role="stat-bar"
                                  style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Price') }}</label>
                              <div class="stat-2 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar"
                                  style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Value') }}</label>
                              <div class="stat-3 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar"
                                  style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                              </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                          <div class="overall-rating-block satisfied-customer-block text-center">
                            <h3>100%</h3>
                            <div class="overall-rating-title">{{ __('staticwords.SatisfiedCustomer') }}</div>
                            <p>{{ __('staticwords.customerText') }}.</p>
                          </div>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-8 product-add-review">
                        <div class="review-table">
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th class="cell-label">&nbsp;</th>
                                  <th>1 star</th>
                                  <th>2 stars</th>
                                  <th>3 stars</th>
                                  <th>4 stars</th>
                                  <th>5 stars</th>
                                </tr>
                              </thead>
                              <form class="cnt-form" method="post"
                                action="{{ route("simpleproduct.rating",$product->id) }}">
                                @csrf
                                <input type="hidden" name="simple_product" value="simple_product">
                                <div class="required">{{$errors->first('quality')}}</div>
                                <div class="required">{{$errors->first('Price')}}</div>
                                <div class="required">{{$errors->first('Value')}}</div>
                                <tbody>
                                  <tr>
                                    <td class="cell-label">{{ __('staticwords.Quality') }} <span class="required">*</span>
                                    </td>
                                    <td><input type="radio" name="quality" class="radio" value="1"></td>
                                    <td><input type="radio" name="quality" class="radio" value="2"></td>
                                    <td><input type="radio" name="quality" class="radio" value="3"></td>
                                    <td><input type="radio" name="quality" class="radio" value="4"></td>
                                    <td><input type="radio" name="quality" class="radio" value="5"></td>
                                  </tr>
                                  <tr>
                                    <td class="cell-label">{{ __('staticwords.Price') }} <span class="required">*</span>
                                    </td>
                                    <td><input type="radio" name="Price" class="radio" value="1"></td>
                                    <td><input type="radio" name="Price" class="radio" value="2"></td>
                                    <td><input type="radio" name="Price" class="radio" value="3"></td>
                                    <td><input type="radio" name="Price" class="radio" value="4"></td>
                                    <td><input type="radio" name="Price" class="radio" value="5"></td>
                                  </tr>
                                  <tr>
                                    <td class="cell-label">{{ __('staticwords.Value') }} <span class="required">*</span>
                                    </td>
                                    <td><input type="radio" name="Value" class="radio" value="1"></td>
                                    <td><input type="radio" name="Value" class="radio" value="2"></td>
                                    <td><input type="radio" name="Value" class="radio" value="3"></td>
                                    <td><input type="radio" name="Value" class="radio" value="4"></td>
                                    <td><input type="radio" name="Value" class="radio" value="5"></td>
                                  </tr>
                                </tbody>
                            </table>
                            <!-- /.table .table-bordered -->
                          </div>
                          <!-- /.table-responsive -->
                        </div>
                        <!-- /.review-table -->
                        <div class="review-form">
                          <div class="form-container">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <input type="hidden" class="form-control txt" id="exampleInputName" name="name" value="
                                  @if(Auth::check()) {{auth()->user()->id}} @endif" placeholder="">
                                  <div class="text-red">{{$errors->first('name')}}</div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="margin-left15"
                                    for="exampleInputReview">{{ __('staticwords.Review') }}:</label>
                                  <textarea class="form-control text-rev" name="review" id="exampleInputReview" rows="5"
                                    cols="50" placeholder=""></textarea>
                                </div>
                              </div>
                            </div><!-- /.row -->
                            <div class="action text-right">
                              <button class="btn btn-primary btn-upper">{{ __('staticwords.SUBMITREVIEW') }}</button>
                            </div><!-- /.action -->
                            </form><!-- /.cnt-form -->
                          </div><!-- /.form-container -->
                        </div><!-- /.review-form -->
                      </div>
                    </div>
                    <!-- /.product-add-review -->
                    <h5>{{ __('staticwords.recReviews') }}</h5>

                    <hr>

                    @if($product->reviews()->where('status','1')->count())
                    @foreach($product->reviews->take(5) as $review)

                    @if($review->status == "1")
                    <div class="row">

                      <div class="col-md-1">
                        @if($review->users->image !='')
                        <img src="{{ url('/images/user/'.$review->users->image) }}" alt="" width="70px" height="70px"
                          class="rounded-circle">
                        @else
                        <img width="70px" height="70px" src="{{ Avatar::create($review->users->name)->toBase64() }}"
                          class="rounded-circle">
                        @endif
                      </div>

                      <div class="col-md-10">
                        <p>
                          <b><i>{{ $review->users->name }}</i></b>
                          <?php
      
                                            $user_count = count([$review]);
                                            $user_sub_total = 0;
                                            $user_review_t = $review->price * 5;
                                            $user_price_t = $review->price * 5;
                                            $user_value_t = $review->value * 5;
                                            $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
      
                                            $user_count = ($user_count * 3) * 5;
                                            $rat1 = $user_sub_total / $user_count;
                                            $ratings_var1 = ($rat1 * 100) / 5;
      
                                            ?>
                          <div class="pull-left">
                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                class="star-ratings-sprite-rating"></span>
                            </div>
                          </div>

                          <small class="pull-right rating-date">{{ __('On') }}
                            {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                          <br>
                          <span class="font-weight500">{{ $review->review }}</span>
                        </p>
                      </div>

                    </div>
                    <hr>
                    @endif

                    @endforeach
                    @else
                    <h5><i class="fa fa-star"></i> {{ __('staticwords.ratetext') }}</h5>
                    @endif

                    @endif
                    @else
                    <h5>{{ __('staticwords.purchaseProText') }}</h5>
                    <hr>
                    <h5>{{ __('staticwords.recReviews') }}</h5>
                    <hr>
                    @if(count($product->reviews)>0)

                    @if(!isset($overallrating))
                    @php
                    $overallrating = 0;
                    @endphp
                    @endif
                    <div class="row">

                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="overall-rating-main-block">
                          <div class="overall-rating-block text-center">
                            <h1>{{ round($overallrating,1) }}</h1>
                            <div class="overall-rating-title">{{ __('staticwords.OverallRating') }}</div>
                            <div class="rating">
                              @php
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $sub_total = 0;
                              $reviews2 = App\UserReview::where('status', '1')->where('simple_pro_id',
                              $product->id)->where('status', '1')->get();
                              @endphp @if(!empty($reviews2[0]))
                              @php
                              $count = App\UserReview::where('status', '1')->where('simple_pro_id',
                              $product->id)->count();
                              foreach ($reviews2 as $review) {
                              $review_t = $review->price * 5;
                              $price_t = $review->price * 5;
                              $value_t = $review->value * 5;
                              $sub_total = $sub_total + $review_t + $price_t + $value_t;
                              }
                              $count = ($count * 3) * 5;
                              $rat = $sub_total / $count;
                              $ratings_var2 = ($rat * 100) / 5;
                              @endphp


                              <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>


                              @else
                              <div class="text-center">
                                {{ __('No Rating') }}
                              </div>
                              @endif
                            </div>
                            <div class="total-review">{{$count =  count($product->reviews)}} Ratings & {{$reviewcount}}
                              {{ __('reviews') }}</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                              <label>{{ __('staticwords.Quality') }}</label>
                              <div class="stat-1 stat-bar">
                                <span class="stat-bar-rating" role="stat-bar"
                                  style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Price') }}</label>
                              <div class="stat-2 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar"
                                  style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Value') }}</label>
                              <div class="stat-3 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar"
                                  style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                              </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                          <div class="overall-rating-block satisfied-customer-block text-center">
                            <h3>100%</h3>
                            <div class="overall-rating-title">{{ __('staticwords.SatisfiedCustomer') }}</div>
                            <p>{{ __('staticwords.customerText') }}</p>
                          </div>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-9">
                        @foreach($product->reviews->take(5) as $review)

                        @if($review->status == "1")
                        <div class="row">

                          <div class="col-md-2">
                            @if($review->users->image !='')
                            <img src="{{ url('/images/user/'.$review->users->image) }}" alt=""
                              class=" rounded-circle img-fluid">
                            @else
                            <img class="rounded-circle img-fluid"
                              src="{{ Avatar::create($review->users->name)->toBase64() }}">
                            @endif
                          </div>

                          <div class="col-md-10">
                            <p>
                              <b><i>{{ $review->users->name }}</i></b>
                              <?php
      
                                        $user_count = count([$review]);
                                        $user_sub_total = 0;
                                        $user_review_t = $review->price * 5;
                                        $user_price_t = $review->price * 5;
                                        $user_value_t = $review->value * 5;
                                        $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
      
                                        $user_count = ($user_count * 3) * 5;
                                        $rat1 = $user_sub_total / $user_count;
                                        $ratings_var1 = ($rat1 * 100) / 5;
      
                                      ?>
                              <div class="pull-left">
                                <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                    class="star-ratings-sprite-rating"></span>
                                </div>
                              </div>

                              <small class="pull-right rating-date">{{ __('On') }}
                                {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                              <br>
                              <span class="font-weight500">{{ $review->review }}</span>
                            </p>
                          </div>

                        </div>
                        <hr>
                        @endif

                        @endforeach
                      </div>
                    </div>
                    @else
                    <h5><i class="fa fa-star"></i> {{ __('staticwords.ratetext') }}</h5>
                    @endif
                    @endif

                    @else
                    <h5>{{ __('staticwords.Please') }} <a href="{{ route('login') }}">{{ __('staticwords.Login') }}</a>
                      {{ __('staticwords.toratethisproduct') }}</h5>

                    @if(count($product->reviews)>0)
                    <hr>
                    <h5>{{ __('staticwords.recReviews') }}</h5>

                    <hr>
                    <div class="row">

                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="overall-rating-main-block">
                          <div class="overall-rating-block text-center">
                            <h1>{{ round($overallrating,1) }}</h1>
                            <div class="overall-rating-title">{{ __('staticwords.OverallRating') }}</div>
                            <div class="rating">
                              @php
                              $review_t = 0;
                              $price_t = 0;
                              $value_t = 0;
                              $sub_total = 0;
                              $sub_total = 0;
                              $reviews2 = App\UserReview::where('simple_pro_id', $product->id)->where('status',
                              '1')->get();
                              @endphp @if(!empty($reviews2[0]))
                              @php
                              $count = App\UserReview::where('status', '1')->where('simple_pro_id',
                              $product->id)->count();
                              foreach ($reviews2 as $review) {
                              $review_t = $review->price * 5;
                              $price_t = $review->price * 5;
                              $value_t = $review->value * 5;
                              $sub_total = $sub_total + $review_t + $price_t + $value_t;
                              }
                              $count = ($count * 3) * 5;
                              $rat = $sub_total / $count;
                              $ratings_var2 = ($rat * 100) / 5;
                              @endphp


                              <div class="star-ratings-sprite">
                                <span style="width:<?php echo $ratings_var; ?>%"
                                  class="star-ratings-sprite-rating"></span>
                              </div>


                              @else
                              <div class="text-center">
                                {{ __('No Rating') }}
                              </div>
                              @endif
                            </div>
                            <div class="total-review">{{$count =  count($product->reviews)}} Ratings & {{$reviewcount}}
                              reviews</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                              <label>{{ __('staticwords.Quality') }}</label>
                              <div class="stat-1 stat-bar">
                                <span class="stat-bar-rating" role="stat-bar"
                                  style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Price') }}</label>
                              <div class="stat-2 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar"
                                  style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                              </div>
                              <label>{{ __('staticwords.Value') }}</label>
                              <div class="stat-3 stat-bar">
                                <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar"
                                  style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                              </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                          <div class="overall-rating-block satisfied-customer-block text-center">
                            <h3>100%</h3>
                            <div class="overall-rating-title">{{ __('staticwords.SatisfiedCustomer') }}</div>
                            <p>{{ __('staticwords.customerText') }}</p>
                          </div>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-9">
                        @foreach($product->reviews->take(5) as $review)

                        @if($review->status == "1")
                        <div class="row">

                          <div class="col-md-2">
                            @if($review->users->image !='')
                            <img src="{{ url('/images/user/'.$review->users->image) }}" alt=""
                              class=" rounded-circle img-fluid">
                            @else
                            <img class="rounded-circle img-fluid"
                              src="{{ Avatar::create($review->users->name)->toBase64() }}">
                            @endif
                          </div>

                          <div class="col-md-10">
                            <p>
                              <b><i>{{ $review->users->name }}</i></b>
                              <?php
      
                                        $user_count = count([$review]);
                                        $user_sub_total = 0;
                                        $user_review_t = $review->price * 5;
                                        $user_price_t = $review->price * 5;
                                        $user_value_t = $review->value * 5;
                                        $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;
      
                                        $user_count = ($user_count * 3) * 5;
                                        $rat1 = $user_sub_total / $user_count;
                                        $ratings_var1 = ($rat1 * 100) / 5;
      
                                        ?>
                              <div class="pull-left">
                                <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%"
                                    class="star-ratings-sprite-rating"></span>
                                </div>
                              </div>

                              <small class="pull-right rating-date">{{ __('On') }}
                                {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                              <br>
                              <span class="font-weight500">{{ $review->review }}</span>
                            </p>
                          </div>

                        </div>
                        <hr>
                        @endif

                        @endforeach
                      </div>
                    </div>
                    @endif
                    @endauth

                  </div>
                @endif

                <div class="tab-pane fade" id="v-pro-comments" role="tabpanel" aria-labelledby="v-pro-comments-tab">
                  <h3><i class="fa fa-comments-o"></i> {{ __('staticwords.RecentComments') }}</h3>
                  <hr>
                  @forelse($product->comments->sortByDesc('id')->take(5) as $key=> $comment)

                  <div class="mt-2 media border border-default p-2">
                    <img src="{{ Avatar::create($comment->name)->toGravatar() }}" class="align-self-center mr-3"
                      alt="{{ $comment->name }}">
                    <div class="media-body">
                      <small class="float-right">{{ $comment->created_at->diffForHumans() }}</small>
                      <h5 class="mt-0">{{ $comment->name }}</h5>
                      <p class="mb-0">
                        {!! $comment->comment !!}
                      </p>
                    </div>
                  </div>

                  <div class="appendComment">

                  </div>

                  @empty

                  <h4><i class="fa fa-trophy"></i> {{ __("staticwords.NoCommentProduct") }}</h4>

                  @endforelse

                  @if(count($product->comments) > 5)

                  <p></p>
                  <div class="remove-row">
                    <button data-simpleproduct="yes" data-proid="{{ $product->id }}" data-id="{{ $comment->id }}"
                      class="btn-more btn btn-info btn-sm">{{ __('staticwords.LoadMore') }}</button>
                  </div>
                  <p></p>

                  @endif
                  <hr>
                  <h5 class="card-title">{{ __('staticwords.LeaveAComment') }}</h5>

                  <form action="{{ route('post.comment') }}" method="POST" novalidate class="needs-validation">
                    @csrf



                    <div class="form-group">
                      <label>{{ __('staticwords.Name') }}: <span class="text-red">*</span></label>
                      <input value="{{ old('name') }}" required autofocus name="name" type="text" class="form-control"">
                          <span class=" text-red">{{$errors->first('name')}}</span>
                    </div>

                    <div class="form-group">

                      <label>{{ __("staticwords.eaddress") }}: <span class="text-red">*</span></label>
                      <input value="{{ old('email') }}" required name="email" type="email" class="form-control"
                        aria-describedby="emailHelp">
                      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                        else.</small>
                      <input type="hidden" name="id" value="{{$product->id}}">
                      <span class="text-red">{{$errors->first('email')}}</span>
                    </div>



                    <div class="form-group">
                      <label>{{ __('staticwords.Comment') }}: <span class="text-red">*</span></label>
                      <textarea name="comment" required placeholder="{{ __('staticwords.Comment') }}"
                        class="form-control" rows="3" cols="30">{{ old('comment') }}</textarea>
                      <span class="text-red">{{$errors->first('comment')}}</span>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('staticwords.Submit') }}</button>
                  </form>



                </div>

                <div class="tab-pane fade" id="v-pro-faqs" role="tabpanel" aria-labelledby="v-pro-comments-tab">

                  @forelse($product->faq as $qid => $fq)
                    <h5>[Q.{{ $qid+1 }}] {{ $fq->question }}</h5>
                    <p class="h6">{!! $fq->answer !!}</p>
                    <hr>
                  @empty

                  <h4>{{ __('staticwords.NOFAQ') }}</h4>

                  @endforelse

                </div>
              </div>
            </div>
          </div>



        </div>


        <!-- ======================== ====================== small-screen tab end ============================================== -->
        <!-- ==============================================    ============================================== -->
        <!-- ============================================== UPSELL PRODUCTS ============================================== -->
        @if(isset($product->relsetting))
        <div class="mt-2 card">


          <div class="card-header bg-white">
            <h5 class="card-title">{{ __('staticwords.RelatedProducts') }}</h5>
          </div>

          <div class="card-body">
            <section class="section-random section new-arriavls related-products-block">
              <div
                class="owl-responsive owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs owl-loaded owl-drag">
                @if($product->relsetting->status == '1')



                <!-- product show manually -->
                @if(isset($product->relproduct))
                @foreach($product->relproduct->related_pro as $relpro)
                @php
                $relproduct = App\Product::find($relpro);
                @endphp

                @if(isset($relproduct))
                @foreach($relproduct->subvariants as $orivar)

                @if($orivar->def == '1')

                @php
                $var_name_count = count($orivar['main_attr_id']);

                $name = array();
                $var_name;
                $newarr = array();
                for($i = 0; $i<$var_name_count; $i++){ $var_id=$orivar['main_attr_id'][$i];
                  $var_name[$i]=$orivar['main_attr_value'][$var_id];
                  $name[$i]=App\ProductAttributes::where('id',$var_id)->first();

                  }


                  try{
                  $url =
                  url('details').'/'.$relproduct->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                  }catch(Exception $e)
                  {
                  $url = url('details').'/'.$relproduct->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                  }
                  @endphp

                  <div class="item item-carousel">
                    <div class="products">
                      <div class="product">

                        <div class="product-image">
                          <div class="image {{ $orivar->stock ==0 ? "pro-img-box" : ""}}">

                            <a href="{{$url}}" title="{{$relproduct->name}}">

                              @if(count($relproduct->subvariants)>0)

                              @if(isset($orivar->variantimages['image2']))
                              <img class="owl-lazy ankit {{ $orivar->stock ==0 ? "filterdimage" : ""}}"
                                data-src="{{url('/variantimages/thumbnails/'.$orivar->variantimages['main_image'])}}"
                                alt="{{$relproduct->name}}">
                              <img class="owl-lazy {{ $orivar->stock ==0 ? "filterdimage" : ""}} hover-image"
                                data-src="{{url('/variantimages/hoverthumbnail/'.$orivar->variantimages['image2'])}}"
                                alt="" />
                              @endif

                              @else
                              <img class="owl-lazy {{ $orivar->stock ==0 ? "filterdimage" : ""}}"
                                title="{{ $relproduct->name }}" data-src="{{url('/images/no-image.png')}}"
                                alt="No Image" />

                              @endif


                            </a>
                          </div>

                          @if($orivar->stock == 0)
                          <h5 align="center" class="oottext">Out of stock</h5>
                          @endif

                          @if($orivar->stock != 0 && $orivar->products->selling_start_at != null &&
                          $orivar->products->selling_start_at >= date('Y-m-d H:i:s'))
                          <h5 align="center" class="oottext2">Coming Soon !</h5>
                          @endif
                          <!-- /.image -->

                          @if($relproduct->featured=="1")
                          <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                          @elseif($product->offer_price=="1")
                          <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                          @else
                          <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                          @endif
                        </div>
                        <!-- /.product-image -->

                        <div class="product-info text-center text-lg-left">
                          <h3 class="name"><a href="{{ $url }}"
                              title="{{$orivar->products->name}}">{{substr($relproduct->name, 0, 20)}}{{strlen($relproduct->name)>20 ? '...' : ""}}</a>
                          </h3>
                          @php
                          $reviews = ProductRating::getReview($relpro);
                          @endphp

                          @if($reviews != 0)


                          <div class="pull-left">
                            <div class="star-ratings-sprite"><span style="width:<?php echo $reviews; ?>%"
                                class="star-ratings-sprite-rating"></span></div>
                          </div>


                          @else
                          <div class="no-rating">{{'No Rating'}}</div>
                          @endif
                          <div class="description"></div>
                          <div class="product-price"> <span class="price">

                              @if($price_login == '0' || Auth::check())

                              @php

                              $result = ProductPrice::getprice($relproduct, $orivar)->getData();

                              @endphp


                              @if($result->offerprice == 0)
                              <span class="price"><i class="{{session()->get('currency')['value']}}"></i>
                                {{ sprintf("%.2f",$result->mainprice*$conversion_rate) }}</span>
                              @else

                              <span class="price"><i
                                  class="{{session()->get('currency')['value']}}"></i>{{ sprintf("%.2f",$result->offerprice*$conversion_rate) }}</span>

                              <span class="price-before-discount"><i
                                  class="{{session()->get('currency')['value']}}"></i>{{  sprintf("%.2f",$result->mainprice*$conversion_rate)  }}</span>

                              @endif

                              @endif
                          </div>
                          <!-- /.product-price -->
                        </div>
                        <!-- /.product-info -->
                        @if($orivar->products->selling_start_at != null && $orivar->products->selling_start_at >=
                        date('Y-m-d H:i:s'))
                        @elseif($orivar->stock == 0)
                        @else
                        <div class="cart clearfix animate-effect">
                          <div class="action">
                            <ul class="list-unstyled">
                              <li id="addCart" class="lnk wishlist">

                                <form method="POST"
                                  action="{{route('add.cart',['id' => $product->id ,'variantid' =>$orivar->id, 'varprice' => $result->mainprice, 'varofferprice' => $result->offerprice ,'qty' =>$orivar->min_order_qty])}}">
                                  {{ csrf_field() }}
                                  <button title="{{ __('Add to Cart') }}" type="submit" class="addtocartcus btn">
                                    <i class="fa fa-shopping-cart"></i>
                                  </button>
                                </form>


                              </li>

                              @auth
                              @if(Auth::user()->wishlist->count()<1) <li class="lnk wishlist">

                                <a mainid="{{ $orivar->id }}" title="{{ __('Add to wishlist') }}"
                                  class="add-to-cart addtowish cursor-pointer"
                                  data-add="{{url('AddToWishList/'.$orivar->id)}}" title="{{ __('Add to wishlist') }}">
                                  <i class="icon fa fa-heart"></i>
                                </a>

                                </li>
                                @else

                                @php
                                $ifinwishlist =
                                App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$orivar->id)->first();
                                @endphp

                                @if(!empty($ifinwishlist))
                                <li class="lnk wishlist active">
                                  <a mainid="{{ $orivar->id }}" title="{{ __('Remove From wishlist') }}"
                                    class="color000 cursor-pointer add-to-cart removeFrmWish active"
                                    data-remove="{{url('removeWishList/'.$orivar->id)}}" title="Wishlist"> <i
                                      class="icon fa fa-heart"></i> </a>
                                </li>
                                @else
                                <li class="lnk wishlist"> <a title="Add to wish list" mainid="{{ $orivar->id }}"
                                    class="add-to-cart addtowish cursor-pointer text-white"
                                    data-add="{{url('AddToWishList/'.$orivar->id)}}" title="Wishlist"> <i
                                      class="activeOne icon fa fa-heart"></i> </a></li>
                                @endif

                                @endif
                                @endauth

                                <li class="lnk"> <a class="add-to-cart"
                                    href="{{route('compare.product',$orivar->products->id)}}" title="Compare"> <i
                                      class="fa fa-signal" aria-hidden="true"></i> </a> </li>

                                <li class="lnk"> <a class="add-to-cart" title="Download catlog"> <i
                                      class="fa fa-download" aria-hidden="true"></i> </a> </li>

                            </ul>
                          </div>
                          <!-- /.action -->
                        </div>
                        @endif
                        <!-- /.cart -->
                      </div>

                      <!-- /.product -->

                    </div>
                    <!-- /.products -->
                  </div>

                  @endif

                  @endforeach
                  @endif

                  @endforeach
                  @endif

                  @else

                  @foreach($product->subcategory->products as $relpro)
                  @if(isset($product->subcategory->products))
                  @foreach($relpro->subvariants as $orivar)

                  @if($orivar->def == '1' && $product->id != $orivar->products->id)

                  @php
                  $var_name_count = count($orivar['main_attr_id']);

                  $name = array();
                  $var_name;
                  $newarr = array();
                  for($i = 0; $i<$var_name_count; $i++){ $var_id=$orivar['main_attr_id'][$i];
                    $var_name[$i]=$orivar['main_attr_value'][$var_id];
                    $name[$i]=App\ProductAttributes::where('id',$var_id)->first();

                    }


                    try{
                    $url =
                    url('details').'/'.$relpro->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                    }catch(\Exception $e)
                    {
                    $url = url('details').'/'.$relpro->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                    }
                    @endphp

                    <div class="item item-carousel">
                      <div class="products">
                        <div class="product">

                          <div class="product-image">
                            <div class="image {{ $orivar->stock ==0 ? "pro-img-box" : ""}}">

                              <a href="{{$url}}" title="{{$product->name}}">

                                @if(count($product->subvariants))

                                @if(isset($orivar->variantimages['image2']))
                                <img class="owl-lazy ankit {{ $orivar->stock ==0 ? "filterdimage" : ""}}"
                                  data-src="{{url('/variantimages/thumbnails/'.$orivar->variantimages['main_image'])}}"
                                  alt="{{$product->name}}">
                                <img class="owl-lazy {{ $orivar->stock ==0 ? "filterdimage" : ""}} hover-image"
                                  data-src="{{url('/variantimages/hoverthumbnail/'.$orivar->variantimages['image2'])}}"
                                  alt="" />
                                @endif

                                @else
                                <img class="owl-lazy {{ $orivar->stock ==0 ? "filterdimage" : ""}}"
                                  title="{{ $product->name }}" data-src="{{url('/images/no-image.png')}}"
                                  alt="No Image" />

                                @endif



                              </a>
                            </div>

                            @if($orivar->stock == 0)
                            <h5 align="center" class="oottext">
                              {{ __('staticwords.Outofstock') }}
                            </h5>
                            @endif

                            @if($orivar->stock != 0 && $orivar->products->selling_start_at != null &&
                            $orivar->products->selling_start_at >= date('Y-m-d H:i:s'))
                            <h5 align="center" class="oottext2">
                              {{ __('staticwords.ComingSoon') }}
                            </h5>
                            @endif
                            <!-- /.image -->

                            @if($product->featured=="1")
                            <div class="tag hot"><span>
                                {{ __('staticwords.Hot') }}
                              </span></div>
                            @elseif($product->offer_price=="1")
                            <div class="tag sale"><span>
                                {{ __('staticwords.Sale') }}
                              </span></div>
                            @else
                            <div class="tag new"><span>
                                {{ __('staticwords.New') }}
                              </span></div>
                            @endif
                          </div>
                          <!-- /.product-image -->

                          <div class="product-info text-center text-lg-left">
                            <h3 class="name"><a href="{{ $url }}"
                                title="{{$relpro->name}}">{{substr($relpro->name, 0, 20)}}{{strlen($relpro->name)>20 ? '...' : ""}}</a>
                            </h3>
                            @php
                            $reviews = ProductRating::getReview($relpro);
                            @endphp

                            @if($reviews != 0)


                            <div class="pull-left">
                              <div class="star-ratings-sprite"><span style="width:<?php echo $reviews; ?>%"
                                  class="star-ratings-sprite-rating"></span></div>
                            </div>


                            @else
                            <div class="no-rating">{{'No Rating'}}</div>
                            @endif
                            <div class="description"></div>
                            <div class="product-price"> <span class="price">

                                @if($price_login == '0' || Auth::check())

                                @php

                                $result = ProductPrice::getprice($relpro, $orivar)->getData();

                                @endphp


                                @if($result->offerprice == 0)
                                <span class="price"><i class="{{session()->get('currency')['value']}}"></i>
                                  {{ sprintf("%.2f",$result->mainprice*$conversion_rate) }}</span>
                                @else

                                <span class="price"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{ sprintf("%.2f",$result->offerprice*$conversion_rate) }}</span>

                                <span class="price-before-discount"><i
                                    class="{{session()->get('currency')['value']}}"></i>{{  sprintf("%.2f",$result->mainprice*$conversion_rate)  }}</span>

                                @endif

                                @endif
                            </div>
                            <!-- /.product-price -->
                          </div>
                          <!-- /.product-info -->
                          @if($orivar->products->selling_start_at != null && $orivar->products->selling_start_at >=
                          date('Y-m-d H:i:s'))
                          @elseif($orivar->stock == 0)
                          @else
                          <div class="cart clearfix animate-effect">
                            <div class="action">
                              <ul class="list-unstyled">
                                <li id="addCart" class="lnk wishlist">

                                  @if($price_login != 1)
                                  <form method="POST"
                                    action="{{route('add.cart',['id' => $product->id ,'variantid' =>$orivar->id, 'varprice' => $result->mainprice, 'varofferprice' => $result->offerprice ,'qty' =>$orivar->min_order_qty])}}">
                                    {{ csrf_field() }}
                                    <button title="{{ __('Add to Cart') }}" type="submit" class="addtocartcus btn">
                                      <i class="fa fa-shopping-cart"></i>
                                    </button>
                                  </form>
                                  @endif


                                </li>

                                @auth
                                @if(Auth::user()->wishlist->count()<1) <li class="lnk wishlist">

                                  <a mainid="{{ $orivar->id }}" title="Add to wishlist"
                                    class="cursor-pointer add-to-cart addtowish"
                                    data-add="{{url('AddToWishList/'.$orivar->id)}}"
                                    title="{{ __('Add to wishlist') }}"> <i class="icon fa fa-heart"></i>
                                  </a>

                                  </li>
                                  @else

                                  @php
                                  $ifinwishlist =
                                  App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$orivar->id)->first();
                                  @endphp

                                  @if(!empty($ifinwishlist))
                                  <li class="lnk wishlist active">
                                    <a mainid="{{ $orivar->id }}" title="{{ __('Remove From wishlist') }}"
                                      class="color000 cursor-pointer add-to-cart removeFrmWish active"
                                      data-remove="{{url('removeWishList/'.$orivar->id)}}" title="Wishlist"> <i
                                        class="icon fa fa-heart"></i> </a>
                                  </li>
                                  @else
                                  <li class="lnk wishlist"> <a title="{{ __('Add to wish list') }}"
                                      mainid="{{ $orivar->id }}" class="add-to-cart addtowish text-white cursor-pointer"
                                      data-add="{{url('AddToWishList/'.$orivar->id)}}" title="Wishlist"> <i
                                        class="activeOne icon fa fa-heart"></i> </a></li>
                                  @endif

                                  @endif
                                  @endauth

                                  <li class="lnk"> <a class="add-to-cart"
                                      href="{{route('compare.product',$relpro->id)}}" title="{{ __('Compare') }}"> <i
                                        class="fa fa-signal" aria-hidden="true"></i> </a> </li>
                              </ul>
                            </div>
                            <!-- /.action -->
                          </div>
                          @endif
                          <!-- /.cart -->
                        </div>

                        <!-- /.product -->

                      </div>
                      <!-- /.products -->
                    </div>

                    @endif

                    @endforeach
                    @endif
                    @endforeach
                    @endif
              </div>
              <!-- /.home-owl-carousel -->
            </section>
          </div>

        </div>
        <br>
        @endif
        <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

        <!-- ============================================== HOT DEALS: END ============================================== -->

      </div><!-- /.col -->
      <!-- ============================================== BRANDS CAROUSEL ============================================== -->
      <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
    </div><!-- /.container -->



  </div><!-- /.body-content -->

  <!-- ============================================================= FOOTER ============================================================= -->

  <!-- ============================================== INFO BOXES ============================================== -->
  <!-- Report Product Modal -->
  <div class="modal fade" id="reportproduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h5 class="modal-title p-2" id="myModalLabel">{{ __('staticwords.ReportProduct') }} {{ $product->name }}</h5>
        </div>

        <div class="modal-body">
          <form action="{{ route('rep.pro',$product->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="simple_product" value="yes">
            <div class="form group">
              <label>{{ __('staticwords.Subject') }}: <span class="text-red">*</span></label>
              <input required type="text" name="title" class="form-control"
                placeholder="{{ __('staticwords.Whyyoureportingtheprdouctentertitle') }}">
            </div>
            <br>
            <div class="form-group">
              <label>{{ __('staticwords.Email') }}: <span class="text-red">*</span></label>
              <input name="email" required type="email" class="form-control" name="email"
                placeholder="{{ __('staticwords.Enteryouremailaddress') }}">
            </div>

            <div class="form-group">
              <label>{{ __('staticwords.Description') }}: <span class="text-red">*</span></label>
              <textarea required class="form-control" placeholder="{{ __('staticwords.Briefdescriptionofyourissue') }}"
                name="des" id="" cols="30" rows="10"></textarea>
            </div>

            <div class="form-group">
              <button type="submit"
                class="btn text-white btn-md bg-primary">{{ __('staticwords.SUBMITFORREVIEW') }}</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="notifyMe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-sm modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="float-right close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="p-1 modal-title" id="exampleModalLabel">Notify me</h5>

        </div>
        <div class="modal-body">
          <form action="{{ url("/subscribe/for/product/stock/".$product->id) }}" method="POST" class="notifyForm">
            @csrf
            <p class="help-block text-dark">
              {{__("Please enter your email to get notified")}}
            </p>
            <div class="form-group">
              <label>Email: <span class="text-red">*</span></label>
              <input name="email" type="email" class="form-control" placeholder="{{ __("Enter your email") }}" required>
            </div>

            <div class="form-group">
              <button type="submit" class="text-light btn btn-md btn-primary">
                {{__("Submit")}}
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <!-- Size chart modal -->
  @if(isset($product->sizechart) && $product->size_chart != '' && $product->sizechart->status == 1)
  <div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="p-2 modal-title">
                {{__('Preview')}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body previewTable">
            @include('admin.sizechart.previewtable',['template' => $product->sizechart]) 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger-rgba" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
  </div>
@endif
<!-- size chart model end -->


  @endsection
  @section('script')
  <!-- Lightbox JS -->
  <script src="{{ url('js/lightbox.min.js') }}"></script>
  <script src="{{url('front/vendor/js/additional-methods.min.js')}}"></script>
  <!-- Drfit ZOOM JS -->
  <script src="{{ url('front/vendor/js/drift.min.js') }}"></script>
  <script src="{{ url('js/share.js') }}"></script>
  <script>
    var baseUrl = @json(url('/'));
  </script>
  <script src='https://unpkg.com/spritespin@x.x.x/release/spritespin.js' type='text/javascript'></script>
  <script src="{{ url('js/detailpage.js') }}"></script>
  <script>
    var owl = $("#productgalleryItems");
    owl.owlCarousel({
      responsive: {
        0: {
          items: 3
        },
        600: {
          items: 3
        },
        1100: {
          items: 4
        }
      },
      slideSpeed: 300,
      autoPlay: true,
      smartSpeed: 1500,
      margin: 10,
      rtl: false,
      loop: true,
      video: true,
      nav: true,
      rewindNav: true,
      navText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"]
    });

    $("#single-product-gallery-item").on('mouseover',function() {
        $('#details-container').css('z-index', '9999');
    });
        
    $("#single-product-gallery-item").on('mouseout',function() {
      $('#details-container').css('z-index', '0');
    });

    driftzoom();

    function driftzoom() {

      new Drift(document.querySelector('.drift-demo-trigger'), {
        paneContainer: document.querySelector('#details-container'),
        inlinePane: 500,
        inlineOffsetY: -85,
        containInline: true,
        hoverBoundingBox: true,
        zoomFactor: 3,
        handleTouch: false,
        showWhitespaceAtEdges: false
      });
    }

    

    $(function(){

     

      var id = '{{ $product->id }}';

        setTimeout(() => {
          

          $.ajax({
              url : '{{ url("/simple_product/360/images") }}',
              type : 'GET',
              dataType : 'json',
              data : {id : id},
              success : function(response){

                $("#produdct360tour").spritespin({
                    // path to the source images.
                      frames : 35,
                      animate : true,
                      responsive : false,
                      loop : false,
                      orientation : 180,
                      reverse : false,
                      detectSubsampling : true,
                      source: response,
                      width   : 600,  // width in pixels of the window/frame
                      height  : 500,  // height in pixels of the window/frame
                });

              }
          });

        }, 2500);

    });

    $('.add_in_wish_simple').on('click',function(){

        var status = $(this).data('status');
        var proid = $(this).data('proid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
          url : '{{ route("add.simple.pro.in.wishlist") }}',
          method : 'GET',
          data : {proid : proid},
          success : function(response){
            if(response.status == 'success'){

              toastr.success(response.msg,'Success');

              console.log(response.msg);

              if(response.msg == 'Product added in wishlist !'){
                $('.add_in_wish_simple').addClass('bg-primary');
              }else{
                $('.add_in_wish_simple').removeClass('bg-primary');
              }


            }else{
              toastr.error(response.msg,'Failed');
            }
          }
        });

    });
  </script>
  @endsection