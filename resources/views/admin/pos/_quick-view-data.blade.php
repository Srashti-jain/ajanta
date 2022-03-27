<style>
    .btn-check {
        position: absolute;
        clip: rect(0, 0, 0, 0);
        pointer-events: none;
    }

    .choice-input {
        width: 7rem;
    }

    .addon-input {
        height: 7rem;
        width: 7rem;
    }

    .addon-quantity-input {
        height: 2rem;
        width: 7rem;
        z-index: 9;
        bottom: 1rem;
        visibility: hidden;
    }

    .check-label {
        background-color: #F3F3F3;
        color: #000000;
        border-width: 2px;
        border-color: #BABFC4;
        font-weight: bold;
    }

    .btn-check:checked + .check-label {
        background-color: #EF7822;
        color: #FFFFFF;
        border: none;
    }

    .product-name {
        word-break: break-all;
    }
</style>
<div class="modal-header p-2">
    <h4 class="modal-title product-title">
    </h4>
    <button class="close call-when-done" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="d-flex flex-row">
        <!-- Product gallery-->
      
        <div class="d-flex align-items-center justify-content-center active" style="height:9.5rem;">
            <img class="img-responsive" style="height:100%;width:auto;overflow:hidden;border-radius: 5%;"
                src="{{asset('images/simple_products')}}/{{$product['img']}}"
                onerror="this.src='{{asset('admin_new/assets/images/160x160/img2.jpg')}}'"
                 data-zoom="{{asset('images/simple_products')}}/{{$product['img']}}"
                 alt="Product image" width="">
            <div class="cz-image-zoom-pane"></div>
        </div>
        <!-- Product details-->
        <div class="details pl-2">
            <span class="product-name"><a href="#" class="h3 mb-2 product-title">{{ \Illuminate\Support\Str::limit($product['name'], 100) }}</a></span>

            <div class="mb-3 text-dark">
                <span class="h3 font-weight-normal text-accent mr-1">
                    {{ ('Rs. '.$product['tot_price']) }}
                </span>
                @if(@$product['discount'] > 0)
                    <strike style="font-size: 12px!important;">
                        {{ $product['tot_price'] . ' ' . \App\CentralLogics\Helpers::currency_symbol() }}
                    </strike>
                @endif
            </div>

            @if(@$product['discount'] > 0)
                <div class="mb-3 text-dark">
                    <strong>Discount : </strong>
                    <strong
                        id="set-discount-amount">{{\App\CentralLogics\Helpers::discount_calculate($product, $product->tot_price) . ' ' . \App\CentralLogics\Helpers::currency_symbol()}}</strong>
                </div>
            @endif
        <!-- Product panels-->
            {{--<div style="margin-left: -1%" class="sharethis-inline-share-buttons"></div>--}}
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            <?php
            $cart = false;
            if (session()->has('cart1')) {
                foreach (session()->get('cart1') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $product['id']) {
                        $cart = $cartItem;
                    }
                }
            }

            ?>
            <h2>{{\App\CentralLogics\translate('description')}}</h2>
            <span class="d-block text-dark">
                {!! $product['name'] !!}
            </span>
            <form id="add-to-cart-form" class="mb-2">
                @csrf
                <input type="hidden" name="id" value="{{ $product['id'] }}">
                <input type="hidden" name="subcategory" value="{{ $product['subcategory_id'] }}">
                {{-- <input type="hidden" name="quantity" value="1"> --}}
                <input type="hidden" name="set_name" value="{{ $product['name'];}}">
            
            <!-- Quantity + Add to cart -->
                <div class="d-flex justify-content-between">
                    <div class="product-description-label mt-2 text-dark h3">{{\App\CentralLogics\translate('Quantity')}}:</div>
                    <div class="product-quantity d-flex align-items-center">
                        <div class="input-group input-group--style-2 pr-3"
                             style="width: 160px;">
                             <span class="input-group-btn">
                                <button class="btn btn-number text-dark" type="button"
                                        data-type="minus" data-field="quantity"
                                        disabled="disabled" style="padding: 10px">
                                        <i class="tio-remove  font-weight-bold"></i>
                                </button>
                            </span>
                          <input type="text" name="quantity"
                                   class="form-control input-number text-center cart-qty-field"
                                   placeholder="1" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark" type="button" data-type="plus"
                                        data-field="quantity" style="padding: 10px">
                                        <i class="tio-add  font-weight-bold"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                @php($add_ons = json_decode(@$product['add_ons']))
               {{-- @if(count($add_ons)>0)
                    <div class="h3 p-0 pt-2">{{ \App\CentralLogics\translate('addon') }}
                    </div>

                    <div class="d-flex justify-content-left flex-wrap">
                        @foreach (\App\Model\AddOn::whereIn('id', $add_ons)->get() as $key => $add_on)
                            <div class="flex-column pb-2">
                                <input type="hidden" name="addon-price{{ @$add_on->id }}" value="{{@$add_on->price}}">
                                <input class="btn-check addon-chek" type="checkbox"
                                       id="addon{{ $key }}" onchange="addon_quantity_input_toggle(event)"
                                       name="addon_id[]" value="{{ @$add_on->id }}"
                                       autocomplete="off">
                                <label class="d-flex align-items-center btn btn-sm check-label mx-1 addon-input"
                                       for="addon{{ $key }}">{{ @$add_on->name }} <br>
                                    {{ @$add_on->price . ' ' . \App\CentralLogics\Helpers::currency_symbol() }}
                                </label>
                                <label class="input-group addon-quantity-input mx-1 shadow bg-white rounded px-1"
                                       for="addon{{ $key }}">
                                    <button class="btn btn-sm h-100 text-dark px-0" type="button"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown(), getVariantPrice()">
                                        <i class="tio-remove  font-weight-bold"></i></button>
                                    <input type="number" name="addon-quantity{{ @$add_on->id }}"
                                           class="form-control text-center border-0 h-100"
                                           placeholder="1" value="1" min="1" max="100" readonly>
                                    <button class="btn btn-sm h-100 text-dark px-0" type="button"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp(), getVariantPrice()">
                                        <i class="tio-add  font-weight-bold"></i></button>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif --}}
                <div class="row no-gutters mt-2 text-dark" id="chosen_price_div">
                    <div class="col-2">
                        <div class="product-description-label">{{\App\CentralLogics\translate('Total Price')}}:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price">
                            <strong id="chosen_price">Rs. {{ $product['tot_price'] }}</strong> 
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2">
                    <button class="btn btn-primary"
                            onclick="addToCart()"
                            type="button"
                            style="width:37%; height: 45px">
                        <i class="tio-shopping-cart"></i>
                        {{\App\CentralLogics\translate('add')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form input').on('change', function () {
        getVariantPrice();
    });
</script>

