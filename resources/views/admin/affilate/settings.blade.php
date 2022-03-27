@extends('admin.layouts.master-soyuz')
@section('title',__('Affiliate Setting'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Affiliate Setting') }}
@endslot

@slot('menu1')
   {{ __('Affiliate Setting') }}
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">
     
      <div class="col-lg-12">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          @foreach($errors->all() as $error)
          <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true" style="color:red;">&times;</span></button></p>
          @endforeach
        </div>
        @endif
        <div class="card m-b-30">
          <div class="card-header">
            <h5 class="box-title">{{ __('Edit') }} {{ __('Affiliate Setting') }}</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.affilate.update') }}" method="POST">
                @csrf
              
    
                <div class="form-group">
                    <label for="my-input">{{ __("Refer code limit") }}: <span class="text-danger">*</span></label>
                    <input required value="{{ isset($af_settings) ? $af_settings->code_limit : 4 }}" id="my-input" min="4" max="6" class="form-control" type="number" name="code_limit">
                    <small class="text-info"> <i class="fa fa-question-circle"></i> {{ __("Refer code character limit eg: if you put 4 then refer code will be AB51 and if you put 6 then it will be ABCD45") }}</small>
                </div>
    
                <div class="form-group">
                    <label for="my-input">{{__("Refer amount")}}: <span class="text-danger">*</span></label>
                    <input id="my-input" min="0" step="0.01" value="{{ isset($af_settings) ? $af_settings->refer_amount : 0 }}" class="form-control" type="number" name="refer_amount">
                    <small class="text-info"> <i class="fa fa-question-circle"></i> {{ __("Per Refer amount in default currency") }}</small>
                </div>
    
                <div class="form-group">
                    <label>{{__("Description")}}:</label> <small class="text-info"> <i class="fa fa-question-circle"></i> {{ __("Some description of your affiliate system that how it gonna work?") }}</small>
                    <textarea class="form-control editor" name="about_system" id="about_system" cols="10" rows="5">{{ isset($af_settings) ? $af_settings->about_system : ""  }}</textarea>
                </div>
                <div class="form-group ">
                    <label>{{ __('Enable affiliate ?') }}</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="enable_affilate" {{ isset($af_settings) && $af_settings->enable_affilate =='1' ? "checked" : "" }}>
                        <span class="knob"></span>
                    </label>
                </div>
    
                <div class="form-group">
                    <label>{{ __("Credit wallet amount on first purchase ?") }}</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="enable_purchase" {{ isset($af_settings) && $af_settings->enable_purchase =='1' ? "checked" : "" }}>
                        <span class="knob"></span>
                    </label>
                    <br>
                    <small class="text-info"> <i class="fa fa-question-circle"></i> {{ __("IF enabled then referal amount will credited to referal once their refered user purchase something.") }}</small>
                </div>
              <br>
                <div class="form-group">
                    <button class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
                    <button class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>{{ __("Update") }}</button>
                </div>
                <div class="clear-both"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection