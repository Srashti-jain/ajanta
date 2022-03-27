@extends('admin.layouts.master-soyuz')
@section('title',__('Progressive Web App Setting | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('PWA Setting') }}
@endslot
@slot('menu2')
{{ __("PWA Setting") }}
@endslot

@endcomponent
​
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
          <h5 class="box-title">{{ __('Progressive Web App Setting') }}</h5>
        </div>
        <div class="card-body">
        <ul class="custom-tab-line nav nav-tabs mb-3" id="defaultTab" role="tablist">
            <li class="nav-item">
				<a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-settings mr-2"></i>{{ __("App Setting") }}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-upload mr-2"></i>{{ __("Update Icons") }}</a>
			</li>
        </ul>

		<div class="tab-content" id="defaultTabContentLine">
			<div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
				<div class="row mr-0 ml-0">
					<div class="col-md-12  p-3 mb-2 bg-success text-white">
						<i class="fa fa-info-circle"></i> {{__("Progessive Web App Requirements")}}
						<ul>
							<li><b>HTTPS</b> {{__("must required in your domain (for enable contact your host provider for SSL configuration)")}}.</li>
							<li><b>{{__("Icons and splash screens")}} </b> {{ __("required and to be updated in Icon Settings.") }}</li>
						
							</li>
						</ul>
					</div>
				</div>
	
				<div class="row">
					<div class="col-md-9">
						<form action="{{ route('pwa.setting.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
                               <div class="row">
							<div class="form-group col-md-6">
								<label class="text-dark"> {{__("Enable PWA:")}} </label>
								<br>
								<label class="switch">
									<input id="pwa_enable" type="checkbox" name="PWA_ENABLE"
									{{ env("PWA_ENABLE") =='1' ? "checked" : "" }}>
									<span class="knob"></span>
								</label>
							</div>
							
							<div class="form-group col-md-12">
								<label class="text-dark"> {{__('App Name:')}} </label>
								<input disabled class="form-control" type="text" name="app_name" value="{{ config("app.name")}}"/>
							</div>

							
							<div class="col-md-6">
									<div class="form-group">
										<label class="text-dark"> {{__("Theme Color for header:")}} </label>
										<div class="input-group initial-color">
											<input type="text" class="form-control input-lg" value="{{env('PWA_THEME_COLOR') ?? '' }}" name="PWA_THEME_COLOR"  placeholder="#000000"/>
											<span class="input-group-append">
											<span class="input-group-text colorpicker-input-addon"><i></i></span>
											</span>
										</div>
										
									</div>
							</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="text-dark" for="">
											{{__("Background Color:")}}
										</label>
										<div class="input-group initial-color">
											<input type="text" class="form-control input-lg" value="{{ env('PWA_BG_COLOR') ?? '' }}" name="PWA_BG_COLOR"  placeholder="#000000"/>
											<span class="input-group-append">
											<span class="input-group-text colorpicker-input-addon"><i></i></span>
											</span>
										</div>

										
									</div>
								</div>
							

							
								<div class="col-md-5">
									<div class="form-group">
										<label class="text-dark" for="">
											{{__("Shortcut icon for cart:")}}
										</label>
										<!--  -->
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" name="shorticon_1" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
												<label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
											</div>
										</div>
									</div>
								</div>
										
										
								

								<div class="col-md-1 p-3 mb-2 bg-secondary rounded text-white">
									<img class="img-fluid"  src="{{ url('images/icons/'.$pwa_settings['shorticon_1']) }}" alt="{{ $pwa_settings['shorticon_1'] }}">
								</div>

								<div class="col-md-5">
									<div class="form-group">
										<label class="text-dark" for="">
											{{__("Shortcut icon for wishlist:")}}
										</label>
										
										<div class="input-group mb-3">
											
											<div class="custom-file">
												<input type="file" class="custom-file-input" name="shorticon_2" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
												<label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
											</div>
										</div>
										
									</div>
								</div>
								

								<div class="col-md-1 p-3 mb-2 bg-secondary rounded text-white">
									<img class="img-fluid" src="{{ url('images/icons/'.$pwa_settings['shorticon_2']) }}" alt="{{ $pwa_settings['shorticon_2'] }}">
								</div>

								<div class="col-md-5">
									<div class="form-group">
										<label class="text-dark" for="">{{ __("Shortcut icon for login:") }}</label>
										<!--  -->
										<div class="input-group mb-3">
											<div class="custom-file">
												<input type="file" class="custom-file-input" name="shorticon_3" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
												<label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
											</div>
										</div>
										<!--  -->
									</div>
								</div>

								<div class="col-md-1 p-3 mb-2 bg-secondary rounded text-white">
									<img class="img-fluid"  src="{{ url('images/icons/'.$pwa_settings['shorticon_3']) }}" alt="{{ $pwa_settings['shorticon_3'] }}">
								</div>

							</div>
							<button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle mr-2"></i>
										{{ __("Update")}}</button>

						</form>
					</div>

					<div class="col-md-3">
						<img  src="{{ url('images/pwa.jpg') }}" alt="" class="img-fluid">
					</div>

				</div>
			</div>

			<div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
				<!-- === PWA Icons & Splash screens form start ======== -->
				<h4>
					{{__("PWA Icons & Splash screens :")}}
				</h4>

				<hr>

				<form action="{{ route('pwa.icons.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row">
						
						<div class="col-md-8">
							<div class="form-group">
								<label class="text-dark" for=""> {{__('PWA Icon')}} (512x512): <span class="text-danger">*</span> </label><br>
								
								<div class="input-group mb-3">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="icon_512" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
											<label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
										</div>
										
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<img style="height: 90px;" class="img-responsive" src="{{ url('images/icons/icon_512x512.png') }}" alt="icon_256x256.png">
						</div>

						<div class="col-md-8">
							<div class="form-group">
								<label class="text-dark" for=""> {{__("PWA Splash Screen")}} (2048x2732): <span class="text-danger">*</span> </label>
								<!--  -->
								<div class="input-group mb-3">
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="splash_2048" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
										<label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
									</div>
								</div>
								<!--  -->
								
							</div>
						</div>

						<div class="col-md-4">
							<img style="height: 100px;" class="img-fluid" src="{{ url('images/icons/splash-2048x2732.png') }}" alt="splash-2048x2732.png">
						</div>

						<div class="col-md-12">
						<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>{{ __("Update")}}</button>
						</div>
						
					</div>

					

				</form>
				<!-- === PWA Icons & Splash screens form end ===========-->
				</div>
				<!-- === PWA Icons & Splash screens end ======== -->

		    </div>
		</div>
	</div>
</div>
							

									
							

								
                        
                  
     
@endsection
@section('custom-script')
  <script src="{{ url('js/pwasetting.js') }}"></script>
@endsection