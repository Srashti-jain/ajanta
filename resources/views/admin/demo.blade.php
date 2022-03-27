@extends('admin.layouts.master-soyuz')
@section('title',__('Create a Import Demo'))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Help Ans Support") }}
@endslot

@slot('menu2')
{{ __("Import Demo") }}
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
          <h5 class="box-title">{{ __('Import') }} {{ __('Demo') }}</h5>
        </div>
        <div class="card-body ">
            
           
                  <div class="col-md-12 p-2 mb-2 bg-success text-white rounded">
                      <i class="fa fa-info-circle"></i> {{__('Note:')}}
                     
                    <ul>
                        <li>
                            {{__("ON Click of import data your existing data like products,brands will remove except users,settings.")}}
                        </li>

                        <li>
                            {{__("ON Click of reset data will reset your site (which you see after fresh install).")}}
                        </li>
                    </ul>
                  </div>
            
              
        <div class="">
            <div style="display:inline-block">
                <form action="{{ url('/admin/import/import-demo') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary-rgba">
                          <i class="feather icon-arrow-up-circle"></i> {{__("One Click Demo Import")}}
                        </button>
                    </div>
                </form>
            </div>
            <div style="display:inline-block">
                <form action="{{ url('/admin/reset-demo') }}" method="POST">
                    @csrf
                
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-warning-rgba">
                           <i class="feather icon-alert-circle"></i> {{__("Reset Demo")}}
                        </button>
                    </div>
                </form>
            </div>
            

        </div>
      
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
