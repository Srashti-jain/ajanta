@extends('admin.layouts.master-soyuz')
@section('title',__('Create Menu'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Menu Management") }}
@endslot

@slot('menu2')
{{ __("Menu") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{ url()->previous() }}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Add') }} {{ __('Menu') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
    
              <div class="col-md-4">
                <label>
                  <h3><input checked class="link_by" type="radio" name="link_by" value="cat"> {{ __("Link By Categories") }}</h3>
                </label>
               
                <label>
                  <h3><input class="link_by" type="radio" name="link_by" value="page"> {{ __('Link By Page') }}</h3>
                </label>
                
                <label>
                  <h3><input class="link_by" type="radio" name="link_by" value="url"> {{ __("Link By Custom URL") }}</h3>
                </label>
                
                              </div>
    
              <div class="col-md-8">
                <div class="form-group">
                  <label>{{__('Menu name:')}} <span class="required">*</span></label>
                  <input value="{{ old('title') }}" name="title" type="text" class="form-control" placeholder="enter menu menu name" required>
                </div>
    
                <div class="form-group">
                  <label>{{__("Menu icon :")}} </label>
                  <div class="input-group">
                    <input type="text" class="form-control iconvalue" name="icon" value="{{ old('icon') }}" >
                    <span class="input-group-append">
                        <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                    </span>
                </div>
                 </div>
    
                <div class="form-group categorybox">
                  <label>{{ __("Select categories:") }}</label>
                  <select required name="cat_id" class="form-control select2 category_id" id="category_id">
                        <option value="">{{ __('Please Select') }}</option>
                        @foreach($category->where('status','=','1') as $p)
                          <option value="{{$p->id}}">{{$p->title}}</option>
                        @endforeach
                  </select>
                </div>
    
                <div class="form-group display-none pagebox">
                  <label>{{ __('Select pages:') }}</label>
                  <select name="page_id" id="pageselector" class="pageselector form-control select2">
                        <option value="">{{ __('Please Choose') }}</option>
                        @foreach($pages as $page)
                        <option value="{{$page->id}}">{{$page->name}}</option>
                        @endforeach
                  </select>
                </div>
    
                <div class="form-group urlbox display-none">
                    <label>{{ __('URL') }}: <span class="required">*</span></label>
                    <input class="url form-control" type="url" placeholder="{{ __('enter custom url') }}" name="url">
                </div>
    
                <div class="form-group categoryboxoption">
                    <label>{{ __('Show categories in dropdown menu:') }}</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="show_cat_in_dropdown" class="show_cat_in_dropdown">
                        <span class="knob"></span>
                    </label>
                </div>
    
                <div id="maincat" class="form-group maincat display-none">
                    <label for="name">{{ __('Category') }}</label>
                    <ul class="list-group list-group-root well"> 
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-default">
                     @foreach(App\Category::where('status','1')->get(); as $item)  
                        <div class="panel-heading" role="tab" id="headingOne">
                          <h4 class="panel-title">
                            <a role="button" data-parent="#accordion" aria-expanded="true" aria-controls="collapseOne">
    
                                <input id="categories_{{$item->id}}" type="checkbox" class="pr_cat required_one categories" name="parent_cat[]" value="{{$item->id}}">
    
                                <i data-toggle="collapse" href="#test{{$item->id}}" class="more-less glyphicon glyphicon-plus"></i> {{$item->title}}
                            </a>
                        </h4>
                      </div>
                    <div id="test{{$item->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      @php
                        $dataList = $item->subcategory->where('status','1')->all();
                      @endphp
    
                      <div class="row left-15">
                        @foreach($dataList as $data)
                        <div class="col-md-6">
                          <label><input type="checkbox" name="child_cat[]" class="categories_panel required_one sub_categories sub_categories_{{$item->id}}" parents_id = "{{$item->id}}" value="{{$data['id']}}">&nbsp;{{$data['title']}}</label>
                        </div>
                        @endforeach   
                      </div>
                      
                    </div>
                    @endforeach
                  </div>  
                  </div>  
                  </ul> 
                </div>
    
                <div class="form-group subcategoriesoption">
                    <label>
                      {{__("Show subcategories and childcategories in dropdown menu:")}}
                    </label>
                    <br>
                    <label class="switch">
                        <input class="show_child_in_dropdown" type="checkbox" name="show_child_in_dropdown" id="show_child_in_dropdown">
                        <span class="knob"></span>
                    </label>
                </div>
    
                <div class="subcat">
                  
                </div>
    
                <div class="form-group advertiseoption display-none">
                    <label>
                      {{__('Show advertise in mega menu:')}}
                    </label>
                    <br>
                    <label class="switch">
                        <input class="show_image" type="checkbox" name="show_image" id="show_image">
                        <span class="knob"></span>
                    </label>
                </div>
    
                 <div id="imgBanner" class="imgBanner display-none">
                  <div class="form-group">
    
                    <label>
                      {{__('Choose Side Menu Banner Image:')}}
                    </label>
    
                    <div class="input-group mb-3">

                     
                      <div class="custom-file">
      
                        <input type="file" name="image" class="inputfile inputfile-1" id="first-name"
                          aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                      </div>
                    </div>                     
    
                  </div>  
    
                  <div class="form-group">
                    <label>
                      {{__('Image Link:')}}
                    </label>
    
                    <input placeholder="http://" type="url" name="img_link" class="form-control">           
                    <small class="text-info"><i class="fa fa-question-circle"></i> {{ __("Target URL so user click on image than where to redirect him/her.") }}</small>
                  </div>     
                </div>
    
                <div class="form-group">
                    <label>{{ __("Menu Tag:") }}</label>
                    <br>
                    <label class="switch">
                        <input class="menu_tag" type="checkbox" name="menu_tag" id="menu_tag">
                        <span class="knob"></span>
                    </label>
                </div>
    
                <div id="color" class="tagcolor form-group display-none">
                    <label>{{ __("Tag Background:") }}</label>
                    <input type="color" name="tag_background" class="form-control" value="#FDD922">
                </div>
    
                
                <div class="tagtextcolor form-group display-none">
                    <label>{{ __('Tag Text Color:') }}</label>
                    <input type="color" name="tag_color" class="form-control" value="#157ED2">
                </div>
    
                <div class="tagbgcolor form-group display-none">
                  <label>{{ __('Tag Text:') }}</label>
                  <input placeholder="{{ __('Please enter tag text') }}" type="text" name="tag_text" class="form-control tagtext">
                </div>
    
    
                <div class="form-group">
                    <label>{{ __('Status:') }}</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="status">
                        <span class="knob"></span>
                    </label>
                </div>
              
    
              </div>
              <div class="form-group">
                <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                  {{ __("Reset") }}</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                  {{ __("Create") }}</button>
              </div>
            </div>
              <div class="clear-both"></div>
            </div>
    
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom-script')
  <script>var customcatid = null</script>
  <script src="{{ url('js/menu.js') }}" ></script>
@endsection
