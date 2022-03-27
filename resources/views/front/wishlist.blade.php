@extends("front.layout.master")
@section('title',__('staticwords.YourWishlist').' ('.$wishcount.') |')
@section("body")
<div class="breadcrumb">
  <div class="container-fluid">
    <div class="breadcrumb-inner">
      <ul class="list-inline list-unstyled">
        <li><a href="{{ url('/') }}">{{ __('staticwords.Home') }}</a></li>
        <li class='active'>{{ __('staticwords.Wishlist') }}</li>
      </ul>
    </div><!-- /.breadcrumb-inner -->
  </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
  <div class="container-fluid">
    <div class="my-wishlist-page">
      <div class="row">
        <div class="col-md-12 my-wishlist">
          <h5>{{ __('staticwords.Wishlist') }} (<span class="wishtitle ">{{$wishcount}}</span>)</h5>
          <hr>
        
          @if(count($data) > 0)
         
          @foreach($data as $p)

        
            @if($p->variant && $p->variant->products->status == 1)
              <div id="orivar{{ $p->variant->id }}" class="row">
                <div class="col-md-2 col-4">
                  <a href="{{ App\Helpers\ProductUrl::getUrl($p->variant->id) }}">
                    @if(isset($p->variant->variantimages) && file_exists(public_path().'/variantimages/thumbnails/'.$p->variant->variantimages->main_image))
                    <img class="wish-img" title="{{ $p->variant->products->name }}"
                      src="{{ url('variantimages/thumbnails/'.$p->variant->variantimages['main_image']) }}"
                      alt="{{ $p->variant->variantimages['main_image'] }}">
                    @else 
                      <img class="pro-img2" src="{{ Avatar::create($p->variant->products->name)->toBase64() }}"
                        alt="product name" />
                    @endif
                  </a>
                </div>

                <div class="col-md-6 col-8 btm-10">
                  <h5 class="product-name"><a title="View product" href="{{ App\Helpers\ProductUrl::getUrl($p->variant->id) }}">{{$p->variant->products->name}}
                      <small>({{ variantname($p->variant) }})</small></a>
                  </h5>
                  <div class="rating">
                    <?php 
                        $reviews = App\UserReview::where('pro_id',$p->variant->products->id)->where('status','1')->get();
                     ?>
                    @if(!empty($reviews[0]))
                    <?php
                                  $review_t = 0;
                                  $price_t = 0;
                                  $value_t = 0;
                                  $sub_total = 0;
                                  $count =  App\UserReview::where('pro_id',$p->variant->products->id)->count();
                                    foreach($reviews as $review){
                                    $review_t = $review->price*5;
                                    $price_t = $review->price*5;
                                    $value_t = $review->value*5;
                                    $sub_total = $sub_total + $review_t + $price_t + $value_t;
                                    }
                                    $count = ($count*3) * 5;
                                    $rat = $sub_total/$count;
                                    $ratings_var = ($rat*100)/5;
                                    ?>

                    <div class="pull-left">
                      <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                          class="star-ratings-sprite-rating"></span></div>
                    </div>


                    @else
                    <div class="no-rating">{{'No Rating'}}</div>
                    @endif
                  </div>
                  <div class="product-price">

                    @if($price_login == 0 || Auth::check())
                    @php
                    $convert_price = 0;
                    $show_price = 0;

                    $commision_setting = App\CommissionSetting::first();

                    if($commision_setting->type == "flat"){

                    $commission_amount = $commision_setting->rate;
                    if($commision_setting->p_type == 'f'){

                    $totalprice = $p->variant->products->vender_price+$p->variant->price+$commission_amount;
                    $totalsaleprice = $p->variant->products->vender_offer_price + $p->variant->price + $commission_amount;

                    if($p->variant->products->vender_offer_price == 0){
                    $show_price = $totalprice;
                    }else{
                    $totalsaleprice;
                    $convert_price = $totalsaleprice =='' ? $totalprice:$totalsaleprice;
                    $show_price = $totalprice;
                    }


                    }else{

                    $totalprice = ($p->variant->products->vender_price+$p->variant->price)*$commission_amount;

                    $totalsaleprice = ($p->variant->products->vender_offer_price+$p->variant->price)*$commission_amount;

                    $buyerprice = ($p->variant->products->vender_price+$p->variant->price)+($totalprice/100);

                    $buyersaleprice = ($p->variant->products->vender_offer_price+$p->variant->price)+($totalsaleprice/100);


                    if($p->variant->products->vender_offer_price ==0){
                    $show_price = round($buyerprice,2);
                    }else{
                    round($buyersaleprice,2);

                    $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                    $show_price = $buyerprice;
                    }


                    }
                    }else{

                    $comm = App\Commission::where('category_id',$p->variant->products->category_id)->first();
                    if(isset($comm)){
                    if($comm->type=='f'){

                    $price = $p->variant->products->vender_price + $comm->rate + $p->variant->price;

                    if($p->variant->products->vender_offer_price != null){
                    $offer = $p->variant->products->vender_offer_price + $comm->rate + $p->variant->price;
                    }else{
                    $offer = $p->variant->products->vender_offer_price;
                    }

                    if($p->variant->products->vender_offer_price == 0 || $p->variant->products->vender_offer_price == null){
                    $show_price = $price;
                    }else{

                    $convert_price = $offer;
                    $show_price = $price;
                    }


                    }
                    else{

                    $commission_amount = $comm->rate;

                    $totalprice = ($p->variant->products->vender_price+$p->variant->price)*$commission_amount;

                    $totalsaleprice = ($p->variant->products->vender_offer_price+$p->variant->price)*$commission_amount;

                    $buyerprice = ($p->variant->products->vender_price+$p->variant->price)+($totalprice/100);

                    $buyersaleprice = ($p->variant->products->vender_offer_price+$p->variant->price)+($totalsaleprice/100);


                    if($p->variant->products->vender_offer_price == 0){
                    $show_price = round($buyerprice,2);
                    }else{
                    $convert_price = round($buyersaleprice,2);

                    $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                    $show_price = round($buyerprice,2);
                    }



                    }
                    }else{
                    $commission_amount = 0;

                    $totalprice = ($p->variant->products->vender_price+$p->variant->price)*$commission_amount;

                    $totalsaleprice = ($p->variant->products->vender_offer_price+$p->variant->price)*$commission_amount;

                    $buyerprice = ($p->variant->products->vender_price+$p->variant->price)+($totalprice/100);

                    $buyersaleprice = ($p->variant->products->vender_offer_price+$p->variant->price)+($totalsaleprice/100);


                    if($p->variant->products->vender_offer_price == 0){
                    $show_price = round($buyerprice,2);
                    }else{
                    $convert_price = round($buyersaleprice,2);

                    $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                    $show_price = round($buyerprice,2);
                    }
                    }
                    }
                    $convert_price_form = $convert_price;
                    $show_price_form = $show_price;
                    $convert_price = $convert_price*$conversion_rate;
                    $show_price = $show_price*$conversion_rate;

                    @endphp

                    @if(Session::has('currency'))
                    @if($convert_price == 0 || $convert_price == 'null')
                    <span class="color000"><i  class="{{session()->get('currency')['value']}}"></i>{{round($show_price,2)}}</span>
                    @else

                    <span class="price2"><i
                        class="{{session()->get('currency')['value']}}"></i>{{round($convert_price,2)}}
                    </span>

                    <span class="price-before-discount"><i
                        class="{{session()->get('currency')['value']}}"></i>{{round($show_price,2)}}
                    </span>


                    @endif
                    @endif

                    @endif
                  </div>
                  <div class="stock">
                    @if($p->variant->stock == 0)
                    <span class="required">{{ __('staticwords.Outofstock') }}</span>
                    @else
                    <span class="text-green"><b>{{ __('staticwords.InStock') }}</b></span>
                    @endif
                  </div>
                </div>

                <div class="col-md-3 col-9 ">
                  @if($p->variant->stock>0)
                  @php
                  $incartcheck = App\Cart::where('user_id',Auth::user()->id)->where('variant_id',$p->variant->id)->first();
                  @endphp
                  @if(!empty($incartcheck))
                  <a title="Remove this variant from cart" href="{{route('rm.cart',$p->variant->id)}}"
                    class="btn-upper btn btn-primary">
                    {{ __('staticwords.Removefromcart') }}
                  </a>
                  @else
                  <form method="POST"
                    action="{{route('add.cart',['id' => $p->variant->products->id ,'variantid' =>$p->variant->id, 'varprice' => $show_price_form, 'varofferprice' => $convert_price_form ,'qty' =>$p->variant->min_order_qty])}}">
                    @csrf
                    <button title="Add this variant in cart" type="submit"
                      class="btn btn-primary">{{ __('staticwords.AddtoCart') }}</button>
                  </form>
                  @endif
                  @else
                  @php
                  $incartcheck = App\Cart::where('user_id',Auth::user()->id)->where('variant_id',$p->variant->id)->first();
                  @endphp
                  @if(!empty($incartcheck))
                  <a disabled title="Remove this variant from cart" class="btn-upper btn btn-primary">
                    {{ __('staticwords.Removefromcart') }}
                  </a>
                  @else

                  <button disabled="disabled" title="Add this variant in cart"
                    class="btn btn-primary">{{ __('staticwords.AddtoCart') }}</button>

                  @endif
                  @endif
                </div>

                <div class="col-md-1 col-3">
                  @if(Auth::user()->wishlist->count()<1) <a class="font-size25" mainid="{{ $p->variant->id }}"
                    data-add="{{url('AddToWishList/'.$p->variant->id)}}" title="Add it to your Wishlist" href="">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                    @else
                    @php
                    $ifinwishlist = App\Wishlist::where('user_id',Auth::user()->id)->where('pro_id',$p->variant->id)->first();
                    @endphp

                    @if(!empty($ifinwishlist))
                    <a mainid="{{ $p->variant->id }}" data-remove="{{url('removeWishList/'.$p->variant->id)}}"
                      title="Remove it from your Wishlist" class="removeFrmWish cursor-pointer font-size-25">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    @endif
                    @endif
                </div>
              </div>
              <hr>
            @endif

            @if(isset($p->simple_product) && $p->simple_product->status == '1')
            <div class="row">
              <div class="col-md-2 col-4">
                <a href="{{ route('show.product',['id' => $p->simple_product->id, 'slug' =>   $p->simple_product->slug]) }}">
                  @if($p->simple_product->thumbnail != '' && file_exists(public_path().'/images/simple_products/'.$p->simple_product->thumbnail))
                    <img class="wish-img" title="{{ $p->simple_product->products_name }}"
                    src="{{ url('images/simple_products/'.$p->simple_product->thumbnail) }}"
                    alt="{{ $p->simple_product->thumbnail }}">
                  @else 
                    <img class="pro-img2" src="{{ Avatar::create($p->simple_product->products_name)->toBase64() }}"
                      alt="product name" />
                  @endif
                </a>
              </div>

              <div class="col-md-6 col-8 btm-10">
                <h5 class="product-name"><a title="View product" href="{{ route('show.product',['id' => $p->simple_product->id, 'slug' =>   $p->simple_product->slug]) }}">{{ $p->simple_product->product_name }}</a>
                </h5>
                <div class="rating">
                  <?php 
                      $reviews = App\UserReview::where('simple_pro_id',$p->simple_product->id)->where('status','1')->get();
                   ?>
                  @if(!empty($reviews[0]))
                  <?php
                                $review_t = 0;
                                $price_t = 0;
                                $value_t = 0;
                                $sub_total = 0;
                                $count =  App\UserReview::where('simple_pro_id',$p->simple_product->id)->count();
                                  foreach($reviews as $review){
                                  $review_t = $review->price*5;
                                  $price_t = $review->price*5;
                                  $value_t = $review->value*5;
                                  $sub_total = $sub_total + $review_t + $price_t + $value_t;
                                  }
                                  $count = ($count*3) * 5;
                                  $rat = $sub_total/$count;
                                  $ratings_var = ($rat*100)/5;
                                  ?>

                  <div class="pull-left">
                    <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%"
                        class="star-ratings-sprite-rating"></span></div>
                  </div>


                  @else
                  <div class="no-rating">{{'No Rating'}}</div>
                  @endif
                </div>
                <div class="product-price">

                 

                  
                  @if($p->simple_product->offer_price == '')
                  <span class="price2"><i
                    class="{{session()->get('currency')['value']}}"></i>{{round($p->simple_product->price * $conversion_rate,2)}}
                  </span>
                  @else

                  <span class="price2"><i
                    class="{{session()->get('currency')['value']}}"></i>{{round($p->simple_product->offer_price * $conversion_rate,2)}}
                  </span>

                  <span class="price-before-discount"><i
                      class="{{session()->get('currency')['value']}}"></i>{{round($p->simple_product->price * $conversion_rate,2)}}
                  </span>

                  @endif

                 
                </div>
                <div class="stock">
                  @if($p->simple_product->stock == 0)
                  <span class="required">{{ __('staticwords.Outofstock') }}</span>
                  @else
                  <span class="text-green"><b>{{ __('staticwords.InStock') }}</b></span>
                  @endif
                </div>
              </div>

              <div class="col-md-3 col-9 ">
                @if(chekcincart($p->simple_product->id) == false)
                <form action="{{ route('add.cart.simple',['pro_id' => $p->simple_product->id, 'price' => $p->simple_product->price, 'offerprice' => $p->simple_product->offer_price]) }}" method="POST">
                  @csrf
                  <div>
                    <div class="cart-quantity">
                      <div class="quant-input">
                        <input type="hidden" value="1" name="qty" min="{{ $p->simple_product->min_order_qty }}"
                          max="{{ $p->simple_product->max_order_qty }}" maxorders="null" class="qty-section">
                      </div>
                    </div>
                    <div class="add-btn">
                      @if($p->simple_product->type == 'ex_product')
                        <a href="{{ $p->simple_product->external_product_link }}" role="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{__("Buy Now")}} <span class="sr-only">(current)</span>
                        </a>
                      @else 
                      <button type="submit" class="btn btn-primary">
                        {{__("Add to Cart")}}
                      </button>
                      @endif
                    </div>
                  </div>
                </form>
                @else 

                <div class="add-btn">
                  @if($p->simple_product->type == 'ex_product')
                    <a href="{{ $p->simple_product->external_product_link }}" role="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{__("Buy Now")}} <span class="sr-only">(current)</span>
                    </a>
                  @else 
                  <a role="button" href="{{ route("rm.simple.cart",$p->simple_product->id) }}" class="btn btn-primary">
                    {{__("Remove from Cart")}}
                  </a>
                  @endif
                </div>

                @endif
              </div>

              <div class="col-md-1 col-3">
               
                <a class="{{ inwishlist($p->simple_product->id) == true ? "bg-primary" : "" }} add_in_wish_simple btn btn-primary" data-proid="{{ $p->simple_product->id }}" data-status="{{ inwishlist($p->simple_product->id) }}" data-toggle="tooltip" data-placement="right"
                  title="  {{ inwishlist($p->simple_product->id) == false ? __("staticwords.AddToWishList") :  __("staticwords.RemoveFromWishlist") }}" href="javascript:void(0)">
                  <i class="fa fa-heart"></i>
                </a>
                 
              </div>
            </div>
            <hr>
           
            @endif

            @endforeach

            @else 

              <h3>
                <i class="fa fa-heart-o"></i> {{ __("staticwords.wishlistempty") }}
              </h3>

            @endif

        </div>
      </div><!-- /.row -->
    </div><!-- /.sigin-in-->
  </div><!-- /.container -->
</div><!-- /.body-content -->
<br>
@endsection
@section('script')
<script src="{{ url('js/wish2.js') }}"></script>
<script>
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
              $(this).remove();
            }


          }else{
            toastr.error(response.msg,'Failed');
          }
        }
      });

    });
</script>
@endsection