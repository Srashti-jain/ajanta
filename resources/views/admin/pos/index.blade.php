<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title -->
    <title>POS @yield('title')</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('admin_new/assets')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('admin_new/assets')}}/vendor/icon-set/style.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('admin_new/assets')}}/css/theme.minc619.css?v=1.0">
    @stack('css_or_js')
    <style>
        .scroll-bar {
            max-height: calc(100vh - 100px);
            overflow-y: auto !important;
        }

        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 1px #cfcfcf;
            /*border-radius: 5px;*/
        }

        ::-webkit-scrollbar {
            width: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            /*border-radius: 5px;*/
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #FC6A57;
        }
        .deco-none {
            color: inherit;
            text-decoration: inherit;
        }
        .qcont{
            text-transform: lowercase;
        }
        .qcont:first-letter {
            text-transform: capitalize;
        }



        .navbar-vertical .nav-link {
            color: #ffffff;
        }

        .navbar .nav-link:hover {
            color: #C6FFC1;
        }

        .navbar .active > .nav-link, .navbar .nav-link.active, .navbar .nav-link.show, .navbar .show > .nav-link {
            color: #C6FFC1;
        }

        .navbar-vertical .active .nav-indicator-icon, .navbar-vertical .nav-link:hover .nav-indicator-icon, .navbar-vertical .show > .nav-link > .nav-indicator-icon {
            color: #C6FFC1;
        }

        .nav-subtitle {
            display: block;
            color: #fffbdf91;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .03125rem;
        }

        .navbar-vertical .navbar-nav.nav-tabs .active .nav-link, .navbar-vertical .navbar-nav.nav-tabs .active.nav-link {
            border-left-color: #C6FFC1;
        }
        .item-box{
            height:250px;
            width:150px;
            padding:3px;
        }

        .header-item{
            width:10rem;
        }
    </style>

    <script src="{{asset('admin_new/assets/admin')}}/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="{{asset('admin_new/assets')}}/css/toastr.css">
</head>

<body class="footer-offset">

{{--loader--}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" style="display: none;">
                <div style="position: fixed;z-index: 9999; left: 40%;top: 37% ;width: 100%">
                    <img width="200" src="{{asset('admin_new/assets/images/loader.gif')}}">
                </div>
            </div>
        </div>
    </div>
</div>
{{--loader--}}

<!-- JS Preview mode only -->
    <header id="header"
            class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered">
        <div class="navbar-nav-wrap">
            <div class="navbar-brand-wrapper">
                <!-- Logo Div-->
                <a href="{{url('/')}}" class="class="navbar-brand"">
                    <img src="{{ url('images/genral/'.$genrals_settings->logo) }}" class="navbar-brand-logo" alt="logo" />
                  </a>
              
            </div>

            <!-- Secondary Content -->
            <div class="navbar-nav-wrap-content-right">
                <!-- Navbar -->
                <ul class="navbar-nav align-items-center flex-row">
                    
                    <li class="nav-item">
                        <!-- Account -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                               data-hs-unfold-options='{
                                     "target": "#accountNavbarDropdown",
                                     "type": "css-animation"
                                   }'>
                                <div class="avatar avatar-sm avatar-circle">
                                    @if(Auth::user()->image != '' &&
                                     file_exists(public_path().'/images/user/'.Auth::user()->image))
                                     <img src="{{url('images/user/'.Auth::user()->image)}}" alt="profilephoto"
                                         class="rounded img-fluid">
                                     @else
                                     <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="profilephoto"
                                         class="rounded img-fluid">
                                     @endif
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                            </a>

                            <div id="accountNavbarDropdown"
                                 class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account"
                                 style="width: 16rem;">
                      
                                <a href="{{ route('logout') }}" class="profile-icon" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><img
                                    src="{{ url('admin_new/assets/images/svg-icon/logout.svg') }}"
                                    class="img-fluid" alt="logout">Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                                </a>
                            </div>
                        </div>
                        <!-- End Account -->
                    </li>
                </ul>
                <!-- End Navbar -->
            </div>
            <!-- End Secondary Content -->
        </div>
    </header>
