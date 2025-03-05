@extends('sellers.layouts.app')
@section('content')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container-xxl flex-grow-1 container-p-y">
    
    
    <div class="row">
        <div class="col-md-12">
            <h4 class="py-3 mb-4">
              <span class="text-muted fw-light">
                <a href="{{url('seller-dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
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
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-company-settings"
                            role="tab"
                            aria-selected="true"
                            >
                            Shop 
                            </button>
                        </li>
                       
                          <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#taxinfo_settings"
                            role="tab"
                            aria-selected="false"
                            >
                            Tax Info
                            </button>
                        </li>

                          <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#Bankinfo"
                            role="tab"
                            aria-selected="false"
                            >
                            Bank Info
                            </button>
                        </li>
                    
                    </ul>
                </div>
                
                <div class="tab-content">
                    <!-- company settings -->
                    <div class="tab-pane fade" id="form-tabs-company-settings" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('seller-update-setting')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @include('sellers/setting/company_settings')
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('seller-dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form> 
                    </div>

                    <div class="tab-pane fade" id="taxinfo_settings" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('seller-update-taxinfo')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @include('sellers/setting/taxinfo_settings')
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('seller-dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form> 
                    </div>

                    <div class="tab-pane fade" id="Bankinfo" role="tabpanel">
                        <form method="POST" id="update-record" action="{{url('seller-update-bankinfo')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @include('sellers/setting/bankinfo')
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1">{{__('lang.admin_button_save_changes')}}</button>
                                    <a href="{!! url('seller-dashboard') !!}" class="btn btn-outline-secondary">{{__('lang.admin_button_back')}}</a>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Show default tab (Company Settings) on page load
    $(document).ready(function() {
        // Add 'active' class to the first tab and its content on load
        $('.nav-tabs .nav-item:first-child .nav-link').addClass('active');
        $('.tab-content .tab-pane:first-child').addClass('active show');
        
        // On tab click, remove active class from all tabs and content, then add to the clicked one
        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $('.tab-pane').removeClass('active show');
            
            $(this).addClass('active');
            var target = $(this).data('bs-target');
            $(target).addClass('active show');
        });
    });
</script>

@endsection