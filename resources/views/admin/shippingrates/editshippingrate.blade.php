@extends('admin.layouts.app')
@section('content')

<?php $segment1 =  Request::segment(3);  

$Symbol = \Helpers::getActiveCurrencySymbol();
?>
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


</style>





<!DOCTYPE html>
<html lang="en">

<body>
<?php if ($segment1 == 'local'): ?>

 <div class="editshippingcontainer">
    <div class="expedited-delivery">
        <div class="header">
            <label for="expeditedDelivery">Standard Delivery Local</label>
        </div>
        <table>
            <tr>
                <th>Regions</th>
                <th>Transit Time</th>
                <th>Shipping Fee</th>
                 <th>Free Shipping</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>
                    <span class="region-name">{{$featchcityname->name}}</span>
                </td>
              <td>
                 <span id="editbutton" class="edit-link" style="visibility: hidden;"><a href="#">Edit</a></span>
  <select class="transit-time transitTime_{{ $localshippingRate->id ?? '' }}">
    <option value="1-3" {{ isset($localshippingRate) && $localshippingRate->transittime === '1-3' ? 'selected' : '' }}>1-3</option>
    <option value="3-5" {{ isset($localshippingRate) && $localshippingRate->transittime === '3-5' ? 'selected' : '' }}>3-5</option>
    <option value="5-7" {{ isset($localshippingRate) && $localshippingRate->transittime === '5-7' ? 'selected' : '' }}>5-7</option>
</select>
    <span>Days</span>
</td>
                <td>
                    <div class="shipping-fee">
           <span>{{$Symbol}}</span><input type="number" class="shipping-cost shippingFee_{{$localshippingRate->id ?? '' }}" value="{{$localshippingRate->rate ?? '' }}"><span>Per Order</span>
                    </div>
                </td>

                <td>
                    <div class="shipping-fee">
        <span>Up to {{$Symbol}}</span><input type="number" class="shipping-cost freeshippinglocal_{{$localshippingRate->id ?? '' }}" value="{{$localshippingRate->freeshipping ?? '' }}">
                    </div>
                </td>
                <td>
                    <div class="d-flex mt-3">
            <button type="button" class="btn btn-primary update-local-rate" data-cityid="{{ $featchcityname->id ?? ''  }}" data-id="{{ $localshippingRate->id ?? ''  }}" data-type="local" data-ratemode="per-order">Update</button>
                    </div>
                </td>
            </tr>
     

        </table>

    </div>
</div>



<?php elseif ($segment1=='regional'): ?>



    <!-- this is for state -->
    <div class="editshippingcontainer">
    <div class="expedited-delivery">
        <div class="header">
            <label for="expeditedDelivery">Standard Delivery State</label>
        </div>

       <table>
    <tr>
        <th>Regions</th>
        <th>Transit Time</th>
        <th>Shipping Fee</th>
        <th>Free Shipping</th>
        <th>Action</th>
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
                <span id="editbutton" class="edit-link " data-editid="{{$city->shippingrate_id}}"><a href="#">Edit</a></span>
                <select class="transit-time transitTime_{{ $city->shippingrate_id }}" id="">
                    <option value="1-3" {{ $city->transittime == '1-3' ? 'selected' : '' }}>1-3</option>
                    <option value="3-5" {{ $city->transittime == '3-5' ? 'selected' : '' }}>3-5</option>
                    <option value="5-7" {{ $city->transittime == '5-7' ? 'selected' : '' }}>5-7</option>
                </select> 
                <span>Days</span>
            </td>
            <td>
                <div class="shipping-fee">
                    <span>{{$Symbol}}</span>
                    <input type="number" id="" class="shipping-cost shippingFee_{{ $city->shippingrate_id }}" value="{{$city->rate}}">
                    <span></span>
                </div>
            </td>

                  <td>
                <div class="shipping-fee">
                    <span>Up to ₹</span>
            <input type="number" id="" class="shipping-cost freeshipping_{{ $city->shippingrate_id }}" value="{{$city->freeshipping}}">
                   
                </div>
            </td>
            <td>
                <div class="d-flex mt-3">
        <button type="button" class="btn btn-primary update-rate" data-id="{{ $city->shippingrate_id }}" data-rate="{{ $city->rate }}" data-type="regional" data-ratemode="per-order">Update</button>
                </div>
            </td>
        </tr>
    @endforeach
</table>
@if(!empty($selectedCities) && count($selectedCities) > 0)
<div class="d-flex justify-content-center mt-3">
    <button type="button" id="addstatebutton" class="btn btn-primary">Add New City</button>
</div>
@endif

    </div>
</div>
<?php elseif ($segment1 == 'national'): ?>

