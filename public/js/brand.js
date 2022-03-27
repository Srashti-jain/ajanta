$(function () {
      "use strict";
      var table = $('#brandTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          language: {
            searchPlaceholder: "Search Brands..."
          },
          columns: [
              {data: 'DT_RowIndex', name: 'brands.id', searchable : false},
              {data : 'name', name : 'brands.name'},
              {data : 'image', name : 'brands.image',searchable : false, orderable : false},
              {data : 'status', name : 'status',searchable : false, orderable : false},
              {data : 'action', name : 'action',searchable : false, orderable : false},
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print'
          ],
          order : [[0,'DESC']]
      });
      
});