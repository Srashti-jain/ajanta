<style>
    .centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 89px;
  /* z-index: 100; */
  height: 28px;
  opacity: 1;
}
</style>
<div class="product-card card " onclick="quickView('{{$product_data['id']}}','{{$product_data['subcategory_id']}}','{{ $product_data['name']}}')"   @if(isset($product_data['set_status']) && $product_data['set_status'] >= 1) style="cursor: pointer;" @else style="pointer-events: none; " @endif>
    <div class="card-header inline_product clickable p-0" style="height:134px;width:100%;overflow:hidden;@if(isset($product_data['set_status']) && $product_data['set_status'] >= 1) @else opacity: 0.4; @endif">
        <div class="d-flex align-items-center justify-content-center d-block">
            <img src="{{asset('images/simple_products')}}/{{$product['img']}}"
            onerror="this.src='{{asset('admin_new/assets/images/160x160/img2.jpg')}}'"
                 style="width: 100%; border-radius: 5%;">  
                 
        </div>
    </div>
    @if(isset($product_data['set_status']) && $product_data['set_status'] >= 1)
    @else
    <div class="bg-danger rounded centered">
         <p class="text-white text-center" >Out of Stock</p>
    </div>
    @endif 

    <div class="card-body inline_product text-center p-1 clickable"
         style="height:3.5rem; max-height: 3.5rem">
        <div style="position: relative;" class="product-title1 text-dark font-weight-bold">
            {{ \Illuminate\Support\Str::limit($product_data['name'], 15) }}
         
        </div>
      
        <div class="justify-content-between text-center">
            <div class="product-price text-center">
                {{ ('Rs. '.$product_data['tot_price']) }}
                @if(@$product_data['discount'] > 0)
                    <strike style="font-size: 12px!important;color: grey!important;">
                        {{ $product_data['tot_price'] . ' ' . \App\CentralLogics\Helpers::currency_symbol() }}
                    </strike><br>
                @endif
            </div>
        </div>
      
    </div>
</div>
