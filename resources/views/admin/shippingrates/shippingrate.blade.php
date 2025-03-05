
<?php $segment1 =  Request::segment(3);  

$Symbol = \Helpers::getActiveCurrencySymbol();
?>

@extends('admin.layouts.app')
@section('content')



<?php if ($segment1 == 1): ?>
    
<!-- this is for local -->
    <div class="shippingcontainer container">
    <div class="expedited-delivery">
       <div class="header" style="display: flex; justify-content: space-between; align-items: center; position: relative;">
            <label for="expeditedDelivery">Standard Delivery Local</label>
        <a href="{{url('admin/edit-shipping-rate/'.'local')}}">
            <button class="btn-add-state" style="padding: 8px 16px; background-color: #7367f0;
; color: #fff; border: none; border-radius: 4px; cursor: pointer;  right: 0;">Edit</button></a>
        </div>

       <table>
    <tr>
        <th>Regions</th>
        <th>Transit Time</th>
        <th>Shipping Fee</th>
        <th colspan="2">Free Shipping</th>
       
    </tr>
 
        <tr>
            <td>
                
                <span class="region-name">{{$featchcityname->name}}</span>
            </td>
            <td>
                
                 <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                        <span>{{$localshippingRate->transittime ?? 'N/A' }}</span><span class=""> Days</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>{{$Symbol}}</span> <span>{{$localshippingRate->rate  ?? 'N/A' }}</span><span class=""> Per Order</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>Up to {{$Symbol}}</span> <span>{{ $localshippingRate->freeshipping  ?? 'N/A' }}</span><span class=""> Order Amount</span>
                    </div>
                </div>
            </td>
            <td>
          
            </td>
        </tr>

</table>


    </div>
</div>


  <!-- this is for state -->
    <div class="shippingcontainer">
    <div class="expedited-delivery">
       <div class="header" style="display: flex; justify-content: space-between; align-items: center; position: relative;">
            <label for="expeditedDelivery">Standard Delivery State</label>
        <a href="{{url('admin/edit-shipping-rate/'.'regional')}}">
            <button class="btn-add-state" style="padding: 8px 16px; background-color: #7367f0;
; color: #fff; border: none; border-radius: 4px; cursor: pointer;  right: 0;">Edit</button></a>
        </div>

       <table>
    <tr>
        <th>Regions</th>
        <th>Transit Time</th>
        <th>Shipping Fee</th>
        <th colspan="2">Free Shipping</th>
    </tr>
    @foreach($citiesdata as $city)
        <tr>
            <td>
                @php
                    // Get city IDs and fetch city names
                    $cityIds = explode(',', $city->cityid);

                    $citiesfeatch = DB::table('cities')->whereIn('id', $cityIds)->pluck('name')->toArray();

                    $cityNames = implode(', ', $citiesfeatch);

                @endphp
                <span class="region-name">{{ $city->state_name }}({{$cityNames}})</span>
            </td>
            <td>
                
                 <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                        <span>{{ $city->transittime  ?? 'N/A' }}</span><span class=""> Days</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>{{$Symbol}}</span> <span>{{ $city->rate  ?? 'N/A' }}</span><span class=""> Per Order</span>
                    </div>
                </div>
            </td>
             <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>Up to {{$Symbol}}</span> <span>{{ $city->freeshipping  ?? 'N/A' }}</span><span class=""> Order Amount</span>
                    </div>
                </div>
            </td>
            <td>
          
            </td>
        </tr>
    @endforeach
</table>


    </div>
</div>

<!-- this is for national  -->


 <div class="shippingcontainer">
    <div class="expedited-delivery">
       <div class="header" style="display: flex; justify-content: space-between; align-items: center; position: relative;">
            <label for="expeditedDelivery">Standard Delivery National</label>
        <a href="{{url('admin/edit-shipping-rate/'.'national')}}">
            <button class="btn-add-state" style="padding: 8px 16px; background-color: #7367f0;
; color: #fff; border: none; border-radius: 4px; cursor: pointer;  right: 0;">Edit</button></a>
        </div>

       <table>
    <tr>
        <th>Regions</th>
        <th>Transit Time</th>
        <th>Shipping Fee</th>
         <th colspan="2">Free Shipping</th>
       
    </tr>
    @foreach($nationalshipping as $city)
        <tr>
            <td>
                @php
                    // Get city IDs and fetch city names
                    $cityIds = explode(',', $city->stateid);

                    $citiesfeatch = DB::table('states')->whereIn('id', $cityIds)->pluck('name')->toArray();

                    $cityNames = implode(', ', $citiesfeatch);

                @endphp
                <span class="region-name">{{ $city->country_name }}({{$cityNames}})</span>
            </td>
            <td>
                
                 <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                        <span>{{ $city->transittime  ?? 'N/A' }}</span><span class=""> Days</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>{{$Symbol}}</span> <span>{{ $city->rate  ?? 'N/A' }}</span><span class=""> Per Order</span>
                    </div>
                </div>

            </td>
             <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>Up to {{$Symbol}}</span> <span>{{ $city->freeshipping  ?? 'N/A' }}</span><span class=""> Order Amount</span>
                    </div>
                </div>
            </td>
            <td>
          
            </td>
        </tr>
    @endforeach
</table>


    </div>
</div>





