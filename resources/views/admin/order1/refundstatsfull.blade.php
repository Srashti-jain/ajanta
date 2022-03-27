<!-- Latest compiled and minified CSS -->

<table align="center" class="table table-striped table-bordered">
	<h4 class="text-center">{{ $paygatename }}</h4>
	<thead>
		@if($paygatename == 'Instamojo')

		<tr>
			<th>
				{{ __('Order Transcation ID:') }}
			</th>

			<td>
				{{$response['refund']['payment_id']}}
			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Transcation ID:') }}
			</th>

			<td>
				{{$response['refund']['id']}}
			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Status:') }}
			</th>

			<td>
				{{$response['refund']['status']}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Refunded Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{$response['refund']['refund_amount']}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Total Order Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{$response['refund']['total_amount']+$order->handlingcharge}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Created at:') }}
			</th>

			<td>
				{{ date('d-m-Y | h:i A',strtotime($response['refund']['created_at'])) }}
			</td>
		</tr>
		@elseif($paygatename == 'Stripe')
		<tr>
			<th>
				{{ __('Order Transcation ID:') }}
			</th>

			<td>
				{{$response['charge']}}

			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Transcation ID:') }}
			</th>

			<td>
				{{$response['id']}}
			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Status:') }}
			</th>

			<td>
				{{ucfirst($response['status'])}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Refunded Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{$response['amount']/100}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Total Order Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{round($order->order_total+$order->handlingcharge,2)}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Created at:') }}
			</th>

			<td>
				{{gmdate("d-m-Y\ | h:i A", $response['created'])}}
			</td>
		</tr>
		@elseif($paygatename == 'PayPal')

		<tr>
			<th>
				{{ __('Order Transcation ID:') }}
			</th>

			<td>
				{{$response->parent_payment}}

			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Transcation ID:') }}
			</th>

			<td>
				{{$response->id}}
			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Status:') }}
			</th>

			<td>
				{{ucfirst($response->state)}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Refunded Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{$response->total_refunded_amount['value']}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Total Order Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{round($order->order_total+$order->handlingcharge,2)}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Created at:') }}
			</th>

			<td>
				{{ date('d-m-Y | h:i A',strtotime($response->update_time)) }}
			</td>
		</tr>

		@elseif($paygatename == 'Razorpay')

		<tr>
			<th>
				{{ __('Order Transcation ID:') }}
			</th>

			<td>
				{{$response->items[0]->payment_id}}

			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Transcation ID:') }}
			</th>

			<td>
				{{$response->items[0]->id}}
			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Status:') }}
			</th>

			<td>
				{{ucfirst($response->items[0]->entity)}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Refunded Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{$response->items[0]->amount/100}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Total Order Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{round($order->order_total+$order->handlingcharge,2)}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Created at:') }}
			</th>

			<td>
				{{gmdate("d-m-Y | h:i A", $response->items[0]->created_at)}}
			</td>
		</tr>
		@elseif($paygatename == 'Paytm')

		<tr>
			<th>
				{{ __('Order Transcation ID:') }}
			</th>

			<td>

				{{$response['TXNID']}}

			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Transcation ID:') }}
			</th>

			<td>
				{{$data->transaction_id}}
			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Status:') }}
			</th>

			<td>
				{{ucfirst('Completed')}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Refunded Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{$response['REFUNDAMT']}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Total Order Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{round($order->order_total+$order->handlingcharge,2)}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Created at:') }}
			</th>

			<td>
				{{ date('d-m-Y h:i a',strtotime($response['TXNDATE'])) }}
			</td>
		</tr>
		@elseif($paygatename == 'Paystack')

		<tr>
			<th>
				{{ __('Order Transcation ID:') }}
			</th>

			<td>

				{{ $response['data']['id'] }}

			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Transcation ID:') }}
			</th>

			<td>
				{{ $response['data']['reference'] }}
			</td>

		</tr>

		<tr>
			<th>
				{{ __('REFUND Status:') }}
			</th>

			<td>
				{{ ucfirst($response['data']['status']) }}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Refunded Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{$response['data']['amount']/100}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Total Order Amount:') }}
			</th>

			<td>
				<i class="{{ $order->paid_in }}"></i>{{round($order->order_total+$order->handlingcharge,2)}}
			</td>
		</tr>

		<tr>
			<th>
				{{ __('Created at:') }}
			</th>

			<td>
				{{ date('d-m-Y h:i a',strtotime($response['data']['paid_at'])) }}
			</td>
		</tr>

		@endif
	</thead>
</table>

<small class="pull-right">{{__("Last Update at:")}} {{ date('d-m-Y | h:i A') }}</small>