@extends('admin.layouts.master-soyuz')
@section('title',__('Front Category Slider | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Slider') }}
@endslot
@slot('menu1')
{{ __("Slider") }}
@endslot

@slot('menu2')
{{ __("Front Category Slider") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/slider')}} " class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Front Category Slider') }}</h5>
        </div>



      
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 p-3 alert alert-info">
                
               
                     <i class="fa fa-info-circle "></i>  
                     {{__("Only those category will list here who have atleast one complete product. (Complete product means product with atleast one variant)")}}
              
            </div>
          </div>
          <form action="{{ route('front.slider.post') }}" method="POST">
           @csrf
            <input  type="hidden" class="form-control" name="user_id" value="{{ Auth::User()->id }}" >
        
              <div class="row mt-md-2">
                
                 <!-- Select Category -->
                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Select Category : ') }}<span class="text-danger">*</span></label>
                        <select class="select2 form-control" name="category_ids[]" multiple="multiple">
                            @foreach (App\Category::where('status','=','1')->get(); as $item)
                                @if($item->products->count()>0)
                                    @if(isset($slider) && $slider->category_ids != '')
                                        <option @foreach($slider['category_ids'] as $c)
                                        {{$c == $item['id'] ? 'selected' : ''}}
                                        @endforeach
                                        value="{{ $item['id'] }}">{{ $item['title'] }}</option>
                                    @else
                                        <option value="{{ $item['id'] }}">{{ $item['title'] }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                       
                    </div>
                </div>

              

                  <!-- Product Show In Slider -->
                  <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Product Show In Slider : ') }} <span class="text-danger">*</span></label>
                        <input type="number" value="{{ $slider->pro_limit ?? '' }}" min="1" max="50" name="pro_limit" class="form-control">
                    </div>
                </div>


                <!-- status -->
                <div class="col-md-6">
                    <div class="form-group">
                    <label class="text-dark">{{ __('Status : ') }}</label><br>
                        <label class="switch">
                            <input class="slider" type="checkbox" name="status" {{ isset($slider->status) && $slider->status == 1 ? "checked" : "" }} />
                            <span class="knob"></span>
                        </label>
                    </div>
                </div>

                 

                <!-- create and close button -->
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button @if(env('DEMO_LOCK') == 0) type="submit" @else title="{{ __('This action cannot be done in demo !') }}" disabled="disabled" @endif class="btn btn-primary-rgba">
                        <i class="fa fa-save"></i> {{ __("Save") }}</button>
                    </div>
                </div>

              </div><!-- row end -->
          </form>
      </div>
    </div>
  </div>
</div>
       

@endsection
@section('custom-script')
  <script src="{{ url('js/slider.js') }}"></script>
@endsection