<!-- this is for national -->
<div class="editshippingcontainer">
    <div class="expedited-delivery">
        <div class="header">
            <label for="expeditedDelivery">Standard Delivery National</label>
        </div>
        <table>
            <tr>
                <th>Regions</th>
                <th>Transit Time</th>
                <th>Shipping Fee</th>
                 <th>Free Shipping</th>
                <th>Action</th>
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
                    <span id="editstaebutton" class="edit-link" data-editid="{{$city->shippingrate_id}}"><a href="#">Edit</a></span>
                    <select class="transit-time transitTime_{{ $city->shippingrate_id }}" id="">
                        <option value="1-3" {{ $city->transittime == '1-3' ? 'selected' : '' }}>1-3</option>
                        <option value="3-5" {{ $city->transittime == '3-5' ? 'selected' : '' }}>3-5</option>
                        <option value="5-7" {{ $city->transittime == '5-7' ? 'selected' : '' }}>5-7</option>
                    </select>
                    <span>Days</span>
                </td>
                <td>
                    <div class="shipping-fee">
                        <span>{{$Symbol}}</span>
                        <input type="number" class="shipping-cost shippingFee_{{ $city->shippingrate_id }}" value="{{$city->rate}}">
                        <span>Per Order</span>
                    </div>


                  <td>
                <div class="shipping-fee">
                    <span>Up to {{$Symbol}}</span>
            <input type="number" id="" class="shipping-cost freeshippingnational_{{ $city->shippingrate_id }}" value="{{$city->freeshipping}}">
                   
                </div>
            </td>
                </td>
                <td>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-primary update-state-rate" data-id="{{ $city->shippingrate_id }}" data-rate="{{ $city->rate }}" data-type="national" data-ratemode="per-order">Update</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

@if(!empty($selectedStates) && count($selectedStates) > 0)
        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="stateaddbutton" class="btn btn-primary stateaddbutton">Add New State</button>
        </div>
        @endif 
    </div>
</div>

<?php endif; ?>

</body>
</html>




 <!-- this modal for add city  -->

 <div class="modal fade" id="addcityModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <form   class="add-city-form" action="{{ url('admin/addnewcity') }}" method="POST">
          @csrf
          <table id="exampleTable" class="table table-bordered exampleTable">
            <input type="hidden" value="{{$featchstatename->id}}" name="stateid">
            <thead>
              <tr>
                <th>Sr No.</th>
                <th>City Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($selectedCities as $index => $city)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $city->name }}</td>
                  <td>
                    <!-- Check if the city is enabled for the user by checking if city_enable_id is not null -->
            <input type="checkbox" name="cityIds[]" value="{{ $city->id }}" 
                           >
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary update-btn" id="updateBtn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>











<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <form action="{{ url('admin/update-for-shipping-city') }}" method="POST">
          @csrf
          <table id="exampleTable" class="table table-bordered exampleTable">
            <thead>
              <tr>
                <th>Sr No.</th>
                <th>City Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
             
                <tr>
                  <td></td>
                  <td></td>
                  <td>
                
                  </td>
                </tr>
            
            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- this modal for add state  -->

 <div class="modal fade stateaddbutton" id="addstatemodal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <form class="add-state-form" action="{{ url('admin/addnewstate') }}" method="POST">
          @csrf
          <table id="exampleTable" class="table table-bordered exampleTable">
         
            <thead>
              <tr>
                <th>Sr No.</th>
                <th>State Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($selectedStates as $index => $state)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $state->name }}</td>
                  <td>
                    <!-- Check if the city is enabled for the user by checking if city_enable_id is not null -->
            <input type="checkbox" name="stateIds[]" value="{{ $state->id }}" 
                           >
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- this is for edit state modal? -->

<div class="modal fade" id="editstaeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <form action="{{ url('admin/update-for-shipping-state') }}" method="POST">
          @csrf
          <table id="exampleTable1" class="table table-bordered exampleTable">
            <thead>
              <tr>
                <th>Sr No.</th>
                <th>City Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
             
                <tr>
                  <td></td>
                  <td></td>
                  <td>
                
                  </td>
                </tr>
            
            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary" id="updateBtn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>





<script>
  $(document).ready(function() {
    $('.exampleTable').DataTable();
  });
</script>

<script type="text/javascript">
    
    $(document).on('click', '#addstatebutton', function(){
      
        $('#addcityModal').modal('show'); 
    });
