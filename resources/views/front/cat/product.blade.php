@php

$pricing = array();
$customer_price = 0;
$customer_price=0;
$customeroffer_price;
$show_price = 0;
$convert_price = 0;

if($a != null){
  $products = array_unique($products);
}

$current_date = date('Y-m-d h:i:s');

@endphp

@if(count($simple_products))
  @foreach($simple_products as $sp)
  @if($sp->offer_price != 0)

    @php
      array_push($pricing, $sp->offer_price);
    @endphp

  @else 

    @php
      array_push($pricing, $sp->price);
    @endphp

  @endif
  @endforeach
@endif


@if($products != null && count($products) || count($simple_products))

@foreach($simple_products as $simple_pro)

    @php
      $finalprice = $simple_pro->offer_price != 0 ? $simple_pro->offer_price : $simple_pro->price;
      
    @endphp

    @if($starts <= $finalprice * $conversion_rate && $ends >= $finalprice * $conversion_rate)
    
      @include('front.cat.simple_product')

    @endif

@endforeach

@foreach($products as $product)

@foreach($product->subvariants as $key=> $sub)



@if($price_login == 0 || Auth::user())

@php


$commision_setting = App\CommissionSetting::first();

if($commision_setting->type == "flat"){

  $commission_amount = $commision_setting->rate;

if($commision_setting->p_type == 'f'){

if($product->tax_r !=''){

  $cit = $commission_amount*$product->tax_r/100;

  $totalprice = $product->vender_price+$sub->price+$commission_amount+$cit;

  if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL)
  {
    $totalsaleprice = $product->vender_offer_price + $sub->price + $commission_amount+$cit;
  }else{
    $totalsaleprice = 0;
  }

}else{

  $totalprice = $product->vender_price+$orivar->price+$commission_amount;

  if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL)
  {
    $totalsaleprice = $product->vender_offer_price + $sub->price + $commission_amount;
  }else{
    $totalsaleprice = 0;
  }

}


if($totalsaleprice == 0){

  $customer_price = $totalprice;
  $customer_price = round($customer_price * round($conversion_rate, 4), 2);
  $convert_price = 0;
  $show_price = $customer_price;

}else{

  $customer_price = $totalsaleprice;
  $customer_price = round($customer_price * round($conversion_rate, 4), 2);
  $convert_price = $totalsaleprice;
  $show_price = $totalprice;
}


}else{


  $totalprice = ($product->vender_price+$sub->price)*$commission_amount;

  if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL){
    $totalsaleprice = ($product->vender_offer_price+$sub->price)*$commission_amount;
  }

  $buyerprice = ($product->vender_price+$sub->price)+($totalprice/100);

  if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL){
    $buyersaleprice = ($product->vender_offer_price+$sub->price)+($totalsaleprice/100);
  }else {
    $buyersaleprice = 0;
  }


  if($buyersaleprice ==0){
    $customer_price = round($buyerprice,2);
    $customer_price = round($customer_price * round($conversion_rate, 4), 2);
    $convert_price = 0;
    $show_price = $buyerprice;
  }else{
    $customer_price = round($buyersaleprice,2);
    $customer_price = round($customer_price * round($conversion_rate, 4), 2);
    $convert_price = $buyersaleprice;
    $show_price = $buyerprice;
  }


}
}else{

$comm = App\Commission::where('category_id',$product->category_id)->first();


if(isset($comm)){
if($comm->type=='f'){

  $commission_amount = $comm->rate;

  if($product->tax_r !=''){

    $cit = $commission_amount*$product->tax_r/100;
    $totalprice = $product->vender_price+$sub->price+$commission_amount+$cit;

    if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL)
    {
      $totalsaleprice = $product->vender_offer_price + $sub->price + $commission_amount + $cit;
    }else{
      $totalsaleprice = 0;
    }

  }else{

    $totalprice = $product->vender_price+$sub->price+$commission_amount;

    if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL)
    {
      $totalsaleprice = $product->vender_offer_price + $sub->price + $commission_amount;
    }else{
      $totalsaleprice = 0;
    }

  }

  if($totalsaleprice == 0){

    $customer_price = $totalprice;
    $customer_price = round($customer_price * round($conversion_rate, 4), 2);
    $convert_price = 0;
    $show_price = $totalprice;

  }else{

    $customer_price = $totalsaleprice;
    $customer_price = round($customer_price * round($conversion_rate, 4), 2);
    $convert_price = $totalsaleprice;
    $show_price = $totalprice;

  }

}
else{

  $commission_amount = $comm->rate;

  $totalprice = ($product->vender_price+$sub->price)*$commission_amount;

  if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL){
    $totalsaleprice = ($product->vender_offer_price+$sub->price)*$commission_amount;
  }

  $buyerprice = ($product->vender_price+$sub->price)+($totalprice/100);

  if($product->vender_offer_price != 0 || $product->vender_offer_price != NULL){
    $buyersaleprice = ($product->vender_offer_price+$sub->price)+($totalsaleprice/100);
  }else {
    $buyersaleprice = 0;
  }


  if($buyersaleprice ==0){
    $customer_price = round($buyerprice,2);
    $customer_price = round($customer_price * round($conversion_rate, 4), 2);
    $convert_price = 0;
    $show_price = $buyerprice;
  }else{
    $customer_price = round($buyersaleprice,2);
    $customer_price = round($customer_price * round($conversion_rate, 4), 2);
    $convert_price = $buyersaleprice;
    $show_price = $buyerprice;
  }

}
}else{

  $commission_amount = 0;

  $totalprice = ($product->vender_price + $sub->price) * $commission_amount;

  $totalsaleprice = ($product->vender_offer_price + $sub->price) * $commission_amount;

  $buyerprice = ($product->vender_price + $sub->price) + ($totalprice / 100);

  $buyersaleprice = ($product->vender_offer_price + $sub->price) + ($totalsaleprice / 100);

  if ($product->vender_offer_price == 0)
  {
    $customer_price = round($buyerprice, 2);
    $customer_price = round($customer_price * round($conversion_rate, 4) , 2);
  }
  else
  {
    $customer_price = round($buyersaleprice, 2);
    $customer_price = round($customer_price * round($conversion_rate, 4) , 2);
    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
    $show_price = $buyerprice;
  }
}
}

