@extends('website.layout.app')
@section('content')







<main class="main">
    <section class="section-box shop-template mt-60">
        <div class="container">
            <div class="row mb-100 justify-content-center">
                <div class="col-lg-5">
                    <h3>Forgot Password</h3>
                    <form action="{{url('user-do-forget-password')}}" method="post">
                        @csrf
                       
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
                                <input class="font-md-bold btn btn-buy" type="submit" value="Submit">
                            </div>
                        </div>
                    </form>
                    <div class="mt-20">
                  
                  <a class="font-xs color-brand-3 font-medium" href="{{url('user-login')}}">Back to login</a></div>
                </div>

            

            </div>
        </div>
    </section>
</main>
@endsection
