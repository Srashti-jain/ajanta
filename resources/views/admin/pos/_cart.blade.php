<div class="d-flex flex-row" style="max-height: 400px; overflow-y: scroll;">
    <table class="table table-bordered">
        <thead class="text-muted">
            <tr>
                <th scope="col">{{\App\CentralLogics\translate('Books')}}</th>
                <th scope="col" class="text-center">{{\App\CentralLogics\translate('qty')}}</th>
                <th scope="col">{{\App\CentralLogics\translate('price')}}</th>
                <th scope="col">{{\App\CentralLogics\translate('delete')}}</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $subtotal = 0;
            $addon_price = 0;
            $discount = 0;
            $discount_type = 'amount';
            $discount_on_product = 0;
            $total_tax = 0;
            ?>
            @if(session()->has('cart1') && count( session()->get('cart1')) > 0)
            <?php
            $cart = session()->get('cart1');
            // if(isset(@$cart['discount']))
            // {
                //     $discount = @$cart['discount'];
                //     $discount_type = @$cart['discount_type'];
                // }
                ?>
                @foreach(session()->get('cart1') as $key => $cartItem)
                @if(is_array($cartItem))
                <?php
                $cartItem['discount'] = 0;
                $product_subtotal = ($cartItem['price'])*$cartItem['quantity'];
                $discount_on_product += ($cartItem['discount']*$cartItem['quantity']);
                $subtotal += $product_subtotal;
                $addon_price += @$cartItem['addon_price'];
                
                //tax calculation
                // $product = \App\Model\Product::find($cartItem['id']);
                $total_tax += $cartItem['tax'] * $cartItem['quantity'];
                
                ?>
                <tr>
                 
                    <td class="media align-items-center">
                     
                        <div class="media-body">  
                            <img class="avatar avatar-sm mr-1" src="{{asset('images/simple_products')}}/{{$cartItem['image']}}"
                            onerror="this.src='{{asset('admin_new/assets/images/160x160/img2.jpg')}}'" alt="{{$cartItem['name']}} image">
                            <table class="table table-bordered">
                                <thead>  <h5 class="text-hover-primary mb-0">{{ \Illuminate\Support\Str::limit($cartItem['name'], 10) }}</h5></thead>
                                <tbody>
                               
                                    @foreach($cartItem['set_array_list'] as $key1 => $book_set)
                                    {{-- {{ dd($book_set )}} --}}
                                    <tr>
                                    <td class="media align-items-center">
                                        {{ \Illuminate\Support\Str::limit($book_set['name'], 30) }} (Rs. {{ ($book_set['price']) }} )
                                    </td>
                                    @if($book_set['set_editable'] == 1)
                                     <td class="align-items-center text-center" id="{{ $book_set['single_product_id'] }}">
                                        <a href="javascript:deletefromset({{$book_set['single_product_id']}}, {{$cartItem['id']}},{{$cartItem['subcategory']}},{{ $cartItem['quantity'] }},{{$key}},'{{$cartItem['name']}}')" class="btn btn-sm btn-outline-danger"> <i class="tio-delete-outlined"></i></a>
                                    </td> 
                                    @endif
                                </tr>
                                      @endforeach
                                
                                 </tbody>
                              
                            </table>
                        </div>
                    </td>
                    <td class="align-items-center text-center">
                        <input type="number"  data-key="{{$key}}" style="width:50px;text-align: center;" value="{{$cartItem['quantity']}}" min="1" onkeyup="updateQuantity(event)">
                    </td>
                    <td class="text-center px-0 py-1">
                        <div class="btn">
                            {{$product_subtotal . 'Rs.'}}
                        </div> <!-- price-wrap .// -->
                    </td>
                    <td class="align-items-center text-center">
                        <a href="javascript:removeFromCart({{$key}},{{$cartItem['id']}},{{$cartItem['subcategory']}})" class="btn btn-sm btn-outline-danger"> <i class="tio-delete-outlined"></i></a>
                    </td>
                </tr>
                @endif
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    
    <?php
    $total = $subtotal+$addon_price;
    $discount_amount = ($discount_type=='percent' && $discount>0)?(($total * $discount)/100):$discount;
    $discount_amount += $discount_on_product;
    $total -= $discount_amount;
    
    $extra_discount = session()->get('cart1')['extra_discount'] ?? 0;
    $extra_discount_type = session()->get('cart1')['extra_discount_type'] ?? 'amount';
    if($extra_discount_type == 'percent' && $extra_discount > 0){
        $extra_discount =  (($total+$total_tax)*$extra_discount) / 100;
    }
    if($extra_discount) {
        $total -= $extra_discount;
    }
    ?>
    <div class="box p-3">
        <dl class="row text-sm-right">
            
            {{-- <dt  class="col-sm-6">{{\App\CentralLogics\translate('addon')}} : </dt>
            <dd class="col-sm-6 text-right">{{$addon_price . ' Rs.'}}</dd> --}}
            
            <dt  class="col-sm-6">{{\App\CentralLogics\translate('sub_total')}} : </dt>
            <dd class="col-sm-6 text-right">{{($subtotal+$addon_price) . ' Rs.' }}</dd>
            
            
            {{-- <dt  class="col-sm-6">{{\App\CentralLogics\translate('product')}} {{\App\CentralLogics\translate('discount')}} :</dt>
            <dd class="col-sm-6 text-right">- {{round($discount_amount,2) . ' Rs.' }}</dd> --}}
            
            <dt  class="col-sm-6">{{\App\CentralLogics\translate('extra')}} {{\App\CentralLogics\translate('discount')}} :</dt>
            <dd class="col-sm-6 text-right"><button class="btn btn-sm" type="button" data-toggle="modal" data-target="#add-discount"><i class="tio-edit"></i></button>- {{$extra_discount . ' Rs.' }}</dd>
        </dd>
        
        <dt  class="col-sm-6">{{\App\CentralLogics\translate('tax')}} : </dt>
        <dd class="col-sm-6 text-right">{{round($total_tax,2) . ' Rs.'}}</dd>
        
        <dt  class="col-sm-6">{{\App\CentralLogics\translate('total')}} : </dt>
        <dd class="col-sm-6 text-right h4 b">{{round($total+$total_tax, 2) . ' Rs.' }}</dd>
    </dl>
    <div class="row">
        <div class="col-md-6">
            <a href="#" class="btn btn-danger btn-sm btn-block" onclick="emptyCart()"><i
                class="fa fa-times-circle "></i> {{\App\CentralLogics\translate('Cancel')}} </a>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn  btn-primary btn-sm btn-block" data-toggle="modal" data-target="#paymentModal"><i class="fa fa-shopping-bag"></i>
                    {{\App\CentralLogics\translate('Order')}} </button>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="add-discount" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{\App\CentralLogics\translate('update_discount')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.pos.discount')}}" method="post" class="row">
                            @csrf
                            <div class="form-group col-sm-6">
                                <label for="">{{\App\CentralLogics\translate('discount')}}</label>
                                <input type="number" class="form-control" name="discount" value="{{ session()->get('cart1')['extra_discount'] ?? 0 }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">{{\App\CentralLogics\translate('type')}}</label>
                                <select name="type" class="form-control">
                                    <option
                                    value="amount" {{$extra_discount_type=='amount'?'selected':''}}>{{\App\CentralLogics\translate('amount')}}
                                    (Rs.)
                                </option>
                                <option
                                value="percent" {{$extra_discount_type=='percent'?'selected':''}}>{{\App\CentralLogics\translate('percent')}}
                                (%)
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <button class="btn btn-sm btn-primary" type="submit">{{\App\CentralLogics\translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-tax" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CentralLogics\translate('update_tax')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pos.tax')}}" method="POST" class="row">
                    @csrf
                    <div class="form-group col-12">
                        <label for="">{{\App\CentralLogics\translate('tax')}} (%)</label>
                        <input type="number" class="form-control" name="tax" min="0">
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <button class="btn btn-sm btn-primary" type="submit">{{\App\CentralLogics\translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CentralLogics\translate('payment')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pos.order')}}" id='order_place' method="post" class="row">

                    @csrf
                    <div class="form-group col-12">
                        <label class="input-label" for="">amount(Rs.)</label>
                        <input type="number" class="form-control" name="amount" min="0" step="0.01" value="{{round($total+$total_tax, 2)}}" disabled>
                    </div>
                    <div class="form-group col-12">
                        <label class="input-label" for="">{{\App\CentralLogics\translate('type')}}</label>
                        <select name="type" class="form-control">
                            <option value="cash">{{\App\CentralLogics\translate('cash')}}</option>
                            {{-- <option value="card">{{\App\CentralLogics\translate('card')}}</option> --}}
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <button class="btn btn-sm btn-primary" type="submit">{{\App\CentralLogics\translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

