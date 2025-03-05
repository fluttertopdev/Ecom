
<?php $segment1 =  Request::segment(2);  


?>

@extends('sellers.layouts.app')
@section('content')


<!DOCTYPE html>
<html lang="en">
<head>


    <style type="text/css">
    
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}

.container {
    width: 95%;
    margin: 15px auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.expedited-delivery {
    width: 100%;
}

.header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.header input {
    margin-right: 10px;
}

.header label {
    font-size: 18px;
    font-weight: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 15px;
    text-align: left;
}

th {
    background-color: #f1f1f1;
    font-size: 16px;
    font-weight: bold;
}

td {
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
}

.region-name {
    font-size: 12px;
    font-weight: bold;
    color: #333;
}

.edit-link {
    margin-right: 10px;
}

.edit-link a {
    color: #007bff;
    text-decoration: none;
}

.edit-link a:hover {
    text-decoration: underline;
}

select {
    padding: 5px;
    font-size: 14px;
}

.shipping-fee {
    display: flex;
    align-items: center;
}

.shipping-fee span {
    margin-right: 5px;
}

.shipping-fee input {
    width: 70px;
    padding: 5px;
    font-size: 14px;
    margin-right: 5px;
}

</style>



    

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Fees</title>
</head>
<body>



    
<!-- this is for local -->
    <div class="container">
    <div class="expedited-delivery">
       <div class="header" style="display: flex; justify-content: space-between; align-items: center; position: relative;">
            <label for="expeditedDelivery">Standard Delivery Local</label>
        <a href="{{url('sellers-edit-shipping-rate/'.'local')}}">
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
                        <span>{{ $localshippingRate?->transittime ?? 'N/A' }}</span><span class=""> Days</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>₹</span> <span>{{$localshippingRate->rate ?? 'N/A'}}</span><span class=""> Per Order</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>Min. ₹</span> <span>{{ $localshippingRate->freeshipping ?? 'N/A'}}</span><span class=""> Order Amount</span>
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
    <div class="container">
    <div class="expedited-delivery">
       <div class="header" style="display: flex; justify-content: space-between; align-items: center; position: relative;">
            <label for="expeditedDelivery">Standard Delivery State</label>
        <a href="{{url('sellers-edit-shipping-rate/'.'regional')}}">
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
                        <span>{{ $city->transittime ?? 'N/A' }}</span><span class=""> Days</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>₹</span> <span>{{ $city->rate ?? 'N/A' }}</span><span class=""> Per Order</span>
                    </div>
                </div>
            </td>
             <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>Min. ₹</span> <span>{{ $city->freeshipping ?? 'N/A'}}</span><span class=""> Order Amount</span>
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


 <div class="container">
    <div class="expedited-delivery">
       <div class="header" style="display: flex; justify-content: space-between; align-items: center; position: relative;">
            <label for="expeditedDelivery">Standard Delivery National</label>
        <a href="{{url('sellers-edit-shipping-rate/'.'national')}}">
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
                        <span>{{ $city->transittime ?? 'N/A' }}</span><span class=""> Days</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>₹</span> <span>{{ $city->rate ?? 'N/A'}}</span><span class=""> Per Order</span>
                    </div>
                </div>

            </td>
             <td>
                <div class="shipping-details">
                    
                    <div class="currency-symbol-fee">
                       <span>Min. ₹</span> <span>{{ $city->freeshipping ?? 'N/A' }}</span><span class=""> Order Amount</span>
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


