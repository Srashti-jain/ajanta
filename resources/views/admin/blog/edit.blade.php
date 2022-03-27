@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Blog'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Front Settings") }}
@endslot

@slot('menu2')
{{ __("Edit Blog") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{ url('admin/blog') }}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __("Edit Blog") }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/blog/'.$blog->id)}}"
            data-parsley-validate class="form-horizontal form-label-left"> {{csrf_field()}} {{ method_field('PUT') }}
            <div class="form-group">
              <label class="control-label" for="first-name"> {{__('Heading')}} <span class="required">*</span> </label>
              
                <input placeholder="{{ __('Enter heading') }}" type="text" id="first-name" name="heading"
                  value="{{ucfirst($blog->heading)}}" class="form-control col-md-12"> </div>
           
            <div class="form-group">
              <label class="control-label" for="first-name"> {{__('Description')}} <span class="required">*</span>
              </label>
              
                <textarea cols="2" id="editor1" name="des" rows="5"> {{ucfirst($blog->des)}} </textarea> 
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Enter Description")}})</small>
           
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">{{__("Author Name")}}: <span class="required">*</span>
              </label>
              
                <input placeholder="{{ __("Enter writer name") }}" type="text" id="first-name" name="user"
                  value="{{ucfirst($blog->user)}}" class="form-control col-md-12">
                <p class="txt-desc">
            
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">About Author: (optional) </label>
              
                <textarea placeholder="{{ __('Write something about author') }}" type="text" id="editor1" name="about"
                  value="{{ucfirst($blog->about)}}" class="form-control col-md-12"></textarea>
          
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name"> Designation: (optional) </label>
             
                <input type="text" placeholder="{{ __("About author designation eg. CEO, Admin") }}" id="first-name" name="post"
                  value="{{ucfirst($blog->post)}}" class="form-control col-md-12"> </div>
            
            <div class="form-group">
              <label class="control-label" for="first-name">Image <span
                  class="required">*</span> </label>
             
                  <div class="input-group">

                    <input required readonly id="image" name="image" type="text"
                        class="form-control">
                    <div class="input-group-append">
                        <span data-input="image"
                            class="bg-primary text-light midia-toggle input-group-text">{{ __("Browse") }}</span>
                    </div>
                  </div>

                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Choose Image for blog post")}})</small>
                  <br>
                  <img src=" {{url('images/blog/'.$blog->image)}}"
                  class="pro-img" />
            </div>

            <div class="form-group">
              <label>
                {{__("Status")}}:
              </label><br>
              <label class="switch">
                <input class="slider tgl tgl-skewed" type="checkbox" id="toggle-event33"
                  {{$blog->status ==1 ? "checked" : ""}}>
                <span class="knob"></span>
                <input type="hidden" name="status" value="{{ $blog->status }}" id="status3">

              </label>
              <br>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Choose status")}})</small>
            </div>
            <div class="form-group">
              <button @if(env('DEMO_LOCK')==0) type="reset" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn btn-danger"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
              <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled title="{{ __('This operation is disabled is demo !') }}"
                @endif class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Update") }}</button>
            </div>
            <div class="clear-both"></div>
        </div>
        </form>
      </div>
    </div>
  
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-header">
        <h5 class="box-title">{{ __("Manage Comments") }}</h5>
        <table id="commenttable" class="table table-bordered">
          <thead>
            <th>#</th>
            <th>{{ __("Name") }}</th>
            <th>{{ __("Comment") }}</th>
            <th>{{ __("Action") }}</th>
          </thead>

          <tbody>
            <tr>

            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>


@endsection
@section('custom-script')
<script>
  var url = @json(route('load.edit.postcomments', $blog->id));
</script>
<script src="{{ url('js/blogcomment.js') }}"></script>
<script>
    $(".midia-toggle").midia({
        base_url: '{{ url('') }}',
        directory_name: 'blog'
    });
</script>
@endsection