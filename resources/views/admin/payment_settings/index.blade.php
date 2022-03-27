@extends('admin.layouts.master-soyuz')
@section('title',__('Payment Settings |'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Payment Settings') }}
@endslot

@slot('menu1')
{{ __("Payment Settings") }}
@endslot

@slot('menu2')
{{ __("Payment Settings") }}
@endslot

@endcomponent
<div class="contentbar">
    <div class="row">
        <div class="col-md-4">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">
                        {{ __('Payment Settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-paypal-tab" data-toggle="pill"
                                    href="#v-pills-paypal" role="tab" aria-controls="v-pills-paypal"
                                    aria-selected="true"><i class="fa fa-cc-paypal" aria-hidden="true"></i> {{__("Paypal")}}
                                    {{ __('Payment Settings') }}
                                    <i title="{{ $configs->paypal_enable == 1 ? "Active" : "Deactive" }}"
                                    class="float-right mt-1 fa fa-circle {{ $configs->paypal_enable == 1 ? "text-success" : "text-danger" }}"
                                    aria-hidden="true"></i>
                                </a>
                                <a class="nav-link" id="v-pills-braintree-tab" data-toggle="pill"
                                    href="#v-pills-braintree" role="tab" aria-controls="v-pills-braintree"
                                    aria-selected="false"><i class="fa fa-cc-discover" aria-hidden="true"></i> {{__("Braintree Payment Settings")}}
                                    <i title="{{ $configs->braintree_enable == 1 ? "Active" : "Deactive" }}" class="float-right mt-1 fa fa-circle {{ $configs->braintree_enable == 1 ? "text-success" : "text-danger" }}" aria-hidden="true"></i>
                                </a>
                                <a class="nav-link" id="v-pills-stripe-tab" data-toggle="pill" href="#v-pills-stripe"
                                    role="tab" aria-controls="v-pills-stripe" aria-selected="false"><i
                                        class="fa fa-cc-stripe" aria-hidden="true"></i> {{__("Stripe Payment Settings")}}
                                        <i title="{{ $configs->stripe_enable == 1 ? "Active" : "Deactive" }}"
                                            class="float-right mt-1 fa fa-circle {{ $configs->stripe_enable == 1 ? "text-success" : "text-danger" }}"
                                            aria-hidden="true"></i>
                                    </a>
                                <a class="nav-link" id="v-pills-paystack-tab" data-toggle="pill"
                                    href="#v-pills-paystack" role="tab" aria-controls="v-pills-paystack"
                                    aria-selected="false"><i class="fa fa-product-hunt" aria-hidden="true"></i> {{__("Paystack Payment Settings")}}
                                    
                                    <i title="{{ $configs->paystack_enable == 1 ? __("Active") : __("Deactive") }}"
                                        class="float-right mt-1 fa fa-circle {{ $configs->paystack_enable == 1 ? "text-success" : "text-danger" }}"
                                        aria-hidden="true"></i>

                                </a>
                                <a class="nav-link" id="v-pills-payubiz-tab" data-toggle="pill" href="#v-pills-payubiz"
                                    role="tab" aria-controls="v-pills-payubiz" aria-selected="false"><i
                                        class="fa fa-pied-piper-pp" aria-hidden="true"></i> 

                                        {{__("PayuBiz/PayUMoney Payment Settings")}}

                                    <i title="{{ $configs->payu_enable == 1 ? __("Active") : __("Deactive") }}"
                                        class="float-right mt-1 fa fa-circle {{ $configs->payu_enable == 1 ? "text-success" : "text-danger" }}"
                                        aria-hidden="true"></i>
                                </a>
                                <a class="nav-link" id="v-pills-instamojo-tab" data-toggle="pill"
                                    href="#v-pills-instamojo" role="tab" aria-controls="v-pills-instamojo"
                                    aria-selected="false"><i class="fa fa-italic" aria-hidden="true"></i> Instamojo
                                    Payment Settings

                                    <i title="{{ $configs->instamojo_enable == 1 ? __("Active") : __("Deactive") }}"
                                        class="float-right mt-1 fa fa-circle {{ $configs->instamojo_enable == 1 ? "text-success" : "text-danger" }}"
                                        aria-hidden="true"></i>

                                </a>
                                <a class="nav-link" id="v-pills-paytm-tab" data-toggle="pill" href="#v-pills-paytm"
                                    role="tab" aria-controls="v-pills-paytm" aria-selected="false"><i
                                        class="fa fa-credit-card-alt" aria-hidden="true"></i> {{__("Paytm Payment Settings")}}

                                        <i title="{{ $configs->paytm_enable == 1 ? __("Active") : __("Deactive") }}"
                                            class="float-right mt-1 fa fa-circle {{ $configs->paytm_enable == 1 ? "text-success" : "text-danger" }}"
                                            aria-hidden="true"></i>
                                        
                                </a>
                                <a class="nav-link" id="v-pills-razorpay-tab" data-toggle="pill"
                                    href="#v-pills-razorpay" role="tab" aria-controls="v-pills-razorpay"
                                    aria-selected="false"><i class="fa fa-connectdevelop" aria-hidden="true"></i>
                                    {{__("Razorpay Payment Settings")}}

                                    <i title="{{ $configs->razorpay == 1 ? __("Active") : __("Deactive") }}"
                                        class="float-right mt-1 fa fa-circle {{ $configs->razorpay == 1 ? "text-success" : "text-danger" }}"
                                        aria-hidden="true"></i>

                                </a>
                                <a class="nav-link" id="v-pills-payhere-tab" data-toggle="pill" href="#v-pills-payhere"
                                    role="tab" aria-controls="v-pills-payhere" aria-selected="false"><i
                                        class="fa fa-paper-plane-o" aria-hidden="true"></i> {{__("PayHere Payment Settings")}}

                                        <i title="{{ $configs->payhere_enable == 1 ? __("Active") : __("Deactive") }}"
                                            class="float-right mt-1 fa fa-circle {{ $configs->payhere_enable == 1 ? "text-success" : "text-danger" }}"
                                            aria-hidden="true"></i>    
                                </a>
                                <a class="nav-link" id="v-pills-cashfree-tab" data-toggle="pill"
                                    href="#v-pills-cashfree" role="tab" aria-controls="v-pills-cashfree"
                                    aria-selected="false"><i class="fa fa-circle-o" aria-hidden="true"></i> {{__("Cashfree Payment Settings")}}

                                    <i title="{{ $configs->cashfree_enable == 1 ? __("Active") : __("Deactive") }}"
                                        class="float-right mt-1 fa fa-circle {{ $configs->cashfree_enable == 1 ? "text-success" : "text-danger" }}"
                                        aria-hidden="true"></i>

                                </a>
                                <a class="nav-link" id="v-pills-skrill-tab" data-toggle="pill" href="#v-pills-skrill"
                                    role="tab" aria-controls="v-pills-skrill" aria-selected="false"> <i
                                        class="fa fa-circle-o" aria-hidden="true"></i> {{__("Skrill Payment Settings")}}

                                        <i title="{{ $configs->skrill_enable == 1 ? __("Active") : __("Deactive") }}"
                                            class="float-right mt-1 fa fa-circle {{ $configs->skrill_enable == 1 ? "text-success" : "text-danger" }}"
                                            aria-hidden="true"></i>    
                                </a>
                                <a class="nav-link" id="v-pills-omise-tab" data-toggle="pill" href="#v-pills-omise"
                                    role="tab" aria-controls="v-pills-omise" aria-selected="false"> <i
                                        class="fa fa-circle-o" aria-hidden="true"></i> {{__("Omise Payment Settings")}}

                                        <i title="{{ $configs->omise_enable == 1 ? __("Active") : __("Deactive") }}"
                                            class="float-right mt-1 fa fa-circle {{ $configs->omise_enable == 1 ? "text-success" : "text-danger" }}"
                                            aria-hidden="true"></i> 

                                    </a>
                                <a class="nav-link" id="v-pills-moli-tab" data-toggle="pill" href="#v-pills-moli"
                                    role="tab" aria-controls="v-pills-moli" aria-selected="false"> <i
                                        class="fa fa-circle-o" aria-hidden="true"></i> {{__('Moli Payment Settings')}}
                                    
                                        <i title="{{ $configs->moli_enable == 1 ? __("Active") : __("Deactive") }}"
                                            class="float-right mt-1 fa fa-circle {{ $configs->moli_enable == 1 ? "text-success" : "text-danger" }}"
                                            aria-hidden="true"></i> 

                                    </a>
                                <a class="nav-link" id="v-pills-rave-tab" data-toggle="pill" href="#v-pills-rave"
                                    role="tab" aria-controls="v-pills-rave" aria-selected="false"> <i
                                        class="fa fa-circle-o" aria-hidden="true"></i> {{__("Rave Payment Settings")}}

                                        <i title="{{ $configs->rave_enable == 1 ? __("Active") : __("Deactive") }}"
                                            class="float-right mt-1 fa fa-circle {{ $configs->rave_enable == 1 ? "text-success" : "text-danger" }}"
                                            aria-hidden="true"></i> 

                                    </a>
                                <a class="nav-link" id="v-pills-sslcommerze-tab" data-toggle="pill"
                                    href="#v-pills-sslcommerze" role="tab" aria-controls="v-pills-sslcommerze"
                                    aria-selected="false"> <i class="fa fa-circle-o" aria-hidden="true"></i> {{__("SSLCommerze Payment Settings")}}
                                    <i title="{{ $configs->sslcommerze_enable == 1 ? __("Active") : __("Deactive") }}"
                                        class="float-right mt-1 fa fa-circle {{ $configs->sslcommerze_enable == 1 ? "text-success" : "text-danger" }}"
                                        aria-hidden="true"></i> 
                                </a>
                                <a class="nav-link" id="v-pills-aamarpay-tab" data-toggle="pill"
                                    href="#v-pills-aamarpay" role="tab" aria-controls="v-pills-aamarpay"
                                    aria-selected="false"> <i class="fa fa-circle-o" aria-hidden="true"></i> {{__("AAMARPAY Payment Settings")}}

                                    <i title="{{ $configs->enable_amarpay == 1 ? __("Active") : __("Deactive") }}"
                                        class="float-right mt-1 fa fa-circle {{ $configs->enable_amarpay == 1 ? "text-success" : "text-danger" }}"
                                        aria-hidden="true"></i> 
                                </a>
                                <a class="nav-link" id="v-pills-iyzico-tab" data-toggle="pill" href="#v-pills-iyzico"
                                    role="tab" aria-controls="v-pills-iyzico" aria-selected="false"> <i
                                        class="fa fa-circle-o" aria-hidden="true"></i> {{__("iyzico Payment Settings")}}
                                    
                                        <i title="{{ $configs->iyzico_enable == 1 ? __("Active") : __("Deactive") }}"
                                            class="float-right mt-1 fa fa-circle {{ $configs->iyzico_enable == 1 ? "text-success" : "text-danger" }}"
                                            aria-hidden="true"></i> 

                                    </a>

                                @if(Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())
                                @include('dpopayment::admin.list')
                                @endif

                                @if(Module::has('Bkash') && Module::find('Bkash')->isEnabled())
                                @include('bkash::admin.list')
                                @endif

                                @if(Module::has('MPesa') && Module::find('MPesa')->isEnabled())
                                @include('mpesa::admin.list')
                                @endif

                                @if(Module::has('AuthorizeNet') && Module::find('AuthorizeNet')->isEnabled())
                                @include('authorizenet::admin.list')
                                @endif

                                @if(Module::has('Worldpay') && Module::find('Worldpay')->isEnabled())
                                @include('worldpay::admin.list')
                                @endif

                                @if(Module::has('Midtrains') && Module::find('Midtrains')->isEnabled())
                                @include('midtrains::admin.list')
                                @endif

                                @if(Module::has('Paytab') && Module::find('Paytab')->isEnabled())
                                @include('paytab::admin.list')
                                @endif

                                @if(Module::has('SquarePay') && Module::find('SquarePay')->isEnabled())
                                @include('squarepay::admin.list')
                                @endif

                                @if(Module::has('Esewa') && Module::find('Esewa')->isEnabled())
                                @include('esewa::admin.list')
                                @endif

                                @if(Module::has('Smanager') && Module::find('Smanager')->isEnabled())
                                    @include('smanager::admin.list')
                                @endif

                                @if(Module::has('Senangpay') && Module::find('Senangpay')->isEnabled())
                                    @include('senangpay::admin.list')
                                @endif

                                @if(Module::has('Onepay') && Module::find('onepay')->isEnabled())
                                    @include('onepay::admin.list')
                                @endif


                                <a class="nav-link" id="v-pills-bank-tab" data-toggle="pill" href="#v-pills-bank"
                                    role="tab" aria-controls="v-pills-bank" aria-selected="false"> <i
                                        class="fa fa-circle-o" aria-hidden="true"></i> 
                                        {{__('Bank Transfer Payment Settings')}}
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="tab-content" id="v-pills-tabContent">

                                    <!-- paypal tab start -->
                                    <div class="tab-pane fade show active" id="v-pills-paypal" role="tabpanel"
                                        aria-labelledby="v-pills-paypal-tab">
                                        <!-- paypal form start -->
                                        <form action="{{ route('paypal.setting.update') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-header">
                                                    <label class="text-dark">
                                                        {{__("Paypal Payment Settings")}}
                                                    </label>
                                                    <div class="pull-right card-title"><a target="__blank"
                                                            title="{{ __('Get Your Keys From here') }}"
                                                            href="https://developer.paypal.com/home/"><i
                                                                class="fa fa-key" aria-hidden="true"></i> {{ __('Get Your Keys From here') }}</a>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div id="pkey"
                                                        class="form-group {{ $configs->paypal_enable==0 ? 'display-none' : ""}}">
                                                        <label class="text-dark" for="PAYPAL_CLIENT_ID">PAYPAL CLIENT ID
                                                            :</label>
                                                        <input type="text" name="PAYPAL_CLIENT_ID"
                                                            value="{{ env('PAYPAL_CLIENT_ID') }}" class="form-control">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__("Enter your PAYPAL CLIENT ID")}}    
                                                        </small>
                                                    </div>

                                                    <div id="psec"
                                                        class="form-group eyeCy {{ $configs->paypal_enable==0 ? 'display-none' : ""}}">
                                                        <label class="text-dark" for="PAYPAL_SECRET">PAYPAL SECRET ID
                                                            :</label>
                                                        <!-- --------------- -->
                                                        <input id="paypl_secret" id="pps" type="password"
                                                            placeholder="{{ __("enter secret key") }}" class="form-control"
                                                            name="PAYPAL_SECRET" value="{{ env('PAYPAL_SECRET') }}">
                                                        <span toggle="#pps" class="fa fa-fw fa-eye field_icon toggle-password1"></span>
                                                        <!-- --------------- -->
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__('Enter your PAYPAL SECRET ID')}}    
                                                        </small>
                                                    </div>

                                                    <div id="pmode"
                                                        class="form-group {{ $configs->paypal_enable==0 ? 'display-none' : ""}}">
                                                        <label class="text-dark" for="MAIL_ENCRYPTION">PAYPAL MODE
                                                            :</label>
                                                        <input type="text" value="{{ env('PAYPAL_MODE') }}"
                                                            name="PAYPAL_MODE" class="form-control">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__("For Live use")}}
                                                            <b>live</b> {{__("and for Test use")}} <b>test</b> {{ __("as mode") }}</small>
                                                    </div>


                                                    <label class="switch">
                                                        <input class="slider" type="checkbox" name="paypal_check"
                                                            {{ $configs->paypal_enable==1 ? "checked" : "" }} />
                                                        <span class="knob"></span>
                                                    </label><br>
                                                    <small class="txt-desc">({{__("Please Enable For Paypal Payment Gateway")}})</small>
                                                </div><br>

                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="{{ __("This action is disabled in demo !") }}" @endif type="submit"
                                                        class="btn btn-md btn-primary">
                                                        <i class="fa fa-check-circle"></i> {{__("Save Settings")}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- paypal form end -->
                                    </div>
                                    <!-- paypal tab end -->

                                    <!-- BRAINTREE tab start -->
                                    <div class="tab-pane fade" id="v-pills-braintree" role="tabpanel"
                                        aria-labelledby="v-pills-braintree-tab">
                                        <!-- form start -->
                                        <form action="{{ route('bt.setting.update') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-header">
                                                    <label class="text-dark">Braintree Payment Settings</label>
                                                    <div class="pull-right card-title"><a target="__blank"
                                                            title="{{ __('Get Your Keys From here') }}"
                                                            href="https://developers.braintreepayments.com/"><i
                                                                class="fa fa-key" aria-hidden="true"></i> {{ __('Get Your Keys From here') }} </a></div>
                                                </div>

                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <label class="text-dark" for="BRAINTREE_ENV">BRAINTREE
                                                            ENVIRONMENT :</label>
                                                        <input type="text" name="BRAINTREE_ENV"
                                                            value="{{  env('BRAINTREE_ENV') }}" class="form-control">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            Enter your
                                                            BRAINTREE ENVIRONMENT <b>sandbox</b> or <b>live</b></small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="text-dark" for="BRAINTREE_MERCHANT_ID">BRAINTREE
                                                            MERCHANT ID :</label>
                                                        <input type="text" name="BRAINTREE_MERCHANT_ID"
                                                            value="{{  env('BRAINTREE_MERCHANT_ID') }}"
                                                            class="form-control">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            Enter your
                                                            BRAINTREE MERCHANT ID Key</small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="text-dark" for="BRAINTREE_MERCHANT_ID">BRAINTREE
                                                            MERCHANT ACCOUNT ID :</label>
                                                        <input type="text" name="BRAINTREE_MERCHANT_ACCOUNT_ID"
                                                            value="{{  env('BRAINTREE_MERCHANT_ACCOUNT_ID') }}"
                                                            class="form-control">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            Enter your<a target="__blank"
                                                                href="https://articles.braintreepayments.com/control-panel/important-gateway-credentials#merchant-account-id-versus-merchant-id">BRAINTREE
                                                                MERCHANT ACCOUNT ID</a> Key</small>
                                                    </div>

                                                    <div class="form-group eyeCy">
                                                        <label class="text-dark" for="BRAINTREE_PUBLIC_KEY">BRAINTREE
                                                            PUBLIC KEY :</label>
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id21" type="password" class="form-control"
                                                            name="BRAINTREE_PUBLIC_KEY"
                                                            value="{{ env('BRAINTREE_PUBLIC_KEY') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password21"></span>
                                                        <!-- --------------- -->
                                                        <!-- <input type="password" name="BRAINTREE_PUBLIC_KEY"
                                                                     value="{{ env('BRAINTREE_PUBLIC_KEY') }}" class="form-control"
                                                                     id="BRAINTREE_PUBLIC_KEY">
                                                                 <span toggle="#BRAINTREE_PUBLIC_KEY"
                                                                     class="eye fa fa-fw fa-eye field-icon toggle-password"></span> -->
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            Enter your
                                                            BRAINTREE PUBLIC KEY Key</small>
                                                    </div>

                                                    <div class="form-group eyeCy">
                                                        <label class="text-dark" for="BRAINTREE_PRIVATE_KEY">BRAINTREE
                                                            PRIVATE KEY :</label>
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id22" type="password" class="form-control"
                                                            name="BRAINTREE_PRIVATE_KEY"
                                                            value="{{ env('BRAINTREE_PRIVATE_KEY') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password22"></span>
                                                        <!-- --------------- -->
                                                        <!-- <input type="password" name="BRAINTREE_PRIVATE_KEY"
                                                                     value="{{ env('BRAINTREE_PRIVATE_KEY') }}" class="form-control"
                                                                     id="BRAINTREE_PRIVATE_KEY">
                                                                 <span toggle="#BRAINTREE_PRIVATE_KEY"
                                                                     class="eye fa fa-fw fa-eye field-icon toggle-password"></span> -->
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            Enter your
                                                            BRAINTREE PRIVATE KEY Key</small>
                                                    </div>

                                                    <!-- ------------ -->
                                                    <label class="switch">
                                                        <input class="slider" type="checkbox" id="braintree_enable"
                                                            name="braintree_enable"
                                                            {{ $configs->braintree_enable==1 ? "checked" :"" }} />
                                                        <span class="knob"></span>
                                                    </label><br>
                                                    <!-- ------------ -->
                                                    <small class="help-block">(Enable it For Braintree Payment Gateway
                                                        )</small>
                                                </div><br>

                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="This action is disabled in demo !" @endif type="submit"
                                                        class="btn btn-md btn-primary">
                                                        <i class="fa fa-check-circle"></i> Save Settings
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- form end -->
                                    </div>
                                    <!-- BRAINTREE tab end -->

                                    <!-- stripe tab start -->
                                    <div class="tab-pane fade" id="v-pills-stripe" role="tabpanel"
                                        aria-labelledby="v-pills-stripe-tab">
                                        <!-- form start -->
                                        <form action="{{ route('stripe.setting.update') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-header">
                                                    <label class="text-dark">Stripe Payment Settings</label>
                                                    <div class="pull-right card-title"><a target="__blank"
                                                            title="{{ __('Get Your Keys From here') }}"
                                                            href="https://stripe.com/docs/development"><i
                                                                class="fa fa-key" aria-hidden="true"></i> {{ __('Get Your Keys From here') }} </a></div>
                                                </div>

                                                <div class="card-body">

                                                    <div id="skey"
                                                        class="form-group {{ $configs->stripe_enable==0 ? 'display-none' : ''}}">
                                                        <label class="text-dark" for="MAIL_FROM_NAME">STRIPE KEY
                                                            :</label>
                                                        <input type="text" name="STRIPE_KEY"
                                                            value="{{  env('STRIPE_KEY') }}" class="form-control">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            Enter your
                                                            Stripe Key</small>
                                                    </div>

                                                    <div id="sst"
                                                        class="form-group eyeCy {{ $configs->stripe_enable==0 ? 'display-none' : ''}}">
                                                        <label class="text-dark" for="MAIL_FROM_ADDRESS">STRIPE SECRET
                                                            :</label>
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id31" type="password" class="form-control"
                                                            name="STRIPE_SECRET" value="{{ env('STRIPE_SECRET') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password31"></span>
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__("Enter your Stripe secret Key")}}    
                                                        </small>
                                                    </div>

                                                    <label class="switch">
                                                        <input class="slider" type="checkbox" id="toggle1"
                                                            name="strip_check"
                                                            {{ $configs->stripe_enable==1 ? "checked" :"" }} />
                                                        <span class="knob"></span>
                                                    </label><br>
                                                    <small class="help-block">({{__("Enable it For Strip Payment Gateway")}}
                                                        )</small>
                                                </div><br>

                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="{{ __("This action is disabled in demo !") }}" @endif type="submit"
                                                        class="btn btn-md btn-primary">
                                                        <i class="fa fa-check-circle"></i> {{__("Save Settings")}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- form end -->
                                    </div>
                                    <!-- stripe tab end -->

                                    <!-- paystack tab start -->
                                    <div class="tab-pane fade" id="v-pills-paystack" role="tabpanel"
                                        aria-labelledby="v-pills-paystack-tab">
                                        <!-- paystack form start -->
                                        <form action="{{ route('store.paystackupdate.settings') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-header">
                                                    <label class="text-dark">Paystack Payment Settings</label>
                                                    <div class="pull-right card-title"><a target="__blank"
                                                            title="{{ __('Get Your Keys From here') }}"
                                                            href="https://paystack.com/developers"><i class="fa fa-key"
                                                                aria-hidden="true"></i> {{ __('Get Your Keys From here') }}</a>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div class="form-group eyeCy">
                                                        <label class="text-dark" for="PAYSTACK_PUBLIC_KEY">PAYSTACK
                                                            PUBLIC KEY :</label>
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id41" type="password" class="form-control"
                                                            name="PAYSTACK_PUBLIC_KEY"
                                                            value="{{ env('PAYSTACK_PUBLIC_KEY') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password41"></span>
                                                        <!-- --------------- -->
                                                        
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__('Enter your Paystack Public Key')}}    
                                                        </small>
                                                    </div>

                                                    <div class="form-group eyeCy">
                                                        <label class="text-dark" for="PAYSTACK_SECRET_KEY">PAYSTACK
                                                            SECRET KEY :</label>
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id42" type="password" class="form-control"
                                                            name="PAYSTACK_SECRET_KEY"
                                                            value="{{ env('PAYSTACK_SECRET_KEY') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password42"></span>
                                                       
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__("Enter your Paystack Secret Key")}}    
                                                        </small>
                                                    </div>

                                                    <div class="form-group">

                                                        <label class="text-dark">
                                                            PAYSTACK PAYMENT URL: <span class="text-danger">*</span>
                                                        </label>
                                                        <input value="{{ env('PAYSTACK_PAYMENT_URL') }}"
                                                            name="PAYSTACK_PAYMENT_URL" type="text" class="form-control"
                                                            placeholder="{{__("Enter your Paystack payment url")}}">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__("Enter your Paystack payment url")}}    
                                                        </small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="text-dark">
                                                            PAYSTACK MERCHANT EMAIL: <span class="text-danger">*</span>
                                                        </label>
                                                        <input value="{{ env('MERCHANT_EMAIL') }}" name="MERCHANT_EMAIL"
                                                            type="email" class="form-control"
                                                            placeholder="enter merchant email">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__("Enter your Paystack merchant url")}}    
                                                        </small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="text-dark">
                                                            {{__("PAYSTACK MERCHANT EMAIL:")}} <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input readonly value="{{ route('paystack.callback') }}"
                                                                type="text"
                                                                placeholder="https://yoursite.com/public/login/facebook/callback"
                                                                name="PAYSTACK_CALLBACK_URL"
                                                                class="callback-url form-control">
                                                            <span class="input-group-addon" id="basic-addon2">
                                                                <button title="{{ __("Copy") }}" type="button"
                                                                    class="copy btn btn-xs btn-default">
                                                                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__("Copy this Paystack callback url to your app")}}    
                                                        </small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="switch">
                                                            <input class="slider" type="checkbox" id="paystack_enable"
                                                                name="paystack_enable"
                                                                {{ $configs->paystack_enable == 1 ? "checked" :"" }} />
                                                            <span class="knob"></span>
                                                        </label><br>
                                                        <small class="help-block">({{__("Enable it For Paystack Payment Gateway ")}})</small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="{{ __("This action is disabled in demo !") }}" @endif
                                                        class="btn btn-md btn-primary"><i
                                                            class="fa fa-check-circle"></i> {{ __("Save Changes") }}</button>
                                                </div>

                                            </div>
                                        </form>
                                        <!-- paystack form end -->
                                    </div>
                                    <!-- paystack tab start -->

                                    <!-- payubiz tab start -->
                                    <div class="tab-pane fade" id="v-pills-payubiz" role="tabpanel"
                                        aria-labelledby="v-pills-payubiz-tab">
                                        <!-- form start -->
                                        <form action="{{ route('store.payu.settings') }}" method="POST">
                                            @csrf
                                            <div class="card">

                                                <div class="card-header">
                                                    <label class="text-dark" for="MAIL_FROM_NAME"> PayU Money API
                                                        Setting (Indian Payment gateway) :</label>
                                                    <div class="pull-right card-title"><a target="__blank"
                                                            title="{{ __('Get Your Keys From here') }}"
                                                            href="https://developer.payumoney.com/"><i class="fa fa-key"
                                                                aria-hidden="true"></i> {{ __('Get Your Keys From here') }}</a>
                                                    </div>
                                                </div>

                                                <div class="card-body">

                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label class="text-dark" for="">PayU Default :</label>
                                                            <input value="{{ env('PAYU_DEFAULT') }}" type="text"
                                                                name="PAYU_DEFAULT" class="form-control"
                                                                placeholder="PAYU DEFAULT MODE">
                                                            <small class="text-muted"><i
                                                                    class="fa fa-question-circle"></i> {{__("If your account on PayUMoney use")}} <b>money</b> {{ __("else use") }}<b>biz</b></small>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label class="text-dark">PayU Method:</label>
                                                            <input value="{{ env('PAYU_METHOD') }}" type="text"
                                                                name="PAYU_METHOD" class="form-control"
                                                                placeholder="PAYU DEFAULT METHOD">
                                                            <small class="text-muted"><i
                                                                    class="fa fa-question-circle"></i> {{__("For Live use")}}
                                                                <b>secure</b> {{__('and for Test use')}} <b>test</b> {{__('as mode')}}</small>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <div class="eyeCy">
                                                                <label class="text-dark" for="PAYU_MERCHANT_KEY"> PayU
                                                                    Merchant Key :</label>
                                                                <!-- ------------------------ -->
                                                                <input id="pass_log_id51" class="form-control"
                                                                    type="password" name="PAYU_MERCHANT_KEY"
                                                                    value="{{ env('PAYU_MERCHANT_KEY') }}">
                                                                <span toggle="#password-field"
                                                                    class="fa fa-fw fa-eye field_icon toggle-password51"></span>
                                                                <!-- ------------------------ -->

                                                            </div>
                                                            <small class="text-muted"><i
                                                                    class="fa fa-question-circle"></i> 
                                                            {{__("Enter Payu merchant key")}}    
                                                            </small>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <div class="eyeCy">
                                                                <label class="text-dark" for="PAYU_MERCHANT_SALT"> PayU
                                                                    MERCHANT SALT:</label>
                                                                <!-- --------------- -->
                                                                <input id="pass_log_id52" type="password"
                                                                    class="form-control" name="PAYU_MERCHANT_SALT"
                                                                    value="{{ env('PAYU_MERCHANT_SALT') }}">
                                                                <span toggle="#password-field"
                                                                    class="fa fa-fw fa-eye field_icon toggle-password52"></span>
                                                              
                                                            </div>
                                                            <small class="text-muted"><i
                                                                    class="fa fa-question-circle"></i> 
                                                                {{__("Enter Payu merchant salt")}}    
                                                            </small>
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label class="text-dark" for="">PayU Auth Header:</label>
                                                            <input type="text" class="form-control"
                                                                name="PAYU_AUTH_HEADER"
                                                                value="{{ env('PAYU_AUTH_HEADER') }}">
                                                            <small class="text-muted"><i
                                                                    class="fa fa-question-circle"></i> 
                                                            {{__("Enter payu auth header require only if your account is on payumoney")}}    
                                                            </small>
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label for="PAY_U_MONEY_ACC">
                                                                {{__("Is it a PayUMoney account?")}}
                                                            </label><br>

                                                            <label class="switch">
                                                                <input class="slider" type="checkbox"
                                                                    name="PAY_U_MONEY_ACC"
                                                                    {{ env('PAY_U_MONEY_ACC')== true ? "checked" : "" }} />
                                                                <span class="knob"></span>
                                                            </label>

                                                        </div>

                                                    </div>
                                                    <label class="text-dark" for="PAYU_REFUND_URL"> PayU API REFUND URL:</label>
                                                    <input type="text" value="{{ env('PAYU_REFUND_URL') }}"
                                                        name="PAYU_REFUND_URL" id="PAYU_REFUND_URL"
                                                        class="form-control">

                                                    <small class="text-muted">
                                                        • {{__("For")}} <b>Live</b> :
                                                        https://payumoney.com/treasury/merchant/refundPayment
                                                        <br>
                                                        • {{__("For")}} <b>Test</b> :
                                                        https://test.payumoney.com/treasury/merchant/refundPayment
                                                    </small>
                                                    <p></p>

                                                    <label class="switch">
                                                        <input class="slider" type="checkbox" name="payu_chk"
                                                            {{ $configs->payu_enable == "1" ? "checked"  :"" }} />
                                                        <span class="knob"></span>
                                                    </label><br>
                                                    <small class="txt-desc">
                                                        ({{__("Enable it to active Payu Payment gateway")}})
                                                    </small>

                                                </div><br>

                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="{{ __("This action is disabled in demo !") }}" @endif
                                                        class="btn btn-primary btn-md">
                                                        <i class="fa fa-check-circle"></i> {{__("Save Setting")}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- form end -->
                                    </div>
                                    <!-- payubiz tab end -->

                                    <!-- ----- instamojo tab start-------- -->
                                    <div class="tab-pane fade" id="v-pills-instamojo" role="tabpanel"
                                        aria-labelledby="v-pills-instamojo-tab">
                                        <!-- instamojo form start -->
                                        <form action="{{ route('instamojo.update') }}" method="POST">
                                            @csrf
                                            <div class="card">
                                                <div class="card-header">
                                                    <label class="text-dark" for="MAIL_FROM_NAME">Instamojo API
                                                        Setting:</label>
                                                    <div class="float-right card-title"><a target="__blank"
                                                            title="{{ __('Get Your Keys From here') }}"
                                                            href="https://www.instamojo.com/developers/"><i
                                                                class="fa fa-key" aria-hidden="true"></i> {{ __('Get Your Keys From here') }} </a></div>
                                                </div>

                                                <div class="card-body">

                                                    <label class="text-dark" for="INSTAMOJO_URL"> Instamojo API
                                                        URL:</label>
                                                    <input type="text" value="{{ env('IM_URL') }}" name="IM_URL"
                                                        id="INSTAMOJO_URL" class="form-control">

                                                    <small class="text-muted">
                                                        • {{__("For")}} <b>Live</b> {{__("use")}} <a
                                                            href="#">https://instamojo.com/api/1.1/</a>
                                                        <br>
                                                        • {{__("For")}} <b>Test</b> {{__("use")}} <a
                                                            href="">https://test.instamojo.com/api/1.1/</a>
                                                    </small>
                                                    <p></p>

                                                    <label class="text-dark" for="IM_REFUND_URL"> Instamojo API REFUND
                                                        URL:</label>
                                                    <input type="text" value="{{ env('IM_REFUND_URL') }}"
                                                        name="IM_REFUND_URL" id="IM_REFUND_URL" class="form-control">

                                                    <small class="text-muted">
                                                        • {{__("For")}} <b>Live</b> {{__("use")}} <a
                                                            href="#">https://instamojo.com/api/1.1/refunds/</a>
                                                        <br>
                                                        • {{__("For")}} <b>Test</b> {{__("use")}} <a
                                                            href="">https://test.instamojo.com/api/1.1/refunds/</a>
                                                    </small>
                                                    <p></p>

                                                    <div class="eyeCy">
                                                        <label class="text-dark" for="IM_API_KEY"> Private API
                                                            Key:</label>
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id61" type="password" class="form-control"
                                                            name="IM_API_KEY" value="{{ env('IM_API_KEY') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password61"></span>
                                                        
                                                    </div>

                                                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                        {{__("Please Enter Instamojo Private API Key")}} </small>
                                                    <p></p>

                                                    <div class="eyeCy">
                                                        <label class="text-dark" for="IM_AUTH_TOKEN"> Private Auth Token:</label>
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id62" type="password" class="form-control"
                                                            name="IM_AUTH_TOKEN" value="{{ env('IM_AUTH_TOKEN') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password62"></span>
                                                      
                                                    </div>

                                                    <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                        {{__("Please Enter Instamojo Auth Token")}} </small>
                                                    <p></p>

                                                    <!-- -------------------------- -->
                                                    <label class="switch">
                                                        <input class="slider" type="checkbox" name="instam_check"
                                                            {{ $configs->instamojo_enable== "1" ? "checked" : "" }} />
                                                        <span class="knob"></span>
                                                    </label><br>
                                                    

                                                    <small class="txt-desc">({{__("Enable it to active Instamojo Payment gateway")}})</small>
                                                </div><br>

                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="{{ __("This action is disabled in demo !") }}" @endif
                                                        class="btn btn-md btn-primary"><i
                                                            class="fa fa-check-circle"></i>
                                                        
                                                        {{__("Save Setting")}}
                                                        </button>
                                                </div>

                                            </div>

                                        </form>
                                        <!-- instamojo form end -->
                                    </div>
                                    <!-- ------- instamojo tab end ------ -->

                                    <!-- paytm tab start -->
                                    <div class="tab-pane fade" id="v-pills-paytm" role="tabpanel"
                                        aria-labelledby="v-pills-paytm-tab">
                                        <!-- paytm form start -->
                                        <form action="{{ route('post.paytm.setting') }}" method="POST">
                                            @csrf

                                            <div class="card">
                                                <div class="card-header">
                                                    <label class="text-dark"> Paytm API Setting:</label>
                                                    <div class="pull-right panel-title"><a target="__blank"
                                                            title="{{ __('Get Your Keys From here') }}"
                                                            href="https://developer.paytm.com/docs/"><i class="fa fa-key"
                                                                aria-hidden="true"></i> {{ __('Get Your Keys From here') }}</a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
    
                                                    <div class="form-group">
                                                        <label class="text-dark" for="PAYTM_ENVIRONMENT"> PAYTM ENVIRONMENT:
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ env('PAYTM_ENVIRONMENT') }}"
                                                            name="PAYTM_ENVIRONMENT" id="PAYTM_ENVIRONMENT" type="password"
                                                            class="form-control">
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i> {{__("For")}}
                                                            Live use
                                                            <b>production</b> {{__("and for Test use")}} <b>local</b> as
                                                            ENVIRONMENT</small>
                                                    </div>
    
    
                                                    <div class="form-group">
                                                        <div class="eyeCy">
                                                            <label class="text-dark" for="PAYTM_MERCHANT_ID">PAYTM MERCHANT
                                                                ID: <span class="text-danger">*</span></label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id71" type="password" class="form-control"
                                                                name="PAYTM_MERCHANT_ID"
                                                                value="{{ env('PAYTM_MERCHANT_ID') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password71"></span>
                                                           
                                                            <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                                {{__("Enter PAYTM MERCHANT ID")}}    
                                                            </small>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <div class="eyeCy">
                                                            <label class="text-dark" for="PAYTM_MERCHANT_KEY">PAYTM MERCHANT
                                                                KEY: <span class="text-danger">*</span></label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id72" type="password" class="form-control"
                                                                name="PAYTM_MERCHANT_KEY"
                                                                value="{{ env('PAYTM_MERCHANT_KEY') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password72"></span>
                                                          
                                                            <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                                {{__("Enter PAYTM MERCHANT KEY")}}    
                                                            </small>
                                                        </div>
                                                    </div>
    
                                                    <p></p>
                                                    <label class="switch">
                                                        <input class="slider" type="checkbox" name="paytmchk"
                                                            {{ $configs->paytm_enable == 1 ? "checked" : "" }} />
                                                        <span class="knob"></span>
                                                    </label><br>
                                                   
                                                    <small>({{__("Enable to activate Paytm Payment gateway")}})</small>
    
                                                </div><br>
    
                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="{{ __("This action is disabled in demo !") }}" @endif
                                                        class="btn btn-md btn-primary"><i class="fa fa-check-circle"></i>
                                                        {{__("Save Changes")}}    
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                        <!-- paytm form end -->
                                    </div>
                                    <!-- paytm tab end -->

                                    <!-- razorpay tab start -->
                                    <div class="tab-pane fade" id="v-pills-razorpay" role="tabpanel"
                                        aria-labelledby="v-pills-razorpay-tab">
                                        <!-- razorpay form start -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <label> RazorPay API Setting:</label>
                                                    <div class="float-right card-title"><a target="__blank"
                                                            title="{{ __('Get Your Keys From here') }}" href="https://razorpay.com/docs/"><i
                                                                class="fa fa-key" aria-hidden="true"></i> 
                                                                {{__("Get Your Keys From here")}}
                                                            </a>
                                                    </div>
                                                </div>
                                                <form action="{{ route('post.rpay.setting') }}" method="POST">
                                                    @csrf
                                                    <div class="card-body">
        
                                                        <div class="form-group">
                                                            <div class="eyeCy">
                                                                <label class="text-dark" for="RAZOR_PAY_KEY"> RazorPay Key:
                                                                    <span class="text-danger">*</span></label>
                                                                <!-- --------------- -->
                                                                <input id="pass_log_id81" type="password" class="form-control"
                                                                    name="RAZOR_PAY_KEY" value="{{ env('RAZOR_PAY_KEY') }}">
                                                                <span toggle="#password-field"
                                                                    class="fa fa-fw fa-eye field_icon toggle-password81"></span>
                                                                
                                                                <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                                {{__("Enter Razorpay API key")}}    
                                                                </small>
                                                            </div>
                                                        </div>
        
                                                        <div class="form-group">
                                                            <div class="eyeCy">
                                                                <label for="RAZOR_PAY_SECRET"> RazorPay Secret Key: <span
                                                                        class="text-danger">*</span></label>
                                                                <!-- --------------- -->
                                                                <input id="pass_log_id82" type="password" class="form-control"
                                                                    name="RAZOR_PAY_SECRET"
                                                                    value="{{ env('RAZOR_PAY_SECRET') }}">
                                                                <span toggle="#password-field"
                                                                    class="fa fa-fw fa-eye field_icon toggle-password82"></span>
                                                                
                                                                <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                                    {{__("Enter Razorpay secret key")}}    
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <p></p>
                                                        <label class="switch">
                                                            <input class="slider" type="checkbox" name="rpaycheck"
                                                                {{ $configs->razorpay == "1" ? "checked" : "" }} />
                                                            <span class="knob"></span>
                                                        </label><br>
                                                       
                                                        <small class="txt-desc">({{__("Enable to activate Razorpay Payment gateway")}})</small>
                                                        <br><br>
        
                                                    </div>
        
                                                    <div class="form-group">
                                                        <button type="reset" class="btn btn-danger mr-1"><i
                                                                class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                            title="{{ __('This action is disabled in demo !') }}" @endif
                                                            class="btn btn-md btn-primary"><i class="fa fa-check-circle"></i>
                                                        {{__("Save Setting")}}    
                                                        </button>
                                                    </div>
        
                                                </form>
                                            </div>
                                        <!-- razorpay form end -->
                                    </div>
                                    <!-- razorpay tab end -->

                                    <!-- payhere tab start -->
                                    <div class="tab-pane fade" id="v-pills-payhere" role="tabpanel"
                                        aria-labelledby="v-pills-payhere-tab">
                                        <!-- payhere form start -->
                                        <div class="card-body">
                                            <div class="card-header">
                                                <label> Payhere API Setting:</label>
                                                <div class="float-right card-title">
                                                    <a target="__blank" title="Get Your Test Keys From here"
                                                        href="https://sandbox.payhere.lk/account/signup/createaccount"><i
                                                            class="fa fa-key" aria-hidden="true"></i> 
                                                            {{__('Get Your Test Keys From here')}}
                                                    </a>
                                                    |
                                                    <a target="__blank" title="{{__('Get Your Live Keys From here') }}"
                                                        href="https://www.payhere.lk/account/signup/createaccount"><i
                                                            class="fa fa-key" aria-hidden="true"></i> {{__('Get Your Live Keys From here') }}
                                                    </a>
                                                </div>
                                            </div>
    
                                            <form action="{{ route('payhere.settings.update') }}" method="POST">
                                                @csrf
                                                <div class="card-body">
    
                                                    <div class="form-group">
                                                        <div class="eyeCy">
                                                            <label for="PAYHERE_BUISNESS_APP_CODE"> PAYHERE BUISNESS APP
                                                                CODE: <span class="text-danger">*</span></label>
                                                            <input value="{{ env('PAYHERE_BUISNESS_APP_CODE') }}"
                                                                name="PAYHERE_BUISNESS_APP_CODE"
                                                                id="PAYHERE_BUISNESS_APP_CODE" type="text"
                                                                class="form-control">
    
                                                            <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                                {{__("Enter PAYHERE BUISNESS APP CODE")}}    
                                                            </small>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <div class="eyeCy">
                                                            <label for="PAYHERE_APP_SECRET"> PAYHERE APP Secret Key: <span
                                                                    class="text-danger">*</span></label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id91" type="password" class="form-control"
                                                                name="PAYHERE_APP_SECRET"
                                                                value="{{ env('PAYHERE_APP_SECRET') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password91"></span>
                                                            
                                                            <small><i class="fa fa-question-circle"></i> 
                                                                {{__('Enter PAYHERE APP secret key')}}    
                                                            </small>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <div class="eyeCy">
                                                            <label for="PAYHERE_MERCHANT_ID"> PAYHERE MERCHANT ID: <span
                                                                    class="text-danger">*</span></label>
                                                            <input value="{{ env('PAYHERE_MERCHANT_ID') }}"
                                                                name="PAYHERE_MERCHANT_ID" id="PAYHERE_MERCHANT_ID"
                                                                type="text" class="form-control">
    
                                                            <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                                {{__("Enter PAYHERE MERCHANT ID CODE")}}    
                                                            </small>
                                                        </div>
                                                    </div>
    
                                                    <p></p>
                                                    <label>Payhere Payment Enviourment:</label><br>
                                                    <label class="switch">
                                                        <input class="slider" type="checkbox" name="PAYHERE_MODE"
                                                            {{ env('PAYHERE_MODE') == "live" ? "checked" : "" }} />
                                                        <span class="knob"></span>
                                                    </label><br>
                                                    
                                                    <small class="txt-desc">({{__("Choose Payhere payment gateway enviourment.")}})</small>
                                                    <br><br>
    
                                                    <label class="switch">
                                                        <input class="slider" type="checkbox" name="payhere_enable"
                                                            {{ $configs->payhere_enable == "1" ? "checked" : "" }} />
                                                        <span class="knob"></span>
                                                    </label><br>
    
                                                  
    
                                                    <small>({{__("Enable to activate Payhere Payment gateway.")}})</small>
                                                    <br><br>
    
                                                </div>
    
                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="{{ __("This action is disabled in demo !") }}" @endif
                                                        class="btn btn-md btn-primary"><i class="fa fa-check-circle"></i>
                                                    {{__("Save Setting")}}    
                                                    </button>
                                                </div>
    
                                            </form>
                                        </div>
                                        <!-- payhere form end -->
                                    </div>
                                    <!-- payhere tab end -->

                                    <!-- cashfree tab start -->
                                    <div class="tab-pane fade" id="v-pills-cashfree" role="tabpanel"
                                        aria-labelledby="v-pills-cashfree-tab">
                                        <!-- cashfree form start -->
                                        <div class="card">
                                            <div class="card-header">
                                                <label class="text-dark"> Cashfree Payment Settings:</label>
                                                <div class="float-right card-title">
                                                    <a target="__blank" title="{{ __('Get Your Keys From here') }}"
                                                        href="https://merchant.cashfree.com/merchants/signup"><i
                                                            class="fa fa-key" aria-hidden="true"></i> {{__("Get Your Keys From here")}}
                                                    </a>
                                                </div>
                                            </div>
    
                                            <form id="demo-form2" method="post" enctype="multipart/form-data"
                                                action="{{ route('cashfree.settings') }}">
                                                @csrf
    
                                                <div class="panel-body">
    
    
                                                    <div class="form-group">
                                                        <label class="text-dark" for="my-input">CASHFREE APP ID: <span
                                                                class="text-danger">*</span></label>
                                                        <input value="{{ env('CASHFREE_APP_ID') }}" id="my-input"
                                                            class="form-control" type="text" name="CASHFREE_APP_ID">
                                                    </div>
    
                                                    <div class="form-group eyeCy">
                                                        <label class="text-dark" for="my-input">CASHFREE SECRET KEY: <span
                                                                class="text-danger">*</span></label>
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id101" type="password" class="form-control"
                                                            name="CASHFREE_SECRET_KEY"
                                                            value="{{ env('CASHFREE_SECRET_KEY') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password101"></span>
                                                      
                                                    </div>
    
                                                    <div class="form-group">
                                                        <label class="text-dark" for="my-input">CASHFREE END POINT: <span
                                                                class="text-danger">*</span></label>
                                                        <input id="my-input" class="form-control" type="text"
                                                            name="CASHFREE_END_POINT"
                                                            value="{{ env('CASHFREE_END_POINT') }}">
    
                                                        <small class="text-muted">
                                                            <i class="fa fa-question-circle"></i> • {{__("For")}} <b>Live</b> {{__("use")}} :
                                                            https://api.cashfree.com | • {{__("For")}} <b>Test</b> {{__("use")}} :
                                                            https://test.cashfree.com
                                                        </small>
                                                    </div>
    
                                                    <div class="form-group">
    
                                                        <label class="switch">
                                                            <input class="slider" type="checkbox" name="cashfree_enable"
                                                                {{ $configs->cashfree_enable == "1" ? "checked" : "" }} />
                                                            <span class="knob"></span>
                                                        </label><br>
    
                                                      
    
                                                        <small>({{ __("Enable to activate Cashfree Payment gateway.") }})</small>
                                                    </div>
    
                                                </div>
    
                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button type="submit" class="btn btn-primary btn-md">
                                                        <i class="fa fa-check-circle"></i> {{__("Save Settings")}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- cashfree form end -->
                                    </div>
                                    <!-- cashfree tab end -->

                                    <!-- skrill tab start -->
                                    <div class="tab-pane fade" id="v-pills-skrill" role="tabpanel"
                                        aria-labelledby="v-pills-skrill-tab">
                                        <!-- skrill form start -->

                                        <div class="card">
                                            <div class="card-header">

                                                <label class="text-dark"> Skrill Payment Settings:</label>
                                                <div class="float-right card-title">
                                                    <a target="__blank" title="{{ __('Get Your Keys From here') }}"
                                                        href="https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf"><i
                                                            class="fa fa-key" aria-hidden="true"></i> 
                                                            {{__("Get Your Keys From here")}}
                                                    </a>
                                                </div>
    
                                            </div>
    
                                            <form id="demo-form2" method="post" enctype="multipart/form-data"
                                                action="{{ route('skrill.settings') }}">
                                                @csrf
    
                                                <div class="card-body">
    
                                                    <div class="alert alert-success">
                                                        <p><i class="fa fa-info-circle"></i> {{ __("Important Note:") }}</p>
                                                        <ul>
                                                            <li>
                                                                

                                                                {{__("Skrill recommends that you open a merchant test account to help you become familiar with the Automated Payments Interface. Test accounts operate in the live environment, but funds cannot be sent from a test account to a live account.")}}
    
    
                                                            </li>
                                                            <li>
                                                                {{__("To obtain a test account, please register a personal account at")}}
                                                                 <a href="http://www.skrill.com"
                                                                    target="__blank">http://www.skrill.com</a> {{__(", and then contact the Merchant Services team with the account details so that they can enable it.")}}
                                                            </li>
                                                        </ul>
                                                    </div>
    
    
                                                    <div class="form-group">
                                                        <label class="text-dark" for="my-input">SKRILL MERCHANT EMAIL: <span
                                                                class="text-danger">*</span></label>
                                                        <input value="{{ env('SKRILL_MERCHANT_EMAIL') }}" id="my-input"
                                                            class="form-control" type="text" name="SKRILL_MERCHANT_EMAIL">
                                                    </div>
    
                                                    <div class="form-group eyeCy">
                                                        <label class="text-dark" for="my-input">SKRILL API PASSWORD: <span
                                                                class="text-danger">*</span></label>
    
                                                        <!-- --------------- -->
                                                        <input id="pass_log_id111" type="password" class="form-control"
                                                            name="SKRILL_API_PASSWORD"
                                                            value="{{ env('SKRILL_API_PASSWORD') }}">
                                                        <span toggle="#password-field"
                                                            class="fa fa-fw fa-eye field_icon toggle-password111"></span>
                                                       
                                                    </div>
    
                                                    <div class="form-group">
    
                                                        <label class="switch">
                                                            <input class="slider" type="checkbox" id="skrill_enable"
                                                                name="skrill_enable"
                                                                {{ $configs->skrill_enable == "1" ? "checked" : "" }} />
                                                            <span class="knob"></span>
                                                        </label><br>
    
                                                       
    
                                                        <small>({{ __("Enable to activate Skrill Payment gateway.") }})</small>
                                                    </div>
    
                                                </div>
    
                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button type="submit" class="btn btn-primary btn-md"><i
                                                            class="fa fa-check-circle"></i> {{__('Save Settings')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- skrill form end -->
                                    </div>
                                    <!-- skrill tab end -->

                                    <!-- omise tab start -->
                                    <div class="tab-pane fade" id="v-pills-omise" role="tabpanel"
                                        aria-labelledby="v-pills-omise-tab">
                                        <!-- omise form start -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <label> Omise Payment Settings:</label>
                                                    <div class="float-right card-title">
                                                        <a target="__blank" title="{{ __('Get Your Keys From here') }}"
                                                            href="https://dashboard.omise.co/signup?locale=en&origin=direct"><i
                                                                class="fa fa-key" aria-hidden="true"></i> {{ __('Get Your Keys From here') }}</a>
                                                    </div>
                                                </div>
        
                                                <form id="demo-form2" method="post" enctype="multipart/form-data"
                                                    action="{{ route('omise.settings') }}">
                                                    @csrf
        
                                                    <div class="card-body">
        
                                                        <div class="alert alert-success">
                                                            <i class="fa fa-info-circle"></i>
                                                            {{ __('Omise ONLY Support JPY AND THB Currency.') }}
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label for="my-input">OMISE PUBLIC KEY: <span
                                                                    class="text-danger">*</span></label>
                                                            <input value="{{ env('OMISE_PUBLIC_KEY') }}" id="my-input"
                                                                class="form-control" type="text" name="OMISE_PUBLIC_KEY">
                                                        </div>
        
                                                        <div class="form-group eyeCy">
                                                            <label for="my-input">OMISE SECRET KEY: <span
                                                                    class="text-danger">*</span></label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id121" type="password" class="form-control"
                                                                name="OMISE_SECRET_KEY" value="{{ env('OMISE_SECRET_KEY') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password121"></span>
                                                           
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label for="my-input">OMISE API VERSION: <span
                                                                    class="text-danger">*</span></label>
                                                            <input id="my-input" class="form-control" type="text"
                                                                name="OMISE_API_VERSION" value="{{ env('OMISE_API_VERSION') }}">
        
                                                            <small class="text-muted">
                                                                <b>• {{__("GET API VERSION")}} <a target="__blank"
                                                                        href="https://dashboard.omise.co/api-version/edit">{{ __("HERE") }}</a></b>
                                                            </small>
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="switch">
                                                                <input class="slider" type="checkbox" name="omise_enable"
                                                                    {{ $configs->omise_enable == "1" ? "checked" : "" }} />
                                                                <span class="knob"></span>
                                                            </label><br>
        
                                                           
        
                                                            <small class="txt-desc">({{ __("Enable to activate Omise Payment gateway.") }})</small>
                                                        </div>
        
                                                    </div>
        
                                                    <div class="form-group">
                                                        <button type="reset" class="btn btn-danger mr-1"><i
                                                                class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary btn-md"><i
                                                                class="fa fa-check-circle"></i> {{ __("Save Settings") }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        <!-- omise form end -->
                                    </div>
                                    <!-- omise tab end -->

                                    <!-- moli tab start -->
                                    <div class="tab-pane fade" id="v-pills-moli" role="tabpanel"
                                        aria-labelledby="v-pills-moli-tab">
                                        <!-- moli form start -->
                                            <div class="card">
                                                <div class="card-header">

                                                    <label class="text-dark"> Mollie Payment Settings:</label>
                                                    <div class="float-right card-title">
                                                        <a target="__blank" title="{{ __('Get Your Keys From here') }}"
                                                            href="https://www.mollie.com/dashboard/signup?lang=en"><i
                                                                class="fa fa-key" aria-hidden="true"></i> 
                                                            {{__("Get Your Keys From here")}}    
                                                        </a>
                                                    </div>
        
                                                </div>
        
                                                <form id="demo-form2" method="post" enctype="multipart/form-data"
                                                    action="{{ route('moli.settings') }}">
                                                    @csrf
        
                                                    <div class="card-body">
        
                                                        <div class="alert alert-success">
                                                            <i class="fa fa-info-circle"></i>
                                                            {{ __('Moli Not Support INR Currency.') }}
                                                        </div>
        
                                                        <div class="form-group eyeCy">
                                                            <label class="text-dark" for="my-input">MOLLIE KEY: <span
                                                                    class="text-danger">*</span></label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id131" type="password" class="form-control"
                                                                name="MOLLIE_KEY" value="{{ env('MOLLIE_KEY') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password131"></span>
                                                           
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="switch">
                                                                <input class="slider" type="checkbox" name="moli_enable"
                                                                    {{ $configs->moli_enable == "1" ? "checked" : "" }} />
                                                                <span class="knob"></span>
                                                            </label><br>
        
        
                                                            <small>({{__("Enable to activate Moli Payment gateway.")}})</small>
                                                        </div>
        
                                                    </div>
        
                                                    <div class="form-group">
                                                        <button type="reset" class="btn btn-danger mr-1"><i
                                                                class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary btn-md">
                                                            <i class="fa fa-check-circle"></i> {{__("Save Settings")}}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <!-- moli form end -->
                                    </div>
                                    <!-- moli tab end -->

                                    <!-- rave tab start -->
                                    <div class="tab-pane fade" id="v-pills-rave" role="tabpanel"
                                        aria-labelledby="v-pills-rave-tab">
                                        <!-- rave form start -->
                                            <div class="card">
                                                <div class="card-header">

                                                    <label class="text-dark">Rave Payment Settings:</label>
                                                    <div class="float-right card-title">
                                                        <a target="__blank" title="{{ __('Get Your Keys From here') }}"
                                                            href="https://dashboard.flutterwave.com/login"><i class="fa fa-key"
                                                                aria-hidden="true"></i> {{ __('Get Your Keys From here') }}
                                                        </a>
                                                    </div>
        
                                                </div>
        
                                                <form id="demo-form2" method="post" enctype="multipart/form-data"
                                                    action="{{ route('rave.settings') }}">
                                                    @csrf
        
                                                    <div class="card-body">
        
                                                        <div class="alert alert-success">
                                                            <i class="fa fa-info-circle"></i>
                                                            {{ __('Rave ONLY Support NGN Currency.') }}
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="text-dark" for="my-input">RAVE PUBLIC KEY: <span
                                                                    class="text-danger">*</span></label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id141" type="password" class="form-control"
                                                                name="RAVE_SECRET_KEY" value="RAVE_PUBLIC_KEY"
                                                                placeholder="XXXXXXX">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password141"></span>
                                                           
                                                        </div>
        
                                                        <div class="form-group eyeCy">
                                                            <label class="text-dark" for="my-input">RAVE SECRET KEY: <span
                                                                    class="text-danger">*</span></label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id142" type="password" class="form-control"
                                                                name="RAVE_SECRET_KEY" value="{{ env('RAVE_SECRET_KEY') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password142"></span>
                                                           
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="text-dark" for="my-input">RAVE Logo: <span
                                                                    class="text-danger">*</span></label>
                                                            <input placeholder="eg:http://yoursite.com/logo.png" id="my-input"
                                                                class="form-control" type="text" name="RAVE_LOGO"
                                                                value="{{ env('RAVE_LOGO') }}">
        
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="text-dark" for="my-input">RAVE PREFIX: <span
                                                                    class="text-danger">*</span></label>
                                                            <input placeholder="eg: rave" id="my-input" class="form-control"
                                                                type="text" name="RAVE_PREFIX" value="{{ env('RAVE_PREFIX') }}">
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="text-dark" for="my-input">RAVE COUNTRY: <span
                                                                    class="text-danger">*</span></label>
                                                            <input placeholder="eg:United States" id="my-input"
                                                                class="form-control" type="text" name="RAVE_COUNTRY"
                                                                value="{{ env('RAVE_COUNTRY') }}">
                                                        </div>
        
        
                                                        <div class="form-group">
                                                            <label class="text-dark" for="my-input">RAVE ENVIRONMENT: <span
                                                                    class="text-danger">*</span></label><br>
                                                            <label class="switch">
                                                                <input class="slider" type="checkbox" name="RAVE_ENVIRONMENT"
                                                                    {{ env('RAVE_ENVIRONMENT') == "live" ? "checked" : "" }} />
                                                                <span class="knob"></span>
                                                            </label>
                                                           
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="text-dark" for="my-input">{{ __('Status:') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <br>
                                                            <label class="switch">
                                                                <input class="slider" type="checkbox" name="rave_enable"
                                                                    {{ $configs->rave_enable == "1" ? "checked" : "" }} />
                                                                <span class="knob"></span>
                                                            </label><br>
                                                           
                                                            <small class="txt-desc">({{__("Enable to activate Rave Payment gateway.")}})</small>
                                                        </div>
        
                                                    </div>
        
                                                    <div class="panel-footer">
                                                        <button type="reset" class="btn btn-danger mr-1"><i
                                                                class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary btn-md">
                                                            <i class="fa fa-save"></i> {{__("Save Settings")}}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <!-- rave form end -->
                                    </div>
                                    <!-- rave tab end -->

                                    <!-- sslcommerze tab start -->
                                    <div class="tab-pane fade" id="v-pills-sslcommerze" role="tabpanel"
                                        aria-labelledby="v-pills-sslcommerze-tab">
                                        <!-- sslcommerze form start -->
                                        <div class="card">
                                            <div class="card-header">

                                                <label class="text-dark">SSLCommerze Payment Settings:</label>
                                                <div class="float-right card-title">
                                                    <a target="__blank" title="{{ __('Get Your Keys From here') }}"
                                                        href="https://developer.sslcommerz.com/"><i class="fa fa-key"
                                                            aria-hidden="true"></i> {{ __('Get Your Keys From here') }}
                                                    </a>
                                                </div>
    
                                            </div>
    
                                           <div class="card-body">
                                                <form action="{{ route('sslcommerze.settings.update') }}" method="POST">
                                                    @csrf
    
                                                    <div class="form-group">
                                                        <label class="text-dark">API Domain URL:</label>
                                                        <input value="{{ env('API_DOMAIN_URL') }}" type="text"
                                                            class="form-control" placeholder="enter api domain url"
                                                            name="API_DOMAIN_URL">
                                                        <small class="text-muted">
    
                                                            <p>• {{__('For') }} <b>Sandbox</b>, {{__("use")}} "https://sandbox.sslcommerz.com" <br> •
                                                                {{__("For")}} <b>Live</b>, {{__("use")}} "https://securepay.sslcommerz.com"</p>
    
                                                        </small>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <label class="text-dark">STORE ID:</label>
                                                        <input name="STORE_ID" value="{{ env('STORE_ID') }}" type="text"
                                                            class="form-control" placeholder="enter store id">
                                                        <small class="text-muted">
    
                                                            <i class="fa fa-question-circle"></i> {{__("Enter your store id")}}
    
                                                        </small>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <div class="eyeCy">
    
                                                            <label class="text-dark" for="STORE_PASSWORD"> {{ __("Store Password:") }}</label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id151" type="password" class="form-control"
                                                                name="STORE_PASSWORD" id="STORE_PASSWORD"
                                                                value="{{ env('STORE_PASSWORD') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password151"></span>
                                                            
    
                                                        </div>
                                                        <small class="text-muted"><i class="fa fa-question-circle"></i>
                                                            {{__("Enter store password")}}
                                                        </small>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <label class="text-dark">Enable LOCALHOST:</label><br>
                                                        <!-- ---------------------- -->
                                                        <label class="switch">
                                                            <input class="slider" type="checkbox" id="IS_LOCALHOST"
                                                                name="IS_LOCALHOST"
                                                                {{ env('IS_LOCALHOST') == true ? "checked"  :"" }} />
                                                            <span class="knob"></span>
                                                        </label><br>
                                                    
                                                        <small class="txt-desc">({{ __("Enable it to when it's when sandbox mode is true.") }}) </small>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <label class="text-dark" for="">SANDBOX MODE:</label><br>
                                                        <!-- ---------------------- -->
                                                        <label class="switch">
                                                            <input class="slider" type="checkbox" name="SANDBOX_MODE"
                                                                {{ env('SANDBOX_MODE') == true ? "checked"  :"" }} />
                                                            <span class="knob"></span>
                                                        </label><br>
                                                    
                                                        <small class="txt-desc">({{__("Enable or disable sandbox by toggle it.")}})
                                                        </small>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <label class="text-dark" for="">{{ __('Status:') }}</label><br>
                                                        <!-- ---------------------- -->
                                                        <label class="switch">
                                                            <input class="slider" type="checkbox" name="sslcommerze_enable"
                                                                {{ $configs->sslcommerze_enable == 1 ? "checked"  :"" }} />
                                                            <span class="knob"></span>
                                                        </label><br>
                                                    
                                                        <small class="txt-desc">({{__("Active or deactive payment gateway by toggling it.")}}) </small>
                                                    </div>
    
                                                    <div class="form-group">
                                                        <button type="reset" class="btn btn-danger mr-1"><i
                                                                class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-md btn-primary">
                                                            <i class="fa fa-save"></i> {{__("Save Settings")}}
                                                        </button>
                                                    </div>
    
                                                </form>
                                           </div>
                                        </div>
                                        <!-- sslcommerze form end -->
                                    </div>
                                    <!-- sslcommerze tab end -->

                                    <!-- aamarpay tab start -->
                                    <div class="tab-pane fade" id="v-pills-aamarpay" role="tabpanel"
                                        aria-labelledby="v-pills-aamarpay-tab">
                                        <!-- aamarpay form start -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <label class="text-dark">AAMARPAY Payment Settings:</label>
                                                    <div class="pull-right panel-title">
                                                        <a target="__blank" title="{{ __('Get Your Keys From here') }}"
                                                            href="https://aamarpay.com/"><i class="fa fa-key"
                                                                aria-hidden="true"></i> {{ __('Get Your Keys From here') }}
                                                        </a>
                                                    </div>
                                                </div>
        
                                                <form method="post" action="{{ route('change.amarpay.settings') }}">
                                                    @csrf
        
                                                    <div class="card-body">
        
                                                        <div class="alert alert-success">
                                                            <i class="fa fa-info-circle"></i>
                                                            {{ __('AAMARPAY ONLY Support BDT (Taka) Currency.') }}
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="text-dark" for="my-input">AAMARPAY STORE ID: <span
                                                                    class="text-danger">*</span></label>
                                                            <input placeholder="XXXXXXX" value="{{ env('AAMARPAY_STORE_ID') }}"
                                                                id="my-input" class="form-control" type="text"
                                                                name="AAMARPAY_STORE_ID">
                                                        </div>
        
                                                        <div class="form-group eyeCy">
                                                            <label class="text-dark" for="my-input">AAMARPAY KEY: <span
                                                                    class="text-danger">*</span></label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id161" type="password" class="form-control"
                                                                name="AAMARPAY_KEY" value="{{ env('AAMARPAY_KEY') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password161"></span>
                                                            
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="switch">
                                                                <input class="slider" type="checkbox" id="AAMARPAY_SANDBOX"
                                                                    name="AAMARPAY_SANDBOX"
                                                                    {{ env('AAMARPAY_SANDBOX') == "1" ? "checked" : "" }} />
                                                                <span class="knob"></span>
                                                            </label><br>
        
                                                           
        
                                                            <small class="txt-desc">({{__("Enable to activate AAMARPAY sandbox payment.")}})</small>
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label class="switch">
                                                                <input class="slider" type="checkbox" name="enable_amarpay"
                                                                    {{ $configs->enable_amarpay == "1" ? "checked" : "" }} />
                                                                <span class="knob"></span>
                                                            </label><br>
                                                            
                                                            <small class="txt-desc">({{__("Enable to activate AAMARPAY Payment gateway.")}})</small>
                                                        </div>
        
                                                    </div>
        
                                                    <div class="form-group">
                                                        <button type="reset" class="btn btn-danger mr-1"><i
                                                                class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary btn-md">
                                                            <i class="fa fa-check-circle"></i> {{__('Save Settings')}}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <!-- aamarpay form end -->
                                    </div>
                                    <!-- aamarpay tab end -->

                                    <!-- iyzico tab start -->
                                    <div class="tab-pane fade" id="v-pills-iyzico" role="tabpanel"
                                        aria-labelledby="v-pills-iyzico-tab">
                                        <!-- iyzico form start -->
                                        <div class="card">
                                            <div class="card-header">

                                                <label class="text-dark">{{ __("iyzico Payment Settings:") }}</label>
                                                <div class="float-right card-title">
                                                    <a target="__blank" title="Get Your TEST Keys From here"
                                                        href="https://sandbox-merchant.iyzipay.com/auth/register"><i
                                                            class="fa fa-key" aria-hidden="true"></i> {{__('Get Your TEST Keys From here')}}
                                                    </a>
                                                </div>
    
                                            </div>
    
                                            <div class="card-body">
                                                <form action="{{ route('iyzico.settings.update') }}" method="POST">
                                                    @csrf
        
                                                    <div class="form-group">
                                                        <label class="text-dark">IYZIPAY BASE URL:</label>
                                                        <input value="{{ env('IYZIPAY_BASE_URL') }}" type="text"
                                                            class="form-control" placeholder="enter IYZIPAY BASE URL"
                                                            name="IYZIPAY_BASE_URL">
                                                        <small class="text-muted">
                                                            <p>• {{__('For') }} <b>{{ __("Sandbox") }}</b>, {{__("use")}} "https://sandbox-api.iyzipay.com" <br>
                                                                • {{__("For")}} <b>Live</b>, {{__("use")}} "https://api.iyzipay.com"</p>
                                                        </small>
                                                    </div>
        
                                                    <div class="form-group">
                                                        <label class="text-dark">IYZIPAY API KEY:</label>
                                                        <input name="IYZIPAY_API_KEY" value="{{ env('IYZIPAY_API_KEY') }}"
                                                            type="text" class="form-control"
                                                            placeholder="{{ __("Enter IYZIPAY API KEY ID") }}">
                                                        <small class="text-muted">
                                                            <i class="fa fa-question-circle"></i> {{__("Enter your IYZIPAY API KEY")}}
                                                        </small>
                                                    </div>
        
                                                    <div class="form-group">
                                                        <div class="eyeCy">
        
                                                            <label class="text-dark" for="IYZIPAY_SECRET_KEY"> IYZIPAY SECRET
                                                                KEY:</label>
                                                            <!-- --------------- -->
                                                            <input id="pass_log_id171" type="password" class="form-control"
                                                                name="IYZIPAY_SECRET_KEY"
                                                                value="{{ env('IYZIPAY_SECRET_KEY') }}">
                                                            <span toggle="#password-field"
                                                                class="fa fa-fw fa-eye field_icon toggle-password171"></span>
        
                                                           
        
                                                        </div>
                                                        <small><i class="fa fa-question-circle"></i> {{ __("Enter IYZIPAY SECRET KEY password") }}</small>
                                                    </div>
        
                                                    <div class="form-group">
                                                        <label class="text-dark" for="">{{ __('Status:') }}</label><br>
                                                        <label class="switch">
                                                            <input class="slider" type="checkbox" id="iyzico_enable"
                                                                name="iyzico_enable"
                                                                {{ $configs->iyzico_enable == 1 ? "checked"  :"" }} />
                                                            <span class="knob"></span>
                                                        </label><br>
                                                       
                                                        <small class="txt-desc">({{__("Active or deactive payment gateway by toggling it.")}}) </small>
                                                    </div>
        
                                                    <div class="form-group">
                                                        <button type="reset" class="btn btn-danger mr-1"><i
                                                                class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-md btn-primary">
                                                            <i class="fa fa-save"></i> {{__("Save Settings")}}
                                                        </button>
                                                    </div>
        
                                                </form>
                                            </div>
                                        </div>
                                        <!-- iyzico form end -->
                                    </div>
                                    <!-- iyzico tab end -->

                                    <!-- module start -->
                                @if(Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())
                                    @include('dpopayment::admin.tab')
                                @endif
        
                                @if(Module::has('Bkash') && Module::find('Bkash')->isEnabled())
                                    @include('bkash::admin.tab')
                                @endif
        
                                @if(Module::has('MPesa') && Module::find('MPesa')->isEnabled())
                                    @include('mpesa::admin.tab')
                                @endif
        
                                @if(Module::has('AuthorizeNet') && Module::find('AuthorizeNet')->isEnabled())
                                    @include('authorizenet::admin.tab')
                                @endif
        
                                @if(Module::has('Worldpay') && Module::find('Worldpay')->isEnabled())
                                    @include('worldpay::admin.tab')
                                @endif
        
                                @if(Module::has('Midtrains') && Module::find('Midtrains')->isEnabled())
                                    @include('midtrains::admin.tab')
                                @endif
        
                                @if(Module::has('Paytab') && Module::find('Paytab')->isEnabled())
                                    @include('paytab::admin.tab')
                                @endif
        
                                @if(Module::has('Wepay') && Module::find('Wepay')->isEnabled())
                                    @include('wepay::admin.tab')
                                @endif
        
                                @if(Module::has('SquarePay') && Module::find('SquarePay')->isEnabled())
                                    @include('squarepay::admin.tab')
                                @endif
        
                                @if(Module::has('Esewa') && Module::find('Esewa')->isEnabled())
                                    @include('esewa::admin.tab')
                                @endif
        
                                @if(Module::has('Smanager') && Module::find('Smanager')->isEnabled())
                                    @include('smanager::admin.tab')
                                @endif

                                @if(Module::has('Senangpay') && Module::find('Senangpay')->isEnabled())
                                    @include('senangpay::admin.tab')
                                @endif

                                @if(Module::has('Onepay') && Module::find('onepay')->isEnabled())
                                    @include('onepay::admin.tab')
                                @endif

                                    <!-- module end -->

                                    <!-- bank tab start -->
                                    <div class="tab-pane fade" id="v-pills-bank" role="tabpanel"
                                        aria-labelledby="v-pills-bank-tab">
                                        <!-- bank form start -->
                                        <form id="demo-form2" method="post" enctype="multipart/form-data"
                                            action="{{url('admin/bank_details/')}}" data-parsley-validate>
                                            {{csrf_field()}}
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        <label class="text-dark">
                                                            {{__("Bank Payment Settings")}}
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label class="text-dark">
                                                            {{__("Bank Name:")}} <span class="text-danger">*</span>
                                                        </label>

                                                        <input placeholder="{{ __("Please enter bank name") }}" type="text"
                                                            id="first-name" name="bankname"
                                                            class="form-control col-md-7 col-xs-12"
                                                            value="{{$bank->bankname ?? ''}} ">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="text-dark">
                                                            {{__("Branch Name:")}} <span class="text-danger">*</span>
                                                        </label>


                                                        <input placeholder="{{ __("Please enter branch name") }}" type="text"
                                                            id="first-name" name="branchname"
                                                            class="form-control col-md-7 col-xs-12"
                                                            value="{{$bank->branchname ?? ''}} ">

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-dark">
                                                            {{__("IFSC Code:")}} <span class="text-danger">*</span>
                                                        </label>


                                                        <input placeholder="{{ __("Enter IFSC code") }}" type="text" id="first-name"
                                                            name="ifsc" class="form-control col-md-7 col-xs-12"
                                                            value="{{$bank->ifsc ?? ''}} ">

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-dark">
                                                            {{__('Account Number')}} <span class="text-danger">*</span>
                                                        </label>

                                                        <input placeholder="{{ __("Enter account no.") }}" type="text"
                                                            id="first-name" name="account"
                                                            class="form-control col-md-7 col-xs-12"
                                                            value="{{$bank->account ?? ''}}">

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-dark">
                                                            {{ __("Account Name ") }}<span class="text-danger">*</span>
                                                        </label>


                                                        <input placeholder="{{ __("Enter account name") }}" type="text"
                                                            id="first-name" value="{{$bank->acountname ?? ''}}"
                                                            name="acountname" class="form-control col-md-7 col-xs-12">

                                                    </div>

                                                </div>

                                                <div class="form-group">
                                                    <button type="reset" class="btn btn-danger mr-1"><i
                                                            class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                                                        title="{{ __("This action is disabled in demo !") }}" @endif
                                                        class="btn btn-md btn-primary"><i
                                                            class="fa fa-check-circle"></i> {{ __("Save Changes") }}</button>
                                                </div>

                                        </form>
                                        <!-- bank form end -->
                                    </div>
                                    <!-- bank tab end -->



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('script')
<script>
    $(document).on('click', '.toggle-password1', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#paypl_secret");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password21', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id21");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password22', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id22");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password31', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id31");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password41', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id41");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password42', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id42");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password51', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id51");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password52', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id52");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password61', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id61");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });


    $(document).on('click', '.toggle-password62', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id62");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password71', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id71");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password72', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id72");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password81', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id81");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password82', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id82");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password91', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id91");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password101', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id101");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password111', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id111");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password121', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id121");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password131', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id131");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password141', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id141");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password142', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id142");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password151', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id151");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password161', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id161");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password171', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id171");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password181', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id181");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password191', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id191");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password192', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id192");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password201', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id201");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password202', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id202");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password211', function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id211");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

   
</script>
@endpush