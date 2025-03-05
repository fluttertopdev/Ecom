<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"
            id="exampleModalLabel">{{__('lang.admin_add_new_customer')}}</h5>
        <button type="button" class="btn-close text-reset"
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form action="{{url('admin/save-customer')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            
            <div class="col-sm-12">
                <label class="form-label"
                    for="name">{{__('lang.admin_name')}} <span class="required">*</span></label>
                <div class="input-group input-group-merge">
                    <input type="text" id="basicFullname"
                        class="form-control dt-full-name" name="name"
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