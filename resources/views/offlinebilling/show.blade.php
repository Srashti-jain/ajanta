@extends('admin.layouts.master-soyuz')
@section('title',__('Viw order # :order | ',['order' => $order->order_id]))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])


@slot('heading')
{{ __('Inhouse Orders') }}
@endslot

@slot('menu1')
{{ __('View Order') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        <a href="{{ route('offline-orders.index') }}" class="btn btn-primary-rgba">
            <i class="feather icon-arrow-left mr-2"></i> {{__("Back")}}
        </a>
    </div>
</div>
@endslot
@endcomponent
    <div class="contentbar">
        <div class="card mb-5">
            <div class="card-header">
                <h3 class="card-title">
                    {{ __("View Order")}} #{{ $order->order_id }}
                </h3>
            </div>
        
                <div class="card-body">
                    <!-- Content Header (Page header) -->
        
                        <h4>
                            {{__('Order Status')}} : 
                            <span title="{{ ucfirst(str_replace('_',' ',$order->order_status)) }}" class="badge badge-success">{{ ucfirst(str_replace('_',' ',$order->order_status)) }}</span>
                        </h4>
                        <hr>
                        <h3>
                            {{__('Invoice')}}
                            <small>#{{ $order->order_id }}</small>
                        </h3>
        
                    
                    <hr>
                    <!-- Main content -->
                    <section class="invoice">
                        
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-md-4 invoice-col">
                                {{__('From')}}
                                <address>
                                    <strong>{{ $store->name }}</strong><br>
                                    {{$store->address}}<br>
                                    {{ $store->city['name'] }},{{ $store->state['name'] }},{{ $store->country['nicename'] }}<br>
                                    {{ $store->pin_code }} <br>
                                    {{__('Phone')}}: {{ $store->mobile }}<br>
                                    {{__('Email')}}: {{ $store->email }}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4 invoice-col">
                                {{__('To')}}
                                <address>
                                    <strong>{{ $order->customer_name }}</strong><br>
                                    {{ $order->customer_shipping_address }}<br>
                                    {{ $order->cities['name'] }},{{ $order->states['name'] }},{{ $order->country['nicename'] }}<br>
                                    {{ $order->customer_pincode }} <br>
                                    {{__('Phone')}}: {{ $order->customer_phone }}<br>
                                    {{__('Email')}}: {{ $order->customer_email }}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4 invoice-col">
                                <b>{{__('Date')}}: {{ date('d/m/Y',strtotime($order->invoice_date)) }}</b>
                                <br>
                                <b>{{__('Order ID')}}:</b> {{ $order->order_id }}<br>
                                <b>{{__('Payment Method')}}:</b> {{ $order->payment_method }}<br>
        
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
        
                        <!-- Table row -->
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Product') }}</th>
                                            <th>{{ __('Gross Price') }}</th>
                                            <th>{{ __('Qty.') }}</th>
                                            <th>{{ __('Tax') }}</th>
                                            <th>{{ __('Subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($order->orderItems))
                                        @foreach($order->orderItems as $key => $item)
        
                                        <tr>
                                            <td> {{ $key+1 }}</td>
                                            <td> {{ $item['product_name'] }} 
                                            <br> <small>Origin : {{ $item['origin'] ?? '-' }}</small>
                                            </td>
                                            <td> {{ sprintf("%.2f",($item['product_price']*$item['product_qty'])) }} <i class="fa {{ $defCurrency->currency_symbol }}"></i></td>
                                            <td> {{ $item['product_qty'] }} </td>
                                            <td> {{ sprintf("%.2f",$item['product_tax']) }} <i class="fa {{ $defCurrency->currency_symbol }}"></i></td>
                                            <td> {{ sprintf("%.2f",$item['product_total']) }} <i class="fa {{ $defCurrency->currency_symbol }}"></i></td>
                                        </tr>
        
                                        @endforeach
                                        @else
        
                                        <tr>
                                            
                                            <td colspan="4">{{__('No items found in this order !') }}</td>
                                            
                                        </tr>
        
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
        
                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-md-6">
                                
        
                               
                                    <div class="card border mt-2">
                                        <div class="card-body">

                                            <p class="lead text-dark">{{ __('Payment Methods') }}:</p>
                                            <blockquote>{{ $order->payment_method }}</blockquote>
                                            @if($order['additional_note'] != NULL)
                                                <p class="lead text-dark">{{ __('Addtional Note') }}:</p>
                                            {!! $order['additional_note'] !!}
                                            @endif
                                        </div>
                                    </div>
                                
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                
        
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">{{ __('Subtotal') }}:</th>
                                            <td>{{ sprintf('%.2f',$order['subtotal']) }}<i class="fa {{ $defCurrency->currency_symbol }}"></i></td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Tax') }}:</th>
                                            <td>
                                                {{ sprintf('%.2f',$order['total_tax']) }}<i class="fa {{ $defCurrency->currency_symbol }}"></i> ({{ $order['tax_rate'] }}%)
                                                <br>
                                                @if($store->state['id'] != $order->states['id'])
                                                
                                                <small>({{ __('IGST') }}) {{ sprintf('%.2f',$order['total_tax']) }}<i class="fa {{ $defCurrency->currency_symbol }}"></i> ({{ $order['tax_rate'] }}%) </small>
                                                <br>
                                                @endif
                                                @if($store->state['id'] == $order->states['id'])
                                                <small>({{ __('SGST') }}) {{ sprintf('%.2f',$order['total_tax']/2) }}<i class="fa {{ $defCurrency->currency_symbol }}"></i> ({{ sprintf("%.2f",$order['tax_rate']/2) }}%) </small>
                                                <br>
                                                <small>({{ __('CGST') }}) {{ sprintf('%.2f',$order['total_tax']/2) }}<i class="fa {{ $defCurrency->currency_symbol }}"></i> ({{ sprintf("%.2f",$order['tax_rate']/2) }}%) </small>
                                                <br>
                                                
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Shipping') }}:</th>
                                            <td>{{ sprintf('%.2f',$order['total_shipping']) }} <i class="fa {{ $defCurrency->currency_symbol }}"></i></td>
                                        </tr>
                                        <tr>
                                            <th>{{__('Adjustable Amount')}}:</th>
                                            <td>{{ sprintf('%.2f',$order['adjustable_amount']) }} <i class="fa {{ $defCurrency->currency_symbol }}"></i></td>
                                        </tr>
                                        <tr>
                                            <th>{{__("Total")}}:</th>
                                            <td>{{ sprintf('%.2f',$order['grand_total']) }} <i class="fa {{ $defCurrency->currency_symbol }}"></i></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <b>{{ config('app.name') }}</b>
                                                <br>
                                                {{ __('Authorised Signature') }}
                                                
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
        
                            
                            
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
        
                        <!-- this row will not appear when printing -->
                        <div class="row d-print-none">
                            <div class="col-md-12">
                                
                            <a onclick="window.print()"  class="btn btn-primary-rgba"><i class="feather icon-printer"></i>
                                {{__("Print")}}        
                            </a>
                              
                            
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection