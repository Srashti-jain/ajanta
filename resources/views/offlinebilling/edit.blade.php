@extends('admin.layouts.master-soyuz')
@section('title',__('Edit order # :order',['order' => $order->order_id]))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])


@slot('heading')
{{ __('Inhouse Orders') }}
@endslot

@slot('menu1')
{{ 'Edit order #'.$order->order_id }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        <a href="{{ route('offline-orders.index') }}" class="btn btn-primary-rgba mr-2">
            <i class="feather icon-arrow-left mr-2"></i> {{__("Back")}}
        </a>
    </div>
</div>
@endslot
@endcomponent
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12 m-b-30">
                <form action="{{ route('offline-orders.update',$order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Customer Details') }}
                            </h3>
                        </div>
                
                        <div class="card-body">
                            <div class="row">
                
                                <div class="col-md-3">
                                  
                                  <label>
                                    {{__("Invoice Date:")}}
                                  </label>
                                  <div class='input-group date' id='datetimepicker1'>
                                    <input placeholder="{{ __('Enter invoice date') }}" value="{{ $order['invoice_date'] ?? old('invoice_date') }}" name="invoice_date" type='text' class="form-control" />
                                    <span class="input-group-text">
                                        <span class="feather icon-calendar"></span>
                                    </span>
                                  </div>
                
                                </div>
                
                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my-input">{{ __('Customer Name') }}: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="feather icon-user" aria-hidden="true"></i>
                                            </span>
                                            <input id="customer_search" value="{{ $order['customer_name'] }}" required id="my-input"
                                                class="form-control" type="text" name="customer_name" placeholder="{{ __('eg: John doe') }}">
                                            <input type="hidden" value="{{ $order['customer_id'] }}" name="customer_id" id="customer_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my-input">{{__('Customer email')}}: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="feather icon-at-sign" aria-hidden="true"></i>
                                            </span>
                                            <input value="{{ $order['customer_email'] }}" required id="my-input"
                                                class="form-control customer_email" type="email" name="customer_email"
                                                placeholder="eg: john@example.com">
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my-input">{{__('Customer Contact No')}}: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                
                                            <span class="input-group-text" id="basic-addon1">
                
                                                <i class="feather icon-phone" aria-hidden="true"></i>
                
                                            </span>
                
                
                                            <input maxlength="10" value="{{ $order['customer_phone'] }}" required pattern="[0-9]+" required id="my-input"
                                                class="form-control customer_phone" type="text" name="customer_phone"
                                                placeholder="eg: 12345678980">
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="my-input">{{__('Customer Shipping Address')}}: <span class="text-danger">*</span></label>
                                        <textarea placeholder="B-123, Los Street, Washington DC, USA" required
                                            class="form-control customer_shipping_address" name="customer_shipping_address" id=""
                                            cols="30" rows="5">{{ $order['customer_shipping_address'] }}</textarea>
                
                                    </div>
                                </div>
                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="my-input">{{__('Customer Billing Address')}}: <span class="text-danger">*</span></label>
                                        <textarea placeholder="B-123, Los Street, Washington DC, USA" required
                                            class="form-control customer_billing_address" name="customer_billing_address" id=""
                                            cols="30" rows="5">{{ $order['customer_billing_address'] }}</textarea>
                                        <label class="text-muted"><input {{ $order['customer_billing_address'] == $order['customer_shipping_address'] ? 'checked' : '' }} type="checkbox" id="same_as_shipping" name="same_as_shipping">
                                            {{ __('Same as Shipping address') }}</label>
                                    </div>
                                </div>
                
                                <div class="col-md-3">
                
                                    <label class="control-label" for="">
                                        {{__('Country')}}: 
                                    </label>
                     
                                    <select onchange="getstate();" data-placeholder="{{ __("Please select country") }}" required name="country_id" class="form-control select2 country_id" id="country_id">
                                         <option value="">{{ __('Please Choose') }}</option>
                                           @foreach($country as $c)
                                           <?php
                                             $iso3 = $c->country;
                     
                                             $country_name = DB::table('allcountry')->
                                             where('iso3',$iso3)->first();
                     
                                              ?>
                                           <option {{ $order['country_id'] == $country_name->id ? "selected" : "" }} value="{{$country_name->id}}">
                                             {{$country_name->nicename}}
                                           </option>
                                           @endforeach
                                    </select>
                     
                                 </div>
                
                                <div class="col-md-3">
                              
                                    <label class="control-label" for="">
                                        {{__('State')}}: 
                                    </label>
                      
                                    <select onchange="getcity();" data-placeholder="{{ __("Please select state") }}" required name="state_id" class="form-control select2 state_id" id="upload_id" >
                                      <option value="">{{ __('Please Choose') }}</option>
                                      @foreach($order->country->states as $state)
                                        <option {{ $state->id == $order['state_id'] ? "selected" : "" }} value="{{ $state->id }}">{{ $state['name'] }}</option>
                                      @endforeach
                                    </select>
                      
                                </div>
                
                                <div class="col-md-3">
                                    
                                     <label class="control-label" for="">
                                            {{__('City')}}: 
                                    </label>
                      
                                <select data-placeholder="{{ __("Please select city") }}" required name="city_id" id="city_id" class="form-control select2 city_id">
                                        <option value="">Please Choose</option>
                                        @foreach($order->states->city as $city)
                                        <option {{ $city->id == $order['city_id'] ? "selected" : "" }} value="{{ $city->id }}">{{ $city['name'] }}</option>
                                      @endforeach
                                </select>
                      
                                </div>
                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="my-input">{{__('Pincode')}}: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                
                                            </span>
                                            <input required placeholder="eg:101011" type="text" class="form-control customer_pincode"
                                                name="customer_pincode" value="{{ $order['customer_pincode'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Payment & Shipping:') }}
                            </h3>
                
                
                        </div>
                
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            {{ __('Payment Method:') }} <span class="text-danger">*</span>
                                        </label>
                                        <input value="{{ $order['payment_method'] }}" required name="payment_method" type="text" class="form-control"
                                            placeholder="{{ __('eg:Cash on delivery') }}">
                                    </div>
                                </div>
                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">
                                        {{ __('Order ID:') }}
                                        </label>
                                    <input name="order_id" type="text" class="form-control" value="{{ $order['order_id'] }}" placeholder="eg:NND7456789">
                                   
                                </div>
                                </div>
                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">
                                            {{ __('Shipping Method:') }} <span class="text-danger">*</span>
                                        </label>
                                    <input value="{{ $order['shipping_method'] }}" required name="shipping_method" type="text" class="form-control" placeholder="Fedex">
                                    </div>
                                </div>
                
                               
                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                    {{ __('Shipping Rate:') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    
                                    <input value="{{ $order['shipping_rate'] }}" required name="shipping_rate" type="number" min="0" step="0.01"
                                        class="form-control shipping_rate" placeholder="eg: 40">
                                    <span class="input-group-text" id="basic-addon1">
                
                                        <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                
                                    </span>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                {{ __('Transcation ID:') }} </small>
                                </label>
                            <input value="{{ $order['txn_id'] }}" required name="txn_id" type="text" class="form-control" placeholder="eg: NND7405">
                            <label class="text-muted"><input {{ $order['order_id'] == $order['txn_id'] ? "checked" : "" }} type="checkbox" name="txn_same_as_orderid"> {{ __('Same as Order ID') }}</label>
                            </div>
                        </div>
                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">
                                    {{ __('Order Status:') }} <span class="text-danger">*</span>
                                </label>
                                <select name="order_status" id="" class="form-control select2">
                                    <option {{ $order['order_status'] == 'pending' ? "selected" : "" }} value="pending">{{ __('Pending') }}</option>
                                    <option {{ $order['order_status'] == 'processed' ? "selected" : "" }} value="processed">{{ __('Processed') }}</option>
                                    <option {{ $order['order_status'] == 'packed' ? "selected" : "" }} value="packed">{{ __('Packed') }}</option>
                                    <option {{ $order['order_status'] == 'shipped' ? "selected" : "" }} value="shipped">{{ __('Shipped') }}</option>
                                    <option {{ $order['order_status'] == 'in_transit' ? "selected" : "" }} value="in_transit">{{ __('In Transit') }}</option>
                                    <option {{ $order['order_status'] == 'out_for_delivery' ? "selected" : "" }} value="out_for_delivery">{{ __('Out for Delivery') }}</option>
                                    <option {{ $order['order_status'] == 'delivered' ? "selected" : "" }} value="delivered">{{ __('Delivered') }}</option>
                                </select>
                            </div>
                        </div>
                
                    </div>
                    </div>
                    </div>
                    <div style="display: none;" class="errorzone fadein alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <p class="errorMessage">
                        </p>
                    </div>
                    <div class="card orderDetails" tabindex="1">
                        <div class="card-header">
                            <div class="float-right">
                                <label class="badge badge-success"> {{__('USE')}} <b><u>Ctrl+D</u></b> {{ __('to quickly add a new row.') }}</label> |
                                <label class="badge badge-danger"> {{__('USE')}} <b><u>Ctrl+E</u></b> {{ __('to quickly remove a row.') }}</label>
                            </div>
                            
                            <h3 class="card-title">
                                {{ __('Order Details') }}
                            </h3>
                
                            
                        </div>
                
                        <div class="card-body">
                            <table class="myTable table table-bordered">
                                <tbody>
                
                                    <tr>
                                        <th>
                                            {{__('Name of product')}}
                                        </th>
                                        <th>
                                            {{__('Price:')}}
                                        </th>
                                        <th>
                                           {{__('Qty.')}}
                                        </th>
                                        <th>
                                            {{__('Origin')}}
                                        </th>
                                        <th>
                                            {{__('Total')}}
                                        </th>
                                        <th>
                
                                        </th>
                                    </tr>
                
                                    <tr id="tableBody" class="tbody">
                                        @foreach($order->orderItems as $orderitem)
                                        <td>
                                        <input value="{{ $orderitem['product_name'] }}" required type="text" class="form-control product_name" name="product_name[]"
                                                placeholder="{{ __('eg:Ring (Gold)') }}">
                                        </td>
                
                                        <td>
                                            <div class="input-group">
                                                <input required value="{{ $orderitem['product_price'] }}" type="text" class="form-control product_price" name="product_price[]"
                                                    placeholder="5000">
                                                <span class="input-group-text" id="basic-addon1">
                
                                                    <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                
                                                </span>
                                            </div>
                                        </td>
                
                                        <td>
                
                                            <input value="{{ $orderitem['product_qty'] }}" required placeholder="1" type="number" class="form-control product_qty" name="product_qty[]"
                                                min="1">
                
                                        </td>
                
                                        <td>
                
                                            <input placeholder="{{ __('eg: India') }}" required type="text" class="form-control product_origin" name="origin[]"
                                        min="1" value="{{ $orderitem['origin'] }}">
                
                                        </td>
                
                                        <td>
                                            <div class="input-group">
                
                                            <input value="{{ $orderitem['product_total'] }}" required readonly type="text" class="form-control product_total" name="product_total[]"
                                                    placeholder="5000">
                                                <span class="input-group-text" id="basic-addon1">
                
                                                    <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                
                                                </span>
                                            </div>
                                        </td>
                                        @if($loop->last)
                                        <td>
                                            <button title="{{ __('Add new') }}" type="button" class="addNew btn btn-primary-rgba rounded btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                
                                        <td>
                                            <button title="{{ __('Remove') }}" type="button" class="removeBtn btn btn-danger-rgba rounded btn-sm">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- -->

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mt-2 text-muted">
                                        <i class="fa fa-info-circle"></i>
                                        {{ __('Please check all the information and total before updating order') }}
                                    </p>
                                    <p class="text-muted">
                                        <label>
                                           <input class="tax_include" {{ $order->tax_include == 1 ? "checked" : "" }} type="checkbox" name="tax_include"> {{ __('All taxes are included in price') }}
                                        </label>
                                        
                                    </p>
                                    <label>{{ __('Additional Note:') }}</label>
                                    <textarea class="form-control" placeholder="{{ __("Any additional order note") }}" name="additional_note" id="additional_note" cols="50" rows="5">{{ $order['additional_note'] }}</textarea>
                                    <br>
                                    <button type="submit" class="btn btn-md btn-success-rgba">
                                        <i class="feather icon-save"></i> {{ __('Update Order') }}
                                    </button>
                        
                                <a href="{{ route('offline-orders.index') }}" role="submit" class="btn btn-md btn-danger-rgba">
                                        <i class="feather icon-x-circle"></i> {{ __('Cancel') }}
                                    </a>
                                </div>
                                <div class="offset-md-2 col-md-4">
                                    <div class="bg-primary-rgba card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>
                                                        <b>{{ __('Subtotal') }}</b> :
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input readonly type="text" class="form-control final_subtotal" value="{{ $order['subtotal'] }}"
                                                                name="subtotal">
                                                            <span class="input-group-text" id="basic-addon1">
                        
                                                                <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                        
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>{{ __('Shipping') }}</b> :
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input readonly type="text" class="form-control total_shipping" value="{{ $order['total_shipping'] }}"
                                                                name="total_shipping">
                                                            <span class="input-group-text" id="basic-addon1">
                        
                                                                <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                        
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>{{ __('Tax') }}</b> :
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                        <input type="number" class="form-control total_tax_percent" value="{{ $order['tax_rate'] }}" name="tax_rate"/>
                                                                
                                                        <input type="hidden" class="form-control total_tax_amount" value="{{ $order['total_tax'] }}"
                                                                name="total_tax"/>
                                                                <span class="input-group-text" id="basic-addon1">
                        
                                                                    %
                        
                                                                </span>
                                                        </div>
                                                    <small class="text-muted">{{__('Tax In RuppesTax In Ruppes')}} : <span class="tax_in_rupees">{{ $order['total_tax'] }}</span> <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i></small>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>{{ __('Adjustable Amount') }}</b> :
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input min="0" step="0.01" type="number" class="form-control adjustable_amount" value="{{ $order['adjustable_amount'] ?? 0 }}" name="adjustable_amount">
                                                            <span class="input-group-text" id="basic-addon1">
                        
                                                                <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                        
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>{{ __('Grand Total') }}</b> :
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input readonly type="text" class="form-control grand_total" value="{{ sprintf("%.2f",$order['grand_total']) }}" name="grand_total">
                                                            <span class="input-group-text" id="basic-addon1">
                        
                                                                <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                        
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                        </div>
                    </div>
                
                    
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom-script')
<script>
    var url = @json(route('offline.customer.search'));
    var baseurl = @json(url('/'));
    var productsearch = @json(route('offline.product.search'));
</script>
<script>
    $(document).ready(function(){
        $(".product_name").each(function(index) {
            enableAutoComplete($(this));
        });
    });
</script>
<script src="{{ url('js/offlineorder.js') }}"></script>
@endsection