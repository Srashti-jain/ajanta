"use strict";
        
// Define your library strictly...

$(function() { 
                 
          $("form:not(#updaterform,#prelogin)").on('submit', function () {
                      if($(this).valid()){
                        $('.preL').fadeIn('fast');
                        $('.preloader3').fadeIn('fast');
                        $('.container').css({ '-webkit-filter':'blur(5px)'});
                        $('body').attr('scroll','no');
                        $('body').css('overflow','hidden');
                      }
                      
                  });

                
          });

 (function() {
        
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();


$("#logo").on('change',function() {
  readURL1(this);
});

function readURL1(input) {
  
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#logo-prev').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

 function readURL2(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#fav-prev').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#favicon").on('change',function() {
 
  readURL2(this);
});



  $(".toggle-password").on('click', function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if(input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
}); 

var logocontainerpresent = $("input").is('#logo'); 

if (logocontainerpresent) {

  $("#logo").on('change',function() {
       readURL1(this);
  });

  function readURL1(input) {
      
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#logo-prev').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

}

var iconpickerpresent = $("button").is('#iconpick');

if(iconpickerpresent){

              $('#iconpick').iconpicker()
              .iconpicker('setAlign', 'center')
              .iconpicker('setCols', 5)
              .iconpicker('setArrowPrevIconClass', 'fa fa-angle-left')
                .iconpicker('setArrowNextIconClass', 'fa fa-angle-right')
                .iconpicker('setIcon', '')
              .iconpicker('setIconset', {
                  iconClass: 'fa',
                  iconClassFix: 'fa-',
                  icons: [

                    'inr', 
                    'eur', 
                    'bitcoin', 
                    'btc', 
                    'cny', 
                    'dollar', 
                    'gg-circle',
                    'gg', 
                    'rub', 
                    'ils', 
                    'try', 
                    'krw', 
                    'gbp', 
                    'zar', 
                    'rs',
                    'pula', 
                    'aud', 
                    'egy', 
                    'taka', 
                    'mal', 
                    'rub', 
                    'brl', 
                    'idr',
                    'zwl', 
                    'ngr', 
                    'eutho', 
                    'sgd',
                    'dzd',
                    'ghc',
                    'lao',
                    'tnd',
                    'ksh',
                    'Kz',
                    'xaf'
                  ]
              })
              .iconpicker('setSearch', false)
              .iconpicker('setFooter', false)
              .iconpicker('setHeader', false)
              .iconpicker('setSearchText', 'Type text')
              .iconpicker('setSelectedClass', 'btn-warning')
              .iconpicker('setUnselectedClass', 'btn-primary');

              $('#iconpick').on('change', function(e) {
                $('#iconvalue').val('fa '+e.icon);
              });

}