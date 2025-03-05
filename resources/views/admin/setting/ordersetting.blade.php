

@if($row->key == 'order_prefix')
<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="one_signal_key">Order Id Prefix</label>
    <input type="text" class="form-control" value="{{$row->value}}" name="order_prefix" placeholder="order prefix">
</div>
@endif
