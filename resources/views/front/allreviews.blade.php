@extends('front.layout.master')
@section('title',__(':productname - All Reviews |',['productname' => $product->name ?? $product->product_name]))
@section('body')

	<div class="container-fluid">
		<br>
		<div class="card-body bg-white all-review-main-block">
			
			<div class="row">

				

				<div class="col-md-4">
					<div class="overall-rating-main-block left-sidebar">
                          <div class="overall-rating-block text-center">
                            @php
                              if(!isset($overallrating)){
                                $overallrating = 0;
                              }
                            @endphp
                            <h1>{{ $overallrating }}</h1>
                            <div class="overall-rating-title">{{ __('Overall Rating') }}</div>
                            <div class="rating">
                                  
                                  <div class="star-ratings-sprite">
                                  	<span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                  </div>
                        
                            </div>
                            <div class="total-review">{{$count =  count($mainproreviews)}} {{ __('Ratings &') }}  {{ $reviewcount }} {{ __('Reviews') }}</div>
                          </div>
                          <div>
                            <div class="stat-levels">
                                <label>{{ __('Quality') }}</label>
                                <div class="stat-1 stat-bar">
                                  <span class="stat-bar-rating" role="stat-bar" style="width: {{ $qualityprogress }}%;">{{ $qualityprogress }}%</span>
                                </div>
                                <label>{{ __('Price') }}</label>
                                <div class="stat-2 stat-bar">
                                  <span class="stat-bar-rating stat-bar-rating-one" role="stat-bar" style="width: {{ $priceprogress }}%;">{{ $priceprogress }}%</span>
                                </div>
                                <label>{{ __('Value') }}</label>
                                <div class="stat-3 stat-bar">
                                  <span class="stat-bar-rating stat-bar-rating-two" role="stat-bar" style="width: {{ $valueprogress }}%;">{{ $valueprogress }}%</span>
                                </div>
                            </div>
                          </div>
                          @if($overallrating>3.9)
                            <div class="overall-rating-block satisfied-customer-block text-center">
                              <h3>100%</h3>
                              <div class="overall-rating-title">{{ __('Satisfied Customer') }}</div>
                              <p>{{ __('All Customers give this product 4 and 5 Star Rating') }}.</p>
                            </div>
                          @endif
           </div>
				</div>

				<div class="col-md-8 main-content">
					<br>
					<div class="row">
            @if($type == 'v')
              <div class="col-lg-1 col-md-2 col-xs-3 viewall-img">
                <img class="img-fluid" title="{{ $product->name }}" src="{{ url('variantimages/'.$product->subvariants[0]->variantimages['main_image']) }}" alt="{{ $product->subvariants[0]->variantimages['main_image'] }}">
              </div>
            @else
              <div class="col-lg-1 col-md-2 col-xs-3 viewall-img">
                <img class="img-fluid" title="{{ $product->product_name }}" src="{{ url('images/simple_products/'.$product->thumbnail) }}" alt="{{ $product->thumbnail }}">
              </div>
            @endif

						<div class="col-lg-11 col-md-6 col-xs-9">
							<h3><a href="{{ $type == 'v' ? $product->getURL($product->subvariants[0]) : $product->slug() }}">{{ $type == 'v' ? $product->name : $product->product_name }}</a></h3>
							<div class="pull-left">
								<div class="star-ratings-sprite">
									<span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
								</div>
							</div>
							<br>
              @if($type == 'v')
							<p>{!! $product->des !!}</p>
              @else 
              <p>{!! $product->product_detail !!}</p>
              @endif
						</div>

					</div>
					<hr>
					@foreach($allreviews as $review)

                             @if($review->status == "1")
                              <div class="row">

                                  <div class="col-lg-1 col-md-2 col-xs-3">
                                    @if($review->users->image !='')
                                    <img src="{{ url('/images/user/'.$review->users->image) }}" alt="" width="70px" height="70px">
                                    @else
                                    <img width="70px" height="70px" src="{{ Avatar::create($review->users->name)->toBase64() }}">
                                    @endif
                                  </div>



                                  <div class="col-lg-10 col-md-10 col-xs-9">
                                    <p>
                                      <b><i>{{ $review->users->name }}</i></b>
                                      <?php

                                        $user_count = count([$review]);
                                        $user_sub_total = 0;
                                        $user_review_t = $review->price * 5;
                                        $user_price_t = $review->price * 5;
                                        $user_value_t = $review->value * 5;
                                        $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;

                                        $user_count = ($user_count * 3) * 5;
                                        $rat1 = $user_sub_total / $user_count;
                                        $ratings_var1 = ($rat1 * 100) / 5;

                                        ?>
                                    <div class="pull-left">
                                        <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var1; ?>%" class="star-ratings-sprite-rating"></span>
                                        </div>
                                    </div>

                                      <small class="pull-right allreview-date">{{ __('On') }} {{ date('jS M Y',strtotime($review->created_at)) }}</small>
                                      <br>
                                      <span class="font-weight500">{{ $review->review }}</span>
                                    </p>
                                  </div>

                              </div>
                              <hr>
                          @endif
                    @endforeach
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12">
          <div class="text-center">
          
          {!! $allreviews->links() !!}
          
          </div>
        
        <div class="text-center">
          <a title="Go back" href="{{ url()->previous() }}" class="btn btn-md btn-primary">
            <i class="fa fa-arrow-left"></i> {{ __('Back') }}
          </a>
        </div>    
        </div>
			</div>
			
			<hr>
		</div>
	</div>
@endsection