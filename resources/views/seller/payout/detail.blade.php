@extends('admin.layouts.sellermastersoyuz')
@section('title', __('View Payout # :payoutid',['payoutid' => $payout->payoutid]))
@section('body')

@component('seller.components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Invoice') }}
@endslot
@slot('menu1')
   {{ __('Completed Payments') }}
@endslot
@slot('menu2')
   {{ __('Invoice') }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <a href="{{ route('seller.payout.index') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot


@endcomponent
<div class="contentbar">                
  <!-- End row -->
  <div class="row justify-content-center">
      <!-- Start col -->
      <div class="col-md-12 col-lg-10 col-xl-10">
          <div class="card m-b-30">
              <div class="card-body">
                  <div class="invoice">
                      <div class="invoice-head">
                          <div class="row">
                              <div class="col-12 col-md-7 col-lg-7">
                                  <div class="invoice-logo">
                                    <a href="{{url('/')}}" class="logo logo-large">
                                      <img src="{{ url('images/genral/'.$genrals_settings->logo) }}" class="img-fluid" alt="logo" />
                                   </a>
                                  </div>
                                  <h4>{{ $title }}</h4>
                                  <p>{{ $seoset['metadata_des'] }}</p>
                              
                                  <p class="mb-0">{{ $genrals_settings['address'] }}</p>
                              </div>
                              <div class="col-12 col-md-5 col-lg-5">
                                  <div class="invoice-name">
                                      <h5 class="text-uppercase mb-3">Invoice</h5>
                                      <p class="mb-1">No :#{{ $inv_cus->prefix.$payout->singleorder->inv_no.$inv_cus->postfix }}</p>
                                      <p class="mb-0"> {{ date('d/m/Y',strtotime($payout->created_at)) }}</p>
                                      <h4 class="text-success mb-0 mt-3"><i class="{{ $defCurrency->currency_symbol }}"></i>
                                        @if($payout->paidvia == 'Bank') {{  sprintf("%.2f", $payout->orderamount+$payout->txn_fee-$payout->txn_fee) }} @else {{  sprintf("%.2f", $payout->orderamount) }} @endif</h4>
                                  </div>
                              </div>
                          </div>
                      </div> 
                      <div class="invoice-billing">
                          <div class="row">
                              <div class="col-sm-6 col-md-4 col-lg-4">
                                  <div class="invoice-address">
                                      <h6 class="mb-3">Form to</h6>
                                      <h6 class="text-muted">{{ $genrals_settings->project_name }}</h6>
                                      <ul class="list-unstyled">
                                          <li> {{ $genrals_settings->address }}</li>  
                                          <li> {{ $genrals_settings->mobile }}</li>  
                                          <li>{{ $genrals_settings->email }}</li>  
                                      </ul>
                                  </div>
                              </div>
                              <div class="col-sm-6 col-md-4 col-lg-4">
                                  <div class="invoice-address">
                                      <h6 class="mb-3">To</h6>
                                      <h6 class="text-muted">{{ $payout->vender->name }}</h6>
                                      <ul class="list-unstyled">
                                          <li>{{ $payout->vender->store->address }}</li>  
                                          <li>  {{ $payout->vender->store->city['name'] }}, {{ $payout->vender->store->state['name'] }}, {{ $payout->vender->store->country['nicename'] }}</li>  
                                          <li>{{ $payout->vender->store->mobile }}</li>  
                                          <li>{{ $payout->vender->store->paypal_email }}</li>  
                                      </ul>
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                  <div class="invoice-address">
                                      <div class="card">
                                          <div class="card-body bg-info-rgba text-center">
                                              <h6>Payment Method</h6>
                                              @if($payout->paidvia == 'Paypal')
                                              <p><i class="mdi mdi-paypal text-info font-40"></i></p>
                                            @endif
                                            @if($payout->paidvia == 'Bank')
                                            <img width="50px" src="{{ url('images/bankt.png') }}" alt="bank_transfer" title="Bank Transfer">
                                            @endif
                                             
                                              <p>via PayPal</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>  
                      <div class="invoice-summary">
                          <div class="table-responsive ">
                              <table class="table table-borderless">
                                  <thead>
                                      <tr>
                                          <th scope="col">#</th>                       
                                          <th scope="col">{{ __('Image') }}</th>
                                          <th scope="col">{{ __('Product') }}</th>
                                          <th scope="col">{{ __('HSN') }}</th>
                                          <th scope="col">{{ __('Qty') }}.</th>
                                          
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>1</td>
                                      @if($payout->singleorder->variant)
                                        <td>
                                          <img height="50px" src="{{url('variantimages/thumbnails/'.$payout->singleorder->variant->variantimages['main_image'])}}" alt=""/>
                                        </td>
                                        <td>{{ $payout->singleorder->variant->products->name }}  
                                          
                                          <small>({{ variantname($payout->singleorder->variant) }})</small></td>
                                        <td>{{ $payout->singleorder->variant->products->hsn }}</td>
                                      @endif
                                      @if($payout->singleorder->simple_product)
                                        <td>
                                          <img height="50px" src="{{url('images/simple_products/'.$payout->singleorder->simple_product->thumbnail)}}"/>
                                        </td>
                                        <td>
                                          {{ $payout->singleorder->simple_product->product_name }}  
                                        </td>
                                        <td>{{ $payout->singleorder->simple_product->hsin }}</td>
                                      @endif
                                      <td>{{ $payout->singleorder->qty }}</td>
                                      
                                    </tr>
                                   
                                      
                                      
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <div class="invoice-summary-total">
                          <div class="row">
                              <div class="col-md-12 order-2 order-lg-1 col-lg-5 col-xl-6">
                                  <div class="order-note">
                                   
         
                                    <b>{{ __('Payout ID') }}:</b> {{ $payout->payoutid}}<br>
                                  @if($payout->paidvia == 'Paypal')
                                    <b>{{ __('Payment Status') }}:</b> {{ $status }}<br>
                                    <b>{{ __('Paypal Batch ID') }}:</b> {{ $payout->txn_id }} <br>
                                  @endif
                                  <b>{{ __('Transcation ID') }}:</b> {{ $txnid }} <br>
                                  <b>{{ __('Payment Method') }}:</b> {{ $payout->paidvia == 'Bank' ? "Bank Transfer [$payout->txn_type]" : $payout->paidvia }}
                                     
                                  </div>
                              </div>
                              <div class="col-md-12 order-1 order-lg-2 col-lg-7 col-xl-6">
                                  <div class="order-total table-responsive ">
                                      <table class="table table-borderless text-right">
                                          <tbody>
                                              <tr>
                                                  <td>{{__("Subtotal")}} :</td>
                                                  <td><i class="{{ $defCurrency->currency_symbol }}"></i> @if($payout->paidvia == 'Bank') {{  sprintf("%.2f", $payout->orderamount+$payout->txn_fee) }} @else {{  sprintf("%.2f", $payout->orderamount) }} @endif</td>
                                              </tr>
                                              @if($payout->txn_fee !='')
                                              @if($payout->paidvia =='Paypal')
                                                <tr>
                                                  <td>{{__("Transcation Charge")}}:</td>
                                                  <td><i class="{{ $defCurrency->currency_symbol }}"></i> {{ $payout->txn_fee }} <i title="{{ __('Already paid by admin not included in this total') }}" class="fa fa-info-circle"></i></td>
                                                </tr>
                                              @else
                                                <tr>
                                                  <td>{{__("Transcation Charge")}}:</td>
                                                  <td> - <i class="{{ $defCurrency->currency_symbol }}"></i> {{ $payout->txn_fee }} <i title="{{ __('Already paid by admin not included in this total') }}" class="fa fa-info-circle"></i></td>
                                                </tr>
                                              @endif
                                              @endif
                                             
                                              <tr>
                                                  <td class="f-w-7 font-18"><h5>{{ __('Total') }}:</h5></td>
                                                  <td class="f-w-7 font-18"><h5><i class="{{ $defCurrency->currency_symbol }}"></i> @if($payout->paidvia == 'Bank') {{  sprintf("%.2f", $payout->orderamount+$payout->txn_fee-$payout->txn_fee) }} @else {{  sprintf("%.2f", $payout->orderamount) }} @endif</h5></td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="invoice-meta">
                          <div class="row">
                              <div class="col-sm-6 col-md-4 col-lg-8">
                                  <div class="invoice-meta-box">
                                    <h6>{{ __('Special Note for this order') }}:</h6>
                                    <p>  @if($payout->paidvia == 'Paypal')
                                      {{__("Payout fee of")}} <i class="cur_sym {{ $defCurrency->currency_symbol }}"></i>{{ $payout->txn_fee }} {{__("is additionally applied by Paypal not included in grand total.")}}
                                      @elseif($payout->paidvia == 'bank')
                                       {{__("Bank Transfer")}} [{{ $payout->txn_type }}] {{__("usually takes 2-3 working days or 48hours for reflect amount in user bank account.")}}
                                      @else
                                        {{__("Amount is already paid to the seller.")}}
                                      @endif</p>
                                  </div>
                              </div>
                             
                              <div class="col-sm-12 col-md-4 col-lg-4">
                                  <div class="invoice-meta-box text-right">
                                    <h6 class="mb-3">{{ __('Contact Us') }}</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="feather icon-aperture mr-2"></i>{{ $genrals_settings->project_name }}</li>  
                                        <li><i class="feather icon-mail mr-2"></i>{{ $genrals_settings->email }}</li>  
                                        <li><i class="feather icon-phone mr-2"></i> {{ $genrals_settings->mobile }}</li>  
                                    </ul>
                                  </div>
                              </div>
                          </div>
                      </div> 
                      <div class="invoice-footer">
                          <div class="row align-items-center">
                              <div class="col-md-6">
                                  <p class="mb-0">{{ __('Thank you for your Business.') }}</p>
                              </div>
                              <div class="col-md-6">
                                  <div class="invoice-footer-btn">
                                  
                                      <a  href="{{ route('vender.print.slip',$payout->id) }}" class="btn btn-primary-rgba py-1 font-16"><i class="feather icon-printer mr-2"></i>
                                        {{__('Print')}}
                                    </a>
                                      
                                  </div>
                              </div>
                          </div>
                      </div>                                   
                  </div>
              </div>
          </div>
      </div>
      <!-- End col -->
  </div>
  <!-- End row -->
</div>

@endsection