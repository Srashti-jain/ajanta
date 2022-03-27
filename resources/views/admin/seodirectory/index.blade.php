@extends('admin.layouts.master-soyuz')
@section('title',__('All Directories | '))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('SEO Directories') }}
@endslot

@slot('menu1')
{{ __('All Directories') }}
@endslot

@slot('button')

<div class="col-md-6">
  <div class="widgetbar">
    <a href=" {{route('seo-directory.create')}} " class="btn btn-primary-rgba mr-2">
      <i class="feather icon-plus mr-2"></i> {{__("Add new directory")}}
    </a>
  </div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  <div class="row">

    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">
            {{ __('All Directories') }}
          </h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="seo_dir" class="width100 table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __("City") }}</th>
                  <th>{{ __("Detail") }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Action') }}</th>
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




@endsection
@section('custom-script')
<script>
  $(function () {
    "use strict";
    var table = $('#seo_dir').DataTable({
      processing: true,
      serverSide: true,
      ajax: @json(route('seo-directory.index')),
      language: {
        searchPlaceholder: "Search in records..."
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 's_e_o_directories.id',
          searchable: false
        },
        {
          data: 'city',
          name: 's_e_o_directories.city'
        },
        {
          data: 'detail',
          name: 's_e_o_directories.detail',
          orderable: false
        },
        {
          data: 'status',
          name: 'status',
          searchable: false,
          orderable: false
        },
        {
          data: 'action',
          name: 'action',
          searchable: false,
          orderable: false
        },
      ],
      dom: 'lBfrtip',
      buttons: [
        'csv', 'excel', 'pdf', 'print'
      ],
      order: [
        [0, 'DESC']
      ]
    });

  });
</script>
@endsection