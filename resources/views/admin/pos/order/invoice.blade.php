
<div style="width:410px;">
    <div class="text-center pt-4 mb-3">
        <h2 style="line-height: 1">{{ \App\Genral::where(['id'=>'1'])->first()->project_name }}</h2>
        <h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
            {{\App\Genral::where(['id'=>'1'])->first()->address}}
        </h5>
        <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
            {{\App\CentralLogics\translate('Phone')}}
            : {{\App\Genral::where(['id'=>'1'])->first()->mobile}}
        </h5>
    </div>
    <span>--------------------------------------------------------------------------------------</span>
    <div class="row mt-3">
        <div class="col-6">
            <h5>{{\App\CentralLogics\translate('Order ID')}} : {{$order['id']}}</h5>
        </div>
        <div class="col-6">
            <h5 style="font-weight: lighter">
                {{date('d/M/Y h:i a',strtotime($order['created_at']))}}
            </h5>
        </div>
        @if($order->customer)
        <div class="col-12">
            <h5>{{\App\CentralLogics\translate('Customer Name')}} : {{$order->customer['f_name'].' '.$order->customer['l_name']}}</h5>
            <h5>{{\App\CentralLogics\translate('Phone')}} : {{$order->customer['phone']}}</h5>
            <h5>
                {{\App\CentralLogics\translate('Address')}}
                : {{isset($order->delivery_address)?json_decode($order->delivery_address, true)['address']:''}}
            </h5>
        </div>
        @endif
    </div>
    <h5 class="text-uppercase"></h5>
    <span>--------------------------------------------------------------------------------------</span>
    <table class="table table-bordered mt-3" style="width: 98%">
        <thead>
            <tr>
                <th style="width: 10%">{{\App\CentralLogics\translate('QTY')}}</th>
                <th class="">{{\App\CentralLogics\translate('Class')}}</th>
                <th class="">{{\App\CentralLogics\translate('Books')}}</th>
                <th class="">{{\App\CentralLogics\translate('Price')}}</th>
            </tr>
        </thead>
        
        <tbody>
            @php($sub_total=0)
            @php($total_tax=0)
            @php($total_dis_on_pro=0)
            @php($add_ons_cost=0)
            @php($parent_ids = json_decode($order->parent_ids,true))
            @php($simple_pro_ids = json_decode($order->simple_pro_ids,true))
          
            @foreach($parent_ids as $Key_class =>  $p_ids)  
            @php($i=0) 
            <tr>
                <td class="">
                    {{$p_ids['quantity']}}
                </td>
                <td class="">
                    {{$Key_class}}
                </td>
               
                <td class="">
                    @foreach($simple_pro_ids[$p_ids['class_id']] as $product_data)
                    @php($i++)
                    <span style="word-break: break-all;">{{ $i }}) {{ \Illuminate\Support\Str::limit($product_data['name'], 50) }}</span><br>
                    @endforeach
                </td>
                <td style="width: 28%">
                    @php($sub_total+=$p_ids['product_amt'])
                    @php($total_tax+=$p_ids['tax'])
                    {{$p_ids['product_amt'] ." Rs."}}
                </td>
            </tr>
            @endforeach
           
        </tbody>
    </table>
    <span>---------------------------------------------------------------------------------------</span>
    <div class="row justify-content-md-end">
        <div class="col-md-7 col-lg-7">
            <dl class="row text-right" style="color: black!important;">
                <dt class="col-6">{{\App\CentralLogics\translate('Items Price')}}:</dt>
                <dd class="col-6">{{$sub_total." Rs."}}</dd>
                <dt class="col-6">{{\App\CentralLogics\translate('Tax')}} / {{\App\CentralLogics\translate('VAT')}}:</dt>
                <dd class="col-6">{{$order->tax_amount." Rs."}}</dd>
                <dt class="col-6">{{\App\CentralLogics\translate('Extra Discount')}}:</dt>
                <dd class="col-6">- {{$order->discount." Rs."}}</dd>
                
             
                    <dt class="col-6" style="font-size: 20px">{{\App\CentralLogics\translate('Total')}}:</dt>
                    <dd class="col-6" style="font-size: 20px">{{$order->order_total." Rs."}}</dd>
                </dl>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-between border-top">
            <span>{{\App\CentralLogics\translate('Paid_by')}}: {{$order->payment_method}}</span>
        </div>
        <span>---------------------------------------------------------------------------------------</span>
        <h5 class="text-center pt-3">
            """{{\App\CentralLogics\translate('THANK YOU')}}"""
        </h5>
        <span>---------------------------------------------------------------------------------------</span>
    </div>
    