@extends('website.layout.app')
@section('content')



    <main class="main">
      <section class="section-box shop-template mt-60">
        <div class="container">
          <div class="row mb-100">
            <div class="col-lg-1"></div>
            <div class="col-lg-5">
              <h3>Reset Password</h3>
            <form action="{{url('douserresetpassword')}}" method="post" onsubmit="return validateForm(event)">
              @csrf
              
               <div class="form-group">
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


       
    </div>
              <div class="form-register mt-30 mb-30">
                <div class="form-group">
                  <label class="mb-5 font-sm color-gray-700">OTP*</label>
                  <input class="form-control" name="otp" type="text" placeholder="OTP" required>
                </div>
                 <div class="form-group">
      <label class="mb-5 font-sm color-gray-700">Password *</label>
      <input id="password" class="form-control" name="password" type="password" placeholder="Password" required>
      <small id="passwordError" style="color: red; display: none;">Password must be at least 8 characters long.</small>
    </div>
                
               <div class="form-group">
      <label class="mb-5 font-sm color-gray-700">Confirm Password *</label>
      <input id="confirmPassword" class="form-control" name="cpassword" type="password" placeholder="Confirm Password" required>
      <small id="confirmPasswordError" style="color: red; display: none;">Passwords do not match.</small>
    </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      
                    </div>
                  </div>
               
                </div>
                <div class="form-group">
                  <input class="font-md-bold btn btn-buy" type="submit" value="Submit">
                </div>
                </form>
              
              </div>
            </div>

            <div class="col-lg-5"></div>
          </div>
        </div>
      </section>
     
    </main>

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
@endsection
