"use strict";
$(document).ready(function() {
    /* -- Form - Touchspin -- */    
    $("#touchspin-value-attribute").TouchSpin();
    $("#touchspin-empty-value").TouchSpin();
    $("#touchspin-postfix").TouchSpin({
        min: 0,
        max: 100,
        stepinterval: 50,
        maxboostedstep: 10000000,
        postfix: '%'
    });    
    $(".editprice").TouchSpin({
        min: -1000,
        max: 1000,
        step: 0.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
       
        
    });    
    $(".simpleproduct").TouchSpin({
        min:0,
        max: 1000,
        step: 0.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
       
        
    });    
    $(".discount2").TouchSpin({
        min:0,
        max: 1000,
        step: 0.001,
        decimals: 3,
        boostat: 5,
        maxboostedstep: 10,
       
        
    });    
    $(".planprice").TouchSpin({
        min:1,
        max: 1000,
        step: 0.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
       
        
    });    
    $(".price").TouchSpin({
        
        max: 1000,
       
        stepinterval: 50,
        maxboostedstep: 10000000,
        
       
        
    });    
    $(".limit").TouchSpin({
        min:1,
        max: 10000,
       
        stepinterval: 50,
        maxboostedstep: 10000000,
        
       
        
    });    
       
    $("#touchspin-prefix").TouchSpin({
        min: -1000000000,
        max: 1000000000,
        stepinterval: 50,
        maxboostedstep: 10000000,
        prefix: '$'
    });
    $("#touchspin-value-attr-not-set").TouchSpin({
        initval: 40
    });
    $("#touchspin-value-set-explicitly").TouchSpin({
        initval: 40
    });
    $("#touchspin-vertical-btn").TouchSpin({
      verticalbuttons: true
    });
    $("#touchspin-change-btn-class").TouchSpin({
        buttondown_class: "btn btn-rounded btn-primary",
        buttonup_class: "btn btn-rounded  btn-primary"
    });
});