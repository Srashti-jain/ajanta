"use strict";
// Define your library strictly...
$(document).on('click', '.removeFrmWish', function() {
  var wc = $('#wishcount').text();
  wc = Number(wc);
  if(wc == 1) {
    wc = 0;
  } else {
    wc = Number(wc) - 1;
  }
  $('#wishcount').text(wc);
  $(this).parent().removeClass('active');
  $('body').append('<div class="preL"><div class="preloader3"></div></div>');
  var id = $(this).attr('mainid');
  var url = baseUrl + '/AddToWishList/' + id;
  var ajaxremoveurl = $(this).attr('data-remove');
  $(this).parent().css({
    background: '#0f6cb2'
  });
  $(this).parent().html('<a mainid="' + id + '" data-add="' + url + '" class="text-white btn addtowish" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="fa fa-heart"></i></a>');
  setTimeout(function() {
    $.ajax({
      type: 'GET',
      url: ajaxremoveurl,
      success: function(response) {
        if(response == 'deleted') {

          toastr.error('Product is removed from wishlist','Removed');
         
        } else {
          toastr.warning('Failed to remove it from wishlist','Failed');
        }
      }
    });
    $('.preL').fadeOut('fast');
    $('.preloader3').fadeOut('fast');
    $('body').attr('scroll', 'yes');
    $('body').css('overflow', 'auto');
  }, 1500);
});
$(document).on('click', '.addtowish', function() {
  var wc = $('#wishcount').text();
  wc = Number(wc);
  if(wc == 0) {
    wc = 1;
  } else {
    wc = Number(wc) + 1;
  }
  $('#wishcount').text(wc);
  $('body').append('<div class="preL"><div class="preloader3"></div></div>');
  var id = $(this).attr('mainid');
  var url = baseUrl + '/removeWishList/' + id;
  var ajaxaddurl = $(this).attr('data-add');
  $(this).parent().css({
    background: '#fdd922'
  });
  
  $(this).parent().html('<a mainid="' + id + '" data-remove="' + url + '" class="color000 btn removeFrmWish" data-toggle="tooltip" data-placement="right" title="Remove From Wishlist"><i class="fa fa-heart"></i></a>');
  setTimeout(function() {
    $.ajax({
      type: 'GET',
      url: ajaxaddurl,
      success: function(response) {
        if(response == 'success') {
          toastr.success('Product is added to your wishlist','Added');
        } else {
          

          toastr.warning('Product is already in your wishlist !','Oops !');
        }
      }
    });
    $('.preL').fadeOut('fast');
    $('.preloader3').fadeOut('fast');
    $('body').attr('scroll', 'yes');
    $('body').css('overflow', 'auto');
  }, 1500);
});
