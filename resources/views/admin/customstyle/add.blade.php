@extends('admin.layouts.master-soyuz')
@section('title',__('Custom Style and Javascript'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Custom Style") }}
@endslot

@slot('menu2')
{{ __("Custom Style") }}
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
          <h5 class="box-title">
            {{__('Custom Style Setting')}}
          </h5>
        </div>
        <div class="card-body ml-2">
          <form action="{{ route('css.store') }}" method="POST">
            {{ csrf_field() }}
           <div class="form-group">
              <label for="css">{{ __("Custom CSS") }}:</label>
                <small class="text-danger">{{ $errors->first('css',__('CSS Cannot be blank !')) }}</small>
              <textarea placeholder="a {
                color:red;
              }"  id="he" class="form-control" name="css" rows="10" cols="30">@if(isset($css)) {{ $css }} @endif</textarea>
           </div>
          
          <div class="form-group">
             <input @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="{{ __("This operation is disabled in Demo !") }}" @endif  value="ADD CSS" class="btn btn-md btn-primary-rgba">
          </div>
          </form>
        </div>
      </div>
      
    </div>
    
    <div class="col-lg-12">
      <div class="card m-b-30">
        
        <div class="card-body ml-2">
          <form action="{{ route('js.store') }}" method="POST">
            {{ csrf_field() }}
          <label for="js">{{ __('Custom JS') }}:</label>
          <small class="text-danger">{{ $errors->first('js',__('Javascript Cannot be blank !')) }}</small>
          <textarea required placeholder="$(document).ready(function{
            //code
        });" class="form-control" name="js" rows="10" cols="30">@if(isset($js)) {{ $js }} @endif</textarea>
       <br>
           
        <div class="form-group">
          <input @if(env('DEMO_LOCK') == 0) type="submit" @else disabled="" title="{{ __("This operation is disabled in Demo !") }}" @endif value="ADD JS" class="btn btn-md btn-primary-rgba">
        </div> 
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
