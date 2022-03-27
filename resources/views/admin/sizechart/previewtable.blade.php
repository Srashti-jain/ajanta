<table class="w-100 table table-bordered">
    @php
                                
        $count_ajax_preview = 0;
        $length = [1];
        
        foreach($template->sizeoptions as $opt)
        {
            $length[] = count($opt->values);
        }

        $length = max($length);
        
    @endphp           
    <thead>
        @foreach ($template->sizeoptions as $option)
            <th class="bg-primary-rgba">
                {{ $option->option }}
            </th>
        @endforeach
    </thead>

    
    <tbody>

       
       @if(count($template->sizeoptions))
        @for ($j = 0; $j < $length; $j++)
                
            <tr>
                @for($i=0;$i < count($template->sizeoptions); $i++)
                    
            
                    <td>
                        <?php
                            try{
                        ?>
                        {{ $template->sizeoptions[$i]->values[$count_ajax_preview]['value'] }}
                        <?php
                            }catch(\Exception $e){
                        ?> 
                            {{__("No value set")}}
                        <?php
                            }
                        ?> 
                            
                    </td>
                
                    
                @endfor
            </tr>
            @php
                $count_ajax_preview++;
            @endphp
        @endfor
    @endif

    </tbody>

</table>