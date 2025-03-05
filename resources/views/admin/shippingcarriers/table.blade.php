


<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Carriers List</h5>
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
                    <th>{{__('lang.admin_image')}}</th>
                    <th>{{__('lang.admin_name')}}</th>
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
                        <img src="{{ url('uploads/carriers/'.$row->image)}}" class="table_img"
                            onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    </td>
                    <td>{{$row->name}}</td>
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                    
               
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-carriers-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-carriers-column/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
                
                    <td>
                        <div class="inline_action_btn">
                               
                                <a class="edit_icon" href="javascript:void(0);"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#edit-new-record_{{$row->id}}"
                                    aria-controls="edit-new-record_{{$row->id}}"
                                    title="{{__('lang.admin_edit')}}"><i
                                        class="ti ti-pencil me-1"></i></a>


                                          <a class="delete_icon" href="javascript:void(0);"
                                onclick="showDeleteConfirmation('carriers' , {{ $row->id }})"
                                ><i class="ti ti-trash me-1"></i>
                            </a>
                             
                            
                        </div>
                    </td>
                 

                    <!-- Modal to edit new record -->
                    <div class="offcanvas offcanvas-end" id="edit-new-record_{{$row->id}}">
                        <div class="offcanvas-header border-bottom">
                            <h5 class="offcanvas-title"
                                id="exampleModalLabel">Edit Carriers</h5>
                            <button type="button" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body flex-grow-1">
                            <form action="{{url('admin/update-carriers')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$row->id}}">
                                <div class="col-sm-12">
                                    <label class="form-label"
                                        for="name">Name<span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="basicFullname"
                                            class="form-control dt-full-name" name="name"
                                            value="{{$row->name}}"
                                            placeholder="Name"
                                            aria-label="John Doe"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                        <label class="form-label image_lable"
                                            for="ecommerce-category-image">Carriers Image<span class="required">*</span></label>
                                        <div class="mb-3 d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{ url('uploads/carriers/'.$row->image)}}"
                                            class="rounded me-50 hide upload_image_show" id="image_preview_icon_edit_{{$row->id}}"
                                            alt="icon" height="80" width="80"
                                            onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                                        <div class="mt-75 ms-1">
                                            <label class="image_upload_btn"
                                                for="change_picture_icon_edit_{{$row->id}}"
                                                style="border: 2px solid;cursor: pointer;">
                                                <span class="d-none d-sm-block">{{__('lang.admin_upload')}}</span>
                                                <input class="form-control" type="file" name="image"
                                                    id="change_picture_icon_edit_{{$row->id}}" hidden
                                                    accept="image/png, image/jpeg, image/jpg" name="icon"
                                                    onclick="showImagePreview('change_picture_icon_edit_{{$row->id}}','image_preview_icon_edit_{{$row->id}}',512,512);" />
                                                <span class="d-block d-sm-none">
                                                    <i class="me-0" data-feather="edit"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
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



