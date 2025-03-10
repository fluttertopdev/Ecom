@extends('website.layout.app')
@section('content')



<main class="main">
  <section class="section-box shop-template mt-60">
    <div class="container">
      <div class="row mb-100">

        <div class="col-lg-1"></div>
        <div class="col-lg-5">
          <h3>{{__('lang.Create_an_account')}}</h3>
          @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
          @endif


          <div class="form-register mt-30 mb-30">
            <!-- Name Field -->
            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">{{__('lang.Full_Name')}}*</label>
              <input class="form-control name" name="name" type="text" placeholder="{{__('lang.Full_Name')}}" value="">

              <div class="text-danger "></div>

            </div>

            <!-- Email Field -->
            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">{{__('lang.Email')}}*</label>
              <input class="form-control email" name="email" type="text" placeholder="{{__('lang.Email')}}" value="">

              <div class="text-danger"></div>

            </div>

            <!-- Phone Field -->
            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">{{__('lang.Phone')}}*</label>
              <input class="form-control mobile" name="phone" type="text" placeholder="{{__('lang.Phone')}}" value="">
              <div class="text-danger"></div>
            </div>

            <!-- Country Field -->
            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">{{__('lang.Country')}}*</label>
              <select id="category-select" class="form-control font-sm select-style1 color-gray-700 country" name="country">
                <option value="">{{__('lang.Select_Country')}}</option>
                @foreach($country_data as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
              </select>

              <div class="text-danger"></div>

            </div>

            <!-- State Field -->
            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">{{__('lang.State')}}*</label>

              <select id="State-select" name="state" value="" class="form-control font-sm select-style1 color-gray-700 state" data-placeholder="">
                <option value="">{{__('lang.Select_state')}}</option>

              </select>

              <div class="text-danger"></div>

            </div>

            <!-- City Field -->


            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">{{__('lang.City')}}*</label>

              <select id="city-select" name="city" value="" class="form-control font-sm select-style1 color-gray-700 city" data-placeholder="">
                <option value="">{{__('lang.Select_city')}}</option>

              </select>

              <div class="text-danger"></div>

            </div>
            <input class="role_id" type="hidden" value="9" name="role_id">
            <!-- Password Field -->


            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">{{__('lang.Password')}}*</label>
              <input class="form-control password" name="password" type="password" placeholder="{{__('lang.Password')}}" value="">
              <div class="text-danger"></div>
            </div>

            <!-- Password Confirmation Field -->


            <div class="form-group">
              <label class="mb-5 font-sm color-gray-700">{{__('lang.Re-Password')}}*</label>
              <input class="form-control password_confirmation" name="password_confirmation" type="password" placeholder="{{__('lang.Re-Password')}}" value="">
              <div class="text-danger"></div>
            </div>

            <!-- Checkbox -->
            <div class="form-group">
              <label>
                <input style="margin-right: 2px;" class="terms_and_policy" name="terms_and_policy" type="checkbox">{{__('lang.By_clicking')}} <a href="{{url('seller-term-and-condition')}}">{{__('lang.terms_and_policy')}}</a>
                <div class="text-danger"></div>
              </label>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
              <input class="font-md-bold btn btn-buy submitseller" type="button" value="{{__('lang.SignUp')}}">
            </div>
          </div>



          <div class="mt-20"><span class="font-xs color-gray-500 font-medium">{{__('lang.Already_have_account')}}</span><a class="font-xs color-brand-3 font-medium" href="{{url('seller-login')}}">{{__('lang.SignIn')}}</a></div>
        </div>

      </div>

    </div>
    </div>
  </section>

</main>

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(document).on('click', '.submitseller', function(e) {
    e.preventDefault();

    // Clear previous errors
    $('.text-danger').html('');

    // Gather form data
    var name = $('.name').val();
    var email = $('.email').val();
    var mobile = $('.mobile').val();
    var country = $('.country').val();
    var state = $('.state').val();
    var city = $('.city').val();
    var password = $('.password').val();
    var role_id = $('.role_id').val();
    var password_confirmation = $('.password_confirmation').val();
    var terms_and_policy = $('.terms_and_policy').is(':checked');

    // Client-side validation
    var isValid = true;

    // Validate Full Name
    if (name == '') {
      $('.name').next('.text-danger').html('Full Name is required.');
      isValid = false;
    }

    // Validate Email
    if (email == '') {
      $('.email').closest('.form-group').find('.text-danger').html('Email is required.');
      isValid = false;
    } else if (!validateEmail(email)) {
      $('.email').closest('.form-group').find('.text-danger').html('Please enter a valid email address.');
      isValid = false;
    }

    // Validate Mobile
    if (mobile == '') {
      $('.mobile').next('.text-danger').html('Mobile is required.');
      isValid = false;
    }

    // Validate Country
    if (country == '') {
      $('.country').next('.text-danger').html('Country is required.');
      isValid = false;
    }

    // Validate State
    if (state == '') {
      $('.state').next('.text-danger').html('State is required.');
      isValid = false;
    }

    // Validate City
    if (city == '') {
      $('.city').next('.text-danger').html('City is required.');
      isValid = false;
    }

    // Validate Password
    if (password == '') {
      $('.password').next('.text-danger').html('Password is required.');
      isValid = false;
    }

    // Validate Confirm Password
    if (password_confirmation == '') {
      $('.password_confirmation').next('.text-danger').html('Re-Password is required.');
      isValid = false;
    } else if (password !== password_confirmation) {
      $('.password_confirmation').next('.text-danger').html('Passwords do not match.');
      isValid = false;
    }

    // Validate Terms and Policy
    if (!terms_and_policy) {
      $('.terms_and_policy').closest('.form-group').find('.text-danger').html('You must agree to the terms and conditions.');
      isValid = false;
    }

    // If there are any validation errors, stop the form submission
    if (!isValid) return;

    // Proceed with AJAX if no validation errors
    $.ajax({
      url: "{{ url('store-sellers') }}",
      type: "POST",
      dataType: "JSON",
      data: {
        name: name,
        mobile: mobile,
        email: email,
        country: country,
        state: state,
        city: city,
        role_id: role_id,
        password: password,
        password_confirmation: password_confirmation,
        terms_and_policy: terms_and_policy,
        _token: '{{ csrf_token() }}'
      },
      success: function(res) {
        if (res.type === 'success') {

          window.location.href = "{{ url('seller-login') }}";
        } else if (res.errors) {
          $.each(res.errors, function(field, message) {
            $('.' + field).next('.text-danger').html(message);
          });
        }
      },
      error: function(xhr) {
        // Handle server errors or network issues
        alert('Something went wrong. Please try again.');
      }
    });
  });

  // Email validation helper function
  function validateEmail(email) {
    var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return regex.test(email);
  }
</script>




@endsection
