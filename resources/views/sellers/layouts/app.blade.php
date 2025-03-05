<!doctype html>


<?php
    if (Session()->has('seller_locale')) {
        $langCode = Session()->get('seller_locale');
    }
    else {
        $langCode = config('app.fallback_locale');
    }

  
    
    $direction = \Helpers::getLanguageDirection($langCode);
    
 
?>
<html lang="{{$langCode}}" class="@if(isset($_COOKIE['theme'])) @if($_COOKIE['theme']=='dark') dark-style @else light-style @endif @else light-style @endif layout-navbar-fixed layout-menu-fixed" dir="{{$direction}}" data-theme="theme-default" data-assets-path="{{asset('/admin-assets/')}}" data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Seller Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('/assets/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/rtl/core.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/rtl/theme-default.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/apex-charts/apex-charts.css')}}" />

    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/animate-css/animate.css')}}" />

    <!-- sweet alert -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />

    <!-- toastr cdn -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/toastr/toastr.css')}}" />

    <!-- form wizward -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />

    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/@form-validation/form-validation.css')}}" />

    <!-- dahboard js page-->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}" />


    <!-- table page -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/@form-validation/form-validation.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/quill/typography.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/quill/katex.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/quill/editor.css')}}" />

    <!-- date -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/pickr/pickr-themes.css')}}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/pages/app-ecommerce.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('/assets/vendor/js/helpers.js')}}"></script>

    <script src="{{asset('/assets/js/config.js')}}"></script>
    
  </head>
    
    @include('sellers.layouts.custom_css')

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

    @include('sellers.layouts.menu')

    @include('sellers.layouts.header')

    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->

    <!-- BEGIN: Footer-->
    @include('sellers.layouts.footer')
    <!-- BEGIN: Footer-->

    <!-- BEGIN: js-->
    @include('sellers.layouts.custom')
    <!-- BEGIN: js-->