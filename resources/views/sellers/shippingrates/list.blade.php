@extends('sellers.layouts.app')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-6">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span>
                  Shipping Rate Modes</h4>
            </div>
         
           
            
        </div>



        
        <!-- Bordered Table -->
        @include('sellers/shippingrates/table')
        <!--/ Bordered Table -->

       

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection

