


<?php
$Symbol = \Helpers::getActiveCurrencySymbol();
?>


<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Orders List</h5>
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
                    <th>Orders Code</th>
                    <th>Customer</th>
                     <th>Seller Name</th>
                    <th>Order Date</th>
                    <th>Amount</th>
                    <th>Delivery Status</th>
                    <th>Payment method</th>
                     <th>Payment Status </th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr> 
                    <td>{{$row->id}}</td>
                    <td>{{$row->order_key}}</td>
                     <td>{{$row->user->name}}</td>
                      <td>{{ $row->seller ? $row->seller->name : 'Admin' }}</td>
                   
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                      <td>{{$Symbol}}{{ number_format($row->order_total, 2, '.', ',') }}</td>

                <td>
    @php
        $statusClasses = [
            'pending' => 'warning',
            'confirmed' => 'primary',
            'Picked-up' => 'info',
            'delivered' => 'success',
            'On-the-way' => 'secondary',
        ];
        
         $paymentstatusclass = [
            'pending' => 'primary',
            'paid' => 'success',
           
        ];
    @endphp
    <span class="badge bg-{{ $statusClasses[$row->status] ?? 'dark' }}">
       {{ ucwords($row->status) }}
    </span>
</td>
                   

                    <td>{{ucwords($row->payment_method)}}</td>
                    
                       <td>
                             @if ($row->payment_method !== 'cash' && $row->payment_status == 'pending')
                          <span class="badge bg-danger">Failed</span>
                           @else
                              <span class="badge bg-{{ $paymentstatusclass[$row->payment_status] ?? 'dark' }}">
                        {{ ucwords($row->payment_status) }}
                        </span>
                        @endif
                       </td>
                       
                     
                    <td>
                        <div class="inline_action_btn">
                         @if (in_array('view-order', \Helpers::sellergetAssignedPermissions()))
                            <a class="edit_icon" href="{{ url('seller-orderDetails/'.$row->id) }}"
                                   
                                    title="Oders Details"><i
                                        class="ti ti-eye me-1"></i></a>
                         @endif

                          
                              
                            
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
<div class="card-footer">
    <div class="pagination" style="float: right;">
        {{$result->withQueryString()->links('pagination::bootstrap-4')}}
    </div>
</div>
</div>


 


















   