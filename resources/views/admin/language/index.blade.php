@extends('admin.layouts.master-soyuz')
@section('title',__('Site Languages'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Site Languages') }}
@endslot

@slot('menu1')
{{ __('Site Languages') }}
@endslot

@slot('button')
<div class="col-md-6">
  @can('advertisements.create')
  <div class="widgetbar">

    <a title="Click to add new language" data-toggle="modal" data-target="#addLang"
      class="float-right btn btn-primary-rgba mr-2">
      <i class="feather icon-plus mr-2"></i> {{__("Add New Language")}}
    </a>
    <form method="POST" action="{{ url('/vue/sync-translation') }}">
      @csrf
      <button title="Sync VUE based homepage translation" type="submit" class="float-right btn btn-primary-rgba mr-2">
        <i class="fa fa-refresh"></i> {{__("Sync homepage translations")}}
      </button>
    </form>
  </div>
  @endcan
</div>
@endslot
@endcomponent
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('All Site Languages') }}</h5>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs custom-tab-line mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                aria-controls="pills-home" aria-selected="true">{{ __('Languages') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                aria-controls="pills-profile" aria-selected="false">{{ __('Update Static Word Translations') }}</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <table class="table table-bordered">
                <thead>
                  <th>
                    #
                  </th>
                  <th>
                    {{__('Display Name')}}
                  </th>
                  <th>
                    {{__("Language Code")}}
                  </th>
                  <th>
                    {{__("Default")}}
                  </th>
                  <th>
                    {{__("Action")}}
                  </th>
                </thead>
                <tbody>
                  @foreach($allLang as $key=> $lang)
                  <tr>
                    <td>
                      {{ $key+1 }}
                    </td>
                    <td>
                      {{ $lang->name }}
                    </td>
                    <td>
                      {{ ucfirst($lang->lang_code) }}
                    </td>
                    <td>
                      @if($lang->def == 1)
                      <i class="text-green fa fa-check-circle"></i>
                    @else
                      <i class="required fa fa-times"></i>
                    @endif
                      
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                            <a class="dropdown-item" data-toggle="modal"  data-target="#editLang{{ $lang->id }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                            <a class="dropdown-item btn btn-link" data-toggle="modal" @if(env('DEMO_LOCK')==0) data-target="#delModal{{ $lang->id }}" title="{{ __("Delete Language") }}"
                              data-toggle="modal" @else disabled title="{{ __('This action is disabled in demo !') }}" @endif >
                                <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                            </a>
                        </div>
                    </div>

                   

                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <table class="table table-bordered">
                <thead>
                  <th>
                    #
                  </th>
                  <th>
                    {{__("Display Name")}}
                  </th>
                  <th>
                    {{__("Language Code")}}
                  </th>
                  <th>
                    {{__('Default')}}
                  </th>
                  <th>
                    {{__('Action')}}
                  </th>
                </thead>
                <tbody>
                  @foreach($allLang as $key=> $lang)
                  <tr>
                    <td>
                      {{ $key+1 }}
                    </td>
                    <td>
                      {{ $lang->name }}
                    </td>
                    <td>
                      {{ ucfirst($lang->lang_code) }}
                    </td>
                    <td>
                      @if($lang->def == 1)
                        <i class="text-green fa fa-check-circle"></i>
                      @else
                        <i class="required fa fa-times"></i>
                      @endif
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                            <a class="dropdown-item" href="{{ url('languages/'.$lang->lang_code.'/translations') }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit") }}</a>
                         
                        </div>
                    </div>

                     
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addLang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
          {{__('Add Language')}}
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      
      </div>

      <div class="modal-body">
        <form action="{{ route('site.lang.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>{{__("Language Name")}}: <span class="required">*</span></label>
            <input required name="name" type="text" class="form-control" placeholder="{{ __("Enter language name") }}" />
          </div>

          <div class="form-group">
            <label>{{__("Language Code")}}: <span class="required">*</span></label>
            <input required type="text" name="lang_code" class="form-control" placeholder="{{ __('Enter language code') }}" />
          </div>

          <div class="form-group">
            <label>{{__("Default")}}:</label>
            <br>
            <label class="switch">
              <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="def" checked>
              <span class="knob"></span>
            </label>
          </div>

          <div class="form-group">
            <label>{{__("RTL")}}:</label>
            <br>
            <label class="switch">
              <input type="checkbox" class="quizfp toggle-input toggle-buttons" name="rtl_available" checked>
              <span class="knob"></span>
            </label>
          </div>

          <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __("Reset") }}</button>
          <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
            {{ __("Create") }}</button>
        </div>

        <div class="clear-both"></div>


        </form>
      </div>

    </div>
  </div>
</div>

@foreach($allLang as $key=> $lang)
<!-- Delete Lang Modal -->
<div id="delModal{{ $lang->id }}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
        <p>{{ __('Do you really want to delete this language? This process cannot be undone.') }}</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{route('site.lang.delete',$lang->id)}}" class="pull-right">
          {{csrf_field()}}
          {{method_field("DELETE")}}
          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
          <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- edit lang Modal -->
<div class="modal fade" id="editLang{{ $lang->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"> {{__('Edit Language :lang',['lang' => $lang->display_name])}}</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('site.lang.update',$lang->id) }}" method="POST">
          @csrf

          <div class="form-group">
            <label>{{__("Edit Language Name")}}: <span class="required">*</span></label>
            <input required name="name" value="{{ $lang->name }}" type="text" class="form-control"
              placeholder="{{ __('enter language name') }}" />
          </div>

          <div class="form-group">
            <label>{{__('Edit Language Code:')}} <span class="required">*</span></label>
            <input required value="{{ $lang->lang_code }}" type="text" name="lang_code" class="form-control"
              placeholder="{{ __('enter language code') }}" />
          </div>

          <div class="form-group">
            <label>{{__('Default')}}:</label>
            <br>
            <label class="switch">
              <input {{ $lang->def == 1 ? 'checked' : "" }} type="checkbox" class="quizfp toggle-input toggle-buttons"
                name="def">
              <span class="knob"></span>
            </label>
          </div>

          <div class="form-group">
            <label>{{__('RTL')}}:</label>
            <br>
            <label class="switch">
              <input {{ $lang->rtl_available == 1 ? 'checked' : '' }} type="checkbox"
                class="quizfp toggle-input toggle-buttons" name="rtl_available">
              <span class="knob"></span>
            </label>
          </div>

          <button type="button" data-dismiss="modal" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Close') }}</button>
          <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
            {{ __("Update") }}</button>
        </div>

        <div class="clear-both"></div>
        </form>
      </div>

    </div>
  </div>
</div>
@endforeach
@endsection