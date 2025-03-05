<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin Login</title>

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
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/@form-validation/form-validation.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('/assets//js/config.js')}}"></script>

  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover authentication-bg">
      <div class="authentication-inner row">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 p-0">
          <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img
              src="{{asset('/assets/img/illustrations/auth-login-illustration-light.png')}}"
              alt="auth-login-cover"
              class="img-fluid my-5 auth-illustration"
              data-app-light-img="illustrations/auth-login-illustration-light.png')}}"
              data-app-dark-img="illustrations/auth-login-illustration-dark.png')}}" />

            <img
              src="{{asset('/assets/img/illustrations/bg-shape-image-light.png')}}"
              alt="auth-login-cover"
              class="platform-bg"
              data-app-light-img="illustrations/bg-shape-image-light.png')}}"
              data-app-dark-img="illustrations/bg-shape-image-dark.png')}}" />
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                    <div class="w-px-400 mx-auto">
                        <!-- Logo -->
                        <!--<div class="app-brand mb-4">-->
                        <!--    <a href="{{url('/admin-login')}}" class="app-brand-link gap-2">-->
                        <!--    <img class="width-45-percent" src="{{url('uploads/setting/'.setting('website_admin_logo'))}}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-logo-image.png') }}`"/>-->
                        <!--    </a>             -->
                        <!--</div>-->
                        <!-- /Logo -->
                        @if(env('CODE_VERIFIED')==true)
                        <!-- <h3 class="mb-1 fw-bold">{{__('lang.admin_login')}}</h3>
                        <p class="mb-4">{{__('lang.admin_login_sub_text')}}</p> -->
                            <h4 class="mb-1 pt-2">Thank You</h4>
                            <p>Purchased code verified successfully</p>
                            <p class="mb-4">Use this credentials to login admin panel</p>
                            <p class="">
                                Username : <span id="username">admin@gmail.com</span>
                                <i class="menu-icon tf-icons ti ti-copy copy-button" data-clipboard-target="#username" style="cursor: pointer;"></i>
                            </p>
                            <p class="">
                                Password : <span id="password">12345678</span>
                                <i class="menu-icon tf-icons ti ti-copy copy-button" data-clipboard-target="#password" style="cursor: pointer;"></i>
                            </p>
                            <a class="btn btn-primary d-grid w-100" href="{{url('/admin-login')}}">Go to admin panel</a>
                        @else
                            <h4 class="mb-1 pt-2">Verify Purchase Code</h4>
                            <small>Please enter purchase code receive from codecanyon license</small>
                            <p class="mb-4"></p>
                            <form id="formAuthentication" class="mb-3"  action="{{ route('license.verify') }}" method="POST" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="purchase_code" class="form-label">Purchase Code</label>
                                    <input
                                        type="text"
                                        id="purchase_code" 
                                        name="purchase_code"
                                        class="form-control @error('purchase_code') is-invalid @enderror" value="{{ old('purchase_code') }}" required autocomplete="purchase_code" autofocus
                                        placeholder="Enter purchase code"
                                    />
                                 <input type="hidden" name="base_url" value="{{ url('/') }}">
                                </div>
                                <button class="btn btn-primary d-grid w-100" type="submit">Verify</button>
                            </form>
                        @endif
                        
                    </div>
                    </div>
        <!-- /Login -->
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js')}} -->

  <script src="{{ asset('admin-assets/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/js/bootstrap.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/js/menu.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/libs/swiper/swiper.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/libs/toastr/toastr.js')}}"></script>
        <script src="{{ asset('admin-assets/js/main.js')}}"></script>
        <script src="{{ asset('admin-assets/js/dashboards-analytics.js')}}"></script>
        <script src="{{ asset('admin-assets/js/theme.js')}}"></script>
        <script src="{{ asset('admin-assets/js/custom.js')}}"></script>
        <script src="{{ asset('admin-assets/js/ui-toasts.js')}}"></script>
        
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
        <!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery (Required for Toastr) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


     @if(Session::has('error'))
            <script>
                toastr['error']('', "{{ session('error') }}");
            </script>
        @endif
        @if(Session::has('info'))
            <script>
                toastr['info']('', "{{ session('info') }}");
            </script>
        @endif
        @if(Session::has('warning'))
            <script>
                toastr['warning']('', "{{ session('warning') }}");
            </script>
        @endif
        @if(Session::has('success'))
        <script>
            $(document).ready(function() {
                $('#basicModal').modal('show');
            });
        </script>
        @endif
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var clipboard = new ClipboardJS('.copy-button');
                clipboard.on('success', function(e) {
                    e.clearSelection();
                    toastr['success']('', 'Copied to clipboard!');
                });
                clipboard.on('error', function(e) {
                    toastr['error']('', 'Copy failed. Please copy the text manually.');
                });
            });
        </script>
  </body>
</html>
