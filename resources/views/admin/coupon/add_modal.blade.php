<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"
            id="exampleModalLabel">Add Coupon</h5>
        <button type="button" class="btn-close text-reset"
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form action="{{url('admin/save-coupon')}}" method="POST"
            enctype="multipart/form-data">
            
            @csrf
            <div class="col-sm-12">
                <label class="form-label" for="name">Coupon Code<span class="required">*</span></label>
                <div class="input-group input-group-merge">
                    <input type="text" id="basicFullname"
                        class="form-control dt-full-name" name="name"
                        placeholder="Coupon Code"
                        aria-label="John Doe"
                        aria-describedby="basicFullname2" required />
                </div>
            </div>


             <div class="col-sm-12">
                <label class="form-label " for="name">Start Date <span class="required">*</span></label>
                <div class="input-group input-group-merge">
                   <input class="form-control date-input" type="date" name="start_date" value="" id="" required />
                </div>
            </div>

              <div class="col-sm-12">
    <label class="form-label" for="name">End Date <span class="required">*</span></label>
    <div class="input-group input-group-merge">
        <input
            class="form-control date-input"
            type="date"
            name="expire_date"
            id="html5-date-input"
            required
        />
    </div>
</div>

             <div class="col-sm-12">
                <label class="form-label " for="name">Type<span class="required">*</span></label>

                <div class="input-group input-group-merge">
                     <select name="type" class="form-control">
                    <option value="">Type</option>
                     <option value="fixed">Fixed</option>
                     <option value="percent">Percent</option>
                     </select required>
                </div>
            </div>

             <div class="col-sm-12">
                <label class="form-label " for="name">Status<span class="required">*</span></label>

                <div class="input-group input-group-merge">
                     <select name="status" class="form-control">
                    <option value="">Status</option>
                     <option value="1">Active</option>
                     <option value="0">Deactive</option>
                     </select required>
                </div>
            </div>


             <div class="col-sm-12">
                <label class="form-label" for="name">Value<span class="required">*</span></label>
                <div class="input-group input-group-merge">
                    <input type="text" id="basicFullname"
                        class="form-control dt-full-name" name="discount"
                        placeholder="Value"
                        aria-label="John Doe"
                        aria-describedby="basicFullname2" required />
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











<script>
    // Get today's date in the format yyyy-mm-dd
    const today = new Date().toISOString().split('T')[0];

    // Set the min attribute for all inputs with the class 'date-input'
    document.querySelectorAll('.date-input').forEach(function (input) {
        input.setAttribute('min', today);
    });
</script>




