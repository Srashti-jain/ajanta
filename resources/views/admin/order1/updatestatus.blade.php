@extends('admin.layouts.master-soyuz')
@section('title',__("Shipping Item : :order | ",['order' => $inv_cus->prefix$invoice->inv_no$inv_cus->postfix]))
@section('body')

@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Shipping Item ') }}
@endslot

@slot('menu1')
   {{ __('Shipping Item ') }}
@endslot


@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('admin.order.edit',$invoice->order->order_id) }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">
      
      <div class="col-lg-12">

        @if ($errors->any())
          <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></p>
            @endforeach
          </div>
        @endif

        <div class="card m-b-30">
          <div class="card-header">
            <h5 class="box-title">{{ __('Edit') }} {{ __('Invoice Setting') }}</h5>
            @if($invoice->variant)
            {{ __("Shipping Item :") }} {{ $invoice->variant->products->name }} ({{ variantname($invoice->variant) }})  {{ '#'.$inv_cus->prefix.$invoice->inv_no.$inv_cus->postfix }}
        @endif

        @if($invoice->simple_product)
        {{ __("Shipping Item :") }} {{ $invoice->simple_product->product_name }}  {{ '#'.$inv_cus->prefix.$invoice->inv_no.$inv_cus->postfix }}
        @endif
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

                    <input required placeholder="2XXXX50" name="tracking_link" type="text" class="form-control" value="{{ $invoice->tracking_link }}"/>

                </div>

                <div class="form-group col-md-6">
                    <label>
                        {{__("Expected Delivery date:")}} <span class="required">*</span>
                    </label>

                    <input required placeholder="{{ now()->addDays(7)->format('Y-m-d') }}" name="exp_delivery_date" type="text" class="deliverydate form-control default-date" value="{{ $invoice->exp_delivery_date ? date("Y-m-d",strtotime($invoice->exp_delivery_date)) : now()->addDays(7)->format('Y-m-d') }}"/>

                </div>

                <div class="form-group col-12">
                    <button type="submit" class="btn btn-md btn-primary">
                        <i class="fa fa-plane"></i> {{__("Ship")}}
                    </button>
                </div>
                
    
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('custom-script')
    <script>
        $(".deliverydate").datepicker({
            dateFormat: "yy-mm-dd",
            minDate : "{{ date('Y-m-d',strtotime($invoice->created_at)) }}"
        });
    </script>
@endsection