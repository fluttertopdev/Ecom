

<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="">Bank Name <span class="required">*</span>
</label>
    <input type="text" class="form-control" value="{{$bankinfo->bank_name ?? ''}}" name="bank_name" placeholder="Bank Name" required>
</div>

<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="">IFSC Code <span class="required">*</span>
</label>
    <input type="text" class="form-control" value="{{$bankinfo->ifsccode ?? ''}}" name="ifsccode" placeholder="IFSC Code" required>
</div>




<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="firebase_msg_key">Account Holder Name <span class="required">*</span>
</label>
    <input type="text" class="form-control" value="{{$bankinfo->holdername ?? ''}}" name="holdername" placeholder="Account Holder Name" required>
</div>



<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="firebase_msg_key">Account Number <span class="required">*</span>

</label>
    <input type="text" class="form-control" value="{{$bankinfo->holdername?? ''}}" name="holdername" placeholder="Account Number
" required>
</div>
<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="firebase_msg_key">UPI ID <span class="required">*</span>

</label>
    <input type="text" class="form-control" value="{{$bankinfo->upiid?? ''}}" name="upiid" placeholder="UPI ID
" required>
</div>




