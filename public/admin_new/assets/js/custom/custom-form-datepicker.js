/*
---------------------------------------
    : Custom - Form Datepicker js :
---------------------------------------
*/
"use strict";



$(function() {

	$('#default-date').datepicker({
	    language: 'en',
	    dateFormat: 'yyyy-mm-dd',
	});
	
	$('.default-date').datepicker({
	    language: 'en',
	    dateFormat: 'yyyy-mm-dd',
	});


	$('.timepickerwithdate').datepicker({
		dateFormat : 'yyyy-mm-dd',
		language: 'en',	    
		timeFormat: 'hh:ii aa',
		timepicker: true,
	
	});
	
    /* --- Form - Datepicker -- */
 
    var disabledDays = [0, 6];
	$('#disable-day-date').datepicker({
	    // language: 'en',
	    dateFormat: 'dd/mm/yyyy',
	    position: 'top left',
	    onRenderCell: function (date, cellType) {
	        if (cellType == 'day') {
	            var day = date.getDay(),
	                isDisabled = disabledDays.indexOf(day) != -1;

	            return {
	                disabled: isDisabled
	            }
	        }
	    }
	});	
});