@endphp

@endif
@php

  $var_name_count = count($sub['main_attr_id']);

  $name;
  $var_name;
  $newarr = array();

  for($i = 0; $i<$var_name_count; $i++){ 
  
    $var_id=$sub['main_attr_id'][$i];
    
    $var_name[$i]=$sub['main_attr_value'][$var_id]; // echo($orivar['main_attr_id'][$i]);
    $name[$i]=App\ProductAttributes::where('id',$var_id)->first();

  }


  try{
    $url = url('details').'/'.$product->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
  }catch(\Exception $e)
  {
    $url = url('details').'/'.$product->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
  }

  array_push($pricing, $customer_price);
  @endphp
  @if($outofstock == 1)




  @if($sub->stock > 0)

  <!-- if stock is greater than 0 start -->
  @if($start_price == 1)

  <!-- on price slider start_price = 1 and on load also -->
  @if($starts <= $customer_price && $ends>= $customer_price)
    <!-- Starts and Ends values are came from URL -->

    @if($a != null)
    <!-- $a = subvariant unique array only work with variant filter -->
      @foreach($a as $provars)
      <!-- Extract Variant array  -->
        @if($provars->id == $sub->id)
        <!-- match unique subvariant id to all subvariant id -->
          

          @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)

            <!-- only work with rating filter -->
            @include('front.cat.filterproduct')

          @else
            @if($ratings == 0)
              @include('front.cat.filterproduct')
            @else
                <!-- No code -->
            @endif
            
          @endif


        @endif
      @endforeach
    @else

    

      @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)
            
        @include('front.cat.filterproduct')

      @else
        @if($ratings == 0)

        @include('front.cat.filterproduct')

        @else
        @endif
      @endif


    @endif

    @endif
    @else

    @if($start <= $customer_price && $end >= $customer_price)

      @if($a != null)
          @foreach($a as $provars)
            @if($provars->id == $sub->id)
            

              @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)
                @include('front.cat.filterproduct')
              @else
                @if($ratings == 0)
                  @include('front.cat.filterproduct')
                @else

                @endif
              @endif

            @endif
          @endforeach
      @else
     


        @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)
          @include('front.cat.filterproduct')
        @else
          @if($ratings == 0)
            @include('front.cat.filterproduct')
          @else

          @endif
        @endif

      @endif
      @endif
      @endif
      @else

      {{--  <span>{{ __('staticwords.ComingSoon') }}</span> Product will show here --}}

      @endif



      @else
      {{--   <span>{{ __('staticwords.ComingSoon') }}</span> include --}}
      @if($sub->stock > 0)
      @if($start_price == 1)

      @if($starts <= $customer_price && $ends>= $customer_price)


        @if($a != null)
        @foreach($a as $provars)
        @if($provars->id == $sub->id)
        
        @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)
          @include('front.cat.filterproduct')
        @else

        @if($ratings == 0)
          @include('front.cat.filterproduct')
        @else

        @endif
        @endif


        @endif
        @endforeach
        @else

       
        @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)

          @include('front.cat.filterproduct')

        @else

        @if($ratings == 0)

          @include('front.cat.filterproduct')

        @else



        @endif
        @endif


        @endif

        @endif
        @else

        @if($start <= $customer_price && $end>= $customer_price)
          @if($a != null)
          @foreach($a as $provars)
          @if($provars->id == $sub->id)
          
          @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)

            @include('front.cat.filterproduct')

          @else


          @if($ratings == 0)
            @include('front.cat.filterproduct')
          @else

          @endif
          @endif

          @endif
          @endforeach
          @else
          

          @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)

            @include('front.cat.filterproduct')

          @else

            @if($ratings == 0)
              @include('front.cat.filterproduct')
            @else

            @endif

          @endif

          @endif
          @endif
          @endif
          @else



          @if($start_price == 1)

          @if($starts <= $customer_price && $ends>= $customer_price)


            @if($a != null)
              @foreach($a as $provars)
                @if($provars->id == $sub->id)
                

                  @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)
                    @include('front.cat.filterproduct')
                  @else
                    @if($ratings == 0)
                      @include('front.cat.filterproduct')
                    @else

                    @endif
                  @endif


                @endif
              @endforeach
            @else


              @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)

                @include('front.cat.filterproduct')

              @else
                @if($ratings == 0)
                  @include('front.cat.filterproduct')
                @else

                @endif
              @endif


            @endif

            @endif
            @else
            @if($start <= $customer_price && $end>= $customer_price)
              @if($a != null)
                @foreach($a as $provars)
                
                    @if($provars->id == $sub->id)
                  

                      @if(get_product_rating($product->id) != 0 && $start_rat !=null && get_product_rating($product->id) >= $start_rat)
                        
                        @include('front.cat.filterproduct')

                      @else

                        @if($ratings == 0)
                          @include('front.cat.filterproduct')
                        @else

                      @endif

                    @endif

                @endif
                @endforeach
              @else

                

                  @if(get_product_rating($product->id) != 0  && $start_rat !=null && get_product_rating($product->id) >= $start_rat)
                    @include('front.cat.filterproduct')
                  @else

                    @if($ratings == 0)
                                  
                      @include('front.cat.filterproduct')
                    
                    @else

                    @endif
                    
                  @endif

              @endif
              @endif
              @endif



              @endif
              @endif


              @endforeach
              @endforeach
              @else
                <div class="mx-auto">
                  <img class="lazy" data-src="{{ url('images/nocart.jpg') }}" alt="{{ __("404") }}"
                    title="{{ __("No results found !") }}">
                  <h3 class="text-center">{{ __('No results found !') }}</h3>
                </div>
              @endif

              <?php
                if($pricing != null){
                  $first_cat=min($pricing);
                  $last_cat=max($pricing);
                }else{
                  $first_cat=0;
                  $last_cat=0;
                }
                if($brand_names == null || $tags_pro == null){
                $brandAvl = 0;
                }else{
                $brandAvl = 1;
                }
                if($slider == 'yes'){
                  $sliding = 1;
                }else{
                  $sliding = 0;
                }
              ?>




  <script>
    var baseUrl = @json('/');
  </script>
  <script src="{{ url('js/wishlist.js') }}"></script>
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


                }else{
                    toastr.error(response.msg,'Failed');
                }
            }
        });


    });
  </script>
  <script>
    var lprice = @json($first_cat * round($conversion_rate, 4));
    var hprice = @json($last_cat * round($conversion_rate, 4));
    var brandAvl = @json($brandAvl);
    var sliding = @json($sliding);
    var tag_chk = @json($tag_check);
  </script>
  <script src="{{ url('js/filterproduct.js') }}"></script>