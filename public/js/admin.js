"use strict";

// Define your library strictly...

$('.is_pass_change').on('click', function () {

  if ($(this).is(':checked')) {
    $('.passwordbox').removeAttr('disabled');
  } else {
    $('.passwordbox').attr('disabled','disabled');
  }

});

$(function () {

  $('#full_detail_table').DataTable({

    responsive: true,
    "sDom": "<'row'><'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-sm-12'p>>",
    "language": {
      "paginate": {
        "previous": '<i class="fa fa-angle-left"></i>',
        "next": '<i class="fa fa-angle-right"></i>'
      }
    },
    buttons: [{
        extend: 'print',
        exportOptions: {
          columns: ':visible'
        }
      },
      'csvHtml5',
      'excelHtml5'
    ],
  
    'deferRender': true,
    'deferLoading': 10,
    'iDisplayLength': 10
  });

  $('#fb_enable').on('change', function () {
    $('#fb_login_enable').val(+$(this).prop('checked'))
  })

  $('#ggl_enable').on('change', function () {
    $('#google_login_enable').val(+$(this).prop('checked'))
  })


  var z = $(window).height() - 50;
  $('.navbar-fixed-top').css("top", z);
  $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    $('#myTabs a[href="' + activeTab + '"]').tab('show');
  }

  $('.js-example-basic-single').select2({
    placeholder: "Search to select category",
    allowClear: true,
    width: '100%'
  });

  $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    $('#myTab a[href="' + activeTab + '"]').tab('show');
  }


  $('#toggle1').on('change', function () {

    if ($('#toggle1').is(':checked')) {
      $('#skey,#sst').show();
    } else {
      $('#skey,#sst').hide();
    }


  });


  $('#toggle').on('change', function () {

    if ($('#toggle').is(':checked')) {
      $('#pkey,#psec,#pmode').show();
    } else {
      $('#pkey,#psec,#pmode').hide();
    }

  })

  $('[data-toggle="popover"]').popover({
    placement: 'top',
    trigger: 'hover',

  });


  tinymce.init({
    selector: '#editor1,#editor2,.editor',
    height: 300,
    menubar: 'edit view insert format tools table tc',
    autosave_ask_before_unload: true,
    autosave_interval: "30s",
    autosave_prefix: "{path}{query}-{id}-",
    autosave_restore_when_empty: false,
    autosave_retention: "2m",
    image_advtab: true,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks fullscreen',
      'insertdatetime media table paste wordcount'
    ],
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
    content_css: '//www.tiny.cloud/css/codepen.min.css'
  });


  $('#events').on('change', function () {
    $('#featureds').val(+$(this).prop('checked'))
  })


  $('[data-toggle="modals"]').on('hover', function () {
    var modalId = $(this).data('target');
    $(modalId).modal('show');

  });


  $('.select2-search__field').css('width', '100%');

  $('.js-example-basic-multiple').select2({
    width: '100%'
  });


  $('#show-image').on('change', function () {
    $('#show_image').val(+$(this).prop('checked'))
  });

  $('#toggle-event').on('change', function () {
    $('#status').val(+$(this).prop('checked'))
  })

  $('#toggle-event1').on('change', function () {
    $('#status1').val(+$(this).prop('checked'))
  });


  $('#new').on('change', function () {
    $('#status0').val(+$(this).prop('checked'))
  })

  $('#toggle-event2').on('change', function () {
    $('#featured').val(+$(this).prop('checked'))
  })


  $('#frees').on('change', function () {
    $('#shipping').val(+$(this).prop('checked'))
  })

  $('#toggle-event5').on('change', function () {
    $('#frees').val(+$(this).prop('checked'))
  })


  $('#toggle-event3').on('change', function () {
    $('#status3').val(+$(this).prop('checked'))
  });


  $('#toggle-event4').on('change', function () {
    $('#status4').val(+$(this).prop('checked'))
  })

  $('#toggle-event5').on('change', function () {
    $('#status5').val(+$(this).prop('checked'))
  });

  var i = 1;
  $('#add').on('click', function () {

    i++;
    $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input name="prokeys[]" class="form-control" type="text" placeholder="Product Attribute"/></td><td><input type="text" name="provalues[]" placeholder="Attribute Value" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn-sm btn_remove">X</button></td></tr>');
  });

  $(document).on('click', '.btn_remove', function () {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
  });


  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // check sub categories
  $(document).on('click', '.sub_categories', function () {

    if ($(this).is(':checked')) {
      var parents_id = $(this).attr('parents_id');
      var t = $('#categories_' + parents_id).prop('checked', true);

    } else {


    }

  });



});

$('#category_id').on('change', function () {

  var up = $('#upload_id').html('');
  $('#grand').html(''); 

  var cat_id = $(this).val();
  if (cat_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: baseUrl + '/admin/dropdown',
      data: {
        catId: cat_id
      },
      success: function (data) {

        up.append('<option value="">Please Choose</option>');
        $.each(data, function (id, title) {
          up.append($('<option>', {
            value: id,
            text: title
          }));
        });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
});


$('#upload_id').on('change', function () {
  var up = $('#grand').html('');
  var cat_id = $(this).val();
  if (cat_id) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "GET",
      url: baseUrl + '/admin/gcat',
      data: {
        catId: cat_id
      },
      success: function (data) {

        up.append('<option value="">Please Choose</option>');
        $.each(data, function (id, title) {
          up.append($('<option>', {
            value: id,
            text: title
          }));
        });
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });
  }
});

