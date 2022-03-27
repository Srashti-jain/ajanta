  "use strict";
// Define your library strictly...
$(document).on('click', '.removeFrmWish', function() {

     var wc = $('#wishcount').text();
      wc = Number(wc);
      if(wc == 1){
        wc = 0;
      }else{
        wc = Number(wc) - 1;
      }

    

    $('#wishcount').text(wc);
    $('.wishtitle').text(wc);

   
    $('body').append('<div class="preL"><div class="preloader3"></div></div>');

    var id = $(this).attr('mainid');
    var url = $(this).attr('data-remove');

    $('#orivar'+id).remove();

   
      setTimeout(function(){
          $.ajax({
             type : 'GET',
             url  : url,
             success : function(response){
              if(response == 'deleted') {

                toastr.error('Product is removed from wishlist','Removed');
               
              } else {
                toastr.warning('Failed to remove it from wishlist','Failed');
              }

             }
          });

          $('.preL').fadeOut('fast');
          $('.preloader3').fadeOut('fast');
          $('body').attr('scroll','yes');
          $('body').css('overflow','auto');



        },1500);

     

  });