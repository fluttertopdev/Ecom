@if($row->key == 'excluding_tax')
<div class="col-md-4 mt-4">
    <label class="switch switch-square">
        <input value="1" type="checkbox" class="switch-input" id="excluding_tax" name="excluding_tax" @if($row->value == 1) checked @endif>
        <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
        </span>
        <span class="switch-label">Price Including Tax</span>
    </label>
</div>
@endif

@if($row->key == 'including_tax')
<div class="col-md-4 mt-4">
    <label class="switch switch-square">
        <input value="1" type="checkbox" class="switch-input" id="including_tax" name="including_tax" @if($row->value == 1) checked @endif>
        <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
        </span>
        <span class="switch-label">Price Excluding Tax</span>
    </label>
</div>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const excludingTaxCheckbox = document.getElementById('excluding_tax');
        const includingTaxCheckbox = document.getElementById('including_tax');

        excludingTaxCheckbox.addEventListener('change', function() {
            if (this.checked) {
                includingTaxCheckbox.checked = false;
            } else {
                includingTaxCheckbox.checked = true;
            }
        });

        includingTaxCheckbox.addEventListener('change', function() {
            if (this.checked) {
                excludingTaxCheckbox.checked = false;
            } else {
                excludingTaxCheckbox.checked = true;
            }
        });
    });
</script>







