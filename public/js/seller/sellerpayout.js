"use strict";

  function trackstatus(id){
    
    $.ajax({
        type : 'GET',
        url  : url+'/'+id,
        dataType : 'html',
        success : function(data){
          
          $('#trackstatus').html('');
          $('#trackstatus').append(data);
          $('#trackmodal').modal('show');
        }
    });

    
  }

$(function (){

      var table = $('#completedPayouts').DataTable({
          processing: true,
          serverSide: true,
          responsive : true,
          dataType : 'json',
          ajax: sellerpayouturl,
          columns: [

              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
              {data: 'type', name: 'sellerpayouts.type'},
              {data: 'orderid', name: 'sellerpayouts.orderid'},
              {data: 'amount', name: 'sellerpayouts.amount'},
              {data: 'detail', name: 'sellerpayouts.detail'},
              {data: 'paidon', name: 'sellerpayouts.paidon'},
              {data: 'action', name: 'action', searchable : false, orderable : false}
              
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print'
          ],
          order : [[0,'desc']]
      });
      
});