<!-- Fevicon -->
<link rel="icon" href="{{url('images/genral/'.$fevicon)}}" type="image/gif" sizes="16x16">
<!-- Fonts  -->
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link href="//fonts.googleapis.com/css2?family=Teko:wght@300&display=swap" rel="stylesheet">

<link href="{{ url('admin_new/assets/plugins/colorpicker/bootstrap-colorpicker.css') }}" rel="stylesheet" type="text/css">  
<!-- theme css -->
<link type="text/css" rel="stylesheet" href="{{ url("admin_new/assets/css/bootstrap-iconpicker.min.css") }}"/>
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{url('css/font-awesome.min.css')}}">

<link href="{{ url('admin_new/assets/css/theme.css') }}" rel="stylesheet">
<!-- Switchery css -->

 <!-- Datepicker css -->
 <link href="{{ url('admin_new/assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">

 <link href="{{ url('admin_new/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
 <!-- Touchspin css -->
 <link href="{{ url('admin_new/assets/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ url('admin_new/assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet">
<!-- Select2 css -->
<link href="{{ url('admin_new/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
<!-- Animation CSS -->
<link rel="stylesheet"  href="//cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<!-- Slick css -->
<link href="{{ url('admin_new/assets/plugins/slick/slick.css') }}" rel="stylesheet">
<link href="{{ url('admin_new/assets/plugins/slick/slick-theme.css') }}" rel="stylesheet">
<link href="{{ url('admin_new/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('admin_new/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('admin_new/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('admin_new/assets/plugins/pnotify/css/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('admin_new/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('admin_new/assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('admin_new/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('admin_new/assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

 <!-- Responsive Datatable css -->
<link href="{{ url('admin_new/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@if(selected_lang()->rtl_available == 0)
    <link href="{{ url('admin_new/assets/css/style.css') }}" rel="stylesheet" type="text/css">
@else
    <link href="{{ url('admin_new/assets/css/style_rtl.css') }}" rel="stylesheet" type="text/css">
@endif
 <!-- Preloadrer Pace -->
<link rel="stylesheet" type="text/css" href="{{ url('css/vendor/pace.min.css') }}">
<!-- jQuery ui css -->
<link href="{{ url('admin_new/assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
<!-- End css -->

@notify_css
{!! midia_css() !!}
<script src="{{ url('admin_new/assets/js/jquery.min.js') }}"></script>
@yield('stylesheet')