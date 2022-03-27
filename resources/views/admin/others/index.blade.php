@extends('admin.layouts.master-soyuz')
@section('title',__('Remove Public & FORCE HTTPS Setting | '))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
  {{ __('Remove Public & FORCE HTTPS Setting') }}
@endslot
@slot('menu2')
  {{ __("Remove Public") }}
@endslot

​
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
          <h5>{{ __('Remove Public & FORCE HTTPS Setting') }}</h5>
        </div>
        <div class="card-body ml-2 mr-1">
         <!-- main content start -->
         <!-- form for https request start -->
         <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{ route('do.forcehttps') }}" data-parsley-validate class="form-horizontal form-label-left">
            @csrf


            <div class="row">
              <div class="col-md-12 p-2 mb-1 bg-success text-white rounded">
                  <i class="fa fa-info-circle"></i> {{ __('Important Note :') }}
                  <ul>
                      <li>{{ __('Enable FORCE https only if VALID SSL already configured else you can set serious errors !') }}</li>
                     
                      </li>
                  </ul>
              </div>
              <button type="submit" class="btn btn-primary-rgba mt-2"><i class="fa fa-check-circle"></i>
                @if(env('FORCE_HTTPS') == '1') {{__("REMOVE FORCE HTTPS REQUESTS")}} @else  {{__("FORCE HTTPS REQUESTS")}}  @endif
              </button>
            </div>
         
          </form>
                        
           
            <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{ route("do.removepublic") }}" data-parsley-validate class="form-horizontal form-label-left">
                @csrf

                <div class="row mt-3">
                  <div class="col-md-12  p-2 mb-1 bg-success text-white rounded">
                      <i class="fa fa-info-circle"></i> {{ __('Important Note :') }}
                      <ul>
                          <li>{{__("Remove public only works if script is on valid subdomain and on main domain !")}}</li>
                            <li>{{__("If above requirment is satisfied and you're getting 500 Internal server error then your a2nMod headers are not enabled or root have 2 htaccess files !")}}
                            <li>{{__("IN Case of a2nmod headers not enabled on your server kindly contact your hosting provider only !")}}</li>
                        </li>
                    </ul>
                </div>
                         
                <button type="submit" class="btn btn-primary-rgba mt-2"><i class="fa fa-check-circle"></i>
                    {{__("REMOVE Public")}}
                </button> 
              </div>
          
            </form>
           
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

