@extends("front.layout.master")
@section('title', __("All deals"))
@section('meta_tags')
<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta property="og:title" content="{{ __("All deals") }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->full() }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="{{ url()->full() }}" />
@endsection
@section("body")
<div class="breadcrumb">
    <div class="container-fluid">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('flashdeals.list') }}">{{ __("Flash deals") }}</a></li>
                <li><a href="{{ url()->full() }}">{{ $deal->title }}</a></li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->


<div class="container-fluid">
    <div class="test" style="background-image: url('{{ url('images/flashdeals/'.$deal->background_image) }}');">
        <div class="overlay-bg"></div>
        <div class="bg_image_deal">
            <div class="countdown-deal">
                <p class="text-center text-white">{{__("Sale ends in ")}}</p>
                <div id="countdown">
                    <ul>
                        <li class="text-shadow"><span class="text-white" id="days"></span><span class="text-white text-20">days</span></li>
                        <li class="text-shadow"><span class="text-white" id="hours"></span><span class="text-white text-20"> hours</span></li>
                        <li class="text-shadow"><span class="text-white" id="minutes"></span><span class="text-white text-20"> minutes</span></li>
                        <li class="text-shadow"><span class="text-white" id="seconds"></span><span class="text-white text-20">seconds</span></li>
                    </ul>
                </div>
            </div>
            <div>
                {!! $deal->detail !!}
            </div>
            <div class="row p-3">
                @forelse($deal->saleitems as $item)
                <div class="mt-2 col-xl-3 col-lg-4 col-md-6">
                    <div class="h-100 card">
                        @if(isset($item->variant))
                            
                            <center>
                                @if(isset($item->variant->variantimages))
                                <a href="{{ App\Helpers\ProductUrl::getUrl($item->variant->id) }}">
                                    <img width="100px" src="{{ url('variantimages/'.$item->variant->variantimages->main_image) }}" class="mt-2" alt="...">
                                </a>
                                @endif
                            </center>
                            <div class="card-body">
                               
                                    <div class="card-title">
                                        <a class="text-dark" href="{{ App\Helpers\ProductUrl::getUrl($item->variant->id) }}">
                                            {{$item->variant->products->name}}
                                        </a>
                                    </div>

                                    
                                    <p>
                                        {{ substr(strip_tags($item->variant->products->des), 0, 100)}}{{strlen(strip_tags($item->variant->products->des))>100 ? '...' : ""}}
                                    </p>

                                    <h5>Discount : {{ $item->discount }}% ({{ $item->discount_type }})</h5>
                                    <hr>
                                    @php

                                        $mainprice = 0;

                                        $get_product_data = new App\Http\Controllers\Api\MainController;

                                        $mainprice = $get_product_data->getprice($item->variant->products, $item->variant);

                                        $price = $mainprice->getData();

                                        if($price->offerprice != '0'){
                                            
                                            echo '<i class="'.session()->get('currency')['value'].'"></i>';
                                            echo sprintf("%.2f",$price->offerprice * $conversion_rate);

                                        }else{
                                            
                                            echo '<i class="'.session()->get('currency')['value'].'"></i>';
                                            echo sprintf("%.2f",$price->mainprice * $conversion_rate);

                                        }

                                        $sellprice = $price->offerprice != 0 ? $price->offerprice : $price->mainprice;

                                        $discount = $item->discount;

                                        $discount_type = $item->discount_type;

                                        $discounted_amount = 0;

                                        if($discount_type == 'upto'){

                                            $random_no = rand(0,$discount);
                                            
                                            $discounted_amount = $sellprice * $random_no / 100;

                                        }else{

                                            $discounted_amount = $sellprice * $discount / 100;

                                        }

                                        $deal_price = $sellprice - $discounted_amount;

                                    @endphp
                                    
                                    <div class="card-body">
                                        <form action="{{ route('add.cart', ['id' => $item->variant->id, 'variantid' => $item->variant->id, 'varprice' => $price->mainprice, 'varofferprice' => $deal_price, 'qty' => $item->variant->min_order_qty]) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-md btn-primary">
                                                <i class="fa fa-cart-plus"></i> {{ __("Add to cart") }}
                                            </button>
                                        </form>
                                    </div>
                            </div>
                        @else
                            <center>
                                <a href="{{ route('show.product',['id' => $item->simple_product->id, 'slug' => $item->simple_product->slug]) }}">
                                    <img width="100px" src="{{ url('images/simple_products/'.$item->simple_product->thumbnail) }}" class="mt-2" alt="{{ $item->simple_product->thumbnail }}">
                                </a>
                            </center>
                            <div class="card-body">
                                <div class="card-title">
                                    <a class="text-dark" href="{{ route('show.product',['id' => $item->simple_product->id, 'slug' => $item->simple_product->slug]) }}">{{ $item->simple_product->product_name }}</a>
                                </div>

                                <p>
                                    {{ substr(strip_tags($item->simple_product->product_detail), 0, 100)}}{{strlen(strip_tags($item->simple_product->product_detail))>100 ? '...' : ""}}
                                </p>

                                <h5>Discount : {{ $item->discount }}% ({{ $item->discount_type }})</h5>
                                <hr>
                                    @php

                                        $mainprice = 0;

                                        if($item->simple_product->offer_price != '0'){
                                            
                                            echo '<i class="'.session()->get('currency')['value'].'"></i>';
                                            echo sprintf("%.2f",$item->simple_product->offer_price * $conversion_rate);

                                        }else{
                                            
                                            echo '<i class="'.session()->get('currency')['value'].'"></i>';
                                            echo sprintf("%.2f",$item->simple_product->price * $conversion_rate);

                                        }

                                        $sellprice = $item->simple_product->offer_price != 0 ? $item->simple_product->offer_price : $item->simple_product->price;

                                        $discount = $item->discount;

                                        $discount_type = $item->discount_type;

                                        $discounted_amount = 0;

                                        if($discount_type == 'upto'){

                                            $random_no = rand(0,$discount);
                                            
                                            $discounted_amount = $sellprice * $random_no / 100;

                                        }else{

                                            $discounted_amount = $sellprice * $discount / 100;

                                        }

                                        $deal_price = $sellprice - $discounted_amount;

                                    @endphp
                                    
                                    <div class="card-body">
                                        <form action="{{ route('add.cart.simple',['pro_id' => $item->simple_product->id, 'price' => $item->simple_product->price, 'offerprice' => $deal_price]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="qty" value="{{ $item->simple_product->min_order_qty }}">
                                            <button class="btn btn-md btn-primary">
                                                <i class="fa fa-cart-plus"></i> {{ __("Add to cart") }}
                                            </button>
                                        </form>
                                    </div>
                            </div>
                        @endif
                    </div>
                </div>
                @empty

                <div class="col-md-12">
                    <h4 class="text-center">
                        {{__("No products found !")}}
                    </h4>
                </div>
                    
                @endforelse
               
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    (function () {
        const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;

        let birthday = "{{ date('M d, Y h:i:s',strtotime($deal->end_date)) }}",
            countDown = new Date(birthday).getTime(),
            x = setInterval(function () {

                let now = new Date().getTime(),
                    distance = countDown - now;

                document.getElementById("days").innerText = Math.floor(distance / (day)),
                    document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

                //do something later when date is reached
                if (distance < 0) {
                    let headline = document.getElementById("headline"),
                        countdown = document.getElementById("countdown"),
                        content = document.getElementById("content");

                    headline.innerText = "It's my birthday!";
                    countdown.style.display = "none";
                    content.style.display = "block";

                    clearInterval(x);
                }
                //seconds
            }, 0)
    }());
</script>
@endsection