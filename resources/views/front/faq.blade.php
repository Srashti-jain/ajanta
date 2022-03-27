@extends('front.layout.master')
@section('title',"FAQ's | ")
@section('body')
<div class="checkout-box faq-page">
	<h4>{{ __('staticwords.AllFAQs') }}</h4>
	<hr>
	<div class="row">
		<div class="col-md-12">

			<div class="card-group checkout-steps" id="accordion">
				<!-- checkout-step-01  -->

				<!-- checkout-step-01  -->
				<div class="card">
					@foreach($faqs as $key=> $faq)

						<div class="card-header">
							<h4 class="unicase-checkout-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#faq{{ $faq->id }}">
									<span>{{ $key+1 }}.</span> {{ $faq->que }}
								</a>
							</h4>
						</div>

						<div id="faq{{ $faq->id }}" class="card-collapse collapse show">

							<div class="card-body">

								{{ $faq->ans }}

							</div>

						</div>

					@endforeach
				</div>

			</div>
		</div>
	</div>
</div>
@endsection