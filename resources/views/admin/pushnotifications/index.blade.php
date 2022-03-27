@extends('admin.layouts.master-soyuz')
@section('title',__('Push Notification Manager | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Push Notification Manager') }}
@endslot
@slot('menu1')
{{ __("Marketing Tools") }}
@endslot
@slot('menu2')
{{ __("Push Notification Manager") }}
@endslot
@endcomponent
<div class="contentbar">
   
    <div class="row">
       
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{__("Push Notification Manager")}} </h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="fa fa-key mr-2"></i>{{ __("Push Notification Manager") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="fa fa-key mr-2"></i>{{ __("Onesignal Keys") }}</a>
                        </li>
                      
                    </ul>
                    <div class="tab-content" id="defaultTabContentLine">
                        <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                            <form action="{{ route('admin.push.notif') }}" method="POST">
                                @csrf
                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">{{__('Select User Group:')}} <span class="text-danger">*</span> </label>
                    
                                        <select required data-placeholder="{{ __('Please select user group') }}" name="user_group" id="" class="select2 form-control">
                                            <option value="">{{ __('Please select user group') }}</option>
                                            <option {{ old('user_group') == 'all_customers' ? "selected" : "" }} value="all_customers">
                                            {{__('All Customers') }}</option>
                                            <option {{ old('user_group') == 'all_sellers' ? "selected" : "" }} value="all_sellers">
                                            {{ __('All Sellers') }}</option>
                                            <option {{ old('user_group') == 'all_admins' ? "selected" : "" }} value="all_admins">{{ __('All Admins') }}</option>
                                            <option {{ old('user_group') == 'all' ? "selected" : "" }} value="all">{{ __('All Users (Seller + Customers + Admins)') }}</option>
                                        </select>
                                    </div>
                
                                    <div class="form-group col-md-6">
                                        <label for="">{{__("Subject:")}} <span class="required">*</span></label>
                                        <input placeholder="{{ __("Hey ! New stock arrived !") }}" type="text" class="form-control" required name="subject" value="{{ old('subject') }}">
                                    </div>
                
                                    <div class="form-group col-md-6">
                                        <label for="">{{__("Notification Body:")}} <span class="text-red">*</span> </label>
                                        <textarea required placeholder="{{ __("Hey I want to tell you something awesome thing !") }}" class="form-control" name="message" id="" cols="3" rows="5">{{ old('message') }}</textarea>
                                    </div>
                
                                    <div class="form-group col-md-6">
                                        <label for="">{{__("Target URL:")}} </label>
                                        <input value="{{ old('target_url') }}" class="form-control" name="target_url" type="url" placeholder="{{ url('/') }}">
                                        <small class="text-muted">
                                            <i class="fa fa-question-circle"></i>
                                            {{__("On click of notification where you want to redirect the user.")}}
                                        </small>
                                    </div>
                
                                    <div class="form-group col-md-6">
                                        <label for="">{{__("Notification Icon:")}} </label>
                                        <input value="{{ old('icon') }}" name="icon" class="form-control" type="url" placeholder="https://someurl/icon.png">
                                        <small class="text-muted">
                                            <i class="fa fa-question-circle"></i> 
                                            {{__("If not enter than default icon will use which you upload at time of create one signal app.")}}
                                        </small>
                                    </div>
                
                                    <div class="form-group col-md-6">
                                        <label for="">Image: </label>
                                        <input value="{{ old('image') }}" class="form-control" name="image" type="url" placeholder="https://someurl/image.png">
                                        <small class="text-muted">
                                            <i class="fa fa-question-circle"></i> <b>{{  __('Recommnaded Size:') }} 450x228 px.</b>
                                        </small>
                                    </div>
                
                                    <div class="from-group col-md-12">
                                        <label for="">{{ __('Show Button:') }} </label>
                                        <br>
                                        <label class="switch">
                                            <input {{ old('show_button') ? "checked" : "" }} class="show_button" type="checkbox" name="show_button">
                                            <span class="knob"></span>
                                        </label>
                                    </div>
                                   
            
                               
                                    <div style="display: {{ old('show_button') ? 'block' : 'none' }};" id="buttonBox" class="col-md-12" >
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="">{{ __('Button Text:') }}  <span class="text-danger">*</span></label>
                                                <input value="{{ old('btn_text') }}" class="form-control" name="btn_text" type="text" placeholder="Grab Now !">
                                            </div>
                    
                                            <div class="form-group col-md-6">
                                                <label for="">{{__("Button Target URL:")}} </label>
                                                <input value="{{ old('btn_url') }}" class="form-control" name="btn_url" type="url" placeholder="https://someurl/image.png">
                                                <small class="text-muted">
                                                    <i class="fa fa-question-circle"></i> {{__("On click of button where you want to redirect the user.")}}
                                                </small>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="from-group col-md-6 mt-1">
                                        <button type="submit" class="btn btn-primary-rgba">
                                            <i class="fa fa-check-circle mr-2"></i> {{__("Send")}}
                                        </button>
                                    </div>
                                 </div>
                                
                            </form>
                        </div>
                     
                        
                        <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                           <div class="row">
                               <div class="col-md-12 form-group">
                                    <a title="Get one signal keys" href="https://onesignal.com/" target="__blank">
                                        <i class="fa fa-key"></i> {{__("Get your keys from here")}}
                                    </a>
                               </div>
                               <div class="col-md-12">
                                <form action="{{ route('admin.onesignal.keys') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="eyeCy">

                                            <label for="ONESIGNAL_APP_ID"> ONESIGNAL APP ID: <span class="text-danger">*</span></label>
                                            <input type="password" value="{{ env('ONESIGNAL_APP_ID') }}"
                                                name="ONESIGNAL_APP_ID" placeholder="{{ __("Enter ONESIGNAL APP ID") }}" id="ONESIGNAL_APP_ID" type="password"
                                                class="form-control">
                                            <span toggle="#ONESIGNAL_APP_ID"
                                                class="fa fa-fw fa-eye field-icon toggle-password"></span>
                
                                        </div>
                                    </div>
                
                                    <div class="form-group">
                                        <div class="eyeCy">

                                            <label for="ONESIGNAL_REST_API_KEY"> ONESIGNAL REST API KEY: <span class="text-danger">*</span></label>
                                            <input type="password" value="{{ env('ONESIGNAL_REST_API_KEY') }}"
                                                name="ONESIGNAL_REST_API_KEY" placeholder="{{ __('Enter ONESIGNAL REST API KEY') }}" id="ONESIGNAL_REST_API_KEY" type="password"
                                                class="form-control">
                                            <span toggle="#ONESIGNAL_REST_API_KEY"
                                                class="fa fa-fw fa-eye field-icon toggle-password"></span>
                
                                        </div>
                                    </div>
                
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary-rgba">
                                            <i class="fa fa-check-circle mr-2"></i> {{__("Save Keys")}}
                                        </button>
                                    </div>
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
                           
          
@endsection
@section('custom-script')
    <script>
        $('.show_button').on('change',function(){

            if($(this).is(":checked")){
                $('input[name=btn_text]').attr('required','required');
                $('#buttonBox').show('fast');
            }else{
                $('input[name=btn_text]').removeAttr('required');
                $('#buttonBox').hide('fast');
            }

        });
    </script>
@endsection