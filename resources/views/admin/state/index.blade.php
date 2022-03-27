@extends('admin.layouts.master-soyuz')
@section('title',__('States | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('States') }}
@endslot
@slot('menu1')
{{ __("States") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">
    <button data-toggle="modal" data-target='#createState' class="btn btn-primary-rgba"><i
        class="feather icon-plus mr-2"></i>
      {{__("Add State")}}
    </button>
  </div>
</div>
@endslot
​
@endcomponent
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('State') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="state_table" class="table table-striped table-bordered">
              <thead>
                <th>{{ __('ID') }}</th>
                <th>{{ __('State') }}</th>
                <th>{{ __('Country') }}</th>
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
​
<div class="modal fade" id="createState" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('Add New State') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
        <form action="{{ route('state.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="text-dark">{{__("Select Country:")}} <span class="text-danger">*</span></label>
            <select required name="country_id" id="country_id" class="select2">
              @foreach(App\Allcountry::orderBy('name','ASC')->get() as $country)
              <option {{ old('value') == $country['id'] ? "selected" : "" }} value="{{ $country['id'] }}">
                {{ $country['nicename'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="text-dark">{{__("Enter State Name:")}} <span class="text-danger">*</span></label>
            <input value="{{ old('name') }}" required type="text" class="form-control" name="name"
              placeholder="{{ __("Enter state name") }}">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-md btn-primary">+ {{ __("Create") }}</button>
      </div>
      </form>
      <!-- form end  -->
    </div>
  </div>
</div>

@endsection
@section('custom-script')
<script>
  var url = @json(route('state.index'));
</script>
<script src="{{ url('js/state.js') }}"></script>
@endsection