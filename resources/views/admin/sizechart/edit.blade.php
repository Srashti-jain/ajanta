@extends('admin.layouts.master-soyuz')
@section('title',__('Edit Template : :template | ',['template' => $template->template_name]))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
        {{ __('Edit Template') }}
    @endslot
    ​
    @slot('menu2')
        {{ __("Edit Template") }}
    @endslot

    @slot('button')
        <div class="col-md-6">
            <div class="widgetbar">
                <a href="{{ route('sizechart.index') }}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
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
                <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></p>
                @endforeach
            </div>
        @endif
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit template : ') }} {{ $template->template_name }} </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('sizechart.update',$template->id) }}" method="POST" class="form">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label>{{ __('Template name:') }} <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" required name="template_name" placeholder="{{ __('Enter template name') }}" value="{{ $template->template_name }}">
                </div>

                <div class="form-group">
                    <label>{{ __('Template code:') }} <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" required name="template_code" placeholder="{{ __('Enter template code') }}" value="{{ $template->template_code }}">
                </div>

                <div class="form-group">
                    <label>{{ __('Template options:') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" data-role="tagsinput" type="text" id="tagsinput-typehead" name="options" value="{{ implode(',',$template->sizeoptions->pluck('option')->all()) }}">
                    <small class="text-muted">
                         <i class="feather icon-help-circle"></i> {{__("Enter option seprate it by comma (',')")}}
                    </small>
                </div>

                <div class="form-group">
                    <label>{{ __('Status:') }}</label>
                    <br>
                    <label class="switch">
                        <input type="checkbox" name="status" {{ $template->status == 1 ? "checked" : "" }}>
                        <span class="knob"></span>
                    </label>
                </div>

                @php
                                
                    $count_preview = 0;
                    $count_input = 0;
                    $length = [1];
                    
                    foreach($template->sizeoptions as $opt)
                    {
                        $length[] = count($opt->values);
                    }

                    $length = max($length);
                    
                @endphp

                <div class="ttui">
                    <table id="myTable" class="myTable w-100 table table-bordered table-striped">
                    
                        <thead>
                            @foreach ($template->sizeoptions as $option)
                                <th>
                                    {{ $option->option }}
                                </th>
                            @endforeach
                            
                            @if($template->sizeoptions()->count())
                                <th>#</th>
                            @endif
                        </thead>
    
                        <tbody>
                           
                            <tbody>
                                
                                @if(count($template->sizeoptions))
                                @for ($j = 0; $j < $length; $j++)
                                    
                                        <tr>
                                            @for($i=0;$i < count($template->sizeoptions); $i++)
                                                
                                        
                                                <td>
                                                    <?php
                                                        try{
                                                    ?>
                                                    <div class="form-group">
                                                        @php
                                                            $value = $template->sizeoptions[$i]->values[$count_input]['value'];
                                                        @endphp
                                                        <input data-optionid="{{ $template->sizeoptions[$i]->id }}" data-valueid="{{ $template->sizeoptions[$i]->values[$count_input]['id'] }}" name="values[{{ $template->sizeoptions[$i]->id }}][]" type="text" class="p_name form-control" value="{{ $value }}">
                                                    </div>
                                                    
                                                    <?php
                                                        }catch(\Exception $e){
                                                    ?> 
                                                    <input data-optionid="{{ $template->sizeoptions[$i]->id }}" data-valueid="0" name="values[{{ $template->sizeoptions[$i]->id }}][]" type="text" class="p_name form-control" value="" placeholder="Please enter value">
                                                    <?php
                                                    }
                                                    ?> 
                                                        
                                                </td>
                                            
                                                
                                            @endfor
                                            <td>
                                                <button type="button" class="addNew btn btn-md btn-primary-rgba">
                                                    <i class="feather icon-plus"></i>
                                                </button>
                                                <button type="button" class="removeBtn btn btn-md btn-danger-rgba">
                                                    <i class="feather icon-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $count_input++;
                                        @endphp
                                    @endfor
                                @endif
                                
                            </tbody>
                                
                        </tbody>
                        
                            
                    </table>
                </div>

               <div class="form-group">
                    <a role="button" class="viewpreview">
                        <i class="feather icon-eye"></i> {{ __('View preview') }}
                    </a>
               </div>
                
               
               

                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-primary-rgba">
                    <i class="feather icon-save"></i> {{__("Update")}}
                    </button>
                </div>
            </form>
            
        </div>
      </div>
    </div>
  </div>
</div>

<!-- preview modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                {{__('Preview')}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body previewTable">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger-rgba" data-dismiss="modal">{{ __('Close') }}</button>
        </div>
        </div>
    </div>
</div>

@endsection
@section('custom-script')
<!-- Tagsinput js -->
<script src="{{ url('admin_new/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
    $('#tagsinput-typehead').on('itemAdded', function(event) {


        var tablelength = $('.myTable tr').length;
        
        $.ajax({

                method  : 'POST',
                data    : {temp_id : @json($template->id), option : event.item},
                dataType : 'json',
                url     : @json(url('/sizechart/add/in/list')),
                success : function(response){

                    if(response.status != 'success'){
                        alert(response.message);
                        return false;
                    }
            
                    if(tablelength > 0){
                        $('.myTable').find('tr').each(function(){
                            $(this).find('th').eq(-2).after('<th class="blink"><span class="tdtext">'+event.item+'</span></th>');
                            $(this).find('td').eq(-2).after('<td class="blink"><div class="tdtext form-group"><input name="values['+response.optionid+'][]" autofocus type="text" placeholder="Please enter value" class="form-control" value=""></div></td>').fadeIn();
                        });
                    }else{
                        $('.ttui').html(response.tableview);
                    }

                    
                }
                
        });

        setTimeout(() => {

            $( ".myTable" ).find( "th.blink" ).removeClass('blink');
            $( ".myTable" ).find( "td.blink" ).removeClass('blink');

        }, 1600);



    });


    $('#tagsinput-typehead').on('beforeItemRemove', function(event) {

        var tble = document.getElementById('myTable'); 
        
        let all_values = $('#tagsinput-typehead').val().split(',');
        
        var c = confirm('Are you sure want to delete this?');

        if(c == true){

        
            var row = tble.rows;  
            var i = all_values.indexOf(event.item,0);

            // Getting the rows in table.

            for (var j = 0; j < row.length; j++) {

                // Deleting the ith cell of each row.
                row[j].deleteCell(i);
            }

            if(i == 0){
                $('.ttui').html('');
            }

            $.ajax({
                method  : 'POST',
                data    : {option : event.item,temp_id : @json($template->id)},
                dataType : 'json',
                url     : @json(url('/sizechart/remove/in/list')),
                success : function(response){
                    if(i == 0){
                        $('.ttui').html(response.tableview);
                    }
                }
                
            });

        }else{
            return event.cancel = true;
        }


    });

    $(".myTable").on('click', 'button.addNew', function () {

        var n = $(this).closest('tr');
        addNewRow(n);

    });

    $('.myTable').on('click', 'button.removeBtn', function () {

        var d = $(this).closest('tr');
        removeRow(d);

    });

    function addNewRow(n) {
        var $tableBody = $('.myTable').find("tbody"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trLast.clone();
        $trNew.find('td').each(function () {
            var el = $(this).find(':first-child');
            var id = el.attr('id') || null;
            if (id) {

                var i = id.substr(id.length - 1);
                var prefix = id.substr(0, (id.length - 1));
                el.attr('id', prefix + (+i + 1));
                el.attr('name', prefix + (+i + 1));
            }
        });
        $trNew.find('input').val('');
        $trLast.after($trNew);
    }

    function removeRow(d) {
        var rowCount = $('.myTable tr').length;
        
        if (rowCount !== 2) {
            d.remove();
        } else {
            console.log('Atleast one sell is required');
        }
    }

    $('.viewpreview').on('click',function(e){

        $.ajax({
            method  : 'POST',
            data    : {temp_id : @json($template->id)},
            dataType : 'json',
            url     : @json(url('/sizechart/preview/view')),
            success : function(response){
                
                if(response.status == 'success'){
                    $('.previewTable').html(response.tablepreview);

                    $('#previewModal').modal('show')


                }else{
                    alert(response.message);
                    return false;
                }
                
            }
            
        });

    });

</script>
@endsection