<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
<!-- Content -->
	<!-- ========================= SECTION CONTENT ========================= -->
	<section class="section-content padding-y-sm bg-default mt-1">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-7 card padding-y-sm card ">
                    <div class="card-header d-flex flex-wrap justify-content-between " id="search_div">
                        <form id="search-form" class="header-item"  >
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch" type="search" value="{{$keyword?$keyword:''}}" name="search" class="form-control" placeholder="Search here" aria-label="Search here">
                            </div>
                            <!-- End Search -->
                        </form>
                        <div class="input-group header-item" style="width: auto">
                            <select name="category" id="category" class="form-control js-select2-custom mx-1" title="select category" onchange="set_category_filter(this.value)">
                                <option value="">All Categories</option>
                                @foreach ($categories as $item)
                                <option value="{{$item->id}}" {{$category==$item->id?'selected':''}}>{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
					<div class="card-body" id="items">
                        <div class="d-flex flex-wrap mt-2 mb-3" style="justify-content: space-around;" id="tch_box">
                            @foreach($small_array as $product_data)
                                <div class="item-box {{ $product_data['name'] }}">
                                    @include('admin.pos._single_product',['product'=>$product_data])
                                    {{--<hr class="d-sm-none">--}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                      
                    </div>
				</div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="row m-0">
                           
                          {{--  <div class="col-12 p-1">
                                <select onchange="store_key('customer_id',this.value)" id='customer' name="customer_id" data-placeholder="{{\App\CentralLogics\translate('Walk In Customer')}}" class="js-data-example-ajax form-control">

                                </select>
                                <!-- <button class="btn btn-sm btn-white btn-outline-primary ml-1" type="button" title="Add Customer">
                                    <i class="tio-add-circle text-dark"></i>
                                </button> -->
                            </div>
                        </div> --}}
                        <div class='w-100' id="cart">
                            @include('admin.pos._cart')
                        </div>
                    </div>
				</div>
				
			</div>
		</div><!-- container //  -->
	</section>

    <!-- End Content -->
    <div class="modal fade" id="quick-view" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="quick-view-modal">

            </div>
        </div>
    </div>
 
    @php($order=\App\Order::find(session('last_order')))
    @if($order)
    <script>
          toastr.info('Order Success', {
                    CloseButton: true,
                    ProgressBar: true
                });
    </script>
    @php(session(['last_order'=> false]))
    <div class="modal fade" id="print-invoice" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Print Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row" style="font-family: emoji;">
                    <div class="col-md-12">
                        <center>
                            <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')"
                                value="Proceed, If thermal printer is ready."/>
                            <a href="{{url()->previous()}}" class="btn btn-danger non-printable">Back</a>
                        </center>
                        <hr class="non-printable">
                    </div>
                    <div class="row" id="printableArea" style="margin: auto;">
                        @include('admin.pos.order.invoice')
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif



</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== END SECONDARY CONTENTS ========== -->

<!-- JS Implementing Plugins -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<!-- JS Front -->
<script src="{{asset('admin_new/assets')}}/js/vendor.min.js"></script>
<script src="{{asset('admin_new/assets')}}/js/theme.min.js"></script>
<script src="{{asset('admin_new/assets')}}/js/sweet_alert.js"></script>
<script src="{{asset('admin_new/assets')}}/js/toastr.js"></script>
{{-- !! Toastr::message() !!--}}


@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif

<script>
       $('#datatableSearch').keyup(function() {
        if (!this.value) {
            $('.item-box').show();
         }else{
        myFunction($(this).val());
         }
});
function myFunction(e) {
  var filter = e.toUpperCase();
  var list = document.getElementById("search_div");
  var divs = list.getElementsByTagName("div");
  $('.item-box').hide();
  $("#tch_box").find("."+filter).show();

}
    $(document).on('ready', function () {
        // INITIALIZATION OF UNFOLD
        // =======================================================
        $('.js-hs-unfold-invoker').each(function () {
            var unfold = new HSUnfold($(this)).init();
        });
    });
</script>
<!-- JS Plugins Init. -->
<script>
    $(document).on('ready', function () {
        @if($order)
        $('#print-invoice').modal('show');
        @endif
    });
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

    function set_category_filter(id) {
        var nurl = new URL('{!!url()->full()!!}');
        nurl.searchParams.set('category_id', id);
        location.href = nurl;
    }


    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        // var keyword= $('#datatableSearch').val();
        // var nurl = new URL('{!!url()->full()!!}');
        // nurl.searchParams.set('keyword', keyword);
        // location.href = nurl;
    });

    function addon_quantity_input_toggle(e)
    {
        var cb = $(e.target);
        if(cb.is(":checked"))
        {
            cb.siblings('.addon-quantity-input').css({'visibility':'visible'});
        }
        else
        {
            cb.siblings('.addon-quantity-input').css({'visibility':'hidden'});
        }
    }
    function quickView(product_id,sub_cat,set_name) {
        $.ajax({
            url: '{{route('admin.pos.quick-view')}}',
            type: 'GET',
            data: {
                product_id: product_id,
                sub_cat: sub_cat,
                set_name: set_name
            },
            dataType: 'json', // added data type
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                // console.log("success...");
                // console.log(data);

                // $("#quick-view").removeClass('fade');
                // $("#quick-view").addClass('show');

                $('#quick-view').modal('show');
                $('#quick-view-modal').empty().html(data.view);
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }

    function checkAddToCartValidity() {
        var names = {};
        $('#add-to-cart-form input:radio').each(function () { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function () { // then count them
            count++;
        });
        if ($('input:radio:checked').length == count) {
            return true;
        }
        return false;
    }

    function cartQuantityInitialize() {
        $('.btn-number').click(function (e) {
            e.preventDefault();

            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            var name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, the minimum value was reached'
                });
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, stock limit exceeded'
                });
                $(this).val($(this).data('oldValue'));
            }
        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

    function getVariantPrice() {
    //  if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //             }
    //         });
    //         $.ajax({
    //             type: "POST",
    //             url: '{{ route('admin.pos.variant_price') }}',
    //             data: $('#add-to-cart-form').serializeArray(),
    //             success: function (data) {
    //                 $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
    //                 $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
    //             }
    //         });
    //     }
    }

    function deletefromset(single_p_id,g_cat_id,sub_cat_id,quantity,session_key,set_name){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.post({
                url: '{{ route('admin.pos.add-to-cart') }}',
                data: {
                    id : g_cat_id,
                    subcategory :sub_cat_id,
                    set_name : set_name,
                    single_p_id : single_p_id,
                    session_key : session_key,
                    quantity : quantity
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                  
                    toastr.success('Book has been removed from set!', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    updateCart();
                },
                complete: function () {
                    $('#loading').hide();
                }
            });   
    }

    function addToCart(form_id = 'add-to-cart-form') {
        if (checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.pos.add-to-cart') }}',
                data: $('#' + form_id).serializeArray(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.data == 1) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Cart',
                            text: "Product already added in cart"
                        });
                        return false;
                    } else if (data.data == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: 'Sorry, product out of stock'
                        });
                        return false;
                    }
                    $('.call-when-done').click();

                    toastr.success('Item has been added in your cart!', {
                        CloseButton: true,
                        ProgressBar: true
                    });

                    updateCart();
                },
                complete: function () {
                    $('#loading').hide();
                }
            });
        } else {
            Swal.fire({
                type: 'info',
                title: 'Cart',
                text: 'Please choose all the options'
            });
        }
    }

    function removeFromCart(key,id,sub_id) {
        $.post('{{ route('admin.pos.remove-from-cart') }}',
         {
             _token: '{{ csrf_token() }}',
              key: key,
              id:id,
              sub_id:sub_id
         },
        function (data) {
        //    console.log(data).die();
            if (data.errors) {
                for (var i = 0; i < data.errors.length; i++) {
                    toastr.error(data.errors[i].message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            } else {
                // console.log(data).die();
                updateCart();
                toastr.info('Item has been removed from cart', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }

        });
    }

    function emptyCart() {
        $.post('{{ route('admin.pos.emptyCart') }}', {_token: '{{ csrf_token() }}'}, function (data) {
            updateCart();
            toastr.info('Item has been removed from cart', {
                CloseButton: true,
                ProgressBar: true
            });
        });
    }

    function updateCart() {
        $.post('<?php echo e(route('admin.pos.cart_items')); ?>', {_token: '<?php echo e(csrf_token()); ?>'}, function (data) {
            $('#cart').empty().html(data);
        });
    }

   $(function(){
        $(document).on('click','input[type=number]',function(){ this.select(); });
    });


    function updateQuantity(e){
        var element = $( e.target );
        var minValue = parseInt(element.attr('min'));
        // maxValue = parseInt(element.attr('max'));
        var valueCurrent = parseInt(element.val());

        var key = element.data('key');
        if (valueCurrent >= minValue) {
            $.post('{{ route('admin.pos.updateQuantity') }}', {_token: '{{ csrf_token() }}', key: key, quantity:valueCurrent}, function (data) {
                updateCart();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Cart',
                text: 'Sorry, the minimum value was reached'
            });
            element.val(element.data('oldValue'));
        }
        // if (valueCurrent <= maxValue) {
        //     $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        // } else {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Cart',
        //         text: 'Sorry, stock limit exceeded.'
        //     });
        //     $(this).val($(this).data('oldValue'));
        // }


        // Allow: backspace, delete, tab, escape, enter and .
        if(e.type == 'keydown')
        {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        }

    };



    // INITIALIZATION OF SELECT2
    // =======================================================
    $('.js-select2-custom').each(function () {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });

    $('.branch-data-selector').select2();

    $('.js-data-example-ajax').select2({
        ajax: {
            url: '{{route('admin.pos.customers')}}',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    // $("#order_place").submit(function(e) {

    //     e.preventDefault(); // avoid to execute the actual submit of the form.

    //     var form = $(this);
    //     form.append("user_id", $('#customer').val());

    //     form.submit();
    // });

    $('#order_place').submit(function(eventObj) {
        if($('#customer').val())
        {
            $(this).append('<input type="hidden" name="user_id" value="'+$('#customer').val()+'" /> ');
        }
        return true;
    });

    function store_key(key, value) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });
        $.post({
            url: '{{route('admin.pos.store-keys')}}',
            data: {
                key:key,
                value:value,
            },
            success: function (data) {
                toastr.success(key+' '+selected+'!', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
        });
    }

 

</script>
<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>

