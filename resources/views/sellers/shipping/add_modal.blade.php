<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"
            id="exampleModalLabel">Add New Shipping </h5>
        <button type="button" class="btn-close text-reset"
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
  <div class="offcanvas-body flex-grow-1">
    <form action="{{url('admin/store-shipping')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Radio Buttons for Category Selection -->
        <div class="col-sm-12">
           
            <div>
                <input type="radio" id="existingCategory" name="country_selection" value="existing" checked>
                <label for="existingCategory">Existing Country</label>
                <input type="radio" id="newCategory" name="country_selection" value="new">
                <label for="newCategory">New Country </label>
            </div>
        </div>

        <!-- Existing Category Select -->
        <div class="col-sm-12 mt-3" id="existingCategoryField">
            <label class="form-label" for="category">Country Name <span class="required">*</span></label>
            <select id="category-select" class="form-control select2 form-select" name="country_id">
                <option value="">Select Country</option>
                @foreach($country_data as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- New Category Input -->
        <div class="col-sm-12 mt-3 d-none" id="newCategoryField">
         
            <div class="input-group input-group-merge">
                <input type="text" id="basicFullname" class="form-control dt-full-name" name="newcountryname" placeholder="Country Name" aria-label="John Doe" aria-describedby="basicFullname2">
            </div>
        </div>


          <!-- Radio Buttons for State Selection -->
        <div class="col-sm-12 mt-3">

            <div>
                <input type="radio" id="existingState" name="state_selection" value="existing" checked>
                <label for="existingState">Existing State</label>
                <input type="radio" id="newState" name="state_selection" value="new">
                <label for="newState">New State</label>
            </div>
        </div>

        <!-- Existing State Select -->
        <div class="col-sm-12 mt-3" id="existingStateField">
            <label class="form-label" for="state">State Name<span class="required">*</span></label>
            
            <select id="State-select" name="state_id" class=" select2 form-select form-select" data-placeholder="">
             <option value="">Select State</option>
                               
            </select>
        </div>

        <!-- New State Input -->
        <div class="col-sm-12 mt-3 d-none" id="newStateField">
            <label class="form-label" for="state_name">State Name <span class="required">*</span></label>
            <div class="input-group input-group-merge">
                <input type="text" id="basicStateName" class="form-control dt-full-name" name="new_state_name" placeholder="State Name" aria-label="State Name" aria-describedby="basicStateName">
            </div>
        </div>


         <!-- Radio Buttons for City Selection -->
<div class="col-sm-12 mt-3">
    
    
    <div>
        <input type="radio" id="existingCity" name="city_selection" value="existing" checked>
        <label for="existingCity">Existing City</label>
        <input type="radio" id="newCity" name="city_selection" value="new">
        <label for="newCity">New City</label>
    </div>
</div>

<!-- Existing City Select -->
<div class="col-sm-12 mt-3" id="existingCityField">
    <label class="form-label" for="city">City Name<span class="required">*</span></label>
    <select class="form-control select2 form-select" id="city-select" name="city_id">
        <option value="">Select City</option>
    </select>
</div>

<!-- New City Input -->
<div class="col-sm-12 mt-3 d-none" id="newCityField">
    <label class="form-label" for="city_name">City Name <span class="required">*</span></label>
    <div class="input-group input-group-merge">
        <input type="text" id="basicCityName" class="form-control dt-full-name" name="new_city_name" placeholder="City Name" aria-label="City Name" aria-describedby="basicCityName">
    </div>
</div>

        

        <div class="col-sm-12 mt-3 " id="">
    <label class="form-label" for="city_name">Post Code<span class="required">*</span></label>
    <div class="input-group input-group-merge">
        <input type="text" id="basicCityName" class="form-control dt-full-name" name="postcode" placeholder="Post Code" aria-label="Post code" aria-describedby="basicCityName">
    </div>
</div>


        <div class="col-sm-12 mt-3 " id="">
    <label class="form-label" for="city_name">Amount<span class="required">*</span></label>
    <div class="input-group input-group-merge">
        <input type="text" id="basicCityName" class="form-control dt-full-name" name="amount" placeholder="Amount" aria-label="Post code" aria-describedby="basicCityName">
    </div>
</div>



        <div class="col-sm-12 mt-4">
            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">{{__('lang.admin_save_changes')}}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{__('lang.admin_cancel')}}</button>
        </div>
    </form>
</div>
</div>





<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    // Category radio buttons
    const existingCategoryRadio = document.getElementById('existingCategory');
    const newCategoryRadio = document.getElementById('newCategory');
    const existingCategoryField = document.getElementById('existingCategoryField');
    const newCategoryField = document.getElementById('newCategoryField');

    // State radio buttons and labels
    const existingStateRadio = document.getElementById('existingState');
    const newStateRadio = document.getElementById('newState');
    const existingStateField = document.getElementById('existingStateField');
    const newStateField = document.getElementById('newStateField');
    const stateLabel = document.querySelector('label[for="state"]');
    const existingStateRadioContainer = existingStateRadio.closest('div');

    // City radio buttons and labels
    const existingCityRadio = document.getElementById('existingCity');
    const newCityRadio = document.getElementById('newCity');
    const existingCityField = document.getElementById('existingCityField');
    const newCityField = document.getElementById('newCityField');
    const cityLabel = document.querySelector('label[for="city"]');
    const existingCityRadioContainer = existingCityRadio.closest('div');

    // Category toggle
    existingCategoryRadio.addEventListener('change', function () {
        if (this.checked) {
            existingCategoryField.classList.remove('d-none');
            newCategoryField.classList.add('d-none');

            // Show existing state and city options
            existingStateRadioContainer.classList.remove('d-none');
            existingStateField.classList.remove('d-none');
            newStateField.classList.add('d-none');
            stateLabel.classList.remove('d-none');

            existingCityRadioContainer.classList.remove('d-none');
            existingCityField.classList.remove('d-none');
            newCityField.classList.add('d-none');
            cityLabel.classList.remove('d-none');

            // Automatically check existing state and city radio buttons
            existingStateRadio.checked = true;
            existingCityRadio.checked = true;
        }
    });

    newCategoryRadio.addEventListener('change', function () {
        if (this.checked) {
            existingCategoryField.classList.add('d-none');
            newCategoryField.classList.remove('d-none');

            // Hide existing state and city options
            existingStateRadioContainer.classList.add('d-none');
            existingStateField.classList.add('d-none');
            newStateRadio.checked = true;
            newStateField.classList.remove('d-none');
            stateLabel.classList.add('d-none');

            existingCityRadioContainer.classList.add('d-none');
            existingCityField.classList.add('d-none');
            newCityRadio.checked = true;
            newCityField.classList.remove('d-none');
            cityLabel.classList.add('d-none');
        }
    });

    // State toggle
    existingStateRadio.addEventListener('change', function () {
        if (this.checked) {
            existingStateField.classList.remove('d-none');
            newStateField.classList.add('d-none');
            stateLabel.classList.remove('d-none');

            // Show existing city options
            existingCityRadioContainer.classList.remove('d-none');
            existingCityField.classList.remove('d-none');
            newCityField.classList.add('d-none');
            cityLabel.classList.remove('d-none');

            // Automatically check existing city radio button
            existingCityRadio.checked = true;
        }
    });

    newStateRadio.addEventListener('change', function () {
        if (this.checked) {
            existingStateField.classList.add('d-none');
            newStateField.classList.remove('d-none');
            stateLabel.classList.add('d-none');

            // Show new city options
            existingCityRadioContainer.classList.add('d-none');
            existingCityField.classList.add('d-none');
            newCityRadio.checked = true; // Check new city radio button
            newCityField.classList.remove('d-none');
            cityLabel.classList.add('d-none');
        }
    });

    // City toggle
    existingCityRadio.addEventListener('change', function () {
        if (this.checked) {
            existingCityField.classList.remove('d-none');
            newCityField.classList.add('d-none');
            cityLabel.classList.remove('d-none');
        }
    });

    newCityRadio.addEventListener('change', function () {
        if (this.checked) {
            existingCityField.classList.add('d-none');
            newCityField.classList.remove('d-none');
            cityLabel.classList.add('d-none');
        }
    });
});
</script>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>




