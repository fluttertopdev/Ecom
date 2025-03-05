

@if($row->key == 'instagram')
<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="">Instagram</label>
    <input type="text" class="form-control" value="{{$row->value}}" name="instagram" placeholder="Instagram">
</div>
@endif

@if($row->key == 'facebook')
<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="">Facebook</label>
    <input type="text" class="form-control" value="{{$row->value}}" name="facebook" placeholder="Facebook">
</div>
@endif

@if($row->key == 'XSocialMedia')
<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="one_signal_key">X Social Media</label>
    <input type="text" class="form-control" value="{{$row->value}}" name="XSocialMedia" placeholder="X Social Media">
</div>
@endif

@if($row->key == 'linkedin')
<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="one_signal_key">Linkedin</label>
    <input type="text" class="form-control" value="{{$row->value}}" name="linkedin" placeholder="Linkedin">
</div>
@endif



