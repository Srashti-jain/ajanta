@extends('admin.layouts.master-soyuz')
@section('title',__('Create Advertisement'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Advertisement") }}
@endslot

@slot('menu2')
{{ __("Advertisement") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{ route('adv.create') }}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
</div>
</div>
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
          <h5 class="card-title">{{ __('Add Advertisement') }}</h5>
        </div>
        <div class="card-body">
			<form action="{{ route('adv.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-md-6">
			 			<label class="h5">{{ __('Select Advertise Position') }}:</label>
			 			<select required name="position" id="" class="form-control select2">
			 				<option value="">{{ __("Please select position of advertisement") }}</option>
			 				<option value="beforeslider">{{ __('Above Slider') }}</option>
			 				<option value="abovenewproduct">{{ __('Above New Product Widget') }}</option>
			 				<option value="abovetopcategory">{{ __('Above Top Category') }}</option>
			 				<option value="abovelatestblog">{{ __('Above Latest Blog Widget') }}</option>
			 				<option value="abovefeaturedproduct">{{ __('Above Featured Product Widget') }}</option>
			 				<option value="afterfeaturedproduct">{{ __("Below Featured Product Widget") }}</option>
			 			</select>

			 			<small class="text-info"><i class="fa fa-question-circle"></i> {{ __("Select the advertisement position") }}</small>
						<br><br>
			 			<label>{{ __("Status") }}</label>
			 			<br>
			 			<label class="switch">
			            	<input type="checkbox" class="quizfp toggle-input toggle-buttons" name="status">
			            	<span class="knob"></span>
			           </label>
			 		</div>
			 		
					<div class="col-md-6">
						@if($layout == 'Three Image Layout')
							<img class="img-adv float-right" title="{{ __('Three Image Layout') }}"  src="{{ url('images/advLayout3.png') }}" alt="three_image_adv_layout">
							<input type="hidden" name="layout" value="{{ $layout }}">
						@elseif($layout == 'Two non equal image layout')
							<img class="img-adv float-right" title="{{ __('Two Non Equal Image Layout') }}" src="{{ url('images/advLayout2.png') }}" alt="two_non_equal_image_adv_layout">
							<input type="hidden" name="layout" value="{{ $layout }}">
						@elseif($layout == 'Two equal image layout')
							<img class="img-adv float-right" title="{{ __('Two Equal Image Layout') }}" src="{{ url('images/advLayout1.png') }}" alt="two_equal_image_adv_layout">
							<input type="hidden" name="layout" value="{{ $layout }}">
						@elseif($layout == 'Single image layout')
							<img class="img-adv float-right" title="{{ __('Single Image Layout') }}" src="{{ url('images/singleImage.png') }}" alt="single_image_adv_layout">
							<input type="hidden" name="layout" value="{{ $layout }}">
						@endif
					</div>

					<div class="col-md-12">
						<br>
						@if($layout == 'Three Image Layout')
							<img title="Preview" id="preview1" align="center" height="100" src="{{ url('images/imagechoosebg.png') }}" alt=""/>
							<img title="Preview" id="preview2" align="center" height="100" src="{{ url('images/imagechoosebg.png') }}" alt=""/>
							<img title="Preview" id="preview3" align="center" height="100" src="{{ url('images/imagechoosebg.png') }}" alt=""/>
						@elseif($layout == 'Two non equal image layout')
							<img title="Preview" id="preview1" align="center" height="100" src="{{ url('images/imagechoosebg.png') }}" alt=""/>
							<img title="Preview" id="preview2" align="center" height="100" src="{{ url('images/imagechoosebg.png') }}" alt=""/>
						@elseif($layout == 'Two equal image layout')
							<div class="row">
								<div class="col-md-6">
									<img title="Preview" id="preview1" class="img-adv float-right" align="center" height="90" src="{{ url('images/imagechoosebg.png') }}" alt=""/>
								</div>
								<div class="col-md-6">
									<img title="Preview" id="preview2" class="img-adv float-right" align="center" height="90" src="{{ url('images/imagechoosebg.png') }}" alt=""/>
								</div>
							</div>
							
							
						@elseif($layout == 'Single image layout')
							<img title="Preview" id="preview1" class="img-responsive" align="center" height="100" src="{{ url('images/imagechoosebg.png') }}" alt=""/>
						@endif
					</div>
					
					<div class="col-md-12">
						
						@if($layout == 'Three Image Layout')
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ __("Choose Image 1:") }} <span class="required">*</span> <small class="text-info"><i class="fa fa-question-circle"></i>
									 {{ __('Recommended image size') }} (438 x 240px)</small></label>
									 <div class="input-group mb-3">

										<div class="custom-file">
						
										  <input type="file" name="image1" class="inputfile inputfile-1"
											aria-describedby="inputGroupFileAddon01" id="image1">
										  <label class="custom-file-label" for="image1">{{ __("Choose file") }}</label>
										</div>
									  </div>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ __("Image 1 Link By:") }} <span class="required">*</span></label>
									<select name="img1linkby" id="img1linkby" class="form-control select2">
										<option value="linkbycat">{{ __("Link By Categories") }}</option>
										<option value="linkbypro">{{ __("Link By Product") }}</option>
										<option value="linkbyurl">{{ __("Link By Custom URL") }}</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div id="catbox1" class="form-group">
									<label>{{ __("Select Category:") }}</label>
									<select name="cat_id1" id="" class="form-control select2">
							              @foreach(App\Category::where('status','=','1')->get() as $cat)
							                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
							              @endforeach
							        </select>
								</div>

								<div id="probox1" class="display-none form-group">
									<label>{{ __("Select Product:") }}</label>
									<select name="pro_id1" id="" class="form-control select2">
							              @foreach($p = App\Product::where('status','=','1')->get() as $pro)
							                @if(count($pro->subvariants)>0)
							                	<option value="{{ $pro->id }}">{{ $pro->name }}</option>
							                @endif
							              @endforeach
							        </select>
								</div>

								<div id="urlbox1" class="display-none form-group">
									<label>{{ __('Enter URL:') }}</label>
									<input class="form-control" type="url" placeholder="http://" name="url1">
								</div>

							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>{{ __("Choose Image 2:") }} <span class="required">*</span> <small class="text-muted"><i class="fa fa-question-circle"></i>
									 {{ __('Recommended image size') }} (438 x 240px)</small></label>
									 <div class="input-group mb-3">

										<div class="input-group-prepend">
										  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
										</div>
						
						
										<div class="custom-file">
						
										  <input type="file" name="image2" class="inputfile inputfile-1"
											aria-describedby="inputGroupFileAddon01" id="image2">
										  <label class="custom-file-label" for="image2">{{ __("Choose file") }} </label>
										</div>
									  </div>
									
								</div>
									
								</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ __('Image 2 Link By:') }} <span class="required">*</span></label>
									<select name="img2linkby" id="img2linkby" class="form-control select2">
										<option value="linkbycat">{{ __("Link By Categories") }}</option>
										<option value="linkbypro">{{ __("Link By Product") }}</option>
										<option value="linkbyurl">{{ __("Link By Custom URL") }}</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div id="catbox2" class="form-group">
									<label>{{ __("Select Category:") }}</label>
									<select name="cat_id2" id="" class="select2 form-control">
							              @foreach(App\Category::where('status','=','1')->get() as $cat)
							                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
							              @endforeach
							        </select>
								</div>

								<div id="probox2" class="display-none form-group">
									<label>{{ __("Select Product:") }}</label>
									<select name="pro_id2" id="" class="select2 form-control">
							              @foreach($p = App\Product::where('status','=','1')->get() as $pro)
							                @if(count($pro->subvariants)>0)
							                	<option value="{{ $pro->id }}">{{ $pro->name }}</option>
							                @endif
							              @endforeach
							        </select>
								</div>

								<div id="urlbox2" class="display-none form-group">
									<label>{{ __('Enter URL:') }}</label>
									<input class="form-control" type="url" placeholder="http://" name="url2">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									
									<label>{{ __("Choose Image 3:") }} <span class="required">*</span> <small class="text-muted"><i class="fa fa-question-circle"></i>
									 {{ __('Recommended image size') }} (438 x 240px)</small></label>
									 <div class="input-group mb-3">

										<div class="input-group-prepend">
										  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
										</div>
						
						
										<div class="custom-file">
						
										  <input type="file" name="image3" class="inputfile inputfile-1"
											aria-describedby="inputGroupFileAddon01" id="image3">
										  <label class="custom-file-label" for="image3">{{ __("Choose file") }} </label>
										</div>
									  </div>
									
								</div>									
								</div>
							

							<div class="col-md-4">
								<div class="form-group">
									<label>{{ __("Image 3 Link By:") }} <span class="required">*</span></label>
									<select name="img3linkby" id="img3linkby" class="form-control select2">
										<option value="linkbycat">{{ __("Link By Categories") }}</option>
										<option value="linkbypro">{{ __("Link By Product") }}</option>
										<option value="linkbyurl">{{ __("Link By Custom URL") }}</option>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div id="catbox3" class="form-group">
									<label>{{ __("Select Category:") }}</label>
									<select name="cat_id3" id="" class="select2 form-control">
							              @foreach(App\Category::where('status','=','1')->get() as $cat)
							                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
							              @endforeach
							        </select>
								</div>

								<div id="probox3" class="display-none form-group">
									<label>{{ __("Select Product:") }}</label>
									<select name="pro_id3" id="" class="form-control select2">
							              @foreach($p = App\Product::where('status','=','1')->get() as $pro)
							                @if(count($pro->subvariants)>0)
							                	<option value="{{ $pro->id }}">{{ $pro->name }}</option>
							                @endif
							              @endforeach
							        </select>
								</div>

								<div id="urlbox3" class="display-none form-group">
									<label>{{ __('Enter URL:') }}</label>
									<input class="form-control" type="url" placeholder="http://" name="url3">
								</div>
							</div>
						</div>
							
							

						@elseif($layout == 'Two non equal image layout')
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{ __("Choose Image 1:") }} <span class="required">*</span></label>
										<input id="image1" type="file" class="form-control" name="image1"/>
										<small class="text-muted"><i class="fa fa-question-circle"></i>
										 {{ __('Recommended image size') }} (822 x 303px)</small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{ __("Image 1 Link By:") }} <span class="required">*</span></label>
										<select name="img1linkby" id="img1linkby" class="form-control">
											<option value="linkbycat">{{ __("Link By Categories") }}</option>
											<option value="linkbypro">{{ __("Link By Product") }}</option>
											<option value="linkbyurl">{{ __("Link By Custom URL") }}</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div id="catbox1" class="form-group">
										<label>{{ __("Select Category:") }}</label>
										<select name="cat_id1" id="" class="select2 form-control">
								              @foreach(App\Category::where('status','=','1')->get() as $cat)
								                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
								              @endforeach
								        </select>
									</div>

									<div id="probox1" class="display-none form-group">
										<label>{{ __("Select Product:") }}</label>
										<select name="pro_id1" id="" class="select2 form-control">
								              @foreach($p = App\Product::where('status','=','1')->get() as $pro)
								                @if(count($pro->subvariants)>0)
								                	<option value="{{ $pro->id }}">{{ $pro->name }}</option>
								                @endif
								              @endforeach
								        </select>
									</div>

									<div id="urlbox1" class="display-none form-group">
										<label>{{ __('Enter URL:') }}</label>
										<input class="form-control" type="url" placeholder="http://" name="url1">
									</div>
								</div>
							</div>
							
							<div class="row">

								<div class="col-md-4">
									<div class="form-group">
										<label>{{ __("Choose Image 2:") }} <span class="required">*</span></label>
										<input id="image2" type="file" class="form-control" name="image2"/>
										<small class="text-info"><i class="fa fa-question-circle"></i>
										 {{ __('Recommended image size') }} (395 x 301px)</small>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>{{ __('Image 2 Link By:') }} <span class="required">*</span></label>
										<select name="img2linkby" id="img2linkby" class="form-control">
											<option value="linkbycat">{{ __("Link By Categories") }}</option>
											<option value="linkbypro">{{ __("Link By Product") }}</option>
											<option value="linkbyurl">{{ __("Link By Custom URL") }}</option>
										</select>
									</div>
								</div>

								<div class="col-md-4">
									<div id="catbox2" class="form-group">
										<label>{{ __("Select Category:") }}</label>
										<select name="cat_id2" id="" class="select2 form-control">
								              @foreach(App\Category::where('status','=','1')->get() as $cat)
								                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
								              @endforeach
								        </select>
									</div>

									<div id="probox2" class="display-none form-group">
										<label>{{ __("Select Product:") }}</label>
										<select name="pro_id2" id="" class="select2 form-control">
								              @foreach($p = App\Product::where('status','=','1')->get() as $pro)
								                @if(count($pro->subvariants)>0)
								                	<option value="{{ $pro->id }}">{{ $pro->name }}</option>
								                @endif
								              @endforeach
								        </select>
									</div>

									<div id="urlbox2" class="display-none form-group">
										<label>{{ __('Enter URL:') }}</label>
										<input class="form-control" type="url" placeholder="http://" name="url2">
									</div>
								</div>

							</div>
									
						
						@elseif($layout == 'Two equal image layout')
							<div class="row">

								<div class="col-md-4">
									<div class="form-group">
										<label>{{ __("Choose Image 1:") }} <span class="required">*</span></label>
										<input id="image1" type="file" class="form-control" name="image1"/>
										<small class="text-muted"><i class="fa fa-question-circle"></i>
										 {{ __('Recommended image size') }} (902 x 220px)</small>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>{{ __("Image 1 Link By:") }} <span class="required">*</span></label>
										<select name="img1linkby" id="img1linkby" class="form-control">
											<option value="linkbycat">{{ __("Link By Categories") }}</option>
											<option value="linkbypro">{{ __("Link By Product") }}</option>
											<option value="linkbyurl">{{ __("Link By Custom URL") }}</option>
										</select>
									</div>
								</div>

								<div class="col-md-4">
									<div id="catbox1" class="form-group">
										<label>{{ __("Select Category:") }}</label>
										<select name="cat_id1" id="" class="select2 form-control">
								              @foreach(App\Category::where('status','=','1')->get() as $cat)
								                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
								              @endforeach
								        </select>
									</div>

									<div id="probox1" class="display-none form-group">
										<label>{{ __("Select Product:") }}</label>
										<select name="pro_id1" id="" class="select2 form-control">
								              @foreach($p = App\Product::where('status','=','1')->get() as $pro)
								                @if(count($pro->subvariants)>0)
								                	<option value="{{ $pro->id }}">{{ $pro->name }}</option>
								                @endif
								              @endforeach
								        </select>
									</div>

									<div id="urlbox1" class="display-none form-group">
										<label>{{ __('Enter URL:') }}</label>
										<input class="form-control" type="url" placeholder="http://" name="url1">
									</div>
								</div>

							</div>
							

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>{{ __("Choose Image 2:") }} <span class="required">*</span></label>
										<input id="image2" type="file" class="form-control" name="image2"/>
										<small class="text-info"><i class="fa fa-question-circle"></i>
										 {{ __('Recommended image size') }} (902 x 220px)</small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>{{ __('Image 2 Link By:') }} <span class="required">*</span></label>
										<select name="img2linkby" id="img2linkby" class="form-control">
											<option value="linkbycat">{{ __("Link By Categories") }}</option>
											<option value="linkbypro">{{ __("Link By Product") }}</option>
											<option value="linkbyurl">{{ __("Link By Custom URL") }}</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div id="catbox2" class="form-group">
										<label>{{ __("Select Category:") }}</label>
										<select name="cat_id2" id="" class="select2 form-control">
								              @foreach(App\Category::where('status','=','1')->get() as $cat)
								                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
								              @endforeach
								        </select>
									</div>

									<div id="probox2" class="display-none form-group">
										<label>{{ __("Select Product:") }}</label>
										<select name="pro_id2" id="" class="select2 form-control">
								              @foreach($p = App\Product::where('status','=','1')->get() as $pro)
								                @if(count($pro->subvariants)>0)
								                	<option value="{{ $pro->id }}">{{ $pro->name }}</option>
								                @endif
								              @endforeach
								        </select>
									</div>

									<div id="urlbox2" class="display-none form-group">
										<label>{{ __('Enter URL:') }}</label>
										<input class="form-control" type="url" placeholder="http://" name="url2">
									</div>
								</div>
							</div>

							
						@elseif($layout == 'Single image layout')
							<div class="row">
								<div class="col-md-12">
									<div class="row">

										<div class="col-md-4">
											<div class="form-group">
												<label>{{ __("Choose Image 1:") }} <span class="required">*</span></label>
												<input id="image1" type="file" class="form-control" name="image1"/>
												<small class="text-muted"><i class="fa fa-question-circle"></i>
												 {{ __('Recommended image size') }} (1375 x 409px)</small>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label>{{ __("Image 1 Link By:") }} <span class="required">*</span></label>
												<select name="img1linkby" id="img1linkby" class="form-control">
													<option value="linkbycat">{{ __("Link By Categories") }}</option>
													<option value="linkbypro">{{ __("Link By Product") }}</option>
													<option value="linkbyurl">{{ __("Link By Custom URL") }}</option>
												</select>
											</div>
										</div>

										<div class="col-md-4">
											<div id="catbox1" class="form-group">
												<label>{{ __("Select Category:") }}</label>
												<select name="cat_id1" id="" class="display-none select2 form-control">
										              @foreach(App\Category::where('status','=','1')->get() as $cat)
										                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
										              @endforeach
										        </select>
											</div>

											<div id="probox1" class="display-none form-group">
												<label>{{ __("Select Product:") }}</label>
												<select name="pro_id1" id="" class="display-none select2 form-control">
										              @foreach($p = App\Product::where('status','=','1')->get() as $pro)
										                @if(count($pro->subvariants)>0)
										                	<option value="{{ $pro->id }}">{{ $pro->name }}</option>
										                @endif
										              @endforeach
										        </select>
											</div>

											<div id="urlbox1" class="display-none form-group">
												<label>{{ __('Enter URL:') }}</label>
												<input class="form-control" type="url" placeholder="http://" name="url1">
											</div>
										</div>
									</div>
									

									
								</div>
							</div>
						@endif
					</div>
		
				</div>
				<div class="box-footer">
					<button class="btn btn-md btn-flat btn-primary-rgba">
						<i class="fa fa-plus-circle"></i> Create
					</button>
					<a title="Cancel and go back !" href="{{ route('adv.create') }}" class="btn btn-md btn-danger-rgba">
						<i class="fa fa-arrow-left"></i> Back
					</a>
				</div>
		 </form>
		</div>
	</div>
	</div>
  </div>
</div>
@endsection
@section('custom-script')
	<script>var advindexurl = "<?=route('adv.index')?>"</script>
    <script src="{{ url('js/layoutadvertise.js') }}"></script>
@endsection 