<script type="text/javascript">
  
 $(document).ready(function() {
    // Initialize select2 plugin if needed
    $('#category-select').select2({
        placeholder: 'Select Country',
        allowClear: true
    });

  $('#State-select').select2({
            placeholder: 'Select State',
            allowClear: true
        });
    // Trigger when category is selected
    $('#category-select').on('change', function() {
        var categoryId = $(this).val(); // Get the selected category ID
         
        // Check if a category is selected
        if (categoryId) {
            $.ajax({
                url: "{{url('admin/country-change')}}", // Route to handle the AJAX request
                type: 'POST',
                data: {
                    category_id: categoryId,
                    _token: '{{ csrf_token() }}' // Laravel CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        var statename = response.statename;
                        
                        // Clear and populate the subcategory select box
                        $('#State-select').empty();
                        $('#State-select').append('<option value="">Select State</option>');
                        
                        $.each(statename, function(key, state) {
                            $('#State-select').append('<option value="'+state.id+'">'+state.name+'</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            // Clear subcategory select box if no category is selected
            $('#State-select').empty();
            $('#State-select').append('<option value="">Select State</option>');
        }
    });



        // Trigger when a state is selected to load cities
        $('#State-select').on('change', function() {
            var stateId = $(this).val(); // Get the selected state ID

            if (stateId) {
                $.ajax({
                    url: "{{url('admin/state-change')}}", // Route to handle the city request
                    type: 'POST',
                    data: {
                        state_id: stateId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            var cities = response.cities;
                            $('#city-select').empty();
                            $('#city-select').append('<option value="">Select City</option>');

                            $.each(cities, function(key, city) {
                                $('#city-select').append('<option value="'+city.id+'">'+city.name+'</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#city-select').empty();
                $('#city-select').append('<option value="">Select City</option>');
            }
        });
});


</script>
