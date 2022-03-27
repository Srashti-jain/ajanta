@extends('admin.layouts.master-soyuz')
@section('title',__('SMS Settings | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('SMS Settings') }}
@endslot
@slot('menu2')
{{ __("SMS Settings") }}
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
                    <h5 class="box-title">{{ __('SMS Channels') }}</h5>
                </div>
                <div class="card-body">
                    <!-- main content start -->
                    <div class="form-group">
                        <label class="text-dark">{{ __('Enable :') }}<span class="text-danger">*</span></label>
                        <br>
                        <label class="switch">
                            <input class="sms_enable" id="login_unicode"
                                {{ $config->sms_channel == 1 ? "checked" : "" }} type="checkbox">
                            <span class="knob"></span>
                        </label>
                    </div>

                    <div id="mainsmsbox" style="display: {{ $config->sms_channel == 1 ? "block" : "none" }};">
                        <div class="form-group">
                            <label class="text-dark">{{ __('Please select sms channel :') }}<span
                                    class="text-danger">*</span></label>
                            <select data-placeholder="Please select sms channel"
                                class="msg_channel form-control select2" name="DEFAULT_SMS_CHANNEL" id="msg_channel">
                                <option value="">Please select sms channel</option>
                                <option {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'selected' : '' }} value="twillo">
                                    Twillo</option>
                                <option {{ env('DEFAULT_SMS_CHANNEL') == 'msg91' ? 'selected' : '' }} value="msg91">
                                    MSG-91</option>
                                @if(Module::has('MimSms') && Module::find('MimSms')->isEnabled())
                                <option {{ env('DEFAULT_SMS_CHANNEL') == 'mim' ? 'selected' : '' }} value="mim">MimSMS
                                </option>
                                @endif
                                @if(Module::has('Exabytes') && Module::find('Exabytes')->isEnabled())
                                <option {{ env('DEFAULT_SMS_CHANNEL') == 'exabytes' ? 'selected' : '' }} value="exabytes">
                                    Exabytes</option>
                                @endif
                            </select>
                        </div>



                        <div style="display: {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'block' : 'none' }};"
                            id="twilloBox">

                            <div class="row">
                                <div class="col-md-12  ">
                                    <div class="p-2 mb-2 bg-success rounded text-white">
                                        <i class="fa fa-info-circle"></i> {{ __('Important note :') }}
                                        <ul>
                                            <li>{{ __('Twillo Only send SMS if user did not opt for DND Services.') }}</li>
                                            <li>
                                                {{__("Twillo trail will send sms only to verified no.")}}
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>



                            <form action="{{ route('change.twilo.settings') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('TWILIO SID :') }}<span
                                                    class="text-danger">*</span></label>
                                            <input {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'required' : '' }}
                                                name="TWILIO_SID" type="text" value="{{ env('TWILIO_SID') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('TWILIO AUTH TOKEN :') }}<span
                                                    class="text-danger">*</span></label>
                                            <input {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'required' : '' }}
                                                name="TWILIO_AUTH_TOKEN" type="text"
                                                value="{{ env('TWILIO_AUTH_TOKEN') }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('TWILIO NUMBER :') }}<span
                                                    class="text-danger">*</span></label>
                                            <input {{ env('DEFAULT_SMS_CHANNEL') == 'twillo' ? 'required' : '' }}
                                                name="TWILIO_NUMBER" type="text" value="{{ env('TWILIO_NUMBER') }}"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i>
                                                {{ __("Reset")}}</button>
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-check-circle"></i> {{ __("Save") }}</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div style="display: {{ env('DEFAULT_SMS_CHANNEL') == 'msg91' ? 'block' : 'none' }};"
                            id="msg91Box">
                            <div class="row">
                                <div class="col-md-12  ">
                                    <div class="p-2 mb-2 bg-success rounded text-white">
                                        <i class="fa fa-info-circle"></i> {{ __('Important note :') }}
                                        <ul>
                                            <li>
                                                {{__("MSG91 Only send SMS if user did not opt for DND Services.")}}
                                            </li>
                                            <li>
                                                {{__("If msg not delivering to customer than make sure he/she updated phonecode in his/her profile.")}}
                                            </li>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <form action="{{ route('sms.update.settings') }}" method="POST">
                                @csrf

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group eyeCy">
                                            <label class="text-dark">{{ __('MSG91 Auth Key :') }}<span
                                                    class="text-danger">*</span></label>

                                            <input id="MSG91_AUTH_KEY" type="password" placeholder="enter secret key"
                                                class="form-control" name="MSG91_AUTH_KEY"
                                                value="{{ env('MSG91_AUTH_KEY') }}">
                                            <span toggle="#password-field"
                                                class="fa fa-fw fa-eye field_icon toggle-password"></span>

                                        </div>
                                    </div>

                                </div>

                                @foreach ($settings as $row)
                                <h4>{{ucfirst( $row->key) }} {{ __('SMS Settings :') }}</h4>
                                <hr>

                                <input type="hidden" name="keys[{{ $row->id }}]" value="{{ $row->key }}">

                                <div class="row">
                                    @if($row->key != 'orders')
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                class="text-dark">{{ __('Message Text (MUST WITH PLACEHOLDER ##OTP##)') }}<span
                                                    class="text-danger">*</span>:</label>
                                            <input placeholder="eg. Your OTP code for login is ##OTP##" type="text"
                                                min="1" max="60" class="form-control"
                                                value="{{ $row->message ? $row->message : "" }}"
                                                name="message[{{ $row->id }}]">
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Enter SENDER ID: (Max char length 6)') }}
                                                <span class="text-danger">*</span></label>
                                            <input placeholder="eg. SMSIND" maxlength="6" type="text"
                                                class="form-control"
                                                value="{{ $row->sender_id ? $row->sender_id : "" }}"
                                                name="sender_id[{{ $row->id }}]">
                                        </div>
                                    </div>

                                    @if($row->key != 'orders')

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('MSG91 OTP Code Expiry (In Minutes) :') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                value="{{ $row->otp_expiry ? $row->otp_expiry : "" }}"
                                                name="otp_expiry[{{ $row->id }}]">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('MSG91 OTP Code Length (Max:6) :') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" min="4" max="6" class="form-control"
                                                value="{{ $row->otp_length ? $row->otp_length : 4 }}"
                                                name="otp_length[{{ $row->id }}]">
                                        </div>
                                    </div>

                                    @endif

                                    <div class="col-md-4">

                                        <div class="form-group eyeCy">
                                            <label class="text-dark">{{ __('MSG91 Flow ID :') }} <span
                                                    class="text-danger">*</span></label>

                                            <input id="flow_id" type="password" placeholder="enter secret key"
                                                class="form-control" name="flow_id[{{$row->id}}]"
                                                value="{{ $row->flow_id }}">
                                            <span toggle="#password-field"
                                                class="fa fa-fw fa-eye field_icon toggle-password1"></span>

                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Enable emoji in Msg :') }} <span
                                                    class="text-danger">*</span></label>
                                            <br>
                                            <label class="switch">
                                                <input id="login_unicode" {{ $row->unicode == 1 ? "checked" : "" }}
                                                    type="checkbox" name="unicode[{{ $row->id }}]">
                                                <span class="knob"></span>
                                            </label>
                                        </div>
                                    </div>


                                </div>
                                @endforeach

                                <div class="form-group">
                                    <label class="text-dark" for="">{{ __('Enable MSG91') }} </label>
                                    <br>
                                    <label class="switch">
                                        <input id="msg91_enable" {{ $configs->msg91_enable == 1 ? "checked" : "" }}
                                            type="checkbox" name="msg91_enable">
                                        <span class="knob"></span>
                                    </label>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fa fa-question-circle"></i> Toggle to activate the MSG-91.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
                                        {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i
                                            class="fa fa-check-circle"></i> Save settings</button>
                                </div>
                            </form>
                        </div>

                        @if(Module::has('MimSms') && Module::find('MimSms')->isEnabled())
                        <div style="display: {{ env('DEFAULT_SMS_CHANNEL') == 'mim' ? 'block' : 'none' }};"
                            id="mimSMSBox">
                            <form action="{{ route("mim.keys.save") }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <label class="text-dark">{{ __('MIM SMS API Key :') }} <span
                                            class="text-danger">*</span></label>
                                    <input value="{{ env("MIM_SMS_API_KEY") }}" type="text" class="form-control"
                                        required name="MIM_SMS_API_KEY">
                                </div>

                                <div class="form-group">
                                    <label class="text-dark">{{ __('MIM SMS SENDER ID :') }} <span
                                            class="text-danger">*</span></label>
                                    <input value="{{ env("MIM_SMS_SENDER_ID") }}" type="text" class="form-control"
                                        required name="MIM_SMS_SENDER_ID">
                                </div>

                                <div class="form-group">
                                    <label class="text-dark">{{ __('Enable OTP Confirmation on Login / Register :') }}
                                        <span class="text-danger">*</span></label>
                                    <br>
                                    <label class="switch">
                                        <input name="MIM_SMS_OTP_ENABLE" class="MIM_SMS_OTP_ENABLE"
                                            id="MIM_SMS_OTP_ENABLE"
                                            {{ env("MIM_SMS_OTP_ENABLE") == 1 ? "checked" : "" }} type="checkbox">
                                        <span class="knob"></span>
                                    </label>
                                </div>

                                <!-- create and reset button -->
                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
                                        {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i
                                            class="fa fa-check-circle"></i> {{ __('Save settings') }}</button>
                                </div>

                            </form>
                        </div>
                        @endif

                        @if(Module::has('Exabytes') && Module::find('Exabytes')->isEnabled())
                            @include('exabytes::admin.smssettings')
                        @endif

                    </div>
                    <!-- main content end -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-script')
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"
    integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ=="
    crossorigin="anonymous"></script>
<script>
    "use Strict";

    $('.msg_channel').on('change', function () {

        var val = $(this).val();

        if (val == 'twillo') {

            $('#twilloBox').show();
            $('#msg91Box').hide();
            $('#mimSMSBox').hide();
            $('#exabytesBox').hide();

        } else if (val == 'msg91') {

            $('#twilloBox').hide();
            $('#msg91Box').show();
            $('#mimSMSBox').hide();
            $('#exabytesBox').hide();

        } else if (val == 'mim') {

            $('#mimSMSBox').show();
            $('#twilloBox').hide();
            $('#msg91Box').hide();
            $('#exabytesBox').hide();

        }
        else if (val == 'exabytes') {

            $('#mimSMSBox').hide();
            $('#twilloBox').hide();
            $('#msg91Box').hide();
            $('#exabytesBox').show();

        }

        axios.post('{{ route("change.channel") }}', {
            channel: val
        }).then(res => {
            console.log(res.data);
        }).catch(err => console.log(err));

    });

    $(".sms_enable").on('change', function () {
        if ($(this).is(":checked")) {
            $('#mainsmsbox').show();
            axios.post('{{ route("change.channel") }}', {
                enable: 1
            }).then(res => {
                console.log(res.data);
            }).catch(err => console.log(err));
        } else {
            $('#mainsmsbox').hide();
            axios.post('{{ route("change.channel") }}', {
                enable: 0
            }).then(res => {
                console.log(res.data);
            }).catch(err => console.log(err));
        }
    });

    $(document).on('click', '.toggle-password', function () {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#MSG91_AUTH_KEY");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password');

    });

    $(document).on('click', '.toggle-password1', function () {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#flow_id");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password');

    });
</script>
<!-- script to hide and show password eye end -->
@endsection