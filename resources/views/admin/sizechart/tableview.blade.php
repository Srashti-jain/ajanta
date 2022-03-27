<table id="myTable" class="myTable w-100 table table-bordered table-striped">
    @php
                                
        $count_ajax_create = 0;
        $length = [1];
        
        foreach($template->sizeoptions as $opt)
        {
            $length[] = count($opt->values);
        }

        $length = max($length);
        
    @endphp                
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
                                        $value = $template->sizeoptions[$i]->values[$count_ajax_create]['value'];
                                    @endphp
                                    <input name="values[{{ $template->sizeoptions[$i]->id }}][]" type="text" class="form-control" value="{{ $value }}">
                                </div>
                                
                                <?php
                                    }catch(\Exception $e){
                                ?> 
                                <input name="values[{{ $template->sizeoptions[$i]->id }}][]" type="text" class="form-control" value="" placeholder="Please enter value">
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
                        $count_ajax_create++;
                    @endphp
                @endfor
            @endif
        </tbody>
            
    </tbody>
    
        
</table>
<script>
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
</script>