

<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="">Business Name
</label>
    <input type="text" class="form-control" value="{{$taxinfo->business_name ?? ''}}" name="business_name" placeholder="Business name">
</div>

<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="">Tax Id
</label>
    <input type="text" class="form-control" value="{{$taxinfo->taxid ?? ''}}" name="tax" placeholder="Tax Id">
</div>




<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="firebase_msg_key">PAN</label>
    <input type="text" class="form-control" value="{{$taxinfo->pan ?? ''}}" name="pan" placeholder="PAN">
</div>



