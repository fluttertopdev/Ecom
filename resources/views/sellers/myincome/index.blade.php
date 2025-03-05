@extends('sellers.layouts.app')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-9">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('restaurant/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span>
                  Seller Wallet
           </h4>

            </div>
             @if (in_array('withdraw-request', \Helpers::sellergetAssignedPermissions()))
            <div class="col-md-3">
                <div class="table-btn-css">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#requestWithdrawModal">
                        <span class="ti-xs ti ti-plus me-1"></span>Request Withdraw

                    </button>
                </div>
            </div>
             @endif
        </div>

        <!-- Boxes -->
        <div class="row g-6">
            <!-- Withdrawable Balance -->
            <div class="col-lg-3 col-sm-6">
              <div class="card h-100">
                <div class="card-body text-center">
                  <div class="badge rounded p-2 bg-label-success mb-2"><i class="ti ti-currency-dollar ti-lg"></i></div>
                  <h5 class="card-title mb-1">{{$totalWithdrawable}}</h5>
                  <p class="mb-0">Withdrawable Balance</p>
                </div>
              </div>
            </div>
            <!-- Pending Withdraw -->
            <div class="col-lg-3 col-sm-6">
              <div class="card h-100">
                <div class="card-body text-center">
                  <div class="badge rounded p-2 bg-label-info mb-2"><i class="ti ti-currency-dollar ti-lg"></i></div>
                  


                  <h5 class="card-title mb-1">{{$pendingwithdraw}}</h5>
                  <p class="mb-0">Pending Withdraw
</p>
                </div>
              </div>
            </div>
            <!-- Total Withdrawn -->
            <div class="col-lg-3 col-sm-6">
              <div class="card h-100">
                <div class="card-body text-center">
                  <div class="badge rounded p-2 bg-label-danger mb-2"><i class="ti ti-currency-dollar ti-lg"></i></div>
                  <h5 class="card-title mb-1">{{$confermwithdraw}}</h5>
                  <p class="mb-0">Total Withdrawn</p>
                </div>
              </div>
           



            </div>
             <!-- Total earning -->
            <div class="col-lg-3 col-sm-6">
              <div class="card h-100">
                <div class="card-body text-center">
                  <div class="badge rounded p-2 bg-label-primary mb-2"><i class="ti ti-currency-dollar ti-lg"></i></div>
                  <h5 class="card-title mb-1">{{$totalearning}}</h5>
                  <p class="mb-0">Total Earning</p>
                </div>
              </div>
            </div>
        </div>

        <!-- Bordered Table -->
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-withdraw-request"
                            role="tab"
                            aria-selected="true"
                            >
                            Withdraw Request
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-tabs-payment-history"
                            role="tab"
                            aria-selected="false"
                            >
                            Payment History
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <!-- Withdraw Request  -->
                    <div class="tab-pane fade active show" id="form-tabs-withdraw-request" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Withdraw Request</h5>
                                    </div>
                                     <div class="col-md-6">
                                        <h6 class="float-right">
                                            <?php if ($allPendingRequest->firstItem() != null) {?>
                                            {{__('lang.admin_showing')}} {{ $allPendingRequest->firstItem() }}-{{ $allPendingRequest->lastItem() }}
                                            {{__('lang.admin_of')}} {{ $allPendingRequest->total() }} <?php }?>
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
                                                <th>Amount</th>
                                                <th>Request time</th>
                                                <th>Transaction Type</th>
                                                <th>Status</th>
                                                <th>Note</th>
                                                <th>Actions</th>
            
                                </tr>
                                        </thead>
                                    <tbody>
                                            @if(count($allPendingRequest) > 0)
                                            @foreach($allPendingRequest as $row)
                                            <tr>
                                                <td>{{$row->id}}</td>
                                                <td>{{$row->amount}}</td>
                                                <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                                                <td>Withdraw Request</td>
                                                <td>
                                                    @if($row->status == 'completed')
                                                    <span class="badge bg-success">{{$row->status}}</span>
                                                    @elseif($row->status == 'cancelled')
                                                    <span class="badge bg-danger">{{$row->status}}</span>
                                                    @else
                                                    <span class="badge bg-primary">{{$row->status}}</span>
                                                    @endif
                                                </td>
                                                <td>{{$row->message ?? '--'}}</td>
                                                   @if (in_array('delete-withdraw request', \Helpers::sellergetAssignedPermissions()))
                                                <td>
                                                    @if($row->status == 'pending')
                                                    <a class="delete_icon" href="javascript:void(0);" title="{{__('lang.admin_delete')}}" onclick="showDeleteConfirmation('withdraw_request' , {{ $row->id }})"><i class="ti ti-trash me-1"></i></a>
                                                    @else
                                                    --
                                                    @endif
                                                </td>
                                                @endif
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
                            <div class="card-footer">
                                
                            </div>
                        </div>                   
                    </div>
                    <!-- Payment method -->
                    <div class="tab-pane fade" id="form-tabs-payment-history" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Payment History</h5>
                                    </div>
                                     <div class="col-md-6">
                                        <h6 class="float-right">
                                            <?php if ($allRequests->firstItem() != null) {?>
                                            {{__('lang.admin_showing')}} {{ $allRequests->firstItem() }}-{{ $allRequests->lastItem() }}
                                            {{__('lang.admin_of')}} {{ $allRequests->total() }} <?php }?>
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
                                                <th>Amount</th>
                                                <th>Request time</th>
                                                <th>Transaction Type</th>
                                                <th>Status</th>
                                                <th>Note</th>
                                             
                                            </tr>
                                        </thead>
                                     <tbody>
                                            @if(count($allRequests) > 0)
                                            @foreach($allRequests as $row)
                                            <tr>
                                                <td>{{$row->id}}</td>
                                                <td>{{$row->amount}}</td>
                                                <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                                                <td>Withdraw Request</td>
                                                <td>
                                                    @if($row->status == 'completed')
                                                    <span class="badge bg-success">{{$row->status}}</span>
                                                    @elseif($row->status == 'cancelled')
                                                    <span class="badge bg-danger">{{$row->status}}</span>
                                                    @else
                                                    <span class="badge bg-primary">{{$row->status}}</span>
                                                    @endif
                                                </td>
                                                <td>{{$row->message ?? '--'}}</td>
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
                              <div class="card-footer">
                                <div class="pagination" style="float: right;">
                                    {{$allRequests->withQueryString()->links('pagination::bootstrap-4')}}
                                </div>
                            </div>
                        </div>                   
                    </div>
                </div>
            </div>
        <!--/ Bordered Table -->

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<!-- Modal -->
<div class="modal fade" id="requestWithdrawModal" tabindex="-1" aria-labelledby="    margin: 0px auto;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="requestWithdraw" style="margin: 0px auto;">Withdraw Request
</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{'send-withdrawl-request'}}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-body">
                        <label>Amount :</label>
                        <input type="number" name="amount" class="form-control" required/>
                    </div>
                </div>
            </div>
         
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        
        </form>
    </div>
  </div>
</div>

@endsection
