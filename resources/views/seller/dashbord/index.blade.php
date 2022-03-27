@extends('admin.layouts.sellermastersoyuz')
@section('title',__('Dashboard'))
@section('body')

<div class="breadcrumbbar">
  <div class="row align-items-center">
    <div class="col-md-8 col-lg-8">

      <div class="breadcrumb-list">
        <ol class="breadcrumb">
          <h4>
            <li class="breadcrumb-item text-dark">
              {{__('Dashboard')}}
            </li>
          </h4>

        </ol>
      </div>
    </div>

  </div>
</div>

<div class="contentbar">
  <!-- Start row -->
  <div class="row">
    <!-- Start col -->
    <div class="col-lg-12 col-xl-12">
      @if(Module::has('SellerSubscription') && Module::find('SellerSubscription')->isEnabled())
      <div class="card mb-3">
        <div class="card-header">
          <h4 class="card-title">
            {{ __("Current Subscription") }}
          </h4>
        </div>
        <div class="card-body">
          <h5><b>{{ __("Plan Name:") }}</b>
            {{ auth()->user()->activeSubscription->plan ? auth()->user()->activeSubscription->plan->name : __("seller.Plan not found !") }}
          </h5>
          <h5><b>{{ __("Product Upload Limit:") }}</b>
            {{ auth()->user()->activeSubscription->plan ? auth()->user()->products()->count().' / '.auth()->user()->activeSubscription->plan->product_create : __("seller.Plan not found !") }}
          </h5>
          <h5><b>{{ __("Expires ON:") }}</b>
            {{ auth()->user()->activeSubscription ?  date('d/m/Y h:i A',strtotime(auth()->user()->activeSubscription->end_date)) : __("seller.Not found !")}}
          </h5>
          <h5><b>{{ __("CSV Product Upload:") }}</b>
            {{ auth()->user()->activeSubscription->plan && auth()->user()->activeSubscription->plan->csv_product ? __("seller.YES")  : __("seller.NO")}}
          </h5>
        </div>
        <div class="card-footer">
          <a class="text-center text-muted" href="{{ route('seller.my.subscriptions') }}">
            <b> {{__("View More")}}</b>
          </a>
        </div>
      </div>
      @endif
      <!-- Start row -->
      <div class="row">
        <!-- Start col -->
        <div class="col-lg-12 col-xl-4 col-12">
          <div class="card m-b-30 bg-success-rgba shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <h4>{{ count($products) + count($simple_products) }}</h4>
                  <p class="font-14 mb-0">{{__('Total products')}}</p>
                </div>
                <div class="col-4 animate__animated animate__fadeIn animate__delay-1s">
                  <a href="{{ route('my.products.index') }}"> <i
                      class="text-success feather icon-shopping-bag iconsize"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-xl-4 col-12">
          <div class="card m-b-30 bg-primary-rgba shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <h4>{{count($orders)}}</h4>
                  <p class="font-14 mb-0"> {{__("Total orders")}}</p>
                </div>
                <div class="col-4 animate__animated animate__fadeIn animate__delay-1s">
                  <a href="{{url('seller/orders')}}"> <i class="text-primary feather icon-shopping-cart iconsize"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-xl-4 col-12">
          <div class="card m-b-30 bg-danger-rgba shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <h4>{{ $totalcanorders }}</h4>
                  <p class="font-14 mb-0"> {{__("Total canceled orders")}}</p>
                </div>
                <div class="col-4 animate__animated animate__fadeIn animate__delay-1s">
                  <a href="{{ url('seller/ord/cancelled') }}"> <i
                      class="text-danger feather icon-x-circle iconsize"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-xl-4 col-12">
          <div class="card m-b-30 bg-info-rgba shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <h4>{{ $totalreturnorders }}</h4>
                  <p class="font-14 mb-0">{{__('Total returned orders')}}</p>
                </div>
                <div class="col-4 animate__animated animate__fadeIn animate__delay-1s">
                  <a href="{{ url('seller/return/orders') }}"> <i class="text-info feather icon-truck iconsize"></i>
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="col-lg-12 col-xl-4 col-12">
          <div class="card m-b-30 bg-warning-rgba shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <h4>{{ $money }}</h4>
                  <p class="font-14 mb-0">{{__("Total earnings")}}</p>
                </div>
                <div class="col-4 animate__animated animate__fadeIn animate__delay-1s">
                  <a href="{{ route('seller.payout.index') }}"> <i
                      class="text-warning feather icon-dollar-sign iconsize"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-xl-4 col-12">
          <div class="card m-b-30 bg-secondary-rgba shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <h4>{{ $payouts }}</h4>
                  <p class="font-14 mb-0">{{__("Received payouts")}}</p>
                </div>
                <div class="col-4 animate__animated animate__fadeIn animate__delay-1s">
                  <a href="{{ route('seller.payout.index') }}"> <i
                      class="text-secondary feather icon-bar-chart-2 iconsize"></i>
                  </a>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12">
          {!! $sellerorders->container() !!}
        </div>

        <div class="col-lg-12 col-xl-12 mt-4">
          <div class="card m-b-30">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-9">
                  <h5 class="card-title mb-0">{{__("Latest Orders")}}</h5>
                </div>
                <div class="col-3">
                  <div class="dropdown">
                    <button class="btn btn-link p-0 font-18 float-right" type="button" id="upcomingTask"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        class="feather icon-more-horizontal-"></i></button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="upcomingTask">
                      <a class="dropdown-item font-13" href="{{ url('seller/orders') }}">
                        {{__('View All')}}
                      </a>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-borderd">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __("Order ID") }}</th>
                      <th>{{ __("Customer name") }}</th>
                      <th>{{ __("Qty") }}</th>
                      <th>{{ __("Price") }}</th>
                      <th>{{ __('Date') }}</th>
                    </tr>
                  </thead>

                  <tbody>

                    @foreach($orders as $key=> $order)

                    @php
                    $x = App\InvoiceDownload::where('order_id','=',$order->id)->where('vender_id',auth()->id())->get();

                    $total = 0;
                    $qty = $x->sum('qty');

                    foreach ($x as $value) {

                    $total = $total+$value->qty*$value->price+$value->tax_amount+$value->shipping;

                    }
                    @endphp

                    <tr>

                      <td>{{$key+1}}</td>
                      <td><a title="View order"
                          href="{{ route('seller.view.order',$order->order_id) }}">#{{ $inv_cus->order_prefix.$order->order_id }}</a>
                      </td>
                      <td>{{ $order->user->name }}</td>
                      <td>{{ $qty }}</td>
                      <td><i class="{{ $order->paid_in }}"></i>{{ $total }}</td>
                      <td>{{ date('d-M-Y',strtotime($order->created_at)) }}</td>

                    </tr>

                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-12 ">
          {!! $sellerpayoutdata->container() !!}
        </div>


        @if($dashsetting->rct_pro ==1)
        <div class="col-md-8 mt-4">
          <div class="card m-b-30">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-9">
                  <h5 class="card-title mb-0">{{ __("Recently Added Products") }}</h5>
                </div>
                <div class="col-3">
                  <div class="dropdown">
                    <button class="btn btn-link p-0 font-18 float-right" type="button" id="upcomingTask"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        class="feather icon-more-horizontal-"></i></button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="upcomingTask">
                      <a class="dropdown-item font-13" href="{{ url('seller/orders') }}">
                        {{__('View All')}}
                      </a>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">

                @foreach($products->take($dashsetting->max_item_pro) as $pro)
                @foreach($pro->subvariants as $key=> $sub)
                @if($sub->def == 1)
                @php
                $var_name_count = count($sub['main_attr_id']);
                $name = array();
                $var_name;
                $newarr = array();
                for($i = 0; $i<$var_name_count; $i++){ $var_id=$sub['main_attr_id'][$i];
                  $var_name[$i]=$sub['main_attr_value'][$var_id]; $name[$i]=App\ProductAttributes::where('id',$var_id)->
                  first();

                  }


                  try{
                  $url =
                  url('/details/').'/'.$pro->id.'?'.$name[0]['attr_name'].'='.$var_name[0].'&'.$name[1]['attr_name'].'='.$var_name[1];
                  }catch(Exception $e)
                  {
                  $url = url('/details/').'/'.$pro->id.'?'.$name[0]['attr_name'].'='.$var_name[0];
                  }

                  @endphp
                  <div class="col-12 mb-2">
                    <div class="row">
                      <div class="col-md-2">
                        @if(count($pro->subvariants)>0)

                        @if($sub->variantimages)
                        <img width="70px" class="object-fit"
                          src="{{ url('variantimages/thumbnails/'.$sub->variantimages['main_image']) }}"
                          alt="{{ $sub->variantimages['main_image'] }}" title="{{ $pro->name }}">
                        @else
                        <img width="70px" class="object-fit" src="{{ Avatar::create($pro->name) }}"
                          title="{{ $pro->name }}">
                        @endif

                        @endif
                      </div>

                      <div class="col-md-8">
                        <b><a href="{{ url($url) }}" class="text-info">{{ $pro->name }}
                          </a></b> <br>
                        <small>
                          {{ substr(strip_tags($pro->des),0,150)}}{{strlen(strip_tags($pro->des))>150 ? "..." : "" }}</small>

                      </div>
                      <div class="col-md-2">
                        <span class="badge badge-success">@if($pro->vender_offer_price !=null)
                          {{ $pro->price_in }} {{ $pro->vender_offer_price+$sub->price }}
                          @else
                          {{ $pro->price_in }} {{ $pro->vender_price+$sub->price }}
                          @endif</span>
                      </div>
                    </div>
                  </div>
                  @endif
                  @endforeach
                  @endforeach
              </div>
            </div>
          </div>
        </div>

        @endif


        <div class="col-md-4 mt-4 mb-4">
          {!! $piechart->container() !!}
        </div>


      </div>
    </div>
  </div>
</div>
@endsection


@section('custom-script')
<script src="{{ url('front/vendor/js/highcharts.js') }}" charset="utf-8"></script>
{!! $sellerorders->script() !!}
{!! $sellerpayoutdata->script() !!}
{!! $piechart->script() !!}
@endsection