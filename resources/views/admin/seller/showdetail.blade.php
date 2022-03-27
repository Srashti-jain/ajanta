@extends('admin.layouts.master-soyuz')
@section('title',__('Payout Detail | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Order Payment Details') }}
@endslot
@slot('menu2')
{{ __("Order Payment Details") }}
@endslot

@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('seller.payouts.index') }}" class="btn btn-primary-rgba"><i
        class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">
  <div class="row">
    
    <div class="col-lg-12">
      @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></p>
        @endforeach
      </div>
      @endif

      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title"><i class="fa fa-globe"></i> {{__("Payout Slip for Order Item")}}
            #{{ $inv_cus->prefix.$order->singleorder->inv_no.$inv_cus->postfix }}
            <small class="pull-right">Date: {{ date('d/m/Y',strtotime($order->created_at)) }}</small></h5>
        </div>
        <div class="card-body">
          <!-- main content start -->

          <div class="row">

            <div class="col-md-6 col-lg-6 col-xl-4">
              <div class="card m-b-30">
                <div class="card-body">
                  <h5 class="card-title font-18">
                    {{__("From")}}
                  </h5>
                  <p class="card-text">
                    <strong>{{ $genrals_settings->project_name }}</strong><br>{{ $genrals_settings->address }}</p>
                  <p class="card-text"><b>Phone :</b> {{ $genrals_settings->mobile }}</p>
                  <p class="card-text"><b>Email :</b> {{ $genrals_settings->email }}</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4">
              <div class="card m-b-30">
                <div class="card-body">
                  @php
                  $seller = App\User::withTrashed()->findorfail($order->sellerid);
                  @endphp
                  <h5 class="card-title font-18">
                    {{__('To')}}
                  </h5>

                  <p class="card-text">
                    <strong><b>{{$seller->name}}</b></strong><br>{{ $seller->store->address }}<br>{{ $seller->store->city['name'] }},
                    {{ $seller->store->state['name'] }},{{ $seller->store->country['nicename'] }}<br></p>
                  <p class="card-text"><b>Phone :</b> @if(isset($seller->mobile)){{$seller->mobile}}@endif</p>
                  <p class="card-text"><b>Email :</b> {{ $seller->email }}</p>

                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-4">
              <div class="card m-b-30">
                <div class="card-body">

                  <h5 class="card-title font-18">{{__('Invoice')}}
                    #{{ $inv_cus->prefix.$order->singleorder->inv_no.$inv_cus->postfix }}</h5>
                  <p class="card-text"><b>{{__("Order ID :")}}
                    </b>#{{ $inv_cus->order_prefix.$order->singleorder->order->order_id }}</p>
                  <p class="card-text"><b>{{ __("Payment Due") }}</b> </p>

                </div>
              </div>
            </div>


          </div>

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>{{ __('Item') }}</th>
                    <th>{{ __("Qty") }}</th>
                    <th>{{  __("Delivered at") }}</th>
                    <th>
                      {{__("Grand Total")}}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    @if($order->singleorder->variant)
                    <td><img height="50px"
                        src="{{url('variantimages/thumbnails/'.$order->singleorder->variant->variantimages['main_image'])}}"
                        alt="" /></td>
                    <td><b>{{$order->singleorder->variant->products->name}}</b>

                      <small>
                        ({{ variantname($order->singleorder->variant) }})
                      </small>

                      <br>
                      <small><b>{{ __("Sold By:") }}</b> {{$order->singleorder->variant->products->store->name}}</small></td>
                    @else
                    <td><img height="50px"
                        src="{{url('images/simple_products/'.$order->singleorder->simple_product->thumbnail)}}"
                        alt="" /></td>
                    <td>

                      <b>{{$order->singleorder->simple_product->product_name}}</b>

                      <br>
                      <small><b>{{ __("Sold By:") }}</b> {{$order->singleorder->simple_product->store->name}}</small>
                    </td>
                    @endif
                    <td>{{$order->singleorder->qty}}</td>
                    <td>{{ date('d-M-Y | h:iA',strtotime($order->singleorder->updated_at)) }}</td>

                    <td>{{ $order->paid_in.' '.sprintf("%.2f",$order->orderamount) }}</td>
                  </tr>

                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->


          <div class="row">
            <!-- accepted payments column -->
            <div class="col-md-6">
              <p class="lead">
                {{__("Payment Methods:")}}
              </p>


              <img src="{{ url('images/paypal.png') }}" alt="Paypal">
              <img width="50px" src="{{ url('images/bankt.png') }}" alt="bank_transfer" title="Bank Transfer">
              <hr>
              <div class="callout callout-success no-shadow">
                <h5><i class="fa fa-info-circle"></i>{{ __('Note:') }}</h5>
                @if($order->singleorder->order->handlingcharge ==0)
                @if($order->singleorder->order->payment_method !='COD')
                <li>{{__("Handling fee")}} {{ $order->paid_in }} {{ sprintf("%.2f",$order->singleorder->order->handlingcharge) }} {{__("already paid out in your account")}}
                </li>
                @endif
                @endif
                <li>
                  {{__('Paypal payout fee additionally applied by Paypal at Transcation time.')}}
                </li>
                <li>{{__("Please refer to this for payout fees for following payment gatways:")}}
                  <a title="Click to open" target="_blank"
                    href="https://developer.paypal.com/docs/payouts/reference/fees/">{{ __("Paypal Payouts") }}</a></li>


                </li>

              </div>


            </div>
            <!-- /.col -->
            <div class="col-md-6">

              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th class="width50">{{ __("Subtotal:") }}</th>
                    <td>+{{ sprintf("%.2f", $order->subtotal) }} <i
                        class="cur_sym {{ $defCurrency->currency_symbol }}"></i>
                      <br>
                      <small>({{__("Gift charge inluded if any")}})</small>
                    </td>
                  </tr>

                  <tr>
                    <th>
                      {{__("Tax:")}}
                    </th>
                    <td>+ {{ sprintf("%.2f",$order->tax) }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i>
                    </td>
                  </tr>

                  <tr>
                    <th>
                      {{__("Shipping:")}}
                    </th>
                    <td>+ {{ sprintf("%.2f",$order->shipping) }} <i
                        class="cur_sym {{ $defCurrency->currency_symbol }}"></i>
                    </td>
                  </tr>

                  <tr>
                    <th>Total </th>
                    <td>+ {{ sprintf("%.2f",$order->orderamount) }} <i
                        class="cur_sym {{ $defCurrency->currency_symbol }}"></i></td>
                  </tr>

                  <tr>
                    <th>
                      {{__("Commission:")}}
                    </th>
                    <td>- @php
                      $commissions = App\CommissionSetting::all();
                      $commissionRate = 0;

                      if($order->singleorder->variant){
                      foreach ($commissions as $commission)
                      {

                      if ($commission->type == "flat")
                      {
                      if ($commission->p_type == "f")
                      {

                      $price = $order->singleorder->variant->products->vender_price + $commission->rate;
                      $offer = $order->singleorder->variant->products->vender_offer_price + $commission->rate;
                      $sellPrice = $price;
                      $sellofferPrice = $offer;
                      $cursym = $defCurrency->currency_symbol;
                      echo "$commissionRate = $commission->rate <i class='cur_sym fa $cursym'></i>";

                      }
                      else
                      {

                      $taxrate = $commission->rate;
                      $price1 = $order->singleorder->variant->products->vender_price;
                      $price2 = $order->singleorder->variant->products->vender_offer_price;
                      $tax1 = ($price1 * (($taxrate / 100)));
                      $tax2 = ($price2 * (($taxrate / 100)));
                      $sellPrice = $price1 + $tax1;
                      $sellofferPrice = $price2 + $tax2;
                      $cursym = $defCurrency->currency_symbol;

                      if (!empty($tax2))
                      {
                      $commissionRate = $tax2;
                      echo sprintf("%.2f",$commissionRate)." <i class='cur_sym fa $cursym'></i>";
                      }
                      else
                      {
                      $commissionRate = $tax1;
                      echo sprintf("%.2f",$commissionRate)." <i class='cur_sym fa $cursym'></i>";
                      }
                      }
                      }
                      else
                      {
                      $cursym = $defCurrency->currency_symbol;
                      $comm = App\Commission::where('category_id',
                      $order->singleorder->variant->products->category_id)->first();

                      if (isset($comm))
                      {
                      if ($comm->type == 'f')
                      {

                      $price = $order->singleorder->variant->products->vender_price + $comm->rate;
                      $offer = $order->singleorder->variant->products->vender_offer_price + $comm->rate;
                      $sellPrice = $price;
                      $sellofferPrice = $offer;
                      $commissionRate = $comm->rate;
                      echo sprintf("%.2f",$commissionRate)."<i class='cur_sym fa $cursym'></i>";

                      }
                      else
                      {
                      $taxrate = $comm->rate;
                      $price1 = $order->singleorder->variant->products->vender_price;
                      $price2 = $order->singleorder->variant->products->vender_offer_price;
                      $tax1 = ($price1 * (($taxrate / 100)));
                      $tax2 = ($price2 * (($taxrate / 100)));
                      $price = $price1 + $tax1;
                      $offer = $price2 + $tax2;
                      $sellPrice = $price;
                      $sellofferPrice = $offer;

                      if (!empty($tax2))
                      {
                      $commissionRate = $tax2;
                      echo sprintf("%.2f",$commissionRate)."<i class='cur_sym fa $cursym'></i>";
                      }
                      else
                      {
                      $commissionRate = $tax1;
                      echo sprintf("%.2f",$commissionRate)."<i class='cur_sym fa $cursym'></i>";
                      }
                      }
                      }
                      }

                      }
                      }

                      if($order->singleorder->simple_product){
                      $commissionRate = $order->singleorder->simple_product->commission_rate;
                      echo $commissionRate.' <i class="cur_sym '.$defCurrency->currency_symbol.'"></i>';
                      }
                      /**/
                      @endphp </td>
                  </tr>
                  <tr>
                    <th>
                      {{__("Payable Amount:")}}
                    </th>
                    @php


                    $total = round(($order->orderamount)-$commissionRate,2);
                    @endphp
                    <td>{{ $total }} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i></td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->


          <!-- this row will not appear when printing -->

          <div class="row">
            <div class="col-md-2">
              <form action="{{ route('seller.pay',['venderid' => $order->sellerid, 'orderid' => $order->id ]) }}"
                method="POST">
                @csrf
                @php
                $amount = Crypt::encrypt(round($order->orderamount-$commissionRate,2));
                @endphp
                <input type="hidden" name="amount" value="{{ $amount }}">
                <button title="{{ __("Click to pay via Paypal") }}" class="btn btn-block btn-primary-rgba"><i
                    class="fa fa-cc-paypal" aria-hidden="true"></i>
                  {{ sprintf("%.2f",$order->orderamount-$commissionRate) }} <i
                    class="cur_sym {{ $defCurrency->currency_symbol }}"></i></button>
              </form>
            </div>
            <div class="col-md-2">

              <button type="button" data-toggle="modal" data-target="#bank_transfer" title="{{ __("Pay via bank transfer") }}"
                class="btn btn-block btn-info-rgba"><i class="fa fa-university" aria-hidden="true"></i>
                {{ sprintf("%.2f",$order->orderamount-$commissionRate) }} <i
                  class="cur_sym {{ $defCurrency->currency_symbol }}"></i></button>

            </div>
            <div class="col-md-2">
              <button data-toggle="modal" data-target="#manualtransfer" class="btn btn-block btn-warning-rgba"><i
                  class="fa fa-circle-o"></i> {{ __("Manual Transfer") }}</button>
            </div>
          </div>



          <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>


<!-- --------------------------------- -->
<!-- Bank Transfer Modal -->
<!-- Modal -->
<div class="modal fade" id="bank_transfer" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info border-info">
        <h5 class="modal-title" id="exampleStandardModalLabel">{{ __("Pay via bank transfer method") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('payout.bank',['venderid' => $order->sellerid, 'orderid' => $order->id ]) }}"
          method="POST">
        <!-- ------------------------------- -->
        <div class="row">
          <div class="col-md-6">
            <div class="card bg-primary-rgba">
              <div class="card-header">
                <h5>{{ __("Bank Account Detail") }}</h5>
              </div>
              <div class="card-body">
                <b>{{ __('Account Name:') }}</b> {{ $seller->store->account_name }} <br>
                <b>{{ __("Account No:") }}</b> {{ $seller->store->account }} <br>
                <b>{{ __("IFSC Code:") }}</b> {{ $seller->store->ifsc }} <br>
                <b>{{ __("Bank Name:") }}</b> {{ $seller->store->bank_name }} <br>
                <b>{{ __('Branch:') }}</b> {{ $seller->store->branch }} <br>
              </div>
            </div>
          </div>
         
            @csrf
            <input type="hidden" name="acno" value="{{ $seller->store->account }}">
            <input type="hidden" name="ifsccode" value="{{ $seller->store->ifsc }}">
            <input type="hidden" name="bankname" value="{{ $seller->store->bank_name }}">
            <input type="hidden" name="acholder" value="{{ $seller->store->account_name }}">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">{{__("Transfer Method:")}} <span class="required">*</span></label>
                <select required="" name="transfer_type" id="" class="form-control">
                  <option value="IMPS">
                    {{__("IMPS")}}
                  </option>
                  <option value="NEFT">
                    {{__("NEFT")}}
                  </option>
                  <option value="RTGS">
                    {{__("RTGS")}}
                  </option>
                </select>
              </div>

              <div class="form-group">
                <div class="form-group">
                  <label for="">
                    {{__("Transfer Fee: (If applied)")}}
                  </label>
                  <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-minus"
                        aria-hidden="true"></i></span>
                    <input id="txn_fee" placeholder="0.00" class="form-control" type="number" step="0.1" name="txn_fee"
                      value="0.00">
                  </div>
                </div>
              </div>

              <div class="form-group">

                <label for="">{{ __('Amount:') }}</label>
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1"><i
                      class="{{ $defCurrency->currency_symbol }}"></i></span>
                  <input id="actualamount" type="number" class="form-control"
                    value="{{ sprintf("%.2f",$order->orderamount-$commissionRate) }}" name="amount" step="0.01">
                </div>

              </div>

            </div>
        </div>
        <!-- ------------------------------- -->
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-success-rgba"> {{__("Pay")}}
          {{ sprintf("%.2f",$order->orderamount-$commissionRate) }}</span> <i
            class="cur_sym {{ $defCurrency->currency_symbol }}"></i></button>
        <button type="button" class="btn btn-danger-rgba" data-dismiss="modal">
          {{__("Cancel")}}
        </button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Manual Transfer Modal -->
<!-- Modal -->
<div class="modal fade" id="manualtransfer" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning border-warning">
        <h5 class="modal-title" id="exampleStandardModalLabel">
          {{__("Saving Record for Manual Transfer.")}}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('manual.seller.payout',['venderid' => $order->sellerid, 'orderid' => $order->id ]) }}"
          method="POST">
          @csrf
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>{{__('Paid via:')}} <small class="help-block">({{__("eg. ") }} Paytm,Paypal,RazarPay etc.)</small></label>
                <input type="text" class="form-control" name="paidvia">
  
              </div>
  
              <div class="form-group">
                <label>{{ __("Transcation ID:") }}</label>
                <input required type="text" class="form-control" name="txn_id">
              </div>
  
            </div>
  
            <div class="col-md-6">
  
  
              <div class="form-group">
                <div class="form-group">
                  <label for="">{{__("Transfer Fee:")}} <small class="help-block">({{__("If applied")}})</small> </label>
                  <div class="input-group">
                      <div class="input-group-prepend" id="basic-addon1">
                        <span class="input-group-text" id="basic-addon1">
                          <i class="fa fa-minus" aria-hidden="true"></i>
                        </span>
                      </div>
                      <input id="txn_fee2" placeholder="0.00" class="form-control" type="number" step="0.1" name="txn_fee"
                      value="0.00">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon1">
                          <i class="{{ $defCurrency->currency_symbol }}"></i>
                        </span>
                      </div>
                  </div>
                </div>
              </div>
  
              <div class="form-group">
  
                <label for="">
                  {{__("Paid Amount:")}}
                </label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="{{ $defCurrency->currency_symbol }}"></i>
                    </span>
                  </div>
                  <input id="actualamount2" type="number" class="form-control"
                    value="{{ sprintf("%.2f",$order->orderamount-$commissionRate) }}" name="amount" step="0.01">
                </div>
  
              </div>
  
            </div>
          </div>

          <div class="form-group">
            <label><input required type="checkbox" name="alreadypaid">
              {{ __("By Saving this record you here by declare that payment has already made to the seller") }}.</label>
          </div>

         
          <button type="submit" class="btn btn-success-rgba btn-md">{{ __('Save Record') }}</button>
          <button type="button" class="btn btn-dark-rgba" data-dismiss="modal">{{ __('Close') }}</button>
          
        </form>
      </div>
      
      

  </div>
</div>
</div>

@endsection
@section('custom-script')
<script>
  var oldamountsent = @json(sprintf("%.2f", $order->orderamount-$commissionRate));
</script>
<script src="{{ url('js/paydetail.js') }}"></script>
@endsection