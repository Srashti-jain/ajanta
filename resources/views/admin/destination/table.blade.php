@extends('admin.layouts.master-soyuz')
@section('title',__('Pincode list of :country | ',['country' => $country->nicename]))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('All Cities') }}
@endslot

@slot('menu1')
{{ __('Cities') }}
@endslot

@slot('button')
<div class="col-md-6">
  <a href="{{ route('admin.desti') }}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i> {{ __("Back") }}</a>
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
          <button data-target="#bulkupdatepincode" data-toggle="modal" class="btn btn-md btn-primary-rgba ml-2  float-right">
            <i class="feather icon-file-text"></i> {{__("Bulk Update Pincode")}}
         </button>
         
          <form id="bulk_export_form" method="POST" action="{{ route('pincode.export') }}" class="float-right form-inline">
              @csrf
              <button type="submit" class="btn btn-md btn-primary-rgba">
                  {{__("Export selected cities")}}
              </button>
          </form>
          
          <h5 class="card-title"> {{ __("All Country") }}</h5>
          
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="" class="data-table table table-hover">
              <thead>
                <tr class="table-heading-row">

                  <th>
                    <div class="inline">
                      <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all"/>
                      <label for="checkboxAll" class="material-checkbox"></label>
                    </div>
                  
                  </th>
                  <th>{{ __('ID') }}</th>
                  <th>{{ __('City') }}</th>
                  <th>{{ __('State') }}</th>
                  <th>{{ __("Pincode") }}</th>

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

<div id="bulkupdatepincode" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">
          {{__("Bulk update pincode")}}
        </h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="text-info">
          <li>
            {{__("Download the CSV/xlsx from ")}} <a class="font-weight-bold" target="__blank" href="{{ route('pincode.export') }}">{{ __("here") }}</a>
          </li>

          <li>
            {{__("Edit exported CSV/xlsx using Excel or WPS office and update your pincode into it and save.")}}
          </li>

          <li>
            {{__("Import that exported CSV/xlsx here again you're done.")}}
          </li>
        </ul>

        <form action="{{ route('pincode.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="pincodecsv" id="pincodecsv" aria-describedby="inputGroupFileAddon01" required>
                <label class="custom-file-label" for="pincodecsv">{{ __("Choose file") }} </label>
            </div>
            @if ($errors->has('pincodecsv'))
              <span class="invalid-feedback text-danger" role="alert">
                  <strong>{{ $errors->first('file') }}</strong>
              </span>
            @endif
            <p></p>
        </div>
          <div class="form-group">
            <button class="btn btn-primary-rgba btn-md" type="submit">
              {{__("Upload")}}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom-script')
<script>
  var baseUrl = @json(url('/'));
</script>
<script src="{{ url('js/pincode.js') }}"></script>
<script>
  var url = @json(route('country.list.pincode', $country->id));
</script>
<script src="{{ url('js/pincode2.js') }}"></script>
@endsection