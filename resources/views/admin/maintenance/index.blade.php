@extends('admin.layouts.master-soyuz')
@section('title',__('Maintenance Mode'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Maintenance Mode') }}
@endslot

@slot('menu1')
   {{ __('Maintenance Mode') }}
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
            <h5 class="box-title">{{ __('Setting') }} {{ __('Maintenance Mode') }}</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('get.m.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>{{__('Allowed IP\'s')}}: </label>
                    <br>
                    <select required class="form-control select2" name="allowed_ips[]" multiple="multiple" id="allowed_ips">
                        @if(isset($data->allowed_ips))
                            @foreach ($data->allowed_ips as $ip)
                                <option {{ $ip ? "selected" : "" }} value="{{ $ip }}">{{ $ip }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('allowed_ips')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <br>
                    <small class="help-block text-info">
                        <i class="fa fa-question-circle"></i> <b>{{__('Your IP is:')}} <span class="text-dark">{{ Request::ip() }}</span></b>
                    </small>
                </div>

                <div class="form-group">
                    <label>{{__("Maintenance mode message")}} <span class="text-danger">*</span></label>
                    <textarea class="editor form-control" name="message" id="message" cols="30" rows="10">@if($data) {!! $data->message !!} @else {{ old('message') }} @endif</textarea>
                    @error('message')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('Enable Maintenance mode:') }}</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="status" {{ isset($data) && $data->status == 1 ? "checked" : "" }}>
                        <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('Turn On the toggle to enable Maintenance mode') }}</small>
                </div>

                <div class="form-group">
                    <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
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
        $('.allowed_ips').select2({
            placeholder: 'Enter IP',
            tags: true,
            tokenSeparators: [',', ' ']
        });
    </script>
@endsection
