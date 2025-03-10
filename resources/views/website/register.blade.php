@extends('website.layout.app')
@section('content')

<style>
    .position-relative {
        position: relative;
    }

    .eye-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
        font-size: 14px;
    }

    .eye-icon:hover {
        color: #333;
    }

    .form-control {
        padding-right: 2.5rem;
    }

    .form-group {
        margin-bottom: 20px;
        /* Equal spacing between input fields */
    }

    .btn-buy {
        display: block;
        width: 200px;
        margin: 0 auto;
        /* Centers the button */
    }

    @media (max-width: 768px) {
        .btn-buy {
            width: 100%;
            /* Make the button full width on mobile */
        }
    }
</style>
<main class="main">
    <section class="section-box shop-template">
        <div class="container mt-60">
            <div class="row mb-100">
                <div class="col-lg-1"></div>
                <div class="col-lg-12">
                    <h3>{{__('lang.Create_an_account')}}</h3>
                    <form action="{{ url('user-store') }}" method="post">
                        @csrf
                        <div class="form-register mt-30 mb-30">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="mb-5 font-sm color-gray-700">{{__('lang.Full_Name')}}*</label>
                                        <input
                                            class="form-control"
                                            name="name"
                                            type="text"
                                            placeholder="{{__('lang.Full_Name')}}"
                                            value="{{ old('name') }}">
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label class="mb-5 font-sm color-gray-700">{{__('lang.Email')}} *</label>
                                        <input
                                            class="form-control"
                                            name="email"
                                            type="text"
                                            placeholder="{{__('lang.Email')}}"
                                            value="{{ old('email') }}">
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="mb-5 font-sm color-gray-700">{{__('lang.Phone')}}*</label>
                                        <input
                                            class="form-control"
                                            name="phone"
                                            type="text"
                                            placeholder="{{__('lang.Phone')}}"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="mb-5 font-sm color-gray-700">{{__('lang.Password')}}*</label>
                                        <div class="position-relative">
                                            <input
                                                class="form-control pr-5"
                                                name="password"
                                                type="password"
                                                value="{{ old('password') }}"
                                                placeholder="{{__('lang.Password')}}"
                                                id="password"
                                                autocomplete="off">
                                            <i
                                                id="togglePasswordIcon"
                                                class="fas fa-eye position-absolute eye-icon"
                                                onclick="togglePasswordVisibility('password', 'togglePasswordIcon')"></i>
                                        </div>
                                        @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="mb-5 font-sm color-gray-700">{{__('lang.Re-Password')}}*</label>
                                        <div class="position-relative">
                                            <input
                                                class="form-control pr-5"
                                                name="password_confirmation"
                                                type="password"
                                                placeholder="{{__('lang.Re-Password')}}"
                                                value="{{ old('password_confirmation') }}"
                                                id="password_confirmation"
                                                autocomplete="off">
                                            <i
                                                id="toggleRePasswordIcon"
                                                class="fas fa-eye position-absolute eye-icon"
                                                onclick="togglePasswordVisibility('password_confirmation', 'toggleRePasswordIcon')"></i>
                                        </div>
                                        @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end mt-4">
                                        <div class="form-group">
                                            <label>
                                                <input
                                                    class="checkagree"
                                                    name="terms_and_policy"
                                                    type="checkbox"
                                                    {{ old('terms_and_policy') ? 'checked' : '' }}>
                                                {{__('lang.By_clicking')}}
                                                <a href="{{ url('term-and-condition') }}">{{__('lang.terms_and_policy')}}</a>
                                            </label>
                                            @error('terms_and_policy')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-center mx-auto">
                                        <input class="font-md-bold btn btn-buy" type="submit" value="{{__('lang.SignUp')}}" style="width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="text-center">
                    <span class="font-xs color-gray-500 font-medium">{{__('lang.Already_have_account')}}</span>
                    <a class="font-xs color-brand-3 font-medium" href="{{url('login')}}">{{__('lang.SignIn')}}</a>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    function togglePasswordVisibility(inputId, iconId) {
        const inputField = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (inputField.type === "password") {
            inputField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            inputField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endsection
