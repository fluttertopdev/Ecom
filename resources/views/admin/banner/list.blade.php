@extends('admin.layouts.app')
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
                Main  Banner List</h4>
            </div>
       
            <div class="col-md-6">
                <div class="table-btn-css">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="offcanvas"
                        data-bs-target="#add-new-record" aria-controls="add-new-record">
                        <span class="ti-xs ti ti-plus me-1"></span>Add New
                    </button>
                </div>
            </div>
        
        </div>

      

        <!-- Bordered Table -->
        @include('admin/banner/table')
        <!--/ Bordered Table -->

        <!-- Modal to add new record -->
        @include('admin/banner/add_modal')
        <!--/ Modal to add new record -->

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
