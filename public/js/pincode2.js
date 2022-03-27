 $(function () {

   $(".checkPin").each(function (i) {
     if ($(this).val().length == 0) {

     } else {
       $(this).attr('disabled', 'disabled');
       $(this).attr('s', 'd');
     }
   })

 });


 function checkPincode($id) {

   var id = $id;
   var boxStatus = $("#pincode" + id).attr('s');

   if (boxStatus == 'd') {
     $("#pincode" + id).removeAttr('disabled');
     $("#btnAddProfile" + id).html("<i class='feather icon-edit'></i>");
     $("#pincode" + id).attr('s', 'a');
   } else {


     $("#pincode" + id).show();
     var code = $("#pincode" + id).val();

     if ($("#pincode" + id).val().length == 0) {
       $("#btnAddProfile" + id).html("<i class='feather icon-plus'></i>");
     }


     $.ajax({
       type: 'GET',
       url: baseUrl + '/pincode-add',
       data: {
         code: code,
         id: id
       },

       success: function (data) {
         $("#pincode" + id).text(data);


         if ($("#pincode" + id).val().length == 0) {
           toastr.warning('Please add pincode');
           $("#btnAddProfile" + id).html("<i class='feather icon-plus'></i>");
         } else {
           toastr.success('Pincode updated !');
           $("#btnAddProfile" + id).html("<i class='feather icon-edit'></i>");
           $("#pincode" + id).attr('disabled', 'disabled');
           $("#pincode" + id).attr('s', 'd');
         }

       }

     });
   }

 }

 $(function () {


   var table = $('.data-table').DataTable({
     processing: true,
     serverSide: true,
     responsive: true,
     ajax: url,
     columns: [
       {
            data: 'checkbox',
            name: 'checkbox',
            orderable: false,
            searchable: false
       },
       {
         data: 'DT_RowIndex',
         name: 'DT_RowIndex',
         orderable: false,
         searchable: false
       },
       {
         data: 'cityname',
         name: 'allcities.name'
       },
       {
         data: 'statename',
         name: 'allstates.name'
       },
       {
         data: 'pincode',
         name: 'allcities.pincode'
       },
     ],
     dom: 'lBfrtip',
     buttons: [
       'csv', 'excel', 'pdf', 'print'
     ],
     order: [
       [0, 'asc']
     ]
   });

 });