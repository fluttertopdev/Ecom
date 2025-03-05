




<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Shipping Rate Modes</h5>
        </div>
        
    </div>
</div>

<div class="card-body">
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr class="text-nowrap">
                    <th>{{__('lang.admin_id')}}</th>
                    <th>Name</th>
                    <th>description</th>
                    <th>{{__('lang.admin_status')}}</th>
                
                
                    <th>{{__('lang.admin_action')}}</th>
                
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->des}}</td>
                
                  
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('seller-update-type-status/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('seller-update-type-status/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
                
                    @if (in_array('update-shipping-setting', \Helpers::sellergetAssignedPermissions()))
                    <td>
                        <div class="inline_action_btn">
                       
                            <a class="edit_icon" href="{{url('sellers-shipping-rate/'.$row->id)}}"
                                data-bs-toggle=""
                                data-bs-target=""
                                aria-controls=""
                                title="{{__('lang.admin_edit')}}"><i
                                    class="ti ti-pencil me-1"></i>
                            </a>
                            
                          
                        </div>
                    </td>
                    
                 @endif

                    
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
