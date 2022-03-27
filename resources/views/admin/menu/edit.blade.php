@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Menu'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Menu Management") }}
@endslot

@slot('menu2')
{{ __("Edit Menu") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{ url('admin/menu') }}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __("Edit Menu") }}</h5>
        </div>
        <div class="card-body">
          
      <form action="{{ route('menu.update',$menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

          <div class="col-md-4">
            <label>
              <h3><input {{ $menu->link_by == 'cat' ? "checked" : "" }} class="link_by" type="radio" name="link_by" value="cat"> {{ __("Link By Categories") }}</h3>
            </label>
           
            <label>
              <h3><input {{ $menu->link_by == 'page' ? "checked" : "" }} class="link_by" type="radio" name="link_by" value="page"> {{ __('Link By Page') }}</h3>
            </label>
           
            <label>
              <h3><input {{ $menu->link_by == 'url' ? "checked" : "" }} class="link_by" type="radio" name="link_by" value="url"> {{ __("Link By Custom URL") }}</h3>
            </label>
           
          </div>

          <div class="col-md-8">
            <div class="form-group">
              <label>{{ __('Menu name:') }} <span class="required">*</span></label>
              <input value="{{ $menu->title }}" name="title" type="text" class="form-control" placeholder="{{ __('enter menu name') }}" required>
            </div>

            <div class="form-group">
              <label>{{__("Menu icon :")}} </label>
               <div id="icongroup">
                <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="{{ $menu->icon }}" >
                  <span class="input-group-append">
                      <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              </div>
                  
                
              </div>
            </div>

            <div class="form-group categorybox {{ $menu->link_by == 'cat' && $menu->show_cat_in_dropdown != 1 ? '' : 'display-none' }}">
              <label>{{ __("Select categories:") }}</label>
              <select {{ $menu->link_by == 'cat' && $menu->show_child_in_dropdown == 1 ? "required" : "" }} name="cat_id" class="form-control select2 category_id" id="category_id">
                    <option value="">{{ __('Please Select') }}</option>
                    @foreach($category->where('status','=','1') as $p)
                      <option {{ $menu->link_by == 'cat' && $menu->cat_id == $p->id ? "selected" : "" }} value="{{$p->id}}">{{$p->title}}</option>
                    @endforeach
              </select>
            </div>

            <div class="form-group {{ $menu->link_by == 'page' ? '' : 'display-none' }} pagebox">
              <label>
                {{__('Select pages:')}}
              </label>
              <select name="page_id" id="pageselector" class="pageselector form-control select2">
                    <option value="">
                      {{__("Please Choose")}}
                    </option>
                    @foreach($pages as $page)
                    <option {{ isset($menu->page_id) && $menu->page_id == $page->id ? "selected" : "" }} value="{{$page->id}}">{{$page->name}}</option>
                    @endforeach
              </select>
            </div>

            <div class="form-group urlbox {{ $menu->link_by == 'url' ? '' : 'display-none' }}">
                <label>{{__('URL:')}} <span class="required">*</span></label>
                <input value="{{ $menu->url }}" class="url form-control" type="url" placeholder="{{ __("enter custom url") }}" name="url">
            </div>

            <div class="form-group categoryboxoption {{ $menu->link_by == 'cat' ? '' : 'display-none' }}">
                <label>{{ __("Show categories in dropdown menu:") }}</label>
                <br>
                <label class="switch">
                    <input {{ $menu->show_cat_in_dropdown == 1 ? "checked" : "" }} type="checkbox" name="show_cat_in_dropdown" class="show_cat_in_dropdown">
                    <span class="knob"></span>
                </label>
            </div>

            <div id="maincat" class="maincat form-group {{ $menu->show_cat_in_dropdown == 1 ? '' : 'display-none' }}">
                  <label>{{ __('Category') }}</label>
                  <ul class="list-group list-group-root well"> 
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                 @foreach(App\Category::where('status','1')->get(); as $item)  
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-parent="#accordion" aria-expanded="true" aria-controls="collapseOne">
                            <?php
                              $pcats = $menu->linked_parent;
                              $childcats = $menu->linked_child;
                            ?>
                            <input @if($menu->show_cat_in_dropdown == 1 && isset($pcats)) @foreach($pcats as $p){{ $p == $item->id ? "checked" : "" }} @endforeach @endif id="categories_{{$item->id}}" type="checkbox" class="required_one categories" name="parent_cat[]" value="{{$item->id}}">

                            <i data-toggle="collapse" href="#test{{$item->id}}" class="more-less glyphicon glyphicon-plus"></i> {{$item->title}}
                        </a>
                    </h4>
                  </div>
                <div id="test{{$item->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  @php
                    $dataList = $item->subcategory->where('status','1')->all();
                  @endphp

                  <div class="left-15 row">
                    @foreach($dataList as $data)

                      <div class="col-md-6">
                        <label><input @if($menu->show_cat_in_dropdown == 1 && isset($childcats)) @foreach($childcats as $c){{ $c == $data['id'] ? "checked" : "" }} @endforeach @endif type="checkbox" name="child_cat[]" class="required_one sub_categories sub_categories_{{$item->id}}" parents_id = "{{$item->id}}" value="{{$data['id']}}"> {{$data['title']}}</label>
                      </div>
  
                    @endforeach
                  </div>
                   
                </div>
                @endforeach
            </div>  
            </div>  
            </ul> 
            
        </div> 

            <div class="form-group subcategoriesoption {{ $menu->link_by == 'cat' ? '' : 'display-none' }}">
                <label>
                  {{__("Show subcategories and childcategories in dropdown menu:")}}
                </label>
                <br>
                <label class="switch">
                    <input {{ $menu->show_child_in_dropdown == 1 ? "checked" : "" }} class="show_child_in_dropdown" type="checkbox" name="show_child_in_dropdown" id="show_child_in_dropdown">
                    <span class="knob"></span>
                </label>
            </div>

            <div class="subcat">
              
            </div>

            <div class="form-group advertiseoption {{ $menu->show_cat_in_dropdown == 1 || $menu->show_child_in_dropdown == 1 ? '' : 'display-none' }}">
                <label>
                  {{__("Show advertise in mega menu:")}}
                </label>
                <br>
                <label class="switch">
                    <input {{ $menu->show_image == 1 ? "checked" : "" }} class="show_image" type="checkbox" name="show_image" id="show_image">
                    <span class="knob"></span>
                </label>
            </div>

             <div id="imgBanner" class="imgBanner {{ $menu->show_image == 1 ? '' : 'display-none' }}">
              <div class="form-group">

                <label>
                    {{__("Choose Side Menu Banner Image:")}}
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

                <input value="{{ $menu->img_link }}" placeholder="http://" type="url" name="img_link" class="form-control">           
                <small class="help-block"><i class="fa fa-question-circle"></i> {{ __("Target URL so user click on image than where to redirect him/her.") }}</small>
              </div>     
            </div>

            <div class="form-group">
                <label>
                  {{__('Menu Tag:')}}
                </label>
                <br>
                <label class="switch">
                    <input {{ $menu->menu_tag == 1 ? "checked" : "" }} class="menu_tag" type="checkbox" name="menu_tag" id="menu_tag">
                    <span class="knob"></span>
                </label>
            </div>

            <div id="color" class="tagcolor form-group {{ $menu->menu_tag == 0 ? 'display-none' : '' }}">
                <label>
                  {{__("Tag Background:")}}
                </label>
                <input value="{{ $menu->tag_bg }}" type="color" name="tag_background" class="form-control" value="#FDD922">
            </div>

            
            <div class="tagtextcolor form-group {{ $menu->menu_tag == 0 ? 'display-none' : '' }}">
                <label>
                  {{__("Tag Text Color:")}}
                </label>
                <input value="{{ $menu->tag_color }}" type="color" name="tag_color" class="form-control" value="#157ED2">
            </div>

            <div class="tagbgcolor form-group {{ $menu->menu_tag == 0 ? 'display-none' : '' }}">
              <label>
                {{__("Tag Text:")}}
              </label>
              <input {{ $menu->menu_tag == 1 ? "required" : "" }} value="{{ $menu->tag_text }}" placeholder="{{ __('Please enter tag text') }}" type="text" name="tag_text" class="form-control tagtext">
            </div>


            <div class="form-group">
                <label>{{ __('Status:') }}</label>
                <br>
                <label class="switch">
                    <input {{ $menu->status == 1 ? "checked" : "" }} type="checkbox" name="status">
                    <span class="knob"></span>
                </label>
            </div>


          </div>
        </div>
        <div class="form-group">
          <button @if(env('DEMO_LOCK') == 0) type="reset" @else disabled title="{{ __('This operation is disabled is demo !') }}"
            @endif class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
          <button @if(env('DEMO_LOCK') == 0) type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}"
            @endif class="btn btn-primary"><i class="fa fa-check-circle"></i>
            {{ __("Update") }}</button>
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
  <script>var menuid  = @json($menu->id);</script>
  <script>var customcatid = @json($menu->show_child_in_dropdown == 1 ? $menu->cat_id : null);</script>
  <script src="{{ url('js/menu.js') }}" ></script>
@endsection 
