@extends('admin.layouts.app')
@section('content')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="row">
        <div class="col-md-12">
            <h4 class="py-3 mb-4">
              <span class="text-muted fw-light">
                <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
              </span>
              <span class="text-muted fw-light">
                {{__('lang.admin_setting')}}
              </span>
            </h4>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="card mb-3">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-company-settings"
                            role="tab"
                            aria-selected="true"
                            >
                            {{__('lang.admin_company_setting')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link @if(Request::is('admin/settings/payment-method*')) active @endif"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-payment-methods"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_payment_method')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link @if(Request::is('admin/settings/push-notification-setting*')) active @endif"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-push-notification"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_push_notification')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link @if(Request::is('admin/settings/email-setting*')) active @endif"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-email-settings"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_email')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link @if(Request::is('admin/settings/sms-setting*')) active @endif"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-sms-settings"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_sms')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link @if(Request::is('admin/settings/map-setting*')) active @endif"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-map-settings"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_google_map')}}
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link @if(Request::is('admin/settings/maintainance-setting*')) active @endif"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-maintainance-settings"
                            role="tab"
                            aria-selected="false"
                            >
                            {{__('lang.admin_maintainance_mode')}}
                            </button>
                        </li>

                         <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link @if(Request::is('admin/settings/map-setting*')) active @endif"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-tax-settings"
                            role="tab"
                            aria-selected="false"
                            >
                            Tax Setting
                            </button>
                        </li>
                           <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link @if(Request::is('admin/settings/map-setting*')) active @endif"
                            data-bs-toggle="tab"
                            data-bs-target="#RefundSetting"
                            role="tab"
                            aria-selected="false"
                            >
                            Refund Setting
                            </button>
                        </li>

                           <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#SocailmediaSetting"
                            role="tab"
                            aria-selected="false"
                            >
                            Social Media
                            </button>
                        </li>
                        
                             <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#headlineSetting"
                            role="tab"
                            aria-selected="false"
                            >
                            Headline
                            </button>
                        </li>



                             <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#orderSetting"
                            role="tab"
                            aria-selected="false"
                            >
                            Order Setting
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="tab-content">
                    <!-- company settings -->
                    <div class="tab-pane fade active show" id="form-tabs-company-settings" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="company-setting">
                            @csrf
                            <div class="row">
                                @include('admin/setting/company_settings')
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>                    
                    </div>
                    <!-- payment method -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/payment-method*')) active show @endif" id="form-tabs-payment-methods" role="tabpanel">
                        @include('admin/setting/payment_method')                   
                    </div>
                    <!-- push notifications -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/push-notification-setting*')) active show @endif" id="form-tabs-push-notification" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="push-notification-setting">
                            @csrf
                            <div class="row">
                            @foreach($result as $row)
                                @include('admin/setting/push_notification_settings')
                            @endforeach
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- email settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/email-setting*')) active show @endif" id="form-tabs-email-settings" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="email-setting">
                            @csrf
                            <div class="row">
                            @foreach($result as $row)
                                @include('admin/setting/email_settings')
                            @endforeach 
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- sms settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/sms-setting*')) active show @endif" id="form-tabs-sms-settings" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="sms-setting">
                            @csrf
                            <div class="row">
                            @foreach($result as $row)
                                @include('admin/setting/sms_settings')
                            @endforeach 
                            </div>
                            <div class="row  mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                        <script>
                            // Wait for the document to be ready
                            $(document).ready(function () {
                                // Handle the click event for is_enable_twilio checkbox
                                $('input[name="is_enable_twilio"]').click(function () {
                                    // If is_enable_twilio is checked, uncheck is_enable_msg91
                                    if ($(this).prop('checked')) {
                                        $('input[name="is_enable_msg91"]').prop('checked', false);
                                    }
                                });

                                // Handle the click event for is_enable_msg91 checkbox
                                $('input[name="is_enable_msg91"]').click(function () {
                                    // If is_enable_msg91 is checked, uncheck is_enable_twilio
                                    if ($(this).prop('checked')) {
                                        $('input[name="is_enable_twilio"]').prop('checked', false);
                                    }
                                });
                            });
                        </script>
                    </div>
                    <!-- map settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/map-setting*')) active show @endif" id="form-tabs-map-settings" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="map-setting">
                            @csrf
                            <div class="row">
                            @foreach($result as $row)
                                @include('admin/setting/map_settings')
                            @endforeach 
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- maintainance settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/maintainance-setting*')) active show @endif" id="form-tabs-maintainance-settings" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="maintainance-setting">
                            @csrf
                            <div class="row">
                            @foreach($result as $row)
                                @include('admin/setting/maintainance_settings')
                            @endforeach 
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>

                     <!-- tax settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/tax-setting*')) active show @endif" id="form-tabs-tax-settings" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="tax-setting">
                            @csrf
                            <div class="row">
                            @foreach($result as $row)
                                @include('admin/setting/taxsetting')
                            @endforeach 
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>

                      <!-- refund settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/tax-setting*')) active show @endif" id="RefundSetting" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="refund-setting">
                            @csrf
                            <div class="row">
                            @foreach($result as $row)
                                @include('admin/setting/refundsetting')
                            @endforeach 
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                      
                           <!-- Socail media settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/tax-setting*')) active show @endif" id="SocailmediaSetting" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="page_name" value="social-media">
                            @csrf
                            <div class="row">
                            @foreach($result as $row)
                                @include('admin/setting/socialMedia')
                            @endforeach 
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    
                              <!-- Socail media settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/tax-setting*')) active show @endif" id="headlineSetting" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/store-heading')}}" method="POST" enctype="multipart/form-data">
                         
                            @csrf
                            <div class="row">
                          
                                @include('admin/setting/headlineSetting')
                         
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>


                                  <!-- order settings -->
                    <div class="tab-pane fade @if(Request::is('admin/settings/tax-setting*')) active show @endif" id="orderSetting" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('admin/update-setting')}}" method="POST" >
                         
                            @csrf
                            <div class="row">
                          
                                @include('admin/setting/ordersetting')
                         
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('admin/dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>



                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection