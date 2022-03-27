/*
------------------------------------
    : Custom - Form Selects js :
------------------------------------
*/
"use strict";
$(function() { 
    /* -- Form Select - Select2 -- */
    $('.select2-single').select2();
    $('.select2-multi-select').select2({
        placeholder: 'Choose',
    });
   
});