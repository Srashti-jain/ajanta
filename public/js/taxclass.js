"use strict";
// Define your library strictly...
function removeRow(id) {
  $('#' + id).remove();
}
$("#xyz").on('click', '.rmsf', function() {
  $(this).parent().parent().remove();
});



function SubmitFormData() {
  var basedArry = new Array();
  var taxArry = new Array();
  var priArry = new Array();
  var testarr = new Array();
  var rowCount = +($('.xyz tr').length);
  for(var i = 1; i <= rowCount; i++) {
    var based_on = $("#based_on" + i).val();
    var priority = $("#priority" + i).val();
    var tax = +($("#tax" + i).val());
    var pObj = {
      priority
    };
    var taxObj = {};
    taxObj[priority] = tax;
    taxArry.push(taxObj);
    var basedOnObj = {};
    basedOnObj[priority] = based_on;
    basedArry.push(basedOnObj);
    priArry.push(priority);
  }
  var data1;
  var data2;
  var taxobj = taxArry[0];
  for(var j = 0; j <= taxArry.length; j++) {
    if(j == 0) {
      data1 = taxArry[j];
      data2 = '';
    } else {
      data1 = taxArry[j];
      data2 = taxArry[j - 1];
    }
    taxobj = $.extend({}, taxobj, data2);
  }
  var data3;
  var data4;
  var basedobj = basedArry[0];
  for(var k = 0; k <= basedArry.length; k++) {
    if(k == 0) {
      data3 = basedArry[k];
      data4 = '';
    } else {
      data3 = basedArry[k];
      data4 = basedArry[k - 1];
    }
    basedobj = $.extend({}, basedobj, data4);
  }
  var title = $("#titles").val();
  var des = $("#des").val();
  var urlLike = baseUrl + '/admin/taxclassAdd';
  $.ajax({
    type: 'GET',
    url: urlLike,
    data: {
      title: title,
      des: des,
      basedArry: basedobj,
      priArry: priArry,
      taxArry: taxobj
    },
    beforeSend: function() {
      $('.preL').fadeIn();
      $('.preloader3').fadeIn();
      $('.box,.main-header,.main-sidebar').css({
        '-webkit-filter': 'blur(5px)'
      });
    },
    success: function(data) {
      $('.preL').fadeOut();
      $('.preloader3').fadeOut();
      $('.box,.main-header,.main-sidebar').css({
        '-webkit-filter': ''
      });
      var animateIn = "lightSpeedIn";
      var animateOut = "lightSpeedOut";
      PNotify.success({
        title: 'Added',
        text: 'Tax Class has been added/updated !',
        icon: 'fa fa-check-circle',
        modules: {
          Animate: {
            animate: true,
            inClass: animateIn,
            outClass: animateOut
          }
        }
      });
      setTimeout(function() {
        location.href = baseUrl + '/admin/tax_class';
      }, 1000);
    }
  });
}
$(function() {
  $('[data-toggle="popover"]').popover({
    placement: 'top',
    trigger: 'hover'
  });
});
