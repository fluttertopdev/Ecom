<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"
            id="exampleModalLabel">{{__('lang.admin_add_subcategory')}}</h5>
        <button type="button" class="btn-close text-reset"
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form action="{{url('admin/save-subcategory')}}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="col-sm-12">
                <label class="form-label" for="name">{{__('lang.admin_category')}} <span class="required">*</span></label>
                <select class="form-control select2 form-select" name="category_id" required>
                    <option value="">{{__('lang.admin_select_category')}}</option>
                        @foreach($category_data as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                </select>
            </div>

            <div class="col-sm-12 mt-3">
                <label class="form-label" for="name">{{__('lang.admin_subcategory_name')}} <span class="required">*</span></label>
                <div class="input-group input-group-merge">
                    <input type="text" id="basicFullname"
                        class="form-control dt-full-name" name="name"
                        placeholder="{{__('lang.admin_subcategory_name_placeholder')}}"
                        aria-label="John Doe"
                        aria-describedby="basicFullname2" required >
                </div>
            </div>

             <div class="col-sm-12 mt-3">
                    <label class="form-label image_lable"
                        for="ecommerce-category-image">Image<span class="required">*</span></label>
                    <div class="mb-3 d-flex align-items-start align-items-sm-center gap-4">
                    <img src="" class="rounded me-50 hide upload_image_show" id="image-preview-icon"
                        alt="icon" height="80" width="80"
                        onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    <div class="mt-75 ms-1">
                        <label class="image_upload_btn"
                            for="change-picture-icon">
                            <span class="d-none d-sm-block">{{__('lang.admin_upload')}}</span>
                            <input class="form-control" type="file" name="image"
                                id="change-picture-icon" hidden
                                accept="image/png, image/jpeg, image/jpg" name="icon"
                                onclick="showImagePreview('change-picture-icon','image-preview-icon',512,512);" required>
                            <span class="d-block d-sm-none">
                                <i class="me-0" data-feather="edit"></i>
                            </span>
                        </label>
                    </div>
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