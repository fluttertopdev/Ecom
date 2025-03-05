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
                  Delivered  Orders List</h4>
            </div>
           
        </div>

        <div class="card margin-bottom-20">
            <div class="card-header">
                <form method="get">
                    <div class="row">
                        <h5 class="card-title display-inline-block">{{__('lang.admin_filters')}}</h5>
                        <div class="form-group col-sm-3 display-inline-block">
                            <input type="text" class="form-control dt-full-name" placeholder="Order Code" name="name" value="@if(isset($_GET['name']) && $_GET['name']!=''){{$_GET['name']}}@endif">
                        </div>
                         <div class="col-sm-3 display-inline-block">
                            <select class="form-control select2 form-select" name="status">
                                <option value="">{{__('lang.admin_select_status')}}</option>
                                <option value="">Pending</option>
                                <option value="">Confirmed</option>
                                <option value="">Picked-up</option>
                                <option value="">On the way</option>
                                <option value="">Delivered</option>    
                            </select>
                        </div>
                         <div class="col-sm-3 display-inline-block">
                            <select class="form-control select2 form-select" name="status">
                                <option value="">Payment Method</option>
                                <option value="">Cash</option>
                                <option value="">Online</option>
                                   
                            </select>
                        </div>
                        <div class="col-sm-3 display-inline-block">
                            <button type="button" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                            <a type="reset" class="btn btn-outline-secondary"
                                href="">{{__('lang.admin_reset')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bordered Table -->
        @include('admin/deliveredorders/table')
        <!--/ Bordered Table -->

        

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
