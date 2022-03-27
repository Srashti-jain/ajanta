@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Social Login Settings'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Social Login Settings") }}
@endslot

@slot('menu2')
{{ __("Social Login Settingss") }}
@endslot

@endcomponent
<div class="contentbar">
	<div class="row">
		<div class="col-md-4">
			<div class="card m-b-30">
				<div class="card-header">
					<h5 class="box-title">{{ __('Edit') }} {{ __('Social Login Settings') }}</h5>
				</div>
				<div class="card-body">
							<div class="row">
						<div class="col-12">
							<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
								aria-orientation="vertical">
								<a class="nav-link active" id="v-pills-facebook-tab" data-toggle="pill"
									href="#v-pills-facebook" role="tab" aria-controls="v-pills-facebook"
									aria-selected="true"><i class="feather icon-facebook mr-2"></i>{{ __('Facebook Login Settings') }}</a>
								<a class="nav-link" id="v-pills-google-tab" data-toggle="pill" href="#v-pills-google"
									role="tab" aria-controls="v-pills-google" aria-selected="false"><i
										class="fa fa-google-plus mr-2"></i>{{ __('Google Login Settings') }}</a>
								<a class="nav-link" id="v-pills-twitter-tab" data-toggle="pill" href="#v-pills-twitter"
									role="tab" aria-controls="v-pills-twitter" aria-selected="false"><i
										class="feather icon-twitter mr-2"></i>{{ __('Twitter Login Settings') }}</a>
								<a class="nav-link" id="v-pills-amazon-tab" data-toggle="pill" href="#v-pills-amazon"
									role="tab" aria-controls="v-pills-amazon mr-2" aria-selected="false"><i
										class="fa fa-amazon mr-2"></i>{{ __('Amazon Login Settings') }}</a>
								<a class="nav-link" id="v-pills-gitlab-tab" data-toggle="pill" href="#v-pills-gitlab"
									role="tab" aria-controls="v-pills-gitlab" aria-selected="false"><i
										class="feather icon-gitlab mr-2"></i>{{ __('Gitlab Login Settings') }}</a>
								<a class="nav-link" id="v-pills-linkedin-tab" data-toggle="pill"
									href="#v-pills-linkedin" role="tab" aria-controls="v-pills-linkedin"
									aria-selected="false"><i class="feather icon-facebook mr-2"></i>{{ __('Linkedin Login Settings') }}</a>

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
									<div class="tab-pane fade show active" id="v-pills-facebook" role="tabpanel"
										aria-labelledby="v-pills-facebook-tab">
										<form action="{{ route('social.login.service.update','facebook') }}"
											method="POST">
											{{ csrf_field() }}

											<label for="">{{__("Client ID")}}:</label>
											<input type="text" placeholder="{{ __("enter client ID") }}" class="form-control"
												name="FACEBOOK_CLIENT_ID" value="{{ env('FACEBOOK_CLIENT_ID') }}">
											<br>

											<div class="form-group eyeCy">

												<label for="">{{__("Client Secret Key")}}:</label>
												<input type="password" placeholder="{{ __('enter secret key') }}"
													class="form-control" id="fb_secret" name="FACEBOOK_CLIENT_SECRET"
													value="{{ env('FACEBOOK_CLIENT_SECRET') }}">

												<span toggle="#fb_secret"
													class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

											</div>
											<label for="">{{__('Callback URL')}}:</label>
											<div class="input-group">
												<input value="{{ route('social.login.callback','facebook') }}"
													type="text"
													placeholder="https://yoursite.com/public/login/facebook/callback"
													name="FB_CALLBACK_URL" value="{{ env('FB_CALLBACK_URL') }}"
													class="callback-url form-control">
												<span class="input-group-addon" id="basic-addon2">
													<button title="{{ __("Copy") }}" type="button"
														class="copy btn btn-xs btn-default">
														<i class="fa fa-clipboard" aria-hidden="true"></i>
													</button>
												</span>
											</div>
											<small class="text-info">
												<i class="fa fa-question-circle"></i> {{__("Copy the callback url and paste in your app")}}
											</small>
											<br><br>
											<div class="form-group">
												<label for=""><i class="fa fa-facebook"></i> {{__("Enable Facebook Login")}}:
												</label>
												<br>
												<label class="switch">
													<input id="fb_login_enable" type="checkbox" name="fb_login_enable"
														{{ $setting->fb_login_enable=='1' ? "checked" : "" }}>
													<span class="knob"></span>
												</label>
											</div>
											<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
												title="{{  __('This action is disabled in demo !') }}" @endif
												class="btn btn-md btn-primary"><i class="fa fa-save"></i> {{__('Save Setting')}}
											</button>
											<br><br>
										</form>
									</div>
									<div class="tab-pane fade" id="v-pills-google" role="tabpanel"
										aria-labelledby="v-pills-google-tab">
										<form action="{{ route('social.login.service.update','google') }}"
											method="POST">
											{{ csrf_field() }}

											<label for="">{{  __('Client ID:') }}</label>
											<input name="GOOGLE_CLIENT_ID" type="text" placeholder="{{  __('enter client ID') }}"
												class="form-control" value="{{ env('GOOGLE_CLIENT_ID') }}">
											<br>

											<div class="eyeCy">

												<label for="">{{ __('Client Secret Key:') }}</label>
												<input type="password" name="GOOGLE_CLIENT_SECRET"
													value="{{ env('GOOGLE_CLIENT_SECRET') }}"
													placeholder="enter secret key" class="form-control" id="gsecret">

												<span toggle="#gsecret"
													class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

											</div>

											<br>
											<label for="">{{ __('Callback URL:') }}</label>
											<div class="input-group">
												<input type="text"
													placeholder="https://yoursite.com/login/public/google/callback"
													name="GOOGLE_CALLBACK_URL"
													value="{{ route('social.login.callback','google') }}"
													class="callback-url form-control">
												<span class="input-group-addon" id="basic-addon2">
													<button title="Copy" type="button"
														class="copy btn btn-xs btn-default">
														<i class="fa fa-clipboard" aria-hidden="true"></i>
													</button>
												</span>
											</div>
											<small class="text-info">
												<i class="fa fa-question-circle"></i> Copy the callback url and paste in
												your app
											</small>
											<br><br>
											<div class="form-group">
												<label for=""><i class="fa fa-google"></i> Enable Google Login: </label>
												<br>
												<label class="switch">
													<input id="google_login_enable" type="checkbox"
														name="google_login_enable"
														{{ $setting->google_login_enable=='1' ? "checked" : "" }}>
													<span class="knob"></span>
												</label>
											</div>
											<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
												title="{{  __('This action is disabled in demo !') }}" @endif
												class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save
												Setting</button>
											<br><br>
										</form>
									</div>
									<div class="tab-pane fade" id="v-pills-twitter" role="tabpanel"
										aria-labelledby="v-pills-twitter-tab">
										<form action="{{ route('social.login.service.update','twitter') }}"
											method="POST">
											{{ csrf_field() }}

											<label for="">{{  __('Client ID:') }}</label>
											<input type="text" placeholder="{{  __('enter client ID') }}" class="form-control"
												name="TWITTER_API_KEY" value="{{ env('TWITTER_API_KEY') }}">
											<br>

											<div class="form-group eyeCy">

												<label for="">{{ __('Client Secret Key:') }}</label>
												<input type="password" placeholder="enter secret key"
													class="form-control" id="tw_secret" name="TWITTER_SECRET_KEY"
													value="{{ env('TWITTER_SECRET_KEY') }}">

												<span toggle="#tw_secret"
													class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

											</div>
											<label for="">{{ __('Callback URL:') }}</label>
											<div class="input-group">
												<input value="{{ route('social.login.callback','twitter') }}"
													type="text"
													placeholder="https://yoursite.com/public/login/twitter/callback"
													name="FB_CALLBACK_URL" value="{{ env('FB_CALLBACK_URL') }}"
													class="callback-url form-control">
												<span class="input-group-addon" id="basic-addon2">
													<button title="Copy" type="button"
														class="copy btn btn-xs btn-default">
														<i class="fa fa-clipboard" aria-hidden="true"></i>
													</button>
												</span>
											</div>
											<small class="text-info">
												<i class="fa fa-question-circle"></i> {{__("Copy the callback url and paste in your app.")}}
											</small>
											<br><br>
											<div class="form-group">
												<label for=""><i class="fa fa-twitter"></i> {{__('Enable Twitter Login:')}}
												</label>
												<br>
												<label class="switch">
													<input id="twitter_enable" type="checkbox" name="twitter_enable"
														{{ $setting->twitter_enable=='1' ? "checked" : "" }}>
													<span class="knob"></span>
												</label>
											</div>
											<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
												title="{{  __('This action is disabled in demo !') }}" @endif
												class="btn btn-md btn-primary"><i class="fa fa-save"></i> {{__('Save Setting')}}
											</button>
											<br><br>
										</form>
									</div>
									<div class="tab-pane fade" id="v-pills-amazon" role="tabpanel"
										aria-labelledby="v-pills-amazon-tab">
										<form action="{{ route('social.login.service.update','amazon') }}"
											method="POST">
											{{ csrf_field() }}

											<label for="">{{  __('Client ID:') }}</label>
											<input type="text" placeholder="{{  __('enter client ID') }}" class="form-control"
												name="AMAZON_LOGIN_ID" value="{{ env('AMAZON_LOGIN_ID') }}">
											<br>

											<div class="form-group eyeCy">

												<label for="">{{ __('Client Secret Key:') }}</label>
												<input type="password" placeholder="{{ __('enter secret key') }}"
													class="form-control" id="amz_secret" name="AMAZON_LOGIN_SECRET"
													value="{{ env('AMAZON_LOGIN_SECRET') }}">

												<span toggle="#amz_secret"
													class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

											</div>
											<label for="">{{ __('Callback URL:') }}</label>
											<div class="input-group">
												<input value="{{ route('social.login.callback','amazon') }}" type="text"
													placeholder="https://yoursite.com/public/login/amazon/callback"
													name="AMAZON_LOGIN_CALLBACK"
													value="{{ env('AMAZON_LOGIN_CALLBACK') }}"
													class="callback-url form-control">
												<span class="input-group-addon" id="basic-addon2">
													<button title="Copy" type="button"
														class="copy btn btn-xs btn-default">
														<i class="fa fa-clipboard" aria-hidden="true"></i>
													</button>
												</span>
											</div>
											<small class="text-info">
												<i class="fa fa-question-circle"></i> {{__("Copy the callback url and paste in your app.")}}
											</small>
											<br><br>
											<div class="form-group">
												<label for=""><i class="fa fa-amazon"></i> {{__('Enable Amazon Login:')}} </label>
												<br>
												<label class="switch">
													<input id="amazon_enable" type="checkbox" name="amazon_enable"
														{{ $setting->amazon_enable == '1' ? "checked" : "" }}>
													<span class="knob"></span>
												</label>
											</div>
											<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
												title="{{  __('This action is disabled in demo !') }}" @endif
												class="btn btn-md btn-primary"><i class="fa fa-save"></i> {{__('Save Setting')}}
											</button>
											<br><br>
										</form>
									</div>
									<div class="tab-pane fade" id="v-pills-gitlab" role="tabpanel"
										aria-labelledby="v-pills-gitlab-tab">
										<form action="{{ route('social.login.service.update','gitlab') }}"
											method="POST">
											{{ csrf_field() }}

											<label for="">{{ __('Gitlab Client ID:') }}</label>
											<input type="text" placeholder="{{ __('enter gitlab client ID') }}" class="form-control"
												name="GITLAB_CLIENT_ID" value="{{ env('GITLAB_CLIENT_ID') }}">
											<br>

											<div class="eyeCy">

												<label for="">{{ __('Gitlab Client Secret Key:') }}</label>
												<input type="password" placeholder="{{ __('enter gitlab client secret key') }}"
													class="form-control" id="gitlab_secret" name="GITLAB_CLIENT_SECRET"
													value="{{ env('GITLAB_CLIENT_SECRET') }}">

												<span toggle="#gitlab_secret"
													class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

											</div>

											<br>
											<label for="">Gitlab Callback URL:</label>
											<div class="input-group">
												<input type="text"
													placeholder="https://yoursite.com/public/login/gitlab/callback"
													name="GITLAB_CALLBACK_URL"
													value="{{ route('social.login.callback','gitlab') }}"
													class="callback-url form-control">
												<span class="input-group-addon" id="basic-addon2">
													<button title="{{ __('Copy') }}" type="button"
														class="copy btn btn-xs btn-default">
														<i class="fa fa-clipboard" aria-hidden="true"></i>
													</button>
												</span>

											</div>
											<small class="text-info">
												<i class="fa fa-question-circle"></i> {{__("Copy the callback url and paste in your app")}}
											</small>
											<br><br>
											<div class="form-group">
												<label for=""><i class="fa fa-gitlab"></i> {{__("Enable GitLab Login:")}} </label>
												<br>
												<label class="switch">
													<input id="ENABLE_GITLAB" type="checkbox" name="ENABLE_GITLAB"
														{{ env('ENABLE_GITLAB') == '1' ? "checked" : "" }}>
													<span class="knob"></span>
												</label>
											</div>

											<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
												title="{{  __('This action is disabled in demo !') }}" @endif
												class="btn btn-md btn-primary"><i class="fa fa-save"></i> {{ __('Save Setting') }}</button>

											<br><br>

										</form>
									</div>
									<div class="tab-pane fade" id="v-pills-linkedin" role="tabpanel"
										aria-labelledby="v-pills-linkedin-tab">
										<form action="{{ route('social.login.service.update','linkedin') }}"
											method="POST">
											{{ csrf_field() }}

											<label for="">{{ __("LINKEDIN Client ID:") }}</label>
											<input type="text" placeholder="{{ __('enter gitlab client ID') }}" class="form-control"
												name="LINKEDIN_CLIENT_ID" value="{{ env('LINKEDIN_CLIENT_ID') }}">
											<br>

											<div class="eyeCy">

												<label for="">{{ __("LINKEDIN Client Secret Key:") }}</label>
												<input type="password" placeholder="{{ __('enter LINKEDIN client secret key') }}"
													class="form-control" id="LINKEDIN_SECRET" name="LINKEDIN_SECRET"
													value="{{ env('LINKEDIN_SECRET') }}">

												<span toggle="#LINKEDIN_SECRET"
													class="inline-flex fa fa-fw fa-eye field-icon toggle-password2"></span>

											</div>

											<br>
											<label for="">{{ __("LINKEDIN Callback URL:") }}</label>
											<div class="input-group">
												<input type="text"
													placeholder="https://yoursite.com/public/login/linkedin/callback"
													name="LINKEDIN_CALLBACK"
													value="{{ route('social.login.callback','linkedin') }}"
													class="callback-url form-control">
												<span class="input-group-addon" id="basic-addon2">
													<button title="Copy" type="button"
														class="copy btn btn-xs btn-default">
														<i class="fa fa-clipboard" aria-hidden="true"></i>
													</button>
												</span>

											</div>
											<small class="text-info">
												<i class="fa fa-question-circle"></i> {{__("Copy the callback url and paste in your app")}}
											</small>
											<br><br>
											<div class="form-group">
												<label for=""><i class="fa fa-linkedin-square"></i> {{__("Enable Linkedin Login")}}:
												</label>
												<br>
												<label class="switch">
													<input id="linkedin_enable" type="checkbox" name="linkedin_enable"
														{{ $configs->linkedin_enable == '1' ? "checked" : "" }}>
													<span class="knob"></span>
												</label>
											</div>

											<button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
												title="{{  __('This action is disabled in demo !') }}" @endif
												class="btn btn-md btn-primary"><i class="fa fa-save"></i>
												{{__("Save Settings")}}
											</button>

											<br><br>

										</form>
									</div>
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
@section('custom-script')
<script>
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if (activeTab) {
		$('#payment_tabs a[href="' + activeTab + '"]').tab('show');
	}

	$('.copy').on('click', function () {

		var copyText = $(this).closest('.input-group').find('.callback-url');
		copyText.select();
		//copyText.setSelectionRange(0, 99999); /*For mobile devices*/

		/* Copy the text inside the text field */
		document.execCommand("copy");
	});
</script>
@endsection