@extends('admin.layouts.sellermastersoyuz')
@section('title',__('Show Return Order Detail # :order',['order' => $inv_cus->order_prefix.$orderid]))
@section('title','Returned Orders |')

@section('body')
@component('admin.component.breadcumb',['secondactive' => 'active'])
  @slot('heading')
    {{ __('Return Orders') }}
  @endslot

  @slot('menu2')
    {{ __("View return order") }}
  @endslot

@endcomponent
<div class="contentbar">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

					<a title="{{ __('Print Slip') }}" onclick="window.print()" class="d-print-none float-right btn btn-md btn-primary-rgba">
                        <i class="fa fa-print"></i>
                    </a>
                    <a title="{{ __('Back') }}" href="{{ url('seller/return/orders') }}" class="d-print-none mr-2 float-right btn btn-md btn-primary-rgba">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    
                    <div class="card-title">
                        
            
                        {{__("Return & Refund Detail for Item :")}}
                        @if(isset($order->getorder->variant))
                            <b>{{ $order->getorder->variant->products->name }} ({{ variantname($order->getorder->variant) }})</b>
                        @endif

                        @if(isset($order->getorder->simple_product))
                            <b>{{  $order->getorder->simple_product->product_name }}</b>
                        @endif
                    </div>
                    
                    
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="margin-15">{{__('Order')}} <b>#{{ $inv_cus->order_prefix.$orderid }}</b>
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <h5 class="margin-15">{{__('TXN ID')}}: <b>{{ $order->txn_id }}</b>
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <h5 class="margin-15">{{ __('Refunded On') }}: <b>{{ date('d-m-Y @ h:i A',strtotime($order->updated_at)) }}</b></h5>
                        </div>
            
                        <div class="col-md-4">
                            <h4 class="margin-15">{{__("Customer Name")}}:
                                <b>{{ ucfirst($order->user->name) }}</b></h4>
                        </div>
            
                        <div class="col-md-4">
                            <h4 class="margin-15">{{__('Refund Method')}} : <b>{{ ucfirst($order->pay_mode) }}</b></h4>
                        </div>
            
                        @if($order->pay_mode == 'bank')
                        <div class="col-md-4">
                            <h4 class="margin-15">{{__('Refunded To')}} {{ ucfirst($order->user->name) }}'s {{__("Bank A/C")}}
                                <b>XXXX{{ substr($order->bank->acno, -4) }}</b></h4>
                        </div>
                        @endif
            
                    </div>
                    <hr>
                    <table class="font-size-14 width100 table table-striped">
                        <thead>
                            <th>
                                {{__("Item")}}
                            </th>
            
                            <th>
                                {{__('Qty.')}}
                            </th>
            
                            <th>
                                {{__('Refunded Amount')}}
                            </th>
            
                            <th>
                                {{__('Additional Info.')}}
                            </th>
                        </thead>
            
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <div class="col-md-11">
                                        @if(isset($order->getorder->variant))
                                                @if($order->getorder->variant->variantimages)
                                                    <img width="100px" class="mr-2 float-left object-fit"
                                                    src="{{url('variantimages/'.$order->getorder->variant->variantimages->mainimage)}}" />
                                                @else
                                                    <img width="100px" class="mr-2 float-left object-fit"
                                                    src="{{ Avatar::create($order->getorder->variant->products->name) }}" />
                                                @endif
                                            @endif
            
                                            @if(isset($order->getorder->simple_product))
                                                <img width="50px" class="mr-2 float-left object-fit" src="{{url('images/simple_products/'.$order->getorder->simple_product->thumbnail)}}" />
                                            @endif
                                        
                                        
                                            
                                            
                                            <p>
                                                @if(isset($order->getorder->variant))
                                                    <b>{{ $order->getorder->variant->products->name }}
                                                        {{ variantname($order->getorder->variant) }}
                                                    </b>
                                                @endif
                
                                                @if(isset($order->getorder->simple_product))
                                                    <b>{{  $order->getorder->simple_product->product_name }}</b>
                                                @endif

                                                <br>
                                                
                                                    @if(isset($order->getorder->simple_product))
                                                    <small>
                                                        <b>{{ __('Sold By') }}:</b> {{$order->getorder->simple_product->store->name}}
                                                    </small>
                                                @endif
                                                @if(isset($order->getorder->variant))
                                                    <small><b>{{ __('Sold By') }}:</b> {{$order->getorder->variant->products->store->name}}</small>
                                                @endif
                                                
                                            </p>
                                            
                                            
            
                                    </div>
                                </td>
                                <td>
                                    {{$order->getorder->qty}}
                                </td>
            
                                <td><b><i class="{{ $order->mainOrder->paid_in }}"></i>{{ $order->amount }} </b><br>
            
                                </td>
            
                                <td>
            
                                    @if($order->txn_fee !='')
                                    <p><b>{{__("Transcation FEE")}}:</b> &nbsp;<i
                                            class="{{ $order->mainOrder->paid_in }}"></i>{{ $order->txn_fee }} ({{__("During Bank Transfer")}})</p>
                                    @endif
            
                                    @if($order->getorder->variant)
                                        @if($order->variant->products->returnPolicy->amount !=0 || $order->variant->products->returnPolicy->amount
                                        !='')
                                        <p>{{__('As per Product')}} {{$order->variant->products->returnPolicy->name}} {{__('Policy')}}
                                            <b>{{$order->variant->products->returnPolicy->amount}}%</b> {{ __('is deducted from Order Amount.') }}</p>
                                        @endif
                                    @endif
            
                                    @if(isset($order->getorder->simple_product))
                                        @if($order->getorder->simple_product->returnPolicy->amount !=0 || $order->getorder->simple_product->returnPolicy->amount
                                        !='')
                                        <p>{{__('As per Product')}} {{$order->getorder->simple_product->returnPolicy->name}}  {{__('Policy')}}
                                            <b>{{$order->getorder->simple_product->returnPolicy->amount}}%</b> {{ __('is deducted from Order Amount.') }}</p>
                                        @endif
                                    @endif
            
                                </td>
            
            
            
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
