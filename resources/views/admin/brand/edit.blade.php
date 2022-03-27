@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Brand | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Product Management") }}
@endslot

@slot('menu2')
{{ __("Edit Brand") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/brand')}}" class="btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <h5 class="box-title">{{ __("Edit Brand") }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/brand/'.$brand->id)}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Brand Name")}}: <span class="required">*</span>
              </label>

              <input placeholder="{{ __("Please enter brand name") }}" type="text" id="first-name" name="name"
                value=" {{$brand->name}} " class="form-control col-md-12">


            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Brand Image")}} <span class="required">*</span>
              </label>
              <br>

              <div class="mb-3">
                @if($image = @file_get_contents('images/brands/'.$brand->image))
                  <img src=" {{url('images/brands/'.$brand->image)}} " width="100px" class="rounded p-3 bg-primary-rgba img-fluid">
                @else
                  <img width="100px" src="{{ Avatar::create($brand->name)->toBase64() }}" class="rounded p-3 bg-primary-rgba img-fluid">
                @endif
              </div>
            
              <div class="input-group">

                <input required readonly id="image" name="image" type="text"
                    class="form-control">
                <div class="input-group-append">
                    <span data-input="image"
                        class="bg-primary text-light midia-toggle input-group-text">{{ __("Browse") }}</span>
                </div>
              </div>
              <small class="txt-desc">({{__("Please Choose Brand Image")}})</small>
            </div>


            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Select Category")}}: <span class="required">*</span>
              </label>



              <select multiple="multiple" class="form-control select2" name="category_id[]">
                @foreach (App\Category::where('status','1')->get(); as $item)

                @if($brand->category_id != '')
                <option @foreach($brand->category_id as $c)
                  {{$c == $item->id ? 'selected' : ''}}
                  @endforeach
                  value="{{ $item->id }}">{{ $item->title }}</option>
                @else
                <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endif
                @endforeach
              </select>


            </div>

            <div class="form-group">
              <label class="control-label" for="first-name">
                Show Image Footer <span class="required">*</span>
              </label>
              <br>
              <label class="switch">
                <input class="slider tgl tgl-skewed" type="checkbox"
                  <?php echo ($brand->show_image=='1')?'checked':'' ?> name="show_image">
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("If You Choose Active Then Image Show In Footer Brand Logo")}})</small>
            </div>

            <div class="form-group">
              <label class="control-label" for="first-name">
                {{__("Status")}}
              </label>
              <br>
              <label class="switch">
                <input class="slider tgl tgl-skewed" type="checkbox" <?php echo ($brand->status=='1')?'checked':'' ?>
                  name="status">
                <span class="knob"></span>
              </label>
              <br>
              <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{__("Choose status for your brand")}})</small>

            </div>
            <div class="box-footer">
              <div class="form-group">
                <button @if(env('DEMO_LOCK')==0) type="reset" @else disabled
                  title="{{ __('This operation is disabled is demo !') }}" @endif class="btn btn-danger"><i class="fa fa-ban"></i>
                  {{ __("Reset") }}</button>
                <button @if(env('DEMO_LOCK')==0) type="submit" @else disabled
                  title="{{ __('This operation is disabled is demo !') }}" @endif class="btn btn-primary"><i
                    class="fa fa-check-circle"></i>
                  {{ __("Update") }}</button>
              </div>
              <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom-script')
  <script>
      $(".midia-toggle").midia({
          base_url: '{{url('')}}',
          directory_name: 'brand',
          dropzone : {
            acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
          }
      });
  </script>
@endsection