// check parents categories
$(document).on('click', '.categories', function () {

  if ($(this).is(':checked')) {

  } else {

    var parents_id = $(this).val();
    $('.sub_categories_' + parents_id).prop('checked', false);
  }

});

$(document).on('click', '.checkboxess', function (e) {

  checked = $("input[type=checkbox]:checked.checkboxess").length;
  if (!checked) {

    return false;
  }

});


$(document).ajaxStart(function () {
  Pace.restart();
});

$("#checkboxAll").on('click', function () {
  $('input:checkbox').not(this).prop('checked', this.checked);
});

$("#checkboxAll_fm").on('click', function () {
  $('.fm_menus_cbox').not(this).prop('checked', this.checked);
});


$('#type').on('change', function () {
  var cat = $(this).val();
  if ($("#type").val() == "flat") {
    $("#rate").show();
    $("#p_type").show();
  } else {
    $("#rate").hide();
    $("#p_type").hide();
  }
});

function showdetails(id) {
  $('#viewdialog' + id).modal('show');
}








$('#target').on('change', function (e) {


  var str = "fast word";
  console.log(str.trimLeft("f"));
});

$('#link_by').on('change', function () {


  var opt = $(this).val();

  if (opt == 'product') {

    $('#minAmount').hide();
    $('#probox').show();
    $('#catbox').hide();
    $('#simpleprobox').hide();

    $('#pro_id').attr('required', 'required');

    $('#cat_id').removeAttr('required');
    $('#simple_pro_id').removeAttr('required');

  } else if (opt == 'simple_product') {

    $('#probox').hide();
    $('#catbox').hide();
    $('#minAmount').show();
    $('#simpleprobox').show();
    
    $('#simple_pro_id').attr('required', 'required');

    $('#cat_id').removeAttr('required');
    $('#pro_id').removeAttr('required');

  }else if (opt == 'category') {
    
    $('#probox').hide();
    $('#catbox').show();
    $('#minAmount').show();
    $('#simpleprobox').hide();

    $('#cat_id').attr('required', 'required');

    $('#simple_pro_id').removeAttr('required');
    $('#pro_id').removeAttr('required');

  }
  else {

    $('#minAmount').show();
    $('#probox').hide();
    $('#simpleprobox').hide();
    $('#catbox').hide();
    $('#pro_id').removeAttr('required');
    $('#cat_id').removeAttr('required');
    $('#simple_pro_id').removeAttr('required');

  }
});

$(".toggle-password").on('click', function () {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }

});

$(".toggle-password2").on('click', function () {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});


$(".abc").on('click', function () {

  return confirm("Do you want to delete this ?");
});

function toggleIcon(e) {
  $(e.target)
    .prev('.panel-heading')
    .find(".more-less")
    .toggleClass('glyphicon-plus glyphicon-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);

$('#tax_manual').on('change', function () {

  if ($('#tax_manual').is(':checked')) {
    $('#manual_tax').show();
    $("#manual_tax_name").show();
    $('#tax_class').hide();
    $('#tax_class_box').removeAttr('required');
    $('#tax_r').attr('required', '');
    $('#tax_name').attr('required', '');

  } else {
    $('#tax_class').show();
    $("#manual_tax_name").hide();
    $('#manual_tax').hide();
    $('#tax_class_box').attr('required', '');
    $('#tax_r').removeAttr('required');
    $('#tax_name').removeAttr('required');
  }
});

$('#choose_policy').on('change', function () {

  var get = $(this).val();

  if (get == 1) {

    $('select[name="return_policy"]').attr('required','required');
    $('#policy').addClass('d-block').removeClass('d-none');

  }else {
    $('select[name="return_policy"]').removeAttr('required','required');
    $('#policy').addClass('d-none').removeClass('d-block');

  }

});

$(function () {

  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('form');
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

  $("#expirydate").datepicker({
    dateFormat: 'yy-m-d'
  });

  $('#order').on('change', function () {
    $('#order_status').val(+$(this).prop('checked'))
  })



  $('#store').on('change', function () {

    $('#store_status').val(+$(this).prop('checked'))
  })



  $('#store').on('change', function () {

    $('#store_status').val(+$(this).prop('checked'))
  })



  $('#product').on('change', function () {

    $('#product_status').val(+$(this).prop('checked'))
  })



  $('#cust').on('change', function () {

    $('#cust_status').val(+$(this).prop('checked'))
  })



  $('#fb').on('change', function () {

    $('#fb_status').val(+$(this).prop('checked'))
  })



  $('#tw').on('change', function () {

    $('#tw_status').val(+$(this).prop('checked'))
  })

  $('#ins').on('change', function () {

    $('#insta_status').val(+$(this).prop('checked'))
  })
});


$('#rpy_btn').on('click', function () {

  $('#rpy_btn').hide('fast');
  $('#replay').show('fast');
});

$('#cancel_btn').on('click', function () {

  $('#rpy_btn').show('fast');
  $('#replay').hide('fast');
});

function changeLang() {
  var lang = $('#changed_lng').val();
  $.ajax({
    url: baseUrl + '/changelang',
    type: 'GET',
    data: {
      lang: lang
    },
    success: function (data) {
      location.reload();
    }
  });
}

function adminlogout() {
  $(".adminlogout").submit();
  event.preventDefault();
}

$('.selected_languagedropdown').on('change', function () {
  var lang = $(this).val();
  $.ajax({
    url: baseUrl + '/changelang',
    type: 'GET',
    data: {
      lang: lang
    },
    success: function (data) {
      location.reload();
    }
  });
});