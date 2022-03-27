@extends("admin.layouts.sellermastersoyuz")
@section('title',__('Shipping Item - :invno',['invno' => $inv_cus->prefix$invoice->inv_no$inv_cus->postfix]))
@section('body')

@component('seller.components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Shipping Item ') }}
@endslot
@slot('menu1')
   {{ __('Shipping Item ') }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a  href="{{ route('admin.order.edit',$invoice->order->order_id) }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot


@endcomponent

<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">@if($invoice->variant)
                        {{ __("Shipping Item :") }} {{ $invoice->variant->products->name }} ({{ variantname($invoice->variant) }})  {{ '#'.$inv_cus->prefix.$invoice->inv_no.$inv_cus->postfix }}
                    @endif

                    @if($invoice->simple_product)
                    {{ __("Shipping Item :") }} {{ $invoice->simple_product->product_name }}  {{ '#'.$inv_cus->prefix.$invoice->inv_no.$inv_cus->postfix }}
                    @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route("ship.item",$invoice->id) }}" method="POST">
                        @csrf
                        <div class="row">

                        
                        <div class="form-group col-md-6">
                            
                            <label>
                                {{__("Courier Channel:")}} <span class="required">*</span>
                            </label>
                            <input required placeholder="DHL" name="courier_channel" type="text" class="form-control" value="{{ $invoice->courier_channel }}"/>
                               
                        </div>

                        <div class="form-group col-md-6">
                            <label>
                                {{__("Courier tracking link OR Consignment No:")}} <span class="required">*</span>
                            </label>

                            <input required placeholder="2132500" name="tracking_link" type="text" class="form-control" value="{{ $invoice->tracking_link }}"/>

                        </div>

                        <div class="form-group col-md-6">
                            <label>
                                {{__("Expected Delivery date:")}} <span class="required">*</span>
                            </label>

                            <div class="input-group">
                                <input type="text" class="form-control"  id="default-date" name="exp_delivery_date" required placeholder="{{ now()->addDays(7)->format('d-M-Y') }}" aria-describedby="basic-addon5" value="{{ $invoice->exp_delivery_date ? date("Y-m-d",strtotime($invoice->exp_delivery_date)) : '' }}"/>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
 

                        </div>

                        <div class="form-group col-md-12">
                            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary"><i class="feather icon-truck mr-2"></i>
                                {{__("Ship")}}</button>
                            
                           
                        </div>
                    </div>
            
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
