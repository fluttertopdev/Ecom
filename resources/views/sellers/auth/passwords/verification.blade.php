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
                            <h2 class="card-title fw-bold mb-1">{{__('lang.admin_reset_password_text')}}</h2>
                            <p class="card-text mb-2">{{__('lang.admin_reset_password_text2')}}</p>
                            @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert" style="padding: 15px;">
                              {{ Session::get('error') }}
                            </div>
                             @endif
                            @if(Session::has('success'))
                            <div class="alert alert-success" role="alert" style="padding: 15px;">
                              {{ Session::get('success') }}
                            </div>
                            @endif
                            <form class="mt-2" action="{{ url('/do-admin-reset-password') }}" method="POST">
                                {!! csrf_field() !!}
                                <div class="mb-1">
                                    <label class="form-label" for="login-email">{{__('lang.admin_otp')}}</label>
                                    <input class="form-control" id="email" type="text" name="otp" placeholder="{{__('lang.admin_enter_otp')}}" aria-describedby="login-email" autofocus="" tabindex="1" autocomplete="off" required />
                                </div>

                               <input type="hidden" name="email" value="{{ isset($_GET['email']) ? $_GET['email'] : '' }}">


                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="login-password">{{__('lang.admin_password')}}</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge" id="login-password" type="password" name="password" placeholder="············" aria-describedby="password" tabindex="2" autocomplete="off" required /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>

                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="login-password">{{__('lang.admin_confirm_password')}}</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge" id="confirm-password" type="password" name="confirm-password" placeholder="············" aria-describedby="login-password" tabindex="2" autocomplete="off" required /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>

                                <button name="submit" value="submit" type="submit" class="btn btn-primary w-100 mt-2" tabindex="4">{{__('lang.admin_button_reset')}}</button>
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
