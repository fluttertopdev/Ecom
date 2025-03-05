
<div class="row">
    <!-- Razorpay -->
   <div class="col-lg-6">
    <div class="card">
        <form class="form-horizontal" action="{{url('admin/update-setting')}}" method="POST">
            @csrf
            <div class="card-header row">
                <div class="col-lg-6">
                    <!-- Razorpay Logo -->
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTnA99TABOEvVDdjInRpcHjvKZIhgCnv0z9zg&s" 
                         alt="Razorpay" 
                         class="mb-4" 
                         style="height: 50px;">
                   
                </div>
                <div class="col-lg-6">
                    <label class="switch switch-success float-right toggle_payment">
                        <input type="checkbox" class="switch-input" name="enable_razorpay" value="1" {{ ($setting = $settings->where('key', 'enable_razorpay')->first()) ? $setting->value == 1 ? 'checked' : '' : '' }}>
                        <span class="switch-toggle-slider">
                            <span class="switch-on">
                                <i class="ti ti-check"></i>
                            </span>
                            <span class="switch-off">
                                <i class="ti ti-x"></i>
                            </span>
                        </span>
                    </label>
                </div>
            </div>
            <hr class="payment-hr">
            <div class="card-body">
                <input type="hidden" name="page_name" value="payment_methods">
                <input type="hidden" name="payment_method" value="razorpay">
                <div class="form-group row mt-3">
                    <div class="col-md-4">
                        <label class="col-from-label">{{__('lang.admin_razorpay_key')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="razorpay_key" value="{{ optional($settings->where('key', 'razorpay_key')->first())->value }}" placeholder="{{__('lang.admin_razorpay_key_placeholder')}}" required>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-md-4">
                        <label class="col-from-label">{{__('lang.admin_razorpay_secret')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="razorpay_secret" value="{{ optional($settings->where('key', 'razorpay_secret')->first())->value }}" placeholder="{{__('lang.admin_razorpay_secret_placeholder')}}" required>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{__('lang.admin_save')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>


    <!-- Stripe -->
    <div class="col-lg-6">
        <div class="card">
            <form class="form-horizontal" action="{{url('admin/update-setting')}}" method="POST">
                @csrf
                <div class="card-header row">
                    <div class="col-lg-6">
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoses6jAz57Kh6hOT2IgSP8hdxilB00L_WPQ&s" 
                         alt="Razorpay" 
                         class="mb-4" 
                         style="height: 50px;">
                    </div>
                    <div class="col-lg-6">
                        <label class="switch switch-success float-right toggle_payment">
                            <input type="checkbox" class="switch-input" name="enable_stripe" value="1" {{ ($setting = $settings->where('key', 'enable_stripe')->first()) ? $setting->value == 1 ? 'checked' : '' : '' }}>
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                        </label>
                    </div>
                </div>
                <hr class="payment-hr">
                <div class="card-body">
                    <input type="hidden" name="page_name" value="payment_methods">
                    <input type="hidden" name="payment_method" value="stripe">
                    <div class="form-group row mt-3">
                        <div class="col-md-4">
                            <label class="col-from-label">{{__('lang.admin_stripe_key')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="stripe_key" value="{{ optional($settings->where('key', 'stripe_key')->first())->value }}" placeholder="{{__('lang.admin_stripe_key_placeholder')}}" required>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-4">
                            <label class="col-from-label">{{__('lang.admin_stripe_secret_key')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="stripe_secret_key" value="{{ optional($settings->where('key', 'stripe_secret_key')->first())->value }}" placeholder="{{__('lang.admin_stripe_secret_key_placeholder')}}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{__('lang.admin_save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Paypal -->
    <div class="col-lg-6 mt-5">
        <div class="card">
            <form class="form-horizontal" action="{{url('admin/update-setting')}}" method="POST">
                @csrf
                <div class="card-header row">
                     <div class="col-lg-6">
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4QEq9pXmCxv8Jz3ho_j8vWjCAygMx07dy7w&s" 
                         alt="Razorpay" 
                         class="mb-4" 
                         style="height: 50px;">
                    </div>
                    <div class="col-lg-6">
                        <label class="switch switch-success float-right toggle_payment">
                            <input type="checkbox" class="switch-input" name="enable_paypal" value="1" {{ ($setting = $settings->where('key', 'enable_paypal')->first()) ? $setting->value == 1 ? 'checked' : '' : '' }}>
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                        </label>
                    </div>
                </div>
                <hr class="payment-hr">
                <div class="card-body">
                    <input type="hidden" name="page_name" value="payment_methods">
                    <input type="hidden" name="payment_method" value="paypal">
                    <div class="form-group row mt-3">
                        <div class="col-md-4">
                            <label class="col-from-label">{{__('lang.admin_paypal_client_id')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="paypal_client_id" value="{{ optional($settings->where('key', 'paypal_client_id')->first())->value }}" placeholder="{{__('lang.admin_paypal_client_id_placeholder')}}" required>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-4">
                            <label class="col-from-label">{{__('lang.admin_paypal_secret_key')}}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="paypal_secret_key" value="{{ optional($settings->where('key', 'paypal_secret_key')->first())->value }}" placeholder="{{__('lang.admin_paypal_secret_key_placeholder')}}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{__('lang.admin_save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- COD -->
    <div class="col-lg-6 mt-5">
        <div class="card">
            <form class="form-horizontal" action="{{url('admin/update-setting')}}" method="POST">
                @csrf
                <div class="card-header row">
                      <div class="col-lg-6">
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvylUhaBFmbMQQiuhKkBwAcg0wF43VTVEZag&s" 
                         alt="Razorpay" 
                         class="mb-4" 
                         style="height: 50px;">
                    </div>
                    <div class="col-lg-6">
                        <label class="switch switch-success float-right toggle_payment">
                            <input type="checkbox" class="switch-input" name="enable_cod" value="1" {{ ($setting = $settings->where('key', 'enable_cod')->first()) ? $setting->value == 1 ? 'checked' : '' : '' }}>
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                        </label>
                    </div>
                </div>
                <hr class="payment-hr">
                <div class="card-body">
                    <input type="hidden" name="page_name" value="payment_methods">
                    <input type="hidden" name="payment_method" value="cod">
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{__('lang.admin_save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>