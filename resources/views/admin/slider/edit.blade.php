@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Slider |'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Sliders') }}
@endslot
@slot('menu1')
{{ __("Slider") }}
@endslot

@slot('menu2')
{{ __("Edit Slide") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/slider')}} " class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Create a new slider') }}</h5>
        </div>
        <div class="card-body">
        <!-- main content start -->
        <form action="{{ route('slider.update',$slider->id) }}" method="POST" enctype="multipart/form-data">
          {{ method_field('PUT') }}
          @csrf
           <div class="row">
             <div class="col-md-7">
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
                  <!-- <input  type="file" class="form-control" name="image" id="image"/> -->
               </div>
                <div class="form-group">
                  <label class="text-dark" for="link_by">{{ __('Link BY :') }}</label>
                  <select required="" class="form-control select2" name="link_by" id="link_by">
                    <option {{ $slider->link_by == 'none' ? "selected" : "" }} value="none">{{ __('None')  }}</option>
                    <option {{ $slider->link_by == 'url' ? "selected" : "" }} value="url">{{ __('URL')  }}</option>
                    <option {{ $slider->link_by == 'cat' ? "selected" : "" }} value="cat">{{ __('Category')  }}</option>
                    <option {{ $slider->link_by == 'sub' ? "selected" : "" }} value="sub">{{ __('Subcategory')  }}</option>
                    <option {{ $slider->link_by == 'child' ? "selected" : "" }} value="child">{{ __('Childcategory')  }}</option>
                    <option {{ $slider->link_by == 'pro' ? "selected" : "" }} value="pro">{{ __('Product')  }}</option>
                  </select>
                </div>
                <div class="form-group {{ $slider->category_id !='' ? "" : 'hide' }}" id="category_id">
                  <label class="text-dark">{{ __('Choose Category :') }}</label>
                  <select class="js-example-basic-single form-control" id="cat" name="category_id">
                      <option value="">{{ __('Please Choose')  }}</option>
                      @foreach(App\Category::all() as $category)
                          @if($category->status == '1')
                              <option {{ $slider['category_id'] == $category->id ? "selected" : "" }} value="{{ $category->id }}">{{ $category->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                 <div class="form-group {{ $slider->child !='' ? "" : 'hide' }}" id="subcat_id">
                  <label class="text-dark">{{ __('Choose Subcategory :') }}</label>
                  <select class="js-example-basic-single form-control" id="subcate" name="subcat" >
                      <option value="">{{ __('Please Choose')  }}</option>
                      @foreach(App\Subcategory::all() as $sub)
                          @if($sub->status == '1')
                              <option {{ $slider['child'] == $sub->id ? "selected" : "" }} value="{{ $sub->id }}">{{ $sub->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="form-group {{ $slider->grand_id !='' ? "" : 'hide' }}" id="child">
                  <label class="text-dark">{{ __('Choose Chilldcategory :') }}</label>
                  <select class="js-example-basic-single form-control" id="subcat" name="child" >
                      <option value="">{{ __('Please Choose')  }}</option>
                      @foreach(App\Grandcategory::all() as $child)
                          @if($child->status == '1')
                              <option {{ $slider['grand_id'] == $child->id ? "selected" : "" }} value="{{ $child->id }}">{{ $child->title }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="form-group {{ $slider->product_id !='' ? "" : 'hide' }}" id="pro">
                  <label class="text-dark">{{ __('Choose Product :') }}</label>
                  <select class="js-example-basic-single form-control" id="pro" name="pro" >
                      <option value="">{{ __('Please Choose')  }}</option>
                      @foreach(App\Product::all() as $pro)
                          @if($pro->status == '1' && count($pro->subvariants)>0)
                              <option {{ $slider['product_id'] == $pro->id ? "selected" : "" }} value="{{ $pro->id }}">{{ $pro->name }}</option>
                          @endif
                      @endforeach
                  </select>
                </div>

                <div class="form-group {{ $slider->url !='' ? "" : 'hide' }}" id="url_box">
                  <label class="text-dark">{{ __('Enter URL :') }}</label>
                  <input type="url" id="url" name="url" value="{{ $slider->url }}" class="form-control" placeholder="http://www.">
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label class="text-dark">{{ __('Slider Top Heading :') }}</label>
                      <input name="heading" type="text" value="{{ $slider->topheading }}" placeholder="Enter top heading" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                       <label class="text-dark" for="">{{ __('Top Heading Text Color :') }}</label>
                       <div class="input-group initial-color" title="Using input value">
                        <input type="text" class="form-control input-lg" value="{{ $slider->headingtextcolor }}" name="headingtextcolor"  placeholder="#000000"/>
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
                      <input name="subheading" type="text" value="{{ $slider->heading }}" placeholder="Enter Sub heading" class="form-control"/>
                    </div>

                    <div class="col-md-4">
                      <label class="text-dark" for="">{{ __('Subheading Text Color :') }}</label>
                      <div class="input-group initial-color" title="Using input value">
                        <input type="text" class="form-control input-lg" value="{{ $slider->subheadingcolor }}" name="subheadingcolor"  placeholder="#000000"/>
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
                      <label class="text-dark">{{ __('Description Text :') }}</label>
                      <input name="moredesc" type="text" value="{{ $slider->moredesc }}" placeholder="Enter top heading" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                       <label class="text-dark" for="">{{ __('Description Text Color :') }}</label>
                       <div class="input-group initial-color" title="Using input value">
                        <input type="text" class="form-control input-lg" value="{{ $slider->moredesccolor }}" name="moredesccolor"  placeholder="#000000"/>
                        <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                        </span>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="form-group">
                  
                    <div class="row">
                      
                      <div class="col-md-6">
                        <label class="text-dark">{{ __('Button Text :') }}</label>
                        <input name="buttonname" type="text" value="{{ $slider->buttonname }}" placeholder="Enter Button Text" class="form-control"/>
                       
                      </div>

                      <div class="col-md-6">
                        <label class="text-dark" for="">{{ __('Button Text Color :') }}</label>
                        <div class="input-group initial-color" title="Using input value">
                          <input type="text" class="form-control input-lg" value="{{ $slider->btntextcolor }}" name="btntextcolor"  placeholder="#000000"/>
                          <span class="input-group-append">
                          <span class="input-group-text colorpicker-input-addon"><i></i></span>
                          </span>
                        </div>
                     
                      </div>

                      <div class="col-md-12">
                        <label class="text-dark" for="">{{ __('Button Background Color :') }}</label>
                        <div class="input-group initial-color" title="Using input value">
                          <input type="text" class="form-control input-lg" value="{{ $slider->btnbgcolor }}" name="btnbgcolor"  placeholder="#000000"/>
                          <span class="input-group-append">
                          <span class="input-group-text colorpicker-input-addon"><i></i></span>
                          </span>
                        </div>
                      
                      </div>

                    </div>
                      
                    
   
                </div>

                <div class="form-group">
                  <label class="text-dark" for="">{{ __('Status :') }}</label><br>
                  <!-- =========== -->
                  <label class="switch">
                      <input class="slider" type="checkbox" name="status" required="" id="status" {{ $slider->status == 1 ? "checked" : "" }} />
                      <span class="knob"></span>
                    </label>
                 
                </div>

                <div class="form-group">
                <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                                            {{ __("Update")}}</button>
                </div>

             </div>
             <div class="col-md-5">
               <label class="text-dark" for="link_by">{{ __('Image Preview :') }}</label>
               <br>
               <img id="slider_preview" class="img-fluid" alt="Responsive image" title="Slider Image Preview" align="center" src="{{ url('images/slider/'.$slider->image) }}">
               
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