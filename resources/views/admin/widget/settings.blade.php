@extends('admin.layouts.master-soyuz')
@section('title',__('Widget Settings | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Widget Settings') }}
@endslot
@slot('menu1')
   {{ __('Front Settingss') }}
@endslot
@slot('menu2')
   {{ __('Widget Settingss') }}
@endslot




@endcomponent

<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __("Widget Settings") }}</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-grid mr-2"></i>
                                {{__('Sidebar Widgets')}}    
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-file-text mr-2"></i>
                                {{__("Main Page Widgets")}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab-line" data-toggle="tab" href="#contact-line" role="tab" aria-controls="contact-line" aria-selected="false"><i class="feather icon-folder mr-2"></i>
                                {{__("Chat Widgets")}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="defaultTabContentLine">
                        <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <th>
                                        
                                        {{__("Widget Example:")}}
        
                                    </th>
                                    <th>
                                        {{__('Widget Name')}}
                                    </th>
                                    <th>
                                        {{__("Widget Place")}}
                                    </th>
                                </thead>
        
                                <tbody>
        
                                    @foreach($widgets as $widget)
                                    <tr>
                                        <td>
                                            @if($widget->name == 'category')
                                            <img  class="img-fluid widget_image"
                                                src="{{ url('images/widgetpreview/category.png') }}" alt="{{ $widget->name }}"
                                                title="{{ ucfirst($widget->name) }}">
                                            @elseif($widget->name == 'hotdeals')
                                            <img  class="img-fluid widget_image"
                                                src="{{ url('images/widgetpreview/hotdeal.png') }}" alt="{{ $widget->name }}"
                                                title="{{ ucfirst($widget->name) }}">
                                            @elseif($widget->name == 'specialoffer')
                                            <img  class="img-fluid widget_image"
                                                src="{{ url('images/widgetpreview/spoffer.png') }}" alt="{{ $widget->name }}"
                                                title="{{ ucfirst($widget->name) }}">
                                            @elseif($widget->name == 'testimonial')
                                            <img  class="img-fluid widget_image"
                                                src="{{ url('images/widgetpreview/testimonial.png') }}"
                                                alt="{{ $widget->name }}" title="{{ ucfirst($widget->name) }}">
                                            @elseif($widget->name == 'newsletter')
                                            <img  class="img-fluid widget_image"
                                                src="{{ url('images/widgetpreview/newsletter.png') }}" alt="{{ $widget->name }}"
                                                title="{{ ucfirst($widget->name) }}">
                                            @elseif($widget->name == 'slider')
                                            <img  class="img-fluid widget_image"
                                                src="{{ url('images/widgetpreview/slider.png') }}" alt="{{ $widget->name }}"
                                                title="{{ ucfirst($widget->name) }}">
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($widget->name) }}</td>
                                        <td>
        
                                            <div class="row">
        
                                                <div class="col-md-6">
                                                    @if($widget->name == 'testimonial' || $widget->name == 'specialoffer' ||
                                                    $widget->name == 'slider' || $widget->name == 'category' || $widget->name ==
                                                    'hotdeals' || $widget->name == 'newsletter')
                                                    <p><b>{{ __("Show On Home Page:") }}</b></p>
                                                    @endif
        
                                                    <form action="{{ route('widget.home.quick.update',$widget->id) }}"
                                                        method="POST">
                                                        {{csrf_field()}}
                                                        <button type="submit"
                                                            class="btn btn-xs {{ $widget->home==1 ? "btn-success-rgba" : "btn-danger-rgba" }}">
                                                            {{ $widget->home ==1 ? 'Yes' : 'No' }}
                                                        </button>
                                                    </form>
                                                </div>
        
                                                <div class="col-md-6">
        
                                                    @if($widget->name == 'hotdeals' || $widget->name == 'newsletter')
                                                    <p><b>{{ __("Show On Product Detail Page:") }}</b></p>
                                                    @endif
        
                                                    @if($widget->name == 'newsletter' || $widget->name == 'hotdeals')
                                                    <form action="{{ route('widget.shop.quick.update',$widget->id) }}"
                                                        method="POST">
                                                        {{csrf_field()}}
                                                        <button @if(env("DEMO_LOCK")==0) type="submit" @else
                                                            title="{{ __("This action is disabled in demo !") }}" disabled="disabled" @endif
                                                            class="btn btn-xs {{ $widget->shop==1 ? "btn-success-rgba" : "btn-danger-rgba" }}">
                                                            {{ $widget->shop ==1 ? 'Yes' : 'No' }}
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
        
        
        
        
                                        </td>
                                    </tr>
                                    @endforeach
        
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                            <h4>
                                {{__("Widget Example:")}}
                            </h4>
                            <hr>
                            <div class="col-md-12">
                                <img class="img-responsive pagewidth_image" src="{{ url('images/widgetpreview/newpro.png') }}" alt="" />
                            </div>
                           
                            <form id="demo-form2" method="post" enctype="multipart/form-data"
                                action="{{url('admin/NewProCat')}}" data-parsley-validate
                                class="form-horizontal form-label-left">
                                {{csrf_field()}}
                               
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>
                                                {{__("Select Categories to show:")}}
                                            </h5>

                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="card">
                                                   <div class="card-body">
                                                    <div class="row">
                                                        @foreach(App\Category::where('status','1')->get(); as $item)
                                                        @php
                                                        if(!empty($NewProCat)){
                                                        $parents = explode(",",$NewProCat->name);
                                                        }
                                                        @endphp
            
                                                        <div class="col-md-6">
                                                            <div class="panel-heading" role="tab" id="headingOne">
                                                                <h5 class="panel-title">
                                                                    <a role="button" data-parent="#accordion" aria-expanded="true"
                                                                        aria-controls="collapseOne">
                                                                        <input id="categories_{{$item->id}}" @if(!empty($parents))
                                                                            @foreach($parents as $p)
                                                                            {{ $p == $item->id ? "checked" : "" }} @endforeach
                                                                            @endif type="checkbox" class=" required_one categories"
                                                                            name="name[]" value="{{$item->id}}">
            
                                                                        {{$item->title}}
                                                                    </a>
                                                                </h5>
                                                            </div>
                                                        </div>
            
                                                        @endforeach
                                                    </div>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                        
                                        
                                <hr>
        
                                <div class="">
                                    <h5> {{ __('Status:') }}</h5>
                                     
                                        <label class="switch">
                                            <input class="slider" type="checkbox" @if(!empty($NewProCat))
                                            {{ $NewProCat->status ==1 ? "checked" : "" }} @endif  id="toggle-event3" name="status" >
                                            <span class="knob"></span>
                                          </label>
                                        
                                        <input type="hidden" name="status"
                                            value="@if(!empty($NewProCat)) {{ $NewProCat->status }} @endif" id="status3">
                                    </div>
                                
                               
                                     <div class="">
                                     
                                        <button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                        <button   class="btn btn-primary-rgba" @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" title="This action is disabled in demo !" @endif><i class="fa fa-check-circle"></i>
                                        {{ __("Update")}}</button>
                                       
                                    </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="contact-line" role="tabpanel" aria-labelledby="contact-tab-line">
                            <h4>
                                {{__("Chat Widget Settings:")}}
                            </h4>
                            <hr>
                            <form action="{{ route('wp.setting.update') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="my-input">{{ __("Enable Whatsapp Chat Floating Button:") }}</label>
                                            <br>
                                            <label class="switch">
                                                <input id="status" type="checkbox" name="status"
                                                  {{ $wp->status == 1 ? "checked" : "" }}>
                                                <span class="knob"></span>
                                            </label>
                                        </div>
                
                                        <div class="form-group">
                                            <label for="my-input">
                                                {{__("Whatsapp No: (with country code without [+] sign):")}}
                                            </label>
                                            <input name="phone_no" value="{{ $wp->phone_no }}" class="form-control" type="text" name="size" placeholder="eg:01234567890">
                                        </div>
                
                                        <div class="form-group">
                                            <label for="my-input">
                                                {{__("Popmessage Text:")}}
                                            </label>
                                            <input value="{{ $wp->popupMessage }}" id="my-input" class="form-control" type="text" name="popupMessage" placeholder="eg: Hi ! How can we help you?">
                                        </div>
                
                                        <div class="form-group">
                                            <label for="my-input">
                                                {{__("Button Size:")}}
                                            </label>
                                            <input value="{{ $wp->size }}" id="my-input" class="form-control" type="text" name="size" placeholder="eg:60px">
                                        </div>
                
                                        <div class="form-group">
                                            <label for="my-input">
                                                {{__("Position:")}}
                                            </label>
                                            <input value="{{ $wp->position }}" id="my-input" class="form-control" type="text" name="position" placeholder="eg:left">
                                        </div>
                
                                        <div class="form-group">
                                            <label for="my-input">
                                                {{__("Header title:")}}
                                            </label>
                                            <input value="{{ $wp->headerTitle }}" id="my-input" class="form-control" type="text" name="headerTitle" placeholder="eg:Chat with us !">
                                        </div>
                
                                        <div class="form-group">
                                            <label for="my-input">
                                                {{__('Header color:')}}
                                            </label>
                                            <div  class="input-group initial-color" title="Using input value">
                                                <input type="text" class="form-control input-lg"  id="my-input" value="{{ $wp->headerColor }}" name="headerColor"  placeholder="#000000"/>
                                                <span class="input-group-append">
                                                  <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                                </span>
                                              </div>
                                        </div>
                                    </div>
        
                                    <div class="col-md-6">
                                        <h4><i class="fa fa-facebook-official" aria-hidden="true"></i>
                                            {{__("Messenger Bubble Chat URL:")}}    
                                        </h4><br>
                                            <label>{{ __("MESSENGER CHAT BUBBLE URL :") }}</label><br>
                                        <div class="form-group">
                                           
                                            <small>
                                                <a target="__blank" title="{{ __("Get your code") }}" class="text-muted" href="https://app.respond.io/"><i
                                                    class="fa fa-key"></i> {{ __("Get Your Code For Messenger Chat Bubble URL Here Here") }}</a>
                                            </small>
                                            <br>
                                            <input placeholder="https://app.respond.io/facebook/chat/plugin/XXXX/XXXXXXXXXX"
                                            id="MESSENGER_CHAT_BUBBLE_URL" value="{{ env('MESSENGER_CHAT_BUBBLE_URL') }}"
                                            name="MESSENGER_CHAT_BUBBLE_URL" type="text" class="form-control"
                                            placeholder="{{ __("Enter MESSENGER CHAT BUBBLE URL") }}">
                                        </div>
                                       
                                       
                                    </div>
        
                                </div>
        
                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button   class="btn btn-primary-rgba" @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="disabled" @endif><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>

                                </div>
        
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection     
                        
    
                    
    
                  
          
                  
    
    
          
                  
    
    
                  
                  
                
    
                
                                      


          

            
          
              




            

            
            
            
  
                 
  
               
  
          
    
             
            

          


