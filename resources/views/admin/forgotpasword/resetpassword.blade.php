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

    <title>Forget Password</title>

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
    
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/pages/page-auth.css')}}"/>


<div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <!-- Login -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-4 mt-2">
                <a href="" class="app-brand-link gap-2">
                  <span class="app-brand-text demo text-body fw-bold ms-1">Reset Password</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1 pt-2">Reset Password 🔒
</h4>
              <p class="mb-4">Reset your password putting otp which is in your registered email</p>

              <form id="" class="mb-3" action="{{ url('/doresetpassword') }}" method="POST" onsubmit="return validateForm(event)">
              @csrf

          @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
                <div class="mb-3">
                  <label for="otp" class="form-label">OTP</label>
                    <input
                    type="text"
                    id=""
                 class="form-control" name="otp" value="" required 
                    placeholder="OTP"
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    
                  </div>
                  <div class="input-group input-group-merge">
                     <input
                      id="password" type="password" placeholder="password" class="form-control" name="password" required 
                    />

                   
                  
                  </div>
                   <small id="passwordError" style="color: red; display: none;">Password must be at least 8 characters long.</small>
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Confirm Password
</label>
                    
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      id="confirmPassword" type="text" placeholder="Confirm Password" class="form-control " name="cpassword" required 
                     
                    />
                 
                  </div>
                     <small id="confirmPasswordError" style="color: red; display: none;">Passwords do not match.</small>
                </div>
                <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Reset</button>
                </div>
              </form>
               
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>
    <script src="{{asset('/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('/assets/vendor/libs/node-waves/node-waves.js')}}"></script>
    <script src="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('/assets/vendor/libs/hammer/hammer.js')}}"></script>
    <script src="{{asset('/assets/vendor/libs/i18n/i18n.js')}}"></script>
    <script src="{{asset('/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{asset('/assets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('/assets/vendor/libs/@form-validation/popular.js')}}"></script>
    <script src="{{asset('/assets/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{asset('/assets/vendor/libs/@form-validation/auto-focus.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('/assets/js/pages-auth.js')}}"></script>

   


  </body>
</html>


<script>
  function validateForm(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    let isValid = true;

    // Check if password length is less than 8 characters
    if (password.length < 8) {
      document.getElementById('passwordError').style.display = 'block';
      isValid = false;
    } else {
      document.getElementById('passwordError').style.display = 'none';
    }

    // Check if password and confirm password match
    if (password !== confirmPassword) {
      document.getElementById('confirmPasswordError').style.display = 'block';
      isValid = false;
    } else {
      document.getElementById('confirmPasswordError').style.display = 'none';
    }

    // Prevent form submission if validation fails
    return isValid;
  }
</script>
