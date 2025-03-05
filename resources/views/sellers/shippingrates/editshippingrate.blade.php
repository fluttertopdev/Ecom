@extends('sellers.layouts.app')
@section('content')

<?php $segment1 =  Request::segment(2);  


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

.container {
    width: 98%;
    margin: 50px auto;
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





<!DOCTYPE html>
<html lang="en">
<body>
<?php if ($segment1 == 'local'): ?>

 <div class="container">
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
                    <span class="region-name">{{ isset($featchcityname) && $featchcityname != null ? $featchcityname->name : 'null' }}</span>
                </td>
              <td>
                 <span id="editbutton" class="edit-link" style="visibility: hidden;"><a href="#">Edit</a></span>
    <select class="transit-time transitTime_{{ isset($localshippingRate) && $localshippingRate != null ? $localshippingRate->id : 'null' }}">
        <option value="1-3" {{ isset($localshippingRate) && $localshippingRate->transittime === '1-3' ? 'selected' : '' }}>1-3</option>
        <option value="3-5" {{ isset($localshippingRate) && $localshippingRate->transittime === '3-5' ? 'selected' : '' }}>3-5</option>
        <option value="5-7" {{ isset($localshippingRate) && $localshippingRate->transittime === '5-7' ? 'selected' : '' }}>5-7</option>
    </select>
    <span>Days</span>
</td>
                <td>
                    <div class="shipping-fee">
           <span>₹</span><input type="number" class="shipping-cost shippingFee_{{ isset($localshippingRate) && $localshippingRate != null ? $localshippingRate->id : 'null' }}" value="{{ isset($localshippingRate) && $localshippingRate != null ? $localshippingRate->rate : 'null' }}"><span>Per Order</span>
                    </div>
                </td>

                <td>
                    <div class="shipping-fee">
        <span>Min. ₹</span><input type="number" class="shipping-cost freeshippinglocal_{{ isset($localshippingRate) && $localshippingRate != null ? $localshippingRate->id : 'null' }}" value="{{ isset($localshippingRate) && $localshippingRate != null ? $localshippingRate->freeshipping : 'null' }}">
                    </div>
                </td>
                <td>
                    <div class="d-flex mt-3">
            <button type="button" class="btn btn-primary update-local-rate" data-cityid="{{ $featchcityname->id ?? ''  }}" data-id="{{ isset($localshippingRate) && $localshippingRate != null ? $localshippingRate->id : 'null' }}" data-type="local" data-ratemode="per-order">Update</button>
                    </div>
                </td>
            </tr>
      </table>

    </div>
</div>

<?php elseif ($segment1 == 'regional'): ?>

    <!-- this is for state -->
    <div class="container">
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
                    $cityIds = isset($city->cityid) ? explode(',', $city->cityid) : [];
                    $citiesfeatch = DB::table('cities')->whereIn('id', $cityIds)->pluck('name')->toArray();
                    $cityNames = implode(', ', $citiesfeatch);
                @endphp
                <span class="region-name">{{ isset($city->state_name) ? $city->state_name : 'null' }}({{ $cityNames ? $cityNames : 'null' }})</span>
            </td>
            <td>
                <span id="editbutton" class="edit-link " data-editid="{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}"><a href="#">Edit</a></span>
                <select class="transit-time transitTime_{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}" id="">
                    <option value="1-3" {{ isset($city->transittime) && $city->transittime == '1-3' ? 'selected' : '' }}>1-3</option>
                    <option value="3-5" {{ isset($city->transittime) && $city->transittime == '3-5' ? 'selected' : '' }}>3-5</option>
                    <option value="5-7" {{ isset($city->transittime) && $city->transittime == '5-7' ? 'selected' : '' }}>5-7</option>
                </select> 
                <span>Days</span>
            </td>
            <td>
                <div class="shipping-fee">
                    <span>₹</span>
                    <input type="number" id="" class="shipping-cost shippingFee_{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}" value="{{ isset($city->rate) ? $city->rate : 'null' }}">
                    <span></span>
                </div>
            </td>

                  <td>
                <div class="shipping-fee">
                    <span>Min. ₹</span>
            <input type="number" id="" class="shipping-cost freeshipping_{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}" value="{{ isset($city->freeshipping) ? $city->freeshipping : 'null' }}">
                    </div>
                </td>
            <td>
                <div class="d-flex mt-3">
        <button type="button" class="btn btn-primary update-rate" data-id="{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}" data-rate="{{ isset($city->rate) ? $city->rate : 'null' }}" data-type="regional" data-ratemode="per-order">Update</button>
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
<div class="container">
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
                    $cityIds = isset($city->stateid) ? explode(',', $city->stateid) : [];
                    $citiesfeatch = DB::table('states')->whereIn('id', $cityIds)->pluck('name')->toArray();
                    $cityNames = implode(', ', $citiesfeatch);
                    @endphp
                    <span class="region-name">{{ isset($city->country_name) ? $city->country_name : 'null' }}({{ $cityNames ? $cityNames : 'null' }})</span>
                </td>
                <td>
                    <span id="editstaebutton" class="edit-link" data-editid="{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}"><a href="#">Edit</a></span>
                    <select class="transit-time transitTime_{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}" id="">
                        <option value="1-3" {{ isset($city->transittime) && $city->transittime == '1-3' ? 'selected' : '' }}>1-3</option>
                        <option value="3-5" {{ isset($city->transittime) && $city->transittime == '3-5' ? 'selected' : '' }}>3-5</option>
                        <option value="5-7" {{ isset($city->transittime) && $city->transittime == '5-7' ? 'selected' : '' }}>5-7</option>
                    </select>
                    <span>Days</span>
                </td>
                <td>
                    <div class="shipping-fee">
                        <span>₹</span>
                        <input type="number" class="shipping-cost shippingFee_{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}" value="{{ isset($city->rate) ? $city->rate : 'null' }}">
                        <span>Per Order</span>
                    </div>

                  <td>
                <div class="shipping-fee">
                    <span>Min.₹</span>
            <input type="number" id="" class="shipping-cost freeshippingnational_{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}" value="{{ isset($city->freeshipping) ? $city->freeshipping : 'null' }}">
                    </div>
                </td>
                </td>
                <td>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-primary update-state-rate" data-id="{{ isset($city->shippingrate_id) ? $city->shippingrate_id : 'null' }}" data-rate="{{ isset($city->rate) ? $city->rate : 'null' }}" data-type="national" data-ratemode="per-order">Update</button>
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

        <form class="add-city-form" action="{{ url('seller-addnewcity') }}"  method="POST">
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
            <button type="submit" class="btn btn-primary cityupdateBtn" id="updateBtn">Update</button>
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

        <form action="{{ url('seller-update-for-shipping-city') }}" method="POST">
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

        <form  class="add-state-form" action="{{ url('sellers-addnewstate') }}" method="POST">
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

        <form action="{{ url('update-for-shipping-state') }}" method="POST">
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
            url: "{{ url('seller-geteditcity') }}",
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
            url: "{{ url('seller-geteditstate') }}",
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
       
    
   
        
      

        // Retrieve CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Example AJAX request
        $.ajax({
            url: "{{url('seller-shipping-rate-update')}}",
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
                            text: 'Updated successfully!',
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
                            title: 'Error',
                            text: 'Error updating the rate',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-danger' // Optional: Add a class for styling the button
                            }
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
       
    
   
        
      

        // Retrieve CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Example AJAX request
        $.ajax({
            url: "{{url('seller-shipping-rate-update')}}",
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
                            text: 'Updated successfully!',
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
                            title: 'Error',
                            text: 'Error updating the rate',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-danger' // Optional: Add a class for styling the button
                            }
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
    
   
        
      

        // Retrieve CSRF token from the meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Example AJAX request
        $.ajax({
            url: "{{url('seller-shipping-rate-update')}}",
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
                // Show success message using SweetAlert
                  Swal.fire({
                            title: 'Success',
                            text: 'Updated successfully!',
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
                            title: 'Error',
                            text: 'Error updating the rate',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-danger' // Optional: Add a class for styling the button
                            }
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
    const updateBtn = document.querySelector(".cityupdateBtn");

    if (form && updateBtn) {
      form.addEventListener('submit', function (event) {
        const checkboxes = document.querySelectorAll('input[name="cityIds[]"]');
        let isChecked = false;

        checkboxes.forEach(function (checkbox) {
          if (checkbox.checked) {
            isChecked = true;
          }
        });

        if (!isChecked) {
          event.preventDefault(); // Prevent form submission
          
          Swal.fire({
            title: 'Error',
            text: 'Please select at least one city.',
            icon: 'error',
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: {
              confirmButton: 'btn btn-danger' // Optional styling
            }
          }).then(() => {
            updateBtn.disabled = false; // Ensure the button is re-enabled
            updateBtn.innerHTML = "Update"; // Reset button text
          });

        } else {
          updateBtn.disabled = true; // Disable button on successful submission
          updateBtn.innerHTML = "Updating..."; // Optional: Change button text
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









 

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const updateBtn = document.querySelector(".cityupdateBtn");
    const form = document.querySelector(".add-city-form");

    form.addEventListener("submit", function () {
      updateBtn.disabled = true;
      updateBtn.innerHTML = "Updating..."; // Optional: Show updating text
    });
  });
</script>

