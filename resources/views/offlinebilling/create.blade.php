@extends('admin.layouts.master-soyuz')
@section('title',__('Create Order'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])


@slot('heading')
{{ __('Inhouse Orders') }}
@endslot

@slot('menu1')
{{ __('Create Order') }}
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

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                @foreach($errors->all() as $error)
                    <p>{{ $error}}</p>
                @endforeach
                </div>
            @endif

            <form action="{{ route('offline-orders.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ __('Customer Details') }}
                        </h4>
                    </div>
            
                    <div class="card-body">
                        <div class="row">
            
                            <div class="col-md-3">
                              
                              <div class="form-group">
                                  <label>
                                    {{__("Invoice Date: ")}}
                                  </label>
                                  <div class='input-group date'>
                                    <input id='default-date' placeholder="{{ __("Enter invoice date") }}" value="{{ old('invoice_date') }}" name="invoice_date" type='text' class="form-control" />
                                    <span class="input-group-text">
                                      <span class="feather icon-calendar"></span>
                                    </span>
                                  </div>
                                 
                              </div>
            
                             
            
                            </div>
            
            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="my-input">{{__("Customer Name:")}} <span class="text-danger">*</span></label>
                                    <div class="input-group">
            
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="feather icon-user" aria-hidden="true"></i>
                                        </span>
                                        <input id="customer_search" value="{{ old('customer_name') }}" required id="my-input"
                                            class="form-control" type="text" name="customer_name" placeholder="eg: John doe">
                                        <input type="hidden" name="customer_id" id="customer_id">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="my-input">{{__("Customer email:")}} <span class="text-danger">*</span></label>
                                    <div class="input-group">
            
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="feather icon-at-sign" aria-hidden="true"></i>
                                        </span>
                                        <input value="{{ old('customer_email') }}" required id="my-input"
                                            class="form-control customer_email" type="email" name="customer_email"
                                            placeholder="eg: john@example.com">
                                    </div>
                                </div>
                            </div>
            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="my-input">{{__("Customer Contact No:")}} <span class="text-danger">*</span></label>
                                    <div class="input-group">
            
                                        <span class="input-group-text" id="basic-addon1">
            
                                            <i class="feather icon-phone" aria-hidden="true"></i>
            
                                        </span>
            
            
                                        <input maxlength="10" value="{{ old('customer_phone') }}" required pattern="[0-9]+" required id="my-input" class="form-control customer_phone" type="text" name="customer_phone"
                                            placeholder="eg: 12345678980">
                                    </div>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="my-input">{{__("Customer Shipping Address:")}} <span class="text-danger">*</span></label>
                                    <textarea placeholder="{{ __("B-123, Los Street, Washington DC, USA") }}" required
                                        class="form-control customer_shipping_address" name="customer_shipping_address" id=""
                                        cols="30" rows="5">{{ old('customer_shipping_address') }}</textarea>
                                        <label class="text-muted"><input checked {{ old('mark_as_default') ? 'checked' : '' }} type="checkbox" id="same_as_shipping" name="mark_as_default">
                                            {{ __('Mark as default address') }}</label>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="my-input">{{__("Customer Billing Address:")}} <span class="text-danger">*</span></label>
                                    <textarea placeholder="{{ __("B-123, Los Street, Washington DC, USA") }}" required
                                        class="form-control customer_billing_address" name="customer_billing_address" id=""
                                        cols="30" rows="5">{{ old('customer_billing_address') }}</textarea>
                                    <label class="text-muted"><input checked {{ old('same_as_shipping') ? 'checked' : '' }} type="checkbox" id="same_as_shipping" name="same_as_shipping">
                                        {{ __('Same as Shipping address') }}</label>
                                </div>
                            </div>
            
                            <div class="col-md-3">
            
                                <label class="control-label" for="">
                                    {{__("Country: ")}}
                                </label>
                 
                                <select onchange="getstate();" data-placeholder="{{ __("Please select country") }}" required name="country_id" class="form-control select2 country_id" id="country_id">
                                     <option value="">{{ __('Please Choose') }}</option>
                                       @foreach($country as $c)
                                       <?php
                                         $iso3 = $c->country;
                 
                                         $country_name = DB::table('allcountry')->
                                         where('iso3',$iso3)->first();
                 
                                          ?>
                                       <option value="{{$country_name->id}}">
                                         {{$country_name->nicename}}
                                       </option>
                                       @endforeach
                                </select>
                 
                             </div>
            
                            <div class="col-md-3">
                          
                                <label class="control-label" for="">
                                    {{__("State: ")}}
                                </label>
                  
                                <select onchange="getcity();" data-placeholder="{{ __("Please select state") }}" required name="state_id" class="form-control select2 state_id" id="upload_id" >
                                  <option value="">{{ __('Please Choose') }}</option>
                                </select>
                  
                            </div>
            
                            <div class="col-md-3">
                                
                                 <label class="control-label" for="">
                                        City: 
                                </label>
                  
                            <select data-placeholder="{{ __("Please select city") }}" required name="city_id" id="city_id" class="form-control select2 city_id">
                                    <option value="">{{ __('Please Choose') }}</option>
                            </select>
                  
                            </div>
            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="my-input">{{__("Pincode:")}} <span class="text-danger">*</span></label>
                                    <div class="input-group">
            
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="feather icon-map-pin" aria-hidden="true"></i>
            
                                        </span>
                                        <input required placeholder="eg:101011" type="text" class="form-control customer_pincode"
                                            name="customer_pincode" value="{{ old('customer_pincode') }}">
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
                                    <input value="{{ old('payment_method') ?? 'Online' }}" required name="payment_method" type="text" class="form-control"
                                        placeholder="{{ __("eg:Cash on delivery") }}">
                                </div>
                            </div>
            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">
                                    {{ __('Order ID:') }} <small class="text-muted">{{ __('(You can leave it blank for auto generation.)') }}</small>
                                    </label>
                                    <input value="{{ old('order_id') }}" name="order_id" type="text" class="form-control" placeholder="eg:NND7456789">
                                    
                                </div>
                            </div>
            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">
                                        {{ __('Shipping Method:') }} <span class="text-danger">*</span>
                                    </label>
                                <input value="{{ old('shipping_method') ?? 'Shiprocket' }}" required name="shipping_method" type="text" class="form-control" placeholder="Fedex">
            
                                
                                </div>
                            </div>
            
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">
                                {{ __('Shipping Rate:') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                
                                <input value="{{ old('shipping_rate') ?? 0 }}" required name="shipping_rate" type="number" min="0" step="0.01"
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
                            {{ __('Transcation ID:') }} <small class="text-muted">{{ __('(Leave blank for update later)') }}</small>
                            </label>
                        <input value="{{ old('txn_id') }}" required name="txn_id" type="text" class="form-control" placeholder="eg: NND7405">
                        <label class="text-muted"><input checked type="checkbox" name="txn_same_as_orderid"> Same as Order ID</label>
                        </div>
                    </div>
            
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">
                                {{ __('Order Status:') }} <span class="text-danger">*</span>
                            </label>
                            <select name="order_status" id="" class="form-control select2">
                                <option value="pending">
                                    {{__("Pending")}}
                                </option>
                                <option value="processed">
                                    {{__("Processed")}}
                                </option>
                                <option value="packed">
                                    {{__("Packed")}}
                                </option>
                                <option value="shipped">
                                    {{__("Shipped")}}
                                </option>
                                <option value="in_transit">
                                    {{__("In Transit")}}
                                </option>
                                <option value="out_for_delivery">
                                    {{__('Out for Delivery')}}
                                </option>
                                <option selected value="delivered">
                                    {{__("Delivered")}}
                                </option>
                            </select>
                        </div>
                    </div>
            
                </div>
                </div>
                </div>
                <div style="display: none;" class="mt-2 errorzone fadein alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="errorMessage">
                    </span>
                </div>
                <div class="card orderDetails" tabindex="1">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ __('Order Details') }}
                        </h3>
            
                        <div class="float-right">
                            <label class="badge badge-success"> {{__("USE")}} <b><u>Ctrl+D</u></b> {{__('to quickly add a new row.')}}</label> |
                            <label class="badge badge-danger"> {{__("USE")}} <b><u>Ctrl+E</u></b> {{ __("to quickly remove a row.") }}</label>
                        </div>
                    </div>
            
                    <div class="card-body">
                        <table class="myTable table table-bordered">
                            <tbody>
            
                                <tr>
                                    <th>
                                        {{__("Name of product")}}
                                    </th>
                                    <th>
                                        {{__("Price:")}}
                                    </th>
                                    <th>
                                        {{__("Origin.")}}
                                    </th>
                                    <th>
                                        {{__("Qty.")}}
                                    </th>
                                    <th>
                                        {{__("Total")}}
                                    </th>
                                    <th>
            
                                    </th>
                                </tr>
                                @if(!old('product_name'))
                                    <tr id="tableBody" class="tbody">
                                        <td>
                                            <input required type="text" class="form-control product_name" name="product_name[]"
                                                placeholder="eg:Ring (Gold)">
                                        </td>
                
                                        <td>
                                            <div class="input-group">
                                                <input required value="" type="text" class="form-control product_price" name="product_price[]"
                                                    placeholder="5000">
                                                <span class="input-group-text" id="basic-addon1">
                
                                                    <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                
                                                </span>
                                            </div>
                                        </td>
                
                                        <td>
                
                                            <input value="India" placeholder="eg: India" required type="text" class="form-control product_origin" name="origin[]"
                                                min="1">
                
                                        </td>
                
                                        <td>
                
                                            <input value="1" required placeholder="1" type="number" class="form-control product_qty" name="product_qty[]"
                                                min="1">
                
                                        </td>
                
                                        <td>
                                            <div class="input-group">
                
                                                <input required readonly type="text" class="form-control product_total" name="product_total[]"
                                                    placeholder="5000">
                                                <span class="input-group-text" id="basic-addon1">
                
                                                    <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                
                                                </span>
                                            </div>
                                        </td>
                
                                        <td>
                                            <button title="{{ __("Add new") }}" type="button" class="addNew btn btn-primary-rgba rounded btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                
                                        <td>
                                            <button title="{{ __("Remove") }}" type="button" class="removeBtn btn btn-danger-rgba rounded btn-sm">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @else
                                    @foreach(old('product_name') as $key => $item)
                                   
                                        <tr id="tableBody" class="tbody">
                                            <td>
                                                <input required type="text" class="form-control product_name" value="{{ $item }}" name="product_name[]"
                                                    placeholder="eg:Ring (Gold)">
                                            </td>
                    
                                            <td>
                                                <div class="input-group">
                                                    <input required value="{{ old('product_price')[$key] }}" type="text" class="form-control product_price" name="product_price[]"
                                                        placeholder="5000">
                                                    <span class="input-group-text" id="basic-addon1">
                    
                                                        <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                    
                                                    </span>
                                                </div>
                                            </td>
                    
                                            <td>
                    
                                                <input placeholder="eg: India" required type="text" class="form-control product_origin" value="{{ old('origin')[$key] }}" name="origin[]"
                                                    min="1">
                    
                                            </td>
                    
                                            <td>
                    
                                                <input required placeholder="1" type="number" class="form-control product_qty" value="{{ old('product_qty')[$key] }}" name="product_qty[]"
                                                    min="1">
                    
                                            </td>
                    
                                            <td>
                                                <div class="input-group">
                    
                                                    <input required readonly type="text" class="form-control product_total"  value="{{ old('product_total')[$key] }}" name="product_total[]" placeholder="5000">
                                                    <span class="input-group-text" id="basic-addon1">
                    
                                                        <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i>
                    
                                                    </span>
                                                </div>
                                            </td>
                    
                                            <td>
                                                <button title="{{ __("Add new") }}" type="button" class="addNew btn btn-primary-rgba rounded btn-sm">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                    
                                            <td>
                                                <button title="{{ __("Remove") }}" type="button" class="removeBtn btn btn-danger-rgba rounded btn-sm">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                        <!-- -->
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mt-2 text-muted">
                                    <i class="fa fa-info-circle"></i>
                                    {{ __('Please check all the information and total before creating order') }}
                                </p>
                    
                                <p class="text-muted">
                                    <label>
                                        <input checked type="checkbox" name="tax_include" class="tax_include">
                                        {{ __('All prices are inclusive of the tax') }}
                                    </label>
                                    
                                </p>
                    
                                <label>{{ __('Additional Note:') }}</label>
                                <textarea class="form-control" placeholder="{{ __("Any additional order note") }}" name="additional_note" id="additional_note" cols="50" rows="5">{{ old('additional_note') }}</textarea>
                                <br>
                                <button type="submit" class="btn btn-md btn-success">
                                    <i class="fa fa-plus-circle"></i> {{ __('Create Order') }}
                                </button>
                            </div>
                            <div class="offset-md-2 col-md-4">
                                <div class="card bg-primary-rgba">
                                    <div class="card-body">
                                        <table id="productTablePOS" class="table table-bordered">
                                            <tr>
                                                <td>
                                                    <b>{{ __('Subtotal') }}</b> :
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input readonly type="text" class="form-control final_subtotal" value="{{ old('subtotal') ?? 0.00 }}
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
                                                        <input readonly type="text" class="form-control total_shipping" value="{{ old('total_shipping') ?? 0.00 }}"
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
                                                        <input type="number" class="form-control total_tax_percent" value="{{ old('tax_rate') ?? 0 }}"
                                                            name="tax_rate"/>
                                                            
                                                            <input type="hidden" class="form-control total_tax_amount" value="0"
                                                            name="total_tax"/>
                                                            <span class="input-group-text" id="basic-addon1">
                    
                                                                %
                    
                                                            </span>
                                                    </div>
                                                    <small class="text-muted">Tax In Ruppes : <span class="tax_in_rupees">{{ old('total_tax_amount') ?? 0 }}</span> <i class="{{ $defCurrency->currency_symbol }}" aria-hidden="true"></i></small>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td>
                                                    <b>{{ __('Adjustable Amount') }}</b> :
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input min="0" step="0.01" type="number" class="form-control adjustable_amount" value="{{ old('adjustable_amount') ?? 0.00}}" name="adjustable_amount">
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
                                                        <input readonly type="text" class="form-control grand_total" value="{{ old('grand_total') ?? 0.00 }}" name="grand_total">
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