<?php else: ?>
    <div class="delivery-container">
        <div class="delivery-section">
            <div class="delivery-header">
                <label for="standard-delivery-local">Standard Delivery Local</label>
            </div>
            <div class="regions-section">
                <div class="region-title">
                    Regions
                    <p>Local delivery</p>
                </div>
                <div class="shipping-details">
                    <span class="fee-unit">Band</span>
                    <div class="currency-symbol-fee">
                        <span class="currency-symbol">{{$Symbol}}0 To {{$Symbol}}</span>
                        <input type="number" value="40.00">
                    </div>
                </div>
                <div class="shipping-details">
                    <span class="fee-unit">Shipping Fees</span>
                    <div class="currency-symbol-fee">
                        <span class="currency-symbol">{{$Symbol}}</span>
                        <input type="text" value="40.00">
                    </div>
                </div>
                <div class="action-section">
                    <span class="action-text">Action Button</span>
                    <button class="btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="delivery-container mt-3">
        <div class="delivery-section">
            <div class="delivery-header">
                <label for="standard-delivery-regional">Standard Delivery Regional</label>
            </div>
            <div class="regions-section">
                <div class="region-title">
                    Regions
                    <p> regional delivery</p>
                </div>
                <div class="shipping-details">
                    <span class="fee-unit">Band</span>
                    <div class="currency-symbol-fee">
                        <span class="currency-symbol">{{$Symbol}}0 To {{$Symbol}}</span>
                        <input type="text" value="40.00">
                    </div>
                </div>
                <div class="shipping-details">
                    <span class="fee-unit">Shipping Fees</span>
                    <div class="currency-symbol-fee">
                        <span class="currency-symbol">{{$Symbol}}</span>
                        <input type="number" value="40.00">
                    </div>
                </div>
                <div class="action-section">
                    <span class="action-text">Action Button</span>
                    <button class="btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="delivery-container my-3">
        <div class="delivery-section">
            <div class="delivery-header">
                <label for="standard-delivery-national">Standard Delivery National</label>
            </div>
            <div class="regions-section">
                <div class="region-title">
                    Regions
                    <p>National delivery</p>
                </div>
                <div class="shipping-details">
                    <span class="fee-unit">Band</span>
                    <div class="currency-symbol-fee">
                        <span class="currency-symbol">{{$Symbol}}0 To {{$Symbol}}</span>
                        <input type="number" value="40.00">
                    </div>
                </div>
                <div class="shipping-details">
                    <span class="fee-unit">Shipping Fees</span>
                    <div class="currency-symbol-fee">
                        <span class="currency-symbol">₹</span>
                        <input type="number" value="40.00">
                    </div>
                </div>
                <div class="action-section">
                    <span class="action-text">Action Button</span>
                    <button class="btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

</body>
</html>

@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).on('click', '.update-rate', function() {
        var rateType = $(this).data('type');
        var ratemode = $(this).data('ratemode');
       
        
        // Retrieve CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        var shippingRate = $(this).closest('.regions-section').find('.shippingrate').val();

        // Example AJAX request
        $.ajax({
            url: "{{url('admin/shipping-rate-update')}}", 
            type: 'POST',
            data: {
                rateType: rateType,
                shippingRate: shippingRate,
                ratemode:ratemode,

            },
            headers: {
                'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request headers
            },
            success: function(response) {
                // Show success message using SweetAlert
                Swal.fire({
                    title: 'Success!',
                    text: ' Updated successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error updating the rate.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>


<script type="text/javascript">
$(document).ready(function() {
    // Initialize the select2 plugin
    $('#select2Primary').select2({
        placeholder: "Please select state",
        allowClear: true // Allows clearing the selection
    });

    // Handle the selection and unselection
    $('#select2Primary').on('select2:select select2:unselect', function() {
        var selected = $(this).val();
        if (selected && selected.length > 0) {
            $('.select2-selection__placeholder').hide(); // Hide the placeholder when options are selected
        } else {
            $('.select2-selection__placeholder').show(); // Show the placeholder when no options are selected
        }
    });

    // Initial check for placeholder visibility
    $('#select2Primary').trigger('change');
});
</script>

<script type="text/javascript">
    
    $(document).ready(function() {
    $('#select2Primary').on('change', function() {
        var selectedStates = $('#select2Primary').val();
        var container = $('.regions-section-container');
        
        // Remove all previously appended sections
        $('.appended-region').remove();
        
        // Loop through the selected states and append regions-section
        $.each(selectedStates, function(index, value) {
            var stateName = $('#select2Primary option[value="'+value+'"]').text();
            
            // Create a new region section (excluding the dropdown)
            var newRegionSection = `
                <div class="regions-section appended-region">
                    <div class="region-title">
                        ` + stateName + `
                    </div>

                    <!-- Shipping Fees Section -->
                    <div class="shipping-details">
                        <span class="fee-unit">Shipping Fees</span>
                        <div class="currency-symbol-fee">
                            <span class="currency-symbol">₹</span>
                            <input type="number" class="shippingrate regional-rate" value="0">
                            <span class="fee-unit">Per Order</span>
                        </div>
                    </div>

                    <!-- Transit Time Section -->
                    <div class="shipping-details">
                        <span class="fee-unit">Transit Time</span>
                        <div class="currency-symbol-fee">
                            <input type="text" value="1-8">
                            <span class="fee-unit">Days</span>
                        </div>
                    </div>

                    <!-- Action Button Section -->
                    <div class="action-section">
                        <span class="action-text">Action Button</span>
                        <button class="btn-primary update-rate" data-userid="1" data-type="regional" data-ratemode="per-order">Update</button>
                    </div>
                </div>
            `;

            // Append the new section
            container.append(newRegionSection);
        });
    });
});
</script>


