<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"
            id="exampleModalLabel">Add Requests</h5>
        <button type="button" class="btn-close text-reset"
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form action="{{url('sellers-save-withdraw-requests')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="col-sm-12">
                <label class="form-label" for="name">Amount<span class="required">*</span></label>
                <div class="input-group input-group-merge">
                    <input type="text" id="basicFullname"
                        class="form-control dt-full-name" name="amount"
                        placeholder="Amount"
                        aria-label="John Doe"
                        aria-describedby="basicFullname2" required />
                </div>
            </div>

                <div class="col-sm-12">
                <label class="form-label" for="name">Message<span class="required">*</span></label>
                <div class="input-group input-group-merge">
                    <textarea type="text" id="basicFullname"
                        class="form-control dt-full-name" name="message"
                        placeholder="Message"
                        aria-label="John Doe"
                        aria-describedby="basicFullname2" required /></textarea>
                 
                </div>
            </div>
                      <div class="col-sm-12 mt-4">
                <button type="submit"
                    class="btn btn-primary data-submit me-sm-3 me-1">{{__('lang.admin_save_changes')}}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="offcanvas">{{__('lang.admin_cancel')}}</button>
            </div>
        </form>
    </div>
</div>
















