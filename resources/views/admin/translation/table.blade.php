<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
    .toast-success {
    background-color: #28a745 !important; /* Green */
    color: #fff !important;
}
</style>
<table class="table">
    <thead class="table-light">
        <tr class="text-nowrap">
            <th>{{__('lang.admin_id')}}</th>
            <th>Group Name</th>
            <th>Value</th>
          
            
        </tr>
    </thead>
<tbody>    
    @php $i=0; @endphp 
    @if(count($result) > 0) 
        @foreach($result as $row) 
            @php $i++; @endphp 
            <tr>
                <td>{{$i}}</td>
                <td>@if($row->group!=''){{$row->group}}@else -- @endif</td>
                <td>
                    <input 
                        type="text" 
                        name="value" 
                        value="{{$row->value}}" 
                        class="form-control update-value" 
                        data-id="{{$row->id}}" 
                    >
                </td>
                <td>
                    <input 
                        type="hidden" 
                        name="id" 
                        value="{{$row->id}}" 
                        class="form-control" 
                        readonly
                    >
                </td>
            </tr> 
        @endforeach 
    @else 
        <tr>
            <td colspan="6" class="record-not-found">
                <span>{{__('lang.admin_record_not_found')}}</span>
            </td>
        </tr> 
    @endif 
</tbody>

</table>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Toastr CSS -->


<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function () {
    $('.update-value').on('change', function () {
        const id = $(this).data('id'); // Get the ID from the data attribute
        const value = $(this).val(); // Get the value from the input

        $.ajax({
            url: "{{ url('admin/update-translation') }}", // Adjust the URL as per your route
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
                value: value,
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function (res) {
                if (res.success) {
                    // Show success toaster
                    toastr.success(res.message || 'Translation updated successfully!');
                } else {
                    // Show error toaster for failed update
                    toastr.error(res.message || 'Failed to update translation.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                // Show error toaster for unexpected errors
                toastr.error('An error occurred while updating the translation.');
            }
        });
    });
});
</script>