$(function () {
    "use strict";

    $("#customer_search").autocomplete({

        source: function (request, response) {
            $.ajax({
                url: url,
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {
                        return {
                            customerid: obj.id,
                            label: obj.label,
                            value: obj.value,
                            email: obj.email,
                            address: obj.address,
                            pincode: obj.pincode,
                            phone: obj.phoneno,
                            country: obj.country,
                            state: obj.state,
                            city: obj.city
                        }
                    });

                    response(resp);
                }
            });
        },
        select: function (event, ui) {



            if (ui.item.value) {

                var countryid = ui.item.country;
                var stateid = ui.item.state;
                var cityid = ui.item.city;


                this.value = ui.item.value.replace(/\D/g, '');

                $('#customer_search').val('');
                $('#customer_id').val(ui.item.customerid);
                $('#customer_search').val(ui.item.value);
                $('.customer_phone').val('');
                $('.customer_phone').val(ui.item.phone);
                $('.customer_email').val('');
                $('.customer_email').val(ui.item.email);
                $('.customer_shipping_address').val('');
                $('.customer_billing_address').val('');

                if ($('input[name=same_as_shipping]').is(':checked')) {
                    $('.customer_billing_address').val(ui.item.address);
                }

                $('.customer_shipping_address').val(ui.item.address);
                $('.customer_pincode').val('');
                $('.customer_pincode').val(ui.item.pincode);

                var urlLike1 = baseUrl + '/choose_state';
                var up1 = $('#upload_id');
                var country_id = countryid;

                $("#country_id option").each(function () {

                    if ($(this).val() == country_id) { // EDITED THIS LINE
                        $('#country_id').val(country_id);
                        $('#country_id').select2().trigger('change');
                    }
                });

                if (country_id) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        url: urlLike1,
                        data: {
                            catId: country_id
                        },
                        success: function (data) {
                            $.each(data, function (id, title) {
                                up1.append($('<option>', {
                                    value: id,
                                    text: title
                                }));
                            });

                            $("#upload_id option").each(function () {
                                if ($(this).val() == stateid) { // EDITED THIS LINE
                                    $(this).attr("selected", "selected");
                                } else {
                                    $(this).removeAttr("selected");
                                }
                            });
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest);
                        }
                    });
                }
                var up = $('#city_id').empty();
                var urlLike = baseUrl + '/choose_city';
                if (stateid) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        url: urlLike,
                        data: {
                            catId: stateid
                        },
                        success: function (data) {
                            up.append('<option value="">Please Choose</option>');
                            $.each(data, function (id, title) {
                                up.append($('<option>', {
                                    value: id,
                                    text: title
                                }));
                            });
                            $("#city_id option").each(function () {
                                if ($(this).val() == cityid) { // EDITED THIS LINE
                                    $(this).attr("selected", "selected");
                                } else {
                                    $(this).removeAttr("selected");
                                }


                            });
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {}
                    });
                }


                return false;
            }
        },
        minLength: 1
    });
});

