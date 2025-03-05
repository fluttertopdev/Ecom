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
                  Sellers  Orders List</h4>
            </div>
           
        </div>

        <div class="card margin-bottom-20">
            <div class="card-header">
                <form method="get">
                    <div class="row">
                        <h5 class="card-title display-inline-block">{{__('lang.admin_filters')}}</h5>
                         <div class="form-group col-sm-3 display-inline-block">
                            <input type="text" class="form-control dt-full-name" placeholder="Order Code" name="order_key" value="@if(isset($_GET['order_key']) && $_GET['order_key']!=''){{$_GET['order_key']}}@endif">
                        </div>
                         <div class="col-sm-3 display-inline-block">
                            <select class="form-control select2 form-select" name="status">
                                <option value="">{{__('lang.admin_select_status')}}</option>
                                    @if(count($paymentstatus))
                                    @foreach($paymentstatus as $value => $label)
                                        <option value="{{$value}}" @if(isset($_GET['status']) && $_GET['status']!='') @if($_GET['status']==$value) selected @endif @endif>{{$label}}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                                    <div class="col-sm-3 display-inline-block">
                <select class="form-control select2 form-select" name="paymentmethod">
                <option value="">Payment Method</option>
                <option value="Cash" @if(isset($_GET['paymentmethod']) && $_GET['paymentmethod'] == 'Cash') selected @endif>Cash</option>
                <option value="razorpay" @if(isset($_GET['paymentmethod']) && $_GET['paymentmethod'] == 'razorpay') selected @endif>Razorpay</option>
                 <option value="paypal" @if(isset($_GET['paymentmethod']) && $_GET['paymentmethod'] == 'paypal') selected @endif>Paypal</option>
                  <option value="stripe" @if(isset($_GET['paymentmethod']) && $_GET['paymentmethod'] == 'stripe') selected @endif>Stripe</option>
            </select>
        </div>
                        <div class="col-sm-3 display-inline-block">
                            <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                            <a type="reset" class="btn btn-outline-secondary"
                                href="{{url('admin/sellers-orders')}}">{{__('lang.admin_reset')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bordered Table -->
        @include('admin/sellersorders/table')
        <!--/ Bordered Table -->

        

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
