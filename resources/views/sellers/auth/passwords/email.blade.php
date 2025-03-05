@extends('layouts.auth.default')

@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v2">
                <div class="auth-inner row m-0">
                    <a class="brand-logo" href="#">
                        <h2 class="brand-text text-primary ms-1">
                            <img src="{{asset('app-assets/images/logo.png')}}" style="width: 80px;">
                        </h2>
                    </a>
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{asset('app-assets/images/pages/login-v2.svg')}}" alt="Login V2" /></div>
                    </div>

                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1">{{__('lang.admin_forgot_password_text')}}</h2>
                            <p class="card-text mb-2">{{__('lang.admin_forgot_password_text2')}}</p>
                            @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert" style="padding: 15px;">
                              {{ Session::get('error') }}
                            </div>
                            @endif
                            <form class="auth-login-form mt-2" action="{{ url('/email-verification-for-password') }}" method="GET">
                                {!! csrf_field() !!}
                                <div class="mb-1">
                                    <label class="form-label" for="login-email">{{__('lang.admin_email')}}</label>
                                    <input class="form-control" id="login-email" type="text" name="email" placeholder="john@example.com" aria-describedby="login-email" autofocus="" tabindex="1" required />
                                </div>
                                <button name="submit" value="submit" type="submit" class="btn btn-primary w-100 mt-2" tabindex="4">{{__('lang.admin_button_forgot')}}</button>
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password"></label>
                                    <a href="{{url('/admin-login')}}">
                                      <small> ⬅ {{__('lang.admin_back_to_login')}}</small>
                                </a>
                                </div>
                            </form>
                        </div>
                    </div>

                   </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
