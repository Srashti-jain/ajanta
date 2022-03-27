@extends('admin.layouts.master-soyuz')
@section('title',__('Reported Products | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Reported Products') }}
@endslot
@slot('menu1')
{{ __("Reported Products") }}
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
          <h5>{{ __('Reported Products') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="reporttable" class="table table-striped table-bordered">
              <thead>
                <th>#</th>
                <th>{{ __('Report Detail') }}</th>
                <th>{{ __('Reported Product Name') }}</th>
                <th>{{ __('Report Description') }}</th>
                <th>{{ __('Reported On') }}</th>
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
</div>
              
       
                       
​
                                     
        
@endsection
@section('custom-script')
<script>
	var url = {!! json_encode( route('get.rep.pro') ) !!};
</script>
<script src="{{ url('js/report.js') }}"></script>
@endsection
