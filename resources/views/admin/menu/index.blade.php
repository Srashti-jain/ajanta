@extends('admin.layouts.master-soyuz')
@section('title',__('All Menus | '))
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("All Menu List") }}
@endslot

@slot('menu2')
{{ __("All Menu List") }}
@endslot

@endcomponent
@inject('pages','App\Page')
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
          <h5 class="box-title">{{ __('All') }} {{ __('Menu List') }}</h5>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                aria-controls="pills-home" aria-selected="true">{{ __('Top Menus') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                aria-controls="pills-profile" aria-selected="false">{{ __('Footer Menus') }}</a>
            </li>

          </ul>
          <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="col-md-12 mb-2 p-2 bg-success text-white rounded">
                <i class="fa fa-info-circle"></i> {{__("Note:")}}
                <ul>
                  <li>
                    {{__('Drag and Drop to sort the Menu Order')}}
                  </li>

                </ul>
              </div>
              @can('menu.create')
              <a href=" {{ route('menu.create') }} " class="float-right btn btn-primary-rgba mr-2">
                <i class="feather icon-plus mr-2"></i> {{__("Add Menu")}}
              </a>
              @endcan
              @can('menu.delete')
              <a data-toggle="modal" data-target="#bulk_delete" class="float-right btn btn-danger-rgba mr-2">
                <i class="feather icon-trash-2 mr-2"></i> {{__("Delete Selected")}}
              </a>
              @endcan


              <br>
              <br>


              <table id="menu_table" class="width100 table table-bordered table-striped table-hover w-100">
                <thead>
                  <th>
                    <div class="inline">
                      <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" />
                      <label for="checkboxAll" class="material-checkbox"></label>
                    </div>
                  </th>
                  <th>#</th>
                  <th>{{ __('Title') }}</th>
                  <th>
                    {{__('Additonal Detail')}}
                  </th>
                  <th>
                    {{__('Action')}}
                  </th>
                </thead>

                <tbody id="menucontent">

                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

              

              <a data-toggle="modal" data-target="#bulk_delete_fm" class="ml-2 float-left btn btn-danger-rgba">
                <i class="feather icon-trash-2 mr-2"></i> {{__("Delete Selected")}}
              </a>

              <button data-toggle="modal" data-target="#help" class="float-right btn btn-success-rgba">
                <i class="fa fa-question-circle"></i> {{__("Help")}}
              </button>

              <a title="Create a new footer menu" data-toggle="modal" data-target="#createnewfootermenu"
                class="mr-2 float-right btn btn-md btn-primary-rgba">
                <i class="feather icon-plus"></i> {{__("Create")}}
              </a>

              

              

              <div class="modal fade" id="createnewfootermenu" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel">{{ __("Create new footer menu") }}</h4>

                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                          aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="modal-body">
                      <form action="{{ route('footermenu.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                          <label>{{__("Menu title:")}} <span class="required">*</span></label>
                          <input name="title" type="text" class="form-control" required placeholder="{{ __('enter menu title') }}">
                        </div>

                        <div class="form-group">
                          <label>{{__("Link by:")}} <span class="required">*</span></label>
                          <select required class="form-control select2" name="link_by" id="link_by">
                            <option value="page">{{ __("Pages") }}</option>
                            <option value="url">{{ __('URL') }}</option>
                          </select>
                        </div>

                        <div class="form-group" id="pagebox">
                          <label>{{__("Select pages:")}} <span class="required">*</span></label>
                          <select required="" class="form-control select2" name="page_id" id="page_id">
                            @foreach($pages->where('status','=','1')->get() as $page)
                            <option value="{{ $page->id }}">{{ $page->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div id="urlbox" class="form-group display-none">
                          <label>{{__("URL:")}} <span class="required">*</span></label>
                          <input class="form-control" type="url" placeholder="{{ __('enter custom url') }}" name="url"
                            id="inputurl">
                        </div>

                        <div class="form-group">
                          <label>{{ __('Widget Position:') }}<span class="required">*</span></label>
                          <select name="widget_postion" id="position" class="form-control select2">
                            <option value="footer_wid_3">
                              {{__("Footer Widget 3")}}
                            </option>
                            <option value="footer_wid_4">
                              {{__("Footer Widget 4")}}
                            </option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label>{{ __('Status:') }}</label>
                          <br>
                          <label class="switch">
                            <input type="checkbox" name="status">
                            <span class="knob"></span>
                          </label>
                        </div>

                        <div class="form-group">
                          <button class="btn btn-md btn-primary-rgba" type="submit">{{ __("Create") }}</button>
                        </div>

                      </form>
                    </div>

                  </div>
                </div>
              </div>
              <br><br>
              <table id="full_detail_table" class="table table-bordered table-striped table-hover w-100">
                @inject('footermenus','App\FooterMenu')
                <thead>
                  <tr>
                    <th>
                      <div class="inline">
                        <input id="checkboxAll_fm" type="checkbox" class="filled-in" name="checked_fm[]" value="all" />
                        <label for="checkboxAll_fm" class="material-checkbox"></label>
                      </div>
                    </th>
                    <th>#</th>
                    <th>{{ __("Menu Title") }}</th>
                    <th>{{ __("Info.") }}</th>
                    <th>
                      {{__("Action")}}
                    </th>
                  </tr>
                </thead>

                <tbody>
                  @foreach($footermenus->get() as $key => $fm)
                  <tr>
                    <td>
                      <div class="inline">
                        <input type="checkbox" form="bulk_delete_form_fm"
                          class="fm_menus_cbox filled-in material-checkbox-input" name="checked_fm[]"
                          value="{{$fm->id}}" id="fm{{$fm->id}}">
                        <label for="fm{{$fm->id}}" class="material-checkbox"></label>
                      </div>
                    </td>
                    <td>{{ $key + 1 }}</td>
                    <td><b>{{ $fm->title }}</b></td>
                    <td>
                      <p>
                        @if($fm->link_by == 'page')
                        <b>{{ __("Linked to:") }}</b> {{__("Page")}}
                        @else
                        <b>{{ __("Linked to:") }}</b> {{__('URL')}}
                        @endif
                      </p>

                      <p>
                        <b>Widget Position:</b>
                        {{ $fm->widget_postion == 'footer_wid_3' ? __("Footer Widget 3") : __("Footer Widget 4") }}
                      </p>

                      <p> <b>{{ __('Status:') }} </b>
                        @if($fm->status == '1')
                        <span class="badge badge-success">{{ __("Active") }}</span>
                        @else
                        <span class="badge badge-danger">
                          {{__("Deactive")}}
                        </span>
                        @endif
                      </p>
                    </td>

                    <td>
                      <div class="dropdown">
                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                            class="feather icon-more-vertical-"></i></button>
                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">

                          <a class="dropdown-item" href="#editmenuModal{{ $fm->id }}" data-toggle="modal"><i
                              class="feather icon-edit mr-2"></i>{{  __('Edit') }}</a>



                          <a class="dropdown-item btn btn-link" data-toggle="modal" href="#footermenudel{{ $fm->id }}">
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

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
          {{__("Example of Footer Widgets & Footer Sections")}}
        </h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
        <img src="{{ url('images/footerhelp.png') }}" title="Footer Help Example" alt="help-footer" class="img-fluid">
      </div>

    </div>
  </div>
</div>

@foreach($footermenus->get() as $key => $fm)
<div class="modal fade" id="editmenuModal{{ $fm->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
          {{__("Edit footer menu")}}
        </h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('footermenu.update',$fm->id) }}" method="POST">
          @csrf

          <div class="form-group">
            <label>{{__("Menu title:")}} <span class="required">*</span></label>
            <input name="title" value="{{ $fm->title }}" type="text" class="form-control" required
              placeholder="{{ __("enter menu title") }}">
          </div>

          <div class="form-group">
            <label>{{__('Link by:')}} <span class="required">*</span></label>
            <select required class="form-control select2 link_by_edit" name="link_by" id="link_by_edit">
              <option {{ $fm->link_by == 'page' ? "selected" : "" }} value="page">{{ __('Pages') }}</option>
              <option {{ $fm->link_by == 'url' ? "selected" : "" }} value="url">{{ __("URL") }}</option>
            </select>
          </div>

          <div class="form-group select2 pagebox_edit {{ $fm->link_by == 'page' ? '' : 'display-none' }}"
            id="pagebox_edit">
            <label>{{__('Select pages:')}} <span class="required">*</span></label>
            <select {{ $fm->link_by == 'page' ? 'required' : '' }} class="form-control page_id_edit" name="page_id"
              id="page_id_edit">
              @foreach($pages->where('status','=','1')->get() as $page)
              <option {{ $fm->page_id == $page->id ? "selected"  : "" }} value="{{ $page->id }}">{{ $page->name }}
              </option>
              @endforeach
            </select>
          </div>

          <div id="urlbox_edit" class="urlbox_edit form-group {{ $fm->link_by == 'url' ? '' : 'display-none' }}">
            <label>{{__("URL:")}} <span class="required">*</span></label>
            <input value="{{ $fm->url }}" class="form-control" type="url" placeholder="{{ __("enter custom url") }}" name="url"
              id="inputurl-edit">
          </div>

          <div class="form-group">
            <label>{{__("Widget Position:")}} <span class="required">*</span></label>
            <select name="widget_postion" id="position" class="form-control select2">
              <option {{ $fm->widget_postion == 'footer_wid_3' ? "selected" : "" }} value="footer_wid_3">
                {{__("Footer Widget 3")}}
              </option>
              <option {{ $fm->widget_postion == 'footer_wid_4' ? "selected" : "" }} value="footer_wid_4">
                {{__("Footer Widget 4")}}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label>{{ __('Status:') }}</label>
            <br>
            <label class="switch">
              <input type="checkbox" name="status" {{ $fm->status == 1 ? "checked" : "" }}>
              <span class="knob"></span>
            </label>
          </div>

          <div class="form-group">
            <button class="btn btn-md btn-primary" @if(env('DEMO_LOCK')==0) type="submit" @else disabled=""
              title="{{ __("This action is disabled in demo !") }}" @endif>{{ __("Update") }}</button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>

<div id="footermenudel{{ $fm->id }}" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
        <p>
          {{__("Do you really want to delete this menu? This process cannot be undone.")}}
        </p>
      </div>
      <div class="modal-footer">
        <form method="post" action="{{ route('footermenu.delete',$fm->id) }}" class="pull-right">
          @csrf
          @method('delete')


          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
          <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

<!-- Top menu Bulk Delete Modal -->
<div id="bulk_delete" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
        <p>
          {{__("Do you really want to delete these top menus? This process cannot be undone.")}}
        </p>
      </div>
      <div class="modal-footer">
        <form id="bulk_delete_form" method="post" action="{{ route('bulk.delete.topmenu') }}">
          @csrf
          @method('DELETE')
          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
          <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Footer menu Bulk Delete Modal -->
<div id="bulk_delete_fm" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">{{ __("Are You Sure ?") }}</h4>
        <p>
          {{__('Do you really want to delete these footer menus? This process cannot be undone.')}}
        </p>
      </div>
      <div class="modal-footer">
        <form id="bulk_delete_form_fm" method="post" action="{{ route('bulk.delete.fm') }}">
          @csrf
          @method('DELETE')
          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __("NO") }}</button>
          <button type="submit" class="btn btn-danger">{{ __("YES") }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom-script')
<script>
  var url = @json(route('menu.index'));
  var sorturl = @json(route('menu.sort'));
  var customcatid = null;
</script>
<script src="{{ url('js/menu.js') }}"></script>
<script src="{{ url('js/footermenu.js') }}"></script>
@endsection