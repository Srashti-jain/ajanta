@extends('admin.layouts.master-soyuz')
@section('title',__('Create Slider'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Sliders') }}
@endslot
@slot('menu1')
{{ __("Slider") }}
@endslot

@slot('menu2')
{{ __("Create Slider") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/slider')}} " class=" btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
  </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">
  <div class="row">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach
    </div>
    @endif
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Create a new slider') }}</h5>
        </div>
        <div class="card-body">
        <!-- main content start -->
        <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
           <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                  <label class="text-dark">{{ __('Choose Slider Image :') }}</label><br>
                  <!-- ================ -->
                  <div class="input-group mb-3">
                    
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" required>
                        <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                    </div>
                  </div>
                  <!-- ================ -->
                  <!-- <input required="" type="file" class="form-control" name="image" id="image"/> -->
               </div>
                <div class="form-group">
                  <label class="text-dark" for="link_by">{{ __('Link BY :') }}</label>
                  <select required="" class="form-control select2" name="link_by" id="link_by">
                    <option value="none">{{ __('None')  }}</option>
                    <option value="url">{{ __('URL')  }}</option>
                    <option value="cat">{{ __('Category')  }}</option>
                    <option value="sub">{{ __('Subcategory')  }}</option>
                    <option value="child"> {{ __('Childcategory')  }}</option>
                    <option value="pro">{{ __('Product')  }}</option>
                  </select>
                </div>
                <div class="hide form-group" id="category_id">
                  <label class="text-dark">{{ __('Choose Category :') }}</label>
                  <select class="form-control select2 " id="cat" name="category_id">
                      <option value="">{{ __('Please Choose')  }}</option>
                      @foreach(App\Category::all() as $category)
                          @if($category->status == '1')
                              <option value="{{ $category->id }}">{{ $category->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                 <div class="hide form-group" id="subcat_id">
                  <label class="text-dark">{{ __('Choose Subcategory :') }}</label>
                  <select class="form-control select2" id="subcat" name="subcat" >
                      <option value="">{{ __('Please Choose')  }}</option>
                      @foreach(App\Subcategory::all() as $sub)
                          @if($sub->status == '1')
                              <option value="{{ $sub->id }}">{{ $sub->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="hide form-group" id="child">
                  <label class="text-dark">{{ __('Choose Chilldcategory :') }}</label>
                  <select class="form-control select2" id="sub" name="child" >
                      <option value="">{{ __('Please Choose')  }}</option>
                      @foreach(App\Grandcategory::all() as $child)
                          @if($child->status == '1')
                              <option value="{{ $child->id }}">{{ $child->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="hide form-group" id="pro">
                  <label class="text-dark">{{ __('Choose Product :') }}</label>
                  <select class="form-control select2" id="pro" name="pro" >
                      <option value="">{{ __('Please Choose')  }}</option>
                      @foreach(App\Product::all() as $pro)
                          @if($pro->status == '1' && count($pro->subvariants)>0)
                              <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="hide form-group" id="url_box">
                  <label class="text-dark">{{ __('Enter URL :') }}</label>
                  <input type="url" id="url" name="url" class="form-control" placeholder="http://www.">
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label class="text-dark">{{ __('Slider Top Heading :') }}</label>
                      <input name="heading" type="text" value="" placeholder="Enter top heading" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                       <label class="text-dark" for="">{{ __('Text Color :') }}</label>
                       <div class="input-group initial-color">
                        <input type="text" class="form-control input-lg" value="#000000" name="headingtextcolor"  placeholder="#000000"/>
                        <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                      </div>
                    
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label class="text-dark">{{ __('Slider Sub Heading :') }}</label>
                      <input name="subheading" type="text" value="" placeholder="Enter Sub heading" class="form-control"/>
                    </div>

                    <div class="col-md-4">
                      <label class="text-dark" for="">{{ __('Text Color :') }}</label>
                      <div class="input-group initial-color">
                        <input type="text" class="form-control input-lg" value="#000000" name="subheadingcolor"  placeholder="#000000"/>
                        <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                      </div>
                   
                    </div>
                  </div>
                </div>

                  <div class="form-group">
                  
                    <div class="row">
                      
                      <div class="col-md-8">
                        <label class="text-dark">{{ __('Button Text :') }}</label>
                        <input name="buttonname" type="text" value="" placeholder="Enter Button Text" class="form-control"/>
                      </div>

                      <div class="col-md-4">
                        <label class="text-dark" for="">{{ __('Button Text Color :') }}</label>
                        <div class="input-group initial-color" title="Using input value">
                          <input type="text" class="form-control input-lg" value="#000000" name="btntextcolor" placeholder="#000000"/>
                          <span class="input-group-append">
                          <span class="input-group-text colorpicker-input-addon"><i></i></span>
                          </span>
                        </div>
                      
                      </div>

                      <div class="col-md-12 mt-md-2">
                        <label class="text-dark" for="">{{ __('Button Background Color :') }}</label>
                        <div class="input-group initial-color" title="Using input value">
                          <input type="text" class="form-control input-lg" value="#000000" name="btnbgcolor" placeholder="#000000"/>
                          <span class="input-group-append">
                          <span class="input-group-text colorpicker-input-addon"><i></i></span>
                          </span>
                        </div>

                      
                      </div>

                    </div>
                      
                    
   
                </div>

                <div class="form-group">
                  <label class="text-dark" for="">{{ __('Status :') }}</label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" checked />
                      <span class="knob"></span>
                    </label>
                </div>

                <div class="form-group">
                <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                                            {{ __("Save")}}</button>
                  <!-- <button class="btn btn-primary-rgba btn-md"><i class="feather icon-plus mr-2"></i>{{ __('ADD Slide') }}</button> -->
                </div>

             </div>
             <div class="col-md-6">
               <label class="text-dark" for="link_by">{{ __("Image Preview :")}}</label>
               <br><br>
               <img src="{{ url('images/sliderpreview.png') }}" class="img-fluid" alt="Responsive image" id="slider_preview" title="Image Preview" align="center">
               
             </div>
            
           </div>
        </form>
         <!-- main content end -->
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('custom-script')
  <script src="{{ url('js/slider.js') }}"></script>
@endsection