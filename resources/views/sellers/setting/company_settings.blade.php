<h5 class="font-weight-bold mt-2 mb-2">Information</h5>

    <div class="col-md-3 ">
        <label class="form-label" for="company_name">Name</label>
        <input type="text" class="form-control" placeholder="Name"  name="name" value="{{$loactionsettings->name}}"/>
    </div>
  
    <div class="col-md-3 ">
        <label class="form-label" for="email">Email</label>
        <input type="text" class="form-control" placeholder="Email"  name="email" value="{{$loactionsettings->email}}"/>
    </div>
   
    <div class="col-md-3 ">
        <label class="form-label" for="phone">Phone</label>
        <input type="text" class="form-control" placeholder="Phone"  name="phone" value="{{$loactionsettings->phone}}"/>
    </div>
  
    <div class="col-md-3 ">
        <label class="form-label" for="country">Country</label>
       
        
        
          <select class="form-control select2 form-select validate-field" name="country" id="category-select" required>
                        <option value="">Select Country</option>
                        @foreach($country_data as $country)
                            <option value="{{ $country->id }}" {{ $country->id == $loactionsettings->countryid ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
    </div>
  
    <div class="col-md-3 ">
        <label class="form-label" for="state">State</label>
       
        
        <select id="State-select" name="state" class="select2 form-select validate-field" required>
                        <option value="">Select State</option>
                        @foreach($state_data as $state)
                            <option value="{{ $state->id }}" {{ $state->id == $loactionsettings->stateid ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
    </div>
 

      
    <div class="col-md-3 ">
        <label class="form-label" for="city">City</label>
    
        
         <select class="form-control select2 form-select validate-field" id="city-select" name="city" required>
                        <option value="">Select City</option>
                        @foreach($city_data as $city)
                            <option value="{{ $city->id }}" {{ $city->id == $loactionsettings->cityid ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
    </div>


    

<div class="col-md-12">
    
    
        <div class="col-md-12 mt-3">
            <label class="form-label" for="address">Full Address</label>
            <textarea type="text" class="form-control" name="address" placeholder="Full Address" value="{{$loactionsettings->address}}">{{$loactionsettings->address}}</textarea>
        </div>
    <div class="col-md-12 mt-3">
            <label class="form-label" for="address">Description</label>
            <textarea type="text" class="form-control" name="description" placeholder="Description"  rows="6" value="{{$loactionsettings->description}}">{{$loactionsettings->description}}</textarea>
        </div>

      
       

</div>




<style>
    #map {
        height: 400px;
    }

    .controls {
        margin-top: 10px;
        margin-left: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        padding: 0 11px 0 13px;
        width: 400px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        text-overflow: ellipsis;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
</style>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>




<script type="text/javascript">
$(document).ready(function() {
    // Initialize select2
    $('#category-select, #State-select, #city-select').select2({
        placeholder: 'Select an option',
        allowClear: true
    });

    // Load states when a country is selected
    $('#category-select').on('change', function() {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: "{{url('admin/country-change')}}",
                type: 'POST',
                data: {
                    category_id: countryId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var states = response.statename;
                        $('#State-select').empty().append('<option value="">Select State</option>');
                        $.each(states, function(key, state) {
                            $('#State-select').append('<option value="' + state.id + '">' + state.name + '</option>');
                        });
                        $('#State-select').trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#State-select').empty().append('<option value="">Select State</option>');
            $('#city-select').empty().append('<option value="">Select City</option>');
        }
    });

    // Load cities when a state is selected
    $('#State-select').on('change', function() {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: "{{url('admin/state-change')}}",
                type: 'POST',
                data: {
                    state_id: stateId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var cities = response.cities;
                        $('#city-select').empty().append('<option value="">Select City</option>');
                        $.each(cities, function(key, city) {
                            $('#city-select').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#city-select').empty().append('<option value="">Select City</option>');
        }
    });
});
</script>