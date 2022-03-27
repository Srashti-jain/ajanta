@extends('admin.layouts.master-soyuz')
@section('title',__('Addon Manager'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Addon Manager') }}
@endslot

@slot('menu1')
   {{ __('Addon Manager') }}
@endslot

@slot('button')

<div class="col-md-6">
    <div class="widgetbar">
        <a data-target="#installnew" data-toggle="modal" class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2e"></i> {{__("Install new add-on")}}
        </a>
    </div>                        
</div>
@endslot
@endcomponent
<div class="contentbar"> 
    <div class="row">
        
        <div class="col-lg-12">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)
                    <p>{{ filter_var($error) }}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></p>
                @endforeach
                </div>
            @endif

            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">
                        {{__('All Addon')}}
                    </h5>
                </div>
                <div class="card-body">
                
                    <div class="table-responsive">
                        <table id="modules" class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>{{ __('Logo') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Version') }}</th>
                                <th>{{ __('Action') }}</th>
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
<div data-backdrop="static" data-keyboard="false" id="installnew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">
                    <b>{{ __("Install new add on") }}</b>
                </h5>
                
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
                <form action="{{ route('addon.install') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{__('Enter purchase code')}}: <span class="text-danger">*</span></label>
                        <input required type="text" placeholder="{{ __('Envanto purchase code of your addon') }}" class="form-control" name="purchase_code">
                    </div>

                    <div class="form-group">
                        <label>{{__('Choose zip file')}}: <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
            
                            <div class="custom-file">
            
                              <input required type="file" name="addon_file" id="inputGroupFile01" class="inputfile inputfile-1"
                                aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">
                                  {{__('Choose file')}}
                              </label>
                            </div>
                          </div>
                       
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-arrow-down"></i> {{__("Install")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="verifymodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">
                    {{ __("Enter purchase code") }}
                </h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form id="verifyform" action="javascript:void(0)">

                    <div class="form-group">
                        <label>{{ __("Enter purchase code :") }} <span class="text-danger">*</span> </label>
                        <input required type="text" class="purchase_code_text form-control" name="purchase_code">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary-rgba">
                             <i class="feather icon-arrow-right"></i> {{__('Continue')}}
                        </button>
                    </div>
               </form>
            </div>
        </div>
    </div>
</div>

@section('custom-script')
<script>
    $(function () {
        "use strict";
        var table = $('#modules').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("admin/addon-manger") }}',
            language: {
                searchPlaceholder: "{{__('Search Modules...')}}"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'image',
                    name: 'image',
                    searchable: false,
                    orderable : false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'version',
                    name: 'version'
                },
                {
                    data: 'action',
                    name: 'action'
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

        $('#modules').on('change', '.toggle_addon', function (e) { 

            var modulename = $(this).data('addon');

            if($(this).is(':checked')){

                var status = 1;
                
                $('#verifymodal').modal('toggle');

                $('#verifyform').on('submit',function(){

                    $.ajax({
                        method : 'POST',
                        url    : @json(url('/api/verify/add-on')),
                        data   : {purchase_code : $(".purchase_code_text").val(), modulename : modulename, status : status},
                        success : function(data){
                            
                            if(data != 200){
                                table.draw();
                                toastr.error(data, 'Error !',{timeOut: 1500});
                                $(this).prop('checked',false);
                                return false;
                            }else{

                                $.ajax({
                                    url : @json(url("admin/toggle/module")),
                                    method : 'POST',
                                    data : {status : 1, modulename : modulename},
                                    success :function(data){
                                        table.draw();

                                        if(data.status == 'success'){
                                            toastr.success(data.msg,{timeOut: 1500});
                                        }else{
                                            toastr.error(data.msg, 'Oops!',{timeOut: 1500});
                                        }
                                        
                                    },
                                    error : function(jqXHR,err){
                                        console.log(err);
                                    }
                                });

                                $('#verifymodal').modal('toggle');
                            }

                        }
                    });     

                });

                

            }else{
                var status = 0;
                $.ajax({
                    url : @json(url("admin/toggle/module")),
                    method : 'POST',
                    data : {status : status, modulename : modulename},
                    success :function(data){
                        table.draw();

                        if(data.status == 'success'){
                            toastr.success(data.msg,{timeOut: 1500});
                        }else{
                            toastr.error(data.msg, 'Oops!',{timeOut: 1500});
                        }
                        
                    },
                    error : function(jqXHR,err){
                        console.log(err);
                    }
                });
            }

            

        });


    });
</script>
@endsection
