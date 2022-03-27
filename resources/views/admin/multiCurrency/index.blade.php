@extends('admin.layouts.master-soyuz')
@section('title',__('Currency List & Other Setting | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Currency') }}
@endslot
@slot('menu2')
{{ __("Currency") }}
@endslot

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
          <h5 class="card-title">{{ __('Multiple Currency & Location Setting') }}</h5>
        </div>


        <div class="card-body">
          <ul class="custom-tab-line nav nav-tabs mb-3" id="defaultTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab"
                aria-controls="home-line" aria-selected="true"><i
                  class="feather icon-dollar-sign mr-2"></i>{{ __('Currency List') }}</a>

            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab"
                aria-controls="profile-line" aria-selected="false"><i
                  class="feather icon-globe mr-2"></i>{{ __('Location') }}</a>

            </li>
            <li class="nav-item">
              <a class="nav-link" id="checkout-tab-line" data-toggle="tab" href="#checkout-line" role="tab"
                aria-controls="checkout-line" aria-selected="false"><i
                  class="feather icon-check-circle mr-2"></i>{{ __('Checkout') }}</a>

            </li>
          </ul>
          <div class="tab-content" id="defaultTabContent">

            <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">


              <div class="form-group">

                <h6><i class="fa fa-key" aria-hidden="true"></i> {{__("OPEN EXCHANGE RATE Settings:") }}</h6>
                <hr>
                <small>
                  <a target="__blank" title="Get your keys from here" class="text-muted pull-right text-info"
                    href="https://openexchangerates.org/signup/free"><i class="fa fa-key"></i> {{__("Get Your OPEN EXCHANGE RATE KEY From Here")}}
                  </a>
                </small>

                <form action="{{ url("admin/save/exchange/key") }}" method="POST">
                  @csrf

                  <div class="form-group">
                    <label class="text-dark">{{ __('OPEN EXCHANGE RATE KEY :') }} <span
                        class="text-danger">*</span></label>
                    <br>
                    <input required id="OPEN_EXCHANGE_RATE_KEY" value="{{ env('OPEN_EXCHANGE_RATE_KEY') }}"
                      name="OPEN_EXCHANGE_RATE_KEY" type="text" class="form-control"
                      placeholder="{{ __("Enter Open Exchange Rate Key") }}">

                    <small class="text-muted">
                      <i class="fa fa-question-circle"></i>
                      {{__("It will be used to fetch exchange rates of currenies.")}}
                    </small>
                  </div>

                  <div class="form-group">
                    <button type="reset" class="btn btn-danger-rgba mr-1"><i
                        class="fa fa-ban mr-2"></i>{{ __("Reset")}}</button>
                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled="disabled" @endif
                      class="btn btn-md btn-primary-rgba">
                      <i class="fa fa-check-circle mr-2"></i> {{ __('Save') }}
                    </button>
                  </div>

                </form>
                <hr>

                <label class="text-dark">Enable Multicurrency :</label><br>
                <label class="switch">
                  <input onchange="enabel_currency()" type="checkbox" name="default" id="enabel"
                    {{$auto_geo->enabel_multicurrency=="1"?'checked':''}}>
                  <span class="knob"></span>
                </label>

                <div class="row">

                  <div class="col-md-12">
                    <br>
                    <!-- ------------------------------------ -->
                    <div class="card bg-success-rgba m-b-30">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-12">
                            <h5 class="card-title text-primary mb-1"><i class="feather icon-alert-circle"></i>
                              {{ __('Additioal fee :') }}</h5>
                            <p class="mb-0 text-primary font-14">
                              {{__('If you enter additional fee for ex. 2 and your currency rate is 1 than at time of conversion total conversion rate will be 3 and new rate will be convert accroding to this conversion rate. It will not work on if above toggle is off.')}}
                            </p>
                          </div>

                        </div>
                      </div>
                    </div>
                    <!--------------------------------------  -->

                    <!-- ------------------------------------ -->
                    <div class="card bg-success-rgba m-b-30">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-12">
                            <h5 class="card-title text-primary mb-1"><i class="feather icon-alert-circle"></i>
                              {{ __('Note :') }}</h5>
                            <p class="mb-0 text-primary font-14">
                              {{__("USD Rate display here will be 1 (Because open exchange free api key a/c only consider base currency as USD if you want to upgrade to Open exchange pro a/c than base currency can be changed) but at the time of conversion it take original rate like you converting an amount of 1 EURO to USD than price will be multiplies from Standard rate.")}}
                            </p>
                          </div>

                        </div>
                      </div>
                    </div>
                    <!--------------------------------------  -->

                    <!-- table start -->
                    <div class="card-header">
                      <h5 class="box-title">{{ __('Currencies') }}</h5>
                    </div>
                    <button data-toggle="modal" data-target="#addCurrency" type="button"
                      class="pull-right btn btn-primary-rgba btn-md mt-1 mb-2"><i class="feather icon-plus"></i>
                      {{ __('Add Currency') }}</button>
                  </div>


                  <table id="currencyTable" class="w-100 table table-bordered">

                    <thead>
                      <tr>
                        <th>#</th>
                        <th scope="col">{{ __("Currency") }}</th>
                        <th scope="col">{{ __("Rate") }}</th>
                        <th scope="col">{{ __("Additional Fee") }}</th>
                        <th scope="col">{{ __('Currency Symbol') }}</th>
                        <th scope="col">{{ __("Action") }}</th>
                      </tr>
                    </thead>
                    <tbody>


                    </tbody>

                  </table>


                </div>


                <!-- add currency Modal start -->

                <div class="modal fade" id="addCurrency" tabindex="-1" role="dialog"
                  aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleStandardModalLabel">
                          {{__("Add New Currency")}}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- form start -->
                        <form action="{{ route('multiCurrency.store') }}" method="POST">
                          @csrf

                          <div class="form-group">
                            <label class="text-dark">{{__("Currency Code:")}} <span class="text-danger">*</span></label>
                            <input placeholder="eg. USD" value="{{ old('code') }}" required class="form-control"
                              type="text" name="code">
                            <small class="text-muted">
                              <i class="fa fa-question-circle"></i> {{__("Currency code must be a valid ISO-3 code. Find your currency ISO3 code")}} <a target="__blank"
                                href="https://www1.oanda.com/currency/help/currency-iso-code-country">{{ __("here") }}</a>
                            </small>
                          </div>

                          <div class="form-group">
                            <label class="text-dark">{{ __("Additional Charges:") }}</label>
                            <input placeholder="eg. 0.50" min="0" step="0.01" value="{{ old('add_amount') }}"
                              class="form-control" type="number" name="add_amount">
                          </div>

                          <div class="form-group">
                            <label class="text-dark">{{__("Currency Position:")}} <span class="text-danger">*</span></label>
                            <select data-placeholder="{{ __("Please select currency position") }}" name="position" id="position"
                              class="form-control select2">
                              <option value="">{{ __('Please select currency position') }}</option>
                              <option value="l">{{ __('Left side currency icon') }}</option>
                              <option value="r">{{ __("Right side currency icon") }}</option>
                              <option value="ls">{{ __('Left side with space currency icon') }}</option>
                              <option value="rs">{{ __("Right side with space currency icon") }}</option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label class="text-dark">{{__("Currency Symbol:")}} <span class="text-danger">*</span></label>
                            <br>
                            <div class="input-group">
                              <input id="iconvalue" name="currency_symbol" type="text" class="form-control" required value="">
                              <span class="input-group-append">
                                <button role="iconpicker" id="iconpick" type="button"
                                  class="btn btn-outline-secondary iconpick"></button>
                              </span>
                            </div>
                          </div>

                          <div class="form-group">
                            <button type="submit" class="btn btn-success-rgba btn-md"><i class="fa fa-check-save"></i>
                              {{ __("Save")}}</button>
                            <button type="button" class="btn btn-danger-rgba" data-dismiss="modal">{{ __('Close') }}</button>

                          </div>

                        </form>
                        <!-- form end -->
                      </div>

                    </div>
                  </div>
                </div>
                <!-- add currency Model ended -->


                <div class="form-group">
                  <button type="submit" class="updateRateBtn btn btn-primary-rgba"><i
                      class="fa fa-check-circle mr-2"></i>{{ __("Update Rates")}}</button>
                </div>

              </div>
              <!-- currencylist form end -->
            </div>
            <!-- === currencylist end ======== -->

            <!-- === location start ======== -->
            <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
              <!-- === location form start ======== -->
              @include('admin.multiCurrency.location')
              <!-- === location form end ===========-->
            </div>
            <!-- === location end ======== -->

            <!-- === checkout start ======== -->
            <div class="tab-pane fade" id="checkout-line" role="tabpanel" aria-labelledby="checkout-tab-line">
              <!-- === checkout form start ======== -->
              @include('admin.multiCurrency.checkout')
              <!-- === checkout form end ===========-->
            </div>
            <!-- === checkout end ======== -->


          </div>
        </div><!-- card body end -->

      </div>
    </div>
  </div>
</div>
</div>
@endsection
@section('custom-script')
<script>
  $(function () {
    "use strict";
    var table = $('#currencyTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route("multiCurrency.index") }}',
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'code',
          name: 'currencies.code'
        },
        {
          data: 'rate',
          name: 'currencies.exchange_rate'
        },
        {
          data: 'additional_amount',
          name: 'multi_currencies.add_amount'
        },
        {
          data: 'symbol',
          name: 'multi_currencies.currency_symbol'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },
      ],
      order: [
        [0, 'ASC']
      ]
    });


    $('.updateRateBtn').on('click', function () {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '{{ route("auto.update.rates") }}',
        beforeSend: function () {
          $('#buttontext').html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
        },
        success: function (data) {
          table.draw();
          console.log(data);
          var animateIn = "lightSpeedIn";
          var animateOut = "lightSpeedOut";
          $('#buttontext').html('<i class="fa fa-refresh"></i>');
          swal({
            title: "Success ",
            text: 'Currency Rates Updated !',
            icon: 'success'
          });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
      });
    });

  });
</script>
<script>
  var baseUrl = @json(url('/'));
</script>
<script src="{{ url('js/currency.js') }}"></script>
@endsection