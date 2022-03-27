@extends("front.layout.master")
@php
$sellerac = App\Store::where('user_id','=', $user->id)->first();
@endphp
@section('title',"View Order #$inv_cus->order_prefix$order->order_id |")
@section("body")



<div class="container-fluid">



  <div class="row">
    <div class="col-lg-3">
      
      @include('user.sidebar')

    </div>




    <div class="col-lg-9">

      <div class="bg-white2 view-full-order-page">

        <h5 class="user_m2">

          <a title="{{ __('Go back') }}" href="{{ url('/order') }}" class="btn btn-sm btn-default"><i
              class="fa fa-reply" aria-hidden="true"></i>
          </a> {{ __('Order') }} #{{ $inv_cus->order_prefix }}{{ $order->order_id }}

          @php
            $checkOrderCancel = $order->cancellog;
            $orderlog = $order->fullordercancellog;
            $deliverycheck = array();
            $tstatus = 0;
            $cancel_valid = array();
          @endphp

          @if(count($order->invoices)>1)

          @foreach($order->invoices as $inv)
            @if($inv->variant)

              @if($inv->variant->products->cancel_avl != 0)
                @php
                  array_push($cancel_valid,1);
                @endphp
              @else
                @php
                array_push($cancel_valid,0);
                @endphp
              @endif
            
            @endif
          @endforeach

          @else
            @php
              array_push($cancel_valid,0);
            @endphp
          @endif

          @if(isset($order))
          @foreach($order->invoices as $sorder)
            @if($sorder->status == 'delivered' || $sorder->status == 'cancel_request' || $sorder->status
            =='return_request' || $sorder->status == 'returned' || $sorder->status == 'refunded' || $sorder->status ==
            'ret_ref')
              @php
              array_push($deliverycheck, 0);
              @endphp
            @else
              @php
              array_push($deliverycheck, 1);
              @endphp
            @endif
          @endforeach
          @endif



          @if(in_array(0, $deliverycheck))
          @php
          $tstatus = 1;
          @endphp
          @endif
          

        </h5>

        @if(!isset($checkOrderCancel) || !isset($orderlog))
        <!-- Modal -->
        <div data-backdrop="static" data-keyboard="false" class="z-index99 modal fade" id="cancelFULLOrder"
          tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">{{ __('staticwords.CancelOrder') }}:
                  #{{ $inv_cus->order_prefix.$order->order_id }}</h5>
              </div>
              <div class="modal-body">
                @php
                  $secureorderID = Crypt::encrypt($order->id);
                @endphp
                <form method="POST" action="{{ route('full.order.cancel',$secureorderID) }}">
                  @csrf

                  <div class="form-group">
                    <label class="font-weight-normal" for="">{{ __('staticwords.ChooseReason') }} <span
                        class="required">*</span></label>
                    <select class="form-control" required="" name="comment" id="">
                      <option value="">{{ __('staticwords.PleaseChooseReason') }}</option>

                        @forelse(App\RMA::where('status','=','1')->get() as $rma)
                          <option value="{{ $rma->reason }}">{{ $rma->reason }}</option>
                        @empty
                          <option value="Other">{{ __('My Reason is not listed here') }}</option>
                        @endforelse
                        
                    </select>
                  </div>

                  @if($order->payment_method !='COD' && $order->payment_method !='BankTransfer')
                  <div class="form-group">

                    <label class="font-weight-normal" for="">{{ __('staticwords.ChooseRefundMethod') }}:</label>
                    <label class="font-weight-normal"><input required class="source_check" type="radio" value="orignal"
                        name="source" />{{ __('staticwords.OrignalSource') }} [{{ $order->payment_method }}]
                    </label>&nbsp;&nbsp;
                    @if(auth()->user()->banks()->count())

                    <label class="font-weight-normal"><input required class="source_check" type="radio" value="bank"
                        name="source" /> {{ __('staticwords.InBank') }}</label>

                    <select name="bank_id" id="bank_id" class="display-none form-control">
                      @foreach(Auth::user()->banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
                      @endforeach
                    </select>

                    @else

                    <label class="font-weight-normal"><input type="radio" disabled="" /> {{ __('staticwords.InBank') }}
                      <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right"
                        title="Add a bank account in My Bank Account" aria-hidden="true"></i></label>

                    @endif
                  </div>


                  @else

                  @if(auth()->user()->banks()->count())

                  <label class="font-weight-normal"><input required class="source_check" type="radio" value="bank" name="source" /> {{ __('staticwords.InBank') }}</label>

                  <select name="bank_id" id="bank_id" class="display-none form-control">
                    @foreach(Auth::user()->banks as $bank)
                      <option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
                    @endforeach
                  </select>

                  @else

                  <label class="font-weight-normal"><input type="radio" disabled="" /> {{ __('staticwords.InBank') }} <i
                      class="fa fa-question-circle" data-toggle="tooltip" data-placement="right"
                      title="Add a bank account in My Bank Account" aria-hidden="true"></i></label>

                  @endif

                  @endif

                  <div class="alert alert-info">
                    <h5><i class="fa fa-info-circle"></i> {{ __('staticwords.Important') }} !</h5>

                    <ol class="font-weight600 sq">
                      <li>{{ __('staticwords.iforisourcechoosen') }}.
                      </li>

                      <li>
                        {{ __('staticwords.ifbankmethodtext') }}.
                      </li>

                      <li>{{ __('staticwords.amounttext') }}.</li>

                    </ol>
                  </div>


                  <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled="disabled"
                    title="This action is disabled in demo !" @endif class="btn btn-md btn-info">
                    {{ __('staticwords.Procced') }}...
                  </button>
                </form>
                <p class="help-block">{{ __('staticwords.actionnotdone') }} !</p>
                <p class="help-block">{{ __('staticwords.windowrefreshwarning') }} !</p>
              </div>

            </div>
          </div>
        </div>
        @endif



        <hr>

        <table class="table table-striped table-striped-one">
          <thead>
            <tr>
              <th>{{ __('staticwords.ShippingAddress') }}</th>
              <th>{{ __('staticwords.BillingAddress') }}</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>
                <p><b><i class="fa fa-user-circle"></i> {{ $address->name }}, {{ $address->phone }}</b></p>
                <p class="font-weight-normal"><i class="fa fa-map-marker" aria-hidden="true"></i>
                  {{ strip_tags($address->address) }},</p>
                  @php
                  

                    $c = App\Allcountry::where('id',$address->country_id)->first()->nicename;
                    $s = App\Allstate::where('id',$address->state_id)->first()->name;
                    $ci = App\Allcity::where('id',$address->city_id)->first() ? App\Allcity::where('id',$address->city_id)->first()->name : '';

                  @endphp
                <p class="font-weight-normal margin-left8">{{ $ci }}, {{ $s }}, {{ $ci }}</p>
                <p class="font-weight-normal margin-left8">{{ $address->pin_code }}</p>
              </td>
              <td>
                <p><b><i class="fa fa-user-circle"></i> {{ $order->billing_address['firstname'] }},
                    {{ $order->billing_address['mobile'] }}</b></p>
                <p class="font-weight-normal"><i class="fa fa-map-marker" aria-hidden="true"></i>
                  {{ strip_tags($order->billing_address['address']) }},</p>
                @php


                  $c = App\Allcountry::where('id',$order->billing_address['country_id'])->first()->nicename;
                  $s = App\Allstate::where('id',$order->billing_address['state'])->first()->name;
                  $ci = App\Allcity::where('id',$order->billing_address['city'])->first() ? App\Allcity::where('id',$order->billing_address['city'])->first()->name : '';

                @endphp
                <p class="font-weight-normal margin-left8">{{ $ci }}, {{ $s }}, {{ $ci }}</p>
                <p class="font-weight-normal margin-left8">@if(isset($order->billing_address['pincode']))
                  {{ $order->billing_address['pincode'] }} @endif</p>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="table-responsive">
          <table class="table table-bordered table-striped-one">
            <thead>
              <tr>
                <td>
                  <b>{{ __('staticwords.TranscationID') }}:</b> {{ $order->transaction_id }}
                </td>
                <td>
                  <b>{{ __('staticwords.PaymentMethod') }}:</b> {{ $order->payment_method }}
                </td>
                <td>
                  <b>{{ __('staticwords.OrderDate') }}: </b> {{ date('d-m-Y',strtotime($order->created_at)) }}
                </td>


              </tr>

            </thead>
          </table>
        </div>
        @php
        if($order->discount != 0){
        if($order->distype == 'category'){

        $findCoupon = App\Coupan::where('code','=',$order->coupon)->first();
        $catarray = collect();
        foreach ($order->invoices as $key => $os) {

          if(isset($os->variant->products) && $os->variant->products->category_id == $findCoupon->cat_id){

            $catarray->push($os);

          }

          if(isset($os->simple_product) && $os->simple_product->category_id == $findCoupon->cat_id){
            $catarray->push($os);
          }

        }

        }
        }
        @endphp
        @foreach($order->invoices as $o)
          
          @php
              $orivar = $o->variant;
          @endphp

          <div class="card mb-2">
            <div class="card-header">
              <div class="card-title">
                <a href="" class="">
                  &nbsp;
                </a>
                @if(isset($orivar->products))
                @if($orivar->products->cancel_avl == '1')
                @if($o->status == 'pending' || $o->status == 'processed')
                  @php
                    $secureid = Crypt::encrypt($o->id);
                  @endphp
                <button @if(env('DEMO_LOCK')==0) title="Cancel This Order?" data-toggle="modal"
                  data-target="#proceedCanItem{{ $o->id }}" @else disabled="disabled"
                  title="This action is disabled in demo !" @endif
                  class="float-right btn btn-sm btn-danger">
                  {{ __('Cancel') }}
                </button>
                @else 
                  <button disabled="" title="Cancel This Order" class="btn btn-sm btn-danger">
                    {{ __('No Cancellation Available') }}
                  </button>
                @endif
                @endif
                @else
                  @if(!in_array($o->status,['shipped','delivered','refunded','return_request','ret_ref','Refund Pending','canceled']))
                    
                    @if($o->simple_product->cancel_avbl == '1')
                      <button @if(env('DEMO_LOCK') == 0) title="Cancel This Order?" data-toggle="modal"
                        data-target="#proceedCanItem{{ $o->id }}" @else disabled="disabled"
                        title="This action is disabled in demo !" @endif
                        class="float-right btn btn-sm btn-danger">
                        {{ __('Cancel') }}
                      </button>
                       
                    @else

                      <button disabled="" title="Cancel This Order" class="btn btn-sm btn-danger">
                          {{ __('No Cancellation Available') }}
                      </button>
                        
                    @endif

                  @endif
                @endif

                @if($o->status == 'refunded')
                  <span class="font-weight-normal float-right badge badge-primary refund-label">
                    {{ __('Refunded') }}
                  </span>
                @elseif($o->status == 'shipped')
                  <span class="font-weight-normal float-right badge badge-success refund-label">
                    {{ __('Shipped') }}
                  </span>
                @elseif($o->status == 'Refund Pending')
                <span class="font-weight-normal float-right badge badge-success">
                  {{ __('Refund in progress') }}
                </span>
                @elseif($o->status == 'returned')
                <span class="font-weight-normal float-right badge badge-success">
                  {{ __('Returned') }}
                </span>
                @endif



                @if(isset($orivar->products))
                  @if($orivar->products->return_avbl == '1' && $o->status == 'delivered')

                      @php

                        $days = $orivar->products->returnPolicy->days;
                        $endOn = date("d-M-Y", strtotime("$o->updated_at +$days days"));
                        $today = date('d-M-Y');

                      @endphp

                      @if($today == $endOn)
                        <button disabled="" class="mr-2 float-right btn btn-sm btn-danger">
                          {{ __('Return period is ended !') }}
                        </button>
                      @else
                      <!--END-->
                        <a class="mr-2 float-right btn btn-sm btn-danger" href="{{ route('return.window',Crypt::encrypt($o->id)) }}">
                          {{ __('Return') }}
                        </a>
                      @endif

                    @else 
                      <button disabled class="mr-2 float-right btn btn-sm btn-danger">
                        {{ __('Return not available !') }}
                      </button>

                  @endif
                @elseif(isset($o->simple_product) && $o->status == 'delivered')
                 
                   @if($o->simple_product->return_avbl == '1')

                      @php

                        $days = $o->simple_product->returnPolicy->days;
                        $endOn = date("d-M-Y", strtotime("$o->updated_at +$days days"));
                        $today = date('d-M-Y');

                      @endphp

                      @if($today == $endOn)
                        <button disabled="" class="m-l-8 pull-right btn btn-sm btn-danger">
                          {{ __('Return period is ended !') }}
                        </button>
                      @else
                      <!--END-->
                        <a class="m-l-8 pull-right btn btn-sm btn-danger" href="{{ route('return.window',Crypt::encrypt($o->id)) }}">
                          {{ __('Return') }}
                        </a>
                      @endif

                   @else

                    <button disabled="" class="m-l-8 pull-right btn btn-sm btn-danger">
                        {{ __('Return not available !') }}
                    </button>

                   @endif
                  
                @endif

                @if($o->status == 'delivered' || $o->status == 'return_request')
                  <a title="Click to View or print" href="{{ route('user.get.invoice',$o->id) }}"
                    class="float-right btn btn-sm btn-danger"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    {{ __('Invoice') }}
                  </a>
                @endif

                @if($o->status == 'delivered')
                  @if(isset($o->simple_product) && $o->simple_product->type == 'd_product')
                    <a title="Download your item" href="{{ URL::temporarySignedRoute('user.download.order', now()->addMinutes(2), ['orderid' => $o->id]) }}"
                      class="mr-2 float-right btn btn-sm bg-success text-light"><i class="fa fa-download" aria-hidden="true"></i>
                      {{ __('Download') }}
                    </a>
                  @endif
                @endif

              </div>
            </div>

            <div class="card-body">

              

              <div id="OrderRow{{ $o->id }}" class="row full-order-main-block">
                <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                  @if(isset($orivar))
                  @if(isset($orivar->variantimages) && file_exists(public_path().'/variantimages/thumbnails/'.$orivar->variantimages->main_image))
                    <img class="pro-img2"
                      src="{{url('variantimages/thumbnails/'.$orivar->variantimages->main_image)}}"
                      alt="product name" />
                    @else
                    <img class="pro-img2"
                      src="{{ Avatar::create($orivar->products->name)->toBase64() }}"
                      alt="product name" />
                    @endif
                  @endif

                  @if($o->simple_product)
               
                      @if($o->simple_product->thumbnail != '' && file_exists(public_path().'/images/simple_products/'.$o->simple_product->thumbnail))
                        <img class="pro-img2" src="{{ url('images/simple_products/'.$o->simple_product->thumbnail) }}"/>
                      @else
                        <img class="pro-img2" src="{{ Avatar::create($o->simple_product->product_name)->toBase64() }}"
                        alt="product name" />
                      @endif
                    @endif
                </div>

                <div class="col-lg-4 col-md-3 col-sm-3 col-7 full-order-main-block">
                  @if(isset($orivar->products))
                  <a target="_blank"
                    href="{{ $orivar->products->getURL($orivar) }}"><b>{{substr($orivar->products->name, 0, 30)}}{{strlen($orivar->products->name)>30 ? '...' : ""}}</b>

                    <small>
                      
                      ({{variantname($o->variant)}})

                    </small>
                  </a>
                  <br>
                  <small><b>{{ __('Sold By:') }}</b> {{$orivar->products->store->name}}</small>
                  @endif

                  @if(isset($o->simple_product))
                    <a target="_blank" href="{{ route('show.product',['id' => $o->simple_product->id, 'slug' =>   $o->simple_product->slug]) }}">
                      <b>{{ $o->simple_product->product_name }}</b>
                    </a>
                    <br>
                    <small><b>{{ __('staticwords.SoldBy') }}:</b> {{$o->simple_product->store->name}}</small>
                  @endif

                  <br>
                  <small><b>{{ __('Qty:') }}</b> {{$o->qty}}</small>
                  <div>
                    @if($o->status == 'delivered')
                    <p>{{ __('Your Product is deliverd on') }} <br>
                      <b>{{ date('d-m-Y @ h:i:a',strtotime($o->updated_at)) }}</b></p>
                    @endif

                    @if($o->status == 'return_request')
                    <span class="font-weight-normal badge badge-warning">{{ __('Return Requested') }}</span>
                    <br>
                    @endif

                    @if($o->status == 'ret_ref')
                      <span class="font-weight-normal badge badge-success">
                        {{ __('Returned & Refunded') }}
                      </span>
                      <br>
                    @endif



                    @if($o->status == 'cancel_request')
                      <span class="font-weight-normal badge badge-danger">
                        {{ __('Cancellation requested') }}
                      </span>
                    @endif

                    @if($o->status == 'canceled')
                      <span class="font-weight-normal badge badge-danger">
                        {{ __('Cancelled') }}
                      </span>
                      <p></p>
                    @endif

                    @if($o->status == 'refunded' || $o->status == 'return_request' || $o->status == 'returned' ||
                    $o->status == 'ret_ref')

                      @php
                        $refundlog = $o->refundlog;
                      @endphp


                      @if(isset($refundlog))

            

                        @if($refundlog->status == 'initiated')
                      
                          
                            <small class="font-weight600">{{ __('Return Request Intiated with Ref. No:') }}
                              [{{ $refundlog->txn_id }}]
                              @if($refundlog->method_choosen == 'bank')
                                <br>
                                {{ __('Choosen bank:') }}
        
                                @if(!$refundlog->bank)
                                  {{ __('Choosen bank has been deleted !') }}
                                @else 
                                <u>{{$refundlog->bank->bankname}} (XXXX{{ substr($refundlog->bank->acno, -4) }})</u>
                                @endif
                              @endif
                            </small>
                        

                        @else

                          @if($refundlog->method_choosen == 'orignal')

                            <small class="font-weight600">{{ __('Refund Amount') }} <i
                                class="fa {{ $o->order->paid_in }}"></i>{{ $refundlog->amount }} {{ __('is') }}
                              {{$refundlog->status}} {{ __('to your Requested payment source') }} {{ $refundlog->pay_mode }}
                              {{ __('and will be reflected to your a/c in 1-2 working days.') }} <br> ({{ __('TXN ID:') }}
                              {{ $refundlog->txn_id }})
                            </small>

                          @else

                            <small class="font-weight600">
                              {{ __('Refund Amount') }} <i class="fa {{ $o->order->paid_in }}"></i>
                              {{ $refundlog->amount }} is
                              {{$refundlog->status}} {{ __('to your Requested bank a/c') }} <u>{{$refundlog->bank->bankname ?? 'Bank account deleted'}}
                                (XXXX{{ substr($refundlog->bank->acno, -4) }})</u> @if($refundlog->status !='refunded')
                              {{ __('and will be reflected to your a/c in 1-2 working days.') }}@endif <br> (TXN ID:
                              {{ $refundlog->txn_id }})
                              .
                              <br>
                              @if($refundlog->txn_fee != '')
                              {{ __('Transcation FEE Charge:') }} <i
                                class="fa {{ $o->order->paid_in }}"></i>{{ $refundlog->txn_fee }}
                              @endif
                            </small>

                          @endif

                        @endif
                      @endif

                    @endif

                    @php

                      $log = App\CanceledOrders::where('inv_id', '=', $o->id)
                                                ->where('user_id',Auth::user()->id)
                                                ->with('bank')
                                                ->first();
                      
                      $orderlog = App\FullOrderCancelLog::where('order_id','=',$order->id)
                                                        ->with('bank')
                                                        ->first();
 
                    @endphp

                    @if(isset($log))

                  

                    @if($log->method_choosen == 'orignal')

                    <small class="text-justify"><b>Refund Amount <u><i
                            class="fa {{ $o->order->paid_in }}"></i>{{$log->amount}}</u>
                        {{ __('is refunded to original source') }} ({{ $o->order->payment_method }}).
                        {{ __("IF it don't than it will take 1-2 days to reflect in your account.") }}
                        <br>({{ __("TXN ID:") }} {{ $log->transaction_id }})</b></small>
                    @elseif($log->method_choosen == 'bank' && $log->is_refunded == 'pending' )
                    <small><b>{{ __('Refund Amount') }} <u><i
                            class="fa {{ $o->order->paid_in }}"></i>{{$log->amount}}</u>
                        {{ __('is proceeded to your bank ac, amount will be reflected to your bank ac in 14 working days.') }}
                        <br>
                        ({{ __('Refrence No.') }} {{ $log->transaction_id }})</b></small>
                 
                    @if(isset($log->bank))
                    <br>
                    <small><b>Choosen Bank: {{ $log->bank->bankname }} ({{ $log->bank->acno }})</b></small>
                    @else
                      {{ __('Choosen Bank ac deleted !') }}
                    @endif
                    @elseif($log->method_choosen == 'bank' && $log->is_refunded == 'completed' )
                    <small><b>{{ __('Amount') }} <u><i class="fa {{ $o->order->paid_in }}"></i>{{$log->amount}}</u>
                        {{ __('is refunded to your bank ac.') }} <br>
                        @if($log->txn_fee !='')
                          {{ __('Transcation FEE:') }} <i class="fa {{ $o->order->paid_in }}"></i>{{ $log->txn_fee }}
                          
                          @if(isset($log->bank))
                            <br>
                            <small><b>{{ __('Choosen Bank:') }} {{ $log->bank->bankname }} ({{ $log->bank->acno }})</b></small>
                          @else
                            {{ __('Choosen Bank ac deleted !') }}
                          @endif
                        @endif
                        <br>({{ __('TXN ID:') }} {{ $log->transaction_id }})
                      </b></small>
                    @endif
                    @elseif(isset($orderlog))

                

                    @if(in_array($o->id, $orderlog->inv_id))


                    @if($orderlog->method_choosen == 'orignal')

                    <small><b>{{ __('Refund Amount') }} <u><i class="fa {{ $o->order->paid_in }}"></i>

                          @if($o->order->discount !=0)

                          @if($o->order->distype == 'product')


                          @if($o->discount != 0)

                          {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                          @else

                          {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}

                          @endif



                          @elseif($o->order->distype == 'category')

                          @if($o->discount != 0)

                          {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                          @else
                          {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                          @endif

                          @elseif($o->order->distype == 'cart')

                          {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                          @endif

                          @else
                          {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                          @endif

                        </u> {{ __('is refunded to original source') }} ({{ $o->order->payment_method }}).
                        {{ __("IF it don't than it will take 1-2 days to reflect in your account.") }}
                        <br>({{ __("TXN ID:") }} {{ $orderlog->txn_id }})</b></small>
                    @elseif($orderlog->method_choosen == 'bank' && $orderlog->is_refunded == 'pending' )
                    <small><b>{{ __("Refund Amount") }} <u><i class="fa {{ $o->order->paid_in }}"></i>

                          @if($o->order->discount !=0)

                          @if($o->order->distype == 'product')


                          @if($o->discount != 0)

                          {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                          @else

                          {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}

                          @endif



                          @elseif($o->order->distype == 'category')

                          @if($o->discount !=0 || $o->discount !='')

                          {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                          @else
                          {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                          @endif

                          @elseif($o->order->distype == 'cart')

                          {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                          @endif

                          @else
                          {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                          @endif

                        </u>
                        {{ __("is proceeded to your bank ac, amount will be reflected to your bank ac in 14 working days.") }}
                        <br>
                        ({{ __('Refrence No.') }} {{ $orderlog->txn_id }})</b></small>

                   
                    @if(isset($orderlog->bank))
                    <br>
                    <small><b>{{ __("Choosen Bank:") }} {{ $orderlog->bank->bankname }} ({{ $orderlog->bank->acno }})</b></small>
                    @else
                    {{ __("Choosen Bank ac modified or deleted !") }}
                    @endif

                    @endif

                    @if($orderlog->method_choosen == 'bank' && $orderlog->is_refunded == 'completed' )

                    @if(in_array($o->id, $orderlog->inv_id))
                    <small><b>{{ __('Amount') }} <u><i class="fa {{ $o->order->paid_in }}"></i> @if($o->order->discount
                          !=0)

                          @if($o->order->distype == 'product')

                            @if($o->discount != 0)

                              {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                            @else

                              {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}

                            @endif


                          @elseif($o->order->distype == 'category')

                          @if($o->discount != 0)

                          {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                          @else
                          {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                          @endif

                          @else

                          {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}

                          @endif

                          @else
                          {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                          @endif </u> {{ __("is refunded to your bank ac.") }} <br>

                        @if($orderlog->txn_fee !='')
                        {{ __("Transcation FEE:") }} <i class="fa {{ $order->paid_in }}"></i>{{ $orderlog->txn_fee }}
                        @endif
                        <br>({{ __("TXN ID:") }} {{ $orderlog->txn_id }})
                      </b></small>
                    @php
                      $bank = $orderlog->bank;
                    @endphp
                    @if(isset($bank))
                      <br>
                      <small><b>{{ __("Choosen Bank:") }} {{ $bank->bankname }} ({{ $bank->acno }})</b></small>
                    @else
                      {{ __("Choosen Bank ac deleted !") }}
                    @endif
                    @endif
                    @endif
                    @endif

                    @endif

                    @if($o->local_pick =='')
                      @if($o->status == 'pending' || $o->status == 'processed' || $o->status == 'shipped')
                        <a role="button" href="{{ route('track.order',['trackingid' => $o['tracking_id']]) }}" class="mt-2 btn btn-md btn-info">
                          {{ __('staticwords.Track') }}
                        </a>

                        @if($o->courier_channel != '' && $o->tracking_link != '' && $o->exp_delivery_date != '')

                          <p class="mt-2 font-weight-bold">
                            {{__("Your order has been shipped via")}} {{ $o->courier_channel }} {{ __("you can track your package here with ") }} {{ $o->tracking_link }} {{__('and expected delivery date is :date',['date' => date("d-M-Y",strtotime($o->exp_delivery_date))] )}}.
                          </p>

                        @endif

                      @endif
                    @else
                      @if($o->status != 'delivered' && $o->status !='refunded' && $o->status !='ret_ref' && $o->status
                      !='returned' && $o->status != 'canceled' && $o->status != 'return_request')
                      <hr>
                        <div class="col-md-12 card bg-light">
                          
                          <div class="card-body">
                            <p><i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                              {{ __('staticwords.lpickupdatetext') }}
                            </p>
                            <p class="font-weight600">
                              {{ $o->loc_deliv_date == '' ? "Yet to update" : date('d/m/Y',strtotime($o->loc_deliv_date)) }} •
                              <a title="Click to see store address" class="know_more" data-toggle="modal"
                                data-target="#localpickModal{{ $o->id }}">
                                {{__('Expand more')}}
                              </a> </p>
                          </div>

                        </div>
                      @endif
                    @endif
                  </div>
                </div>

                <div class="m-8 col-md-4 offset-sm-2 col-sm-3 offset-3 col-6 m-8-no">
                  <b><i class="{{ $o->order->paid_in }}"></i>

                    @if($o->order->discount !=0)

                    @if($o->order->distype == 'product')

                      {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                      <small class="couponbox"><b>{{ $order->coupon }}</b> applied</small>
                    
                    @elseif($o->order->distype == 'simple_product')

                      {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                      <small class="couponbox"><b>{{ $order->coupon }}</b> applied</small>
                   

                    @elseif($o->order->distype == 'category')


                      @if($o->discount != 0)
                      {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                        <small class="couponbox"><b>{{ $order->coupon }}</b> applied</small>
                      @else
                        {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                      @endif



                    @elseif($o->order->distype == 'cart')

                      {{ price_format(($o->qty*$o->price+$o->tax_amount+$o->shipping)-$o->discount,2) }}
                      <small class="couponbox"><b>{{ $order->coupon }}</b> applied</small>

                    @endif

                    @else
                    {{ price_format($o->qty*$o->price+$o->tax_amount+$o->shipping,2) }}
                    @endif



                  </b><br>
                  <small>({{ __('staticwords.inctax') }})</small>


                </div>
              </div>
            </div>
          </div>
          @if( isset($o->variant) || isset($o->simple_product) )
          <!-- Modal -->
          <div data-backdrop="static" data-keyboard="false" class="z-index99 modal fade" id="proceedCanItem{{ $o->id }}"
            tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                      aria-hidden="true">&times;</span></button>
                  <h5 class="modal-title" id="myModalLabel">{{ __('Cancel Item:') }}
                    @if($o->variant)
                      {{$orivar->products->name}}
                      ({{variantname($o->variant)}})
                    @endif

                    @if($o->simple_product)
                         {{ $o->simple_product->product_name }}
                    @endif

                  </h5>
                </div>

                <div class="modal-body">
                  @if(!in_array($o->status,['shipped','canceled','delivered','Refund Pending','ret_ref','refunded','return_request','shipped']))
                    <form action="{{ route('cancel.item',Crypt::encrypt($o->id)) }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label class="font-weight-normal" for="">{{ __('staticwords.ChooseReason') }} <span
                            class="required">*</span></label>
                        <select class="form-control" required="" name="comment" id="">
                          <option value="">{{ __('staticwords.PleaseChooseReason') }}</option>
                          
                            @forelse(App\RMA::where('status','=','1')->get() as $rma)
                              <option value="{{ $rma->reason }}">{{ $rma->reason }}</option>
                            @empty
                              <option value="Other">{{ __('My Reason is not listed here') }}</option>
                            @endforelse
                            
                        </select>
                      </div>
                      @if($order->payment_method !='COD' && $order->payment_method !='BankTransfer')
                        <div class="form-group">

                          <label class="font-weight-normal" for="">{{ __('staticwords.ChooseRefundMethod') }}: </label>
                          <label class="font-weight-normal"><input onclick="hideBank('{{ $o->id }}')"
                              id="source_check_o{{ $o->id }}" required type="radio" value="orignal"
                              name="source" />{{ __('Orignal Source') }} [{{ $o->order->payment_method }}]
                          </label>&nbsp;&nbsp;
                          @if(Auth::user()->banks()->count())
                          <label class="font-weight-normal"><input onclick="showBank('{{ $o->id }}')"
                              id="source_check_b{{ $o->id }}" required type="radio" value="bank" name="source" />
                            {{ __('In Bank') }}</label>

                            <select name="bank_id" id="bank_id_single{{ $o->id }}" class="display-none form-control">
                              @foreach(Auth::user()->banks as $bank)
                              <option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
                              @endforeach
                            </select>

                          @else
                          <label class="font-weight-normal"><input disabled="disabled" type="radio" /> {{ __('In Bank') }}
                            <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right"
                              title="Add a bank account in My Bank Account" aria-hidden="true"></i></label>
                          @endif

                          

                        </div>


                      @else
                      
                      @if(Auth::user()->banks()->count())
                        <label class="font-weight-normal"><input onclick="showBank('{{ $o->id }}')"
                            id="source_check_b{{ $o->id }}" required type="radio" value="bank"
                            name="source" />{{ __('staticwords.InBank') }}</label>

                            <select name="bank_id" id="bank_id_single{{ $o->id }}" class="form-control display-none">
                              @foreach(Auth::user()->banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
                              @endforeach
                            </select>
                        @else
                        <label class="font-weight-normal"><input disabled="disabled" type="radio" />
                        {{ __('staticwords.InBank') }} <i class="fa fa-question-circle" data-toggle="tooltip"
                          data-placement="right" title="Add a bank account in My Bank Account"
                          aria-hidden="true"></i></label>
                      @endif

                    
                      @endif
                      <div class="alert alert-info">
                        <h5><i class="fa fa-info-circle"></i> {{ __('staticwords.Important') }} !</h5>

                        <ol class="font-weight600 sq">
                          <li>{{ __('staticwords.iforisourcechoosen') }}.
                          </li>

                          <li>
                            {{ __('staticwords.ifbankmethodtext') }}*).
                          </li>

                          <li>{{ __('staticwords.amounttext') }}.</li>

                        </ol>
                      </div>
                      <button type="submit" class="btn btn-md btn-info">
                        {{ __('staticwords.Procced') }}...
                      </button>
                      <p class="help-block">{{ __('staticwords.actionnotdone') }} !</p>
                      <p class="help-block">{{ __('staticwords.windowrefreshwarning') }} !</p>
                    </form>
                  @endif

                </div>


              </div>
            </div>
          </div>

          @endif

          <!-- localpickup modal-->

          @if($o->status != 'delivered' && $o->local_pick != '')

          <div class="modal fade" id="localpickModal{{ $o->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="p-2 modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                      aria-hidden="true">&times;</span></button>
                  <h5 class="modal-title" id="myModalLabel">
                    {{ __('Local Pickup Store Address') }}
                  </h5>
                </div>

                <div class="modal-body">

                  <p>
                      {{ __('Pick your Ordered Item') }} 
                      
                      @if($o->variant)
                        <b>{{ $o->variant->products->name }}
                          <small>({{ variantname($o->variant) }})</small>
                        </b>
                      @else
                        <b>{{ $o->simple_product->product_name }}
                        </b>
                      @endif
                      {{ __('From:') }}</p>

                  @php
                 
                      $country = App\Allcountry::where('id',$o->seller->store->country_id)->first();
                      $state = App\Allstate::where('id',$o->seller->store->state_id)->first()->name;
                      $city = App\Allcity::where('id',$o->seller->store->city_id)->first()->name;
                    
                  @endphp

                  <div class="store_header">
                    @if(isset($o->variant))

                   

                      <h5>{{ $o->variant->products->store->name }}</h5>
                      <p>{{ $o->variant->products->store->address }}</p>
                      <p>{{ $city }}, {{ $state }},{{ $country['nicename'] }}</p>
                      <p>{{ $o->variant->products->store->pin_code }}</p>

                    @elseif($o->simple_product)
                      <h5>{{ $o->seller->store->name }}</h5>
                      <p>{{ $o->seller->store->address }}</p>
                      <p>{{ $city }}, {{ $state }},{{ $country['nicename'] }}</p>
                      <p>{{ $o->seller->store->pin_code }}</p>
                    @endif
                  </div>
                  <p></p>
                  <p>{{ __('on') }}
                    <b>{{ $o->loc_deliv_date !='' ? date('d/m/Y',strtotime($o->loc_deliv_date))  : "Yet to update" }}</b>
                  </p>
                </div>

              </div>
            </div>
          </div>
          @endif

          <!--end-->

          @endforeach

          <div class="card">
            <div class="card-footer">

              <p class="btmText"><b>{{ __('staticwords.Total') }}:</b> <i
                  class="{{ $order->paid_in }}"></i>{{ price_format($order->order_total - $order->gift_charge ) }}</p>

              <p class="btmText"><b>{{ __('staticwords.TotalGiftCharge') }}:</b> <i
                    class="{{ $order->paid_in }}"></i>{{ price_format($order->gift_charge) }}</p>

              <p class="btmText"><b>{{ __('staticwords.HandlingCharge') }}:</b> <i
                  class="{{ $order->paid_in }}"></i>{{ price_format($order->handlingcharge) }}</p>

              <p class="btmText"><b>{{ __('staticwords.OrderTotal') }}:</b> <i
                  class="{{ $order->paid_in }}"></i>{{ price_format(($order->order_total+$order->handlingcharge),2) }}</p>


            </div>
          </div>




      </div>

    </div>


  </div>

</div>

<!-- Change password Modal -->
<div class="z-index99 modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="p-2 modal-title" id="myModalLabel">{{ __('staticwords.ChangePassword') }} ?</h5>
      </div>
      <div class="modal-body">
        <form id="form1" action="{{ route('pass.update',Auth::user()->id) }}" method="POST">
          {{ csrf_field() }}

          <div class="form-group eyeCy">
           
              
          <label class="font-weight-bold" for="confirm">{{ __('staticwords.Oldpassword') }}:</label>
          <input required="" type="password" class="form-control @error('old_password') is-invalid @enderror" placeholder="{{ __('staticwords.Enteroldpassword') }}" name="old_password" id="old_password" />
          
          <span toggle="#old_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

          @error('old_password')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>



          <div class="form-group eyeCy">
         

            
               <label class="font-weight-bold" for="password">{{ __('staticwords.EnterPassword') }}:</label>
                <input required="" id="password" min="6" max="255" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('staticwords.EnterPassword') }}" name="password" minlength="8"/>
              
               <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            
             @error('password')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
         
          
          </div>

          
          
          <div class="form-group eyeCy">
           
              
                <label class="font-weight-bold" for="confirm">{{ __('staticwords.ConfirmPassword') }}:</label>
          <input required="" id="confirm_password" type="password" class="form-control" placeholder="{{ __('staticwords.re-enter-password') }}" name="password_confirmation" minlength="8"/>
          
          <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>

           <p id="message"></p>
          </div>
          

          <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="disabled" title="This action is disabled in demo !" @endif id="test" class="btn btn-md btn-success"><i class="fa fa-save"></i> {{ __('staticwords.SaveChanges') }}</button>
          <button id="btn_reset" data-dismiss="modal" class="btn btn-danger btn-md" type="reset">X {{ __('staticwords.Cancel') }}</button>
        </form>
        
      </div>
      
    </div>
  </div>
</div>

@endsection
@section('script')

<script src="{{ url('js/userorder.js') }}"></script>

@endsection