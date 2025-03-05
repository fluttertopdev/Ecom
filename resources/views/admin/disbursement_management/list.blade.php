@extends('admin.layouts.app')
@section('content')

<style type="text/css">
    
</style>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span>
                  Seller Disbursement</h4>
            </div>
        </div>

        

        <!-- Bordered Table -->
        @include('admin/disbursement_management/table')
        <!--/ Bordered Table -->

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<!-- Modal -->
<div class="modal fade" id="informationRestaurantWithdrawReqModal" tabindex="-1" aria-labelledby="margin: 0px auto;" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content modal-inner-html-restaurant-withdrawl-req">
        
    </div>
  </div>
</div>

@endsection


