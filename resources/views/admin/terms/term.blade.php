@extends('admin.layouts.master-soyuz')
@section('title',__('Terms Settings | '))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Terms Settings') }}
@endslot
@slot('menu1')
   {{ __('Terms Settings') }}
@endslot




@endcomponent

<div class="contentbar">
  <!-- Start row -->
  <div class="row">
      <!-- Start col -->
      <div class="col-md-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{ __("Terms Settings") }}</h5>
              </div>
              <div class="card-body">
                  <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-user mr-2"></i>{{ __("User term setting") }}</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-users mr-2"></i>{{ __("Seller term setting") }}</a>
                      </li>
                      
                  </ul>
                  <div class="tab-content" id="defaultTabContentLine">
                      <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                        <form method="POST" action="{{ route('update.term.setting',$userTerm->key) }}">
                          @csrf

                          <div class="form-group">
                              <label for="title">{{__("Title:")}} <span class="required">*</span></label>
                              <input required placeholder="{{ __("Enter title") }}" id="title" class="form-control" type="text" name="title" value="@if(old('title')) {{ old('title') }} @elseif(isset($userTerm)){{ $userTerm['title'] }}@endif">

                              @error('title')
                                <p class="text-danger">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label>{{__("Description:")}} <span class="required">*</span></label>
                              <textarea placeholder="{{__('Enter content')}}" class="editor" name="description" id="description" cols="30" rows="10">@if(old('content')) {{ old('content') }} @elseif(isset($userTerm)){!! $userTerm['description'] !!}@endif</textarea>

                              @error('description')
                                <p class="text-danger">{{ $message }}</p>
                              @enderror
                          </div>

                          <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                            {{ __("Update")}}</button>
                          </div>
                      </form>
                      </div>
                      <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                        <form method="POST" action="{{ route('update.term.setting',$sellerTerm->key) }}">
                          @csrf
  
                          <div class="form-group">
                              <label for="title">{{__('Title:')}} <span class="required">*</span></label>
                              <input required placeholder="{{ __("Enter title") }}" id="title" class="form-control" type="text" name="title" value="@if(old('title')) {{ old('title') }} @elseif(isset($sellerTerm)){{ $sellerTerm['title'] }}@endif">
  
                              @error('title')
                                <p class="text-danger">{{ $message }}</p>
                              @enderror
                          </div>
  
                          <div class="form-group">
                              <label>{{__("Description:")}} <span class="required">*</span></label>
                              <textarea placeholder="{{ __('Enter content') }}" class="editor" name="description" id="description" cols="30" rows="10">@if(old('content')) {{ old('content') }} @elseif(isset($sellerTerm)){!! $sellerTerm['description'] !!}@endif</textarea>
  
                              @error('description')
                                <p class="text-danger">{{ $message }}</p>
                              @enderror
                          </div>
  
                          <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                            {{ __("Update")}}</button>
                          </div>
                      </form>
                      </div>
                      
                  </div>
              </div>
          </div>
      </div>

@endsection     
               