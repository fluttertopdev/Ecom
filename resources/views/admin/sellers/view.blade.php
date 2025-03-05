@extends('admin.layouts.app')
@section('content')
<?php
$Symbol = \Helpers::getActiveCurrencySymbol();
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-9">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span><span class="text-muted fw-light">
                    <a href="{{url('admin/all-seller')}}">Seller List</a> /
                  </span>
                  View Seller</h4>
            </div>
             <div class="col-md-3">
                <div class="table-btn-css">
                    <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/all-sellers')}}">{{__('lang.admin_back')}}</a>
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
                                data-bs-target="#form-tabs-overview"
                                role="tab"
                                aria-selected="true"
                                >
                                {{__('lang.admin_overview')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-food"
                                role="tab"
                                aria-selected="false"
                                >
                                Products
                                </button>
                            </li>
                           
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-order"
                                role="tab"
                                aria-selected="false"
                                >
                                {{__('lang.admin_orders')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-transaction"
                                role="tab"
                                aria-selected="false"
                                >
                                {{__('lang.admin_transactions')}}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                type="button"
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-reviews"
                                role="tab"
                                aria-selected="false"
                                >
                                {{__('lang.admin_reviews')}}
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <!-- overview -->
                        <div class="tab-pane fade active show" id="form-tabs-overview" role="tabpanel">
                            <div class="row g-3 mt-3">
                                <!-- boxes -->
                                  <div class="row">
                                     
                                      <div class="col-md-12 row">
                                          <div class="col-sm-26 col-lg-6 mb-4">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-2 pb-1">
                                                        <div class="avatar me-2">
                                                            <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-wallet ti-md"></i></span>
                                                        </div>
                                                        <h4 class="ms-1 mb-0"> {{$Symbol}}{{$pendingwithdraw}}</h4>
                                                    </div>
                                                    <p class="mb-1">{{__('lang.admin_pending_withdraw')}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-26 col-lg-6 mb-4">
                                            <div class="card card-border-shadow-danger">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-2 pb-1">
                                                        <div class="avatar me-2">
                                                            <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-wallet ti-md"></i></span>
                                                        </div>
                                                        <h4 class="ms-1 mb-0">{{$Symbol}}{{$confermwithdraw}}</h4>
                                                    </div>
                                                    <p class="mb-1">{{__('lang.admin_total_withdrawn_amount')}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-26 col-lg-6 mb-4">
                                            <div class="card card-border-shadow-info">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-2 pb-1">
                                                        <div class="avatar me-2">
                                                            <span class="avatar-initial rounded bg-label-info"><i class="ti ti-wallet ti-md"></i></span>
                                                        </div>
                                                        <h4 class="ms-1 mb-0">{{$Symbol}}{{$totalWithdrawable}}</h4>
                                                    </div>
                                                 


                                                    <p class="mb-1">Total Withdrawable Balance</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-26 col-lg-6 mb-4">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-2 pb-1">
                                                        <div class="avatar me-2">
                                                            <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-wallet ti-md"></i></span>
                                                        </div>
                                                        <h4 class="ms-1 mb-0">{{$Symbol}}{{$totalearning}}</h4>
                                                    </div>
                                                    <p class="mb-1">{{__('lang.admin_total_earning')}}</p>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                    
                                  </div>
                               
                                <div class="row mt-4">
                                    
                                    <div class="col-12 col-lg-6">
                                        <!-- Basic Information -->
                                        <div class="card mb-4">
                                          <div class="card-header">
                                            <h5 class="card-tile mb-0">Seller Details</h5>
                                          </div>
                                          <div class="card-body row">

                                            <div class="col-md-12 row">

                                                <div class="col-md-6 mb-2">
                                                       <img src="{{ url('uploads/sellers/'.$sellerdata->image)}}" class="view_res_pro_img" 
                                                        onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`">
                                                </div>

                                              <div class="col-md-12">

                                                <div class="mt-2">
                                                  <span class="d-inline-flex">Seller Name: <h6 class="margin-left">{{$sellerdata->name}}</h6></span>
                                                </div>

                                                <div class="mt-2">
                                                  <span class="d-inline-flex">Seller Phone : <h6 class="margin-left">{{$sellerdata->phone}}</h6></span>
                                                </div>

                                                <div class="mt-2">
                                                  <span class="d-inline-flex">Seller Email : <h6 class="margin-left">{{$sellerdata->email}}</h6></span>
                                                </div>

                                              </div>
                                            </div>


                                          </div>
                                        </div>
                                        <!-- /Basic Information -->
                                    </div>
                                    <!-- / column 2-->
                                </div>
                                <!-- end Res info -->
                            </div>                
                        </div>
                        <!-- food-->
                        <div class="tab-pane fade" id="form-tabs-food" role="tabpanel">
                            <div class="row g-3">
                                <div class="item-count row">
                                    <div class="col-md-4 all-items">
                                       <i class="fa-solid fa-shopping-cart item-icon mr-3"></i>
                                        <span>All Product</span> 
                                        <span class="ml-3">{{$allproduct}}</span>
                                    </div>
                                    <div class="col-md-4 active-items">
                                      <i class="fa-solid fa-shopping-cart item-icon mr-3"></i>
                                        <span>Active Product</span> 
                                        <span class="ml-3">{{$activeproduct}}</span>
                                    </div>
                                    <div class="col-md-4 inactive-items">
                                    <i class="fa-solid fa-shopping-cart item-icon mr-3"></i>
                                        <span>Inactive Product</span> <span class="ml-3">{{$deactiveproduct}}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr class="text-nowrap">
                                                    <th>{{__('lang.admin_id')}}</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Created At  </th>
                                                    <th>Category</th>
                                                    <th>Brand</th>
                                                    <th>Status</th>
                                                  
                                                   
                                                </tr>
                                 
                                            </thead>
<tbody>
    @if(count($result) > 0)
        @foreach($result as $row)
           @php
                    $activeVariant = $row->productVariants->where('status', '1')->first();
                    $productPrice = $activeVariant ? $activeVariant->price : $row->price;
                                         $imageArray = $activeVariant && $activeVariant->images ? explode(',', $activeVariant->images) : [];
    $firstImage = count($imageArray) > 0 ? $imageArray[0] : null;

    $productImage = $firstImage ? url('uploads/' . $firstImage) : url('uploads/product/' . $row->product_image);
                @endphp
            <tr>
                <td>{{$row->id}}</td>
                <td aria-colindex="2" role="cell" class="">
                    <span class="b-avatar mr-1 badge-secondary rounded-circle">
                         <span class="b-avatar-img">
                                    @if($productImage != '')
                                    <img src="{{ $productImage }}" width="100px" height="75px;" style="object-fit: contain;"  onerror="this.src='{{asset('uploads/no-image.png')}}';">
                                    @else
                                    <img src="{{asset('/admin-assets/images/no-image.png')}}">
                                    @endif
                                </span>
                    </span>
                </td>
                <td>{{$row->name}}</td>
             
                <td>{{$Symbol}}{{$productPrice}}</td>
                <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                <td>{{$row->category->name}}</td>
                <td>{{$row->brand->name}}</td>
            
                    <td>
                        @if($row->status == 1)
                            <a >
                                <span class="badge bg-success">{{__('lang.admin_active')}}</span>
                            </a>
                        @else
                            <a>
                                <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span>
                            </a>
                        @endif
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
                            </div>             
                        </div>

                        <!-- Order-->
                        <div class="tab-pane fade" id="form-tabs-order" role="tabpanel">
                            <!-- Boxes -->
                            <div class="row">
                                <!-- Total Order -->
                                <div class="col-lg-3 col-sm-6 mt-3">
                                  <div class="card card-border-shadow-warning h-100">
                                    <div class="card-body">
                                      <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                          <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-package ti-26px"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{$Symbol}}{{$total_order_count}}</h4>
                                      </div>
                                      <p class="mb-1">Total Order</p>
                                    </div>
                                  </div>
                                </div>
                                <!-- Total Order -->
                                <!-- Total Pending Order -->
                                <div class="col-lg-3 col-sm-6 mt-3">
                                  <div class="card card-border-shadow-primary h-100">
                                    <div class="card-body">
                                      <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                          <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-package ti-26px"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{$Symbol}}{{$pending_order_count}}</h4>
                                      </div>
                                      


                                      <p class="mb-1">Total Pending Order</p>
                                    </div>
                                  </div>
                                </div>
                                <!-- Total Pending Order -->
                                <!-- Total Delivered Order -->
                                <div class="col-lg-3 col-sm-6 mt-3">
                                  <div class="card card-border-shadow-success h-100">
                                    <div class="card-body">
                                      <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                          <span class="avatar-initial rounded bg-label-success"><i class="ti ti-package ti-26px"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{$Symbol}}{{$delivered_order_count}}</h4>
                                      </div>
                                      <p class="mb-1">Total Delivered Order</p>
                                    </div>
                                  </div>
                                </div>
                                <!-- Total Delivered Order -->
                                <!-- Total Order -->
                                <div class="col-lg-3 col-sm-6 mt-3">
                                  <div class="card card-border-shadow-danger h-100">
                                    <div class="card-body">
                                      <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                          <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-package ti-26px"></i></span>
                                        </div>
                                        <h4 class="mb-0">{{$Symbol}}{{$cancelled_order_count}}</h4>
                                      </div>
                                      <p class="mb-1">Total Cancelled Orders</p>
                                    </div>
                                  </div>
                                </div>
                                <!-- Total Order -->
                            </div>
                            <!-- /Boxes -->
                            <div class="row g-3">
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr class="text-nowrap">
                                                    <th>{{__('lang.admin_id')}}</th>
                                                    <th>Orders Code </th>
                                                    <th>Customer</th>
                                                    <th>Order Date</th>
                                                    <th>Amount</th>
                                                    <th>Delivery Status</th>
                                                    <th>Payment method </th>
                                                    <th>Payment Status</th>
                                                    <th>Action</th>
                                                    
                                                </tr>
                                            </thead>
                                         
            <tbody>
                @if(count($seller_order) > 0)
                @foreach($seller_order as $row)
                <tr> 
                    <td>{{$row->id}}</td>
                    <td>{{$row->order_key}}</td>
                     <td>{{$row->user->name}}</td>
                  
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                      <td>{{$Symbol}}{{$row->order_total}}</td>

                <td><span class="badge bg-primary">{{$row->status}}</span></td>
                    

                    <td>{{$row->payment_method}}</td>
                
                       <td><span class="badge bg-success">{{$row->payment_status}}</span></td>
                    <td>
                        <div class="inline_action_btn">
                              
                            <a class="edit_icon" href="{{ url('admin/order-details/'.$row->id) }}"
                                   
                                    title="Oders Details"><i
                                        class="ti ti-eye me-1"></i></a>


                               
                              
                            
                        </div>
                    </td>
            

                                      <!--/ Modal to add new record -->
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
                            </div>             
                        </div>
                        <!-- transaction-->
                        <div class="tab-pane fade" id="form-tabs-transaction" role="tabpanel">
                            <div class="row g-3">
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr class="text-nowrap">
                                                    <th>{{__('lang.admin_id')}}</th>
                                                    <th>Withdraw request date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($withdraw_request) > 0)
                                                @foreach($withdraw_request as $row)
                                                <tr>
                                                    <td>{{$row->id}}</td>
                                                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                                                    <td>{{$row->amount}}</td>
                                                    <td>
                                                        @if($row->status == 'completed')
                                                        <span class="badge bg-success">{{$row->status}}</span>
                                                        @elseif($row->status == 'cancelled')
                                                        <span class="badge bg-danger">{{$row->status}}</span>
                                                        @else
                                                        <span class="badge bg-primary">{{$row->status}}</span>
                                                        @endif
                                                    </td>
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
                        <!-- reviews -->
                        <div class="tab-pane fade" id="form-tabs-reviews" role="tabpanel">
                            <div class="row g-3 mt-3">
                                <div class="col-md-12">
                                    <div class="rating-box" style="margin-left: 400px;">
                                        <div class="rating-overall">
                                            <span>/5</span>
                                        </div>
                                        <div class="rating-stars">
                                           
                                            <span class="rating-count">Reviews</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>{{__('lang.admin_review_list')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table">
                                                <thead class="table-light">
                                                    <tr class="text-nowrap">
                                                        <th>{{__('lang.admin_sl')}}</th>
                                                        <th>{{__('lang.admin_order_id')}}</th>
                                                        <th>{{__('lang.admin_name')}}</th>
                                                        <th>{{__('lang.admin_image')}}</th>
                                                        <th>{{__('lang.admin_reviewer_info')}}</th>
                                                        <th>{{__('lang.admin_reviewer_review')}}</th>
                                                        <th>{{__('lang.admin_date')}}</th>
                                                    </tr>
                                                </thead>
                                           
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


    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->


<!-- Modal -->
<div class="modal fade" id="ScheduleAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel ScheduleAdd" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">{{__('lang.admin_create_schedule')}} <span class="dayName"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="{{url('admin/store-open-close-time')}}" method="POST" class="scheduleForm" role="form" id="scheduleForm">
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="day" class="hiddenDayName">
                    <input type="hidden" name="restaurant_id" value="{{ Request::segment(3) }}">
                  <div class="col mb-3">
                    <label for="nameBasic" class="form-label">{{__('lang.admin_opening_time')}}</label>
                    <input type="time" name="opening_time" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-3">
                    <label for="nameBasic" class="form-label">{{__('lang.admin_closing_time')}}</label>
                    <input type="time" name="closing_time" class="form-control">
                  </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="submitForm">{{__('lang.admin_submit')}}</button>
            </div>
        </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).on('click','.add_schedule',function(){
        var day = $(this).attr('data-day');
        var form = $('#scheduleForm');
        form[0].reset();
        $('.dayName').text(day);
        $('.hiddenDayName').val(day);
        $('#ScheduleAdd').modal('show');
    });

    $(document).on('click','.close',function(){
        $('#ScheduleAdd').modal('hide');
    });
</script>

<script type="text/javascript">
    function fetchHtmlData(restaurant_id){
        var base_url = "{{ url('/admin/get-open-close-schedule') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: base_url,
            type: 'POST',
            data: { restaurant_id: restaurant_id },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('.schedule_html_body').html(response.data);
                } else {
                    myToastr(response.message, 'error');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText); // Log the error for debugging
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        var res_id = "{{ Request::segment(3) }}";
        fetchHtmlData(res_id);
    })
</script>


<script>
    $(document).ready(function() {
        $('#submitForm').on('click', function(e) {
            e.preventDefault();
            
            var form = $('#scheduleForm');
            var formData = form.serialize();
            var res_id = "{{ Request::segment(3) }}";

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#ScheduleAdd').modal('hide');
                    fetchHtmlData(res_id);
                },
                error: function(xhr) {
                    // Handle error
                    toastr.error('An error occurred while adding the schedule: ' + xhr.responseText);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    // Add an event listener to the delete button
    $(document).on('click','.delete_schedule', function(event) {
      event.preventDefault();
      var id = $(this).data('id');
      var url = '{{ url("admin/delete-open-close-time") }}';
      var res_id = "{{ Request::segment(3) }}";


      Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            customClass: {
                confirmButton: 'swal-confirm-button-class'
            }
        }).then((result) => {
            if (result.isConfirmed) {
               
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        fetchHtmlData(res_id);
                    },
                    error: function(xhr) {
                        // Handle error
                        alert('An error occurred while adding the schedule.'+xhr);
                    }
                });
            }
        });


    });
</script>
@endsection
