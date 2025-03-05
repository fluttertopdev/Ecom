<table class="table">
    <thead class="table-light">
        <tr class="text-nowrap">
            <th>{{__('lang.admin_id')}}</th>
            <th>{{__('lang.admin_role_name')}}</th>
            <th>{{__('lang.admin_created_at')}}</th>
        
            <th>{{__('lang.admin_action')}}</th>
          
        </tr>
    </thead>
    <tbody>    
        @php $i=0; @endphp 
        @if(count($result) > 0) 
            @foreach($result as $row) 
                @php $i++; @endphp 
                <tr>
                    <td>{{$i}}</td>
                    <td>
                        
                            @if($row->name!='')<a class="cursor-pointer" href="javascript:;" data-bs-toggle="modal" data-bs-target="#editRoleModal_{{$row->id}}" class="role-edit-modal">{{$row->name}}</a>@else -- @endif
                       
                    </td>
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                  
                    <td>
                        <div class="inline_action_btn">
                           
                            <a class="edit_icon role-edit-modal" type="button" href="javascript:;" data-bs-toggle="modal" data-bs-target="#editRoleModal_{{$row->id}}" title="{{__('lang.admin_edit')}}"><i class="ti ti-pencil me-1"></i>
                            </a>
                         
                         
                              
                            
                              
                            
                        </div>
                        <div class="modal fade" id="editRoleModal_{{$row->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
                                <div class="modal-content p-3 p-md-5">
                                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <h3 class="role-title mb-2">{{__('lang.admin_edit_role')}}</h3>
                                            <p class="text-muted">{{__('lang.admin_set_role_permission')}}</p>
                                        </div>

                                        <!-- Edit role form -->
                                        <form class="row g-3" id="edit-record_{{$row->id}}" onsubmit="return validateRole('edit-record_{{$row->id}}');" action="{{url('admin/update-role')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$row->id}}">
                                            
                                            <!-- Role Name -->
                                            <div class="col-12 mb-4">
                                                <label class="form-label" for="name">{{__('lang.admin_role_name')}} <span class="required">*</span></label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('lang.admin_role_name_placeholder')}}" value="{{$row->name}}"/>
                                                
                                            </div>
                                            
                                            <!-- Role Permissions -->
                                            <div class="col-12 mb-4">
                                                <h5>{{__('lang.admin_role_permissions')}}</h5>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-all-checkbox_List" type="checkbox" value="List" data-permission="List" onclick="selectAllSameData('permission-all-checkbox_List','permission-checkbox_List');" />
                                                            <label class="form-check-label" for="{{__('lang.admin_all_list')}}">{{__('lang.admin_all_list')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-all-checkbox_Add" type="checkbox" value="Add" data-permission="Add" onclick="selectAllSameData('permission-all-checkbox_Add','permission-checkbox_Add');" />
                                                            <label class="form-check-label" for="{{__('lang.admin_all_add')}}">{{__('lang.admin_all_add')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-all-checkbox_Update" type="checkbox" value="Update" data-permission="Update" onclick="selectAllSameData('permission-all-checkbox_Update','permission-checkbox_Update');" />
                                                            <label class="form-check-label" for="{{__('lang.admin_all_update')}}">{{__('lang.admin_all_update')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-all-checkbox_Status" type="checkbox" data-permission="Status" onclick="selectAllSameData('permission-all-checkbox_Status','permission-checkbox_Status');" />
                                                            <label class="form-check-label" for="{{__('lang.admin_all_status_change')}}">{{__('lang.admin_all_status_change')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-all-checkbox_Delete" type="checkbox" value="Delete" data-permission="Delete" onclick="selectAllSameData('permission-all-checkbox_Delete','permission-checkbox_Delete');" />
                                                            <label class="form-check-label" for="{{__('lang.admin_all_delete')}}">{{__('lang.admin_all_delete')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Permission table -->
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>{{__('lang.admin_all_module')}}</th>
                                                                <th>{{__('lang.admin_all_permissions')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($permission as $value)
                                                            <tr>
                                                                <td class="fw-semibold">{{$value->permission[0]->module}}</td>
                                                                <td>
                                                                    <div class="d-flex flex-wrap gap-2">
                                                                        @foreach($value->permission as $detail)
                                                                        <div class="form-check me-3">
                                                                            @if($detail->permission_name == 'Status Change')
                                                                                <input class="form-check-input permission-checkbox_Status" type="checkbox" id="{{ $detail->name }}" name="permission[]" value="{{$detail->id}}" {{\Helpers::checkRoleHasPermission($row->id, $detail->id) || $detail->is_default ? 'checked' : ''}}  @if($detail->name == 'dashboard') onclick="return false;" @endif/>
                                                                            @else
                                                                                <input class="form-check-input permission-checkbox_{{ $detail->permission_name }}" type="checkbox" id="{{ $detail->name }}" name="permission[]" value="{{$detail->id}}" {{\Helpers::checkRoleHasPermission($row->id, $detail->id) || $detail->is_default ? 'checked' : ''}} @if($detail->name == 'dashboard') onclick="return false;" @endif
                                                                                />
                                                                            @endif
                                                                            <label class="form-check-label" for="{{ $detail->name }}"> {{ $detail->permission_name }} </label>
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- Permission table -->

                                            <!-- Submit & Cancel Buttons -->
                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1">{{__('lang.admin_button_save_changes')}}</button>
                                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">{{__('lang.admin_button_cancel')}}</button>
                                            </div>
                                        </form>
                                        <!--/ Edit role form -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                 
                </tr> 
            @endforeach 
        @else 
            <tr>
                <td colspan="7" class="record-not-found">
                    <span>{{__('lang.admin_record_not_found')}}</span>
                </td>
            </tr> 
        @endif 
    </tbody>
</table>