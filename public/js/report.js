 $(function () {

     "use strict";
      
      var table = $('#reporttable').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable : false, orderable : false},
              {data: 'info', name: 'info'},
              {data: 'product', name: 'product',searchable : false, orderable : false},
              {data: 'rdtl', name: 'rdtl'},
              {data: 'rpon', name: 'rpon'}
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print'
          ],
          order : [[0,'DESC']]
      });
      
});