</script>
<script type="text/javascript">
    $(document).on('click', '#editbutton', function() {
        var editid = $(this).data('editid');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Example AJAX request
        $.ajax({
            url: "{{ url('admin/geteditcity') }}",
            type: 'POST',
            data: {
                editid: editid
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request headers
            },
            success: function(response) {
                // Clear previous city names
                $('#exampleTable tbody').empty();
                
                // Create a Set for checked city IDs
                const checkedCityIds = new Set(response.cities.map(city => city.id));

                // Check if response has city data
                if (response.cities.length > 0) {
                    response.cities.forEach(function(city, index) {
                        // Append the city data to the table
                        $('#exampleTable tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${city.name}</td>
                                <td>
                              <input type="hidden" name="editid" value="${editid}" />
                                    <input type="checkbox" name="cityIds[]" value="${city.id}" ${checkedCityIds.has(city.id) ? 'checked' : ''} />
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    // Optionally handle if no cities are found
                    $('#exampleTable tbody').append(`
                        <tr>
                            <td colspan="3" class="text-center">No cities found</td>
                        </tr>
                    `);
                }
                
                // Show the modal
                $('#editModal').modal('show');
            },
        });
    });
</script>



<!-- this is for edit state -->



<script type="text/javascript">
    $(document).on('click', '#editstaebutton', function() {
        var editid = $(this).data('editid');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Example AJAX request
        $.ajax({
            url: "{{ url('admin/geteditstate') }}",
            type: 'POST',
            data: {
                editid: editid
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request headers
            },
            success: function(response) {
                // Clear previous city names
                $('#exampleTable1 tbody').empty();
                
                // Create a Set for checked city IDs
                const checkedCityIds = new Set(response.cities.map(city => city.id));

                // Check if response has city data
                if (response.cities.length > 0) {
                    response.cities.forEach(function(city, index) {
                        // Append the city data to the table
                        $('#exampleTable1 tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${city.name}</td>
                                <td>
                              <input type="hidden" name="editid" value="${editid}" />
                                    <input type="checkbox" name="cityIds[]" value="${city.id}" ${checkedCityIds.has(city.id) ? 'checked' : ''} />
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    // Optionally handle if no cities are found
                    $('#exampleTable1 tbody').append(`
                        <tr>
                            <td colspan="3" class="text-center">No cities found</td>
                        </tr>
                    `);
                }
                
                // Show the modal
                $('#editstaeModal').modal('show');
            },
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).on('click', '.update-rate', function() {
        var rateType = $(this).data('type');
        var shippingrateid = $(this).data('id');
       
     

        var ratemode = $(this).data('ratemode') || ''; 
       var transitTime = $('.transitTime_'+shippingrateid).val();
       var shippingFee = $('.shippingFee_'+shippingrateid).val();
       var freeshipping = $('.freeshipping_'+shippingrateid).val();
       
    
         if (!shippingFee) {
          
               Swal.fire({
          title: 'warning',
          text: 'Please fill in the Shipping Fee field!',
          icon: 'warning',
          confirmButtonText: 'OK',
          buttonsStyling: false,
          customClass: {
          confirmButton: 'btn btn-warning' // Optional: Add a class for styling the button
         }
     });
            return; // Stop the request if shippingFee is empty
        }
        
             // Check if freeshipping is empty
            if (!freeshipping) {
           
            
              
               Swal.fire({
          title: 'warning',
          text: 'Please fill in the Free Shipping field',
          icon: 'warning',
          confirmButtonText: 'OK',
          buttonsStyling: false,
          customClass: {
          confirmButton: 'btn btn-warning' // Optional: Add a class for styling the button
         }
     });
            
            return; // Stop the request if freeshipping is empty
        }
        
      

        // Retrieve CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Example AJAX request
        $.ajax({
            url: "{{url('admin/shipping-rate-update')}}",
            type: 'POST',
            data: {
                rateType: rateType,
                ratemode: ratemode,
                transitTime: transitTime,
                shippingFee: shippingFee,
                shippingrateid:shippingrateid,
                freeshipping:freeshipping
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request headers
            },
            success: function(response) {
                // Show success message using SweetAlert
               
                Swal.fire({
                            title: 'Success',
                            text: 'Updated successfully',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success' // Optional: Add a class for styling the button
                            }
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



 <!-- this is for update rate for state  -->


 <script type="text/javascript">
    $(document).on('click', '.update-state-rate', function() {
        var rateType = $(this).data('type');
        var shippingrateid = $(this).data('id');
       
     

        var ratemode = $(this).data('ratemode') || ''; 
       var transitTime = $('.transitTime_'+shippingrateid).val();
       var shippingFee = $('.shippingFee_'+shippingrateid).val();
       var freeshipping = $('.freeshippingnational_'+shippingrateid).val();
       
    
   
          if (!shippingFee) {
          
               Swal.fire({
          title: 'warning',
          text: 'Please fill in the Shipping Fee field!',
          icon: 'warning',
          confirmButtonText: 'OK',
          buttonsStyling: false,
          customClass: {
          confirmButton: 'btn btn-warning' // Optional: Add a class for styling the button
         }
     });
            return; // Stop the request if shippingFee is empty
        }
        
             // Check if freeshipping is empty
            if (!freeshipping) {
           
            
              
               Swal.fire({
          title: 'warning',
          text: 'Please fill in the Free Shipping field',
          icon: 'warning',
          confirmButtonText: 'OK',
          buttonsStyling: false,
          customClass: {
          confirmButton: 'btn btn-warning' // Optional: Add a class for styling the button
         }
     });
            
            return; // Stop the request if freeshipping is empty
        }
      

        // Retrieve CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Example AJAX request
        $.ajax({
            url: "{{url('admin/shipping-rate-update')}}",
            type: 'POST',
            data: {
                rateType: rateType,
                ratemode: ratemode,
                transitTime: transitTime,
                shippingFee: shippingFee,
                shippingrateid:shippingrateid,
                freeshipping:freeshipping
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request headers
            },
            success: function(response) {
                // Show success message using SweetAlert
              Swal.fire({
                            title: 'Success',
                            text: 'Updated successfully',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success' // Optional: Add a class for styling the button
                            }
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

 <!-- this is for  rate update local  -->
<script type="text/javascript">
    $(document).on('click', '.update-local-rate', function() {
        var rateType = $(this).data('type');
        var shippingrateid = $(this).data('id');
       
     

        var ratemode = $(this).data('ratemode') || ''; 
       var transitTime = $('.transitTime_'+shippingrateid).val();
       var shippingFee = $('.shippingFee_'+shippingrateid).val();
    var freeshipping = $('.freeshippinglocal_'+shippingrateid).val();
      var cityid = $(this).data('cityid') || '';
      
    
    
   
          if (!shippingFee) {
          
               Swal.fire({
          title: 'warning',
          text: 'Please fill in the Shipping Fee field!',
          icon: 'warning',
          confirmButtonText: 'OK',
          buttonsStyling: false,
          customClass: {
          confirmButton: 'btn btn-warning' // Optional: Add a class for styling the button
         }
     });
            return; // Stop the request if shippingFee is empty
        }

        // Check if freeshipping is empty
            if (!freeshipping) {
           
            
              
               Swal.fire({
          title: 'warning',
          text: 'Please fill in the Free Shipping field',
          icon: 'warning',
          confirmButtonText: 'OK',
          buttonsStyling: false,
          customClass: {
          confirmButton: 'btn btn-warning' // Optional: Add a class for styling the button
         }
     });
            
            return; // Stop the request if freeshipping is empty
        }
      

        // Retrieve CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Example AJAX request
        $.ajax({
            url: "{{url('admin/shipping-rate-update')}}",
            type: 'POST',
            data: {
                rateType: rateType,
                ratemode: ratemode,
                transitTime: transitTime,
                shippingFee: shippingFee,
                shippingrateid:shippingrateid,
                freeshipping:freeshipping,
                cityid:cityid
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request headers
            },
            success: function(response) {
             
                
                Swal.fire({
                            title: 'Success',
                            text: 'Updated successfully',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success' // Optional: Add a class for styling the button
                            }
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


<!-- this for add state -->
<script type="text/javascript">
    
    $(document).on('click', '.stateaddbutton', function(){
         
        $('#addstatemodal').modal('show'); 


    });



    
</script>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.add-city-form');
    if (form) {
      form.addEventListener('submit', function (event) {
        const checkboxes = document.querySelectorAll('input[name="cityIds[]"]');
        let isChecked = false;

        checkboxes.forEach(function (checkbox) {
          if (checkbox.checked) {
            isChecked = true;
          }
        });

        if (!isChecked) {
          event.preventDefault();
          
          
            Swal.fire({
                            title: 'error',
                            text: 'Please select at least one city.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-danger' // Optional: Add a class for styling the button
                            }
                        });
        }
      });
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.add-state-form');
    if (form) {
      form.addEventListener('submit', function (event) {
        const checkboxes = document.querySelectorAll('input[name="stateIds[]"]');
        let isChecked = false;

        checkboxes.forEach(function (checkbox) {
          if (checkbox.checked) {
            isChecked = true;
          }
        });

        if (!isChecked) {
          event.preventDefault();
          
          
            Swal.fire({
                            title: 'error',
                            text: 'Please select at least one State.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-danger' // Optional: Add a class for styling the button
                            }
                        });
        }
      });
    }
  });
</script>







 
