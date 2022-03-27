@extends('admin.layouts.master-soyuz')
@section('title',__('Create a Subcategory |'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("SubCategory") }}
@endslot

@slot('menu2')
{{ __("SubCategory") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/subcategory')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __('Add') }} {{ __('SubCategory') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/subcategory')}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="form-group">
              <label class="control-label" for="first-name">
                Parent Category: <span class="required">*</span>
              </label>
              <div class="row">
                <div class="col-md-10">
                  <select name="parent_cat" class="form-control select2 col-md-12">

                    @foreach($parent as $p)
                    <option value="{{$p->id}}">{{$p->title}}</option>
                    @endforeach
                  </select>
                  <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Parent Category")}})</small>

                </div>
                <div class="col-md-2">
                  @can('category.create')
                  <button type="button" data-toggle="modal" data-target="#myModal"
                    class="btn btn-md btn-primary">+</button>
                  @endcan
                </div>
              </div>

            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Subcategory")}}: <span class="required">*</span>
              </label>

              
                <input placeholder="{{ __('Please enter subcategory name') }}" type="text" id="first-name" name="title"
                  class="form-control col-md-12">

             

            </div>
            <div class="form-group">
              <label class="control-label" for="first-name"> {{__('Description')}}: <span class="required">*</span>
              </label>
          
                <textarea cols="2" id="editor1" name="description" rows="5">
                           </textarea>
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please enter description")}})</small>

          
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Icon')}}:
              </label>
          
                <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="{{  __('Choose icon') }}">
                  <span class="input-group-append">
                    <button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              


              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name"> {{__("Image")}}:
              </label>
              <div class="input-group">

                <input required readonly id="image" name="image" type="text"
                    class="form-control">
                <div class="input-group-append">
                    <span data-input="image"
                        class="bg-primary text-light midia-toggle input-group-text">{{ __("Browse") }}</span>
                </div>
              </div>
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose image")}})</small>

             
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Featured")}}:
              </label>
              <br>
                <label class="switch">
                  <input class="slider tgl tgl-skewed" type="checkbox" id="featured" checked="checked">
                  <span class="knob"></span>
                </label>
                <br>
                <input type="hidden" name="featured" value="1" id="featured">
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("If enabled than Subcategory will be featured")}})</small>

             
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__('Status')}}: <span class="required">*</span>
              </label>
              <br>
                <label class="switch">
                  <input class="slider tgl tgl-skewed" type="checkbox" id="status" checked="checked">
                  <span class="knob"></span>
                </label>
                <br>
                <input type="hidden" name="status" value="1" id="status3">
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Status")}})</small>
            
            </div>
            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                {{ __("Reset") }}</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                {{ __("Create") }}</button>
            </div>

            <div class="clear-both"></div>
          </form>

        </div>
        <!-- /.box -->

        @can('category.create')

        <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ __('Add Category') }}</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
              </div>

              <div class="modal-body">
                <form enctype="multipart/form-data" action="{{ route('quick.cat.add') }}" method="POST">
                  @csrf
                  <label for="">{{__("Category Name")}}:</label>
                  <input required type="text" class="form-control" placeholder="{{ __("Enter category name") }}" name="title" />
                  <br>
                  <label for="">{{ __('Description') }}:</label>
                  <textarea name="detail" id="editor2" cols="30" rows="10"></textarea>
                  <br>

                  <label for="">{{__("Icon")}}:</label>
                  <div class="input-group">
                    <input type="text" class="form-control iconvalue" name="icon" value="{{ __('Choose icon') }}">
                    <span class="input-group-append">
                        <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                    </span>
                </div>
                 

                  <br>
                  <label for="">{{__('Category Image')}}:</label>
                  <div class="input-group">

                    <input required readonly id="image" name="image" type="text"
                        class="form-control">
                    <div class="input-group-append">
                        <span data-input="image"
                            class="bg-primary text-light midia-toggle1 input-group-text">{{ __('Browse') }}</span>
                    </div>
                  </div>
                  <br>
                  <label for="">{{__("Status")}}:</label>
                  <label class="switch">
                    <input class="slider tgl tgl-skewed" type="checkbox" id="status4" checked="checked">
                    <span class="knob"></span>
                  </label>
                  <br>
                  <input type="hidden" name="status" value="1" id="status4">
                  <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Status")}})</small>

                  <br>
                  <label for="">{{__('Featured')}}:</label>
                  <label class="switch">
                    <input class="slider tgl tgl-skewed" type="checkbox" id="status5" checked="checked">
                    <span class="knob"></span>
                  </label>
                  <br>
                  <input type="hidden" name="featured" value="1" id="status5">
                  <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Please Choose Feature")}})</small>
                  <br>
                  <div class="form-group">
                    <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                      {{ __("Reset") }}</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                      {{ __("Create") }}</button>
                  </div>

                  <div class="clear-both"></div>
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

@endcan

@endsection
@section('custom-script')
  <script>
      $(".midia-toggle").midia({
          base_url: '{{ url('') }}',
          directory_name: 'subcategory'
      });

      $(".midia-toggle1").midia({
          base_url: '{{ url('') }}',
          directory_name: 'category'
      });
  </script>
@endsection