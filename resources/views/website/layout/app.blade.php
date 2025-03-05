
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#0E0E0E">
    <meta name="template-color" content="#0E0E0E">
    <meta name="description" content="Index page">
    <meta name="keywords" content="index, page">
    <meta name="author" content="">
   
   
   <link rel="shortcut icon" type="image/x-icon" href="{{url('uploads/setting/'.setting('favicon'))}}">
   <link href="{{asset('front_assets/css/style.css?v=3.0.0')}}" rel="stylesheet">
    <link href="{{asset('front_assets/css/custom.css')}}" rel="stylesheet">
    <title>Ecom</title>
  </head>



    @include('website.layout.header')

        <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->

     <!-- BEGIN: Footer-->
    @include('website.layout.footer')
    <!-- BEGIN: Footer-->



