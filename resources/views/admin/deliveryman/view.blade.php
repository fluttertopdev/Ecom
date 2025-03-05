@extends('admin.layouts.app')
@section('content')
<style>
    .rating-overall {
        margin-top: 75px;
        display: flex;
        align-items: center;
        font-size: 3.5em;
        color: #7367f0;
    }
    .rating-overall span {
        font-size: 0.5em;
        color: #666;
        margin-left: 5px;
    }
    .rating-stars {
        margin-top: 10px;
        color: #7367f0;
    }
    .rating-stars i {
        font-size: 1.5em;
        color: #7367f0;
    }
    .rating-count {
        font-size: 0.9em;
        color: #666;
    }
    .rating-bars {
        margin-top: 20px;
    }
    .rating-bar {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .rating-bar-label {
        width: 100px;
    }
    .rating-bar-fill {
        width: 100%;
        height: 10px;
        background-color: #f1f1f1;
        margin: 0 10px;
        border-radius: 5px;
        position: relative;
    }
    .rating-bar-fill span {
        display: block;
        height: 100%;
        background-color: #7367f0;
        border-radius: 5px;
    }
    .rating-bar-count {
        width: 30px;
        text-align: right;
    }
    .view_deliveryman_img {
        height: 170px;
        width: 170px;
        border-radius: 10px;
   }
</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-8">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span><span class="text-muted fw-light">
                    <a href="{{url('admin/deliveryman')}}">{{__('lang.admin_deliveryman_list')}}</a> /
                  </span>
                  {{__('lang.admin_view_deliveryman_form')}}</h4>
            </div>
             <div class="col-md-4">
                <div class="table-btn-css">
                    <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/deliveryman')}}">{{__('lang.admin_back')}}</a>
                </div>
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
                                data-bs-target="#form-tabs-deliveryman-info"
                                role="tab"
                                aria-selected="true"
                                >
                                {{__('lang.admin_deliveryman_info')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-deliveryman-transaction"
                                role="tab"
                                aria-selected="false"
                                >
                                {{__('lang.admin_deliveryman_transaction')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-deliveryman-timelog"
                                role="tab"
                                aria-selected="false"
                                >
                                {{__('lang.admin_deliveryman_timelog')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-deliveryman-disbursement"
                                role="tab"
                                aria-selected="false"
                                >
                                {{__('lang.admin_deliveryman_disbursement')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-deliveryman-reviews"
                                role="tab"
                                aria-selected="false"
                                >
                                {{__('lang.admin_deliveryman_reviews')}}
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <!-- overview -->
                        <div class="tab-pane fade active show" id="form-tabs-deliveryman-info" role="tabpanel">
                            <div class="row g-3 mt-3">
                                <!-- boxes -->
                                <div class="row">
                                  <div class="col-md-12 row">
                                    <div class="col-sm-3 col-lg-3 mb-4">
                                        <div class="card card-border-shadow-danger">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                    <div class="avatar me-2">
                                                        <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-wallet ti-md"></i></span>
                                                    </div>
                                                    <h4 class="ms-1 mb-0">0</h4>
                                                </div>
                                                <p class="mb-1">{{__('lang.admin_total_delivered_orders')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-lg-3 mb-4">
                                        <div class="card card-border-shadow-info">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                    <div class="avatar me-2">
                                                        <span class="avatar-initial rounded bg-label-info"><i class="ti ti-wallet ti-md"></i></span>
                                                    </div>
                                                    <h4 class="ms-1 mb-0">0</h4>
                                                </div>
                                                <p class="mb-1">{{__('lang.admin_cash_in_hand')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-lg-3 mb-4">
                                        <div class="card card-border-shadow-warning">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                    <div class="avatar me-2">
                                                        <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-wallet ti-md"></i></span>
                                                    </div>
                                                    <h4 class="ms-1 mb-0">0</h4>
                                                </div>
                                                <p class="mb-1">{{__('lang.admin_total_earning')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-lg-3 mb-4">
                                        <div class="card card-border-shadow-secondary">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                    <div class="avatar me-2">
                                                        <span class="avatar-initial rounded bg-label-secondary"><i class="ti ti-wallet ti-md"></i></span>
                                                    </div>
                                                    <h4 class="ms-1 mb-0">0</h4>
                                                </div>
                                                <p class="mb-1">{{__('lang.admin_total_withdrawn')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- /boxes -->
                                 <!-- Deliveryman info -->
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="card-header">
                                                <h5 class="card-tile mb-0">{{__('lang.admin_deliveryman_info')}} <i class="menu-icon tf-icons ti ti-user"></i></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12 row">

                                                    <div class="col-md-12 mt-2">
                                                      <span class="d-inline-flex">{{__('lang.admin_deliveryman_id')}} : <h6 class="margin-left">#{{$result->id}}</h6></span>
                                                    </div> 

                                                    <div class="col-md-12 mt-2">
                                                      <span class="d-inline-flex">{{__('lang.admin_deliveryman_name')}} : <h6 class="margin-left"> {{$result->name}}</h6></span>
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                      <span class="d-inline-flex">{{__('lang.admin_deliveryman_email')}} : <h6 class="margin-left"> {{$result->email}}</h6></span>
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                      <span class="d-inline-flex">{{__('lang.admin_deliveryman_phone')}} : <h6 class="margin-left"> {{$result->phone}}</h6></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="col-md-12">
                                                <img class="view_deliveryman_img d-block mt-5" src="{{asset('/uploads/deliveryman/'.$result->image)}}">
                                            </div> 
                                        </div>
                                        <div class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="rating-box">
                                                    <div class="rating-overall">
                                                       2<span>/5</span>
                                                    </div>
                                                    <div class="rating-stars">
                                                                ★★★★
                                                        <span class="rating-count">2 Reviews</span>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <!-- end Deliveryman info -->
                                <!-- Identity Information -->
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-header">
                                               <h5 class="card-tile mb-0">{{__('lang.admin_identity_information')}} <i class="menu-icon tf-icons ti ti-id"></i></h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                  <span class="d-inline-flex">{{__('lang.admin_vehicle_type')}} : <h6 class="margin-left"> {{$result->vehicle_type}}</h6></span>
                                                </div>

                                                <div class="col-md-12">
                                                  <span class="d-inline-flex">{{__('lang.admin_identity_type')}} : <h6 class="margin-left">{{$result->identity_type}}</h6></span>
                                                </div> 

                                                <div class="col-md-12">
                                                  <span class="d-inline-flex">{{__('lang.admin_identity_number')}} : <h6 class="margin-left"> {{$result->identity_number}}</h6></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <img class="view_res_idenity_img d-block mt-3" src="{{asset('/uploads/identity_front_image/'.$result->identity_front_image)}}">
                                        </div>
                                        <div class="col-md-3">
                                            <img class="view_res_idenity_img d-block mt-3" src="{{asset('/uploads/identity_back_image/'.$result->identity_back_image)}}">
                                        </div>
                                    </div>
                                </div>
                                <!-- end  Identity Information -->
                            </div>         
                        </div>
                        <!-- deliveryman-transaction -->
                        <div class="tab-pane fade" id="form-tabs-deliveryman-transaction" role="tabpanel">
                            <div class="row g-3">
                                <div class="card-body">
                                    <form method="get">
                                           <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <input type="text" class="form-control flatpickr-input active" placeholder="YYYY-MM-DD" id="flatpickr-date" readonly="readonly" value="@if(isset($_GET['date']) && $_GET['date']!=''){{$_GET['date']}}@endif">
                                                </div>
                                                <div class="col-sm-3 display-inline-block">
                                                    <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                                                    <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/deliveryman')}}">{{__('lang.admin_reset')}}</a>
                                                </div>
                                            </div>
                                        </form>
                                    <div class="table-responsive text-nowrap mt-4">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr class="text-nowrap">
                                                    <th>{{__('lang.admin_id')}}</th>
                                                    <th>{{__('lang.admin_order_id')}}</th>
                                                    <th>{{__('lang.admin_delivery_fee_earned')}}</th>
                                                    <th>{{__('lang.admin_date')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="record-not-found">
                                                        <span>{{__('lang.admin_no_data_found')}}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
                        </div>
                        <!--deliveryman-timelog -->
                        <div class="tab-pane fade" id="form-tabs-deliveryman-timelog" role="tabpanel">
                            <div class="row g-3">
                                <div class="card-body">
                                    <form method="get">
                                       <div class="row">
                                            <div class="form-group col-sm-3">
                                                <input type="text" class="form-control flatpickr-input active" placeholder="YYYY-MM-DD" id="flatpickr-date" readonly="readonly" value="@if(isset($_GET['from_date']) && $_GET['from_date']!=''){{$_GET['from_date']}}@endif">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <input type="text" class="form-control flatpickr-input active" placeholder="YYYY-MM-DD" id="flatpickr-date" readonly="readonly" value="@if(isset($_GET['to_date']) && $_GET['to_date']!=''){{$_GET['to_date']}}@endif">
                                            </div>
                                            <div class="col-sm-3 display-inline-block">
                                                <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                                                <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/deliveryman')}}">{{__('lang.admin_reset')}}</a>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive text-nowrap mt-4">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr class="text-nowrap">
                                                    <th>{{__('lang.admin_id')}}</th>
                                                    <th>{{__('lang.admin_shift')}}</th>
                                                    <th>{{__('lang.admin_date')}}</th>
                                                    <th>{{__('lang.admin_active_time')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="record-not-found">
                                                        <span>{{__('lang.admin_no_data_found')}}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <!--deliveryman-disbursement -->
                        <div class="tab-pane fade" id="form-tabs-deliveryman-disbursement" role="tabpanel">
                            <div class="row g-3">
                                <div class="card-body">
                                    <form method="get">
                                       <div class="row">
                                            <div class="form-group col-sm-3">
                                                <input type="text" class="form-control" placeholder="{{__('lang.admin_search_by_disbursement_id')}}" value="@if(isset($_GET['disbursement_id']) && $_GET['disbursement_id']!=''){{$_GET['disbursement_id']}}@endif">
                                            </div>
                                            <div class="col-sm-3 display-inline-block">
                                                <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                                                <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/deliveryman')}}">{{__('lang.admin_reset')}}</a>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive text-nowrap mt-4">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr class="text-nowrap">
                                                    <th>{{__('lang.admin_id')}}</th>
                                                    <th>{{__('lang.admin_disburse_amount')}}</th>
                                                    <th>{{__('lang.admin_payment_method')}}</th>
                                                    <th>{{__('lang.admin_status')}}</th>
                                                    <th>{{__('lang.admin_action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="record-not-found">
                                                        <span>{{__('lang.admin_no_data_found')}}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
                        </div>
                        <!--deliveryman-reviews -->
                        <div class="tab-pane fade" id="form-tabs-deliveryman-reviews" role="tabpanel">
                            <div class="row g-3">
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr class="text-nowrap">
                                                    <th>{{__('lang.admin_sl')}}</th>
                                                    <th>{{__('lang.admin_order_id')}}</th>
                                                    <th>{{__('lang.admin_name')}}</th>
                                                    <th>{{__('lang.admin_reviewer_info')}}</th>
                                                    <th>{{__('lang.admin_reviewer_review')}}</th>
                                                    <th>{{__('lang.admin_date')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($deliverymanReviews) > 0)
                                                @foreach($deliverymanReviews as $review)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td> 
                                                        <td>{{ $review->order->order_unique_id }}</td>
                                                         <td>{{ $review->deliveryman->name }}</td>
                                                        <td>
                                                            {{ $review->user->name }} <br>
                                                            Rating: {{ $review->star_rating }}/5
                                                        </td>
                                                        <td>{{ \Helpers::getReviewLimit($review->review) }}</td>
                                                        <td>{{ \Helpers::commonDateFormateWithTime($review->created_at) }}</td>
                                                    </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="10" class="record-not-found">
                                                        <span>{{__('lang.admin_no_data_found')}}</span>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
