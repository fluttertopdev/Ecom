<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>{{__('lang.admin_customer_list')}}</h5>
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
                    <th>{{__('lang.admin_contact_info')}}</th>
                    <th>{{__('lang.admin_created_at')}}</th>
                    @can('update-customer-column')
                    <th>{{__('lang.admin_status')}}</th>
                    @endcan
                    @canany(['update-customer', 'delete-customer','view-customer'])
                    <th>{{__('lang.admin_action')}}</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$row->name}}</td>
                    <td>
                        <div class="d-flex flex-column">
                                <p class="mb-0 fw-medium">
                                {{$row->email}}
                                </p>
                                <small class="text-muted text-nowrap">{{ \Helpers::checkNull($row->phone) }}
                                </small>
                        </div>
                    </td>
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                    @can('update-customer-column')
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-customer-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-customer-column/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
                    @endcan
                    @canany(['update-customer', 'delete-customer','view-customer'])
                    <td>
                        <div class="inline_action_btn">
                                @can('view-customer')
                                <a class="edit_icon" href="{{url('admin/view-customer/'.$row->id)}}" title="{{__('lang.admin_view')}}"><i class="ti ti-eye me-1"></i>
                                </a>
                                @endcan
                                @can('update-customer')
                                <a class="edit_icon" href="javascript:void(0);"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#edit-new-record_{{$row->id}}"
                                    aria-controls="edit-new-record_{{$row->id}}"
                                    title="{{__('lang.admin_edit')}}"><i
                                        class="ti ti-pencil me-1"></i></a>
                                @endcan
                                @can('delete-customer')
                                <a class="delete_icon" href="javascript:void(0);" title="{{__('lang.admin_delete')}}"
                                    onclick="showDeleteConfirmation('customer' , {{ $row->id }})"
                                    ><i class="ti ti-trash me-1"></i></a
                                >
                                @endcan
                        </div>
                    </td>
                    @endcanany

                    <!-- Modal to edit new record -->
                    <div class="offcanvas offcanvas-end" id="edit-new-record_{{$row->id}}">
                        <div class="offcanvas-header border-bottom">
                            <h5 class="offcanvas-title"
                                id="exampleModalLabel">{{__('lang.admin_edit_customer')}}</h5>
                            <button type="button" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body flex-grow-1">
                            <form action="{{url('admin/update-customer')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$row->id}}">

                                <div class="col-sm-12">
                                    <label class="form-label"
                                        for="name">{{__('lang.admin_name')}} <span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="basicFullname"
                                            class="form-control dt-full-name" name="name"
                                            value="{{$row->name}}"
                                            placeholder="{{__('lang.admin_name_placeholder')}}"
                                            aria-label="John Doe"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <label class="form-label"
                                        for="name">{{__('lang.admin_email')}} <span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="email" id="basicFullname"
                                            class="form-control dt-full-name" name="email"
                                            value="{{$row->email}}"
                                            placeholder="{{__('lang.admin__email_placeholder')}}"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <label class="form-label"
                                        for="name">{{__('lang.admin_phone')}} <span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="tel" id="basicFullname"
                                            class="form-control dt-full-name" name="phone"
                                            value="{{$row->phone}}"
                                            placeholder="{{__('lang.admin_phone_placeholder')}}"
                                            aria-describedby="basicFullname2" maxlength="10" required />
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <label class="form-label"
                                        for="name">{{__('lang.admin_password')}} <span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="basicFullname"
                                            class="form-control dt-full-name" name="password"
                                            value="{{$row->password}}"
                                            placeholder="{{__('lang.admin_password_placeholder')}}"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 mt-3">
                                    <button type="submit"
                                        class="btn btn-primary data-submit me-sm-3 me-1">{{__('lang.admin_save_changes')}}</button>
                                    <button type="reset" class="btn btn-outline-secondary"
                                        data-bs-dismiss="offcanvas">{{__('lang.admin_cancel')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
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