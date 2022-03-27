@component('mail::message')
# {{__("Hi,")}} {{$value->order->user->name}}

<p>{{__("This is to inform you that your order #")}}{{ $value->order->order_id }} {{'item has been come in stock.'}}</p>
<p>{{__("Please click here to pay your remaning amount")}}</p>

@component('mail::button', ['url' => URL::temporarySignedRoute('preorder.remain.payment', now()->addMinutes(15), ['id' => $value->id]) ])
    {{ $value->order->paid_in_currency }} {{ price_format($value->remaning_amount) }}
@endcomponent

<p>
    {{__("Once the amount is paid your order will be proceed further.")}}
</p>

<br>

<code>
    {{__("This link is valid only for 15 minutes if it's expired kindly contact seller to re-send it.")}}
</code>

{{__("Thanks,") }}
<br>
{{ config('app.name') }}
@endcomponent
