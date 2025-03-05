<?php
use App\Models\Category;
$category = Category::where('deleted_at', null)->get();


?>


<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>{{__('lang.admin_category_list')}}</h5>
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
                    <th>Popular</th>
                   
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
                        <img src="{{ url('uploads/category/'.$row->image)}}" class="table_img"
                            onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    </td>
                    <td>{{$row->name}}</td>
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                    <td>
                        @if($row->is_featured == 1)
                        <a href="{{ url('admin/update-is-featured-category-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_yes')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-is-featured-category-column/'.$row->id) }}">
                            <span class="badge bg-danger">{{__('lang.admin_no')}}</span></a>
                        @endif
                    </td>
                   
                  
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-category-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-category-column/'.$row->id) }}">
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
                                onclick="showDeleteConfirmations('category' , {{ $row->id }})"
                                ><i class="ti ti-trash me-1"></i>
                            </a>
                            
                            <a class="edit_icon" href="{{ url('admin/categories/translation/'.$row->id) }}"
                          title="Translation">
                          <i class="ti ti-language me-1 margin-top-negative-4"></i>
                            </a>
                            
                        </div>
                    </td>
                

                    <!-- Modal to edit new record -->
                    <div class="offcanvas offcanvas-end" id="edit-new-record_{{$row->id}}">
                        <div class="offcanvas-header border-bottom">
                            <h5 class="offcanvas-title"
                                id="exampleModalLabel">{{__('lang.admin_edit_category')}}</h5>
                            <button type="button" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body flex-grow-1">
                            <form action="{{url('admin/update-category')}}" method="POST"
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
                                            placeholder="{{__('lang.admin_category_name_placeholder')}}"
                                            aria-label="John Doe"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                        <label class="form-label image_lable"
                                            for="ecommerce-category-image">{{__('lang.admin_category_image')}} <span class="required">*</span></label>
                                        <div class="mb-3 d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{ url('uploads/category/'.$row->image)}}"
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




 <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                  <div class="modal-content">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-6">
                        <h4 class="mb-2">Delete Confirmation</h4>
                        <p>Are you sure you want to delete this <strong id="categoryName"></strong> category?</p>
                      </div>
                     <div class="modal-body">
        
        
        <p><strong>Category have Product:</strong> <span id="productCount"></span></p>
        <p><strong>Category have Subcategory :</strong> <span id="subcategoryCount"></span></p>
        <label for="deleteReason">Please Transfer to other category then delete:</label>
        <select id="deleteReason" class="form-select">
              <option value="">Please select</option>
             @foreach($category as $list)

          <option value="{{ $list->id }}">{{ $list->name }}</option>
          @endforeach
        
        </select>
      </div>


       <div class="col-12 text-center">
                          <button type="button" class="btn btn-primary me-3" onclick="confirmDelete()">Delete</button>
                          <button
                            type="reset"
                            class="btn btn-label-secondary btn-reset"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                          </button>
                        </div>
                   
                    </div>
                  </div>
                </div>
              </div>

<script>

function showDeleteConfirmations(type, id) {
   
    window.categoryToDelete = id;
    var categoryid = id;

   
    $.ajax({
        url: '{{ url("admin/fatch-categorydata") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            categoryid: categoryid
        },
        success: function (response) {
           
            $('#productCount').text(response.product_count);
            $('#subcategoryCount').text(response.subcategory_count);
            $('#categoryName').text(response.categoryName);
           
        
            if (response.product_count == 0 && response.subcategory_count == 0) {
                $('#deleteReason').prev('label').text('You can delete this category without transfer:');
            } else {
                $('#deleteReason').prev('label').text('Do you want to transfer the sub-category and products under another main category?');
            }

          
            $('#deleteReason').empty(); 
            $('#deleteReason').append('<option value="">Please select</option>'); // Add default option

            @foreach($category as $list)
               
                if ("{{ $list->id }}" != categoryid) {
                    $('#deleteReason').append('<option value="{{ $list->id }}">{{ $list->name }}</option>');
                }
            @endforeach

           
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        },
        error: function (xhr) {
          
            alert('An error occurred while fetching category data.');
        }
    });
}


</script>





 




