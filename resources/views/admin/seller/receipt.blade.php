<table class="table table-bordered">
	
	<tbody>

		<tr>
			<td>
				<b>
					{{__("Payout Batch ID")}}
				</b>
			</td>
			<td>
				{{ $response->batch_header->payout_batch_id }}
			</td>
		</tr>

		<tr>
			<td>
				<b>
					{{__("Amount")}}
				</b>
			</td>

			<td>
				{{ $response->batch_header->amount->currency.' '.$response->batch_header->amount->value }}
			</td>
		</tr>

		<tr>
			<td>
				<b>
					{{__("Payout Status")}}
				</b>
			</td>
			<td>
				{{ $response->batch_header->batch_status }}
			</td>
		</tr>

		<tr>
			<td>
				<b>
					{{__("Payout Created ON")}}
				</b>
			</td>
			<td>
				{{ date('d-m-Y | h:i A',strtotime($response->batch_header->time_created)) }}
			</td>
		</tr>

		<tr>
			<td>
				<b>
					{{__("Payout Proccessed ON")}}
				</b>
			</td>
			<td>
				{{ date('d-m-Y | h:i A',strtotime($response->items[0]->time_processed)) }}
			</td>
		</tr>

		<tr>
			<td><b>{{ __("Payout Completed On") }}</b></td>
			<td>{{ date('d-m-Y | h:i A',strtotime($response->batch_header->time_completed)) }}</td>
		</tr>

		<tr>
			<td><b>{{ __("Transcation ID") }}</b></td>
			<td>{{ $response->items[0]->transaction_id }}</td>
		</tr>

		<tr>
			<td><b>{{ __("Transcation Status") }}</b></td>
			<td>{{ $response->items[0]->transaction_status }}</td>
		</tr>

		<tr>
			<td ><b>{{ __('Message') }}</b></td>
			<td class="width60">
				<p><b>{{ $response->items[0]->errors->name }}</b></p>
				<p>{{ $response->items[0]->errors->message }}</p>
			</td>
		</tr>

	</tbody>

	
</table>