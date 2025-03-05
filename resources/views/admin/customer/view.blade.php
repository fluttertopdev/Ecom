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
                  </span><span class="text-muted fw-light">
                    <a href="{{url('admin/customer')}}">{{__('lang.admin_customer_list')}}</a> /
                  </span>
                  {{__('lang.admin_view_customer_form')}}</h4>
            </div>
             <div class="col-md-6">
                <div class="table-btn-css">
                    <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/customer')}}">{{__('lang.admin_back')}}</a>
                </div>
            </div>
        </div>  

        <!-- boxes -->
        <div class="row">
              <!-- box-1 -->
              <div class="col-md-12 row">
                  <div class="col-sm-6 col-lg-6 mb-4">
                    <a href="{{ url('admin/wallet?customer_id=' . Request::segment(3)) }}">
                    <div class="card card-border-shadow-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-wallet ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">{{$finalAmount}}</h4>
                            </div>
                            <p class="mb-1">{{__('lang.admin_customer_wallet_balance')}}</p>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-6 mb-4">
                    <div class="card card-border-shadow-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-info"><i class="ti ti-shopping-cart ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">0</h4>
                            </div>
                            <p class="mb-1">{{__('lang.admin_total_order')}}</p>
                        </div>
                    </div>
                </div>
              </div>
              <!-- / box-1 -->
        </div>
        <!-- /boxes -->


        <!-- Cus info -->
        <div class="row">
            <!-- Basic Information -->
            <div class="col-4 col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">{{__('lang.admin_customer_info')}} <i class="menu-icon tf-icons ti ti-user"></i></h5>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-12 row">

                            <div class="col-md-12 mt-2">
                              <span class="d-inline-flex">{{__('lang.admin_customer_id')}} : <h6 class="margin-left">#{{$customerData->id}}</h6></span>
                            </div>

                            <div class="col-md-12 mt-2">
                               <span class="d-inline-flex">{{__('lang.admin_customer_name')}} : <h6 class="margin-left"> {{$customerData->name}}</h6></span>
                            </div>

                            <div class="col-md-12 mt-2">
                              <span class="d-inline-flex">{{__('lang.admin_customer_email')}} : <h6 class="margin-left"> {{$customerData->email}}</h6></span>
                            </div>

                            <div class="col-md-12 mt-2">
                              <span class="d-inline-flex">{{__('lang.admin_customer_phone')}} : <h6 class="margin-left"> {{$customerData->phone}}</h6></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Basic Information -->
            <!-- Table -->
            <div class="col-8 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{__('lang.admin_order_list')}}</h5>
                            </div>
                            <div class="col-md-6">
                                <h6 class="float-right">
                                    <?php if ($result->firstItem() != null) {?>
                                    {{__('lang.admin_showing')}} {{ $result->firstItem() }}-{{ $result->lastItem() }}
                                    {{__('lang.admin_of')}} {{ $result->total() }} <?php }?>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead class="table-light">
                                    <tr class="text-nowrap">
                                        <th>{{__('lang.admin_id')}}</th>
                                        <th>{{__('lang.admin_order_id')}}</th>
                                        <th>{{__('lang.admin_deliveryman_name')}}</th>
                                        <th>{{__('lang.admin_restaurant')}}</th>
                                        <th>{{__('lang.admin_order_date')}}</th>
                                        <th>{{__('lang.admin_total_items')}}</th>
                                        <th>{{__('lang.admin_total_amount')}}</th>
                                        <th>{{__('lang.admin_status')}}</th>
                                        <th>{{__('lang.admin_action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($result) > 0)
                                    @foreach($result as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->order_unique_id}}</td>
                                        <td>{{ \Helpers::checkAssignDeliveryMan($row->deliveryman_id) }}</td>
                                        <td>{{$row->restaurant->name}}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-medium">
                                                    {{ \Helpers::commonDateFormate($row->created_at) }}
                                                    </p>
                                                    <small class="text-muted text-nowrap">
                                                    {{ \Helpers::commonTimeFormate($row->created_at) }}
                                                    </small>
                                            </div>
                                        </td>
                                         <td>{{count($row->orderItems)}}</td>
                                        <td>{{ \Helpers::getPriceFormate($row->final_amount) }} {{ $row->final_amount }}</td>
                                        <td>
                                            @if($row->status == 'Confirmed')
                                                <a><span class="badge bg-success">{{$row->status}}</span></a>
                                            @elseif($row->status == 'Processing')
                                                <a><span class="badge bg-info">{{$row->status}}</span></a>
                                            @elseif($row->status == 'Out For Delivery')
                                                <a><span class="badge bg-primary">{{$row->status}}</span></a>
                                            @elseif($row->status == 'Delivered')
                                                <a><span class="badge bg-secondary">{{$row->status}}</span></a>
                                            @elseif($row->status == 'Failed')
                                                <a><span class="badge bg-danger">{{$row->status}}</span></a>
                                            @elseif($row->status == 'Cancelled')
                                                <a><span class="badge bg-dark">{{$row->status}}</span></a>
                                            @elseif($row->status == 'Refund Request')
                                                <a><span class="badge bg-secondary">{{$row->status}}</span></a>
                                            @elseif($row->status == 'Refunded')
                                                <a><span class="badge bg-secondary">{{$row->status}}</span></a>
                                            @else
                                                <a><span class="badge bg-warning">{{$row->status}}</span></a>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="inline_action_btn">
                                                <a class="edit_icon" href="{{url('admin/order-details/'.$row->id)}}" title="{{__('lang.admin_view')}}"><i class="ti ti-eye me-1"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7" class="record-not-found">
                                            <span>{{__('lang.admin_no_data_found')}}</span>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="pagination" style="float: right;">
                            {{$result->withQueryString()->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Table -->
        </div>
      <!-- end Cus info -->


    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
