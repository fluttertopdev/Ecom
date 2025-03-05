

@if($row->key == 'refundsetting')
<div class="col-md-6 mb-3 display-inline-block">
    <label class="form-label" for="one_signal_key">Refund day</label>
    <input type="text" class="form-control" value="{{$row->value}}" name="refundsetting" placeholder="Refund day">
</div>
@endif
