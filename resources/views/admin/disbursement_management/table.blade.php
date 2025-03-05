
<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Seller Disbursement List</h5>
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
                    <th>Seller Name</th>
                    <th>Amount</th>
                    <th>Request time    </th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$row->user->name}}</td>
                    <td>{{$row->amount}}</td>
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                    <td>
                        @if($row->status == 'completed')
                        <span class="badge bg-success">{{$row->status}}</span>
                        @elseif($row->status == 'cancelled')
                        <span class="badge bg-danger">{{$row->status}}</span>
                        @else
                        <span class="badge bg-primary">{{$row->status}}</span>
                        @endif
                    </td>
                    <td>
                        <div class="inline_action_btn">
                            <a href="{{url('admin/withdraw-request/'.$row->id)}}" class="" href="javascript:void(0);" title="{{__('lang.admin_view')}}"><i class="ti ti-eye me-1"></i>
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