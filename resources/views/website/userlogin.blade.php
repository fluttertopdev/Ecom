@extends('website.layout.app')
@section('content')

<main class="main">
    <section class="section-box shop-template mt-60">
        <div class="container">
            <div class="row mb-100 justify-content-center">
                <div class="col-lg-5">
                    <h3>{{ __('lang.UserLogin') }}</h3>
                    <form action="{{ url('check-email') }}" method="post">
                        @csrf
                        <!-- <p class="font-md color-gray-500">{{ __('lang.Welcomeback') }}</p> -->
                        <div class="form-group">
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                            @endif
                        </div>
                        <div class="form-register mt-30 mb-30">
                            <div class="form-group">
                                <label class="mb-5 font-sm color-gray-700">{{ __('lang.Email') }}*</label>
                                <input class="form-control" name="email" type="text" placeholder="{{ __('lang.Email') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-5 font-sm color-gray-700">{{ __('lang.Password') }}*</label>
                                <input class="form-control" name="password" type="password" placeholder="{{ __('lang.Password') }}" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6 text-end">
                                    <div class="form-group">
                                        <a class="font-xs color-gray-500" href="{{ url('user-forgot-password') }}">{{ __('lang.Forgotyourpassword') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="font-md-bold btn btn-buy" type="submit" value="{{ __('lang.Login') }}">
                            </div>
                        </div>
                    </form>
                    <div class="mt-20">
                        <span class="font-xs color-gray-500 font-medium">{{ __('lang.Havenotanaccount') }}</span>
                        <a class="font-xs color-brand-3 font-medium" href="{{ url('signup') }}">&nbsp;{{ __('lang.SignUp') }}</a>
                    </div>
                </div>



            </div>
        </div>
    </section>
</main>

@endsection