function getstate(state) {

    var ups = $('#upload_id').empty();

    $('#city_id').empty();

    var cat_id = $('#country_id').val();

    if (cat_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: baseUrl + '/choose_state',
            data: {
                catId: cat_id
            },
            success: function (data) {

                ups.append('<option value="">Please Choose</option>');

                $.each(data, function (id, title) {
                    ups.append($('<option>', {
                        value: id,
                        text: title
                    }));
                });

                if (state) {
                    $("#upload_id option").each(function () {

                        if ($(this).val() == state) {

                            $('#upload_id').val(state);
                            $('#upload_id').select2().trigger('change');

                        }
                    });
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

}

function getcity() {


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: baseUrl + '/choose_city',
        data: {
            catId: $('#upload_id').val()
        },
        success: function (data) {

            $('#city_id').empty();
            $.each(data, function (id, title) {

                $('#city_id').append($('<option>', {
                    value: id,
                    text: title
                }));


            });



            $("#city_id option").each(function () {

                if ($(this).val() == c) {

                    $('#city_id').val(c);
                    $('#city_id').select2().trigger('change');

                }
            });


        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });

}

$('#same_as_shipping').on('change', function () {
    if ($('#same_as_shipping').is(':checked')) {
        var shippaddress = $('.customer_shipping_address').val();
        $('.customer_billing_address').val(shippaddress);
    } else {
        $('.customer_billing_address').val('');
    }
});

$(".myTable").on('click', 'button.addNew', function () {

    var n = $(this).closest('tr');
    addNewRow(n);

});

function addNewRow(n) {

    // e.preventDefault();

    var $tr = n;
    var allTrs = $tr.closest('table').find('tr');
    var lastTr = allTrs[allTrs.length - 1];
    var $clone = $(lastTr).clone(); 
    $clone.find('td').each(function () {
        var el = $(this).find(':first-child');
        var id = el.attr('id') || null;
        if (id) {

            var i = id.substr(id.length - 1);
            var prefix = id.substr(0, (id.length - 1));
            el.attr('id', prefix + (+i + 1));
            el.attr('name', prefix + (+i + 1));
        }
    });

    $clone.find('input').val('');

    $tr.closest('table').append($clone);

    $('input.product_name').last().focus();

    enableAutoComplete($("input.product_name:last"));
}

function enableAutoComplete($element) {

    $element.autocomplete({
        source: function (request, response) {
            $.ajax({
                url: productsearch,
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (data) {

                    var resp = $.map(data, function (obj) {
                        return {
                            productid: obj.id,
                            label: obj.label,
                            value: obj.value
                        }
                    });

                    response(resp);
                }
            });
        },
        select: function (event, ui) {

            if (ui.item.value) {
                this.value = ui.item.value.replace(/\D/g, '');
            }

        },
        minlength: 1,

    });
}



$('.myTable').on('click', 'button.removeBtn', function () {

    var d = $(this);
    removeRow(d);

});

function removeRow(d) {
    var rowCount = $('.myTable tr').length;
    if (rowCount !== 2) {
        d.closest('tr').remove();
        subtotalcalculation();
        tax_calculator();
        grand_total_caluclation();
    } else {
        console.log('Atleast one sell is required');
        subtotalcalculation();
        tax_calculator();
        grand_total_caluclation();
    }
}

/** Calculation */

var total;

$('.myTable').on('change', '.product_price', function () {


    var row = $(this).closest("tr");

    var price = row.find("input.product_price").val();
    var qty = row.find("input.product_qty").val();
    var totalbox = row.find("input.product_total");





    if (!qty) {
        price = +price * 1;
    } else {


        price = +price * qty;
        price = price.toFixed(2);

    }



    refreshTotal(price, totalbox);

    subtotalcalculation();
    tax_calculator();
    grand_total_caluclation();

});



$('.myTable').on('change', '.product_qty', function () {

    var row = $(this).closest("tr");

    var price = row.find("input.product_price").val();
    var qty = row.find("input.product_qty").val();

    var totalbox = row.find("input.product_total");

    if (qty && qty != 0) {

        price = price;

        var newprice = +price * qty;

        total = +newprice;

        refreshTotal(total, totalbox);

    } else {

        $('.errorMessage').html('Minimum quantity should be 1');

        $('.errorzone').show();

        row.find("input.product_qty").val(1);

        price = +price * 1;

        total = price;


        refreshTotal(total, totalbox);
    }

    total = total.toFixed(2);
    subtotalcalculation();
    tax_calculator();
    grand_total_caluclation();

});




function refreshTotal(total, totalbox) {
    totalbox.val(total);
}

function grand_total_caluclation() {

    var subtotal = +$('.final_subtotal').val();
    var shipping = +$('.total_shipping').val();
    var tax = +$('.total_tax_amount').val();
    var adjust_amount = +$('.adjustable_amount').val();
    var grandtotal = subtotal + shipping + tax + adjust_amount;
    grandtotal = grandtotal.toFixed(2);
    $('.grand_total').val(grandtotal);
}

function subtotalcalculation() {

    var subtotal = 0;

    $('.product_price').each(function (index) {

        var row = $(this).closest("tr");
        var p = +$(this).val();
        var q = +row.find("input.product_qty").val();

        if (!q) {
            var q = 1;
        }

        var total = p * q;
        subtotal = subtotal + total;
    });

    $('.final_subtotal').val(subtotal);
    grand_total_caluclation();
}



$('.orderDetails').on('keydown', function (e) {

    if ((e.metaKey || e.ctrlKey) && (String.fromCharCode(e.which).toLowerCase() === 'd')) {

        event.preventDefault();
        var n = $('.myTable tr:last');
        addNewRow(n);

    }

});

$(document).on('keydown', function (e) {

    if ((e.metaKey || e.ctrlKey) && (String.fromCharCode(e.which).toLowerCase() === 'e')) {

        event.preventDefault();
        var n = $('.myTable tr:last');
        // return confirm('Are you sure want to delete this row?');
        removeRow(n);
        subtotalcalculation();
        tax_calculator();
        grand_total_caluclation();
    }
});

$('.shipping_rate').on('change', function () {
    $('.total_shipping').val($(this).val());
    grand_total_caluclation();
});

$('.adjustable_amount').on('change', function () {
    grand_total_caluclation();
});

$('.total_tax_percent').on('change', function () {

    tax_calculator();

});

$('.customer_shipping_address').on('keyup', function () {
    if ($('input[name=same_as_shipping]').is(':checked')) {
        $('.customer_billing_address').val($(this).val());
    }
});

function tax_calculator() {

    var subtotal = 0;

    $('.product_total').each(function () {
        var x = +$(this).val();
        subtotal = subtotal + x;
    });

    var taxpercent = +$('.total_tax_percent').val();

    var taxamount = 0;

    if ($('.tax_include').is(':checked')) {

        var p = 100;

        var pt = p + taxpercent;

        taxamount = +subtotal / pt * taxpercent;

        taxamount = taxamount.toFixed(2);

        var newsubtotal = subtotal - taxamount;

        newsubtotal = newsubtotal.toFixed(2);

        $('.final_subtotal').val(newsubtotal);

    } else {

        taxamount = +subtotal * taxpercent / 100;

        taxamount = taxamount.toFixed(2);

        $('.final_subtotal').val(subtotal);

    }

    $('.total_tax_amount').val(taxamount);

    $('.tax_in_rupees').html(taxamount);

    grand_total_caluclation();

}

$('.tax_include').on('click', function () {
    if ($(this).is(':checked')) {
        tax_calculator();
    } else {
        tax_calculator();
    }
});

$('input[name=txn_same_as_orderid]').on('change', function () {

    if ($(this).is(':checked')) {
        $("input[name=txn_id]").val($("input[name=order_id]").val());
    } else {
        $("input[name=txn_id]").val('');
    }

});

$("input[name=order_id]").on("keyup", function () {

    if ($('input[name=txn_same_as_orderid]').is(':checked')) {
        $("input[name=txn_id]").val($(this).val());
    }

});

/** End */