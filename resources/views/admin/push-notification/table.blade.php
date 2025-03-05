<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>{{__('lang.admin_banner_list')}}</h5>
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
                    <th>{{__('lang.admin_area')}}</th>
                    <th>{{__('lang.admin_title')}}</th>
                    <th>{{__('lang.admin_description')}}</th>
                    <th>{{__('lang.admin_banner')}}</th>
                    <th>{{__('lang.admin_target')}}</th>
                    <th>{{__('lang.admin_publish_date_time')}}</th>
                    <th>{{__('lang.admin_status')}}</th>
                    @can('delete-push-notification')
                    <th>{{__('lang.admin_action')}}</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$row->area->name}}</td>
                    <td>{{$row->title}}</td>
                    <td>{{substr($row->description,0,100)}}</td>
                    <td>
                        <img src="{{ url('uploads/push-notification/'.$row->banner)}}" class="table_img_banner"
                            onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    </td>
                    <td>{{ \Helpers::checkSendTo($row->send_to) }}</td>
                     <td>
                        {{date("d-m-Y",strtotime($row->schedule_date))}}</br>
                        <span>{{date("h:i A",strtotime($row->schedule_date))}}</span>
                    </td>
                    <td>
                        @if($row->status == 1)
                            <span class="badge bg-success">{{__('lang.admin_sended')}}</span>
                        @else
                            <span class="badge bg-warning">{{__('lang.admin_scheduled')}}</span>
                        @endif
                    </td>
                    @can('delete-push-notification')
                    <td>
                        <div class="inline_action_btn">
                            <a class="delete_icon" title="{{__('lang.admin_delete')}}" href="javascript:void(0);" onclick="showDeleteConfirmation('push-notification' , {{ $row->id }})">
                                <i class="ti ti-trash me-1"></i>
                            </a>
                        </div>
                    </td>
                    @endcan
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