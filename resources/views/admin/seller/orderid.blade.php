@php
	$inv = App\Invoice::first();
@endphp

<p><b>#{{ $inv->order_prefix }}{{ $orderid }}</b></p>
<p><small>{{ __("Invoice No:") }} <b>#{{ $inv->prefix }}{{ $invid }}{{ $inv->prefix }}</b></small></p>
@if($paidvia == 'Paypal')
<small><a role="button" class="cursor-pointer" onclick="trackstatus('{{ $txn_id }}')" title="{{ __("Click to track payout status live") }}">{{ __("Track Payout Status Live") }}</a></small>
@endif