<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>{{__('lang.admin_deliveryman_list')}}</h5>
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
                    <th>{{__('lang.admin_name')}}</th>
                    <th>{{__('lang.admin_image')}}</th>
                  
                   
                    <th>{{__('lang.admin_created_at')}}</th>
                   
                    <th>{{__('lang.admin_status')}}</th>
                  
                  
                    <th>{{__('lang.admin_action')}}</th>
                    
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>
                        <div class="d-flex flex-column">
                                <p class="mb-0 fw-medium">
                               {{ \Helpers::checkNull($row->name) }}
                                </p>
                                <small class="text-muted text-nowrap">{{ $row->phone }}
                                </small>
                        </div>
                    </td>
                    <td> 
                        <img src="{{ url('uploads/deliveryman/'.$row->image)}}" class="table_img"
                            onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    </td>
                  
                   
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                   
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-deliveryman-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-deliveryman-column/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
                  
                    
                    <td>
                        <div class="inline_action_btn">
                           
                        
                          
                          
                            <a class="edit_icon" href="{{url('admin/edit-deliveryman/'.$row->id)}}" title="{{__('lang.admin_edit')}}"><i class="ti ti-pencil me-1"></i>
                            </a>
                           
                           
                            <a class="delete_icon" title="{{__('lang.admin_delete')}}" href="javascript:void(0);" onclick="showDeleteConfirmation('deliveryman' , {{ $row->id }})">
                                <i class="ti ti-trash me-1"></i>
                            </a>
                           
                        </div>
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
<div class="card-footer">
    <div class="pagination" style="float: right;">
        {{$result->withQueryString()->links('pagination::bootstrap-4')}}
    </div>
</div>
</div>