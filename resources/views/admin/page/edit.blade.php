@extends('admin.layouts.master-soyuz')
@section('title',__('Edit page :page | ',['page' => $page->name]))
@section('body')
​
@component('admin.component.breadcumb',['thirdactive' => 'active'])
​
@slot('heading')
{{ __('Pages') }}
@endslot
​
@slot('menu1')
{{ __("Page") }}
@endslot
​
@slot('menu2')
{{ __("Edit Page") }}
@endslot
​
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/page')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
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
          <h5>{{ __('Edit Pages') }}</h5>
        </div>
        <div class="card-body">
          
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/page/'.$page->id)}}" data-parsley-validate class="form-horizontal form-label-left">
              {{csrf_field()}}
              {{ method_field('PUT') }}
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-dark">{{ __('Page Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{$page->name}}" autofocus="" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Enter Page Name') }}" name="name" required="">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
          
                <div class="col-md-6">
                  <div class="form-group">
                      <label class="text-dark">{{ __('Slug') }} <span class="text-danger">*</span></label>
                      <input type="text" pattern="[/^\S*$/]+" value="{{$page->slug}}" autofocus="" class="form-control @error('slug') is-invalid @enderror" placeholder="{{ __('Enter Slug') }}" name="slug" required="">
                      @error('title')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                </div>
          
                <div class="col-md-12">
                  <div class="form-group">
                      <label class="text-dark">{{ __('Description') }} <span class="text-danger">*</span></label>
                      <textarea id="editor1" name="des" class="@error('des')  is-invalid @enderror" placeholder="Please enter description">{!! $page->des !!}</textarea>
                      <small>
                        {{__("Please enter description")}}
                      </small>
                      @error('des')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                </div>
​
                <div class="form-group col-md-2">
                    <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} </label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" {{ $page->status ==1 ? "checked" : "" }} />
                      <span class="knob"></span>
                    </label>
                </div>
        
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-save"></i>
                        {{ __("Update")}}</button>
                    </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  @endsection