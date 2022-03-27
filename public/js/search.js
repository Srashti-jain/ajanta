/*=================================================
=            Autocomplete search 				  =
=			  Developer - @nkit                   =
=================================================*/

"use strict";

var search_word;

$(function() {
	search(search_word);
});

$('.searchDropMenu').on('change', function() {
	search_word = $(this).val();
	search(search_word);
});

function search(search_word) {
	if(!search_word) {
		var x = $('.searchDropMenu option:selected').val();
	} else {
		var x = search_word;
	}


	$(".search-field").autocomplete({
		source: function(request, response) {
			$.ajax({
				url: sendurl,
				data: {
					catid: x,
					search: request.term
				},
				dataType: "json",
				success: function(data) {
					var resp = $.map(data, function(obj) {
						return {
							label: obj.value,
							value: obj.value,
							img: obj.img,
							url: obj.url
						}
					});
					response(resp);
				}
			});
		},
		select: function(event, ui) {
			if(ui.item.value != 'No Result found') {
				event.preventDefault();
				location.href = ui.item.url;
			} else {
				return false;
			}
		},
		html: true,
		open: function(event, ui) {
			$(".ui-autocomplete").css("z-index", 1000);
		},
	}).autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li><div><img src='" + item.img + "'><span>" + item.value + "</span></div></li>").appendTo(ul);
	};
}

var catids = sessionStorage.getItem("searchcat");
$(function() {
  
        
  if (window.location.href.indexOf('&keyword=') > 0) {
     // No code
  }else{
    sessionStorage.clear();
  }
      
  var cachesearchedValue;
  if(typeof(Storage) !== "undefined") {
    cachesearchedValue = sessionStorage.getItem("searchItem");
  }
  $('.search-field').val(cachesearchedValue);
  setinhtmlsession(catids);
  $(".searchDropMenu option").each(function() {
    if($(this).val() == catids) { // EDITED THIS LINE
      $(this).attr("selected", "selected");
    } else {
      $(this).removeAttr("selected");
    }
  });
});

$('.searchDropMenu').on('change', function() {
  catids = $(this).val();
  setinhtmlsession(catids);
});

function setinhtmlsession(catids) {
  if(!catids) {
    var catids1 = $('.searchDropMenu').val();
  } else {
    var catids1 = catids;
  }
  sessionStorage.setItem("searchcat", catids1);
}
