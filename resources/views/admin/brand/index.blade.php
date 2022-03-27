@extends('admin.layouts.master-soyuz')
@section('title',__('All Brands | '))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('All Brands') }}
@endslot

@slot('menu1')
{{ __('Brands') }}
@endslot

@slot('button')

<div class="col-md-6">
  <div class="widgetbar">
    <a data-toggle="modal" data-target="#importbrand" role="button" class="btn btn-success-rgba mr-2">
      <i class="feather icon-file-text mr-2"></i> {{__("Import Brands")}}
    </a>
    <a href=" {{url('admin/brand/create')}} " class="btn btn-primary-rgba mr-2">
      <i class="feather icon-plus mr-2"></i> {{__("Add Brand")}}
    </a>
  </div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  <div class="row">

    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title"> {{__("All Brands")}}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="brandTable" class="width100 table table-bordered table-striped">
              <thead>
                <tr>
                  <th>{{ __("Sr. NO.") }}</th>
                  <th>{{ __("Brand Name") }}</th>
                  <th>{{ __("Brand Logo") }}</th>
                  <th>{{ __("Status") }}</th>
                  <th>{{ __("Action") }}</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@foreach($brands as $brand)
<div class="modal fade bd-example-modal-sm" id="delete{{$brand->id}}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __("DELETE") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>{{ __('Are You Sure ?')}}</h4>
        <p>{{ __('Do you really want to delete')}}? {{ __('This process can\'t be undone.')}}</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{url('admin/brand/'.$brand->id)}}" class="pull-right">
          {{csrf_field()}}
          {{method_field("DELETE")}}
          <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{  __('NO') }}</button>
          <button type="submit" class="btn btn-primary">{{ __("YES") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

<div class="modal fade" id="importbrand" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleStandardModalLabel">{{__("Bulk Import Brands")}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- main content start -->
        <a href="{{ url('files/Brands.xlsx') }}" class="btn btn-md btn-success"> {{__("Download Example xls/csv file")}}
          </a>
        <hr>
        <form action="{{ url('/import/brands') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="form-group col-md-12">
              <label for="file">{{__("Choose your xls/csv file")}} :</label>
              <!-- ------------ -->
              <div class="input-group mb-3">
               
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="file" id="inputGroupFile01"
                    aria-describedby="inputGroupFileAddon01" required>
                  <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file") }} </label>
                </div>
                @if ($errors->has('file'))
                <span class="invalid-feedback text-danger" role="alert">
                  <strong>{{ $errors->first('file') }}</strong>
                </span>
                @endif
                <p></p>
              </div>
              <!-- ------------- -->
              <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> {{ __('Import') }}</button>
            </div>

          </div>

        </form>

        <div class="box box-danger">
          <div class="box-header with-border">
            <div class="box-title">{{ __("Instructions") }}</div>
          </div>

          <div class="box-body">
            <p><b>{{ __("Follow the instructions carefully before importing the file.") }}</b></p>
            <p>{{ __("The columns of the file should be in the following order.") }}</p>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th>{{ __("Column NO") }}</th>
                  <th>{{ __("Column Name") }}</th>
                  <th>{{ __("Required") }}</th>
                  <th>{{ __("Description") }}</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>1</td>
                  <td><b>name</b></td>
                  <td><b>{{ __("Yes") }}</b></td>
                  <td>{{ __("Enter brand name") }}</td>
                </tr>

                <tr>
                  <td>2</td>
                  <td> <b>status</b> </td>
                  <td><b>{{ __("Yes") }}</b></td>
                  <td>{{ __("Brand status") }} (1 = {{__("active")}}, 0 = {{__("deactive")}})</b> .</td>
                </tr>
                

                <tr>
                  <td>3</td>
                  <td> <b>image</b> </td>
                  <td><b>{{  __('NO') }}</b></td>
                  <td>{{__('Name your image eg: example.jpg')}} <b>({{__("Image can be uploaded using Media Manager / Brand Tab.")}} )</b> .</td>
                </tr>

                <tr>
                  <td>4</td>
                  <td> <b>show_image</b> </td>
                  <td><b>{{  __('NO') }}</b></td>
                  <td>{{ __("Show brand in brand slider in footer (front)") }}</b> .</td>
                </tr>

                <tr>
                  <td>5</td>
                  <td> <b>category_id</b> </td>
                  <td><b>{{ __("Yes") }}</b></td>
                  <td>{{ __("Multiple category id can be pass here seprate by comma") }}</b> .</td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
        <!-- main content end -->
      </div>

    </div>
  </div>
</div>

@endsection
@section('custom-script')
<script>
  var url = @json(route('brand.index'));
</script>
<script src="{{ url('js/brand.js') }}"></script>
@endsection